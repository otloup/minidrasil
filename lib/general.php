<?php

	class general {

		public static function clearUrl($sUrl){
			$sUrl = strtolower($sUrl);

			preg_match('#([a-z0-9-_./:]*)#', $sUrl, $aMatches);
			return $aMatches[1];		
		}

		public static function clearPost(){
			require_once(LIB_DIR.'mysql.php');
			$db = new mysqlDb();
			$aPost = array();
			if(!empty($_POST)){
				foreach($_POST as $key=>$val){
					$aPost[$key] = $db->escape($val);
				}
			}

			return $aPost;
		}
	}

?>
