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
    $add = md5('Insert');
	?>
    <form method="post" name="01" action="product_search.php?id=<?=$add?>&cn=<?=@$_GET['cn']?>">
      <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend>ค้นหา</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"> หมวดสินค้า
              <select name="pro_g" class="frominput" >
                <?php                     
								$sql_cat = sqlsrv_query($con,"SELECT CATE_KEY, CATE_SHOT_NAME, CATE_NAME FROM  Category WHERE CATE_STATUS = '1'");
								while($cat = sqlsrv_fetch_array($sql_cat)){
								echo "<option value='".$cat[0]."'>".$cat[2]."</option>";	
							    }		
					  ?>
                <option value="all" selected="selected"   id="selected" >------------ทั้งหมด------------</option>
              </select>
              ยี่ห้อ
              <select name="pro_b" class="frominput" >
                <?php                     
								$sql_band = sqlsrv_query($con,"SELECT BRAND_KEY, BRAND_SHOT_NAME, BRAND_NAME FROM Brand WHERE BRAND_STATUS = '1'");
								while($band = sqlsrv_fetch_array($sql_band)){
								echo "<option value='".$band[0]."'>".$band[2]."</option>";	
							    }		
					  ?>
                <option value="all" selected="selected"   id="selected" >------------ทั้งหมด------------</option>
              </select>
              ขนาดขอบยาง
              <select name="pro_s" class="frominput" >
                <?php                     
								$sql_size = sqlsrv_query($con,"SELECT SIZE_KEY, SIZE_NAME FROM Size WHERE (SIZE_STATUS = '1');");
								while($size = sqlsrv_fetch_array($sql_size)){
								echo "<option value='".$size[0]."'>".$size[1]."</option>";	
							    }		
					  ?>
                <option value="all" selected="selected"   id="selected" >------------ทั้งหมด------------</option>
              </select></td>
            <td rowspan="2" align="left" width="150"><input type="submit" class="search_but" value=""></td>
          </tr>
          <tr>
            <td> รหัสสินค้า <input type="text" name="pro_id" size="30" >
                    ชื่อสินค้า <input type="text" name="pro_name" size="70" ></td>
          </tr>
        </table>
      </fieldset>
      </form>
      <?PHP
      $add_temp = md5('addtemp');
	  ?>
      <?PHP
      if(@$_GET['cn'] != ""){
	  ?>
         <form method="post" action="process_cn.php?id_s=<?=$add_temp?>" name="02">
      <?PHP }else{?>
         <form method="post" action="process_rent.php?id_s=<?=$add_temp?>" name="02">
      <?PHP
	  }
	  ?>
      <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend>รายละเอียดสินค้า</legend>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF;">
                <tr bgcolor="#333333" height="30">
                  <td align="center" width="35px">ลำดับ</td>
                  <td align="center">รหัส</td>
                  <td align="center">ชื่อสินค้า</td>
                  <td align="center">หมวดสินค้า</td>
                  <td align="center">ยี่ห้อสิ้นค้า</td>
                  <td align="center">ขนาดขอบยาง</td>
                  <td align="center">หน่วย</td>
                  <td align="center">ราคา/หน่วย</td>
                  <td align="center">สินค้าคงเหลือ</td>
                  <td align="center" width="55px">ตัวเลือก</td>
                </tr>
                <?PHP
                 if(@$_GET['id']  == md5('Insert')){
					 if($_POST['pro_g'] == 'all'){
					    $pro_g  = "";  
					 }else{
					    $pro_g  = " AND (Category.CATE_KEY = '".$_POST['pro_g']."')  "; 
					 }
					 if($_POST['pro_b'] == 'all'){
					    $pro_b = "";
					 }else{
					    $pro_b = " AND   (Brand.BRAND_KEY = '".$_POST['pro_b']."')   ";
					 }
					 if($_POST['pro_s'] == 'all'){
					    $pro_s = "";
					 }else{
					    $pro_s = " AND  (Size.SIZE_KEY = '".$_POST['pro_s']."') ";
				  	 }
					 if($_POST['pro_id']  !=  ''){
					    $pro_id = " AND  (Goods.GOODS_CODE LIKE '%".$_POST['pro_id']."%') "; 
					 }else{
					    $pro_id = "";
				  	 }
					 if($_POST['pro_name'] != ''){
					    $pro_name = " AND  (Goods.GOODS_NAME_MAIN LIKE '%".$_POST['pro_name']."%') ";				   
					 }else{


					    $pro_name = "";
				  	 }

					  $sql_dbgseh = "SELECT        Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Units_of_Measurement.UOM_NAME, Size.SIZE_NAME, Brand.BRAND_NAME, Category.CATE_NAME,
                             (SELECT        SUM(STOCK_BALANCE) AS Expr1
                               FROM            Stock_Balance
                               WHERE        (GOODS_KEY = Goods.GOODS_KEY)) AS STOCK_BALANCE, Goods_Price_List.GPL_PRICE, Goods.GOODS_KEY
FROM            Goods INNER JOIN
                         Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY INNER JOIN
                         Category ON Goods.CATE_KEY = Category.CATE_KEY INNER JOIN
                         Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                         Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                         Units_of_Measurement ON Goods.UOM_KEY = Units_of_Measurement.UOM_KEY
WHERE        (Goods_Price_List.GPL_STATUS = 1)";
					 $i = 1;
					  $seach = sqlsrv_query($con,$sql_dbgseh.$pro_g.$pro_b.$pro_s.$pro_id.$pro_name);
					  while($dbgseh =  sqlsrv_fetch_array($seach)){
				?>
                <tr bgcolor="#CCCCCC" height="30">
                  <td align="center" width="35px" bgcolor="#888888"><?=$i ;?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['GOODS_CODE']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['GOODS_NAME_MAIN']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['CATE_NAME']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['BRAND_NAME']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['SIZE_NAME']?></td>
                  <td align="left" bgcolor="#888888">&nbsp;<?=$dbgseh['UOM_NAME']?></td>
                  <td align="right" bgcolor="#888888">&nbsp;<?=$dbgseh['GPL_PRICE']?></td>
                  <td align="right" bgcolor="#888888">&nbsp;<?=$dbgseh['STOCK_BALANCE']?></td>
                  <td align="center" bgcolor="#888888"><input type="checkbox" name="<?=$i?>" value="<?=$dbgseh[0];?>"  /></td>
                </tr>
                <?PHP		    
				      $i  = $i  +1 ;
				      }
				  $m = $i ;
				  }
				?>
              </table></td>
          </tr>
        </table>
        <input type="hidden" value="<?=$m?>" name="max">
        <input type="reset" class="Xcloase" value=""><input type="submit" class="cinfirm" value="">
        </fieldset>
        </form>
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