<?php

	require_once 'IDatabase.php';
	require_once 'SQLServerDriver.class.php';

	//$dsn = ['server' => "SP2014P01SN",
	//		'options' => ["Database" => "GPS"]];
	$dsn = ['server' => "WIN-01D44SNDUFQ",
			'options' => ["Database" => "GPS"]];


	$db = new DB\SQLServerDriver($dsn);
	$db->connect();

		$db->query("SELECT TOP 20 tagID, Tagname, AlarmCount, DailyAverage, ROUND(PercentOfTotal*100, 2) AS PercentOfTotal FROM almTag ORDER BY AlarmCount DESC");

		while ($row = $db->fetch())
		{
			$json['categories'][] = $row['Tagname'];
			$json['data'][] = ['y' => $row['AlarmCount'], 'tooltext' => 'Alarm count: ' . $row['AlarmCount'] . '<br>DailyAverage: ' . $row['DailyAverage'] . '<br>PercentOfTotal: ' . $row['PercentOfTotal']];
		}
		$db->freeStmt();
		$db->close();

		$json['title'] = 'Top 20 alarms';

		echo json_encode($json);

	?>