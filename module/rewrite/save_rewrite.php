<?php
include("../../config.php");
?>

<?php
if(@$_POST['dos']=='save_rewrite'){
	mysqlconnect();
		
	$docid=safe($_POST['docid1']);	
	$newnotice=safe($_POST['newnotice']);	
	$addresseefromtag = $_POST["addresseefromtag"];
	$adds=explode(",",$addresseefromtag);
	
	
	$lvls=mysql_fetch_array(mysql_query("select MAX(level) from rewrites where did='".$docid."'")) or die(mysql_error());	
	$lvl=$lvls['MAX(level)']+1;
	$i=1;
	while($adds[$i]!=""){
		$worker=mysql_fetch_array(mysql_query("select * from workers where id='".$adds[$i]."'"));
		mysql_query("insert into rewrites values (null,'".$docid."', '".$adds[$i]."', '".$worker['post_id']."', '".$newnotice."', '".$lvl."')");
		$i++;
	}
	echo '<div class="alert alert-success">დოკუიმენტი წარმატებით გადაეწერა</div>';
}
?>

