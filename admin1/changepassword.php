<?php
date_default_timezone_set("Asia/Bangkok");
include("../config/my_con.class.php");
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
  <title>EDITPASSWORD</title>
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
    include('../config/my_con.class.php');
    include("../config/pg_con.class.php");
  ///////////////////////////////////// เมื่อกดรับงาน ส่ง POST เข้ามาทำงาน //////////////////////////////// 


  if (isset($_POST['submit'])) {
    echo $newpassword  =  md5($_POST['password']);
    $opassword  =  md5($_POST['opassword']);
    $newniname  =  ($_POST['niname']);
    if($opassword == $_SESSION['password'] ){
        echo $Updatepassword = 'UPDATE web_data_admin SET qpasslogin = "'.$newpassword .'"   WHERE qnamelogin = "'.$_SESSION['username'].'"';
        $queryUpdate = mysqli_query($con, $Updatepassword);
        if($queryUpdate){
            $_SESSION['statusinsert'] = 1;
            $message = '<hr/><p style="color:GREEN;">ดำเนินการเรียบร้อย โปรดเข้าสู่ระบบอีกครั้ง</p>';
            session_destroy();
            header('location:./login.php');
        }
    }
    else 
    $_SESSION['statusinsert'] = 2;
    $_POST['password'] = '';
    $_POST['opassword'] = '';
    $message = '<hr/><p style="color:red;">รหัสผ่านไม่ถูกต้อง</p>';
}

if($_SESSION['statusinsert'] == 1){
    echo "<script>alertify.success('บันทึกสำเร็จ');</script>";
    $_SESSION['statusinsert'] = 0;//กำหนดให้ค่าเป็น 0 
    unset($_SESSION['statusinsert']);//ยกเลิกการใช้งาน session ตัวเช็คสถานะการบันทึกออก
  }
  if($_SESSION['statusinsert'] == 2){
    echo "<script>alertify.error('รหัสผ่านเดิมไม่ถูกต้อง');</script>";
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
      <span class="brand-text font-weight-light">EDITPASSWORD</span>
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
                  <a href="page/checkpayment.php" class="nav-link">
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
                <h1>PROFILE <?php// echo date("Y/m/d") ;?></h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">แก้ไขข้อมูลUSER</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal"   action="#" method="post">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">ชื่อ</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="ชื่อ" name="fname" value="<?php echo $_SESSION['qfname'];?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">นามสกุล</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="นามสกุล"  name="lname" value="<?php echo $_SESSION['qlname'];?>" disabled>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label" >username</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" value="<?php echo $_SESSION['username'];?>" disabled> 
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">passwordเดิม</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="passwordold" placeholder="password" name="opassword" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">passwordใหม่</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="passwordnew" placeholder="password" name="password" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" name='submit' value="submit">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
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
  
</body>

</html>