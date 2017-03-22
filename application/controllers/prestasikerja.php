<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestasikerja extends MY_Controller {

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
		$data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('laporan/prestasikerja_view',$data);
	}
	
	public function cetak()
	{
	    $data['aksi']			= $this->input->post('aksi');
		$data['vertikal']		= $this->input->post('vertikal');
		$perintah        		= $this->input->post('perintah');
        $data['pelaksana']      = $this->input->post('pelaksana'); 		
		$data['instansi']		= $this->input->post('instansi');
		$reportrange        	= $this->input->post('reportrange');
		$xreportrange       	= explode("-",$reportrange);
		$data['startdate']		= $xreportrange[0];
		$data['enddate']		= $xreportrange[1];
		
		
		
		if($perintah == 1)
		{
			$this->_harian($data);
		}
		elseif($perintah == 2)
		{
		   $this->_rekap($data);
		   
		}
		elseif($perintah == 3)
		{
		    $this->_cetakKarin($data);
		}
		else
		{
		    $this->_cetakDaftar($data);
		}
	}
	
	public function _rekap($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$aksi         =  $data['aksi'];
		
		if($aksi != ' ')
		{
		    $data['sql_aksi'] =" AND a.aksi='$aksi' "; 
		}		
		else
		{
		   $data['sql_aksi']  =" "; 
		}
		
		if($pelaksana != '')
		{
		    $data['sql_pelaksana'] =" AND a.id_pelaksana='$pelaksana' "; 
		}		
		else
		{
		   $data['sql_pelaksana'] =" "; 
		}
		
		 
		 
		if($vertikal == '1')
		{
		    $this->_cetak_rekap_pusat($data); 
		}
		else
		{
		   
			$this->_cetak_rekap_daerah($data);
		  
		}	
		   
	}
	
	function _cetak_rekap_pusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		   
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		if($instansi  == '00' )
		{
		   $sql_instansi = ''; 
		}
		else
		{
		    $sql_instansi = " AND kode_provinsi='$instansi' ";
		}
		
		
	   $sql="SELECT a.*,count(a.nip) jumlah FROM (SELECT a.*,LEFT(a.lokasi_kerja,2) kode_provinsi, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 AND  b.INS_KODINS BETWEEN '1010' AND '4062'
$sql_aksi AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y' ) $sql_pelaksana ) a WHERE 1=1 $sql_instansi
GROUP BY a.aksi,a.tmt,a.kode_instansi ";
       
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPREKAPITULASIPUSAT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN NPKP REKAPITULASI PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>WILAYAH KERJA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td>{$this->_get_nama_instansi($kode_instansi)}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->jumlah}</td>";							
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
	
	function _cetak_rekap_daerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		
		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
WHERE 1=1 $sql_aksi  AND a.kode_instansi='$instansi' AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY a.aksi,a.tmt";
       
	     //var_dump($sql);
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPREKAPITULASIDAERAH".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN NPKP REKAPITULASI PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->jumlah}</td>";					
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
	
	
	public function _harian($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$aksi         =  $data['aksi'];
		
		if($aksi != ' ')
		{
		    $data['sql_aksi'] =" AND a.aksi='$aksi' "; 
		}		
		else
		{
		   $data['sql_aksi']  =" "; 
		}
		
		if($pelaksana != '')
		{
		    $data['sql_pelaksana'] =" AND a.id_pelaksana='$pelaksana' "; 
		}		
		else
		{
		   $data['sql_pelaksana'] =" "; 
		}
		
		if($vertikal == '1')
		{
		    $this->_cetak_harian_pusat($data); 
		}
		else
		{
		    $this->_cetak_harian_daerah($data);
		
		}	
		   
	}
	
	function _cetak_harian_pusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		
		if($instansi  == '00' )
		{
		   $sql_instansi = ''; 
		}
		else
		{
		    $sql_instansi = " AND a.kode_provinsi='$instansi' ";
		}
		
		
	  /*  $sql="SELECT * FROM (SELECT a.*,LEFT(a.lokasi_kerja,2) kode_provinsi, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU, e.JKP_JPNNAMA, f.LOK_LOKNAM, f.LOK_KANREG FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
INNER JOIN mirror.jenis_kp e ON e.JKP_JPNKOD = a.jenis_kp
INNER JOIN mirror.lokker f ON f.LOK_LOKKOD = a.lokasi_kerja
WHERE 1=1 AND  b.INS_KODINS BETWEEN '1010' AND '4062'
$sql_aksi AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y' ) $sql_pelaksana ) a  WHERE 1=1 $sql_instansi ";
        */
	    //var_dump($sql);exit;
		$sql="select 
    a . *, b.INS_NAMINS SAPK_INS
FROM
    (select 
        a . *,
            b.PNS_PNSNAM,
            b.PNS_INSDUK,
			b.PNS_INSKER,
			c.KED_KEDNAM,
            SUBSTRING_INDEX(b.PNS_PNSNAM, ' ', 1) LABEL
    FROM
        (select 
        a . *,
            b.GOL_GOLNAM GOL_BARU,
            c.JKP_JPNNAMA,
            d.LOK_LOKNAM,
            d.LOK_KANREG
    from
        (SELECT 
        a . *,
            LEFT(a.lokasi_kerja, 2) kode_provinsi,
            b.INS_NAMINS,
            c.GOL_GOLNAM GOL_LAMA
    FROM
        takah.npkp a
    INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
    INNER JOIN mirror.golru c ON c.GOL_KODGOL = a.gol_lama_id
    WHERE
        1 = 1
            AND a.kode_instansi BETWEEN '1010' AND '4062' $sql_aksi 
            AND DATE(tgl_input) BETWEEN STR_TO_DATE('$startdate', '%d/%m/%Y ') AND STR_TO_DATE('$enddate', '%d/%m/%Y')
            $sql_pelaksana ) a
    INNER JOIN mirror.golru b ON b.GOL_KODGOL = a.gol_baru_id
    INNER JOIN mirror.jenis_kp c ON c.JKP_JPNKOD = a.jenis_kp
    INNER JOIN mirror.lokker d ON d.LOK_LOKKOD = a.lokasi_kerja) a
    LEFT JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU  
	LEFT JOIN mirror.kedhuk c ON c.KED_KEDKOD = b.PNS_KEDHUK
	WHERE 1=1  $sql_instansi ) a
        LEFT JOIN
    mirror.instansi b ON a.PNS_INSKER = b.INS_KODINS";
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPHARIANPUSAT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PRESTASI KINERJA PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>KEDUDUKAN HUKUM</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>WILAYAH KERJA</th>
					<th>INSTANSI</th>
					<th>NO.LG</th>
					<th>TGL.LG</th>
					<th>GOLONGAN</th>
					<th>JENIS KP</th>
					<th>PELAKSANA</th>
					<th>LOKASI</th>
					<th>KANREG</th>
					<th>KETERANGAN</th>
					<th>SAPK INSTANSI</th>
					<th>LABEL</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str width=150>{$r->nip}</td>";
				$html .= "<td>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->KED_KEDNAM}</td>";				
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td>{$this->_get_nama_instansi($kode_instansi)}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->no_lg}</td>";
				$html .= "<td>{$r->tgl_lg}</td>";
				$html .= "<td>{$r->GOL_LAMA}-{$r->GOL_BARU}</td>";
				$html .= "<td>{$r->JKP_JPNNAMA}</td>";
				$html .= "<td>{$this->_get_nama_user($r->id_pelaksana)}</td>";
				$html .= "<td>{$r->LOK_LOKNAM}</td>";
				$html .= "<td>{$r->LOK_KANREG}</td>";
				$html .= "<td width=400>{$r->keterangan}</td>";	
				$html .= "<td width=450>{$r->SAPK_INS}</td>";
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
	
	function _cetak_harian_daerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		
		
	   /* $sql="SELECT a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU, e.JKP_JPNNAMA FROM takah.npkp a
INNER JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
INNER JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
INNER JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
INNER JOIN mirror.jenis_kp e ON e.JKP_JPNKOD = a.jenis_kp
WHERE 1=1 $sql_aksi  AND a.kode_instansi='$instansi' AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana "; */
        $sql="SELECT a.*, b.PNS_PNSNAM,SUBSTRING_INDEX( b.PNS_PNSNAM,' ',1) LABEL,c.INS_NAMINS SAPK_INS, d.KED_KEDNAM from (SELECT 
    a . *,
    b.INS_NAMINS,
    c.GOL_GOLNAM GOL_LAMA,
    d.GOL_GOLNAM GOL_BARU,
    e.JKP_JPNNAMA
FROM
    takah.npkp a
        INNER JOIN
    mirror.instansi b ON b.INS_KODINS = a.kode_instansi
        INNER JOIN
    MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
        INNER JOIN
    MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
        INNER JOIN
    mirror.jenis_kp e ON e.JKP_JPNKOD = a.jenis_kp
WHERE
    1 = 1 $sql_aksi 
        AND a.kode_instansi = '$instansi'
        AND DATE(tgl_input) BETWEEN STR_TO_DATE('$startdate', '%d/%m/%Y ') AND STR_TO_DATE('$enddate', '%d/%m/%Y ')
        $sql_pelaksana
) a
LEFT JOIN mirror.pupns  b ON a.nip = b.PNS_NIPBARU
LEFT JOIN mirror.instansi c ON b.PNS_INSKER = c.INS_KODINS
LEFT JOIN mirror.kedhuk d ON d.KED_KEDKOD = b.PNS_KEDHUK";
       
	   //var_dump($sql);exit;  
		$q    = $this->db1->query($sql);
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "NPKPHARIANDAERAH".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN PRESTASI KINERJA PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>TGL</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>KEDUDUKAN HUKUM</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>INSTANSI</th>
					<th>NO.LG</th>
					<th>TGL.LG</th>
					<th>GOLONGAN</th>
					<th>JENIS KP</th>
					<th>PELAKSANA</th>
					<th>KETERANGAN</th>
					<th>SAPK INSTANSI</th>
					<th>LABEL</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->tgl_input}</td>";
				$html .= "<td class=str width=150>{$r->nip}</td>";
				$html .= "<td>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->KED_KEDNAM}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->no_lg}</td>";
				$html .= "<td>{$r->tgl_lg}</td>";
				$html .= "<td>{$r->GOL_LAMA}-{$r->GOL_BARU}</td>";
				$html .= "<td>{$r->JKP_JPNNAMA}</td>";
				$html .= "<td>{$this->_get_nama_user($r->id_pelaksana)}</td>";
				$html .= "<td width=500>{$r->keterangan}</td>";	
				$html .= "<td width=400>{$r->SAPK_INS}</td>";
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
	
	
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
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
	    
		$sql="SELECT id,nama FROM app_user WHERE 1=1 $sql_limit_user AND level!='kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	function _get_nama_instansi($id)
	{
	   $sql="SELECT INS_NAMINS FROM instansi WHERE INS_KODINS='$id' ";
       $query  = $this->db3->query($sql);
	   
	   if($query->num_rows() > 0)
	    {
	        $row    = $query->row();
			$r      = $row->INS_NAMINS;
	    }
		else
		{
		    $r      = '';
		}
	  
	   
	   return $r;
	   
	   
	
	}
	
	function _get_nama_user($id)
	{
	   $sql="SELECT nama FROM app_user WHERE id='$id' ";
       $query  = $this->db1->query($sql);
	   $row    = $query->row();
	   
	   return $row->nama;
	   
	
	}
	
	function _cetakKarin($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$aksi          = $data['aksi'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$kode_instansi = $instansi;
		
		if($aksi != ' ')
		{
		    $data['sql_aksi'] =" AND a.aksi='$aksi' "; 
		}		
		else
		{
		   $data['sql_aksi']  =" "; 
		}
		
		if($pelaksana != '')
		{
		    $data['sql_pelaksana'] =" AND a.id_pelaksana='$pelaksana' "; 
		}		
		else
		{
		   $data['sql_pelaksana'] =" "; 
		}
		
			if($vertikal == '1')
		{
		    $this->_cetakKarinPusat($data); 
		}
		else
		{
		   
			$this->_cetakKarinDaerah($data);
		  
		}
	}
	
	function _cetakKarinPusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;		
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		
		if($instansi  == '00' )
		{
		   $sql_instansi = ''; 
		}
		else
		{
		    $sql_instansi = " AND a.kode_provinsi='$instansi' ";
		}
		
				
		$sql="SELECT 
    a . *, b.DIK_NAMDIK pendidikan, c.JPG_JPGNAM jenis_peg
FROM
    (SELECT 
        a . *,
            b.PNS_PNSNAM nama_pns,
            if(b.PNS_PNSSEX = 1, 'PRIA', 'WANITA') kelamin,
            DATE_FORMAT(b.PNS_TGLLHRDT, '%d-%m-%Y') tgl_lahir,
            c.AGA_NAMAGA agama,
            d.GOL_GOLNAM golongan,
            b.PNS_TKTDIK,
            b.PNS_JENPEG,
			DATE_FORMAT(b.PNS_TMTCPN, '%d-%m-%Y') tmt_cpns,
            LEFT(b.PNS_TEMKRJ, 2) kode_provinsi
    FROM
        (SELECT a.id,
        a.nip, a.kode_instansi, b.INS_NAMINS instansi_kerja
    FROM
        takah.npkp a
    INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS
    WHERE 1=1 $sql_aksi  $sql_pelaksana
        AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) AND  a.kode_instansi BETWEEN '1010' AND '4062' ) a
    INNER JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
    LEFT JOIN mirror.agama c ON b.PNS_KODAGA = c.AGA_KODAGA
    INNER JOIN mirror.golru d ON d.GOl_KODGOL = b.PNS_GOLRU) a
        INNER JOIN
    mirror.tktpendik b ON a.PNS_TKTDIK = b.DIK_TKTDIK
        INNER JOIN
    mirror.jenpeg c ON a.PNS_JENPEG = c.JPG_JPGKOD
	WHERE 1=1  $sql_instansi  ORDER by a.id ASC";
	
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
		    if($value->kode_provinsi == '71')
			{
			   $provinsi  = 'Sulawesi Utara';
			}
			elseif($value->kode_provinsi == '75')
			{
			    $provinsi = 'Gorontalo';
			}
			else
			{
			    $provinsi ='Maluku Utara';
			}
			
			$this->pdf->AddPage('P','USLEGAL');			
			$this->pdf->SetMargins(0,0, 0, true);
			
		    /* // get the current page break margin
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
			$this->pdf->setPageMark();   */
			
			$this->pdf->SetFont('helvetica', 'B', 12);
			
			$this->pdf->SetXY(19,54);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(24,54);
			$txt2 = substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(30,54);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(36,54);
			$txt4 = substr($value->nip,3,1);;
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(42,54);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(47,54);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(53,54);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,54);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(69,54);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(75,54);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,54);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(86,54);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(92,54);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(97,54);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,54);
			$txt15 = substr($value->nip,14,1);
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(120,54);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(125,54);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(131,54);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(111,69);
			$nm = $value->nama_pns;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,75);
			$st = 'CPNS';
			$this->pdf->Write(0, $st, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,81);
			$jp = $value->jenis_peg;
			$this->pdf->Write(0, $jp, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,87);
			$gol = $value->golongan;
			$this->pdf->Write(0, $gol, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(145,87);
			$tmt = $value->tmt_cpns;
			$this->pdf->Write(0, $tmt, '', 0, 'L', true, 0, false, false, 0);
			/*
			$this->pdf->SetXY(111,97);
			$tgl_sk = $value->tgl_penetapan;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,108);
			$no_sk = $value->no_sk.' / '.$value->tgl_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,121);
			$pejabat = 'KEPALA BADAN KEPEGAWAIAN NEGARA';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,126);
			$jabatan = $value->jabatan;
			$this->pdf->Write(0, $jabatan, '', 0, 'L', true, 0, false, false, 0);
			*/
			
			$this->pdf->SetXY(111,133);
			$lahir = ' '. $value->tgl_lahir;
			$this->pdf->Write(0, $lahir, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,139);
			$jk = $value->kelamin;
			$this->pdf->Write(0, $jk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,144);
			$agama = strtoupper($value->agama);
			$this->pdf->Write(0, $agama, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,150);
			$pendidikan = $value->pendidikan;
			$this->pdf->Write(0, $pendidikan, '', 0, 'L', true, 0, false, false, 0);
			
			$sql1="SELECT a.PEN_TAHLUL tahun, b.DIK_NMDIK nama_sekolah FROM mirror.pupns_pendidikan a 
INNER JOIN mirror.pendik b ON a.PEN_PENKOD = b.DIK_KODIK
where a.PNS_NIPBARU='$value->nip'
ORDER BY PEN_TAHLUL ASC";
            
			
          
			$y = 167;$i  = 1;
			
			$query1= $this->db1->query($sql1);
			foreach($query1->result() as $val)
			{
               	$this->pdf->SetFont('helvetica', '', 8);
				
				$this->pdf->SetXY(28,$y);
				$no_sekolah = $i.'.';
				$this->pdf->Write(0, $no_sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$this->pdf->SetXY(35,$y);
				$sekolah = $val->nama_sekolah;
				$this->pdf->Write(0, $sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$this->pdf->SetXY(115,$y);
				$thn_sekolah = $val->tahun;
				$this->pdf->Write(0, $thn_sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$y += 4.5;
				$i++;
			}
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			if($value->kode_instansi == '4024')
			{
			    $dep = strtoupper('Kementerian Agraria dan Tata Ruang');
			}
			else
			{
			    $dep = strtoupper($value->instansi_kerja);
			}
		    $this->pdf->SetXY(111,295);			
			$this->pdf->Write(0, $dep, '', 0, 'L', true, 0, false, false, 0);
			
			/*
			$this->pdf->SetXY(111,302);
			$dep = $value->unit;
			$this->pdf->Write(0, $dep, '', 0, 'L', true, 0, false, false, 0);
			*/
			
			$this->pdf->SetXY(111,308);
			$prop = strtoupper($provinsi);
			$this->pdf->Write(0, $prop, '', 0, 'L', true, 0, false, false, 0);
			/*
			$this->pdf->SetXY(111,315);
			$kota = ($value->kode_kota =='00' ? '' : strtoupper($value->nama_instansi));
			$this->pdf->Write(0, $kota, '', 0, 'L', true, 0, false, false, 0); 
			*/
			$this->pdf->SetXY(111,321);
			$induk = strtoupper($dep);
			$this->pdf->Write(0, $induk, '', 0, 'L', true, 0, false, false, 0);
			
        } 
		
		$this->pdf->Output('Karin.pdf', 'D');
	
	
	}
	
	function _cetakKarinDaerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
								
		$sql="SELECT a.* FROM (SELECT 
    a . *, b.DIK_NAMDIK pendidikan, c.JPG_JPGNAM jenis_peg
FROM
    (SELECT 
        a . *,
            b.PNS_PNSNAM nama_pns,
            if(b.PNS_PNSSEX = 1, 'PRIA', 'WANITA') kelamin,
            DATE_FORMAT(b.PNS_TGLLHRDT, '%d-%m-%Y') tgl_lahir,
            c.AGA_NAMAGA agama,
            d.GOL_GOLNAM golongan,
            b.PNS_TKTDIK,
            b.PNS_JENPEG,
			DATE_FORMAT(b.PNS_TMTCPN, '%d-%m-%Y') tmt_cpns,
            LEFT(b.PNS_TEMKRJ, 2) kode_provinsi
    FROM
        (SELECT a.id,
        a.nip, a.kode_instansi, b.INS_NAMINS instansi_kerja
    FROM
        takah.npkp a
    INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS
    WHERE 1=1 $sql_aksi  $sql_pelaksana AND a.kode_instansi='$instansi'
        AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' )) a
    INNER JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
    LEFT JOIN mirror.agama c ON b.PNS_KODAGA = c.AGA_KODAGA
    INNER JOIN mirror.golru d ON d.GOl_KODGOL = b.PNS_GOLRU) a
        INNER JOIN
    mirror.tktpendik b ON a.PNS_TKTDIK = b.DIK_TKTDIK
        INNER JOIN
    mirror.jenpeg c ON a.PNS_JENPEG = c.JPG_JPGKOD ) a ORDER by a.id ASC
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
		    if($value->kode_provinsi == '71')
			{
			   $provinsi  = 'Sulawesi Utara';
			}
			elseif($value->kode_provinsi == '75')
			{
			    $provinsi = 'Gorontalo';
			}
			else
			{
			    $provinsi ='Maluku Utara';
			}
			
			$this->pdf->AddPage('P','USLEGAL');			
			$this->pdf->SetMargins(0,0, 0, true);
			
		    /* // get the current page break margin
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
			$this->pdf->setPageMark();   */
			
			$this->pdf->SetFont('helvetica', 'B', 12);
			
			$this->pdf->SetXY(19,54);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(24,54);
			$txt2 = substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(30,54);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(36,54);
			$txt4 = substr($value->nip,3,1);;
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(42,54);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(47,54);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(53,54);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,54);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(69,54);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(75,54);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,54);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(86,54);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(92,54);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(97,54);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,54);
			$txt15 = substr($value->nip,14,1);
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(120,54);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(125,54);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(131,54);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(111,69);
			$nm = $value->nama_pns;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,75);
			$st = 'CPNS';
			$this->pdf->Write(0, $st, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,81);
			$jp = $value->jenis_peg;
			$this->pdf->Write(0, $jp, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,87);
			$gol = $value->golongan;
			$this->pdf->Write(0, $gol, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(145,87);
			$tmt = $value->tmt_cpns;
			$this->pdf->Write(0, $tmt, '', 0, 'L', true, 0, false, false, 0);
			/*
			$this->pdf->SetXY(111,97);
			$tgl_sk = $value->tgl_penetapan;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,108);
			$no_sk = $value->no_sk.' / '.$value->tgl_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,121);
			$pejabat = 'KEPALA BADAN KEPEGAWAIAN NEGARA';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,126);
			$jabatan = $value->jabatan;
			$this->pdf->Write(0, $jabatan, '', 0, 'L', true, 0, false, false, 0);
			*/
			
			$this->pdf->SetXY(111,133);
			$lahir = ' '. $value->tgl_lahir;
			$this->pdf->Write(0, $lahir, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,139);
			$jk = $value->kelamin;
			$this->pdf->Write(0, $jk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,144);
			$agama = strtoupper($value->agama);
			$this->pdf->Write(0, $agama, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(111,150);
			$pendidikan = $value->pendidikan;
			$this->pdf->Write(0, $pendidikan, '', 0, 'L', true, 0, false, false, 0);
			
			$sql1="SELECT a.PEN_TAHLUL tahun, b.DIK_NMDIK nama_sekolah FROM mirror.pupns_pendidikan a 
INNER JOIN mirror.pendik b ON a.PEN_PENKOD = b.DIK_KODIK
where a.PNS_NIPBARU='$value->nip' ORDER BY PEN_TAHLUL ASC";         
			
          
			$y = 167;$i  = 1;
			
			$query1= $this->db1->query($sql1);
			foreach($query1->result() as $val)
			{
               	$this->pdf->SetFont('helvetica', '', 8);
				
				$this->pdf->SetXY(28,$y);
				$no_sekolah = $i.'.';
				$this->pdf->Write(0, $no_sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$this->pdf->SetXY(35,$y);
				$sekolah = $val->nama_sekolah;
				$this->pdf->Write(0, $sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$this->pdf->SetXY(115,$y);
				$thn_sekolah = $val->tahun;
				$this->pdf->Write(0, $thn_sekolah, '', 0, 'L', true, 0, false, false, 0);
				
				$y += 4.5;
				$i++;
			}
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			if($value->kode_instansi == '4024')
			{
			    $dep = strtoupper('Kementerian Agraria dan Tata Ruang');
			}
			else
			{
			    $dep = strtoupper($value->instansi_kerja);
			}
		    $this->pdf->SetXY(111,295);			
			$this->pdf->Write(0, $dep, '', 0, 'L', true, 0, false, false, 0);
			
			/*
			$this->pdf->SetXY(111,302);
			$dep = $value->unit;
			$this->pdf->Write(0, $dep, '', 0, 'L', true, 0, false, false, 0);
			*/
			
			$this->pdf->SetXY(111,308);
			$prop = strtoupper($provinsi);
			$this->pdf->Write(0, $prop, '', 0, 'L', true, 0, false, false, 0);
			/*
			$this->pdf->SetXY(111,315);
			$kota = ($value->kode_kota =='00' ? '' : strtoupper($value->nama_instansi));
			$this->pdf->Write(0, $kota, '', 0, 'L', true, 0, false, false, 0); 
			*/
			$this->pdf->SetXY(111,321);
			$induk = strtoupper($dep);
			$this->pdf->Write(0, $induk, '', 0, 'L', true, 0, false, false, 0);
			
        } 
		
		$this->pdf->Output('Karin.pdf', 'D');
	
	
	}
	
	function _cetakDaftar($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$aksi          = $data['aksi'];
		$pelaksana     = $data['pelaksana'];
		$vertikal      = $data['vertikal'];
		$kode_instansi = $instansi;
		
		if($aksi != ' ')
		{
		    $data['sql_aksi'] =" AND a.aksi='$aksi' "; 
		}		
		else
		{
		   $data['sql_aksi']  =" "; 
		}
		
		if($pelaksana != '')
		{
		    $data['sql_pelaksana'] =" AND a.id_pelaksana='$pelaksana' "; 
		}		
		else
		{
		   $data['sql_pelaksana'] =" "; 
		}
		
			if($vertikal == '1')
		{
		    $this->_cetakDaftarPusat($data); 
		}
		else
		{
		   
			$this->_cetakDaftarDaerah($data);
		  
		}
	}
	
	function _cetakDaftarPusat($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$kode_instansi = $instansi;		
		
		if($instansi  == '7100')
		{
		   $instansi ='75';
		}
		elseif($instansi == '7000') 
		{
		   $instansi ='71';
		}
		elseif ($instansi == '7900')
		{
		   $instansi ='83';
		}
		else
		{
		    $instansi ='00';
		}
		
		
		if($instansi  == '00' )
		{
		   $sql_instansi = ''; 
		}
		else
		{
		    $sql_instansi = " AND a.kode_prov='$instansi' ";
		}
		
		$sql="SELECT 
    a . *,
    b.PERSETUJUAN_TEKNIS_NOMOR no_sk,
    b.PERSETUJUAN_TEKNIS_TANGGAL tgl_sk,
    b.DITETAPKAN_TANGGAL tgl_penetapan
FROM
    (SELECT 
        a . *, b.DIK_NAMDIK pendidikan, c.JPG_JPGNAM jenis_peg
    FROM
        (SELECT 
        a . *,
            b.PNS_PNSNAM nama_pns,
            if(b.PNS_PNSSEX = 1, 'PRIA', 'WANITA') kelamin,
            DATE_FORMAT(b.PNS_TGLLHRDT, '%d-%m-%Y') tgl_lahir,
            c.AGA_NAMAGA agama,
            d.GOL_GOLNAM golongan,
            b.PNS_TKTDIK,
            b.PNS_JENPEG,
            DATE_FORMAT(b.PNS_TMTCPN, '%d-%m-%Y') tmt_cpns,
            DATE_FORMAT(b.PNS_TMTPNS, '%d-%m-%Y') tmt_pns,
            LEFT(b.PNS_TEMKRJ, 2) kode_prov
    FROM
        (SELECT a.id,
        a.nip, a.kode_instansi, b.INS_NAMINS instansi_kerja
    FROM
        takah.npkp a
    INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS
    WHERE 1=1 $sql_aksi $sql_pelaksana
    AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) AND  a.kode_instansi BETWEEN '1010' AND '4062' ) a
    INNER JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
    LEFT JOIN mirror.agama c ON b.PNS_KODAGA = c.AGA_KODAGA
    INNER JOIN mirror.golru d ON d.GOl_KODGOL = b.PNS_GOLRU) a
    INNER JOIN mirror.tktpendik b ON a.PNS_TKTDIK = b.DIK_TKTDIK
    INNER JOIN mirror.jenpeg c ON a.PNS_JENPEG = c.JPG_JPGKOD) a
        LEFT JOIN
    mirror.pupns_pengadaan_info b ON a.nip = b.NIP
	WHERE 1=1  $sql_instansi  ORDER by a.id ASC
";

        //var_dump($sql);exit;
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
			
			$this->pdf->SetXY(37,57);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(44,57);
			$txt2 =substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(51,57);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(59,57);
			$txt4 = substr($value->nip,3,1);
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(66,57);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(73,57);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,57);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(88,57);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(102,57);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,57);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(117,57);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(123,57);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0); 
			
			$this->pdf->SetXY(130,57);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(137,57);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(153,57);
			$txt15 = substr($value->nip,14,1);;
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(167,57);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(174,57);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(181,57);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(37,71);
			$nm = $value->nama_pns;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(10,117);
			$no = '1. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,117);
			$isi = 'Kartu Induk ';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,125);
			$no = '2. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,125);
			$pejabat = 'Kepala. BKN';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,125);
			$no_sk = $value->no_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,125);
			$tgl_sk = $value->tgl_sk;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,125);
			$isi = 'Penetapan NIP';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,131);
			$no = '3. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,131);
			$pejabat = ' ';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,131);
			$no_sk = ' ';
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,131);
			$tgl_sk = $value->tmt_cpns;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,131);
			$isi = 'SK CPNS';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,137);
			$no = '4. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,137);
			$pejabat = ' ';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,137);
			$no_sk = ' ';
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,137);
			$tgl_sk = $value->tmt_pns;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,137);
			$isi = 'SK PNS';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$sql1= "SELECT 
    DATE_FORMAT(a.PKI_TMT_GOLONGAN_BARU, '%d-%m-%Y') tmt,
    a.NOTA_PERSETUJUAN_KP no_sk,
    DATE_FORMAT(a.TGL_NOTA_PERSETUJUAN_KP, '%d-%m-%Y') tgl_sk,
    b.GOL_GOLNAM gol_lama,
    c.GOL_GOLNAM gol_baru
FROM
    mirror.pupns_kp_info a
        INNER JOIN
    mirror.golru b ON a.PKI_GOLONGAN_LAMA_ID = b.GOL_KODGOL
        INNER JOIN
    mirror.golru c ON a.PKI_GOLONGAN_BARU_ID = c.GOL_KODGOL
WHERE
    a.PKI_NIPBARU = '$value->nip' ORDER BY a.PKI_TMT_GOLONGAN_BARU ASC";
			
			$query1 = $this->db1->query($sql1);
			$i = 5;$y=145;
			
			if($query1->num_rows() > 0)
			{
			    foreach($query1->result() as $val)
				{
				    $this->pdf->SetXY(10,$y);
					$no = $i.'. ';
					$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(18,$y);
					$pejabat = 'KAKANREG XI BKN ';
					$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(58,$y);
					$no_sk = $val->no_sk;
					$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(94,$y);
					$tgl_sk = $val->tgl_sk;
					$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(115,$y);
					$isi = 'NPKP '.$val->gol_lama.' - '.$val->gol_baru.' , '.$val->tmt;
					$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);  
					
					$i++; $y +=7;
				
				}
			   
			}
				
		
        } 
		
		$this->pdf->Output('daftar.pdf', 'D');
		
	}
	
	
	function _cetakDaftarDaerah($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
			
		$sql="SELECT 
    a . *,
    b.PERSETUJUAN_TEKNIS_NOMOR no_sk,
    b.PERSETUJUAN_TEKNIS_TANGGAL tgl_sk,
    b.DITETAPKAN_TANGGAL tgl_penetapan
FROM
    (SELECT 
        a . *, b.DIK_NAMDIK pendidikan, c.JPG_JPGNAM jenis_peg
    FROM
        (SELECT 
        a . *,
            b.PNS_PNSNAM nama_pns,
            if(b.PNS_PNSSEX = 1, 'PRIA', 'WANITA') kelamin,
            DATE_FORMAT(b.PNS_TGLLHRDT, '%d-%m-%Y') tgl_lahir,
            c.AGA_NAMAGA agama,
            d.GOL_GOLNAM golongan,
            b.PNS_TKTDIK,
            b.PNS_JENPEG,
            DATE_FORMAT(b.PNS_TMTCPN, '%d-%m-%Y') tmt_cpns,
            DATE_FORMAT(b.PNS_TMTPNS, '%d-%m-%Y') tmt_pns,
            LEFT(b.PNS_TEMKRJ, 2) kode_prov
    FROM
        (SELECT a.id,
        a.nip, a.kode_instansi, b.INS_NAMINS instansi_kerja
    FROM
        takah.npkp a
    INNER JOIN mirror.instansi b ON a.kode_instansi = b.INS_KODINS
    WHERE 1=1 $sql_aksi $sql_pelaksana AND a.kode_instansi='$instansi'
    AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' )  ) a
    INNER JOIN mirror.pupns b ON a.nip = b.PNS_NIPBARU
    LEFT JOIN mirror.agama c ON b.PNS_KODAGA = c.AGA_KODAGA
    INNER JOIN mirror.golru d ON d.GOl_KODGOL = b.PNS_GOLRU) a
    INNER JOIN mirror.tktpendik b ON a.PNS_TKTDIK = b.DIK_TKTDIK
    INNER JOIN mirror.jenpeg c ON a.PNS_JENPEG = c.JPG_JPGKOD) a
        LEFT JOIN
    mirror.pupns_pengadaan_info b ON a.nip = b.NIP 
	ORDER by a.id ASC";
    
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
			
			$this->pdf->SetXY(37,57);
			$txt1 = substr($value->nip,0,1);
			$this->pdf->Write(0, $txt1, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(44,57);
			$txt2 =substr($value->nip,1,1);
			$this->pdf->Write(0, $txt2, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(51,57);
			$txt3 = substr($value->nip,2,1);
			$this->pdf->Write(0, $txt3, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(59,57);
			$txt4 = substr($value->nip,3,1);
			$this->pdf->Write(0, $txt4, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(66,57);
			$txt5 = substr($value->nip,4,1);
			$this->pdf->Write(0, $txt5, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(73,57);
			$txt6 = substr($value->nip,5,1);
			$this->pdf->Write(0, $txt6, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(80,57);
			$txt7 = substr($value->nip,6,1);
			$this->pdf->Write(0, $txt7, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(88,57);
			$txt8 = substr($value->nip,7,1);
			$this->pdf->Write(0, $txt8, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(102,57);
			$txt9 = substr($value->nip,8,1);
			$this->pdf->Write(0, $txt9, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(109,57);
			$txt10 = substr($value->nip,9,1);
			$this->pdf->Write(0, $txt10, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(117,57);
			$txt11 = substr($value->nip,10,1);
			$this->pdf->Write(0, $txt11, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(123,57);
			$txt12 = substr($value->nip,11,1);
			$this->pdf->Write(0, $txt12, '', 0, 'L', true, 0, false, false, 0); 
			
			$this->pdf->SetXY(130,57);
			$txt13 = substr($value->nip,12,1);
			$this->pdf->Write(0, $txt13, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(137,57);
			$txt14 = substr($value->nip,13,1);
			$this->pdf->Write(0, $txt14, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(153,57);
			$txt15 = substr($value->nip,14,1);;
			$this->pdf->Write(0, $txt15, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(167,57);
			$txt16 = substr($value->nip,15,1);
			$this->pdf->Write(0, $txt16, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(174,57);
			$txt17 = substr($value->nip,16,1);
			$this->pdf->Write(0, $txt17, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(181,57);
			$txt18 = substr($value->nip,17,1);
			$this->pdf->Write(0, $txt18, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(37,71);
			$nm = $value->nama_pns;
			$this->pdf->Write(0, $nm, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetFont('helvetica', '', 9);
			
			$this->pdf->SetXY(10,117);
			$no = '1. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,117);
			$isi = 'Kartu Induk ';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,125);
			$no = '2. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,125);
			$pejabat = 'Kepala. BKN';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,125);
			$no_sk = $value->no_sk;
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,125);
			$tgl_sk = $value->tgl_sk;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,125);
			$isi = 'Penetapan NIP';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,131);
			$no = '3. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,131);
			$pejabat = ' ';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,131);
			$no_sk = ' ';
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,131);
			$tgl_sk = $value->tmt_cpns;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,131);
			$isi = 'SK CPNS';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(10,137);
			$no = '4. ';
			$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(18,137);
			$pejabat = ' ';
			$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(58,137);
			$no_sk = ' ';
			$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(94,137);
			$tgl_sk = $value->tmt_pns;
			$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
			
			$this->pdf->SetXY(115,137);
			$isi = 'SK PNS';
			$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);
			
			$sql1= "SELECT 
    DATE_FORMAT(a.PKI_TMT_GOLONGAN_BARU, '%d-%m-%Y') tmt,
    a.NOTA_PERSETUJUAN_KP no_sk,
    DATE_FORMAT(a.TGL_NOTA_PERSETUJUAN_KP, '%d-%m-%Y') tgl_sk,
    b.GOL_GOLNAM gol_lama,
    c.GOL_GOLNAM gol_baru
FROM
    mirror.pupns_kp_info a
        INNER JOIN
    mirror.golru b ON a.PKI_GOLONGAN_LAMA_ID = b.GOL_KODGOL
        INNER JOIN
    mirror.golru c ON a.PKI_GOLONGAN_BARU_ID = c.GOL_KODGOL
WHERE
    a.PKI_NIPBARU = '$value->nip' ORDER BY a.PKI_TMT_GOLONGAN_BARU ASC";
			
			$query1 = $this->db1->query($sql1);
			$i = 5;$y=145;
			
			if($query1->num_rows() > 0)
			{
			    foreach($query1->result() as $val)
				{
				    $this->pdf->SetXY(10,$y);
					$no = $i.'. ';
					$this->pdf->Write(0, $no, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(18,$y);
					$pejabat = 'KAKANREG XI BKN ';
					$this->pdf->Write(0, $pejabat, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(58,$y);
					$no_sk = $val->no_sk;
					$this->pdf->Write(0, $no_sk, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(94,$y);
					$tgl_sk = $val->tgl_sk;
					$this->pdf->Write(0, $tgl_sk, '', 0, 'L', true, 0, false, false, 0);
					
					$this->pdf->SetXY(115,$y);
					$isi = 'NPKP '.$val->gol_lama.' - '.$val->gol_baru.' , '.$val->tmt;
					$this->pdf->Write(0, $isi, '', 0, 'L', true, 0, false, false, 0);  
					
					$i++; $y +=7;
				
				}
			   
			}
				
		
        } 
		
		$this->pdf->Output('daftar.pdf', 'D');
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
