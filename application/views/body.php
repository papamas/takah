 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
		   <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>
           
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Dashboard Aplikasi</h2>   
                        <h5>Selamat Datang <b><?php echo $this->session->userdata('nama')?></b> , Senang Melihat Anda Kembali. </h5>
                    </div>
                </div> 
                <hr/>				
                 <!-- /. ROW  -->
                <div class="row"> 
				 <div class="text-center">
					<img src="<?php echo base_url()?>assets/img/garuda2.png" class="logo-image img-responsive">
				  </div>
                 <p style="font-size:16px;font-weight: bold;" class="text-center">
				  APLIKASI PENGELOLAAN TATA NASKAH KEPEGAWAIAN PNS<BR/>
				  BADAN KEPEGAWAIAN NEGARA KANTOR REGIONAL XI MANADO
				</p>
				<hr/>
				
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading bg-color-green">
							Prestasi Kinerja Seksi Pengelolaan Arsip Instansi Vertikal dan Provinsi
						</div>
						<div class="panel-body">
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($line_chart)) {?>
								<div class="col-md-6">
									<canvas id="areaChart"></canvas>
								</div>
								<div class="col-md-6">
								  <div id="legend-area" style="font-size:10px"></div>   
								</div>
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>	
							</div>							
							<div class="panel-footer text-center bg-color-red">
							   Pindah Wilayah Kerja (Masuk)								
							</div>
						</div>
						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($line_chart_asal)) {?>							
								<div class="col-md-6">
									 <canvas id="lineChart"></canvas>
								</div>
								<div class="col-md-6">
								  <div id="legend-line" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>		
							</div>							
							<div class="panel-footer text-center bg-color-blue">
							   Pindah Wilayah Kerja (Keluar)
								
							</div>
						</div>
						<div class="col-md-5">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($line_chart_asal)) {?>	
								<div class="col-md-7">
									<canvas id="barChart"></canvas>
								</div>
								<div class="col-md-5">
								  <div id="legend-bar" style="font-size:10px"></div>    
								</div>
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>		
							</div>							
							<div class="panel-footer text-center bg-color-brown">
							   Nota Persetujuan Kenaikan Pangkat								
							</div>
						</div>						
						</div>
						
						<div class="col-md-7">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_cpns)) {?>								
								<div class="col-md-6">
									<canvas id="barChart2"></canvas>
								</div>								
								<div class="col-md-6">
								  <div id="legend-bar2" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>	
							</div>							
							<div class="panel-footer text-center bg-color-orange">
							   CPNS								
							</div>
						</div>						
						</div>
						
						<div class="col-md-12">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_surat)) {?>
								<div class="col-md-6">
									<canvas id="barChart3"></canvas>
								</div>								
								<div class="col-md-6">
								  <div id="legend-bar3" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>	
							</div>							
							<div class="panel-footer text-center bg-color-fuchsia">
							   SURAT MASUK								
							</div>
						</div>						
						</div>
						
						<div class="col-md-6">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_bup)) {?>
								<div class="col-md-5">
									<canvas id="barChart4"></canvas>
								</div>								
								<div class="col-md-7">
								  <div id="legend-bar4" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>		
							</div>							
							<div class="panel-footer text-center bg-color-purple">
							   BUP								
							</div>
						</div>						
						</div>
						
						<div class="col-md-6">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_hd)) {?>
								<div class="col-md-4">
									<canvas id="barChart5"></canvas>
								</div>								
								<div class="col-md-8">
								  <div id="legend-bar5" style="font-size:9px"></div>    
								</div>
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>		
							</div>							
							<div class="panel-footer text-center bg-color-maron">
							   Hukuman Disiplin							
							</div>
						</div>						
						</div>
						
						<div class="col-md-12">
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($statistik)) {?>
								<div class="col-md-7">
									<canvas id="pieChart" ></canvas>
								</div>
								<div class="col-md-5">
								  <div id="legend"></div>  
								</div> 
							<?php } else { echo "<p class='text-center'> NO DATA</p>";}?>	
							</div>
							<div class="panel-footer text-center bg-color-red">
							  Statistik Pertumbuhan Data								
							</div>
						</div>
						</div>					    
					</div>		 
					</div>				  				
				</div>
				<hr/>
				
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-info">
						<div class="panel-heading bg-color-green">
							Prestasi Kinerja Seksi Pengelolaan Arsip Instansi Kabupaten dan Kota
						</div>
						
						<div class="panel-body">
						<div class="panel no-boder">
							<div class="panel-body">
								<?php if(!empty($line_chart_kab)){?>
								    <div class="col-md-6">								
									<canvas id="areaChart_kab"></canvas>
									</div>
									<div class="col-md-6">
									  <div id="legend-area_kab" style="font-size:10px"></div>   
									</div> 
								<?php } else { echo "<p class=text-center>NO DATA</p>";}?> 				
							</div>							
							<div class="panel-footer text-center bg-color-red">
							   Pindah Wilayah Kerja (Masuk)								
							</div>
						</div>
						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($line_chart_asal_kab)){?>
								<div class="col-md-6">								    
									 <canvas id="lineChart_kab"></canvas>									
								</div>
								<div class="col-md-6">
								  <div id="legend-line_kab" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?> 				
							</div>							
							<div class="panel-footer text-center bg-color-blue">
							   Pindah Wilayah Kerja (Keluar)
							</div>
						</div>
						
						<div class="col-md-12">
						<div class="col-md-5">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($bar_chart_kab)) {?>
								<div class="col-md-7">								
								<canvas id="barChart_kab"></canvas>
								</div>
								<div class="col-md-5">
								  <div id="legend-bar_kab" style="font-size:10px"></div>    
								</div>
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?> 								 
							</div>							
							<div class="panel-footer text-center bg-color-brown">
							   Nota Persetujuan Kenaikan Pangkat								
							</div>
						</div>						
						</div>
						
						<div class="col-md-7">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_cpns_kab)) {?>
								<div class="col-md-5">
									<canvas id="barChart_kab2"></canvas>
								</div>								
								<div class="col-md-7">
								  <div id="legend-bar_kab2" style="font-size:9px"></div>    
								</div> 
							</div>	
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?> 	
							<div class="panel-footer text-center bg-color-orange">
							   CPNS								
							</div>
						</div>						
						</div>						
                       </div>
						
						<div class="col-md-12">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_surat_kab)){?>
								<div class="col-md-6">
									<canvas id="barChart_kab3"></canvas>
								</div>								
								<div class="col-md-6">
								  <div id="legend-bar_kab3" style="font-size:10px"></div>    
								</div>
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?>
							</div>							
							<div class="panel-footer text-center bg-color-fuchsia">
							   SURAT MASUK								
							</div>
						</div>						
						</div>
						
						<div class="col-md-6">						
						<div class="panel no-boder">
							<div class="panel-body">
							 <?php if(!empty($stat_bup_kab)){?>   
								<div class="col-md-5">
									<canvas id="barChart_kab4"></canvas>
								</div>								
								<div class="col-md-7">
								  <div id="legend-bar_kab4" style="font-size:10px"></div>    
								</div> 
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?>	
							</div>							
							<div class="panel-footer text-center bg-color-purple">
							   BUP								
							</div>
						</div>						
						</div>
						
						<div class="col-md-6">						
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($stat_hd_kab)){?>   							
								<div class="col-md-4">
									<canvas id="barChart_kab5"></canvas>
								</div>								
								<div class="col-md-8">
								  <div id="legend-bar_kab5" style="font-size:9px"></div>    
								</div> 
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?>		
							</div>							
							<div class="panel-footer text-center bg-color-maron">
							   Hukuman Disiplin							
							</div>
						</div>						
						</div>
						
						<div class="col-md-12">
						<div class="panel no-boder">
							<div class="panel-body">
							<?php if(!empty($statistik_kab)){?>   	
								<div class="col-md-7">
									<canvas id="pieChart_kab" ></canvas>
								</div>
								<div class="col-md-5">
								  <div id="legend-kab"></div>  
								</div> 
							<?php } else { echo "<p class=text-center>NO DATA</p>";}?>		
							</div>
							<div class="panel-footer text-center bg-color-red">
							  Statistik Pertumbuhan Data								
							</div>
						</div>
						</div>						    
					</div>		 
					</div>					  				
				</div>
				<!--
			    
				<p style="font-size:18px;font-weight: bold;" class="text-center">
					INFORMASI TERKINI
				</p>
				<div class="col-md-12 col-sm-12 col-xs-12">                     
                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="danger">
                                            <th>NO</th>
                                            <th>INFORMASI</th>
                                            <th>KETERANGAN</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tempatkan PNS sesuai dengan UNIT KERJANYA dengan fitur PINDAH KOLEKTIF</td>
                                            <td>e-PUPNS</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>SK KP/Pensiun golongan IV/c ke atas mulai Januari 2015 ditandatangani oleh Kepala BKN</td>
                                            <td>KP-PENSIUN</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Materi Sosialisasi e-PUPNS untuk Instnasi Pusat dan Instnasi Daerah</td>
                                            <td>e-PUPNS</td>
                                            
                                        </tr>
										<tr>
                                            <td>4</td>
                                            <td>Berkas BTL paling lambat selama 10 hari kerja</td>
                                            <td>KP</td>
                                            
                                        </tr>
										<tr>
                                            <td>5</td>
                                            <td>Daftar status pengusulan penetapan NIP CPNS 2014</td>
                                            <td>PENGADAAN</td>
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                  -->    
                 <!-- /. ROW  -->           
				</div>

             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>