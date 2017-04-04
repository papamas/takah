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
                            Disposisi Surat Masuk
                        </div>
                        <div class="panel-body">
						<form method="post" action="<?php echo site_url()?>/disposisi/search/" data-toggle="validator" class="" role="form">
							<div class="form-group row">
								<label class="control-label col-md-2">Instansi:</label>
								<div class="col-md-10">
									<select name="instansi"  class="form-control select2" >
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($instansi->result() as $value):?>
										<option value="<?php echo $value->INS_KODINS?>"  <?php if($this->session->userdata('instansi')== $value->INS_KODINS) echo 'selected="selected"'?>  ><?php echo $value->INS_NAMINS?></option>
										<?php endforeach?>
										
									</select>											
									<span class="help-block with-errors"> </span>
								</div>	
                            </div>	
							<div class="form-group row">
								<label class="control-label col-md-2">Penerima Surat:</label>
								<div class="col-md-10">
								<select name="penerima"  id="penerima" class="form-control select2" >
									<option value="">--Silahkan Pilih--</option>
									<?php foreach($penerima->result() as $value):?>
								<option value="<?php echo $value->id ?>" <?php if($this->session->userdata('penerima')== $value->id) echo 'selected="selected"'?>><?php echo $value->nama?></option>
								<?php endforeach?>
								</select>										 
								<span class="help-block with-errors"> </span>
								</div>
							</div>
							<div class="form-group row">
								<label class="control-label col-md-2">Status:</label>
								<div class="col-md-5">
									<input type="radio" required value="1" name="status" id="status1"  <?php if($this->session->userdata('status')== '1') echo 'checked' ?>/>&nbsp;Sudah diterima
									<input type="radio" required value="2" name="status" id="status2" <?php if($this->session->userdata('status')== '2') echo 'checked' ?>/> &nbsp;Belum diterima
									<input type="radio" required value="3" name="status" id="status3" <?php if($this->session->userdata('status')== '3') echo 'checked' ?> />&nbsp;Semua
							
								</div>	
							 </div>
							 <button type="submit" class="btn-sm btn-block btn-primary"><i class="glyphicon glyphicon-cog"></i>&nbsp; Jalankan Perintah</button>
								
						</form>	
						<br/>
						<div class="row">
						 <form action="<?php echo site_url()?>/disposisi/search/" method="post" >		   		     
							 <div class="col-md-8 col-md-offset-2 input-group">
								  <input type="text" name="search" class="form-control" placeholder="Masukan NIP atau Nomor Surat">
								  <span class="input-group-btn">
									<button type="submit" class="btn btn-default" type="button"><i class="fa fa-search"> Search!</i></button>
								  </span>
							  </div>
						  </form>
						 </div>
						<hr/>	 
						<?php if($show && $surat_masuk->num_rows() > 0):?>
						 
						<form method="post" action="<?php echo site_url()?>/disposisi/aksimultiple/" data-toggle="validator" class="" role="form">
							
                            <div class="row">
							 <table class="table table-striped">
							  <thead>
								  <tr>
									  <th>No</th>
									  <th>NIP</th>
									  <th>Nama</th>
									  <th>Instansi</th>
									  <th>No.Surat</th>
									  <th>Tgl Surat</th>
									  <th>Jumlah</th>
									  <th>
									    <div class="btn-group">
										    <button data-toggle="dropdown" class="btn-xs btn-primary dropdown-toggle">Act<span class="caret"></span></button>
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
							    <?php foreach ($surat_masuk->result() as $value):?>
								<tr>
									<td><?php echo anchor_popup(site_url().'/disposisi/note/'.$value->id,$value->id, $ket);?></td>
									<td><?php echo anchor_popup(site_url().'/disposisi/detail/'.$value->nip,$value->nip, $det);?></td>
									<td><?php echo $value->PNS_PNSNAM?></td>
									<td width="200"><?php echo $value->INS_NAMINS?></td>
									<td><?php echo $value->nomor_surat?></td>
									<td><?php echo $value->tgl_surat?></td>
									<td><?php echo $value->jumlah_surat?></td>
									<td width="75" align="center"><input type="checkbox" value="<?php echo $value->id ?>" class="checkbox-surat" name="status_penerima[]" <?php if($value->status_penerima) echo 'checked'?>/> </td>
								</tr>
								<?php $i++;endforeach?>
                              </tbody>
							</table> 
							
							<div class="col-md-offset-8">
							 <?php echo $pagination?>
							</div> 
							<hr/>
							</div>
							    <div class="form-group row">
									<label class="control-label col-md-2">Aksi Disposisi:</label>
									<div class="col-md-9">
									<textarea name="keterangan" required class="form-control" rows="3"></textarea>
									</div>
								 </div>
								 <button type="submit" class="btn-sm btn-block btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp; Simpan Sesuai Listing</button>
								
						</form>
						<?php endif?>
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