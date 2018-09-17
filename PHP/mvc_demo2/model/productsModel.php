<?php

	class productsModel {

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

	  		// $query = "SELECT products.p_id, products.name, category.name, images.imagename, products.price, products.quantity, products.status FROM products inner join images on products.p_id = images.p_id WHERE products.isdelete = '9999-12-31' ";
			$query = "SELECT * FROM products WHERE isdelete = '9999-12-31' ";
			$result = mysqli_query($this->con, $query);
			return $result;

	  	}

	  	public function InsertImage($arrayimage){

	  		$query = "INSERT INTO images
	  					(p_id, imagename, defaultimg)
	  					VALUES ( 0,
	  							'" . $arrayimage['imagename'] . "',
	  							'N') ";
	  		//print_r($query);exit();
	  		$image = mysqli_query($this->con, $query);
	  		return $image;
	  	}

	  	public function FetchImageId(){

	  		$query = "SELECT id FROM images WHERE p_id = 0 ";
	  
	  		$fetchimgid = mysqli_query($this->con,$query);
	  		return $fetchimgid;
	  	}

	  	public function AddProduct($arrayrecords){

	  		$query = "INSERT INTO products
					(name, category, image, price, quantity, status, isdelete ) 
					VALUES
					('" . addslashes($arrayrecords['name']) . "',
					'" . addslashes($arrayrecords['category']) . "',
					'" . $arrayrecords["image"] . "',
					'" . addslashes($arrayrecords['price']) . "',
					'" . addslashes($arrayrecords['quantity']) . "',
					'1',
					'9999-12-31')";
			$result = mysqli_query($this->con, $query);	
			return $result;
	  	}

	  	public function fetchID($result){

                $query = "SELECT last_insert_id() FROM products";
                $lastid = mysqli_query($this->con, $query);
                $noofrow = mysqli_num_rows($lastid);  
                if($noofrow>0){
                    while ($last_id = mysqli_fetch_array($lastid)) {
                        $id = $last_id['last_insert_id()'];
                    }
                }
                $query1 = "UPDATE images
                			SET p_id = '$id' WHERE P_id = 0";
               	$res = mysqli_query($this->con, $query1);
               	return $res;
	  	}

	  	public function fetchID_c($result){

                $query = "SELECT last_insert_id() FROM products";
                $lastid = mysqli_query($this->con, $query);
                $noofrow = mysqli_num_rows($lastid);  
                if($noofrow>0){
                    while ($last_id = mysqli_fetch_array($lastid)) {
                        $id = $last_id['last_insert_id()'];
                    }
                }
                $query1 = "UPDATE category
                			SET p_id = '$id' WHERE P_id = 0";
               	$res = mysqli_query($this->con, $query1);
               	return $res;
	  	}

	  	public function FetchProductDetails($id){
	  		
	  		$query = "SELECT * FROM products WHERE p_id='$id'" ;	

	  		//$query = "SELECT products.p_id, products.name, products.category, images.imagename, products.price, products.quantity, products.status FROM products inner join images on products.p_id = images.p_id WHERE products.p_id='$id'" ;		
	  		//print_r($query);exit();
			$result = mysqli_query($this->con, $query);
			return $result;
	  	}

	  	public function FetchName($key){
	  		$query = "SELECT imagename FROM images WHERE id = $key ";
	  		$result = mysqli_query($this->con, $query);
	  		$noofrow = mysqli_num_rows($result);  
                if($noofrow>0){
                    while ($img_name = mysqli_fetch_array($result)) {
                        $name = $img_name['imagename'];
                        $id =$img_name['id'];
                    }
                }
                return $name;

	  	}

	  	public function EditProduct($arrayrecords) {
		
			$query = "UPDATE products 
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
			$query = " UPDATE products 
						SET image = '' WHERE p_id = $id " ;
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function ChangeStatusP($id){

			$query = "UPDATE products 
						SET status = IF(status=1, 0, 1) WHERE p_id = $id ";

			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function DeleteProduct($id) {
			$query = "UPDATE products
					  	SET isdelete = curdate() WHERE p_id=$id";	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function ShowProduct($name){
			$query = "SELECT name,category FROM products ";
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
			if (substr($result, -1, 1) == ',')
            {
                $result = substr($result, 0, -1);
            }
			return $result;
		}

		public function Search($keyword){
			$query =" SELECT name FROM products 
						WHERE name like '" . $keyword . "%' AND isdelete = '9999-12-31' ORDER BY name LIMIT 0,6 ";

			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function SearchShow($keyword){

			$query = " SELECT * FROM products
						WHERE name = '$keyword' AND isdelete = '9999-12-31' ";			
			$result = mysqli_query($this->con, $query);
			return $result;

		}


	}

?>