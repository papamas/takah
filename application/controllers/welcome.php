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
		$data['tahun']            = $this->_get_tahun();
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
	
	function _get_statistik()
	{
	   $sql="SELECT * FROM pie_chart GROUP BY label ORDER BY created_date DESC";
	   
	   $query = $this->db1->query($sql);
	   
	    if($query->num_rows() > 0)
	    {
	   
			foreach ($query->result() as  $key => $value)
			{
				$data[]   = array('label'   		=> $value->label,
								  'color'   		=> $value->color,
								  'highlight'		=> $value->highlight,
								  'value'			=> $value->value,
				);			
			}
	   
	    }
		
	   return json_encode($data);
	
	}
	
	function _get_line_chart()
	{
	   $sql="SELECT * FROM line_chart ";
	   
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
	   
	    }
		
	   return  json_encode($data);
	
	}
	
	function _get_line_chart_asal()
	{
	   $sql="SELECT * FROM line_chart_asal ";
	   
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
	   
	    }
		
	   return  json_encode(@$data);
	
	}
	
	function _get_bar_chart()
	{
	   $sql="SELECT * FROM bar_chart ";
	   
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
								  'data'					=> [$value->Y1,$value->Y2]
				);			
			}
	   
	    }
		
	   return  json_encode($data);
	
	}
	
	function _get_tahun()
	{
	    $sql="select YEAR(SUBDATE(CURDATE(), INTERVAL 1 YEAR)) as tahun";
		$row  = $this->db1->query($sql)->row();
		
		return $row->tahun;
	
	}
	
	
	
	
	

   
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */