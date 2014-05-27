<script type="text/javascript" >
function searchdep(){ 
		
	$.post('module/workers/search_dep.php',{dos:"search_dep"}, function(data){
		$("#department").html(data);
	});
}
searchdep()


</script>

<script type="text/javascript">
function add_worker(){ 
	var name = $('#name').val();
	var pid = $('#pid').val();
	var date = $('#date').val();
	
	var get_id = document.getElementById('typepost');  
	var department = get_id.options[get_id.selectedIndex].value;
		
	if(name!="" && department!=""){
	$('#addworker').addClass("disabled");
	$.post('module/workers/add_worker.php',{dos:"add_worker",name:name,pid:pid,date :date,department:department}, function(data){
		$("#report").html(data);
		$('#addworker').removeClass("disabled");
		$('#name').val("");
		$('#pid').val("");
		$('#date').val("");
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
	});
	} else {
		$("#report").html('<div class="alert alert-error">გთხოვთ შეავსოთ ყველა ველი!</div>');
	}
	return false;
}
</script>


<div class="span8">
<div class="hero-unit">
<h2>თანამშრომლის დამატება</h2>
	   
	   <input type="text" id="name" placeholder="სახელი გვარი">
	   <br>
	   <input type="text" id="pid" placeholder="პირადი ნომერი">
	   <div id="timein" class="input-append">
		<input data-format="MM/dd/yyyy" type="text" class="input-medium" id="date" name="date" placeholder="დაბ. თარიღი"></input>
		<span class="add-on">
		<i data-time-icon="icon-time" data-date-icon="icon-calendar">
		</i>
		</span>
		
		</div>
			<script type="text/javascript">
			  $(function() {
			 $('#timein').datetimepicker({
			   pickTime: false
			 });
			  });
			</script>
			
	  
	   
<?php
	mysqlconnect();
	
	echo '<br><select id="type" name="type" onChange="changeposts()">';							
	$qu=mysql_query("select * from departments");
	while($client=mysql_fetch_array($qu)){		
		echo '<option value="'.$client['id'].'">'.$client['department'].'</option>';
	}
	echo '</select>';
	
	echo '<select id="typepost" name="typepost">';		
	$qu=mysql_query("select * from posts WHERE dep_id=1");
	while($client2=mysql_fetch_array($qu)){
		echo '<option value="'.$client2['id'].'">'.$client2['name'].'</option>';		
	 }
	echo '</select>';
?>

	  
		  	   
	    <br>
		<br>

	   <input type="submit"  class="btn btn-large btn-primary" id="addworker" name="addworker" onclick="add_worker()" data-loading-text="Loading..." value="შენახვა">
	   <br><div id='report'></div>
	   
	   
  </div>
 
</div><!--/span-->





<script>

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
