<?php

	if (!ini_get('display_errors')) {
	    ini_set('display_errors', '1');
	}


	ini_set('session.use_cookies', '1');
	ini_set('session.use_only_cookies', '1'); // PHP >= 4.3
	ini_set('session.use_trans_sid', '0');
	ini_set('url_rewriter.tags', '');
