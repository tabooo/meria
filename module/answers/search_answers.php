<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='searchdoc'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['fromtimein']!="") $sql.=" AND date>=".safe($_POST['fromtimein']);
	if(@$_POST['totimein']!="") $sql.=" AND date<=".safe($_POST['fromtimein']);
	if(@$_POST['author']!="") $sql.=" AND author=".safe($_POST['author']);
	
	$answers=mysql_query("SELECT * FROM documents where answer_doc_id!=''") or die(mysql_error());	

		
	echo '<table class="table table-hover"><tr><th>#</th><th>თარიღი</th><th>ავტორი</th><th>ადრესატი</th></tr>';
	while($answer=mysql_fetch_array($answers)){
		$answer_author=$answer['author'];

		$authors="";
		$author="";
		
		//$document=mysql_fetch_array(mysql_query("SELECT * FROM documents WHERE id='".$answer['doc_id']."'"));
		
		$addresse='';
		if($answer['inner_outer']==1){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM citizens WHERE id='".$answer['author']."'"));
			$authors=mysql_query("SELECT name FROM workers WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
		}
		if($answer['inner_outer']==2){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$answer['author']."'"));
			$authors=mysql_query("SELECT name FROM workers WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
		}
		if($answer['inner_outer']==3){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$answer['author']."'"));
			$authors=mysql_query("SELECT name FROM citizens WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
		}
				
		echo "<tr ondblclick='editdocument(\"".$answer['id']."\")'><td>".$answer['regnumber']."</td><td>".date('m/d/Y',$answer['date'])."</td><td>".$author['name']."</td><td>".$addresse['name']."</td></tr>";
		
	}
	echo '</table>';

}

if(@$_POST['dos']=='after_save'){
	mysqlconnect();
	
	$answers=mysql_query("SELECT * FROM answers ORDER BY id DESC") or die(mysql_error());	

		
	echo '<table class="table table-hover"><tr><th>#</th><th>თარიღი</th><th>ავტორი</th><th>ადრესატი</th></tr>';
	while($answer=mysql_fetch_array($answers)){
		$answer_author=$answer['author'];

		$authors="";
		$author="";
		
		$document=mysql_fetch_array(mysql_query("SELECT * FROM documents WHERE id='".$answer['doc_id']."'"));
		
		$addresse='';
		if($document['inner_outer']==1){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM citizens WHERE id='".$document['author']."'"));
			$authors=mysql_query("SELECT name FROM workers WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
		}
		if($document['inner_outer']==2){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$document['author']."'"));
			$authors=mysql_query("SELECT name FROM workers WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
		}
		if($document['inner_outer']==3){
			$addresse=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$document['author']."'"));
			$authors=mysql_query("SELECT name FROM citizens WHERE id='$answer_author'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
		}
				
		echo "<tr ondblclick='editdocument(\"".$answer['id']."\")'><td>".$document['regnumber']."</td><td>".date('m/d/Y',$answer['date'])."</td><td>".$author['name']."</td><td>".$addresse['name']."</td></tr>";
		
	}
	echo '</table>';
	
}
?>

