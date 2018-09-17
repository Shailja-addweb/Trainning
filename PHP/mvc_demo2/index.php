<?php

	$action = $_GET['op'];

	switch ( $action ) {
		case 'show':

        include_once 'controller/categoryController.php';

        $controller = new categoryController();
                 
        $controller->handleRequest();
			  
        break;

    case 'search':

        include_once 'controller/productsController.php';
                
        $controller = new productsController();
                 
        $controller->handleRequest();

        break;
		
		default:?>

			<style>
            ul#menubar{
              margin:0px;
              padding:0px;
              list-style:none;
              width:800px;
              height:40px;
            }
            ul#menubar li{
              width:100px;
              height:40px;
              line-height:30px;
              float:left;
              padding-left: 10px;
            }
            ul#menubar li a{
              text-decoration:none;
              color:WHITE;
            }
            ul#menubar li a:hover{
            	color:RED; 
            }
        </style>

        <html>                                                                                          
            <body>
            <div id="records">
              <div style="width:1250px;background-color:#000000;height:30px;color:#ffffff;" id="record" class="re"> 
                  <ul id="menubar">
                      <li><a href="index.php">Home</a></li>
                      <li><a href="?op=productlist">Product</a></li>
                      <li><a href="?op=categorylist">Category</a></li>
                  </ul>
                  <br/>
                  <br/>
              </div>
              <div class="title"><strong>" Welcome to Product - Category Window "</strong></div>

              </body>
        </html><?php 

				if($_GET['op'] == 'productlist' || $_GET['op'] == '' || $_GET['op'] == 'addproduct' || $_GET['op'] == 'editproduct' || $_GET['op'] == 'deleteproduct'|| $_GET['op'] == 'changestatusp' || $_GET['op'] == 'remove' || $_GET['op'] == 'searchshow'){

            include_once 'controller/productsController.php';
                
            $controller = new productsController();
                 
            $controller->handleRequest();

				}
				
				elseif ($_GET['op'] == 'categorylist' || $_GET['op'] == 'addcategory' || $_GET['op'] == 'editcategory' || $_GET['op'] == 'deletecategory' || $_GET['op'] == 'changestatusc' || $_GET['op'] == 'remove' ) {

            include_once 'controller/categoryController.php';

            $controller = new categoryController();
                 
            $controller->handleRequest();
					
				}

			break;
	}

?>