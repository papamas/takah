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
                    <!-- Form Elements -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Pencatatan Pegawai Negeri Sipil Pindah Wilayah Kerja
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
								       <form method="post" action="<?php echo site_url()?>/pindah/save/" data-toggle="validator" class="" role="form">
									    <div class="form-group row">
                                        	<label class="control-label col-md-2">Pilih:</label>
												<div class="col-md-10">
												<input type="radio" required value="1" name="pengalihan" id="pengalihan1" checked />&nbsp;Pengalihan Guru
												<input type="radio" required value="2"  name="pengalihan" id="pengalihan2" />&nbsp;Normal
                                                </div>  
										</div>
										<div class="form-group row">
                                            <label class="control-label col-md-2">Instansi Asal:</label>
                                            <div class="col-md-10">
											<select name="instansi_asal" id="instansi_asal" required class="form-control select2" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($instansi->result() as $value):?>
												<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('instansi_asal')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
                                                <?php endforeach?>
												
											</select>											 
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
										
										<div class="form-group row">
                                            <label class="control-label col-md-2">Instansi Tujuan:</label>
                                            <div class="col-md-10">
											<select name="instansi_tujuan" id="instansi_tujuan" required class="form-control select2" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($instansi->result() as $value):?>
												<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('instansi_tujuan')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
                                                <?php endforeach?>
												
											</select>											 
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
										<div class="form-group row">
										    <label class="control-label col-md-2">NIP:</label>
                                            <div  class="col-md-6 no_nip">
											<select name="nip" required id="nip" class="form-control" >
											<option value="">--Silahkan Pilih--</option>											
										    </select>				
											</div>   
											<label class="control-label col-md-1">Status:</label>
											<div class="col-md-3">
											<input type="radio"  value="1" name="status_nip" id="status_nip"  />&nbsp;NIP tidak ditemukan											
											</div>
										</div>	
										<div class="form-group row">									
                                            <label class="control-label col-md-2">TMT:</label>
                                            <div class="col-md-4">
											<div class='input-group date' id='datetimepicker2'>
												<input pattern="^\d{2}\-\d{1,2}\-\d{4}$" type='text' required name="tmt" id="tmt" value="" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
											</div>											            
                                           <span class="help-block with-errors"></span>
										   </div>
										    <label class="control-label col-md-1 col-md-offset-1">No SK :</label>
                                            <div class="col-md-4">
											<input type="text" id="no_sk" required name="no_sk" class="form-control">
											</div> 		
										</div>
										<div class="form-group row">
										    <label class="control-label col-md-2">Tanggal SK:</label>
                                            <div class="col-md-4">
											<div class='input-group date' id='datetimepicker1'>
												<input pattern="^\d{2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_sk" id="tgl_sk" value="" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
											</div>											            
                                           <span class="help-block with-errors"></span>
										   </div>	                                          	
										</div>
										 <div class="form-group row">
                                            <label class="control-label col-md-2">Keterangan:</label>
                                            <div class="col-md-10">
											<textarea name="keterangan" class="form-control" rows="3" id="keterangan"></textarea>
											</div>
                                        </div>
                                        
                                       <div class="form-group">
									     <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
                                        
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