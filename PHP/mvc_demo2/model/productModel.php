<?php

	class productModel {

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


	  	public function ProductList(){

	  		$query = "SELECT * FROM Product WHERE isDelete = 0 ";
			$result = mysqli_query($this->con, $query);
			return $result;

	  	}

	  	public function AddProduct($arrayrecords){

	  		$query = "INSERT INTO Product
					(name, category, image, price, quantity, status, isDelete) 
					VALUES
					('" . addslashes($arrayrecords['name']) . "',
					'" . addslashes($arrayrecords['category']) . "',
					'" . $arrayrecords["image"] . "',
					'" . addslashes($arrayrecords['price']) . "',
					'" . addslashes($arrayrecords['quantity']) . "',
					'1',
					'0' )";
			
			$result = mysqli_query($this->con, $query);	
			
			return $result;
	  	}

	  	public function FetchProductDetails($id){
	  		$query = "SELECT * FROM Product WHERE p_id='$id' " ;		
			$result = mysqli_query($this->con, $query);
			return $result;
	  	}

	  	public function EditProduct($arrayrecords) {
		
			$query = "UPDATE Product 
						SET name = '" . addslashes($arrayrecords['name']) . "' , 
						category = '" . addslashes($arrayrecords['category']) . "',
						image = '" . $arrayrecords["image"] . "',
						price = '" . addslashes($arrayrecords['price']) . "',
						quantity = '" . addslashes($arrayrecords['quantity']) . "',
						status = '" . addslashes($arrayrecords['status']) . "'
						WHERE p_id='" . $arrayrecords['p_id'] . "'";	
			 	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function RemoveImg($id){
			$query = " UPDATE Product 
						SET image = 'default.png' WHERE p_id = $id " ;
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function ChangeStatusP($id){

			$query = "UPDATE Product 
						SET status = IF(status=1, 0, 1) WHERE p_id = $id ";

			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function DeleteProduct($id) {
			$query = "UPDATE Product
					  	SET isDelete = 1 WHERE p_id=$id";	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

	}

?>