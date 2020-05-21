<?php session_start();
ob_start();
date_default_timezone_set('asia/bangkok');
include("class.con.php"); 
	if(trim($_POST["txtUsername"]) == "")
	{
		exit();	
	}
	if(trim($_POST["txtPassword"]) == "")
	{
		exit();	
	}	
$user = $_POST["txtUsername"];
$pass = $_POST["txtPassword"];
$dt 				= date('Y-m-d H:i:s');
$ip   				= $_SERVER['REMOTE_ADDR'];
$pathlink 			= dirname($_SERVER['PHP_SELF']);
	$strSQL = "SELECT * FROM covid_qlogin WHERE qnamelogin = '".trim($_POST['txtUsername'])."' AND qpasslogin = '".trim(md5($_POST['txtPassword']))."'  ";
	$objQuery = mysqli_query($obj_con,$strSQL);
	$objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
	if($objResult)
	{
		$log = "INSERT INTO covid_logfile (dt,user ,pass ,flag,ip,pathlink) 
  				VALUES ('$dt','$user','xxxxxxx','YES','$ip','adminisdata')";
  		$query = mysqli_query($obj_con,$log);
  				  $_SESSION["qnamelogin"] 	= $objResult["qnamelogin"];
				  $_SESSION["qpasslogin"] 	= $objResult["qpasslogin"];
				  session_write_close();
				header("Location: index.php");
	}
	else
	{	
		$log = "INSERT INTO covid_logfile (dt,user,pass,flag,ip,pathlink ) 
  				VALUES ('$dt','$user','$pass','NO','$ip','login')";
  		$query = mysqli_query($obj_con,$log);
			header("Location: login.html");	
	}
	mysqli_close($obj_con);
?>