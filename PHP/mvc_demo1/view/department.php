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
	else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '0') {
		echo '<span class="failmsg"> Status is not changed..!! </span>';
	}
	else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '1') {
		echo '<span class="succmsg"> Status changed. </span>';
	}
	else if(isset($_GET['sort_flag']) && $_GET['sort_flag'] == '0') {
		echo '<span class="succmsg"> Sort Acsending by name </span>';
	}
	else if(isset($_GET['sort_flag']) && $_GET['sort_flag'] == '1') {
		echo '<span class="failmsg"> Sort Desending by name </span>';
	}
	else {
		echo '';
	}; ?>

	<br>
	<br><?php

		$act_checked = '';
		$inct_checked = '';
		$allchecked = 'checked="checked"';

		if ( $_GET['op'] == 'alldep' ) {
			$allchecked = 'checked="checked"';
		}
		elseif ( $_GET['op'] == 'activedep' ) {
			$act_checked = 'checked="checked"';
		}
		elseif ( $_GET['op'] == 'inactivedep' ) {
			$inct_checked = 'checked="checked"';
		}
	?>

<div class="data">
	<form method="post" action="" name="btn-name">
	   <label><input type="radio" name="show" value="all" id = "all" 
	   				 onclick="location.href='index.php?op=alldep'" 
	   				 onload="location.href='index.php?op=alldep'" <?php echo $allchecked ;?> > All
	   	</label>
	  	
	  	<label><input type="radio" name="show" value="active" id = "active" 
	  	              onclick="location.href='index.php?op=activedep'" <?php echo $act_checked ;?> > Active
	  	</label>

	  	<label><input type="radio" name="show" value="inactive" id = "inactive" 
	  	              onclick="location.href='index.php?op=inactivedep'" <?php echo $inct_checked ;?> > Inactive 
	  	</label>
	 </form>

	 <!--   -->
	 		 <!--  <a href="javascript:;" id="sort_name_desc" style="display: none"> DESC </a>
 -->

	<table cellpadding="10" cellspacing="5" id="tblDept">
		<tr>
			<td colspan="6" align="right"><a href="index.php?op=adddep">Add Department</a></td>
		</tr>

		<?php echo $data; ?>
		
	</table>

</div>
  
 <script >

	$(document).ready(function(){

		$('#sort_name_desc').hide();
		flag = 0;

 		$('.delete').click(function(e){

  			var recId = $(this).attr("data-id");
  			var res = confirm('Are you sure you want to delete ?');
  			e.preventDefault();

  			if(res){
  				$.ajax({
   					//	url: 'index.php?op=deletedep&id='+recId,
   					url: 'index.php?op=deletedep&delete_flag=1&id='+recId,
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
 		 		url: 'index.php?op=changeD&status_flag=1&id='+recId,
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

		var temp2 = localStorage.getItem('temp2', 0);
		$('#change').click(function(){
			var change = $('#change').text();
			//alert(change);
			//alert(temp);

		if ( temp2 == 0 ) {
			localStorage.setItem('temp2', 1);
			
				$.ajax({
					url: 'index.php?op=sort_asc&sort_flag=0',
					type:'GET',
					success: function(response){

						$('#records').html(response);
					}
				});
			}
			else{
				localStorage.setItem('temp2', 0);
				$.ajax({
					url: 'index.php?op=sort_desc&sort_flag=1	',
					type:'GET',
					success: function(response){

						$('#records').html(response);
					}
				});
			}
		})

   	});

</script>
</div>	