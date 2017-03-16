 <!-- DATA TABLE SCRIPTS -->
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<!--  Date Range Picker -->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/daterange/daterangepicker.js"></script>
<script src="<?php echo base_url()?>assets/js/select2/select2.full.min.js"></script>

<script>	
	$(document).ready(function () {
	     $(".select2").select2();
		
		 
		
		 $('#reportrange').daterangepicker({
			   format: 'DD/MM/YYYY',
			   minDate: '01/04/2015',
			   locale: 'id',
			   //maxDate: '06/07/2015',
			   //dateLimit: { days: 4 }

		 });
		 
		 
	
	});
</script>

