<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pindah extends MY_Controller {

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
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT PNS_NIPBARU as id,CONCAT( PNS_NIPBARU ,' - ', PNS_PNSNAM)  as text FROM PUPNS WHERE PNS_NIPBARU LIKE '$search%' ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
	
	function _get_instansi()
	{
	     return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
	}
	
	function _get_instansi2()
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
	    
		$sql="SELECT id,nama FROM app_user where 1=1 $sql_limit_user  AND level != 'kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	
	public function save()
	{
	    $instansi_asal     = $this->input->post('instansi_asal');
		$instansi_tujuan   = $this->input->post('instansi_tujuan');
		$nip			   = $this->input->post('nip');
		$tmt			   = $this->input->post('tmt');
		$tgl_sk		       = $this->input->post('tgl_sk');
		$no_sk             = $this->input->post('no_sk');
		$keterangan        = $this->input->post('keterangan');
		$tnip              = $this->input->post('tnip');
		$status_nip		   = $this->input->post('status_nip');
		
		if($status_nip == '1' ) $nip = $tnip;
		
		$data = array('instansi_asal'			=> $instansi_asal,
					  'instansi_tujuan'			=> $instansi_tujuan,
					  'nip'						=> $nip,
					  'tmt'						=> date('Y-m-d',strtotime($tmt)),
					  'tgl_sk'					=> date('Y-m-d',strtotime($tgl_sk)),
					  'no_sk'					=> $no_sk,
					  'keterangan'				=> $keterangan,
					  'created_by'				=> $this->session->userdata('user_id'),
					  
		);
		
		$this->db1->insert('pwk',$data);	
		
		$data['instansi']       = $this->_get_instansi();
		$data['message']		= 'Save Successfully..';
		$this->load->view('pencatatan/vpindah_wilayah',$data);
	}  
	
	
	public function laporan()
	{
	    $data['instansi']              = $this->_get_instansi2();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('laporan/vpindah',$data);
	}
	
	public function cetakLaporan()
	{
	    $instansi    	= $this->input->post('instansi');
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
		    $sql_instansi  = " AND a.instansi_tujuan='$instansi' ";
		}
		elseif($mutasi == '2')
		{
		   $sql_instansi  = " AND a.instansi_asal='$instansi'  ";
		
		}
		else
		{
		   $sql_instansi  = "   ";
		
		}
		
		
		
		
		/* $sql="SELECT a.*,DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM pwk a  WHERE 1=1  
		$sql_pelaksana $sql_instansi  AND DATE( created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')"; */
        $sql="SELECT a.*,
		b.PNS_PNSNAM, 
		SUBSTRING_INDEX(b.PNS_PNSNAM, ' ', 1) LABEL,
        c.INS_NAMINS nama_instansi_asal,
        d.INS_NAMINS nama_instansi_tujuan		
		FROM (
		SELECT a.*,DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input 
		FROM takah.pwk a WHERE 1=1 
		$sql_pelaksana $sql_instansi  AND DATE( created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')) a 
LEFT JOIN  mirror.pupns b ON a.nip = b.pns_nipbaru
LEFT JOIN mirror.instansi c ON c.INS_KODINS = a.instansi_asal
LEFT JOIN mirror.instansi d ON d.INS_KODINS = a.instansi_tujuan";
		
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
		
		$html   = 'LAPORAN PINDAH WILAYAH KERJA PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
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
					<th rowspan="2" >LABEL</th>
					
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
				$html .= "<td>{$r->LABEL}</td>";
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
	   
	   if($query->num_rows() > 0)
	   {	   
			$row    = $query->row();
			$r      = $row->INS_NAMINS;
			
	   }
	   else
	   {
	       $r       = '';
	   }
	   
	   return   $r;
	
	}
	
	function _get_nama_orang($id)
	{
	
	   $sql="SELECT nama FROM app_user WHERE id='$id' ";
	   $query  = $this->db1->query($sql);
	   $row    = $query->row();
	   
	   return $row->nama;  
	
	}
	
	function search()
	{
	    $search =$this->input->post('search');
		
		if($search)
		{
		   $sql_search = "AND a.nip ='$search' ";
		}
		else
		{
		   $sql_search ="";
		}
		
		$user_id = $this->session->userdata('user_id');		
		
		$sql="SELECT a.*, DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input,
		DATE_FORMAT(a.tgl_sk, '%d-%m-%Y') tgl_suratkep, 
		DATE_FORMAT(a.tmt, '%d-%m-%Y') tgl_tmt,
		b.INS_NAMINS asal , c.INS_NAMINS tujuan FROM pwk a
		INNER JOIN mirror.instansi b ON a.instansi_asal = b.INS_KODINS 
		INNER JOIN mirror.instansi c ON a.instansi_tujuan = c.INS_KODINS 
		WHERE 1=1 $sql_search  AND a.created_by='$user_id' LIMIT 10";
		$query = $this->db1->query($sql);
		
		$data['record']    = $query; 
		$data['message']   ='';
		$data['instansi']  = $this->_get_instansi();
	    $this->load->view('search/vpwk',$data);
	}
	
	function get_pwk()
	{
	   $id = $this->input->post('pindah_id');
	   
	   $sql="SELECT *,DATE_FORMAT(created_date,'%d-%m-%Y') tgl_input,
	   DATE_FORMAT(tgl_sk,'%d-%m-%Y') tgl_suratkep,
	   DATE_FORMAT(tmt,'%d-%m-%Y') tgl_tmt
	   FROM takah.pwk where id='$id' ";
	   $query = $this->db1->query($sql);
		
	   echo json_encode($query->result_array());
	   
	
	}
	
	function update()
	{
	    $id  			        = $this->input->post('pindah_id');
		$tgl_input  			= $this->input->post('tgl_input');
		$nip  					= $this->input->post('nip');
		$asal	  		    	= $this->input->post('instansi_asal');
		$tujuan	  		    	= $this->input->post('instansi_tujuan');
		$no_sk		  			= $this->input->post('no_sk');
		$tgl_sk		  			= $this->input->post('tgl_sk');
		$tgl_tmt		  		= $this->input->post('tgl_tmt');
		
		$data = array('created_date'     => date('Y-m-d', strtotime($tgl_input)),
					  'nip'              => $nip,
					  'instansi_asal'    => $asal,
					  'instansi_tujuan'  => $tujuan,
					  'no_sk'            => strtoupper($no_sk),
					  'tgl_sk'           => date('Y-m-d', strtotime($tgl_sk)),
					  'tmt'              => date('Y-m-d', strtotime($tgl_tmt)),
		
		);
		
		$this->db1->where('id',$id);
	    $this->db1->update('pwk', $data);
		
	}
	
	function delete()
	{
	    $id  			    = $this->input->post('pindahdel_id');
		$this->db1->where('id',$id);
	    $this->db1->delete('pwk');
	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
