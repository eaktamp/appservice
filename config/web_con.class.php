<?php
 function sql_con(){
   $pdo =  new PDO('mysql:host=163.44.198.57;dbname=cp187623_cv19db', 'cp187623_webcv19', '#Jhosxp10665!', 
 		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 	return $pdo;
 }
 
/*
$host= "localhost" ;
$userr="web";
$pwd= "@HAbhai#infor|10665!" ;
$dbname="complaint";
$obj_con = mysqli_connect($host,$userr,$pwd,$dbname);
	mysqli_set_charset($obj_con,"utf8");
if(!$obj_con)  {
          echo  "<h3> ERROR  :  ERROR CONNECT DATABASE</h3>" ;
          exit ();
}
*/
?>
