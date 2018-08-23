<form method="post" action="" name="addemployeeForm">
<table cellpadding="10">

	<tr>
		<td>Employee Name:</td>
		<td><input type="text" name="employee_name" value="<?php if(!empty($row['employee_name'])) echo $row['employee_name']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Month:</td>
		<td><input type="text" name="month" value="<?php if(!empty($row['month'])) echo $row['month']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Year:</td>
		<td><input type="text" name="year" value="<?php if(!empty($row['year'])) echo $row['year']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Amount:</td>
		<td><input type="text" name="amount" value="<?php if(!empty($row['amount'])) echo $row['amount']; else echo '';?>"></td>
	</tr>

	<?php if(!empty($row['recid'])) {?>

	<input type="hidden" name="recid" value="<?php echo $row['recid']; ?>">
	<tr>
		<td colspan="2"><input type="submit" name="submit" value="Update">
			<input type="reset" name="reset" value="Cancel">
		</td>
	</tr><?php 

	} else { ?>
	<tr>
		<td colspan="2"><input type="submit" name="submit" value="Save">
			<input type="reset" name="reset" value="Cancel">
		</td>
	</tr><?php
	} ?>
	
</table>
</form>