    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Home</a>
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
      <span class="brand-text font-weight-light">ADMIN</span>
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
                  <a href="./confirmhn.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <!-- <p>ยืนยันข้อมูลสำหรับ admin</p> -->
                    <p>ค้นหาข้อมูลผู้ป่วย</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../api_patient_hn.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <!-- <p>ยืนยันข้อมูลสำหรับ admin</p> -->
                    <p title="กรณีค้นหา  HN ไม่พบ ดึงข้อมูลจาก Hosxp">Service 1 HN</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="page/checkpayment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ข้อมูลนัดส่งยาที่จ่ายเงินแล้ว</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./payment.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>PayMent ทดสอบ</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../checkthpost.php" target="_blank" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p title="สำหรับผู้ป่วย">ติดตามสถานะไปรษณีย์</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./changepassword.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>เปลี่ยนรหัสผ่าน</p>
                  </a>
                  <li class="nav-item">
                  <a href="./adddata.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>เพิ่มข้อมูล (สำหรับ เดย์ สปา)</p>
                  </a>
                </li>
                </li>
              </ul>
            </li>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
