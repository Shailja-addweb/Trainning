<style>
	.succmsg {
		color: green;
		font-size:14px;
	}
	.failmsg {
		color: red;
		font-size:14px;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
	
</script><?php

	if(isset($_GET['add_flag']) && $_GET['add_flag'] == '1') {
		echo '<span class="succmsg"> Record Inserted Successfully </span>';
	}
 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '1') {
		echo '<span class="succmsg"> Record Updated Successfully </span>';
	}
 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong..!! </span>';
	}
 	else if(isset($_GET['add_flag']) && $_GET['add_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong with add..!! </span>';
	}
 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '1') {
		echo '<span class="succmsg"> Record Deleted Successfully </span>';
	}
 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong..!! </span>';
	}
 	else {
		echo '';
	}; ?><br>


<div class="data">
	<form method="post" action="" name="btn-name"><?php
		
		$act_checked = '';
		$inct_checked = '';
		$allchecked = 'checked="checked"';

		if ( $_GET['op'] == 'allemp' ) {
			$allchecked = 'checked="checked"';
		} elseif ( $_GET['op'] == 'activeemp' ) {
			$act_checked = 'checked="checked"';
		} elseif ( $_GET['op'] == 'inactiveemp' ) {
			$inct_checked = 'checked="checked"';
		}
	
	?><label><input type="radio" name="show" value="all" id = "all" 
					onclick="location.href='index.php?op=allemp'"  
					oncload="location.href='index.php?op=allemp'" <?php echo $allchecked ;?> > All
		</label>

  		<label><input type="radio" name="show" value="active" id = "active" 
  					  onclick="location.href='index.php?op=activeemp'" <?php echo $act_checked ;?>> Active
  		</label>

  		<label><input type="radio" name="show" value="inactive" id = "inactive" 
  					  onclick="location.href='index.php?op=inactiveemp'" <?php echo $inct_checked ;?>> Inactive 
  		</label>

  		<!-- <label><input type="radio" name="show" value="sortdep" id = "sortdep" 
  					  onclick="location.href='index.php?op=sortdep'" <?php echo $inct_checked ;?>> Sort by Department 
  		</label> -->

 	</form>

 	<a href="javascript:;" id="sort_dep">Sort By Department</a> &nbsp; &nbsp;
 	<a href="javascript:;" id="sort_dj">Sort By 'Date of Joining'</a>


	<table cellpadding="10" cellspacing="5" id="tblEmp">
		<tr>
			<td colspan="6" align="right"><a href="index.php?op=addemp">Add Employee</a></td>
		</tr>

		<?php echo $data; ?>

	</table>

</div>

<script >

	$(document).ready(function(){

 		// Delete 
 		$('.delete').click(function(e){

  			var recId = $(this).attr("data-id");
  			var res = confirm('Please confirm deletion');
  			e.preventDefault();
            /*var form = $("#record");
            var rec = $(".re");*/

  			if(res){
  				$.ajax({
   					url: 'index.php?op=delete&id='+recId,
   					type: 'GET',
   					success: function(response){

  						  $('#records').empty();
  						  $('#records').html(response);
   					}
    			});
  			}
   		});
 		 	
 		$('.status').click(function(){
 		 	var recId = $(this).attr("data-id");
 		 	var Status = $(this).text();

			$.ajax({
 		 		url: 'index.php?op=changeE&id='+recId,
 		 		type: 'GET',
 		 		success: function(response){
 		 			
 		 			/*if ( Status == 1 ){
						$('#status-'+recId).text("0");
					}
					else {
				 		$('#status-'+recId).text('1');
				 	}*/
				 	$('#records').html(response);
 		 		}
 		 	});
		});

		$('#sort_dep').click(function(){

			$.ajax({
				url: 'index.php?op=sortdep',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});

		$('#sort_dj').click(function(){

			$.ajax({
				url: 'index.php?op=sortdj',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});
 	});
</script>
</div>