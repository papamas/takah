<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pascascanning extends MY_Controller {

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
		$this->db2   = $this->load->database('okmdb', TRUE);
	    $this->db1   = $this->load->database('default', TRUE);
		$this->load->library('openkm');
	}
	
	public function index()
	{
		$user_id   = $this->session->userdata('user_id');
										
		$dms_login = $this->_get_dms_login($user_id);
		
		$data['user_dms']  = $dms_login->dms_user;
		$data['pass_dms']  = $dms_login->dms_password;
		$this->load->view('pascascanning/vpascascanning',$data);
		
	}
	
	public function get_uuid()
	{
		$uuid  		= $this->uri->segment(3);
		
		// get dms user login
		$user_id   = $this->session->userdata('user_id');
		
		$dms_login = $this->_get_dms_login($user_id);
		$user_dms  = $dms_login->dms_user;
		$pass_dms  = $dms_login->dms_password;
		
      	$this->openkm->Login($user_dms,$pass_dms);
		
		
		$res    	= $this->openkm->getPath($uuid);
		$path       = $res['result'];
		//$pro    	= $this->openkm->getPropertiesDoc('/okm:root/Pemerintah Provinsi Sulawesi Utara/197111041998021002/D2 NP NIP/D2-NP_NIP_195603231978031014.pdf');//getTreeFolder
		//$pro    	= $this->openkm->getChilds($path);//getChilds
		$pro    	= $this->openkm->getChildrenDoc($path);//getTreeFolder
		//$pro    	= $this->openkm->getTreeFolder($path);
        $this->openkm->Logout();
		
	 	 
		echo '<pre>';
		print_r($pro);
		echo '</pre>';
	
	}
	
    public function getDoc()
	{
	    $uuid  		= $this->input->post('uuid');
		
      	// get dms user login
		$user_id   = $this->session->userdata('user_id');
		
		$dms_login = $this->_get_dms_login($user_id);
		$user_dms  = $dms_login->dms_user;
		$pass_dms  = $dms_login->dms_password;
		
      	$this->openkm->Login($user_dms,$pass_dms);
		
		$res_path 	= $this->openkm->getPath($uuid);
		$path       = $res_path['result'];
		$response  	= $this->openkm->getChildrenDoc($path);
		$this->openkm->Logout();
		
		
		$result   = $response['result'];
		/* echo '<pre>';
		print_r(count($result));
		echo '</pre>';  */
		
		$html ='';
		if(count($result) > 1)
		{
			foreach ( $result as $value)
			{
			   $exres 		= explode('/',$value->path);
			   $file_name  = $exres[5];
			   $html .= '<tr><td><a  href=#  id='.$value->uuid.' class="file">'.$file_name.'</a></td></tr> ';
			}
		}
		elseif(count($result) == 1)
		{
		    $exres 		= explode('/',$result->path);
			$file_name  = $exres[5] ;
			$html .= '<tr> <td ><a href=# id='.$result->uuid. ' class="file" >'.$file_name.'</a></td></tr> ';
		}
		else
		{
		   $html .= '<tr> <td>NO FILE FOUND</td></tr> ';
		}
		//$html .='</tbody></table>';
								
	    echo $html;
	}
	
	public function getContent()
	{
	    $uuid           = $this->uri->segment(3);
		
		// get dms user login
		$user_id   = $this->session->userdata('user_id');
		
		$dms_login = $this->_get_dms_login($user_id);
		$user_dms  = $dms_login->dms_user;
		$pass_dms  = $dms_login->dms_password;
		
      	$this->openkm->Login($user_dms,$pass_dms);
		
		$respath        = $this->openkm->getPathDoc($uuid);
	    $path           = $respath['result'];
		$response  	= $this->openkm->getContent($path);
		$this->openkm->Logout();
		header('Pragma:public');
		header('Cache-Cont rol:no-store, no-cache, must-revalidate');
		header('Content-type:application/pdf');
		header('Content-Disposition:inline; filename='.'test.pdf');                      
		header('Expires:0'); 
		header('Content-Transfer-Encoding: binary'); 
		echo $response['result'];   
	}	
	
	
	function _get_okm_menu()
	{
        // get dms user login
		$user_id   = $this->session->userdata('user_id');
		
		$dms_login = $this->_get_dms_login($user_id);
		$user_dms  = $dms_login->dms_user;
		$pass_dms  = $dms_login->dms_password;
		 
		
		$r1 	= $this->openkm->Login($user_dms,$pass_dms);
		$r2 	= $this->openkm->getTreeFolder('/okm:root');
		$menu   = $this->openkm->buildMenu($r2); 
		$r3 	= $this->openkm->Logout(); 
		
		return $menu;
	}
	
	function _get_nama($id)
	{
	   $sql="SELECT * FROM app_user WHERE id='$id' ";
	   $row   = $this->db1->query($sql)->row();
	   return $row->nama;
	   
	   
	   
	}
	
	function _get_dms_login($id)
	{
	    $sql="SELECT dms_user,dms_password FROM app_user WHERE id='$id' ";
		$query = $this->db1->query($sql);
		$row   = $query->row();
		
		return $row;
		
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */