<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scanning extends MY_Controller {

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
		$data['pelaksana']			   = $this->_get_app_user();
		$data['lihat']		           = FALSE;	
	    
		$this->load->view('scanning/vscanning',$data);
	}
	
	public function jalankan()
	{
	    $data['instansi']      = $this->input->post('instansi'); 
	    $data['perintah']	   = $this->input->post('perintah');
		$data['pelaksana']     = $this->input->post('pelaksana');
		
		  // save session user
		$this->session->set_userdata(array('instansi'  	  => $this->input->post('instansi'),			   
										   'pelaksana'    => $this->input->post('pelaksana'),
										   
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
	
	function getCetak($data)
	{
	    $data['lihat']		           = FALSE;	
	    $instansi                      = $data['instansi'];    
		
        $q						       = $this->getRecord($data);		
		// creating xls file
		$now              = date('dmYHis');
		$filename         = "SCANNINGPNS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LISTING SCANNING BERDASARKAN DATABASE MIRROR UPDATE TGL : '. $this->_get_time_create().' ' .$this->_get_instansi_name($instansi). ' <br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>PRASCANNING</th>
					<th>PRADATE</th>
					<th>SCANNING</th>
					<th>SCANDATE</th>
					<th>PEMBERI TUGAS</th>
					<th>PELAKSANA</th>
					'; 
		$html 	.= '</tr>';
		if($q->num_rows() > 0){
			$i = 1;		        
			foreach ($q->result() as $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td width=400>{$r->PNS_PNSNAM}</td>";
				$html .= "<td align=center>".($r->prascanning ? '&#10004;' : '')."</td>";
				$html .= "<td>{$r->pradate}</td>";
				$html .= "<td align=center>".($r->scanning ? '&#10004;' : ' ')."</td>";	
				$html .= "<td>{$r->scandate}</td>";
				$html .= "<td>{$r->pemberi_tugas}</td>";	
				$html .= "<td>{$r->pelaksana}</td>";	
				$html .= "</tr>";
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=5 >There is no data found</td></tr></table>";
			echo $html;
		}
       
	    
		
	}
	function getLihat($data)
	{
	    $data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = TRUE;
        $data['pelaksana']			   = $data['pelaksana'];		
	    $data['record']			   	   = $this->getRecord($data);
		
	    $data['instansi']			   = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('scanning/vscanning',$data);  
	
	}
	
	function getResult($data)
	{
	    $data ['create_time']          = $this->_get_time_create();
	    $data['lihat']		           = FALSE;	
	    $data['record']			   	   = $this->getRecord($data);
		
	    $data['instansi']			   = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		
		$this->load->view('scanning/vscanning',$data);  
	
	}
	
	function createFolder()
	{
		
		$nama_instansi	=  $this->input->post('instansi');
		$nip			=  $this->input->post('nip');
		
		$result			= $this->_createFolder($nama_instansi,$nip);
		
		//var_dump($result['Text']);exit;
		$search            = $nip;
		
		if($search)
		{
		
				$sql="SELECT 
			a . *
		FROM
			okmdb.`okm_node_base` a
			INNER JOIN    okmdb.okm_node_folder b ON b.NBS_UUID = a.NBS_UUID
			WHERE a.NBS_CONTEXT ='okm_root' and a.NBS_NAME LIKE '%$search%'
			
			";
			$r = $this->db1->query($sql)->result_array();
			$children = array();
			if(count($r) > 0) 
			{
				# It has children, let's get them.
				foreach ( $r as $key => $item )
				{
					# Add the child to the list of children, and get its subchildren
					$children = $this->getChildParent($item['NBS_UUID']);
					
				}
				$data['message'] = $result['Text'];
			}
			else
			{
				$data['message'] = $result['Text'];
			}
			
			
			$data['children'] = $this->buildMenu($children);
		
		}
		else
		{
		    $data['message'] = $result['Text'];
		}
		
		$data['search']    = $search;	
		// pupns
		$data['pupns']      = $this->_get_pupns($search);
		$data['pendidikan'] = $this->_get_pendidikan($search);
		$data['pengadaan']  = $this->_get_pengadaan_info($search);	
		$data['kp']		    = $this->_getkp_info($search);			
        $data['unor']		= $this->_get_unorpns($search);			
		$this->load->view('search/vdms',$data);
	}
	
	function _get_time_create()
	{
	    $sql="select DATE_FORMAT(create_time,'%d-%m-%Y %h:%i:%s') create_time from information_schema.tables where table_schema='mirror' and
table_name='pupns_kp_info'";

        $query  = $this->db3->query($sql);
		$row    = $query->row();
		
		return $row->create_time;
	
	}
	
	
	function getRecord($data)
	{
	    $instansi		= $data['instansi']	;
		$pelaksana		= $data['pelaksana'];	
		
		if($pelaksana != '')
		{
		    $user =" AND a.id_pelaksana='$pelaksana'";
		}
		else
		{
		    $user  = " ";
		}
	   
	   $sql="SELECT * FROM (SELECT c.PNS_PNSNAM,c.PNS_INSDUK,d.INS_NAMINS, a.*,b.nama  pemberi_tugas,e.nama pelaksana FROM dms_nip a 
	   INNER JOIN app_user b ON b.id = a.id_app_user
	   INNER JOIN mirror.pupns c ON a.nip = c.PNS_NIPBARU
	   INNER JOIN mirror.instansi d ON  d.INS_KODINS = c.PNS_INSDUK 
	   INNER JOIN app_user e ON e.id = a.id_pelaksana
	   WHERE c.PNS_INSDUK='$instansi' $user
	   ) a
	   GROUP BY a.nip ORDER BY a.nip ASC";
	   return $this->db1->query($sql);
	
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
	    $sql="SELECT id,nama FROM app_user WHERE 1=1 $sql_limit_user and level !='kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
	
	function _get_instansi()
	{
	    $sql="SELECT  * FROM instansi order by INS_KODINS ASC";		
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
	
	public function search()
	{	   
		$search            = trim($this->input->post('search'));	
		
		if(strlen($search) < 32){			
			$search = $search;
		}else{
			$query = $this->_getBarcode_data($search);
			
			if($query->num_rows() > 0){
				$row 	= $query->row();
				$search = $row->NIP_BARU;
			}else{
				$search = $search;
			}			
		}
		
		
		
		if($search)
		{
		
				$sql="SELECT 
			a . *
		FROM
			okmdb.`okm_node_base` a
			INNER JOIN    okmdb.okm_node_folder b ON b.NBS_UUID = a.NBS_UUID
			WHERE a.NBS_CONTEXT ='okm_root' and a.NBS_NAME LIKE '%$search%'
			
			";
			$r = $this->db1->query($sql)->result_array();
			$children = array();
			if(count($r) > 0) 
			{
				# It has children, let's get them.
				foreach ( $r as $key => $item )
				{
					# Add the child to the list of children, and get its subchildren
					$children = $this->getChildParent($item['NBS_UUID']);
					
				}
				$data['message'] = '';
			}
			else
			{
				$data['message'] = 'Sorry, File Not Found';
			}
			
			
			$data['children'] = $this->buildMenu($children);
		
		}
		else
		{
		    $data['message'] = '';
		}
		
		$data['search']    = $search;	
		// pupns
		$data['pupns']      = $this->_get_pupns($search);
		$data['pendidikan'] = $this->_get_pendidikan($search);
		$data['pengadaan']  = $this->_get_pengadaan_info($search);	
		$data['kp']		    = $this->_getkp_info($search);			
        $data['unor']		= $this->_get_unorpns($search);		
		$this->load->view('search/vdms',$data);
	
	}
	
	function _getBarcode_data($barcode){
		
		$sql="SELECT a.* FROM mirror.`pupns_barcode_dokumen` a WHERE a.`ID`='$barcode'";			
		$query  = $this->db1->query($sql);	
		return $query;
	}
	
	function _getkp_info($search)
	{
	   $sql="select * from (select a.*,b.PNS_TEMKRJ, c.GOL_GOLNAM GOL_BARU, d.GOL_GOLNAM GOL_LAMA , e.JKP_JPNNAMA FROM (
	   SELECT JKP_JPNKOD,PKI_NIPBARU,NOTA_PERSETUJUAN_KP ,PKI_SK_TANGGAL,
	   DATE_FORMAT(TGL_NOTA_PERSETUJUAN_KP,'%d-%m-%Y') TGL_NOTA_PERSETUJUAN_KP,
	   DATE(PKI_TMT_GOLONGAN_BARU) PKI_TMT_GOLONGAN_BARU ,
	   PKI_GOLONGAN_LAMA_ID,PKI_GOLONGAN_BARU_ID FROM mirror.pupns_kp_info 
	   WHERE PKI_NIPBARU='$search' AND NOTA_PERSETUJUAN_KP IS NOT NULL 
	   ) a 
	   INNER JOIN mirror.pupns b ON b.PNS_NIPBARU = a. PKI_NIPBARU
	   LEFT JOIN mirror.golru  c ON a.PKI_GOLONGAN_BARU_ID = c.GOL_KODGOL
	   LEFT JOIN mirror.golru  d ON a.PKI_GOLONGAN_LAMA_ID = d.GOL_KODGOL
	   LEFT JOIN mirror.jenis_kp e ON a.JKP_JPNKOD = e.JKP_JPNKOD
	   ) a ORDER BY PKI_SK_TANGGAL DESC";
	   
	    $r = $this->db1->query($sql);
		
		return $r;
	}
	
	function _get_pengadaan_info($search)
	{
	    $sql ="SELECT a.*,DATE_FORMAT(a.TMT_CPNS,'%d-%m-%Y') CPNS,
		DATE_FORMAT(a.PERSETUJUAN_TEKNIS_TANGGAL,'%d-%m-%Y') TANGGAL_TEKNIS,
		DATE_FORMAT(a.DITETAPKAN_TANGGAL,'%d-%m-%Y') TANGGAL_PENETAPAN
		FROM mirror.pupns_pengadaan_info  a WHERE a.NIP LIKE '$search' ";
		$r = $this->db1->query($sql);
		if($r->num_rows() > 0)
		{
			
			$r = $r->row();
		}
		else
		{
			
			$r = array();
		}	
		
		return $r;
		
		
	}
	
	function _get_pendidikan($search)
	{
	
	   $sql="SELECT a.*, b.*  FROM mirror.`pupns_pendidikan` a
LEFT JOIN mirror.pendik b ON a.PEN_PENKOD = b.DIK_KODIK
WHERE a.`PNS_NIPBARU` LIKE '$search'
ORDER BY a.`PEN_TAHLUL` DESC";

       $r = $this->db1->query($sql);
		
		return $r;
	}
	
	function _get_pupns($search)
	{
	
	    $sql="SELECT a.*,DATE_FORMAT(a.PNS_TGLLHRDT,'%d-%m-%Y') LAHIR,
		DATE_FORMAT(a.PNS_TMTCPN,'%d-%m-%Y') CPNS,
		DATE_FORMAT(a.PNS_TMTPNS,'%d-%m-%Y') PNS,
		b.GOL_GOLNAM,b.GOL_PKTNAM, c.DIK_NAMDIK, d.LOK_LOKNAM,
		e.KED_KEDNAM, f.GOL_GOLNAM GOL_AWAL , g.JPG_JPGNAM,
		h.INS_NAMINS INSDUK , i.INS_NAMINS INSKER, j.JJB_JJBNAM
		FROM mirror.pupns a 
		LEFT JOIN mirror.golru b ON a.PNS_GOLRU =b.GOL_KODGOL
		LEFT JOIN mirror.tktpendik c ON a.PNS_TKTDIK = c.DIK_TKTDIK
		LEFT JOIN mirror.lokker  d ON  a.PNS_TEMKRJ = d.LOK_LOKKOD
		LEFT JOIN mirror.kedhuk e ON a.PNS_KEDHUK = e.KED_KEDKOD
		LEFT JOIN mirror.golru f ON a.PNS_GOLAWL = f.GOL_KODGOL
		LEFT JOIN mirror.jenpeg g ON a.PNS_JENPEG = g.JPG_JPGKOD
		LEFT JOIN mirror.instansi h ON a.PNS_INSDUK = h.INS_KODINS
		LEFT JOIN mirror.instansi i ON a.PNS_INSKER = i.INS_KODINS
		LEFT JOIN mirror.jenjab j ON a.PNS_JNSJAB = j.JJB_JJBKOD
		WHERE a.PNS_NIPBARU LIKE '$search'";
		$r = $this->db1->query($sql);
		
		if($r->num_rows() > 0)
		{
			
			$r = $r->row();
		}
		else
		{
			
			$r = array();
		}	
		
		return $r;
	}
	
	function _get_unorpns($search)
	{
	
	    $sql="SELECT 
    a.`PNS_NIPBARU`,
    a.`PNS_PNSNAM`,
    h.INS_NAMINS INSDUK,
    j.JJB_JJBNAM,
    k.JBF_NAMJAB,
    l.UNO_NAMUNO,
    l.UNO_NAMJAB,
    l.UNO_DIATASAN_ID,
    m.UNO_NAMUNO UNO_INDUK
FROM
    mirror.pupns a
        LEFT JOIN
    mirror.instansi h ON a.PNS_INSDUK = h.INS_KODINS
        LEFT JOIN
    mirror.jenjab j ON a.PNS_JNSJAB = j.JJB_JJBKOD
        LEFT JOIN
    mirror.jabfun k ON a.PNS_JABFUN = k.JBF_KODJAB
		LEFT JOIN
    mirror.unor l ON (a.PNS_UNITOR = l.UNO_KODUNO
        AND a.PNS_INSDUK = l.UNO_INSTAN
        AND a.PNS_UNOR = l.UNO_ID)
    LEFT join
    mirror.unor m ON (l.UNO_DIATASAN_ID = m.UNO_ID  AND a.PNS_INSDUK = m.UNO_INSTAN) 
WHERE
    a.PNS_NIPBARU='$search'";
		$r = $this->db1->query($sql);
		
		if($r->num_rows() > 0)
		{
			
			$r = $r->row();
		}
		else
		{
			
			$r = array();
		}	
		
		return $r;
	}
	
	function buildMenu($array)
	{
		 //if(count($array) == 1 ) return FALSE;
		 $html = "<ul>";		  
		  foreach ($array as $item)
		  {
			/* if(count($array) != 10)
			{
			    $html .='<li> <span><i class="fa fa-file"></i> ';
				$html .='<span class="file" id='.$item['NBS_UUID'].'>'.$item['NBS_NAME'].'</span>';
			}
			else
			{
				$html .='<li> <span><i class="fa fa-folder-open"></i> ';	
				$html .='<span class="file" id='.$item['NBS_UUID'].'>'.$item['NBS_NAME'].'</span>';
				//$html .=$item['NBS_NAME'].' <span class="">'.count($item['CHILDREN']).'</span>';
			} */
			
			$html .='<li> <span><i class="fa fa-folder-open"></i> ';
			$html .='<span class="file" id='.$item['NBS_UUID'].'>'.$item['NBS_NAME'].'</span>';
			
			if (!empty($item['CHILDREN']))
			{
			  $html .= $this->buildMenu($item['CHILDREN']);
			}
			$html .='</span></li>';
			
		  }
		  $html .='</ul>';
		  
		  return $html;
	}
	
	
	function getChildParent($uuid) 	
	{
		$sql = "select 
		*
	from
		okmdb.okm_node_base
	WHERE
		nbs_parent = '$uuid' ORDER BY NBS_NAME ASC";
		$r = $this->db1->query($sql)->result_array();
		$children   = array();
		
		if(count($r) > 0) 
		{
		    foreach ( $r as $key => $item )
			{
			    $children[] = array( 'NBS_NAME' 	=> $item['NBS_NAME'],				
									 'NBS_UUID'		=> $item['NBS_UUID'],
									 'NBS_AUTHOR'   => $item['NBS_AUTHOR'],
									 'NBS_CREATED'  => $item['NBS_CREATED'],
									 'JUMLAH'		=> COUNT($this->getChildParent($item['NBS_UUID'])),
									 'CHILDREN'     => $this->getChildParent($item['NBS_UUID']),
				);
				
				
				
			}
		}
				
		return $children;
		
	}
	
	
	
	function _get_dms_login($id)
	{
	    $sql="SELECT dms_user,dms_password FROM app_user WHERE id='$id' ";
		$query = $this->db1->query($sql);
		$row   = $query->row();
		
		return $row;
		
	
	}
	
	
	function _createFolder($nama_instansi,$nip)
	
	{
		$id_user		= $this->session->userdata('user_id');		
		$row			= $this->_get_dms_login($id_user);
		
		if(count($row) > 0){
			
		    $username 		= $row->dms_user;
			$pass			= $row->dms_password;
		}else{
			$username		= '198105122015031001';
			$pass			= '198105122015031001';
		}
		
		$this->load->library('openkm');
		$token 				 = $this->openkm->Login($username,$pass);
		$validnip            = $this->openkm->isValid('/'.$nama_instansi.'/'.$nip);
		$isValidnip          = $validnip['result'];
		$template			 = array('D2 NP NIP','DIKLAT JABATAN','DPCP','DRH','DT KELUARGA','HUKUMAN DISIPLIN','IJAZAH','NPKP','PAK','PANGKALAN DATA','PERUB DT DASAR','PMK','SK CPNS','SK KP TERAKHIR','SK MUTASI PINDAH','SK PJO','SK PNS','SK PPJN','SKP','SPMJ TERAKHIR','STLUD','SURAT IJIN BELAJAR','URAIAN TUGAS');
		if(!$isValidnip)
		{
		    $dms              = $this->openkm->CreateFolder('/'.$nama_instansi.'/'.$nip); 
		   
		    foreach ($template as $value){
				$status  		 = $this->openkm->CreateFolder('/'.$nama_instansi.'/'.$nip.'/'.$value); 
		    }
		   
		    $dms	= array('Text' => 'DMS Folder Has Been Created', 'Status'   => $status['status']);
		}
		else
		{
		    $dms		 = array ('Text'  => 'DMS Folder Has Been Exist' , 'Status'   => $isValidnip); 
		}
		
		return $dms;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
