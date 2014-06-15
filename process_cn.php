<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!-- Validate Form -->
<script src="js/jquery.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" />
<!-- Validate Form -->
<!-- DatePicker Jquery-->
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript">
  $(function () {
        $(".datepicker").datepicker({  
          changeMonth: true, 
          changeYear: true,
          dateFormat: 'dd/mm/yy', 
         // yearRange: '1900:2013',
        dayNames: 
       ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
       dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
       monthNames: 
       [
       'มกราคม',
       'กุมภาพันธ์',
       'มีนาคม',
       'เมษายน',
       'พฤษภาคม',
       'มิถุนายน',
       'กรกฎาคม',
       'สิงหาคม',
       'กันยายน',
       'ตุลาคม',
       'พฤศจิกายน',
       'ธันวาคม'
       ],
       monthNamesShort:['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
        $("#datepicker-en").datepicker({ 
         dateFormat: 'dd/mm/yy'
       });
        $("#inline").datepicker({
         dateFormat: 'dd/mm/yy', 
         inline: true
       });
      });
</script>
<style type="text/css">
.demoHeaders {
	margin-top: 2em;
}
#dialog_link {
	padding: .4em 1em .4em 20px;
	text-decoration: none;
	position: relative;
}
#dialog_link span.ui-icon {
	margin: 0 5px 0 0;
	position: absolute;
	left: .2em;
	top: 50%;
	margin-top: -8px;
}
ul#icons {
	margin: 0;
	padding: 0;
}
ul#icons li {
	margin: 2px;
	position: relative;
	padding: 4px 0;
	cursor: pointer;
	float: left;
	list-style: none;
}
ul#icons span.ui-icon {
	float: left;
	margin: 0 4px;
}
ul.test {
	list-style:none;
	line-height:30px;
}
</style>
<!-- DatePicker Jquery-->
<?PHP 	
     ob_start();
	@session_start();
	include"include/connect.inc.php";?>
<title>BOOKING(Online)</title>
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
      <?PHP 
	if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
      <?PHP
	$item = @$_POST['max'];
	$item_edt = @$_GET['item'];
	$gkey_edt = @$_GET['gkey'];
    if(@$_GET['id_s'] == md5('addtemp') ||  (@$_GET['ide'] == md5('fu313'))){
		for($i = 1; $i <= $item; $i ++ ){;
		    if(@$_POST["".$i.""] != ""){
			$tmp =  " Goods.GOODS_KEY = '".$_POST["".$i.""]."' ";
			@$set = $set . $tmp ."OR" ;
			}
		}
		$id_addtemp=md5('id_addtemp');
		?>
      <?PHP
       if($item_edt == "" && $gkey_edt  ==""){
	   ?>
      <form method="post" action="process_cn.php?id_addtemp=<?=$id_addtemp?>" name="02">
      <?PHP
	   }else{
	  ?>
      <form method="post" action="process_cn.php?id_addtemp=<?=$id_addtemp?>&gkey=<?=$gkey_edt?>&item_edt=<?=$item_edt?>" name="02">
        <?PHP
	   }
	   ?>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend>สินค้าเคลม</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF;">
                  <tr bgcolor="#333333" height="30">
    					<td align="center" >ลำดับ</td>
    					<td align="center">รหัสสินค้า</td>
    					<td align="center">ชื่อสินค้า</td>
    					<td align="center">หน่วย</td>
    					<td align="center">Serial <br>Number</td>
    					<td align="center">ดอกยาง<br>ที่เหลือ(.mm)</td>
   					    <td align="center">อาการ<br>ที่รับเคลม</td>
    					<td align="center" width="15%">หมายเหตุ</td>
                  </tr>
                  <?PHP
		if(@$_GET['ide'] == md5('fu313')){
		$sql_dbgseh_cn = "SELECT     Goods.GOODS_KEY, Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Category.CATE_KEY, Category.CATE_NAME, Brand.BRAND_KEY, Brand.BRAND_NAME, 
                      Size.SIZE_KEY, Size.SIZE_NAME, Units_of_Measurement.UOM_KEY, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, 
                      Goods_Price_List.GPL_ITEM, Stock_Sale.STOCK_BALANCE, Customer_Return_Detail_Temp.AR_CN_ID, Customer_Return_Detail_Temp.AR_CND_ITEM, 
                      Customer_Return_Detail_Temp.GOODS_KEY AS Expr1, Customer_Return_Detail_Temp.AR_CND_REMARK,Customer_Return_Detail_Temp.AR_CND_DETAIL, Customer_Return_Detail_Temp.SERIAL_NUMBER, Customer_Return_Detail_Temp.AR_CND_REMAIN, Customer_Return_Detail_Temp.AR_CND_PER_CLAIM
FROM         Goods LEFT OUTER JOIN
                      Customer_Return_Detail_Temp ON Goods.GOODS_KEY = Customer_Return_Detail_Temp.GOODS_KEY LEFT OUTER JOIN
                      Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                      Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY LEFT OUTER JOIN
                      Category ON Goods.CATE_KEY = Category.CATE_KEY LEFT OUTER JOIN
                      Stock_Sale ON Goods.GOODS_KEY = Stock_Sale.GOODS_KEY RIGHT OUTER JOIN
                      Units_of_Measurement ON Stock_Sale.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY
WHERE     (Goods_Price_List.GPL_STATUS = '1')AND (Customer_Return_Detail_Temp.AR_CND_ITEM = ".$item_edt.") AND  (Customer_Return_Detail_Temp.GOODS_KEY = '".$gkey_edt."')  ";
		}else{
		$sql_dbgseh_cn = "SELECT     Goods.GOODS_KEY, Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Category.CATE_KEY, Category.CATE_NAME, Brand.BRAND_KEY, Brand.BRAND_NAME, 
                      Size.SIZE_KEY, Size.SIZE_NAME, Units_of_Measurement.UOM_KEY, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, 
                      Goods_Price_List.GPL_ITEM, Stock_Sale.STOCK_BALANCE
FROM            Goods LEFT OUTER JOIN
                      Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                      Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY LEFT OUTER JOIN
                      Category ON Goods.CATE_KEY = Category.CATE_KEY LEFT OUTER JOIN
                      Stock_Sale ON Goods.GOODS_KEY = Stock_Sale.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Stock_Sale.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY
WHERE       (Goods_Price_List.GPL_STATUS = '1')  AND ( ".$set." Goods.GOODS_KEY='#' )";	
		}
        $result_cn = sqlsrv_query($con,$sql_dbgseh_cn);
		$j = 1;
        while($reccord_cn = sqlsrv_fetch_array($result_cn)){
        ?>
       <?PHP
       if($item_edt != "" && $gkey_edt  !=""){
		  $pp = $reccord_cn['AR_CND_DETAIL'];
		  $seriel = $reccord_cn['SERIAL_NUMBER'];
		  $size_mm = $reccord_cn['AR_CND_REMAIN'];
		  $remark = $reccord_cn['AR_CND_REMARK'];
	   }
	   ?>
                  <tr bgcolor="#CCCCCC" height="30">
                    <td align="center" width="35px" bgcolor="#888888"><?=$j ;?></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="gc<?=$j ;?>" value="<?=@$reccord_cn['GOODS_CODE']?>" size="8" readonly="readonly" /></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="gn<?=$j ;?>" value="<?=@$reccord_cn['GOODS_NAME_MAIN']?>" size="20" readonly="readonly"  /></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="un<?=$j ;?>" value="<?=@$reccord_cn['UOM_NAME']?>" size="1" readonly="readonly"  /></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="sn<?=$j ;?>" value="<?=@$seriel?>" size="20"  /></td>
                    <td align="right" bgcolor="#888888">&nbsp;
                    <input type="text" value="<?=@$size_mm?>" name="mm<?=$j?>" size="4" class="validate[required,custom[onlyNumber]]" ></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="pp<?=$j ;?>" value="<?=@$pp?>" size="25"   /></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                    <input type="text" name="rm<?=$j ;?>" value="<?=@$remark?>" size="18"  /></td>
                    <input type="hidden" value="<?=@$reccord_cn['GOODS_KEY']?>" name="gk<?=$j ;?>" >
                    <input type="hidden" value="<?=@$reccord_cn['UOM_KEY']?>" name="uk<?=$j ;?>" >
                  </tr>
                  <?PHP
				$j++;	
				$m = $j ;
		}
     ?>
                </table></td>
            </tr>
          </table>
          <input type="hidden" value="<?=$m?>" name="mx">
          <input type="reset" class="Xcloase" value="">
          <input type="submit" class="cinfirm" value="">
        </fieldset>
      </form>
      <?PHP
	}	
	?>
      <?PHP
	$itm = @$_POST['mx'];
	if(@$_GET['id_addtemp'] == md5('id_addtemp') && (@$_GET['gkey'] != "" && @$_GET['item_edt'] != "")){
	   $sql_up = "UPDATE [Dream_Thai].[dbo].[Customer_Return_Detail_Temp]
       SET
       [SERIAL_NUMBER] = '".$_POST["sn1"]."'   
      ,[AR_CND_REMAIN] = '".$_POST["mm1"]."' 
      ,[AR_CND_DETAIL] = '".$_POST["pp1"]."'  
	  ,[AR_CND_REMARK] =   '".$_POST["rm1"]."'
      WHERE AR_CND_ITEM = ".$_REQUEST['item_edt']." AND  GOODS_KEY = '".$_REQUEST['gkey']."'  ";
       mssql_query($sql_up);
	 echo "<script>window.close();</script>";
	}else if(@$_GET['id_addtemp'] == md5('id_addtemp') && (@$_GET['gkey'] == "" && @$_GET['item_edt'] == "")) {
	$run_item = sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ISNULL(MAX(AR_CND_ITEM),0)+1 AS iTEM FROM [Dream_Thai].[dbo].[Customer_Return_Detail_Temp];"));
		for($k = 1; $k <= $itm; $k ++ ){
		  if($run_item[0] == 1){
                $item_no = $k;
	      }else{
			    $item_no = ($run_item[0] + ($k-1));
		  }
			$sql_add_temp = "INSERT INTO [Dream_Thai].[dbo].[Customer_Return_Detail_Temp]
           ([AR_CN_ID]
           ,[AR_CND_ITEM]
           ,[GOODS_KEY]
           ,[UOM_KEY]
           ,[SERIAL_NUMBER]
           ,[AR_DO_ID]
           ,[AR_CND_DOT]
           ,[AR_CND_REMAIN]
           ,[CNR_KEY]
           ,[AR_CND_DETAIL]
           ,[AR_CND_PER_CLAIM]
           ,[AR_CND_PRICE_CLAIM]
           ,[AR_CND_STATUS]
           ,[AR_CND_SENT_STATUS]
           ,[AR_CND_SENT_PRICE]
           ,[AR_CND_PER_WEARING_OUT]
           ,[AR_CND_LASTUPD]
		   ,[AR_CND_REMARK]
		   )
     VALUES
           (".@$_SESSION['id_cn']."
           ,".$item_no."
           ,'".@$_POST["gk".$k.""]."'
           ,'".@$_POST["uk".$k.""]."'
           ,'".@$_POST["sn".$k.""]."'
           ,NULL
           ,''
           ,".@$_POST["mm".$k.""]."
           ,''
           ,'".@$_POST["pp".$k.""]."'
           ,0.00
           ,0.00
           ,3
           ,NULL
           ,0.00
           ,0.00
           ,'".date("Y/m/d H:i:s")."'
           ,'".@$_POST["rm".$k.""]."' ) ";
		       $ap_file1  = sqlsrv_query($con,$sql_add_temp);
			    if($ap_file1 == true){
	           echo "<script>window.close();</script>";
			    }
		    }
	}
	?>
      <?PHP
        }else{
		echo"<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";  
      } ?>
    </div>
    <div class="foot">
      <?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>