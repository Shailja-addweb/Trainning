<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

       print_r("<pre>");
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
      echo "<hr>";
		echo "<br />";
		echo "marks of mohmand : ";
		echo $marks['mohammad']['physics'] . "<br />";

		$cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");
		print_r(array_chunk($cars,2));
      echo "<hr>";
      echo "<br />";
      echo "array_count_values <br />";
      $a=array("A","Cat","Dog","A","Dog");
      print_r(array_count_values($a));

      echo "<hr>";
      echo "<br />";
      echo "array_diff <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("e"=>"red","f"=>"green","g"=>"blue");
      $result=array_diff($a1,$a2);
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_diff_assoc <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("e"=>"red","b"=>"green","g"=>"blue");
      $result=array_diff_assoc($a1,$a2);
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_diff_key <br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue");
      $a2=array("c"=>"yellow","b"=>"black","e"=>"brown");
      $a3=array("f"=>"green","b" =>"purple","g"=>"red");
      $result=array_diff_key($a1,$a2,$a3);
      print_r($result);

      echo "<hr>";
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
      echo "<hr>";

      $a3 = ["apple","boy"];
      $b3 = ["cake", "bat"];

      $res = array_combine(array_diff($a3,$b3),array_diff($b3,$a3));
      print_r($res);

      echo "<hr>";
      echo "<br />";
      echo "array_fill<br />";
      $a4 = array_fill(3,3,"cake");
      print_r($a4);

      echo "<hr>";
      echo "<br />";
      echo "array_fill_keys<br />";
      $keys=array("a","b","c","d");
      $a1=array_fill_keys($keys,"red");
      print_r($a1);

      echo "<hr>";

      echo "<br />";
      echo "array_filter<br />";
      function test_odd($var)
      {
         print_r($var);
         return($var & 9);
      }

      $a1=array('a','b',2,4,5);
      print_r($a1);
      echo "<br />";
      echo "<br />";
      print_r(array_filter($a1,"test_odd"));

      echo "<hr>";

      echo "<br />";
      echo "array_flip<br />";
      $keys=array("a","b","c","d");
      $key=array("a","e","f","h");
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"d");
      $result=array_flip($a1);

      print_r($result);

      echo "<hr>";

      echo "<br />";
      echo "asort<br />";
      $age=array("Peter"=>"95","Ben"=>"37","Joe"=>"43");
      $keys=array("a","b","c","d");
      asort($age);
      print_r($age);
       echo "<br>";
      /*foreach($age as $x=>$x_value)
      {
         echo "Key=" . $x . ", Value=" . $x_value;
         echo "<br>";
      }
   */

      echo "<hr>";

      echo "<br />";
      echo "arsort<br />";
      $age=array("Peter"=>95,"Ben"=>"a","Joe"=>"z");
      arsort($age);
      print_r($age);

      echo "<hr>";
      echo "<br />";
      echo "array_intersect<br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("e"=>"red","b"=>"black","g"=>"purple");
      $a3=array("a"=>"red","b"=>"black","h"=>"yellow");
      $result=array_intersect($a1,$a2,$a3);
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_intersect_assoc<br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("a"=>"red","b"=>"green","g"=>"blue");
      $a3=array("a"=>"red","b"=>"green","g"=>"blue");
      $result=array_intersect_assoc($a1,$a2,$a3);
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_intersect_key<br />";
      $a1=array("red","green","blue","yellow");
      $a2=array("red","green","blue");
      $result=array_intersect_key($a1,$a2);
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_intersect_uassoc<br />";
      function myfunctions($a,$b)
      {
         if ($a===$b)
         {
            return 0;
         }
      return ($a>$b)?1:-1;
      }

      $a12=array("a"=>"red","b"=>"green","d"=>"pink");
      $a22=array("a"=>"red","b"=>"green","d"=>"blue");
      $a32=array("e"=>"yellow","a"=>"red","d"=>"blue");
      $result=array_intersect_uassoc($a12,$a22,$a32,"myfunctions");
      print_r($result);

      function myfunctionn($a,$b)
      {
         if ($a===$b)
         {
            return 0;
         }
         return ($a>$b)?1:-1;
      }
      $a1=array("a"=>"red","b"=>"green","c"=>"blue");
      $a2=array("a"=>"blue","b"=>"black","e"=>"blue");
      $result=array_intersect_ukey($a1,$a2,"myfunctionn");
      print_r($result);

      echo "<hr>";
      echo "<br />";
      echo "array_key_exists<br />";
      $a9=array("Volvo","BMW");
      if (array_key_exists(5,$a9))
      {
         echo "Key exists!";
      }
      else
      {
         echo "Key does not exist!";
      }

      echo "<hr>";
      echo "<br />";
      echo "array_keys<br />";
      $a4=array(10,20,30,"10");
      print_r(array_keys($a4,"10",false));

      echo "<hr>";
      echo "<br />";
      echo "array_map<br />";
      function functions($v)
      {
         if ($v==="Dog")
         {
            return "Fido";
         }
         return $v;
      }

      $all=array("Horse","Dog","Cat");
      print_r(array_map("functions",$all));

      echo "<hr>";
      echo "<br />";
      echo "array_ksort<br />";
      $age=array("Peter"=>"35","Ben"=>"37","Joe"=>"43");
      ksort($age);
      foreach($age as $x=>$x_value)
      {
         echo "Key=" . $x . ", Value=" . $x_value;
         echo "<br>";
      }

      echo "<hr>";
      echo "<br />";
      echo "array_krsort<br />";
      $age=array("Peter"=>"35","Ben"=>"37","Joe"=>"43");
      krsort($age);

      foreach($age as $x=>$x_value)
      {
         echo "Key=" . $x . ", Value=" . $x_value;
         echo "<br>";
      }

      echo "<hr>";
      echo "<br />";
      echo "arary_search<br />";
      $a=array("a"=>"red","b"=>"green","c"=>"blue");
      echo array_search("red",$a);

      echo "<hr>";
      echo "<br />";
      echo "arary_shift<br />";
      $a4=array("a"=>"red","b"=>"green","c"=>"blue");
      echo array_shift($a4)."<br>";
      print_r ($a4);

      echo "<hr>";
      echo "<br />";
      echo "arary_slice<br />";
      $a5=array("red","green","blue","yellow","brown");
      print_r(array_slice($a5,2));

      echo "<hr>";
      echo "<br />";
      echo "arary_splice<br />";
      $a1=array("a"=>"red","b"=>"green","c"=>"blue","d"=>"yellow");
      $a2=array("a"=>"purple","b"=>"pink");
      array_splice($a1,0,2,$a2);
      //array_splice($a1,0,3);   
      print_r($a1);

       echo "<hr>";
      echo "<br />";
      echo "arary_sum<br />";
      $a=array("abc",15,25,"xyz");
      echo array_sum($a);

      echo "<hr>";
      echo "<br />";
      echo "arary_merge<br />";
      $a1=array("a"=>"red","1"=>"green");
      $a2=array("d"=>"blue","c"=>"yellow");
      print_r(array_merge($a2,$a1));

      echo "<hr>";
      echo "<br />";
      echo "arary_merge_recursive<br />";
      $a1=array("a"=>"red","b"=>"green");
      $a2=array("c"=>"blue","b"=>"yellow");
     
      print_r(array_merge_recursive($a1,$a2));
      print_r(array_merge_recursive($a1));

      echo "<hr>";
      echo "<br />";
      echo "array_multisort<br />";
      $a1=array("Dog","Dog","Cat");
      $a2=array("Pluto","Fido","Missy");
      array_multisort($a1,SORT_ASC,$a2,SORT_DESC);
      print_r($a1);
      print_r($a2);

      echo "<hr>";
      echo "<br />";
      echo "array_pad<br />";
      $a=array("red","green");
      print_r(array_pad($a,5,"blue"));
      print_r(array_pad($a,-5,"blue"));
      print_r(array_pad($a,2,"blue"));

      echo "<hr>";
      echo "<br />";
      echo "array_pop <br />";
      $a=array("red","green","pink","d"=>"blue");
      array_pop($a);
      print_r($a);
	?>

</body>
</html>

