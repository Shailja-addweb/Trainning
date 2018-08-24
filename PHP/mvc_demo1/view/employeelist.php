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
<!-- <script >
	$(document).ready(function(){

 		// Delete 
 		$('.delete').click(function(){
  			var el = this;
  			var id = this.id;
  			var splitid = id.split("_");

  			// Delete id
  			var deleteid = splitid[1];
 
  			// AJAX Request
  			$.ajax({
   				url: 'remove.php',
   				type: 'POST',
   				data: { id:deleteid },
   				success: function(response){

    			// Removing row from HTML Table
    				$(el).closest('tr').css('background','tomato');
    				$(el).closest('tr').fadeOut(800, function(){ 
     					$(this).remove();
    				});

   				}
  			});

 		});
	});
</script> -->

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
		<!-- <th>Endeffdt</th> -->
		<th colspan="2">ACTION</th>
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
				<td><?php echo $resultArray['contact_number']; ?></td>
				<td><?php echo $resultArray['department']; ?></td>
				<td><?php echo $resultArray['date_of_joining']; ?></td>
				<td><?php echo $resultArray['date_of_leaving']; ?></td>
				<td><a href="index.php?op=statusemp&id=<?php echo $resultArray['recid'];?>"><?php echo $resultArray['status']; ?></a></td>
				<!-- <td><?php echo $resultArray['endeffdt']; ?></td> -->
				<td><a href="index.php?op=edit&id=<?php echo $resultArray['recid'];?>">Edit</a></td>
				<td><span class="delete">
				<a onClick="javascript: return confirm('Please confirm deletion	');" href="index.php?op=delete&id=<?php echo $resultArray['recid'];?>">Delete</a>
				</span></td>
			</tr><?php
	} } else { ?>
		<td colspan="5">No Record</td><?php
	}?>
	
	

</table>

<form method="post" action="" name="btn-name">
   <label><input type="radio" name="all" value="all" id = "all" onclick="location.href='index.php?op=allemp'"> All</label>
  	<label><input type="radio" name="active" value="active" id = "active" onclick="location.href='index.php?op=activeemp'"> Active</label>
  	<label><input type="radio" name="inactive" value="inactive" id = "inactive" onclick="location.href='index.php?op=inactiveemp'"> Inactive </label>
 </form>