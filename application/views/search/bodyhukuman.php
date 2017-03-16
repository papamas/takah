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
                            Pencarian Hukuman Disiplin Pegawai Negeri Sipil
                        </div>
                        <div class="panel-body">
						    <div class="row">
							 <form action="<?php echo site_url()?>/hukuman/search/" method="post" >		   		     
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
												  <th>Tgl</th>
												  <th>NIP</th>
												  <th>Instansi</th>
												  <th>TMT</th>
												  <th>Sampai</th>
												  <th>Tingkat</th>
												  <th>Perintah</th>
											  </tr>
										  </thead>   
										  <tbody>
										   	<?php foreach($record->result() as $value):?>
												<tr>
												   <td><?php echo $value->tgl_input?></td>
												   <td><?php echo $value->nip?></td>
												   <td><?php echo $value->INS_NAMINS?></td>	
												    <td><?php echo $value->tgl_tmt?></td>
													<td><?php echo $value->tgl_sampai?></td>
													<td><?php echo $value->tingkat?></td>
												   <td>
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
			<form id="form-hukuman">
			    <div class="form-group row">
					<label class="control-label col-md-2">Tanggal:</label>
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
				   <label class="control-label col-md-2">NIP:</label>
					<div  class="col-md-10">
					<input type="text" name="nip" required id="nip" class="form-control" >									
					</div> 	
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Instansi:</label>
					<div class="col-md-10">
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
					<label class="control-label col-md-2">TMT:</label>
					<div class="col-md-4">
					<div class='input-group date datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_tmt" id="tgl_tmt" value="" class="form-control" />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>								
					</div>											            
				   <span class="help-block with-errors"></span>
				   </div>				   	
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Sampai:</label>
					<div class="col-md-4">
					<div class='input-group date datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl_sampai" id="tgl_sampai" value="" class="form-control" />
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
						</span>								
					</div>											            
				   <span class="help-block with-errors"></span>
				   </div>
				   <label class="control-label col-md-2">Tingkat:</label>
					<div  class="col-md-4">
						<select name="tingkat" required id="tingkat" class="form-control" >
							<option value="">--Silahkan Pilih--</option>
							<option value="Ringan">Ringan</option>	
							<option value="Sedang">Sedang</option>
							<option value="Berat">Berat</option>		
						</select>				
					</div> 		
				</div>
				
				
				<div class="form-group row">
				   <label class="control-label col-md-2">Jenis Hukuman:</label>
					<div  class="col-md-10">
					<textarea name="jenis_hukuman" id="jenis_hukuman" class="form-control" rows="2"></textarea>
																		
					</div>
														            
				   <span class="help-block with-errors"></span>
				  
				</div>
				
				<input type="hidden" value="" id="hukuman_id" name="hukuman_id">
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="update_hukuman" class="btn btn-primary">Save changes</button>
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
			  <form id="frmdel-hukuman">Anda Yakin Menghapus data ini?
			    <input type="hidden" value="" id="hukumandel_id" name="hukumandel_id">
			  </form>	
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="delete-hukuman" class="btn btn-danger">OK</button>
			   </div> 
		    
		  </div>
		</div>
	</div>'
	