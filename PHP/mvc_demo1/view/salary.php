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

<?php if(isset($_POST['add_flag']) && $_POST['add_flag'] == '1') {
	echo '<span class="succmsg"> Record Inserted Successfully </span>';
}
 else if(isset($_POST['update_flag']) && $_POST['update_flag'] == '1') {
	echo '<span class="succmsg"> Record Updated Successfully </span>';
}
 else if(isset($_POST['update_flag']) && $_POST['update_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong..!! </span>';
}
 else if(isset($_POST['add_flag']) && $_POST['add_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong with add..!! </span>';
}
 else if(isset($_POST['delete_flag']) && $_POST['delete_flag'] == '1') {
	echo '<span class="succmsg"> Record Deleted Successfully </span>';
}
 else if(isset($_POST['delete_flag']) && $_POST['delete_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong..!! </span>';
}
 else {
	echo '';
}; ?>
<br />
<br />
<form method = "post" action="index.php?op=show">
Employee Name : 
<select id = "name" name = "emp_name">
	<option > Select Name </option>
	<?php 
		if($row>0){
			while ($resultArrayN = mysqli_fetch_array($result1)) {
            	echo '<option value="'.$resultArrayN['recid'].'">'.$resultArrayN['employee_name'].
            	'</option>';
			}        
        }
	?>
	
	
</select>

Month : <input type="text" name="month"> 
Year : <input type="text" name="year">

<button>Show</button>
</form>
<br />
<br />
<br />

<table cellpadding="10" cellspacing="5">
	<tr>
		<td colspan="6" align="right"><a href="index.php?op=addsal">Add Salary</a></td>
	</tr>

	<tr>
		<th>Id</th>
		<th>Employee Name</th>
		<th>Month</th>
	    <th>Year</th>
	    <th>Amount</th>
		<th colspan="2">ACTION</th>
	</tr>
	<?php 
	if($noofrow > 0) {
	
		while($resultArray = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><?php echo $resultArray['recid']; ?></td>
				<td><?php echo $resultArray['employee_name']; ?></td>
				<td><?php echo $resultArray['month']; ?></td>
				<td><?php echo $resultArray['year']; ?></td>
				<td><?php echo $resultArray['amount'];?></td>
				<td><a href="index.php?op=editsal&id=<?php echo $resultArray['recid'];?>">Edit</a></td>
				<td><span class="delete">
				<a onClick="javascript: return confirm('Please confirm deletion	');" href="index.php?op=deletesal&id=<?php echo $resultArray['recid'];?>">Delete</a>
				</span></td>
			</tr><?php
		} 
	} 
	else { ?>
		<td colspan="5">No Record</td><?php
	}?>

</table>