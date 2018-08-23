<?php 
//echo "5";
include('./model/employeeModel.php');

//echo '6';
class employeeController{
    	
	private $employeeModel = NULL;

	public function __construct() {

		$this->employeeModel = new employeeModel();
	
	}

	public function handleRequest() {

        //echo 'ygiud'; 
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
            } elseif ( $op == 'dep') {
                $this->ListDep();
            } elseif ( $op == 'adddep' ) {
                $this->addDep();
            } elseif ( $op == 'editdep' ) {
                $this->editDep();
            } elseif ( $op == 'deletedep' ) {
                $this->deleteDep();
            } elseif ( $op == 'sal'){
                $this->ListSal();
            } elseif ( $op == 'addsal' ) {
                $this->addSal();
            } elseif ( $op == 'editsal' ) {
                $this->editSal();
            } elseif ( $op == 'deletesal' ) {
                $this->deleteSal();
            } elseif ( $op == 'status' ) {
                $this->change();
            } else {
                $this->showError("Page not found", "Page for operation ".$op." was not found!");
            }
        } catch ( Exception $e ) {
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function addUser() {
        //echo "fun";
    	if(isset($_POST['submit']) && !empty($_POST['submit'])) 
    	{  
    		$arrayemployee = array();
    		$arrayemployee['username'] = $_POST['username'];
    		$arrayemployee['firstname'] = $_POST['firstname'];
    		$arrayemployee['lastname'] = $_POST['lastname'];
    		$arrayemployee['address'] = $_POST['address'];
    		$arrayemployee['contact_number'] = $_POST['contact_number'];
    		$arrayemployee['department'] = $_POST['department'];
    		$arrayemployee['date_of_joining'] = $_POST['date_of_joining'];
    		$arrayemployee['date_of_leaving'] = $_POST['date_of_leaving'];
    		//$arrayemployee['status'] = "active";
    		//$arrayemployee['endeffdt'] = "";
    		$result = $this->employeeModel->AddUser($arrayemployee);

            if($result) {
                header('location:index.php?op=list&add_flag=1');
            }
            else {
                header('location:index.php?op=list&add_flag=0');
            }
    	}
    	else {
            $row = array();
    		include('./view/add-employee.php');
    	}
    	
    }

    public function ListUser() {
    	$result = $this->employeeModel->listUser();
    	$noofrow = mysqli_num_rows($result);
    	include('./view/employeelist.php');
    }

    public function editUser() {
     	if(!empty($_GET['id'])) {
     		$recid = $_GET['id'];
     		$result = $this->employeeModel->FetchUserDetails($recid);
     		$row = mysqli_fetch_array($result);
     		if(isset($_POST['submit']) && !empty($_POST['submit'])) 
	    	{
	    		$arrayemployee = array();
	    		$arrayemployee['recid'] = $_POST['recid'];
	    		$arrayemployee['username'] = $_POST['username'];
                $arrayemployee['firstname'] = $_POST['firstname'];
	    		$arrayemployee['lastname'] = $_POST['lastname'];
	    		$arrayemployee['address'] = $_POST['address'];
                $arrayemployee['contact_number'] = $_POST['contact_number'];
                $arrayemployee['department'] = $_POST['department'];
                $arrayemployee['date_of_joining'] = $_POST['date_of_joining'];
                $arrayemployee['date_of_leaving'] = $_POST['date_of_leaving'];
                //$arrayemployee['status'] = $_POST['status'];
                //$arrayemployee['endeffdt'] = $_POST['endeffdt'];
	    		$result = $this->employeeModel->UpdateUser($arrayemployee);
                if(!empty($result)) {
                    header('location:index.php?op=list&update_flag=1');
                } else {
                    header('location:index.php?op=list&update_flag=0');
                }
	    	}
	    	else {
	    		include('./view/add-employee.php');
	    	}
     	} 
    }

    public function deleteUser() {
        
         //print_r($_GET['id']);

        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->DeleteUser($recid); 
            if(!empty($result)) {
                header('location:index.php?op=list&delete_flag=1');
            }  
            else {
                header('location:index.php?op=list&delete_flag=0');
            }       
        }
    }

    public function ListDep() {
        $result = $this->employeeModel->listDep();
        $noofrow = mysqli_num_rows($result);
        include('./view/department.php');
    }

    public function addDep() {
        //echo "fun";
        if(isset($_POST['submit']) && !empty($_POST['submit'])) 
        {  
            $arrayemployee = array();
            $arrayemployee['name'] = $_POST['name'];
            $arrayemployee['status'] = $_POST['status'];
            $arrayemployee['endeffdt'] = $_POST['endeffdt'];
            $result = $this->employeeModel->AddDep($arrayemployee);

            if($result) {
                header('location:index.php?op=dep&add_flag=1');
            }
            else {
                header('location:index.php?op=dep&add_flag=0');
            }
        }
        else {
            $row = array();
            include('./view/add-department.php');
        }
        
    }

    public function editDep() {
        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->FetchDepDetails($recid);
            $row = mysqli_fetch_array($result);
            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {
                $arrayemployee = array();
                $arrayemployee['recid'] = $_POST['recid'];
                $arrayemployee['name'] = $_POST['name'];
                $arrayemployee['status'] = $_POST['status'];
                $arrayemployee['endeffdt'] = $_POST['endeffdt'];
                $result = $this->employeeModel->UpdateDep($arrayemployee);
                if(!empty($result)) {
                    header('location:index.php?op=dep&update_flag=1');
                } else {
                    header('location:index.php?op=dep&update_flag=0');
                }
            }
            else {
                include('./view/add-department.php');
            }
        } 
    }

    public function deleteDep() {
        
         //print_r($_GET['id']);

        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->DeleteDep($recid); 
            if(!empty($result)) {
                header('location:index.php?op=dep&delete_flag=1');
            }  
            else {
                header('location:index.php?op=dep&delete_flag=0');
            }       
        }
    }

    public function ListSal() {
        $result = $this->employeeModel->listSal();
        $noofrow = mysqli_num_rows($result);
        include('./view/salary.php');
    }

    public function addSal() {
        //echo "fun";
        if(isset($_POST['submit']) && !empty($_POST['submit'])) 
        {  
            $arrayemployee = array();
            $arrayemployee['employee_name'] = $_POST['employee_name'];
            $arrayemployee['month'] = $_POST['month'];
            $arrayemployee['year'] = $_POST['year'];
            $arrayemployee['amount'] = $_POST['amount'];
            $result = $this->employeeModel->AddSal($arrayemployee);
            if($result) {
                header('location:index.php?op=sal&add_flag=1');
            }
            else {
                header('location:index.php?op=sal&add_flag=0');
            }
        }
        else {
            $row = array();
            include('./view/add-salary.php');
        }
        
    }

    public function editSal() {
        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->FetchSalDetails($recid);
            $row = mysqli_fetch_array($result);
            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {
                $arrayemployee = array();
                $arrayemployee['recid'] = $_POST['recid'];
                $arrayemployee['employee_name'] = $_POST['employee_name'];
                $arrayemployee['month'] = $_POST['month'];
                $arrayemployee['year'] = $_POST['year'];
                $arrayemployee['amount'] = $_POST['amount'];
                $result = $this->employeeModel->UpdateSal($arrayemployee);
                if(!empty($result)) {
                    header('location:index.php?op=sal&update_flag=1');
                } else {
                    header('location:index.php?op=sal&update_flag=0');
                }
            }
            else {
                include('./view/add-salary.php');
            }
        } 
    }

    public function deleteSal() {
        
         //print_r($_GET['id']);

        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->DeleteSal($recid); 
            if(!empty($result)) {
                header('location:index.php?op=sal&delete_flag=1');
            }  
            else {
                header('location:index.php?op=sal&delete_flag=0');
            }       
        }
    }

    public function change() {
        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            if($_GET['status'] == 'active'){
                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    $arrayemployee = array();
                        
                    $arrayemployee['status'] = $_POST['status'];
                    $arrayemployee['endeffdt'] = $_POST['endeffdt'];
                    $result = $this->employeeModel->ChangeA($arrayemployee);
                    if(!empty($result)) {
                        header('location:index.php?op=list&update_flag=1');
                    } else {
                        header('location:index.php?op=list&update_flag=0');
                    }
                }
                else {
                    include('./view/add-employee.php');
                }
            }
            else{
                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    $arrayemployee = array();
                    $arrayemployee['recid'] = $_POST['recid'];
                    $arrayemployee['username'] = $_POST['username'];
                    $arrayemployee['firstname'] = $_POST['firstname'];
                    $arrayemployee['lastname'] = $_POST['lastname'];
                    $arrayemployee['address'] = $_POST['address'];
                    $arrayemployee['contact_number'] = $_POST['contact_number'];
                    $arrayemployee['department'] = $_POST['department'];
                    $arrayemployee['date_of_joining'] = $_POST['date_of_joining'];
                    $arrayemployee['date_of_leaving'] = $_POST['date_of_leaving'];
                    $arrayemployee['status'] = $_POST['status'];
                    $arrayemployee['endeffdt'] = $_POST['endeffdt'];
                    $result = $this->employeeModel->ChangeI($arrayemployee);
                    if(!empty($result)) {
                        header('location:index.php?op=list&update_flag=1');
                    } else {
                        header('location:index.php?op=list&update_flag=0');
                    }
                }
                else {
                    include('./view/add-employee.php');
                }
            }
            
        } 
    }

    /*if(isset($_POST['radio']) && !empty($_POST['radio'])) {
        $btn = $_GET['name'];
        if($btn == 'all'){
            $result = $this->employeeModel->listUser();
            $noofrow = mysqli_num_rows($result);
            include('./view/employeelist.php');
        }
        elseif($btn == 'active'){
            $status = $_GET['name']
            $result = $this->employeeModel->active($status);
            $noofrow = mysqli_num_rows($result);
            include('./view/employeelist.php');
        }
        elseif ($btn == 'inactive')) {
            $status = $_GET['name'];
            $result = $this->employeeModel->inactive($status);
            $noofrow = mysqli_num_rows($result);
            include('./view/employeelist.php');
        }
        
    }*/

}


?>