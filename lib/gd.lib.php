<?php

	class gd{

		private $sOrgPath;
		private $sTargetPath;
		private $aSizes;
		private $bWatermark = false;
		private $sWatermarkPath;
		private $iPercentResize;
		private $aOSize;
		private $sResizeType;
		private $aOutNames;
		private $imageHandler;
		private $_imageHandler;
		private $aNSizes;
		private $aImgData;
		private $aOSizes = array();

		public $return;

		const TO_WIDTH = 0;
		const PROPORT = 1;
		const PERCENT = 2;
		const FIT = 3;
		const TO_HEIGHT = 4;
		const NONE = 5;
		const ORG_FILE_PREFIX = 'org';

		private function setAttributes($aConfig){
			$this->sResizeType = $aConfig[0];
			$this->sTargetPath = $aConfig[1];
			$this->sOrgPath = $aConfig[2];
			$this->aOutNames = !is_array($aConfig[3]) ? array('th','sml','med','big','max','org') : $aConfig[3];
			$this->aSizes = !is_array($aConfig[4]) ? array(
					'th'		=>	"64x64"
					,'sml'	=>	"256x256"
					,'med'	=>	"1024x1024"
					,'big'	=>	"2048x2048"
					,'max'	=>	"4096x4096"
			) : $aConfig[4];
			$this->aImgData = getimagesize($this->sOrgPath);
		}

  	public function resize($aConfig){
			$this->setAttributes($aConfig);

			$this->aOSizes['w'] = $this->aImgData[0];
			$this->aOSizes['h'] = $this->aImgData[1];


			$type = explode('/',$this->aImgData['mime']);
			$type = end($type);
      
			switch($type){
        case 'jpg':
        case 'jpeg':
				case 'pjpeg':
          $this->_imageHandler = imagecreatefromjpeg($this->sOrgPath);
        break;
        case 'gif':
          $this->_imageHandler = imagecreatefromgif($this->sOrgPath);
        break;
        case 'png':
          $this->_imageHandler = imagecreatefrompng($this->sOrgPath);
        break;
				default:
					exit('unsupported image type');
				break;
      }

			switch($this->sResizeType){
				case self::TO_WIDTH 	:$this->scaleToWidth();break;
				case self::PROPORT 		:$this->scaleToProport();break;
				case self::PERCENT	 	:$this->scaleToPercent();break;
				case self::FIT 				:$this->scaleToFit();break;
				case self::TO_HEIGHT 	:$this->scaleToHeight();break;
				case self::NONE 			:$this->scaleToNothing();break;
			}

			$this->create();
			return $this->return;

		}

		private function scaleToWidth(){
			foreach($this->aOutNames as $key => $val){
				$toSizes = $this->aSizes[$val];
				$toSizes = explode('x',$toSizes);
				if($this->aOSizes['w']>$toSizes[0]){
					$ratio = $this->aOSizes['w']/$toSizes[0];
					$this->aNSizes[$val]['w'] = $this->aOSizes['w']/$ratio;
					$this->aNSizes[$val]['h'] = $this->aOSizes['h']/$ratio;
				}
				else{
					$this->aNSizes[$val]['w'] = $this->aOSizes['w'];
					$this->aNSizes[$val]['h'] = $this->aOSizes['h'];				
				}
			}
		}

		private function scaleToNothing(){
			foreach($this->aOutNames as $key => $val){
					$this->aNSizes[$val]['w'] = $this->aOSizes['w'];
					$this->aNSizes[$val]['h'] = $this->aOSizes['h'];				
			}
		}

		private function scaleToProport(){
			foreach($this->aOutNames as $key => $val){
				$toSizes = $this->aSizes[$val];
				$toSizes = explode('x',$toSizes);
				
				if($this->aOSizes['w']>$toSizes[0] || $this->aOSizes['h']>$toSizes[1]){
					$ratio1 = $this->aOSizes['h']/$toSizes[1];
					$ratio2 = $this->aOSizes['w']/$toSizes[0];

					$this->aNSizes[$val]['w'] = $this->aOSizes['w']/$ratio2;
					$this->aNSizes[$val]['h'] = $this->aOSizes['h']/$ratio1;
				}
				else{
					$this->aNSizes[$val]['w'] = $this->aOSizes['w'];
					$this->aNSizes[$val]['h'] = $this->aOSizes['h'];				
				}
			}		
		}

		private function scaleToPercent(){
			foreach($this->aOutNames as $key => $val){
				$iPercernt = $this->iPercentResize;

				if($this->aOSizes['w']>$this->aOSizes['w']*($iPercent/10) || $this->aOSizes['h']>$this->aOSizes['h']*($iPercent/10)){
					$this->aNSizes[$val]['w'] = $this->aOSizes['w']*($iPercent/10);
					$this->aNSizes[$val]['h'] = $this->aOSizes['h']*($iPercent/10);
				}
				else{
					$this->aNSizes[$val]['w'] = $this->aOSizes['w'];
					$this->aNSizes[$val]['h'] = $this->aOSizes['h'];				
				}
			}		
		}

		private function scaleToFit(){
			$this->scaleToProport();
		}

		private function scaleToHeight(){
			foreach($this->aOutNames as $key => $val){
				$toSizes = $this->aSizes[$val];
				$toSizes = explode('x',$toSizes);
				if($this->aOSizes['h']>$toSizes[1]){
					$ratio = $this->aOSizes['h']/$toSizes[0];
					$this->aNSizes[$val]['w'] = $this->aOSizes['w']/$ratio;
					$this->aNSizes[$val]['h'] = $this->aOSizes['h']/$ratio;
				}
				else{
					$this->aNSizes[$val]['w'] = $this->aOSizes['w'];
					$this->aNSizes[$val]['h'] = $this->aOSizes['h'];				
				}
			}
		}

		private function makePath($startPath){
			return '';
		}

		private function create(){
			$this->aOutNames[] = self::ORG_FILE_PREFIX;
			$this->aNSizes[self::ORG_FILE_PREFIX]['w'] = $this->aOSizes['w'];
			$this->aNSizes[self::ORG_FILE_PREFIX]['h'] = $this->aOSizes['h'];
			$sName = 	md5(time()*mt_rand());

			foreach($this->aOutNames as $key=>$val){
	      $width = round($this->aNSizes[$val]['w']);
	      $height = round($this->aNSizes[$val]['h']);

				if(round($this->aNSizes[$val]['w'])==0){$width = $this->aNSizes[self::ORG_FILE_PREFIX]['w'];}
				if(round($this->aNSizes[$val]['h'])==0){$height = $this->aNSizes[self::ORG_FILE_PREFIX]['h'];}
				
				$this->imageHandler	= imagecreatetruecolor($width, $height);

				$width_orig = $this->aOSizes['w'];
				$height_orig = $this->aOSizes['h'];

				$this->sTargetPath .= $this->makePath($this->sTargetPath);		
				$name = $val.'_'.$sName.'.jpg';
				imagecopyresampled($this->imageHandler, $this->_imageHandler, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	      imagejpeg($this->imageHandler, $this->sTargetPath.$name, 100);
	      
	      $out[$val]['path'] = $name;
				$out[$val]['x'] = $width;
				$out[$val]['y'] = $height;
	    }   
	
	    $this->return = $out;
	  }
	}  
?>
