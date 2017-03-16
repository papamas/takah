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
					<div class="panel panel-primary">
						<div class="panel-heading">
							Statistik Pindah Wilayah Kerja Berdasarkan Instansi Tujuan
						</div>
						<div class="panel-body">
							<div class="col-md-7">
								<canvas id="areaChart"></canvas>
						    </div>
							<div class="col-md-5">
							  <div id="legend-area"></div>   
							</div>  
						</div>
					</div>   				
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Statistik Pindah Wilayah Kerja Berdasarkan Instansi Asal
						</div>
						<div class="panel-body">
							<div class="col-md-7">
								 <canvas id="lineChart"></canvas>
							  </div>
							<div class="col-md-5">
								<div id="legend-line" class="chart-legend"></div>    
						    </div>
						</div>
					</div>   				
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Statistik Pertumbuhan Data
						</div>
						<div class="panel-body">
							<div class="col-md-8">							
								<canvas id="pieChart" ></canvas>
							</div>
							<div class="col-md-4">
								<div id="legend"></div>
							</div>	
						</div>
					</div>   				
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Statistik Nota Persetujuan Kenaikan Pangkat
						</div>
						<div class="panel-body">
							<div class="col-md-8">							
								  <canvas id="barChart"></canvas>
							</div>
							<div class="col-md-4">
							    <div id="legend-bar"></div>
							  </div>
							
						</div>
					</div>   				
				</div>
				
				
				
				
				
				
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
                        
                 <!-- /. ROW  -->           
				</div>

             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>