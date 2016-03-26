<?php
	class renderer {

		private static $oIncludedLibs;
		private $aUsedModules = array();
		private static $aModuleTypes;
		private $oRequest = null;

		public function __construct(requestParser $oRequest){
			self::$oIncludedLibs = new stdClass();
			$this->oRequest = $oRequest;

			require_once(CONF_DIR.'render_conf.php');

			$aModuleConf = @$aRenderConf[$oRequest->sParsedRequest];

			if(empty($aModuleConf)){
				$oMDB = self::getLib('mysql');
				
				$aSetup = $oMDB->execute('SELECT name, id, modules_set_name, mode, access FROM setups WHERE name = "'.$oRequest->sParsedRequest.'" OR name IN ("'.join('","', array_reverse($oRequest->aParsedRequestAlternatives)).'")', mysql::RESULT_ROW);

				if(empty($aSetup) || $aSetup == false){
					if(CREATE_IF_NONE){
//						print 'no configuration found for address: "'.$oRequest->sParsedRequest.'" or "'.$oRequest->sParsedRequestAlternative.'"';
						$this->renderModule($aRenderConf[HREF_CREATE_NEW_PAGE]);
					}
					else{
						$this->renderSetup(DEFAULT_MODULE);
					}
				}
				else{
					$this->renderSetup($aSetup);
				}
			}
			else{
				$this->renderModule($aModuleConf);
			}
		}

		public static function getLib($sLibName, $sConstructorType = 'new'){
			$sFileName = LIB_DIR.$sLibName.FILE_LIB_POSTFIX;

			if(empty(self::$oIncludedLibs->$sLibName)){
				if(file_exists($sFileName)){
					require_once $sFileName;
				}
				else{
					print 'file '.$sFileName.' does not exists';
					exit;
				}
			}

			if($sConstructorType == 'new'){
				self::$oIncludedLibs->$sLibName = new $sLibName();
				return self::$oIncludedLibs->$sLibName;
			}
			else{
				return $sLibName;
			}
		}

		private function renderSetup($aSetup){
			$oMDB = self::getLib('mysql');
			
			if(!empty($aSetup['modules_set_name'])){
				$aModules = $oMDB->execute('SELECT module_id, module_params FROM modules_set WHERE set_name = "'.$aSetup['modules_set_name'].'" AND status = 1 ORDER BY lp ASC', mysql::RESULT_HASH);

				if(plugin::pluginExists('access')){
					plugin::init('access')->handleAccess($aSetup['access']);
				}

				if(!empty($aModules)){
					foreach($aModules as $key => $val){
						$aModule = $oMDB->execute('SELECT name, tpl_path, src_path, type_id FROM modules WHERE id = '.$val['module_id'], mysql::RESULT_ROW);
						
						$sModuleName = $aModule['name'];

						$aModule = array(
							'html'		=>	$aModule['tpl_path'],
							'src'			=>	$aModule['src_path'],
							'mode'		=>	$aSetup['mode'],
							'access'	=>	$aSetup['access'],
							'id'			=>	$val['module_id'],
							'set_name'	=>	$aSetup['modules_set_name'],
							'page_id'	=>	$aSetup['id'],
							'page_name'	=>	$aSetup['name'],
							'page_tabs'	=>	$this->oRequest->aTabs,
							'type_id'	=>	$aModule['type_id'],
							'params'	=>	[]
						);

						parse_str($val['module_params'], $aModule['params']);

						$aUsedModules[$sModuleName] = $aModule;

						self::renderModule($aModule);
					}
				}
			}
		}

		public static function printModule($mModule, $aParams = array()){
			$oMDB = self::getLib('mysql');
			$mModule = $oMDB->escape($mModule);

			if(intval($mModule) > 0){
				$sQuantifier = 'id = '.intval($mModule);
			}
			else{
				$sQuantifier = 'name = "'.$mModule.'"';
			}

			$aModuleConfig = $oMDB->execute('SELECT tpl_path html, src_path src, type_id FROM modules WHERE '.$sQuantifier, mysql::RESULT_ROW);
			
			if(!empty($aModuleConfig)){
				$aModuleConfig['params'] = $aParams;
				$aModuleConfig['params']['render'] = 'ahtml';

				ob_start();
				self::renderModule($aModuleConfig);
				$sRenderedModule = ob_get_contents();
				ob_end_clean();

				return $sRenderedModule;
			}

			return false;
		}	

		public static function printAdminModule($mModule, $aParams = array()){
			ob_start();
			self::renderAdminModule($mModule, $aParams);
			$sRenderedModule = ob_get_contents();
			ob_end_clean();

			return $sRenderedModule;
		}

		public static function renderAdminModule($mModule, $aParams = array()){
			$oMDB = self::getLib('mysql');
			$mModule = $oMDB->escape($mModule);

			if(intval($mModule) > 0){
				$sQuantifier = 'id = '.intval($mModule);
			}
			else{
				$sQuantifier = 'name = "'.$mModule.'"';
			}

			$aModuleData = $oMDB->execute('SELECT id, type_id FROM modules WHERE '.$sQuantifier, mysql::RESULT_ROW);
			$sModuleType = self::getModuleType($aModuleData['type_id']);
			$oModuleConfig = null;
			
			if(!empty($sModuleType)){
				$sPluginAdminConfigPath = sprintf(PLUGIN_ADMIN_DIR, $sModuleType).$sModuleType.'Config.php';
				$sPluginControllerPath = sprintf(PLUGIN_ADMIN_DIR, $sModuleType).$sModuleType.'Admin.php';
				$sPluginAdminSrcPath = sprintf(PLUGIN_ADMIN_DIR, $sModuleType).$sModuleType.'.php';
				$sPluginAdminTplPath = sprintf(PLUGIN_ADMIN_DIR, $sModuleType).$sModuleType.'.html';

				if(file_exists($sPluginAdminConfigPath)){
					require_once($sPluginAdminConfigPath);
				
					$oModuleConfig = self::initPluginConfig($sModuleType);
				}
				else{
					die('configuration file for plugin "'.$sModuleType.'" does not exist (file not found: '.$sPluginAdminConfigPath.')');
				}

				if(file_exists($sPluginControllerPath)){
					require_once($sPluginControllerPath);
				}
				else{
					die('controler module for plugin "'.$sModuleType.'" does not exist (file not found: '.$sPluginControllerPath.')');
				}

				if(file_exists($sPluginAdminSrcPath)){
					$oPlugin = self::initPlugin($sModuleType, $aModuleData['id']);

					$sModulePluginAdminName = $sModuleType.'Admin';
					$$sModulePluginAdminName = new $sModulePluginAdminName($aModuleData['id'], $oPlugin, $oModuleConfig);
					require_once($sPluginAdminSrcPath);
				}
				else{
					die('source file for admin module for plugin "'.$sModuleType.'" does not exist (file not found: '.$sPluginAdminSrcPath.')');
				}

				if(file_exists($sPluginAdminTplPath)){
					require_once($sPluginAdminTplPath);
				}
				else{
					die('template file for admin module for plugin "'.$sModuleType.'" does not exist (file not found: '.$sPluginAdminTplPath.')');
				}

			}

			return false;
		}	

		private static function renderModule($aModuleConf){
			/*if(!empty($aModuleConf['access'])){
				require_once(LIB_DIR.'user.php');
				$oUser = new user();
				
				if($oUser->sRole != $aModuleConf['access']){
					header('Location: '.BASE_URL);
					exit;
				}
			}*/
			
			switch(@$aModuleConf['mode']){
				case 'blank':
					self::renderBlankModule($aModuleConf);
				break;

				case 'json':
					self::renderJsonModule($aModuleConf);
				break;

				default:
					self::renderStandardModule($aModuleConf);
				break;
			}
		}

		private static function renderBlankModule($aModuleConf){
			foreach(explode(',',$aModuleConf['src']) as $file){
				if(!empty($file)){
					$file = trim($file);
					$file = SRC_DIR.$file.'.php';

					if(file_exists($file)){
						require_once($file);
					}
					else{
						print "file '$file' does not exist! <br />\n";
					}
				}
			}	
		}

		private static function renderJsonModule($aModuleConf){
			foreach(explode(',',$aModuleConf['src']) as $file){
				if(!empty($file)){
					$file = trim($file);
					$file = JSON_DIR.$file.'.json.php';

					if(file_exists($file)){
						require_once($file);
					}
					else{
						print "file '$file' does not exist! <br />\n";
					}
				}
			}	
		}

		private static function renderStandardModule($aModuleConf){
			$aTplData = array();
			$sModuleType = self::getModuleType($aModuleConf['type_id']);
			
			${'plugin'.ucfirst($sModuleType)} = self::initPlugin($sModuleType, $aModuleConf['id']);

			foreach(explode(',',$aModuleConf['src']) as $file){
				if(!empty($file)){
					$file = trim($file);
					$file = SRC_DIR.$file.'.php';
					
					if(file_exists($file)){
						require_once($file);
					}
					else{
						print "file '$file' does not exist! <br />\n";
					}
				}
			}
			
			foreach(explode(',',$aModuleConf['html']) as $file){
				if(!empty($file)){
					$file = trim($file);
					$file = TPL_DIR.$file.'.html';

					if(file_exists($file)){
						require_once($file);
					}
					else{
						print "file '$file' does not exist! <br />\n";
					}
				}
			}
		}
	
		public static function getModulesList($bDetails = false) {
			if($bDetails) {
				return $this->aUsedModules;
			}
			else {
				return array_keys($this->aUsedModules);
			}
		}

		private static function getModuleType($iModuleType){
			if(empty(self::$aModuleTypes)){
				$oMDB = self::getLib('mysql');
				$aModuleTypes = $oMDB->execute('SELECT id, name FROM module_types', mysql::RESULT_HASH);

				foreach($aModuleTypes as $aType){
					self::$aModuleTypes[$aType['id']] = $aType['name'];
				}
			}

			return self::$aModuleTypes[$iModuleType];
		}

		private static function initPlugin($sModuleType, $iModuleId){
			if(plugin::pluginExists($sModuleType)){
				$oPlugin = plugin::init($sModuleType, true);
				$oPlugin->setParent($iModuleId);
				return $oPlugin;
			}
		}

		private static function initPluginConfig($sModuleType){
			if(plugin::configExists($sModuleType)){
				$oConfig = plugin::initConfig($sModuleType);
				return $oConfig;
			}
			else{
				die('plugin configuration for module "'.$sModuleType.'" does not exist');
			}
		}

	}

?>
