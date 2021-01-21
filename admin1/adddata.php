<?php
date_default_timezone_set("Asia/Bangkok");
include("../config/web_con.php");
include "../config/func.class.php";
session_start();
if (isset($_SESSION['username']) == "" || isset($_SESSION['username']) == null) {
  echo "<script>window.location ='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ตรวจสอบ</title>
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

  <!-- JavaScript alerttify-->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <!-- alerttify CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <!-- alerttify Default theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
  <!-- alerttify Semantic UI theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>

  
  <!-- jquery.Thailand.js -->
  <link rel="stylesheet" href="../jquery.Thailand.js/dist/jquery.Thailand.min.css">

</head>

<body class="hold-transition sidebar-mini">
<?php 
  
  ///////////////////////////////////// เมื่อกดรับงาน ส่ง POST เข้ามาทำงาน //////////////////////////////// 
if (isset($_POST['NeedGetMedicine'])) { //หากกดยืนยันรับงาน 

  $_SESSION['username'];
  mysqli_set_charset($conf, "utf8");

  $updatestatus = "UPDATE `web_data_appoint` SET 
  `confirm_drugs` = 'Y', 
  `admin_checkConfirm` = '" . $_SESSION['qfname'].' '.$_SESSION['qlname'] . "' WHERE oapp_id = '" .  $_POST['oapp_id']. "'";
  $Queryaddadminjob =  mysqli_query($conf, $updatestatus);
  if ($Queryaddadminjob) {
        $_POST['oapp_id'] = '';
        $_SESSION['statusinsert'] = 1;
        header('location:./index.php');
        exit(0);
  }else{
    echo "<script>alertify.error('บันทึกไม่สำเร็จ');</script>";
  }
}
if($_SESSION['statusinsert'] == 1){
  echo "<script>alertify.success('บันทึกสำเร็จ');</script>";
  $_SESSION['statusinsert'] = 0;//กำหนดให้ค่าเป็น 0 
  unset($_SESSION['statusinsert']);//ยกเลิกการใช้งาน session ตัวเช็คสถานะการบันทึกออก
}
?>

  <div class="wrapper">
    <?php include "navbarleft.php"?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>เพิ่มข้อมูล</h1>
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

              <!-- <div class="card">
                <div class="card-header">
    
                    div class="col-12">
                      <form name="form1" class="form-horizontal" action="#" method="POST">
                          <div class="form-group row">
                              <div class="col-8 col-lg-10">
                                <input type="text" class="form-control" name="cid" value="" maxlength="13"  placeholder="ค้นหา" required />
                              </div>
                              <div class="col-4 col-lg-2">
                                <button class="btn btn-primary btn-block" type="submit"  name="submit" value="submit"> ค้นหา</button>
                              </div>
                            </div>
                      </form>
                    </div> -->
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                



<?php
                include '../config/web_con.php';
                if (isset($_POST['submit'])) {
                    $cidfromadmin = $_POST['cid'] ;
                    //echo strlen( $HnfromAdmin).'<br/>';
                    $numofcid = strlen( $cidfromadmin);
                    if(strlen( $cidfromadmin) < 9 ){
                      for($ins=0;$ins < 9 - strlen( $cidfromadmin) ;$ins++){
                             $numss[$ins] = '0';
                      }
                      //วนเอาค่าเลขในอาเรย์มาใช้
                      for($sum=0;$sum < sizeof($numss);$sum++ ){
                          $fillcid .= $numss[$sum]  ;
                      }
                         $realcid = $fillcid .=  $cidfromadmin;
                          $realcid;
                    }
                    else{
                        $realcid = $_POST['cid'];
                    }



                    $searchuser = " SELECT cid FROM patient_2 where  cid = '" .  $realcid . "'";
                    $have_user_yet = mysqli_query($conf, $searchuser);
                    $count = mysqli_num_rows($have_user_yet);
                    //echo $have_user_yet['cid'];

                    if ($count > 0) {
                        $accoutUsser = mysqli_fetch_assoc($have_user_yet);
                        $patientcid =  $accoutUsser['cid'];
                        echo "<script>alertify.warning('พบข้อมูล');</script>";


                        $checkinmysqlbase =  " SELECT * FROM web_data_patient where  cid = '" . $patientcid  . "' ORDER BY dateupdate limit 1";
                        $have_user_inmydb = mysqli_query($conf, $checkinmysqlbase);
                        $countcid = mysqli_num_rows($have_user_inmydb);
    
                        if ($countcid == 0) {
                            //echo ' <br/>' . 'is null data in mydb then check in pgsql on his hospital' . '<br/>';
                            $searchuser = " SELECT * FROM patient_2
                            WHERE cid = '" .$patientcid  . "'";
                            $have_user_yet = mysqli_query($conf, $searchuser);
                            $result = mysqli_fetch_assoc($have_user_yet);
                        } else {
                            //echo '<br/>' . 'is have data in mydb then show data in db' . '<br/>';
                            $result = mysqli_fetch_assoc($have_user_inmydb);
                        }
                        
                        //header('location:senddata.php');
                    } else {
                        echo "<script>alertify.error('ไม่พบข้อมูลผู้ป่วย');</script>";
                    }
                }
                ?>

                    <script>
                        (function(i, s, o, g, r, a, m) {
                            i['GoogleAnalyticsObject'] = r;
                            i[r] = i[r] || function() {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                            a.async = 1;
                            a.src = g;
                            m.parentNode.insertBefore(a, m)
                        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                        ga('create', 'UA-33058582-1', 'auto', {
                            'name': 'Main'
                        });
                        ga('Main.send', 'event', 'jquery.Thailand.js', 'GitHub', 'Visit');
                    </script>







                    <hr>
                    <div id="loader">
                        <div uk-spinner></div> รอสักครู่ กำลังโหลดฐานข้อมูล...
                    </div>

                    <form id="senddata" class="demo" style="display:none;" autocomplete="off"  method="post" target="_blank " action="insert_2.php">
                        <input type="hidden"  name="cid" value="<?php echo $result['cid'] ?>">
                        <input type="hidden" name="cid" value="<?php echo $result['cid'] ?>">
                        
                      <div class="row">
                        <div class="col-6"> 
                            <label ><i class="fas fa-male"></i>  ชื่อ </label>
                            <input name="fname" class="form-control" type="text" value="<?php echo $result['fname'] ?>" required>
                          </div>

                        <!--   <div class="col-6"> 
                            <label ><i class="fas fa-male"></i>  เลขบัตรประจำตัวประชาชน 13 หลัก </label>
                            <input name="cid" class="form-control" type="text" value="<?php echo $result['cid'] ?>">
                          </div> -->

                        <div class="col-6">
                        <label >นามสกุล</label>
                            <input name="lname" class="form-control" type="text" value="<?php echo $result['lname'] ?>" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-4">
                            <label ><i class="fas fa-phone-square"></i>  เบอร์โทรศัพท์ </label>
                            <input name="phone" class="form-control" type="text" value="<?php echo $result['phone'] ?>" required>
                        </div>
                       <!--  <div class="col-4">
                            <label ><i class="fas fa-user-md"></i>  สิทธิ์</label>
                            <input name="pttype" class="form-control" type="text" value="<?php echo $result['pttype'] ?>">
                        </div> -->
                        <!-- <div class="col-4">
                            <label ><i class="fab fa-line"></i>  LINE ID:</label>
                            <input name="lineid" class="form-control" type="text">
                        </div> -->
                      </div>

                      <div class="row">
                        <div class="col-lg-3">
                            <label ><i class="fas fa-address-book"></i> บ้านเลขที่</label>
                            <input name="adddess" class="form-control" type="text" value="<?php echo $result['adddess'] ?>" required>
                        </div>
                        <div class="col-lg-3">
                            <label ><i class="fas fa-address-book"></i> หมู่</label>
                            <input name="moo" class="form-control" type="text" value="<?php echo $result['moo'] ?>">

                        </div>
                        <div class="col-lg-3">  
                            <label ><i class="fas fa-address-book"></i> ตำบล / แขวง</label>
                            <input name="district" class="form-control" type="text" value="<?php echo $result['district'] ?>" required>
                        </div>
                        <div class="col-lg-3">
                          
                        <label ><i class="fas fa-address-book"></i> อำเภอ / เขต</label>
                            <input name="amphoe" class="form-control" type="text" value="<?php echo $result['amphoe'] ?>" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                            <label ><i class="fas fa-address-book"></i> จังหวัด</label>
                            <input name="province" class="form-control" type="text" value="<?php echo $result['province'] ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <label ><i class="fas fa-address-book"></i>  รหัสไปรษณีย์</label>
                            <input name="zipcode" class="form-control" type="text" value="<?php echo trim($result['zipcode'])?>" required>
                        </div>
                      </div>
                      <button class="btn btn-block btn-success mt-3" id="send" name="send" ><span> พิมพ์เอกสาร </span></button>
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

    <script type="text/javascript" src="../jquery.Thailand.js/dependencies/zip.js/zip.js"></script>
    <script type="text/javascript" src="../jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="../jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <script type="text/javascript" src="../jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
    <script type="text/javascript">
        $.Thailand({
            database: '../jquery.Thailand.js/database/db.json',
            $district: $('#senddata [name="district"]'),
            $amphoe: $('#senddata [name="amphoe"]'),
            $province: $('#senddata [name="province"]'),
            $zipcode: $('#senddata [name="zipcode"]'),
            onDataFill: function(data) {
                console.info('Data Filled', data);
            },
            onLoad: function() {
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });
        $('#senddata [name="district"]').change(function() {
            console.log('ตำบล', this.value);
        });
        $('#senddata [name="amphoe"]').change(function() {
            console.log('อำเภอ', this.value);
        });
        $('#senddata [name="province"]').change(function() {
            console.log('จังหวัด', this.value);
        });
        $('#senddata [name="zipcode"]').change(function() {
            console.log('รหัสไปรษณีย์', this.value);
        });
    </script>
</body>

</html>
