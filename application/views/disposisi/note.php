<?php $this->load->view('header')?>
<body>             
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Aksi dari disposisi Surat Masuk
                        </div>
                        <div class="panel-body">
						     <div class="row">
                                <div class="col-md-12">
								    <form method="post" action="<?php echo site_url()?>/disposisi/aksi/" data-toggle="validator" class="form-vertikal" role="form">
									    <div class="form-group row">
                                            <label class="control-label col-md-2">No Agenda:</label>
                                           	<div class="col-md-10">
												<input name="noagenda" required class="form-control" value="<?php echo $record->id?>" readonly  />
											</div>
										</div>
                                         <div class="form-group row">
                                            <label class="control-label col-md-2">Keterangan:</label>
                                            <div class="col-md-9">
											<textarea name="keterangan" class="form-control" rows="3"><?php echo $record->action_disposisi?></textarea>
											</div>
                                        </div>
										<button type="submit" class="btn-sm btn-block btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp; Simpan</button>
										
									</form>
								</div>
							</div>	
								
                        </div>
                    </div>                      
                </div>
              </div>
                   
            <!-- /. ROW  -->
<?php $this->load->view('footer')?>    
<?php $this->load->view('vernpkp/js_nota_persetujuan')?> 
</body>
</html>			
              
                    
                         

            