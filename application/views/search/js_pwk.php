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
						type        : 'success',
						dismissQueue: false,
						layout      : 'topCenter',
						theme       : 'defaultTheme'
					});
					
					setTimeout(function () {
						$.noty.close(n.options.id); 
					}, 2000);	
             }				 
			 
		$('.datetimepicker').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		});
		
		$('#myModal').on('show.bs.modal',function(event){
		    $('.msg').text(''); 
		    var id= $(event.relatedTarget).data('id');	
			$.ajax({
			    url: "<?php echo site_url()?>/pindah/get_pwk",
				dataType:'json',
				type:'POST',
				data:{pindah_id:id},
				success: function(result){                  				
                    $("#pindah_id").val(result[0].id);
					$("#tgl_input").val(result[0].tgl_input);
					$("#no_sk").val(result[0].no_sk);
					$("#tgl_sk").val(result[0].tgl_suratkep);
					$("#tgl_tmt").val(result[0].tgl_tmt);
					$('[name=instansi_asal]').val(result[0].instansi_asal);
					$('[name=instansi_tujuan]').val(result[0].instansi_tujuan);
					$('[name=nip]').val(result[0].nip);
					
				},				
			});		
				
			
		});
		
		// event delete
		$("#update_pindah").on("click",function(){
		    $('.msg').text('Updating Please Wait.....')
			         .removeClass( "text-green")
			         .addClass( "text-blue" ); 
			
			var data = $('#form-pindah').serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/pindah/update",
				data: data,
				success: function(){
					$('.msg').text('Updated Succesfully.....')
					         .removeClass( "text-blue")
					         .addClass( "text-green" ); 			
				}, // akhir fungsi sukses
		    });
			return false;
		});
		
		$('#modalDelete').on('show.bs.modal',function(event){
		    var id= $(event.relatedTarget).data('id');
			$('#msg-del').text(' '); 
			//console.log(id);
            $("#pindahdel_id").val(id);			
						
		});
		
		$("#delete-pindah").on("click",function(){
		    $('.msg-del').text('Deleting Please Wait.....')
			             .removeClass( "text-green")
			             .addClass( "text-blue" );
						 
			var data = $('#frmdel-pindah').serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/pindah/delete",
				data: data,
				success: function(){
					$('.msg-del').text('Deleted Succesfully.....')
                                 .removeClass( "text-blue")
					            .addClass( "text-green" ); 					
				}, // akhir fungsi sukses
		    });
			return false;
		});
		
		$(".nip").select2({
		    minimumInputLength: 10,
    	    ajax: {
				url:  '<?php echo site_url() ?>'+'/pinjam/get_pns2',
				dataType:'json',
				type:'GET',							
			},
			results: function(data, page) {
			    return { results: data.results };
               // console.log(results: data.results);
				//return {results:data};
            }  
		});
		
		
	});	
</script>

