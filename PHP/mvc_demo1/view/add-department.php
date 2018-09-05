<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form method="post" action="" name="addemployeeForm" id="dep-form">
	<table cellpadding="10">

		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" 
			           value="<?php if(!empty($row['name'])) echo $row['name']; else echo '';?>" required>
			</td>
		</tr><?php 
		if(!empty($row['recid'])) {?>

			<input type="hidden" name="recid" value="<?php echo $row['recid']; ?>">

			<tr>
				<td colspan="2"><input type="submit" name="submit" value="Update" id= "update">
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
		$('#dep-form').validate();
		
		$('#save').click(function(){
			var n = $('#name').val();
			var letters = new RegExp("^[a-zA-Z]+$");
			
			if(!letters.test(n)){
				var res = alert(" Department Name must be alphabetic");
				return false;
			}
		});	

		$('#update').click(function(){
			var n = $('#name').val();
			var letters = new RegExp("^[a-zA-Z]+$");
			
			if(!letters.test(n)){
			    alert("Department Name must be alphabetic");
				return false;
			}
		});
	});
</script>