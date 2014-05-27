<?php
include("../../config.php");
?>

<?php
////////////----------REMOVE REWRITE-------------
if(@$_POST['dos']=='delete'){
	mysqlconnect();
	
	$rewriteid=safe($_POST['rewriteid']);	
	$docid=safe($_POST['docid']);	
	
	mysql_query("DELETE FROM rewrites WHERE id='".$rewriteid."'") or die(mysql_error());
	draw($docid);
}
///////////////////////////////////////////////

////////////----------ADD REWRITE-------------
if(@$_POST['dos']=='add'){
	mysqlconnect();
	
	$docid=safe($_POST['docid']);	
	draw($docid);
}
///////////////////////////////////////////////


function draw($cid){
	$rewrites=mysql_query("SELECT * FROM rewrites WHERE did='$cid'");
		
	$i=0;
	
	while($rewrite=mysql_fetch_array($rewrites)){
	$i++;		
	$caddressee=$rewrite['addressee_id'];
	$cnotice=$rewrite['notice'];
	
	echo '<br>';
	echo '<select class="input" name="addressee'.$i.'" id="addressee'.$i.'" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">';
	$wrkr=mysql_fetch_array(mysql_query("select * from workers WHERE id='$caddressee'"));		
	$qu2=mysql_query("select * from workers");
	while($client1=mysql_fetch_array($qu2)){
		$selected="";
		if($wrkr['id']==$client1['id']) $selected="selected";
		$post_id=$client1['post_id'];
		$dep=mysql_fetch_array(mysql_query("select * from departments WHERE id in (select dep_id from posts where id='$post_id')"));
		echo '<option '.$selected.' value="'.$client1['id'].'">'.$client1['name'].'-('.$dep['department'].')</option>';
		$selected="";
	}
		  
	echo '</select>';
	
	echo '<input type="text" name="notice'.$i.'" id="notice'.$i.'" value="'.$cnotice.'">';		
	echo '<input type="text" class="input-small" style="width:40px;" value="'.$rewrite['level'].'" disabled>';
	echo '<button type="button"  class="btn btn-small btn-danger" id="delete'.$i.'" title="წაშლა" onclick="delete_addressee(\''.$rewrite["id"].'\',\''.$cid.'\')" data-loading-text="Loading...">x</button>'; ///DELETE ADDRESSEE
	echo '<button type="button"  class="btn btn-small btn-primary" id="save'.$i.'" title="შენახვა" onClick="save_addressee(\''.$rewrite["id"].'\',\''.$i.'\')" data-loading-text="Loading...">√</button><br>'; ///save ADDRESSEE
	

	}
		
}

?>

