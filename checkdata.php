<?php
date_default_timezone_set("Asia/Bangkok");
function alphanumeric_rand($num_require=8) {
  $alphanumeric = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',0,1,2,3,4,5,6,7,8,9);
  if($num_require > sizeof($alphanumeric)){
    echo "Error alphanumeric_rand(\$num_require) : \$num_require must less than " . sizeof($alphanumeric) . ", $num_require given";
    return;
}
$rand_key = array_rand($alphanumeric , $num_require);
for($i=0;$i<sizeof($rand_key);$i++) $randomstring .= $alphanumeric[$rand_key[$i]];
  return $randomstring;
}
$rd = alphanumeric_rand(12);
$r5 = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ23456789'),0,5);
$fc = DATE('YmdHis');

$link = $rd.MD5($fc).$r5;

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet"> <!--load all styles -->
    <!-- include the script -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
</head>
<body>
    <div class="uk-container uk-padding">
        <form name="form1" style=" margin-top:15%;" action="#" method="POST">
            <div class="uk-width-1-2@m">
                <label class="h2"> รหัสประจำตัวประชาชน <i class="fas fa-address-card"></i></label>
                <input type="text"  name="cid" value="" maxlength="13" minlength="13" placeholder="9999999999999" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" required />
            </div>
            <div class="uk-width-1-2@m">
                <label class="h2">รหัสประจำตัวผู้ป่วย (HN) </label>
                <input type="text" name="hn" value="" maxlength="9" minlength="9" placeholder="123456789 ให้เติมเลข 0 จนครบ 9 หลัก" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" required />
            </div>
            <button class="button" type="submit" style="vertical-align:middle;font-size:16px;margin-top:20px" name="submit" value="submit"><span> ตรวจสอบ</span></button>
        </form>
    </div>

    <?php
    include 'config/web_con.php';
    if (isset($_POST['submit'])) {
        $searchuser = " SELECT hn,cid FROM patient where  hn = '" . $_POST['hn'] . "' and cid = '" . $_POST['cid'] . "'  ";
        $have_user_yet = mysqli_query($conf, $searchuser);
        $count = mysqli_num_rows($have_user_yet);
        //echo $have_user_yet['hn'];

        if ($count > 0) {
           // session_start();
            $accoutUsser = mysqli_fetch_assoc($have_user_yet);
            $_POST['hn']  =  $accoutUsser['hn'];
            //echo ' <br>';
            $_POST['cid'] = $accoutUsser['cid'];

            $hn  =  $_POST['hn'];
            $cid =  $_POST['cid'];

            /*echo $_POST['hn']  =  $accoutUsser['hn'];
            echo ' <br>';
            echo $_POST['cid'] = $accoutUsser['cid'];
            */
            //$password = $con->real_escape_string md5((md5($_POST['cid'])));//decode
            echo "<script>alertify.success('พบข้อมูล');</script>";
           // header('location:senddata.php');
            ?>
            <script type="text/javascript">
                window.location.href = "senddata.php?<?=$link;?>&cid=<?=$cid;?>&hn=<?=$hn;?>&<?=$link;?>";
            </script>
            <?php
        } else {
            echo "<script>alertify.error('ไม่พบข้อมูลผู้ป่วย');</script>";
        }
    }
    ?>


</body>

</html>

<style>
    body {
        background: -webkit-linear-gradient(left, #6a11cb, #2575fc);
        min-height: 96.9vh;
        padding: 15px;
        color: white;
    }
    input[type=text]:focus {
        border-radius: 0px;
    }
    input {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        height: 40px;
        vertical-align: middle;
        display: inline-block;
        line-height: 38px;
        border-radius: 25px;
        border: none;
        padding: 20px;
    }

</style>