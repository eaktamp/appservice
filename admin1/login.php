<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../checkdata.php"><b>ADMIN</b>Login</a>
  </div>
  <!-- /.login-logo -->
  <?php 
    include "../config/pg_con.class.php";
    include "../config/web_con.php";
    if(isset($_POST['submit'])){
      $username = $_POST['username'];
      $password = $conf->real_escape_string (md5($_POST['password']));
      /*
      $hash = password_hash($password,PASSWORD_BCRYPT);
      echo  $hash;
      */
      $sql = "SELECT * FROM `web_data_admin` WHERE `qnamelogin` =  '".$username."'";//query เช็ค user password ตรงไหม
      $result = $conf->query($sql);
    
      if($result->num_rows>0){
        $sqlcheckpassword = "SELECT * FROM `web_data_admin` WHERE  `qnamelogin` =  '".$username."' AND `qpasslogin` = '".$password."'";
        $resultcheckpassword  = $conf->query($sqlcheckpassword);
        if($resultcheckpassword->num_rows>0){
            $accoutUsser = $result->fetch_assoc();
            $_SESSION['username'] =  $accoutUsser['qnamelogin'];
            $_SESSION['password'] =  $accoutUsser['qpasslogin'];
            $_SESSION['qfname'] =  $accoutUsser['qfname'];
            $_SESSION['qlname'] =  $accoutUsser['qlname'];
            $_SESSION['status'] =  $accoutUsser['qstatus'];
           // $_SESSION['department'] =  $accoutUsser['department'];
            
            if($_SESSION['status'] =='1'){
                header('location:./index.php'); 
            }
            else 
            { 
                header('location:./index.php');
            }
        }else{ $message =  "login fail password ไม่ถูกต้อง!!!"; }

    }else{  $message =  "login fail ไม่มีชื่อ Username นี้ในระบบ!!!"; }
      }
  ?>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="#" method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" value="" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" value=""  placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">Sign In</button>
            <center><a href="../checkdata.php">กลับหน้าหลัก</a></center>
            <?php echo '<center><p style = "margin-top:10px;" class="col-12 alert-danger">'.$message.'</p></center>';?>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>

</body>
</html>
