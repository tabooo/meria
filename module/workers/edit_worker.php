<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='editworker'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['workerid']!=""){
		$sql=" WHERE id=".safe($_POST['workerid']);
		
		$worker=mysql_fetch_array(mysql_query("SELECT * FROM workers".$sql)) or die(mysql_error());
		
		$workerpost=$worker['post_id'];
		
		
		$citid=$worker['id'];
		$ctype=$worker['post_id'];
		$cname=$worker['name'];
		$cpid=$worker['pid'];
		$birthday=$worker['birthdate'];
		
		
		
		echo '<br>';		
		echo '<h2>თანამშრომლის რედაქტირება</h2>';
		
		echo '<br><select id="type" name="type" onChange="changeposts()">';
		$type=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in (select dep_id from posts where id='$workerpost')")) or die(mysql_error());					
		$qu=mysql_query("select * from departments");
		while($client=mysql_fetch_array($qu)){
			$selected="";
			if($type['id']==$client['id']) $selected="selected";
			echo '<option '.$selected.' value="'.$client['id'].'">'.$client['department'].'</option>';
			$selected="";
		 }
		echo '</select>';
		
		echo '<select id="typepost" name="typepost">';
		$typepost=mysql_fetch_array(mysql_query("SELECT * FROM posts where id='$workerpost'")) or die(mysql_error());					
		$qu=mysql_query("select * from posts where dep_id='".$type['id']."'");
		while($client2=mysql_fetch_array($qu)){
			$selected="";
			if($typepost['id']==$client2['id']) $selected="selected";
			echo '<option '.$selected.' value="'.$client2['id'].'">'.$client2['name'].'</option>';
			$selected="";
		 }
		echo '</select>';
		
		echo '<br>';
		echo '<input type="text" id="name" value="'.$cname.'" placeholder="სახელი და გვარი">';
		echo '<input type="text" id="pid" value="'.$cpid.'" placeholder="პირადო ნომერი">';
		
		echo '<br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="update_worker('.$citid.')" data-loading-text="Loading...">შენახვა</button>';
		
		echo '<br><div id="report111"></div>';
		
		
	}
}
?>
