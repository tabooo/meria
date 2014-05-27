<?php
include("../../config.php");
mysqlconnect();
if($_POST["dos"]=="save_document"){
	mysqlconnect();
	$date = strtotime($_POST["date"]." 00:00:01");
	$address1 = $_POST["address123"];
	$author = $_POST["author"];
	$annotation = $_POST["annotation"];
	$vada=$_POST["vada_value"];
	$document_type=$_POST["doc_type"];	
	$notice = $_POST["notice"];
	//$docid = $_POST["docid"];
	$externalid = $_POST["externalid"];
	
	$answer_doc_id = $_POST["answer_doc_id"];
	$answer_doc_id2="";
	
	if($answer_doc_id!=""){
		$checkanswer=mysql_query("select * from documents where regnumber='$answer_doc_id' limit 0,1") or die(mysql_error());
		if(mysql_num_rows($checkanswer)<1) die('||<div class="alert alert-error">პასუხის ველში ჩაწერილი დოკუმენტის რეგისტრაციის ნომერი არ მოიძებნა ბაზაში</div>');
		$answer_doc_id_query=mysql_fetch_array($checkanswer);
		$answer_doc_id2=$answer_doc_id_query['id'];
	}
	
	$_SESSION['docid']="";
	$regnumber2=mysql_fetch_array(mysql_query("select * from document_types where id='$document_type'"));
	$regnumber1=$regnumber2["numeration"]+1;
	if($document_type==1) $regnumber1=$regnumber2["numeration"]+1;
	if($document_type==2) $regnumber1=($regnumber2["numeration"]+1)."/1";
	if($document_type==3) $regnumber1="1/".($regnumber2["numeration"]+1);
	
	mysql_query("INSERT INTO documents VALUES (null,'".$_SESSION['userid']."','$date','$address1','$regnumber1','$author','$annotation','','$document_type','$vada','$externalid','".$answer_doc_id2."')") or die(mysql_error());
	$docid=mysql_insert_id();
	$_SESSION['docid']=$docid;
	mysql_query("update document_types set numeration=numeration+1 where id='$document_type'");
	
	if($document_type==1){
		$addresseefromtag = $_POST["addresseefromtag"];
		$adds=explode(",",$addresseefromtag);
		$i=1;
		while($adds[$i]!=""){
			$worker=mysql_fetch_array(mysql_query("select * from workers where id='".$adds[$i]."'"));
			mysql_query("insert into rewrites values (null,'$docid', '".$adds[$i]."', '".$worker['post_id']."', '$notice', '1')");
			$i++;
		}
		echo $docid."|".$regnumber1."|".'<div class="alert alert-success">დოკუმენტი წარმატებით შეინახა. გთხოვთ დაასკანიროთ სურათი და დააჭიროთ "სურათის ატვირთვ"–ის ღილაკს</div>';
		//refreshPage(2,"?cat=documents");
		die();			
	}
	
	if($document_type==2){
		$addresseefromtag = $_POST["addresseefromtag"];
		$adds=explode(",",$addresseefromtag);
		$i=1;
		while($adds[$i]!=""){
			$worker=mysql_fetch_array(mysql_query("select * from workers where id='".$adds[$i]."'"));
			mysql_query("insert into rewrites values (null,'$docid', '".$adds[$i]."', '".$worker['post_id']."', '$notice', '1')") or die(mysql_error());
			$i++;
		}
		echo $docid."|".$regnumber1."|".'<div class="alert alert-success">დოკუმენტი წარმატებით შეინახა. გთხოვთ დაასკანიროთ სურათი და დააჭიროთ "სურათის ატვირთვ"–ის ღილაკს</div>';
		//refreshPage(2,"?cat=documents");
		die();	
	}
	
	if($document_type==3){ 
		$addresseefromtag = $_POST["addresseefromtag"];
		$adds=explode(",",$addresseefromtag);
		$i=1;
		while($adds[$i]!=""){
			$citizen=mysql_fetch_array(mysql_query("select * from citizens where id='".$adds[$i]."'"));
			mysql_query("insert into rewrites values (null,'$docid', '".$adds[$i]."', '0', '$notice', '1')");
			$i++;
		}
		echo $docid."|".$regnumber1."|".'<div class="alert alert-success">დოკუმენტი წარმატებით შეინახა. გთხოვთ დაასკანიროთ სურათი და დააჭიროთ "სურათის ატვირთვ"–ის ღილაკს</div>';
		die();	
	}
}
if($_POST["dos"]=="delete_file"){
	$filename=$_POST["filename"];
	$path="../uploadedimages/";
	if (file_exists($path . $filename))
	{
		unlink($path . $filename);
	}
}
?>
