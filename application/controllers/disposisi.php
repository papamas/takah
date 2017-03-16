<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disposisi extends MY_Controller {

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
		$this->db3   = $this->load->database('sapkdb', TRUE);
	    $this->db1   = $this->load->database('default', TRUE);
		//$this->load->library('openkm');
	}
	
	public function index()
	{
		$ket = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Aksi Disposisi'
            );
		
		$det = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Lihat Detail'
            );		
		$data['ket']                  = $ket;
		$data['det']                  = $det;
		
		//$data['surat_masuk']    = $this->_get_surat_masuk();
		$data['penerima']		= $this->_get_app_user();
		$data['instansi']       = $this->_get_instansi();
		$data['show']			= FALSE;
	    $data['message']        = '';
		$this->load->view('disposisi/vdisposisi',$data);
	}
	
	public function search()
	{
		$instansi 		   = $this->input->post('instansi');
		$penerima		   = $this->input->post('penerima');
		$status			   = $this->input->post('status');
		$search			   = $this->input->post('search');
		
		$this->session->set_userdata(array('instansi'  	  => $instansi,			   
										   'penerima'     => $penerima,
										   'status'       => $status,
										   'search'       => $search,
								   ));     
			
		$ket = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Aksi Disposisi'
            );
		
		$det = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Lihat Detail'
            );		
		$data['ket']                  = $ket;
		$data['det']                  = $det;
		$data['instansi']			  = $instansi;
		$data['penerima']             = $penerima;
		$data['status']               = $status;
		$data['search']               = $search;
		$data['page']				  = 0;
		$data['pagination']	          = $this->_get_pagination($data);		
		$data['surat_masuk']          = $this->_get_surat_masuk($data);
		
		// reload
		$data['penerima']		      = $this->_get_app_user();
		$data['instansi']             = $this->_get_instansi();
		$data['show']			      = TRUE;
		$data['message']		      = '';		
		$this->load->view('disposisi/vdisposisi',$data);
	}
	
	public function page()
	{
		if ($this->uri->segment(3) === FALSE)
		{
			$page = 0;
		}
		else
		{
			$page	= $this->uri->segment(3);
		}
		
		
		$ket = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Tambah Keterangan'
            );
		
		$det = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Lihat Detail'
            );		
			
		$data['ket']                  = $ket;
		$data['det']                  = $det;
		$data['instansi']			  = $this->session->userdata('instansi');
		$data['penerima']             = $this->session->userdata('penerima');
		$data['status']               = $this->session->userdata('status');
		$data['search']               = $this->session->userdata('search');
		
		$data['page']		          = $page;
		$data['pagination']	          = $this->_get_pagination($data);		
		$data['surat_masuk']          = $this->_get_surat_masuk($data);
		
		// reload
		$data['penerima']		      = $this->_get_app_user();
		$data['instansi']             = $this->_get_instansi();
		$data['show']			      = TRUE;
		$data['message']		      = '';	
		$this->load->view('disposisi/vdisposisi',$data);
	}
	
	
	function _get_pagination($data)
	{
	    $this->load->library('pagination');	
		
		$result_count				= $this->_count_surat_masuk($data)->num_rows();

		$config['base_url']   = site_url().'/disposisi/page/';
		$config['total_rows'] = $result_count;
		$config['per_page']   = 25;
		$config['full_tag_open'] = '<nav><div class="text-center"><ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul></div></nav>';
		$config['first_link'] = 'Awal';
		$config['first_tag_open'] = '<li><span aria-hidden="true">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Akhir';
		$config['last_tag_open'] = '<li><span aria-hidden="true">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li><span aria-hidden="true">';
		$config['next_tag_close'] = '</span></li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li><span aria-hidden="true">';
		$config['prev_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="active"><span class="">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		return  $this->pagination->create_links();
		
	
	}
	
	public function detail()
	{
	    if ($this->uri->segment(3) === FALSE)
		{
			$nip = 0;
		}
		else
		{
			$nip = $this->uri->segment(3);
		}
		
		$sql="SELECT a.*,d.action_disposisi, b.INS_NAMINS,c.PNS_PNSNAM FROM surat_masuk a 
	   LEFT JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
	   LEFT JOIN mirror.pupns c ON c.PNS_NIPBARU = a.nip 
	   LEFT JOIN takah.action_disposisi d ON d.id_surat = a.id
	   where a.nip='$nip' ORDER BY d.created_date DESC LIMIT 1";
	   
	    $data['record']  = $this->db1->query($sql);
	
		$this->load->view('disposisi/detail',$data);
	}
	
	public function note()
	{
	    if ($this->uri->segment(3) === FALSE)
		{
			$id = 0;
		}
		else
		{
			$id = $this->uri->segment(3);
		}
		
		$sql="SELECT a.*,b.action_disposisi from surat_masuk  a  
		LEFT JOIN action_disposisi b ON a.id = b.id_surat
		where a.id='$id' order by b.created_date desc";
		$data['record']  = $this->db1->query($sql)->row();
	
		$this->load->view('disposisi/note',$data);
		
	}
	
	public function aksimultiple()
	{
	    $status_penerima 	=  $this->input->post('status_penerima');
	    $keterangan			=  $this->input->post('keterangan');
	   
	    foreach ($status_penerima as $key => $value)
	    {
	        $id_surat	   = $status_penerima[$key];
		    $sql="SELECT id FROM action_disposisi WHERE id_surat='$id_surat' ";
		    $query  = $this->db1->query($sql);
		   	$insert         = array('id_surat' => $id_surat,'action_disposisi' => $keterangan);
			$this->db1->insert('action_disposisi',$insert);
	       
			
			$this->db1->set('status_penerima',1);
			$this->db1->set('update_date','NOW()',false);
			$this->db1->where('id',$id_surat);
			$this->db1->update('surat_masuk');
	    }
		
		
		$ket = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Aksi Disposisi'
            );
		
		$det = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0',
			  'title'      => 'Lihat Detail'
            );		
		$data['ket']                  = $ket;
		$data['det']                  = $det;
		
		//$data['surat_masuk']		= $this->_get_surat_masuk();
		$data['penerima']		= $this->_get_app_user();
		$data['instansi']       = $this->_get_instansi();
		$data['show']			= FALSE;
	    $data['message']        = 'Save successfuly...';
		$this->load->view('disposisi/vdisposisi',$data);
	
	}
	
	public function aksi()
	{
	    $id				= $this->input->post('noagenda');
		$ket			= $this->input->post('keterangan');
		
		$insert         = array('id_surat' => $id,'action_disposisi' => $ket);
		$this->db1->insert('action_disposisi',$insert);
		
		$this->db1->where('id',$id);
		$this->db1->set('status_penerima',1);
		$this->db1->set('update_date','NOW()',false);
		$this->db1->update('surat_masuk');
		
		$sql="SELECT a.*,b.action_disposisi from surat_masuk a
        LEFT JOIN action_disposisi b ON b.id_surat=a.id		
		where a.id='$id' order by b.created_date DESC ";
		$data['record']  = $this->db1->query($sql)->row();
	
		$this->load->view('disposisi/note',$data);
		
	
	}
	
	function _get_surat_masuk($data)
	{
	   $user_id   = $this->session->userdata('user_id');
	   $instansi  = $data['instansi'];
	   $penerima  = $data['penerima'];
	   $status    = $data['status'];
	   $page      = $data['page'];
	   $search   = $data['search'];
	   
	    if($penerima != '')
	    {
	        $sql_penerima = " AND a.id_penerima='$penerima' "; 
	    }
		else
		{
		    $sql_penerima  = " AND a.id_penerima='$user_id' ";
		}
		
		if($instansi != '')
		{
		    $sql_instansi  = " AND  a.kode_instansi = '$instansi' ";
		}
		else
		{
		    $sql_instansi  = " ";
			
		}
	   
	    if($status == 1)
        {
           $sql_status = "  AND status_penerima IS NOT NULL";
        }
		elseif($status == 2)
		{
		   $sql_status = "  AND status_penerima IS NULL";
		}
		else
		{
		   $sql_status = " ";
		}
		
		if($search != '')
		{
		    $sql_search  = " AND  a.nip ='$search' ";
		}
		else
		{
		    $sql_search  = " ";
			
		}
		
		$sql="SELECT a.*,b.INS_NAMINS FROM surat_masuk a 
		INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
		WHERE 1=1 $sql_penerima $sql_instansi $sql_status  $sql_search order by a.status_penerima,a.id DESC LIMIT $page,25 ";
	   
	   $query	=  $this->db1->query($sql);
	   
	   return $query;
	}
	
	function _count_surat_masuk($data)
	{
	   $user_id   = $this->session->userdata('user_id');
	   $instansi  = $data['instansi'];
	   $penerima  = $data['penerima'];
	   $status    = $data['status'];
	   $search    = $data['search'];
	   
	    if($penerima != '')
	    {
	        $sql_penerima = " AND a.id_penerima='$penerima' "; 
	    }
		else
		{
		    $sql_penerima  = " ";
		}
		
		if($instansi != '')
		{
		    $sql_instansi  = " AND  a.kode_instansi = '$instansi' ";
		}
		else
		{
		    $sql_instansi  = " ";
			
		}
	   
	    if($status == 1)
        {
           $sql_status = "  AND status_penerima IS NOT NULL";
        }
		elseif($status == 2)
		{
		   $sql_status = "  AND status_penerima IS NULL";
		}
		else
		{
		   $sql_status = " ";
		}
		
		if($search != '')
		{
		    $sql_search  = " AND  a.nip ='$search' ";
		}
		else
		{
		    $sql_search  = " ";
			
		}
		
		$sql="SELECT a.*,b.INS_NAMINS FROM surat_masuk a 
		INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
		WHERE 1=1 $sql_penerima $sql_instansi $sql_status  $sql_search order by a.status_penerima ASC ";
	   
	   $query	=  $this->db1->query($sql);
	   
	   return $query;
	}
	
	public function save()
	{
	   	$instansi				= $this->input->post('instansi');
		$nosurat				= $this->input->post('nosurat');
		$tglsurat				= $this->input->post('tglsurat');
		$tglterima				= $this->input->post('tglterima');
		$jumlahsurat			= $this->input->post('jumlahsurat');
		$nip                    = $this->input->post('nip');
		$perihal				= $this->input->post('perihal');
		$keterangan				= $this->input->post('keterangan');
		$penerima				= $this->input->post('penerima');
		
		$surat_masuk = array('tgl_terima'			=> $tglterima,
							 'nomor_surat'			=> $nosurat,
							 'tgl_surat'			=> $tglsurat,
							 'perihal'				=> $perihal,
							 'keterangan'			=> $keterangan,
							 'nip'					=> $nip,
							 'kode_instansi'		=> $instansi,
							 'id_pengirim'			=> $this->session->userdata('user_id'),
							 'id_penerima'			=> $penerima,
							 'jumlah_surat'			=> $jumlahsurat,
		
		);
		
		$this->db1->insert('surat_masuk',$surat_masuk);
		
		$data['instansi']       = $this->_get_instansi();
		$data['penerima']		= $this->_get_app_user();
		$data['message']        = 'Save successfuly...';
		$this->load->view('pencatatan/vsurat_masuk',$data);   
	}
	
	
	function _get_instansi()
	{
	    return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
	}
	
	
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT PNS_NIPBARU as id,CONCAT( PNS_NIPBARU ,' - ', PNS_PNSNAM)  as text FROM PUPNS WHERE PNS_NIPBARU LIKE '$search%' ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
	
	function _get_app_user()
	{
	    if($this->session->userdata('level') == 'kasie')
		{
		   $sql_limit_user = " ";
		}
		else
		{
		   $id  = $this->session->userdata('user_id');
		   $sql_limit_user  = " AND id='$id'";
		
		}
	    
		$sql="SELECT id,nama FROM app_user where 1=1 $sql_limit_user  AND level != 'kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
