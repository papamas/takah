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
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas);
		
		/* var dynamicColors = function() {
			var r = Math.floor(Math.random() * 255);
			var g = Math.floor(Math.random() * 255);
			var b = Math.floor(Math.random() * 255);
			return "rgb(" + r + "," + g + "," + b + ")";
		} */

		
        var areaChartData = {
          labels: ['<?php echo $tahun?>'+" Q1", '<?php echo $tahun?>'+" Q2", '<?php echo $tahun?>'+" Q3",'<?php echo $tahun?>'+" Q4"],
          datasets: <?php echo $line_chart?>
		};

        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: false,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: false,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
		  scaleShowLabels: true,
		  //multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
        };

        //Create the line chart
        var myarea = areaChart.Line(areaChartData, areaChartOptions);
		
		var legendarea = myarea.generateLegend();
        $("#legend-area").html(legendarea);

        //-------------
        //- LINE CHART -
        //--------------
		
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

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
		var PieData = <?php echo $statistik?>
        
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
		  //tooltipTemplate: "<%= value %>%",
          //String - A legend template
          legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var mypie = pieChart.Doughnut(PieData, pieOptions);
		
		var legend = mypie.generateLegend();
        $("#legend").html(legend);

        //-------------
        //- BAR CHART -
        //-------------
		var barChartDta = {
          labels: ["Y1"],
          datasets: <?php echo $bar_chart?>
		};
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = barChartDta;
       // barChartData.datasets[1].fillColor = "#00a65a";
        //barChartData.datasets[1].strokeColor = "#00a65a";
        //barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
          //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
          scaleBeginAtZero: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: true,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - If there is a stroke on each bar
          barShowStroke: true,
          //Number - Pixel width of the bar stroke
          barStrokeWidth: 2,
          //Number - Spacing between each of the X value sets
          barValueSpacing: 5,
          //Number - Spacing between data sets within X values
          barDatasetSpacing: 1,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to make the chart responsive
          responsive: true,
          maintainAspectRatio: false,
		  multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
        };

        barChartOptions.datasetFill = true;
        var mybar = barChart.Bar(barChartData, barChartOptions);
		
		var legend = mybar.generateLegend();
        $("#legend-bar").html(legend);
      });
    </script>
	<?php endif ?>
	