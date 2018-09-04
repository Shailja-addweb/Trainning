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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
	
</script><?php

	if(isset($_GET['add_flag']) && $_GET['add_flag'] == '1') {
		echo '<span class="succmsg"> Record Inserted Successfully </span>';
	}
 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '1') {
		echo '<span class="succmsg"> Record Updated Successfully </span>';
	}
 	else if(isset($_GET['update_flag']) && $_GET['update_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong..!! </span>';
	}
 	else if(isset($_GET['add_flag']) && $_GET['add_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong with add..!! </span>';
	}
 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '1') {
		echo '<span class="succmsg"> Record Deleted Successfully </span>';
	}
 	else if(isset($_GET['delete_flag']) && $_GET['delete_flag'] == '0') {
		echo '<span class="failmsg"> Something goes wrong..!! </span>';
	}
 	else {
		echo '';
	}; ?><br>


<div class="data">
	<form method="post" action="" name="btn-name"><?php
		
		$act_checked = '';
		$inct_checked = '';
		$allchecked = 'checked="checked"';

		if ( $_GET['op'] == 'allemp' ) {
			$allchecked = 'checked="checked"';
		} elseif ( $_GET['op'] == 'activeemp' ) {
			$act_checked = 'checked="checked"';
		} elseif ( $_GET['op'] == 'inactiveemp' ) {
			$inct_checked = 'checked="checked"';
		}
	
	?><label><input type="radio" name="show" value="all" id = "all" 
					onclick="location.href='index.php?op=allemp'"  
					oncload="location.href='index.php?op=allemp'" <?php echo $allchecked ;?> > All
		</label>

  		<label><input type="radio" name="show" value="active" id = "active" 
  					  onclick="location.href='index.php?op=activeemp'" <?php echo $act_checked ;?>> Active
  		</label>

  		<label><input type="radio" name="show" value="inactive" id = "inactive" 
  					  onclick="location.href='index.php?op=inactiveemp'" <?php echo $inct_checked ;?>> Inactive 
  		</label>

 	</form>

 	SORT BY : <a href="javascript:;" id="sort_dep_asc">Department ASC</a> &nbsp; &nbsp;
 	<a href="javascript:;" id="sort_dep_desc">Department DESC</a> &nbsp; &nbsp;
 	<a href="javascript:;" id="sort_dj_asc">Date of Joining ASC</a>&nbsp; &nbsp;
 	<a href="javascript:;" id="sort_dj_desc">Date of Joining DESC</a>


	<table cellpadding="10" cellspacing="5" id="tblEmp">
		<tr>
			<td colspan="6" align="right"><a href="index.php?op=addemp">Add Employee</a></td>
		</tr>

		<?php echo $data; ?>

	</table>

</div>

<script >

	$(document).ready(function(){

 		// Delete 
 		$('.delete').click(function(e){

  			var recId = $(this).attr("data-id");
  			var res = confirm('Please confirm deletion');
  			e.preventDefault();
            /*var form = $("#record");
            var rec = $(".re");*/

  			if(res){
  				$.ajax({
   					url: 'index.php?op=delete&id='+recId,
   					type: 'GET',
   					success: function(response){

  						  $('#records').empty();
  						  $('#records').html(response);
   					}
    			});
  			}
   		});
 		 	
 		$('.status').click(function(){
 		 	var recId = $(this).attr("data-id");
 		 	var Status = $(this).text();

			$.ajax({
 		 		url: 'index.php?op=changeE&id='+recId,
 		 		type: 'GET',
 		 		success: function(response){
 		 			
 		 			/*if ( Status == 1 ){
						$('#status-'+recId).text("Inactive");
					}
					else {
				 		$('#status-'+recId).text('Active');
				 	}*/
				 	$('#records').html(response);
 		 		}
 		 	});
		});

		$('#sort_dep_asc').click(function(){

			$.ajax({
				url: 'index.php?op=sortdep_asc',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});

		$('#sort_dep_desc').click(function(){

			$.ajax({
				url: 'index.php?op=sortdep_desc',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});

		$('#sort_dj_asc').click(function(){

			$.ajax({
				url: 'index.php?op=sortdj_asc',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});

		$('#sort_dj_desc').click(function(){

			$.ajax({
				url: 'index.php?op=sortdj_desc',
				type:'GET',
				success: function(response){

					$('#records').html(response);
				}
			});
		});

		/*var table = $('table');
		$('#dep, #dj').wrapInner('<span title="sort this column"/>').each(function(){

			var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function(){

            	table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
            });
		});*/
 	});
</script>
</div>
