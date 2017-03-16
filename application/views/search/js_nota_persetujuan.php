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
		
		
		$('#myModal').on('show.bs.modal',function(event){
		    $('.msg').text(''); 
		    var id= $(event.relatedTarget).data('id');			
			$.ajax({
			    url: "<?php echo site_url()?>/notapersetujuan/get_npkp",
				dataType:'json',
				type:'POST',
				data:{npkp_id:id},
				success: function(result){                  				
                    $("#npkp_id").val(result[0].id);
					$("#tgl").val(result[0].tgl_in);
					$("#tmt_thn").val(result[0].tmt_thn);
					$('[name=tmt_bln]').val(result[0].tmt_bln );
					$('[name=instansi]').val(result[0].kode_instansi);
					$('[name=nip]').val(result[0].nip);
					//$('[name=action]').removeAttr("checked");
					$('input[name=action][value='+result[0].aksi+']').prop('checked',true);
				},				
			});			
			
			
		});
		
		// event delete
		$("#update_npkp").on("click",function(){
		    $('.msg').text('Updating Please Wait.....')
                     .removeClass( "text-green")
				     .addClass( "text-blue" );  
					 
			var data = $('#form-npkp').serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/notapersetujuan/update",
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
			$('.msg-del').text(' '); 
			//console.log(id);
            $("#npkpdel_id").val(id);			
						
		});
		
		$("#delete-npkp").on("click",function(){
		    $('.msg-del').text('Deleting Please Wait.....')
			             .removeClass( "text-green")
				         .addClass( "text-blue" ); 
						 
			var data = $('#frmdelnpkp').serialize();
			$.ajax({
				type: "POST",
				url : "<?php echo site_url()?>/notapersetujuan/delete",
				data: data,
				success: function(){
					$('.msg-del').text('Deleted Succesfully.....')
                                 .removeClass( "text-blue")
				                 .addClass( "text-green" ); 					
				}, // akhir fungsi sukses
		    });
			return false;
		});
		
		
	});	
</script>

