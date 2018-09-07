<?php 
	
	 include('./model/productModel.php');

	class productController{

		private $productModel = NULL;

    	public function __construct() {

    		$this->productModel = new productModel();
    	
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
    		 		$this->deleteProduct();
    		 	}
    		 	elseif ( $op == 'changestatusp' ) {
    		 		$this->changeStatusP();
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
                            
                        $data .= " <td> " . $resultdata['id'] . " </td> " ;
                        $data .= " <td> " . $resultdata['name'] . " </td> " ;
                        $data .= " <td> " . $resultdata['category'] . " </td> " ;
                        if(!empty($resultdata['image'])){
                            $data .= " <td> <img src=\"images/" . ($resultdata['image']) . "\" width=\"50\" height=\"50\"> </td> " ;
                        }
                        else {
                            $data .= " <td> <img src=\"images/default.png\" width=\"50\" height=\"50\"> </td> " ;    
                        }
                        $data .= " <td> " . $resultdata['price'] . " </td> " ;
                        $data .= " <td> " . $resultdata['quantity'] . " </td> " ;
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['id'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['id'] . " > " . ($resultdata['status'] == 1 ? 'active' : 'inactive') . " </a></td> " ;
                        $data .= " <td> <a href=\"index.php?op=edit&id= " . $resultdata['id'] . "\">
                                    Edit</a> </td>" ;
                        $data .= "<td> <a class=\"delete\" href=\"javascript:;\" data-id= " . $resultdata['id'] . " >Delete </a> </td> " ; 

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
                include('./view/add-product.php');
            }   

    	}

	}

?>