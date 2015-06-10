<?php

$conn = sqlsrv_connect("SP2014P01SN", ["Database" => "GPS"]);//, "UID" => "php", "PWD" => "Goodtech1234"]);

$stmt = sqlsrv_query($conn, "SELECT TOP 20 tagID, Tagname, AlarmCount FROM almTag ORDER BY AlarmCount DESC");

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
{
	echo '(' . $row['tagID'] . ') ' . $row['Tagname'] . ' - ' . $row['AlarmCount'] . '<br>';
}

?>