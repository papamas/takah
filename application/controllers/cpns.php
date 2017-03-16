<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpns extends MY_Controller {

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
		$this->load->view('pencatatan/vcpns',$data);
	}
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT NIP as id,CONCAT( NIP ,' - ', JABATAN_NAMA)  as text FROM pupns_pengadaan_info WHERE NIP LIKE '$search%' ORDER BY NIP ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
	
	public function get_cpns_data()
	{
	    $nip  =  $this->input->post('nip');
		
		$sql="SELECT DATE_FORMAT(TMT_CPNS,'%d-%m-%Y') TMT_CPNS,PERSETUJUAN_TEKNIS_NOMOR,
		DATE_FORMAT(PERSETUJUAN_TEKNIS_TANGGAL,'%d-%m-%Y') PERSETUJUAN_TEKNIS_TANGGAL
		FROM `pupns_pengadaan_info` WHERE `NIP`='$nip' ";
		
		$query  = $this->db3->query($sql);
		
		if($query->num_rows()  > 0)
		{
		    $row		= $query->row();
		
            $data[]		= array('TMT'				       => $row->TMT_CPNS,
								'NOSK' 					   => $row->PERSETUJUAN_TEKNIS_NOMOR,
								'TGL'					   => $row->PERSETUJUAN_TEKNIS_TANGGAL,								
			);			
		}
		else
		{
		    $data[]		= array('TMT'				       => '',
								'NOSK' 					   => '',
								'TGL'   				   => '',								
			);		
		}
		
		echo json_encode($data);
	
	}
	
	
	function _get_instansi()
	{
	     return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
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
	
	
	public function save()
	{
	    $instansi          = $this->input->post('instansi');
		$nip			   = $this->input->post('nip');
		$tmt			   = $this->input->post('tmt');
		$tgl_sk		       = $this->input->post('tgl_sk');
		$no_sk             = $this->input->post('no_sk');
		$keterangan        = $this->input->post('keterangan');
		
		$data = array('instansi'				=> $instansi,
					  'nip'						=> $nip,
					  'tmt'						=> date('Y-m-d',strtotime($tmt)),
					  'tgl_sk'					=> date('Y-m-d',strtotime($tgl_sk)),
					  'no_sk'					=> $no_sk,
					  'keterangan'				=> $keterangan,
					  'created_by'				=> $this->session->userdata('user_id'),
					  
		);
		
		$arr_session		= $data;
		
	    $this->session->set_userdata($arr_session);
		
		$this->db1->insert('cpns',$data);	
		
		$data['instansi']       = $this->_get_instansi();
		$data['message']		= 'Save Successfully..';
		$this->load->view('pencatatan/vcpns',$data);
	}  
	
	
	public function laporan()
	{
	    $data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('laporan/vcpns',$data);
	}
	
	public function cetakLaporan()
	{
	    $instansi    	= $this->input->post('instansi');
		$pelaksana    	= $this->input->post('pelaksana');
		$reportrange 	= $this->input->post('reportrange');
		$xreportrange	= explode("-",$reportrange);
	    $startdate		= $xreportrange[0];
	    $enddate		= $xreportrange[1];

		
		if($instansi != '')
		{
		   $sql_instansi  = " AND a.instansi='$instansi' ";
		}
		else
		{
		   $sql_instansi  = " ";
		
		}
		
		if($pelaksana != '')
		{
		    $sql_pelaksana   = " AND a.created_by='$pelaksana' ";
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		
		
		
		$sql="SELECT a.*, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM cpns a  WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
		
		//var_dump($sql); exit;
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PENGADAAN CPNS PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>INTANSI </th>
					<th>TMT</th>
					<th>NO.SK</th>
					<th>TGL SK</th>
					<th>PELAKSANA</th>
					<th>KETERANGAN</th>
					'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td WIDTH=350>{$this->_get_nama_instansi($r->instansi)}</td>";
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
	
	
	function _get_nama_instansi($id)
	{
	   $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
       $query  = $this->db3->query($sql);
	   $row    = $query->row();
	   
	   return $row->INS_NAMINS;  
	
	}
	
	function _get_nama_orang($id)
	{
	
	   $sql="SELECT nama FROM app_user WHERE id='$id' ";
	   $query  = $this->db1->query($sql);
	   $row    = $query->row();
	   
	   return $row->nama;  
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */