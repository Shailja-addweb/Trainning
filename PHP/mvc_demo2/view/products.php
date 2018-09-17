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
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="./js/jquery-ui.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
		
	</script><?php

		if(isset($_GET['add_flag']) && $_GET['add_flag'] == '1') {
			echo '<span class="succmsg"> Record Inserted Successfully </span>';
		}
	 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '1') {
			echo '<span class="succmsg"> Record Updated Successfully </span>';
		}
	 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with update..!! </span>';
		}
	 	else if(isset($_GET['add_flag']) && $_GET['add_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with add..!! </span>';
		}
	 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '1') {
			echo '<span class="succmsg"> Record Deleted Successfully </span>';
		}
	 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '0') {
			echo '<span class="failmsg"> Something goes wrong with delete..!! </span>';
		}
		else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '0') {
			echo '<span class="failmsg"> Status is not changed..!! </span>';
		}
		else if(isset($_GET['status_flag']) && $_GET['status_flag'] == '1') {
			echo '<span class="succmsg"> Status changed. </span>';
		}
	 	else {
			echo '';
		}; ?><br>

	<br>
	<div class="search">
			<b>Search Product : </b>
			<input type="text" size="30" id="search-box">
			<div id="suggesstion-box"></div>
	</div>

	<div class="data">

		<table cellpadding="10" cellspacing="5" id="tblEmp">
			<tr>
				<td colspan="6" align="right"><a href="index.php?op=addproduct">Add Product</a></td>
			</tr>

			<?php echo $data; ?>

		</table>

	</div>

	<script >

		$(document).ready(function(){

			$("#search-box").keyup(function(){
				var keyword = $(this).val();
				var res = keyword.length;

				if(res == '3'){
					$("#suggesstion-box").autocomplete({
						source: "index.php?op=search&keyword=" + $(this).val()
					});
					/*$.ajax({
					url: "index.php?op=search&keyword="+keyword,
					type: "GET",
					success: function(response){

							 $("#suggesstion-box").show();
							 $("#suggesstion-box").html(response);
							 //$("#search-box").css("background","#FFF");
						}
					});*/
				}
			});

	 		// Delete 
	 		$('.delete').click(function(e){

	  			var Id = $(this).attr("data-id");
	  			var res = confirm('Are you sure you want to delete ?');
	  			e.preventDefault();

	  			if(res){
	  				$.ajax({
	   					url: 'index.php?op=deleteproduct&delete_flag=1&id='+Id,
	   					type: 'GET',
	   					success: function(response){

	  						  $('#records').empty();
	  						  $('#records').html(response);
	   					}
	    			});
	  			}
	   		});
	 		 	
	 		$('.status').click(function(){
	 		 	var Id = $(this).attr("data-id");
	 		 	var Status = $(this).text();

				$.ajax({
	 		 		url: 'index.php?op=changestatusp&status_flag=1&id='+Id,
	 		 		type: 'GET',
	 		 		success: function(response){

					 	$('#records').html(response);
	 		 		
	 		 		}
	 		 	});
			});		
	 	});

	 	function selectproduct(val) {
				$("#search-box").val(val);
				$("#suggesstion-box").hide();

				$.ajax({
					url: "index.php?op=searchshow&keyword="+val,
					type: "GET",
					success: function(response){

	  						$('#records').html(response);
						}
					});
			}

	</script>
</div>
