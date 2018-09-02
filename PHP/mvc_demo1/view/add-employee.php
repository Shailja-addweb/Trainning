<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<form method="post" action="" name="addemployeeForm" id="emp-form"> 
	<table cellpadding="10">

		<tr>
			<td>User Name:</td>
			<td><input type="text" name="username" id="username" 
			           value="<?php if(!empty($row['username'])) echo $row['username']; else echo '';?>">
			</td>
		</tr>

		<tr>
			<td>First Name:</td>
			<td><input type="text" name="firstname" id="firstname" 
					   value="<?php if(!empty($row['firstname'])) echo $row['firstname']; else echo '';?>">
			</td>
		</tr>

		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="lastname" id="lastname" 
			           value="<?php if(!empty($row['lastname'])) echo $row['lastname']; else echo ''; ?>">
			</td>
		</tr>

		<tr>
			<td>Address:</td>
			<td><input type="text" name="address" id="address" 
			           value="<?php if(!empty($row['address'])) echo $row['address']; else echo '';?>">
			</td>
		</tr>

		<tr>
			<td>Contact Number:</td>
			<td><input type="text" name="contact_number" id="contact_number" 
					   value="<?php if(!empty($row['contact_number'])) echo $row['contact_number']; else echo '';?>" >
		    </td>
		</tr>

		<tr>
			<td>Department:</td>
			<td><input type="text" name="department" id="department" 
		              value="<?php if(!empty($row['department'])) echo $row['department']; else echo '';?>">
		    </td>
		</tr>

		<tr>
			<td>Date of Joining:</td>
			<td><input type="text" name="date_of_joining" id="date_of_joining" 
			           value="<?php if(!empty($row['date_of_joining'])) echo $row['date_of_joining']; else echo '';?>" >
			</td>
		</tr>

		<tr>
			<td>Date of Leaving:</td>
			<td><input type="text" name="date_of_leaving" id="date_of_leaving" 
			           value="<?php if(!empty($row['date_of_leaving'])) echo $row['date_of_leaving']; else echo '';?>" >
			</td>
		</tr> <?php 
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
		
		$('#save').click(function(){
			
			var un = $('#username').val();
			var fn = $('#firstname').val();
			var ln = $('#lastname').val();
			var ad = $('#address').val();
			var dep = $('#department').val();
			var cn = $('#contact_number').val();
			var cnl = $('#contact_number').val().length;
			var dj = $('#date_of_joining').val();
			var dl = $('#date_of_leaving').val();
			var letters = new RegExp("^[a-zA-Z]+$");
			var letter = new RegExp("^[a-zA-Z0-9_.]+$");
			var num = new RegExp("^[0-9]+$");
			var dt = new RegExp("^\d{4}-\d{2}-\d{2}$");	

			if(!letter.test(un) || !letter.test(ad) || !letter.test(dep) ){
				alert("Username and address and department must be alphanumeric");
				return false;
			}
			else if(!letters.test(fn) || !letters.test(ln)){
				var res = alert("Name must be alphabetic");
				return false;
			}
			else if(!num.test(cn) || cnl != 10 ){
				alert("contact number must be numeric and 10 digit");
				return false;
			}
			else if( !dt.test(dj) || !dt.test(dl)){
				alert(dj "and" dl);
				alert("invalid format, format must be YYYY-MM-DD");
				return false;
			}
			else if( dl < dj ){
				alert("date of Leaving must be after date of joining");
				return false;
			}
			else {
				var res = confirm("Are you sure you want to save records?");
				//alert(res);
				if(res){
					return true;
				}
				else{
					return false;
				}
			}
		});
	});
</script>
