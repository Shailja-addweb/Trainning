<?php 
	
	 include('./model/productModel.php');
     include('./model/categoryModel.php');

	class productController{

		private $productModel = NULL;

    	public function __construct() {

    		$this->productModel = new productModel();
            $this->categoryModel = new categoryModel();
    	
    	}

    	public function handleRequest(){

    		 $op = isset($_GET['op'])?$_GET['op']:NULL;
    		 
    		 try{

    		 	if( !$op || $op == 'productlist' ){
    		 		$this->productList();
    		 	}
    		 	elseif ( $op == 'addproduct' ) {
    		 		$this->addProduct();
    		 	}
    		 	elseif ( $op == 'editproduct' ) {
    		 		$this->editProduct();
    		 	}
    		 	elseif ( $op == 'deleteproduct' ) {
                    $id = $_GET['id'];
    		 		$this->deleteProduct($id);
    		 	}
    		 	elseif ( $op == 'changestatusp' ) {
                    $id = $_GET['id'];
    		 		$this->changeStatusP($id);
    		 	}
                elseif ( $op == 'remove' ) {
                     $id = $_GET['id'];
                    $this->removeImg($id);
                }
    		 	else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }   

    		 }
    		 catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }

    	}

    	public function productList(){

    		$result = $this->productModel->ProductList();
        	$noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblProduct($noofrow, $result); 
                include('./view/product.php');
            }
    	}

    	public function TblProduct($noofrow, $result){

    		$data = " <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th colspan=\"2\">ACTION</th>
                      </tr> ";

            if($noofrow>0) {
                while($resultdata = mysqli_fetch_array($result)) {
                     
                    $data .= " <tr> " ;
                            
                        $data .= " <td> " . $resultdata['p_id'] . " </td> " ;
                        $data .= " <td> " . $resultdata['name'] . " </td> " ;
                        $data .= " <td> " . $resultdata['category'] . " </td> " ;
                        $data .= " <td> ";
                        if(!empty($resultdata['image'])){
                            $image_name = $resultdata['image'];
                            $ima = explode(',',$image_name);
                            foreach($ima as $i =>$key){
                                $data .= " <img src=\"images/" . $key . "\" width=\"50\" height=\"50\"> " ;
                            }
                        }
                        else {
                            $data .= "<img src=\"images/default.png\" width=\"50\" height=\"50\" ";
                        }
                        $data .= " </td> ";
                        $data .= " <td> " . $resultdata['price'] . " </td> " ;
                        $data .= " <td> " . $resultdata['quantity'] . " </td> " ;
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['p_id'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['p_id'] . " > " . ($resultdata['status'] == 1 ? 'active' : 'inactive') . " </a></td> " ;
                        $data .= " <td> <a href=\"index.php?op=editproduct&id= " . $resultdata['p_id'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= " . $resultdata['p_id'] . " >Delete </a> </td> " ; 

                    $data .= " </tr>" ;
    
                } 
                return $data; 
            }
            else {
                $data .= "<tr><td colspan=\"5\">No Record</td></tr>" ;

                return $data;
            }
    	}

    	public function addProduct(){

            $result = $this->categoryModel->AddNameCategory();
            $noofrow = mysqli_num_rows($result);

            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {   
                extract($_POST);
                $error=array();
               
                foreach($_FILES["image"]["tmp_name"] as $key=>$tmp_name)
                        {   
                            $file_name=$_FILES["image"]["name"][$key];
                            $file_tmp=$_FILES["image"]["tmp_name"][$key];
                            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                            if(!file_exists("./images/".$file_name))
                            {
                                move_uploaded_file($file_tmp=$_FILES["image"]["tmp_name"][$key],"./images/".$file_name);
                            }
                            else
                            {
                                array_push($error,"$file_name, ");
                            }

                            $filename = implode(",",$_FILES['image']['name']);
                        }

              
                $arrayrecords = array();
                $arrayrecords['name'] = $_POST['name'];
                $arrayrecords['category'] = implode(", ",$_POST['category']);
                $arrayrecords['image'] =  $filename;   
                $arrayrecords['price'] =  $_POST['price'];
                $arrayrecords['quantity'] = $_POST['quantity'];
                $arrayrecords['status'] = "1";
                $arrayrecords['isDelete'] = "0";
                $result = $this->productModel->AddProduct($arrayrecords);


                if($result) {
                    header('location:index.php?op=productlist&add_flag=1');
                    $data = $this->TblProduct($noofrow, $result); 
                    include('./view/product.php');
                }
                else {
                    header('location:index.php?op=productlist&add_flag=0');
                    $data = $this->TblProduct($noofrow, $result); 
                    include('./view/product.php');
                }
                   
            }
            else {
                $row = array();
                include('./view/add-product.php');
            }   

    	}

        public function editProduct(){
  
            if(!empty($_GET['id'])) {
                $id = $_GET['id'];
                $result1 = $this->productModel->FetchProductDetails($id);
                $row = mysqli_fetch_array($result1);
                
                $result = $this->categoryModel->AddNameCategory();
                $noofrow = mysqli_num_rows($result);

                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    extract($_POST);
                    $error=array();
               
                    print_r($imagess);
                    foreach($_FILES["image"]["tmp_name"] as $key=>$tmp_name){   
                            $file_name=$_FILES["image"]["name"][$key];
                            $file_tmp=$_FILES["image"]["tmp_name"][$key];
                            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                            if(!file_exists("./images/".$file_name))
                            {
                                move_uploaded_file($file_tmp=$_FILES["image"]["tmp_name"][$key],"./images/".$file_name);
                            }
                            else
                            {
                                array_push($error,"$file_name, ");
                            }

                            $filename = implode(",",$_FILES['image']['name']);
                    }

                    if($file_name == ''){
                        $filename = $row["image"];
                    }


                    $arrayrecords = array();
                    $arrayrecords['p_id'] = $_POST['p_id'];
                    $arrayrecords['name'] = $_POST['name'];
                    $arrayrecords['category'] = implode(", ",$_POST['category']);
                    $arrayrecords['image'] =  $imagename;   
                    $arrayrecords['price'] =  $_POST['price'];
                    $arrayrecords['quantity'] = $_POST['quantity'];
                    $arrayrecords['status'] = $row['status'];
                    $result = $this->productModel->EditProduct($arrayrecords);
                    if(!empty($result)) {
                        header('location:index.php?op=productlist&update_flag=1');
                    } else {
                        header('location:index.php?op=productlist&update_flag=0');
                    }
                }
                else {
                    include('./view/add-product.php');
                }
            } 
        }

        public function removeImg($id){

            if(!empty($_GET['id'])){
        
                $result = $this->productModel->RemoveImg($id);
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {

                    $data = $this->productList(); 

                }  
                else {
                    header('location:index.php?op=productlist&delete_flag=0');
                }  
            }
        }

        public function changeStatusP($id){

            $result = $this->productModel->ChangeStatusP($id);
            $noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                
                $data = $this->productList($noofrow, $result); 

            }
            else {
                    header('location:index.php?op=productlist&status_flag=0');
                }   
        }

        public function deleteProduct($id) {
           
            if(!empty($_GET['id'])) {
                $id = $_GET['id']; 
                $result = $this->productModel->DeleteProduct($id); 
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {

                    $data = $this->productList(); 

                }  
                else {
                    header('location:index.php?op=productlist&delete_flag=0');
                }       
            }
        }

	}

?>