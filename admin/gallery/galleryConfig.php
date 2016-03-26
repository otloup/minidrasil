<?php

	class galleryConfig {

		const GALLERY_THUMB_SIZE 	= '64x64';
		const GALLERY_SMALL_SIZE 	= '256x256';
		const GALLERY_MEDIUM_SIZE = '1024x1024';
		const GALLERY_BIG_SIZE 		= '2048x2048';
		const GALLERY_MAX_SIZE 		= '4096x4096';

		private $aScaleSizes = [];
		private $sTargetPath = '';
		private $sScaleType = '';

		private $oDB = null;

		public function __construct($oDB){
			$this->oDB = $oDB;
			
			renderer::getLib('imageUpload');
			renderer::getLib('gd');

			$this->aScaleSizes = [
				'th'		=>	self::GALLERY_THUMB_SIZE
				,'sml'	=>	self::GALLERY_SMALL_SIZE
				,'med'	=>	self::GALLERY_MEDIUM_SIZE
				,'big'	=>	self::GALLERY_BIG_SIZE
				,'max'	=>	self::GALLERY_MAX_SIZE	
			];

			$this->sScaleType = gd::TO_WIDTH;

			$this->sTargetPath = IMG_DIR.'gallery/';
		}

		public function getScaleSizes(){
			return $this->aScaleSizes;
		}

		public function getScaleType(){
			return $this->sScaleType;
		}

		public function getTargetPath(){
			return $this->sTargetPath;
		}

	}

?>
