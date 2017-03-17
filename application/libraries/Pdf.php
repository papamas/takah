<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class PDF extends TCPDF
{
    
	
	function __construct($params)
    {
        parent::__construct();
		
		$this->title  =$params['title'];
		$this->instansi=$params['instansi'];
		$this->kepala_seksi =$params['kepala_seksi'];
		$this->nip = $params['nip'];
		$this->pengelola = $params['pengelola'];
		$this->top_margin =20;
    }
	
	
	
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-33);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// $this->Line(10,195, $this->getPageWidth()-10, 195);
		// Page number
		$this->Cell(0, 10, 'Dokumen ini dicetak pada tanggal :'.date('d-m-Y H:i'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	    
		
	    
		
	}
	
	public function Header() {
		// set document information
		$this->SetCreator(PDF_CREATOR);
		$this->SetAuthor('Nur Muhamad Holik');
		//$this->SetTitle('TCPDF Example 003');
		$this->SetSubject('Aplikasi Pengelolaan Tata Naskah Kepegawaian PNS');
		$this->SetKeywords('Aplikasi, PDF, Tata Naskah, Kepegawaian, PNS');

		// Logo
		
		$tutwuri  = base_url().'assets/img/garuda2.jpg';
		$pohuwato = base_url().'assets/img/garuda2.jpg';
		$this->Image($pohuwato, 10, 5, 20, '', 'JPG', '', 'T', false, 200, '', false, false, 0, false, false, false);
		//$this->Image($pohuwato,170, 5, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		
		$this->SetFont('helvetica', 'B', 10);
		$this->Text(5,10,'BADAN KEPEGAWAIAN NEGARA',false,false,true,0,4,'C',false,'',0,false,'T','M',false); 
		$this->Text(5,15,'KANTOR REGIONAL XI',false,false,true,0,4,'C',false,'',0,false,'T','M',false); 
		$this->Text(5,20,$this->title,false,false,true,0,4,'C',false,'',0,false,'T','M',false);
		$this->Text(5,25,'SEKSI PENGELOLAAN ARSIP KEPEGAWAIAN INSTANSI '.$this->instansi,false,false,true,0,4,'C',false,'',0,false,'T','M',false);
        $this->Line(10,30, $this->getPageWidth()- 10, 30); 
		
				 		
		
	}
}
 
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */