<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='search_dep'){
	mysqlconnect();
	
	echo '<br><select id="type" name="type" onChange="changeposts()">';							
	$qu=mysql_query("select * from departments");
	while($client=mysql_fetch_array($qu)){		
		echo '<option value="'.$client['id'].'">'.$client['department'].'</option>';
	}
	echo '</select>';
	
	echo '<select id="typepost" name="typepost">';		
	$qu=mysql_query("select * from posts");
	while($client2=mysql_fetch_array($qu)){
		echo '<option value="'.$client2['id'].'">'.$client2['name'].'</option>';		
	 }
	echo '</select>';

}
?>