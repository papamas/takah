 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
           <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			<div class="panel panel-primary">
                        <div class="panel-heading">
                            Pencarian Arsip Digital PNS
                        </div>
                        <div class="panel-body">
						   
							 <form action="<?php echo site_url()?>/scanning/search/" method="post" >		   		     
								 <div class="col-md-8 col-md-offset-2 input-group">
									  <input type="text" name="search" required class="form-control" placeholder="Masukan NIP ">
									  <span class="input-group-btn">
										<button type="submit" class="btn btn-default" type="button"><i class="fa fa-search"> Search!</i></button>
									  </span>
								  </div>
							  </form>
							 </div>
							 
			</div>
		    <?php if($search):?>
			<?php if (count($pupns) > 0 ):?>
			<div class="row">
			<div class="col-md-4">
 
              <!-- Profile Image -->
              <div class="box box-info">
                <div class="box-body box-profile">
                  <img alt="User profile picture" src="<?php echo base_url(); ?>assets/img/<?php if($pupns->PNS_PNSSEX == 2) {echo "avatar3.png";} else {echo "avatar5.png";}?>" class="profile-user-img img-responsive img-circle">
                  <h3 class="profile-username text-center"><?php echo $pupns->PNS_PNSNAM?></h3>
                  <p class="text-muted text-center"><?php echo $pupns->GOL_PKTNAM?> - <?php echo $pupns->GOL_GOLNAM?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>NIP</b> <a class="pull-right"><?php echo $pupns->PNS_NIPBARU?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Kelamin</b> <a class="pull-right"><?php if($pupns->PNS_PNSSEX == 2) {echo "WANITA";} else {echo "PRIA";}?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Lahir</b> <a class="pull-right"><?php echo $pupns->LAHIR?></a>
                    </li>
					<li class="list-group-item">
                      <b>Status</b> <a class="pull-right"><?php echo $pupns->KED_KEDNAM?></a>
                    </li>
					<li class="list-group-item">
                      <b>Lokasi</b> <a class="pull-right"><?php echo $pupns->LOK_LOKNAM;?></a>
                    </li>
                  </ul>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>  
			<div class="col-md-8">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#activity" aria-expanded="true">Data Utama</a></li>
                  <li class=""><a data-toggle="tab" href="#timeline" aria-expanded="false">Pendidikan</a></li>
				   <li class=""><a data-toggle="tab" href="#unor" aria-expanded="false">Posisi & Jabatan</a></li>
                </ul>
                <div class="tab-content">
                  <div id="activity" class="tab-pane active">
					  <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
						  <b>Gelar Depan</b> <span class="pull-right"><?php echo $pupns->PNS_GLRDPN?></span>
						</li>
						<li class="list-group-item">
						  <b>Gelar Belakang</b> <span class="pull-right"><?php echo $pupns->PNS_GLRBLK?></span>
						</li>
						<li class="list-group-item">
						  <b>Pendidikan Terakhir</b> <span class="pull-right"><?php echo $pupns->DIK_NAMDIK?></span>
						</li>
						<li class="list-group-item">
						  <b>Golongan Awal</b> <span class="pull-right"><?php echo $pupns->GOL_AWAL?></span>
						</li>
						<li class="list-group-item">
						  <b>TMT CPNS</b> <span class="pull-right"><?php echo $pupns->CPNS?></span>
						</li>
						<li class="list-group-item">
						  <b>TMT PNS</b> <span class="pull-right"><?php echo $pupns->PNS?></span>
						</li>
						<li class="list-group-item">
						  <b>Jenis Pegawai</b> <span class="pull-right"><?php echo $pupns->JPG_JPGNAM?></span>
						</li>
						<li class="list-group-item">
						  <b>Jenis Jabatan</b> <span class="pull-right"><?php echo $pupns->JJB_JJBNAM?></span>
						</li>
						<li class="list-group-item">
						  <b>Instansi Kerja</b> <span class="pull-right"><?php echo $pupns->INSKER?></span>
						</li>
						<br/>
						<form action="<?php echo site_url()?>/scanning/createFolder" method="post">
						<div class="form-group row">
							<input type="hidden" name="instansi" value="<?php echo $pupns->INSKER?>" />
							<input type="hidden" name="nip" value="<?php echo $pupns->PNS_NIPBARU?>" />	          
						</div>
						
						<div class="form-group">
						 <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-cog"></i>&nbsp;Create DMS Folder</button>
						
					    </div>
						</form>
						
					  </ul>
                  </div><!-- /.tab-pane -->
                  <div id="timeline" class="tab-pane ">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      
					  <?php foreach($pendidikan->result() as $value):?>
					  <li class="time-label">
                        <span class="bg-green">
                          Tahun <?php echo $value->PEN_TAHLUL;?>
                        </span>
                      </li>
                      <li>
                        <i class="fa fa-fw fa-graduation-cap bg-aqua"></i>
                        <div class="timeline-item">
                          <h3 class="timeline-header no-border"><a href="#"><?php echo $value->DIK_NMDIK?></a> </h3>
                        </div>
                      </li>
					  <?php endforeach;?>
                      <!-- END timeline item -->
                      
                    </ul>
                  </div><!-- /.tab-pane -->
				  <div id="unor" class="tab-pane">
					  <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
						  <b>Jabatan</b> <span class="pull-right"><?php echo $unor->JBF_NAMJAB?></span>
						</li>
						
						<li class="list-group-item">
						  <b>Unit Organisasi</b> <span class="pull-right"><?php echo $unor->UNO_NAMUNO?></span>
						</li>						
						<li class="list-group-item">
						  <b>Unit Organisasi Induk</b> <span class="pull-right"><?php echo $unor->UNO_INDUK?></span>
						</li>
						
					  </ul>
                  </div><!-- /.tab-pane -->

                 
            </div>
			</div><!-- /.nav-tabs-custom -->           
			</div>
			</div>
			<div class="row">
                    <div class="pull-left col-md-4 col-sm-12 col-xs-12">                   
						<div class="chat-panel panel panel-default chat-boder chat-panel-head" >
							<div class="panel-heading">
								File Browser
							</div>
							<div class="panel-body tree" style="height:70%;overflow-y:auto">
								 <?php echo $children;?>
							</div>
						</div>
                    </div>	 
					
					<div class="col-md-8 col-sm-12 col-xs-12">                   
						<div class="panel panel-default" >
							<div class="panel-heading">
								File Preview
							</div>
							<div class="panel-body" style="height:750px;">
								<iframe id="frame" style="width:100%;height:100%" >
								</iframe>
							</div>
						</div>
                    </div>	 
			</div>
			<?php endif;?>
			<?php endif;?>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
		
	