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
                            Pencarian Peminjaman Tata Naskah
                        </div>
                        <div class="panel-body">
						    <div class="row">
							 <form action="<?php echo site_url()?>/pinjam/search/" method="post" >		   		     
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
												  <th>Tgl Pinjam</th>
												  <th>Takah PNS</th>
												  <th>Instansi</th>		
												  <th>Peminjam</th>
												  <th>Pelaksana</th>
												  <th>Status</th>
												  <th>Perintah</th>
											  </tr>
										  </thead>   
										  <tbody>
										   	<?php foreach($record->result() as $value):?>
												<tr>
												   <td><?php echo $value->tgl_input?></td>
												   <td><?php echo $value->PNS_PNSNAM?><br/><?php echo $value->nip_pns?></td>
												   <td><?php echo $value->INS_NAMINS?></td>	
												   <td><?php echo $value->NamaPeminjam?><br/><?php echo $value->nip_peminjam?></td>
												   <td><?php echo $value->nama?></td>
												   <td align="center"><?php echo ($value->tgl_kembali ? '&#10004;' : '&#10007;')?></td>
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
			<form id="form-pinjam">
			    <div class="form-group row">
				   <label class="control-label col-md-4">NIP Yang Menerima:</label>
					<div  class="col-md-8">
					<input type="text" name="nip_yang_menerima" required id="nip_yang_menerima" class="form-control" >									
					</div> 	
				</div>
				<div class="form-group row">
				   <label class="control-label col-md-4">NIP Yang Menyerahkan:</label>
					<div  class="col-md-8">
					<input type="text" name="nip_yang_menyerahkan" required id="nip_yang_menyerahkan" class="form-control" >									
					</div> 	
				</div>
				<input type="hidden" value="" id="update_id" name="update_id">
			</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="update_pinjam" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
	</div>	
	
	<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	   <div class="modal-dialog">
	      <div class="modal-content">
		      <div class="modal-header">
		        <h4 class="modal-title" id="myModalLabel"><span class="msg-del"></span></h4>
			  </div>	
		      <div class="modal-body">
			  <form id="frmdel-pinjam">Anda Yakin Menghapus data ini?
			    <input type="hidden" value="" id="pinjamdel_id" name="pinjamdel_id">
			  </form>	
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="delete-pinjam" class="btn btn-danger">OK</button>
			   </div> 
		    
		  </div>
		</div>
	</div>'
	