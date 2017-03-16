<?php $this->load->view('header')?>
<body>             
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Detail Surat
                        </div>
                        <div class="panel-body">
						    <table class="table table-striped">
							  <thead>
								  <tr>
									  <th>NIP</th>
									  <th>Nama</th>
									  <th>Perihal</th>
									  <th>Disposisi</th>
									  <th>Aksi</th>									  
								 </tr>
							  </thead>
                              <tbody>
							  <?php foreach ($record->result() as $value):?>
							       <tr>
								      <td><?php echo $value->nip?></td>
									   <td><?php echo $value->PNS_PNSNAM?></td>
									  <td><?php echo $value->perihal?></td>
									   <td><?php echo $value->keterangan?></td>
									  <td><?php echo $value->action_disposisi?></td>
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
              
                    
                         

            