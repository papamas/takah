<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prascanning extends MY_Controller {

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
		$this->load->library('openkm');
		
	}
	
	public function index()
	{
		 $data['instansi']			   = $this->_get_instansi();
		 $data['status']			   = $this->_get_status();
		 $data['lihat']		           = FALSE;	
		 $data['pelaksana']			   = $this->_get_app_user();
	  
		$this->load->view('prascanning/vprascanning',$data);
	}
	
	public function jalankan()
	{
	    $data['instansi']      = $this->input->post('instansi');
	    $data['status']		   = $this->input->post('status');
	    $data['perintah']	   = $this->input->post('perintah');
		$data['start']	       = $this->input->post('start');
	    $data['end']	       = $this->input->post('end');
		$data['pelaksana']     = $this->input->post('pelaksana');
	   
	     // save session user
		$this->session->set_userdata(array('instansi'  	  => $this->input->post('instansi'),			   
										   'status'       => $this->input->post('status'),								   
										   
										   
								   ));     
								   
	    if($this->input->post('perintah') == '1')
	    {
		    $this->getResult($data); 
	   
	    }
		elseif($this->input->post('perintah') == '2')
		{
		    $this->getLihat($data); 
	   
		}
		else
		{
		    $this->getCetak($data); 
	   	
		}
		
	    
	
	}
	
	public function getCetak($data)
	{
	    $instansi 			    = $data['instansi'];
	    $status                 = $data['status']; 
        $start                  = $data['start']; 	
		$end                    = $data['end']; 	
		$pelaksana				= $data['pelaksana'];
		
		
        $q						= $this->_get_recordListing($data);		
		
		//creating xls file
		$now              = date('dmYHis');
		$filename         = "PRACANNINGPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LISTING PRASCANNING KEADAAN DATA PNS BERDASARKAN DATABASE MIRROR UPDATE TGL : '. $this->_get_time_create().' ' .$instansi. ' <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>STATUS</th>
					<th>INSTANSI</th>'; 
		$html 	.= '</tr>';
		if(count($q) > 0){
			$i = 1;		        
			foreach ($q as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r['PNS_NIPBARU']}</td>";
				$html .= "<td width=400>{$r['PNS_PNSNAM']}</td>";
				$html .= "<td>{$r['KED_KEDNAM']}</td>";
				$html .= "<td width=450>{$r['INS_NAMINS']}</td>";				
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=5 >There is no data found</td></tr></table>";
			echo $html;
		}
         
	    $this->_insertDMS($data);
		
	}
	
	function _get_dms_login($id)
	{
	    $sql="SELECT dms_user,dms_password FROM app_user WHERE id='$id' ";
		$query = $this->db1->query($sql);
		$row   = $query->row();
		
		return $row;
		
	
	}
	
	
	function _insertDMS($data)
	{
	    $instansi 			    = $data['instansi'];
	    $status                 = $data['status']; 
        $start                  = $data['start']; 	
		$end                    = $data['end']; 	
		$pelaksana				= $data['pelaksana'];		
        $q						= $this->_get_recordListing($data);	
		
		$rdata = array();
		
		// get dms user login
		$dms_login = $this->_get_dms_login($pelaksana);
		$user_dms  = $dms_login->dms_user;
		$pass_dms  = $dms_login->dms_password;
		
		//var_dump($dms_login);exit;
		
		
		
		$this->openkm->Login($user_dms,$pass_dms);
		
		//var_dump($q);exit;
			
		foreach ($q as $key => $value)
		{
		    $nama_instansi    = $this->_get_nama_instansi($value['PNS_INSDUK']);
			$nip              = $value['PNS_NIPBARU'];
		    $valid            = $this->openkm->isValid('/'.$nama_instansi);
		    $isValid          = $valid['result'];
			if(!$isValid)
			{
			   $dms_instansi              = $this->openkm->CreateFolder('/'.$nama_instansi); 
			   
			}
			
			$validnip            = $this->openkm->isValid('/'.$nama_instansi.'/'.$nip);
			$isValidnip          = $validnip['result'];
			
			if(!$isValidnip)
			{
			  $rdata[] 				     =  $this->openkm->CreateFolder('/'.$nama_instansi.'/'.$nip); 
			 
			}
       		
			$rdata[$key]['nip']   			 = $nip;
			$rdata[$key]['nama_instansi']    = $nama_instansi;
			$rdata[$key]['kode_instansi']    = $value['PNS_INSDUK'];
			$rdata[$key]['nama']             = $value['PNS_PNSNAM'];
            			
			 
		}
		
		// create template
        if(count($rdata) > 0)
		{
			
			foreach($rdata as $key => $value)
			{
				$path = $rdata[$key]['result']->path;
				$rpath     = explode('/',$path);
				if(count($rpath) == 4)
				{ 
					$template  = $this->openkm->getTemplate();
					foreach($template as $val)
					{
						$cpath   = $path.'/'.$val;
						$c       = $this->openkm->CreateTemplate($cpath);			
						
					}	
				}
				
			    $dms = array('nip'			=> $rdata[$key]['nip'],
						 'prascanning'		=> 1,
						 'scanning'         => '',
						 'id_app_user'		=> $this->session->userdata('user_id'),						 
						 'scandate'			=> '',						 
						 'kode_instansi'	=> $rdata[$key]['kode_instansi'],
						 'nama_instansi'	=> $rdata[$key]['nama_instansi'],
						 'path'             => $path,
						 'nama'				=> $rdata[$key]['nama'],
						 'id_pelaksana'		=> $pelaksana,
						 'uuid'             => $rdata[$key]['result']->uuid
		    	);		
                $this->db1->set('pradate','NOW()',FALSE);
                $this->db1->insert('dms_nip',$dms);				
			} 
		}

        $this->openkm->Logout(); 		
	
	}
	
	
	
	
	function _get_app_user()
	{
	
	    $sql="SELECT id,nama FROM app_user ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	public function getLihat($data)
	{
	    $instansi 			    = $data['instansi'];
	    $status                 = $data['status'];  
		$start                  = $data['start']; 	
		$end                    = $data['end']; 
		
		
		$data['jumlah']		    = $this->_get_jumlah($data);
	    $data['record']         = $this->_get_recordListing($data);
		$data ['create_time']   = $this->_get_time_create();
		
		$data['instansi']	    = $this->_get_instansi();
	    $data['status']		    = $this->_get_status();
		$data['lihat']			= TRUE;
		$data['pelaksana']	    = $this->_get_app_user();
		
		$this->load->view('prascanning/vprascanning',$data);
	
	}
	
	function _get_recordListing($data)
	{
	    $instansi 			    = $data['instansi'];
	    $status                 = $data['status'];  
		$start                  = $data['start']; 	
		$end                    = $data['end']; 
		
		$sql="SELECT a.PNS_INSDUK, a.PNS_NIPBARU,a.PNS_PNSNAM, b.INS_NAMINS,c.KED_KEDNAM FROM mirror.pupns a 
		INNER JOIN mirror.instansi b ON b.INS_KODINS = a.PNS_INSDUK 
		INNER JOIN mirror.kedhuk c ON c.KED_KEDKOD = a.PNS_KEDHUK 
		WHERE a.PNS_KEDHUK='$status' AND a.PNS_INSDUK='$instansi'  
		AND a.PNS_NIPBARU NOT IN (SELECT nip FROM takah.dms_nip) LIMIT $end";
		
		//var_dump($sql);exit;
		
		$query  = $this->db3->query($sql)->result_array();
		
		$data = array();
		
		foreach ($query as $key =>$value)
		{
		    $isExisting = $this->_isExisting($value['PNS_NIPBARU']);
			
			if($isExisting)
			{
			    unset($query[$key]);			
			}
			
			$data[]  = array('PNS_INSDUK'   => $value['PNS_INSDUK'],
			                 'PNS_NIPBARU'  => $value['PNS_NIPBARU'],
							 'PNS_PNSNAM'   => $value['PNS_PNSNAM'],
							 'INS_NAMINS'   => $value['INS_NAMINS'],
							 'KED_KEDNAM'   => $value['KED_KEDNAM'],
			);
		}
		
		return $data;
	
	}
	
	function _isExisting($nip)
	{
	    $nip  = $nip;
		
		$sql="SELECT nip FROM dms_nip WHERE nip='$nip' ";
		$query  = $this->db1->query($sql);
		
		if($query->num_rows() > 0)
		{
		   $r = TRUE;
		}
		else
		{
		   $r = FALSE;

		}
		
		return $r;
		
	
	}
	
	public function getResult($data)
	{
	   $instansi 			   = $data['instansi'];
	   $status                 = $data['status'];  
	   
	   
	   $data['jumlah']		   = $this->_get_jumlah($data);
	   $data['instansi']	   = $this->_get_instansi();
	   $data['status']		   = $this->_get_status();
	   $data ['create_time']   = $this->_get_time_create();
	   $data['lihat']		   = FALSE;	
	   $data['pelaksana']	   = $this->_get_app_user();
	   
	   $this->load->view('prascanning/vprascanning',$data);
	  
	   
	}
	
	function _get_time_create()
	{
	    $sql="select DATE_FORMAT(create_time,'%d-%m-%Y %h:%i:%s') create_time from information_schema.tables where table_schema='mirror' and
table_name='pupns'";

        $query  = $this->db3->query($sql);
		$row    = $query->row();
		
		return $row->create_time;
	
	}
	
	function _get_jumlah($data)
	{
        $instansi   = $data['instansi'];
        $status     = $data['status'];
		

	    $sql="SELECT PNS_NIPBARU FROM pupns WHERE PNS_KEDHUK='$status' AND PNS_INSDUK='$instansi' AND PNS_NIPBARU NOT IN (SELECT nip FROM takah.dms_nip)";
		$query  = $this->db3->query($sql);
		
		return $query->num_rows();
	
	}
	
	function _get_instansi()
	{
	    $sql="SELECT  * FROM instansi order by INS_KODINS ASC";		
		$query  = $this->db3->query($sql);
		return $query;
		
	}
	
	function _get_status()
	{
	    $sql="select * from kedhuk order by KED_KEDKOD  ASC";
		$query  = $this->db3->query($sql);
		return $query;
	
	}
	
	function _get_nama_instansi($id)
	{
	    $sql="select INS_NAMINS from instansi WHERE INS_KODINS='$id' ";
		$row  = $this->db3->query($sql)->row();
		return $row->INS_NAMINS; 
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */