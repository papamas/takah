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
	    
		var message   = '<?php echo $message?>';
		
			 if(message != '')
			 {
					var n = noty({
						text        : '<?php echo $message?>',
						type        : 'info',
						dismissQueue: false,
						layout      : 'topCenter',
						theme       : 'defaultTheme'
					});
					
					setTimeout(function () {
						$.noty.close(n.options.id); 
					}, 2000);	
             }	 
		
		
	});	
</script>

