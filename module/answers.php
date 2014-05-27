 <script type="text/javascript" >
function searchdoc(){ 
	var fromtimein = $('#fromtimein').val();
	var totimein = $('#totimein').val();
	var author=$('#author').val();	
	
	$.post('module/answers/search_answers.php',{dos:"searchdoc",fromtimein:fromtimein,totimein:totimein,author:author}, function(data){
		$("#report").html(data);
	});
}

function searchdoc1(){ 		
	$.post('module/answers/search_answers.php',{dos:"after_save"}, function(data){
		$("#report").html(data);
	});
}
</script>
<div class="span8">
<div class="hero-unit">
<h2>დოკუმენტის ძებნა</h2>
	   <div id="time1" class="input-append">
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
		
		<select class="input" name="author" id="author" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" required onchange="changeaddress()">
	   <option value="">აირჩიეთ ავტორი</option>
			<?php
			mysqlconnect();
				$qu=mysql_query("select * from citizens");
				 while($client=mysql_fetch_array($qu)){
				 echo '<option value="'.$client['id'].'">'.$client['name'].'-('.$client['address'].')</option>';
				 }
			?>  
			</select>
		
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
	   <input type="button"  class="btn btn-large btn-primary" id="save" name="submit" onclick="searchdoc()" data-loading-text="Loading..." value="ძებნა">
	   <br><div id='report'></div>
	   <script>
	   searchdoc();
	   </script>
	   
  </div>
 
</div><!--/span-->



<script>
function editdocument(answerid){

	var answer=answerid;
	
	
	$.post('module/answers/edit_answer.php',{dos:"editdocument",answer:answer}, function(data){
		$("#report").html(data);
	});	
}
</script>

<script>
function update_document(answerid1){
	var cid=answerid1;
	var ctimein = $('#timein').val();	
	var doc_id = $('#doc_id').val();
	var cauthor = $('#author12').val();
	var cannotation = $('#annotation1').val();
	var cnotice = $('#notice').val();
	
	if(cid!=""){	
	$.post('module/answers/update_answer.php',{dos:"update_document",cid:cid,ctimein:ctimein,doc_id:doc_id,cauthor:cauthor,cannotation:cannotation,cnotice:cnotice}, function(data){
		$("#report111").html(data);
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
		
	$.post('module/documents/update_document.php',{dos:"save_updated_rewrites",rewriteid123:rewriteid123,newaddressee:newaddressee, newnotice:newnotice}, function(data){
		$("#report111").html(data);
});

}
</script>