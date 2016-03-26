<?php

	class dic {

		private static $oDB;
		private static $sDefaultLang;
		private static $sDefaultLangTablesFormat;
		private static $sDefaultLangTableName;
		private static $sDefaultLangTablePath;
		private static $sDefaultLangDBRequest;

		private static function getDB(){
			if(empty($oDB)){
				self::$oDB = renderer::getLib('mysql');
			}

			self::$sDefaultLangCode = DEFAULT_LANGUAGE;
			self::$sDefaultLangTablesFormat = DEFAULT_LANG_TABLES_FORMAT;
			self::$sDefaultLangTableName = DEFAULT_LANG_TABLE_NAME;
			self::$sDefaultLangFilePath = DEFAULT_LANG_FILE_PATH;
			self::$sDefaultLangTableRequest = DEFAULT_LANG_DB_REQUEST;
		}

		public static function get($sLineName, $sLangCode = '', $sLangTableFormat = '', $sLangTableName = ''){
			$sLangCode = empty($sLangCode) ? self::$sDefaultLangCode : $sLangCode;
			$sLangTableFormat = empty($sLangTableFormat) ? self::$sDefaultLangTablesFormat : $sLangTableFormat;
			$sLangTableName = empty($sLangTableName) ? self::$sDefaultLangTableName : $sLangTableName;

			switch($sLangTableFormat) {
				case 'static' :
					return self::getStaticLine($sLineName, $sLangCode, $sLangTableName);
				break;

				case 'dynamic' :
					return self::getDynamicLine($sLineName, $sLangCode, $sLangTableName);
				break;
			}
		}

		private static function getStaticLine($sLineName, $sLangCode, $sLangTableName){
			$sFilePath = self::getTableFile($sLangCode);

			if(empty($aDicTable[$sLangCode][$sLineName])){
				return 'String You Are Requesting Has Not Been Found In <pre>static:'.$sFilePath.'</pre>';
			}

			return $aDicTable[$sLangCode][$sLineName];
		}

		private static function getTableFile($sLangCode){
			$sLangFileName = sprintf(LANG_TABLE_NAME_STATIC, $sLangCode);
			$sLangFilePath = sprintf(DEFAULT_LANG_FILE_PATH, $sLangFileName);

			if(file_exists($sLangFilePath)){
				require_once($sLangFilePath);
			}

			return $sLangFilePath;
		}

		private static function getDynamicLine($sLineName, $sLangCode, $sLangTableName){
//			$sRequest = sprintf(DEFAULT_LANG_DB_REQUEST, )
		}

	}

?>
