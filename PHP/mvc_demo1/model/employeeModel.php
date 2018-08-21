<?php 

class employeeModel{
	echo "model";
	var $con;
	function __construct()
  	{
	     $this->con = mysqli_connect("mysql", "root", "root","php");
	     //mysqli_select_db("mvc_demo", $con);
  	}

  	public function addUser($arrayemployee) {
		
		$query = "INSERT INTO Employee(`recid`, `username`, `firstname`, `lastname`, `address`, `contact-number`, `department`, `date-of-joining`, `date-of-leaving`, `status`, `endeffdt`) 
				VALUES('" . addslashes($arrayemployee['username']) . "',
					'". addslashes($arrayemployee['firstname']) ."',
					'". addslashes($arrayemployee['lastname']) ."',
					'".addcslashes($arrayemployee['address'])"',
					'".addcslashes($arrayemployee['contact-number'])"',
					'".addcslashes($arrayemployee['department'])"',
					'".addcslashes($arrayemployee['date-of-joining'])"',
					'".addcslashes($arrayemployee['date-of-leaving'])"',
					'".addcslashes($arrayemployee['status'])"',
					'".addcslashes($arrayemployee['endeffdt'])"',)";
		
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
					SET username ='". addslashes($arrayemployee['username']) . "' , 
					firstname = '" . addslashes($arrayemployee['firstname']) . "', 
					lastname = '" . addslashes($arrayemployee['lastname']) . "',
					address = '" . addslashes($arrayemployee['address']) . "',
					contact-number = '" . addslashes($arrayemployee['contact-number']) . "',
					department = '" . addslashes($arrayemployee['department']) . "',
					date-of-joining = '" . addslashes($arrayemployee['date-of-joining']) . "',
					date-of-leaving = '" . addslashes($arrayemployee['date-of-leaving']) . "',
					status = '" . addslashes($arrayemployee['status']) . "',
					endeffdt = '" . addslashes($arrayemployee['endeffdt']) . "' 
					WHERE recid='" . $arrayUserinfo['recid'] . "'";		

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