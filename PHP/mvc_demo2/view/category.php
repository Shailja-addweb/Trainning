	<style>
		.succmsg {
			color: green;
			font-size:14px;
		}
		.failmsg {
			color: red;
			font-size:14px;
		}

		a.name:link {
		    color: green;
		    text-decoration: none;
		}
		a.name:hover {
		    color: red;
		}
		a.name:active {
	    	color: blue;
		}
	</style>
	<script src="./js/jquery.min.js">
		
	</script><?php

		if(isset($_GET['add_flag']) && $_GET['add_flag'] == '1') {
			echo '<span class="succmsg"> Record Inserted Successfully </span>';
		}
	 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '1') {
			echo '<span class="succmsg"> Record Updated Successfully </span>';
		}
	 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with update..!! </span>';
		}
	 	else if(isset($_GET['add_flag']) && $_GET['add_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with add..!! </span>';
		}
	 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '1') {
			echo '<span class="succmsg"> Record Deleted Successfully </span>';
		}
	 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with delete..!! </span>';
		}
		else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '0') {
			echo '<span class="failmsg"> Status is not changed..!! </span>';
		}
		else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '1') {
			echo '<span class="succmsg"> Status changed. </span>';
		}
	 	else {
			echo '';
		}; ?><br>


	<div class="data">

		<table cellpadding="10" cellspacing="5" id="tblEmp">
			<tr>
				<td colspan="6" align="right"><a href="index.php?op=addcategory">Add Category</a></td>
			</tr>

			<?php echo $data; ?>

		</table>

	</div>

	<script >

		$(document).ready(function(){

			$('.name').click(function(){
				var name = $(this).text();
				var name_id = $(this).attr("id");
				//$("#yourPopup").dialog('open');


				$.ajax({
					url: 'index.php?op=show&name='+name,
					type: 'GET',
					success: function(response){

	  					//$('#yourPopup').html(response);
	  					//showyourPopup();
	  					alert(response);
	   				}
				})
			});

	 		// Delete 
	 		$('.delete').click(function(e){

	  			var Id = $(this).attr("data-id");
	  			var res = confirm('Are you sure you want to delete ?');
	  			e.preventDefault();

	  			if(res){
	  				$.ajax({
	   					url: 'index.php?op=deletecategory&delete_flag=1&id='+Id,
	   					type: 'GET',
	   					success: function(response){

	  						  $('#records').empty();
	  						  $('#records').html(response);
	   					}
	    			});
	  			}
	   		});
	 		 	
	 		$('.status').click(function(){
	 		 	var Id = $(this).attr("data-id");
	 		 	var Status = $(this).text();

				$.ajax({
	 		 		url: 'index.php?op=changestatusc&status_flag=1&id='+Id,
	 		 		type: 'GET',
	 		 		success: function(response){

					 	$('#records').html(response);
	 		 		
	 		 		}
	 		 	});
			});		
	 	});
	</script>
</div>



