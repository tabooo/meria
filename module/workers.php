<?php
mysqlconnect();
?>
<script type="text/javascript" >
function searchdoc(){ 
	var worker=$('#worker').val();
	
	$.post('module/workers/search_workers.php',{dos:"searchcworkers",worker:worker}, function(data){
		$("#report").html(data);
	});
}

function changeposts(){
	//alert(document.getElementById('type').options[document.getElementById('type').selectedIndex].value);
	var s = document.getElementById('typepost');
	 c = document.getElementById('type').options[document.getElementById('type').selectedIndex].value;
	 s.options.length = 0;
	<?php
	$resp2=mysql_query("select * from departments");
	 while($show2=mysql_fetch_array($resp2)){
	  echo "if (c =='".$show2['id']."') {";
	   $resp3=mysql_query("select * from posts where dep_id='".$show2['id']."'");
	   $i=0;
	   while($show3=mysql_fetch_array($resp3)){
		echo "s.options[".$i."] = new Option('".$show3['name']."','".$show3['id']."');";
		$i++;
	   }
	  echo "}";
	}
	?>
}
</script>
<div class="span8">
<div class="hero-unit">
<h2>თანამშრომლის ძებნა</h2>
	   		
		<select class="input-xlarge" name="worker" id="worker" type="text" placeholder="საძიებო" data-provide="typeahead" data-items="4" required onchange="changeaddress()">
	   <option value="">საძიებო</option>
			<?php
			
				$qu=mysql_query("select * from workers");
				 while($workers=mysql_fetch_array($qu)){
				 echo '<option value="'.$workers['id'].'">'.$workers['name'].' '.$workers['birthdate'].'</option>';
				 }
			?>  
			</select>
			   
	    <br>
	   <input type="button"  class="btn btn-large btn-primary" id="save" name="submit" onclick="searchdoc()" data-loading-text="Loading..." value="ძებნა">
	   <br><div id='report'></div>
	   
  </div>
 
</div><!--/span-->


<script>
function gotoeditproduct(wid){

	var workerid=wid;
	
	
	$.post('module/workers/edit_worker.php',{dos:"editworker",workerid:workerid}, function(data){
		$("#report").html(data);
	});	
}
</script>


<script>
function update_worker(wid1){ 
	var cid=wid1;	
	var name = $('#name').val();
	var pid = $('#pid').val();
	
	var get_id = document.getElementById('typepost');
	var typepost = get_id.options[get_id.selectedIndex].value;
	
	if(name!=""){
	
	$.post('module/workers/update_worker.php',{dos:"update_worker",cid:cid,name:name,pid :pid,typepost:typepost}, function(data){
		$("#report111").html(data);
		
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
	});
	} else {
		$("#report111").html('<div class="alert alert-error">შეიყვანეთ სახელი და გვარი!</div>');
	}
	return false;
}
</script>