<HTML>
<head>
<style>
.refesh {
	background:url(../img/ref.png);
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
<meta http-equiv=refresh content='15; url=clamTemp.php'>
</head>
<body>
<a href="clamTemp.php"  class="refesh"  ></a>            
<a href="clear_temp.php?id=1" class="clear_list"   onclick="return confirm('�س����������')"  ></a> <BR>
<?PHP 
	ob_start();
	@session_start();
	include"connect.inc.php";?>
<?PHP
$sql  = "SELECT  Customer_Return_Detail_Temp.AR_CN_ID, Customer_Return_Detail_Temp.AR_CND_ITEM, Customer_Return_Detail_Temp.GOODS_KEY, 
                      Units_of_Measurement.UOM_NAME, Customer_Return_Detail_Temp.SERIAL_NUMBER, Goods.GOODS_NAME_MAIN, Goods.GOODS_CODE, 
                      Customer_Return_Detail_Temp.AR_CND_REMAIN, Customer_Return_Detail_Temp.AR_CND_DOT, Customer_Return_Detail_Temp.AR_CND_DETAIL, Customer_Return_Detail_Temp.AR_CND_REMARK, Units_of_Measurement.UOM_KEY
FROM         Customer_Return_Detail_Temp INNER JOIN
                      Goods ON Customer_Return_Detail_Temp.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Customer_Return_Detail_Temp.UOM_KEY = Units_of_Measurement.UOM_KEY
					  WHERE Customer_Return_Detail_Temp.AR_CN_ID = ".$_SESSION['id_cn']." ";
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF; font-size:13px; font-family:Tahoma, Geneva, sans-serif; border:  thin #999 solid; ">
  <tr bgcolor="#333333" height="20">
    <td align="center" >�ӴѺ</td>
    <td align="center">�����Թ���</td>
    <td align="center">�����Թ���</td>
    <td align="center">˹���</td>
    <td align="center">Serial Number</td>
    <td align="center">�͡�ҧ��������<BR>(.mm)</td>
    <td align="center">�ҡ�÷���Ѻ���</td>
    <td align="center" width="15%">�����˵�</td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
  <?PHP
   $j = 1;
          $result = mssql_query($sql);
          while($reccord = mssql_fetch_array($result)){
   ?>
  <tr bgcolor="#7f7f7f" height="20">
    			  <td align="center" ><?=$j?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['GOODS_CODE']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['GOODS_NAME_MAIN']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['UOM_NAME']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['SERIAL_NUMBER']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['AR_CND_REMAIN']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['AR_CND_DETAIL']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$reccord['AR_CND_REMARK']?></td>
                  <td align="center" bgcolor="#888888"> 
                  <a href="../add_edit_pic_cn.php?id_item=<?=$reccord['AR_CND_ITEM']?>" target="_blank"  ><img src="../img/pic.png" border="0"></a>
                  </td>
                  <td align="center">
 <a href="../process_cn.php?ide=<?=md5('fu313')?>&gkey=<?=$reccord['GOODS_KEY']?>&item=<?=$reccord['AR_CND_ITEM']?>"  target="_blank" >
 <img src="../img/edt_list.png" border="0"></a>
                 </td>
                  <td align="center">
                  <a href="../clear_temp.php?id=<?=md5('del313')?>&gitem=<?=$reccord['AR_CND_ITEM']?>"  target="_blank" onClick="return confirm('�س����������')">
                  <img src="../img/del_list.png" border="0"></a>
                  </td>
  </tr>
  <?PHP
  $j++;
  $_SESSION['max_cn'] =   $j-1; 
		  }
  ?>
  <!---WHILE LOOP-->
</table>
</body>
</HTML>
