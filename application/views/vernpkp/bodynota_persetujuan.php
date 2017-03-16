 <div id="wrapper">
         <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
           <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <hr />              
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Pencatatan Nota Persetujuan Kenaikan Pangkat berdasarkan database SAPK
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
								       <form method="post" action="<?php echo site_url()?>/vernpkp/jalankan/" data-toggle="validator" class="form-vertikal" role="form">
																
										<div class="form-group row">
                                            <label class="control-label col-md-2">Instansi:</label>
                                            <div class="col-md-9">
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
                                             <label class="control-label col-md-2">TMT:</label>
                                           	<div class="col-md-1">
												<input name="tmt_tgl" required class="form-control" value="01" disabled />
											</div>
											<div class="col-md-2">
												<select name="tmt_bln" class="form-control">
												   <option value="04" <?php if($this->session->userdata('tmt_bln')=='04') echo 'selected="selected"'?> >April</option>
												   <option value="10" <?php if($this->session->userdata('tmt_bln')=='10') echo 'selected="selected"'?> >Oktober</option>
												</select>
											</div>
											<div class="col-md-2">
											<input name="tmt_thn" value="<?php echo $this->session->userdata('tmt_thn');?>" required pattern="^[0-9]+$" maxlength="4" class="form-control"  placeholder="2015" />
											    
											</div>
										</div>	
										
										 <div class="form-group row">
										    <label class="control-label col-md-2">Status:</label>
											<div class="col-md-5">
												<input type="radio" required value="1" name="status" id="status1"  <?php if($this->session->userdata('status')== '1') echo 'checked' ?>/>&nbsp;Sudah dikerjakan
												<input type="radio" required value="2" name="status" id="status2" <?php if($this->session->userdata('status')== '2') echo 'checked' ?>/> &nbsp;Belum dikerjakan
											    <input type="radio" required value="3" name="status" id="status3" <?php if($this->session->userdata('status')== '3') echo 'checked' ?> />&nbsp;Semua
										
											</div>	
										 </div>
										 <div class="form-group row">
                                            <label class="control-label col-md-2">Jenis KP:</label>
                                            <div class="col-md-9">
											<select name="jeniskp"  class="form-control select2" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($jenis_kp->result() as $value):?>
												<option value="<?php echo $value->JKP_JPNKOD?>"  <?php if($this->session->userdata('jenis_kp')== $value->JKP_JPNKOD) echo 'selected="selected"'?>  ><?php echo $value->JKP_JPNNAMA?></option>
                                                <?php endforeach?>
												
											</select>
											 
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
										<div class="form-group row">
											<label class="control-label col-md-2">Perintah:</label>
											<div class="col-md-5">
												<input type="radio" required value="1" name="perintah" id="perintah1"  <?php if($this->session->userdata('perintah')== '1') echo 'checked' ?>/>&nbsp;Hitung Jumlah
												<input type="radio" required value="2" name="perintah" id="perintah2" <?php if($this->session->userdata('perintah')== '2') echo 'checked' ?> />&nbsp;Lihat Listing
												<input type="radio" required value="3" name="perintah" id="perintah3" <?php if($this->session->userdata('perintah')== '3') echo 'checked' ?> />&nbsp;Cetak Listing
											</div>										
										 </div> 
                                         
                                       <div class="form-group">
									    <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-cog"></i>&nbsp; Jalankan Perintah</button>
										</div>
										
										<?php if($show_jml):?>
										<div class="form-group row">
										<label class="control-label col-md-12">Berdasarkan Data Mirror SAPK Update : <?php echo $create_time ?> , Jumlah NPKP : <?php echo number_format($jumlah->num_rows(),0,' ','.')?></label>
										</div>
										<?php endif;?>

                                    </form>
									
									<?php if($lihat):?>
									<hr/>
									<form method="post" action="<?php echo site_url()?>/vernpkp/simpanmultiple/" data-toggle="validator" class="form-vertikal" role="form">
										
									<table class="table table-striped">
										  <thead>
											  <tr>
												  <th>No</th>
												  <th>NIP</th>
												  <th>Nama</th>
												  <th>Jenis</th>
												  <th>Golongan</th> 
												  <th>No.LG</th>
												  <!--<th>Tgl.LG</th>-->
												  <th>TMT</th>
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
											 <?php $i=1;?>
											<?php foreach ($record->result() as $value):?>
											<tr>
												<td><?php echo anchor_popup(site_url().'/vernpkp/note/'.$value->id,$i, $atts);?></td>
												<td  width="150"><?php echo anchor_popup(site_url().'/vernpkp/history/'.$value->PKI_NIPBARU,$value->PKI_NIPBARU, $atts);?></td>
												<td width="250"><?php echo $value->PNS_PNSNAM?></td>
												<td width="150"><?php echo $value->JKP_JPNNAMA?></td>
												<td class="center"><?php echo $value->GOL_LAMA?> - <?php echo $value->GOL_BARU?></td>          
												<td><?php echo $value->NOTA_PERSETUJUAN_KP?></td>
												<!--<td><?php echo $value->TGL_NPKP?></td>-->
												<td><?php echo $value->TMT_GOL?></td>
												<td align="center">
												<input type="checkbox" value="<?php echo $value->PKI_NIPBARU?>" <?php if($value->status_npkp)  echo "checked"; ?> class="checkbox-npkp" name="nip[]"/> </td>
											    <input style="display:none" type="checkbox" value="<?php echo $value->PNS_INSDUK?>" <?php if($value->kode_instansi)  echo "checked"; ?> id="instansi<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="kode_instansi[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->TMT_GOL?>" <?php if($value->tmt)  echo "checked"; ?> id="tmt<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="tmt[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->NOTA_PERSETUJUAN_KP?>" <?php if($value->no_lg)  echo "checked"; ?> id="nolg<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="nolg[]"/> </td>
												<input style="display:none" type="checkbox" value="<?php echo $value->TGL_NPKP?>" <?php if($value->tgl_lg)  echo "checked"; ?> id="tgllg<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="tgllg[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->PKI_GOLONGAN_LAMA_ID?>" <?php if($value->gol_lama_id)  echo "checked"; ?> id="gollama<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="gollama[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->PKI_GOLONGAN_BARU_ID?>" <?php if($value->gol_baru_id)  echo "checked"; ?> id="golbaru<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="golbaru[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->PNS_TEMKRJ?>" <?php if($value->lokasi_kerja)  echo "checked"; ?> id="lokasi_kerja<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="lokasi_kerja[]"/> </td>
									            <input style="display:none" type="checkbox" value="<?php echo $value->JKP_JPNKOD?>" <?php if($value->jenis_kp)  echo "checked"; ?> id="jenis_kp<?php echo $value->PKI_NIPBARU?>" class="checkbox-npkp" name="jenis_kp[]"/> </td>
									            
									            
											</tr>
											<?php $i++;endforeach?>
										  </tbody>																			  
									</table>
									<hr/>
								    <div class="col-md-offset-8">
										<?php echo $pagination?>
									</div>
									<hr/>
									<div class="form-group row" style="display:none">
                                             <label class="control-label col-md-2">TMT:</label>
                                           	<div class="col-md-1">
												<input name="tmt_tgl" required class="form-control" value="01" disabled />
											</div>
											<div class="col-md-2">
												<select name="tmt_bln" class="form-control">
												   <option value="04" <?php if($this->session->userdata('tmt_bln')=='04') echo 'selected="selected"'?> >April</option>
												   <option value="10" <?php if($this->session->userdata('tmt_bln')=='10') echo 'selected="selected"'?> >Oktober</option>
												</select>
											</div>
											<div class="col-md-2">
											<input name="tmt_thn" value="<?php echo $this->session->userdata('tmt_thn');?>" required pattern="^[0-9]+$" maxlength="4" class="form-control"  placeholder="2015" />
											    
											</div>
										</div>	
										
										 <div class="form-group row " style="display:none">
										    <label class="control-label col-md-2">Status:</label>
											<div class="col-md-5">
												<input type="radio" required value="1" name="status" id="status1"  <?php if($this->session->userdata('status')== '1') echo 'checked' ?>/>&nbsp;Sudah dikerjakan
												<input type="radio" required value="2" name="status" id="status2" <?php if($this->session->userdata('status')== '2') echo 'checked' ?>/> &nbsp;Belum dikerjakan
											    <input type="radio" required value="3" name="status" id="status3" <?php if($this->session->userdata('status')== '3') echo 'checked' ?> />&nbsp;Semua
										
											</div>	
										 </div>
										 <div class="form-group row" style="display:none">
                                            <label class="control-label col-md-2">Jenis KP:</label>
                                            <div class="col-md-9">
											<select name="jeniskp"  class="form-control select2" >
                                                <option value="">--Silahkan Pilih--</option>
												<?php foreach($jenis_kp->result() as $value):?>
												<option value="<?php echo $value->JKP_JPNKOD?>"  <?php if($this->session->userdata('jenis_kp')== $value->JKP_JPNKOD) echo 'selected="selected"'?>  ><?php echo $value->JKP_JPNNAMA?></option>
                                                <?php endforeach?>
												
											</select>
											 
											</div>
										 <span class="help-block with-errors"> </span>	
                                        </div>
									<div class="form-group row">
                                            <label class="control-label col-md-2">Tanggal:</label>
                                            <div class="col-md-5">
											<div class='input-group date' id='datetimepicker'>
												<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' name="tgl" id="tgl" value="<?php if($this->session->userdata('tgl')) echo $this->session->userdata('tgl'); else echo date('d-m-Y')?>" class="form-control" />
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>								
											</div>											            
                                          
											<span class="help-block with-errors"></span>
									      </div>
									</div>	  
									<div class="form-group row">									       
                                            <label class="control-label col-md-2">Keterangan:</label>
                                            <div class="col-md-10">
											<textarea name="keterangan" class="form-control" rows="3"></textarea>
											</div>
                                        </div>
                                    <div class="form-group">
									    <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp; Simpan NPKP Sesuai Listing</button>
										</div>   
									</form>	
									<?php endif;?>
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