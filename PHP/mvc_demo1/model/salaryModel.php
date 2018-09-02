<?php 
	
class salaryModel{

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

  	public function listSal() {

		$query = "SELECT * FROM Salary WHERE isDelete = 0";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function salName(){
		$query = "SELECT recid, employee_name FROM Salary";
		$result1 = mysqli_query($this->con, $query);
		return $result1;
	}

	public function AddSal($arrayemployee) {
  			
		$query = "INSERT INTO Salary
				(employee_name, month, year, amount, isDelete) 
				VALUES
				('" . addslashes($arrayemployee['employee_name']) . "',
				'" . addslashes($arrayemployee['month']) . "',
				'" . addslashes($arrayemployee['year']) . "',
				'" . addslashes($arrayemployee['amount']) . "',
				0 )";

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function FetchSalDetails($recid) {
	
		$query = "SELECT * FROM Salary WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function UpdateSal($arrayemployee) {
		
		$query = "UPDATE Salary 
					SET employee_name ='" . addslashes($arrayemployee['employee_name']) . "' , 
					month = '" . addslashes($arrayemployee['month']) . "', 
					year = '" . addslashes($arrayemployee['year']) . "',
					amount = '" . addslashes($arrayemployee['amount']) . "'
					WHERE recid='" . $arrayemployee['recid'] . "'";	

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function DeleteSal($id) {
		$query = "UPDATE Salary
				  SET isDelete = 1 WHERE recid=$id";	

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function Show($id, $month, $year){
		$query = "SELECT * FROM Salary WHERE recid='$id' OR month='$month' OR year='$year'";
		$result = mysqli_query($this->con, $query);
		return $result;
	}
}
?>