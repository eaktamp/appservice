<?php
$host= "172.16.0.251" ;
$userr="report";
$pwd= "report" ;
//$host= "localhost" ;
//$userr="web";
//$pwd= "@HAbhai#infor|10665!" ;
$dbname="cv19db";
//$dbname="complaint";
$obj_con = mysqli_connect($host,$userr,$pwd,$dbname);
	mysqli_set_charset($obj_con,"utf8");
if(!$obj_con)  {
          echo  "<h3> ERROR  :  ERROR CONNECT DATABASE</h3>" ;
          exit ();
}
?>