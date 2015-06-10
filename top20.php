<?php


		$conn = sqlsrv_connect("SP2014P01SN", ["Database" => "GPS"]);//, "UID" => "php", "PWD" => "Goodtech1234"]);

		$stmt = sqlsrv_query($conn, "SELECT TOP 20 tagID, Tagname, AlarmCount, DailyAverage, ROUND(PercentOfTotal*100, 2) AS PercentOfTotal FROM almTag ORDER BY AlarmCount DESC");

		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
		{
			$json['categories'][] = $row['Tagname'];
			$json['data'][] = ['y' => $row['AlarmCount'], 'tooltext' => 'Alarm count: ' . $row['AlarmCount'] . '<br>DailyAverage: ' . $row['DailyAverage'] . '<br>PercentOfTotal: ' . $row['PercentOfTotal']];
		}
		sqlsrv_free_stmt($stmt);
		sqlsrv_close($conn);

		$json['title'] = 'Top 20 alarms';

		echo json_encode($json);

	?>