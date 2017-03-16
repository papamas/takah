<?php

/**
 * MY_Controller Class
 *
 * Base controller
 *
 * @package		Kalkun
 * @subpackage	Base
 * @category	Controllers
 */
class MY_Controller  extends CI_Controller  {
	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function __construct($login=TRUE)
	{
		parent::__construct();	
		
		
		if($login)
		{
			// session check
			if($this->session->userdata('logged_in')==NULL) 
			{
				redirect('login','refresh');
	        }		
		}
	}
	
	
	function log($log)
	{
	  
		$log		= array( 'log'				=> $log,
							 'created_by'		=> $this->session->userdata('user_id'),
							 'ip_address'		=> $this->input->ip_address(),
							 'request_uri'		=> $_SERVER['REQUEST_URI'],
							 'http_user_agent'  => $_SERVER['HTTP_USER_AGENT'],
							 'http_post'		=> $_SERVER['HTTP_HOST'],
							 'http_referer'     => @$_SERVER['HTTP_REFERER'],
		);
		$this->db->insert('log_app', $log);
	
	}
	
	
	
	
		
	
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */ 
