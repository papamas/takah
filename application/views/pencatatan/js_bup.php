<!-- Date Picker-->
<script src="<?php echo base_url()?>assets/js/select2/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/noty/packaged/jquery.noty.packaged.js"></script>
<script>	
	$(document).ready(function () {	
		$('#datetimepicker').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		 });
		 
		 $(".select2").select2();
		 
		 $("#nip").select2({
		    minimumInputLength: 7,
    	    ajax: {
				url:  '<?php echo site_url() ?>'+'/pindah/get_pns',
				dataType:'json',
				type:'GET',
				cache: "true",
				delay: 250,	
                
			},
			results: function(data, page) {
			    return { results: data.results };
               // console.log(results: data.results);
				//return {results:data};
            }  
		});
		
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
		
	});	
</script>

