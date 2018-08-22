<?php 

//echo "Here";

class employeeModel{

	/*public function s(){
		echo " func here"; die;
	}*/

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


  	public function AddUser($arrayemployee) {
  			
		$query = "INSERT INTO Employee
				(username, firstname, lastname, address, contact_number, department, 
				date_of_joining, date_of_leaving, status, endeffdt) 
				VALUES
				('" . addslashes($arrayemployee['username']) . "',
				'" . addslashes($arrayemployee['firstname']) . "',
				'" . addslashes($arrayemployee['lastname']) . "',
				'" . addslashes($arrayemployee['address']) . "',
				'" . addslashes($arrayemployee['contact_number']) . "',
				'" . addslashes($arrayemployee['department']) . "',
				'" . addslashes($arrayemployee['date_of_joining']) . "',
				'" . addslashes($arrayemployee['date_of_leaving']) . "',
				'" . addslashes($arrayemployee['status']) . "',
				'" . addslashes($arrayemployee['endeffdt']) . "')";
		
		$result = mysqli_query($this->con, $query);		
		return $result;
	}

	public function listUser() {

		$query = "SELECT * FROM Employee";
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
					status = '" . addslashes($arrayemployee['status']) . "',
					endeffdt = '" . addslashes($arrayemployee['endeffdt']) . "' 
					WHERE recid='" . $arrayemployee['recid'] . "'";		

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function deleteUser($recid) {
		
		$query = "DELETE FROM Employee WHERE recid=$recid";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}
}

?>