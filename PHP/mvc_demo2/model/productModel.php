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

	  		$query = "SELECT * FROM product WHERE isdelete = 0 ";
			$result = mysqli_query($this->con, $query);
			return $result;

	  	}

	  	public function AddProduct($arrayrecords){

	  		$query = "INSERT INTO product
					(name, category, image, price, quantity, status, isdelete) 
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
	  		$query = "SELECT * FROM product WHERE p_id='$id' " ;		
			$result = mysqli_query($this->con, $query);
			return $result;
	  	}

	  	public function EditProduct($arrayrecords) {
		
			$query = "UPDATE product 
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
			$query = " UPDATE product 
						SET image = 'default.png' WHERE p_id = $id " ;
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function ChangeStatusP($id){

			$query = "UPDATE product 
						SET status = IF(status=1, 0, 1) WHERE p_id = $id ";

			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function DeleteProduct($id) {
			$query = "UPDATE product
					  	SET isdelete = 1 WHERE p_id=$id";	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function ShowProduct($name){
			$query = "SELECT name,category FROM product ";
			$cat = mysqli_query($this->con, $query);
			$noofrow = mysqli_num_rows($cat);
			$result = 'Product of '.$name.' category are : ';
			if($noofrow>0){
				while ($resultdata = mysqli_fetch_array($cat)) {
					$namecat = explode(", ", $resultdata['category']);
					foreach ($namecat as $i => $key) {
						$categoryname = explode(',', $key);
						for ($i=0; $i < count($categoryname); $i++) { 
							$name = trim($name," ");
							if($categoryname[$i] == $name){
								$result .= $resultdata['name'];
								$result .= ", ";
							}
						}
					}
				}
			}
			return $result;
		}

		public function Search($keyword){
			$query =" SELECT name FROM product 
						WHERE name like '" . $keyword . "%' AND isdelete = 0 ORDER BY name LIMIT 0,6 ";

			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function SearchShow($keyword){

			$query = " SELECT * FROM product
						WHERE name = '$keyword' AND isdelete = 0 ";			
			$result = mysqli_query($this->con, $query);
			return $result;

		}

	}

?>