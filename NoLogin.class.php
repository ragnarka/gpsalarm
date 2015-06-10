<?php

namespace Login;

require_once 'ILogin.php';

class NoLogin implements ILogin
{
	public function __construct()
	{

	}
	public function authenticate()
	{
		return new User('Gjest');
	}

	public function authorize()
	{
		return true;
	}
}
?>