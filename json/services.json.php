<?php

	renderer::getLib('globalUtil', 'static');
	$oDB = renderer::getLib('mysql');

	if(intval($_POST['index'] >= 0)){
		$aService = $oDB->execute('SELECT name, header, content FROM widget_slider WHERE status = 1 AND group_name = "services" ORDER BY lp LIMIT '.intval($_POST['index']).', 1', mysql::RESULT_ROW);

		echo globalUtil::forgeJSONResponse($aService);
	}

?>
