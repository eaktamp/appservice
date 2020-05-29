<?php
date_default_timezone_set("Asia/Bangkok");
include("../config/web_con.php");
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


  <!-- JavaScript alerttify-->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <!-- alerttify CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <!-- alerttify Default theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
  <!-- alerttify Semantic UI theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>

</head>

<body class="hold-transition sidebar-mini">
<?php 
  
  ///////////////////////////////////// เมื่อกดรับงาน ส่ง POST เข้ามาทำงาน //////////////////////////////// 
if (isset($_POST['NeedGetMedicine'])) { //หากกดยืนยันรับงาน 

  $_SESSION['username'];
  mysqli_set_charset($conf, "utf8");

  $updatestatus = "UPDATE `web_data_appoint` SET 
  `confirm_drugs` = 'Y', 
  `admin_checkConfirm` = '" .$_SESSION['username']. "' WHERE oapp_id = '" .  $_POST['oapp_id']. "'";
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
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">พบปัญหาแจ้ง 3148,3149</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
        <a href="../logout.php" class="nav-link">คุณ: <?php echo $_SESSION['qfname'].' '. $_SESSION['qlname'];?></a>
        </li>
        <li class="nav-item dropdown">
          <a href="../logout.php" class="nav-link">Logout</a>
        </li>
      </ul>
    </nav>

    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"  style="opacity: .8">
      <span class="brand-text font-weight-light">AdminPage</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  เมนู
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item ">
                  <a href="./index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>หน้าแรก</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./page/checkpayment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อมูลนัดส่งยาที่จ่ายเงินแล้ว</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./changepassword.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>เปลี่ยนรหัสผ่าน</p>
                  </a>
                </li>
              </ul>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ข้อมูลผู้ป่วยที่มีนัดหลังจากวันที่ <?php// echo date("Y/m/d") ;?></h1>
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
                  <h3 class="card-title">ตารางแสดงข้อมูลผู้ป่วยที่ผ่านการ verify ข้อมูลที่อยู่แล้วและมีรายการนัดหลังจากวันที่ <?php echo date("Y/m/d") ;?></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>HN</th>
                        <th>เลขบัตรประชาชน</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>สิทธิ</th>
                        <th>หมายเลขโทรศัพท์</th>
                        <th>LINE ID</th>
                        <th>ที่อยู่</th>
                        <th>ข้อมูลนัด</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $rw = 0;
                      while ($row_result = mysqli_fetch_array($query)) {
                        $rw++;  ?>
                        <tr>
                          <td><?php echo $row_result['hn'] ?></td>
                          <td><?php echo $row_result['cid'] ?></td>
                          <td><?php echo $row_result['fname'] . ' ' . $row_result['lname'] ?></td>
                          <td><?php echo $row_result['pttype'] ?></td>
                          <td><?php echo $row_result['phone'] ?></td>
                          <td><?php echo $row_result['lineid'] ?></td>
                          <td><?php echo $row_result['adddess'] . ' หมู่ ' . $row_result['moo'] . ' ' . $row_result['district'] . ' ' . $row_result['amphoe'] . ' ' . $row_result['province'] ?></td>
                          <td><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#appoint<?php echo $row_result['hn'];?>"><i class="fas fa-bars"></i></button></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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




    <!----------------------------------------------------- Modal----------------------------------------------------------------------------- -->
      <!--------------------------------------------------------------------------------------------------------------------------------------- -->
    <?php 
       $sql = " SELECT hn FROM web_data_appoint where date_appoint > CURRENT_DATE ORDER BY date_appoint DESC  ";
       $result1 = mysqli_query($conf, $sql);
       foreach ($result1 as $item) { $hn = $item['hn'];
    ?>
    <div class="modal fade bd-example-modal-lg" id="appoint<?php echo $item['hn']?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">ข้อมูลรายการนัด HN:<?php echo $item['hn']?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <!-- The time line -->
                <div class="timeline">
                  <!-- timeline time label -->
                  <?php $queryApp = " SELECT * FROM web_data_appoint where hn = '$hn' and oapp_id is not null and date_appoint > CURRENT_DATE ORDER BY date_appoint  limit 10 ";
                        $resultappoint = mysqli_query($conf, $queryApp);
                        foreach ($resultappoint as $Appointment) { ?>
                  <div class="time-label">
                    <span class="bg-green"><?php echo $Appointment['date_appoint']; ?></span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-clock bg-purple"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="fas fa-clock"></i><?php echo $Appointment['date_appoint']; ?></span>
                      <h3 class="timeline-header"><a href="#"> <?php echo $Appointment['clinic_appoint']; ?></a> </h3>

                      <div class="timeline-body">
                            <?php echo 'แพทย์ผู้นัด : '. $Appointment['doctor_appoint']; ?><br>
                            <form action="#" method="POST" name='NeedGetMedicine'>
                              <input type="hidden" name="oapp_id" value="<?= $Appointment['oapp_id'];?>">
                              <button type="submit" class="btn btn-primary" name="NeedGetMedicine" <?php if($Appointment['confirm_drugs'] !='') echo 'disabled';?>>
                                <i class="fas fa-check"></i>&nbsp; จ่ายเงินแล้ว </button>
                                <button type="button" class="btn btn-warning" name="NeedGetMedicine" ><i class="fas fa-print"></i>&nbsp; พิมพ์รายการนี้ </button>
                            </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <div>
                    <i class="fas fa-clock bg-gray"></i>
                  </div>
                  <!-- END timeline item -->
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger">Print ที่อยู่</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  <!----------------------------------------------------- END   Modal----------------------------------------------------------------------------- -->

 




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