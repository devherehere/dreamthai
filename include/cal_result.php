<HTML>
<head>
<style>
.frominput {
	background-color:#e3efff;
}
input {
	background-color:#e3efff;
	border-radius:4px;
	height:20px;
	margin:3px;
	text-align:right;
}
.cal {
	background:url(../img/cal.png);
	float:right;
	margin-top:5px;
	margin-right:0px;
	margin-bottom:5px;
	border:none;
	display:block;
	width:94px;
	height:26px;
	cursor:pointer;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<meta http-equiv=refresh content='15; url=cal_result.php?id=cal'> 
</head>
<body>
<?PHP 
	ob_start();
	@session_start();
	include"connect.inc.php";?>
<?PHP
if($_REQUEST['id'] == 'cal'){
	
$sql_p  = "SELECT SUM(TEMP.AR_BOD_TOTAL)AS sumprice , (SUM(TEMP.AR_BOD_TOTAL)*7/100)AS sum_vat FROM (SELECT     Book_Order_Detail_Temp.AR_BO_ID, Book_Order_Detail_Temp.AR_BOD_ITEM, Book_Order_Detail_Temp.GOODS_KEY, Book_Order_Detail_Temp.UOM_KEY, 
                      Book_Order_Detail_Temp.AR_BOD_GOODS_SELL, Book_Order_Detail_Temp.AR_BOD_GOODS_AMOUNT, Book_Order_Detail_Temp.AR_BOD_GOODS_SUM, 
                      Book_Order_Detail_Temp.AR_BOD_DISCOUNT_PER, Book_Order_Detail_Temp.AR_BOD_DISCOUNT_AMOUNT, Book_Order_Detail_Temp.AR_BOD_TOTAL, 
                      Book_Order_Detail_Temp.AR_BOD_RE_DATE, Book_Order_Detail_Temp.AR_BOD_SO_STATUS, Book_Order_Detail_Temp.AR_BOD_REMARK, 
                      Book_Order_Detail_Temp.AR_BOD_LASTUPD, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, Goods.GOODS_NAME_MAIN, 
                      Goods.GOODS_CODE
FROM         Book_Order_Detail_Temp INNER JOIN
                      Goods ON Book_Order_Detail_Temp.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Book_Order_Detail_Temp.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Book_Order_Detail_Temp.UOM_KEY = Units_of_Measurement.UOM_KEY)AS TEMP
					  WHERE TEMP.AR_BO_ID = ".$_SESSION['id_bo']." ";
					  
 echo $sql_pro = "SELECT     PROM_KEY, PROM_NAME, PROM_DISCOUNT, PROM_START_DATE, PROM_END_DATE FROM Promotion
                   WHERE     ('".date("Y-m-d")."' >= PROM_START_DATE) AND ('".date("Y-m-d")."' <= PROM_END_DATE) AND PROM_STATUS = 1";

  $pay_dis = "SELECT DISC_NAME, DISC_STATUS FROM Discount_Cash WHERE (DISC_STATUS = '1')";

				      $dis_c = sqlsrv_fetch_array(sqlsrv_query($con,$pay_dis));
					  $promo = sqlsrv_fetch_array(sqlsrv_query($con,$sql_pro));
				     /*if($promo['PROM_DISCOUNT'] == ""){
					  $chk = "disabled";	 
					 }else{ 
					  $chk = "";
					 } */
                      $reccord = sqlsrv_fetch_array(sqlsrv_query($con,$sql_p));
					  $_SESSION['sumprice'] = $reccord['sumprice'];
                      $promo_txt_1 = $promo['PROM_DISCOUNT'];
					  $_SESSION['promo_txt_1'] = $promo_txt_1;
					  $promo_txt_2 = (($reccord['sumprice']*$promo['PROM_DISCOUNT'])/100);
					  $_SESSION['promo_txt_2'] = $promo_txt_2;
					  $promo_txt_3 = ($reccord['sumprice']-(($reccord['sumprice']*$promo['PROM_DISCOUNT'])/100));
					  $_SESSION['promo_txt_3'] = $promo_txt_3;
					  $dis_co_txt_1 = $dis_c['DISC_NAME'];
					  $_SESSION['dis_co_txt_1'] = $dis_co_txt_1;
					  $dis_co_txt_2 = (($promo_txt_3 * $dis_co_txt_1)/100);
					  $_SESSION['dis_co_txt_2'] = $dis_co_txt_2;
					  $dis_co_txt_3 = ($promo_txt_3 - $dis_co_txt_2);
					  $_SESSION['dis_co_txt_3'] = $dis_co_txt_3;
					  if($_POST['vat'] != 0){
					     $vat_1 = $_POST['vat'];
					  }else{
					     $vat_1 = 0;
					  }
					  $_SESSION['vat_1'] = $vat_1;
					  $vat_2 = (($dis_co_txt_3 * $vat_1) / 100);
					  $_SESSION['vat_2'] = $vat_2;
					  $total = ($dis_co_txt_3 + $vat_2);
					  $_SESSION['total'] = $total;
}
   ?>
  <form method="post" action="cal_result.php?id=cal">
<table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#36C; font-size:13px; font-family:Tahoma, Geneva, sans-serif; ">
  <tr>
    <td>มูลค่าสินค้ารวม</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" name="PRICE" value="<?=$reccord['sumprice']?>" disabled  id='amount1'></td>
  </tr>
  <tr>
    <td><font color="#000000">ส่วนลดตามโปรโมชั่น</font></td>
    <td><input type='text' name='PROMO' size='5'  disabled value='<?php echo $promo_txt_1 ;?>' ></td>
    <td>%</td> 
    <td><input type='text' name='SUMPROMO' size='5'  disabled  value='<? printf("%.2f",$promo_txt_2); ?>'  ></td>
    <td><input type="text" name="PRICE_PROMO" disabled value="<? printf("%.2f",$promo_txt_3); ?>"></td>
  </tr>
  <tr>
    <td><font color="#000000">ส่วนลดเงินสด</font></td>
    <?PHP
  /*  if($_SESSION['vatsale'] != "ขายสด"){
		    $chkk = "disabled";	 
		}else{
			$chkk = "";
		} */
	?>
    <td><input type='text' name='MONEY' size='5'    value='<? printf("%.2f",$dis_co_txt_1); ?>' disabled></td>
    <td>%</td>
    <td><input type='text' name='SUMMONEY' size='5'   value='<? printf("%.2f",$dis_co_txt_2); ?> ' disabled></td>
    <td><input type="text" name="PRICE_MONNEY" disabled value="<? printf("%.2f",$dis_co_txt_3); ?>"></td>
  </tr>
  <tr>
    <td>ภาษีมูลค่าเพิ่ม</td>
    <td><input type="text" name="vat" size="5" value="<?=$vat_1?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" name="PRICE_VAT" disabled value="<? printf("%.2f",$vat_2); ?>" ></td>
  </tr>
  <tr>
    <td>มูลค่าสุทธิ</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" name="TOTAL_PRICE" value="<?  printf("%.2f",$total);?>" disabled></td>
  </tr>
</table>
<input type="submit" value=""  class="cal" >
</form>
</body>
</HTML>
