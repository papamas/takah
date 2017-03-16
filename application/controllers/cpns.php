<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpns extends MY_Controller {

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
		$data['message']		= '';
		$this->load->view('pencatatan/vcpns',$data);
	}
	
	function get_pns()
	{
	   $search   = $this->input->get('q');
	   
	   $sql="SELECT NIP as id,CONCAT( NIP ,' - ', JABATAN_NAMA)  as text FROM pupns_pengadaan_info WHERE NIP LIKE '$search%' ORDER BY NIP ASC";
	   $query= $this->db3->query($sql);
	   $ret['results'] = $query->result_array();
	   echo json_encode($ret);
	}
	
	public function get_cpns_data()
	{
	    $nip  =  $this->input->post('nip');
		
		$sql="SELECT DATE_FORMAT(TMT_CPNS,'%d-%m-%Y') TMT_CPNS,PERSETUJUAN_TEKNIS_NOMOR,
		DATE_FORMAT(PERSETUJUAN_TEKNIS_TANGGAL,'%d-%m-%Y') PERSETUJUAN_TEKNIS_TANGGAL
		FROM `pupns_pengadaan_info` WHERE `NIP`='$nip' ";
		
		$query  = $this->db3->query($sql);
		
		if($query->num_rows()  > 0)
		{
		    $row		= $query->row();
		
            $data[]		= array('TMT'				       => $row->TMT_CPNS,
								'NOSK' 					   => $row->PERSETUJUAN_TEKNIS_NOMOR,
								'TGL'					   => $row->PERSETUJUAN_TEKNIS_TANGGAL,								
			);			
		}
		else
		{
		    $data[]		= array('TMT'				       => '',
								'NOSK' 					   => '',
								'TGL'   				   => '',								
			);		
		}
		
		echo json_encode($data);
	
	}
	
	
	function _get_instansi()
	{
	     return $this->db3->query("SELECT  * FROM instansi order by INS_KODINS ASC");
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
	
	
	public function save()
	{
	    $instansi          = $this->input->post('instansi');
		$nip			   = $this->input->post('nip');
		$tmt			   = $this->input->post('tmt');
		$tgl_sk		       = $this->input->post('tgl_sk');
		$no_sk             = $this->input->post('no_sk');
		$keterangan        = $this->input->post('keterangan');
		
		$data = array('instansi'				=> $instansi,
					  'nip'						=> $nip,
					  'tmt'						=> date('Y-m-d',strtotime($tmt)),
					  'tgl_sk'					=> date('Y-m-d',strtotime($tgl_sk)),
					  'no_sk'					=> $no_sk,
					  'keterangan'				=> $keterangan,
					  'created_by'				=> $this->session->userdata('user_id'),
					  
		);
		
		$arr_session		= $data;
		
	    $this->session->set_userdata($arr_session);
		
		$this->db1->insert('cpns',$data);	
		
		$data['instansi']       = $this->_get_instansi();
		$data['message']		= 'Save Successfully..';
		$this->load->view('pencatatan/vcpns',$data);
	}  
	
	
	public function laporan()
	{
	    $data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('laporan/vcpns',$data);
	}
	
	function laporanCetak()
	{
	    $data['instansi']    	= $this->input->post('instansi');
		$data['pelaksana']    	= $this->input->post('pelaksana');
		$reportrange        	= $this->input->post('reportrange');
		$xreportrange			= explode("-",$reportrange);
	    $data['startdate']      = $xreportrange[0];
	    $data['enddate']	    = $xreportrange[1];
		
		$perintah			   	= $this->input->post('perintah');		
		
		//var_dump($perintah);exit;
		if ($perintah == '1')
		{
		    $this->cetakKarin($data);
        }
		elseif($perintah == '2')
		{
		    $this->cetakDaftar($data);
		}
		else
		{   
		     $this->cetakLaporan($data);
		}
	    
	}
	
	function cetakLaporan($data)
	{
	    $instansi    	= $data['instansi'];
		$pelaksana    	= $data['pelaksana'];
		$startdate		= $data['startdate'];
	    $enddate		= $data['enddate'];

		
		if($instansi != '')
		{
		   $sql_instansi  = " AND a.instansi='$instansi' ";
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
		
		
		/* $sql="SELECT a.*, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM cpns a  WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') order by a.nip asc"; */
		$sql="SELECT 
    a . *,
    b.PNS_PNSNAM,
	SUBSTRING_INDEX(b.PNS_PNSNAM, ' ', 1) LABEL,
    c.INS_NAMINS,
	d.INS_NAMINS  SAPK_INSTANSI
FROM
    (SELECT 
        a . *, DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input
    FROM
        cpns a
    WHERE
        1 = 1 $sql_pelaksana  $sql_instansi
            AND DATE(created_date) BETWEEN STR_TO_DATE('$startdate', '%d/%m/%Y ') AND STR_TO_DATE('$enddate', '%d/%m/%Y')) a
        LEFT JOIN
    mirror.pupns b ON a.nip = b.PNS_NIPBARU
        INNER JOIN
    mirror.instansi c ON a.instansi = c.INS_KODINS
	LEFT JOIN mirror.instansi d ON d.INS_KODINS = b.PNS_INSKER
order by a.id asc";
		
		//var_dump($sql); exit;
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PENGADAAN CPNS PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>INTANSI </th>
					<th>TMT</th>
					<th>NO.SK</th>
					<th>TGL SK</th>
					<th>PELAKSANA</th>
					<th>SAPK INSTANSI</th>
					<th>KETERANGAN</th>
					<th>LABEL</th>
					'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td >{$r->PNS_PNSNAM}</td>";
				$html .= "<td WIDTH=350>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->no_sk}</td>";
				$html .= "<td>{$r->tgl_sk}</td>";
				$html .= "<td>{$this->_get_nama_orang($r->created_by)}</td>";
				$html .= "<td>{$r->SAPK_INSTANSI}</td>";
                $html .= "<td>{$r->keterangan}</td>";	
				$html .= "<td>{$r->LABEL}</td>";	
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
	
	
	function _get_nama_instansi($id)
	{
	   $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
       $query  = $this->db3->query($sql);
	   $row    = $query->row();
	   
	   return $row->INS_NAMINS;  
	
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
		   $sql_search = "AND a.nip ='$search' ";
		}
		else
		{
		   $sql_search ="";
		}
		
		$user_id = $this->session->userdata('user_id');		
		
		$sql="SELECT a.*, DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input,
		DATE_FORMAT(a.tgl_sk, '%d-%m-%Y') tgl_suratkep, 
		DATE_FORMAT(a.tmt, '%d-%m-%Y') tgl_tmt,
		b.INS_NAMINS FROM cpns a
		INNER JOIN mirror.instansi b ON a.instansi = b.INS_KODINS 
		WHERE 1=1 $sql_search  AND a.created_by='$user_id' LIMIT 10";
		$query = $this->db1->query($sql);
		
		$data['record']    = $query; 
		$data['message']   ='';
		$data['instansi']  = $this->_get_instansi();
	    $this->load->view('search/vcpns',$data);
	}
	
	function get_cpns()
	{
	   $id = $this->input->post('cpns_id');
	   
	   $sql="SELECT *,DATE_FORMAT(created_date,'%d-%m-%Y') tgl_input,
	   DATE_FORMAT(tgl_sk,'%d-%m-%Y') tgl_suratkep,
	   DATE_FORMAT(tmt,'%d-%m-%Y') tgl_tmt
	   FROM takah.cpns where id='$id' ";
	   $query = $this->db1->query($sql);
		
	   echo json_encode($query->result_array());
	   
	
	}
	
	function update()
	{
	    $cpns_id  			    = $this->input->post('cpns_id');
		$tgl_input  			= $this->input->post('tgl_input');
		$nip  					= $this->input->post('nip');
		$instansi	  			= $this->input->post('instansi');
		$no_sk		  			= $this->input->post('no_sk');
		$tgl_sk		  			= $this->input->post('tgl_sk');
		$tgl_tmt		  		= $this->input->post('tgl_tmt');
		
		$data = array('created_date'     => date('Y-m-d', strtotime($tgl_input)),
					  'nip'              => $nip,
					  'instansi'         => $instansi,
					  'no_sk'            => strtoupper($no_sk),
					  'tgl_sk'           => date('Y-m-d', strtotime($tgl_sk)),
					  'tmt'              => date('Y-m-d', strtotime($tgl_tmt)),
		
		);
		
		$this->db1->where('id',$cpns_id);
	    $this->db1->update('cpns', $data);
		
	}
	
	function delete()
	{
	    $cpns_id  			    = $this->input->post('cpnsdel_id');
		$this->db1->where('id',$cpns_id);
	    $this->db1->delete('cpns');
	
	}
	
	function cetakKarin($data)
	{
	    $instansi    	= $data['instansi'];
		$pelaksana    	= $data['pelaksana'];
		$startdate		= $data['startdate'];
	    $enddate		= $data['enddate'];

		
		if($instansi != '')
		{
		   $sql_instansi  = " AND a.instansi='$instansi' ";
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
		
		
		$sql="SELECT a.*, b.INS_NAMINS instansi_induk, c.INS_NAMINS instansi_kerja FROM (SELECT a.*,
b.PNS_PNSNAM nama ,
if(b.PNS_PNSSEX=1 ,'PRIA','WANITA') kelamin,
DATE_FORMAT( b.PNS_TGLLHRDT,'%d-%m-%Y' ) tgl_lahir,
c.AGA_NAMAGA agama, b.PNS_INSKER, b.PNS_INSDUK
FROM (SELECT  a.id, a.nip,LEFT(a.instansi,2) kode_prov,RIGHT(a.instansi,2) kode_kota, a.no_sk,DATE_FORMAT(a.tgl_sk,'%d-%m-%Y') tgl_sk,
		DATE_FORMAT(a.tmt,'%d-%m-%Y') tgl_tmt, b.JABATAN_NAMA jabatan, b.UNIT_KERJA_NAMA unit,
		b.IJASAH_NAMA pendidikan , b.TAHUN_IJAZAH thn_ijazah, DATE_FORMAT( b.DITETAPKAN_TANGGAL ,'%d-%m-%Y' ) tgl_penetapan,
        e.GOL_GOLNAM golongan,  c.INS_NAMINS nama_instansi
        FROM  takah.cpns a
		INNER JOIN mirror.pupns_pengadaan_info b  ON a.nip = b.NIP
		INNER JOIN mirror.instansi c ON a.instansi = c.INS_KODINS
		INNER JOIN mirror.golru e ON b.GOLONGAN_AWAL_ID = e.GOl_KODGOL
        WHERE 1=1 AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana $sql_instansi
) a
INNER JOIN mirror.pupns b ON  a.nip = b.PNS_NIPBARU
LEFT JOIN mirror.agama c ON  b.PNS_KODAGA = c.AGA_KODAGA
) a
INNER JOIN mirror.instansi b ON a.PNS_INSDUK = b.INS_KODINS
INNER JOIN mirror.instansi c ON a.PNS_INSKER = c.INS_KODINS
order by a.id asc 
		";
		//var_dump($sql);exit;
		$query = $this->db1->query($sql);

		$this->load->library("PDF",array(
			'title'=>'',
			'instansi'=>  '',
			'kepala_seksi' => '',
			'nip' => '',
			'pengelola' => '',
			)
		);
		
		
		$this->pdf->SetHeaderMargin(0);
        $this->pdf->SetFooterMargin(0);		
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
				
				
		// add a page
		foreach ($query->result() as $value)
        {		
		    if($value->kode_prov == '70')
			{
			   $provinsi  = 'Sulawesi Utara';
			}
			elseif($value->kode_prov == '71')
			{
			    $provinsi = 'Gorontalo';
			}
			else
			{
			     $provinsi ='Maluku Utara';
			}
			
			$this->pdf->AddPage('P','USLEGAL');			
			$this->pdf->SetMargins(0,0, 0, true);
			
		   /*  // get the current page break margin
			$bMargin = $this->pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $this->pdf->getAutoPageBreak();
			// disable auto-page-break
			$this->pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = base_url().'assets/template/karin.jpg';
			$this->pdf->Image($img_file, 0, 0, 215, 330, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$this->pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$this->pdf->setPageMark();  
			  */
			$this->pdf->SetFont('helvetica', 'B', 12);
			
			$this->pdf->SetXY(19,53);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(24,53);
			$txt2 = substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(30,53);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(36,53);
			$txt4 = substr($value->nip,3,1);;
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(42,53);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(47,53);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(53,53);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,53);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(69,53);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(75,53);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,53);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(86,53);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(92,53);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(97,53);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,53);
			$txt15 = substr($value->nip,14,1);
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(120,53);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(125,53);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(131,53);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(111,68);
			$nm = $value->nama;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,74);
			$st = 'CPNS';
			$this->pdf->Write(0, $st, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,80);
			$jp = 'PNS DAERAH';
			$this->pdf->Write(0, $jp, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,86);
			$gol = $value->golongan;
			$this->pdf->Write(0, $gol, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(145,86);
			$tmt = $value->tgl_tmt;
			$this->pdf->Write(0, $tmt, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,97);
			$tgl_sk = $value->tgl_penetapan;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,108);
			$no_sk = $value->no_sk.' / '.$value->tgl_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,120);
			$pejabat = 'KEPALA BADAN KEPEGAWAIAN NEGARA';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,126);
			$jabatan = $value->jabatan;
			$this->pdf->Write(0, $jabatan, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,132);
			$lahir = ' '. $value->tgl_lahir;
			$this->pdf->Write(0, $lahir, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,136);
			$jk = $value->kelamin;
			$this->pdf->Write(0, $jk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,143);
			$agama = strtoupper($value->agama);
			$this->pdf->Write(0, $agama, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,149);
			$pendidikan = $value->pendidikan;
			$this->pdf->Write(0, $pendidikan, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(28,166);
			$no_sekolah = '1.';
			$this->pdf->Write(0, $no_sekolah, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(35,166);
			$sekolah = $value->pendidikan;
			$this->pdf->Write(0, $sekolah, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,166);
			$thn_sekolah = $value->thn_ijazah;
			$this->pdf->Write(0, $thn_sekolah, '', 0, 'L', true, 0, false, false, 0);
			
		    $this->pdf->SetXY(111,293);
			$dep = strtoupper($value->instansi_kerja);
			$this->pdf->Write(0, $dep, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,300);
			$dep = $value->unit;
			
			switch ($dep) {
				case 'BADAN PEMBERDAYAAN PEREMPUAN, KELUARGA BERENCANA DAN PERLINDUNGAN ANAK':
					$label = 'BPPKB dan PA';
					break;
				case 'BADAN PELAKSANA PENYULUHAN PERTANIAN, PERIKANAN DAN KEHUTANAN':
					$label='BP3K';
					break;
				case 'DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET DAERAH':
					$label ='DPPKAD';
					break;
				case 'BADAN PERENCANAAN PEMBANGUNAN, PENELITIAN PENGEMBANGAN DAN PENANAMAN MODAL':
					$label ='BAPPEDA';
					break;
				case 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI &USAHA MIKRO KECIL MENENGAH':
					$label ='DINPERINDAGKOP & UMKM';
					break;
				case 'UPTD DINAS PENDIDIKAN, PEMUDA DAN OLAHRAGA KEC.MANGANITU':
					$label ='UPTD DISDIKPORA KEC.MANGANITU';
					break;
				case 'UPTD DINAS PENDIDIKAN PEMUDA DAN OLAHRAGA KEC.MANGANITU SELATAN':
					$label ='UPTD DISDIKPORA KEC.MANGANITU SELATAN';
					break;	
				default:
					$label= $dep;
			} 
			
			$this->pdf->Write(0, $label, '', 0, 'L', true, 0, false, false, 0);			
			$this->pdf->SetXY(111,306);
			$prop = strtoupper($provinsi);
			$this->pdf->Write(0, $prop, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,313);
			$kota = ($value->kode_kota =='00' ? '' : strtoupper($value->nama_instansi));
			$this->pdf->Write(0, $kota, '', 0, 'L', true, 0, false, false, 0); 
			
			$this->pdf->SetXY(111,319);
			$induk = strtoupper($value->instansi_induk);
			$this->pdf->Write(0, $induk, '', 0, 'L', true, 0, false, false, 0);
        } 
		
		$this->pdf->Output('Karin.pdf', 'D');
		
	}
	
	function cetakDaftar($data)
	{
	    $instansi    	= $data['instansi'];
		$pelaksana    	= $data['pelaksana'];
		$startdate		= $data['startdate'];
	    $enddate		= $data['enddate'];
		
		if($instansi != '')
		{
		   $sql_instansi  = " AND a.instansi='$instansi' ";
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

		
		$sql="SELECT a.nip,a.no_sk, DATE_FORMAT(a.tgl_sk,'%d-%m-%Y') tgl_sk,
b.PNS_PNSNAM nama FROM takah.cpns a
INNER JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU 
WHERE 1=1 AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana $sql_instansi
order by a.id asc ";

        $query   = $this->db1->query($sql);
		
		$this->load->library("PDF",array(
			'title'=>'',
			'instansi'=>  '',
			'kepala_seksi' => '',
			'nip' => '',
			'pengelola' => '',
			)
		);
		
		$this->pdf->SetHeaderMargin(0);
        $this->pdf->SetFooterMargin(0);		
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
		
		// add a page
		foreach($query->result() as $value)
        {		
		
			$this->pdf->AddPage('P','USLEGAL');
			$this->pdf->SetMargins(0,0, 0, true);

			/* // get the current page break margin
			$bMargin = $this->pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $this->pdf->getAutoPageBreak();
			// disable auto-page-break
			$this->pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			$img_file = base_url().'assets/template/daftar.jpg';
			$this->pdf->Image($img_file, 0, 0, 215, 330, 'JPG', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$this->pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$this->pdf->setPageMark();  */
			
			$this->pdf->SetFont('helvetica', 'B', 12);
			
			$this->pdf->SetXY(37,56);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(44,56);
			$txt2 =substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(51,56);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(59,56);
			$txt4 = substr($value->nip,3,1);
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(66,56);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(73,56);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,56);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(88,56);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(102,56);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,56);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(117,56);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(123,56);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0); 
			
			$this->pdf->SetXY(130,56);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(137,56);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(153,56);
			$txt15 = substr($value->nip,14,1);;
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(167,56);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(174,56);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(181,56);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(37,70);
			$nm = $value->nama;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(10,116);
			$no = '1. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,116);
			$isi = 'Kartu Induk ';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,123);
			$no = '2. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,123);
			$pejabat = 'Kepala. BKN';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,123);
			$no_sk = $value->no_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,123);
			$tgl_sk = $value->tgl_sk;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,123);
			$isi = 'Penetapan NIP CPNS DAERAH';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
				
		
        } 
		
		$this->pdf->Output('daftar.pdf', 'D');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
