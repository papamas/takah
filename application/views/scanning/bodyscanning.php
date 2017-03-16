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
                            Scanning  Dokumen Kepegawaian PNS
                        </div>
						<div class="panel-body">
						 <form method="post" action="<?php echo site_url()?>/scanning/jalankan/" data-toggle="validator" class="form-vertikal" role="form">
									
						   <div class="form-group row">
									<label class="control-label col-md-2">Instansi PNS:</label>
									<div class="col-md-9">
									<select name="instansi" required class="form-control select2" >
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($instansi->result() as $value):?>
                                        <option value="<?php echo $value->INS_KODINS ?>" <?php if($this->session->userdata('instansi')== $value->INS_KODINS) echo 'selected="selected"'?>><?php echo $value->INS_NAMINS?></option>
                                        <?php endforeach?>										
									</select>									 
									</div>
								 <span class="help-block with-errors"> </span>	
							</div>
							<div class="form-group row" id="petugas">
									<label class="control-label col-md-2">Pelaksana Tugas:</label>
									<div class="col-md-5">
									<select name="pelaksana" id="pelaksana" class="form-control select2" >
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($pelaksana->result() as $value):?>
                                        <option value="<?php echo $value->id ?>" <?php if($this->session->userdata('pelaksana')== $value->id) echo 'selected="selected"'?>><?php echo $value->nama?></option>
                                        <?php endforeach?>										
									</select>									 
									</div>
								 <span class="help-block with-errors"> </span>	
							</div>
							<div class="form-group row">
								    <label class="control-label col-md-2">Perintah:</label>
									<div class="col-md-10">
                                        <input type="radio" required value="1" name="perintah" id="perintah1"  <?php if($this->session->userdata('perintah')== '1') echo 'checked' ?>/>&nbsp;Hitung Jumlah
										<input type="radio" required value="2" name="perintah" id="perintah2" <?php if($this->session->userdata('perintah')== '2') echo 'checked' ?> />&nbsp;Lihat Listing
										<input type="radio" required value="3" name="perintah" id="perintah3" <?php if($this->session->userdata('perintah')== '3') echo 'checked' ?> />&nbsp;Cetak Listing
								    </div>	
                            </div>
							<div class="form-group">
									    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-cog"></i>&nbsp; Jalankan Perintah</button>
                                </div>
						    </form>
							
							<?php if($this->input->post()):?>
							<div class="form-group row">
							<label class="control-label col-md-12">Berdasarkan Data Mirror SAPK Update : <?php echo $create_time ?> , Jumlah Pra/Scanning : <?php echo number_format($record->num_rows(),0,' ','.')?></label>
							</div>
							<?php endif;?>
						</div>
						<?php if($lihat):?>
						<table class="table table-striped">
							  <thead>
								  <tr>
									  <th>NO</th>
									  <th>NIP</th>
									  <th>NAMA</th>
									  <th>INSTANSI</th>
									  <th>PELAKSANA</th>
									  <th>PRASCANNING</th>
									  <th>SCANNING</th>
								  </tr>
							  </thead>   
							  <tbody>
							     <?php $i=1;?>
							    <?php foreach ($record->result() as $value):?>
								<tr>
									<td><?php echo $i?></td>
									<td><?php echo $value->nip?></td>
									<td><?php echo $value->PNS_PNSNAM?></td>
									<td><?php echo $value->INS_NAMINS?></td>
									<td><?php echo $value->pelaksana?></td>
									<td><?php if($value->prascanning != NULL) echo '<i class="glyphicon glyphicon-check"></i>'; else  echo '<i class="glyphicon glyphicon-unchecked"></i>';?></td>
									<td><?php if($value->scanning != NULL) echo '<i class="glyphicon glyphicon-check"></i>'; else  echo '<i class="glyphicon glyphicon-unchecked"></i>';?></td>                                       
								</tr>
								<?php $i++;endforeach?>
							  </tbody>
                        </table>							  
                         <?php endif?>
                   </div>
				</div>   
            </div>
                <!-- /. ROW  -->
              
                    
                         
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>