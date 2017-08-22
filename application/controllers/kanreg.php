<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kanreg extends MY_Controller {

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
		$data['instansi']       = $this->_get_instansi();
		$data['message']		= '';
		$this->load->view('pencatatan/vpindah_wilayah',$data);
	}
	
	public function laporan()
	{
	    $data['wilayah']               = $this->_get_wilayah();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('laporan/vpindahkanreg',$data);
	}
	
	public function cetakLaporan()
	{
	    $wilayah    	= $this->input->post('wilayah');
		$pelaksana    	= $this->input->post('pelaksana');
		$mutasi     	= $this->input->post('mutasi');
		$reportrange 	= $this->input->post('reportrange');
		$xreportrange	= explode("-",$reportrange);
	    $startdate		= $xreportrange[0];
	    $enddate		= $xreportrange[1];

		
		if($pelaksana != '')
		{
		    $sql_pelaksana   = " AND a.created_by='$pelaksana' ";
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		if($mutasi == '1')
		{
		    $sql_instansi  = " a.instansi_asal IN (SELECT kode_instansi FROM takah.kantor_instansi where kode_kantor_wilayah='$wilayah') ";
			
			$txt = " INSTANSI ASAL PADA WILAYAH ";
		}
		elseif($mutasi == '2')
		{
		   $sql_instansi  = " a.instansi_tujuan IN (SELECT kode_instansi FROM takah.kantor_instansi where kode_kantor_wilayah='$wilayah') ";
		   
		   $txt =" INSTANSI TUJUAN PADA WILAYAH ";
		
		}
		else
		{
		   $sql_instansi  = "   ";
		
		}
		
		
	   $sql="SELECT a.*,
		b.PNS_PNSNAM, 
		c.INS_NAMINS nama_instansi_asal,
        d.INS_NAMINS nama_instansi_tujuan		
		FROM (
		SELECT a.*,DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input 
		FROM takah.pwk a WHERE $sql_instansi 
		$sql_pelaksana AND DATE( created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')) a 
LEFT JOIN  mirror.pupns b ON a.nip = b.pns_nipbaru
LEFT JOIN mirror.instansi c ON c.INS_KODINS = a.instansi_asal
LEFT JOIN mirror.instansi d ON d.INS_KODINS = a.instansi_tujuan ORDER BY a.id ASC";
		
		//var_dump($sql); exit;
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "PWK".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PINDAH WILAYAH KERJA '. $txt . $this->_get_nama_wilayah($wilayah).' <br/>PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th rowspan="2">NO</th>
					<th rowspan="2">TGL</th>
					<th rowspan="2">NIP</th>
					<th rowspan="2">NAMA</th>
					<th colspan="2">INTANSI </th>
					<th rowspan="2">TMT</th>
					<th rowspan="2">NO.SK</th>
					<th rowspan="2">TGL SK</th>
					<th rowspan="2">PELAKSANA</th>
					<th rowspan="2" >KETERANGAN</th>					
					'; 
		$html 	.= '</tr><tr><th>ASAL</th><th>TUJUAN</th></tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td>{$r->tgl_input}</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->nama_instansi_asal}</td>";
				$html .= "<td>{$r->nama_instansi_tujuan}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->no_sk}</td>";
				$html .= "<td>{$r->tgl_sk}</td>";
				$html .= "<td>{$this->_get_nama_orang($r->created_by)}</td>";				
                $html .= "<td>{$r->keterangan}</td>";				
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
	
	function _get_wilayah()
	{
	    $sql="SELECT * FROM takah.kantor_bkn Order by kode ASC";		
		$query  = $this->db1->query($sql);
		return $query;
		
	}
	
	function _get_nama_wilayah($id)
	{
	
	   $sql="SELECT CONCAT(nama_kantor,'  ',alamat) text FROM kantor_bkn WHERE kode='$id' ";
	   $query  = $this->db1->query($sql);
	   $row    = $query->row();
	   
	   return $row->text;  
	
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
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */