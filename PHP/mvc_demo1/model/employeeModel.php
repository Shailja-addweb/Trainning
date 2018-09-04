<?php 
	
class employeeModel{

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


  	public function AddEmployee($arrayemployee) {
  			
		$query = "INSERT INTO Employee
				(username, firstname, lastname, address, contact_number, department, 
				date_of_joining, date_of_leaving, image, status, endeffdt, isDelete) 
				VALUES
				('" . addslashes($arrayemployee['username']) . "',
				'" . addslashes($arrayemployee['firstname']) . "',
				'" . addslashes($arrayemployee['lastname']) . "',
				'" . addslashes($arrayemployee['address']) . "',
				'" . addslashes($arrayemployee['contact_number']) . "',
				'" . addslashes($arrayemployee['department']) . "',
				'" . addslashes($arrayemployee['date_of_joining']) . "',
				'" . addslashes($arrayemployee['date_of_leaving']) . "',
				'" . $arrayemployee["image"] . "',
				'1',
				'2020-01-01',
				0 )";
		
		$result = mysqli_query($this->con, $query);	
		
		return $result;
	}

	public function listUser() {

		$query = "SELECT * FROM Employee WHERE isDelete = 0 ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function FetchUserDetails($recid) {

		
		$query = "SELECT * FROM Employee WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function UpdateUser($arrayemployee) {
		
		$query = "UPDATE Employee 
					SET username ='" . addslashes($arrayemployee['username']) . "' , 
					firstname = '" . addslashes($arrayemployee['firstname']) . "', 
					lastname = '" . addslashes($arrayemployee['lastname']) . "',
					address = '" . addslashes($arrayemployee['address']) . "',
					contact_number = '" . addslashes($arrayemployee['contact_number']) . "',
					department = '" . addslashes($arrayemployee['department']) . "',
					date_of_joining = '" . addslashes($arrayemployee['date_of_joining']) . "',
					date_of_leaving = '" . addslashes($arrayemployee['date_of_leaving']) . "',
					image = '" . $arrayemployee["image"] . "',
					status = '" . addslashes($arrayemployee['status']) . "',
					endeffdt = '" . addslashes($arrayemployee['endeffdt']) . "' 
					WHERE recid='" . $arrayemployee['recid'] . "'";	

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function DeleteUser($id) {
		$query = "UPDATE Employee
				  SET endeffdt = NOW(), isDelete = 1 WHERE recid=$id";	
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	
	
	public function fetchStatusE($recid){
		$query = "SELECT recid,status FROM Employee WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function changeStatusE($id){

		$query = "UPDATE Employee 
					SET status = IF(status=1, 0, 1) WHERE recid = $id ";

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function AllEmp(){
		$query = "SELECT * FROM Employee WHERE isDelete = 0";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function ActiveEmp(){
		$query = "SELECT *  FROM Employee WHERE status = 1 AND isDelete = 0 ";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function InactiveEmp(){
		$query = "SELECT *  FROM Employee WHERE status = 0  AND isDelete = 0 ";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}
	
	public function SortDep(){
		$query = "SELECT * FROM Employee WHERE isDelete = 0 ORDER BY department ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function SortDJ(){
		$query = "SELECT * FROM Employee WHERE isDelete = 0 ORDER BY date_of_joining";
		$result = mysqli_query($this->con, $query);
		return $result;
	}
}

?>