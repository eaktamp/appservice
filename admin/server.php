<?php
$order_number_check = $_POST['order_number_check'];
$query= mysql_query("SELECT * FROM web_data_patient = '$order_number_check' ");
$return = mysql_fetch_array($query);
echo json_encode($return);
?>