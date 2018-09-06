<?php 

	include('./model/salaryModel.php');
    include('./model/employeeModel.php');
   
    class salaryController{
        	
    	private $salaryModel = NULL;
        public $employeeModel = NULL;


    	public function __construct() {

    		$this->salaryModel = new salaryModel();
             $this->employeeModel = new employeeModel();
    	
    	}


    	public function handleRequest() {

            $op = isset($_GET['op'])?$_GET['op']:NULL;
           // print_r($op);exit();

            try {
            	if ( $op == 'sallist'){
                    $this->ListSal();
                } 
                elseif ( $op == 'addsal' ) {
                    $this->addSal();
                } 
                elseif ( $op == 'editsal' ) {
                    $this->editSal();
                } 
                elseif ( $op == 'deletesal' ) {
                    $this->deleteSal();
                } 
                elseif ( $op == 'show' ) {
                    $this->show();
                }
                else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }
            } catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }
        }


		public function ListSal() {

            $result = $this->salaryModel->listSal();
            $result1 = $this->salaryModel->salName();
            $noofrow = mysqli_num_rows($result);
            $row = mysqli_num_rows($result1);
            if(!empty($result)){
                $data = $this->TblDataS($noofrow, $result); 
                include('./view/salary.php');
            }
            
        }

        public function TblDataS($noofrow, $result) {
            $data = " <tr>
                        <th>Id</th>
                        <th>Employee Name</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Amount</th>
                        <th colspan=\"2\">ACTION</th>
                    </tr> ";

            if($noofrow>0) {
                while($resultdata = mysqli_fetch_array($result)) {
                     
                    $data .= " <tr> " ;
                            
                        $data .= " <td> " . $resultdata['recid_sal'] . " </td> " ;
                        //$data .= " <td> " . $resultdata['recid'] . " </td> " ;
                        $data .= " <td> " . $resultdata['employee_name'] . " </td> " ;
                        $data .= " <td> " . $resultdata['month'] . " </td> " ;
                        $data .= " <td> " . $resultdata['year'] . " </td> " ;
                        $data .= " <td> " . $resultdata['amount'] . " </td> " ;
                        $data .= " <td> <a href=\"index.php?op=editsal&id= " . $resultdata['recid_sal'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= " . $resultdata['recid_sal'] . " >Delete </a> </td> " ; 

                    $data .= " </tr>" ;
                } 
                return $data; 
            }
            else {
                $data .= "<tr><td colspan=\"5\">No Record</td></tr>" ;

                return $data;
            }
            //return $data;

        }

        public function addSal() {

            $result1 = $this->employeeModel->saladdName();
            $row = mysqli_num_rows($result1);
            
            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {  
                $id = $_POST['name'];
                $res = $this->employeeModel->fetchname($id);
                $row = mysqli_num_rows($res);
                $name = mysqli_fetch_array($res);
                $emp_name = $name['firstname'];

                $arrayemployee = array();
                $arrayemployee['recid'] = $_POST['name'];
                $arrayemployee['employee_name'] = $emp_name;
                $arrayemployee['month'] = $_POST['month'];
                $arrayemployee['year'] = $_POST['year'];
                $arrayemployee['amount'] = $_POST['amount'];
                $result = $this->salaryModel->AddSal($arrayemployee);
                if($result) {
                    header('location:index.php?op=sallist&add_flag=1');
                    $data = $this->TblDataS($noofrow, $result); 
                    include('./view/salary.php');
                }
                else {
                    header('location:index.php?op=sallist&add_flag=0');
                    $data = $this->TblDataS($noofrow, $result); 
                    include('./view/salary.php');
                }
            }
            else {
                $row = array();
                include('./view/add-salary.php');
            }
            
        }

        public function editSal() {

            $result1 = $this->employeeModel->saladdName();
            $row = mysqli_num_rows($result1);

            if(!empty($_GET['id'])) {

                $id = $_POST['name'];
                $res = $this->employeeModel->fetchname($id);
                $row = mysqli_num_rows($res);
                $name = mysqli_fetch_array($res);
                $emp_name = $name['firstname'];
                
                $recid_sal = $_GET['id'];

                $result1 = $this->employeeModel->saladdName();
                $row1 = mysqli_num_rows($result1);
                
                $result = $this->salaryModel->FetchSalDetails($recid_sal);
                $row = mysqli_fetch_array($result);
                
                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    $arrayemployee = array();
                    $arrayemployee['recid_sal'] = $_POST['recid_sal'];
                    $arrayemployee['employee_name'] = $emp_name;
                    $arrayemployee['month'] = $_POST['month'];
                    $arrayemployee['year'] = $_POST['year'];
                    $arrayemployee['amount'] = $_POST['amount'];
                    $result = $this->salaryModel->UpdateSal($arrayemployee);
                    if(!empty($result)) {
                        header('location:index.php?op=sallist&update_flag=1');
                    } else {
                        header('location:index.php?op=sallist&update_flag=0');
                    }
                }
                else {
                    include('./view/add-salary.php');
                }
            } 
        }

        public function deleteSal() {

            if(!empty($_GET['id'])) {
                $recid_sal = $_GET['id'];
                $result = $this->salaryModel->DeleteSal($recid_sal); 
                if(!empty($result)) {
                    //header('location:index.php?op=sallist&delete_flag=1');
                    $data = $this->ListSal($noofrow, $result); 
                    //include('./view/salary.php');
                }  
                else {
                    header('location:index.php?op=sallist&delete_flag=0');
                }       
            }
        }

        public function show(){
            $recid_sal = $_POST['emp_name'];
            $month = $_POST['month'];
            $year = $_POST['year'];
            //print_r($recid_sal); print_r($month); print_r($year); exit();
            $result = $this->salaryModel->Show($recid_sal, $month, $year);
            $noofrow = $result->num_rows;
            $result1 = $this->salaryModel->salName();
            $row = mysqli_num_rows($result1);
            $data = $this->TblDataS($noofrow, $result);     
            include('./view/salary.php');
        }

        public function showName(){
            $result = $this->employeeModel->saladdName();
            $row = mysqli_num_rows($result);
        }
    }

?>