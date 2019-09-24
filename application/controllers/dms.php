<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dms extends MY_Controller {

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
        $data['instansi']              = $this->_get_instansi();
		$data['pelaksana']			   = $this->_get_app_user();
		$this->load->view('dms/vdms',$data);
		
	}	
	
	public function cetakMe(){
		
		$pelaksana 		= $this->input->post('pelaksana');
		$reportrange 	= $this->input->post('reportrange');
		$vertikal		= $this->input->post('vertikal');
		$xreportrange	= explode("-",$reportrange);
	    $startdate		= $xreportrange[0];
	    $enddate		= $xreportrange[1];
		
				
		$sql_kab="select a.* from 
(select t4.NBS_AUTHOR t4_NBS_AUTHOR,t1.NBS_NAME t1_NBS_NAME,t1.NBS_CREATED t1_NBS_CREATED,
t2.NBS_NAME t2_NBS_NAME,t2.NBS_CREATED t2_NBS_CREATED,
t3.NBS_NAME t3_NBS_NAME,t3.NBS_CREATED t3_NBS_CREATED,
t4.NBS_NAME t4_NBS_NAME,t4.NBS_CREATED t4_NBS_CREATED
FROM okmdb.okm_node_base t1
LEFT JOIN okmdb.okm_node_base t2 ON t2.NBS_PARENT = t1.NBS_UUID
LEFT JOIN okmdb.okm_node_base t3 ON t3.NBS_PARENT = t2.NBS_UUID
LEFT JOIN okmdb.okm_node_base t4 ON t4.NBS_PARENT = t3.NBS_UUID
WHERE DATE(t4.NBS_CREATED) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')
AND t4.NBS_AUTHOR='$pelaksana'
) a
WHERE 1=1
AND (t1_NBS_NAME LIKE '%Kab%' OR t1_NBS_NAME LIKE '%Kota%')
ORDER BY t4_NBS_CREATED DESC
";

$sql_prov ="/* Query Laporan DMS Provinsi*/
select a.* from 
(select t4.NBS_AUTHOR t4_NBS_AUTHOR,t1.NBS_NAME t1_NBS_NAME,t1.NBS_CREATED t1_NBS_CREATED,
t2.NBS_NAME t2_NBS_NAME,t2.NBS_CREATED t2_NBS_CREATED,
t3.NBS_NAME t3_NBS_NAME,t3.NBS_CREATED t3_NBS_CREATED,
t4.NBS_NAME t4_NBS_NAME,t4.NBS_CREATED t4_NBS_CREATED
FROM okmdb.okm_node_base t1
LEFT JOIN okmdb.okm_node_base t2 ON t2.NBS_PARENT = t1.NBS_UUID
LEFT JOIN okmdb.okm_node_base t3 ON t3.NBS_PARENT = t2.NBS_UUID
LEFT JOIN okmdb.okm_node_base t4 ON t4.NBS_PARENT = t3.NBS_UUID
WHERE DATE(t4.NBS_CREATED) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y')
AND t4.NBS_AUTHOR='$pelaksana'
) a
WHERE 1=1
AND t1_NBS_NAME LIKE '%Provinsi%' 
ORDER BY t4_NBS_CREATED DESC";

//var_dump($sql_kab);exit;

        if($vertikal == 1){
			$query   = $this->db1->query($sql_prov);
		}else{
			$query   = $this->db1->query($sql_kab);
		}
		
		
		$now              = date('dmYHis');
		$filename         = "DMS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN DMS  PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>					
					<th>INSTANSI</th>
					<th>PELAKSANA</th>
					<th>FOLDER</th>
					<th>DOKUMEN</th>
					<th>CREATED</th>
					'; 
		$html 	.= '</tr>';
		if($query->num_rows() > 0){
			$i = 1;		        
			foreach ($query->result() as  $k => $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->t2_NBS_NAME}</td>";				
				$html .= "<td>{$r->t1_NBS_NAME}</td>";	
				$html .= "<td>{$this->_get_nama($r->t4_NBS_AUTHOR)}</td>";
				$html .= "<td>{$r->t3_NBS_NAME}</td>";	
				$html .= "<td>{$r->t4_NBS_NAME}</td>";		
				$html .= "<td>{$r->t4_NBS_CREATED}</td></tr>";				
				$i++;
			}
			$html .="</table>";
			echo $html;
		}else{
			$html .="<tr><td  colspan=7 >There is no data found</td></tr></table>";
			echo $html;
		} 
	}
	
	public function cetak()
	{
	    $instansi       = $this->input->post('instansi');
		$pelaksana 		= $this->input->post('pelaksana');
		$reportrange 	= $this->input->post('reportrange');
		$status         = $this->input->post('status');
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
		    $sql_pelaksana   = " AND a.id_pelaksana='$pelaksana' ";
		}
		else
		{
		    $sql_pelaksana  = " ";
		}
		
		if($status == '1')
		{
		   $sql_status  = " AND a.prascanning IS NOT NULL ";
		}
		elseif($status == '2')
		{
		   $sql_status  = " AND a.scanning IS NOT  NULL";
		}
		else
		{
		   $sql_status  = " ";
		}
		
		
		// creating xls file
	    
		$sql="SELECT  a.* FROM dms_nip a  
		INNER JOIN dms_scan b ON b.id_dms_nip = a.id 
		where 1=1 AND DATE( b.created_doc ) BETWEEN STR_TO_DATE( '$startdate', '%d/%m/%Y ' )
AND STR_TO_DATE( '$enddate', '%d/%m/%Y') $sql_pelaksana   $sql_instansi  $sql_status 
		GROUP BY a.id";
		
		$query   = $this->db1->query($sql);
		
		$now              = date('dmYHis');
		$filename         = "DMS".$now.".xls";
		
		header('Pragma:public');
		header('Cache-Control:no-store, no-cache, must-revalidate');
		header('Content-type:application/x-msdownload');
		header('Content-Disposition:attachment; filename='.$filename);                      
		header('Expires:0'); 
		
		$html   = 'LAPORAN DMS  PERIODE '.$startdate.'  sampai dengan '. $enddate.'<br/>
				   Aplikasi Tata Naskah  Kepegawaian<br/><br/>';
		$html .= '<style> .str{mso-number-format:\@;}</style>';
		$html .= '<table border="1">';					
		$html .='<tr>
					<th>NO</th>
					<th>NIP</th>
					<th>NAMA</th>
					<th>INSTANSI</th>
					<th>PELAKSANA</th>
					<th rowspan="2">JENIS DOKUMEN</th>
					<th rowspan="2">JUMLAH</th>
					'; 
		$html 	.= '</tr>';
		if($query->num_rows() > 0){
			$i = 1;		        
			foreach ($query->result() as  $k => $r) {
			   	$html .= "<tr><td>$i</td>";
				$html .= "<td class=str>{$r->nip}</td>";
				$html .= "<td>{$r->nama}</td>";
				$html .= "<td>{$r->nama_instansi}</td>";	
				$html .= "<td>{$this->_get_nama($r->id_pelaksana)}</td>";
				$dms_scan  = $this->_get_dmsScan($r->id);
				foreach ($dms_scan->result()  as $value)
				{
					$html .= "<tr><td></td><td></td><td></td><td></td><td></td><td>".$value->jenis_doc."</td><td>".$value->jumlah."</td></tr>";
				}
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
	
	function _get_nama($id)
	{
	   $sql="SELECT * FROM app_user WHERE dms_user='$id' ";
	   $row   = $this->db1->query($sql)->row();
	   return $row->nama;
	   
	   
	   
	}
	
	function _get_dmsScan($id)
	{
	   $sql="SELECT * FROM dms_scan WHERE id_dms_nip='$id' ";
	   $query  = $this->db1->query($sql);
	   
	   return $query;
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
	    
		$sql="SELECT dms_user,nama FROM app_user where 1=1 $sql_limit_user  AND level != 'kasie' ORDER BY nama ASC";
		
		return $this->db1->query($sql);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */