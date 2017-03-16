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
                            Prascanning  Dokumen Kepegawaian PNS
                        </div>
						<form method="post" action="<?php echo site_url()?>/prascanning/jalankan/" data-toggle="validator" class="form-vertikal" role="form">
						<div class="panel-body">
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
												
								<div class="form-group row">
									<label class="control-label col-md-2">Status PNS:</label>
									<div class="col-md-5">
									<select name="status" required class="form-control select2" >
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($status->result() as $value):?>
                                        <option value="<?php echo $value->KED_KEDKOD ?>" <?php if($this->session->userdata('status')== $value->KED_KEDKOD) echo 'selected="selected"'?>><?php echo $value->KED_KEDNAM?></option>
                                        <?php endforeach?>										
									</select>									 
									</div>
								 <span class="help-block with-errors"> </span>	
								</div> 
                                 <div class="form-group row" id="batas">
								    <label class="control-label col-md-2">Start Listing:</label>
                                            <div class="col-md-2">
												<input name="start"  id="startlist"  type="text" class="form-control " value="<?php echo $this->session->userdata('start')?>"  placeholder=""/>    
												<span class="help-block with-errors"></span>
                                            </div>
									<label class="control-label col-md-2">End Listing:</label>
                                            <div class="col-md-2">
												<input name="end"  id="endlist"  type="text" class="form-control " value="<?php echo $this->session->userdata('end')?>"  placeholder=""/>    
												<span class="help-block with-errors"></span>
                                            </div>
									
									
								</div>	
								<div class="form-group row">
								    <label class="control-label col-md-2">Perintah:</label>
									<div class="col-md-10">
                                        <input type="radio" required value="1" name="perintah" id="perintah1"  <?php if($this->session->userdata('perintah')== '1') echo 'checked' ?>/>&nbsp;Hitung Jumlah
										<input type="radio" required  value="2" name="perintah" id="perintah2" <?php if($this->session->userdata('perintah')== '2') echo 'checked' ?> />&nbsp;Lihat Listing
										<input type="radio" required value="3" name="perintah" id="perintah3" <?php if($this->session->userdata('perintah')== '3') echo 'checked' ?> />&nbsp;Cetak Listing
								    </div>	
                                 </div>  
								 
                                <div class="form-group row" id="petugas" style="">
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
								
								<div class="form-group">
									    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-cog"></i>&nbsp; Jalankan Perintah</button>
                                </div>
								<?php if($this->input->post()):?>
                                <div class="form-group row">
								<label class="control-label col-md-12">Berdasarkan Data Mirror SAPK Update : <?php echo $create_time ?> , Jumlah PNS yang blm masuk Pra/Scanning  : <?php echo number_format($jumlah,0,' ','.')?></label>
                                </div>
                                <?php endif;?>

																						
                        </div>
					    </form>
                         <!-- End Form Elements -->
						 <?php if($lihat):?>
						 <table class="table table-striped">
							  <thead>
								  <tr>
									  <th>NO</th>
									  <th>NIP</th>
									  <th>NAMA</th>
									  <th>INSTANSI</th>
									  <th>STATUS</th>                                          
								  </tr>
							  </thead>   
							  <tbody>
							     <?php $i=1;?>
							    <?php foreach ($record as $value):?>
								<tr>
									<td><?php echo $i?></td>
									<td><?php echo $value['PNS_NIPBARU']?></td>
									<td class="center"><?php echo $value['PNS_PNSNAM']?></td>
									<td class="center"><?php echo $value['INS_NAMINS']?></td>
									<td class="center"><?php echo $value['KED_KEDNAM']?></td>                                       
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