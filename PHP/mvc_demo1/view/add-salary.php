<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form method="post" action="" name="addemployeeForm" id="sal-form">
	<table cellpadding="10">

		<tr>
			<td>Employee Name:</td>
			<td><?php if(!empty($row['employee_name'])){ ?>
					<select id = "name" name="name">
						<option> Select-Name</option><?php 
							if($row>0){
								while ($resultArrayN = mysqli_fetch_array($result1)) {
									
									echo '<option id="'.$resultArrayN['recid'].'" value="' . $resultArrayN['recid'].'"'.($row['employee_name'] == $resultArrayN['firstname'] ? ' selected="selected"':'').'>' .$resultArrayN['firstname'].'</option>';
								}
							}?>
					</select>


				<?php } else { ?>
					<select id = "name" name = "name">
							<option > Select-Name </option><?php 
									// print_r($resultArrayN);exit();
								if($row>0){
									while ($resultArrayN = mysqli_fetch_array($result1)) {
				            			echo '<option id="'.$resultArrayN['recid'].'" value="'.$resultArrayN['recid'].'">'.$resultArrayN['firstname'].' </option>';
									}        
				        		}
							?>
						</select>
				<?php }?>
			</td>
		</tr>

		<tr>
			<td>Month:</td>
			<td><?php if(!empty($row['year'])){ ?>
							<select id = "month" name = "month">
								<option> Select-Year </option><?php 
									for ($i=1; $i <= 12; $i++) { 
										echo '<option id="'. $i .'" value="'. $i .'"' . ($i == $row['month'] ? ' selected="selected"' : '') . '>'. $i .' </option>';
									}
								?>
							</select>
						<?php }
						else { ?>
								<select id = "month" name = "month">
									<option> Select-Month </option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
						<?php } ?>
			</td> 
		</tr>

		<tr>
			<td>Year:</td>
			<td> <?php if(!empty($row['year'])){ ?>
							<select id = "year" name = "year">
								<option> Select-Year </option><?php 
									$year = date('Y');
									for ($i=2000; $i <= $year; $i++) { 
										echo '<option id="'. $i .'" value="'. $i .'"' . ($i == $row['year'] ? ' selected="selected"' : '') . '>'. $i .' </option>';
									}
								?>
							</select>
						<?php }
						else { ?>
							<select id = "year" name = "year">
								<option> Select-Year </option><?php 
									$year = date('Y');
									for ($i=2000; $i <= $year; $i++) { 
										echo '<option id="'. $i .'" value="'. $i .'"' . ($i === $currently_selected ? ' selected="selected"' : '') . '>'. $i .' </option>';
									}
								?>
							</select>
						<?php }	?>
				
			</td>
		</tr>

		<tr>
			<td>Amount:</td>
			<td><input type="text" name="amount" id="amount" min="0" 
					  value="<?php if(!empty($row['amount'])) echo $row['amount']; else echo '';?>" >
			</td>
		</tr><?php 
			if(!empty($row['recid_sal'])) {?>

				<input type="hidden" name="recid_sal" value="<?php echo $row['recid_sal']; ?>">
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Update" id="update">
									<input type="reset" name="reset" value="Cancel">
					</td>
				</tr><?php 

			} 
			else { ?>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Save" id="save">
									<input type="reset" name="reset" value="Cancel">
					</td>
				</tr><?php
			} ?>	
	</table>
</form>

<script>
	$(document).ready(function(){
		//$('#sal-form').validate();

		$('#save').click(function(){

			var n = $('#name').val();
			var amount = $('#amount').val();
			var month = $('#month').val();
			var year = $('#year').val();

			if(n == 'Select-Name' ){ 
				alert("Please select name of employee ");
				return false;
			}
			else if( amount == '' ){
				alert("Please enter amount");
				return false;
			}
			else if( month == 'Select-Month' ){
				alert("Please select month");
				return false;
			} 
			else if(year == 'Select-Year') {
				alert("Please select year");
				return false;
			}
			else{
				if( isNaN(amount) ){
					alert("Please enter amount in numbers");	
					return false;
				}
			}
			
		});	

		$('#update').click(function(){

			var n = $('#name').val();
			var amount = $('#amount').val();
			var month = $('#month').val();
			var year = $('#year').val();

			if(n == 'Select-Name' ){ 
				alert("Please select name of employee ");
				return false;
			}
			else if( amount == '' ){
				alert("Please enter amount");
				return false;
			}
			else if( month == 'Select-Month' ){
				alert("Please select month");
				return false;
			} 
			else if(year == 'Select-Year') {
				alert("Please select year");
				return false;
			}
			else{
				if( isNaN(amount) ){
					alert("Please enter amount in numbers");	
					return false;
				}
			}
			
		});	
	});
</script>