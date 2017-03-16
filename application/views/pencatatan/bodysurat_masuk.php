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
                            Agenda Surat Masuk
                        </div>
                        <div class="panel-body">
                            <div class="row">
							<div class="col-md-12">
							
							    <form method="post" action="<?php echo site_url()?>/suratmasuk/save/" data-toggle="validator" class="" role="form">
								<div class="form-group row">
									<label class="control-label col-md-2">Instansi:</label>
									<div class="col-md-10">
										<select name="instansi" required class="form-control select2" >
											<option value="">--Silahkan Pilih--</option>
											<?php foreach($instansi->result() as $value):?>
											<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('kode_instansi')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
											<?php endforeach?>
											
										</select>											
										<span class="help-block with-errors"> </span>
									</div>	
                                </div>
								<div class="form-group row">
                                    <label class="control-label col-md-2">Nomor Surat:</label>
									<div class="col-md-4">		
									<input name="nosurat" autofocus required type="text" value="<?php if($this->session->userdata('nomor_surat')) echo $this->session->userdata('nomor_surat')?>" class="form-control "  placeholder=""/>    
									<span class="help-block with-errors"></span>
                                    </div>
									<label class="control-label col-md-2">Tangal Surat:</label>
									<div class="col-md-4">
                                        <div class='input-group date' id='datetimepicker1'>
													<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' name="tglsurat" id="tgl" value="<?php echo date('d-m-Y')?>" class="form-control" />
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
													</span>								
										</div>
									</div>	
								</div>
								<div class="form-group row">
									<label class="control-label col-md-2">Tangal Terima:</label>
									<div class="col-md-4">	
									<div class='input-group date' id='datetimepicker2'>
												<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' name="tglterima" id="tglterima" value="<?php echo date('d-m-Y')?>" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
									</div>
									</div>
									<label class="control-label col-md-2">Jumlah Surat:</label>
									<div class="col-md-4">
									<input name="jumlahsurat"  required type="text" class="form-control "  placeholder=""/>    
									<span class="help-block with-errors"></span>
									</div>
								</div>
								
								<div class="form-group row ">
									<label class="control-label col-md-2">NIP:</label>
									<div class="col-md-5 no_nip">
									<select name="nip" required id="nip" class="form-control" >
										<option value="">--Silahkan Pilih--</option>										
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>
									
									<label class="control-label col-md-1">Status:</label>
								    <div class="col-md-4">
									<input type="radio"  value="1" name="status_nip" id="status_nip"  />&nbsp;NIP tidak ditemukan
									
								    </div>	
								</div>
								
								<div class="form-group row">
									<label class="control-label col-md-2">Penerima Surat:</label>
									<div class="col-md-10">
									<select name="penerima" required id="penerima" class="form-control select2" >
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($penerima->result() as $value):?>
									<option value="<?php echo $value->id ?>" <?php if($this->session->userdata('penerima')== $value->id) echo 'selected="selected"'?>><?php echo $value->nama?></option>
									<?php endforeach?>
									</select>										 
									<span class="help-block with-errors"> </span>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="control-label col-md-2">Perihal:</label>
									<div class="col-md-10">
									<textarea name="perihal" class="form-control" rows="2"><?php if($this->session->userdata('perihal')) echo $this->session->userdata('perihal')?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-md-2">Disposisi:</label>
									<div class="col-md-10">
									    <textarea name="keterangan" class="form-control" rows="2"><?php if($this->session->userdata('keterangan')) echo $this->session->userdata('keterangan')?></textarea>
									</div>	
								</div>
								<button type="submit" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Simpan dan Disposisi</button>
                                		
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