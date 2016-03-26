<?php

	class accessPlugin {

    private $oCookie = null;
    private $aUserCookie = null;
    private $oDb = null;
    private $bLogged = false;

		const DB_NAME = 'plugin_access';
    const USER_STATUS_INACTIVE = 0;
    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_SUSPENDED = 2;
    
    const USER_COOKIE_NAME = 'login';

		private $oDB = null;
		private $iParentModule = 0;

		public function __construct ($oDB){
			if(is_a($oDB, 'mysql')){
				$this->oDB = $oDB;
			}
			else{
				die('execute is not a mysql class');
			}
		}

		public function handleAccess($iRequiredAccessLevel){
			if(empty($_SESSION[self::USER_COOKIE_NAME])){
				return false;
			}
			else{
				return ($_SESSION[self::USER_COOKIE_NAME]['access_level'] & $iRequiredAccessLevel) > 0;
			}
		}

		public function isLogged(){
			return !empty($_SESSION[self::USER_COOKIE_NAME]);
		}

		public function login($sLogin, $sPassword){
			$sLogin = $this->oDB->escape($sLogin);
			$sPassword = $this->oDB->escape($sPassword);

			$aLoginData = $this->oDB->execute('SELECT id, email, access_level, status FROM '.self::DB_NAME.' WHERE email = "'.$sLogin.'" AND password = PASSWORD("'.$sPassword.'")', mysql::RESULT_ROW);
			$aLoginData['login'] = $sLogin;
			
			return $this->returnLoginStatus($aLoginData);
		}

		private function returnLoginStatus($aLoginData){
			$mReturnData = null;
			
			if(empty($aLoginData)){
				$mReturnData = $this->failedLogin($aLoginData);
			}
			else{
				switch($aLoginData['status']){
					case self::USER_STATUS_INACTIVE:
						$mReturnData = $this->inactiveLogin($aLoginData);
					break;

					case self::USER_STATUS_ACTIVE:
						$mReturnData = $this->successfulLogin($aLoginData);
					break;

					case self::USER_STATUS_SUSPENDED:
						$mReturnData = $this->suspendedLogin($aLoginData);
					break;
				}
			}

			return $mReturnData;
		}

		private function failedLogin($aLoginData){
			return false;
		}

		private function inactiveLogin($aLoginData){
			return false;
		}

		private function suspendedLogin($aLoginData){
			return false;
		}

		private function successfulLogin($aLoginData){
			if(empty(session_id())){
				session_start();
			}	

			$_SESSION[self::USER_COOKIE_NAME] = $aLoginData;

			return true;
		}

		public function logout(){
			unset($_SESSION[self::USER_COOKIE_NAME]);
		}

	}

?>
