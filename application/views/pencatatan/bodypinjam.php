 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
           <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php //echo $this->load->view('vwelcome');?>              
                 <!-- /. ROW  -->
                  <hr />
				    
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Permintaan Salinan / Peminjaman Tata Naskah
                        </div>
                        <div class="panel-body">
                            <div class="row">
							<div class="col-md-12">							
							    <form method="post" action="<?php echo site_url()?>/pinjam/save/" data-toggle="validator" class="" role="form">
								<div class="form-group row">
									<label class="control-label col-md-2">Instansi:</label>
									<div class="col-md-10">
										<select name="instansi" id="instansi" required class="form-control select2" >
											<option value="">--Silahkan Pilih--</option>
											<?php foreach($instansi->result() as $value):?>
											<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('kode_instansi')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
											<?php endforeach?>
											
										</select>											
										<span class="help-block with-errors"> </span>
										 
									</div>	
                                </div>
								<!--
								<div class="form-group row ">
									<label class="control-label col-md-2">Dari :</label>
									<div class="col-md-7">
									<select name="dari" required id="dari" class="form-control" >
										<option value="">--Silahkan Pilih--</option>
										<option value="1">Pengelola Arsip Kepegawaian Instansi Vertikal Provinsi</option>
									    <option value="2">Pengelola Arsip Kepegawaian Instansi Kabupaten/Kota</option>
									
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>
								</div>
								-->
								<div class="form-group row ">
									<label class="control-label col-md-2">NIP:</label>
									<div class="col-md-7 no_nip">
									<select name="nip" required id="nip" class="form-control" >
										<option value="">--Silahkan Pilih--</option>										
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>				
								   
								</div>							
								<div class="form-group row">
									<label class="control-label col-md-2">Keperluan:</label>
									<div class="col-md-10">
									<textarea name="keperluan" class="form-control" rows="1"></textarea>
									</div>
								</div>
								<div class="form-group row ">
									<label class="control-label col-md-2">Peminjam:</label>
									<div class="col-md-7">
									<select name="peminjam" required id="peminjam" class="form-control" >
										<option value="">--Silahkan Pilih--</option>										
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>										                           
								</div>
								<div class="form-group row ">
								    <label class="control-label col-md-2">Nomor Handphone:</label>
									<div class="col-md-7">
									<input type="text" name="handphone" required class="form-control" />	 
									<span class="help-block with-errors"> </span>
									</div>	
									
								</div>
								<!--								
								<div class="form-group row ">
									<label class="control-label col-md-2">Mengetahui:</label>
									<div class="col-md-7">
									<select name="mengetahui" required id="mengetahui" class="form-control" >
										<option value="">--Silahkan Pilih--</option>										
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>	
									                                 
								</div>
								<div class="form-group row ">
                                    <label class="control-label col-md-2">Yang Menyerahkan:</label>
									<div class="col-md-7">
									<select name="yang_menyerahkan" required id="yang_menyerahkan" class="form-control" >
										<option value="">--Silahkan Pilih--</option>										
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>	
															
								</div>
								!-->
								<hr/>														
								 <table class="table table-striped">
								  <thead>
									<tr>
									  <th>No</th>
									  <th>Nama Dokumen</th>
									  
									  <th>
										<div class="btn-group">
										  <button data-toggle="dropdown" class="btn-xs btn-primary dropdown-toggle">Action <span class="caret"></span></button>
											  <ul class="dropdown-menu">
												<li><a href="#" id="check"><span class="glyphicon glyphicon-check"></span> Check </a></li>
												<li><a href="#" id="uncheck"><span  class="glyphicon glyphicon-unchecked"></span> Uncheck</a></li>															
											  </ul>
										</div>
									  </th>
									</tr>
								  </thead>   
								  <tbody> 
                                    <tr>
									   <td>1.</td>
									   <td>Kartu Pendaftaran Pegawai Negeri Sipil </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field1" /> </td>							
									</tr> 	
                                    <tr>
									   <td>2.</td>
									   <td>Nota Pengangkatan Pegawai Baru/CPNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field2" /> </td>							
									</tr>
									<tr>
									   <td>3.</td>
									   <td>SK Pengangkatan Pegawai Baru/CPNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field3" /> </td>							
									</tr>
									<tr>
									   <td>4.</td>
									   <td>SK Pengangkatan menjadi PNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field4" /> </td>							
									</tr>
									<tr>
									   <td>5.</td>
									   <td>Nota Persetujuan/Pertimbangan Kenaikan Pangkat </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field5" /> </td>							
									</tr>
									<tr>
									   <td>6.</td>
									   <td>SK Kenaikan Pangkat </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field6" /> </td>							
									</tr>
									<tr>
									   <td>7.</td>
									   <td>SK Pengangkatan dalam atau pemberhentian dari jabatan</td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field7" /> </td>							
									</tr>
									<tr>
									   <td>8.</td>
									   <td>SK Perpindahan Wilayah Kerja </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field8" /> </td>							
									</tr>
									<tr>
									   <td>9.</td>
									   <td>SK Perpindahan Antar Instansi </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field9" /> </td>							
									</tr>
									<tr>
									   <td>10.</td>
									   <td>SK Peninjauan Masa Kerja </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field10" /> </td>							
									</tr>
									<tr>
									   <td>11.</td>
									   <td>SK Cuti diluar Tanggungan Negara </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field11" /> </td>							
									</tr>
									<tr>
									   <td>12.</td>
									   <td>SK Hukuman Disiplin Pegawai Negeri Sipil </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field12" /> </td>							
									</tr>
									<tr>
									   <td>13.</td>
									   <td>SK Pemberian Tanda Jasa </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field13" /> </td>							
									</tr>
									<tr>
									   <td>14.</td>
									   <td>SK Peninjauan Masa Kerja </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field14" /> </td>							
									</tr>
									<tr>
									   <td>15.</td>
									   <td>SK Perbantuan kepada Pemerintah Daerah/Instansi Lain </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field15" /> </td>							
									</tr>
									<tr>
									   <td>16.</td>
									   <td>SK Pemberian Uang Tunggu </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field16" /> </td>							
									</tr>
									<tr>
									   <td>17.</td>
									   <td>SK Pemberhentian Sebagai PNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field17" /> </td>							
									</tr>
									<tr>
									   <td>18.</td>
									   <td>SK Pemberhentian Sementara </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field18" /> </td>							
									</tr>
									<tr>
									   <td>19.</td>
									   <td>SK Pengangkatan/Pemberhentian Sebagai Pejabat Negara </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field19" /> </td>							
									</tr>
									<tr>
									   <td>20.</td>
									   <td>SK Pembebasan dari Jabatan Organik karena diangkat sebagai Pejabat Negara </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field20" /> </td>							
									</tr>
									<tr>
									   <td>21.</td>
									   <td>SK Pernyataan Hilang </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field21" /> </td>							
									</tr>
									<tr>
									   <td>22.</td>
									   <td>SK kembalinya PNS yang dinyatakan hilang </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field22" /> </td>							
									</tr>
									<tr>
									   <td>23.</td>
									   <td>SK Perubahan data dasar </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field23" /> </td>							
									</tr>
									<tr>
									   <td>24.</td>
									   <td>Berita Acara Pengambilan Sumpah/Janji PNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field24" /> </td>							
									</tr>
									<tr>
									   <td>25.</td>
									   <td>SK Pemberhentian Sebagai PNS karena menjadi Anggota/Pengurus Parpol  </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field25" /> </td>							
									</tr>
									<tr>
									   <td>26.</td>
									   <td>SK Meninggal Dunia </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field26" /> </td>							
									</tr>
									<tr>
									   <td>27.</td>
									   <td>SK Mutasi Keluarga</td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field27" /> </td>							
									</tr>
									<tr>
									   <td>28.</td>
									   <td>SK Peningkatan Pendidikan </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field28" /> </td>							
									</tr>
									<tr>
									   <td>29.</td>
									   <td>SK Pendidikan dan Latihan Struktural/Fungsional </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field29" /> </td>							
									</tr>
									<tr>
									   <td>30.</td>
									   <td>SK Pensiun </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field30" /> </td>							
									</tr>
									<tr>
									   <td>31.</td>
									   <td>Pertimbangan Kenaikan Pangkat/Formulir I.E </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field31" /> </td>							
									</tr>
									<tr>
									   <td>32.</td>
									   <td>Pertimbangan Pengangkatan Pegawai Baru/Formulir I.F </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field32" /> </td>							
									</tr>
									<tr>
									   <td>33.</td>
									   <td>Nota Persetujuan Peninjauan Masa Kerja/Formulir D.3</td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field33" /> </td>							
									</tr>
									<tr>
									   <td>34.</td>
									   <td>Nota Persetujuan Mutasi Lain-lain/Formulir D.4 </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field34" /> </td>							
									</tr>
									<tr>
									   <td>35.</td>
									   <td>Nota Persetujuan Peneliti/Formulir D.12 </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field35" /> </td>							
									</tr>
									<tr>
									   <td>36.</td>
									   <td>SK Pengalihan PNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field36" /> </td>							
									</tr>
									<tr>
									   <td>37.</td>
									   <td>Surat Tanda Tamat Pendidikan dan Latihan Prajabatan </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field37" /> </td>							
									</tr>
									<tr>
									   <td>38.</td>
									   <td>Daftar Penilaian Pelaksanaan PNS </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field38" /> </td>							
									</tr>
									<tr>
									   <td>39.</td>
									   <td>Data Lainnya </td>
									   <td><input type="checkbox" value="1" class="checkbox" name="field39" /> </td>							
									</tr>
								  </tbody>
								  </table>
								  
								<button type="submit" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Simpan dan Cetak Formulir</button>
                                
								
								  		
							</form>	
							</div>					
							</div><!-- row-->                                       
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
                <!-- /. ROW  -->
              
                    
                         
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>