<?php 
if(empty($_SESSION))
	session_start();
if(!isset($_SESSION['qnamelogin'])) { 
	header("Location: login.html");
	exit;
}
$id   = $_SESSION["id"];
$gtx  = MD5(DATE('YmdHis'));
date_default_timezone_set("Asia/Bangkok");
include("class.con.php"); 
$log = " SELECT a.*,b.agegroup as agep ,c.name as mgroup
FROM covid_data as a
left JOIN covid_age as b ON a.agep = b.id
left JOIN covid_dep as c ON a.mgroup = c.id
GROUP BY fname,lname,tel,dep
ORDER BY a.id DESC ";
$query = mysqli_query($obj_con,$log);

$covidc = " SELECT 'ระดับ 5 - 6 คะแนน ' as lie,count(*) as ca
FROM (SELECT b.agegroup as agep ,c.name as mgroup
FROM covid_data as a
left JOIN covid_age as b ON a.agep = b.id
left JOIN covid_dep as c ON a.mgroup = c.id
WHERE a.score = '1'
GROUP BY fname,lname,tel,dep) as aaa ";
$c_c = mysqli_query($obj_con,$covidc);
$row_c = mysqli_fetch_array($c_c);

$covidd = " SELECT 'ระดับ 7 - 11 คะแนน ' as lie,count(*) as ca
FROM (SELECT b.agegroup as agep ,c.name as mgroup
FROM covid_data as a
left JOIN covid_age as b ON a.agep = b.id
left JOIN covid_dep as c ON a.mgroup = c.id
WHERE a.score = '2'
GROUP BY fname,lname,tel,dep) as aaa ";
$c_d = mysqli_query($obj_con,$covidd);
$row_d = mysqli_fetch_array($c_d);

$covidf = " SELECT  'ระดับ มากกว่า 12 คะแนน ' as lie,count(*) as ca 
FROM (SELECT b.agegroup as agep ,c.name as mgroup
FROM covid_data as a
left JOIN covid_age as b ON a.agep = b.id
left JOIN covid_dep as c ON a.mgroup = c.id
WHERE a.score = '3'
GROUP BY fname,lname,tel,dep) as aaa ";
$c_f = mysqli_query($obj_con,$covidf);
$row_f = mysqli_fetch_array($c_f);

$covids = " SELECT COUNT(*) as ca
FROM (SELECT b.agegroup as agep ,c.name as mgroup
FROM covid_data as a
left JOIN covid_age as b ON a.agep = b.id
left JOIN covid_dep as c ON a.mgroup = c.id
GROUP BY fname,lname,tel,dep) as aaa ";
$c_s = mysqli_query($obj_con,$covids);
$row_s = mysqli_fetch_array($c_s);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Covid19 Quest</title>
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
	<div class="cont">
		<div class="headadmin"><i class="fas fa-temperature-high"></i>&nbsp;ข้อมูลการคัดกรองความกังวลต่อไวรัส COVID-19 &nbsp;<i class="fab fa-angellist"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="82e97907336e0c412051d2c585e1914a.php?checksum?<?=$gtx.$gtx.$gtx.$gtx.$gtx.$gtx.$gtx.$gtx;?>?=???" target="">
				<span class="fiter" title="คลิกดูรายการสรุป"><i class="fas fa-lungs-virus"></i>&nbsp;&nbsp;ข้อมูลคัดกรอง&nbsp;&nbsp;</span>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="" class="aa" title="จำนวน <?php echo number_format($row_c['ca'],0);?> รายการ">
				<?php echo "<i class='fas fa-pump-medical'></i>&nbsp;".$row_c['lie']."&nbsp;[&nbsp;".number_format($row_c['ca'],0)."&nbsp;]"; ?>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="" class="bb" title="จำนวน <?php echo number_format($row_d['ca'],0);?> รายการ">
				<?php echo "<i class='fas fa-head-side-virus'></i>&nbsp;".$row_d['lie']."&nbsp;[&nbsp;".number_format($row_d['ca'],0)."&nbsp;]"; ?>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="" class="cc" title="จำนวน <?php echo number_format($row_f['ca'],0);?> รายการ">
				<?php echo "<i class='fas fa-head-side-cough'></i>&nbsp;".$row_f['lie']."&nbsp;[&nbsp;".number_format($row_f['ca'],0)."&nbsp;]"; ?>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="" class="dd" title="จำนวนรวม <?php echo number_format($row_s['ca'],0);?> รายการ">
				<?php echo "<i class='fas fa-hand-holding-water'></i>&nbsp;Total&nbsp;&nbsp;[&nbsp;".number_format($row_s['ca'],0)."&nbsp;]"; ?>
			</a>&nbsp;&nbsp;&nbsp;&nbsp;

					<a href="logout.php" class="logi" title="ออกจากระบบทุกครั้งที่ใช้งาน"><i class="fas fa-charging-station"></i>&nbsp;LOGOUT</a></div>
					<table id="exampleTable" class="table table-hover ">	
						<thead class="thead-dark">
							<tr class="">
								<th class="thh" title="ลำดับรายการ"><i class="fas fa-virus"></i></th>
								<th class="thh" title="วันที่กรอกแบบประเมิน">วันที่</th>
								<th class="thh" title="ชื่อสกุลผู้กรอกแบบประเมิน">ชื่อ-สกุล</th>
								<th class="thh" title="เบอร์ติดต่อผู้กรอกแบบประเมิน">เบอร์โทรศัพท์</th>
								<th class="thh" title="กลุ่มงานผู้กรอกแบบประเมิน">กลุ่มงาน</th>
								<th class="thh" title="กลุ่มภารกิจผู้กรอกแบบประเมิน">กลุ่มภารกิจ</th>
								<th class="thh" title="ช่วงอายุผู้กรอกแบบประเมิน">ช่วงอายุ</th>
								<th class="thh" title="ท่านรู้สึกกังวล ไม่สบายใจกับการที่ต้องออกไปนอกบ้าน">Q1</th>
								<th class="thh" title="ท่านรู้สึกกังวลกับการเตรียมตัวเพื่อป้องกันการติดไวรัส COVID-19 เช่น กักตุนอาหาร,หน้ากาก เป็นต้น">Q2</th>
								<th class="thh" title="ท่านนอนไม่หลับ/หรือมีปัญหาการนอน เพราะคิดเกี่ยวกับไวรัส COVID-19">Q3</th>
								<th class="thh" title="ท่านคิดว่า ไวรัส COVID-19 ส่งผลต่อการดำเนินชีวิตประจำวันของท่าน">Q4</th>
								<th class="thh" title="ท่านคิดว่าท่านมีโอกาสติดเชื้อไวรัส COVID-19 มากเพียงใด">Q5</th>
								<th class="thh" title="ระดับการประเมิน">ระดับ</th>
								<th class="thh" title="คะแนนรวม">รวม</th>
								<th class="thh" title="สถานะ"><i class="fas fa-hand-holding-water"></i></th>
								<th class="thh" title="เวลาในการส่งแบบประเมิน">เวลา</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$rw=0;
							while($row_result = mysqli_fetch_array($query)) 
							{ 
								$rw++;
								?>

								<tr class="rr">
									<td class="cen"><?php echo $rw; ?></td>
									<td><?php echo $row_result['cdate']; ?></td>
									<td><?php echo $row_result['fname']." ".$row_result['lname']; ?></td>
									<td><?php echo $row_result['tel']; ?></td>
									<td><?php echo $row_result['dep']; ?></td>
									<td class=""><?php echo $row_result['mgroup']; ?></td>
									<td class=""><?php echo $row_result['agep']; ?></td>
									<td class="cen"><?php echo $row_result['covid1']; ?></td>
									<td class="cen"><?php echo $row_result['covid2']; ?></td>
									<td class="cen"><?php echo $row_result['covid3']; ?></td>
									<td class="cen"><?php echo $row_result['covid4']; ?></td>
									<td class="cen"><?php echo $row_result['covid5']; ?></td>
									<td class=" summ cen">
										<?php 
										$csum = $row_result['covidsum'];				
										if ($csum < "7") {
											$csum =  "<span class='xx'> 5 - 6 </span>";
										} elseif ($csum > "6" && $csum < "12" ) {
											$csum = "<span class='yy'> 7 - 11 </span>";
										} elseif ($csum > "11") {
											$csum = "<span class='zz'> > 12 </span>";
										}
										echo $score = $csum;
										?>
									</td>
									<td class="total cen"><?php //echo $row_result['covidsum']; ?>
										

										<?php 
										$csumx = $row_result['covidsum'];				
										if ($csumx < "7") {
											$csumx =  "<span class='xx'>".$csumx."</span>";
										} elseif ($csumx > "6" && $csumx < "12" ) {
											$csumx = "<span class='yy'>".$csumx."</span>";
										} elseif ($csumx > "11") {
											$csumx = "<span class='zz'>".$csumx."</span>";
										}
										echo $scorex = $csumx;
										?>
									</td>

									<td class="cen">
										<?php 
										$csum = $row_result['covidsum'];				
										if ($csum < "7") {
											$csum =  "<img class='st_img' src='images/34-512.png'>";
										} elseif ($csum > "6" && $csum < "12" ) {
											$csum = "<img class='st_img' src='images/z123.jpg'>";
										} elseif ($csum > "11") {
											$csum = "<img class='st_img' src='images/red_cross-512.png'>";
										}
										echo $score = $csum;
										?>
									</td>
									<td><?php echo $row_result['ctime']; ?></td>
								</tr>
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