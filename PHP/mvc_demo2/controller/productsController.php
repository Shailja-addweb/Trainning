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
                     $p_id = $_GET['p_id'];
                    $this->delete($id,$p_id);
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
                            
                        $data .= " <td> " . $resultdata['p_id'] . " </td> " ;
                        $data .= " <td> " . $resultdata['name'] . " </td> " ;

                        $res = $this->categoryModel->fetchname();
                        $nr = mysqli_num_rows($res);
                        $catname = '';
                        if($nr>0) {
                            while($rdata = mysqli_fetch_array($res)) {
                                $rd = explode(",", $resultdata['category'] );
                                foreach ($rd as $i => $value) {
                                    if($rdata['id'] == $value ){

                                        $catname = $catname.",".$rdata['name'];
                                    }
                                }
                            }
                        }
                        $catname = substr( $catname, 1 );
                        
                        $data .= " <td> " .  $catname . "</td> " ;
                        $data .= " <td> ";
                        if(!empty($resultdata['image'])){
                            $image_name = $resultdata['image'];
                            $ima = explode(',',$image_name);
                            foreach($ima as $i =>$key){
                                $res = $this->productsModel->FetchName($key);
                                $noofrow1 = mysqli_num_rows($res);
        
                                foreach ($res['name'] as $name) {
                                     
                                    $filename = $name.",".$filename; 
                                } 

                                $data .= " <img src=\"images/" . $name . "\" width=\"50\" height=\"50\"> " ;
                            }
                        }
                        else {
                            $data .= "<img src=\"images/default.png\" width=\"50\" height=\"50\" > ";
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

                            $arrayimage['imagename'] = $file_name;
                            $image = $this->productsModel->InsertImage($arrayimage); 
                            //$filename = implode(",",$_FILES['image']['name']);
                        }

                $fetchimgid = $this->productsModel->FetchImageId();
                $noofrow = mysqli_num_rows($fetchimgid);  
                $idofimages = '';
                if($noofrow>0){
                    while ($imgid = mysqli_fetch_array($fetchimgid)) {

                        $idofimages .= $imgid['id'];
                        $idofimages .= ',';
                    }
                } 
                //rtrim($idofimages,",");     
                
                if (substr($idofimages, -1, 1) == ',')
                {
                  $idofimages = substr($idofimages, 0, -1);
                }
                

                $arrayrecords = array();
                $arrayrecords['name'] = $_POST['name'];
                $arrayrecords['category'] = implode(",",$_POST['category']);
                $arrayrecords['image'] =  $idofimages;   
                $arrayrecords['price'] =  $_POST['price'];
                $arrayrecords['quantity'] = $_POST['quantity'];
                $arrayrecords['status'] = "1";
                $result = $this->productsModel->AddProduct($arrayrecords);

                $lastid = $this->productsModel->fetchID($result,$idofimages);
                $lastid_c = $this->productsModel->fetchID_c($result);

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

                //for image
                $name = $row['image'];
                $filename = '';
                $ima = explode(',',$name);
                $id_img =array();
                foreach($ima as $i =>$key){
                    $res = $this->productsModel->FetchName($key);
                    $noofrow1 = mysqli_num_rows($res);
        
                    foreach ($res['name'] as $name) {
                        if($filename != '' ){
                            $filename = $filename.",".$name; 
                        }
                        else{
                            $filename = $name;
                        }
                    } 

                    foreach ($res['id'] as $id) {  
                        $id_img[] = $id; 
                    }
                    
                }

                if (substr($filename, -1, 1) == ',')
                {
                  $filename = substr($filename, 0, -1);
                }
                
                if(isset($_POST['submit']) && !empty($_POST['submit'])) 
                {
                    $idofimages = '';

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

                                $arrayimage['imagename'] = $file_name;
                                
                                $image = $this->productsModel->InsertImage($arrayimage, $id_set); 
                                
                            }
                            $idofimages = $row['image'];
                            
               
                    $fetchimgid = $this->productsModel->FetchImageId($id_set);
                    $noofrow = mysqli_num_rows($fetchimgid);  
                    if($noofrow>0){
                
                        while ($imgid = mysqli_fetch_array($fetchimgid)) {

                            if($idofimages != ''){
                                $idofimages .= ',';
                                $idofimages .= $imgid['id'];
                                /*$id_up = $imgid['id'];
                                $id_set = $_POST['id'];
                                $update = $this->productsModel->updateId($id_up,$id_set);*/
                            }
                            else{
                                $idofimages .= $imgid['id'];
                            }
                        }
                    }     
                    
                    if (substr($idofimages, -1, 1) == ',')
                    {
                        $idofimages = substr($idofimages, 0, -1);
                    }
                 
                    
                    $arrayrecords = array();
                    $arrayrecords['p_id'] = $_POST['p_id'];
                    $arrayrecords['name'] = $_POST['name'];
                    $arrayrecords['category'] = implode(", ",$_POST['category']);
                    $arrayrecords['image'] = $idofimages;  
                    $arrayrecords['price'] = $_POST['price'];
                    $arrayrecords['quantity'] = $_POST['quantity'];
                    $arrayrecords['status'] = $row['status'];
                    $result = $this->productsModel->EditProduct($arrayrecords);

                    $lastid = $this->productsModel->fetchID($result,$idofimages);
                    $lastid_c = $this->productsModel->fetchID_c($result);

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

        public function delete($id,$p_id){

            $res = $this->productsModel->Delete($id,$p_id);
            
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