<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scanning extends MY_Controller {

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
		$data['instansi']			   = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		$data['lihat']		           = FALSE;	
	    
		$this->load->view('scanning/vscanning',$data);
	}
	
	public function jalankan()
	{
	    $data['instansi']      = $this->input->post('instansi'); 
	    $data['perintah']	   = $this->input->post('perintah');
		$data['pelaksana']     = $this->input->post('pelaksana');
		
		  // save session user
		$this->session->set_userdata(array('instansi'  	  => $this->input->post('instansi'),			   
										   'pelaksana'    => $this->input->post('pelaksana'),
										   
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
	
	function getCetak($data)
	{
	    $data['lihat']		           = FALSE;	
	    $instansi                      = $data['instansi'];    
		
        $q						       = $this->getRecord($data);		
		// creating xls file
		$now              = date('dmYHis');
		$filename         = "SCANNINGPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LISTING SCANNING BERDASARKAN DATABASE MIRROR UPDATE TGL : '. $this->_get_time_create().' ' .$this->_get_instansi_name($instansi). ' <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>PRASCANNING</th>
					<th>PRADATE</th>
					<th>SCANNING</th>
					<th>PEMBERI TUGAS</th>
					<th>PELAKSANA</th>
					'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td width=400>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->prascanning}</td>";
				$html .= "<td>{$r->pradate}</td>";
				$html .= "<td>{$r->scanning}</td>";	
				$html .= "<td>{$r->pemberi_tugas}</td>";	
				$html .= "<td>{$r->pelaksana}</td>";	
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=5 >There is no data found</td></tr></table>";
			echo $html;
		}
       
	    
		
	}
	function getLihat($data)
	{
	    $data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = TRUE;	
		$data['pelaksana']			   = $data['pelaksana'];
	    $data['record']			   	   = $this->getRecord($data);
		
	    $data['instansi']			   = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('scanning/vscanning',$data);  
	
	}
	
	function getResult($data)
	{
	    $data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = FALSE;	
	    $data['record']			   	   = $this->getRecord($data);
		
	    $data['instansi']			   = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('scanning/vscanning',$data);  
	
	}
	
	function _get_time_create()
	{
	    $sql="select DATE_FORMAT(create_time,'%d-%m-%Y %h:%i:%s') create_time from information_schema.tables where table_schema='mirror' and
table_name='pupns_kp_info'";

        $query  = $this->db3->query($sql);
		$row    = $query->row();
		
		return $row->create_time;
	
	}
	
	
	function getRecord($data)
	{
	    $instansi		= $data['instansi']	;
		$pelaksana		= $data['pelaksana'];	
		
		if($pelaksana != '')
		{
		    $user =" AND a.id_pelaksana='$pelaksana'";
		}
		else
		{
		    $user  = " ";
		}
	   
	   $sql="SELECT * FROM (SELECT c.PNS_PNSNAM,c.PNS_INSDUK,d.INS_NAMINS, a.*,b.nama  pemberi_tugas,e.nama pelaksana FROM dms_nip a 
	   INNER JOIN app_user b ON b.id = a.id_app_user
	   INNER JOIN mirror.pupns c ON a.nip = c.PNS_NIPBARU
	   INNER JOIN mirror.instansi d ON  d.INS_KODINS = c.PNS_INSDUK 
	   INNER JOIN app_user e ON e.id = a.id_pelaksana
	   WHERE c.PNS_INSDUK='$instansi' $user
	   ) a
	   group by nip ORDER BY a.nip ASC";
	   
	   //var_dump($sql);
	   
	   return $this->db1->query($sql);
	
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
	    $sql="SELECT id,nama FROM app_user WHERE 1=1 $sql_limit_user and level !='kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	
	function _get_instansi()
	{
	    $sql="SELECT  * FROM instansi order by INS_KODINS ASC";		
		$query  = $this->db3->query($sql);
		return $query;
		
	}
	
	function _get_instansi_name($id)
	{
	
	    $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
		$query  = $this->db3->query($sql);
	    $row	= $query->row();
		return $row->INS_NAMINS;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */