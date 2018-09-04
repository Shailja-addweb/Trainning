<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<form method="post" action="" name="addemployeeForm" id="emp-form" enctype="multipart/form-data"> 
	<table cellpadding="10">

		<tr>
			<td>Image:</td>
			<td>
				<?php if (!empty($row['recid'])) { ?>
						<div class="forImages">
						<?php if(!empty($row['image'])){
							?>
					<img src="images/<?php echo $row['image'];?> " width="100" height="80" alt="book image" id="forimage"><?php }
					else {?>
						<img src="images/default.png" width="100" height="80" alt="book image" id="forimage"> <?php }?><br><br>
					<input type="checkbox" name="change" value="change" id="change">Change Profile Photo &nbsp; &nbsp;  
					<input type="button" name="remove" value="Remove Photo" id="remove"></div><br>
					<div class="changeimage" style="display: none">
						<input type="file" name="image" accept="image/*" id="image"  value="<?php if(!empty($row['image'])) echo $row['image']; else echo '';?>">
					</div>
				<?php } 

				else { ?>
					<input type="file" name="image" accept="image/*" id="image"  value="<?php if(!empty($row['image'])) echo $row['image']; else echo '';?>">
				<?php } ?>

			</td>
		</tr>

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
		</tr> 

		<?php 
				if(!empty($row['recid'])) {?>

					<input type="hidden" name="recid" value="<?php echo $row['recid']; ?>">
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="Update" id=update>
										<input type="reset" name="reset" value="Cancel">
						</td>
					</tr><?php 
				} 
				else { ?>
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="Save" id="save"  /> 
										<input type="reset" name="reset" value="Cancel">
						</td>
					</tr><?php
				} ?>
	</table>

</form>

<script>
	$(document).ready(function(){

		$('.changeimage').hide();

		$('#change').click(function(){
			if($(this).is(":checked")) {
				$('#forimage').hide();
        		$(".changeimage").show();
        		$('#remove').hide();
    		} else {
        		$(".changeimage").hide();
        		$('#forimage').show();
        		$('#remove').show();
    		} 
		});
		
		$("#remove").click(function(){
			  $('#forimage').attr('src','images/default.png');
		});

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
			// var image = $('#image').val();
			var ext = $	('#image').val().split('.').pop().toLowerCase();
			var letters = new RegExp("^[a-zA-Z]+$");
			var letter = new RegExp("^[a-zA-Z0-9_.]+$");
			var num = new RegExp("^[0-9]+$");
			var dt = new RegExp("^\d{4}-\d{2}-\d{2}$");	

			if(un == '' || fn == '' || ln == '' || ad == '' || dep == '' || cn == '' || dj == '' || dl == '' ){
			 	alert("Please Enter each values");
			 	return false;
			 }
			else if(!letter.match(un) || !letter.match(ad) || !letters.match(dep) ){
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
			else if( !dt.match(dj) || !dt.match(dl)){
				alert("invalid format, format must be YYYY-MM-DD");
				return false;
			}
			else if( dl < dj ){
				alert("date of Leaving must be after date of joining");
				return false;
			}
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1){
				alert("invalid image file");
				//$('#image').val('');
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

		$('#update').click(function(){
			
			var un = $('#username').val();
			var fn = $('#firstname').val();
			var ln = $('#lastname').val();
			var ad = $('#address').val();
			var dep = $('#department').val();
			var cn = $('#contact_number').val();
			var cnl = $('#contact_number').val().length;
			var dj = $('#date_of_joining').val();
			var dl = $('#date_of_leaving').val();
			var image = $('#image').val();
			var ext = $	('#image').val().split('.').pop().toLowerCase();
			var letters = new RegExp("^[a-zA-Z]+$");
			var letter = new RegExp("^[a-zA-Z0-9_.,]+$");
			var num = new RegExp("^[0-9]+$");
			var dt = new RegExp("^\d{4}-\d{2}-\d{2}$");	

			 if(un == '' || fn == '' || ln == '' || ad == '' || dep == '' || cn == '' || dj == '' || dl == '' ){
			 	alert("Please Enter each values");
			 	return false;
			 }
			else if(!letter.match(un) || !letter.match(ad) || !letter.match(dep) ){
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
			/*else if( !dt.test(dj) || !dt.test(dl)){
				alert("invalid format, format must be YYYY-MM-DD");
				return false;
			}*/
			else if( dl < dj ){
				alert("date of Leaving must be after date of joining");
				return false;
			}
			/*else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1){
				alert("invalid image file");
				$('#image').val('');
				return false;	
			}*/
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
