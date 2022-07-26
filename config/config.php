<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
	header('Location: /');
}
if ( !defined('ACTION') ) {
	die( 'Direct access not permitted' );
}
define("DB_HOST", "revpanda");
define("DB_NAME", "");
define("DB_USER", "");
define("DB_PASSWORD", "");