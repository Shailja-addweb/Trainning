<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<form method="post" action="" name="addemployeeForm" id="emp-form" enctype="multipart/form-data"> 
	<table cellpadding="10">
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" id="name" value="<?php if(!empty($row['name'])) echo $row['name']; else echo '';?>">
			</td>
		</tr>
		<tr>
			<td>Category:</td>
			<td><?php 
				if(!empty($row['id'])){
					$cat = explode(",",$row['GROUP_CONCAT(DISTINCT c.name)']);
					$i = 0;
					if($noofrow > 0) {
						while($rowarray = mysqli_fetch_array($result)) {
							$id = $cat[$i];
							$k = $rowarray['name'];
							if(in_array($k, $cat)) {
								$flag[$k] = 1;
							}
							else {
								$flag[$k] = 0;
							}
							echo '<label><input type="checkbox" name="category[]" value="' . $rowarray["id"] . '"'. ($flag[$k] == 1 ? 'checked = "checked"' : '') .'>' .  $rowarray["name"] . '</label>&nbsp;';
							$i++;	
						}
					}
				}
				else {
					if($noofrow > 0) {
						while($rowarray = mysqli_fetch_array($result)) {
							echo '<label><input type="checkbox" name="category[]" value="' . $rowarray["id"] . '">' .  $rowarray["name"] . '</label>&nbsp;';
						}
					}
				}
			?></td>
		</tr>
		<tr>
			<td>Image:</td>
			<td>
				<div id="image"><?php 
					if (!empty($row['id'])) { 
						?><div class="forImages">
							<div class="images"><?php 
								if(!empty($row['GROUP_CONCAT(DISTINCT i.name)'])) {
									$filename = $row['GROUP_CONCAT(DISTINCT i.name)'];
                					$filename = trim($filename, ',');
		                            $ima = explode(",",$filename);
		                            foreach($ima as $i => $key) {
		                            	if($key != 'default.png') {
		                                	echo "<span class = \"image_span\" data-id=\"".$row['id']."\" id=\"image".$img_id[$i]."\"> 
		                                	<img src=\"images/" . $key . "\" width=\"50\" height=\"50\"> 
		                                	<a href=\"javascript:;\" class=\"delete\" id=\"".$img_id[$i]."\">DELETE</a>
		                                	<label><input type=\"checkbox\" class=\"changedefault\" id=\"".$img_id[$i]."\" ".($img_flag[$i] == 'Y' ? 'checked = "checked"' : '').">Set as Default</label></span>" ;
		                            	}
		                            }
		                        }
								else {
									?><img src="images/default.png" width="100" height="80" alt="book image" id="forimage"><?php 
								}
							?></div><br><br>
							<a href="javascript:;" id="newimage">Add Image</a> 
							 &nbsp; &nbsp;  
							<a id="remove" data-id=<?php echo $row['id'];?> href="javascript:;">REMOVE ALL IMAGES</a></div><br><?php 
					} 
					else { 
						?><div class="images"><input type="file" name="image[]" id="image" value="<?php if(!empty($row['GROUP_CONCAT(DISTINCT i.name)'])) echo $row['GROUP_CONCAT(DISTINCT i.name)']; else echo '';?>" multiple ></div> <br><?php 
					}
				?></div>
			</td>
		</tr>
		<tr>
			<td>Price:</td>
			<td><input type="text" name="price" id="price" value="<?php if(!empty($row['price'])) echo $row['price']; else echo '';?>">
			</td>
		</tr>
		<tr>
			<td>Quantity:</td>
			<td><input type="text" name="quantity" id="quantity" value="<?php if(!empty($row['quantity'])) echo $row['quantity']; else echo '';?>">
			</td>
		</tr><?php 
			if(!empty($row['id'])) {
				?><input type="hidden" name="id" value="<?php echo $row['id']; ?>">
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Update" id=update>
									<input type="reset" name="reset" value="Cancel">
					</td>
				</tr><?php 
			} 
			else { 
				?><tr>
					<td colspan="2"><input type="submit" name="submit" value="Save" id="save"  /> 
									<input type="reset" name="reset" value="Cancel">
					</td>
				</tr><?php
			} 
		?></table>
</form>

<script>
	$(document).ready(function() {
		var i = 1;
		$('.changedefault').click(function() { 			
			var n = $("#image input:checkbox:checked").length;
			if( n > 1 ) {
				alert("Please select only one image as default");
				return false;
			}
			else {
				var id = $(this).attr("id");
				var p_id = $('span').attr("data-id");
				$.ajax({
		 		 	url: 'index.php?op=changedefault&id='+id+'&p_id='+p_id,
		 		 	type: 'GET',
		 		 	success: function(response)  {
		 		 		
		 			}
		 		});
			}	
		});

		$('.delete').click(function() {
			var check = $(this).closest('.image_span').find('input:checkbox');
			var id = check.attr('checked');
			if(id == undefined) {
				var res = confirm("Are you sure you want to delete this image?");
				var id_span = $(this).attr("id");
				if(res) {
					var id = $(this).attr("id");
					var p_id = $('span').attr("data-id");
					$.ajax ({
			 		 	url: 'index.php?op=delete&id='+id+'&p_id='+p_id,
			 		 	type: 'GET',
			 		 	success: function(response) {
			 		 		$('span[id = image'+id_span+']').remove();
			 		 	}
			 		});
				}
				else {
					return false;
				}
			}
			else {
				alert("You can't delete this is image beacuse this is default image.\n if you want to delete image first set another image as default.");
			}

		});
		
		$("#remove").click(function() {		 
			var res = confirm("Are you sure you want to REMOVE ALL IMAGES ?");
			if(res) {
				var Id = $(this).attr("data-id");
	 		 	var Status = $(this).text();
				$.ajax ({
	 		 		url: 'index.php?op=remove&id='+Id,
	 		 		type: 'GET',
	 		 		success: function(response) {
	 		 			$('span').remove();
	 		 		}
	 		 	});
			}
			else {
				return false;
			}
		});

		$("#newimage").click(function() {
			var x = document.createElement("INPUT");
		    x.setAttribute("type", "file");
		    x.setAttribute("id", "image"+i);
		    x.setAttribute("name","image[]");
		    x.setAttribute("value","");
		    x.setAttribute("multiple", true);
		    $(".images").append(x);
		    i++;	
		});

		$('#save').click(function() {	
			var name = $('#name').val();
			var category = $('input[type=checkbox]:checked').val();
			var price = $('#price').val();
			var quantity = $('#quantity').val();
			var image = $('input[type=file]').val().split("\\").pop();
			var ext = image.split(".").pop();
			var letter = new RegExp("^[a-zA-Z-_0-9'\\s]+$");
			var numbers = new RegExp("^[0-9.,]+$");

			if(name == '') {
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)) {
				alert("Name must be alphanumeric(include alphabet and numbers with underscore)");
				return false;	
			}
			else if(category == undefined) {
				alert("Please enter Category");
				return false;
			}
			else if(price == '') {
				alert("Please enter Price");
				return false;
			}
			else if(!numbers.test(price)) {
				alert("Price must be numeric ");
				return false;
			}
			else if(quantity == '') {
				alert("Please enter Quantity");
				return false;
			}
			else if(isNaN(quantity)) {
				alert("Quantity must be numeric ");
				return false;
			}	
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg', '']) == -1) {
				alert("invalid image file");
				return false;	
			}
			else {
				var res = confirm("Are you sure you want to save records?");
				if(res) {
					return true;
				}
				else {
					return false;
				}
			}
		});

		$('#update').click(function() {			
			var name = $('#name').val();
			var category = $('input[type=checkbox]:checked').val();
			var n = $("#image input:checkbox:checked").length;
			var price = $('#price').val();
			var quantity = $('#quantity').val();
			var image = $('input[type=file]').val().split("\\").pop();
			var ext = image.split(".").pop();
			var letter = new RegExp("^[a-zA-Z-_0-9'\\s]+$");
			var numbers = new RegExp("^[0-9.,]$");
			if(name == '') {
				alert("Please enter Name");
				return false;
			}
			else if(!letter.test(name)) {
				alert("Name must be alphanumeric(include alphabet and numbers with underscore)");
				return false;	
			}
			else if(category == undefined) {
				alert("Please enter Category");
				return false;
			}
			else if(price == '') {
				alert("Please enter Price");
				return false;
			}
			else if(numbers.test(price)) {
				alert("Price must be numeric ");
				return false;
			}
			else if(quantity == '') {
				alert("Please enter Quantity");
				return false;
			}
			else if(isNaN(quantity)) {
				alert("Quantity must be numeric ");
				return false;
			}	
			else if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'svg', '']) == -1) {
				alert("invalid image file");
				return false;	
			}
			else {
				var res = confirm("Are you sure you want to update records?");
				if(res) {
					return true;
				}
				else {
					return false;
				}
			}
		});
	});
</script>
