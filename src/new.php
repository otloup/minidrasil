<?php
	$oForm = plugin::init('logun')->form('newPage', URL_CREATE_NEW_PAGE, LogunForm::TYPE_STANDARD, [
		'method'	=>	LogunForm::METHOD_POST
		,'input_defaults'	=>	[
			'class'	=>	[
				'all'	=>	'form-input'
			]
		]
	]);

	$oForm->text('page_name', 'Page Name');

	$oForm->select('type', 'type of the page', [
			'cnt'	=>	'content'
			,'sta'	=>	'static'
			,'jso'	=>	'json'
			]);

	$oForm->select('module1', 'select module', [
			'first'
			,'second'
			,'third'
		]);

	$oForm->select('module2', 'select module', [
			'first'
			,'second'
			,'third'
		]);

	$oForm->select('module3', 'select module', [
			'first'
			,'second'
			,'third'
		]);

	$oForm->submit('submit', 'submit');


	//type			<- choose content (page content), static (not editable content), json (available only via json request)
	//module		<- select with list of all modules
	//module #2 ... #10 
	//submit

	$aForm = $oForm->getHtmlArray();

?>
