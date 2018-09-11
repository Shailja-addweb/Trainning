<?php

	class categoryModel {

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

	  	public function CategoryList(){

	  		$query = "SELECT * FROM Category WHERE isDelete = 0 ";
			$result = mysqli_query($this->con, $query);
			return $result;

	  	}

	  	public function AddCategory($arrayrecords) {
  			
			$query = "INSERT INTO Category
					(name, status, image, isDelete) 
					VALUES
					('" . addslashes($arrayrecords['name']) . "',
					'1',
					'" . $arrayrecords["image"] . "',
					'0' )";
			
			$result = mysqli_query($this->con, $query);	
			
			return $result;
		}

		public function RemoveImg($id){
			$query = " UPDATE Category 
						SET image = 'default.png' WHERE id = $id " ;
			$result = mysqli_query($this->con, $query);
			return $result;
		}

		public function FetchCatgoryDetails($id) {

			$query = "SELECT * FROM Category WHERE id='$id' " ;		
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function EditCategory($arrayrecords) {
		
			$query = "UPDATE Category  
						SET name ='" . addslashes($arrayrecords['name']) . "' , 
						status = '" . addslashes($arrayrecords['status']) . "',
						image = '" . $arrayrecords["image"] . "'
						WHERE id='" . $arrayrecords['id'] . "'";	
			
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function DeleteCategory($id) {
			$query = "UPDATE Category
					  	SET isDelete = 1 WHERE id=$id";	
			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function ChangeStatusC($id){

			$query = "UPDATE Category 
						SET status = IF(status=1, 0, 1) WHERE id = $id ";

			$result = mysqli_query($this->con, $query);	
			return $result;
		}

		public function AddNameCategory(){

			$query = "SELECT name FROM Category WHERE isDelete = 0 " ;		
			$result = mysqli_query($this->con, $query);	
			return $result;

		}

	}

?>