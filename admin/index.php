<?php 
if(empty($_SESSION))
	session_start();
if(!isset($_SESSION['qnamelogin'])) { 
	header("Location: login.html");
	exit;
}
//$id   = $_SESSION["id"];
//$gtx  = MD5(DATE('YmdHis'));
date_default_timezone_set("Asia/Bangkok");
include("class.con.php"); 
$log = " SELECT * FROM web_data_patient WHERE 1 ";
$query = mysqli_query($obj_con,$log);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.js?"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap4.min.js"></script>
	<script src="css/dataTables.bootstrap4.min.css"></script>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link href="https://fonts.googleapis.com/css2?family=Sriracha&display=swap" rel="stylesheet">
	<link href="font/css/all.css" rel="stylesheet"> 
	<script defer src="font/js/all.js"></script>
	<link href="font/css/fontawesome.css" rel="stylesheet">
	<link href="font/css/brands.css" rel="stylesheet">
	<link href="font/css/solid.css" rel="stylesheet">
	<script defer src="font/js/brands.js"></script>
	<script defer src="font/js/solid.js"></script>
	<script defer src="font/js/fontawesome.js"></script>

</head>
<body>

	<div class="row">
		<div class="col-sm-12 headadmin">
			<i class="fas fa-temperature-high"></i>ข้อมูลการคัดกรองความกังวลต่อไวรัส COVID-19 <i class="fab fa-angellist"></i>
			<a href="logout.php" class="logi" title="ออกจากระบบทุกครั้งที่ใช้งาน">
				<i class="fas fa-charging-station"></i>LOGOUT</a>
			</div>
		</div>



		<div class="cont">
			<table id="exampleTable" class="table table-hover ">	
				<thead class="thead-dark">
					<tr class="">
						<th class="thh" title=""><i class="fas fa-virus"></i></th>
						<th class="thh" title="">วันที่ทำรายการ</th>
						<th class="thh" title="">OrderNumber</th>
						<th class="thh" title="">HN</th>
						<th class="thh" title="">ชื่อสกุล</th>
						<th class="thh" title="">เบอร์โทรศํพท์</th>
						<th class="thh" title="">สิทธิ์</th>
						<th class="thh" title="">ที่อยู่ในการจัดส่ง</th>
						<th class="thh" title="">วันที่นัด</th>
						<th class="thh" title="">คลินิก</th>
						<th class="thh" title="">แพทย์</th>
						<th class="thh" title="">สถานะ</th>
						<th class="thh" title="">test</th>
<!-- 								<th class="thh" title="">พิมพ์ที่อยู่</th>
								<th class="thh" title="">Q4</th>
								<th class="thh" title="">Q5</th>
								<th class="thh" title="">ระดับ</th>
								<th class="thh" title="">รวม</th>
								<th class="thh" title=""><i class="fas fa-hand-holding-water"></i></th>
								<th class="thh" title="">เวลา</th> -->
							</tr>
						</thead>
						<tbody>
							<?php
							$rw=0;
							while($row_result = mysqli_fetch_array($query)) 
							{ 
								$rw++;
								?>

<!-- hn
fname
lname
cid
lineid
qcode
keycode
modify

flage
fileimg -->


<tr class="rr">
	<td class="cen"><?php echo $rw; ?></td>
	<td><?php echo $row_result['dateupdate']; ?></td>
	<td><?php echo $row_result['order_number_check']; ?></td>
	<td><?php echo $row_result['hn']; ?></td>
	<td><?php echo $row_result['fname']." ".$row_result['lname']; ?></td>
	<td class=""><?php echo $row_result['phone']; ?></td>
	<td><?php echo $row_result['pttype']; ?></td>
	<td class=""><?php echo $row_result['adddess']." ม.".$row_result['moo']." ต.".$row_result['district']." อ.".$row_result['amphoe']." จ.".$row_result['province']." ".$row_result['zipcode']; ?></td>
	<td class=""><?php echo $row_result['appdate']; ?></td>
	<td class=""><?php echo $row_result['appclinic']; ?></td>
	<td class=""><?php echo $row_result['appdoctor']; ?></td>
	<td class=""><a href="#" data-toggle="modal" data-target="#myModal">รอตรวจสอบ</a></td>


									<!-- <td class="cen"><?php //echo $row_result['covid3']; ?></td>
									<td class="cen"><?php //echo $row_result['covid4']; ?></td>
									<td class="cen"><?php //echo $row_result['covid5']; ?></td> -->
									<!-- <td class=" summ cen">
										<?php 
										// $csum = $row_result['covidsum'];				
										// if ($csum < "7") {
										// 	$csum =  "<span class='xx'> 5 - 6 </span>";
										// } elseif ($csum > "6" && $csum < "12" ) {
										// 	$csum = "<span class='yy'> 7 - 11 </span>";
										// } elseif ($csum > "11") {
										// 	$csum = "<span class='zz'> > 12 </span>";
										// }
										// echo $score = $csum;
										?>
									</td>
									<td class="total cen"><?php //echo $row_result['covidsum']; ?>
										

										<?php 
										// $csumx = $row_result['covidsum'];				
										// if ($csumx < "7") {
										// 	$csumx =  "<span class='xx'>".$csumx."</span>";
										// } elseif ($csumx > "6" && $csumx < "12" ) {
										// 	$csumx = "<span class='yy'>".$csumx."</span>";
										// } elseif ($csumx > "11") {
										// 	$csumx = "<span class='zz'>".$csumx."</span>";
										// }
										// echo $scorex = $csumx;
										?>
									</td>

									<td class="cen">
										<?php 
										// $csum = $row_result['covidsum'];				
										// if ($csum < "7") {
										// 	$csum =  "<img class='st_img' src='images/34-512.png'>";
										// } elseif ($csum > "6" && $csum < "12" ) {
										// 	$csum = "<img class='st_img' src='images/z123.jpg'>";
										// } elseif ($csum > "11") {
										// 	$csum = "<img class='st_img' src='images/red_cross-512.png'>";
										// }
										// echo $score = $csum;
										?>
									</td>
									<td><?php// echo $row_result['ctime']; ?></td> -->
								</tr>
								<!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p><?php echo $row_result['hn']; ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<?php
}
?>	
</tbody>
</table>
</div>
<script>
	$(document).ready(function() {
		$('#exampleTable').DataTable();
	} );
</script>
</body>
</html>