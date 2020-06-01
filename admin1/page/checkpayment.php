<?php
date_default_timezone_set("Asia/Bangkok");
include("../../config/web_con.php");
include "../../config/func.class.php";
session_start();
if (isset($_SESSION['username']) == "" || isset($_SESSION['username']) == null) {
  echo "<script>window.location ='../login.php';</script>";
}
//echo   $_SESSION['statusinsert'];
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ตรวจสอบชำระเงิน</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
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
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"  style="opacity: .8">
      <span class="brand-text font-weight-light">ข้อมูลนัดที่จ่ายเงินแล้ว</span>
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
                  <a href="../index.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>หน้าแรก</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อมูลนัดส่งยาที่จ่ายเงินแล้ว</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../changepassword.php" class="nav-link">
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
                <h1>ข้อมูลนัดที่มีการชำระเงินแล้ว</h1>
                <form class="form-inline" method="POST" action="#">
                    วันที่นัด 
                    <input type="date" class="form-control" id="datepickers" name="datepickers" data-provide="datepicker" data-date-language="th" autocomplete="off" required >
                    ถึง 
                    <input type="date" class="form-control" id="datepickert" name="datepickert" data-provide="datepicker" data-date-language="th" autocomplete="off" required>
                   
                    <input type="radio" id="Y" name="payment" value="Y">
                    <label for="Y">ชำระเงินแล้ว</label><br>
                  <button type="submit" name="submit" class="btn btn-default" vaule = 'submit'>ตกลง</button>
              </form>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
 <!-- Main content -->
 <section class="content">
        <?php
          if(isset($_POST['datepickers'])) {
             //หากมีการเลือกวันที่และสถานะให้ใช้คิวรี่นี้
             $datepickers    = $_POST['datepickers'];
             $datepickert    = $_POST['datepickert'];
             $radiopayment   = $_POST['payment'];
             $log = "SELECT wp.hn,wp.cid,concat(fname,' ',lname)as patient,pttype,phone,lineid,adddess,moo,district,amphoe,province,zipcode,date_appoint,
             doctor_appoint,clinic_appoint,app_status as checkaddress,confirm_drugs as successpayment
             FROM web_data_patient wp 
             LEFT JOIN web_data_appoint  wa on wp.hn = wa.hn
             where  date_appoint BETWEEN {datepickers} AND {datepickert}  ";
              if(isset( $radiopayment)){
                  $log .= "AND confirm_drugs = "."'".$radiopayment."'";
              }
             $log .= " GROUP BY  wp.hn,wp.cid,patient,pttype,phone,lineid,adddess,moo,district,amphoe,province,zipcode,
             date_appoint,doctor_appoint,clinic_appoint,app_status,confirm_drugs
             ORDER BY date_appoint";

             if($datepickers != "--") {
              $log = str_replace("{datepickers}", "'$datepickers'", $log);
              $log = str_replace("{datepickert}", "'$datepickert'", $log);
            }
          }
          if($_POST['datepickers'] == '' || $_POST['datepickers']  = null){
          $log = "SELECT wp.hn,wp.cid,concat(fname,' ',lname)as patient,pttype,phone,lineid,adddess,moo,district,amphoe,province,zipcode,date_appoint,
          doctor_appoint,clinic_appoint,app_status as checkaddress,confirm_drugs as successpayment
          FROM web_data_patient wp 
          LEFT JOIN web_data_appoint  wa on wp.hn = wa.hn
          where  date_appoint is not null  
          GROUP BY  wp.hn,wp.cid,patient,pttype,phone,lineid,adddess,moo,district,amphoe,province,zipcode,
          date_appoint,doctor_appoint,clinic_appoint,app_status,confirm_drugs
          ORDER BY date_appoint";
          }
   
        $query = mysqli_query($conf, $log);
        ?>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">
                  <?php 
                  if($datepickers != '' || $datepickert != null){ 
                    echo "ตารางแสดงข้อมูลผู้ป่วยที่ผ่านการ verify ข้อมูลที่อยู่แล้วและมีรายการนัดระหว่าง วันที่ ".thaiDateFull($datepickers).' ถึงวันที่ '.thaiDateFull($datepickert);
                  }
                  if($datepickers == '' || $datepickert == null ){
                  ?>
                    ตารางแสดงข้อมูลผู้ป่วยที่ผ่านการ verify ข้อมูลที่อยู่แล้วและมีรายการนัดหลังจาก วันที่ &nbsp<?php echo '&nbsp;'. thaiDatefull(date("Y-m-d")) ;?>
                  <?php }?>
                  </h3>
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
                        <th>คลินิก</th>
                        <th>แพทย์</th>
                        <th>วันที่นัด</th>
                        <th>ยืนยันรับยา</th>
                        <th>ชำระเงิน</th>
                        <th>print</th>
                      </tr>
                    </thead>
                    <tbody>
                       
                      <?php
                      $rw = 0;
                      while ($row_result = mysqli_fetch_array($query)) {
                        $rw++;  ?>
                        <tr>
                          <td><?php echo $row_result['hn']; ?></td>
                          <td><?php echo $row_result['cid'] ;?></td>
                          <td><?php echo $row_result['patient']; ?></td>
                          <td><?php echo $row_result['pttype']; ?></td>
                          <td><?php echo $row_result['phone'] ;?></td>
                          <td><?php echo $row_result['lineid'] ;?></td>
                          <td><?php echo $row_result['adddess'] . ' หมู่ ' . $row_result['moo'] . ' ' . $row_result['district'] . ' ' . $row_result['amphoe'] . ' ' . $row_result['province'] ?></td>
                          <td><?php echo $row_result['clinic_appoint'] ;?></td>
                          <td><?php echo $row_result['doctor_appoint'] ;?></td>
                          <td><?php echo thaiDate($row_result['date_appoint']) ;?></td>
                          <td class="text-center text-success"><?php if($row_result['checkaddress'] == '1'){echo ' <i class="fas fa-check"></i>';} ;?></td>
                          <td class="text-center text-success"><?php if($row_result['successpayment'] == 'Y'){echo ' <i class="fas fa-check"></i>';} ;?></td>
                          <td><button class="btn btn-secondary align-center"><i class="fas fa-print"></i></button></td>
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
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
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