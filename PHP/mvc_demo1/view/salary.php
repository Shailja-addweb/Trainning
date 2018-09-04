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
		            			echo '<option id="'.$resultArrayN['recid'].'" value="'.$resultArrayN['recid'].'">'.$resultArrayN['employee_name'].' </option>';
							}        
		        		}
					?>
				</select>

			Month : <input type="text" name="month" id="month" 
			               value="<?php if(!empty($row['month'])) echo $row['month']; else echo '';?>"> 

			Year : <input type="text" name="year" id=year 
						  value="<?php if(!empty($row['year'])) echo $row['year']; else echo '';?>">

			<button id="show">Show</button>
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
					var res = confirm('Please confirm deletion');
					e.preventDefault();

					if(res){
						$.ajax({
							url: 'index.php?op=deletesal&id='+recId,
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

					if( name == "Select-Name" && m == '' && y == ''){
						alert("Please Enter value");
						return false;
					}
					else if ( name == 'Select-Name' && m == '' ){
						alert("please enter one value");
						return false;
					}
					else if ( name == 'Select-Name' && y == ''){
						alert("please enter one value");
						return false; 
					}
					else if(isNaN(m) || isNaN(y)){
						alert("Please enter numeric value");
						return false;
					}
					else {
						return true;
					}
				});
			});
		</script>
</div>