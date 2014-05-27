<?php
include("config.php");
?>

<?php
if(@$_POST['dos']=='login'){
mysqlconnect();
if(safe($_POST['username'])!="" || $_POST['password']!=""){
$username=safe($_POST['username']);
$loginquery=mysql_query("select * from users where username='$username'") or die(mysql_error());
$login=mysql_fetch_array($loginquery);
if($login['username']!=""){
	if($_POST['password']==$login['password']){

			$_SESSION['username']=$username;
			$_SESSION['role']=$login['role'];
			$_SESSION['userid']=$login['id'];
			echo '<div class="alert alert-success">ავტორიზაცია წარმატებით გაიარეთ<br>თუ ავტომატურად არ გადადის მთავარ გვერდზე <a href="index">დააჭირეთ აქ.</a></div>';
			echo '<meta http-equiv="refresh" content="0; URL=index">';
			die();
		
	}
	echo '<div class="alert alert-error">არასწორი პაროლი! </div>';
	die();
}
else {
echo '<div class="alert alert-error">არასწორი სახელი</div>'; die();
}
}
else die();
}


if(@$_GET['dos']=="logout"){
mysqlconnect();
session_destroy();
echo '<meta http-equiv="refresh" content="0; URL=login">';
}
?>
