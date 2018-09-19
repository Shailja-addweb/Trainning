<?php

	class shopModel {

		var $con;
		function __construct()
	  	{
		    $servername = "mysql";
			$username = "root";
			$password = "root";
			$dbname = "php";

			// Create connection
			$this->con = mysqli_connect($servername, $username, $password, $dbname);

			// Check connection
			if (!$this->con) {
		    	die("Connection failed: " . mysqli_connect_error());
			}
			//echo "connected";
	  	}

	  	public function fetchImages($id){

	  		$query = "SELECT id,imagename,defaultimg FROM images 
	  						WHERE p_id = $id AND isdelete = '9999-12-31'";
	  		$result = mysqli_query($this->con, $query);
	  		return $result;
	  	}

	  	public function productname($id){
	  		$query = "SELECT name FROM products WHERE p_id = $id AND isdelete = '9999-12-31'";
	  		$result = mysqli_query($this->con, $query);
	  		$noofrow = mysqli_num_rows($result);  
                if($noofrow>0){
                    while ($pro_name = mysqli_fetch_array($result)) {
                    	$name = $pro_name['name'];
                    }
                }
	  		return $name;
	  	}
	}
?>