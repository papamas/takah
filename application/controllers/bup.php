<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bup extends MY_Controller {

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
		$this->load->view('pencatatan/vbup',$data);
	}
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT a.PNS_NIPBARU as id,CONCAT( a.PNS_NIPBARU ,' - ', a.PNS_PNSNAM)  as text FROM PUPNS a
	   WHERE a.PNS_NIPBARU LIKE '$search%' OR a.PNS_PNSNIP LIKE '$search' 
	   ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	   
	   
	}
	
    function get_bup_data()
	{
	    $nip   = $this->input->post('nip');
		$sql="SELECT *, DATE_FORMAT(PNI_SK_TANGGAL,'%d-%m-%Y') tgl_sk, DATE_FORMAT(PNI_TMT_PENSIUN,'%d-%m-%Y') tmt_pen FROM 
		`pupns_pensiun_info` WHERE `PNI_NIPBARU` LIKE '$nip' OR PNI_PNSNIP LIKE '$nip'
		ORDER BY `pupns_pensiun_info`.`PNI_SK_TANGGAL`desc ,PNI_TGL_USUL DESC";
		$query= $this->db3->query($sql);
		
		if($query->num_rows()  > 0)
		{
		    $row		= $query->row();
		
            $data[]		= array('tgl_sk'      			   => $row->tgl_sk,
								'tmt_pen'  				   => $row->tmt_pen,
								'PNI_SK_NOMOR'             => $row->PNI_SK_NOMOR,
								'PNI_PNSNIP'               => $row->PNI_PNSNIP,
			);			
		}
		else
		{
		     $data[]		= array('tgl_sk'      			   => '',
								    'tmt_pen'  				   => '',
								    'PNI_SK_NOMOR'             => '',
									'PNI_PNSNIP'               => '',
								
			);		
		}
		
		echo json_encode($data);	
		
	}
	
	function _get_instansi()
	{
	     return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
	}
	
	
	public function save()
	{
	    $instansi          = $this->input->post('instansi');
		$nip			   = $this->input->post('nip');
		$tmt			   = $this->input->post('tmt');
		$tgl_sk			   = $this->input->post('tgl_sk');
		$no_sk			   = $this->input->post('no_sk');
		$nip_lama		   = $this->input->post('nip_lama');
		$keterangan        = $this->input->post('keterangan');
		
		if(!empty($tgl_sk))
		{
		    $tgl_sk = date('Y-m-d',strtotime($tgl_sk));
		}
		else
		{
		    $tgl_sk = NULL;
		}
		
		if(!empty($no_sk))
		{
		    $no_sk = $no_sk;
		}
		else
		{
		    $no_sk = NULL;
		}
		
		if(!empty($nip_lama))
		{
		    $nip_lama = $nip_lama;
		}
		else
		{
		    $nip_lama = NULL;
		}
		
		
		$data = array('instansi'				=> $instansi,
					  'nip'						=> $nip,
					  'tmt'						=> date('Y-m-d',strtotime($tmt)),
					  'tgl_sk'					=> $tgl_sk,
					  'nomor_sk'				=> $no_sk,
					  'keterangan'				=> $keterangan,
					  'created_by'				=> $this->session->userdata('user_id'),
					  'nip_lama'				=> $nip_lama,
					  
		);
		
		$arr_session		= $data;
		
	    $this->session->set_userdata($arr_session);
		
		$this->db1->insert('bup',$data);	
		
		$data['instansi']       = $this->_get_instansi();
		$data['message']		= 'Save Successfully..';
		$this->load->view('pencatatan/vbup',$data);
	}  
	
	public function laporan()
	{
	    $data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('laporan/vbup',$data);
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
		
		
		
		
		$sql="SELECT a.*, b. PNS_PNSNAM , c.INS_NAMINS , d.nama ,
		DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM takah.bup a
        LEFT JOIN mirror.pupns b ON a.nip =  b.PNS_NIPBARU
        LEFT JOIN mirror.instansi c ON a.instansi =  c.INS_KODINS
        LEFT JOIN takah.app_user d ON d.id = a.created_by 		
		WHERE 1=1  $sql_pelaksana $sql_instansi  
		AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') ORDER BY a.id ASC";
		
		//var_dump($sql); exit;
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "BUP".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN BUP PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>NIP LAMA</th>	
					<th>NAMA</th>					
					<th>INTANSI </th>
					<th>TMT</th>
					<th>TGL SK</th>
					<th>NOMOR</th>
					<th>PELAKSANA</th>
					<th>KETERANGAN</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td>{$r->tgl_input}</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td class=str>{$r->nip_lama}</td>";
				$html .= "<td class=str>{$r->PNS_PNSNAM}</td>";				
				$html .= "<td>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->tgl_sk}</td>";
				$html .= "<td>{$r->nomor_sk}</td>";
				$html .= "<td>{$r->nama}</td>";				
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
	
	function search()
	{
	    $search =$this->input->post('search');
		
		if($search)
		{
		   $sql_search = "AND (a.nip ='$search' OR a.nip_lama ='$search')";
		}
		else
		{
		   $sql_search ="";
		}
		
		$user_id = $this->session->userdata('user_id');		
		
		$sql="SELECT a.*, DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input,
		DATE_FORMAT(a.tmt, '%d-%m-%Y') tgl_tmt,
		DATE_FORMAT(a.tgl_sk, '%d-%m-%Y') tglsk,
		b.INS_NAMINS FROM bup a
		INNER JOIN mirror.instansi b ON a.instansi = b.INS_KODINS 
		WHERE 1=1 $sql_search  AND a.created_by='$user_id' LIMIT 10";
		$query = $this->db1->query($sql);
		
		$data['record']    = $query; 
		$data['message']   ='';
		$data['instansi']  = $this->_get_instansi();
	    $this->load->view('search/vbup',$data);
	}
	
	function get_bup()
	{
	   $id = $this->input->post('bup_id');
	   
	   $sql="SELECT *,DATE_FORMAT(created_date,'%d-%m-%Y') tgl_input,
	    DATE_FORMAT(tmt,'%d-%m-%Y') tgl_tmt,
		DATE_FORMAT(tgl_sk,'%d-%m-%Y') tglsk
	    FROM takah.bup where id='$id' ";
	   $query = $this->db1->query($sql);
		
	   echo json_encode($query->result_array());
	   
	
	}
	
	function update()
	{
	    $id  			        = $this->input->post('bup_id');
		$tgl_input  			= $this->input->post('tgl_input');
		$nip  					= $this->input->post('nip');
		$instansi	  			= $this->input->post('instansi');
		$tgl_tmt		  		= $this->input->post('tgl_tmt');
		$tgl_sk			        = $this->input->post('tgl_sk');
		$no_sk			        = $this->input->post('no_sk');
		$keterangan		  		= $this->input->post('keterangan');
		
		$data = array('created_date'     => date('Y-m-d', strtotime($tgl_input)),
					  'nip'              => $nip,
					  'instansi'         => $instansi,
					  'tmt'              => date('Y-m-d', strtotime($tgl_tmt)),
					  'tgl_sk'			 => date('Y-m-d',strtotime($tgl_sk)),
					  'nomor_sk'		 => $no_sk,
					  'keterangan'       => $keterangan,
					  
		);
		
		
		
		
		$this->db1->where('id',$id);
	    $this->db1->update('bup', $data);
		
	}
	
	function delete()
	{
	    $id  			    = $this->input->post('bupdel_id');
		$this->db1->where('id',$id);
	    $this->db1->delete('bup');
	
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
