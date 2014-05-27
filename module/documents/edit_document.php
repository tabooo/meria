<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='editdocument'){
	mysqlconnect();
	
	$sql="";
	if(@$_POST['documentid']!=""){
		$sql=" WHERE id=".safe($_POST['documentid']);
		
		$doc=mysql_fetch_array(mysql_query("SELECT * FROM documents".$sql." order by id desc"));
		
		$cid=$doc['id'];
		$cdate=date('m/d/Y',$doc['date']);
		$cregnumber=$doc['regnumber'];		
		$cauthor=$doc['author'];		
		$cannotation=$doc['annotation'];
		$cfilename=$doc['filename'];
		$authors='';
		$author='';
		$str1='';
		$answer=mysql_num_rows(mysql_query("SELECT * FROM answers WHERE doc_id='".$doc['id']."'"));
		if($answer>0){
			$str1="disabled";
		}
		
		
		echo '<br>';		
		echo '<h2>დოკუმენტის რედაქტირება</h2>';
		echo '<input type="hidden" name="doc_type" id="doc_type" value="'.$doc['inner_outer'].'">';
		echo '<input type="hidden" name="docid" id="docid" value="'.$doc['id'].'">';
		echo '<input type="hidden" name="filename" id="filename" value="">';
		
		echo '<br>';
		echo '<ul class="thumbnails">';
		echo '<li class="span2"><a data-toggle="lightbox" href="#demoLightbox" class="thumbnail"><img src="module/uploadedimages/'.$doc['filename'].'" alt="სურათის გასადიდებლად დააჭირეთ სურათს"></a><button type="button" class="btn btn-primary" onclick="showchangeimageform()" >სურათის შეცვლა</button></li>';
		echo '<div id="demoLightbox" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">';
		echo '<div class="lightbox-content">';
		echo '<img src="module/uploadedimages/'.$doc['filename'].'">';
		//echo '<div class="lightbox-caption"><p>'.$doc['annotation'].'</p></div>';
		echo '</div>';
		echo '</div>';
		echo "</ul>";
		
		
		echo '<select '.$str1.' class="input-xxlarge" name="author1" id="author1" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">';
		if($doc['inner_outer']==1)
		{
			$author=mysql_fetch_array(mysql_query("select * from citizens WHERE id='$cauthor'"));		
			$qu1=mysql_query("select * from citizens");
			while($client12=mysql_fetch_array($qu1)){
				$selected="";
				if($author['id']==$client12['id']) $selected="selected";				 
				echo '<option '.$selected.' value="'.$client12['id'].'">'.$client12['name'].'-('.$client12['address'].')</option>';
				$selected="";
			}
		}
		if($doc['inner_outer']==2 || $doc['inner_outer']==3)
		{
			$author=mysql_fetch_array(mysql_query("select * from workers WHERE id='$cauthor'"));			
			$qu1=mysql_query("select * from workers");
			 while($client12=mysql_fetch_array($qu1)){
				 $selected="";
				 if($author['id']==$client12['id']) $selected="selected";
				 $dep2=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in (select dep_id from posts where id='".$client12['post_id']."')"));
				 echo '<option '.$selected.' value="'.$client12['id'].'">'.$client12['name'].'-('.$dep2['department'].')</option>';
				 $selected="";
			 }
		}
	   
			
			  
		echo '</select>';
		
		echo '<br>';
		
		echo '<div id="timein" class="input-append">';
		echo '<input '.$str1.' data-format="MM/dd/yyyy" type="text" class="input-small" id="date" name="date" value="'.$cdate.'"></input>';
		echo '<span class="add-on">';
		echo '<i data-time-icon="icon-time" data-date-icon="icon-calendar">';
		echo '</i>';
		echo '</span>';
		echo '</div>';
		?>
			<script type="text/javascript">
			  $(function() {
			 $('#timein').datetimepicker({
			   pickTime: false
			 });
			  });
			</script>
			
			
			<?php
				echo '<input type="hidden" name="vada_value" id="vada_value" value="'.$doc['vada_id'].'" >';
				$vadebi=mysql_query("select * from vada");
				$str='';
				echo '<div class="btn-group" data-toggle="buttons-radio" name="vada" id="vada">';
				while($vada=mysql_fetch_array($vadebi)){
				$str='';
				if($doc['vada_id']==$vada["id"]){
				 $str=' active';
				 
				}
				//echo '<input '.$str.' type="radio" name="vada" id="vada" value="'.$vada["id"].'">'.$vada["name"].'&nbsp;&nbsp;&nbsp;';
				echo '<button '.$str1.' type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'vada_value\').value=\''.$vada["id"].'\'" >'.$vada["name"].'</button>';
				$str='';
				
				}
				echo '</div>';
			
			
			echo '<br>';
		
		echo '<br>';
		echo '<input disabled type="text" name="regnumber" id="regnumber" value="'.$cregnumber.'">';
		echo '<br>';
		echo '<textarea '.$str1.' class="editor" type="text" name="annotation1" id="annotation1" value="'.$cannotation.'" placeholder="ანოტაცია">'.$cannotation.'</textarea>';
		
			
		
///////////--------------ADDRESSEES---------------<<<<<<<<<<<<
		echo '<div id=addresseesdiv>';
		$rewrites=mysql_query("SELECT * FROM rewrites WHERE did='$cid'");
		
		$i=0;
		
		while($rewrite=mysql_fetch_array($rewrites)){
		$i++;		
		$caddressee=$rewrite['addressee_id'];
		$cnotice=$rewrite['notice'];
		
		echo '<br>';
		if($doc['inner_outer']==1 || $doc['inner_outer']==2)
		{
		echo '<select '.$str1.' class="input" name="addressee'.$i.'" id="addressee'.$i.'" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">';
		$wrkr=mysql_fetch_array(mysql_query("select * from workers WHERE id='$caddressee'"));
	    echo '<option value="'.$wrkr['id'].'">'.$wrkr['name'].'-('.$dep1['department'].')</option>';			
		$qu2=mysql_query("select * from workers");
		while($client1=mysql_fetch_array($qu2)){
			$post_id=$client1['post_id'];
			$selected="";
			if($wrkr['id']==$client1['id']) $selected="selected";
			$dep=mysql_fetch_array(mysql_query("select * from departments WHERE id in (select dep_id from posts where id='$post_id')"));
			echo '<option '.$selected.' value="'.$client1['id'].'">'.$client1['name'].'-('.$dep['department'].')</option>';
			$selected="";
		}		
		echo '</select>';
		}
		
		if($doc['inner_outer']==1 || $doc['inner_outer']==2)
		{
		echo '<select '.$str1.' class="input" name="addressee'.$i.'" id="addressee'.$i.'" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">';
		$wrkr=mysql_fetch_array(mysql_query("select * from workers WHERE id='$caddressee'"));
	    echo '<option value="'.$wrkr['id'].'">'.$wrkr['name'].'-('.$dep1['department'].')</option>';			
		$qu2=mysql_query("select * from workers");
		while($client1=mysql_fetch_array($qu2)){
			$post_id=$client1['post_id'];
			$selected="";
			if($wrkr['id']==$client1['id']) $selected="selected";
			$dep=mysql_fetch_array(mysql_query("select * from departments WHERE id in (select dep_id from posts where id='$post_id')"));
			echo '<option '.$selected.' value="'.$client1['id'].'">'.$client1['name'].'-('.$dep['department'].')</option>';
			$selected="";
		}
		}
		if($doc['inner_outer']==3)
		{
		echo '<select '.$str1.' class="input" name="addressee'.$i.'" id="addressee'.$i.'" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">';
		$citid=mysql_fetch_array(mysql_query("select * from citizens WHERE id='$caddressee'"));
	    echo '<option value="'.$citid['id'].'">'.$citid['name'].'-('.$citid['address'].')</option>';			
		$qu2=mysql_query("select * from citizens");
		while($client1=mysql_fetch_array($qu2)){
			$post_id=$client1['post_id'];
			$selected="";
			if($citid['id']==$client1['id']) $selected="selected";			
			echo '<option '.$selected.' value="'.$client1['id'].'">'.$client1['name'].'-('.$client1['address'].')</option>';
			$selected="";
		}
		}

		echo '<input '.$str1.' type="text" name="notice'.$i.'" id="notice'.$i.'" value="'.$cnotice.'" placeholder="შენიშვნა">';		
		echo '<input type="text" class="input-small" style="width:40px;" value="'.$rewrite['level'].'" disabled>';
		echo '<button type="button"  class="btn btn-small btn-danger" id="delete'.$i.'" title="წაშლა" onclick="delete_addressee(\''.$rewrite["id"].'\',\''.$cid.'\')" data-loading-text="Loading...">x</button>'; ///DELETE ADDRESSEE
		echo '<button type="button"  class="btn btn-small btn-primary" id="save'.$i.'" title="შენახვა" onClick="save_addressee(\''.$rewrite["id"].'\',\''.$i.'\')" data-loading-text="Loading...">√</button><br>'; ///save ADDRESSEE
		}
		echo '</div>';
		///////////--------------ADDRESSEES--------------->>>>>>>>>>>>>>>>>>>>

	    echo '<br>';
		echo '<br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="update_document('.$cid.')" data-loading-text="Loading...">შენახვა</button>';
		echo '<br><div id="report"></div>';
		echo '<br><div id="report111"></div>';
		?>
		<?php include("../scannerimageform.php"); ?>
		<div id="changeimage" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">სურათის შეცვლა</h3>
		  </div>
		  <div class="modal-body" id="changeimage-body">
		  <?php include("../scannerimageform.php"); ?>
		  </div>
		  <div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">დახურვა</button>
		  </div>
		</div>
<script>		
$('#changeimage').css(
{
	'margin-left': function () {
		return ($(window).width()-$(this).width())/2;
	}
});

function showchangeimageform(){
    $("#changeimage").modal("show");
	//$.post('module/citizen/addcitizenform.php', function(data){
	  // $("#changeimage-body").html(data);
	//});
}
</script>
		<?php
		
	}
}
?>
