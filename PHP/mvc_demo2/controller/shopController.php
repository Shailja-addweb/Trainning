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
    		 
    		 }
    		 catch ( Exception $e ) {
                $this->showError("Application error", $e->getMessage());
            }

    	}

    	public function shopList(){

            $ids = $this->productsModel->fetchIds();
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
                    $data .= " <div class=\"column\" data-id=\"".$imgid['p_id']."\">";

                        $id = $imgid['p_id'];
                        $name = $this->shopModel->productname($id);
                        $data .= "<center><b>".$name."</b></center>";
                        $result = $this->shopModel->fetchImages($id);
                        $rows = mysqli_num_rows($result);
                        if($rows>0){
                            while ($imagerow = mysqli_fetch_array($result)) {
                                if($imagerow['defaultimg'] == 'Y' ){

                                    $data .= "<img src =\"images/".$imagerow['imagename']."\" id = \"".$imagerow['id']."\" style =\"width:90%\" >";
                                }
                                else{
                                    $data .= "<img src =\"images/".$imagerow['imagename']."\" id = \"".$imagerow['id']."\" style =\"width:20%\" >";
                                }
                            }
                        }
                    $data .= "</div>";
                }
            }
                return $data; 
        }
            
    }
?>