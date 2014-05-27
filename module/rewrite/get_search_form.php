<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='get_search_form'){
	mysqlconnect();	

		?>				
		<select class="input-xxlarge" name="docid" id="docid" type="text" placeholder="საძიებო" data-provide="typeahead" data-items="10">
			<option value="">საძიებო</option>
			<?php
				mysqlconnect();
				$docs=mysql_query("select * from documents WHERE inner_outer=1 or inner_outer=2");
				while($dokuments=mysql_fetch_array($docs)){
					$avtori='';
					if($dokuments['inner_outer']==1){
						$author=mysql_fetch_array(mysql_query("select * from citizens WHERE id='".$dokuments['author']."'"));
						$avtori=" ( ".$author['name'].', '.$author['address']." )";
					}
					if($dokuments['inner_outer']==2){
						$author=mysql_fetch_array(mysql_query("select * from workers WHERE id='".$dokuments['author']."'"));
						$dep=mysql_fetch_array(mysql_query("select * from departments WHERE id in (SELECT dep_id FROM posts WHERE id='".$author['post_id']."')"));
						$avtori=" ( ".$author['name'].', '.$dep['department']." )";
					}
					echo '<option value="'.$dokuments['id'].'">'.$dokuments['regnumber'].' '.date('Y-m-d',$dokuments['date']).$avtori.'</option>';
				}
			?>  
		</select>
	
<?php } ?>

