<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='searchdoc'){
	mysqlconnect();
	$frompage=0;
	$pagenumber=1;
	if($_POST['pagenumber']!='') $pagenumber=$_POST['pagenumber'];
	$frompage=($pagenumber-1)*20;
	
	$sql="";	
	if(@$_POST['fromtimein']!="") $sql.=" AND date>=".safe($_POST['fromtimein']);
	if(@$_POST['totimein']!="") $sql.=" AND date<=".safe($_POST['fromtimein']);
	if(@$_POST['author']!="") $sql.=" AND author=".safe($_POST['author']);
	if(@$_POST['regnumbersearch']!="") $sql.=" AND regnumber like '%".safe($_POST['regnumbersearch'])."%'";
	if(@$_POST['doctype']!="") $sql.=" AND inner_outer='".safe($_POST['doctype'])."'";
	$docs=mysql_query("SELECT * FROM documents WHERE user!=''$sql ORDER BY id DESC LIMIT $frompage,20") or die(mysql_error());
	
	$sul=mysql_num_rows(mysql_query("SELECT * FROM documents WHERE user!=''$sql"));	
	echo $sul."|||";
	echo '<table class="table table-hover"><tr><th>#</th><th>თარიღი</th><th>ავტორი</th><th>ადრესატი</th></tr>';
	$addressees=array();
	if(@$_POST['addressee']!=""){
		$adds=mysql_query("select did from rewrites where addressee_id=".safe($_POST['addressee']));
		while($add=mysql_fetch_array($adds)){
			$addressees[] = $add['did'];
		}
	}
	
	$docs2=mysql_query("SELECT * FROM documents WHERE user!=''$sql ORDER BY id DESC") or die(mysql_error());
	$docsarr=array();
	while($doc12=mysql_fetch_array($docs2)){
		$docsarr[] = $doc12;
	}
	echo $docsarr[0]['date'];
	echo count($addressees);
	if(count($addressees)>0){
		foreach($docsarr as $doc2){
			echo $doc2['id']."///";
			if(!in_array($doc2, $addressees)) unset($doc2);
		}
	}
	//while($doc=mysql_fetch_array($docs)){
	/*foreach ($docsarr as $doc){
		//if(count($addressees)>0 && !in_array($doc['id'], $addressees)) continue;
		$cid=$doc['author'];
		
		$authors='';
		$author='';
		$addresse=mysql_fetch_array(mysql_query("SELECT * FROM rewrites WHERE did='".$doc['id']."'"));		
		$addr="";
		if($doc['inner_outer']==1){
			$authors=mysql_query("SELECT name FROM citizens WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);				
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$addresse['addressee_id']."'"));
		}
		if($doc['inner_outer']==2){
			$authors=mysql_query("SELECT name FROM workers WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$addresse['addressee_id']."'"));
		}
		if($doc['inner_outer']==3){
			$authors=mysql_query("SELECT name FROM workers WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM citizens WHERE id='".$addresse['addressee_id']."'"));
		}
		
				
		$str1='';
		$vada=mysql_fetch_array(mysql_query("SELECT * FROM vada WHERE id='".$doc['vada_id']."'"));
		$answer=mysql_num_rows(mysql_query("SELECT * FROM documents WHERE answer_doc_id='".$doc['id']."'"));
		if((time()-$doc['date'])>($vada['vada']*24*3600)){
		 $str1="class='error'";
		}
		if($answer>0){
			$str1="class='success'";
		}
		echo "<tr ".$str1." ondblclick='editdocument(\"".$doc['id']."\")'><td>".$doc['regnumber']."</td><td>".date('m/d/Y',$doc['date'])."</td><td>".$author['name']."</td><td>".$addr['name']."</td></tr>";
		$str1='';
	}*/
	echo '</table>';
	
	$pages=ceil($sul/20);
	$pagefto=ceil($pagenumber/10)*10;
	$pagefrom=$pagefto-9;

	echo '<div class="pagination pagination-centered" style="cursor: pointer"><ul>';
	$disabled='';
	
	if($pagefrom<10) $disabled='disabled';
	echo ' <li class="'.$disabled.'" onClick="if(!this.classList.contains(\'disabled\')){$(\'#pagenumber\').val(\''.($pagefrom-10).'\');searchdoc();}"><a>«</a></li>';
	$disabled='';
	
	for($i=$pagefrom;$i<=$pagefto;$i++){
		if($pagenumber==$i) $disabled='active';
		//if($i==1 && $pagenumber=="") $disabled='active';
		echo '<li class="'.$disabled.'" onClick="$(\'#pagenumber\').val(\''.$i.'\');searchdoc();"><a>'.$i.'</a></li>';
		//echo ' <input type="button"  class="btn '.$disabled.'" onClick="$(\'#pagenumber\').val(\''.$i.'\'); searchdoc();" value="'.$i.'">';
		$disabled='';
	}
	
	if($pagefto>$pages) $disabled='disabled';
	echo ' <li class="'.$disabled.'" onClick="if(!this.classList.contains(\'disabled\')){$(\'#pagenumber\').val(\''.($pagefto+1).'\');searchdoc();}"><a>»</a></li>';
	$disabled='';
	echo '</div>';
}

if(@$_POST['dos']=='after_save'){
	mysqlconnect();
	
	$docs=mysql_query("SELECT * FROM documents ORDER BY id DESC") or die(mysql_error());	

		
	echo '<table class="table table-hover"><tr><th>#</th><th>თარიღი</th><th>ავტორი</th><th>ადრესატი</th></tr>';
	while($doc=mysql_fetch_array($docs)){
		$cid=$doc['author'];
		
		$authors='';
		$author='';
		$addresse=mysql_fetch_array(mysql_query("SELECT * FROM rewrites WHERE did='".$doc['id']."'"));		
		$addr="";
		if($doc['inner_outer']==1){
			$authors=mysql_query("SELECT name FROM citizens WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);				
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$addresse['addressee_id']."'"));
		}
		if($doc['inner_outer']==2){
			$authors=mysql_query("SELECT name FROM workers WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM workers WHERE id='".$addresse['addressee_id']."'"));
		}
		if($doc['inner_outer']==3){
			$authors=mysql_query("SELECT name FROM workers WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);			
			$addr=mysql_fetch_array(mysql_query("SELECT * FROM citizens WHERE id='".$addresse['addressee_id']."'"));
		}
		
		$str1='';
		$vada=mysql_fetch_array(mysql_query("SELECT * FROM vada WHERE id='".$doc['vada_id']."'"));
		$answer=mysql_num_rows(mysql_query("SELECT * FROM documents WHERE answer_doc_id='".$doc['id']."'"));
		if((time()-$doc['date'])>($vada['vada']*24*3600)){
		 $str1="class='error'";
		}
		if($answer>0){
			$str1="class='success'";
		}
		
		echo "<tr ".$str1." ondblclick='editdocument(\"".$doc['id']."\")'><td>".$doc['regnumber']."</td><td>".date('m/d/Y',$doc['date'])."</td><td>".$author['name']."</td><td>".$addr['name']."</td></tr>";
	}
	echo '</table>';
	
}

if(@$_POST['dos']=='searchfromnewdocument' && @$_POST['search']!=""){
	
	//get the q parameter from URL
	$q=$_POST["search"];

	//lookup all links from the xml file if length of q>0
	if (strlen($q)>0)
	{
		mysqlconnect();
		$docs=mysql_query("select * from documents where regnumber like '$q%' order by id asc limit 0,5") or die(mysql_error());
		$hint="";
		while($doc=mysql_fetch_array($docs)){
				$hint.= "<a onclick='$(\"#answer_doc_id\").val(\"".$doc['regnumber']."\")'> ".$doc['regnumber']."</a><br>";
		}
	}

	// Set output to "no suggestion" if no hint were found
	// or to the correct values
	if ($hint=="")
	  {
	  $response="ასეთი დოკუმენტი ვერ მოიძებნა";
	  }
	else
	  {
	  $response=$hint;
	  }

	//output the response
	echo $response;
}

if(@$_POST['dos']=='searchauthorsfromdocuments' && @$_POST['search']!=""){
	
	$q=$_POST["search"];

	if (strlen($q)>0)
	{
		mysqlconnect();
		$hint="";
		$docs=mysql_query("select * from citizens where name like '%$q%' order by id asc limit 0,5") or die(mysql_error());
		while($doc=mysql_fetch_array($docs)){
			$hint.= "<a onclick='$(\"#author\").val(\"".$doc['name']."\");$(\"#authorid\").val(\"".$doc['id']."\");$(\"#livesearchauthor\").css(\"visibility\", \"hidden\");'> ".$doc['name']."-(".$doc['address'].")</a><br>";
		}
		
		$docs2=mysql_query("select * from workers where name like '%$q%' order by id asc limit 0,5") or die(mysql_error());
		while($doc1=mysql_fetch_array($docs2)){
			$workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$doc1['post_id']."')"));
			$hint.= "<a onclick='$(\"#author\").val(\"".$doc1['name']."\");$(\"#authorid\").val(\"".$doc1['id']."\");$(\"#livesearchauthor\").css(\"visibility\", \"hidden\");''> ".$doc1['name']."-(".$workerpost['department']."</a><br>";
		}
	}

	if ($hint=="")
	  {
	  $response="";
	  }
	else
	  {
	  $response=$hint;
	  }

	echo $response;
}

if(@$_POST['dos']=='searcaddresseefromdocuments' && @$_POST['search']!=""){
	
	$q=$_POST["search"];

	if (strlen($q)>0)
	{
		mysqlconnect();
		$hint="";
		$addressees=mysql_query("select * from citizens where name like '%$q%' and id in (select addressee_id from rewrites) order by id asc limit 0,5") or die(mysql_error());
		while($add=mysql_fetch_array($addressees)){
			$hint.= "<a onclick='$(\"#addressee\").val(\"".$add['name']."\");$(\"#addresseeid\").val(\"".$add['id']."\");$(\"#livesearchaddressee\").css(\"visibility\", \"hidden\");'> ".$add['name']."-(".$add['address'].")</a><br>";
		}
		
		$addressees2=mysql_query("select * from workers where name like '%$q%' and id in (select addressee_id from rewrites) order by id asc limit 0,5") or die(mysql_error());
		while($add2=mysql_fetch_array($addressees2)){
			$workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$add2['post_id']."')"));
			$hint.= "<a onclick='$(\"#addressee\").val(\"".$add2['name']."\");$(\"#addresseeid\").val(\"".$add2['id']."\");$(\"#livesearchaddressee\").css(\"visibility\", \"hidden\");''> ".$add2['name']."-(".$workerpost['department']."</a><br>";
		}
	}

	if ($hint=="")
	  {
	  $response="";
	  }
	else
	  {
	  $response=$hint;
	  }

	echo $response;
}
?>

