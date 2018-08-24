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
<script>
	/*$("#hide").click(function {
		delete_fun = function(){
			alert("here");
		}
	});*/
	/*function delete_fun() {
		//
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {
      			
    		}
  		};
  		xhttp.open("POST", "index.php?op=deletedep&id=<?php echo $resultArray['recid'];?>", true);
 	 	xhttp.send(<?php echo $resultArray['recid'];?>);
	}*/

	function delete_fun(){
		//alert("here");
        var req = new XMLHttpRequest();
        var out = '';
        var url = "index.php?op=deletedep&id=<?php echo $resultArray['recid'];?>";
        req.open('GET',url,true);

        req.onreadystatechange = function(){
            if (req.readyState == 4){
                //out = req.result;
                //$('#delrow').hide("slow");
                $('.delrow').hide();
            }
        }  
	}

	 /*function delete_fun(){
	 	//link clicked
	 	alert("here");
	 	$(".hide").click(function(){
	 		var id = $this->$resultArray['recid'];
	 		var rownum = id;
	 		 
	 	});
	 }*/
</script>

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
			<span id="delrow">
				<tr>
					<td><?php echo $resultArray['recid']; ?></td>
					<td><?php echo $resultArray['name']; ?></td>
					<td><a href="index.php?op=statusdep&id=<?php echo $resultArray['recid'];?>"><?php echo $resultArray['status']; ?></a></td>
					<td><?php echo $resultArray['endeffdt']; ?></td>
					<td><a href="index.php?op=editdep&id=<?php echo $resultArray['recid'];?>">Edit</a></td>
					<td>
					<a class ="hide" href="#" onClick="delete_fun()">Delete</a>
					</td>
				</tr>
			</span><?php
		} 
	}
	else { ?>
		<td colspan="5">No Record</td><?php
	}?>
	
</table>
  
 <form method="post" action="" name="btn-name">
   <label><input type="radio" name="all" value="all" id = "all" onclick="location.href='index.php?op=alldep'"> All</label>
  	<label><input type="radio" name="active" value="active" id = "active" onclick="location.href='index.php?op=activedep'"> Active</label>
  	<label><input type="radio" name="inactive" value="inactive" id = "inactive" onclick="location.href='index.php?op=inactivedep'"> Inactive </label>
 </form>