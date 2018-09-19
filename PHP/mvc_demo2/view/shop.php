<style>

	.row{
		width: 100%;
		display: block;
	}
	
	div.column {
		float: left;
		width: 33%;
		height: 100%;

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

</style>
<?php
	echo "<center><h1>::Products::</h1></center>";
	
	echo "<div class=\"row\">";
		echo $data;
	echo "</div>";

?>