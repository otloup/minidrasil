<?php

if($_SERVER['CONTENT_EDITABLE'] != 'true'){
	exit;
}

	renderer::getLib('globalUtil', 'static');
$oDB = renderer::getLib('mysql');

if(!empty($_GET['a'])){
    $a = array('wartosc'=>$_GET['a']);
    echo globalUtil::forgeJSONResponse($a);
}

	if(!empty($_POST['content']) && !empty($_POST['name'])){

		list($sElement, $sGroupName, $sElementName, $sChangeType) = explode('_', $_POST['name']);
		$sContent = $_POST['content'];

		$sElement = $oDB->escape($sElement);
		$sGroupName = $oDB->escape($sGroupName);
		$sElementName = $oDB->escape($sElementName);
		$sChangeType = $oDB->escape($sChangeType);
		$sContent = $oDB->escape($sContent);

		switch($sElement){
			case 'slider':
				$sUpdateFunc = $sChangeType == 'header' ? 'updateSliderHeader' : 'updateSliderContent';
				echo globalUtil::forgeJSONResponse(call_user_func($sUpdateFunc, $sGroupName, $sElementName, $sContent));
			break;

			case 'subpage':
				$sUpdateFunc = $sChangeType == 'header' ? 'updateSubpageHeader' : 'updateSubpageContent';
				echo globalUtil::forgeJSONResponse(call_user_func($sUpdateFunc, $sGroupName, $sElementName, $sContent));
			break;
		}

	}

	function slideExists($sGroupName, $sName){
		$oDB = renderer::getLib('mysql');
		$iSlideId = $oDB->execute('SELECT id FROM widget_slider WHERE group_name = "'.$sGroupName.'" AND name = "'.$sName.'"', mysql::RESULT_SINGLE);

		return !!($iSlideId > 0);
	}

	function subpageExists($sGroupName, $sName){
		$oDB = renderer::getLib('mysql');
		$iSubpageId = $oDB->execute('SELECT id FROM pages_content WHERE name = "'.$sName.'"', mysql::RESULT_SINGLE);

		return !!($iSubpageId > 0);
	}

	function updateSliderHeader($sSlideGroup, $sSlideName, $sContent){
		$oDB = renderer::getLib('mysql');
		$mStatus = false;

		if(slideExists($sSlideGroup, $sSlideName)){
			$mStatus = $oDB->execute('UPDATE widget_slider SET header = "'.$sContent.'" WHERE group_name = "'.$sSlideGroup.'" AND name = "'.$sSlideName.'"');
		}
		else{
			$mStatus = 'No Slide Found With Name '.$sSlideName.' And Group '.$sSlideGroup;
		}

		return array(
				'status'=>$mStatus
			);
	}

	function updateSliderContent($sSlideGroup, $sSlideName, $sContent){
		$oDB = renderer::getLib('mysql');
		$mStatus = false;

		if(slideExists($sSlideGroup, $sSlideName)){
			$mStatus = $oDB->execute('UPDATE widget_slider SET content = "'.$sContent.'" WHERE group_name = "'.$sSlideGroup.'" AND name = "'.$sSlideName.'"');
		}
		else{
			$mStatus = 'No Slide Found With Name '.$sSlideName.' And Group '.$sSlideGroup;
		}

		return array(
				'status'=>$mStatus
			);
	}

	function updateSubpageHeader($sSubpageGroup, $sSubpageName, $sContent){
		$oDB = renderer::getLib('mysql');
		$mStatus = false;

		if(subpageExists($sSubpageGroup, $sSubpageName)){
			$mStatus = $oDB->execute('UPDATE pages_content SET header = "'.$sContent.'" WHERE name = "'.$sSubpageName.'"');
		}
		else{
			$mStatus = 'No Subpage Found With Name "'.$sSubpageName.'"';
		}

		return array(
				'status'=>$mStatus
			);
	}

	function updateSubpageContent($sSubpageGroup, $sSubpageName, $sContent){
		$oDB = renderer::getLib('mysql');
		$mStatus = false;

		if(subpageExists($sSubpageGroup, $sSubpageName)){
			$mStatus = $oDB->execute('UPDATE pages_content SET content = "'.$sContent.'" WHERE name = "'.$sSubpageName.'"');
		}
		else{
			$mStatus = 'No Subpage Found With Name "'.$sSubpageName.'"';	
		}

		return array(
				'status'=>$mStatus
			);
	}

	function addSlide(){}

	function addSubpage(){}

?>
