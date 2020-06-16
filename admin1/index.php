<?php
date_default_timezone_set("Asia/Bangkok");
include("../config/web_con.php");
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
  //echo  'this button  '.$_POST['book_no'];

  $updatestatus = "UPDATE `web_data_appoint` SET 
  `confirm_drugs` = 'Y', 
  `admin_checkConfirm` = '" . $_SESSION['qfname'].' '.$_SESSION['qlname'] . "' ,
  `book_no` = '" .  $_POST['book_no']. "' 
  WHERE oapp_id = '" .  $_POST['oapp_id']. "'  ";
 
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



if (isset($_POST['post_track'])) { //หากกดยืนยันรับงาน 
  $_SESSION['username'];
  mysqli_set_charset($conf, "utf8");
  echo  'this button  '.$_POST['postcode'];

  echo $updatestatus = "UPDATE `web_data_appoint` SET 
  `confirm_drugs` = 'Y', 
  `admin_checkConfirm` = '" . $_SESSION['qfname'].' '.$_SESSION['qlname'] . "' ,
  `barcode` = '" .  $_POST['postcode']. "' ,
  `confirm_postcode` = 'Y' 
  WHERE oapp_id = '" .  $_POST['oapp_id']. "'  ";
 
  $Queryaddadminjob =  mysqli_query($conf, $updatestatus);
  if ($Queryaddadminjob) {
        $_POST['oapp_id'] = '';
        $_SESSION['statusinsert'] = 1;
        header('location:./index.php'); 
        exit(0);
  }else{ echo "<script>alertify.error('บันทึกไม่สำเร็จ');</script>"; }
 
  if($_SESSION['statusinsert'] == 1){
    echo "<script>alertify.success('บันทึกสำเร็จ');</script>";
    $_SESSION['statusinsert'] = 0;//กำหนดให้ค่าเป็น 0 
    unset($_SESSION['statusinsert']);//ยกเลิกการใช้งาน session ตัวเช็คสถานะการบันทึกออก
  }
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
                <h1>รายชื่อผู้ป่วยที่มีการยืนยันสถานที่อยู่ในการจัดส่งแล้ว </h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <?php
        $log = " SELECT * FROM web_data_patient where hn  in (select hn from web_data_appoint where date_appoint > CURRENT_DATE GROUP BY hn) ";
        $query = mysqli_query($conf, $log);
        ?>
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">ตารางแสดงข้อมูลผู้ป่วยที่ผ่านการ verify ข้อมูลที่อยู่แล้ว <hilight style="color:red;font:bold;"> รายการนัดจะแสดงแค่หลังจากวันที่ <?php echo thaiDate(date("Y-m-d")) ;?>  </hilight></h3>
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
       $sql = " SELECT hn FROM web_data_patient  ";
       $result1 = mysqli_query($conf, $sql);
       foreach ($result1 as $item) { 
         $hn = $item['hn'];
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
                  <?php $queryApp = " SELECT * FROM web_data_appoint wa LEFT JOIN opi_rcpt opr on wa.vn = opr.vn 
                        where wa.hn = '$hn' and wa.oapp_id is not null and wa.date_appoint > CURRENT_DATE and book_no is null
                        ORDER BY wa.date_appoint  limit 10 ";
                        $resultappoint = mysqli_query($conf, $queryApp);
                        foreach ($resultappoint as $Appointment) { ?>
                  <div class="time-label">
                    <span class="bg-green"><?php echo thaiDatefull($Appointment['date_appoint']); ?></span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div>
                    <i class="fas fa-clock bg-purple"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="fas fa-clock"></i><?php echo thaiDate($Appointment['date_appoint']); ?></span>
                      <h3 class="timeline-header"><a href="#"> <?php echo $Appointment['clinic_appoint'].' vn :'.$Appointment['vn']; ?></a> </h3>

                      <div class="timeline-body">
                            <?php echo 'แพทย์ผู้นัด : '. $Appointment['doctor_appoint'].'<br>เหตุที่นัด : '. $Appointment['app_cause']; ?><br>
           

                            <!--  //confirm payment -->
                              <form action="#" method="POST" name='NeedGetMedicine'>
                                  <input type="hidden" name="oapp_id" value="<?= $Appointment['oapp_id'];?>">

                                  <?php if(isset($Appointment['book_number'])) {?>

                                    <input type="text" name="book_no" maxlength="20" 
                                      value="<?php if(isset($Appointment['book_no'])){ echo $Appointment['book_no'];}
                                                   else { echo $Appointment['book_number'].'/'.$Appointment['bill_number'];} ?>" 
                                      placeholder="เลขที่เล่มที่ 9999/99" <?php  if($Appointment['confirm_drugs'] == 'Y'){echo 'disabled'; }?> required> 

                                  <?php }
                                  else  {?>
                                       <input type="text" name="book_no" maxlength="20" 
                                      value="<?php if(isset($Appointment['book_no'])){ echo $Appointment['book_no'];}
                                                   else { echo ''; }?>" 
                                      placeholder="เลขที่เล่มที่ 9999/99" <?php  if($Appointment['confirm_drugs'] == 'Y'){echo 'disabled'; }?> required> 
                                  <?php }?>

                                <button type="submit" class="btn btn-primary" name="NeedGetMedicine" value="NeedGetMedicine" <?php if($Appointment['confirm_drugs'] !='') echo 'disabled';?>>
                                <i class="fas fa-check"></i>&nbsp; ยืนยันการจ่ายเงิน </button>
                              </form>
                          
                              
                              <!--  //Tag postman -->
                              <form action="#"  method="POST" name='post_track'>
                                <input type="hidden" name="oapp_id" value="<?= $Appointment['oapp_id'];?>">
                                <input type="text" placeholder="เลขติดตามไปรษณีย์" name="postcode" value='<?php echo $Appointment['barcode'];?>'
                                <?php if(($Appointment['confirm_drugs'] != 'Y' || $Appointment['confirm_postcode'] == 'Y') ){ echo"disabled";}   ?> required>
                                <button type="submit" class="btn btn-primary" name="post_track" value="post_track" <?php if($Appointment['confirm_drugs'] != 'Y' || $Appointment['confirm_postcode'] == 'Y'   ) echo 'disabled';?>>
                                <i class="fas fa-check"></i>&nbsp; ยืนยันเลขติดตามไปรษณีย์</button>
                              </form>
                               <hr>


                              <!--  //print -->
                              <form action="./page/print_appoint.php" target="blank" method="POST" name='printappoint'>
                                  <input type="hidden" name="hn"   value="<?php echo $hn; ?>"  required />
                                  <input type="hidden" name="oapp_id"   value="<?php echo $Appointment['oapp_id'];?>"  required />
                                  <button type="submit" class="btn btn-warning" name="printappoint" value = "submit" <?php if($Appointment['confirm_drugs'] != 'Y'  ){ echo"disabled";}?>>
                                    <i class="fas fa-print">
                                    </i>&nbsp; print ที่อยู่ตามใบนัด </button>
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
                  <form action="page/print_pems.php" target="blank" method="POST" name='print'>
                  <?php
                    $selectaddresspt = "SELECT * FROM web_data_patient where hn = '$hn'";
                    $queryAdpt= mysqli_query($conf,$selectaddresspt);
                    $resultaddressPt = mysqli_fetch_array($queryAdpt);
                       $fname      = $resultaddressPt['fname'];
                       $lname      = $resultaddressPt['lname'];
                       $adddess    = $resultaddressPt['adddess'];
                       $moo        = $resultaddressPt['moo'];
                       $district   = $resultaddressPt['district'];
                       $amphoe     = $resultaddressPt['amphoe'];
                       $province   = $resultaddressPt['province'];
                       $zipcode    = $resultaddressPt['zipcode'];
                       $hn         = $resultaddressPt['hn'];
                       $phone      = $resultaddressPt['phone'];
                  ?>
                      <input type="hidden" name="fname"     value="<?php echo $fname; ?>"  required />
                      <input type="hidden" name="lname"     value="<?php echo $lname; ?>"  required />
                      <input type="hidden" name="adddess"   value="<?php echo $adddess; ?>"  required />
                      <input type="hidden" name="moo"       value="<?php echo $moo; ?>"  required />
                      <input type="hidden" name="district"  value="<?php echo $district; ?>"  required />
                      <input type="hidden" name="amphoe"    value="<?php echo $amphoe; ?>"  required />
                      <input type="hidden" name="province"  value="<?php echo $province; ?>"  required />
                      <input type="hidden" name="zipcode"   value="<?php echo $zipcode; ?>"  required />
                      <input type="hidden" name="hn"   value="<?php echo $hn; ?>"  required />
                      <input type="hidden" name="phone"   value="<?php echo $phone; ?>"  required />
                    <button id="send" type="submit" type="button" class="btn btn-danger">Print ที่อยู่ไม่มีคลินิก</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                  </form>
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

<style>
  .radiobtn{
    display: inline; 
  }
</style>