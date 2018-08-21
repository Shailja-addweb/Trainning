<form method="post" action="" name="addemployeeForm">
<table cellpadding="10">
	<tr>
		<td>User Name:</td>
		<td><input type="text" name="username" value="<?php if(!empty($row['username'])) echo $row['username']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>First Name:</td>
		<td><input type="text" name="firstname" value="<?php if(!empty($row['firstname'])) echo $row['firstname']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Last Name:</td>
		<td><input type="text" name="lastname" value="<?php if(!empty($row['lastname'])) echo $row['lastname']; else echo ''; ?>"></td>
	</tr>

	<tr>
		<td>Address:</td>
		<td><input type="text" name="address" value="<?php if(!empty($row['address'])) echo $row['address']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Contact Number:</td>
		<td><input type="text" name="contact-number" value="<?php if(!empty($row['contact-number'])) echo $row['contact-number']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Department:</td>
		<td><input type="text" name="department" value="<?php if(!empty($row['department'])) echo $row['department']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Date of Joining:</td>
		<td><input type="text" name="date-of-joining" value="<?php if(!empty($row['date-of-joining'])) echo $row['date-of-joining']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Date of Leaving:</td>
		<td><input type="text" name="date-of-leaving" value="<?php if(!empty($row['date-of-leaving'])) echo $row['date-of-leaving']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Status:</td>
		<td><input type="text" name="status" value="<?php if(!empty($row['status'])) echo $row['status']; else echo '';?>"></td>
	</tr>

	<tr>
		<td>Endeffdt:</td>
		<td><input type="text" name="endeffdt" value="<?php if(!empty($row['endeffdt'])) echo $row['endeffdt']; else echo '';?>"></td>
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