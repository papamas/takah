<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class barcodenp extends MY_Controller {

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
		
		$data['page']                  = " LIMIT  0 , 5";		
	    $data['temp_kp']			   = $this->_getTemp_kp($data);    
		$data['pagination']	           = $this->_get_pagination($data);	
		$data['instansi']              = $this->_get_instansi();
		$this->load->view('pencatatan/vbarcode_np',$data);
	}
	
	public function search(){
		
		$search   = $this->input->post('search');
		// '8ae4828757ab0a7a0157ad55071d7c6f'
	    $result = $this->_getBarcode_data($search);
		
		if(count($result) > 0){
			
			foreach ($result->result() as $value){
			   
			    $data['nip']   			= $value->PKI_NIPBARU;
				$data['no_lg'] 			= $value->NOTA_PERSETUJUAN_KP;
				$data['kode_instansi']  = $value->PNS_INSKER;
				$data['tmt']			= $value->PKI_TMT_GOLONGAN_BARU;
				
				$insert = array( 'kode_instansi'		=> $value->PNS_INSKER,
								 'nip'					=> $value->PKI_NIPBARU,
								 'tgl_input'			=> date("Y-m-d"),
								 'tmt'					=> $value->PKI_TMT_GOLONGAN_BARU,
								 'aksi'					=> 'GABUNG',
								 'keterangan'			=> 'Barcode Input',
								 'no_lg'				=> $value->NOTA_PERSETUJUAN_KP,
								 'tgl_lg'				=> $value->TGL_NOTA_PERSETUJUAN_KP,
								 'gol_lama_id'			=> $value->PKI_GOLONGAN_LAMA_ID,
								 'gol_baru_id'			=> $value->PKI_GOLONGAN_BARU_ID,
								 'status_npkp'			=> 1,
								 'id_pelaksana'			=> $this->session->userdata('user_id'),
								 'lokasi_kerja'			=> $value->PNS_TEMKRJ,
								 'jenis_kp'				=> $value->JKP_JPNKOD
				
				);
				
				if($this->_tada_temp($data))
				{
					$this->db1->insert('temp_kp', $insert);	
				}
            }
            		
            		
		}
		
		$data['page']                  = " LIMIT  0 , 5";		
	    $data['temp_kp']			   = $this->_getTemp_kp($data);    
		$data['pagination']	           = $this->_get_pagination($data);
		$data['instansi']              = $this->_get_instansi();
		$this->load->view('pencatatan/vbarcode_np',$data);
	}
	
	
	public function save(){
		
		
		$record		= $this->_getjumlah_kp();
		
		foreach ($record->result() as $value){
			
			$data['nip']   			= $value->nip;
			$data['no_lg'] 			= $value->no_lg;
			$data['kode_instansi']  = $value->kode_instansi;
			$data['tmt']			= $value->tmt;
			
			$this->db1->trans_start();
			// cek before insert
			if($this->_tada_npkp($data))
			{
				$insert = array( 'kode_instansi'		=> $value->kode_instansi,
								 'nip'					=> $value->nip,
								 'tgl_input'			=> $value->tgl_input,
								 'tmt'					=> $value->tmt,
								 'aksi'					=> 'GABUNG',
								 'keterangan'			=> 'Barcode Input',
								 'no_lg'				=> $value->no_lg,
								 'tgl_lg'				=> $value->tgl_lg,
								 'gol_lama_id'			=> $value->gol_lama_id,
								 'gol_baru_id'			=> $value->gol_baru_id,
								 'status_npkp'			=> 1,
								 'id_pelaksana'			=> $this->session->userdata('user_id'),
								 'lokasi_kerja'			=> $value->lokasi_kerja,
								 'jenis_kp'				=> $value->jenis_kp
				
				);
				// insert to npkp
				$this->db1->insert('npkp',$insert);	

                //delete temp kp by id pelaksana
				$id    = $this->session->userdata('user_id');
                $this->db1->delete('temp_kp', array('id_pelaksana' => $id));  				
			}
            $this->db1->trans_complete();			
			
		}
		
		$data['page']                  = " LIMIT  0 , 5";		
	    $data['temp_kp']			   = $this->_getTemp_kp($data);    
		$data['pagination']	           = $this->_get_pagination($data);	
		$data['instansi']              = $this->_get_instansi();
		$this->load->view('pencatatan/vbarcode_np',$data);
		
	}
	
	public function update()
	{
	    $temp_id      = $this->input->post('temp_id');		
		$instansi     = $this->input->post('instansi');		

        $data = array('kode_instansi' 	=>  $instansi); 
		
		$this->db1->where('idtemp_kp',$temp_id);
		$this->db1->update('temp_kp',$data);	
		
		
	}
	
	public function delete()
	{
	     $temp_id      = $this->input->post('temp_id');
		 $this->db1->where('idtemp_kp',$temp_id);
		 $this->db1->delete('temp_kp');
	}
	
	function get_temp()
	{
	   $id = $this->input->post('temp_id');
	   $sql="SELECT *,DATE_FORMAT(tgl_input,'%d-%m-%Y') tgl_in,
	   MONTH(tmt) tmt_bln ,YEAR(tmt) tmt_thn FROM takah.temp_kp where idtemp_kp='$id' ";
	   $query = $this->db1->query($sql);
		
	   echo json_encode($query->result_array());
	   
	
	}
	function _get_instansi()
	{
	     return $this->db1->query("SELECT  * FROM mirror.instansi order by INS_KODINS ASC");
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
	
	function _tada_temp($data)
	
	{
	    $nip				= $data['nip'];
		$tmt				= $data['tmt'];
		$no_lg				= $data['no_lg'];
		$kode_instansi		= $data['kode_instansi'];
		
		$sql="SELECT idtemp_kp FROM temp_kp WHERE nip='$nip' AND tmt='$tmt' AND no_lg='$no_lg' AND kode_instansi='$kode_instansi'";
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
		
		
        $data['page']                  = " LIMIT  $page , 5";		
	    $data['temp_kp']			   = $this->_getTemp_kp($data);    
		$data['pagination']	           = $this->_get_pagination($data);		
		
		$this->load->view('pencatatan/vbarcode_np',$data);
	  
	   
	}
	
	function _get_pagination($data)
	{
	    $this->load->library('pagination');	
		
		$result_count				= $this->_getJumlah_kp()->num_rows();

		$config['base_url']   = site_url().'/barcodenp/page/';
		$config['total_rows'] = $result_count;
		$config['per_page']   = 5;
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
	
	function _getjumlah_kp(){
		
		$id = $this->session->userdata('user_id');
		$sql="SELECT a.*,DATE_FORMAT(a.tmt,'%d-%m-%Y')format_tmt, b.PNS_PNSNAM,d.GOL_GOLNAM gol_lama,
		e.GOL_GOLNAM gol_baru,f.JKP_JPNNAMA, c.INS_NAMINS FROM takah.temp_kp a 
		LEFT JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
		LEFT JOIN mirror.instansi c ON a.kode_instansi= c.INS_KODINS
		LEFT JOIN mirror.golru d ON a.gol_lama_id = d.GOL_KODGOL
		LEFT JOIN mirror.golru e ON a.gol_baru_id = e.GOL_KODGOL
		LEFT JOIN mirror.jenis_kp f ON a.jenis_kp = f.JKP_JPNKOD
		where a.id_pelaksana='$id'";
		$query  = $this->db1->query($sql);
		return $query;
	}
	
	function _getTemp_kp($data){
		
		$id             = $this->session->userdata('user_id');
		$page           = $data['page']; 
		
		$sql="SELECT a.*,DATE_FORMAT(a.tmt,'%d-%m-%Y')format_tmt, b.PNS_PNSNAM,d.GOL_GOLNAM gol_lama,
		e.GOL_GOLNAM gol_baru,f.JKP_JPNNAMA, c.INS_NAMINS FROM takah.temp_kp a 
		LEFT JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
		LEFT JOIN mirror.instansi c ON a.kode_instansi= c.INS_KODINS
		LEFT JOIN mirror.golru d ON a.gol_lama_id = d.GOL_KODGOL
		LEFT JOIN mirror.golru e ON a.gol_baru_id = e.GOL_KODGOL
		LEFT JOIN mirror.jenis_kp f ON a.jenis_kp = f.JKP_JPNKOD
		where a.id_pelaksana='$id' ORDER By idtemp_kp DESC
		$page ";
		$query  = $this->db1->query($sql);
		return $query;
	}
	
	function _getBarcode_data($barcode){
		
		$qkp_info = array();
		
		$sql="SELECT a.*, MONTH(a.GENERATION_DATE) BULAN,YEAR(a.GENERATION_DATE) TAHUN  FROM mirror.`pupns_barcode_dokumen` a WHERE a.`ID`='$barcode'";			
		$query  = $this->db1->query($sql);
		
		if($query->num_rows() > 0 ){
			$row  		= $query->row();
			$nip   		= $row->NIP_BARU;
			$bulan		= $row->BULAN;
			$tahun		= $row->TAHUN;
			
			switch ($bulan) {
				case "12":
					$periode = $tahun.'-10-'.'01';
					break;
				case "11":
					$periode = $tahun.'-10-'.'01';
					break;
				case "10":
					$periode = $tahun.'-10-'.'01';
					break;
				case "9":
					$periode = $tahun.'-10-'.'01';
					break;
				case "8":
					$periode = $tahun.'-10-'.'01';
					break;	
				case "7":
					$periode = $tahun.'-10-'.'01';
					break;
				case "6":
					$periode = $tahun.'-04-'.'01';
					break;
				case "5":
					$periode = $tahun.'-04-'.'01';
					break;	
				case "4":
					$periode = $tahun.'-04-'.'01';
					break;
				case "3":
					$periode = $tahun.'-04-'.'01';
					break;	
				case "2":
					$periode = $tahun.'-04-'.'01';
					break;	
				case "1":
					$periode = $tahun.'-04-'.'01';
					break;	
				default:
					$periode = $tahun.'-04-'.'01';
			}
			
			$qkp_info = $this->_getkp_info($nip,$periode);
			
		}
		return $qkp_info;
	}
	
	function _getkp_info($nip,$periode){
		
		$sql_periode   = " AND DATE(PKI_TMT_GOLONGAN_BARU)='$periode'";
		
		$sql="select a.*, b.PNS_INSKER,b.PNS_TEMKRJ FROM (SELECT JKP_JPNKOD,PKI_NIPBARU,NOTA_PERSETUJUAN_KP ,DATE(TGL_NOTA_PERSETUJUAN_KP) TGL_NOTA_PERSETUJUAN_KP ,DATE(PKI_TMT_GOLONGAN_BARU) PKI_TMT_GOLONGAN_BARU ,
		PKI_GOLONGAN_LAMA_ID,PKI_GOLONGAN_BARU_ID,MONTH(PKI_TMT_GOLONGAN_BARU) tmt_bln ,YEAR(PKI_TMT_GOLONGAN_BARU) tmt_thn
		FROM mirror.pupns_kp_info WHERE PKI_NIPBARU='$nip' AND 1=1  $sql_periode   AND NOTA_PERSETUJUAN_KP IS NOT NULL  ORDER BY PKI_SK_TANGGAL DESC LIMIT 0,1) a 
		INNER JOIN mirror.pupns b ON b.PNS_NIPBARU = a. PKI_NIPBARU";
		
		
		$query  = $this->db1->query($sql);
		return $query;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */