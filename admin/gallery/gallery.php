<?php

  $oForm = plugin::init('logun')->form('gallery', null, LogunForm::TYPE_STANDARD, [
    'method'  =>  LogunForm::METHOD_POST
    ,'input_defaults' =>  [
      'class' =>  [
        'all' =>  'form-input'
      ]
		]
		,'parse'	=>	[
			'file'	=>	[$galleryAdmin, 'indexFile']
		]
  ]);

//	$oForm->setAlwaysValidOverride();

	$oForm->file('file', 'file', [
		'multiple'	=>	'multiple'
	]);

  $oForm->text('lp', 'lp');

	$oForm->select('lang', 'lang code', [
				0	=>	'pl_PL'
				,1	=>	'en_US'
			]);

  $oForm->submit('submit', 'submit');

  $aForm = $oForm->getHtmlArray();

  if($oForm->isValid()){
		print_r([
			$oForm->getFile()
			,$oForm->getLp()
			,$oForm->getLang()
		]);
  }	

?>
