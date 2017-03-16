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
		
		
		$("#nip").change(function(){
		    myApp.showPleaseWait();
			$('.progress-bar').css('width', '' + 0 + '%');
			$('.progress-bar').text( 0 + '% Complete' );
			$('.progress-bar').attr("aria-valuenow", 0);
				
            $.ajax({
			    url: "<?php echo site_url()?>/notapersetujuan/get_npkp_data",
				dataType:'json',
				type:'POST',
				data:{nip:this.value},
				success: function(result){
				    
                    //console.log();
					$("#nolg").val(result[0].NOTA_PERSETUJUAN_KP);
					$("#tgllg").val(result[0].TGL_NOTA_PERSETUJUAN_KP);
					//$("#tmt_thn").val(result[0].TMT_THN);
					//$('[name=tmt_bln]').val(result[0].TMT_BLN );
					$('[name=gol_lama]').val(result[0].PKI_GOLONGAN_LAMA_ID); 
					$('[name=gol_baru]').val(result[0].PKI_GOLONGAN_BARU_ID);
					$("#lokasi_kerja").val(result[0].PNS_TEMKRJ);
					$("[name=jeniskp]").val(result[0].JKP_JPNKOD);
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
		
		 $("#nip").select2({
		    minimumInputLength: 7,
    	    ajax: {
				url:  '<?php echo site_url() ?>'+'/notapersetujuan/get_pns',
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
		
		$('#datetimepicker').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
		});
		
		$('#tgllgdatetime').datetimepicker({
		   sideBySide: true,
		   locale: 'id',
		   format:'DD-MM-YYYY',
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
		
		
		$("#gol_lama").change(function(){
		   var gol_baru;
		   if((this.value == '14') || (this.value == '24') || (this.value == '34') )
		   {
		        if(this.value == '14' )  gol_baru = '21';
				if(this.value == '24' )  gol_baru = '31';
				if(this.value == '34' )  gol_baru = '41';	
				

		   }
		   else
		   {
				gol_baru = parseInt(this.value) + 1;
		   }
		   //console.log(gol_baru);
           $('[name=gol_baru]').val(gol_baru); 
		});		
		
		
	});	
</script>

