<?PHP
	ob_start();
	@session_start();
	include"connect.inc.php";

 $sql  = "SELECT     Book_Order_Detail_Temp.AR_BO_ID, Book_Order_Detail_Temp.AR_BOD_ITEM, Book_Order_Detail_Temp.GOODS_KEY, Book_Order_Detail_Temp.UOM_KEY,
                      Book_Order_Detail_Temp.AR_BOD_GOODS_SELL, Book_Order_Detail_Temp.AR_BOD_GOODS_AMOUNT, Book_Order_Detail_Temp.AR_BOD_GOODS_SUM, 
                      Book_Order_Detail_Temp.AR_BOD_DISCOUNT_PER, Book_Order_Detail_Temp.AR_BOD_DISCOUNT_AMOUNT, Book_Order_Detail_Temp.AR_BOD_TOTAL, 
                      Book_Order_Detail_Temp.AR_BOD_RE_DATE, Book_Order_Detail_Temp.AR_BOD_SO_STATUS, Book_Order_Detail_Temp.AR_BOD_REMARK, 
                      Book_Order_Detail_Temp.AR_BOD_LASTUPD, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, Goods.GOODS_NAME_MAIN, 
                      Goods.GOODS_CODE
FROM          Book_Order_Detail_Temp INNER JOIN
                      Goods ON Book_Order_Detail_Temp.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Book_Order_Detail_Temp.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Book_Order_Detail_Temp.UOM_KEY = Units_of_Measurement.UOM_KEY
					  WHERE Book_Order_Detail_Temp.AR_BO_ID = ".$_SESSION['id_bo']." ";
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF; font-size:13px;  ">
  <tr bgcolor="#333333" height="20">
    <td align="center">ลำดับ</td>
    <td align="center">รหัสสินค้า</td>
    <td align="center">ชื่อสินค้า</td>
    <td align="center">หน่วย</td>
    <td align="center">จำนวนที่จอง</td>
    <td align="center">ราคา/หน่วย</td>
    <td align="center">จำนวนเงิน</td>
    <td align="center">ส่วนลด%</td>
    <td align="center">จำนวนเงิน<br>
      หลังหักส่วนลด</td>
    <td align="center">วันที่<br>
      ต้องการสินค้า</td>
    <td align="center">หมายเหตุ</td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <?PHP
   $j = 1;
          $result = sqlsrv_query($con,$sql);
          while($reccord = sqlsrv_fetch_array($result)){
   ?>
  <tr bgcolor="#7f7f7f" height="20">
    <td align="center" ><?=$j?></td>
    <td align="left" bgcolor="#888888">&nbsp;
      <?=$reccord['GOODS_CODE']?></td>
    <td align="left" bgcolor="#888888">&nbsp;
      <?=$reccord['GOODS_NAME_MAIN']?></td>
    <td align="left" bgcolor="#888888">&nbsp;
      <?=$reccord['UOM_NAME']?></td>
    <td align="right" bgcolor="#888888">&nbsp;
      <?=$reccord['AR_BOD_GOODS_AMOUNT']?></td>
    <td align="right" bgcolor="#888888">&nbsp;
      <?=$reccord['GPL_PRICE']?></td>
    <td align="right" bgcolor="#888888">&nbsp;
      <?=$reccord['AR_BOD_GOODS_SUM']?></td>
    <td align="right" bgcolor="#888888">&nbsp;
      <?=$reccord['AR_BOD_DISCOUNT_PER']?></td>
    <td align="right" bgcolor="#888888">&nbsp;
      <?=$reccord['AR_BOD_TOTAL']?></td>
    <td align="center" bgcolor="#888888">&nbsp;
	
      <?php

	 //echo @date("d/m/Y",strtotime($reccord['AR_BOD_RE_DATE']));
      echo $reccord['AR_BOD_RE_DATE']->format('d/m/Y');
      ?>
	  </td>
    <td align="left" bgcolor="#888888">&nbsp;
      <?=$reccord['AR_BOD_REMARK']?></td>
    <td align="center"><a href="<?php echo BASE_URL;?>process_rent.php?ide=<?=md5('fu215')?>&gkey=<?=$reccord['GOODS_KEY']?>&item=<?=$reccord['AR_BOD_ITEM']?>"  target="_blank" > <img src="<?php echo BASE_URL;?>img/edt_list.png"></a></td>
    <td align="center"><a href="<?php echo BASE_URL;?>clear_temp.php?id=<?=md5('del558')?>&gitem=<?=$reccord['AR_BOD_ITEM']?>"  target="_blank" onClick="return confirm('ต้องการลบ')"> <img src="<?php echo BASE_URL;?>img/del_list.png"></a></td>
  </tr>
  <?PHP
  $j++;
		  }
  ?>
  <!---WHILE LOOP-->
</table>
