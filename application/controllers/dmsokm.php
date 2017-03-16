<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmsokm extends CI_Controller {

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
		//$this->db2   = $this->load->database('okmdb', TRUE);
	    //$this->db1   = $this->load->database('default', TRUE);
	}
	
	public function index()
	{
	   	$url = 'http://localhost:8080/OpenKM/services/rest/folder/getChildren/?fldId=371925f1-d41f-4851-a9db-dce8a1a24f67';
		      		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERPWD, 'nurmuhamadh:nurmuhamadh');
		curl_setopt($curl, CURLOPT_HEADER, true);
		//curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($curl, CURLOPT_POSTFIELDS, array(
			'fldId' => '371925f1-d41f-4851-a9db-dce8a1a24f67',
		));
		$response = curl_exec($curl);		
		echo "<pre>";
	    print_r(curl_getinfo($curl));
		echo "</pre>";
		//print_r($response);
		echo "<code>" . nl2br(htmlentities($response)) . "</code><br/>\n\n";
		curl_close($curl);
		
		$xml = simplexml_load_string($response);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		print_r($array); 
	
		
	
	}
	
	public function createFolder()
	{
	    $url = 'http://localhost:8080/OpenKM/services/rest/folder/createSimple';
		      		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERPWD, 'nurmuhamadh:nurmuhamadh');
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		//curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS,'/okm:root/newfolder8');
		$response = curl_exec($curl);		
		echo "<pre>";
	    print_r(curl_getinfo($curl));
		echo "</pre>";
		curl_close($curl);
		echo "<code>" . nl2br(htmlentities($response)) . "</code><br/>\n\n";
		
		
	}
	
	public function createFolder2()
	{
	    $this->load->library('Curl');				
		$url = 'http://localhost:8080/OpenKM/services/rest/folder/createSimple';
		$this->curl->http_login('nurmuhamadh', 'nurmuhamadh');
		$this->curl->option(CURLOPT_HTTPHEADER,array('Content-Type: application/xml'));
		//$this->curl->option(CURLOPT_POSTFIELDS,'/okm:root/newfolder');
		$output  = $this->curl->simple_post($url,'/okm:root/newfolder1/newfolder1.1');
		
		
		$xml = simplexml_load_string($output);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		print_r($array); 
		
		$info   = $this->curl->get_info();
		
		print_r($info['http_code']);
		
	
	}
	
	
	
	public function createDocument()
	{
	    $this->load->library('Curl');
	    
		$this->curl->option(CURLOPT_BUFFERSIZE, 10);
		$this->curl->option(CURLOPT_HTTPHEADER, array('Content-Type: text/html;charset=utf-8'));
				
		$this->curl->http_login('nurmuhamadh', 'nurmuhamadh');		
		$url = 'http://178.100.211.17:8080/OpenKM/services/rest/document/createSimple/';		
		$params = array('docPath'       => '/okm:root/PROVINSI SULUT',
						'content'		=> '@new.txt'
		);
		
		$output  = $this->curl->simple_post($url,$params);
		$this->curl->debug();
		
		var_dump($output );
	
	}
	
	
	public function getChildren()
	{
	    $this->load->library('Curl');
		
		
		$url = 'http://localhost:8080/OpenKM/services/rest/folder/getChildren/';
       		
		$params = array('fldId' 		=> '371925f1-d41f-4851-a9db-dce8a1a24f67');
		
		$this->curl->http_login('nurmuhamadh', 'nurmuhamadh');
		
		$output  = $this->curl->simple_get($url,$params);
		$this->curl->debug();
		
		$xml = simplexml_load_string($output);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);
		
		print_r($array); 
		 
	
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */