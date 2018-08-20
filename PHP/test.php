<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

		$age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
		echo "Peter is " . $age['Peter'] . " years old.";
		echo "<br />";
		print_r($age);

		$marks = array( 
            "mohammad" => array (
               "physics" => 35,
               "maths" => 30,	
               "chemistry" => 39
            ),
            
            "qadir" => array (
               "physics" => 30,
               "maths" => 32,
               "chemistry" => 29
            ),
            
            "zara" => array (
               "physics" => 31,
               "maths" => 22,
               "chemistry" => 39
            )
         );
		echo "<br />";
		echo "marks of mohmand : ";
		echo $marks['mohammad']['physics'] . "<br />";

		$cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");
		print_r(array_chunk($cars,2));

      echo "<br />";
      echo "array_count_values <br />";
      $a=array("A","Cat","Dog","A","Dog");
      print_r(array_count_values($a));

      echo "<br />";
      echo "array_diff <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("e"=>"red","f"=>"green","g"=>"blue");
      $result=array_diff($a1,$a2);
      print_r($result);

      echo "<br />";
      echo "array_diff_assoc <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("e"=>"red","b"=>"green","g"=>"blue");
      $result=array_diff_assoc($a1,$a2);
      print_r($result);

      echo "<br />";
      echo "array_diff_key <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue");
      $a2=array("c"=>"yellow","b"=>"black","e"=>"brown");
      $a3=array("f"=>"green","b" =>"purple","g"=>"red");
      $result=array_diff_key($a1,$a2,$a3);
      print_r($result);

      echo "<br />";
      echo "array_diff_uassoc<br />";
      function myfunction($a,$b)
      {
      if ($a===$b)
        {
        return 0;
        }
        return ($a>$b)?1:-1;
      }

      $b1=array("a"=>"red","b"=>"green","c"=>"blue", "s"=>"white");
      $b2=array("d"=>"red","b"=>"green","c"=>"blue");

      $result=array_diff_uassoc($b2,$b1,"myfunction");
      print_r($result);

      $a3 = ["apple","boy"];
      $b3 = ["cake", "bat"];

      $res = array_combine(array_diff($a3,$b3),array_diff($b3,$a3));
      print_r($res);
	?>

</body>
</html>

