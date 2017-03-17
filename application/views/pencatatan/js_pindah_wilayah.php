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
        
		$('#status_nip').click(function() {
		   var input_nip = '<br/><input type="text" required value="" name="tnip" id="tnip" class="form-control "  placeholder=""  />';
								
		   $('.no_nip').append(input_nip);
		   $('#nip').removeAttr('required');
		   $('#nip').hide();
		});
		
		
		$("#nip").change(function(){
		    myApp.showPleaseWait();
			$('.progress-bar').css('width', '' + 0 + '%');
			$('.progress-bar').text( 0 + '% Complete' );
			$('.progress-bar').attr("aria-valuenow", 0);
			var pilih = $('input[name=pengalihan]:checked').val();
				
            $.ajax({
			    url: "<?php echo site_url()?>/pindah/get_pengalihan",
				dataType:'json',
				type:'POST',
				data:{nip:this.value,pilih:pilih},
				success: function(result){
				    //console.log(result);
					$("#no_sk").val(result[0].nomor_sk);
					$("#tgl_sk").val(result[0].tgl_sk);
					$("#tmt").val(result[0].tmt);
					$("#instansi_asal").val(result[0].kode_instansi).trigger('change');
					$("#instansi_tujuan").val(result[0].PNS_INSKER).trigger('change');
					$("#keterangan").val(result[0].keterangan);
					setTimeout(function() {myApp.hidePleaseWait();	} , 1000);						
		        },
				xhr: function() {
						var xhr = new window.XMLHttpRequest();
						xhr.addEventListener('progress', function(e) {
							if (e.lengthComputable) {
							    var value = (100 * e.loaded / e.total);
								$('.progress-bar').css('width', '' + value + '%');
								$('.progress-bar').text( value + '% Complete' );
								$('.progress-bar').attr("aria-valuenow", value);
								
							}
						});
						return xhr;
					}, 
			});			
		  
		});
		
		var myApp;
		myApp = myApp || (function () {
			var pleaseWaitDiv = $('<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><img src="<?php echo base_url()?>assets/img/load.gif"/><label> Processing...</label></h2></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div></div></div></div></div>');
			return {
				showPleaseWait: function() {
					pleaseWaitDiv.modal('show');
				},
				hidePleaseWait: function () {
					pleaseWaitDiv.modal('hide');
				},	

			};
		})();  
		

		
	});	
</script>

