<!DOCTYPE html>
<html>
<head>
	<title>Demo1</title>
</head>
<body>
	<h1>Result of students</h1>
	<?php

		$count = 0;
		$marks  = array("37","95","75","70","80","60","50");
		print_r($marks);
		echo "<br />";

		sort($marks);
		print_r($marks);

		echo "<br />";
		$myfile = fopen("condition.txt", "r") or die("Unable to open file!");
		while(!feof($myfile)) {
  			echo fgets($myfile) . "<br>";
		}

		echo "<br />";
		echo "<br />";
		
		echo "Showing result of year 2017- "; 
		echo date("Y");

		echo "<br />";
		
		function check($a){

				if($a < 40){
					throw new Exception("given value is not correct ");
					echo "<br />";
				}
				  return true; 
		}

		function grade($marks){
			
			for ($i= 0; $i < sizeof($marks); $i++) { 

			try {

  				check($marks[$i]);
			 	/*echo 'If you see this, the number is 1 or below';*/
			 	/*echo($i);*/
			}

			catch(Exception $e) {
				echo 'Message: ' .$e->getMessage();
			}

				if($marks[$i] >= 90){
					echo "Student" . $i . " have A grade";
					echo "<br />";
				}
				elseif($marks[$i] >= 80){
					echo "Student" . $i . " have B grade";
					echo "<br />";
				}
				elseif($marks[$i] >= 70){
					echo "Student" . $i . " have C grade";
					echo "<br />";
				}
				elseif($marks[$i] >= 60){
					echo "Student" . $i . " have D grade";
					echo "<br />";
				}
				elseif($marks[$i] == 50){
					echo "Student" . $i . " is having passing marks only";
					echo "<br />";
				}
				else{
					echo "Student" . $i . " is failed";
					echo "<br />";
				}

			}
		}
		grade($marks);


	?>

</body>
</html>