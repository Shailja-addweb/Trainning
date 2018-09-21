<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<form method="post" action="" name="addcategoryform" id="cat-form" enctype="multipart/form-data"> 
	<table cellpadding="10">

		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" 
			           value="<?php if(!empty($row['name'])) echo $row['name']; else echo '';?>">
			</td>
		</tr>

		<tr>
			<td>Image:</td>
			<td>
				<?php if (!empty($row['id'])) { ?>
						<div class="forImages">
						<?php if(!empty($row['image'])){
							?>
					<img src="images/<?php echo $row['image'];?> " width="100" height="80" alt="book image" id="forimage"><?php }
					else {?>
						<img src="images/default.png" width="100" height="80" alt="book image" id="forimage"> <?php }?><br><br>
					<input type="checkbox" name="change" value="change" id="change">Change Photo &nbsp; &nbsp;  
					
					<a id="remove" data-id=<?php echo $row['id'];?> href="javascript:;">REMOVE PHOTO</a></div><br>
					<div class="changeimage" style="display: none">
						<input type="file" name="image" accept="image/*" id="image"  value="<?php if(!empty($row['image'])) echo $row['image']; else echo '';?>">
					</div>
				<?php } 

				else { ?>
					<input type="file" name="image" accept="image/*" id="newimage"  value="<?php if(!empty($row['image'])) echo $row['image']; else echo '';?>">
				<?php } ?>

			</td>
		</tr>

		<?php 
				if(!empty($row['id'])) {?>

					<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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
			var Id = $(this).attr("data-id");
 		 	var Status = $(this).text();

			$.ajax({
 		 		url: 'index.php?op=remove&id='+Id,
 		 		type: 'GET',
 		 		success: function(response){

 		 		}
 		 	});
		});

		$('#save').click(function(){
			
			var name = $('#name').val();
			var image = $('input[type=file]').val().split("\\").pop();
			var ext = image.split(".").pop();
			
			var letter = new RegExp("^[a-zA-Z0-9_]+$");	

			if(name == ''){
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)){
					alert("Name must be alphabetic(include alphabets, numbers and unserscore)");
					return false;	
			}
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg', '']) == -1){
				alert("invalid image file");
				return false;	
			}
			else {
				var res = confirm("Are you sure you want to save records?");

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
			var image = $('input[type=file]').val().split("\\").pop();
			var ext = image.split(".").pop();
			
			var letter = new RegExp("^[a-zA-Z0-9_]+$");	

			if(name == ''){
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)){
					alert("Name must be alphabetic(include alphabets, numbers and unserscore)");
					return false;	
			}
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg', '']) == -1){
				alert("invalid image file");
				return false;	
			}
			else {
				var res = confirm("Are you sure you want to update records?");

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
