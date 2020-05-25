<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include"config/pg_con.class.php";
include"config/my_con.class.php";
include"config/func.class.php";
$cid    = $_GET['cid'];
$hn     = $_GET['hn'];
$searchuser = " SELECT  id,order_number_check,fname,lname,phone,lineid,adddess,cid,hn
moo,district,amphoe,province,zipcode,qcode,keycode,modify,status,flage,fileimg,dateupdate
FROM web_data_patient
WHERE hn = '$hn' ";
$query = mysqli_query($con,$searchuser);
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
$sql = " SELECT  o.nextdate AS dateapp ,C.NAME AS clinic
,o.hn
,p.cid
,CAST ( concat ( P.pname, P.fname, '  ', P.lname ) AS VARCHAR ( 250 )) AS patientname
,d.NAME AS doctor 
,CONCAT(pp.pttype,' ',pp.name) as insptty
FROM oapp o
LEFT JOIN vn_stat v ON v.vn = o.vn
LEFT  JOIN patient P ON P.hn = o.hn 
LEFT  JOIN clinic C ON C.clinic = o.clinic
LEFT  JOIN doctor d ON d.code = o.doctor
LEFT  JOIN kskdepartment K ON K.depcode = o.depcode
LEFT JOIN pttype as pp ON pp.pttype = v.pttype  
WHERE   1 = 1
AND p.hn = '$hn'
 -- AND DATE(o.nextdate) <> '$da'
 -- AND C.NAME <> '$cc'
AND o.nextdate > CURRENT_DATE
AND (( o.oapp_status_id < 4 ) OR o.oapp_status_id IS NULL ) 
ORDER BY    o.nextdate";
$result = pg_query($conn, $sql);
$count = pg_fetch_row($result);
//echo 'sadsad'.$count;

?>
<body>
    <div class="uk-container uk-padding">
        <h1> รายการนัด  <sup><h3>เลือกรายการส่งยาทางไปรษณีย์</h3></sup></h1>
        <hr>

        <form id="save" class="" autocomplete="" uk-grid method="POST" action="save.php">
            <?php
            $rw=0;
            while($row_result = pg_fetch_array($result)) 
            { 
                $rw++;
                ?>
                <div class="">
                    <div>
                      <input type="radio" id="<?=$rw;?>"  name="dateapp" value="<?php echo $row_result['dateapp']; ?>">
                      <label for="<?=$rw;?>">
                        <h2 class="hh2"><?php echo thaiDateFULL($row_result['dateapp']); ?></h2>
                        <p class="p1"><?php echo $row_result['clinic']; ?></p>
                        <p class="p2"><?php echo $row_result['doctor'];?></p>
                    </label>
                </div>
            </div>
            <input type="hidden" id="<?=$rw;?>" name="clinic" value="<?php echo $row_result['clinic']; ?>">
            <input type="hidden" id="<?=$rw;?>" name="doctor" value="<?php echo $row_result['doctor'];?>">
            <input type="hidden" id="<?=$rw;?>" name="hn" value="<?php echo $row_result['hn']; ?>">
            <input type="hidden" id="<?=$rw;?>" name="cid" value="<?php echo $row_result['cid']; ?>">
            <br>
            <?php
        }
        ?>

        <div class="uk-width-1-2@m">
            <button class="button" id="submit" name="submit" style="vertical-align:middle;font-size:16px"><span> ยืนยันรายการ </span></button>
        </div>
    </form>
</div>
</body>
</html>