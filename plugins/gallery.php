<?php

	class galleryPlugin {

		const DB_NAME = "plugin_gallery";
		const DEFAULT_PAGE = 1;
		const DEFAULT_RESULTS_PER_PAGE = 15;

		private $oDB = null;
		private $iParentModule = 0;

		public function __construct ($oDB){
			if(is_a($oDB, 'mysql')){
				$this->oDB = $oDB;
			}
			else{
				die('execute is not a mysql class');
			}
		}

		public function setParent($iModuleId){
			$this->iParentModule = $iModuleId;
		}

		public function getList($sPhotosUrl, $iPage = self::DEFAULT_PAGE, $iFrom = 0, $iTo = self::DEFAULT_RESULTS_PER_PAGE){
			$iFrom = ($iTo+1)*($iPage-1);
			$sSql = 'SELECT path, name, alt, description, lp FROM '.self::DB_NAME.' ORDER BY lp ASC LIMIT '.$iFrom.', '.$iTo;
			$aPhotos = $this->oDB->execute($sSql, mysql::RESULT_HASH);

			array_walk($aPhotos, function(&$item) use ($sPhotosUrl){
						$item['path'] = $sPhotosUrl.$item['path'];
					});

			return $aPhotos;
		}

		public function getAnalogList($sPhotosUrl, $sPhotosPath){
			$aPhotos = [];

			if ($handle = opendir($sPhotosPath)) {
				$i = 0;
				while (false !== ($entry = readdir($handle))) {
						if ($entry != "." && $entry != "..") {
							$i++;
							$aPhotos[] = array(
								'path'	=>	$sPhotosUrl.$entry,
								'name'	=>	$entry,
								'alt'	=>	'Zdjęcie '.$i,
								'description'	=>	'Zdjęcie '.$i,
								'lp'	=>	$i
							);
						}
				}
				closedir($handle);
			}

			return $aPhotos;
		}

	}

?>
