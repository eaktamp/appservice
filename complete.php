<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include "config/web_con.php";
include "config/func.class.php";
$cid             = $_SESSION['cid'];
$token_check     = $_GET['token_check'];
$oapp_id     = $_GET['oapp_id'];
?>
<?php if (isset($_SESSION['cid']) == "" || isset($_SESSION['hn']) == null) {
        echo "<script>window.location ='checkdata.php';</script>";
} ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/radio.css">
</head>
<?php
$searchuser = " SELECT  * 
FROM web_data_appoint as a  
INNER JOIN web_data_patient as b ON a.cid = b.cid
WHERE 1 = 1
AND a.cid = '".$cid."' 
AND a.oapp_id = '".$oapp_id."' ";
$query = mysqli_query($conf,$searchuser);
$row_result = mysqli_fetch_array($query);
//echo $searchuser;
?>
<body>
    <div class="uk-container uk-padding">
        <h2><img src="img/iconsend.jpg" class="iimg">ทำรายการสำเร็จ เลขที่ OrderNo. <B><?php echo $row_result['oapp_id'];?></B></h2>
        <center><span class="fon">บันทึกรายการเมื่อวันที่ <?php echo thaiDateFULL($row_result['cdate'])." เวลา ".$row_result['ctime']." น.";?></span></center>
        <hr>
        <h3 class="fon">ข้อมูลที่ลงทะเบียนและที่อยู่ ในการจัดส่งยาทางไปรษณีย์</h3>
        <div class="">
            <div class="hh2 fon"><span class="fon">คุณ</span><?php echo $row_result['fname']."  ".$row_result['lname']." ( HN : ".$row_result['hn']." )";?></div>
            <div class="hh2 fon"><span class="fon">เบอร์โทรศัพท์ </span><?php echo $row_result['phone']; ?></div>
            <hr>
            <div class="hh2 fon"><span class="fon">วันที่ </span><span class=""><?php echo thaiDateFULL($row_result['date_appoint']);?></span></div>
            <div class="hh2 fon"><span class=""></span><?php echo $row_result['clinic_appoint'];?></div>
            <div class="hh2 fon"><span class=""></span><?php echo $row_result['doctor_appoint'];?></div>
            <hr>

            <div class="hh2 fon"><?php echo " เลขที่ ".$row_result['adddess']." หมู่ ".$row_result['moo'];?></div>
            <div class="hh2 fon"><?php echo " ตำบล".$row_result['district']." อำเภอ".$row_result['amphoe'];?>
            <div class="hh2 fon"><?php echo " จังหวัด".$row_result['province']." ".$row_result['zipcode'];?></div>
        </div>
        <a href="logout.php"><< กลับหน้าแรก</a>
    </div>
<!--    <hr>
    <center><span class="fon">ติดต่อสอบถามข้อมูลเพิ่มเติมได้ที่ Line@ </span></center>
  <center><span class="fon"><img src="img/lineadd.jpg" width="150px" height="150px;"> </span></center> 
-->
</body>
</html>