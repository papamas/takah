<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soap extends CI_Controller {

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
	}
	
	public function index()
	{
		// Register WSDL
		  $OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
		 
		  // Login
		  $loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin'));
		  $token = $loginResp->return;
		  echo "Token: ".$token;
		 
		  // Logout
		  $OKMAuth->logout(array('token' => $token));
	}
	
	public function okmAuth()
	{
	   // Register WSDL
		  $OKMAuth = new SoapClient('http://localhost:8080/OpenKM/services/OKMAuth?wsdl');
		 
		  // Disable WSDL cache
		  ini_set('soap.wsdl_cache_enabled', 0);
		  ini_set('soap.wsdl_cache_ttl', 0); 
		  ini_set('soap.wsdl_cache', 0);
		 
		  echo "<br>**** FUNCTIONS ****<br>";
		  foreach ($OKMAuth->__getFunctions() as $function) {
			echo $function."<br>";
		  }
		 
		  echo "<br>**** TYPES ****<br>";
		  foreach ($OKMAuth->__getTypes() as $types) {
			echo $types."<br>";
        }
	}
	
	public function okmFolder()
	{
	   // Register WSDL
		  $OKMAuth = new SoapClient('http://localhost:8080/OpenKM/services/OKMFolder?wsdl');
		 
		  // Disable WSDL cache
		  ini_set('soap.wsdl_cache_enabled', 0);
		  ini_set('soap.wsdl_cache_ttl', 0); 
		  ini_set('soap.wsdl_cache', 0);
		 
		  echo "<br>**** FUNCTIONS ****<br>";
		  foreach ($OKMAuth->__getFunctions() as $function) {
			echo $function."<br>";
		  }
		 
		  echo "<br>**** TYPES ****<br>";
		  foreach ($OKMAuth->__getTypes() as $types) {
			echo $types."<br>";
        }
	}
	
	public function okmDocument()
	{
	   // Register WSDL
		  $OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMDocument?wsdl');
		 
		  // Disable WSDL cache
		  ini_set('soap.wsdl_cache_enabled', 0);
		  ini_set('soap.wsdl_cache_ttl', 0); 
		  ini_set('soap.wsdl_cache', 0);
		 
		  echo "<br>**** FUNCTIONS ****<br>";
		  foreach ($OKMAuth->__getFunctions() as $function) {
			echo $function."<br>";
		  }
		 
		  echo "<br>**** TYPES ****<br>";
		  foreach ($OKMAuth->__getTypes() as $types) {
			echo $types."<br>";
        }
	}
	
	function okmCreateFolder()
	{
	    try {
			
			// Register WSDL
			$OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
			$OKMFolder = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMFolder?wsdl');
			
			// Login
			$loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin')); 		
			$token = $loginResp->return;
			
			 // create Folder
			$response  = $OKMFolder->createSimple( array('token' => $token, 'fldPath' => '/okm:root/WSDL1'));
			echo "<pre>";
			print_r($response);
			echo "</pre>";		
		
		} catch (Exception $e) {
		
			echo "<pre>";
			print_r($e);
			echo "</pre>";		
		
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
			
		 // Logout
		$OKMAuth->logout(array('token' => $token));
	}
	function okmTest()
	{
		try{
		    $OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
			$OKMDocument = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMDocument?wsdl');
		 	
			
			
			// Login
			$loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin')); 		
			$token = $loginResp->return;
			
			$r = $OKMDocument->getChildren(array('token' => $token, 'fldPath' => '/okm:root/Pemerintah Provinsi Sulawesi Utara/197111041998021002/D2 NP NIP'));
			
			echo "<pre>";
				print_r($r);
				echo "</pre>";
        } catch (Exception $e) {
		
			echo "<pre>";
			print_r($e);
			echo "</pre>";		
		
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}		
		// Logout
		$OKMAuth->logout(array('token' => $token));
	}
	
	function okmContent()
	{
		try{
		    $OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
			$OKMDocument = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMDocument?wsdl');
		 	
			
			
			// Login
			$loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin')); 		
			$token = $loginResp->return;
			
			
			
			$r = $OKMDocument->getContent(array('token' => $token, 'docPath' => '/okm:root/Pemerintah Provinsi Sulawesi Utara/197111041998021002/D2 NP NIP/D2-NP_NIP_195603231978031014.pdf','checkout' => TRUE));
			
			header('Pragma:public');
			header('Cache-Control:no-store, no-cache, must-revalidate');
			header('Content-type:application/pdf');
			header('Content-Disposition:inline; filename='.'test.pdf');                      
			header('Expires:0'); 
			header('Content-Transfer-Encoding: binary'); 
			echo $r->return;
			
        } catch (Exception $e) {
		
			echo "<pre>";
			print_r($e);
			echo "</pre>";		
		
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}		
		// Logout
		$OKMAuth->logout(array('token' => $token));
	}
	
	public function okmRepository()
	{
	    try {
		
			// Register WSDL
			//$OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
			$OKMRepository = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMRepository?wsdl');
			 
			// Disable WSDL cache
			  ini_set('soap.wsdl_cache_enabled', 0);
			  ini_set('soap.wsdl_cache_ttl', 0); 
			  ini_set('soap.wsdl_cache', 0);
			 
			  echo "<br>**** FUNCTIONS ****<br>";
			  foreach ($OKMRepository->__getFunctions() as $function) {
				echo $function."<br>";
			  }
			 
			  echo "<br>**** TYPES ****<br>";
			  foreach ($OKMRepository->__getTypes() as $types) {
				echo $types."<br>";
			}
			
        } catch (Exception $e) {
		
			echo "<pre>";
			print_r($e);
			echo "</pre>";		
		
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
				
	}
	
	public function okmgetTemplate()
	{
	    try {
		
			// Register WSDL
			$OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
			$OKMRepository = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMRepository?wsdl');
			//var_dump(); 
            //var_dump(); 
			 // Login
			$loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin'));
			$token = $loginResp->return;
			
			$r  = $OKMRepository->getRootFolder(array('token' => $token,'path' => '/okm:templates/DMS','uuid' => '5d671541-7eb0-45cc-948a-b4786956e267'));
			
			echo "<pre>";
			print_r($r);
			echo "</pre>";		
			
					
			
			
        } catch (Exception $e) {
		
			echo "<pre>";
			print_r($e);
			echo "</pre>";		
		
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
				
	}
	
	
	public function okmList()
	{
	     // Register WSDL
		  $OKMAuth = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMAuth?wsdl');
		  $OKMDocument = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMDocument?wsdl');
		  $OKMFolder = new SoapClient('http://178.100.211.17:8080/OpenKM/services/OKMFolder?wsdl');
		  $path = '/okm:root';
		 
		  // Login
		  $loginResp = $OKMAuth->login(array('user' => 'okmAdmin', 'password' => 'admin'));
		  $token = $loginResp->return;
		  echo "Token: ".$token."<br>";
		  echo "Path: ".$path."<br>";
		 
		  // List folders
		  $getChildrenResp = $OKMFolder->getChildren(array('token' => $token, 'fldPath' => $path));
		  $folderArray = $getChildrenResp->return;
		 
		  if ($folderArray) {
			if (is_array($folderArray)) {
			  foreach ($folderArray as $folder) {
				$this->printFolder($folder);
			  }
			} else {
			  $this->printFolder($folderArray);
			}
		  }
		 
		  // List documents
		  $getChildrenResp = $OKMDocument->getChildren(array('token' => $token, 'fldPath' => $path));
		  $documentArray = $getChildrenResp->return;
		
		  if ($documentArray) {
			if (is_array($documentArray)) {
			  foreach ($documentArray as $document) {
				$this->printDocument($document);
			  }
			} else {
			  $this->printDocument($documentArray);
			}
		  }
		 
		  // Logout
		  $OKMAuth->logout(array('token' => $token));
	}
	
	function printFolder($folder) {
		echo "[FOLDER] Path: ".$folder->path.", Author: ".$folder->author."<br>";
	}
 
	function printDocument($document) {
		echo "[DOCUMENT] Path: ".$document->path.", Author: ".$document->author.", Size: ".$document->actualVersion->size."<br>";
	}
	
	
	function _get_okm_user()
	{
	    $user_id		= $this->session->userdata('user_id');
		 
		$sql="SELECT * FROM okm_user WHERE USR_ID='$user_id'";
		
		$result		= $this->db2->query($sql);
		
		if($result->num_rows() > 1)
		{
		    $sql		.=" LIMIT 1,1";
			$row		 = $this->db2->query($sql)->row();
			
		}
		else
		{   $row					= $result->row();
		    		
		}
		
        return $row;	
	
	}
	
	public function okm()
	{
	    $this->load->library('openkm');
		$r1 = $this->openkm->Login();
		foreach($this->nip_test() as $value)
		{
			$r2 = $this->openkm->CreateFolder('/Pemerintah Provinsi Sulawesi Utara/'.$value['nip']);
			$data[]  = $r2;
			
		}
		
		foreach($data as $key => $value)
		{
		    $path = $data[$key]['result']->path;
			$rpath     = explode('/',$path);
			if(count($rpath) == 4)
			{ 
			    $template  = $this->openkm->getTemplate();
				foreach($template as $val)
				{
					$cpath   = $path.'/'.$val;
					$c       =$this->openkm->CreateTemplate($cpath);
					
					echo '<pre>';
					print_r($c);
					echo '</pre>';
				}	
			}
			
		}
		
		//$r2 = $this->openkm->getTreeFolder('/okm:root');
		//$this->openkm->buildMenu($r2);
		$r3 = $this->openkm->Logout();
		
		
		//var_dump($r1);
		
	}
	
	function nip_test()
	{
	   $r = array(array('nip'  => '198105122015031001'), array('nip'  => '198105122015031002'));
	   
	   return $r;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */