<?php

	class globalUtil {

		private static $aErrors = array();

		public static function forgeJSONResponse($mResponse){
			return json_encode($mResponse);
		}

		public static function clearString($sString){
			$oDB = renderer::getLib('mysql');
			return $oDB->escape($sString);
		}

		public static function addError($sFileName, $sName, $bFlag, $sType = '', $sMsg = ''){
			self::$aErrors[$sFileName]['flags'][$sName] = $bFlag;

			if(/*!$bFlag && */(!empty($sType) && !empty($sMsg))){
				self::$aErrors[$sFileName]['messages'][$sName]['type'] = $sType;
				self::$aErrors[$sFileName]['messages'][$sName]['message'] = $sMsg;
			}
		}

		public static function checkError($sFileName, $sName){
			return self::$aErrors[$sFileName]['flags'][$sName];
		}

		public static function getErrors($sFileName){
			return self::$aErrors[$sFileName];
		}

		public static function validateEmail($sEmailAddress){
			$sEmailStandard = "(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])";

			return !!preg_match($sEmailStandard, $sEmailAddress);
		}

		public static function getSets($sType = 'page', $sMode = 'basic', $sAccess = null, $iFrom = 0, $iLimit = 0){
			$oDB = renderer::getLib('mysql');		

			$aReturn = array();
			$aQuantifiers = array();
			
			if(!empty($sType)){
				$aQuantifiers[] = 'setup_type = "'.$sType.'"';
			}

			if(!empty($sMode)){
				$aQuantifiers[] = 'mode = "'.$sMode.'"';
			}

			if(!empty($sAccess)){
				$aQuantifiers[] = 'access = "'.$sAccess.'"';
			}

			if(!empty($iLimit)){
				$sLimit = 'ORDER BY id LIMIT '.intval($iFrom).', '.$iLimit;
			}

			$sSql = 'SELECT owner_id, setup_type, name, alias, href, mode, access, status FROM setups';

			if(!empty($aQuantifiers)){
				$sSql .= ' WHERE '.join(' AND ', $aQuantifiers);
			}

			if(!empty($sLimit)){
				$sSql .= ' '.$sLimit;
			}

			$aSets = $oDB->execute($sSql, mysql::RESULT_HASH);

			$sBaseUrl = PAGE_MODE == 'CMS' ? 'CMS_'.CURRENT_LANG.'_BASE_URL' : 'BASE_URL';
			$sBaseUrl = constant($sBaseUrl);

			if(!empty($aSets)){
				foreach($aSets as $key=>$val){
					$aReturn[$key] = $val;
					$aReturn[$key]["url"]	= empty($val['href']) ? $sBaseUrl : sprintf($val["href"], URL_BASE);
					$aReturn[$key]["alias"] = empty($val["alias"]) ? $val["name"] : $val["alias"];
				}
			}

			return $aReturn;
		}

		public static function getSetLink($sSetName){
			$oDB = renderer::getLib('mysql');

			$sBaseUrl = PAGE_MODE == 'CMS' ? 'CMS_'.CURRENT_LANG.'_BASE_URL' : 'BASE_URL';
			$sBaseUrl = constant($sBaseUrl);

			$aSet = $oDB->execute('SELECT id, href FROM setups WHERE name = "'.$sSetName.'"', mysql::RESULT_ROW);
			
			if(intval($aSet['id']) > 0){
				return (empty($aSet['href']) ? $sBaseUrl : sprintf($aSet["href"], URL_BASE));
			}

			return $sBaseUrl;
		}

		public static function redirect($sUrl, $aParams = null){
			header('Location: '.$sUrl);
			exit;
		}

		public static function getLangText($sIndex){
			if(empty($sIndex)){
				return '';
			}
			
			global $aLang;
			if(empty($aLang[$sIndex])){
				print 'no index found: '.$sIndex;
				return false;
			}
			return $aLang[$sIndex];
		}

	}

?>
