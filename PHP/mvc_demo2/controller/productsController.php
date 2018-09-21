<?php 
	
	 include('./model/productsModel.php');
     include('./model/categoryModel.php');

	class productsController{

		private $productsModel = NULL;

    	public function __construct() {

    		$this->productsModel = new productsModel();
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
                elseif ( $op == 'changedefault' ) {
                     $id = $_GET['id'];
                     $p_id = $_GET['p_id'];
                    $this->changeDefault($id,$p_id);
                }
                elseif ( $op == 'delete' ) {
                     $id = $_GET['id'];
                     //$p_id = $_GET['p_id'];
                    $this->delete($id);
                }
                elseif ( $op == 'search' ) {
                    $this->search();
                }
                elseif ( $op == 'searchshow' ) {
                    $this->searchshow();
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

    		$result = $this->productsModel->ProductList();
        	$noofrow = mysqli_num_rows($result);
            if(!empty($result)){
                $data = $this->TblProduct($noofrow, $result); 
                include('./view/products.php');
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
                        $data .= " <td> " . $resultdata['GROUP_CONCAT(DISTINCT c.name)'] . " </td> ";
                        $data .= " <td> ";
                        if(!empty($resultdata['GROUP_CONCAT(DISTINCT i.name)'])){
                            $image_name = $resultdata['GROUP_CONCAT(DISTINCT i.name)'];
                            $image_name = trim($image_name,",");
                            $ima = explode(',',$image_name);
                            foreach($ima as $i =>$key){
                                if($key != 'default.png'){

                                    $data .= " <img src=\"images/" . $key . "\" width=\"50\" height=\"50\"> " ;
                                }
                            }
                        }
                        else {
                            $data .= "<img src=\"images/default.png\" width=\"50\" height=\"50\" > ";
                        }
                        $data .= " </td> ";
                        $data .= " <td> " . $resultdata['price'] . " </td> " ;
                        $data .= " <td> " . $resultdata['quantity'] . " </td> " ;
                        $data .= " <td> <a class=\"status\" id=\"status-" . $resultdata['id'] . "\" 
                                           href=\"javascript:;\" data-id= " .  $resultdata['id'] . " > " . ($resultdata['status'] == 1 ? 'active' : 'inactive') . " </a></td> " ;
                        $data .= " <td> <a href=\"index.php?op=editproduct&id= " . $resultdata['id'] . "\">
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

            $result = $this->categoryModel->AddNameCategory();
            $noofrow = mysqli_num_rows($result);

            if(isset($_POST['submit']) && !empty($_POST['submit'])) 
            {  

                $arrayrecords = array();
                $arrayrecords['name'] = $_POST['name'];
                $arrayrecords['price'] =  $_POST['price'];
                $arrayrecords['quantity'] = $_POST['quantity'];
                $arrayrecords['status'] = "1";
                $result = $this->productsModel->AddProduct($arrayrecords);

                $p_id = $this->productsModel->fetchp_id();

                $cat = $_POST['category'];
                foreach ($cat as $i => $value) {   
                    $c_id = $value;
                    $cat = $this->productsModel->category_insert($p_id,$c_id);
                }
                

                extract($_POST);
                $error=array();
                $arrayimage =array();
               
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

                            $arrayimage['name'] = $file_name;
                           
                            $image = $this->productsModel->InsertImage($arrayimage,$p_id); 
                        }

                if($result) {
                    header('location:index.php?op=productlist&add_flag=1');
                    $data = $this->TblProduct($noofrow, $result); 
                    include('./view/products.php');
                }
                else {
                    header('location:index.php?op=productlist&add_flag=0');
                    $data = $this->TblProduct($noofrow, $result); 
                    include('./view/products.php');
                }
                   
            }
            else {
                $row = array();
                include('./view/add-products.php');
            }   

    	}

        public function editProduct(){
  
            if(!empty($_GET['id'])) {
                $id = $_GET['id'];

                $result1 = $this->productsModel->FetchProductDetails($id);
                $row = mysqli_fetch_array($result1);
                

                //for category name
                $result = $this->categoryModel->AddNameCategory();
                $noofrow = mysqli_num_rows($result);

                //for image id
                $img_id = $this->productsModel->fetch_img_id($id);
                $img_flag = $this->productsModel->fetch_img_flag($id);
            

                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {


                    $arrayrecords = array();
                    $arrayrecords['id'] = $_POST['id'];
                    $arrayrecords['name'] = $_POST['name'];
                    $arrayrecords['price'] = $_POST['price'];
                    $arrayrecords['quantity'] = $_POST['quantity'];
                    $arrayrecords['status'] = $row['status'];
                    $result = $this->productsModel->EditProduct($arrayrecords);

                    $cat = $_POST['category'];
                    //print_r("selected category :  ");print_r($cat); print_r("<br>");
                    $p_id = $_POST['id'];
                    $old_cat = $row['GROUP_CONCAT(DISTINCT c.name)'];
                    $cat_id = $this->productsModel->fetchID_c($p_id);
                    
                    $noofrow = mysqli_num_rows($cat_id); 
                    $i = 0;
                    $catid = array();;
                    if($noofrow>0){
                        while ($category_id = mysqli_fetch_array($cat_id)){

                            $catid[] = $category_id['c_id']; 
                        }
                    }
                    //print_r($catid);
                    $cat_diff = array_diff($cat, $catid);
                    $cat_diff2 = array_diff($catid,$cat);
                    //print_r($cat_diff);
                    //print_r($cat_diff2);

                    if($cat_diff){ 
                        foreach ($cat_diff as $i => $c_id) {
                            //echo "no";
                            $cat_ins = $this->productsModel->category_insert($p_id,$c_id);
                        }
                    }
                    if($cat_diff2){
                        foreach ($cat_diff2 as $i => $c_id) {
                            //echo "yes";
                            $cat_del = $this->productsModel->category_delete($c_id);
                        }
                    }

                    extract($_POST);
                    $error=array();
                    $arrayimage =array();
            
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

                                $arrayimage['name'] = $file_name;
                               
                                $image = $this->productsModel->InsertImage($arrayimage,$p_id); 
                            }

                    if(!empty($result)) {
                        header('location:index.php?op=productlist&update_flag=1');
                    } else {
                        header('location:index.php?op=productlist&update_flag=0');
                    }
                }
                else {
                    include('./view/add-products.php');
                }
            } 
        }

        public function changeDefault($id,$p_id){

            $res = $this->productsModel->ChangeDefault($id,$p_id);
            
        }

        public function delete($id){

            $res = $this->productsModel->Delete($id);
            
        }

        public function removeImg($id){

            if(!empty($_GET['id'])){
        
                $result = $this->productsModel->RemoveImg($id);
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

            $result = $this->productsModel->ChangeStatusP($id);
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
                $result = $this->productsModel->DeleteProduct($id); 
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {

                    $data = $this->productList(); 

                }  
                else {
                    header('location:index.php?op=productlist&delete_flag=0');
                }       
            }
        }

        public function search(){

            if(!empty($_GET['keyword'])){
                $keyword = $_GET['keyword'];
                $result = $this->productsModel->Search($keyword);
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {
                    /*echo "<ul id=\"product-list\">";
                    
                    foreach($result as $product) {

                        echo "<li onClick=\"selectproduct('" . $product["name"] . "')\">" . $product["name"] ."</li>";
                    }
                    echo "</ul>";*/
                    foreach($result as $product) {

                        echo "<option value='". $product['name'] ."' onClick=\"selectproduct('" . $product['name'] . "')\" >". $product['name'] ."</option>";
                    }
                } 
            }
        }

        public function searchshow(){

            if(!empty($_GET['keyword'])){
                $keyword = $_GET['keyword'];
                $result = $this->productsModel->SearchShow($keyword);
                $noofrow = mysqli_num_rows($result);
                if(!empty($result)) {

                    $data = $this->TblProduct($noofrow, $result); 
                     include('./view/products.php');

                }  
                else {
                    header('location:index.php?op=productlist');
                }  
            }
        }

	}

?>