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
	
</script><br><?php 
 
    
/*print("<pre>");
print_r($_POST);*/
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
	}; ?>

	<br />
	<br />
		<form method = "post" action="index.php?op=show" name="show-form" id="showdata">
			Employee Name : 
				 <select id = "name" name = "emp_name">
					<option > Select-Name </option><?php 
						if($row>0){
							while ($resultArrayN = mysqli_fetch_array($result1)) {
								
		            			echo '<option id="'.$resultArrayN['recid_sal'].'" value="' . $resultArrayN['recid_sal'].'"'.($resultArrayN['recid_sal'] == $_POST['emp_name'] ? ' selected="selected"':'').'>' .$resultArrayN['employee_name'].'</option>';
							}        
		        		}
					?>
				</select> 

			Month : <select id = "month" name = "month">
						<option> Select-Month </option><?php
							for ($i=1; $i <= 12; $i++) { 
								echo '<option id="'. $i .'" value="'. $i .'"' . ($i == $_POST['month'] ? ' selected="selected"' : '') . '>'. $i .' </option>';
							}?>
					</select> 

			Year : <select id = "year" name = "year">
						<option> Select-Year </option><?php 
							$year = date('Y');
							for ($i=2000; $i <= $year; $i++) { 
								echo '<option id="'. $i .'" value="'. $i .'"' . ($i == $_POST['year'] ? ' selected="selected"' : '') . '>'. $i .' </option>';
							}
						?>
					</select>

			&nbsp; &nbsp; <button id="show">Show</button>
		</form>
		<br />
		<br />
		<br />

		<table cellpadding="10" cellspacing="5">
			<tr>
				<td colspan="6" align="right"><a href="index.php?op=addsal">Add Salary</a></td>
			</tr>

			<?php echo $data; ?>

		</table>

		<script>
			$(document).ready(function(){
				
				$('.delete').click(function(e){
					var recId = $(this).attr("data-id");
					var res = confirm('Are you sure you want to delete ?');
					e.preventDefault();

					if(res){
						$.ajax({
							url: 'index.php?op=deletesal&delete_flag=1&id='+recId,
							type: 'GET',
							success: function(response){

								$('#records').empty();
		  						$('#records').html(response);
							}
						});
					}			
				});

				//validation
				$('#show').click(function(){
					var m = $('#month').val();
					var y = $('#year').val();
					var name = $( "#name option:selected" ).val();

					if( name == "Select-Name" && m == 'Select-Month' && y == 'Select-Year'){
						alert("Please Enter value what you want to search");
						return false;
					}
					else {
						return true;
					}
				});
			});
		</script>
</div>