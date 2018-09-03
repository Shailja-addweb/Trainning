<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form method="post" action="" name="addemployeeForm" id="sal-form">
	<table cellpadding="10">

		<tr>
			<td>Employee Name:</td>
			<td><input type="text" name="employee_name" id="name"
					   value="<?php if(!empty($row['employee_name'])) echo $row['employee_name']; else echo '';?>" >
			</td>
		</tr>

		<tr>
			<td>Month:</td>
			<td><input type="text" name="month" id="month" 
					    value="<?php if(!empty($row['month'])) echo $row['month']; else echo '';?>" >
			</td> 
		</tr>

		<tr>
			<td>Year:</td>
			<td><input type="text" name="year" id="year" 
					   value="<?php if(!empty($row['year'])) echo $row['year']; else echo '';?>" >
			</td>
		</tr>

		<tr>
			<td>Amount:</td>
			<td><input type="text" name="amount" id="amount" min="0" 
					  value="<?php if(!empty($row['amount'])) echo $row['amount']; else echo '';?>" >
			</td>
		</tr><?php 
			if(!empty($row['recid'])) {?>

				<input type="hidden" name="recid" value="<?php echo $row['recid']; ?>">
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
			var letters = new RegExp("^[a-zA-Z]+$");
			var currentYear = (new Date).getFullYear();
			var amount = $('#amount').val();
			var month = $('#month').val();
			var year = $('#year').val();

			if(n == '' || amount == '' || month == '' || year == '') {
				alert("Please Enter values ");
				return false;
			}
			else{
				if(isNaN(month) || isNaN(year) || isNaN(amount) || month % 1 != 0 || year % 1 != 0 || amount % 1 != 0  ){
					alert("Please enter valid values of month year and amount and all values are required");	
					return false;
				}
				else if(month < 1 && month > 12) {
					alert("Please Enter month Between 1 to 12");
					return false;
				}
				else if(year < 2000 && year >= currentYear) {
					alert("Please Enter year Between 2000 to currentYear");
					return false;
				}
				else if(letters.match(n)) {
					alert("Name must be alphabetic and it's required");
					return false;
				}
			}
			
		});	

		$('#update').click(function(){

			var n = $('#name').val();
			var letters = new RegExp("^[a-zA-Z]+$");
			var currentYear = (new Date).getFullYear();
			var amount = $('#amount').val();
			var month = $('#month').val();
			var year = $('#year').val();

			if(n == '' || amount == '' || month == '' || year == '') {
				alert("Please Enter values ");
				return false;
			}
			else{
				if(isNaN(month) || isNaN(year) || isNaN(amount) || month % 1 != 0 || year % 1 != 0 || amount % 1 != 0  ){
					alert("Please enter valid values of month year and amount and all values are required");	
					return false;
				}
				else if(month < 1 && month > 12) {
					alert("Please Enter month Between 1 to 12");
					return false;
				}
				else if(year < 2000 && year >= currentYear) {
					alert("Please Enter year Between 2000 to currentYear");
					return false;
				}
				else if(letters.match(n)) {
					alert("Name must be alphabetic and it's required");
					return false;
				}
			}
			
		});	
	});
</script>