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
                elseif( $op == 'productdetails_1'){
                    $this->Productdetails_1();
                }
                elseif( $op == 'productdetails_2'){
                    $this->Productdetails_2();
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

                    $data .= " <div class=\"column\" data-id=\"".$imgid['id']."\">";

                        $id = $imgid['id']; //4
                        $p_id = $imgid['p_id']; //2

                        $name = $this->shopModel->productname($p_id);
                        $data .= "<center><b>".$name."</b></center>";
                        $result = $this->shopModel->fetchImages($p_id);
                       
                        $rows = mysqli_num_rows($result);
                        if($rows>0){
                            while ($imagerow = mysqli_fetch_array($result)) {
                                if($imagerow['flag'] == 'Y' ){

                                    $data .= "<a href = \"?op=productdetails_".$p_id."\"><img src =\"images/".$imagerow['name']."\" id = \"".$imagerow['id']."\" style =\"width:90%\" ></a>";
                                }
                               
                            }
                        }
                    $data .= "</div>";
                }
            }
                return $data; 
        }

        public function Productdetails_1(){
           
            $images = $this->shopModel->ProductDetails_1();      
            $noofrow = mysqli_num_rows($images); 

            echo "<br><br><center><b style=font-size:35px;color:green; >Harry Potter</b></center>";
            echo "<div class=\"default_img\"  style=float:left;>";
            if($noofrow>0){
                while ($images_of_product = mysqli_fetch_array($images)) { 
                    

                    if($images_of_product['flag'] == 'Y'){

                        echo "<img src =\"images/".$images_of_product['name']."\" id = \"".$images_of_product['id']."\" style =\"width:80%; padding-top: 30px;\" >";
                    }

                    echo "<div class=\"other-img\"><img src =\"images/".$images_of_product['name']."\" id = \"".$images_of_product['id']."\" style =\"width:20%; height:100px; padding-top: 30px; float:left;\" ></div>";
                    

                }
            } 
            echo "</div>";

            echo "<div class=\"description\" >
                        <p style=\"float:left; padding-top: 30px; font-size: 40px\" >Description of Product</p>
                        <div class=\"details\" style=\"float:left; padding-top: 30px; font-size: 20px\" >
                            <p>Book : 7 books are avialable</p>
                            <p>Cloths: different types of clothes are avialable.</p>
                        </div>
                </div>";
        }

        public function Productdetails_2(){
           
            $images = $this->shopModel->ProductDetails_2();      
            $noofrow = mysqli_num_rows($images); 

            echo "<br><br><center><b style=font-size:35px;color:green; >Rose</b></center>";
            echo "<div class=\"default_img\"  style=float:left;>";
            if($noofrow>0){
                while ($images_of_product = mysqli_fetch_array($images)) { 
                    

                    if($images_of_product['flag'] == 'Y'){

                        echo "<img src =\"images/".$images_of_product['name']."\" id = \"".$images_of_product['id']."\" style =\"width:80%; padding-top: 30px;\" >";
                    }

                    echo "<div class=\"other-img\"><img src =\"images/".$images_of_product['name']."\" id = \"".$images_of_product['id']."\" style =\"width:20%; height:100px; padding-top: 30px; float:left;\" ></div>";
                    

                }
            } 
            echo "</div>";

            echo "<div class=\"description\" >
                        <p style=\"float:left; padding-top: 30px; font-size: 40px\" >Description of Product</p>
                        <div class=\"details\" style=\"float:left; padding-top: 30px; font-size: 20px\" >
                            <p>flower : 7 types of flowers are avialable</p>
                            <p>Cloths: different types of clothes are avialable.</p>
                        </div>
                </div>";
        }
    }
?>