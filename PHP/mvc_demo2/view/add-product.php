<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<form method="post" action="" name="addemployeeForm" id="emp-form" enctype="multipart/form-data"> 
	<table cellpadding="10">

		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" 
			           value="<?php if(!empty($row['name'])) echo $row['name']; else echo '';?>">
			</td>
		</tr>

		<tr>
			<td>Category:</td>
			<td><input type="text" name="category" id="category" 
					   value="<?php if(!empty($row['category'])) echo $row['category']; else echo '';?>">
			</td>
		</tr>
		
		<tr>
			<td>Image:</td>
			<td>
				<?php if (!empty($row['p_id'])) { ?>
						<div class="forImages">
						<?php if(!empty($row['image'])){
							?>
					<img src="images/<?php echo $row['image'];?> " width="100" height="80" alt="book image" id="forimage"><?php }
					else {?>
						<img src="images/default.png" width="100" height="80" alt="book image" id="forimage"> <?php }?><br><br>
					<input type="checkbox" name="change" value="change" id="change">Change Profile Photo &nbsp; &nbsp;  
					<!-- <input type="button" name="remove" value="Remove Photo" id="remove"> -->
					<a id="remove" data-id=<?php echo $row['p_id'];?> href="javascript:;">REMOVE PHOTO</a></div><br>
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
			<td>Price:</td>
			<td><input type="text" name="price" id="price" 
			           value="<?php if(!empty($row['price'])) echo $row['price']; else echo ''; ?>">
			</td>
		</tr>

		<tr>
			<td>Quantity:</td>
			<td><input type="text" name="quantity" id="quantity" 
			           value="<?php if(!empty($row['quantity'])) echo $row['quantity']; else echo '';?>">
			</td>
		</tr>


		<?php 
				if(!empty($row['p_id'])) {?>

					<input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
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
			var recId = $(this).attr("data-id");
 		 	var Status = $(this).text();

			$.ajax({
 		 		url: 'index.php?op=remove&id='+recId,
 		 		type: 'GET',
 		 		success: function(response){
 		 		
 		 		}
 		 	});
		});

		$('#save').click(function(){
			
			var name = $('#name').val();
			var category = $('#category').val();
			var price = $('#price').val();
			var quantity = $('#quantity').val();
			var image = $('#image').val();
			var ext = $	('#image').val().split('.').pop().toLowerCase();
			var letter = new RegExp("^[a-zA-Z]+$");

			if(name == ''){
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)){
					alert("Name must be alphanumeric(include alphabet)");
					return false;
				
			}else if(category == ''){
				alert("Please enter Category");
				return false;
			}
			else if(price == ''){
				alert("Please enter Price");
				return false;
			}
			else if(isNaN(price)){
				alert("Price must be numeric ");
				return false;
			}
			else if(quantity == ''){
				alert("Please enter Price");
				return false;
			}
			else if(isNaN(quantity)){
				alert("Quantity must be numeric ");
				return false;
			}	
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1){
				alert("invalid image file");
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
			
			var name = $('#name').val();
			var category = $('#category').val();
			var price = $('#price').val();
			var quantity = $('#quantity').val();
			var image = $('#image').val();
			var ext = $	('#image').val().split('.').pop().toLowerCase();
			var letter = new RegExp("^[a-zA-Z]+$");

			if(name == ''){
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)){
					alert("Name must be alphanumeric(include alphabet)");
					return false;
				
			}else if(category == ''){
				alert("Please enter Category");
				return false;
			}
			else if(price == ''){
				alert("Please enter Price");
				return false;
			}
			else if(isNaN(price)){
				alert("Price must be numeric ");
				return false;
			}
			else if(quantity == ''){
				alert("Please enter Price");
				return false;
			}
			else if(isNaN(quantity)){
				alert("Quantity must be numeric ");
				return false;
			}	
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1){
				alert("invalid image file");
				return false;	
			}
			else {
				var res = confirm("Are you sure you want to Update records?");
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
