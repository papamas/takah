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
                            Pencatatan Nota Persetujuan Kenaikan Pangkat Berdasarkan Barcode Dokumen
                        </div>
                        <div class="panel-body">
                            <div class="row">								
								 <form action="<?php echo site_url()?>/barcodenp/search/" method="post" >		   		     
									 <div class="col-md-8 col-md-offset-2 input-group">
										  <input type="text" name="search" class="form-control" placeholder="silahkan scan barcode" autofocus>
										  <span class="input-group-btn">
											<button type="submit" class="btn btn-default" type="button"><i class="fa fa-search"> Search!</i></button>
										  </span>
									  </div>
								  </form>							
                            </div>
                            
							
							<div class="row">
							
								<div class="col-md-12">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>NIP</th>
												<th>NAMA</th>
												<th>INSTANSI</th>
												<th>NO.LG</th>
												<th>GOL</th>
												<th>TMT</th>
												<th>KP</th>
												<th>PERINTAH</th>
											</tr>
										</thead>   
										<tbody>
										    <?php foreach($temp_kp->result() as $value):?>
										    <tr>
												<td><?php echo $value->nip?></td>
												<td><?php echo $value->PNS_PNSNAM?></td>
												<td><?php echo $value->INS_NAMINS?></td>
												<td><?php echo $value->no_lg?> </td>
												<td><?php echo $value->gol_lama?>-<?php echo $value->gol_baru?> </td>
												<td><?php echo $value->format_tmt?></td>
												<td><?php echo $value->JKP_JPNNAMA?></td>
												<td>
												   <button class="btn btn-primary btn-xs" title="Edit" data-id="<?php echo $value->idtemp_kp?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit "></i> E</button>
													<button class="btn btn-danger btn-xs" title="Delete" data-id="<?php echo $value->idtemp_kp?>" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-eraser"></i> D</button>
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
									<form action="<?php echo site_url()?>/barcodenp/save/" method="post">
									<div class="form-group">
									 <button type="submit" class="btn btn-block btn-sm btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;Simpan Semua data Nota Persetujuan Kenaikan Pangkat</button>
									</div>
									</form>	
								</div>
								<div class="col-md-12">
									<?php echo $pagination?>									
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
		<form id="frm_edit">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><span class="msg"></span></h4>
			</div>
			<div class="modal-body">
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
				<input type="hidden" value="" id="temp_id" name="temp_id">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="update_temp" class="btn btn-primary">Save changes</button>
			</div>
		</div>
		</form>
		</div>
    </div>
    </div>	
	
	<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" width="900px">
	<div class="modal-dialog">
		<form id="frm_delete">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><span class="msg-del"></span></h4>
			</div>
			<div class="modal-body">
			   Anda Yakin Menghapus data ini?
			    <input type="hidden" value="" id="tempdel_id" name="temp_id">
			 	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="delete_temp" class="btn btn-danger">OK</button>
			</div>
		</div>
		 </form>
    </div>
    </div>	
			