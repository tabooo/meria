<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='searchdocs'){
	mysqlconnect();
	
	$docid=safe($_POST['docid']);	
	
		$docs=mysql_query("SELECT * FROM documents WHERE id='$docid'") or die(mysql_error());	
		$doc=mysql_fetch_array($docs);		
				
		echo '<br>';
		echo '<ul class="thumbnails">';
		echo '<li class="span2"><a data-toggle="lightbox" href="#demoLightbox" class="thumbnail"><img src="module/uploadedimages/'.$doc['filename'].'" alt="სურათის გასადიდებლად დააჭირეთ სურათს"></a></li>';
		echo '<div id="demoLightbox" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">';
		echo '<div class="lightbox-content">';
		echo '<img src="module/uploadedimages/'.$doc['filename'].'">';
		//echo '<div class="lightbox-caption"><p>'.$doc['annotation'].'</p></div>';
		echo '</div>';
		echo '</div>';
		echo "</ul>";
		
		echo '<input type="text" placeholder='.date("Y-m-d H:i:s",$doc['date']).' readonly>';
		echo '<br>';
		
		$cid=$doc['author'];
		
		if($doc['inner_outer']==1){
			$authors=mysql_query("SELECT * FROM citizens WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
			echo '<input type="text" placeholder="'.$author['name'].'" readonly>';
		    echo '<input class="input-xxlarge" type="text" placeholder="'.$author['address'].'" readonly>';
		}
		else if($doc['inner_outer']==2){
			$authors=mysql_query("SELECT * FROM workers WHERE id='$cid'") or die(mysql_error());
			$author=mysql_fetch_array($authors);
			$post=mysql_fetch_array(mysql_query("SELECT * FROM posts WHERE id='".$author['post_id']."'"));
			$dep=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id='".$post['dep_id']."'"));
			echo '<input type="text" placeholder="'.$author['name'].'" readonly>';
			echo '<br>';
			echo '<input class="input-xxlarge" type="text" placeholder="'.$dep['department'].' - '.$post['name'].'" readonly>';
		}
		
		echo '<br>';
		echo '<input type="text" placeholder='.$doc['regnumber'].' readonly>';
		echo '<br>';
		echo '<textarea class="editor" type="text" placeholder="'.$doc['annotation'].'" readonly></textarea>';
		echo '<br>';
		
		$wids=mysql_query("select * from rewrites where did='".$docid."'");
		while($wid=mysql_fetch_array($wids)){
			if($doc['inner_outer']==1 || $doc['inner_outer']==2){
				$workers=mysql_query("SELECT * FROM workers WHERE id='".$wid['addressee_id']."'") or die(mysql_error());
				$worker=mysql_fetch_array($workers);
				echo '<input type="text" value="'.$worker["name"].'" readonly><input type="text" value="'.$wid["notice"].'" readonly>';
				
				echo '<input type="text" class="input-small" style="width:40px;" value="'.$wid['level'].'" readonly><br>';
			} else if($doc['inner_outer']==3){
				$workers=mysql_query("SELECT * FROM citizens WHERE id='".$wid['addressee_id']."'") or die(mysql_error());
				$worker=mysql_fetch_array($workers);
				echo '<input type="text" value="'.$worker["name"].'" readonly><input type="text" value="'.$wid["notice"].'" readonly>';
				
				echo '<input type="text" class="input-small" style="width:40px;" value="'.$wid['level'].'" readonly><br>';
			}
			
		}

		echo '<select class="input" name="newaddressee" id="newaddressee" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" style="float:left" onchange="selectaddresseetag()">';
	   echo '<option value="">აირჩიეთ ადრესატი</option>';
		$qu=mysql_query("select * from workers");
		 while($worker2=mysql_fetch_array($qu)){
			 $workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker2['post_id']."')"));
			 echo '<option value="'.$worker2['id'].'">'.$worker2['name'].'-('.$workerpost['department'].')</option>';
		 }
		echo '</select>';
			
		
		
		echo '<input type="text" id="newnotice" placeholder="ახალი შენიშვნა" >';

	    
	    echo '<br>';
	    echo '<div class="bootstrap-tagsinput" id="addresseetags"></div>';
		echo '<input type="hidden" id="addresseefromtag" name="addresseefromtag" value="">';
	    echo '<br>';
		echo '<input type="button"  class="btn btn-large btn-primary" id="save_rewrite" name="save_rewrite" onclick="save_rewrite()" data-loading-text="Loading..." value="გადაწერა">';
		echo '<br><div name="report"></div>';
	
	
	
}
?>

