<?php
include("config.php");
$docid=$_GET['docid'];
if($docid!=""){
mysqlconnect();
	$type=explode(".",$_FILES["RemoteFile"]["name"]);
	$newname=rand(10,100).time().".".$type[1];
	$path="module/uploadedimages/";

	/*$oldfile=mysql_fetch_array(mysql_query("select * from documents where id='$docid'"));
	if($oldfile['filename']!="" && file_exists($path . $oldfile['filename'])){
		unlink($path . $oldfile['filename']);
	}*/

	if (file_exists($path . $newname))
	{
		$newname=rand(10,100).time().".".$type[1];
	}
	move_uploaded_file($_FILES['RemoteFile']['tmp_name'], $path.$newname);
	$newname1="|".$newname;
	mysql_query("update documents set filename=CONCAT(filename,'$newname1') where id='$docid'") or die(mysql_error());
	$photos=mysql_fetch_array(mysql_query("select * from documents where id='$docid'"));
	//echo $photos['filename'];
	$docimage=explode("|",$photos['filename']);
	echo '<ul class="thumbnails">';
		$i=1;
		while($docimage[$i]!=""){
			echo "<li class='span2'><a data-toggle='lightbox' href='#demoLightbox$i' class='thumbnail'><img src='module/uploadedimages/".$docimage[$i]."' alt='სურათის გასადიდებლად დააჭირეთ სურათს'></a><br><input type='button' value='წაშლა' class='btn btn-small btn-danger' onclick='deleteimage(\"".$docimage[$i]."\")'></li>";
			echo '<div id="demoLightbox'.$i.'" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">';
			echo '<div class="lightbox-content">';
			echo '<img src="module/uploadedimages/'.$docimage[$i].'">';
			//echo '<div class="lightbox-caption"><p>'.$doc['annotation'].'</p></div>';
			echo '</div>';
			echo '</div>';
			$i++;
		}
		echo "</ul>";
}
?> 
