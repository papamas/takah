 <?php 
$menu = $this->session->userdata('seksi');
switch ($menu) {
	case "3":
		$this->load->view('menu_3');
		break;
	case "2":
		$this->load->view('menu_2');
		break;				
	default:
		$this->load->view('menu_1');
}	   
?>