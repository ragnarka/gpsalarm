<?php

namespace Login;

class User
{
	private $firstname;
	private $lastname;
	private $username;
	private $groups;

	public function __construct($username)
	{
		$this->username = $username;
	}

	public function getDisplayName()
	{
		return $this->username;//$this->firstname . " " . $this->lastname;
	}

	public function getUsername()
	{
		return $this->username;
	}
}

?>