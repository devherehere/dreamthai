<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<?PHP 	
ob_start();
@session_start();
include"include/connect.inc.php";
?>
<title>BOOKING (Online)</title>
</head>
<body>
<div id="wrapper">
  <div class="mian">
    <div class="head">
      <?PHP include"include/head.php";?>
      <div class="chklogin">
        <?PHP include"include/sessionl_ogin.php";?>
      </div>
      <div class="menu">
        <?PHP include"include/menu.php";?>
      </div>
    </div>
    <div class="content">
      <?
	if($_GET['id'] == 1){
     $ap_file1 = sqlsrv_query($con,"DELETE FROM   Book_Order_Detail_Temp WHERE AR_BO_ID = ".$_SESSION['id_bo']."");
	  echo "<script>alert(\" ลบทั้งหมดเรียบร้อย\") ; window.close(); </script>";
      //---------------------------------------------------------------------------------------------------------------
	}else if ($_GET['id'] == md5('del558')){
	  $ap_file1 = sqlsrv_query($con,"DELETE FROM   Book_Order_Detail_Temp WHERE AR_BO_ID = ".$_SESSION['id_bo']." AND AR_BOD_ITEM = ".$_GET['gitem']."");
	  echo "<script>alert(\" ลบทั้งหมดเรียบร้อย\");  window.close(); </script>";
	 //---------------------------------------------------------------------------------------------------------------
	}else if($_GET['id'] == 2){
		    $sql = "SELECT * FROM [Dream_Thai].[dbo].[Customer_Return_Picture] WHERE   AR_CN_ID = ".$_SESSION['id_cn']." ";
		    $row = sqlsrv_num_rows(sqlsrv_query($con,$sql));
			for($i = 1; $i <= $row ; $i ++){
				  $sql2 = "SELECT * FROM [Dream_Thai].[dbo].[Customer_Return_Picture] WHERE   AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$i." ";
		          $row2 = sqlsrv_num_rows(sqlsrv_query($con,$sql2));
				       for($j = 1; $j <= $row2 ; $j ++){
		                   $sql_qli = " SELECT AR_CNP_PIC_NAME FROM [Dream_Thai].[dbo].[Customer_Return_Picture] 
			               WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$i." AND AR_CNP_ITEM  = ".$j." ";
		                   $item_pic = sqlsrv_fetch_array(sqlsrv_query($con,$sql_qli));
		                   @unlink("_pic_file_cn/".$item_pic['AR_CNP_PIC_NAME'].""); 
		                  // echo $item_pic[0]."<BR>";
					   }
            }	
	 $ap_file2 = sqlsrv_query($con,"DELETE FROM   Customer_Return_Picture  WHERE AR_CN_ID = ".$_SESSION['id_cn']."");
     $ap_file1 = sqlsrv_query($con,"DELETE FROM   Customer_Return_Detail_Temp  WHERE AR_CN_ID = ".$_SESSION['id_cn']."");
	  if($ap_file1 == true    &&   $ap_file2 == true ){
		  
		   echo "<script>alert(\" ลบทั้งหมดเรียบร้อย\");  window.close(); </script>";
	   }
    //---------------------------------------------------------------------------------------------------------------   
	}else if ($_GET['id'] == md5('del313')){
		$sql = "SELECT * FROM [Dream_Thai].[dbo].[Customer_Return_Picture] WHERE   AR_CND_ITEM = ".$_GET['gitem']." ";
		if($_GET['gitem'] != ""){
		$_SESSION['gitem']  =  $_GET['gitem'];	
		}
		$row = sqlsrv_num_rows(sqlsrv_query($con,$sql));
		if($row  != 0){
			for($i = 1; $i <= $row ; $i ++){
		    $sql_qli = " SELECT AR_CNP_PIC_NAME FROM [Dream_Thai].[dbo].[Customer_Return_Picture] 
			WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_SESSION['gitem']." AND AR_CNP_ITEM  = ".$i." ";
		    $item_pic = sqlsrv_fetch_array(sqlsrv_query($con,$sql_qli));
		     	if($item_pic['AR_CNP_PIC_NAME'] != ""){
		        @unlink("_pic_file_cn/".$item_pic[0].""); 
		        $ap_file1 = sqlsrv_query($con,"DELETE FROM Customer_Return_Picture
		        WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_SESSION['gitem']." AND AR_CNP_ITEM  = ".$i."");
			    }
            }	
	    }
	  $ap_file1 = sqlsrv_query($con,"DELETE FROM   Customer_Return_Detail_Temp
			WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_GET['gitem']."");
	  if($ap_file1 == true){
		   echo "<script>alert(\" ลบทั้งหมดเรียบร้อย\") ;window.close(); </script>";
	   }	
	   //---------------------------------------------------------------------------------------------------------------
	}else if($_GET['id']  == md5('del_pic_cn')){    
	   $ap_file1 = sqlsrv_query($con,"DELETE FROM Customer_Return_Picture WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CNP_ITEM  = ".$_GET['gitem']." AND AR_CND_ITEM = ".$_GET['item']."");
	  if($ap_file1 == true){
	       @unlink("_pic_file_cn/".$_GET['namep']."");
		   echo "<script>//alert(\" ลบทั้งหมดเรียบร้อย\") ;window.close();   </script>";
		   echo("<meta http-equiv='refresh' content='1;url= add_edit_pic_cn.php' />");
	   }	
	}
	/*else if($_GET['id']  == md5('del_pic_all')){ 
	  for($i = 1; $i <= $_GET['itemp']; $i ++){
		    $sql_qli = " SELECT AR_CNP_PIC_NAME FROM [Dream_Thai].[dbo].[Customer_Return_Picture] WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_SESSION['id_item']." AND AR_CNP_ITEM  = ".$i." ";
		    $item_pic = mssql_fetch_array(mssql_query($sql_qli));
		   @unlink("_pic_file_cn/".$item_pic[0].""); 
		    $ap_file1 = mssql_query("DELETE FROM Customer_Return_Picture WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_GET['item']." AND AR_CNP_ITEM  = ".$i."");
      }
	  	   echo "<script>alert(\" ลบทั้งหมดเรียบร้อย\") window.close();</script>";
		   echo("<meta http-equiv='refresh' content='1;url= add_edit_pic_cn.php' />");
	}*/
	//---------------------------------------------------------------------------------------------------------------
	else if($_GET['id']  == md5('del_pic_calcle')){ 
	  for($i = 1; $i <= $_GET['itemp']; $i ++){
		    $sql_qli = " SELECT AR_CNP_PIC_NAME FROM [Dream_Thai].[dbo].[Customer_Return_Picture] WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_SESSION['id_item']." AND AR_CNP_ITEM  = ".$i." ";
		    $item_pic = sqlsrv_fetch_array(sqlsrv_query($con,$sql_qli));
		   @unlink("_pic_file_cn/".$item_pic[0].""); 
		    $ap_file1 = sqlsrv_query($con,"DELETE FROM Customer_Return_Picture WHERE AR_CN_ID = ".$_SESSION['id_cn']." AND AR_CND_ITEM = ".$_GET['item']." AND AR_CNP_ITEM  = ".$i."");
      }
	  	   echo "<script>window.close();</script>";
	}
    ?>
    </div>
    <div class="foot">
      <?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>