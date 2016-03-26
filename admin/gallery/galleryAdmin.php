<?php
	class galleryAdmin extends imageUpload{

		private $iModuleId = 0;

		public function __construct($iModuleId, $galleryPlugin, $galleryConfig){
			parent::__construct();
			
			$this->iModuleId = $iModuleId;
			$this->setUploadParams(
					$galleryConfig->getTargetPath()
					,$galleryConfig->getScaleSizes()	
					,$galleryConfig->getScaleType()
				);
		}

		public function getSizes(){
			return $this->aSizes;
		}

		public function getScaleType($sType){
			return $this->sScaleType;
		}

		public function indexFile($aImageData){
			$aUploadData = $this->uploadImage($aImageData);
			$aRegisterResult = $this->registerImage($aUploadData);
		}

	}

?>
