<?php
include("../../config.php");
mysqlconnect();

	if(@$_POST['dos']=='getclients'){
		$qu=mysql_query("select * from citizens");
		if($_POST['doc_type']==3){
			echo ' <select class="input-xlarge" name="addressee" id="addressee" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()"><option value="">აირჩიეთ ადრესატი</option>';
		} else {
			echo ' <select class="input-xlarge" name="author" id="author" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" onchange="changeaddress()"><option value="">აირჩიეთ ადრესატი</option>';
		}
		while($client=mysql_fetch_array($qu)){
		echo '<option value="'.$client['id'].'">'.$client['name'].'-('.$client['address'].')</option>';
		}
		echo '</select>';
	}
		else{?>
	<script type="text/javascript" >
function save_citizen(){ 
	var name = $('#name').val();
	var pid = $('#pid').val();
	var address = $('#address').val();
	
	var get_id = document.getElementById('type');
	var type = get_id.options[get_id.selectedIndex].value;
	
	if(name!=""){
	$('#save').addClass("disabled");
	$.post('module/citizen/save_citizen.php',{dos:"save_citizen",name:name,pid :pid,address:address, type:type}, function(data){
		$("#reportaddcitizen").html(data);
		$('#save').removeClass("disabled");
		$('#name').val("");
		$('#pid').val("");
		$('#address').val("");
		$('#type').val("");
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
		 $.post('module/citizen/addcitizenform.php',{dos:"getclients"}, function(data){
			$("#authorsdiv").html(data);
		});
	});
	} else {
		$("#reportaddcitizen").html('<div class="alert alert-error">გთხოვთ შეიტანოთ სახელი და გვარი!</div>');
	}
	return false;
}
</script>


				<div class="span8">
          <div class="hero-unit">
		  
		  
            <h2>მოქალაქის შეტანა</h2>
				   <br><select id="type" name="type">
					  <?php
				$qu=mysql_query("select * from company_types");
				 while($client=mysql_fetch_array($qu)){
				 echo '<option value="'.$client['id'].'">'.$client['type'].'</option>';
				 }
			?>  
					</select>
				   <br>
                   <input type="text" id="name" placeholder="სახელი გვარი">
				   <input type="text" id="pid" placeholder="პირადი ნომერი">
				   <input type="text" id="address" placeholder="მისამართი">
				   <br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="save_citizen()" data-loading-text="Loading...">შენახვა</button>
				   <br><div id='reportaddcitizen'></div>
				   
          </div>
         
        </div><!--/span-->
		
			
			
<?php
}
mysql_close($con);
?>		
