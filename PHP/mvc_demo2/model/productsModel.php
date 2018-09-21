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

	  		$query = "SELECT p.id, p.name, 
	  						GROUP_CONCAT(DISTINCT c.name), 
	  						GROUP_CONCAT(DISTINCT i.name), p.price, p.quantity, p.status 
	  					FROM products AS p 
	  						INNER JOIN images AS i ON p.id = i.p_id 
	  						INNER JOIN product_category AS pc ON p.id = pc.p_id 
	  						INNER JOIN category AS c ON pc.c_id = c.id 
	  							WHERE p.isdelete = '9999-12-31' 
	  								AND c.isdelete = '9999-12-31' 
	  								GROUP BY p.id";
	  		 					//print_r($query);exit();
			//$query = "SELECT * FROM products WHERE isdelete = '9999-12-31' ";
			$result = mysqli_query($this->con, $query);
			return $result;

	  	}

	  	public function AddProduct($arrayrecords){

	  		$query = "INSERT INTO products
					(name, price, quantity, status, isdelete ) 
					VALUES
					('" . addslashes($arrayrecords['name']) . "',
					'" . addslashes($arrayrecords['price']) . "',
					'" . addslashes($arrayrecords['quantity']) . "',
					'1',
					'9999-12-31')";
			$result = mysqli_query($this->con, $query);	
			return $result;
	  	}

	  	public function fetchp_id(){

			$query ="SELECT id FROM products WHERE isdelete = '9999-12-31' ORDER BY id DESC LIMIT 1";
			$result =  mysqli_query($this->con, $query);
			$noofrow = mysqli_num_rows($result);

			if($noofrow>0){
				while ($resdata = mysqli_fetch_array($result)) {
					$p_id = $resdata['id'];
				}
			}
			return $p_id;
		}

		public function category_insert($p_id,$c_id){

			$query = "INSERT INTO product_category 
						(p_id, c_id)
						VALUES
						('".$p_id."',
						'".$c_id."')";
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function InsertImage($arrayimage,$p_id){

	  		$query = "INSERT INTO images
	  					(p_id, name, flag, isdelete)
	  					VALUES ( '". $p_id ."',
	  							'" . $arrayimage['name'] . "',
	  							'N',
	  							'9999-12-31') ";
	  		//print_r($query);exit();
	  		$image = mysqli_query($this->con, $query);
	  		return $image;
	  	}

	  	public function FetchProductDetails($id){
	  		
	  		//$query = "SELECT * FROM products WHERE p_id='$id'" ;	

	  		$query = "SELECT p.id, p.name, 
	  						GROUP_CONCAT(DISTINCT c.name), 
	  						GROUP_CONCAT(DISTINCT i.name), p.price, p.quantity, p.status 
	  					FROM products AS p 
	  						INNER JOIN images AS i ON p.id = i.p_id 
	  						INNER JOIN product_category AS pc ON p.id = pc.p_id 
	  						INNER JOIN category AS c ON pc.c_id = c.id 
	  							WHERE p.isdelete = '9999-12-31' 
	  								
	  								AND c.isdelete = '9999-12-31' 
	  								AND p.id = $id
	  								GROUP BY p.id" ;		
	  		//print_r($query);exit();
			$result = mysqli_query($this->con, $query);
			return $result;
	  	}

	  	public function FetchName($key){
	  		$query = "SELECT id,name FROM images WHERE id = $key AND isdelete = '9999-12-31' AND name <> 'default.png' ";
	  		$result = mysqli_query($this->con, $query);
	  		$noofrow = mysqli_num_rows($result);  
                if($noofrow>0){
                    while ($img_name = mysqli_fetch_array($result)) {
                    	$res = array();
                        $name = $img_name['name'];
                        $res['name'][] = $name;
                        $id = $img_name['id'];
                        $res['id'][] = $id; 
                    }
                }
                return $res;

	  	}

	  	public function EditProduct($arrayrecords) {
		
			$query = "UPDATE products 
						SET name = '" . addslashes($arrayrecords['name']) . "' , 
						price = '" . addslashes($arrayrecords['price']) . "',
						quantity = '" . addslashes($arrayrecords['quantity']) . "',
						status = '" . addslashes($arrayrecords['status']) . "'
						WHERE id='" . $arrayrecords['id'] . "'";	
			
			$result = mysqli_query($this->con, $query);	

			return $result;
		}

		public function fetch_img_id($id){

			$query = "SELECT id,flag FROM images WHERE p_id = $id";
			$result = mysqli_query($this->con, $query);
			$noofrow = mysqli_num_rows($result);
			$img_id = array();
			if($noofrow>0){
				while ($image_id = mysqli_fetch_array($result)) {
					$img_id[] = $image_id['id'];
				}
			}
			return $img_id;

		}

		public function fetch_img_flag($id){

			$query = "SELECT flag FROM images WHERE p_id = $id";
			$result = mysqli_query($this->con, $query);
			$noofrow = mysqli_num_rows($result);
			$img_flag = array();
			if($noofrow>0){
				while ($image_id = mysqli_fetch_array($result)) {
					$img_flag[] = $image_id['flag'];
				}
			}
			return $img_flag;

		}

		public function fetchID_c($p_id){
			$query = "SELECT c_id FROM product_category WHERE p_id = $p_id";
			$result = mysqli_query($this->con, $query);	
            return $result;		
        }

        public function category_delete($c_id){

        	$query = "DELETE FROM product_category WHERE c_id = $c_id" ;
        	$result = mysqli_query($this->con, $query);	
            return $result;	
        }

		public function updateId($id_up,$id_set){
			$query = "UPDATE images
						SET p_id = $id_set WHERE id = $id_up";
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function RemoveImg($id){
			$query = " UPDATE images
						SET isdelete = curdate(),
						name = 'default.png' WHERE p_id = $id " ;
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function ChangeStatusP($id){

			$query = "UPDATE products 
						SET status = IF(status=1, 0, 1) WHERE id = $id ";

			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function DeleteProduct($id) {
			$query = "UPDATE products
					  	SET isdelete = curdate() WHERE id=$id";	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function ShowProduct($id){

			$query = "SELECT p_id FROM product_category WHERE c_id = $id";
			$pro_id = mysqli_query($this->con, $query);
			$noofrow = mysqli_num_rows($pro_id);
			$p_id = array();
			if($noofrow>0){
				while ($id_pro = mysqli_fetch_array($pro_id)) {
					$p_id[] = $id_pro['p_id'];
				}
			}
			foreach ($p_id as $i => $value) {
				$query1 = "SELECT name FROM products WHERE id = $value AND isdelete = '9999-12-31'";
				$pro_name = mysqli_query($this->con, $query1);
				$noofrow = mysqli_num_rows($pro_name);
				
				if($noofrow>0){
					while ($name_pro = mysqli_fetch_array($pro_name)) {
					
						$name_p .= $name_pro['name'];
						$name_p .= ',';
						
					}
				}
				
			}
			if (substr($name_p, -1, 1) == ',')
            {
                $name_p = substr($name_p, 0, -1);
            }
			
			return $name_p;
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

		public function ChangeDefault($id,$p_id){

			$query = "UPDATE images 
						SET flag = 'N' WHERE p_id = $p_id";
			$query1 = "UPDATE images
						SET flag = 'Y' WHERE id = $id ";
			$res = mysqli_query($this->con, $query);
			$res1 = mysqli_query($this->con, $query1);
			return $res1;
		}

		public function Delete($id){
/*
			$query = "UPDATE images
						SET isdelete = curdate() WHERE id = $id";*/
			$query = "DELETE FROM images WHERE id = $id";
			$res = mysqli_query($this->con, $query);
			return $res;	

		}
		
	}

?>