<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='update_citizen'){
mysqlconnect();

$id=safe($_POST['cid']);
$name=safe($_POST['name']);
$pid=safe($_POST['pid']);
$address=safe($_POST['address']);
$type=safe($_POST['type']);
if($name!="" && $address!="" && $type!=""){
	
			mysql_query("UPDATE citizens SET name='$name', pid='$pid', address='$address', type='$type' WHERE id='$id'") or die(mysql_error());
			die('<div class="alert alert-success">მოქალაქე წარმატებით ჩასწორდა</div>');
		
}
else die('<div class="alert alert-error">გთხოვთ შეიყვანოთ მისამართი</div>');
}

?>