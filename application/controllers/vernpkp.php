<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vernpkp extends MY_Controller {

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
		$data['instansi']			   = $this->_get_instansi();
		$data['jenis_kp']			   = $this->_get_jenis_kp();
		$data['lihat']		           = FALSE;	
		$data['show_jml']              = FALSE;
		$data['message']               = '';
		$this->load->view('vernpkp/vnota_persetujuan',$data);
	}
	
	public function jalankan()
	{
	    $data['instansi']      = $this->input->post('instansi'); 
	    $data['perintah']	   = $this->input->post('perintah');
		$data['tmt_bln']       = $this->input->post('tmt_bln');
		$data['tmt_thn']       = $this->input->post('tmt_thn');
		$data['start']	       = $this->input->post('start');
	    $data['end']	       = $this->input->post('end');
		$data['status']        = $this->input->post('status');
		$data['jenis_kp']      = $this->input->post('jeniskp');
		
		  // save session user
		$this->session->set_userdata(array('instansi'  	  => $this->input->post('instansi'),			   
										   'tmt_bln'   	  => $this->input->post('tmt_bln'),
										   'tmt_thn'   	  => $this->input->post('tmt_thn'),
										   'status'       => $this->input->post('status'),
										   'jenis_kp'     => $this->input->post('jeniskp'),
								   ));     
		
		if($this->input->post('perintah') == '1')
	    {
		    $this->getResult($data); 
	   
	    }
		elseif($this->input->post('perintah') == '2')
		{
		    $this->getLihat($data); 
	   
		}
		else
		{
		    $this->getCetak($data); 
	   	
		}
	}
	
	public function getCetak($data)
	{
	    $data['lihat']		           = FALSE;
        $data['show_jml']              = FALSE;
		
	    $instansi                      = $data['instansi'];    	
		$data['page']                  = " ";
        $q						       = $this->_getRecord($data);	
		
		// creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKP".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LISTING NPKP BERDASARKAN DATABASE MIRROR UPDATE TGL : '. $this->_get_time_create().' ' .$this->_get_instansi_name($instansi). ' <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>GOLONGAN</th>
					<th>NO.LG</th>
					<th>TGL.NPKP</th>
					<th>TMT</th>
					<th>JENIS</th>
					<th>AKSI</th>
					<th>TGL INPUT</th>
					<th>STATUS</th>
					<th>CREATED</th>
					<th>KETERANGAN</th>
					'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->PKI_NIPBARU}</td>";
				$html .= "<td width=400>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->GOL_LAMA} - {$r->GOL_BARU}</td>";
				$html .= "<td>{$r->NOTA_PERSETUJUAN_KP}</td>";
				$html .= "<td>{$r->TGL_NPKP}</td>";
				$html .= "<td>{$r->TMT_GOL}</td>";
				$html .= "<td>{$r->JKP_JPNNAMA}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td>{$r->tgl_input}</td>";
				$html .= "<td>{$r->status_npkp}</td>";
				$html .= "<td>{$r->created_date}</td>";
				$html .= "<td>{$r->keterangan}</td>";
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=7 >There is no data found</td></tr></table>";
			echo $html;
		}
       
	    
		
	}
	
	public function getLihat($data)
	{
	    $data['page']                  = " LIMIT  0 , 25";
		$data['record']			   	   = $this->_getRecord($data);				
		$data['pagination']	           = $this->_get_pagination($data);
		$data['jumlah']				   = $this->_getJumlah($data);
		
		// reload
		$atts = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0'
            );
		$data['atts']                  = $atts;
		$data['jenis_kp']			   = $this->_get_jenis_kp();
		$data['show_jml']              = TRUE;
	    $data['instansi']			   = $this->_get_instansi();
		$data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = TRUE;	
		$data['message']               = '';
		
		$this->load->view('vernpkp/vnota_persetujuan',$data);
	  
	   
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
		
		$data['status']				   = $this->session->userdata('status');
	    $data['jenis_kp']			   = $this->session->userdata('jenis_kp');
		$data['instansi']              = $this->session->userdata('instansi');
    	$data['tmt_thn']               = $this->session->userdata('tmt_thn');
		$data['tmt_bln']               = $this->session->userdata('tmt_bln');
        $data['page']                  = " LIMIT  $page , 25";		
	    $data['record']			   	   = $this->_getRecord($data);    
		$data['pagination']	           = $this->_get_pagination($data);
		$data['jumlah']				   = $this->_getJumlah($data);
		// reload
		$atts = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0'
            );
		$data['atts']                  = $atts;
		$data['jenis_kp']			   = $this->_get_jenis_kp();
		$data['instansi']			   = $this->_get_instansi();
		$data['show_jml']              = TRUE;
		$data['lihat']		           = TRUE;	
	    $data ['create_time']          = $this->_get_time_create();
	    $data['message']               = '';
		
		
		$this->load->view('vernpkp/vnota_persetujuan',$data);
	  
	   
	}
	
	function _get_pagination($data)
	{
	    $this->load->library('pagination');	
		
		$result_count				= $this->_getJumlah($data)->num_rows();

		$config['base_url']   = site_url().'/vernpkp/page/';
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
	
	public function history()
	{
	    if ($this->uri->segment(3) === FALSE)
		{
			$nip = 0;
		}
		else
		{
			$nip = $this->uri->segment(3);
		}

		$sql="
		select 
			b.GOL_GOLNAM GOL_LAMA,
				c.GOL_GOLNAM GOL_BARU,
				a.PKI_NIPBARU,
				a.PKI_TGL_USUL,
				a.PKI_NOM_USUL,
				a.NOTA_PERSETUJUAN_KP,
				DATE_FORMAT(a.TGL_NOTA_PERSETUJUAN_KP, '%d-%m-%Y') TGL_NPKP,
				DATE_FORMAT(a.PKI_TMT_GOLONGAN_BARU, '%d-%m-%Y') TMT
		FROM
			mirror.pupns_kp_info a
		INNER JOIN MIRROR.golru b ON b.GOL_KODGOL = a.PKI_GOLONGAN_LAMA_ID
		INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.PKI_GOLONGAN_BARU_ID
		WHERE a.PKI_NIPBARU='$nip'
		ORDER BY a.TGL_NOTA_PERSETUJUAN_KP DESC";   
		$data['record']  = $this->db3->query($sql);
	
		$this->load->view('vernpkp/historynpkp',$data);
	}
	
	public function getResult($data)
	{
	      
	    $data['jumlah']			   	   = $this->_getJumlah($data);
		
		// reload
		$data['show_jml']              = TRUE;
	    $data['instansi']			   = $this->_get_instansi();
		$data['jenis_kp']			   = $this->_get_jenis_kp();
		$data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = FALSE;	
	    $data['message']               = '';
		
		$this->load->view('vernpkp/vnota_persetujuan',$data);
	  
	   
	}
	
	function _get_time_create()
	{
	    $sql="select DATE_FORMAT(create_time,'%d-%m-%Y %h:%i:%s') create_time from information_schema.tables where table_schema='mirror' and
table_name='pupns_kp_info'";

        $query  = $this->db3->query($sql);
		$row    = $query->row();
		
		return $row->create_time;
	
	}
	
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
		
	}
	
	function _getRecord($data)
	{
	    //var_dump($data);exit;
			
		$status    		= $data['status'];
	    $jkp        	= $data['jenis_kp'];
		$instansi   	= $data['instansi'];
    	$tmt	    	= $data['tmt_thn'].'-'.$data['tmt_bln'].'-'.'01';  
	    $page           = $data['page']; 
		 
	    if($status == '1')
	    {
	        $status= " AND a.status_npkp IS NOT NULL";
			 
	    }
        elseif($status == '2')
        {
	         $status = " AND a.status_npkp IS NULL";
			 
	    }
		else
		{
		    $status = " ";
			
		}
		
		if($jkp != '')
		{
		    $jenis  = " AND a.JKP_JPNKOD='$jkp' ";
		}
		else
		{
		    $jenis  = " ";
		}
	   
    $sql="SELECT A.* from (SELECT 
    a . *,
    b.id,
    b.aksi,
    b.tgl_input,
    b.created_date,
    b.keterangan,
    b.status_npkp,
    b.nip,
    b.kode_instansi,
    b.tmt,
    b.no_lg,
    b.tgl_lg,
    b.gol_baru_id,
    b.gol_lama_id,
    b.lokasi_kerja,
	b.jenis_kp
FROM
    (SELECT 
        a . *, b.PNS_INSDUK, b.PNS_PNSNAM, b.PNS_TEMKRJ
    FROM
        (select 
        a.PKI_NIPBARU,
            a.PKI_TGL_USUL,
            a.PKI_NOM_USUL,
            a.NOTA_PERSETUJUAN_KP,
            DATE_FORMAT(a.TGL_NOTA_PERSETUJUAN_KP, '%Y-%m-%d') TGL_NPKP,
            DATE_FORMAT(a.PKI_TMT_GOLONGAN_BARU, '%Y-%m-%d') TMT_GOL,
            a.JKP_JPNKOD,
            a.PKI_GOLONGAN_LAMA_ID,
            a.PKI_GOLONGAN_BARU_ID,
            b.JKP_JPNNAMA,
            c.GOL_GOLNAM GOL_LAMA,
            d.GOL_GOLNAM GOL_BARU
    FROM
        mirror.pupns_kp_info a
    INNER JOIN mirror.jenis_kp b ON b.JKP_JPNKOD = a.JKP_JPNKOD
    INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.PKI_GOLONGAN_LAMA_ID
    INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.PKI_GOLONGAN_BARU_ID
    WHERE
        a.NOTA_PERSETUJUAN_kp IS NOT NULL
            AND DATE(a.PKI_TMT_GOLONGAN_BARU) = '$tmt') a
    INNER JOIN (SELECT 
        a.PNS_NIPBARU, a.PNS_INSDUK, a.PNS_PNSNAM, a.PNS_TEMKRJ
    FROM
        mirror.pupns a    
    WHERE
        a.PNS_INSDUK = '$instansi'
            ) b ON b.PNS_NIPBARU = a.PKI_NIPBARU) a
        LEFT JOIN
    takah.npkp b ON b.nip = a.PKI_NIPBARU
)a
INNER JOIN  mirror.LOKKER b ON b.LOK_LOKKOD = a.PNS_TEMKRJ
where b.LOK_KANREG = '11' $status $jenis $page ";
	
	//var_dump($sql);exit;
   
    $query  = $this->db3->query($sql);
	
	
	return $query;
	
	}
	
	function _getJumlah($data)
	{
	    $instansi   = $data['instansi'];
	    $tmt		= $data['tmt_thn'].'-'.$data['tmt_bln'].'-'.'01';
	    $status     = $data['status'];
	    $jkp        = $data['jenis_kp'];
	   
	   
	   if($status == '1')
	    {
	        $status= " AND a.status_npkp IS NOT NULL";
			 
	    }
        elseif($status == '2')
        {
	         $status = " AND a.status_npkp IS NULL";
			 
	    }
		else
		{
		    $status = " ";
			
		}
		
		if($jkp != '')
		{
		    $jenis  = " AND a.JKP_JPNKOD='$jkp' ";
		}
		else
		{
		    $jenis  = " ";
		}
	   
    $sql="SELECT A.* from (SELECT 
    a . *,
    b.id,
    b.aksi,
    b.tgl_input,
    b.created_date,
    b.keterangan,
    b.status_npkp,
    b.nip,
    b.kode_instansi,
    b.tmt,
    b.no_lg,
    b.tgl_lg,
    b.gol_baru_id,
    b.gol_lama_id,
    b.lokasi_kerja,
	b.jenis_kp
FROM
    (SELECT 
        a . *, b.PNS_INSDUK, b.PNS_PNSNAM, b.PNS_TEMKRJ
    FROM
        (select 
        a.PKI_NIPBARU,
            a.PKI_TGL_USUL,
            a.PKI_NOM_USUL,
            a.NOTA_PERSETUJUAN_KP,
            DATE_FORMAT(a.TGL_NOTA_PERSETUJUAN_KP, '%Y-%m-%d') TGL_NPKP,
            DATE_FORMAT(a.PKI_TMT_GOLONGAN_BARU, '%Y-%m-%d') TMT_GOL,
            a.JKP_JPNKOD,
            a.PKI_GOLONGAN_LAMA_ID,
            a.PKI_GOLONGAN_BARU_ID,
            b.JKP_JPNNAMA,
            c.GOL_GOLNAM GOL_LAMA,
            d.GOL_GOLNAM GOL_BARU
    FROM
        mirror.pupns_kp_info a
    INNER JOIN mirror.jenis_kp b ON b.JKP_JPNKOD = a.JKP_JPNKOD
    INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.PKI_GOLONGAN_LAMA_ID
    INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.PKI_GOLONGAN_BARU_ID
    WHERE
        a.NOTA_PERSETUJUAN_kp IS NOT NULL
            AND DATE(a.PKI_TMT_GOLONGAN_BARU) = '$tmt') a
    INNER JOIN (SELECT 
        a.PNS_NIPBARU, a.PNS_INSDUK, a.PNS_PNSNAM, a.PNS_TEMKRJ
    FROM
        mirror.pupns a    
    WHERE
        a.PNS_INSDUK = '$instansi'
            ) b ON b.PNS_NIPBARU = a.PKI_NIPBARU) a
        LEFT JOIN
    takah.npkp b ON b.nip = a.PKI_NIPBARU
)a
INNER JOIN  mirror.LOKKER b ON b.LOK_LOKKOD = a.PNS_TEMKRJ
where b.LOK_KANREG = '11' $status $jenis ";
	$query  = $this->db3->query($sql);
	return $query;
	
	}
	
	function _get_instansi_name($id)
	{
	
	    $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
		$query  = $this->db3->query($sql);
	    $row	= $query->row();
		return $row->INS_NAMINS;
	}
	
	public function simpanmultiple()
	{     
		
		$kode_instansi     = $this->input->post('kode_instansi');
		$tmt    		   = $this->input->post('tmt');
		$nolg    		   = $this->input->post('nolg');
		$tgllg    		   = $this->input->post('tgllg');
		$gollama   		   = $this->input->post('gollama');
		$golbaru   		   = $this->input->post('golbaru');
		$nip    		   = $this->input->post('nip');
		$tgl    		   = $this->input->post('tgl');
		$keterangan		   = $this->input->post('keterangan');
		$lokasi_kerja      = $this->input->post('lokasi_kerja');
		$jenis_kp          = $this->input->post('jenis_kp');
		
		
		//var_dump($this->input->post()); exit;
		
		// hidden form buat paging
		$data['instansi']      = $this->input->post('instansi'); 
	    $data['tmt_bln']       = $this->input->post('tmt_bln');
		$data['tmt_thn']       = $this->input->post('tmt_thn');
		$data['status']        = $this->input->post('status');
		$data['jenis_kp']      = $this->input->post('jeniskp');
		
		
		
		if($nip)
		{
			foreach ($nip as $key => $value)
			{
				$insert  = array('kode_instansi'		=> $kode_instansi[$key],
								 'nip'					=> $nip[$key],
								 'tgl_input'			=> date('Y-m-d',strtotime($tgl)),
								 'tmt'					=> date('Y-m-d',strtotime($tmt[$key])),
								 'aksi'					=> 'GABUNG',
								 'keterangan'			=> $keterangan,
								 'no_lg'				=> $nolg[$key],
								 'tgl_lg'				=> date('Y-m-d',strtotime($tgllg[$key])),
								 'gol_lama_id'			=> $gollama[$key],
								 'gol_baru_id'			=> $golbaru[$key],
								 'status_npkp'			=> 1,
								 'id_pelaksana'			=> $this->session->userdata('user_id'),
								 'lokasi_kerja'			=> $lokasi_kerja[$key],
								 'jenis_kp'				=> $jenis_kp[$key],
				
				
				);
				
				$dt['nip']     			= $nip[$key];
				$dt['tmt']     			= date('Y-m-d',strtotime($tmt[$key]));
				$dt['no_lg']   			= $nolg[$key];
				$dt['kode_instansi']    = $kode_instansi[$key];
				
				if($this->_tada_npkp($dt))
				{
					$this->db1->insert('npkp',$insert);
				}
			}
			
			$data['message']               = 'Save successfuly...';
		}
		else
		{
		    $data['message']               = 'Nothing to save try again...';
		
		}
		$data['page']                  = " LIMIT  0 , 25";
		$data ['create_time']          = $this->_get_time_create();
	    $data['record']			   	   = $this->_getRecord($data);
		$data['instansi']			   = $this->_get_instansi();
	    $data['jenis_kp']			   = $this->_get_jenis_kp();
		$data['lihat']		           = FALSE;	
		
		$atts = array(
              'width'      => '800',
              'height'     => '400',
              'scrollbars' => 'no',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'    => '200',
              'screeny'    => '0'
            );
		$data['atts']                  = $atts;
	    $data['show_jml']              = FALSE;	
		
		$this->load->view('vernpkp/vnota_persetujuan',$data);
		
	}
	
	function _get_jenis_kp()
	{
	    $sql="SELECT * FROM `jenis_kp` ORDER BY JKP_JPNKOD ASC";
		$query  = $this->db3->query($sql);
	    return  $query;
		
	}
	
	function _tada_npkp($data)
	
	{
	    $nip				= $data['nip'];
		$tmt				= $data['tmt'];
		$no_lg				= $data['no_lg'];
		$kode_instansi		= $data['kode_instansi'];
		
		
		$sql="SELECT id FROM npkp WHERE nip='$nip' AND tmt='$tmt' AND no_lg='$no_lg' AND kode_instansi='$kode_instansi' ";
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
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */