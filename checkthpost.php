<!-- https://track.thailandpost.co.th/dashboard?trackNumber -->
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
<br>
<br>
<br>
<center><div class="hhh"><img src=".//img/thaipost.PNG" alt="" width="150px" hight="150px"></div></center>
<!-- <center><div class="hhh">ติดตามสถานะสิ่งของ</div></center> -->
    <div class="uk-container uk-padding">
        <form name="form1" style=" margin-top:15%;" action="#" method="POST">
            <div class="uk-width-1-2@m">
                <label class="h2"> รหัสประจำตัวประชาชน <i class="fas fa-address-card"></i></label>
                <input type="text" name="cid" value="" maxlength="13" minlength="13" placeholder="9999999999999" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" required />
            </div>
            <div class="uk-width-1-2@m">
                <label class="h2">รหัสประจำตัวผู้ป่วย (HN) </label>
                <input type="text" name="hn" value="" maxlength="9"  placeholder="โปรดกรอกเลขประจำตัวผู้ป่วย (HN)" onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลข'); this.value='';}" required />
            </div>
            <button class="button" type="submit" style="vertical-align:middle;font-size:16px;margin-top:20px" name="submit" value="submit"><span>ติดตาม</span></button>
        </form>
    </div>

    <?php
    include 'config/web_con.php';
    if (isset($_POST['submit'])) {
        $HnfromAdmin = $_POST['hn'] ;
        //echo strlen( $HnfromAdmin).'<br/>';
        $numofhn = strlen( $HnfromAdmin);
        if(strlen( $HnfromAdmin) < 9 ){
          for($ins=0;$ins < 9 - strlen( $HnfromAdmin) ;$ins++){
                 $numss[$ins] = '0';
          }
          //วนเอาค่าเลขในอาเรย์มาใช้
          for($sum=0;$sum < sizeof($numss);$sum++ ){
              $fillHn .= $numss[$sum]  ;
          }
             $realhn = $fillHn .=  $HnfromAdmin;
              $realhn;
        }
        else{
            $realhn = $_POST['hn'];
        }

        $searchuser = " SELECT hn,cid,GROUP_CONCAT(barcode) as bc FROM web_data_appoint where  hn = '" .  $realhn . "' and cid = '" . $_POST['cid'] . "'";
        $have_user_yet = mysqli_query($conf, $searchuser);
        $count = mysqli_num_rows($have_user_yet);
        $searchuser;
        if ($count > 0) {
        while ($accoutUsser = mysqli_fetch_assoc($have_user_yet)){
        $trackNumber       = $accoutUsser['bc'];
        }

            echo "<script>alertify.success('พบรายการ);</script>";
            header('location:https://track.thailandpost.co.th/dashboard?trackNumber='.$trackNumber.'&HelloWordAbhaihospitaldatacenterinformationCpa');
        } else {
            echo "<script>alertify.error('ไม่พบรายการ');</script>";
        }
    }
    ?>

      
</body>

</html>

<style>
    body {
        background: -webkit-linear-gradient(left, #0E6251, #1D8348);
        min-height: 96.9vh;
        padding: 15px;
        color: white;
    }
input:focus{
    border-radius: 0;
}
    input {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        height: 40px;
        vertical-align: middle;
        display: inline-block;
        line-height: 38px;
        /* border-radius: 25px; */
        padding: 20px;
    }
</style>