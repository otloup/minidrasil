<?php
	$oDB = renderer::getLib('mysql');

	$sPage = $aModuleConf['page_tabs'][1];
	$sModule = $aModuleConf['page_tabs'][2];
	$sEdit = '';

	$aSets = $oDB->execute('SELECT name FROM setups WHERE access IS NULL AND status = 1', mysql::RESULT_HASH);

	if(!empty($sPage)){
		$sModuleSetName = $oDB->execute('SELECT modules_set_name FROM setups WHERE name = "'.$sPage.'" AND status = 1', mysql::RESULT_SINGLE);
		
		$aModules = $oDB->execute('SELECT 
				m.name, m.description 
				FROM modules m 
				WHERE m.id IN(SELECT 
					ms.module_id 
					FROM modules_set ms 
					WHERE ms.set_name = "'.$sModuleSetName.'" 
			)', mysql::RESULT_HASH);
	}

	if(!empty($sModule)){
		$sEdit = renderer::printAdminModule($sModule);	
	}
?>
