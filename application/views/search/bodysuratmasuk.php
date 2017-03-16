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
                            Pencarian Surat Masuk
                        </div>
                        <div class="panel-body">
						    <div class="row">
							 <form action="<?php echo site_url()?>/suratmasuk/search/" method="post" >		   		     
								 <div class="col-md-8 col-md-offset-2 input-group">
									  <input type="text" name="search" class="form-control" placeholder="Masukan NIP ">
									  <span class="input-group-btn">
										<button type="submit" class="btn btn-default" type="button"><i class="fa fa-search"> Search!</i></button>
									  </span>
								  </div>
							  </form>
							 </div>
							 <br/>
                            <div class="row">
                                <div class="col-md-12">
								  <?php if($record->num_rows() > 0) {?>
								   <table class="table table-striped">
										  <thead>
											  <tr>
												  <th>Tgl Input</th>
												  <th>NIP</th>
												  <th>Instansi</th>
												  <th>No.Surat</th>
												  <th>Tgl Surat</th>
												  <th>Tgl Terima</th>
												  <th>Perintah</th>
											  </tr>
										  </thead>   
										  <tbody>
										   	<?php foreach($record->result() as $value):?>
												<tr>
												   <td><?php echo $value->tgl_input?></td>
												   <td><?php echo $value->nip?></td>
												   <td><?php echo $value->INS_NAMINS?></td>	
												   <td><?php echo $value->nomor_surat?></td>
												   <td><?php echo $value->tgl_sur?></td>
												   <td><?php echo $value->tgl_ter?></td>
												   <td width="100">
													<button class="btn btn-primary btn-xs" title="Edit" data-id="<?php echo $value->id?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit "></i> E</button>
													<button class="btn btn-danger btn-xs" title="Delete" data-id="<?php echo $value->id?>" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-eraser"></i> D</button>
												   </td>
												</tr>
												<?php endforeach;?>
											</tbody>																			  
									</table>
									<?php } else { echo "<p><b>Sorry ,  Data NOT FOUND</b></p>";}?>
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
		
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="900px">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><span class="msg"></span></h4>
			</div>
			<div class="modal-body">
			<form id="form-surat">
			    <div class="form-group row">
					<label class="control-label col-md-3">Tanggal:</label>
					<div class="col-md-4">
					<div class='input-group date datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_input" id="tgl_input" value="" class="form-control" />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>								
					</div>											            
				   <span class="help-block with-errors"></span>
				   </div>
				   	
				</div>
			    <div class="form-group row">
				   <label class="control-label col-md-3">NIP:</label>
					<div  class="col-md-9">
					<input type="text" name="nip" required id="nip" class="form-control" >									
					</div> 	
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3">Instansi:</label>
					<div class="col-md-9">
					<select name="instansi" required class="form-control" >
						<option value="">--Silahkan Pilih--</option>
						<?php foreach($instansi->result() as $value):?>
						<option value="<?php echo $value->INS_KODINS?>"><?php echo $value->INS_NAMINS?></option>
						<?php endforeach?>
						
					</select>											 
					</div>
				 <span class="help-block with-errors"> </span>	
				</div>
				<div class="form-group row">
				   <label class="control-label col-md-3">No.Surat:</label>
					<div  class="col-md-9">
					<input type="text" name="no_surat" required id="no_surat" class="form-control" >									
					</div>
														            
				   <span class="help-block with-errors"></span>
				  
				</div>
				<div class="form-group row">
				   <label class="control-label col-md-3">Tgl Surat:</label>
					<div class="col-md-4">
					<div class='input-group date datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_surat" id="tgl_surat" value="" class="form-control" />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>								
					</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-3">Tgl Terima:</label>
					<div class="col-md-4">
					<div class='input-group date datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_terima" id="tgl_terima" value="" class="form-control" />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>								
					</div>											            
				    </div>				   	
				</div>
				<div class="form-group row">
				   <label class="control-label col-md-3">Perihal:</label>
					<div  class="col-md-9">
					<textarea name="perihal" id="perihal" class="form-control" rows="2"></textarea>
																		
					</div>
														            
				   <span class="help-block with-errors"></span>
				  
				</div>
				
				<input type="hidden" value="" id="surat_id" name="surat_id">
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="update_surat" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
	</div>	
	
	<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-dialog">
	      <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title" id="myModalLabel"><span class="msg-del"></span></h4>
			  </div>	
		      <div class="modal-body">
			  <form id="frmdel-surat">Anda Yakin Menghapus data ini?
			    <input type="hidden" value="" id="suratdel_id" name="suratdel_id">
			  </form>	
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="delete-surat" class="btn btn-danger">OK</button>
			   </div> 
		    
		  </div>
		</div>
	</div>'
	