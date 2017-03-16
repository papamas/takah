<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crontab extends CI_Controller {

	/**
	 * Public function Index Login controller.
	 * Output Message Login
     * Action Login Auth 
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
		echo " Memulai scanning directory ....<br/>";
		$this->scandir();
		
		echo " <br/>Memulai mehitung statistik data..... <br/>";
		echo " <br/>Mehitung statistik database..... <br/>";
		$this->getAll();
		echo " <br/>Mehitung statistik PWK..... <br/>";
		$this->getAll2();
		$this->getAll3();
		echo " <br/>Mehitung statistik NPKP..... <br/>";
		$this->getAll4();
		echo " <br/>Complete.. <br/>";
		
	}
	
    public function scandir()
	{
	   echo " Starting get DMS Scanning data....<br/>";
	   // TIMESTAMPDIFF(MONTH, '2015-01-01', NOW())
	   
	   $sql="SELECT * from dms_nip WHERE TIMESTAMPDIFF(DAY, pradate, NOW()) < '25' ";
	   $query=$this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	       echo "Found DMS Scanning data : ". $query->num_rows().'<br/>';
	    }
		else
		{
		     echo "SORRY DATA NOT FOUND ".'<br/>';
			 echo "EXIT SCANNING DIRECTORY ";
			 return FALSE;
		}
	   
	   echo " Starting Login to DMS Server....<br/>";
	   $loginres  =  $this->openkm->Login();
	   
	   echo "Login Response.. <br/>";
	   
	   echo "<pre>";
	   print_r($loginres);
	   echo "</pre><br/>";
	   
	   $data = array();
	   $datDoc = array();
	   
	    foreach($query->result() as $key => $value)
	    {
	        $data[] = array('nip'             => $value->nip,
			                'kode_instansi'   => $value->kode_instansi,
							'nama_instansi'   => $value->nama_instansi,
							'id_pelaksana'    => $value->id_pelaksana,
							'id_pemberi_tugas'=> $value->id_app_user,
							'nama_pns'		  => $value->nama,
							'id_dms_nip'      => $value->id
							
			
			);
			
			$response  	= $this->openkm->getChildren($value->path);
			if($response['status'])
			{
				foreach($response['result'] as $k => $val)
				{
					echo "Getting Document Path.. ".$val->path.'<br/>';
					
					$responseDoc  	= $this->openkm->getChildrenDoc($val->path);
					$exres 		    = explode('/',$val->path);
			        $jenisDoc       = $exres[4];
					$datDoc[$jenisDoc]= array('Jumlah' => count($responseDoc['result']), 'Created' => $val->created ,'path' => $val->path);
					$data [$key] ['jenisDoc'] = $datDoc;
					
					echo "Getting Response Document .. <br/>";
					echo "<pre>";
					print_r($datDoc);
					echo "</pre><br/>";
					
				    /* echo '<pre>';
					print_r($responseDoc);
					echo '</pre> <br/>';  */ 
					
				}	
			}
			            			
	    }	   
	   
	   $this->openkm->Logout();
	   
	    echo "Logout from DMS server.. <br/>";
		
		echo "Starting update DMS FILE.. <br/>";
	   
	    foreach ($data as $value)
	    {
		    $this->db1->where('id_dms_nip',$value['id_dms_nip']);
			$this->db1->delete('dms_scan');
				
			$jenisDoc =  $value['jenisDoc'];
		   
		    foreach ( $jenisDoc as $key =>  $item)  {
				
				
				$dms_scan =  array('id_dms_nip' 	=> $value['id_dms_nip'],
							 'path'					=> $item['path'],
						     'jenis_doc'			=> $key,
						     'jumlah'				=> $item['Jumlah'],
						     'created_doc'			=> $item['Created'],
						
				);
				
				/*  echo '<pre>';
				print_r($dms_scan);
				echo '</pre>'; */ 
				$this->db1->insert('dms_scan',$dms_scan);
			}

			$this->db1->set('scanning',1);
			$this->db1->set('scandate','NOW()',FALSE);
			$this->db1->where('id',$value['id_dms_nip']);
			$this->db1->update('dms_nip');
	    }     
  	    
		echo "Success update DMS FILE.. <br/>";
	   
	  return TRUE;	   
	    
	}
	
	function getAll()
	{
	    $this->db1->truncate('pie_chart');
		
		$surat    = $this->_getJumlahSurat();
		$npkp     = $this->_getJumlahNPKP();
		$pwk	  = $this->_getJumlahPWK();
		$bup      = $this->_getJumlahBUP();
		$hukuman  = $this->_getJumlahHukuman();
		$scanning = $this->_getJumlahScanning();
		$cpns     = $this->_getJumlahCPNS();
	    
	}
	
	function _getJumlahCPNS()
	{
	    $sql="SELECT id FROM cpns ";	
		$cpns =  $this->db1->query($sql)->num_rows();	
		$color   = $this->getColor();
		
		$icpns  = array( 'value'         =>  $cpns,
		                'color'		     =>  $color ,
						'highlight'      =>  $color ,
		                'label'		     =>  'CPNS',
						
		);
		$this->db1->insert('pie_chart', $icpns);
		
	}
	
	
	function _getJumlahScanning()
	{
	    $sql="SELECT nip FROM dms_nip WHERE scanning IS NOT NULL";	
		$scanning =  $this->db1->query($sql)->num_rows();	
		$color   = $this->getColor();
		
		$iscan  = array( 'value'         => $scanning,
		                'color'		     => $color ,
						'highlight'      => $color ,
		                'label'		     => 'SCAN',
						
		);
		$this->db1->insert('pie_chart', $iscan);
	}
	
	function _getJumlahSurat()
	{
	    $this->db1->select('id');
		$surat =  $this->db1->get('surat_masuk')->num_rows();
        $color   = $this->getColor();
		
		$isurat = array('value'          => $surat,
		                'color'		     => $color,
						'highlight'      => $color,
		                'label'		     => 'SURAT',
						
		);

        $this->db1->insert('pie_chart', $isurat);		
	}
	
	function _getJumlahNPKP()
	{
	    $this->db1->select('id');
		$npkp  = $this->db1->get('npkp')->num_rows();	
		
		$color   = $this->getColor();
		
		$inpkp  = array('value'         =>  $npkp,
		                'color'		     => $color,
						'highlight'      => $color,
		                'label'		     => 'NPKP',
						
		);
		
		$this->db1->insert('pie_chart', $inpkp);
		
		
	}
	
	function _getJumlahPWK()
	{
	    $this->db1->select('id');
		$pwk  =  $this->db1->get('pwk')->num_rows();		
		
		$color   = $this->getColor();	
		$ipwk  = array( 'value'          => $pwk,
		                'color'		     => $color ,
						'highlight'      => $color ,
		                'label'		     => 'PWK',
						
		);
		$this->db1->insert('pie_chart', $ipwk);
	}
	
	function _getJumlahBUP()
	{
	    $this->db1->select('id');
		$bup =  $this->db1->get('bup')->num_rows();	
		
		$color   = $this->getColor();		
		$ibup  = array( 'value'          => $bup,
		                'color'		     => $color ,
						'highlight'      => $color ,
		                'label'		     => 'BUP' ,
						
		);
		
		$this->db1->insert('pie_chart', $ibup);
	}
	
	function _getJumlahHukuman()
	{
	    $this->db1->select('id');
		$hukuman =  $this->db1->get('hukuman')->num_rows();	
		$color   = $this->getColor();
		
		$ihuk  = array( 'value'          => $hukuman,
		                'color'		     => $color ,
						'highlight'      => $color ,
		                'label'		     => 'HD',
						
		);
		
		$this->db1->insert('pie_chart', $ihuk);
		
	}
	
	function getAll2()
	{   
	    $this->db1->truncate('line_chart');
		
	    $res = $this->getPWK();
		foreach ($res->result()  as $value)
        {
            $color =  $this->getColor();
			
			$line = array('label'    			=>  $this->_get_namaInstansi($value->instansi_tujuan),
						  'fillColor'			=>  $color,
						  'strokeColor'			=>  $color,
						  'pointColor'			=>  $color,
						  'pointStrokeColor'    =>  $color,
						  'pointHighlightFill'	=>  '#fff',
						  'pointHighlightStroke'=>  $color,	
						  'kd_ins'              =>  $value->instansi_tujuan,
						  'Q1'                  =>  $value->Q1,
						  'Q2'                  =>  $value->Q2,
						  'Q3'                  =>  $value->Q3,
						  'Q4'                  =>  $value->Q4,
						  
						  
			);  
			$this->db1->insert('line_chart',$line);
			
			/* 
			YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR))
			select a.instansi_tujuan, 
			SUM(CASE WHEN quarter(tmt) = 1 AND year(tmt)= YEAR(CURDATE()) THEN 1 ElSE 0 END) AS Q1,
			SUM(CASE WHEN quarter(tmt) = 2 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q2, 
			SUM(CASE WHEN quarter(tmt) = 3 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q3, 
			SUM(CASE WHEN quarter(tmt) = 4 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q4 
			from pwk a
			*/
        }		
	
	}
	
	function getAll3()
	{   
	    $this->db1->truncate('line_chart_asal');
		
	    $res = $this->getPWKAsal();
		foreach ($res->result()  as $value)
        {
            $color =  $this->getColor();
			
			
			$line = array('label'    			=>  $this->_get_namaInstansi($value->instansi_asal),
						  'fillColor'			=>  $color,
						  'strokeColor'			=>  $color,
						  'pointColor'			=>  $color,
						  'pointStrokeColor'    =>  $color,
						  'pointHighlightFill'	=>  '#fff',
						  'pointHighlightStroke'=>  $color,	
						  'kd_ins'              =>  $value->instansi_asal,
						  'Q1'                  =>  $value->Q1,
						  'Q2'                  =>  $value->Q2,
						  'Q3'                  =>  $value->Q3,
						  'Q4'                  =>  $value->Q4,
						  
						  
			);  
			
			$this->db1->insert('line_chart_asal',$line);
				
				
			
			/* 
			YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR))
			select a.instansi_tujuan, 
			SUM(CASE WHEN quarter(tmt) = 1 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
			SUM(CASE WHEN quarter(tmt) = 2 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q2, 
			SUM(CASE WHEN quarter(tmt) = 3 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q3, 
			SUM(CASE WHEN quarter(tmt) = 4 AND year(tmt)= YEAR(CURDATE()) THEN 1 ELSE 0 END) AS Q4 
			from pwk a
			*/
        }		
	
	}
	
	function getPWK()
    {
        $sql="select a.instansi_tujuan, 
			SUM(CASE WHEN quarter(tmt) = 1 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
			SUM(CASE WHEN quarter(tmt) = 2 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
			SUM(CASE WHEN quarter(tmt) = 3 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
			SUM(CASE WHEN quarter(tmt) = 4 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
			from pwk a GROUP BY instansi_tujuan";
		$query  = $this->db1->query($sql);
		
		return $query;
		
    }
	
	function getPWKAsal()
    {
        $sql="select a.instansi_asal, 
			SUM(CASE WHEN quarter(tmt) = 1 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
			SUM(CASE WHEN quarter(tmt) = 2 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
			SUM(CASE WHEN quarter(tmt) = 3 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
			SUM(CASE WHEN quarter(tmt) = 4 AND year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
			from pwk a  WHERE a.instansi_asal IN (
			SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972')
			GROUP BY instansi_asal";
		$query  = $this->db1->query($sql);
		
		return $query;
		
    }
	
	
	function getColor()
	{
	   /*  $c1 = mt_rand(200,225); //r(ed)
        $c2 = mt_rand(50,200); //g(reen)
        $c3 = mt_rand(50,200); //b(lue)
		
		$color = 'rgb('.$c1.', '.$c2.', '.$c3.')';
		return $color; */
		
		 mt_srand((double)microtime()*1000000);
		$c = '';
		while(strlen($c)<6){
			$c .= sprintf("%02X", mt_rand(0, 255));
		}
		return '#'.$c;
	  
	}
	
	function _get_namaInstansi($id)
	{
	    $sql="SELECT INS_NAMINS FROM mirror.instansi WHERE INS_KODINS='$id' ";		
		$row = $this->db3->query($sql)->row();
		
		return $row->INS_NAMINS;
		
	
	}
	
	function getAll4()
	{   
	    $this->db1->truncate('bar_chart');
		
	    $res = $this->getNPKP();
		foreach ($res->result()  as $value)
        {
            $color =  $this->getColor();
			
			$line = array('label'    			=>  $value->tmt,
						  'fillColor'			=>  $color,
						  'strokeColor'			=>  $color,
						  'pointColor'			=>  $color,
						  'pointStrokeColor'    =>  $color,
						  'pointHighlightFill'	=>  '#fff',
						  'pointHighlightStroke'=>  $color,	
						  'Y1'                  =>  $value->Y1,
						  'Y2'                  =>  $value->Y2,		  
						  
			);  
			
			$this->db1->insert('bar_chart',$line);
			
        }		
	
	}
	
	function getNPKP()
	{
      $sql="select a.kode_instansi,a.tmt ,
SUM(CASE WHEN year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Y1,
SUM(CASE WHEN year(tmt)= YEAR(CURDATE()) 	                       THEN 1 ELSE 0 END) AS Y2 
from npkp a GROUP BY tmt,kode_instansi";	 

	 

       $query  = $this->db1->query($sql);
		
		return $query;
	}
	
	 	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */