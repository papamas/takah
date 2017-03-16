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
	public function scan_nip()
	{
	     $sql="SELECT 
    a . *, b . *
FROM
    okmdb.`okm_node_base` a
        inner join
    takah.dms_nip b ON a.NBS_NAME LIKE concat('%', b.nip, '%')
        INNER JOIN
    okmdb.okm_node_folder c ON c.NBS_UUID = a.NBS_UUID
	WHERE a.NBS_CONTEXT ='okm_root'
	AND	TIMESTAMPDIFF(DAY, b.pradate, NOW()) < '30' 
	-- AND id_pelaksana='9'
	";
	     $r  = $this->db1->query($sql)->result_array();
         return $r;		
    }
	function getChild($uuid) 	
	{
		$sql = "select 
		*
	from
		okmdb.okm_node_base
	WHERE
		nbs_parent = '$uuid'";
		$r = $this->db1->query($sql)->result_array();
		$children = array();
		if(count($r) > 0) 
		{
			# It has children, let's get them.
			foreach ( $r as $key => $item )
			{
				# Add the child to the list of children, and get its subchildren
				$children[$item['NBS_NAME']] = count($this->getChild($item['NBS_UUID']));
			}
		}
		return $children;
	}
    public function scandir()
	{
	    $nip       = $this->scan_nip();
		echo " Starting get DMS Scanning data....".count($nip)."<br/>";
		$data = array();
		foreach ( $nip as $item)
		{		
		    $folder  = $this->getChild($item['NBS_UUID']);	    
            $data [] = array('NIP'    		 => $item['NBS_NAME'],
			                 'UUID'          => $item['NBS_UUID'],
			                 'CREATED_DOC'	 => $item['NBS_CREATED'],
							 'DMS_NIP_ID'    => $item['id'],
							 'KODE_INSTANSI' => $item['kode_instansi'],
							 'ID_PELAKSANA'  => $item['id_pelaksana'],
							 'AUTHOR'        => $item['NBS_AUTHOR'],
                     		 'FOLDER' 		 => $folder
							);
		}
		echo "Starting update DMS FILE.. <br/>";
		if(count($data) > 0){
	    foreach ($data as $key => $value)
	    {
		    $this->db1->where('id_dms_nip',$value['DMS_NIP_ID']);
			$this->db1->delete('dms_scan');				
			$folder =  $value['FOLDER'];
			echo "Counting FILE..".$value['NIP']. "<br/>";
			foreach ( $folder as $key =>  $item)  {
				$dms_scan =  array('id_dms_nip' 	=> $value['DMS_NIP_ID'],
							 'path'					=> '',
						     'jenis_doc'			=> $key,
						     'jumlah'				=> $folder[$key],
						     'created_doc'			=> $value['CREATED_DOC'],
				);
				$this->db1->insert('dms_scan',$dms_scan);
			} 
			echo "Updating status.. ".$value['NIP']."<br/>";
			$id = $this->getid_by_author($value['AUTHOR']);
			$this->db1->set('scanning',1);
			$this->db1->set('scandate','NOW()',FALSE);
			$this->db1->set('id_pelaksana',$id);
			$this->db1->where('id',$value['DMS_NIP_ID']);
			$this->db1->update('dms_nip');
	    }     
		echo "Success update DMS FILE.. <br/>";
		}
	  return TRUE;	   
	}
	function getid_by_author($author)
	{
	    $sql="SELECT * FROM app_user WHERE user_name='$author' ";
		$q  = $this->db1->query($sql);
		if($q->num_rows() > 0)
		{
		    $row = $q->row();
			$r = $row->id;
		}
		else
		{
		    $r = '';
		}
		
		return $r;
	}
	function getAll()
	{
	    $this->db1->truncate('pie_chart');
		$surat    = $this->_getJumlahSurat();
		$npkp     = $this->_getJumlahNPKP();
		$pwk_m	  = $this->_getJumlahPWK_masuk();
		$pwk_k	  = $this->_getJumlahPWK_keluar();
		$bup      = $this->_getJumlahBUP();
		$hukuman  = $this->_getJumlahHukuman();
		$scanning = $this->_getJumlahScanning();
		$cpns     = $this->_getJumlahCPNS();
		$pinjam   = $this->_getJumlahPeminjaman();
	}
	function _getJumlahCPNS()
	{
	    $sql="SELECT instansi, count(id) jumlah FROM `cpns` where year(created_date)= year(curdate()) group by instansi ";	
		//$cpns =  $this->db1->query($sql)->num_rows();	
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{
			$icpns  = array( 'value'         =>  $value->jumlah,
							'color'		     =>  $color ,
							'highlight'      =>  $color ,
							'label'		     =>  'CPNS',
							'kd_instansi'    => $value->instansi,
			);
			$this->db1->insert('pie_chart', $icpns);
        }			
	}
	function _getJumlahScanning()
	{
	    $sql="SELECT kode_instansi,count(id) jumlah FROM dms_nip WHERE scanning IS NOT NULL AND year(created_date)=year(curdate()) GROUP BY kode_instansi";	
		//$scanning =  $this->db1->query($sql)->num_rows();	
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{
			$iscan  = array( 'value'         => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'SCAN',
							'kd_instansi'    => $value->kode_instansi,
			);
			$this->db1->insert('pie_chart', $iscan);
		}	
	}
	function _getJumlahSurat()
	{
	    //$this->db1->select('id');
		//$surat =  $this->db1->get('surat_masuk')->num_rows();
        $sql="SELECT count(id) jumlah,kode_instansi FROM `surat_masuk` WHERE year(created_date)=year(curdate()) group by kode_instansi";
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{
			$isurat = array('value'          => $value->jumlah,
							'color'		     => $color,
							'highlight'      => $color,
							'label'		     => 'SURAT',
							'kd_instansi'    => $value->kode_instansi,
			);
			$this->db1->insert('pie_chart', $isurat);
        }			
	}
	function _getJumlahNPKP()
	{
	    //$this->db1->select('id');
		//$npkp  = $this->db1->get('npkp')->num_rows();	
		$sql="SELECT count(id) jumlah,kode_instansi FROM `npkp` where year(created_date)=year(curdate()) group by kode_instansi";
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{	
			$inpkp  = array('value'         =>  $value->jumlah,
							'color'		     => $color,
							'highlight'      => $color,
							'label'		     => 'NPKP',
							'kd_instansi'    => $value->kode_instansi,
			);
			$this->db1->insert('pie_chart', $inpkp);
		}
	}
	function _getJumlahPWK_masuk()
	{
	    //$this->db1->select('id');
		//$pwk  =  $this->db1->get('pwk')->num_rows();		
		$sql= "SELECT count(id) jumlah,instansi_tujuan FROM `pwk` where year(created_date)=year(curdate()) group by instansi_tujuan";
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{	
			$ipwk  = array( 'value'          => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'PWK Masuk',
							'kd_instansi'    => $value->instansi_tujuan,
			);
			$this->db1->insert('pie_chart', $ipwk);
		}	
	}
	function _getJumlahPWK_keluar()
	{
	    //$this->db1->select('id');
		//$pwk  =  $this->db1->get('pwk')->num_rows();		
		$sql= "SELECT count(id) jumlah,instansi_asal FROM `pwk` where year(created_date)=year(curdate()) group by instansi_asal";
		$color   = $this->getColor();
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{	
			$ipwk  = array( 'value'          => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'PWK Keluar',
							'kd_instansi'    => $value->instansi_asal,
			);
			$this->db1->insert('pie_chart', $ipwk);
		}	
	}
	function _getJumlahBUP()
	{
	    //$this->db1->select('id');
		//$bup =  $this->db1->get('bup')->num_rows();	
		$sql="SELECT count(id) jumlah, instansi FROM `bup` WHERE year(created_date)=year(curdate()) GROUP by instansi";
		$color   = $this->getColor();	
        $query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{		
			$ibup  = array( 'value'          => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'BUP' ,
							'kd_instansi'    => $value->instansi,
			);
			$this->db1->insert('pie_chart', $ibup);
		}	
	}
	function _getJumlahHukuman()
	{
	    //$this->db1->select('id');
		//$hukuman =  $this->db1->get('hukuman')->num_rows();	
		$color   = $this->getColor();
		$sql="SELECT count(id) jumlah, instansi FROM `hukuman` where year(created_date)=year(curdate()) GROUP by instansi";
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{
			$ihuk  = array( 'value'          => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'HD',
							'kd_instansi'    => $value->instansi,
			);
			$this->db1->insert('pie_chart', $ihuk);
		}	
	}
	function _getJumlahPeminjaman()
	{
	    //$this->db1->select('id');
		//$hukuman =  $this->db1->get('hukuman')->num_rows();	
		$color   = $this->getColor();
		$sql="SELECT count(id) jumlah, kode_instansi FROM `formulir_pinjam` where year(created_date)=year(curdate()) GROUP by kode_instansi";
		$query   = $this->db1->query($sql);
		foreach ($query->result() as $value)
		{
			$ihuk  = array( 'value'          => $value->jumlah,
							'color'		     => $color ,
							'highlight'      => $color ,
							'label'		     => 'Peminjaman',
							'kd_instansi'    => $value->kode_instansi,
			);
			$this->db1->insert('pie_chart', $ihuk);
		}	
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
        /* $sql="SELECT a.*,
SUM(CASE WHEN quarter(a.tmt) = 1 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
SUM(CASE WHEN quarter(a.tmt) = 2 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
SUM(CASE WHEN quarter(a.tmt) = 3 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
SUM(CASE WHEN quarter(a.tmt) = 4 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
FROM (SELECT a.instansi_tujuan ,a.tmt FROM pwk a WHERE year(tmt) = year(SUBDATE(CURDATE(),INTERVAL 1 YEAR))
) a
WHERE a.instansi_tujuan IN (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972')
GROUP BY a.instansi_tujuan"; */
        $sql="SELECT a.*,
SUM(CASE WHEN quarter(a.tmt) = 1 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
SUM(CASE WHEN quarter(a.tmt) = 2 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
SUM(CASE WHEN quarter(a.tmt) = 3 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
SUM(CASE WHEN quarter(a.tmt) = 4 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
FROM (SELECT a.instansi_tujuan ,a.tmt FROM pwk a WHERE year(tmt) = year(SUBDATE(CURDATE(),INTERVAL 1 YEAR))
) a
GROUP BY a.instansi_tujuan";
		$query  = $this->db1->query($sql);
		return $query;
    }
	function getPWKAsal()
    {
		/* $sql="SELECT a.*,
SUM(CASE WHEN quarter(a.tmt) = 1 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
SUM(CASE WHEN quarter(a.tmt) = 2 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
SUM(CASE WHEN quarter(a.tmt) = 3 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
SUM(CASE WHEN quarter(a.tmt) = 4 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
FROM (SELECT a.instansi_asal ,a.tmt FROM pwk a WHERE year(tmt) = year(SUBDATE(CURDATE(),INTERVAL 1 YEAR))
) a
WHERE a.instansi_asal IN (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972')
GROUP BY a.instansi_asal";	 */
        $sql="SELECT a.*,
SUM(CASE WHEN quarter(a.tmt) = 1 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Q1,
SUM(CASE WHEN quarter(a.tmt) = 2 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q2, 
SUM(CASE WHEN quarter(a.tmt) = 3 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q3, 
SUM(CASE WHEN quarter(a.tmt) = 4 AND year(a.tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ELSE 0 END) AS Q4 
FROM (SELECT a.instansi_asal ,a.tmt FROM pwk a WHERE year(tmt) = year(SUBDATE(CURDATE(),INTERVAL 1 YEAR))
) a
GROUP BY a.instansi_asal";	
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
						  'kd_instansi'         =>  $value->kode_instansi
			);  
			$this->db1->insert('bar_chart',$line);
        }		
	}
	function getNPKP()
	{
      $sql="select a.kode_instansi,a.tmt ,
SUM(CASE WHEN year(tmt)= YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) THEN 1 ElSE 0 END) AS Y1,
SUM(CASE WHEN year(tmt)= YEAR(CURDATE()) 	                       THEN 1 ELSE 0 END) AS Y2 
from npkp a GROUP BY a.tmt,a.kode_instansi";	 
       $query  = $this->db1->query($sql);
		return $query;
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
