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
				'active',
				'2020-01-01')";
		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function listUser() {

		$query = "SELECT * FROM Employee WHERE isDelete = 0 ORDER BY department, date_of_joining ";
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

	public function DeleteUser($recid) {
		$query = "UPDATE Employee
				  SET endeffdt = NOW(), isDelete = 1 WHERE recid=$recid";	
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function listDep() {

		$query = "SELECT * FROM Department WHERE isDelete = 0 ORDER BY name ";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function AddDep($arrayemployee) {
  			
		$query = "INSERT INTO Department
				(name, status, endeffdt) 
				VALUES
				('" . addslashes($arrayemployee['name']) . "',
				'active',
				'2020-01-01')";
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

	public function DeleteDep($recid) {
		$query = "UPDATE Department
				  SET endeffdt = NOW(), isDelete = 1 WHERE recid=$recid";	
		$result = mysqli_query($this->con, $query);	
		return $result;
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
				(employee_name, month, year, amount) 
				VALUES
				('" . addslashes($arrayemployee['employee_name']) . "',
				'" . addslashes($arrayemployee['month']) . "',
				'" . addslashes($arrayemployee['year']) . "',
				'" . addslashes($arrayemployee['amount']) . "')";
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
					amount = '" . addslashes($arrayemployee['amount']) . "',
					WHERE recid='" . $arrayemployee['recid'] . "'";		

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function DeleteSal($recid) {
		$query = "UPDATE Salary
				  SET isDelete = 1 WHERE recid=$recid";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function fetchStatusE($recid){
		$query = "SELECT recid,status FROM Employee WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function fetchStatusD($recid){
		$query = "SELECT recid,status FROM Department WHERE recid='$recid'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function ChangeEmpA($row){
		$query = "UPDATE Employee 
					SET status = 'inactive' 
					WHERE recid='" . $row['recid'] . "'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function ChangeEmpI($row){
		$query = "UPDATE Employee 
					SET status = 'active' 
					WHERE recid='" . $row['recid'] . "'";		

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function ChangeDepA($row){
		$query = "UPDATE Department 
					SET status = 'inactive' 
					WHERE recid='" . $row['recid'] . "'";		
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function ChangeDepI($row){
		$query = "UPDATE Department 
					SET status = 'active' 
					WHERE recid='" . $row['recid'] . "'";		

		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function AllEmp(){
		$query = "SELECT * FROM Employee";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function ActiveEmp(){
		$query = "SELECT *  FROM Employee WHERE status='active'";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function InactiveEmp(){
		$query = "SELECT *  FROM Employee WHERE status='inactive'";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function AllDep(){
		$query = "SELECT * FROM Department";
		$result = mysqli_query($this->con, $query);
		return $result;
	}

	public function ActiveDep(){
		$query = "SELECT *  FROM Department WHERE status='active'";
		$result = mysqli_query($this->con, $query);	
		return $result;
	}

	public function InactiveDep(){
		$query = "SELECT *  FROM Department WHERE status='inactive'";
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