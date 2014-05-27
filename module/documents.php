 <script type="text/javascript" >
function searchdoc(){
	var fromtimein = $('#fromtimein').val();
	var totimein = $('#totimein').val();
	var author=$('#authorid').val();
	var addressee=$('#addresseeid').val();
	var regnumbersearch=$('#regnumbersearch').val();
	//var doctype1=$('#doctype1').prop('checked') === true?$('#doctype1').attr('value'):0;
	//var doctype2=$('#doctype2').prop('checked') === true?$('#doctype2').attr('value'):0;
	//var doctype3=$('#doctype3').prop('checked') === true?$('#doctype3').attr('value'):0;
	var doctype=$('#doc_type').val();
	var pagenumber=$('#pagenumber').val();
	var dt="";
	$.post('module/documents/search_documents.php',{dos:"searchdoc",regnumbersearch:regnumbersearch,fromtimein:fromtimein,totimein:totimein,author:author,addressee:addressee,doctype:doctype,pagenumber:pagenumber}, function(data){
		dt=data.split("|||");
		$("#reportsul").html("დოკუმენტების რაოდენობა: "+dt[0]);
		$("#report").html(dt[1]);
	});
}

function showresultauthors(str){
	if (str.length==0) {$("#livesearchauthor").html('');$("#authorid").val('');}
	if(str.length>2){
		$.post('module/documents/search_documents.php',{dos:'searchauthorsfromdocuments',search:str}, function(data){
			$("#livesearchauthor").css("visibility", "visible");
			$("#livesearchauthor").html(data);
		});
	}
}

function showresultaddressee(str){
	if (str.length==0) {$("#livesearchaddressee").html('');$("#addresseeid").val('');}
	if(str.length>2){
		$.post('module/documents/search_documents.php',{dos:'searcaddresseefromdocuments',search:str}, function(data){
			$("#livesearchaddressee").css("visibility", "visible");
			$("#livesearchaddressee").html(data);
		});
	}
}


function searchdoc1(){ 	
	$.post('module/documents/search_documents.php',{dos:"after_save"}, function(data){
		$("#report").html(data);
	});
}
</script>
<div class="span8">
<div class="hero-unit">
<h2>დოკუმენტის ძებნა</h2>
	<?php
	   mysqlconnect();
	   $types=mysql_query("select * from document_types");
	   echo '<input type="hidden" name="doc_type" id="doc_type" value="">';
	   echo '<div class="btn-group" data-toggle="buttons-radio" name="doctype" id="doctype">';
		while($type=mysql_fetch_array($types)){
			echo '<button  type="button" class="btn btn-primary" onclick="document.getElementById(\'doc_type\').value=\''.$type["id"].'\'" >'.$type["name"].'</button>';
		}
		echo '<button  type="button" class="btn btn-primary" onclick="document.getElementById(\'doc_type\').value=\'\'" >ყველა</button>';
		echo '</div>';
	?>
	<input type="text" id="regnumbersearch" placeholder="რეგ. ნომერი"><br><br>
	   <div id="time1" class="input-append">
	    <input type="hidden" id="pagenumber" value="">
		<input id="fromtimein" data-format="MM/dd/yyyy" type="text" class="input-small" id="prodsearchfromtimein" name="date" placeholder="თარიღიდან"></input>
		<span class="add-on">
		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
		</i>
		</span>
		</div>
		
		<div id="time2" class="input-append">
		<input id="totimein" data-format="MM/dd/yyyy" type="text" class="input-small" id="prodsearchfromtimein" name="date" placeholder="თარიღამდე"></input>
		<span class="add-on">
		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
		</i>
		</span>
		
		</div>
		<input type="hidden" size="30" placeholder="ავტორი" id="authorid">
		<input type="text" size="30" placeholder="ავტორი" id="author" onchange="showresultauthors(this.value)" style=" float:left; width:125px">
		
		<input type="hidden" size="30" placeholder="ადრესატი" id="addresseeid">
		<input type="text" size="30" placeholder="ადრესატი" id="addressee" onchange="showresultaddressee(this.value)" style=" width:125px">
		
		<br><div id="livesearchauthor" style="position:absolute; display:block; float:left; width:250px; border:1px solid black; cursor: pointer; background-color:white; margin-top:10px; vitibility:hidden"></div>
		<div id="livesearchaddressee" style="position:absolute; display:block; width:250px; margin-left: 300px; border:1px solid black; cursor: pointer; background-color:white; margin-top:10px; vitibility:hidden"></div>
		
			<script type="text/javascript">
			  $(function() {
			 $('#time1').datetimepicker({
			   pickTime: false
			 });
			  $('#time2').datetimepicker({
			   pickTime: false
			 });			 
			  });
			  
			</script>
			
	   
	    <br>
	   <input type="button"  class="btn btn-large btn-primary" id="save" name="submit" onclick="$('#pagenumber').val('1');searchdoc()" data-loading-text="Loading..." value="ძებნა"><div id='reportsul' style="float:right"></div>
	   <br><div id='report'></div>
	   <script>
	   searchdoc();
	   </script>
	   
  </div>
 
</div><!--/span-->



<script>
function editdocument(docid){
	window.location.href = '?cat=edit_document&documentid='+docid;
	
	//$.post('module/documents/edit_document.php',{dos:"editdocument",documentid:docid}, function(data){
	//	$("#report").html(data);
	//});	
}
</script>

<script>
function update_document(docid1){ 
	var cid=docid1;
	var cauthor = $('#author1').val();
//	alert(cauthor);
	var ctimein = $('#date').val();
	var cregnumber = $('#regnumber').val();
	var cannotation = $('#annotation1').val();
	var vada = $('#vada_value').val();
					
	if(cid!=""){
	
	$.post('module/documents/update_document.php',{dos:"update_document",cid:cid,cauthor:cauthor,ctimein:ctimein,cregnumber :cregnumber,cannotation:cannotation,vada:vada}, function(data){
		$("#report111").html(data);
		
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
	});
	} else {
		$("#report111").html('<div class="alert alert-error">გთხოვთ შეავსოთ ყველა ველი!</div>');
	}
	return false;
}
</script>


<script>
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
</script>


<script>
function delete_addressee(rewriteid2,docid11){
	var docid=docid11;
	var rewriteid=rewriteid2;
	
	$.post('module/rewrite/disable_addressee.php',{dos:"delete",docid:docid,rewriteid:rewriteid}, function(data){
		$("#addresseesdiv").html(data);
});

}
</script>
