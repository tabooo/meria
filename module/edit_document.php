<?php
if(@$_GET['documentid']!=''){
	mysqlconnect();
	
	$sql="";

		$sql=" WHERE id=".safe($_GET['documentid']);
		
		$doc=mysql_fetch_array(mysql_query("SELECT * FROM documents".$sql." order by id desc"));
		$doctype=mysql_fetch_array(mysql_query("SELECT * FROM document_types where id='".$doc['inner_outer']."'"));
		
		$cid=$doc['id'];
		$externalid=$doc['externalid'];
		$cdate=date('m/d/Y',$doc['date']);
		$cregnumber=$doc['regnumber'];		
		$cauthor=$doc['author'];		
		$cannotation=$doc['annotation'];
		$cfilename=$doc['filename'];
		$answer_doc_id=$doc['answer_doc_id'];		
		$authors='';
		$author='';
		$str1='';
		$answer=mysql_num_rows(mysql_query("SELECT * FROM documents WHERE answer_doc_id='".$doc['id']."'"));
		//if($answer>0){
		//	$str1="disabled";
		//}
		
		$docimage=explode("|",$doc['filename']);
		echo "<div class='span8'><div class='hero-unit'>";
		echo '<br>';		
		echo '<h2>დოკუმენტის რედაქტირება</h2>';
		echo "<h3>".$doctype['name']."</h3>";
		echo '<input type="hidden" name="doc_type" id="doc_type" value="'.$doc['inner_outer'].'">';
		echo '<input type="hidden" name="docid" id="docid" value="'.$doc['id'].'">';
		echo '<input type="hidden" name="filename" id="filename" value="">';
		echo '<input type="text" readonly name="regnumber" id="regnumber" value="'.$cregnumber.'">';
		echo '<input type="text" name="externalid" id="externalid" value="'.$externalid.'" placeholder="გარე ნომერი">';
		echo '<br>';
		?>
		<select class="input-xxlarge" name="answer_doc_id" id="answer_doc_id" type="text" placeholder="დოკუმენტის პასუხად" data-provide="typeahead" data-items="4" <?php echo $str1; ?>>
			<option value="">დოკუმენტის პასუხად</option>
			<?php
			$qu=mysql_query("select * from documents");
			//$answr=mysql_query("select * from documents WHERE answer_doc_id=".$cid." limit 0,1");
			while($docs=mysql_fetch_array($qu)){
				$selected="";
				if($answer_doc_id==$docs['id']) $selected="selected";
				echo '<option value="'.$docs["id"].'" '.$selected.'>'.$docs["regnumber"].'</option>';
				$selected='';
			}
			?>  
		</select>
		<?php
		echo '<ul class="thumbnails">';
		//$i=1;
		//while($docimage[$i]!=""){
		for($i=1;$i<count($docimage);$i++){
			echo "<li class='span2'><a data-toggle='lightbox' href='#demoLightbox$i' class='thumbnail'><img src='module/uploadedimages/".$docimage[$i]."' alt='სურათის გასადიდებლად დააჭირეთ სურათს'></a><br><input type='button' value='წაშლა' class='btn btn-small btn-danger' onclick='deleteimage(\"".$docimage[$i]."\")'></li>";
			echo '<div id="demoLightbox'.$i.'" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">';
			echo '<div class="lightbox-content">';
			echo '<img src="module/uploadedimages/'.$docimage[$i].'">';
			//echo '<div class="lightbox-caption"><p>'.$doc['annotation'].'</p></div>';
			echo '</div>';
			echo '</div>';
			//$i++;
		}
		echo "</ul>";
		
		
		
		echo '<select '.$str1.' class="input-xxlarge" name="author1" id="author1" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" required onchange="">';
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
				echo '<button '.$str1.' type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'vada_value\').value=\''.$vada["id"].'\'" >'.$vada["name"].'</button>';
				$str='';
				
				}
				echo '</div>';
			
		
		echo '<br>';
		//echo '<input disabled type="text" name="regnumber" id="regnumber" value="'.$cregnumber.'">';
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
		if($answer<1){
			echo '<br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="update_document('.$cid.')" data-loading-text="Loading...">შენახვა</button>';
			//echo '<button type="button" class="btn btn-large btn-danger" onclick="delete_document(\''.$cid.'\')" >წაშლა</button>';
		}
		echo '<button type="button" class="btn btn-large btn-warning" onclick="get_scan_form()" >სურათის დამატება</button>';
		$hasanswer=mysql_query("select * from documents where answer_doc_id='$cid'");
		if(mysql_num_rows($hasanswer)>0){
			$ans=mysql_fetch_array($hasanswer);
			echo '<button type="button" class="btn btn-large btn-success" onclick="show_answer(\''.$ans["id"].'\')" >პასუხის ნახვა</button>';
		}
		
		echo '<br><div id="report"></div>';
		echo '<br><div id="report111"></div>';
		echo "<br><div name='scannerimageform' id='scannerimageform' style='visibility:hidden'>";
		include("module/scannerimageform.php");
		echo "</div>";
		echo "</div></div>";
		?>
		<?php //include("module/scannerimageform.php"); ?>
<script>
function get_scan_form(){
	$('#scannerimageform').css("visibility", "visible");		
}

function update_document(docid1){ 
	var cid=docid1;
	var cauthor = $('#author1').val();
	var externalid = $('#externalid').val();
	var ctimein = $('#date').val();
	var cregnumber = $('#regnumber').val();
	var cannotation = $('#annotation1').val();
	var vada = $('#vada_value').val();
	var answer_doc_id = $('#answer_doc_id').val();		
	if(cid!=""){
	$.post('module/documents/update_document.php',{dos:"update_document",cid:cid,externalid:externalid,cauthor:cauthor,ctimein:ctimein,cregnumber :cregnumber,cannotation:cannotation,vada:vada,answer_doc_id:answer_doc_id}, function(data){
		$("#report111").html(data);
	});
	} else {
		$("#report111").html('<div class="alert alert-error">გთხოვთ შეავსოთ ყველა ველი!</div>');
	}
	return false;
}

function delete_addressee(rewriteid2,docid11){
	var docid=docid11;
	var rewriteid=rewriteid2;
	
	$.post('module/rewrite/disable_addressee.php',{dos:"delete",docid:docid,rewriteid:rewriteid}, function(data){
		$("#addresseesdiv").html(data);
});

}

function save_addressee(rewriteid1,ii){
	var rewriteid123=rewriteid1;
	var nn=ii;		
	var newaddressee=$("#addressee"+nn).val();
	var newnotice=$("#notice"+nn).val();
	var doc_type = $('#doc_type').val();

	$.post('module/documents/update_document.php',{dos:"save_updated_rewrites",rewriteid123:rewriteid123,newaddressee:newaddressee, newnotice:newnotice,doc_type:doc_type}, function(data){
		$("#report111").html(data);
});

}

function delete_document(docid){
	$.post('module/documents/update_document.php',{dos:"delete_document",id:docid}, function(data){
		$("#report111").html(data);
	});
}

function show_answer(id){
	window.open("?cat=edit_document&documentid="+id);
}
</script>
		<?php
		
	
}
?>
