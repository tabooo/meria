<script type="text/javascript" >
function save_post(){ 
	var name = $('#name2').val();	
	
		$('#save').addClass("disabled");
		$.post('module/workers/save_dep.php',{dos:"save_dep",name:name}, function(data){
		$("#report2").html(data);
		$('#save').removeClass("disabled");
		$('#name').val("");
	});
	
}
</script>


<div class="span8">
  <div class="hero-unit">  
	<h2>განყოფილების შეტანა</h2>		   
		   <br>
		  
			<br><input type="text" id="name2" name="name2" placeholder="განყოფილება">
			<br><button type="button"  class="btn btn-large btn-primary" id="save" onclick="save_post()" data-loading-text="Loading...">შენახვა</button>
			<br><div id='report2'></div>
		   
  </div>
 
</div><!--/span-->
