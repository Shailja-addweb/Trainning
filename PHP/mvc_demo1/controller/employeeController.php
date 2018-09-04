    <?php 

    include('./model/employeeModel.php');
   
    class employeeController{
        	
    	private $employeeModel = NULL;

    	public function __construct() {

    		$this->employeeModel = new employeeModel();
    	
    	}

    	public function handleRequest() {

            $op = isset($_GET['op'])?$_GET['op']:NULL;
            //print_r($op);

            try {
                if ( !$op || $op == 'emplist' ) {
                    $this->ListEmployee();
                } 
                elseif ( $op == 'addemp' ) {
                    $this->addEmployee();
                }
                elseif ( $op == 'delete' ) {
                    $id = $_GET['id']; 
                    $this->deleteEmployee($id);
                } 
                elseif ( $op == 'edit' ) {
                    $this->editEmployee();
                }
                elseif ( $op == 'allemp' ) {
                    $this->allemp();
                } 
                elseif ( $op == 'activeemp' ) {
                    $this->activeemp();
                } 
                elseif ( $op == 'inactiveemp' ) {
                    $this->inactiveemp();
                } 
                elseif ( $op == 'sortdep_asc' ) {
                    $this->sortDepA();
                }
                elseif ( $op == 'sortdep_desc' ) {
                    $this->sortDepD();
                }
                elseif ( $op == 'sortdj_asc' ) {
                    $this->sortDJA();
                }
                elseif ( $op == 'sortdj_desc' ) {
                    $this->sortDJD();
                }
                elseif ( $op == 'changeE') {
                    $id = $_GET['id']; 
                    $this->changeE($id);
                }
                else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }   
            } 
            catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }
        }

        public function addEmployee() {
           
        	if(isset($_POST['submit']) && !empty($_POST['submit'])) 
        	{  
                $target_dir = "./images/";
                $target_file = basename($_FILES["image"]["name"]);
                $file_tmp = $_FILES["image"]["tmp_name"];

                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file)){
                    echo "The file " . basename( $_FILES["image"]["name"]) . " has been uploaded."; 
                } 
                 else {
                    echo "Sorry, there was an error uploading your file.";
                }
            
        		$arrayemployee = array();
        		$arrayemployee['username'] = $_POST['username'];
        		$arrayemployee['firstname'] = $_POST['firstname'];
        		$arrayemployee['lastname'] = $_POST['lastname'];
        		$arrayemployee['address'] = $_POST['address'];
        		$arrayemployee['contact_number'] = $_POST['contact_number'];
        		$arrayemployee['department'] = $_POST['department'];
        		$arrayemployee['date_of_joining'] = $_POST['date_of_joining'];
        		$arrayemployee['date_of_leaving'] = $_POST['date_of_leaving'];
                $arrayemployee['image'] = $target_file;
        		$arrayemployee['status'] = "1";
        		$arrayemployee['endeffdt'] = "";
        		$result = $this->employeeModel->AddEmployee($arrayemployee);


                if($result) {
                    header('location:index.php?op=emplist&add_flag=1');
                    $data = $this->TblDataE($noofrow, $result); 
                    include('./view/employeelist.php');
                }
                else {
                    header('location:index.php?op=emplist&add_flag=0');
                    $data = $this->TblDataE($noofrow, $result); 
                    include('./view/employeelist.php');
                }
               print_r("here");exit();

                   
        	}
        	else {
                $row = array();
        		include('./view/add-employee.php');
        	}	
        }

        public function ListEmployee() {
        	$result = $this->employeeModel->listUser();
        	$noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function TblDataE($noofrow, $result) {
            $data = " <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th id=\"dep\">Department</th>
                        <th id=\"dj\">Date of Joining</th>
                        <th>Date of leaving</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th colspan=\"2\">ACTION</th>
                      </tr> ";

            if($noofrow>0) {
                while($resultdata = mysqli_fetch_array($result)) {
                     
                    $data .= " <tr> " ;
                            
                        $data .= " <td> " . $resultdata['recid'] . " </td> " ;
                        $data .= " <td> " . $resultdata['username'] . " </td> " ;
                        $data .= " <td> " . $resultdata['firstname'] . " </td> " ;
                        $data .= " <td> " . $resultdata['lastname'] . " </td> " ;
                        $data .= " <td> " . $resultdata['address'] . " </td> " ;
                        $data .= " <td> " . $resultdata['contact_number'] . " </td> " ;
                        $data .= " <td> " . $resultdata['department'] . " </td> " ;
                        $data .= " <td> " . $resultdata['date_of_joining'] . " </td> " ;
                        $data .= " <td> " . $resultdata['date_of_leaving'] . " </td> " ;
                        if(!empty($resultdata['image'])){
                            $data .= " <td> <img src=\"images/" . ($resultdata['image']) . "\" width=\"50\" height=\"50\"> </td> " ;
                        }
                        else {
                            $data .= " <td> <img src=\"images/default.png\" width=\"50\" height=\"50\"> </td> " ;    
                        }
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['recid'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['recid'] . " > " . $resultdata['status'] . " </a></td> " ;
                       // $data .= " <td> " $resultdata['endeffdt'] . " </td> " ;
                        $data .= " <td> <a href=\"index.php?op=edit&id= " . $resultdata['recid'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= " . $resultdata['recid'] . " >Delete </a> </td> " ; 

                    $data .= " </tr>" ;
    
                } 
                return $data; 
            }
            else {
                $data .= "<tr><td colspan=\"5\">No Record</td></tr>" ;

                return $data;
            }

        }

        public function editEmployee() {
         	if(!empty($_GET['id'])) {
         		$recid = $_GET['id'];
         		$result = $this->employeeModel->FetchUserDetails($recid);
         		$row = mysqli_fetch_array($result);
                //print_r($row["image"]);exit();
         		if(isset($_POST['submit']) && !empty($_POST['submit'])) 
    	    	{
                    $target_dir = "./images/";
                    $target_file = basename($_FILES["image"]["name"]);
                    $file_tmp = $_FILES["image"]["tmp_name"];

                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$target_file)){
                        echo "The file " . basename( $_FILES["image"]["name"]) . " has been uploaded."; 
                    } 
                    else {
                        echo "Sorry, there was an error uploading your file.";
                    }
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
                    $arrayemployee['image'] = $target_file;
                    $arrayemployee['status'] = $row['status'];
                    $arrayemployee['endeffdt'] = $row['endeffdt'];
    	    		$result = $this->employeeModel->UpdateUser($arrayemployee);
                    if(!empty($result)) {
                        header('location:index.php?op=emplist&update_flag=1');
                    } else {
                        header('location:index.php?op=emplist&update_flag=0');
                    }
    	    	}
    	    	else {
    	    		include('./view/add-employee.php');
    	    	}
         	} 
        }

        public function deleteEmployee($id) {
           
            if(!empty($_GET['id'])) {
                $result = $this->employeeModel->DeleteUser($id); 
                if(!empty($result)) {
                    header('location:index.php?op=emplist&delete_flag=1');
                    $data = $this->TblDataE($noofrow, $result); 
                    include('./view/employeelist.php');
                }  
                else {
                    header('location:index.php?op=emplist&delete_flag=0');
                }       
            }
        }

        public function changeE($id){
            $result = $this->employeeModel->changeStatusE($id);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                header('location:index.php?op=emplist&update_flag=1');
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function allemp(){
            $result = $this->employeeModel->AllEmp();
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function activeemp(){
            $result = $this->employeeModel->ActiveEmp();
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function inactiveemp(){
            $result = $this->employeeModel->InactiveEmp();
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function sortDepA(){
            $result = $this->employeeModel->SortDepA();
            $noofrow = mysqli_num_rows($result);

            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function sortDepD(){
            $result = $this->employeeModel->SortDepD();
            $noofrow = mysqli_num_rows($result);

            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function sortDJA(){
            $result = $this->employeeModel->SortDJA();
            $noofrow = mysqli_num_rows($result);

            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }

        public function sortDJD(){
            $result = $this->employeeModel->SortDJD();
            $noofrow = mysqli_num_rows($result);

            if(!empty($result)){
                $data = $this->TblDataE($noofrow, $result); 
                include('./view/employeelist.php');
            }
        }
    }
?>