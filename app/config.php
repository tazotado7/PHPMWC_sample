<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 


$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";
define("URL", $base_url);
define("ROOT", $_SERVER['DOCUMENT_ROOT']); 
define("APP", ROOT.'/app'); 
define("PAGES", APP.'/pages'); 

use taladashvili\root\core;


include(APP.'/root/db.php');
include(APP.'/helpers/geturl.php');


include(APP.'/root/core.php'); 


new core();