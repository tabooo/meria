<?php
include("../../config.php");
mysqlconnect();

if(@$_POST['dos']=='getaddresses'){
?>
<select class="input" name="addressee" id="addressee" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()" required>
	   <option value="">აირჩიეთ ადრესატი</option>
			<?php
				$qu=mysql_query("select * from workers");
				 while($worker=mysql_fetch_array($qu)){
				 $workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
				 echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
				 }
			?>  
			</select>
<?php
}

if(@$_POST['dos']=='getnewaddresses'){
?>
<select class="input" name="newaddressee" id="newaddressee" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()" required>
	   <option value="">აირჩიეთ ადრესატი</option>
			<?php
				$qu=mysql_query("select * from workers");
				 while($worker=mysql_fetch_array($qu)){
				 $workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
				 echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
				 }
			?>  
			</select>
<?php
}

mysql_close($con);
?>		