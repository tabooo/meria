<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='editcitizen'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['citizenid']!=""){
		$sql=" WHERE id=".safe($_POST['citizenid']);
		
		$citizen=mysql_fetch_array(mysql_query("SELECT * FROM citizens".$sql)) or die(mysql_error());
		
		$ctzntpid=$citizen['type'];
		$type=mysql_fetch_array(mysql_query("SELECT * FROM company_types WHERE id='$ctzntpid'")) or die(mysql_error());			
		
		$citid=$citizen['id'];
		$ctype=$type['type'];
		$cname=$citizen['name'];
		$cpid=$citizen['pid'];
		$caddress=$citizen['address'];
		
		
		
		echo '<br>';		
		echo '<h2>მოქალაქის რედაქტირება</h2>';
		
		echo '<br><select id="type" name="type">';		
		$qu=mysql_query("select * from company_types");
		echo '<option value="'.$type['id'].'">'.$type['type'].'</option>';
		while($client=mysql_fetch_array($qu)){
			echo '<option value="'.$client['id'].'">'.$client['type'].'</option>';
		 }
		echo '</select>';
		
		echo '<br>';
		echo '<input type="text" id="name" value="'.$cname.'">';
		echo '<input type="text" id="pid" value="'.$cpid.'">';
		echo '<input type="text" id="address" value="'.$caddress.'">';
		
		echo '<br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="update_citizen('.$citid.')" data-loading-text="Loading...">შენახვა</button>';
		echo '<br><div id="report"></div>';
		echo '<br><div id="report111"></div>';
		
		
	}
}
?>
