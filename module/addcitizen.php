 <?php
mysqlconnect();
?>

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
		$("#report").html(data);
		$('#save').removeClass("disabled");
		$('#name').val("");
		$('#pid').val("");
		$('#address').val("");
		$('#type').val("");
		//document.getElementById("error").style.visibility="visible";
		//alert(username+password);
	});
	} else {
		$("#report").html('<div class="alert alert-error">გთხოვთ შეიყვანოთ სახელი და გვარი!</div>');
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
					<!--<button type="button" class="btn btn-primary" onclick="addclient()" >+სხვა</button>-->
				   <br>
                   <input type="text" id="name" placeholder="სახელი გვარი">
				   <input type="text" id="pid" placeholder="პირადი ნომერი">
				   <input type="text" id="address" placeholder="მისამართი">
				   <br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="save_citizen()" data-loading-text="Loading...">შენახვა</button>
				   <br><div id='report'></div>
				   
          </div>
         
        </div><!--/span-->
		
		
<div id="addclient" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">მოქალაქის ტიპის დამატება</h3>
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

	function addclient(){
		$("#addclient").modal("show");
		$.post('module/citizen/addtypeform.php', function(data){
		   $("#addclient-body").html(data);
		});
	}
</script>