<?php
date_default_timezone_set("Asia/Bangkok");
include ("../config/web_con.php");
include "../config/func.class.php";
session_start();
if (isset($_SESSION['username']) == "" || isset($_SESSION['username']) == null) {
  echo "<script>window.location ='login.php';</script>";
}


//echo   $_SESSION['statusinsert'];
?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>หน้าแรก</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  
  <link rel="stylesheet" type="text/css" href="css/radio.css">

  <!-- JavaScript alerttify-->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <!-- alerttify CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <!-- alerttify Default theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
  <!-- alerttify Semantic UI theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
</head>


<?php
        $hn = $_GET['hn'];
        $checkAp = "SELECT * FROM web_data_appoint  where hn ='$hn' and date_appoint > CURRENT_DATE ORDER BY date_appoint";
        $queryCheckAp = mysqli_query($conf,$checkAp);
        $oppid_check = mysqli_query($conf,$checkAp);
        $rowc        = mysqli_num_rows($oppid_check);


        $sql = " SELECT * FROM oapp WHERE hn = '$hn' ";
        if ($rowc > 0) {
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
        if($countdata < 1 ){$checkbutton = 1;}
        if($countdata > 1 ){$checkbutton = 0;}
        //echo $sql;
?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include "navbarleft.php"?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>รายการข้อมูลนัดของ HN : <?php echo  $hn;?> </h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        $log = " SELECT * FROM web_data_patient where hn in (select hn from web_data_appoint where date_appoint > CURRENT_DATE GROUP BY hn) ";
        $query = mysqli_query($conf, $log);
        ?>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"> เลือกรายการส่งยาไปรษณีย์</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="uk-container uk-padding">
                        <?php
                        //ทดสอบเช็คหากมีการกดไปแล้วให้ไม่แสดง
                        $i = 0;
                        while ($row_result22 = mysqli_fetch_array($queryCheckAp)) {
                            $i++;
                            $date_appoint[$i]   = $row_result22['date_appoint'];
                            $clinic_appoint[$i] = $row_result22['clinic_appoint'];
                            $doctor_appoint[$i] = $row_result22['doctor_appoint'];
                            //echo '<br>data ['.$i.'] '.$date_appoint[$i].' '.$clinic_appoint[$i].' '.$doctor_appoint[$i];
                        }
                        ?>

                        <form id="save" class="" autocomplete=""  method="POST" action="#">
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
                                $app_cause  =  $row_result['app_cause'];
                                $vn  =  $row_result['vn'];

                                $dateapp .' '. $date_appoint[$rw];
                                //if($dateapp != $date_appoint[$rw] &&  $clinic !=   $clinic_appoint[$rw] && $doctor !=  $doctor_appoint[$rw]   ){//echo 'ยังไม่มีกดติก'; ?>
                                <div class="" >
                                    <div>
                                        <input type="radio" id="<?= $rw; ?>" name="dateapp" value="<?php echo $dateapp."|".$clinic."|".$doctor."|".$hn."|".$cid."|".$oapp_id."|".$vn."|".$app_cause;?>" required>
                                        <label for="<?= $rw; ?>">
                                            <h2 class="hh2"><?php echo thaiDateFULL($row_result['dateapp']); ?></h2>
                                            <p class="p2"><?php echo $row_result['vn']; ?></p>                       
                                            <p class="p1"><?php echo $row_result['clinic']; ?></p>
                                            <p class="p2"><?php echo $row_result['doctor']; ?></p>                                       
                                            <p class="p2"><?php echo $row_result['app_cause']; ?></p>
                                        </label>
                                    </div>
                                </div>
                                <br> 
                            <?php  }// } ?>
                            <?php
                            if ($countdata < 1) {
                                echo "<center><h1>ไม่พบรายการนัดหมาย/ยืนยันรับยาครบแล้ว !!</h1><hr/></center>";
                            }
                            ?>
                            <div>
                                <div class="row">
                                    <div class="col-3"></div>
                                    <div class="col-3"> <center><button type="submit" class="btn btn-block btn-primary" id="submit" name="submit" value="submit" style="vertical-align:middle;font-size:16px" <?php if($countdata < 1) { echo 'disabled';}?>><span> ยืนยันรายการ </span></button> </center></div>
                                    <div class="col-3"> <center><button type="button" class="btn btn-block btn-secondary" onclick="window.location.href='confirmhn.php'" style="vertical-align:middle;font-size:16px;">ยกเลิก</button> </center></div>   
                                    <div class="col-3"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <?php
     if(isset($_POST['submit'])){
         date_default_timezone_set("Asia/Bangkok");
         include("../config/web_con.php");
         $token_check = mt_rand(100, 999) . mt_rand(100, 999);
          echo 'hello';
         //เอาค่าที่รับมาจาก radio มา suustring แต่ละตัวที่ขั้นด้วย | เก็บไว้ในตัวแปร data เป็น array แต่ละช่อง
         $string = $_POST['dateapp'];//ประกาษเก็บค่าที่รับมา
         $arrposition = strpos($string, "|");//หาตำแหน่งแรกที่เป็นตัว | จากโจทย์จะได้เป็น 10
         $arrpositionSub =   $string;// เก็บค่าตัวแปรไว้วนเปลี่ยนแปลงค่าตาม forloop
         for ($i = 0; $i <= 7; $i++) {//วนรอบเก็บค่าค่าที่ส่งมามี4แถว
             if ($arrposition != 0) {//เมื่อค่าแรกไม่ใช่ 0 ซึ่งปกติจะเป็ฯ 10 เสมอ | หลังวันที่ เช่น 2020-06-01| จะเป็นตัวที่ 11
             $data[$i] = substr($arrpositionSub, 0, $arrposition); //ตัดเอคำที่อย่หน้า | ในรอบแรกมาเก็บในdata
             $arrpositionSub = substr($arrpositionSub,$arrposition+1, 1000000);// เอาตัวแปร arrpositionSub รับค่าที่ตัดออกมาตัวแรก โดย arrpositionSub = ค่าstring ที่รับมาจากหน้าแรก ตัดส่วนแรกซึ่งคือวันที่ออกไป
             }
             if($arrposition == 0){ $data[7] = $arrpositionSub;}//รอบสุดท้ายค่า cid มันจะไม่มี | จึงเป็น0 เช็คเก็บแบบธรรมดาเลย
             $arrposition = strpos($arrpositionSub, "|").'<br>';//ทำงานครบให้ค่าตำแหน่งที่จะตัดเปลี่ยนไปตามค่าล่าสุด
             echo '<center>this is arr ['.$i.'] '.$data[$i] . '</center><br>';//แสดงผลค่าในอาเรย์ที่เก็บ
         }

         $date_appoint   = $data[0];
         $clinic_appoint = $data[1];
         $doctor_appoint = trim($data[2]);
         $doctor_appoint  = str_replace("  "," ",$doctor_appoint);//เกิดปัญหาinsert ชื่อสกุลเป็น2เคาะ เจอ2เคาะให้เปลี่ยนเป็ฯเคาะเดียว
         $hn             = $data[3];
         $cid            = $data[4];
         $oapp_id        = $data[5]; // เพิ่ม oapp_id
         $vn             = $data[6]; // เพิ่ม oapp_id
         $app_cause      = $data[7]; // เพิ่ม oapp_id
         $app_status     = "1";
         $updatedate     = DATE('Y-m-d');
         $update_time    = DATE('H:i:s');
         //echo  $date_appoint . '<br/>' . $clinic_appoint . '<br/>' . $doctor_appoint . '<br>';

         $searchdata = " SELECT * FROM  web_data_appoint WHERE oapp_id = '$oapp_id' ";
         $check_have_data = mysqli_query($conf, $searchdata);
         $countrow = mysqli_num_rows($check_have_data);
         //echo   $searchdata.'<br>';

         if ($countrow <= 0) {
            $log = "INSERT INTO web_data_appoint (hn,cid,oapp_id,token_check,date_appoint,clinic_appoint,doctor_appoint,app_status,updatedate,update_time,vn,app_cause) 
                 VALUES ('$hn','$cid','$oapp_id','$token_check','$date_appoint','$clinic_appoint','$doctor_appoint','$app_status','$updatedate','$update_time','$vn','$app_cause')";
             $query = mysqli_query($conf, $log);
             //echo $log;
             //header("Location: complete.php?cid=$cid&token_check=$token_check");
             header("Location:app.php?hn=$hn");
             mysqli_close($conf);
         } else {
             echo "<script>javascript:alert('เคยบันทึกอนุมัติรายการนี้ไปแล้ว!');window.location='app.php';</script>";
         }
     }
    ?>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.5
      </div>
      <strong>Copyright &copy; 2020 <a href="http://cpa.go.th">cpa.go.th</a>.</strong>ข้อมูลที่อยู่ V.0.1
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="./plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./dist/js/demo.js"></script>
  <!-- page script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
      });
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  
</body>

</html>