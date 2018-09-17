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
			<td><?php if(!empty($row['p_id'])){
					$cat = explode(",",$row['category']);
					//$rowarray = mysqli_fetch_array($result);

					$i = 0;
						if($noofrow>0){
							while($rowarray = mysqli_fetch_array($result)) {
								$id = $cat[$i];
								$name = $this->categoryModel->gettingname($id);
								echo '<label><input type="checkbox" name="category[]" value="' . $rowarray["id"] . '"'. ($rowarray['name'] == $name ? 'checked = "checked"' : '') .'>' .  $rowarray["name"] . '</label>&nbsp;';
								$i++;	
							}
						}

				}else?>
					<?php if($noofrow>0){
						while($rowarray = mysqli_fetch_array($result)) {
							echo '<label><input type="checkbox" name="category[]" value="' . $rowarray["id"] . '">' .  $rowarray["name"] . '</label>&nbsp;';
						}
					}?> 
			</td>
		</tr>
		
		<tr>
			<td>Image:</td>
			<td>
				<?php if (!empty($row['p_id'])) { ?>
						<div class="forImages">
							<div class="images">
								<?php if(!empty($row['image'])){
		                            $ima = explode(",",$filename);
		                            foreach($ima as $i =>$key){
		                                echo "<span data-id=\"".$row['p_id']."\" id=\"image".$row['p_id']."\"> <img src=\"images/" . $key . "\" width=\"50\" height=\"50\"> <a href=\"javascript:;\" class=\"delete\" id=\"delete".+$i."\">DELETE</a></span>" ;
		                            }
		                        }
								else {?>
									<img src="images/default.png" width="100" height="80" alt="book image" id="forimage"> <?php }?>
							</div><br><br>

					<a href="javascript:;" id="newimage">Add Image</a> 
					<!-- <input type="checkbox" name="change" value="change" id="change">Change Profile Photo --> &nbsp; &nbsp;  
					<a id="remove" data-id=<?php echo $row['p_id'];?> href="javascript:;">REMOVE ALL IMAGES</a></div><br>

					<div class="changeimage" style="display: none">
						<!-- <input type="file" name="otherimage[]" accept="image/*" id="image"  value="<?php //if(!empty($row['image'])) echo $row['image']; else echo '';?>"  multiple > -->
					</div>
				<?php } 

				else { ?>
					<div class="images"><input type="file" name="image[]" id="image"  value="<?php if(!empty($row['imagename'])) echo $row['imagename']; else echo '';?>" multiple ></div> <br>
					
				<?php } ?>

			</td>
		</tr>

		<tr>
			<td>Price:</td>
			<td><input type="text" name="price" id="price" 
						value="<?php if(!empty($row['price'])) echo $row['price']; else echo '';?>">
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
		var i = 1;

		/*$('#change').click(function(){
			if($(this).is(":checked")) {
				$('.forImages').hide();
        		$(".changeimage").show();
        		$('#remove').hide();

        		var x = document.createElement("INPUT");
			    x.setAttribute("type", "file");
			    x.setAttribute("id", "image"+i);
			    x.setAttribute("name","image[]");
			    x.setAttribute("value","");
			    x.setAttribute("multiple", true);
			    $(".changeimage").append(x);
		    	i++;
		    	
    		} else {
        		$(".changeimage").hide();
        		$('.forimage').show();
        		$('#remove').show();
    		} 
		});*/
		
		$("#remove").click(function(){
			  //$('img').attr('src','images/default.png');
			  $('span').remove();
			var Id = $(this).attr("data-id");
 		 	var Status = $(this).text();

			$.ajax({
 		 		url: 'index.php?op=remove&id='+Id,
 		 		type: 'GET',
 		 		success: function(response){
 		 		
 		 		}
 		 	});
		});

		$("span").click(function(){
			//$(this).remove();
			var Id = $(this).attr("data-id");
			var src = $("span").closest("img").attr("src");
			alert(src);

			/*$.ajax({
 		 		url: 'index.php?op=remove&id='+Id,
 		 		type: 'GET',
 		 		success: function(response){
 		 		
 		 		}
 		 	});*/
		});

		$("#newimage").click(function(){
			var x = document.createElement("INPUT");
		    x.setAttribute("type", "file");
		    x.setAttribute("id", "image"+i);
		    x.setAttribute("name","image[]");
		    //x.setAttribute("value","<?php //if(!empty($row['image'])) echo $row['image']; else echo '';?>");
		    x.setAttribute("value","");
		    x.setAttribute("multiple", true);
		    $(".images").append(x);
		    i++;	
		});

		$('#save').click(function(){
			
			var name = $('#name').val();
			var category = $('#category').val();
			var price = $('#price').val();
			var quantity = $('#quantity').val();
			var image = $('#image').val();
			var ext = $	('#image').val().split('.').pop().toLowerCase();
			var letter = new RegExp("^[a-zA-Z-_0-9]+$");

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
			var letter = new RegExp("^[a-zA-Z_-0-9]+$");

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
			/*else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg']) == -1){
				alert("invalid image file");
				return false;	
			}*/
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
