<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='searchcitizens'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['author']!="") $sql=" WHERE id=".safe($_POST['author']);
	
	$citizens=mysql_query("SELECT * FROM citizens".$sql) or die(mysql_error());
		
	echo '<table class="table table-hover"><tr><th>ტიპი</th><th>სახელი და გვარი</th><th>პირადი #</th><th>მისამართი</th></tr>';
	while($citizen=mysql_fetch_array($citizens)){
		$ctzntpid=$citizen['type'];
		$types=mysql_query("SELECT * FROM company_types WHERE id='$ctzntpid'") or die(mysql_error());
		$type=mysql_fetch_array($types);
				
		echo "<tr ondblclick='gotoeditproduct(\"".$citizen['id']."\")'></td><td>".$type['type']."</td><td>".$citizen['name']."</td><td>".$citizen['pid']."</td><td>".$citizen['address']."</td></tr>";
	}
	echo '</table>';

}
?>