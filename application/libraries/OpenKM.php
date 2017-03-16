<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OpenKM {

    var $server    = 'http://178.100.211.17:8080/OpenKM/';
	var $user      = 'okmAdmin';
	var $password  = 'admin';
	var $okmAuth   = 'services/OKMAuth?wsdl';
	var $okmFolder = 'services/OKMFolder?wsdl';
	var $okmDoc    = 'services/OKMDocument?wsdl';
	var $okmRepo   = 'services/OKMRepository?wsdl';
	var $token;
	var $OKMAuth;
	var $RootPath = '/okm:root';
	var $FolderPath = '/New Folder';
	var $OKMFolder;
	var $OKMDocument;
	
	public function __construct($params = array())
    {
        log_message('debug', "OpenKM Class Initialized");
		// Register WSDL
		try{
			@$this->OKMAuth = new SoapClient($this->server.$this->okmAuth);
		} catch (Exception $e) {
           
		   	echo '<pre>';
			echo $e->getMessage();
			echo '</pre>';
            
		}	
    }
	
	public function Login($user,$password)
    {
	    
		if($user != '' && $password != '')
		{
			$this->user      = $user;
			$this->password  = $password;
		}
		
		try{
			// Login
			$loginResp = $this->OKMAuth->login(array('user' => $this->user, 'password' => $this->password));
			$this->token = $loginResp->return; 
			
			return array( 'status' => TRUE ,'message'  => 'Connection Succesfully ', 'token'  => $this->token);
			
		} catch (Exception $e) {
           
		   	return array('status' => FALSE ,'message'  => 'Connection Failed '. $e->getMessage()); 
		}
		
		//var_dump($loginResp);
    }
	
	public function CreateFolder($path)
	{
	        
		$this->FolderPath  = $path;		
		
		try{
		    
			$this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
			 // create Folder
			 
			$response  = $this->OKMFolder->createSimple( array('token' => $this->token, 'fldPath' => $this->RootPath.$this->FolderPath)); 
					
            $r = array('status' => TRUE , 'result' => $response->return);			
		
		}catch (Exception $e) {
           
		   	$r  =  array('status' => FALSE ,'message'  => 'Create Folder Failed '. $e->getMessage()); 
		}
		
		return $r;
	
	}
	
	public function CreateTemplate($path)
	{
	    try{
		    
			$this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
			 // create Folder
			 
			$response  = $this->OKMFolder->createSimple( array('token' => $this->token, 'fldPath' => $path)); 
					
            $r = array('status' => TRUE , 'result' => $response->return);			
		
		}catch (Exception $e) {
           
		   	$r  =  array('status' => FALSE ,'message'  => 'Create Folder Failed '. $e->getMessage()); 
		}
		
		return $r;
	
	}
	
	public function getChildren($RootPath)
	{
        $this->RootPath = $RootPath;
		
		try{
		
		    $this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
            $response  = $this->OKMFolder->getChildren(array('token' => $this->token, 'fldPath' => $this->RootPath));	
			//if(count($response) == 1 ) return FALSE;
            $r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'message'  => 'Get Children Failed '. $e->getMessage()); 			
		}
		
		return $r;
	
	}	
	

	public function getTreeFolder($path)
	{
	    $this->RootPath   = $path;
		
		try{
		
		    $response  = $this->getChildren($this->RootPath);	
			//if(count($response) == 1 ) return FALSE;
			$result    = $response['result'];
			
			$tree   = array();
			
		    if(sizeof($result) > 1)
			{
				foreach ($result as $key =>$value)
				{
					$tree[] = array('path' 					=> $value->path,
					                'uuid' 					=> $value->uuid,
									'hasChildren' 			=> $value->hasChildren
							);
							
					$hasChildren       = $value->hasChildren;
					$extext		   	   = explode('/',$value->path);
					
					if($hasChildren)
					{					
						
						$tree[$key]['Text']       = 'Call GET TREE FOLDER '. $value->path;
						$tree[$key]['Title']	  = $extext[count($extext)-1];
						$res 					  = $this->getTreeFolder($value->path);
						$tree[$key]['Children']   = $res;
						
						
					}
                    else
					{
					   $tree[$key]['Title']	  = $extext[count($extext)-1];
					}
					$r = $tree;    	
					
					
				}
					
		    }
			else
			{
			    $hasChildren   = $result->hasChildren;
				$tree[] = array('path' => $result->path,'uuid' => $result->uuid,'hasChildren' => $result->hasChildren);
				$extext				   = explode('/',$result->path);
					
				if($hasChildren)
				{
					$tree[0]['Text']       = 'Call GET TREE FOLDER '. $result->path;
					$res 					= $this->getTreeFolder($result->path);
					$tree[0]['Title']	   = $extext[count($extext)-1];
					$tree[0]['Children']   = $res;
						
				}
				else
				{
				   $tree[0]['Title']	  = $extext[count($extext)-1];
				}	
					
				$r = $tree;  
			}
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'message'  => 'Get Tree Folder Failed '. $e->getMessage()); 			
		}
		
		return $r;
	
	}	
	
	
	
	function buildMenu($array)
	{
		 //if(count($array) == 1 ) return FALSE;
		 echo "<ul>";
		  
		  foreach ($array as $item)
		  {
			echo '<li class="folder">';
			echo '<a href='.$item['uuid'].'>'.$item['Title'].'</a>';
			if (!empty($item['Children']))
			{
			  $this->buildMenu($item['Children']);
			}
			echo '</li>';
			
		  }
		  echo '</ul>';
	}
	
	function isValid($path)
	{
	    $this->FolderPath  = $path;
		
		try{
		
		    $this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
            $response  = $this->OKMFolder->isValid(array('token' => $this->token, 'fldPath' => $this->RootPath.$this->FolderPath));	
            $r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Is Valid Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	function getPath($uuid)
	{
	    try{
		
		    $this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
            $response  = $this->OKMFolder->getPath (array('token' => $this->token, 'uuid' => $uuid));	
            $r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Folder Path Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	function getProperties($path)
	{
	    try{
		
		    $this->OKMFolder = new SoapClient($this->server.$this->okmFolder);
            $response  = $this->OKMFolder->getProperties(array('token' => $this->token, 'fldPath' => $path));	
            $r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Folder Properties Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	// DOcument
	
	function getChildrenDoc($path)
	{
	    try{
		
		    $this->OKMDocument = new SoapClient($this->server.$this->okmDoc);
            $response  = $this->OKMDocument->getChildren(array('token' => $this->token, 'fldPath' => $path));
			$r = array('status' => TRUE , 'result' => @$response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Children Doc Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	
	function getChilds ($path)
	{
	    try{
		
		    $this->OKMDocument = new SoapClient($this->server.$this->okmDoc);
            $response  = $this->OKMDocument->getChilds(array('token' => $this->token, 'fldPath' => $path));
			$r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Childs Doc Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	function getPropertiesDoc ($path)
	{
	    try{
		
		    $this->OKMDocument = new SoapClient($this->server.$this->okmDoc);
            $response  = $this->OKMDocument->getProperties (array('token' => $this->token, 'docPath' => $path));
			$r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Childs Doc Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}


    function getContent ($path)
	{
	    try{
		
		    $this->OKMDocument = new SoapClient($this->server.$this->okmDoc);
            $response  = $this->OKMDocument->getContent(array('token' => $this->token, 'docPath' => $path,'checkout' => TRUE));
			
			$r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Content Doc Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}
	
	function getPathDoc($uuid)
	{
	    try{
		
		    $this->OKMDocument = new SoapClient($this->server.$this->okmDoc);
            $response  = $this->OKMDocument->getPath (array('token' => $this->token, 'uuid' => $uuid));	
            $r = array('status' => TRUE , 'result' => $response->return);				
		
		}catch (Exception $e) {
		    
            $r  =  array('status' => FALSE ,'result' => FALSE, 'message'  => 'Get Folder Path Failed '. $e->getMessage()); 			
		}
		
		return $r;

	}

	
	function getTemplate()
	{
	    $template  = array('D2 NP NIP','IJAZAH','SK CPNS','SK PNS','PERUB DT DASAR','DRH','SK KP TERAKHIR','SPMJ TERAKHIR','SK PJO','SK PPJN');
		return $template;
	}
	
	
	public function Logout()
	{
	    // Logout
		$r = $this->OKMAuth->logout(array('token' => $this->token));
		
		return $r;
	}
}

/* End of file Someclass.php */