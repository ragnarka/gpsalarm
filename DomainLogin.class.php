<?php

namespace Login;

require_once 'ILogin.php';

class DomainLogin implements ILogin
{
	private $db;

	public function __construct(\DB\IDatabase $db)
	{
		$this->db = $db;
	}

	public function authenticate()
	{
		return new User('Process\Ragnar');
	}

	public function authorize()
	{

	}
}

?>