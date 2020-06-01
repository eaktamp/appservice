<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include "config/web_con.php";
include "config/func.class.php";
$cid    = $_SESSION['cid'];
$hn     = $_SESSION['hn'];
$searchuser = " SELECT  id,order_number_check,fname,lname,phone,lineid,adddess,cid,hn
moo,district,amphoe,province,zipcode,qcode,keycode,modify,status,flage,fileimg,dateupdate
FROM web_data_patient
WHERE hn = '$hn' ";
$query = mysqli_query($conf, $searchuser);
$row_result = mysqli_fetch_array($query);
?>

<?php if (isset($_SESSION['cid']) == "" || isset($_SESSION['hn']) == null) {
    echo "<script>window.location ='./checkdata.php';</script>";
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
$checkAp = "SELECT * FROM web_data_appoint  where hn ='$hn' and cid = '$cid' and date_appoint > CURRENT_DATE ORDER BY date_appoint";
$queryCheckAp = mysqli_query($conf,$checkAp);
$oppid_check = mysqli_query($conf,$checkAp);
$rowc        = mysqli_num_rows($oppid_check);


$sql = " SELECT * FROM oapp WHERE
hn = '$hn' ";
// AND o.oapp_id Not in ('1050932')";
  if ($rowc > 0) {
//if(sizeof($rowcount) > 0 ){
        $sql .= " AND oapp_id Not in (";
        while ($value = mysqli_fetch_array($oppid_check)) 
                {
                    $sql .="'" .$value['oapp_id']. "',";
                }
                    $sql = rtrim($sql,',');
                    $sql .= ") ";
                }
$sql .= " AND dateapp > CURRENT_DATE ";
//$sql .= " AND (( oapp_status_id < 4 ) OR oapp_status_id IS NULL ) "; 
$sql .= " ORDER BY dateapp ";
$result = mysqli_query($conf, $sql);
$countdata = mysqli_num_rows($result);//เช็คมีนัดไม่มีนัด
// echo $sql;
?>

<body>
    <div class="uk-container uk-padding">
 
        <h1> รายการนัด <sup>
                <h3>เลือกรายการส่งยาทางไปรษณีย์</h3>
            </sup></h1>
            <a href="logout.php"><< กลับหน้าแรก</a>
        <hr>

        <?php
        //ทดสอบเช็คหากมีการกดไปแล้วให้ไม่แสดง
        $i = 0;
          while ($row_result22 = mysqli_fetch_array($queryCheckAp)) {
            $i++;
            $date_appoint[$i]   = $row_result22['date_appoint'];
            $clinic_appoint[$i] = $row_result22['clinic_appoint'];
            $doctor_appoint[$i] = $row_result22['doctor_appoint'];

           // echo '<br>data ['.$i.'] '.$date_appoint[$i].' '.$clinic_appoint[$i].' '.$doctor_appoint[$i];
         }
        ?>
    
        <form id="save" class="" autocomplete="" uk-grid method="POST" action="save.php">
            <?php
            $rw = 0;
            while ($row_result = mysqli_fetch_array($result)) {
                $rw++;
                $dateapp  =  $row_result['dateapp'];
                $clinic   =  $row_result['clinic'];
                $doctor   =  $row_result['doctor'];
                $hn       =  $row_result['hn'];
                $cid      =  $row_result['cid'];
                $oapp_id  =  $row_result['oapp_id'];

                //echo $dateapp .' '. $date_appoint[$rw];
                if($dateapp!= $date_appoint[$rw] &&  $clinic !=   $clinic_appoint[$rw] && $doctor !=  $doctor_appoint[$rw]   ){//echo 'ยังไม่มีกดติก';
            ?>
                <div class="">
                    <div>
                        <input type="radio" id="<?= $rw; ?>" name="dateapp" value="<?php echo $dateapp."|".$clinic."|".$doctor."|".$hn."|".$cid."|".$oapp_id;?>" required>
                        <label for="<?= $rw; ?>">
                            <h2 class="hh2"><?php echo thaiDateFULL($row_result['dateapp']); ?></h2>
                            <p class="p1"><?php echo $row_result['clinic']; ?></p>
                            <p class="p2"><?php echo $row_result['doctor']; ?></p>
                        </label>
                    </div>
                </div>
                <br> 
            <?php  } } ?>
            <?php
            if ($countdata < 1) {
                echo "<center><h1>ไม่พบรายการนัดหมาย/ยืนยันรับยาครบแล้ว !!</h1><hr/></center>";
                $checkbutton = 1;
            }
            ?>

            <div>
                <?php if ($checkbutton == 1) { ?>
                    <center><input type="button" class="button1" onclick="window.location.href='./logout.php'" style="vertical-align:middle;font-size:16px;" value="กลับหน้าหลัก"></button> </center>
                <?php } else { ?>
                    <center><button type="submit" class="button" id="submit" name="submit" style="vertical-align:middle;font-size:16px"><span> ยืนยันรายการ </span></button> </center>
                <?php } ?>
              
            </div>
        </form>
    </div>
</body>

</html>

<style>
    .button1 {
        display: inline-block;
        border-radius: 4px;
        background-color: #f4511e;
        border: none;
        color: #FFFFFF;
        text-align: center;
        font-size: 28px;
        padding: 20px;
        width: 200px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 5px;
    }

    .button1:hover {
        background-color: #f4511e;
        color: black;

    }
</style>