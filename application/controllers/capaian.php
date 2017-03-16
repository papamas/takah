<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capaian extends MY_Controller {

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
		
		
		$data['pelaksana']			   = '';
		
		$this->load->view('rekap/capaian_view',$data);
	}
	
	public function cetak()
	{
	   	$reportrange        	= $this->input->post('reportrange');
		$xreportrange       	= explode("-",$reportrange);
		$data['startdate']		= $xreportrange[0];
		$data['enddate']		= $xreportrange[1];
		
		$this->_rekap($data);		
	}
	
	public function _rekap($data)
	{
	    $startdate     =  $data['startdate'];
		$enddate       =  $data['enddate'];
		
        $this->_cetak_rekap($data);	
			
		   
	}
	
	function _cetak_rekap($data)
	{
	    $startdate     = $data['startdate'];
		$enddate       = $data['enddate'];
		
		// NPKP
	   $sql="SELECT count(a.id) jumlah from takah.npkp a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')	";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "CAPAIAN".$now.".xls";
		
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
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// CPNS
	   $sql="SELECT count(a.id) jumlah from takah.cpns a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')	";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'CPNS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// PEMINJAMAN
	   $sql="SELECT count(a.id) jumlah from takah.formulir_pinjam a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')	";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'PEMINJAMAN<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
	   $sql="SELECT count(a.jumlah) jumlah from takah.dms_scan a 
WHERE 1=1 AND DATE( a.created_doc )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'DMS<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// SURAT MASUK
	   $sql="SELECT count(a.id) jumlah from takah.surat_masuk a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'SURAT MASUK<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// BUP
	   $sql="SELECT count(a.id) jumlah from takah.bup a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'BUP<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// PWK
	   $sql="SELECT count(a.id) jumlah from takah.pwk a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'PWK<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
		
		// HD
	   $sql="SELECT count(a.id) jumlah from takah.hukuman a 
WHERE 1=1 AND DATE( a.created_date )
BETWEEN STR_TO_DATE( '$startdate ', '%d/%m/%Y ' ) AND STR_TO_DATE( '$enddate', '%d/%m/%Y')";
       
		$q    = $this->db1->query($sql);
		
		//var_dump($sql);exit;
		
        	
		$html   = 'HUKUMAN<br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>JUMLAH</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
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
	
	
	
	
}
