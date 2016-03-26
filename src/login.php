<?php

	renderer::getLib('globalUtil');

	$oAccess = plugin::init('access');
	$bLogged = false;

	if($_GET['logout']==1){
		$oAccess->logout();
	}

	$bLogged = $oAccess->isLogged();

	$oForm = plugin::init('logun')->form('login', URL_LOGIN_PAGE, LogunForm::TYPE_STANDARD, [
		'method'	=>	LogunForm::METHOD_POST
		,'input_defaults'	=>	[
			'class'	=>	[
				'all'	=>	'form-input'
			]
		]
	]);

	$oForm->text('login', 'login/email');

	$oForm->password('pass', 'password');

	$oForm->submit('submit', 'submit');

	$aForm = $oForm->getHtmlArray();

	if($oForm->isValid()){
		$bLogged = $oAccess->login($oForm->getLogin(), $oForm->getPass());
	}

	if($bLogged){
		globalUtil::redirect(URL_ADMIN_PAGE);
	}

?>
