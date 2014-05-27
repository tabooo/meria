<?php
include("../../config.php");
mysqlconnect();
if(@$_POST['dos']=='get_form'){
//////////////////////////// SHEMOSULI DOCUMENTI //////////////////////////////
if(@$_POST['type']=='1'){
?>
<br>
<input type="hidden" readonly name="docid" id="docid" value="">
<input type="hidden" readonly name="regnumber" id="regnumber" value="">
<input type="text" name="externalid" id="externalid" value="" placeholder="გარე ნომერი" style=" float:left">
<!--<select class="input-xxlarge" name="answer_doc_id" id="answer_doc_id" type="text" placeholder="დოკუმენტის პასუხად" data-provide="typeahead" data-items="4">
	<option value="">დოკუმენტის პასუხად</option>
	<?php
	/*$qu=mysql_query("select * from documents");
	while($docs=mysql_fetch_array($qu)){
		$answr=mysql_query("select * from documents WHERE answer_doc_id=".$docs['id']."");
		if(mysql_num_rows($answr)<1){
		echo '<option value="'.$docs['id'].'">'.$docs['regnumber'].' '.date('m-d-Y',$docs['date']).'</option>';
		}
	}*/
	?>  
</select>
-->
<input type="text" size="30" placeholder="დოკუმენტის პასუხად" id="answer_doc_id" onkeyup="showresult(this.value)" style=" float:left">
<div id="livesearchregnumber" style="display:block; float:right; width:100px; border:1px solid black;cursor: pointer; background-color:white;"></div>
<br>
<div id="timein" class="input-append" >
<input data-format="MM/dd/yyyy" type="text" class="input-small" id="date" name="date" placeholder="თარიღი" value="<?php echo date('m/d/Y')?>"></input>
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
	echo '<input type="hidden" name="vada_value" id="vada_value" value="">';
	$vadebi=mysql_query("select * from vada");
	$str='';
	echo '<div class="btn-group" data-toggle="buttons-radio" name="vada" id="vada">';
	while($vada=mysql_fetch_array($vadebi)){
	$str='';
	
	//echo '<input '.$str.' type="radio" name="vada" id="vada" value="'.$vada["id"].'">'.$vada["name"].'&nbsp;&nbsp;&nbsp;';
	echo '<button  type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'vada_value\').value=\''.$vada["id"].'\'" >'.$vada["name"].'</button>';
	$str='';	
	}
	echo '</div>';
?>
			
<br>
<div name="authorsdiv" id="authorsdiv" style="float:left">
<select class="input-xlarge" name="author" id="author" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="changeaddress()">
	<option value="">აირჩიეთ ავტორი</option>
	<?php
	$citzs=mysql_query("select * from citizens");
	while($clienti=mysql_fetch_array($citzs)){
		echo '<option value="'.$clienti['id'].'">'.$clienti['name'].'-('.$clienti['address'].')</option>';
	}
	?>  
</select>
</div>
<button type="button" class="btn btn-primary" onclick="addclient()" >+ახალი მოქალაქე</button>					
			
			
<br><br><input type="text" name="address123" id="address123" style="display:none" value="gfdfgdfg" readonly >

<br>
<textarea class="editor" type="text" name="annotation" id="annotation" placeholder="ანოტაცია"></textarea>

<br>
<div id="addressees" style="float:left">
<select class="input" name="addressee" id="addressee" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()">
<option value="">აირჩიეთ ადრესატი</option>
	<?php
		$qu=mysql_query("select * from workers");
		while($worker=mysql_fetch_array($qu)){
			$workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
			echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
		}
	?>  
</select>
</div>
		
<input type="text" name="notice" id="notice" placeholder="შენიშვნა">

<br>
<input type="hidden" id="addresseefromtag" name="addresseefromtag" value="">

<br>
<div class="bootstrap-tagsinput" id="addresseetags"></div>

<!-- ფაილის მიმაგრება-->
<!--<br>
<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="http://www.placehold.it/50x50/EFEFEF/AAAAAA" /></div>
	<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
	<span class="btn btn-file"><span class="fileupload-new">ფაილის მიმაგრება</span><span class="fileupload-exists">შეცვლა</span><input type="file" name="file" /></span>
	<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">წაშლა</a>
</div>

<br>
<br>
<input type="submit"  class="btn btn-large btn-primary" id="save" name="submit" data-loading-text="Loading..." value="შენახვა">
<br><div name='report'></div>-->

	   
  </div>
 
</div><!--/span-->
<!--<div id="addclient" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">კლიენტის დამატება</h3>
  </div>
  <div class="modal-body" id="addclient-body">
  </div>
  <div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">დახურვა</button>
  </div>
</div>	-->


<?php
}
///////////////////////////////////////////////////////////////// SHIDA DOCUMENTI //////////////////////////////
if(@$_POST['type']=='2'){
?>
<br>
<input type="hidden" readonly name="docid" id="docid" value="">
<input type="hidden" readonly name="regnumber" id="regnumber" value="">
<input type="text" name="externalid" id="externalid" value="" placeholder="გარე ნომერი" style=" float:left">
<!--<select class="input-xxlarge" name="answer_doc_id" id="answer_doc_id" type="text" placeholder="დოკუმენტის პასუხად" data-provide="typeahead" data-items="4">
	<option value="">დოკუმენტის პასუხად</option>
	<?php
	/*$qu=mysql_query("select * from documents");
	while($docs=mysql_fetch_array($qu)){
		$answr=mysql_query("select * from documents WHERE answer_doc_id=".$docs['id']."");
		if(mysql_num_rows($answr)<1){
		echo '<option value="'.$docs['id'].'">'.$docs['regnumber'].' '.date('m-d-Y',$docs['date']).'</option>';
		}
	}*/
	?>  
</select>-->
<input type="text" size="30" placeholder="დოკუმენტის პასუხად" id="answer_doc_id" onkeyup="showresult(this.value)" style=" float:left">
<div id="livesearchregnumber" style="display:block; float:right; width:100px; border:1px solid black;cursor: pointer; background-color:white;"></div>
<br>
<div id="timein" class="input-append">
	<input data-format="MM/dd/yyyy" type="text" class="input-small" id="date" name="date" placeholder="თარიღი" value="<?php echo date("m/d/Y")?>"></input>
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
	echo '<input type="hidden" name="vada_value" id="vada_value" value="">';
	$vadebi=mysql_query("select * from vada");
	$str='';
	echo '<div class="btn-group" data-toggle="buttons-radio" name="vada" id="vada">';
	while($vada=mysql_fetch_array($vadebi)){
	$str='';
	
	//echo '<input '.$str.' type="radio" name="vada" id="vada" value="'.$vada["id"].'">'.$vada["name"].'&nbsp;&nbsp;&nbsp;';
	echo '<button  type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'vada_value\').value=\''.$vada["id"].'\'" >'.$vada["name"].'</button>';
	$str='';
	
	}
	echo '</div>';
?>
			
<br>
	   

<select class="input" name="author" id="author" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="changeaddress()">
<option value="">აირჩიეთ ავტორი</option>
	<?php
		$qu=mysql_query("select * from workers");
		 while($worker=mysql_fetch_array($qu)){
			$workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
			echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
		 }
	?>  
	</select>
			
			
			
<br><input type="text" name="address123" id="address123" style="display:none" value="gfdfgdfg" readonly >
<br>
<textarea class="editor" type="text" name="annotation" id="annotation" placeholder="ანოტაცია"></textarea>

<br>
<div id="addressees" style="float:left">
<select class="input" name="addressee" id="addressee" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()">
<option value="">აირჩიეთ ადრესატი</option>
	<?php
		$qu=mysql_query("select * from workers");
		 while($worker=mysql_fetch_array($qu)){
		 $workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
		 echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
		 }
	?>  
</select>
</div>
		
<input type="text" name="notice" id="notice" placeholder="შენიშვნა">
<br>
<input type="hidden" id="addresseefromtag" name="addresseefromtag" value="">
<br>
<div class="bootstrap-tagsinput" id="addresseetags"></div>
<!--<br>
<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="http://www.placehold.it/50x50/EFEFEF/AAAAAA" /></div>
	<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
	<span class="btn btn-file"><span class="fileupload-new">ფაილის მიმაგრება</span><span class="fileupload-exists">შეცვლა</span><input type="file" name="file" /></span>
	<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">წაშლა</a>
</div>
<br>
<br>
<input type="submit"  class="btn btn-large btn-primary" id="save" name="submit" data-loading-text="Loading..." value="შენახვა">
<br><div name='report'></div>-->

	   
	   
<?php
}
//////////////////////////////////////////////////////////////////////////// GASULI DOCUMENTI //////////////////////////////
if(@$_POST['type']=='3'){
?>
<br>
<input type="hidden" readonly name="docid" id="docid" value="">
<input type="hidden" readonly name="regnumber" id="regnumber" value="">
<input type="text" name="externalid" id="externalid" value="" placeholder="გარე ნომერი" style=" float:left">
<!--<select class="input-xxlarge" name="answer_doc_id" id="answer_doc_id" type="text" placeholder="დოკუმენტის პასუხად" data-provide="typeahead" data-items="4">
	<option value="">დოკუმენტის პასუხად</option>
	<?php
	/*$qu=mysql_query("select * from documents");
	while($docs=mysql_fetch_array($qu)){
		$answr=mysql_query("select * from documents WHERE answer_doc_id=".$docs['id']."");
		if(mysql_num_rows($answr)<1){
		echo '<option value="'.$docs['id'].'">'.$docs['regnumber'].' '.date('m-d-Y',$docs['date']).'</option>';
		}
	}*/
	?>  
</select>-->
<input type="text" size="30" placeholder="დოკუმენტის პასუხად" id="answer_doc_id" onkeyup="showresult(this.value)" style=" float:left">
<div id="livesearchregnumber" style="display:block; float:right; width:100px; border:1px solid black;cursor: pointer; background-color:white;"></div>
<br>
<div id="timein" class="input-append">
	<input data-format="MM/dd/yyyy" type="text" class="input-small" id="date" name="date" placeholder="თარიღი" value="<?php echo date("m/d/Y")?>"></input>
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
	echo '<input type="hidden" name="vada_value" id="vada_value" value="">';
	$vadebi=mysql_query("select * from vada");
	$str='';
	echo '<div class="btn-group" data-toggle="buttons-radio" name="vada" id="vada">';
	while($vada=mysql_fetch_array($vadebi)){
	$str='';
	
	//echo '<input '.$str.' type="radio" name="vada" id="vada" value="'.$vada["id"].'">'.$vada["name"].'&nbsp;&nbsp;&nbsp;';
	echo '<button  type="button" class="btn btn-primary'.$str.'" onclick="document.getElementById(\'vada_value\').value=\''.$vada["id"].'\'" >'.$vada["name"].'</button>';
	$str='';
	
	}
	echo '</div>';
?>
			
<br>
	   

<select class="input" name="author" id="author" type="text" placeholder="ავტორი" data-provide="typeahead" data-items="4" onchange="changeaddress()">
<option value="">აირჩიეთ ავტორი</option>
	<?php
		$qu=mysql_query("select * from workers");
		 while($worker=mysql_fetch_array($qu)){
			$workerpost=mysql_fetch_array(mysql_query("SELECT * FROM departments WHERE id in(SELECT dep_id FROM posts WHERE id='".$worker['post_id']."')"));
			echo '<option value="'.$worker['id'].'">'.$worker['name'].'-('.$workerpost['department'].')</option>';
		 }
	?>  
	</select>

<br>
<textarea class="editor" type="text" name="annotation" id="annotation" placeholder="ანოტაცია"></textarea>

<br>

<div name="authorsdiv" id="authorsdiv" style="float:left">
<select class="input-xlarge" name="addressee" id="addressee" type="text" placeholder="ადრესატი" data-provide="typeahead" data-items="4" onchange="selectaddresseetag()">
	<option value="">აირჩიეთ ადრესატი</option>
	<?php
	$citzs=mysql_query("select * from citizens");
	while($clienti=mysql_fetch_array($citzs)){
		echo '<option value="'.$clienti['id'].'">'.$clienti['name'].'-('.$clienti['address'].')</option>';
	}
	?>  
</select>
</div>
<button type="button" class="btn btn-primary" onclick="addclient()" >+ახალი მოქალაქე</button>					
<br>
<br>
<input type="text" name="notice" id="notice" placeholder="შენიშვნა">
<br>
<input type="hidden" id="addresseefromtag" name="addresseefromtag" value="">
<br>
<div class="bootstrap-tagsinput" id="addresseetags"></div>

<!--<br>
<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="fileupload-new thumbnail" style="width: 50px; height: 50px;"><img src="http://www.placehold.it/50x50/EFEFEF/AAAAAA" /></div>
	<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
	<span class="btn btn-file"><span class="fileupload-new">ფაილის მიმაგრება</span><span class="fileupload-exists">შეცვლა</span><input type="file" name="file" /></span>
	<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">წაშლა</a>
</div>
<br>
<br>
<input type="submit"  class="btn btn-large btn-primary" id="save" name="submit" data-loading-text="Loading..." value="შენახვა">
<br><div name='report'></div>-->

<?php
}
}
?>
