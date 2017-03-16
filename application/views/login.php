<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Silahkan Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link href="<?php echo base_url()?>assets/css/favicon.ico" rel="shortcut icon" type="image/x-icon">
	
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css" />
	 <link href="<?php echo base_url()?>assets/css/font-awesome.css" rel="stylesheet" />
	 <style>
	 .contact {
    text-shadow: 1px 1px 1px #0000;
}
.contact a {
    color: #3071a9;
    display: inline-block;
    font-size: 16px;
    margin-right: 12px;
    padding: 0 3px;
    text-decoration: none;
}
.contact a:hover {
    
}

.red-tooltip + .tooltip > .tooltip-inner {background-color: #f00;}
.red-tooltip + .tooltip > .tooltip-arrow { border-bottom-color:#f00; }
	 </style>
  </head>
  <body class="login">
     <div class="text-center">
        <img src="<?php echo base_url()?>assets/img/garuda2.png" class="logo-image img-responsive">
      </div>
      <p style="font-size:16px;font-weight: bold;" class="text-warning text-center">
		      APLIKASI PENGELOLAAN TATA NASKAH KEPEGAWAIAN PNS<BR/>
              BADAN KEPEGAWAIAN NEGARA KANTOR REGIONAL XI MANADO
            </p>

          <form method="post" action="<?php echo site_url()?>/login/auth/" class="form-signin" role="form">           
			<p class="text-info text-center">
               <?php echo $message;?>
            </p>
			
			<div class="form-group">
			<label for="username" class="sr-only">username</label>
				<div class="input-group"> 			
					<span class="input-group-addon">
					  <i class="fa fa-user"></i>
					</span> <input type="text" required name="username" placeholder="Username" class="form-control">
					
				</div>
			</div>
			
			<div class="form-group">
			<label for="password" class="sr-only">Password</label>
				<div class="input-group"> 				
					<span class="input-group-addon">
						<i class="fa fa-key"></i>
					</span><input type="password" required name="password" placeholder="Password" class="form-control">
				</div>
			</div>	
			<div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit"><b>LOGIN</b></button>
			</div>
          </form>
     
        
      
       <p style="font-size:16px;" class="text-info text-center">
             Copyright &copy; Nur Muhamad Holik 2015 - 2016
        </p>
		
		
    
	
	<div class="row"> 
		  <!-- .col-lg-6 -->
        <div class="col-lg-5 col-md-offset-7 contact">
          <dl class="dl-horizontal">    
              
            <dt class="text-primary">Follow Us :</dt>
            <dd>
              <a  class="red-tooltip" href="https://www.facebook.com/nurmuhamad.holik" data-toggle="tooltip" data-placement="top" data-original-title="facebook">
                <i class="fa fa-facebook-square"></i>
              </a>
              <a class="red-tooltip" href="http://twitter.com/papa_mas" rel="tooltip" data-placement="top" data-original-title="Twitter">
                <i class="fa fa-twitter-square "></i>
              </a>
              
            </dd>
          </dl>
        </div><!-- /.col-lg-6 -->
		</div>
    <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function(){
    $("a").tooltip();
});
	</script>
    </body>
</html>
