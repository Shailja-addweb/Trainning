<?php 
   
	include('./model/categoryModel.php');
    include('./model/productsModel.php');

	class categoryController{

		private $categoryModel = NULL;

    	public function __construct() {

    		$this->categoryModel = new categoryModel();
            $this->productsModel = new productsModel();
    	
    	}

    	public function handleRequest() {

    		 $op = isset($_GET['op'])?$_GET['op']:NULL;

    		 try{

    		 	if( !$op || $op == 'categorylist' ){
    		 		$this->categoryList();
    		 	}
    		 	elseif ( $op == 'addcategory' ) {
    		 		$this->addCategory();
    		 	}
    		 	elseif ( $op == 'editcategory' ) {
    		 		$this->editCategory();
    		 	}
    		 	elseif ( $op == 'deletecategory' ) {
    		 		$this->deleteCategory();
    		 	}
    		 	elseif ( $op == 'changestatusc' ) {
                    $id = $_GET['id'];
    		 		$this->changeStatusC($id);
    		 	}
                elseif ( $op == 'remove' ) {
                    $id = $_GET['id'];
                    $this->removeImg($id);
                }
                elseif ( $op == 'show' ) {
                    $this->showProduct();
                }
    		 	else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }   

    		 }
    		 catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }

    	}

        public function categoryList(){

            $result = $this->categoryModel->CategoryList();
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblCategory($noofrow, $result); 
                include('./view/category.php');
            }
        }

        public function TblCategory($noofrow, $result){

            $data = " <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th colspan=\"2\">ACTION</th>
                      </tr> ";

            if($noofrow>0) {
                while($resultdata = mysqli_fetch_array($result)) {
                     $i = 1;
                    $data .= " <tr> " ;
                            
                        $data .= " <td> " . $resultdata['id'] . " </td> " ;
                        $data .= " <td><a href=\"javascript:;\" class=\"name\" value=\"". $resultdata['id'] ."\"> <div id=\"yourPopup\" style=\"padding:0; margin:0; display:none;\"></div>" . $resultdata['name'] . " </a></td> " ;
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['id'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['id'] . " > " . ($resultdata['status'] == 1 ? 'active' : 'inactive') . " </a></td> " ;
                        if(!empty($resultdata['image'])){
                            $data .= " <td> <img src=\"images/" . ($resultdata['image']) . "\" width=\"50\" height=\"50\"> </td> " ;
                        }
                        else {
                            $data .= " <td> <img src=\"images/default.png\" width=\"50\" height=\"50\"> </td> " ;    
                        }
                        $data .= " <td> <a href=\"index.php?op=editcategory&id= " . $resultdata['id'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= " . $resultdata['id'] . " >Delete </a> </td> " ; 

                    $data .= " </tr>" ;
                    $i++;
                } 
                return $data; 
            }
            else {
                $data .= "<tr><td colspan=\"5\">No Record</td></tr>" ;

                return $data;
            }
        }

        public function addCategory(){

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
            
                $arrayrecords = array();
                $arrayrecords['name'] = $_POST['name'];
                $arrayrecords['status'] = "1";
                $arrayrecords['image'] = $target_file;
                $arrayrecords['isDelete'] = "0";
                $result = $this->categoryModel->AddCategory($arrayrecords);


                if($result) {
                    header('location:index.php?op=categorylist&add_flag=1');
                    $data = $this->TblCategory($noofrow, $result); 
                    include('./view/category.php');
                }
                else {
                    header('location:index.php?op=categorylist&add_flag=0');
                    $data = $this->TblCategory($noofrow, $result); 
                    include('./view/category.php');
                }
                   
            }
            else {
                $row = array();
                include('./view/add-category.php');
            }   
        }

        public function removeImg($id){
            if(!empty($_GET['id'])){

                $result = $this->categoryModel->RemoveImg($id);
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {

                    $data = $this->categoryList(); 

                }  
                else {
                    header('location:index.php?op=categorylist&delete_flag=0');
                }  
            }
        }

        public function editCategory() {
            if(!empty($_GET['id'])) {
                $id = $_GET['id'];
                $result = $this->categoryModel->FetchCatgoryDetails($id);
                $row = mysqli_fetch_array($result);
                //print_r($row['image']);

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

                    if($target_file == ''){
                        $target_file = $row["image"];
                    }

                    $arrayrecords = array();
                    $arrayrecords['id'] = $_POST['id'];
                    $arrayrecords['name'] = $_POST['name'];
                    $arrayrecords['status'] = $row['status'];
                    $arrayrecords['image'] = $target_file;
                    $result = $this->categoryModel->EditCategory($arrayrecords);
                    if(!empty($result)) {
                        header('location:index.php?op=categorylist&update_flag=1');
                    } else {
                        header('location:index.php?op=categorylist&update_flag=0');
                    }
                }
                else {
                    include('./view/add-category.php');
                }
            } 
        }

        public function deleteCategory() {
           
            if(!empty($_GET['id'])) {
                $id = $_GET['id']; 

                $result1 = $this->categoryModel->check_cat($id);
                $noofrow1 = mysqli_num_rows($result1);
                
                if($noofrow1 != 0){

                    echo '<script language="javascript">';
                    echo 'alert("This category is in use, So that you cannot delete this category.")';
                    echo '</script>';  

                    $data = $this->categoryList(); 
                   
                }
                else{

                    $result = $this->categoryModel->DeleteCategory($id); 
                    $noofrow = mysqli_num_rows($result);
                    if(!empty($result)) {
                        header('location:index.php?op=categorylist&delete_flag=1');
                        $data = $this->categoryList(); 

                    }  
                    else {
                        header('location:index.php?op=categorylist&delete_flag=0');
                    }    
                }
                     
            }
        }

        public function changeStatusC($id){

            $result = $this->categoryModel->ChangeStatusC($id);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                
                $data = $this->categoryList($noofrow, $result); 

            }
            else {
                    header('location:index.php?op=categorylist&status_flag=0');
                }   
        }

        public function showProduct(){
            $id = $_GET['id'];
            
            $result = $this->productsModel->ShowProduct($id);

            if(!empty($result)){
               echo $result;
            }
        }
	}

?>