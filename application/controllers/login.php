<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Public function Index Login controller.
	 * Output Message Login
     * Action Login Auth 
	 */    
	function __construct()
	{
	    parent::__construct();
		$this->db2   = $this->load->database('okmdb', TRUE);
	    $this->db1   = $this->load->database('default', TRUE);
	}
		
    public function index()
	{
		// hide messaage pada pertama view
		$data['message']		= 'Masukan username dan password';		
		// load view login
		$this->load->view('login',$data);
	}
	
	/*
	public Auth
	remove space from user name dan password
	cek app user first jika di temukan berarti yang login app user
	jika tidak di temukan cari di tabel peserta
	jika tidak di temukan di app user dan peserta message auth failed
	set last login app user
	set session login
	*/
	public function auth()
	{
		$name  = $this->_remove_space($this->input->post('username'));
		$pwd   = $this->_remove_space($this->input->post('password'));		
		
		// cek in okm user
		$query = $this->db1->query(" SELECT nama,level,id FROM app_user WHERE user_name='$name' AND password =SHA1('$pwd')"); 
	    	
		
		 
		if($query->num_rows() > 0)
		{
			//  get  login data
			$row   	     = $query->row();
			
			// save session user
			$this->session->set_userdata(array('nama'  		      => $row->nama,			   
											   'logged_in'        => TRUE,
											   'user_id'	      => $row->id,
											   'app_user'         => TRUE,	
                                               'level'            => $row->level,						  
									   ));      
            // set last login
			$this->_set_last_login();
			
			// online user
			$this->_set_online_user();
			
			$last_login  =   $this->_get_lastlogin();
			
			// redirect to dash board after sukses login
			redirect('welcome');			   
		}
		else 
		{
			// bukan peserta dan app u
			$data['message']  = '<span class="text-danger ">&nbsp;Username atau Password Salah</span>	';
			$this->load->view('login',$data);
				
        }
    }
	/*
	public function logout
	*/
	public function logout()
	{
	    
		// destroy session
		$this->session->sess_destroy();
		// redirect login page
		redirect('login');
           		
	
	}
	
	/*
	private funtion set last login
	*/
	function _set_last_login()
	{	    
		// get app user id from session
		$created_by		= $this->session->userdata('user_id');	
		
		// insert 1 record  last login tabel
		$this->db1->set('last_login','NOW()',FALSE);
		$this->db1->set('last_ip',$this->input->ip_address());
		$this->db1->set('id_app_user',$created_by);
		$this->db1->insert('last_login');
	
	}
	
	/*
	private set online user
	*/
	function _set_online_user()
	{
	    // get app user from session
		$created_by		=  $this->session->userdata('user_id');
		
		// insert 1 record table online user
		$this->db1->set('created_date','NOW()',FALSE);
		$this->db1->set('id_app_user',$created_by);
		$this->db1->insert('online_user');

	}
	
	/*
	private function delete online app_user
	*/
	function _delete_online_user()
	{
	    $this->db1->where('id_app_user',$this->session->userdata('user_id'));
		$this->db1->delete('online_user');

	}
	
	/*
	Private function
	function _remove_space untuk menghapus space pada  text box
	*/
	function _remove_space($string)
	{
         $text = $str=preg_replace('/\s+/', '', $string);
		 return $text;		 
	}
	

    /*
	get user login
	*/
	function _get_lastlogin($name)
	{
	    $created_by		= $this->session->userdata('user_id');	
		
		$sql	= "SELECT DATE_FORMAT(b.last_login,'%d-%m-%Y %h:%i') as last_login
		FROM `last_login` b WHERE b.id_app_user ='$created_by' order by b.last_login desc LIMIT 1,1";
        $result		= $this->db1->query($sql);
		
		$row		 = $this->db1->query($sql)->row();
					
        $this->session->set_userdata('last_login',$row->last_login);	
      		
	}
	 	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */