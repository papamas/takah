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
		
	    $('#myModal').on('show.bs.modal',function(event){
		    $('.msg').text(''); 
		    var id= $(event.relatedTarget).data('id');			
			$.ajax({
			    url: "<?php echo site_url()?>/barcodenp/get_temp",
				dataType:'json',
				type:'POST',
				data:{temp_id:id},
				success: function(result){                  				
                    $("#temp_id").val(result[0].idtemp_kp);
					$('[name=instansi]').val(result[0].kode_instansi);					
				},				
			});			
			
		});
		
		// event delete
		$("#update_temp").on("click",function(){
		    $('.msg').text('Updating Please Wait.....')
                     .removeClass( "text-green")
				     .addClass( "text-blue" );  
					 
			var data = $('#frm_edit').serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/barcodenp/update",
				data: data,
				success: function(){
					$('.msg').text('Updated Succesfully.....')
                             .removeClass( "text-blue")
				             .addClass( "text-green" ); 					
				}, // akhir fungsi sukses
				complete: function(xmlHttp) {
					window.location.replace('<?php echo site_url()?>/barcodenp');
				}
		    });
			return false;
		});
		
		$('#modalDelete').on('show.bs.modal',function(event){
		    var id= $(event.relatedTarget).data('id');
			$('.msg-del').text(' '); 
			//console.log(id);
            $("#tempdel_id").val(id);					
		});
		
		$("#delete_temp").on("click",function(){
		    $('.msg-del').text('Deleting Please Wait.....')
			             .removeClass( "text-green")
				         .addClass( "text-blue" ); 
					 
			var data = $("#frm_delete").serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/barcodenp/delete",
				data: data,
				success: function(){
					$('.msg-del').text('Deleted Succesfully.....')
                                 .removeClass( "text-blue")
				                 .addClass( "text-green" ); 					
				}, // akhir fungsi sukses
				complete: function(xmlHttp) {
					window.location.replace('<?php echo site_url()?>/barcodenp');
				} 
		    });
			return false;
		});
	});	
</script>

