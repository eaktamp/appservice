<?php session_start();
date_default_timezone_set('asia/bangkok');
include"config/pg_con.class.php";
include"config/web_con.php";
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

<?php
$checkAp = " SELECT MAX(hn) AS maxhn
			 FROM patient
			 WHERE hn NOT IN ('999999999','999999998','999999995','999999994','999999993','999999992','999999991','999999989','999999988','999999987','999999922','999999222','777777777')
 			AND hn NOT IN (SELECT hn FROM patient WHERE hn LIKE '0090%%') ";
$oppid_check = mysqli_query($conf,$checkAp);
//$rowc        = mysqli_num_rows($oppid_check);
$value = mysqli_fetch_array($oppid_check);
$chack_max = $value['maxhn'];
?>
<body>
	 API Service Patient || MAX HN = <?php echo $chack_max; ?>
      <div id="progressbox">
         <div id="progressbar"></div >
         <div id="statustxt">0%</div >
      </div>
   </body>
</html>

<?php
$ssql = " SELECT  DISTINCT p.hn   AS hn
 ,p.pname     AS pname,p.fname     AS fname
,p.lname    AS lname
,pty.name   AS pttype
,p.addrpart AS adddess
,dbs.province AS province
,dbs.amphur    AS amphoe
,dbs.district  AS district
,p.moopart     AS moo
,r.full_name AS full_name
,p.mobile_phone_number AS phone
,p.birthday
,(SELECT pocode FROM thaiaddress WHERE pocode IS NOT NULL AND chwpart = p.chwpart AND amppart =  p.amppart AND tmbpart = '00' AND codetype = '2') as zipcode
,p.cid      AS cid

FROM ovst a
inner join patient p on a.hn = p.hn
INNER JOIN thaiaddress AS r ON r.tmbpart = p.tmbpart AND r.amppart = p.amppart AND r.chwpart = p.chwpart 
LEFT JOIN dbaddress as dbs on dbs.iddistrict = r.addressid
LEFT JOIN pttype pty        ON pty.pttype       = p.pttype

WHERE   1 = 1 ";
/*
if ($rowc > 0) {
	$ssql .= " AND p.hn Not in (";
	while ($value = mysqli_fetch_array($oppid_check)) 
	{
		$ssql .="'" .$value['hn']. "',";
	}
	$ssql = rtrim($ssql,',');
	$ssql .= ") ";
}   
*/
//$ssql .= " AND a.vstdateate > CURRENT_DATE ";
$ssql .= " AND p.hn NOT IN ";
$ssql .= " ('999999999','999999998','999999995','999999994','999999993','999999992','999999991','999999989','999999988','999999987','999999922','999999222','777777777') ";
$ssql .= " AND p.hn NOT IN (SELECT hn FROM patient WHERE hn LIKE '0090%%') ";
$ssql .= " AND p.hn > '".$chack_max."' ";
//$ssql .= " AND a.vstdate = '2020-06-01' ";
//$ssql .= " AND a.vstdate  BETWEEN '2014-01-01' and '2014-04-30' ";
$have_user_yet = pg_query($conn, $ssql);

//echo $ssql."<br>";

try {
	if (!file_exists('config/web_con.class.php'))
		throw new Exception('ไม่สามารถเข้าถึงข้อมูล');
	else {
		require_once('config/web_con.class.php' );
		$pdo = sql_con();
		$rw = 0;
		while ($result = pg_fetch_array($have_user_yet)) { 
		$rw++;
			$hn 		=   $result['hn'];
			$pname 		=	$result['pname'];
			$fname 		=	$result['fname'];
			$lname 		=	$result['lname'];
			$cid 		=	$result['cid'];
			$pttype 	=	$result['pttype'];
			$phone 		=	$result['phone'];
			$adddess	=	$result['adddess'];
			$moo 		=	$result['moo'];
			$district 	=	$result['district'];
			$amphoe 	=	$result['amphoe'];
			$province 	=	$result['province'];
			$zipcode 	=	$result['zipcode'];
			$full_name 	=	$result['full_name'];
			$flage 		=	"1";
			$birthday 	=	$result['birthday'];
			$dateupdate   = date('Y-m-d H:i:s');
			for ($i = 1; $i <= count($result); $i++) {	
				if ($result[$i] != "") $sql = " INSERT INTO patient (hn,pname,fname,lname,cid,pttype,phone,adddess,moo,district,amphoe,province,zipcode,flage,birthday,dateupdate,full_name)
				VALUES ('".$hn."','".$pname."','".$fname."','".$lname."','".$cid."','".$pttype."','".$phone."','".$adddess."','".$moo."','".$district."','".$amphoe."','".$province."','".$zipcode."','".$flage."','".$birthday."','".$dateupdate."','".$full_name."'); ";
			};		   
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
	
			echo $rw."-".$hn. " | ";
		}
	}
} catch (Exception $e) {
	echo '<p><span style="color:red">ERROR : </span><span>' . $e->getMessage() . '</span></p>';
}
?>
