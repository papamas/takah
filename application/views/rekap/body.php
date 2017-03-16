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
                             Laporan Capaian  Kinerja
     					 </div>
                        <div class="panel-body">
						
<div>
<form method="post" class="" action="<?php echo site_url()?>/capaiankinerja/cetak/">
 <div class="form-group row">
	<label for="inputfield3" class="col-md-2 control-label">Instansi :</label>
	<div class="col-sm-10">
	  <select name="instansi"   id="instansi" class="form-control select2" >
		<option value="">--Silahkan Pilih--</option>
		<?php foreach($instansi->result() as $value):?>
		<option value="<?php echo $value->INS_KODINS?>"><?php echo $value->INS_NAMINS?></option>
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
		<label class="control-label col-md-2">Aksi:</label>
			<div class="col-md-4">
				<input type="radio" required value="SISIP" name="aksi" id="aksi1"  />&nbsp;Sisip
				<input type="radio" required value="GABUNG" name="aksi" id="aksi2" />&nbsp;Gabung
				<input type="radio" value=" " name="aksi" id="aksi2" checked />&nbsp; Semua
			</div>
		<label class="control-label col-md-1">Seksi:</label>
			<div class="col-md-4">
				<input type="radio" required value="1" name="seksi" id="seksi1"  checked />&nbsp;Vertikal/Provinsi
				<input type="radio" required value="2" name="seksi" id="seksi2"  />&nbsp;Kabupaten/Kota
			</div>	
		
	</div> 	
    <div class="form-group row" id="petugas" style="">
		<label class="control-label col-md-2">Pelaksana Tugas:</label>
		<div class="col-md-10">
		<select name="pelaksana" id="pelaksana" class="form-control select2" >
			<option value="">--Silahkan Pilih--</option>
			<?php foreach($pelaksana->result() as $value):?>
			<option value="<?php echo $value->id ?>" <?php if($this->session->userdata('pelaksana')== $value->id) echo 'selected="selected"'?>><?php echo $value->nama?></option>
			<?php endforeach?>										
		</select>									 
		</div>
	 <span class="help-block with-errors"> </span>	
	</div> 
	
	<button type="submit" class="btn btn-primary btn-sm btn-block" name="print" id="print" value="print"><i class="glyphicon glyphicon-print fa fa-print"></i>&nbsp;Cetak Laporan</button>

</form>
</div>
