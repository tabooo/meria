<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='add_worker'){
mysqlconnect();
//if(safe($_POST['name'])!="" || $_POST['pid']!="" || $_POST['address']!=""){
$name=safe($_POST['name']);
$pid=safe($_POST['pid']);
$date=date(safe($_POST['date']));
$department=safe($_POST['department']);

if($name!="" && $department!=""){
	mysql_query("INSERT INTO workers VALUES (null,'$name','$pid','$date','$department','1')") or die(mysql_error());
	die('<div class="alert alert-success">წარმატებით დაემატა</div>');
		}
		else die('<div class="alert alert-error">პრობლემა</div>');
}

?>