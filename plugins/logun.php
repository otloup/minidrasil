<?php

	class logunPlugin {

		private $oDB = null;

		public function __construct ($oDB){
			if(is_a($oDB, 'mysql')){
				$this->oDB = $oDB;
			}
			else{
				die('execute is not a mysql class');
			}

			require_once(PLUGINS_DIR.'logun/LogunForm.php');
		}

		public function form($sName, $sAction = null, $sType = null, $aAttributes = [], $aConfig = []){
			return new LogunForm($sName, $sAction, $sType, $aAttributes, $aConfig);
		}

	}

?>
