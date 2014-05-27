<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='update_worker'){
	mysqlconnect();

	$id=safe($_POST['cid']);
	$name=safe($_POST['name']);
	$pid=safe($_POST['pid']);
	$type=safe($_POST['typepost']);
	if($name!="" && $type!=""){		
		mysql_query("UPDATE workers SET name='$name', pid='$pid', post_id='$type' WHERE id='$id'") or die(mysql_error());
		die('<div class="alert alert-success">თანამშრომელი წარმატებით ჩასწორდა</div>');			
	}
	else die('<div class="alert alert-error">შეიყვანეთ სახელი და გვარი</div>');
}

?>