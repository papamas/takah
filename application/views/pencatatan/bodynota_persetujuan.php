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
                            Pencatatan Nota Persetujuan Kenaikan Pangkat Secara Manual
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
								       <form method="post" action="<?php echo site_url()?>/notapersetujuan/save/" data-toggle="validator" class="form-vertikal" role="form">
									    
										<div class="form-group row">
                                            <label class="control-label col-md-2">Instansi:</label>
                                            <div class="col-md-10">
											<select name="instansi" required class="form-control select2" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($instansi->result() as $value):?>
												<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('instansi')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
                                                <?php endforeach?>
												
											</select>											 
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
										<div class="form-group row">
                                            <label class="control-label col-md-2">Tanggal:</label>
                                            <div class="col-md-4">
											<div class='input-group date' id='datetimepicker'>
												<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl" id="tgl" value="<?php if($this->session->userdata('tgl')) echo $this->session->userdata('tgl'); else echo date('d-m-Y')?>" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
											</div>											            
                                           <span class="help-block with-errors"></span>
										   </div>
										   <label class="control-label col-md-1">NIP:</label>
                                            <div  class="col-md-5">
											<select name="nip" required id="nip" class="form-control" >
											<option value="">--Silahkan Pilih--</option>											
										    </select>				
											</div>   
										    
										
										</div>
										
                                        <div class="form-group row">
										     <label class="control-label col-md-2">Tanggal LG:</label>
                                            <div class="col-md-4">
											<div class='input-group date' id='tgllgdatetime'>
												<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" required type='text' name="tgllg" id="tgllg" value="<?php if($this->session->userdata('tgl')) echo $this->session->userdata('tgl'); else echo date('d-m-Y')?>" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
											</div>											            
                                           <span class="help-block with-errors"></span>
										   </div>
                                            <label class="control-label col-md-1">No. LG:</label>
                                            <div class="col-md-5">
											<input type="text" id="nolg" required name="nolg" class="form-control">
											</div>                                      
                                        </div>
                                        <div class="form-group row">
										    <label class="control-label col-md-2">TMT:</label>
                                           	<div class="col-md-1">
												<input name="tmt_tgl" required class="form-control" value="01" disabled />
											</div>
											<div class="col-md-2">
												<select name="tmt_bln" required id="tmt_bln" class="form-control">
												   <option value="4"  <?php if($this->session->userdata('tmt_bln')=='04') echo 'selected="selected"'?> >April</option>
												   <option value="10"  <?php if($this->session->userdata('tmt_bln')=='10') echo 'selected="selected"'?> >Oktober</option>
												</select>
											</div>
											<div class="col-md-2">
											<input name="tmt_thn" id="tmt_thn" value="<?php echo $this->session->userdata('tmt_thn');?>" required pattern="^[0-9]+$" maxlength="4" class="form-control"  placeholder="2015" />
											   
											</div>
                                            <label class="control-label col-md-1">Pilih:</label>
												<div class="col-md-4">
												<input type="radio" required value="GABUNG" name="action" id="action1" checked />&nbsp;GABUNG
												<input type="radio" required value="SISIP"  name="action" id="action2" />&nbsp;SISIP
                                                </div>                                                                                  
                                        </div>
										<div class="form-group row">
                                            <label class="control-label col-md-2">Gol.Lama:</label>
                                            <div class="col-md-5">
											<select name="gol_lama" id="gol_lama" required class="form-control" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($golongan->result() as $value):?>
												<option value="<?php echo $value->GOL_KODGOL?>" ><?php echo $value->GOL_GOLNAM ?> - <?php  echo $value->GOL_PKTNAM?></option>
                                                <?php endforeach?>
												
											</select>											 
											</div>
										  
										    <label class="control-label col-md-1">Gol.Baru:</label>
                                            <div class="col-md-4">
											<select name="gol_baru" id="gol_baru" required class="form-control" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($golongan->result() as $value):?>
												<option value="<?php echo $value->GOL_KODGOL?>" ><?php echo $value->GOL_GOLNAM ?> - <?php  echo $value->GOL_PKTNAM?></option>
                                                <?php endforeach?>
												
											</select>											 
											</div>
										 </div>
										 <div class="form-group row">
										 <label class="control-label col-md-2">Jenis KP:</label>
                                            <div class="col-md-6">
											<select name="jeniskp"  required id="jeniskp" class="form-control" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($jenis_kp->result() as $value):?>
												<option value="<?php echo $value->JKP_JPNKOD?>" ><?php echo $value->JKP_JPNNAMA?></option>
                                                <?php endforeach?>
												
											</select>									 
											</div>
										 </div>
                                         <div class="form-group row">
                                            <label class="control-label col-md-2">Keterangan:</label>
                                            <div class="col-md-10">
											<textarea name="keterangan" class="form-control" rows="3"></textarea>
											</div>
                                        </div>
                                        <input type="hidden" id="lokasi_kerja" required name="lokasi_kerja" class="form-control">
                                       <div class="form-group">
									     <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan</button>
                                        
									   </div>
                                    </form>
									
                            </div>
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