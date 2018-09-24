<?php 
   
	include('./model/categoryModel.php');
    include('./model/productsModel.php');
    include('./model/shopModel.php');

	class shopController{

		private $shopModel = NULL;

    	public function __construct() {

            $this->shopModel = new shopModel();
    		$this->categoryModel = new categoryModel();
            $this->productsModel = new productsModel();
    	
    	}

    	public function handleRequest() {

    		 $op = isset($_GET['op'])?$_GET['op']:NULL;
    		 
    		 try{

    		 	if( !$op || $op == 'shoplist' ){
    		 		$this->shopList();
    		 	}
                elseif( $op == 'productdetails'){
                   
                    $this->Productdetails();
                }
                else {
                    $this->showError("Page not found", "Page for operation ".$op." was not found!");
                }   
    		 
    		 }
    		 catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }

    	}

    	public function shopList(){

            $ids = $this->shopModel->fetchId_shop();
            $noofrow = mysqli_num_rows($ids);
            if(!empty($ids)){
                 /*if($noofrow>0){
                    while ($imgid = mysqli_fetch_array($ids)) {*/
                        $data .= $this->viewProduct($noofrow,$ids);
                        
                    /*}
                }*/
                include('./view/shop.php');
            }
            else {

                $data = "NO PRODUCTS" ;

            }

    	}

        public function viewProduct($noofrow,$ids) {

            if($noofrow>0){
                while ($imgid = mysqli_fetch_array($ids)) {
                   ; 
                    $data .= " <div class=\"column\" data-id=\"".$imgid['p_id']."\">";

                        $id = $imgid['id']; //4
                        $p_id = $imgid['p_id']; //2

                        $name = $this->shopModel->productname($p_id);
                        $data .= "<center><b>".$name."</b></center>";
                        $result = $this->shopModel->fetchImages($p_id);
                       
                        $rows = mysqli_num_rows($result);
                        if($rows>0){
                            while ($imagerow = mysqli_fetch_array($result)) {
                                if($imagerow['flag'] == 'Y' ){

                                    $data .= "<a href = \"?op=productdetails&p_id=".$p_id."\"><img src =\"images/".$imagerow['name']."\" id = \"".$imagerow['id']."\" style =\"width:90%\" ></a>";
                                }
                               
                            }
                        }
                    $data .= "</div>";
                }
            }
                return $data; 
        }

        public function Productdetails(){

            $id = $_GET['p_id'];
            $def_images = $this->shopModel->Product_img_Details($id);      
            $noofrow = mysqli_num_rows($def_images); 

            $name = $this->shopModel->productname($id);
            include('./view/shop.php');
            echo "<center><b style=font-size:35px;color:green; >".$name."</b></center>";
            echo "<div class=\"default_img\"  style=float:left;>";
            if($noofrow>0){
                while ($def_images_of_product = mysqli_fetch_array($def_images)) { 
                    

                    if($def_images_of_product['flag'] == 'Y'){

                        echo "<div class=\"selected-img\"><img src =\"images/".$def_images_of_product['name']."\" id = \"".$def_images_of_product['id']."\" style =\"width:70%; padding-top: 30px;\" ></div>";

                    }

                }
            } 

            $images = $this->shopModel->Product_img_Details($id);
            $noofrow1 = mysqli_num_rows($images); 
            if($noofrow1>0){
                while ($images_of_product = mysqli_fetch_array($images)) { 

                    echo "<div class=\"other-img\"><a href=\"javascript:;\"><img src =\"images/".$images_of_product['name']."\" id = \"".$images_of_product['id']."\" style =\"width:20%; height:100px; padding-top: 30px; float:left;\" ></a></div>";
                }
            } 

            
           
            echo "</div>";

            $pro = $this->shopModel->Product_Details($id);   

            $noofrow3 = mysqli_num_rows($pro); 
            if($noofrow3>0){
                while ($details_of_product = mysqli_fetch_array($pro)) { 

                    echo "<div class=\"description\" >";

                        echo "<br>Category : ".$details_of_product['GROUP_CONCAT(DISTINCT c.name)'] ;
                        echo "<br><br>Price : " .$details_of_product['price'];
                        echo "<br><br>Quantity : " .$details_of_product['quantity'];
                                
                    echo "</div>";

                }
            }
        }
    }
?>