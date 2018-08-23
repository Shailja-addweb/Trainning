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

<table cellpadding="10" cellspacing="5">
	<tr>
		<td colspan="6" align="right"><a href="index.php?op=adddep">Add Department</a></td>
	</tr>

	<tr>
		<th>Id</th>
		<th>Name</th>
		<th>Status</th>
	    <th>Endeffdt</th>
		<th colspan="2">ACTION</th>
	</tr>
	<?php 
	if($noofrow>0) {
		while($resultArray = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><?php echo $resultArray['recid']; ?></td>
				<td><?php echo $resultArray['name']; ?></td>
				<td><a href="#"><?php echo $resultArray['status']; ?></a></td>
				<td><?php echo $resultArray['endeffdt']; ?></td>
				<td><a href="index.php?op=editdep&id=<?php echo $resultArray['recid'];?>">Edit</a></td>
				<td><span class="delete">
				<a onClick="javascript: return confirm('Please confirm deletion	');" href="index.php?op=deletedep&id=<?php echo $resultArray['recid'];?>">Delete</a>
				</span></td>
			</tr><?php
	} } else { ?>
		<td colspan="5">No Record</td><?php
	}?>

	
	
</table>
  