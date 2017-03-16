 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
		   <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>
           
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <hr/>	
				<div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            PascaScanning  Dokumen Kepegawaian PNS
                        </div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div id="tree">
									<?php
									if($this->uri->segment(1)==="pascascanning")
									{
									   //var_dump($pass_dms);
									   // get dms user login
										$r1 	= $this->openkm->Login($user_dms,$pass_dms);
										
										//var_dump($r1);
										$r2 	= $this->openkm->getTreeFolder('/okm:root');
										//var_dump($r2);
										$menu   = $this->openkm->buildMenu($r2); 
										$r3 	= $this->openkm->Logout(); 
									}	
									?> 

									 </div>
								</div>
								<div class="col-md-6">
								   <table class="table table-striped" id="file_load">
									<thead>
									<tr>
										 <th>FILE</th>											  
									</tr>
									</thead>
									<tbody>
									<tr><td></td></tr>
									</tbody>
							         </table> 
								</div>
							</div>
						</div>
                    </div>
					</div>
				</div>
				<div class="row" id="preview">
                   <div class="col-md-12">				
						<div class="panel panel-info">
								<div class="panel-heading">
									Preview Dokumen Kepegawaian PNS
								</div>
								<div class="panel-body">
									<iframe id="frame" style="width:100%;height:400px" >
									</iframe>
								</div>
						</div>
					</div>
				</div>	
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
		<!--
		<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-header">
            <h1>Processing...</h1>
        </div>
        <div class="modal-body">
            <div class="progress progress-striped active">
                <div class="bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>-->