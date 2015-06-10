<?php
namespace DB;

interface IDatabase
{
	public function connect();
	public function query($query);
	public function fetch();
	public function freeStmt();
	public function close();
}
?>