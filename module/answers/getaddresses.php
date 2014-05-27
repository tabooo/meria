<?php
include("../../config.php");
mysqlconnect();

if(@$_POST['dos']=='getaddresses'){
?>
<select class="input" name="author" id="author" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()" required>
	   <option value="">აირჩიეთ ავტორი</option>
			<?php
				$qu=mysql_query("select * from workers");
				 while($worker=mysql_fetch_array($qu)){
				 echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$worker['birthdate'].')</option>';
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
				 echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$worker['birthdate'].')</option>';
				 }
			?>  
			</select>
<?php
}

mysql_close($con);
?>		