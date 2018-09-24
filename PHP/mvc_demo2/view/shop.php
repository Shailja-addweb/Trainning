<style>

	.row{
		width: 100%;
		display: block;
	}
	
	div.column {
		float: left;
		width: 33%;
		height: 70%;

	}
	div.column a img{
		height: 70%;
	}
	img{
		float: left;
		padding-bottom: 20px;
		padding-right: 20px;
		width: 90%;
		
	}
	b{
		color: red;
		font-size: 30px;
	}
	.description {
		padding-top: 40px;
		font-size: 20px; 
		color: #7d00ff;
	}

</style>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="./js/autocomplete.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<div class="data">
		<?php
			echo "<center><h1>::Products::</h1></center>";
			
			echo "<div class=\"row\">";
				echo $data;
			echo "</div>";

		?>
	</div>

	<script>

		$(document).ready(function(){

			$('.other-img').click(function(){
				
				var img = $(this).find('img').attr("src");
				$('.selected-img').find('img').attr("src", img);
			});

		});
	</script>

</div>