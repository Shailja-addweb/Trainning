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

<?php if(isset($_GET['add_flag']) && $_GET['add_flag'] == '1') {
	echo '<span class="succmsg"> Record Inserted Successfully </span>';
} else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '1') {
	echo '<span class="succmsg"> Record Updated Successfully </span>';
} else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong..!! </span>';
} else if(isset($_GET['add_flag']) && $_GET['add_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong..!! </span>';
} else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '1') {
	echo '<span class="succmsg"> Record Deleted Successfully </span>';
} else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '0') {
	echo '<span class="failmsg"> Something goes wrong..!! </span>';
} else {
	echo '';
}; ?>

<table cellpadding="10" cellspacing="5">
	<tr>
		<td colspan="6" align="right"><a href="index.php?op=add">Add User</a></td>
	</tr>

	<tr>
		<th>Id</th>
		<th>User Name</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Address</th>
		<th>Contact Number</th>
		<th>Department</th>
		<th>Date of Joining</th>
		<th>Date of leaving</th>
		<th>Status</th>
		<th>Endeffdt</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	<?php 
	if($noofrow>0) {
		while($resultArray = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><?php echo $resultArray['recid']; ?></td>
				<td><?php echo $resultArray['username']; ?></td>
				<td><?php echo $resultArray['firstname']; ?></td>
				<td><?php echo $resultArray['lastname']; ?></td>
				<td><?php echo $resultArray['address']; ?></td>
				<td><?php echo $resultArray['contact-number']; ?></td>
				<td><?php echo $resultArray['department']; ?></td>
				<td><?php echo $resultArray['date-of-joining']; ?></td>
				<td><?php echo $resultArray['date-of-leaving']; ?></td>
				<td><?php echo $resultArray['status']; ?></td>
				<td><?php echo $resultArray['endeffdt']; ?></td>
				<td><a href="index.php?op=edit&id=<?php echo $resultArray['recid'];?>">Edit</a></td>
				<td><a onClick="javascript: return confirm('Please confirm deletion');" href="index.php?op=delete&id=<?php echo $resultArray['recid'];?>">Delete</a></td>
			</tr><?php
	} } else { ?>
		<td colspan="5">No Record</td><?php
	}?>
	
</table>
  