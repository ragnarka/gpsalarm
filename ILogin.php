<?php

namespace Login;

interface ILogin
{
	public function authenticate();
	public function authorize();
}

?>