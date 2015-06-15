<?php

	require_once 'IDatabase.php';
	require_once 'SQLServerDriver.class.php';

	$dsn = ['server' => "SP2014P01SN",
			'options' => ["Database" => "GPS"]];
	//$dsn = ['server' => "WIN-01D44SNDUFQ",
	//		'options' => ["Database" => "GPS"]];

	$db = new DB\SQLServerDriver($dsn);
	$db->connect();


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="assets/css/bootstrap.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" />
	<link rel="stylesheet" href="assets/css/reveal.css" />

	<script src="assets/js/jquery-2.1.4.js"></script>
	<script src="assets/js/reveal.js"></script>
	<script src="assets/highcharts/js/highcharts.js"></script>

	
</head>
<body>
	<div class="reveal">
		<div class="slides">
			<section>Hei</section>
			<section>
	        	<section><?php // require_once 'Widget.Col2.tpl.php'; ?></section>
				<section><?php require_once 'Charts.Column.tpl.php'; ?></section>
			</section>
		</div>
	</div>
	<script>
		Reveal.initialize({
		    // Display controls in the bottom right corner
		    controls: true,

		    // Display a presentation progress bar
		    progress: true,

		    // Display the page number of the current slide
		    slideNumber: false,

		    // Push each slide change to the browser history
		    history: false,

		    // Enable keyboard shortcuts for navigation
		    keyboard: true,

		    // Enable the slide overview mode
		    overview: true,

		    // Vertical centering of slides
		    center: true,

		    // Enables touch navigation on devices with touch input
		    touch: true,

		    // Loop the presentation
		    loop: true

		});
	</script>
</body>
</html>
<?php $db->close(); ?>