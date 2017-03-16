<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestasikerja extends MY_Controller {

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
		$data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('laporan/prestasikerja_view',$data);
	}
	
	public function cetak()
	{
	    $data['aksi']			= $this->input->post('aksi');
		$data['vertikal']		= $this->input->post('vertikal');
		$perintah        		= $this->input->post('perintah');
        $data['pelaksana']      = $this->input->post('pelaksana'); 		
		$data['instansi']		= $this->input->post('instansi');
		$reportrange        	= $this->input->post('reportrange');
		$xreportrange       	= explode("-",$reportrange);
		$data['startdate']		= $xreportrange[0];
		$data['enddate']		= $xreportrange[1];
		
		if($perintah == 1)
		{
			$this->_harian($data);
		}
		else
		{
		   $this->_rekap($data);
		}
		
	}
	
	public function _rekap($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$aksi         =  $data['aksi'];
		
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
		
		if($vertikal == '1')
		{
		    $this->_cetak_rekap_pusat($data); 
		}
		else
		{
		    $this->_cetak_rekap_daerah($data);
		
		}	
		   
	}
	
	function _cetak_rekap_pusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		
	   $sql="SELECT a.*,count(a.nip) jumlah FROM (SELECT a.*,LEFT(a.lokasi_kerja,2) kode_provinsi, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 AND  b.INS_KODINS BETWEEN '1010' AND '4062'
$sql_aksi AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y' ) $sql_pelaksana ) a WHERE kode_provinsi='$instansi'
GROUP BY a.aksi,a.tmt,a.kode_instansi ";
       
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPREKAPITULASIPUSAT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN NPKP REKAPITULASI PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>WILAYAH KERJA</th>
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
				$html .= "<td>{$this->_get_nama_instansi($kode_instansi)}</td>";
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
	
	function _cetak_rekap_daerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		
		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 $sql_aksi  AND a.kode_instansi='$instansi' AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY aksi,tmt ";
       
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPREKAPITULASIDAERAH".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN NPKP REKAPITULASI PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
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
	
	
	public function _harian($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$aksi         =  $data['aksi'];
		
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
		
		if($vertikal == '1')
		{
		    $this->_cetak_harian_pusat($data); 
		}
		else
		{
		    $this->_cetak_harian_daerah($data);
		
		}	
		   
	}
	
	function _cetak_harian_pusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		
	   $sql="SELECT * FROM (SELECT a.*,LEFT(a.lokasi_kerja,2) kode_provinsi, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU, e.JKP_JPNNAMA FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
INNER JOIN mirror.jenis_kp e ON e.JKP_JPNKOD = a.jenis_kp
WHERE 1=1 AND  b.INS_KODINS BETWEEN '1010' AND '4062'
$sql_aksi AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y' ) $sql_pelaksana ) a WHERE kode_provinsi='$instansi' ";
       
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPHARIANPUSAT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PRESTASI KINERJA PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>WILAYAH KERJA</th>
					<th>INSTANSI</th>
					<th>NO.LG</th>
					<th>TGL.LG</th>
					<th>GOLONGAN</th>
					<th>JENIS KP</th>
					<th>KETERANGAN</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str width=150>{$r->nip}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td>{$this->_get_nama_instansi($kode_instansi)}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->no_lg}</td>";
				$html .= "<td>{$r->tgl_lg}</td>";
				$html .= "<td>{$r->GOL_LAMA}-{$r->GOL_BARU}</td>";
				$html .= "<td>{$r->JKP_JPNNAMA}</td>";
				$html .= "<td width=500>{$r->keterangan}</td>";				
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
	
	function _cetak_harian_daerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		
		
	   $sql="SELECT a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU, e.JKP_JPNNAMA FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
INNER JOIN mirror.jenis_kp e ON e.JKP_JPNKOD = a.jenis_kp
WHERE 1=1 $sql_aksi  AND a.kode_instansi='$instansi' AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana ";
       
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPHARIANDAERAH".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PRESTASI KINERJA PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>INSTANSI</th>
					<th>NO.LG</th>
					<th>TGL.LG</th>
					<th>GOLONGAN</th>
					<th>JENIS KP</th>
					<th>KETERANGAN</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str width=150>{$r->nip}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->no_lg}</td>";
				$html .= "<td>{$r->tgl_lg}</td>";
				$html .= "<td>{$r->GOL_LAMA}-{$r->GOL_BARU}</td>";
				$html .= "<td>{$r->JKP_JPNNAMA}</td>";
				$html .= "<td width=500>{$r->keterangan}</td>";				
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
	
	
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
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
	    
		$sql="SELECT id,nama FROM app_user WHERE 1=1 $sql_limit_user AND level!='kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	function _get_nama_instansi($id)
	{
	   $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
       $query  = $this->db3->query($sql);
	   $row    = $query->row();
	   
	   return $row->INS_NAMINS;
	   
	   
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */