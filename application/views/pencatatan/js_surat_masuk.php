<script src="<?php echo base_url()?>assets/js/select2/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/js/noty/packaged/jquery.noty.packaged.js"></script>
<!-- Date Picker-->
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
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
		
	    $("#nip").select2({
		    minimumInputLength: 10,
    	    ajax: {
				url:  '<?php echo site_url() ?>'+'/suratmasuk/get_pns',
				dataType:'json',
				type:'GET',							
			},
			results: function(data, page) {
			    return { results: data.results };
               // console.log(results: data.results);
				//return {results:data};
            }  
		});
		
		$('#datetimepicker1').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		 });
		 
		 $('#datetimepicker2').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		 });
		 
		$('#status_nip').click(function() {
		   var input_nip = '<input type="text" required value="" name="tnip" id="tnip" class="form-control "  placeholder=""  />';
								
		   $('.no_nip').append(input_nip);
		   $('#nip').removeAttr('required');
		   $('#nip').hide();
		});
		 
		
	});	
</script>

