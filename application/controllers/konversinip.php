<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konversinip extends MY_Controller {

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
	public function index()
	{
		$this->load->library('form_validation');
		$data['user']			= $this->_get_userlogin();
		$data['instansi']       = $this->_get_instansi();
		$data['npkp_today']     = $this->_get_nkpkp_today();
		$session_id = $this->session->userdata('session_id');
		//var_dump($this->session->all_userdata());
		
		$this->load->view('pencatatan/vkonversi_nip',$data);
	}
	
	public function save()
	{
	   $this->load->library('form_validation');
	   $this->form_validation->set_message('min_length', 'field " %s " panjang minimal character kurang"');
	   $this->form_validation->set_rules('instansi', 'Instansi', 'required|integer');
       $this->form_validation->set_rules('nip', 'NIP', 'required|max_length[18]|min_length[18]');
       $this->form_validation->set_rules('tmt_thn', 'Tahun', 'required|is_natural_no_zero|max_length[4]|min_length[4]');
       
	   $instansi		= $this->input->post('instansi');
	   $nip				= $this->input->post('nip');
	   $tmt_tgl			= '01';
	   $tmt_bln			= $this->input->post('tmt_bln');
	   $tmt_tahun		= $this->input->post('tmt_thn');
	   $keterangan		= $this->input->post('keterangan');
	   $action          = $this->input->post('action');
	   $tgl 	        = $this->input->post('tgl');
	   
	   //var_dump($tgl);exit;
	   
	   if ($this->form_validation->run() == FALSE)
		{
			$data['message']		= '<p><label class="label label-danger"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;GAGAL menambahkan data kenaikan pangkat</label></p>';
		
		}
		else
		{
			// session set base on user activity
			   $arr_session		= array( 'instansi'			=> $instansi,
										 'tmt_bln'			=> $tmt_bln,
										 'tmt_thn'			=> $tmt_tahun,
										 'tgl'				=> $tgl
			   );
			   $this->session->set_userdata($arr_session);
			   
			   $tmt			= $tmt_tahun.'-'.$tmt_bln.'-'.$tmt_tgl;
			   
			   $data = array(
				   'nip' 			=> $nip,
				   'tmt' 			=> $tmt,
				   'id_action' 		=> $action,
				   'id_instansi'	=> $instansi,
				   'keterangan'		=> $keterangan,
				   'id_app_user'    => $this->session->userdata('user_id')
				);
				
				if($tgl != '')
				{
				    $this->db->set('tanggal_input', $tgl);
				}
				else
				{
				    $this->db->set('tanggal_input', 'NOW()', FALSE);
				}

				$result   = $this->db->insert('pencatatan', $data); 
			   
			    //$data['message']		= "SUKSES menambahkan data kenaikan pangkat";
		        $data['message']		= '<p><label class="label label-success"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;SUKSES menambahkan data kenaikan pangkat</label></p>';
		
		}	   
		// reload again
	    $data['user']			= $this->_get_userlogin();
	    $data['instansi']       = $this->_get_instansi();
		$data['npkp_today']     = $this->_get_nkpkp_today();
		$session_id = $this->session->userdata('session_id');
		// load view
		$this->load->view('pencatatan/pencatatan_view',$data);
	   
	}
	
	/*
	get user login
	*/
	function _get_userlogin()
	{
	    $id		= $this->session->userdata('user_id');
		$sql	= "SELECT a.nama, DATE_FORMAT(b.last_login,'%d-%m-%Y %h:%i') as last_login,
		b.last_ip,a.file,a.level
FROM `last_login` b
INNER JOIN app_user a ON a.id = b.id_app_user
WHERE a.id =$id order by b.last_login desc";
        $result		= $this->db->query($sql);
		
		if($result->num_rows() > 1)
		{
		    $sql		.=" LIMIT 1,1";
			$row		 = $this->db->query($sql)->row();
			
		}
		else
		{   $row					= $result->row();
		    		
		}
		
        return $row;		
      		
	}
	
	function _get_instansi()
	{
	     return $this->db->query("SELECT * FROM instansi ORDER BY id_instansi ASC");
	}
	
	function _get_nkpkp_today()
	{
	    $id_app_user    = $this->session->userdata('user_id');
		
		$sql="SELECT * FROM pencatatan a WHERE DATE( a.created_date ) BETWEEN DATE( NOW( ) )
		AND DATE( NOW( ) ) AND a.id_app_user='$id_app_user'
		";
		
		$query= $this->db->query($sql);
		
		return $query;
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */