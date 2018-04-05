<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capaiankinerja extends MY_Controller {

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
		
		$data['instansi']			= $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('rekap/capaiankinerja_view',$data);
	}
	
	public function cetak()
	{
	    $data['aksi']			= $this->input->post('aksi');
		$data['seksi']		    = $this->input->post('seksi');
		$data['pelaksana']      = $this->input->post('pelaksana'); 		
		$data['instansi']		= $this->input->post('instansi');
		$reportrange        	= $this->input->post('reportrange');
		$xreportrange       	= explode("-",$reportrange);
		$data['startdate']		= $xreportrange[0];
		$data['enddate']		= $xreportrange[1];
		
		$this->_rekap($data);		
	}
	
	public function _rekap($data)
	{
	    $instansi      =  $data['instansi'];
		$startdate     =  $data['startdate'];
		$enddate       =  $data['enddate'];
		$pelaksana     =  $data['pelaksana'];
		$aksi          =  $data['aksi'];
		$seksi         =  $data['seksi'];
		
		if($instansi != '')
		{
		    $data['sql_instansi'] =" AND a.kode_instansi='$instansi' "; 
		}		
		else
		{
		   $data['sql_instansi']  =" "; 
		}
		
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
		
		if($seksi == '1')
		{
		    $this->_cetak_rekap_verprov($data); 
		}
		else
		{
		    $this->_cetak_rekap_kabkot($data);
		
		}	
		   
	}
	
	function _cetak_rekap_verprov($data)
	{
	    $instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$sql_instansi  = $data['sql_instansi'];
		$verprov       = implode(',',$this->_get_verprov());
		$sql_instansi  = $sql_instansi . "  AND a.kode_instansi IN($verprov)";
		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU , e.nama FROM takah.npkp a
LEFT JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
LEFT JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
LEFT JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
LEFT JOIN takah.app_user e ON e.id  =  a.id_pelaksana
WHERE 1=1 $sql_aksi  $sql_instansi  AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY concat(a.aksi,a.tmt,a.kode_instansi,a.id_pelaksana) ";
       
		$q    = $this->db1->query($sql);
		
		
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CAPAIANNPKPREKAPITULASIKABKOT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN CAPAIAN KINERJA  '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>
				   PEREKAMAN NPKP<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>					
					<th>INSTANSI</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";				
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
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

        // Peminjaman TAKAH
		
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.id_pelaksana','a.created_by',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		$sql="SELECT a.*,count(a.id) jumlah,DATE( a.created_date ) tgl_pinjam, 
		DATE( a.tgl_kembali ) tgl_balik , b.nama , c.INS_NAMINS
		FROM  takah.formulir_pinjam a
        LEFT JOIN takah.app_user b ON a.created_by = b.id 
  		LEFT JOIN mirror.instansi c ON c.INS_KODINS = a.kode_instansi
		WHERE 1=1 AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana $sql_instansi
		GROUP BY concat(a.kode_instansi,a.created_by)";
			
		$q    = $this->db1->query($sql);
		
		
	    $html   = '<br/>
				   PEMINJAMAN TATA NASKAH<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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

		
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.kode_instansi','a.instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}

    // perekaman cpns    
    $sql="SELECT 
    a . *,
    c.INS_NAMINS, d.nama,
	count(a.id) jumlah
FROM
    (SELECT 
        a . *,  DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input
    FROM
        takah.cpns a
    WHERE
        1 = 1 $sql_pelaksana  $sql_instansi
            AND DATE(created_date) BETWEEN STR_TO_DATE('$startdate', '%d/%m/%Y ') AND STR_TO_DATE('$enddate', '%d/%m/%Y')) a
        
    LEFT JOIN
    mirror.instansi c ON a.instansi = c.INS_KODINS
	LEFT JOIN takah.app_user d ON d.id  = a.created_by
GROUP by concat(a.instansi,a.created_by)";

        $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN CPNS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// Perekaman BUP
		$sql="SELECT a.*, count(a.id) jumlah, b.INS_NAMINS,c.nama,  
		DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM takah.bup a  
		LEFT JOIN mirror.instansi b ON a.instansi = b.INS_KODINS
		LEFT JOIN takah.app_user c ON c.id  = a.created_by
		WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi)";
       
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN BUP<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// PWK MASUK BY TUJUAN
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi','a.instansi_tujuan',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		
		$sql="SELECT a.*,count(a.id) jumlah, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input , b.INS_NAMINS, c.nama
		FROM takah.pwk a 
		LEFT JOIN mirror.instansi b ON a.instansi_tujuan  = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id
		WHERE 1=1 
		$sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi_tujuan)";
		
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN PINDAH WILAYAH KERJA (MASUK)<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// PWK KELUAR BY ASAL
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi_tujuan','a.instansi_asal',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		
		$sql="SELECT a.*,count(a.id) jumlah, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input , b.INS_NAMINS, c.nama
		FROM takah.pwk a 
		LEFT JOIN mirror.instansi b ON a.instansi_asal  = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id
		WHERE 1=1 
		$sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi_asal)";
		
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN PINDAH WILAYAH KERJA (KELUAR)<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// HUKUMAN DISIPLIN
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi_asal','a.instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		$sql="SELECT a.*, count(a.id) jumlah, b.INS_NAMINS, c.nama FROM takah.hukuman a  
		LEFT JOIN mirror.instansi b ON a.instansi = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id		
		WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi)";

         $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN HUKUMAN DISIPLIN<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// DMS
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.created_by','a.id_pelaksana',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi','a.kode_instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}

		$sql="select a.*, sum(a.jumlah) jumlah_doc , count(a.nip) jumlah  from (
		SELECT  a.*, sum(b.jumlah) jumlah, c.INS_NAMINS, d.nama pelaksana FROM dms_nip a  
		LEFT JOIN dms_scan b ON b.id_dms_nip = a.id 
		LEFT JOIN mirror.instansi c ON a.kode_instansi = c.INS_KODINS
		LEFT JOIN takah.app_user d ON a.id_pelaksana = d.id	
		where 1=1 AND DATE( b.created_doc ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')  $sql_pelaksana   $sql_instansi  AND a.scanning IS NOT  NULL
		GROUP BY concat(a.id,a.id_pelaksana,a.kode_instansi)
		) a GROUP BY concat(a.id_pelaksana,a.kode_instansi)";
		
		$q    = $this->db1->query($sql);
		$html   = '<br/>
				   PEREKAMAN DMS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH FILE</th>
					<th>JUMLAH TAKAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->pelaksana}</td>";
				$html .= "<td >{$r->INS_NAMINS}</td>";
				$html .= "<td width=450>{$r->jumlah_doc}</td>";
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
		
		// surat masuk	
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.id_pelaksana','a.id_penerima',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		$sql="SELECT a.*, count(a.id) jumlah, b.action_disposisi, c.INS_NAMINS, d.nama FROM  takah.surat_masuk a 
		LEFT JOIN action_disposisi  b ON b.id_surat=a.id  
		LEFT JOIN mirror.instansi c ON a.kode_instansi = c.INS_KODINS
		LEFT JOIN takah.app_user d ON a.id_penerima = d.id	
		WHERE 1=1 AND (DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') OR DATE( a.update_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') )  $sql_pelaksana  $sql_instansi 
        -- AND a.status_penerima IS NOT NULL 
		GROUP BY concat(a.id_penerima,a.kode_instansi)
		";
		
       
		$q    = $this->db1->query($sql);
		$html   = '<br/>
				   PEREKAMAN SURAT MASUK<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>';
					 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
				$html .= "<td >{$r->INS_NAMINS}</td>";
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
	
	
	function _cetak_rekap_kabkot($data)
	{
	    
		
		$instansi      = $data['instansi'];
		$startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		$sql_aksi      = $data['sql_aksi'];
		$sql_pelaksana = $data['sql_pelaksana'];
		$sql_instansi  = $data['sql_instansi'];
		$kab_kot       = implode(',',$this->_get_kabkot());				
		$sql_instansi  = $sql_instansi . "  AND a.kode_instansi IN($kab_kot)";		
	   $sql="SELECT count(a.nip) jumlah,a.*, b.INS_NAMINS,c.GOL_GOLNAM GOL_LAMA,
d.GOL_GOLNAM GOL_BARU , e.nama FROM takah.npkp a
LEFT JOIN mirror.instansi b ON b.INS_KODINS = a.kode_instansi
LEFT JOIN MIRROR.golru c ON c.GOL_KODGOL = a.gol_lama_id
LEFT JOIN MIRROR.golru d ON d.GOL_KODGOL = a.gol_baru_id
LEFT JOIN takah.app_user e ON e.id  =  a.id_pelaksana
WHERE 1=1 $sql_aksi  $sql_instansi  AND DATE( tgl_input ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y ' ) $sql_pelaksana GROUP BY concat(a.aksi,a.tmt,a.kode_instansi,a.id_pelaksana) ";
       
		$q    = $this->db1->query($sql);	
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CAPAIANNPKPREKAPITULASIKABKOT".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN CAPAIAN KINERJA  '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>
				   PEREKAMAN NPKP<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>					
					<th>INSTANSI</th>
					<th>TMT</th>
					<th>AKSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";				
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->tmt}</td>";
				$html .= "<td>{$r->aksi}</td>";
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

        // Peminjaman TAKAH
		
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.id_pelaksana','a.created_by',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		$sql="SELECT a.*,count(a.id) jumlah,DATE( a.created_date ) tgl_pinjam, 
		DATE( a.tgl_kembali ) tgl_balik , b.nama , c.INS_NAMINS
		FROM  takah.formulir_pinjam a
        LEFT JOIN takah.app_user b ON a.created_by = b.id 
  		LEFT JOIN mirror.instansi c ON c.INS_KODINS = a.kode_instansi
		WHERE 1=1 AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana $sql_instansi
		GROUP BY concat(a.kode_instansi,a.created_by)";
		
        //var_dump($sql );exit;		
		$q    = $this->db1->query($sql);
		
		
	    $html   = '<br/>
				   PEMINJAMAN TATA NASKAH<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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

		
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.kode_instansi','a.instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}

    // perekaman cpns    
    $sql="SELECT 
    a . *,
    c.INS_NAMINS, d.nama,
	count(a.id) jumlah
FROM
    (SELECT 
        a . *,  DATE_FORMAT(a.created_date, '%d-%m-%Y') tgl_input
    FROM
        takah.cpns a
    WHERE
        1 = 1 $sql_pelaksana  $sql_instansi
            AND DATE(created_date) BETWEEN STR_TO_DATE('$startdate', '%d/%m/%Y ') AND STR_TO_DATE('$enddate', '%d/%m/%Y')) a
        
    LEFT JOIN
    mirror.instansi c ON a.instansi = c.INS_KODINS
	LEFT JOIN takah.app_user d ON d.id  = a.created_by
GROUP by concat(a.instansi,a.created_by)";

        $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN CPNS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// Perekaman BUP
		$sql="SELECT a.*, count(a.id) jumlah, b.INS_NAMINS,c.nama,  
		DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input FROM takah.bup a  
		LEFT JOIN mirror.instansi b ON a.instansi = b.INS_KODINS
		LEFT JOIN takah.app_user c ON c.id  = a.created_by
		WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi)";
       
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN BUP<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// PWK MASUK BY TUJUAN
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi','a.instansi_tujuan',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		
		$sql="SELECT a.*,count(a.id) jumlah, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input , b.INS_NAMINS, c.nama
		FROM takah.pwk a 
		LEFT JOIN mirror.instansi b ON a.instansi_tujuan  = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id
		WHERE 1=1 
		$sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi_tujuan)";
		
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN PINDAH WILAYAH KERJA (MASUK)<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// PWK KELUAR BY ASAL
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi_tujuan','a.instansi_asal',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		
		$sql="SELECT a.*,count(a.id) jumlah, DATE_FORMAT(a.created_date,'%d-%m-%Y') tgl_input , b.INS_NAMINS, c.nama
		FROM takah.pwk a 
		LEFT JOIN mirror.instansi b ON a.instansi_asal  = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id
		WHERE 1=1 
		$sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi_asal)";
		
	    $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN PINDAH WILAYAH KERJA (KELUAR)<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// HUKUMAN DISIPLIN
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi_asal','a.instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}
		$sql="SELECT a.*, count(a.id) jumlah, b.INS_NAMINS, c.nama FROM takah.hukuman a  
		LEFT JOIN mirror.instansi b ON a.instansi = b.INS_KODINS
		LEFT JOIN takah.app_user c ON a.created_by = c.id		
		WHERE 1=1  $sql_pelaksana $sql_instansi  AND DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') GROUP BY concat(a.created_by,a.instansi)";

         $q    = $this->db1->query($sql);
	   
	    $html   = '<br/>
				   PEREKAMAN HUKUMAN DISIPLIN<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
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
		
		// DMS
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.created_by','a.id_pelaksana',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		if($sql_instansi != '')
		{
		    $sql_instansi   = str_replace('a.instansi','a.kode_instansi',$sql_instansi);
		}
		else
		{
		    $sql_instansi  = " ";
		}

		$sql="select a.*, sum(a.jumlah) jumlah_doc , count(a.nip) jumlah  from (
		SELECT  a.*, sum(b.jumlah) jumlah, c.INS_NAMINS, d.nama pelaksana FROM dms_nip a  
		LEFT JOIN dms_scan b ON b.id_dms_nip = a.id 
		LEFT JOIN mirror.instansi c ON a.kode_instansi = c.INS_KODINS
		LEFT JOIN takah.app_user d ON a.id_pelaksana = d.id	
		where 1=1 AND DATE( b.created_doc ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')  $sql_pelaksana   $sql_instansi  AND a.scanning IS NOT  NULL
		GROUP BY concat(a.id,a.id_pelaksana,a.kode_instansi)
		) a GROUP BY concat(a.id_pelaksana,a.kode_instansi)";
		
		$q    = $this->db1->query($sql);
		$html   = '<br/>
				   PEREKAMAN DMS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH FILE</th>
					<th>JUMLAH TAKAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->pelaksana}</td>";
				$html .= "<td >{$r->INS_NAMINS}</td>";
				$html .= "<td width=450>{$r->jumlah_doc}</td>";
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
		
		// surat masuk	
		if($sql_pelaksana != '')
		{
		    $sql_pelaksana   = str_replace('a.id_pelaksana','a.id_penerima',$sql_pelaksana);
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		$sql="SELECT a.*, count(a.id) jumlah, b.action_disposisi, c.INS_NAMINS, d.nama FROM  takah.surat_masuk a 
		LEFT JOIN action_disposisi  b ON b.id_surat=a.id  
		LEFT JOIN mirror.instansi c ON a.kode_instansi = c.INS_KODINS
		LEFT JOIN takah.app_user d ON a.id_penerima = d.id	
		WHERE 1=1 AND ( DATE( a.created_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') OR DATE( a.update_date ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') ) $sql_pelaksana  $sql_instansi 
        -- AND a.status_penerima IS NOT NULL 
		GROUP BY concat(a.id_penerima,a.kode_instansi)
		";
		 //var_dump($sql); exit;			
		$q    = $this->db1->query($sql);
		$html   = '<br/>
				   PEREKAMAN SURAT MASUK<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>PELAKSANA</th>
					<th>INSTANSI</th>
					<th>JUMLAH</th>';
					 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td >{$r->nama}</td>";
				$html .= "<td >{$r->INS_NAMINS}</td>";
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
	
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
	}
	
	function _get_kabkot()
	{
	    $sql="SELECT a.* FROM (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
) a WHERE INS_KODINS NOT IN ('7100','7000','7900')";		
		$query  = $this->db3->query($sql)->result_array();
		foreach($query as $value)
		{
		    $r[]  =$value['INS_KODINS']; 
		}
		return $r;
	}
	
	function _get_verprov()
	{
	    $sql="SELECT a.* FROM (SELECT INS_KODINS FROM mirror.instansi where 
INS_KODINS between '1010' and '4062' OR INS_KODINS IN ('7100','7000','7900')) a ";		
		$query  = $this->db3->query($sql)->result_array();
		foreach($query as $value)
		{
		    $r[]  =$value['INS_KODINS']; 
		}
		return $r;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */