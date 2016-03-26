<?php

	class plugin {

		private static $aIncludedPlugins = [];
		private static $aIncludedConfigs = [];

		public static function init($sPluginName, $bForce = false){
			if(!empty(self::$aIncludedPlugins[$sPluginName]) && !$bForce){
				return self::$aIncludedPlugins[$sPluginName];
			}

			if(self::pluginExists($sPluginName)){
				require_once(PLUGINS_DIR.$sPluginName.'.php');

				$sPluginClass = $sPluginName.'Plugin';
				$oDB = renderer::getLib('mysql');
				
				$oPlugin = new $sPluginClass ($oDB);
				
				if(!$bForce){
					self::$aIncludedPlugins[$sPluginName] = $oPlugin;
				}

				return $oPlugin;
			}

		}

		public static function pluginExists($sPluginName){
			return file_exists(PLUGINS_DIR.$sPluginName.'.php');
		}

		public static function initConfig($sPluginName){
			if(!empty(self::$aIncludedConfigs[$sPluginName])){
				return self::$aIncludedConfigs[$sPluginName];
			}

			if(self::configExists($sPluginName)){
				require_once(sprintf(PLUGIN_ADMIN_DIR, $sPluginName).$sPluginName.'Config.php');

				$sPluginConfigClass = $sPluginName.'Config';
				$oDB = renderer::getLib('mysql');
				
				$oConfig = new $sPluginConfigClass ($oDB);
				
				self::$aIncludedConfigs[$sPluginName] = $oConfig;

				return $oConfig;
			}

		}

		public static function configExists($sPluginName){
			return file_exists(sprintf(PLUGIN_ADMIN_DIR, $sPluginName).$sPluginName.'Config.php');
		}

	}

?>
