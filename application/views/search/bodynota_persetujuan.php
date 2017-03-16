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
                            Pencarian Nota Persetujuan Kenaikan Pangkat
                        </div>
                        <div class="panel-body">
						    <div class="row">
							 <form action="<?php echo site_url()?>/notapersetujuan/search/" method="post" >		   		     
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
												  <th>TMT</th>
												  <th>Aksi</th> 
												  <th>Instansi</th>												 												 
												  <th>Perintah</th>
											  </tr>
										  </thead>   
										  <tbody>
										   	<?php foreach($record->result() as $value):?>
												<tr>
												   <td><?php echo $value->tgl_in?></td>
												   <td><?php echo $value->nip?></td>
												   <td><?php echo $value->tmt_kp?></td>											   
												   <td><?php echo $value->aksi?></td>
												   <td><?php echo $value->INS_NAMINS?></td>				   
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
			<form id="form-npkp">
			    <div class="form-group row">
					<label class="control-label col-md-2">Tanggal:</label>
					<div class="col-md-4">
					<div class='input-group date' id='datetimepicker'>
						<input pattern="^\d{1,2}\-\d{1,2}\-\d{4}$" type='text' required name="tgl" id="tgl" value="<?php echo date('d-m-Y')?>" class="form-control" />
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
					<label class="control-label col-md-2">TMT:</label>
					<div class="col-md-2">
						<input name="tmt_tgl" required class="form-control" value="01" disabled />
					</div>
					<div class="col-md-3">
						<select name="tmt_bln" required id="tmt_bln" class="form-control">
						   <option value="4">April</option>
						   <option value="10">Oktober</option>
						</select>
					</div>
					<div class="col-md-2">
					<input name="tmt_thn" id="tmt_thn" value="" required pattern="^[0-9]+$" maxlength="4" class="form-control"  placeholder="2015" />
					   
					</div>
					                                                                                
				</div>
				<div class="form-group row">
				   <label class="control-label col-md-2">Aksi:</label>
						<div class="col-md-4">
						<input type="radio" required value="GABUNG" name="action" id="action1" checked />&nbsp;GABUNG
						<input type="radio" required value="SISIP"  name="action" id="action2" />&nbsp;SISIP
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
				<input type="hidden" value="" id="npkp_id" name="npkp_id">
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="update_npkp" class="btn btn-primary">Save changes</button>
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
			  <form id="frmdelnpkp">Anda Yakin Menghapus data ini?
			    <input type="hidden" value="" id="npkpdel_id" name="npkp_id">
			  </form>	
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="delete-npkp" class="btn btn-danger">OK</button>
			   </div> 
		    
		  </div>
		</div>
	</div>'
	