<?php

	session_start();

	require_once 'IDatabase.php';
	require_once 'SQLServerDriver.class.php';
	require_once 'Session.class.php';


	$dsn = ['server' => "SP2014P01SN",
			'options' => ["Database" => "GPS"]];

	$db = new DB\SQLServerDriver($dsn);
	$db->connect();

	$loginMethod = Login\Session::NoLogin;
	$s = new Login\Session();

	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action)
	{
		case 'logout':
			$s->logout();
			break;

		default: 

			break;

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="assets/css/bootstrap.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-theme.css" />

	<script src="assets/js/jquery-2.1.4.js"></script>
	<script src="assets/js/moment.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootstrap.datetimepicker.min.js"></script>
	<script src="assets/highcharts/js/highcharts.js"></script>

	<script>
		$(document).ready(function() {
			$.getJSON("top20.php", function(data) {
				$("#chartContainer").highcharts({
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

</head>

<body>
<header>
	<nav class="navbar navbar-default" style="border-bottom-color: #FF8000; ">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="/projects/gpsalarm">Alarmalizer</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
						<?= $_SESSION['userDisplayName']; ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Innstillinger</a></li>
						<li class="divider"></li>
						<?php if ($s->isAutheticated()) : ?>
						<li><a href="?action=logout">Logg ut</a></li>
						<?php else : ?>
						<li><a href="?action=login">Logg inn</a></li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>
<div class="well" style="margin-top: 0;">
	<div class="row">
		<div class="col-xs-2 col-md-1">
			<label>Area</label>
			<select class="form-control">
				<option>All</option>
				<option>Area 1</option>
				<option>Area 2</option>
				<option>Area 3</option>
				<option>Area 4</option>
			</select>
		</div>
		<div class="col-xs-2 col-md-1">
			<label>Selection</label>
			<select class="form-control">
				<option>All</option>
				<option>Area 1</option>
				<option>Area 2</option>
				<option>Area 3</option>
				<option>Area 4</option>
			</select>
		</div>
	</div>
	</div>
<div class="container-fluid">

	<div class="row">

		<?php require_once 'Widget.Col2.tpl.php'; ?>

		<div class="col-xs-12">
			<?php		

				if (isset($_SESSION['userDisplayName']))
				{
					//echo '<a class="btn btn-default" href="?action=logout">Logg ut</a>';
				}
				else if (isset($_POST['btnSubmit']) || $loginMethod == Login\Session::NoLogin)
				{
					$s->login($db, $loginMethod);
				}
				else if (isset($_GET['action']) && $_GET['action'] == 'login')
				{		
					$s->renderLogin($loginMethod);
					//$s->login(new DB\Database(), Login\Session::DomainLogin);
				}
			?>

		<div id="chartContainer"></div>

		<h2>Topp 20</h2>
		<table class="table table-striped table-bordered table-condensed table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Tagname</th>
				<th>AlarmCount</th>
				<th>DailyAverage</th>			
				<th>PercentOfTotal</th>
			</tr>
		</thead>
		<tbody>
		<?php

			//$conn = sqlsrv_connect("SP2014P01SN", ["Database" => "GPS"]);//, "UID" => "php", "PWD" => "Goodtech1234"]);

			$db->query("SELECT TOP 20 tagID, Tagname, AlarmCount, DailyAverage, ROUND(PercentOfTotal*100, 2) AS PercentOfTotal FROM almTag ORDER BY AlarmCount DESC");
			//$stmt = sqlsrv_query($conn, "SELECT TOP 20 tagID, Tagname, AlarmCount, DailyAverage, ROUND(PercentOfTotal*100, 2) AS PercentOfTotal FROM almTag ORDER BY AlarmCount DESC");

			//while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
			$i = 1;
			while ($row = $db->fetch())
			{
				echo '<tr><td>' . $i . '</td><td>' . $row['Tagname'] . '</td><td>' . $row['AlarmCount'] . '</td><td>' . $row['DailyAverage'] . '</td><td>' . $row['PercentOfTotal'] . '</td></tr>';
				$i++;
			}
			$db->freeStmt();
			//sqlsrv_free_stmt($stmt);
			//sqlsrv_close($conn);

		?>
		</tbody>
		</table>

		<?php //require_once 'Charts.Column.tpl.php'; ?>
		</div>
	</div>
</div>

</body>
</html>
<?php $db->close(); ?>