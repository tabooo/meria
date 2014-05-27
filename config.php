<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$con="";
$host="localhost";
function mysqlconnect(){
global $con;
$con = mysql_connect("127.0.0.1","root","tabagari89");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("meria");
mysql_query("SET NAMES 'utf8'");
}

function refreshPage($time,$location) {
	print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time; URL=$location\">";
}

function addlogs($action){
	$date=time();
	mysql_query("INSERT INTO logs VALUES(null,'$action','$date')") or die(mysql_error());
}

function safe($string)
{
    $string = stripslashes($string);
    $string = strip_tags($string);
    $string = mysql_real_escape_string($string);
    return $string;
}
?>
