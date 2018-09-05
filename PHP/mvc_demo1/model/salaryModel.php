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

		$query = "SELECT * FROM salary WHERE isDelete = 0";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function salName(){
		
		$query = "SELECT recid_sal, recid, employee_name FROM salary WHERE isDelete = 0 ";
		$result1 = mysqli_query($this->con, $query);
		return $result1;
	}

	public function AddSal($arrayemployee) {
  			
		$query = "INSERT INTO salary
				(recid, employee_name, month, year, amount, isDelete) 
				VALUES
				('" . addslashes($arrayemployee['recid']) . "',
				'" . addslashes($arrayemployee['employee_name']) . "',
				'" . addslashes($arrayemployee['month']) . "',
				'" . addslashes($arrayemployee['year']) . "',
				'" . addslashes($arrayemployee['amount']) . "',
				0 )";

		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function FetchSalDetails($recid_sal) {
	
		$query = "SELECT * FROM salary WHERE recid_sal='$recid_sal'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function UpdateSal($arrayemployee) {
		
		$query = "UPDATE salary 
					SET employee_name ='" . addslashes($arrayemployee['employee_name']) . "' , 
					month = '" . addslashes($arrayemployee['month']) . "', 
					year = '" . addslashes($arrayemployee['year']) . "',
					amount = '" . addslashes($arrayemployee['amount']) . "'
					WHERE recid_sal='" . $arrayemployee['recid_sal'] . "'";	

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function DeleteSal($recid_sal) {
		$query = "UPDATE salary
				  SET isDelete = 1 WHERE recid_sal=$recid_sal";	

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function Show($recid_sal, $month, $year){
		$query = "SELECT * FROM salary 
					WHERE recid_sal='$recid_sal' OR month='$month' OR year='$year' AND isDelete = 0 ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}
}
?>