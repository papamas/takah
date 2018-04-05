<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pinjam extends MY_Controller {

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
	}
	
	public function index()
	{
		$data['instansi']			   = $this->_get_instansi();
		$data['message']               = '';
		$this->load->view('pencatatan/vpinjam',$data);
	}
		
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
		
	}	
	
	public function cetakFormulir($id)
	{
	   
		$row             = $this->_get_formulir($id);
		$nama_instansi   = $this->_get_nama_instansi($row->kode_instansi);
		$seksi           = $this->_get_seksi();
		$nama_pns        = $this->_get_nama_pns($row->nip_pns);
		$nama_peminjam   = $this->_get_nama_pns($row->nip_peminjam);
		$nama_mengetahui = $this->_get_nama_pns($row->nip_mengetahui);
		

		$html   = '<p align="right">ANAK LAMPIRAN 1 PERATURAN KEPALA BADAN <br/>KEPEGAWAIAN NEGARA <br/> NOMOR : 18 TAHUN 2011 <br/> TANGGAL : 18 JULI 2011<br/></p>';
		$html .=' <p align="center"><u>'. strtoupper($nama_instansi) .'</u></p>'; 
		$html .=' <p align="center">TANDA PINJAM TATA NASKAH</p><br/>'; 
		$html .=' <table border="0"><tr><td>Tanda Pinjam dari</td><td width="5">:</td><td width="450"> '. $seksi .'</td></tr>'; 
		$html .=' <tr><td>Tata Naskah PNS Atas Nama</td><td>:</td><td> '. $nama_pns .' </td></tr>';
		$html .=' <tr><td>NIP</td><td>:</td><td> '. $row->nip_pns . '</td></tr>';
		$html .=' <tr><td>Untuk keperluan</td><td>:</td><td> '. $row->keperluan . '</td></tr>';
		$html .= '<tr><td>Isi Tata Naskah yang dipinjam</td><td>:</td></tr>';
		$html 	.= '<tr><td></td></tr>';	
		$html .= '</table>';	
		$html .= '<table border="0">';					
		$html .='<tr>
					<td width="600">1.Kartu Pendaftaran Pegawai Negeri Sipil..........................................................................................................</td>
					<td border="1" width="50" align="center">'.($row->field1 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td>2.Nota Pengangkatan Pegawai Baru/CPNS.......................................................................................................</td> 
					<td border="1" align="center">'.($row->field2 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td>3.SK Pengangkatan Pegawai Baru/CPNS..........................................................................................................</td>
					<td border="1" align="center">'.($row->field3 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';	
		$html .='<tr>
					<td>4.SK Pengangkatan menjadi PNS......................................................................................................................</td>
					<td border="1" align="center">'.($row->field4 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';	
		$html .='<tr>
					<td>5.Nota Persetujuan/Pertimbangan Kenaikan Pangkat........................................................................................</td>
					<td border="1" align="center">'.($row->field5 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';	
		$html .='<tr>
					<td class=nama>6.SK Kenaikan Pangkat......................................................................................................................................</td>
					<td border="1" align="center">'.($row->field6 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';	
		$html .='<tr>
					<td class=nama>7.SK Pengangkatan dalam atau pemberhentian dari jabatan ...........................................................................</td>
					<td border="1" align="center">'.($row->field7 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td>8.SK Perpindahan Wilayah Kerja.......................................................................................................................</td>
					<td border="1" align="center">'.($row->field8 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>9.SK Perpindahan Antar Instansi.......................................................................................................................</td>
					<td border="1" align="center">'.($row->field9 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>10.SK Peninjauan Masa Kerja............................................................................................................................</td>
					<td border="1" align="center">'.($row->field10 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>11.SK Cuti diluar Tanggungan Negara...............................................................................................................</td>
					<td border="1" align="center">'.($row->field11 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>12.SK Hukuman Disiplin Pegawai Negeri Sipil...................................................................................................</td>
					<td border="1" align="center">'.($row->field12 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>13.SK Pemberian Tanda Jasa............................................................................................................................</td>
					<td border="1" align="center">'.($row->field13 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>14.SK Peninjauan Masa Kerja............................................................................................................................</td>
					<td border="1" align="center">'.($row->field14 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>15.SK Perbantuan kepada Pemerintah Daerah/Instansi Lain............................................................................</td>
					<td border="1" align="center">'.($row->field15 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>16.SK Pemberian Uang Tunggu.........................................................................................................................</td>
					<td border="1" align="center">'.($row->field16 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>17.SK Pemberhentian Sebagai PNS..................................................................................................................</td>
					<td border="1" align="center">'.($row->field17 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>18.SK Pemberhentian Sementara.................................................................,....................................................</td>
					<td border="1" align="center">'.($row->field18 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		
		$html .='<tr>
					<td class=nama>19.SK Pengangkatan/Pemberhentian Sebagai Pejabat Negara........................................................................</td>
					<td border="1" align="center">'.($row->field19 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>20.SK Pembebasan dari Jabatan Organik karena diangkat sebagai Pejabat Negara.......................................</td>
					<td border="1" align="center">'.($row->field20 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>21.SK Pernyataan Hilang...................................................................................................................................</td>
					<td border="1" align="center">'.($row->field21 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>22.SK kembalinya PNS yang dinyatakan hilang................................................................................................</td>
					<td border="1" align="center">'.($row->field22 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>23.SK Perubahan data dasar.............................................................................................................................</td>
					<td border="1" align="center">'.($row->field23 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>24.Berita Acara Pengambilan Sumpah/Janji PNS.............................................................................................</td>
					<td border="1" align="center">'.($row->field24 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>25.SK Pemberhentian Sebagai PNS karena menjadi Anggota/Pengurus Parpol..............................................</td>
					<td border="1" align="center">'.($row->field25 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>26.SK Meninggal Dunia......................................................................................................................................</td>
					<td border="1" align="center">'.($row->field26 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>27.SK Mutasi Keluarga.......................................................................................................................................</td>
					<td border="1" align="center">'.($row->field27 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>28.SK Peningkatan Pendidikan..........................................................................................................................</td>
					<td border="1" align="center">'.($row->field28 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>29.SK Pendidikan dan Latihan Struktural/Fungsional........................................................................................</td>
					<td border="1" align="center">'.($row->field29 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>30.SK Pensiun....................................................................................................................................................</td>
					<td border="1" align="center">'.($row->field30 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>31.Pertimbangan Kenaikan Pangkat/Formulir I.E...............................................................................................</td>
					<td border="1" align="center">'.($row->field31 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>32.Pertimbangan Pengangkatan Pegawai Baru/Formulir I.F..............................................................................</td>
					<td border="1" align="center">'.($row->field32? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>33.Nota Persetujuan Peninjauan Masa Kerja/Formulir D.3................................................................................</td>
					<td border="1" align="center">'.($row->field33 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>34.Nota Persetujuan Mutasi Lain-lain/Formulir D.4............................................................................................</td>
					<td border="1" align="center">'.($row->field34 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>35.Nota Persetujuan Peneliti/Formulir D.12........................................................................................................</td>
					<td border="1" align="center">'.($row->field35 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>36.SK Pengalihan PNS.......................................................................................................................................</td>
					<td border="1" align="center">'.($row->field36 ? '&#10004;' : ' ').'</td>'; 
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>37.Surat Tanda Tamat Pendidikan dan Latihan Prajabatan...............................................................................</td>
					<td border="1" align="center">'.($row->field37 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>38.Daftar Penilaian Pelaksanaan PNS...............................................................................................................</td>
					<td border="1" align="center">'.($row->field38 ? '&#10004;' : ' ').'</td>';
		$html 	.= '</tr>';
		$html .='<tr>
					<td class=nama>39.Data Lainnya..................................................................................................................................................</td>
					<td border="1" align="center">'.($row->field39 ? '&#10004;' : ' ').'</td>';; 
		$html 	.= '</tr>';
		$html 	.= '<tr><td></td></tr>';		
		$html   .=' </table>';
		
		$html   .='<table border="0">';
		$html   .='<tr><td width="325" align="center">Peminjam, <br/><br/><br/><br/><u>'.$nama_peminjam.'</u><br/> NIP. '.$row->nip_peminjam.'</td><td width="325" align="center"> Mengetahui, <br/><br/><br/><br/><u>'.$nama_mengetahui.'</u><br/> NIP. '.$row->nip_mengetahui.'</td></tr>';
		$html 	.= '<tr><td></td></tr>';	
		$html   .='<tr><td width="325" align="center">Yang Menerima, <br/><br/><br/><br/><u>.......................................................</u><br/> NIP. ...............................................</td><td width="325" align="center">Yang Menyerahkan, <br/><br/><br/><br/><u>.......................................................</u><br/> NIP. ...............................................</td></tr>';
		$html   .='</table>';
		$html .='NB : <br/>';
		$html .='1. Peminjaman Maksimal 10 hari kerja<br/>';
		$html .='2. Selama Peminjaman tanda bukti disimpan oleh pengelola TAKAH<br/>';
		$html .='3. Setiap Peminjaman dan Pengembalian harus dicek dokumennya<br/><br/>';
		
		//echo $html;
		$this->load->library("PDF",array(
			'title'=>'',
			'instansi'=>  '',
			'kepala_seksi' => '',
			'nip' => '',
			'pengelola' => '',
			)
		);
		
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(true);
		
		// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => true,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => true,
			'font' => 'helvetica',
			'fontsize' => 8,
			'stretchtext' => 4,
			'position' => 'L'
		);
		
	    
		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);	
		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// set font
		$this->pdf->SetFont('freeserif', '', 8.5, '', true);
		// add a page
		$this->pdf->AddPage('P', 'F4');	
		$this->pdf->writeHTML($html,  true, false, true, false, '');
		$this->pdf->write1DBarcode($row->nip_pns, 'C39', '', '', '', 12, 0.3, $style, 'N');
		$this->pdf->Output('FormulirPinjam.pdf', 'D');
		
	
	}	
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT PNS_NIPBARU as id,CONCAT( PNS_NIPBARU ,' - ', PNS_PNSNAM,',' ,if(PNS_GLRBLK is null ,'',PNS_GLRBLK))  as text FROM PUPNS WHERE PNS_NIPBARU LIKE '$search%' ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
	
	
	function save()
	{
	    $kode_instansi           = $this->input->post('instansi');
		$dari		             = $this->_get_id_seksi();
		$nip_pns	   	         = $this->input->post('nip');
		$keperluan     	         = $this->input->post('keperluan');
		$nip_peminjam  	         = $this->input->post('peminjam');
		$nip_mengetahui          = $this->_get_mengetahui();
		$telp					 = $this->input->post('handphone');
		
		$data = array('kode_instansi'   			=> $kode_instansi,
		              'dari'            			=> $dari,
					  'nip_pns'						=> $nip_pns,
					  'keperluan'					=> $keperluan,
					  'nip_peminjam'				=> $nip_peminjam,
					  'nip_mengetahui'				=> $nip_mengetahui,
					  'telp'						=> $telp,
					  'field1'						=> $this->input->post('field1'),
					  'field2'						=> $this->input->post('field2'),
					  'field3'						=> $this->input->post('field3'),
					  'field4'						=> $this->input->post('field4'),
					  'field5'						=> $this->input->post('field5'),
					  'field6'						=> $this->input->post('field6'),
					  'field7'						=> $this->input->post('field7'),
					  'field8'						=> $this->input->post('field8'),
					  'field9'						=> $this->input->post('field9'),
					  'field10'						=> $this->input->post('field10'),
					  'field11'						=> $this->input->post('field11'),
					  'field12'						=> $this->input->post('field12'),
					  'field13'						=> $this->input->post('field13'),
					  'field14'						=> $this->input->post('field14'),
					  'field15'						=> $this->input->post('field15'),
					  'field16'						=> $this->input->post('field16'),
					  'field17'						=> $this->input->post('field17'),
					  'field18'						=> $this->input->post('field18'),
					  'field19'						=> $this->input->post('field19'),
					  'field20'						=> $this->input->post('field20'),
					  'field21'						=> $this->input->post('field21'),
					  'field22'						=> $this->input->post('field22'),
					  'field23'						=> $this->input->post('field23'),
					  'field24'						=> $this->input->post('field24'),
					  'field25'						=> $this->input->post('field25'),
					  'field26'						=> $this->input->post('field26'),
					  'field27'						=> $this->input->post('field27'),
					  'field28'						=> $this->input->post('field28'),
					  'field29'						=> $this->input->post('field29'),
					  'field30'						=> $this->input->post('field30'),
					  'field31'						=> $this->input->post('field31'),
					  'field32'						=> $this->input->post('field32'),
					  'field33'						=> $this->input->post('field33'),
					  'field34'						=> $this->input->post('field34'),
					  'field35'						=> $this->input->post('field35'),
					  'field36'						=> $this->input->post('field36'),
					  'field37'						=> $this->input->post('field37'),
					  'field38'						=> $this->input->post('field38'),
					  'field39'						=> $this->input->post('field39'),
					  'created_by'				    => $this->session->userdata('user_id'),
		);
		
		$this->db1->insert('formulir_pinjam',$data);
		
		$id = $this->db1->insert_id();
		
		$this->cetakFormulir($id);
		
	}
	
    function laporan()
	{
	    $data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
	    $this->load->view('laporan/vpinjam',$data);
	}
	
	function cetakLaporan()
	{
	    $instansi    	= $this->input->post('instansi');
		$pelaksana    	= $this->input->post('pelaksana');
		$reportrange 	= $this->input->post('reportrange');
		$xreportrange	= explode("-",$reportrange);
	    $startdate		= $xreportrange[0];
	    $enddate		= $xreportrange[1];

		
		if($instansi != '')
		{
		   $sql_instansi  = " AND a.kode_instansi='$instansi' ";
		}
		else
		{
		   $sql_instansi  = " ";
		
		}
		
		if($pelaksana != '')
		{
		    $sql_pelaksana   = " AND a.created_by='$pelaksana' ";
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		
		
		
		$sql="SELECT a.*,DATE( a.created_date ) tgl_pinjam, DATE( a.tgl_kembali ) tgl_balik FROM  takah.formulir_pinjam a 
		WHERE 1=1 AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana $sql_instansi
		ORDER BY a.created_date,a.id ASC";
		
		//var_dump($sql); exit;
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "PeminjamanTakah".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PEMINJAMAN TATA NASKAH PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL PINJAM</th>
					<th>INSTANSI</th>
					<th>TATA NASKAH</th>
					<th>KEPERLUAN</th>
					<th>PEMINJAM</th>
					<th>PELAKSANA</th>
					<th>YANG MENERIMA</th>
					<th>YANG MENYERAHKAN</th>
					<th>TGL KEMBALI</th>'; 
					
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td>{$r->tgl_pinjam}</td>";
				$html .= "<td>{$this->_get_nama_instansi($r->kode_instansi)}</td>";
				$html .= "<td class=str align=center>{$this->_get_nama_pns($r->nip_pns)}<br/>{$r->nip_pns}</td>";
				$html .= "<td>{$r->keperluan}</td>";
				$html .= "<td class=str align=center>{$this->_get_nama_pns($r->nip_peminjam)}<br/>{$r->nip_peminjam}</td>";	
				$html .= "<td>{$this->_get_nama_orang($r->created_by)}</td>";
				$html .= "<td class=str align=center>{$this->_get_nama_pns($r->nip_yang_menerima)}<br/>{$r->nip_yang_menerima}</td>";
				$html .= "<td class=str align=center>{$this->_get_nama_pns($r->nip_yang_menyerahkan)}<br/>{$r->nip_yang_menyerahkan}</td>";
				$html .= "<td>{$r->tgl_balik}</td>";
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=6 >There is no data found</td></tr></table>";
			echo $html;
		} 	  
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
	    
		$sql="SELECT id,nama FROM app_user where 1=1 $sql_limit_user  ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	function _get_nama_pns($nip)
	{
	   $sql="SELECT CONCAT(PNS_PNSNAM,' , ', if(PNS_GLRBLK is null ,'',PNS_GLRBLK))  as nama FROM mirror.pupns WHERE PNS_NIPBARU='$nip'";
	   $query =  $this->db3->query($sql);
	   
	    if( $query->num_rows() > 0)
	    {
	       $row = $query->row();
		   $r   = $row->nama;
	    }
		else
		{
		   $r  = '';
		}
	   
	   return $r;
	}
	
	function _get_seksi()
	{
	    $user_id = $this->session->userdata('user_id');
		
		$sql="SELECT id_seksi FROM app_user WHERE id='$user_id' ";
		$query     =  $this->db1->query($sql)->row();
	    $id_seksi  =  $query->id_seksi;
		
		if($id_seksi ==  '1')
		{
		   $r  = 'Pengelola Arsip Kepegawaian Instansi Vertikal dan Provinsi';
		}
		else
		{
		   $r  = 'Pengelola Arsip Kepegawaian Instansi Kabupaten/Kota'; 
		} 
		
		return $r;
	}
	
	function _get_id_seksi()
	{
	    $user_id = $this->session->userdata('user_id');
		
		$sql="SELECT id_seksi FROM app_user WHERE id='$user_id' ";
		$query     =  $this->db1->query($sql)->row();
	    $id_seksi  =  $query->id_seksi;	
		
		return $id_seksi;
	}
	
	function _get_nama_instansi($id)
	{
	    $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
		$query     =  $this->db3->query($sql)->row();
	    return   $query->INS_NAMINS;
	
	}
	
	function _get_formulir($id)
	{
	   $sql="SELECT * FROM formulir_pinjam WHERE id='$id'  ";
	   $query     =  $this->db1->query($sql)->row();
	   return     $query;
	
	}
	
	function _get_mengetahui()
	{
	    $user_id = $this->session->userdata('user_id');
		
		$sql="SELECT id_seksi FROM app_user WHERE id='$user_id' ";
		$query     =  $this->db1->query($sql)->row();
	    $id_seksi  =  $query->id_seksi;
		
		if($id_seksi ==  '1')
		{
		   $r  = '196810011995111001';
		}
		else
		{
		   $r  = '198005112008022001'; 
		} 
		
		return $r;
	}
	
	function _get_nama_orang($id)
	{
	
	   $sql="SELECT nama FROM app_user WHERE id='$id' ";
	   $query  = $this->db1->query($sql);
	   $row    = $query->row();
	   
	   return $row->nama;  
	
	}
	
	function search()
	{
	    $search =$this->input->post('search');
		
		if($search)
		{
		   $sql_search = "AND a.nip_pns ='$search' ";
		}
		else
		{
		   $sql_search ="";
		}
		
		$user_id = $this->session->userdata('user_id');
		
		
		/*
		$sql="SELECT a.*, DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input,
		b.INS_NAMINS, c.PNS_PNSNAM , 
		d.PNS_PNSNAM NamaPeminjam ,
		e.nama FROM takah.formulir_pinjam a 
		INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS 
		INNER JOIN mirror.pupns c ON a.nip_pns = c.PNS_NIPBARU
		INNEr JOIN mirror.pupns d ON a.nip_peminjam = d.PNS_NIPBARU
		INNER JOIN takah.app_user e ON a.created_by = e.id
		WHERE 1=1 $sql_search  LIMIT 5";
		*/
		$sql="SELECT a.*,b.INS_NAMINS, c.PNS_PNSNAM , 
		d.PNS_PNSNAM NamaPeminjam ,
		e.nama,DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input 
		FROM (SELECT * FROM takah.formulir_pinjam ORDER BY id DESC LIMIT 5 ) a
		INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS 
		INNER JOIN mirror.pupns c ON a.nip_pns = c.PNS_NIPBARU
		INNER JOIN mirror.pupns d ON a.nip_peminjam = d.PNS_NIPBARU
		INNER JOIN takah.app_user e ON a.created_by = e.id
		WHERE 1=1 $sql_search
		";
		
		$query = $this->db1->query($sql);
		
		$data['record']    = $query; 
		$data['message']   ='';
		$data['instansi']  = $this->_get_instansi();
	    $this->load->view('search/vpinjam',$data);
	}
	
	function update()
	{
	
	   $pinjam_id  			    = $this->input->post('update_id');
	   $nip_yang_menerima   	= $this->input->post('nip_yang_menerima');
	   $nip_yang_menyerahkan    = $this->input->post('nip_yang_menyerahkan');
	   
	   $data  = array('nip_yang_menerima'				=> $nip_yang_menerima,
					  'nip_yang_menyerahkan'			=> $nip_yang_menyerahkan
	   
	   );
	   
	   $this->db1->where('id',$pinjam_id);
	   $this->db1->set('tgl_kembali','NOW()', FALSE);
	   $this->db1->update('formulir_pinjam', $data);
	   
	}
	
	function delete()
	{  
	    $pinjam_id  			    = $this->input->post('pinjamdel_id');
		$this->db1->where('id',$pinjam_id);
	    $this->db1->delete('formulir_pinjam');
	}
	
	function get_pns2()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT PNS_NIPBARU as id,CONCAT( PNS_NIPBARU ,' - ', PNS_PNSNAM)  as text FROM PUPNS WHERE PNS_NIPBARU LIKE '$search%' ORDER BY PNS_PNSNAM ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */