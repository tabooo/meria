<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='save_type'){
mysqlconnect();

		$name=safe($_POST['name']);
		//$pidq=mysql_query("SELECT * FROM company_types") or die(mysql_error());
		echo($name);
		
		mysql_query("INSERT INTO company_types VALUES (null,'$name')") or die(mysql_error());

		
		
}
?>