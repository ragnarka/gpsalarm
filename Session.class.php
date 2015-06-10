<?php
namespace Login;

require_once 'NoLogin.class.php';
require_once 'StandardLogin.class.php';
require_once 'DomainLogin.class.php';
require_once 'User.class.php';

class Session
{
	const NoLogin = 0;
	const StandardLogin = 1;
	const DomainLogin = 2;

	private $user;


	public function renderLogin($loginMethod)
	{
		switch ($loginMethod) {
			case Session::StandardLogin:
				require_once 'StandardLogin.tpl.php';
				break;

			case Session::DomainLogin:
				require_once 'DomainLogin.tpl.php';
				break;

			case Session::NoLogin:
			default:
				require_once 'NoLogin.tpl.php';
				break;
			
		}
	}

	public function login(\DB\IDatabase $db, $loginMethod)
	{
		switch ($loginMethod) {
			case Session::NoLogin:
				$lm = new NoLogin();
				break;

			case Session::StandardLogin:
				$lm = new StandardLogin($db);
				break;

			case Session::DomainLogin:
				$lm = new DomainLogin($db);
				break;
			
			default:
				// Error
				break;
		}

		$this->doLogin($lm);
	}

	private function doLogin(ILogin $lm)
	{
		$user = $lm->authenticate();

		if ($user instanceof User)
		{
			$_SESSION['userDisplayName'] = $user->getDisplayName();
			header("Location: index.php");
		}
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		header("Location: index.php");
	}

	public function getUser()
	{
		return $this->user;
	}

	public function isAutheticated()
	{
		return isset($_SESSION['userDisplayName']) && $_SESSION['userDisplayName'] != 'Gjest';
	}
}
?>