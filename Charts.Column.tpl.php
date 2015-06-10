<script>
	$(document).ready(function() {
		$.getJSON("top20.php", function(data) {
			$("#chartContainer2").highcharts({
				chart: {
					type: "column"
				},
				colors: ['#FF8000'],
				legend : {
					enabled: false
				},
				title: {
					text: data.title
				},
				xAxis: {
					categories: data.categories,
					labels: {
						rotation: -45
					}
				},
				yAxis: {
					title: {
						text: 'Number of alarms'
					}
				},
				tooltip: {
					headerFormat: '<span>{point.key}</span><br>',
					pointFormat: '{point.tooltext}'
				},
				series: [{name: 'Alarms', data: data.data}]
			});
		});
	}); 
</script>

<div id="chartContainer2"></div>
