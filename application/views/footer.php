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
	 <!-- ChartJS 1.0.1 -->
    <script src="<?php echo base_url()?>assets/js/chartjs/Chart.min.js"></script>
	<!--
	<script src="<?php echo base_url()?>assets/js/morris/morris.js"></script>
	<script src="<?php echo base_url()?>assets/js/morris/raphael-2.1.0.min.js"></script>
	-->
	<script>	
	$(document).ready(function () {	
	  $("#tree").hide();
	  $("#tree").fancytree();
	  
	  
	});
   </script>
   <?php if($this->uri->segment(1) == 'welcome'):?>
    <script>
      $(function () {
        // Vertikal Pwk masuk        
        var areaChartOptions = {
          showScale: true,
          scaleShowGridLines: true,
          scaleGridLineColor: "rgba(0,0,0,.05)",
          scaleGridLineWidth: 1,
          scaleShowHorizontalLines: true,
          scaleShowVerticalLines: true,
          bezierCurve: true,
          bezierCurveTension: 0.3,
          pointDot: false,
          pointDotRadius: 4,
          pointDotStrokeWidth: 1,
          pointHitDetectionRadius: 20,
          datasetStroke: true,
          datasetStrokeWidth: 2,
          datasetFill: false,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          maintainAspectRatio: false,
          responsive: true,
		  scaleShowLabels: true,
		  //multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
        };
		<?php if(!empty($line_chart)):?>
		var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        var areaChart = new Chart(areaChartCanvas);		
        var areaChartData = {
          labels: ['<?php echo $tahun?>'+" Q1", '<?php echo $tahun?>'+" Q2", '<?php echo $tahun?>'+" Q3",'<?php echo $tahun?>'+" Q4"],
          datasets: <?php echo $line_chart?>
		};
        var myarea = areaChart.Line(areaChartData, areaChartOptions);
		var legendarea = myarea.generateLegend();
        $("#legend-area").html(legendarea);
        <?php endif;?>
		
        // Pwk keluar
		<?php if(!empty($line_chart_asal)):?>
		var lineChartData = {
          labels: ['<?php echo $tahun?>'+" Q1", '<?php echo $tahun?>'+" Q2",'<?php echo $tahun?>'+" Q3",'<?php echo $tahun?>'+" Q4"],
          datasets: <?php echo $line_chart_asal?>
		};
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        var myline = lineChart.Line(lineChartData, lineChartOptions);		
		var legendline = myline.generateLegend();
        $("#legend-line").html(legendline);
		<?php endif;?>

        // Statistik
        var pieOptions = {
          segmentShowStroke: true,
          segmentStrokeColor: "#fff",
          segmentStrokeWidth: 2,
          percentageInnerCutout: 50, 
          animationSteps: 100,
          animationEasing: "easeOutBounce",
          animateRotate: true,
          animateScale: false,
          responsive: true,
          maintainAspectRatio: false,
		  //tooltipTemplate: "<%= value %>%",
          legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        
		<?php if(!empty($statistik)):?>
		var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
		var PieData = <?php echo $statistik?>;
        var mypie = pieChart.Doughnut(PieData, pieOptions);
		var legend = mypie.generateLegend();
        $("#legend").html(legend);
        <?php endif;?>
		
        // NPKP        
		var barChartOptions = {
          scaleBeginAtZero: true,
          scaleShowGridLines: true,
          scaleGridLineColor: "rgba(0,0,0,.05)",
          scaleGridLineWidth: 1,
          scaleShowHorizontalLines: true,
          scaleShowVerticalLines: true,
          barShowStroke: true,
          barStrokeWidth: 2,
          barValueSpacing: 5,
          barDatasetSpacing: 1,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          responsive: true,
          maintainAspectRatio: false,
		  multiTooltipTemplate: "<%= value %>"
        };
		<?php if(!empty($bar_chart)):?>
        var barChartDta = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $bar_chart?>
		};
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = barChartDta;
		barChartOptions.datasetFill = true;
        var mybar = barChart.Bar(barChartData, barChartOptions);		
		var legend = mybar.generateLegend();
        $("#legend-bar").html(legend);
		<?php endif;?>
		
		//CPNS
		<?php if(!empty($stat_cpns)):?>
		var barChartDta2 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_cpns?>
		};
        var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
        var barChart2 = new Chart(barChartCanvas2);
        var barChartData2 = barChartDta2;		      
        barChartOptions.datasetFill = true;
        var mybar2 = barChart2.Bar(barChartData2, barChartOptions);		
		var legend2 = mybar2.generateLegend();
        $("#legend-bar2").html(legend2);
		<?php endif;?>
		
		// surat
		<?php if(!empty($stat_surat)):?>
		var barChartDta3 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_surat?>
		};
        var barChartCanvas3 = $("#barChart3").get(0).getContext("2d");
        var barChart3 = new Chart(barChartCanvas3);
        var barChartData3 = barChartDta3;
		      
        barChartOptions.datasetFill = true;
        var mybar3 = barChart3.Bar(barChartData3, barChartOptions);		
		var legend3 = mybar3.generateLegend();
        $("#legend-bar3").html(legend3);
        <?php endif;?>
	    
		// BUP
		<?php if(!empty($stat_bup)):?>
	    var barChartDta4 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_bup?>
		};
        var barChartCanvas4 = $("#barChart4").get(0).getContext("2d");
        var barChart4 = new Chart(barChartCanvas4);
        var barChartData4 = barChartDta4;		      
        barChartOptions.datasetFill = true;
        var mybar4 = barChart4.Bar(barChartData4, barChartOptions);		
		var legend4 = mybar4.generateLegend();
        $("#legend-bar4").html(legend4);
        <?php endif;?>
	  
	    // HD
		<?php if(!empty($stat_hd)):?>
	    var barChartDta5 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_hd?>
		};
        var barChartCanvas5 = $("#barChart5").get(0).getContext("2d");
        var barChart5 = new Chart(barChartCanvas5);
        var barChartData5 = barChartDta5;		      
        barChartOptions.datasetFill = true;
        var mybar5 = barChart5.Bar(barChartData5, barChartOptions);		
		var legend5 = mybar5.generateLegend();
        $("#legend-bar5").html(legend5);
		 <?php endif;?>
		 
		 // Kab pwk masuk
		<?php if(!empty($line_chart_kab)): ?>
		// Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas_kab = $("#areaChart_kab").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart_kab = new Chart(areaChartCanvas_kab);
		var areaChartData_kab = {
          labels: ['<?php echo $tahun?>'+" Q1", '<?php echo $tahun?>'+" Q2", '<?php echo $tahun?>'+" Q3",'<?php echo $tahun?>'+" Q4"],
          datasets: <?php echo $line_chart_kab?>
		};
		var myarea_kab = areaChart_kab.Line(areaChartData_kab, areaChartOptions);
		var legendarea_kab = myarea_kab.generateLegend();
        $("#legend-area_kab").html(legendarea_kab);
        <?php endif;?>
		
		// pwk keluar
		<?php if(!empty($line_chart_asal_kab)): ?>
		var lineChartData_kab = {
          labels: ['<?php echo $tahun?>'+" Q1", '<?php echo $tahun?>'+" Q2",'<?php echo $tahun?>'+" Q3",'<?php echo $tahun?>'+" Q4"],
          datasets: <?php echo $line_chart_asal_kab?>
		};
        var lineChartCanvas_kab = $("#lineChart_kab").get(0).getContext("2d");
        var lineChart_kab = new Chart(lineChartCanvas_kab);
        var lineChartOptions_kab = areaChartOptions;
        lineChartOptions_kab.datasetFill = false;
        var myline_kab = lineChart_kab.Line(lineChartData_kab, lineChartOptions);		
		var legendline_kab = myline_kab.generateLegend();
        $("#legend-line_kab").html(legendline_kab);
		 <?php endif;?>
		
		// NPKP
		<?php if(!empty($bar_chart_kab)):?>
		var barChartDta_kab = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $bar_chart_kab?>
		};
        var barChartCanvas_kab = $("#barChart_kab").get(0).getContext("2d");
        var barChart_kab = new Chart(barChartCanvas_kab);
        var barChartData_kab = barChartDta_kab;		      
        barChartOptions.datasetFill = true;
        var mybar_kab = barChart_kab.Bar(barChartData_kab, barChartOptions);		
		var legend_kab = mybar_kab.generateLegend();
        $("#legend-bar_kab").html(legend_kab);
		<?php endif;?>
		
		// cpns
		<?php if(!empty($stat_cpns_kab)):?>
		var barChartDta_kab2 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_cpns_kab?>
		};
        var barChartCanvas_kab2 = $("#barChart_kab2").get(0).getContext("2d");
        var barChart_kab2 = new Chart(barChartCanvas_kab2);
        var barChartData_kab2 = barChartDta_kab2;		      
        barChartOptions.datasetFill = true;
        var mybar_kab2 = barChart_kab2.Bar(barChartData_kab2, barChartOptions);		
		var legend_kab2 = mybar_kab2.generateLegend();
        $("#legend-bar_kab2").html(legend_kab2);
		<?php endif;?>
		
		// surat
		<?php if(!empty($stat_surat_kab)):?>
		var barChartDta_kab3 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_surat_kab?>
		};
        var barChartCanvas_kab3 = $("#barChart_kab3").get(0).getContext("2d");
        var barChart_kab3 = new Chart(barChartCanvas_kab3);
        var barChartData_kab3 = barChartDta_kab3;		      
        barChartOptions.datasetFill = true;
        var mybar_kab3 = barChart_kab3.Bar(barChartData_kab3, barChartOptions);		
		var legend_kab3 = mybar_kab3.generateLegend();
        $("#legend-bar_kab3").html(legend_kab3);
        <?php endif;?>
		
		<?php if(!empty($stat_bup_kab)):?>
		var barChartDta_kab4 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_bup_kab?>
		};
        var barChartCanvas_kab4 = $("#barChart_kab4").get(0).getContext("2d");
        var barChart_kab4 = new Chart(barChartCanvas_kab4);
        var barChartData_kab4 = barChartDta_kab4;
		      
        barChartOptions.datasetFill = true;
        var mybar_kab4 = barChart_kab4.Bar(barChartData_kab4, barChartOptions);		
		var legend_kab4 = mybar_kab4.generateLegend();
        $("#legend-bar_kab4").html(legend_kab4);
         <?php endif;?>
	    
        <?php if(!empty($stat_hd_kab)):?>		
	    var barChartDta_kab5 = {
          labels: ['<?php echo date("Y")?>'],
          datasets: <?php echo $stat_hd_kab?>
		};
        var barChartCanvas_kab5 = $("#barChart_kab5").get(0).getContext("2d");
        var barChart_kab5 = new Chart(barChartCanvas_kab5);
        var barChartData_kab5 = barChartDta_kab5;		      
        barChartOptions.datasetFill = true;
        var mybar_kab5 = barChart_kab5.Bar(barChartData_kab5, barChartOptions);		
		var legend_kab5 = mybar_kab5.generateLegend();
        $("#legend-bar_kab5").html(legend_kab5);
		<?php endif;?>
		
		<?php if(!empty($statistik_kab)):?>
		var pieChartCanvas_kab = $("#pieChart_kab").get(0).getContext("2d");
        var pieChart_kab = new Chart(pieChartCanvas_kab);
		var PieData_kab = <?php echo $statistik_kab?>;		 
		var mypie_kab = pieChart_kab.Doughnut(PieData_kab, pieOptions);		
		var legend_kab = mypie_kab.generateLegend();
        $("#legend-kab").html(legend_kab);
		<?php endif;?>
		
      }); 
    </script>
	<?php endif ?>
	