<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" /> 
<?PHP 	
    ob_start();
	@session_start();
	include"include/connect.inc.php";?>
    
<title>BOOKING (Online)</title>
</head>
<body>
<div id="wrapper">
  <div class="mian">
	<div class="head">
      <?PHP include"include/head.php";?>
       <div class="chklogin"><?PHP include"include/sessionl_ogin.php";?></div>
       <div class="menu"><?PHP include"include/menu.php";?></div>
    </div>
    <div class="content">
     <?PHP  if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
     
       <form method="post" name="011" action="cust_search.php?id=search&regis=<?=$_GET['tmp']?>">
    		<div style="margin-left:30px; color:#000;">  
   			 ค้นหาชื่อลูกค้า  <input type="text" name="search" size="60"><input type="submit" value="ค้นหา" class="OK" style="width:auto; height:30px;">
    		</div>
       </form>
                                  <table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF; ">
		  							<tr bgcolor="#333333" height="30">
    										<td align="center" width="41px">ลำดับ</td>
                                    		<td align="center">สถานะ</td>
                                    		<td align="center">สถานะการอนุมัติวงเงิน</td>
                                    		<td align="center">ชื่อลูกค้า(THAI)</td>
                                            <td align="center">ชื่อลูกค้า(ENG)</td>
                                            <td align="center">ประเภทลูกค้า</td>
                                            <td align="center">เมนู</td>
  										</tr>
                                        
       <?PHP
        if($_REQUEST['id'] == 'search'){
			if($_POST['search'] == ""){
				
			   $sql = sqlsrv_query($con,"SELECT  *, CASE ARF_STATUS WHEN 0 THEN 'ติดต่อไม่ได้' WHEN 1 THEN 'ติดต่อได้' END AS STATUS ,
								                                  CASE ARF_CREDIT_STATUS WHEN 1 THEN 'ไม่อนุมัติ' WHEN 2 THEN 'อนุมัติ' END AS CREDIT_STATUS,
																  CASE ARF_TYPE WHEN 1 THEN 'ลูกหนี้การค้าในประเทศ' WHEN 2 THEN 'ลูกหนี้การค้าต่างประเทศ'
																  WHEN 3 THEN 'ลูกหนี้การค้าอื่นๆ'  END AS TYPE
						    FROM   AR_File
							WHERE     (ARF_STATUS = '1')  ORDER BY ARF_COMPANY_NAME_THAI");
			}else{   
		       $sql = sqlsrv_query($con,"SELECT  *, CASE ARF_STATUS WHEN 0 THEN 'ติดต่อไม่ได้' WHEN 1 THEN 'ติดต่อได้' END AS STATUS,
								                                  CASE ARF_CREDIT_STATUS WHEN 1 THEN 'ไม่อนุมัติ' WHEN 2 THEN 'อนุมัติ' END AS CREDIT_STATUS,
																  CASE ARF_TYPE WHEN 1 THEN 'ลูกหนี้การค้าในประเทศ' WHEN 2 THEN 'ลูกหนี้การค้าต่างประเทศ' 
																  WHEN 3 THEN 'ลูกหนี้การค้าอื่นๆ' END AS TYPE
						    FROM  AR_File  
			   				WHERE     (ARF_STATUS = '1')  AND  ARF_COMPANY_NAME_THAI   LIKE '%".$_POST['search']."%'  OR
							ARF_COMPANY_NAME_ENG   LIKE '%".$_POST['search']."%'  ");  
			}
			$i = 1 ;	
	                   while ($row_show = sqlsrv_fetch_array($sql)){
								echo"<tr bgcolor=\"#CCCCCC\" height=\"30\">";
								echo"   <td align=\"center\" width=\"41px\"  bgcolor=\"#888888\" >".$i."</td>
                                    		<td align=\"center\"  bgcolor=\"#888888\" >".$row_show['STATUS']."</td>
                                    		<td align=\"center\"  bgcolor=\"#888888\" >".$row_show['CREDIT_STATUS']."</td>
                                    		<td align=\"center\"  bgcolor=\"#888888\" >".$row_show['ARF_COMPANY_NAME_THAI']."</td>
                                            <td align=\"center\"  bgcolor=\"#888888\" >".$row_show['ARF_COMPANY_NAME_ENG']."</td>
                                            <td align=\"center\"  bgcolor=\"#888888\" >".$row_show['TYPE']."</td>
	                                        <td align=\"center\"  bgcolor=\"#888888\" >
											<a href = 'cust_chk.php?id_search=".$row_show['ARF_KEY']."&id_action=".$_REQUEST['regis']." '>
											<img src=\"img/select.png\" border='0'></a></td>";
		echo"</tr>";
					   $i = $i + 1;
					   } // END  While
		?>
        <?PHP
        } //end IF
	   ?>
       	    </table>
      <?PHP }else{
		echo"<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";  
        } 
	  ?>
    </div>
   	<div class="foot"><?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>