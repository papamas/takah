<!-- Date Picker-->
<script src="<?php echo base_url()?>assets/js/moment-with-locales.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/select2/select2.full.min.js"></script>
<script>	
$(document).ready(function(){ 

    $(".select2").select2();
	
	$("#petugas").hide();
	$('#batas').hide();
	
		
    $("input[name$='perintah']").click(function() {
        var p = $(this).val();
		//console.log(p);
		if(p == 1)
		{	   
			$('#startlist').removeAttr('required');
			$('#endlist').removeAttr('required');
			$('#batas').hide();
			$("#petugas").hide();
			$("#pelaksana").removeAttr('required');
		}
		
		if(p == 2)
		{	   
			
			$('#startlist').prop('required',true);
			$('#endlist').prop('required',true);
			$('#batas').show();
			$("#petugas").hide();
			$("#pelaksana").removeAttr('required');
			
		}
		
		if(p == 3)
		{	   
			
			$('#startlist').prop('required',true);
			$('#endlist').prop('required',true);
			$('#batas').show();
			$("#petugas").show();
			$("#pelaksana").prop('required',true);
			
		}
		
		
    }); 
	
	
});
</script>

