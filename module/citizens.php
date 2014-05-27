 <script type="text/javascript" >
function searchdoc(){ 
	var author=$('#author').val();
	
	$.post('module/citizen/search_citizens.php',{dos:"searchcitizens",author:author}, function(data){
		$("#report").html(data);
	});
}
</script>
<div class="span8">
<div class="hero-unit">
<h2>მოქალაქის ძებნა</h2>
	   		
		<select class="input-xlarge" name="author" id="author" type="text" placeholder="საძიებო" data-provide="typeahead" data-items="4" required onchange="changeaddress()">
	   <option value="">საძიებო</option>
			<?php
			mysqlconnect();
				$qu=mysql_query("select * from citizens");
				 while($client=mysql_fetch_array($qu)){
				 echo '<option value="'.$client['id'].'">'.$client['name'].' '.$client['pid'].'-('.$client['address'].')</option>';
				 }
			?>  
			</select>
			   
	    <br>
	   <input type="button"  class="btn btn-large btn-primary" id="save" name="submit" onclick="searchdoc()" data-loading-text="Loading..." value="ძებნა">
	   <br><div id='report'></div>
	   
  </div>
 
</div><!--/span-->

<script>
function gotoeditproduct(citid){

	var citizenid=citid;
	
	
	$.post('module/citizen/edit_citizen.php',{dos:"editcitizen",citizenid:citizenid}, function(data){
		$("#report").html(data);
	});	
}
</script>

<script>
function update_citizen(citizenid1){ 
	var cid=citizenid1;
	var name = $('#name').val();
	var pid = $('#pid').val();
	var address = $('#address').val();
	
	var get_id = document.getElementById('type');
	var type = get_id.options[get_id.selectedIndex].value;
	
	if(name!=""){
	
	$.post('module/citizen/update_citizen.php',{dos:"update_citizen",cid:cid,name:name,pid :pid,address:address, type:type}, function(data){
		$("#report111").html(data);
		
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
	});
	} else {
		$("#report111").html('<div class="alert alert-error">გთხოვთ შეიყვანოთ სახელი და გვარი!</div>');
	}
	return false;
}
</script>