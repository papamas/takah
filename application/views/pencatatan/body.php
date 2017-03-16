 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
           <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php echo $this->load->view('vwelcome');?>                
                 <!-- /. ROW  -->
                  <hr />
				 
					 <div class="row"><a href="<?php echo site_url()?>/prestasikerja/">
						 <div class="col-md-6">	  
						  <div class="panel panel-back noti-box">
							<span class="icon-box bg-color-blue set-icon">
								<i class="fa fa-bell"></i>
							</span>
							<div class="text-box" >
								<p class="main-text"><?php echo $npkp_today->num_rows()?> Baru</p>
								<p class="text-muted">Pencatatan NPKP hari ini</p>
							</div>
							
						 </div>	 
						</div> </a>			 
					 </div>
				
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Pencatatan Kenaikan Pangkat
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
								       <form method="post" action="<?php echo site_url()?>/notapersetujuan/save/" data-toggle="validator" class="form-horizontal" role="form">
									    <?php if($this->input->post()):?>
										<?php echo $message?>
										<?php endif;?>
										<div class="form-group ">
                                            <label class="control-label col-md-3">Tanggal:</label>
                                            <div class="col-md-5">
											<div class='input-group date' id='datetimepicker'>
												<input pattern="^\d{4}\-\d{1,2}\-\d{1,2}$" type='text' name="tgl" id="tgl" value="<?php if($this->session->userdata('tgl')) echo $this->session->userdata('tgl'); else echo date('Y-m-d')?>" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
												</span>								
											</div>											            
                                            <?php echo form_error('tgl', '<span class="label label-danger"> ', '</span>'); ?>
											<span class="help-block with-errors"></span>
										</div>
										
										</div>
										<div class="form-group">
                                            <label class="control-label col-md-3">Instansi:</label>
                                            <div class="col-md-9">
											<select name="instansi" required class="form-control" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($instansi->result() as $value):?>
												<option value="<?php echo $value->id_instansi?>"  <?php if($this->session->userdata('instansi')== $value->id_instansi) echo 'selected="selected"'?>  ><?php echo $value->nama_instansi?></option>
                                                <?php endforeach?>
												
											</select>
											 <?php echo form_error('instansi', '<span class="label label-danger"> ', '</span>'); ?>
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
                                        <div class="form-group form-group-md">
                                            <label class="control-label col-md-3">NIP:</label>
                                            <div class="col-md-9">
											<input name="nip" autofocus required pattern="^[0-9]+$" maxlength="18" data-minlength="18" type="text" class="form-control "  placeholder="198105122015031001"/>                                            
                                            <?php echo form_error('nip', '<span class="label label-danger"> ', '</span>'); ?>
									
											</div>
										<span class="help-block with-errors"></span>
										</div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">TMT:</label>
                                           	<div class="col-md-2">
												<input name="tmt_tgl" required class="form-control" value="01" disabled />
											</div>
											<div class="col-md-4">
												<select name="tmt_bln" class="form-control">
												   <option value="04" <?php if($this->session->userdata('tmt_bln')=='04') echo 'selected="selected"'?> >April</option>
												   <option value="10" <?php if($this->session->userdata('tmt_bln')=='10') echo 'selected="selected"'?> >Oktober</option>
												</select>
											</div>
											<div class="col-md-3">
											<input name="tmt_thn" value="<?php echo $this->session->userdata('tmt_thn');?>" required pattern="^[0-9]+$" maxlength="4" class="form-control"  placeholder="2015" />
											    <?php echo form_error('tmt_thn', '<span class="label label-danger"> ', '</span>'); ?>
										
											</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Pilih:</label>
												<div class="col-md-9">
												<input type="radio" value="1" name="action" id="action1" checked />&nbsp;GABUNG
												<input type="radio" value="2" name="action" id="action2" />&nbsp;SISIP
                                                </div>                                                                                  
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-md-3">Keterangan:</label>
                                            <div class="col-md-9">
											<textarea name="keterangan" class="form-control" rows="3"></textarea>
											</div>
                                        </div>
                                        
                                       <div class="col-md-9 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Simpan</button>
                                        <button type="reset" class="btn btn-danger"><i class="glyphicon glyphicon-floppy-remove"></i>&nbsp;Reset</button>
									   </div>
                                    </form>
                                    
                  
    </div>
                                
                                
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
                <!-- /. ROW  -->
              
                    
                         
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>