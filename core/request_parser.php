<?php

	class requestParser {

		public $sOriginalRequest = '';
		public $aParsingBiproduct = array();
		public $sParsedRequest = '';
		public $aParsedRequestAlternatives = array();
		public $aSubdomains = array();
		public $aTabs = array();

		public function __construct($sRequestString=null){

			$sRequestString = empty($sRequestString) ? (empty($_SERVER['REDIRECT_URL']) ? $_SERVER['REQUEST_URI'] : $_SERVER['REDIRECT_URL']) : $sRequestString;
			$this->sOriginalRequest = $sRequestString;

			$sParsedString = $this->stripRequest($sRequestString);

			if(empty($sRequestString) || empty($sParsedString)){
				$this->sParsedRequest = DEFAULT_MODULE;
			}
			else{
				$this->sParsedRequest = $sParsedString;
			}

			$this->extractSubdomains();
			$this->extractTabs();
			$this->setLanguage();
			$this->setPageMode();

			if(!empty($this->aTabs)){
				$sMainAlternative = '';
				$sMainWildcard = '';

				foreach($this->aTabs as $sTab){
					$sMainAlternative .= $sTab;
					$this->aParsedRequestAlternatives[] = $sMainAlternative . '/*';
			 		$this->aParsedRequestAlternatives[] = $sMainAlternative;

					if(empty($sMainWildcard)){
						$sMainWildcard = $sTab;
					}
					else{
						$sMainWildcard .= '/*';
						
						if(!in_array($sMainWildcard, $this->aParsedRequestAlternatives)){
							$this->aParsedRequestAlternatives[] = $sMainWildcard;					
						}
					}

					$sMainAlternative .= '/';

				}
			}

		}

		private function stripRequest($sRequestString){
      $aMatches = array();
                        
			preg_match('/\/([^?]*)\/?/', $sRequestString, $aMatches);
			$this->aParsingBiproduct = $aMatches; 
			
			if(substr($aMatches[1],-1,1)=='/'){
				return substr($aMatches[1],0,-1);
			}

			return $aMatches[1];
		}

		private function extractSubdomains(){
			$sSubdomains = substr(str_replace(SERVER_NAME, '', $_SERVER['HTTP_HOST']), 0, -1);
			
			if(!empty($sSubdomains)) {
				$this->aSubdomains = explode('.', $sSubdomains);
			}
		}

		private function extractTabs(){
			$this->aTabs = explode('/', $this->sParsedRequest);
		}

		private function setLanguage(){
			$sLang = '';
			
			if(!empty($this->aSubdomains)){
				$sLang = $this->aSubdomains[0];
			}

			switch(strtolower($sLang)){
				case 'pl':
					define('CURRENT_LANG', 'PL');
				break;

				default:
					define('CURRENT_LANG', DEFAULT_LANG);
				break;

			}
		}

		private function setPageMode(){
			$sPageMode = empty($this->aSubdomains) ? 'simple' : end($this->aSubdomains);

			switch($sPageMode){
				case 'cms':
					define('PAGE_MODE', 'CMS');
				break;

				default:
					define('PAGE_MODE', 'SIMPLE');
				break;
			}
		}

	}

?>
