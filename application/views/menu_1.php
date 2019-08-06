            <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<!--
				<li class="text-center">
                    <img src="<?php echo base_url()?>assets/img/<?php //echo $user->file?>" class="user-image img-responsive"/>
					</li>
				
				-->	
                    <li>
                        <a  class="<?php if($this->uri->segment(1)==="welcome") echo "active-menu" ?>" href="<?php echo site_url()?>/welcome/"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
					<li>
                        <a  class="<?php if($this->uri->segment(1)==="profil") echo "active-menu" ?>" href="#"><i class="fa fa-users fa-3x"></i> PNS <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
						    <li>
                                <a  href="<?php echo site_url()?>/profil/">Profil PNS</a>
                            </li>
						</ul>	
					</li>
					<li>
                        <a  class="<?php if($this->uri->segment(1)==="pascascanning" || $this->uri->segment(1)==="prascanning" || $this->uri->segment(1)==="scanning") echo "active-menu" ?>" href="#"><i class="fa fa-file fa-3x"></i> DMS <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
						    <?php if($this->session->userdata('level')== 'kasie'):?>
						    <li>
                                <a  href="<?php echo site_url()?>/prascanning/">Pra Scanning </a>
                            </li>
							<?php endif?>
							
							<li>
                                <a  href="<?php echo site_url()?>/scanning/">Scanning </a>
							</li>							
							<li><a  href="<?php echo site_url()?>/scanning/search">Search</a></li>		 
							
						</ul>	
					</li>
					
					 <li>
                        <a href="#" class="<?php if( ($this->uri->segment(1) == "pinjam" && $this->uri->segment(2) != 'laporan' ) || ($this->uri->segment(1) == "hukuman" && $this->uri->segment(2) != 'laporan' ) || ($this->uri->segment(1)==="cpns" && $this->uri->segment(2) !== 'laporan' )  || $this->uri->segment(1)==="disposisi"  || $this->uri->segment(1)==="vernpkp" || $this->uri->segment(1)==="notapersetujuan" || ($this->uri->segment(1)==="bup" && $this->uri->segment(2) != "laporan" ) || $this->uri->segment(1)==="konversinip" || ($this->uri->segment(1)==="suratmasuk" &&  $this->uri->segment(2) != 'laporan') || ($this->uri->segment(1)==="pindah"  &&  $this->uri->segment(2) != 'laporan' ) ) echo "active-menu" ?>"><i class="fa fa-edit fa-3x"></i> Pencatatan<span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level">
						    <li>
                                <a  href="#">Nota Persetujuan KP <span class="fa arrow"></span></a>
								<ul class="nav nav-third-level">
									<li>
										<a  href="<?php echo site_url()?>/notapersetujuan/">Manual</a>
									</li>
									<li>
										<a  href="<?php echo site_url()?>/barcodenp/">Barcode</a>
									</li>
									<li>
										<a  href="<?php echo site_url()?>/vernpkp/">SAPK</a>
									</li>
									<li>
										<a  href="<?php echo site_url()?>/notapersetujuan/search">Search</a>
									</li>
								</ul>	
                            </li>
							<li>
							    <a  href="#">Batas Usia Pensiun<span class="fa arrow"></span></a>
							    <ul class="nav nav-third-level">
                                   <li><a  href="<?php echo site_url()?>/bup/">PNS BUP</a></li>
								    <li><a  href="<?php echo site_url()?>/bup/search">Search</a></li>
								</ul>   
                            </li>
							
							<li>
							    <a  href="#">Pindah Wilayah Kerja<span class="fa arrow"></span></a>
							    <ul class="nav nav-third-level">
                                   <li><a  href="<?php echo site_url()?>/pindah/">Pindah</a></li>
								   <li><a  href="<?php echo site_url()?>/pindah/search">Search</a></li>
								</ul>
                            </li>
							
							<li>
                                <a  href="#">Surat Masuk <span class="fa arrow"></span> </a>
								<ul class="nav nav-third-level">
								     <?php if($this->session->userdata('level')== 'kasie'):?>
									<li>
										<a  href="<?php echo site_url()?>/suratmasuk/">Agenda</a>
									</li>
									<?php endif;?>
									<li>
										<a  href="<?php echo site_url()?>/disposisi/">Disposisi</a>
									</li>
									<li>
										<a  href="<?php echo site_url()?>/suratmasuk/search">Search</a>
									</li>
								</ul>	
                            </li>
							<li>
							    <a  href="#">CPNS <span class="fa arrow"></span> </a>
							   <ul class="nav nav-third-level">
                                   <li><a  href="<?php echo site_url()?>/cpns/">Pengadaan</a></li>
								   <li><a  href="<?php echo site_url()?>/cpns/search">Search</a></li>
								</ul>
                            </li>
							<li>
							    <a  href="#">Hukuman Disiplin <span class="fa arrow"></span> </a>
							    <ul class="nav nav-third-level">
                                    <li><a  href="<?php echo site_url()?>/hukuman/">Hukuman</a></li>
									<li><a  href="<?php echo site_url()?>/hukuman/search">Search</a></li>
								</ul>
                            </li>
							<li>
                                <a  href="#">Peminjaman Takah<span class="fa arrow"></span> </a>
								<ul class="nav nav-third-level">
								   <li> <a  href="<?php echo site_url()?>/pinjam/">Peminjaman </a></li>
								   <li> <a  href="<?php echo site_url()?>/pinjam/search">Search </a></li>
								</ul>
                            </li>
							<!--
							<li>
                                <a  href="<?php echo site_url()?>/konversinip/">Perbaikan Konversi NIP</a>
                            </li>
							-->
                         </ul>						 
					</li>
					<?php //endif;?>
					<li>
                        <a  class="<?php if(($this->uri->segment(2)==="laporan") || $this->uri->segment(1)==="dms" || $this->uri->segment(1)==="prestasikerja" || $this->uri->segment(1)==="capaiankinerja") echo "active-menu" ?>" href="#"><i class="fa fa-bar-chart-o  fa-3x"></i> Laporan<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
						    <li>
                                <a class="" href="<?php echo site_url()?>/prestasikerja/">Prestasi Kerja</a>
                            </li>
                            <li>
                                <a class="" href="<?php echo site_url()?>/suratmasuk/laporan">Surat Masuk</a>
                            </li>
							<?php if($this->session->userdata('level') == 'kasie' || $this->session->userdata('user_id') == '7'):?>
							<li>
                               
								<a href="<?php echo site_url()?>/capaiankinerja/">Rekapitulasi Capaian Kinerja</a>
                            </li>
							<?php endif;?>
							<li>
                                <a class="" href="<?php echo site_url()?>/dms/">DMS</a>
                            </li>
							<li>
							    <a  href="#">Pindah Wilayah Kerja<span class="fa arrow"></span></a>
							    <ul class="nav nav-third-level">
                                   <li><a  href="<?php echo site_url()?>/pindah/laporan">Per Instansi</a></li>
								   <li><a  href="<?php echo site_url()?>/kanreg/laporan">Per Kanreg</a></li>
								</ul>
                            </li>
							<li>
                                <a class="" href="<?php echo site_url()?>/bup/laporan">Batas Usia Pensiun</a>
                            </li>
							<li>
                                <a class="" href="<?php echo site_url()?>/cpns/laporan">CPNS</a>
                            </li>
							<li>
                                <a class="" href="<?php echo site_url()?>/hukuman/laporan">Hukuman Disiplin</a>
                            </li>
							<li>
                                <a class="" href="<?php echo site_url()?>/pinjam/laporan">Peminjaman Takah</a>
                            </li>
                        </ul>
                      </li>                   			 
                </ul>
               
            </div>
            
        </nav>  
        
