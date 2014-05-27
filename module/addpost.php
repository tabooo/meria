<div class="span8">
  <div class="hero-unit">  
	<h2>ტიპის შეტანა</h2>		   
		   <br>
		   <?php
			mysqlconnect();
			
			echo '<br><select id="type" name="type" onChange="getposts()">';
			$firstdep=1;
			$qu=mysql_query("select * from departments");
			$i=0;
			while($client=mysql_fetch_array($qu)){
				if($i==0) $firstdep=$client['id'];
				$i++;
				echo '<option value="'.$client['id'].'">'.$client['department'].'</option>';
			}
			echo '</select>';			
			?>
			<button type="button" class="btn btn-primary" onclick="adddep()">+ახალი განყოფილება</button>
			<br><input type="text" id="name1" name="name1" placeholder="თანამდებობა">
			<br><button type="button"  class="btn btn-large btn-primary" name="save" id="save" onclick="savepost2()" data-loading-text="Loading...">შენახვა</button>
			<br><div id='report'></div>
			<br><div id='reportposts'>
			<?php
			$posts=mysql_query("select * from posts where dep_id='$firstdep'");
			while($post=mysql_fetch_array($posts)){
				echo $post['name']."<br>";
			}
			?>
			</div>
		   
  </div>
 
</div><!--/span-->

		
<div id="adddep" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">განყოფილების დამატება</h3>
  </div>
  <div class="modal-body" id="adddep-body">
  </div>
  <div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">დახურვა</button>
  </div>
</div>	

<script>
	$('#adddep').css(
		{
			'margin-left': function () {
				return ($(window).width()-$(this).width())/2;
		}
	});
$('#adddep').on('hidden', function () {
    window.location.href = '?cat=addpost';
})
	
	function adddep(){
		$("#adddep").modal("show");
		$.post('module/workers/add_dep.php', function(data){
		   $("#adddep-body").html(data);
		});
	}
</script>

<script>
function savepost2(){
	var get_id = document.getElementById('type');  
	var dep = get_id.options[get_id.selectedIndex].value;
	var name = $('#name1').val();		
		
	$.post('module/workers/save_dep.php',{dos:"save_post",dep:dep,name:name}, function(data){
		$("#report").html(data);
		$('#save').removeClass("disabled");
		$('#name').val("");
		getposts();
	});
	
}

function getposts(){
	var get_id = document.getElementById('type');  
	var dep = get_id.options[get_id.selectedIndex].value;
	$.post('module/workers/save_dep.php',{dos:"get_posts",dep:dep}, function(data){
		$("#reportposts").html(data);
	});
}
</script>
