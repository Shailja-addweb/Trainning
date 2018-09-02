<?php 
	
    include('./model/departmentModel.php');

    class departmentController{
        	
    	private $departmentModel = NULL;

    	public function __construct() {

    		$this->departmentModel = new departmentModel();
    	
    	}

    	public function handleRequest() {

            $op = isset($_GET['op'])?$_GET['op']:NULL;

            try {
            	if ( $op == 'deplist') {
                    $this->listDep();
                }
                elseif ( $op == 'adddep' ) {
                    $this->addDep();
                } 
                elseif ( $op == 'editdep' ) {
                    $this->editDep();
                } 
                elseif ( $op == 'deletedep' ) {
                    $id = $_GET['id']; 
                    $this->deleteDep($id);
                }
                elseif ( $op == 'alldep' ) {
                    $this->alldep();
                } 
                elseif ( $op == 'activedep' ) {
                    $this->activedep();
                } 
                elseif ( $op == 'inactivedep' ) {
                    $this->inactivedep();
                }
                elseif ( $op == 'changeD') {
                    $id = $_GET['id']; 
                    $this->changeD($id);
                }
                else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!"); 
                }
            } catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }
        }

        public function listDep() {
            $result = $this->departmentModel->ListDep();
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataD($noofrow, $result); 
                include('./view/department.php');
            }    
        }

        public function TblDataD($noofrow, $result) {
            $data = " <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th colspan=\"2\">ACTION</th>
                    </tr> ";
            //print_r($noofrow);  
            if($noofrow>0) {
                while($resultdata = mysqli_fetch_array($result)) {
                     
                    $data .= " <tr> " ;
                            
                        $data .= " <td> " . $resultdata['recid'] . " </td> " ;
                        $data .= " <td> " . $resultdata['name'] . " </td> " ;
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['recid'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['recid'] . " > " . $resultdata['status'] . " </a></td> " ;
    
                        $data .= " <td> <a href=\"index.php?op=editdep&id= " . $resultdata['recid'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= \"" . $resultdata['recid'] . "\" >Delete </a> </td> " ; 

                    $data .= " </tr>" ;
                } 
                return $data; 
            }
            else {
                $data .= "<tr><td colspan=\"5\">No Record</td></tr>" ;

                return $data;
            }

        }

        public function addDep() {
            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {  
                $arrayemployee = array();
                $arrayemployee['name'] = $_POST['name'];
                //$arrayemployee['status'] = $_POST['status'];
                //$arrayemployee['endeffdt'] = $_POST['endeffdt'];
                //$arrayemployee['isDelete'] = $_POST['isDelete'];
                $result = $this->departmentModel->AddDep($arrayemployee);

                if($result) {
                    header('location:index.php?op=dep&add_flag=1');
                    $data = $this->TblDataD($noofrow, $result); 
                    include('./view/department.php');
                }
                else {
                    header('location:index.php?op=dep&add_flag=0');
                    $data = $this->TblDataD($noofrow, $result); 
                    include('./view/department.php');
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
                $result = $this->departmentModel->FetchDepDetails($recid);
                $row = mysqli_fetch_array($result);
                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    $arrayemployee = array();
                    $arrayemployee['recid'] = $_POST['recid'];
                    $arrayemployee['name'] = $_POST['name'];
                    $arrayemployee['status'] = $row['status'];
                    $arrayemployee['endeffdt'] = $row['endeffdt'];
                    $result = $this->departmentModel->UpdateDep($arrayemployee);
                    if(!empty($result)) {
                        header('location:index.php?op=deplist&update_flag=1');
                    } else {
                        header('location:index.php?op=deplist&update_flag=0');
                    }
                }
                else {
                    include('./view/add-department.php');
                }
            } 
        }

        public function deleteDep($id) {

            if(!empty($_GET['id'])) {
                //$recid = $_GET['id'];
                $result = $this->departmentModel->DeleteDep($id); 
                $noofrow = mysqli_num_rows($result); 
                if(!empty($result)) {
                    //echo $this->tblDept($result);
                    header('location:index.php?op=deplist&delete_flag=1');
                    $data = $this->TblDataD($noofrow, $result); 
                    include('./view/department.php');
                }  
                else {
                    header('location:index.php?op=deplist&delete_flag=0');
                }       
            }
        }

        public function changeD($id){
            $result = $this->departmentModel->changeStatusD($id);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                header('location:index.php?op=deplist&delete_flag=1');
                $data = $this->TblDataD($noofrow, $result); 
                include('./view/department.php');
            }  
        }

        public function alldep(){
            $result = $this->departmentModel->AllDep();
            $noofrow = mysqli_num_rows($result);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataD($noofrow, $result); 
                include('./view/department.php');
            }  
        }

        public function activedep(){
            $result = $this->departmentModel->ActiveDep();
            $noofrow = mysqli_num_rows($result);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataD($noofrow, $result); 
                include('./view/department.php');
            }  
        }

        public function inactivedep(){
            $result = $this->departmentModel->InactiveDep();
            $noofrow = mysqli_num_rows($result);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblDataD($noofrow, $result); 
                include('./view/department.php');
            }  
        }
	}				
?>