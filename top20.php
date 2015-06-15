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


	$db->query("SELECT TOP 20 
					t.dTagname AS Tagname
					,SUM(t.dAlarmCount) AS AlarmCount
					,AVG(t.dAlarmCount) AS DailyAverage
					,ROUND(100*CAST(SUM(t.dAlarmCount) AS float) / CAST((SELECT SUM(AlarmCountLow+AlarmCountMedium+AlarmCountHigh+AlarmCountCritical) FROM almData) AS float), 2) AS PercentOfTotal
				FROM
				(
					SELECT
						CAST(datehour AS date) AS dDay
						,at.Tagname AS dTagname
						,SUM(AlarmCountLow+AlarmCountMedium+AlarmCountHigh+AlarmCountCritical) AS dAlarmCount
					FROM almData AS ad 
					LEFT JOIN almTag AS at 
						ON (ad.tagID = at.tagID) 
					GROUP BY CAST(datehour AS date), at.Tagname
				) AS t
				".$filter."
				GROUP BY t.dTagname
				ORDER BY AlarmCount DESC");
		//$db->query("SELECT TOP 20 tagID, Tagname, AlarmCount, DailyAverage, ROUND(PercentOfTotal*100, 2) AS PercentOfTotal FROM almTag ORDER BY AlarmCount DESC");

		while ($row = $db->fetch())
		{
			$json['categories'][] = $row['Tagname'];
			//$json['data'][] = ['y' => $row['AlarmCount'], 'tooltext' => 'Alarm count: ' . $row['AlarmCount'] . '<br>DailyAverage: N/A <br>PercentOfTotal: N/A'];
			$json['data'][] = ['y' => $row['AlarmCount'], 'tooltext' => 'Alarm count: ' . $row['AlarmCount'] . '<br>DailyAverage: ' . $row['DailyAverage'] . '<br>PercentOfTotal: ' . $row['PercentOfTotal']];
		}
		$db->freeStmt();
		$db->close();

		$json['title'] = 'Top 20 alarms';

		echo json_encode($json);

	?>