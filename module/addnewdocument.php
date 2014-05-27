<?php
mysqlconnect();
?>
<meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
<script>
function add_document(){
	var date = $('#date').val();
	var address123 = $('#address123').val();
	var author = $('#author').val();
	var annotation = $('#annotation').val();
	var doc_type = $('#doc_type').val();
	var notice = $('#notice').val();
	var filename = $('#filename').val();
	var addresseefromtag = $('#addresseefromtag').val();
	var addressee = $('#addressee').val();
	var vada_value = $('#vada_value').val();
	var externalid = $('#externalid').val();
	var docid = $('#docid').val();
	var answer_doc_id = $('#answer_doc_id').val();

	if(docid==""){
		if(date!="" && author!="" && vada_value!="" && doc_type!=""){
			$.post('module/documents/save_document.php',{dos:"save_document",externalid:externalid,date:date,address123:address123,author:author,annotation:annotation,doc_type:doc_type,notice:notice,filename:filename,addresseefromtag:addresseefromtag,addressee:addressee,vada_value:vada_value,answer_doc_id:answer_doc_id}, function(data){
				var dt=data.split("|");
				var regnumber=document.getElementById('regnumber');
				regnumber.type = 'text';
				regnumber.value=dt[1];
				document.getElementById('docid').value=dt[0];
				//document.getElementById('save').type = 'hidden';
			   //$("#report").html(data);
			   $("#report").html(dt[2]);
			   if(dt[1]!="" && dt[0]!=""){
					get_scan_form();
			   }
			});
		} else {
			//alert(date+"," + author+"," + vada_value+"," + doc_type+"," + docid+"," + regnumber+"," + addresseefromtag);
			$("#report").html('<div class="alert alert-error">გთხოვთ შეავსოთ ყველა აუცილებელი ველი</div>');
		}
	}
}

function showresult(str){
	
	if (str.length==0) $("#livesearchregnumber").html('');
	if(str.length>0){
		$.post('module/documents/search_documents.php',{dos:'searchfromnewdocument',search:str}, function(data){
			$("#livesearchregnumber").html(data);
		});
	}
	/*if (str.length==0)
	  { 
	  document.getElementById("livesearchregnumber").innerHTML="";
	  document.getElementById("livesearchregnumber").style.border="0px";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("livesearchregnumber").innerHTML=xmlhttp.responseText;
		document.getElementById("livesearchregnumber").style.border="1px solid #A5ACB2";
		}
	  }
	xmlhttp.open("GET","module/documents/search_documents.php?dos=searchfromnewdocument&search="+str,true);
	xmlhttp.send();*/
	}
</script>


<div class="span8">
<div class="hero-unit">
<h2>დოკუმენტის დამატება</h2>
<input type="hidden" name="filename" id="filename" value="">
	<br>	
	<?php		
		echo '<input type="hidden" name="doc_type" id="doc_type" value="">';
		$doc_types=mysql_query("select * from document_types");
		$str='';
		echo '<div class="btn-group" data-toggle="buttons-radio" name="vada" id="vada">';
		while($doc_type=mysql_fetch_array($doc_types)){
			$str='';
			echo '<button  type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'doc_type\').value=\''.$doc_type["id"].'\';get_doc_form()">'.$doc_type["name"].'</button>';
			$str='';		
		}
		echo '</div>';
	?>
	
	<div name="get_document_form" id="get_document_form">
	</div>
	<div id="footer-form" style="visibility:hidden">
		
<br>
<input type="button" onclick="add_document()" class="btn btn-large btn-primary" id="save" name="submit" data-loading-text="Loading..." value="შენახვა">
<br><div name='report' id="report"></div>   
<br><div name='scannerimageform' id="scannerimageform" style="visibility:hidden">  
<?php include("module/scannerimageform.php"); ?>
</div>
<button type="button" class="btn btn-primary" onclick="finishdocument()">დასრულება</button>
</div> 
   
</div>
 
</div><!--/span-->
<div id="addclient" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">კლიენტის დამატება</h3>
  </div>
  <div class="modal-body" id="addclient-body">
  </div>
  <div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">დახურვა</button>
  </div>
</div>	

<script>		
$('#addclient').css(
{
	'margin-left': function () {
		return ($(window).width()-$(this).width())/2;
	}
});
$('#addclient').on('hidden', function () {
    $.post('module/citizen/addcitizenform.php',{dos:"getclients",doc_type:$('#doc_type').val()}, function(data){
	   $("#authorsdiv").html(data);
	});
})
function addclient(){
    $("#addclient").modal("show");
	$.post('module/citizen/addcitizenform.php', function(data){
	   $("#addclient-body").html(data);
	});
}

function changeaddress(){
	$.post('module/citizen/save_citizen.php',{dos:"get_citizen_address", id:document.getElementById('author').options[document.getElementById('author').selectedIndex].value}, function(data){
		$("#address123").val(data);
		$("#address123").css("display", "block");
		});
}	

function selectaddresseetag(){
	var name=$('#addressee').find('option:selected').text();
	var id=$('#addressee').find('option:selected').val();
	//alert(name+id);
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
	$.post('module/documents/getaddresses.php',{dos:"getaddresses"}, function(data){
	   $("#addressees").html(data);
	});
}

function get_doc_form(){	
	var type_form = $('#doc_type').val();	
	$.post('module/documents/get_document_forms.php',{dos:"get_form", type:type_form}, function(data){
	   $("#get_document_form").html(data);
	   $('#footer-form').css("visibility", "visible");
	});
}

function get_scan_form(){
	$('#scannerimageform').css("visibility", "visible");		
	//$.post('module/scannerimageform.php', function(data){
	  // $("#scannerimageform").html(data);
	//});
}

function finishdocument(){
	window.location.href = '?cat=edit_document&documentid='+document.getElementById("docid").value;
}
</script>
