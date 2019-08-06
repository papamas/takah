<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notapersetujuan extends MY_Controller {

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
		
		$data['instansi']       = $this->_get_instansi();
		$data['golongan']		= $this->_get_golongan();
		$data['message']        = '';
		$data['jenis_kp']		= $this->_get_jenis_kp();
		$this->load->view('pencatatan/vnota_persetujuan',$data);
	}
	
	public function save()
	{
	    
        //var_dump($this->input->post());exit;
 
	    $instansi		 = $this->input->post('instansi');
	    $nip			 = $this->input->post('nip');
	    $tmt_tgl		 = '01';
	    $tmt_bln		 = $this->input->post('tmt_bln');
	    $tmt_tahun		 = $this->input->post('tmt_thn');
	    $keterangan		 = $this->input->post('keterangan');
	    $action          = $this->input->post('action');
	    $tgl 	         = $this->input->post('tgl');
	    $tgl_lg          = $this->input->post('tgllg');
	    $no_lg           = strtoupper($this->input->post('nolg'));
	    $gol_lama        = $this->input->post('gol_lama');
	    $gol_baru        = $this->input->post('gol_baru');
	    $tmt			 = $tmt_tahun.'-'.$tmt_bln.'-'.$tmt_tgl;
		$lokasi_kerja    = $this->input->post('lokasi_kerja');
		$jenis_kp		 = $this->input->post('jeniskp');
	   
	   	// session set base on user activity
	    $arr_session		= array( 'instansi'	    => $instansi,
								 'tmt_bln'			=> $tmt_bln,
								 'tmt_thn'			=> $tmt_tahun,
								 'tgl'				=> $tgl
	    );
	    $this->session->set_userdata($arr_session);
			   
		 $insert  = array(  'kode_instansi'		    => $instansi,
							 'nip'					=> $nip,
							 'tgl_input'			=> date('Y-m-d',strtotime($tgl)),
							 'tmt'					=> $tmt,
							 'aksi'					=> $action,
							 'keterangan'			=> $keterangan,
							 'no_lg'				=> $no_lg,
							 'tgl_lg'				=> date('Y-m-d',strtotime($tgl_lg)),
							 'gol_lama_id'			=> $gol_lama,
							 'gol_baru_id'			=> $gol_baru,
							 'status_npkp'			=> 1,
							 'id_pelaksana'			=> $this->session->userdata('user_id'),
							 'lokasi_kerja'			=> $lokasi_kerja,
							 'jenis_kp'				=> $jenis_kp
			
		);
		
		$data['nip']             = $nip;
		$data['no_lg']           = $no_lg;
		$data['tmt']		     = $tmt;
		$data['kode_instansi']   = $instansi;
		
		if($this->_tada_npkp($data))
		{
			$this->db1->insert('npkp',$insert);		
		}	   
		// reload again
	    $data['instansi']       = $this->_get_instansi();
		$data['golongan']		= $this->_get_golongan();
		$data['message']        = 'Save successfuly...';
		$data['jenis_kp']		= $this->_get_jenis_kp();
		// load view
		$this->load->view('pencatatan/vnota_persetujuan',$data);
	   
	}
	
	function search()
	{
	    $search =$this->input->post('search');
		
		if($search)
		{
		   $sql_search = "AND a.nip ='$search' ";
		}
		else
		{
		   $sql_search ="";
		}
		
		$user_id = $this->session->userdata('user_id');
		
		
		
		$sql="SELECT a.*,b.INS_NAMINS FROM 
		(SELECT a.*, DATE_FORMAT(a.tgl_input, '%d-%m-%Y') tgl_in,DATE_FORMAT(a.tmt, '%d-%m-%Y') tmt_kp
		FROM takah.npkp a  WHERE 1=1 $sql_search  AND id_pelaksana='$user_id'  order by id desc LIMIT 10 )a			 
		LEFT JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS ";
		$query = $this->db1->query($sql);
		
		$data['record']    = $query; 
		$data['message']   ='';
		$data['instansi']  = $this->_get_instansi();
	    $this->load->view('search/vnota_persetujuan',$data);
	}
	
	function _tada_npkp($data)
	
	{
	    $nip				= $data['nip'];
		$tmt				= $data['tmt'];
		$no_lg				= $data['no_lg'];
		$kode_instansi		= $data['kode_instansi'];
		
		$sql="SELECT id FROM npkp WHERE nip='$nip' AND tmt='$tmt' AND no_lg='$no_lg' AND kode_instansi='$kode_instansi'";
	    $query  = $this->db1->query($sql);
	    
		if($query->num_rows > 0)
	    {
	        $r = FALSE;
	    }
		else
		{
		    $r = TRUE;
		}
		
		return $r;
	}
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT PNS_NIPBARU as id,CONCAT( PNS_NIPBARU ,' - ', PNS_PNSNAM)  as text FROM PUPNS WHERE TRIM(PNS_NIPBARU)=TRIM('$search') OR TRIM(PNS_PNSNIP)=TRIM('$search') ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
			
	function _get_instansi()
	{
	     return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
	}
		
	function get_npkp_data()
	{
	    $nip  		=  $this->input->post('nip');
		$bulan      =  $this->input->post('bulan');
		$tahun		=  $this->input->post('tahun');
		
		if(!empty($bulan) AND !empty($tahun))
		{
		   $periode       = $tahun.'-'.$bulan.'-'.'01';
		   $sql_periode   = " AND DATE(PKI_TMT_GOLONGAN_BARU)='$periode'";
		}
		else
		{
		    $sql_periode  =" ";
		
		}
		
		$sql="select a.*,b.PNS_TEMKRJ FROM (SELECT JKP_JPNKOD,PKI_NIPBARU,NOTA_PERSETUJUAN_KP ,DATE_FORMAT(TGL_NOTA_PERSETUJUAN_KP,'%d-%m-%Y') TGL_NOTA_PERSETUJUAN_KP,DATE(PKI_TMT_GOLONGAN_BARU) PKI_TMT_GOLONGAN_BARU ,
		PKI_GOLONGAN_LAMA_ID,PKI_GOLONGAN_BARU_ID,MONTH(PKI_TMT_GOLONGAN_BARU) tmt_bln ,YEAR(PKI_TMT_GOLONGAN_BARU) tmt_thn
		FROM mirror.pupns_kp_info WHERE PKI_NIPBARU='$nip' AND 1=1  $sql_periode   AND NOTA_PERSETUJUAN_KP IS NOT NULL  ORDER BY PKI_SK_TANGGAL DESC LIMIT 0,1) a 
		INNER JOIN mirror.pupns b ON b.PNS_NIPBARU = a. PKI_NIPBARU";
		
		$query  = $this->db3->query($sql);
		if($query->num_rows()  > 0)
		{
		    $row		= $query->row();
		
            $data[]		= array('NOTA_PERSETUJUAN_KP'      => $row->NOTA_PERSETUJUAN_KP,
								'TGL_NOTA_PERSETUJUAN_KP'  => $row->TGL_NOTA_PERSETUJUAN_KP,
								'PKI_TMT_GOLONGAN_BARU'    => $row->PKI_TMT_GOLONGAN_BARU,
								'PKI_GOLONGAN_LAMA_ID'     => $row->PKI_GOLONGAN_LAMA_ID,
								'PKI_GOLONGAN_BARU_ID'	   => $row->PKI_GOLONGAN_BARU_ID,
								'TMT_BLN'                  => $row->tmt_bln,
								'TMT_THN'				   => $row->tmt_thn,
								'PNS_TEMKRJ'               => $row->PNS_TEMKRJ,
								'JKP_JPNKOD'			   => $row->JKP_JPNKOD,
			);			
		}
		else
		{
		    $data[]		= array('NOTA_PERSETUJUAN_KP'      => '',
								'TGL_NOTA_PERSETUJUAN_KP'  => '',
								'PKI_TMT_GOLONGAN_BARU'    => '',
								'PKI_GOLONGAN_LAMA_ID'     => '',
								'PKI_GOLONGAN_BARU_ID'	   => '',
								'TMT_BLN'                  => '',
								'TMT_THN'				   => '',
								'PNS_TEMKRJ'               => '',
								'JKP_JPNKOD'			   => '',
			);		
		}
		
		echo json_encode($data);	
	
	}
	
	function _get_golongan()
	{
	    $sql="SELECT * FROM `golru` ";
		$query = $this->db3->query($sql);
		
		return $query;
	}
	
	function _get_jenis_kp()
	{
	    $sql="SELECT * FROM `jenis_kp` ORDER BY JKP_JPNKOD ASC";
		$query  = $this->db3->query($sql);
	    return  $query;
		
	}
	
	function get_npkp()
	{
	   $id = $this->input->post('npkp_id');
	   $sql="SELECT *,DATE_FORMAT(tgl_input,'%d-%m-%Y') tgl_in,
	   MONTH(tmt) tmt_bln ,YEAR(tmt) tmt_thn FROM takah.npkp where id='$id' ";
	   $query = $this->db1->query($sql);
		
	   echo json_encode($query->result_array());
	   
	
	}
	
	public function update()
	{
	    $npkp_id      = $this->input->post('npkp_id');
		$nip          = $this->input->post('nip');
		$tmt_bln      = $this->input->post('tmt_bln');
		$tmt_thn      = $this->input->post('tmt_thn');
		$instansi     = $this->input->post('instansi');
		$tgl          = $this->input->post('tgl');
		$tmt          = $tmt_thn.'-'.$tmt_bln.'-'.'01';
        $aksi         = $this->input->post('action');

        $data = array('nip'				=>  $nip,
					 'kode_instansi' 	=>  $instansi,
					 'tgl_input'		=>  date('Y-m-d', strtotime($tgl)),
					 'tmt'              =>  $tmt,
					 'aksi'				=>  $aksi,
	    ); 
		
		$this->db1->where('id',$npkp_id);
		$this->db1->update('npkp',$data);


	
	}
	
	public function delete()
	{
	     $npkp_id      = $this->input->post('npkp_id');
		 $this->db1->where('id',$npkp_id);
		 $this->db1->delete('npkp');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */