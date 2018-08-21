<?php 
echo 'in'; die;

include_once('model/employeeModel.php');

class employeeController{
    echo "controller";
	
	private $employeeModel = NULL;

	public function __construct() {

		$this->employeeModel = new employeeModel();
	
	}

	public function handleRequest() {

        $op = isset($_GET['op'])?$_GET['op']:NULL;
        try {
            if ( !$op || $op == 'list' ) {
                $this->ListUser();
            } elseif ( $op == 'add' ) {
                $this->addUser();
            } elseif ( $op == 'delete' ) {
                $this->deleteUser();
            } elseif ( $op == 'edit' ) {
                $this->editUser();
            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function addUser() {
    	if(isset($_POST['submit']) && !empty($_POST['submit'])) 
    	{
    		$arrayemployee = array();
    		$arrayemployee['username'] = $_POST['username'];
    		$arrayemployee['firstname'] = $_POST['firstname'];
    		$arrayemployee['lastname'] = $_POST['lastname'];
    		$arrayemployee['address'] = $_POST['address'];
    		$arrayemployee['contact-number'] = $_POST['contact -number'];
    		$arrayemployee['department'] = $_POST['department'];
    		$arrayemployee['date-of-joining'] = $_POST['date-of-joining'];
    		$arrayemployee['date-of-leaving'] = $_POST['date-of-leaving'];
    		$arrayemployee['status'] = $_POST['status'];
    		$arrayemployee['endeffdt'] = $_POST['endeffdt'];
    		$result = $this->employeeModel->addUser($arrayemployee);
            if($result) {
                header('location:index.php?op=list&add_flag=1');
            }
            else {
                header('location:index.php?op=list&add_flag=0');
            }
    	}
    	else {
            $row = array();
    		include('view/add-employee.php');
    	}
    	
    }

    public function ListUser() {
       
    	$result = $this->employeeModel->listUser();
    	$noofrow = mysqli_num_rows($result);
    	include('view/employeelist.php');
    }

    public function editUser() {
     	if(!empty($_GET['recid'])) {
     		$recid = $_GET['recid'];
     		$result = $this->UserinfoModel->FetchUserDetails($recid);
     		$row = mysqli_fetch_array($result);
     		if(isset($_POST['submit']) && !empty($_POST['submit'])) 
	    	{
	    		$arrayemployee = array();
	    		$arrayemployee['recid'] = $_POST['recid'];
	    		$arrayemployee['username'] = $_POST['username'];
                $arrayemployee['firstname'] = $_POST['firstname'];
	    		$arrayemployee['lastname'] = $_POST['lastname'];
	    		$arrayemployee['address'] = $_POST['address'];
                $arrayemployee['contact-number'] = $_POST['contact-number'];
                $arrayemployee['department'] = $_POST['department'];
                $arrayemployee['date-of-joining'] = $_POST['date-of-joining'];
                $arrayemployee['date-of-leaving'] = $_POST['date-of-leaving'];
                $arrayemployee['status'] = $_POST['status'];
                $arrayemployee['endeffdt'] = $_POST['endeffdt'];
	    		$result = $this->employeeModel->UpdateUser($arrayemployee);
                if(!empty($result)) {
                    header('location:index.php?op=list&update_flag=1');
                } else {
                    header('location:index.php?op=list&update_flag=0');
                }
	    	}
	    	else {
	    		include('view/add-employee.php');
	    	}
     	}
    }

    public function deleteUser() {
        if(!empty($_GET['recid'])) {
            $recid = $_GET['recid'];
            $result = $this->employeeModel->deleteUser($recid); 
            if(!empty($result)) {
                header('location:index.php?op=list&delete_flag=1');
            }  
            else {
                header('location:index.php?op=list&delete_flag=0');
            }       
        }
    }

}


?>