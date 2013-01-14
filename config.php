<?php

	# Database Details
	define('DB_NAME',	  '');
	define('DB_USERNAME', '');
	define('DB_PASSWORD', '');
	define('DB_SERVER',   'localhost');
	define('DB_PREFIX',   'vl_');
	
	/*********************************************
	**********************************************
	********* DON'T EDIT BELOW THIS LINE *********
	**********************************************
	*********************************************/
	
	# No Errors
	error_reporting(0);

	# Start Session
	session_start();
	
	# Connection
	mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
	mysql_select_db(DB_NAME);

	# Install (If Needed)
	mysql_query('CREATE TABLE IF NOT EXISTS `'.DB_PREFIX.'urls` ('
			   .'`id` int(11) NOT NULL auto_increment,'
			   .'`title` text NOT NULL,'
			   .'`url` text NOT NULL,'
			   .'`timestamp` int(10) NOT NULL,'
			   .'PRIMARY KEY  (`id`)'
			   .') ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
	
	# Domain
	define('VL_DOMAIN', preg_replace('#^www\.#', '', $_SERVER['SERVER_NAME']));
	define('VL_URL', 	str_replace('/index.php', '', 'http://'.VL_DOMAIN.$_SERVER['PHP_SELF']));

?>