 <div id="wrapper">
           <?php $this->load->view('nav_top')?>  
           <!-- /. NAV TOP  -->
           <!-- / Menu Load -->
		   <?php $this->load->view('menu')?>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                             
                 <!-- /. ROW  -->
                  <hr />
               <div class="row">
                <div class="col-md-12">
                   <!-- Advanced Tables -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             Laporan Pengadaan CPNS
                        </div>
                        <div class="panel-body">						
							<form method="post" class="" id="lapcpns" action="#">
								 <input type="hidden" name="page" id="page"/>
								 <div class="form-group row">
									<label for="inputfield3" class="col-md-2 control-label">Instansi :</label>
									<div class="col-sm-10">
									  <select name="instansi"   id="instansi" class="form-control select2" required>
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($instansi->result() as $value):?>
										<option value="<?php echo $value->INS_KODINS?>"><?php echo $value->INS_NAMINS?></option>
										<?php endforeach?>
									 </select> 

									</div>
								  </div>
								<div class="form-group row">
								    <label class="control-label col-md-2">Pelaksana Tugas:</label>
									<div class="col-md-4">
									<select name="pelaksana" id="pelaksana" class="form-control select2" required>
										<option value="">--Silahkan Pilih--</option>
										<?php foreach($pelaksana->result() as $value):?>
                                        <option value="<?php echo $value->id ?>" <?php if($this->session->userdata('pelaksana')== $value->id) echo 'selected="selected"'?>><?php echo $value->nama?></option>
                                        <?php endforeach?>										
									</select>									 
									</div>								    					 
								</div>
								<div class="form-group row">
								    <label for="inputfield2" class="col-md-2 control-label">Periode :</label>
									<div class="col-sm-4 controls">
									  <div class="input-group">
										<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  style="" name="reportrange" id="reportrange" class="form-control" value="<?php echo date('d/m/Y')?> - <?php echo date('d/m/Y')?>"/>  
									  </div>
									</div>										
								 </div>
								 <div class="form-group row">
								    <label class="control-label col-md-2">Template:</label>
									<div class="col-md-8">
									<select name="template" id="template" class="form-control select2" required>
										<option value="">--Silahkan Pilih--</option>
										<option value="<?php echo site_url()?>/cpns/laporanCetak/">Template 1 ( Printer HP 1102 PAKIKK + Blangko 2019 )</option>
										<option value="<?php echo site_url()?>/cpns2/laporanCetak/">Template 2 ( Printer HP 1102 PAKIVP + Blangko 2019 )</option>
                                      	<option value="<?php echo site_url()?>/cpns3/laporanCetak/">Template 3 ( Printer HP 1102 PAKIVP + Blangko 2018 )</option>	
										<option value="<?php echo site_url()?>/cpns4/laporanCetak/">Template 4 ( Printer HP 1102 PAKIKK + Blangko 2018 )</option>
									</select>									 
									</div>								    					 
								</div>
								 <div class="form-group row">
								   	<label class="control-label col-md-2">Perintah Cetak:</label>
									<div class="col-md-4">
										<input type="radio" required value="1" name="perintah" id="perintah1"   />&nbsp;KARIN
										<input type="radio" required value="2" name="perintah" id="perintah2" />&nbsp;DAFTAR ISI
										<input type="radio" required value="3" name="perintah" id="perintah3" checked />&nbsp;LAPORAN
									</div>	
								</div> 	
															
								<button type="submit" class="btn btn-primary btn-sm btn-block" name="print" id="print" value="print"><i class="glyphicon glyphicon-print fa fa-print"></i>&nbsp;Cetak Laporan</button>
                            </form>
	 
	                     </div>
                     </div>
					</div>
                </div>                    
           <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
	</div>	

    