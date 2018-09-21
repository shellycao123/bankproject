<?php
//turn on output buffering
ob_start();

//turn on session fro each page
session_start();

//use define(CONSTANT_NAME,value) to define constants
//__FILE__ is a constant for the full path and file name to the current file
//dirname() returns the path to the parent directory of the parameter file
define("PRIVATE_PATH",dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH.'/public');
define("SHARED_PATH",PRIVATE_PATH.'/shared');
require_once PRIVATE_PATH."/functions.php";


//file path are not the same as URL!!! define new constants for relative URL
$public_end = strpos($_SERVER["SCRIPT_NAME"],'/public')+7;
$doc_root = substr($_SERVER["SCRIPT_NAME"], 0, $public_end);
define("WWW_ROOT",$doc_root);
//strpos: find the first occurance of the substring in a string
//$_SERVER is an array containing information
//such as headers, paths, and script locations.
//$_SERVER["SCRIPT_NAME"]:name of the current script's path

require_once 'database.php';
 $db = db_connect();
 require_once 'query_functions.php';
 require_once 'validation.php';
 require_once 'auth_functions.php';
 $errors = [];

