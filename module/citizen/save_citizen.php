<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='save_citizen'){
mysqlconnect();

$name=safe($_POST['name']);
$pid=safe($_POST['pid']);
$address=safe($_POST['address']);
$type=safe($_POST['type']);
if($name!="" && $type!=""){
	$pidq=mysql_query("SELECT * FROM citizens WHERE name='$name' AND address='$address'") or die(mysql_error());
	$pidn=mysql_num_rows($pidq);
		if($pidn<1){
			mysql_query("INSERT INTO citizens VALUES (null,'$name','$pid','$address','$type')") or die(mysql_error());
			die('<div class="alert alert-success">მოქალაქე წარმატებით დაემატა</div>');
		}
		else die('<div class="alert alert-error">ასეთი პირადი ნომერი უკვე არის</div>');
}
else die('<div class="alert alert-error">გთხოვთ შეიტანოთ მისამართი!</div>');
}

if(@$_POST['dos']=='get_citizen_address'){
	mysqlconnect();
	if(safe($_POST['id'])!=""){

		$id=safe($_POST['id']);

		$pidq=mysql_fetch_array(mysql_query("SELECT address FROM citizens WHERE id='$id'"));
		//echo $pidq['address'];
		$asd=$pidq['address'];
		
		echo $asd;
	}
}

if(@$_POST['dos']=='get_departament'){
	mysqlconnect();
	if(safe($_POST['id'])!=""){

		$id=safe($_POST['id']);

		$pidq=mysql_fetch_array(mysql_query("SELECT post_id FROM workers WHERE id='$id'"));
		$pidq1=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in (select dep_id from posts where id='".$pidq['post_id']."')"));
		//echo $pidq['address'];
		$asd=$pidq1['department'];
		
		echo $asd;
	}
}
?>
