<?php session_start();
date_default_timezone_set('asia/bangkok');
	include "config/pg_con.class.php";
 	include "config/web_con.php";
?>
<html>
   <head>
      <title></title>
      <style type="text/css">
         #progressbox {
         border: 1px solid #4E616D;
         padding: 1px;
         position:relative;
         width:400px;
         border-radius: 3px;
         margin: 10px;
         display:block;
         text-align:left;
         }
         #progressbar {
         height:20px;
         border-radius: 3px;
         background-color: #D84A38;
         width:1%;
         }
         #statustxt {
         top:3px;
         left:50%;
         position:absolute;
         display:inline-block;
         color: #003333;
         }
      </style>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script type="text/javascript">
         $( document ).ready(function() {

          var idTime=self.setInterval(function(){clock()},50);//ตั้งเวลา

          var i=0;
         function clock()
         {
           i=i+1;
           $('#progressbar').width(i+'%');
           $('#statustxt').text(i+'%');

         if(i==100)
         {
 			clearInterval(idTime);//กรณีที่ไม่ต้องการ Loop  100% แล้วให้หยุด
             i=0;
         }

         }
         });

      </script>
   </head>
      <body>
	 API Service Appoint  
      <div id="progressbox">
         <div id="progressbar"></div >
         <div id="statustxt">0%</div >
      </div>
   </body>
</html>
<?php
$checkAp = "SELECT oapp_id FROM oapp ";
$oppid_check = mysqli_query($conf,$checkAp);
$rowc        = mysqli_num_rows($oppid_check);
	$ssql = " SELECT  o.nextdate AS dateapp 
	,C.NAME AS clinic
	,o.hn
	,p.cid
	,o.oapp_id
	,concat(P.pname,P.fname,' ',P.lname) AS patientname
	,d.NAME::TEXT AS doctor 
	,d.licenseno
	,CONCAT(pp.pttype,' ',pp.name) as insptty
	,o.vstdate,o.vn
	FROM oapp o
	LEFT JOIN ovst v ON v.vn = o.vn
	LEFT  JOIN patient P ON P.hn = o.hn 
	LEFT  JOIN clinic C ON C.clinic = o.clinic
	LEFT  JOIN doctor d ON d.code = o.doctor
	LEFT  JOIN kskdepartment K ON K.depcode = o.depcode
	LEFT JOIN pttype as pp ON pp.pttype = v.pttype  
	WHERE   1 = 1 ";
	if ($rowc > 0) {
   $ssql .= " AND o.oapp_id Not in (";
        while ($value = mysqli_fetch_array($oppid_check)) 
                {
                    $ssql .="'" .$value['oapp_id']. "',";
                }
                    $ssql = rtrim($ssql,',');
                    $ssql .= ") ";
                }    
	$ssql .= " AND o.nextdate > CURRENT_DATE ";
	$ssql .= " AND (( o.oapp_status_id < 4 ) OR o.oapp_status_id IS NULL ) ";
	$ssql .= " ORDER BY o.nextdate ";
	$have_user_yet = pg_query($conn, $ssql);
try {
	if (!file_exists('config/web_con.class.php'))
		throw new Exception('ไม่สามารถเข้าถึงข้อมูล');
	else {
		require_once('config/web_con.class.php' );
		$pdo = sql_con();
		$rw = 0;
		while ($result = pg_fetch_array($have_user_yet)) {
		$rw++;	
			$dateapp 	=   $result['dateapp'];
			$clinic 	=	$result['clinic'];
			$cid 		=	$result['cid'];
			$hn 		=	$result['hn'];
			$oapp_id 	=	$result['oapp_id'];
			$patientname 	=	$result['patientname'];
			$doctor 	=	$result['doctor'];
			$insptty 	=	$result['insptty'];
			$vn 		=	$result['vn'];
			$vstdate 	=	$result['vstdate'];
			$licenseno 	=	$result['licenseno'];
			for ($i = 1; $i <= count($result); $i++) {	
            if ($result[$i] != "") 
            echo $sql = " INSERT INTO oapp (dateapp,clinic,cid,hn,oapp_id,patientname,doctor,insptty,vn,vstdate,licenseno)
				VALUES ('".$dateapp."','".$clinic."','".$cid."','".$hn."','".$oapp_id."','".$patientname."','".$doctor."','".$insptty."','".$vn."','".$vstdate."','".$licenseno."'); ";
			};		   
$stmt = $pdo->prepare($sql);
$stmt->execute();
echo $rw."-".$hn." | ";

}
}
} catch (Exception $e) {
	echo '<p><span style="color:red">ERROR : </span><span>' . $e->getMessage() . '</span></p>';
}
?>
