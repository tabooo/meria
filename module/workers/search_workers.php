<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='searchcworkers'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['worker']!="") $sql=" WHERE id=".safe($_POST['worker']);
	
	$workers=mysql_query("SELECT * FROM workers".$sql) or die(mysql_error());
		
	echo '<table class="table table-hover"><tr><th>თანამდებობა</th><th>სახელი და გვარი</th><th>დაბადების თარიღი</th></tr>';
	while($worker=mysql_fetch_array($workers)){
		$post_id=$worker['post_id'];
		$types=mysql_query("SELECT * FROM departments WHERE id in (select dep_id from posts where id='$post_id')") or die(mysql_error());
		$type=mysql_fetch_array($types);
				
		echo "<tr ondblclick='gotoeditproduct(\"".$worker['id']."\")'></td><td>".$type['department']."</td><td>".$worker['name']."</td><td>".$worker['birthdate']."</td></tr>";
	}
	echo '</table>';

}
?>