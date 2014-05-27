<script type="text/javascript" >
function save_citizen(){ 
	var name = $('#name1').val();		
		$('#save').addClass("disabled");
		$.post('module/citizen/save_type.php',{dos:"save_type",name:name}, function(data){
		$("#report").html(data);
		$('#save').removeClass("disabled");
		$('#name').val("");
	});
	
}
</script>


<div class="span8">
  <div class="hero-unit">  
	<h2>ტიპის შეტანა</h2>		   
		   <br>
		   <input type="text" id="name1" name="name" placeholder="ტიპი">
		   <br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="save_citizen()" data-loading-text="Loading...">შენახვა</button>
		   <br><div id='report'></div>
		   
  </div>
 
</div><!--/span-->
		
			
			
