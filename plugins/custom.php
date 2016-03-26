<?php

	class customPlugin {

		private $oDB = null;

		public function __construct ($oDB){
			if(is_a($oDB, 'mysql')){
				$this->oDB = $oDB;
			}
			else{
				die('execute is not a mysql class');
			}

			//do nothing
		}

		public function setParent(){}

	}

?>
