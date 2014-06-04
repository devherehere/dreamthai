<?php
header("Content-type: application/xhtml+xml; charset=TIS-620"); 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
// ส่วนติดต่อกับฐานข้อมูล  
include"include/connect.inc.php";
?>
<?php
  if(isset($_GET['list1']) && $_GET['list1']!=""){?>
  <?php
  $q="SELECT AMPHOE_PROVINCE, AMPHOE_NAME_THAI, 
      AMPHOE_KEY FROM Amphoe WHERE AMPHOE_PROVINCE ='".$_GET['list1']."'AND  AMPHOE_STATUS='1'";
  $qr=mssql_query($q);
  while($rs=mssql_fetch_array($qr)){
  ?>
  <option value="<?=$rs[2]?>"><?=$rs[1]?></option>
  <?php 
    } ?>
  <?php 
  }?>
  <?PHP
 if(isset($_GET['list2']) && $_GET['list2']!=""){
  $qr="SELECT Province.PROVINCE_KEY, Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI, 
  		Amphoe.AMPHOE_KEY , Tambon.TAMBON_KEY FROM Amphoe INNER JOIN Tambon ON Amphoe.AMPHOE_KEY = Tambon.TAMBON_AMPHOE 
		INNER JOIN Province ON Tambon.TAMBON_PROVINCE = Province.PROVINCE_KEY  
		WHERE Amphoe.AMPHOE_KEY = '".$_GET['list2']."' AND Tambon.TAMBON_STATUS = '1'";
  $qrr=mssql_query($qr);
  while($rsr=mssql_fetch_array($qrr)){
  ?>
  <option value="<?=$rsr[4]?>"><?=$rsr[1]?></option>
  <?PHP
  }
  }
  if(isset($_GET['list3']) && $_GET['list3']!=""){
  $qt="SELECT TAMBON_NAME_THAI, TAMBON_KEY, TAMBON_POSTCODE FROM Tambon
  WHERE TAMBON_KEY = '".$_GET['list3']."' ";
  $qtt=mssql_query($qt);
  while($wq=mssql_fetch_array($qtt)){
  ?>
  <option value="<?=$wq[2]?>"><?=$wq[2]?></option>
  <!--<input type="text" name="post_no_cust" value="<?=$wq[4]?>"  />---->
  <?PHP
   }
  }
?>
