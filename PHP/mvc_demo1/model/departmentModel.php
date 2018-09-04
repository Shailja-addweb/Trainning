<?php
	
	class departmentModel{

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

  	public function ListDep() {

		$query = "SELECT * FROM Department WHERE isDelete = 0 ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function AddDep($arrayemployee) {
  			
		$query = "INSERT INTO Department
				(name, status, endeffdt, isDelete) 
				VALUES
				('" . addslashes($arrayemployee['name']) . "',
				'1',
				'2020-01-01',
				'0')";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function FetchDepDetails($recid) {

		
		$query = "SELECT * FROM Department WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function UpdateDep($arrayemployee) {
		
		$query = "UPDATE Department 
					SET name ='" . addslashes($arrayemployee['name']) . "' , 
					status = '" . addslashes($arrayemployee['status']) . "',
					endeffdt = '" . addslashes($arrayemployee['endeffdt']) . "' 
					WHERE recid='" . $arrayemployee['recid'] . "'";		

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function DeleteDep($id) {
		$query = "UPDATE Department
				  SET endeffdt = NOW(), isDelete = 1 WHERE recid=$id";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function fetchStatusD($recid){
		$query = "SELECT recid,status FROM Department WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function changeStatusD($id){

		$query = "UPDATE Department 
					SET status = IF(status=1, 0, 1) WHERE recid = $id ";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function AllDep(){
		$query = "SELECT * FROM Department WHERE isDelete = 0";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function ActiveDep(){
		$query = "SELECT *  FROM Department WHERE status = 1 AND isDelete = 0";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function InactiveDep(){
		$query = "SELECT *  FROM Department WHERE status = 0 AND isDelete = 0";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}	

	public function SortName(){
		$query = "SELECT * FROM Department WHERE isDelete = 0 ORDER BY name ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

}

 ?>