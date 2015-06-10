<?php

namespace Login;

require_once 'ILogin.php';

class StandardLogin implements ILogin
{
	private $db;

	public function __construct(\DB\IDatabase $db)
	{
		$this->db = $db;
	}

	public function authenticate()
	{
		return new User('Ragnar');
	}

	public function authorize()
	{

	}
}
?>