<!-- Date Picker-->
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script>	
	$(document).ready(function () {	
		$('#datetimepicker').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'YYYY-MM-DD',
		 });
	});	
</script>

