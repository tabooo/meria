<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='save_post'){
mysqlconnect();
	$dep=safe($_POST['dep']);
	$name=safe($_POST['name']);

	mysql_query("INSERT INTO posts VALUES (null,'$name','$dep')") or die(mysql_error());
	echo '<div class="alert alert-success">'.$name.' დაემატა</div>';
}

if(@$_POST['dos']=='save_dep'){
mysqlconnect();	
	$name=safe($_POST['name']);

	mysql_query("INSERT INTO departments VALUES (null,'$name')") or die(mysql_error());
	echo '<div class="alert alert-success">'.$name.' დაემატა</div>';
		
}

if(@$_POST['dos']=='get_posts'){
	mysqlconnect();	
	$dep=safe($_POST['dep']);

	$posts=mysql_query("select * from posts where dep_id='$dep'");
	while($post=mysql_fetch_array($posts)){
		echo $post['name']."<br>";
	}
		
}
?>