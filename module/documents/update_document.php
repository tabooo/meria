<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='update_document'){
mysqlconnect();

$cid=safe($_POST['cid']);
$externalid=safe($_POST['externalid']);
$cauthor=safe($_POST['cauthor']);
$ctimein=strtotime(safe($_POST['ctimein'])." 00:00:01");
$cregnumber=safe($_POST['cregnumber']);
$cannotation=safe($_POST['cannotation']);
$answer_doc_id=safe($_POST['answer_doc_id']);
$vada=safe($_POST['vada']);
	
			mysql_query("UPDATE documents SET externalid='$externalid', date='$ctimein', regnumber='$cregnumber', author='$cauthor', annotation='$cannotation', vada_id='$vada', answer_doc_id='$answer_doc_id' WHERE id='$cid'") or die(mysql_error());
			echo '<div class="alert alert-success">დოკუმენტი წარმატებით ჩასწორდა</div>';
		refreshpage(1, "?cat=edit_document&documentid=".$cid);
		die();

}

if(@$_POST['dos']=='delete_document' && $_POST['id']!=''){
	mysqlconnect();
	$id=safe($_POST['id']);
	$hasanswer=mysql_query("select * from documents where answer_doc_id='$id'");
	if(mysql_num_rows($hasanswer)<1){
		mysql_query("delete from rewrites WHERE did='$id'");
		mysql_query("delete from documents WHERE id='$id'") or die(mysql_error());
				echo '<div class="alert alert-success">დოკუმენტი წარმატებით წაიშალა</div>';
			refreshpage(0, "?cat=documents");
	} else {
		echo '<div class="alert alert-error">ამ დოკუემნტს აქვს პასუხი</div>';
	}
		die();

}

if(@$_POST['dos']=='delete_image' && $_POST['img']!="" && $_POST['docid']!=""){
	mysqlconnect();

	$docid=safe($_POST['docid']);
	$img=$_POST['img'];
	$doc=mysql_fetch_array(mysql_query("select * from documents where id='$docid'"));
	$photoslast=str_replace('|'.$img,'',$doc['filename']);
	mysql_query("update documents set filename='$photoslast' where id='$docid'") or die(mysql_error());
	if(file_exists("../uploadedimages/".$img))unlink("../uploadedimages/".$img);
	echo "სურათი წაიშალა";
	refreshpage(0,"?cat=edit_document&documentid=".$docid);
	die();
}


if(@$_POST['dos']=='save_updated_rewrites'){
mysqlconnect();
	$rewriteid=safe($_POST['rewriteid123']);
	$newaddressee=safe($_POST['newaddressee']);
	$newnotice=safe($_POST['newnotice']);
	$doc_type=safe($_POST['doc_type']);
	if($doc_type==1 || $doc_type==2){
	$struqture=mysql_fetch_array((mysql_query("SELECT post_id FROM workers WHERE id='".$newaddressee."'"))) or die(mysql_error());
		
		mysql_query("UPDATE rewrites SET  addressee_id='".$newaddressee."', structur_id='".$struqture['post_id']."', notice='".$newnotice."' WHERE id='".$rewriteid."'") or die(mysql_error());
				die('<div class="alert alert-success">დოკუმენტი წარმატებით ჩასწორდა</div>');
	}
	
	if($doc_type==3){		
		mysql_query("UPDATE rewrites SET  addressee_id='".$newaddressee."', structur_id='0', notice='".$newnotice."' WHERE id='".$rewriteid."'") or die(mysql_error());
				die('<div class="alert alert-success">დოკუმენტი წარმატებით ჩასწორდა</div>');
	}
}
?>