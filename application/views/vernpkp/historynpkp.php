<?php $this->load->view('header')?>
<body>             
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            History Nota Persetujuan Kenaikan Pangkat
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
									  <thead>
										  <tr>
											  <th>NIP</th>
											  <th>GOLONGAN</th> 
											  <th>NO.LG</th>
											  <th>TGL.LG</th>
											  <th>TMT</th>
										  </tr>
									  </thead>   
									  <tbody>
									        <?php foreach ($record->result() as $value):?>
											<tr>
												<td><?php echo $value->PKI_NIPBARU;?></td>
												<td><?php echo $value->GOL_LAMA?> - <?php echo $value->GOL_BARU?></td>          
												<td><?php echo $value->NOTA_PERSETUJUAN_KP?></td>
												<td><?php echo $value->TGL_NPKP?></td>
												<td><?php echo $value->TMT?></td>
											</tr>
											<?php endforeach?>
										
									  </tbody>
							</table>	
									
                        </div>
                    </div>                      
                </div>
              </div>
                   
            <!-- /. ROW  -->
<?php $this->load->view('footer')?>    
<?php $this->load->view('vernpkp/js_nota_persetujuan')?> 
</body>
</html>			
              
                    
                         

            