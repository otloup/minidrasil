<?php

	class imageUpload {

		protected $oGd = null;
		protected $oMysql = null;

		protected $sTargetPath = '';
		protected $aSizes = [];
		protected $sScaleType = '';

		public function __construct(){
			$this->oGd = renderer::getLib('gd');
			$this->oMysql = renderer::getLib('mysql');
		}

		protected function setUploadParams($sTargetPath, $aSizes, $sScaleType){
			$this->sTargetPath = $sTargetPath;
			$this->aSizes = $aSizes;
			$this->sScaleType = $sScaleType;
		}

		protected function uploadImage($aImageData){
			$oGd = $this->oGd;
			$sScaleType = $this->sScaleType;
			$sTargetPath = $this->sTargetPath;
			$aSizes = $this->aSizes;

			$fFileResize = function($sPath) use($oGd, $sScaleType, $sTargetPath, $aSizes){
				return $oGd->resize([
					$sScaleType
					,$sTargetPath
					,$sPath
					,array_keys($aSizes)
					,$aSizes
				]);
			};

			if(is_array($aImageData['path'])){
				$aImages = [];
				
				for($i = 0; $i < count($aImageData['path']); $i++){
					$aImages[] = [
						'data'		=>	[
							'name'	=>	$this->oMysql->escape($aImageData['name'][$i])
							,'size'	=>	$aImageData['size'][$i]
							,'mime'	=>	$aImageData['type'][$i]
						]
						,'image'	=>	$fFileResize($aImageData['path'][$i])
					];
				}

				return $aImages;
			}
			else{
				return [
					'data'	=>	[
						'name'	=>	$this->oMysql->escape($aImageData['name'])
						,'size'	=>	$aImageData['size']
						,'mime'	=>	$aImageData['type']
					]
					,'image'	=>	$fFileResize($aImageData['path'])
				];
			}
		}

		protected function registerImage($aUploadedImageData){
			$fCreateQuery = function($aImage){
				$sPath = substr($aImage['image']['org']['path'], strpos($aImage['image']['org']['path'], '_')+1);
				
				$aSqlPrep = [
					'"'.$aImage['data']['name'].'"'
					,'"'.$aImage['data']['mime'].'"'
					,'"'.$aImage['data']['size'].'"'
					,'NOW()'
					,'"'.$sPath.'"'
					,$aImage['image']['org']['x']
					,$aImage['image']['org']['y']
					,$aImage['image']['max']['x']
					,$aImage['image']['max']['y']
					,$aImage['image']['big']['x']
					,$aImage['image']['big']['y']
					,$aImage['image']['med']['x']
					,$aImage['image']['med']['y']
					,$aImage['image']['sml']['x']
					,$aImage['image']['sml']['y']
					,$aImage['image']['th']['x']
					,$aImage['image']['th']['y']
				];

				return '('.
					join(',', $aSqlPrep)
				.')';			
			};

			$sSql = 'INSERT INTO image_data (name, mime, size, upload_date, path, org_x, org_y, max_x, max_y, big_x, big_y, med_x, med_y, sml_x, sml_y, th_x, th_y) VALUES ';

			if(!empty($aUploadedImageData[0])){
				$aSqls = [];

				foreach($aUploadedImageData as $aImage){
					$aSqls[] = $fCreateQuery($aImage);
				}
				print '<pre>';
				print_r($aSqls);
				$sSql .= join(',', $aSqls);
				print $sSql;
			}
			else{
				$sSql .= '('.$fCreateQuery($aUploadedImageData).')';
			}

			return $this->oMysql->execute($sSql);
		}

	}

?>
