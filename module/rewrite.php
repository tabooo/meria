 <script type="text/javascript" >
function searchdoc(){
	var get_id = document.getElementById('docid');
	//var docid = get_id.options[get_id.selectedIndex].value;
	var docid = get_id.value;
	
	$.post('module/rewrite/search_document_for_rewrite.php',{dos:"searchdocs",docid:docid}, function(data){
		$("#report").html(data);
	});
}

function save_rewrite(){
	var addresseefromtag=$('#addresseefromtag').val();
	var newnotice=$('#newnotice').val();
	
	var get_id = document.getElementById('docid');
	//var docid1 = get_id.options[get_id.selectedIndex].value;
	var docid1 = get_id.value;
	//var docid2=$('#docid').val();;

	$.post('module/rewrite/save_rewrite.php',{dos:"save_rewrite",docid1:docid1,addresseefromtag:addresseefromtag,newnotice:newnotice}, function(data){
		$("#report").html(data);
	});
}

function get_search_form(){
	$.post('module/rewrite/get_search_form.php',{dos:"get_search_form"}, function(data){
	$("#search").html(data);
	});
}

function showresultdocs(str){
	if (str.length==0) {$("#livesearchdocuments").html('');$("#docid").val('');}
	if(str.length>0){
		$.post('module/documents/search_documents.php',{dos:'searchdocumentsbystr',search:str}, function(data){
			$("#livesearchdocuments").css("visibility", "visible");
			$("#livesearchdocuments").html(data);
		});
	}
}
</script>

<div class="span8">
<div class="hero-unit">
<h2>გადაწერა</h2>
	   		
			
			<div id='search'></div><br>
			<input type="hidden" size="30" id="docid">
			<input type="text" size="30" placeholder="საძიებო" onchange="showresultdocs(this.value)" style=" float:left; width:300px">			
<!--<select class="input-xxlarge" name="docid" id="docid" type="text" placeholder="საძიებო" data-provide="typeahead" data-items="10">
	<option value="">საძიებო</option>
	<?php
		/*mysqlconnect();
		$docs=mysql_query("select * from documents where inner_outer='1' OR inner_outer='2'");
		while($dokuments=mysql_fetch_array($docs)){
			$avtori='';
			if($dokuments['inner_outer']==1 || $dokuments['inner_outer']==3){
				$author=mysql_fetch_array(mysql_query("select * from citizens WHERE id='".$dokuments['author']."'"));
				$avtori=" ( ".$author['name'].', '.$author['address']." )";
			}
			if($dokuments['inner_outer']==2){
				$author=mysql_fetch_array(mysql_query("select * from workers WHERE id='".$dokuments['author']."'"));
				$dep=mysql_fetch_array(mysql_query("select * from departments WHERE id in (SELECT dep_id FROM posts WHERE id='".$author['post_id']."')"));
				$avtori=" ( ".$author['name'].', '.$dep['department']." )";
			}
			echo '<option value="'.$dokuments['id'].'">'.$dokuments['regnumber'].' '.date('Y-m-d',$dokuments['date']).$avtori.'</option>';
		}*/
	?> --> 
</select>
<input type="button"  class="btn btn-primary" id="save" name="submit" onclick="searchdoc()" data-loading-text="Loading..." value="ძებნა">

<br><div id="livesearchdocuments" style="position:absolute; display:block; float:left; width:250px; border:1px solid black; cursor: pointer; background-color:white; margin-top:10px; vitibility:hidden"></div>

<br><div id='report'></div>

</div>

</div><!--/span-->


<script>
function selectaddresseetag(){
	var name=$('#newaddressee').find('option:selected').text();
	var id=$('#newaddressee').find('option:selected').val();
	if(!document.getElementById("tags"+id)){
		var i=0;
		while(document.getElementById("tags"+i)){
			i++;
		}
		$("#addresseetags").append('<span class="tag label label-info" id="tags'+id+'">'+name+'<span data-role="remove" onClick="removetag(\''+id+'\')"></span></span>');
		if($("#addresseefromtag").val()!=""){
			$("#addresseefromtag").val($("#addresseefromtag").val()+id+",");
		} else {
			$("#addresseefromtag").val($("#addresseefromtag").val()+","+id+",");
		}
		getaddresses();
	}
}

function removetag(id){
	$("#tags"+id).remove();
	//var str = $("#addresseefromtag").val();
	//str = str.replace(','+id,"");
	$("#addresseefromtag").val($("#addresseefromtag").val().replace(','+id+',',","));
}

function getaddresses(){
	$.post('module/documents/getaddresses.php',{dos:"getnewaddresses"}, function(data){
	   $("#newaddressee").html(data);
	});
}
</script>