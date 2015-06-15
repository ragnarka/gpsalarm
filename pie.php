<?php

	require_once 'IDatabase.php';
	require_once 'SQLServerDriver.class.php';

	$dsn = ['server' => "SP2014P01SN",
			'options' => ["Database" => "GPS"]];
	//$dsn = ['server' => "WIN-01D44SNDUFQ",
	//		'options' => ["Database" => "GPS"]];

	$filter = '';

	if (isset($_GET['f'])) {
		$startDate 	= (isset($_GET['sd'])) ? $_GET['sd'] : '';
		$endDate 	= (isset($_GET['ed'])) ? $_GET['ed'] : '';

		if (!$startDate == '' && !$endDate == '')
		{
			$filter = "WHERE datehour between '" . $startDate . "' and '" . $endDate . "'";
		}
	}


	$db = new DB\SQLServerDriver($dsn);
	$db->connect();

	$db->query("SELECT 
					SUM(AlarmCountLow) AS Low
					,SUM(AlarmCountMedium) AS Medium
					,SUM(AlarmCountHigh) AS High
					,SUM(AlarmCountCritical) AS Critical 
				FROM almData " . $filter);

	$row = $db->fetch();
	$json['name'] = 'Alarm percentage';
	$json['data'] = [
						['name' => 'Low'		, 'y' => $row['Low']], 
						['name'	=> 'Medium'		, 'y' => $row['Medium']], 
						['name' => 'High'		, 'y' => $row['High']],
						['name' => 'Critical'	, 'y' => $row['Critical'], 'sliced' => true, 'selected' => true]
					];
	$db->freeStmt();
	$db->close();

	$json['title'] = '';

	echo json_encode($json);

	?>