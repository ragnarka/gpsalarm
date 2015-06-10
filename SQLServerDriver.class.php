<?php

namespace DB;

class SQLServerDriver implements IDatabase
{
	private $dsn;
	private $connection_id;
	private $stmt;

	public function __construct($dsn)
	{
		$this->dsn = $dsn;
	}

	public function connect() 
	{
		$this->connection_id = sqlsrv_connect($this->dsn['server'], $this->dsn['options']);
	}

	public function query($query)
	{
		$this->stmt = sqlsrv_query($this->connection_id, $query);
	}

	public function fetch()
	{
		return sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC);
	}

	public function freeStmt()
	{
		sqlsrv_free_stmt($this->stmt);
	}

	public function close()
	{
		sqlsrv_close($this->connection_id);
	}

}

?>