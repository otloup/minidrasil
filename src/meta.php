<?php
$aAdditionalJS = [];
$aAdditionalCSS = [];

if(@$_SERVER['CONTENT_EDITABLE']=='true'){
	$aAdditionalJS[] = 'editor.js';
	$aAdditionalJS[] = 'tinymce/tinymce.min.js';

	$aAdditionalCSS[] = 'edition.css';
}

?>
