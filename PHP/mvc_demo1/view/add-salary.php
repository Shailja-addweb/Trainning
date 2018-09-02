<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form method="post" action="" name="addemployeeForm" id="sal-form">
	<table cellpadding="10">

		<tr>
			<td>Employee Name:</td>
			<td><input type="text" name="employee_name" 
					   value="<?php if(!empty($row['employee_name'])) echo $row['employee_name']; else echo '';?>" required>
			</td>
		</tr>

		<tr>
			<td>Month:</td>
			<td><input type="text" name="month" id="month" 
					    value="<?php if(!empty($row['month'])) echo $row['month']; else echo '';?>" required>
			</td> 
		</tr>

		<tr>
			<td>Year:</td>
			<td><input type="text" name="year" id="year" 
					   value="<?php if(!empty($row['year'])) echo $row['year']; else echo '';?>" required>
			</td>
		</tr>

		<tr>
			<td>Amount:</td>
			<td><input type="text" name="amount" id="amount" 
					  value="<?php if(!empty($row['amount'])) echo $row['amount']; else echo '';?>" required>
			</td>
		</tr><?php 
			if(!empty($row['recid'])) {?>

				<input type="hidden" name="recid" value="<?php echo $row['recid']; ?>">
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Update">
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
		$('#sal-form').validate();

		$('#save').click(function(){

			if(isNaN($('#month').val()) || isNaN($('#year').val()) || isNaN($('#amount').val()) || $('#month').val() % 1 != 0 || $('#year').val() % 1 != 0 || $('#amount').val() % 1 != 0  ){
				alert("Please enter valid values");	
				return false;
			}
		});
		
		/*$('#save').click(function(){
			//alert("here");
			var n = $('#name').val();
			var letters = new RegExp("^[a-zA-Z]+$");
			//alert(letters);
			if(letters.test(n)){
				alert("Name must be alphabetic");
			}
		});*/	
	});
</script>