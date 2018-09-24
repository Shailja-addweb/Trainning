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


	  	public function fetchImages($p_id){

	  		$query = "SELECT id,name,flag FROM images 
	  						WHERE p_id = $p_id AND isdelete IS NULL AND name <> 'default.png'";
	  		$result = mysqli_query($this->con, $query);
	  		return $result;
	  	}

	  	public function productname($p_id){
	  		$query = "SELECT name FROM products WHERE id = $p_id AND isdelete IS NULL";
	  		$result = mysqli_query($this->con, $query);
	  		$noofrow = mysqli_num_rows($result);  
                if($noofrow>0){
                    while ($pro_name = mysqli_fetch_array($result)) {
                    	$name = $pro_name['name'];
                   	}
                }
	  		return $name;
	  	}

	  	public function fetchId_shop(){
			$query = "SELECT id,p_id FROM images WHERE isdelete IS NULL  AND name <> 'default.png' AND flag = 'Y' ORDER BY p_id";
			$result = mysqli_query($this->con, $query); 
			return $result;
		}

		public function Product_img_Details($id){
			$query="SELECT * FROM images WHERE p_id = $id AND isdelete IS NULL AND name <> 'default.png'";
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function ProductDetails(){
			$query="SELECT * FROM images WHERE p_id = 2 AND isdelete IS NULL AND name <> 'default.png'";
			$result = mysqli_query($this->con, $query);
			return $result;
		}
		public function Product_Details($id){
			$query = "SELECT p.name, p.quantity, p.price, GROUP_CONCAT(DISTINCT c.name) 
						FROM products AS p 
						INNER JOIN product_category AS pc ON p.id = pc.p_id 
						INNER JOIN category AS c ON pc.c_id = c.id 
						WHERE p.isdelete IS NULL 
	  								AND c.isdelete IS NULL  
	  								AND p.id = $id
	  								GROUP BY p.id ";
			$result = mysqli_query($this->con, $query);
			return $result;
		}
	}
?>