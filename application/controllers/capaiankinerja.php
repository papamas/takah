<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capaiankinerja extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
	    parent::__construct();
		$this->db3   = $this->load->database('sapkdb', TRUE);
	    $this->db1   = $this->load->database('default', TRUE);
		//$this->load->library('openkm');
	}
	 
	public function index()
	{
		
		$data['instansi']			= $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('rekap/capaiankinerja_view',$data);
	}
	
	public function cetak()
	{
	    $data['aksi']			= $this->input->post('aksi');
		$data['seksi']		    = $this->input->post('seksi');
		$data['pelaksana']      = $this->input->post('pelaksana'); 		
		$data['instansi']		= $this->input->post('instansi');
		$reportrange        	= $this->input->post('reportrange');
		$xreportrange       	= explode("-",$reportrange);
		$data['startdate']		= $xreportrange[0];
		$data['enddate']		= $xreportrange[1];
		
		$this->_rekap($data);		
	}
	
	public function _rekap($data)
	{
	    $instansi      =  $data['instansi'];
		$startdate     =  $data['startdate'];
		$enddate       =  $data['enddate'];
		$pelaksana     =  $data['pelaksana'];
		$aksi          =  $data['aksi'];
		$seksi         =  $data['seksi'];
		
		if($instansi != '')
		{
		    $data['sql_instansi'] =" AND a.kode_instansi='$instansi' "; 
		}		
		else
		{
		   $data['sql_instansi']  =" "; 
		}
		
		if($aksi != ' ')
		{
		    $data['sql_aksi'] =" AND a.aksi='$aksi' "; 
		}		
		else
		{
		   $data['sql_aksi']  =" "; 
		}
		
		if($pelaksana != '')
		{
		    $data['sql_pelaksana'] =" AND a.id_pelaksana='$pelaksana' "; 
		}		
		else
		{
		   $data['sql_pelaksana'] =" "; 
		}
		
		if($seksi == '1')
		{
		    $this->_cetak_rekap_verprov($data); 
		}
		else
		{
		    $this->_cetak_rekap_kabkot($data);
		
		}	
		   
	}
	
	function _cetak_rekap_verprov($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$sql_instansi  = $data['sql_instansi'];
		$verprov       = implode(',',$this->_get_verprov());
		$sql_instansi  = $sql_instansi . "  AND a.kode_instansi IN($verprov)";
		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 $sql_aksi  $sql_instansi  AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY aksi,tmt,kode_instansi ";
       
		$q    = $this->db->query($sql);
		
		//var_dump($sql);exit;
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CAPAIANNPKPREKAPITULASIVERPROV".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN CAPAIAN KINERJA <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->jumlah}</td>";					
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=6 >There is no data found</td></tr></table>";
			echo $html;
		} 	  
	
	}
	
	
	function _cetak_rekap_kabkot($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$sql_instansi  = $data['sql_instansi'];
		$kab_kot       = implode(',',$this->_get_kabkot());
		$sql_instansi  = $sql_instansi . "  AND a.kode_instansi IN($kab_kot)";
		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 $sql_aksi  $sql_instansi  AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY aksi,tmt,kode_instansi ";
       
		$q    = $this->db->query($sql);
		
		//var_dump($sql);exit;
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CAPAIANNPKPREKAPITULASIKABKOT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN CAPAIAN KINERJA <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->jumlah}</td>";					
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=6 >There is no data found</td></tr></table>";
			echo $html;
		} 	  
	
	}
	
	function _get_app_user()
	{
	    if($this->session->userdata('level') == 'kasie')
		{
		   $sql_limit_user = " ";
		}
		else
		{
		   $id  = $this->session->userdata('user_id');
		   $sql_limit_user  = " AND id='$id'";
		
		}
	    
		$sql="SELECT id,nama FROM app_user where 1=1 $sql_limit_user  AND level != 'kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
	}
	
	function _get_kabkot()
	{
	    $sql="SELECT a.* FROM (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
) a WHERE INS_KODINS NOT IN ('7100','7000','7900')";		
		$query  = $this->db3->query($sql)->result_array();
		foreach($query as $value)
		{
		    $r[]  =$value['INS_KODINS']; 
		}
		return $r;
	}
	
	function _get_verprov()
	{
	    $sql="SELECT a.* FROM (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '1010' and '4062' OR INS_KODINS IN ('7100','7000','7900')) a ";		
		$query  = $this->db3->query($sql)->result_array();
		foreach($query as $value)
		{
		    $r[]  =$value['INS_KODINS']; 
		}
		return $r;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */