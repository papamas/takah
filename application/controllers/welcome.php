<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

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
		//$this->load->library('openkm');
	}
	
	public function index()
	{
	    
		$data['statistik']		  = $this->_get_statistik();
		$data['line_chart']       = $this->_get_line_chart();
		$data['line_chart_asal']  = $this->_get_line_chart_asal();
		$data['bar_chart']        = $this->_get_bar_chart();
		$data['stat_cpns']        = $this->_get_stat_cpns();
		$data['stat_surat']       = $this->_get_stat_surat();
		$data['stat_bup']         = $this->_get_stat_bup();
		$data['stat_hd']          = $this->_get_stat_hd();
		$data['tahun']            = $this->_get_tahun();
		
		// kab
		$data['statistik_kab']		  = $this->_get_statistik_kab();
		$data['line_chart_kab']       = $this->_get_line_chart_kab();
		$data['line_chart_asal_kab']  = $this->_get_line_chart_asal_kab();
		$data['bar_chart_kab']        = $this->_get_bar_chart_kab();
		$data['stat_cpns_kab']        = $this->_get_stat_cpns_kab();
		$data['stat_surat_kab']       = $this->_get_stat_surat_kab();
		$data['stat_bup_kab']         = $this->_get_stat_bup_kab();
		$data['stat_hd_kab']          = $this->_get_stat_hd_kab();
		$this->load->view('welcome_message',$data);
		
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
	
	function _get_okm_menu()
	{
	    $this->load->library('openkm');
		$r1 	= $this->openkm->Login();
		$r2 	= $this->openkm->getTreeFolder('/okm:root');
		$menu   = $this->openkm->buildMenu($r2);
		$r3 	= $this->openkm->Logout();
		
		return $menu;
	}
	
	
	function _get_stat_hd()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM (SELECT a.* FROM takah.pie_chart a WHERE kd_instansi in(
		select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') 
		OR kd_instansi IN(7000,7100,7900)) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='HD' ";
	   
	    $query = $this->db1->query($sql);
		
		
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
	        return json_encode($data);
	    }
		
	}
	
	function _get_stat_hd_kab()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM 
		(SELECT a.* FROM takah.pie_chart a WHERE 
		kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
		) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='HD' ";
	   
	    $query = $this->db1->query($sql);
					   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
			return json_encode($data);
	   
	    }   
	
	}
	
	function _get_stat_bup()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM (SELECT a.* FROM takah.pie_chart a WHERE kd_instansi in(
		select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') 
		OR kd_instansi IN(7000,7100,7900)) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='BUP' ";
	   
	    $query = $this->db1->query($sql);
		
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
			return json_encode($data);   
	    }		   
	}
	
	function _get_stat_bup_kab()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM 
		(SELECT a.* FROM takah.pie_chart a WHERE 
		kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
		) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='BUP' ";
	   
	    $query = $this->db1->query($sql);
		  
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
	        return json_encode($data);
	    }	
	}
	
	function _get_stat_surat()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM (SELECT a.* FROM takah.pie_chart a WHERE kd_instansi in(
		select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') 
		OR kd_instansi IN(7000,7100,7900)) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='SURAT' ";
	   
	    $query = $this->db1->query($sql);
		
		if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
	        return json_encode($data);
	    }	
	}
	
	function _get_stat_surat_kab()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM 
		(SELECT a.* FROM takah.pie_chart a WHERE 
		kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
		) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='SURAT' ";
	   
	    $query = $this->db1->query($sql);
		  
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
			
			return json_encode($data);	   
	    }
	}
	
	function _get_stat_cpns()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM (SELECT a.* FROM takah.pie_chart a WHERE kd_instansi in(
		select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') 
		OR kd_instansi IN(7000,7100,7900)) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='CPNS' ";
	   
	    $query = $this->db1->query($sql);
		
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
	        return json_encode($data);
	    }
	}
	
	function _get_stat_cpns_kab()
	{
	    $sql="SELECT a.*,a.value nilai, b.INS_NAMINS nama_instansi FROM 
		(SELECT a.* FROM takah.pie_chart a WHERE 
		kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	    kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
		) a 
		INNER JOIN mirror.instansi b ON a.kd_instansi = b.INS_KODINS WHERE a.label='CPNS' ";
	   
	    $query = $this->db1->query($sql);
		  
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$color  = $this->getColor();
				
				$data[]   = array('label'   		    	=> $value->nama_instansi,
								  'fillColor'   			=> $color,
								  'strokeColor'		    	=> $color,
								  'pointColor'				=> $color,
								  'pointStrokeColor'		=> $color,
								  'pointHighlightFill'		=> "#fff",
								  'pointHighlightStroke'	=> $color,
								  'data'					=> [$value->nilai]
				);			
			}
	        return json_encode($data);
	    }	
	}
	
	function _get_statistik()
	{
	   $sql="SELECT a.*, SUM(value) tvalue FROM pie_chart a WHERE kd_instansi in(
	   select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') 
	   OR kd_instansi IN(7000,7100,7900) GROUP BY label";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		=> $value->label,
								  'color'   		=> $value->color,
								  'highlight'		=> $value->highlight,
								  'value'			=> $value->tvalue,
				);			
			}
	        return json_encode($data);
	    }	
	}
	
	function _get_statistik_kab()
	{
	   $sql="SELECT a.*, SUM(value) tvalue FROM pie_chart a 
	   WHERE kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	   kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	   kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
	   GROUP BY label";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		=> $value->label,
								  'color'   		=> $value->color,
								  'highlight'		=> $value->highlight,
								  'value'			=> $value->tvalue,
				);			
			}
	        return json_encode($data);
	    }	
	}
	
	function _get_line_chart()
	{
	   $sql="SELECT * FROM line_chart where
	   kd_ins in(select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') OR kd_ins IN(7000,7100,7900) ";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> $value->label,
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->Q1,$value->Q2,$value->Q3,$value->Q4]
				);			
			}
	        return  json_encode($data);
	    }	
	}
	
	function _get_line_chart_kab()
	{
	   $sql="SELECT * FROM line_chart where
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> $value->label,
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->Q1,$value->Q2,$value->Q3,$value->Q4]
				);			
			}
			
			return  json_encode($data);   
	    }			  
	}
	
	function _get_line_chart_asal()
	{
	   $sql="SELECT * FROM line_chart_asal where 
	   kd_ins in(select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') OR kd_ins IN(7000,7100,7900) ";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> $value->label,
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->Q1,$value->Q2,$value->Q3,$value->Q4]
				);			
			}
	        return  json_encode($data);
	    }	
	}
	
	function _get_line_chart_asal_kab()
	{
	   $sql="SELECT * FROM line_chart_asal where 
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	   kd_ins IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> $value->label,
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->Q1,$value->Q2,$value->Q3,$value->Q4]
				);			
			}
	        return  json_encode($data);
	    }	
	}
	
	function _get_bar_chart()
	{
	   $sql="SELECT a.*,sum(Y1) tY1,sum(Y2)tY2 FROM 
	   (SELECT * FROM bar_chart WHERE kd_instansi in(
	    select ins_kodins from mirror.instansi where ins_kodins between '1010' AND '4062') OR kd_instansi IN(7000,7100,7900) )
		a GROUP by a.label ";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> DATE('m-Y',strtotime($value->label)),
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->tY1]
				);			
			}
	        return  json_encode($data);
	    }   
	
	}
	
	function _get_bar_chart_kab()
	{
	   $sql="SELECT a.*,sum(Y1) tY1,sum(Y2)tY2 FROM 
	   (SELECT * FROM bar_chart WHERE 
	   kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7901' AND 7972 ) OR
	   kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7101' AND 7171 ) OR
	   kd_instansi IN(SELECT INS_KODINS FROM mirror.instansi WHERE INS_KODINS BETWEEN '7001' AND 7074 )
	   ) a 
	   GROUP by a.label ";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		    	=> DATE('m-Y',strtotime($value->label)),
								  'fillColor'   			=> $value->fillColor,
								  'strokeColor'		    	=> $value->strokeColor,
								  'pointColor'				=> $value->pointColor,
								  'pointStrokeColor'		=> $value->pointStrokeColor,
								  'pointHighlightFill'		=> $value->pointHighlightFill,
								  'pointHighlightStroke'	=> $value->pointHighlightStroke,
								  'data'					=> [$value->tY1]
				);			
			}
			
			return  json_encode($data); 
	    }
	}
	
	function _get_tahun()
	{
	    $sql="select YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) as tahun";
		$row  = $this->db1->query($sql)->row();
		
		return $row->tahun;
	
	}
	
	
	
	function getColor()
	{
	    /* mt_srand((double)microtime()*1000000);
		$c = '';
		while(strlen($c)<6){
			$c .= sprintf("%02X", mt_rand(0, 255));
		}
		return '#'.$c; */
		$characters  = 'ABCDEF0123456789';
		   $hexadecimal = '#';
		   for ($i = 1; $i <= 6; $i++) {
			  $position     = rand(0, strlen($characters) - 1);
			  $hexadecimal .= $characters[$position];
		   }
		   return $hexadecimal;
			  
	}
	
	

   
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */