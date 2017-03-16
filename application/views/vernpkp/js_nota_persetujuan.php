 <!-- DATA TABLE SCRIPTS -->
<script src="<?php echo base_url()?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url()?>assets/js/dataTables/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<!-- Date Picker-->
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/select2/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/js/noty/packaged/jquery.noty.packaged.js"></script>
<script>	
	$(document).ready(function () {	
	    $(".select2").select2();
		
		var message   = '<?php echo $message?>';
		
			 if(message != '')
			 {
					var n = noty({
						text        : '<?php echo $message?>',
						type        : 'success',
						dismissQueue: false,
						layout      : 'topCenter',
						theme       : 'defaultTheme'
					});
					
					setTimeout(function () {
						$.noty.close(n.options.id); 
					}, 2000);	
             }				 
			 
		$('#datetimepicker').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		});
		
		$('#check').on('click',function(){
            //alert(this);
		   $('.checkbox-npkp').prop('checked',true);
		   
		});
		
		$('#uncheck').on('click',function(){
            //alert(this);
		   $('.checkbox-npkp').prop('checked',false);
		});
		
		$('.checkbox-npkp').on('click',function(){
            //alert(this);
			var nip = this.value;
		    if(this.checked)
			{
			   $('#instansi'+nip).prop('checked',true);
			   $('#tmt'+nip).prop('checked',true);
			   $('#nolg'+nip).prop('checked',true);
			   $('#tgllg'+nip).prop('checked',true);
			   $('#gollama'+nip).prop('checked',true);
			   $('#golbaru'+nip).prop('checked',true);
			   $('#lokasi_kerja'+nip).prop('checked',true);
			   $('#jenis_kp'+nip).prop('checked',true);
			}
			else
			{
			   $('#instansi'+nip).prop('checked',false);
			   $('#tmt'+nip).prop('checked',false);
			   $('#nolg'+nip).prop('checked',false);
			   $('#tgllg'+nip).prop('checked',false);
			   $('#gollama'+nip).prop('checked',false);
			   $('#golbaru'+nip).prop('checked',false);
			   $('#lokasi_kerja'+nip).prop('checked',false);
			   $('#jenis_kp'+nip).prop('checked',false);
			}
		   
		});
		
		
	});	
</script>

