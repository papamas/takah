<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//include  dirname(__FILE__) . '\openkm\OpenKM.php';
 
use openkm\OKMWebServicesFactory;
use openkm\OpenKM;
use openkm\bean\Folder;

class Dms
{
    
	//const HOST = "http://localhost:8080/OpenKM/";
    //const USER = "nurmuhamadh";
    //const PASSWORD = "nurmuhamadh";
    //const TEST_DOC_PATH = "/okm:root/PROVINSI GORONTALO/IJAZAH_196312241990032005.pdf";
    //const TEST_DOC_UUID = 'd6eab74f-7d6f-4281-bd06-a98f34bac0fd';    

    private $ws;

    
    public function __construct($params = array()) {
	    $this->host		= $params['host'];
		$this->user     = $params['user'];
		$this->password = $params['password'];
		
		
	
	    $this->ws = OKMWebServicesFactory::build($this->host, $this->user, $this->password);
		//var_dump($this->ws);
              
	}
	
	public function Auth()
	{
	    return $this->ws->getName($this->user);
	
	}
	
	public function createFolder()
	{
	    return $this->ws->createFolderSimple("/okm:root/design1");
	
	}
	
	public function deleteFolder()
	{
	    return $this->ws->deleteFolder('5df7be0c-f8d4-4796-8619-6b6dde8ca2c2'); 
	
	}
	
	

}


	
	
 
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */