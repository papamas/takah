<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MY_Controller {

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
		$this->db3   	= $this->load->database('sapkdb', TRUE);
	    $this->oracle   = $this->load->database('oracle', TRUE);
		
		//$this->load->library('openkm');
	}
	
	public function index()
	{
		$data['instansi']			   = $this->_get_instansi();
		$data['status']			       = $this->_get_status();
		$this->load->view('profil/vprofil',$data);
	}
	
	public function jalankan()
	{
	    $data['instansi']       = $this->input->post('instansi');
	    $data['status']		    = $this->input->post('status');
	    $data['vertikal']       = $this->input->post('vertikal');
	    $data['perintah']       = $this->input->post('perintah');
		
          // save session user
		$this->session->set_userdata(array('instansi'  	  => $this->input->post('instansi'),			   
										   'status'       => $this->input->post('status'),								   
										   'vertikal'     => $this->input->post('vertikal'),
										   'perintah'     => $this->input->post('perintah'),
								   ));     
	  	if($this->input->post('perintah') == '1')
        {		
			$this->getResult($data);
		}
        else
        {
             $this->cetakListing($data);
        } 		
	}
	
	public function getResult($data)
	{
	    $vertikal            = $data['vertikal'];
	   
	   // var_dump($this->input->post());exit;
	   
	   
	   	if($vertikal == '2')
	    {
			$data['jumlah']		   = $this->_get_jumlah($data)->num_rows();
	   	}
		else
		{
		    $data['jumlah']		   = $this->_get_jumlah_vertikal($data)->num_rows();
		}
		
		$data ['create_time']      = $this->_get_time_create();
		
		// reload
		$data['instansi']	   = $this->_get_instansi();
	    $data['status']		   = $this->_get_status();
	    
		$this->load->view('profil/vprofil',$data);
	  
	   
	}
	
	function _get_jumlah($data)
	{
        $instansi   = $data['instansi'];
        $status     = $data['status'];
		

	    $sql="SELECT PNS_NIPBARU FROM pupns WHERE PNS_KEDHUK='$status' AND PNS_INSDUK='$instansi'";
		
		
		$query  = $this->db3->query($sql);
		
		return $query;
	
	}
	
	function _get_instansi()
	{
	    $sql="SELECT * FROM mirror.instansi where 
INS_KODINS between '7000' and '7171' OR   INS_KODINS between '7900' and '7972'
Order by ins_kodins ASC";		
		$query  = $this->db3->query($sql);
		return $query;
		
	}
	
	function _get_status()
	{
	    $sql="select * from kedhuk order by KED_KEDKOD  ASC";
		$query  = $this->db3->query($sql);
		return $query;
	
	}
	
	
	function _get_jumlah_vertikal($data)
	{
		$instansi   = $data['instansi'];
        $status     = $data['status'];
		
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
		$sql="SELECT a.* FROM (SELECT a.*,LEFT(a.PNS_TEMKRJ,2) KD_PROV,LOK_LOKNAM,LOK_KANREG  FROM (SELECT b.INS_NAMins, a.PNS_NIPBARU,a.PNS_PNSNAM
,a.PNS_INSDUK,a.PNS_TEMKRJ ,a.PNS_KEDHUK    FROM mirror.pupns a
INNER JOIN instansi b ON b.INS_KODINS=a.PNS_INSDUK
where b.INS_KODINS BETWEEN '1010' AND '4062'
) a 
INNER JOIN LOKKER b ON b.LOK_LOKKOD = a.PNS_TEMKRJ
where b.LOK_KANREG='11' ) a WHERE a.KD_PROV='$instansi' AND a.PNS_KEDHUK='$status'";
        $query  = $this->db3->query($sql);
		return $query;


	}
	
	function _get_time_create()
	{
	    $sql="select DATE_FORMAT(create_time,'%d-%m-%Y %h:%i:%s') create_time from information_schema.tables where table_schema='mirror' and
table_name='pupns'";

        $query  = $this->db3->query($sql);
		$row    = $query->row();
		
		return $row->create_time;
	
	}
	
	
	public function cetakListing($data)
	{
	   	$instansi			= $data['instansi'] ;
	    $status				= $data['status'];
	    $vertikal       	= $data['vertikal'];
		        
		if($vertikal == '2')
		{		
			$result   = $this->_cetakDaerah($data);
			$q        = $result['record'];
			$instansi = $result['instansi'];
						
		}
		else
		{
		   	$result   = $this->_cetakPusat($data);
			$q        = $result['record'];
			$instansi = $result['instansi'];
		}
		
        // creating xls file
		$now              = date('dmYHis');
		$filename         = "ProfilPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'PROFIL KEADAAN DATA PNS BERDASARKAN DATABASE MIRROR UPDATE TGL : '. $this->_get_time_create().' ' .$instansi. ' <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>STATUS</th>
					<th>INSTANSI</th>
					<th>LOKASI KERJA</th>'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->PNS_NIPBARU}</td>";
				$html .= "<td width=400>{$r->PNS_PNSNAM}</td>";
				$html .= "<td>{$r->KED_KEDNAM}</td>";
				$html .= "<td width=450>{$r->INS_NAMINS}</td>";
				$html .= "<td>{$r->LOK_LOKNAM}</td>";
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
	
	function _cetakDaerah($data)
	{
	    $instansi   = $data['instansi'];
        $status     = $data['status'];
		
	    $sql1="select a.*,d.KED_KEDNAM, b.INS_NAMINS, c.LOK_LOKNAM FROM (SELECT a.PNS_KEDHUK,a.PNS_NIPBARU,a.PNS_PNSNAM,a.PNS_INSDUK,a.PNS_TEMKRJ FROM mirror.pupns a
WHERE a.PNS_KEDHUK='$status' AND a.PNS_INSDUK='$instansi'
)a
INNER JOIN INSTANSI b on b.INS_KODINS = a.PNS_INSDUK
INNER JOIN LOKKER c ON c.LOK_LOKKOD = a.PNS_TEMKRJ
INNER JOIN KEDHUK d ON d.KED_KEDKOD = a.PNS_KEDHUK
ORDER BY a.PNS_NIPBARU ASC ";

        $q  = $this->db3->query($sql1);
		
		return array('instansi'  => '' , 'record'  => $q);

	}
	
	function _cetakPusat($data)
	{
	    $instansi   = $data['instansi'];
        $status     = $data['status'];
		 
	    if($instansi  == '7100')
		{
		   $kinstansi ='75';
		   $tinstansi = 'INSTANSI VERTIKAL GORONTALO';
		}
		elseif($instansi == '7000') 
		{
		   $kinstansi ='71';
		   $tinstansi = 'INSTANSI VERTIKAL SULAWESI UTARA';
		   
		}
		elseif ($instansi == '7900')
		{
		   $kinstansi ='83';
		   $tinstansi = 'INSTANSI VERTIKAL MALUKU UTARA UTARA';
		}
		else
		{
			$kinstansi ='00';
			$tinstansi = '';
		}

				$sql2="SELECT a.* FROM (SELECT a.*,LEFT(a.PNS_TEMKRJ,2) KD_PROV,LOK_LOKNAM,LOK_KANREG  FROM (SELECT c.KED_KEDNAM,b.INS_NAMINS, a.PNS_NIPBARU,a.PNS_PNSNAM
		,a.PNS_INSDUK,a.PNS_TEMKRJ ,a.PNS_KEDHUK    FROM mirror.pupns a
		INNER JOIN instansi b ON b.INS_KODINS=a.PNS_INSDUK
		INNER JOIN KEDHUK c ON c.KED_KEDKOD = a.PNS_KEDHUK
		where b.INS_KODINS BETWEEN '1010' AND '4062'
		) a 
		INNER JOIN LOKKER b ON b.LOK_LOKKOD = a.PNS_TEMKRJ
		where b.LOK_KANREG='11' ) a WHERE a.KD_PROV='$kinstansi' AND a.PNS_KEDHUK='$status'
		ORDER BY a.PNS_NIPBARU ASC"; 
					
		$q  = $this->db3->query($sql2);
		
		return array('instansi'  => $tinstansi , 'record'  => $q);
	
	}
	

	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */