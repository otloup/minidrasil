<?php

	date_default_timezone_set('Europe/Berlin');

	define('HOSTNAME', trim(`hostname`));

	$sServerName = !empty($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
	preg_match("/\/home\/([a-zA-Z]*).*/i", $_SERVER['DOCUMENT_ROOT'], $aMatches);

	list($sHomePath, $sUser) = $aMatches;

	switch(HOSTNAME){
		case ('yggdrasil');
			define('DB_USER','root');
			define('DB_PASS','rootdb');
			define('DB_HOST','localhost');
			define('DB','ragnacode');
			define('RENDER_PREFIX','');
			define('RECAPTCHA_PRIVATE_KEY','');
			define('RECAPTCHA_PUBLIC_KEY','');

			define('MAIN_EMAIL_ADDRESS', 'info@ragnacode.eu');
			define('CONTACT_FORM_EMAIL_ADDRESS', 'contact-form@ragnacode.eu');

			define('STAGE', 'DEV');
			define('CONTENT_EDITABLE', true);

			define('DEFAULT_LANG', 'EN');

			define('SERVER_NAME', 'hpv2.local.dev.ragnacode.eu');
		break;

		case ('ratatosk');
			define('DB_USER','root');
			define('DB_PASS','rootdb');
			define('DB_HOST','localhost');
			define('DB','ragnacode');
			define('RENDER_PREFIX','');
			define('RECAPTCHA_PRIVATE_KEY','');
			define('RECAPTCHA_PUBLIC_KEY','');

			define('MAIN_EMAIL_ADDRESS', 'info@ragnacode.eu');
			define('CONTACT_FORM_EMAIL_ADDRESS', 'contact-form@ragnacode.eu');
		break;

		case ('ragnacode');
			define('DB_USER','ragnacode');
			define('DB_PASS','ragn4c0de$H0m3page!');
			define('DB_HOST','localhost');
			define('DB','ragnacode');
			define('RENDER_PREFIX','');
			define('RECAPTCHA_PRIVATE_KEY','6LcP0-MSAAAAAH1MR4zw9NCBz_552vrfn20IDKKi');
			define('RECAPTCHA_PUBLIC_KEY','6LcP0-MSAAAAAFCgAehbOegWvgsPgfqaSN0xRN0z');

			define('MAIN_EMAIL_ADDRESS', 'info@ragnacode.eu');
			define('CONTACT_FORM_EMAIL_ADDRESS', 'contact-form@ragnacode.eu');

			define('STAGE', 'DEV');
			define('CONTENT_EDITABLE', true);

			define('DEFAULT_LANG', 'EN');

			define('SERVER_NAME', 'ragnacode.loup.dev.ragnacode.eu');
		break;
	}

	if(defined('SERVER_NAME')){
		define('BASE_URL', 'http://'.SERVER_NAME.RENDER_PREFIX);
		define('PL_BASE_URL', 'http://pl.'.SERVER_NAME.RENDER_PREFIX);
		define('CMS_BASE_URL', 'http://cms.'.SERVER_NAME.RENDER_PREFIX);
		define('CMS_PL_BASE_URL', 'http://pl.cms.'.SERVER_NAME.RENDER_PREFIX);
		
		$sRequest = preg_replace('%\?.*%',$_SERVER['REQUEST_URI'],'');
		define('CURRENT_URL',BASE_URL.$sRequest);
	}

	if(!empty($_SERVER['STAGE']) && !defined('STAGE')){
		define('STAGE', strtoupper($_SERVER['STAGE']));
	}

	if(!empty($_SERVER['CONTENT_EDITABLE']) && !defined('CONTENT_EDITABLE')){
		define('CONTENT_EDITABLE', !!$_SERVER['CONTENT_EDITABLE']);
	}

	define('CREATE_IF_NONE', false);

	define('URL_BASE',BASE_URL.'/%s');
	define('HREF_BASE',RENDER_PREFIX.'/%s');
	
	define('URL_CREATE_NEW_PAGE',  sprintf(URL_BASE,'new'));
	define('HREF_CREATE_NEW_PAGE', sprintf(HREF_BASE,'new'));
	define('URL_LOGIN_PAGE',  sprintf(URL_BASE,'login'));
	define('URL_ADMIN_PAGE',  sprintf(URL_BASE,'admin'));
        
	define('BASE_DIR', dirname(__FILE__).'/../');
	define('SRC_DIR', BASE_DIR.'src/');
	define('CONF_DIR', dirname(__FILE__).'/');
	define('TPL_DIR', BASE_DIR.'tpl/');
	define('WEBROOT_DIR', BASE_DIR.'webroot/');
	define('JS_DIR', WEBROOT_DIR.'js/');
	define('CSS_DIR', WEBROOT_DIR.'css/');
	define('IMG_DIR', WEBROOT_DIR.'img/');
	define('CORE_DIR', BASE_DIR.'core/');
	define('JSON_DIR', BASE_DIR.'json/');
	define('LIB_DIR', BASE_DIR.'lib/');
	define('CRON_DIR',BASE_DIR.'cron/');
	define('TMP_DIR',BASE_DIR.'tmp/');
	define('UPLOAD_DIR',TMP_DIR.'upload/');
	define('LANG_DIR',BASE_DIR.'i18n/');
	define('PLUGINS_DIR', BASE_DIR.'plugins/');
	define('PLUGINS_ADMIN_DIR', BASE_DIR.'admin/');
	define('PLUGIN_ADMIN_DIR', PLUGINS_ADMIN_DIR.'%s/');

  define('FILE_LIB_POSTFIX','.lib.php');
        
	define('USER_TIMEOUT',(1*60*60*24));//one day

	define('DEFAULT_MODULE', 'index');
        define('SETUP_BUNDLE_TYPE_TEMPLATE', 'template');
        define('SETUP_BUNDLE_TYPE_PAGE', 'page');
	
        #---------------------------------------------
        
        define('USER_PERMISSION_CREATE_PAGE',2);
        define('USER_PERMISSION_CREATE_TEMPLATE',2);
        define('USER_PERMISSION_CREATE_MODULE',4);
        
        define('GROUP_PERMISSION_CREATE_PAGE',2);
        define('GROUP_PERMISSION_CREATE_TEMPLATE',2);
        define('GROUP_PERMISSION_CREATE_MODULE',4);

        define('SESSION_NAME', 'ragnacode');
        define('SESSION_USER_DATA_NAME', 'user_data');

				define('CONTACT_MINIMUM_MAILING_INTERVAL', 1*60*5); //5min

	define('DEFAULT_LANGUAGE','pl_PL');
	define('LANG_TABLES_FORMAT_STATIC','static');
	define('LANG_TABLES_FORMAT_DYNAMIC','dynamic');
	define('DEFAULT_LANG_TABLES_FORMAT',LANG_TABLES_FORMAT_DYNAMIC);
	define('LANG_TABLE_NAME_STATIC', '%s.dic.php');
	define('LANG_TABLE_NAME_DYNAMIC','%s_dic');
	define('DEFAULT_LANG_FILE_PATH',LANG_DIR.'%s');
	define('DEFAULT_LANG_DB_REQUEST','SELECT content FROM %s WHERE lang = "%s" AND name = "%s"');
	define('DEFAULT_PAGE_LIMIT', 5);
?>
