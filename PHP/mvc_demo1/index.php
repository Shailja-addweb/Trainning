<?php

    $action = $_GET['op'];
    
    switch ($action) {
        case 'extra':
   
        include_once 'controller/employeeController.php';

        $controller = new employeeController();

        $controller->handleRequest();

        break;
  
    default:?>
        <style>
            ul{
              margin:0px;
              padding:0px;
              list-style:none;
              width:800px;
              height:40px;
            }
            ul li{
              width:100px;
              height:40px;
              line-height:30px;
              float:left;
              padding-left: 10px;
            }
            ul li a{
              text-decoration:none;
              color:WHITE;
            }
            ul li a:hover{
            	color:RED; 
            }
        </style>

        <html>                                                                                          
            <body>
                <div class="rm" id="records">
                      <div style="width:1250px;background-color:#000000;height:30px;color:#ffffff;" id="record" class="re"> 
                          <ul>
                              <li><a href="index.php">Home</a></li>
                              <li><a href="?op=emplist">Employeelist</a></li>
                              <li><a href="?op=deplist">Department</a></li>
                              <li><a href="?op=sallist">Salary</a></li>
                          </ul>
                      </div><?php
                  echo "Welcome to the MVC ARCHITECTURE..!!";
                  ?><br/>
                  <br/>
                </div>
              </body>
        </html><?php 

              if ($_GET['op'] == 'emplist' || $_GET['op'] == '' || $_GET['op'] == 'addemp' || $_GET['op'] == 'delete' || $_GET['op'] == 'edit' || $_GET['op'] == 'allemp' || $_GET['op'] == 'activeemp' || $_GET['op'] == 'inactiveemp' || $_GET['op'] == 'changeE'){

                  include_once 'controller/employeeController.php';
                  
                  $controller = new employeeController();
                 
                  $controller->handleRequest();
              
              } elseif ($_GET['op'] == 'deplist' || $_GET['op'] == 'adddep' || $_GET['op'] == 'deletedep' || $_GET['op'] == 'editdep' || $_GET['op'] == 'alldep' || $_GET['op'] == 'activedep' || $_GET['op'] == 'inactivedep' || $_GET['op'] == 'changeD'){

                  include_once 'controller/departmentController.php';
    
                  $controller = new departmentController();
                  
                  $controller->handleRequest();
              
              } elseif ($_GET['op'] == 'sallist' || $_GET['op'] == 'addsal' || $_GET['op'] == 'editsal' || $_GET['op'] == 'deletesal' || $_GET['op'] == 'show') {
                                  
                  include_once 'controller/salaryController.php';
                 
                  $controller = new salaryController();
                 
                  $controller->handleRequest();
              
              }
        break;
    }

?>  




