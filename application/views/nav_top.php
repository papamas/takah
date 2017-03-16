<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>               
            </div>
			 <div style="color: white;
padding: 15px 10px 5px 10px;
float: left;
font-size: 16px;"> <i class="fa fa-home fa-fw"></i> <b>APLIKASI PENGELOLAAN TATA NASKAH KEPEGAWAIAN PNS</b> 
             
<a  href="#"></a> </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Login dengan : <i><?php echo $this->session->userdata('level')?> </i>, Last access : <?php echo $this->session->userdata('last_login')?> &nbsp;<a href="<?php echo site_url()?>/login/logout/" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->