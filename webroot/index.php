<?php

	require_once(CORE_DIR.'request_parser.php');

	$oRequest = new requestParser();

	$aLang = array();

	require_once(LANG_DIR.CURRENT_LANG.'.php');
	require_once(CORE_DIR.'plugin.php');
	require_once(CORE_DIR.'renderer.php');
	require_once(LIB_DIR.'general.php');
	require_once(LIB_DIR.'error.php');

	new renderer($oRequest);

	//session_destroy();
?>
