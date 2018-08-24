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
                //$this->salname();
            } elseif ( $op == 'addsal' ) {
                $this->addSal();
            } elseif ( $op == 'editsal' ) {
                $this->editSal();
            } elseif ( $op == 'deletesal' ) {
                $this->deleteSal();
            } elseif ( $op == 'statusemp' ) {
                $this->changeEmp();
            } elseif ( $op == 'statusdep' ) {
                $this->changeDep();
            } elseif ( $op == 'allemp' ) {
                $this->allemp();
            } elseif ( $op == 'activeemp' ) {
                $this->activeemp();
            } elseif ( $op == 'inactiveemp' ) {
                $this->inactiveemp();
            } elseif ( $op == 'alldep' ) {
                $this->alldep();
            } elseif ( $op == 'activedep' ) {
                $this->activedep();
            } elseif ( $op == 'inactivedep' ) {
                $this->inactivedep();
            } elseif ( $op == 'show' ) {
                $this->show();
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
        $result1 = $this->employeeModel->salName();
        $noofrow = mysqli_num_rows($result);
        $row = mysqli_num_rows($result1);
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
            //$row = array();
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

    public function changeEmp() {
        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->fetchStatusE($recid);
            $row = mysqli_fetch_array($result);
            if($row['status'] == 'active'){
                $result = $this->employeeModel->ChangeEmpA($row);
                if(!empty($result)) {
                    header('location:index.php?op=list&update_flag=1');
                } else {
                    header('location:index.php?op=list&update_flag=0');
                }
            } else {
                $result = $this->employeeModel->ChangeEmpI($row);
                if(!empty($result)) {
                    header('location:index.php?op=list&update_flag=1');
                } else {
                    header('location:index.php?op=list&update_flag=0');
                }
            }
            
        }
        else {
            include('./view/employeelist.php');
        }
    }

    public function changeDep() {
        if(!empty($_GET['id'])) {
            $recid = $_GET['id'];
            $result = $this->employeeModel->fetchStatusD($recid);
            $row = mysqli_fetch_array($result);
            if($row['status'] == 'active'){
                $result = $this->employeeModel->ChangeDepA($row);
                if(!empty($result)) {
                    header('location:index.php?op=dep&update_flag=1');
                } else {
                    header('location:index.php?op=dep&update_flag=0');
                }
            } else {
                $result = $this->employeeModel->ChangeDepI($row);
                if(!empty($result)) {
                    header('location:index.php?op=dep&update_flag=1');
                } else {
                    header('location:index.php?op=dep&update_flag=0');
                }
            }
            
        }
        else {
            include('./view/department.php');
        }
    }

    public function allemp(){
        $result = $this->employeeModel->AllEmp();
        $noofrow = mysqli_num_rows($result);
        include('./view/employeelist.php');
    }

    public function activeemp(){
        $result = $this->employeeModel->ActiveEmp();
        $noofrow = mysqli_num_rows($result);
        include('./view/employeelist.php');
    }

    public function inactiveemp(){
        $result = $this->employeeModel->InactiveEmp();
        $noofrow = mysqli_num_rows($result);
        include('./view/employeelist.php');
    }

    public function alldep(){
        $result = $this->employeeModel->AllDep();
        $noofrow = mysqli_num_rows($result);
        include('./view/department.php');
    }

    public function activedep(){
        $result = $this->employeeModel->ActiveDep();
        $noofrow = mysqli_num_rows($result);
        include('./view/department.php');
    }

    public function inactivedep(){
        $result = $this->employeeModel->InactiveDep();
        $noofrow = mysqli_num_rows($result);
        include('./view/department.php');
    }

    public function show(){
        $id = $_POST['emp_name'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $result = $this->employeeModel->Show($id, $month, $year);
        $noofrow = $result->num_rows;
        /*echo "result: ";
        print_r($result);
        echo "nooofrow ";
        print_r($nooofrow);*/
        include('./view/salary.php');
    }

}


?>