    <!-- JQUERY SCRIPTS -->
    <script src="<?php echo base_url()?>assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo base_url()?>assets/js/jquery.metisMenu.js"></script>
    
	<!-- CUSTOM SCRIPTS -->
    <script src="<?php echo base_url()?>assets/js/custom.js"></script>

	<!-- CUSTOM SCRIPTS -->
	<script src="<?php echo base_url()?>assets/js/jQueryUI/jquery-ui.custom.js"></script>
	<script src="<?php echo base_url()?>assets/js/fancytree/jquery.fancytree.js" type="text/javascript"></script>
	
	<script>	
	$(document).ready(function () {	
	  $("#preview").hide();
	  $("#tree").fancytree({
	    focus: function(event, data) {
			var node = data.node;
			
		},
		activate: function(event, data){
			var node 		= data.node
			    children	= node.children
				uuid		= node.data.href;			
			if(children == null)	
  			{
			   
				$('.progress-bar').css('width', '' + 0 + '%');
				$('.progress-bar').text( 0 + '% Complete' );
				$('.progress-bar').attr("aria-valuenow", 0);
				myApp.showPleaseWait();
				
				
				$("#file_load tbody tr").remove()				
				$.ajax({
					method:'POST',
					data:{'uuid' : uuid},
					url:'<?php echo site_url()?>/pascascanning/getDoc',
					success:function(data){
					    $("#file_load tbody").append(data);					   
					  	  
					},
					complete : function(){
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
								
								 /* if(value == 100){
								    myApp.hidePleaseWait();} */
							}
						});
						return xhr;
					}, 
							
				});
			  
			
			}
		},
		
	  
	  });
	  
	   $("#tree").show();
	   
	   $('#file_load').on('click', '.file', function() {
	        $('#preview').show();
	        var uuid = $(this).attr('id');
			var iframe = $('#frame');
		    iframe.attr('src', '<?php echo site_url()?>' + '/pascascanning/getContent/'+ uuid);
			//console.log();
	    });
	      
		var myApp;
		myApp = myApp || (function () {
			var pleaseWaitDiv = $('<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><img src="<?php echo base_url()?>assets/img/load.gif"/><label>Processing...</label></div><div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div></div></div></div></div>');
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

	