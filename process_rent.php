<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=tis-620">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!-- Validate Form -->
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="js/jquery.validationEngine.js"></script>

    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <!-- Validate Form -->
    <!-- DatePicker Jquery-->
    <script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
    <link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css"/>
    <script type="text/javascript">
        $(function () {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                minDate:0,
                //dateFormat: 'dd/mm/yy',
                dateFormat: 'yy/mm/dd',
                // yearRange: '1900:2013',
                dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                monthNames: [
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
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
            });

            $("#datepicker-en").datepicker({
                dateFormat: 'dd/mm/yy'
            });

            $("#inline").datepicker({
                dateFormat: 'dd/mm/yy',
                inline: true
            });

            $('.discount').mask('99.99');

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
            list-style: none;
            line-height: 30px;
        }
    </style>
    <!-- DatePicker Jquery-->
    <?PHP
    ob_start();
    @session_start();
    include "include/connect.inc.php";?>
    <title>BOOKING(Online)</title>
</head>
<body>
<div id="wrapper">
<div class="mian">
<div class="head">
    <?PHP include "include/head.php"; ?>
    <div class="chklogin">
        <?PHP include "include/sessionl_ogin.php"; ?>
    </div>
    <div class="menu">
        <?PHP include "include/menu.php"; ?>
    </div>
</div>
<div class="content">
<?PHP
if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != ''){
?>
<?PHP
$item = @$_POST['max'];
$item_edt = @$_GET['item'];
$gkey_edt = @$_GET['gkey'];
if (@$_GET['id_s'] == md5('addtemp') || (@$_GET['ide'] == md5('fu215'))){
for ($i = 1; $i <= $item; $i++) {
    ;
    if (@$_POST["" . $i . ""] != "") {
        $tmp = " Goods.GOODS_KEY = '" . @$_POST["" . $i . ""] . "' ";
        @$set = $set . $tmp . "OR";
    }
}
$id_addtemp = md5('id_addtemp');
?>
<?PHP
if ($item_edt == "" && $gkey_edt == ""){
?>
<form method="post" action="process_rent.php?id_addtemp=<?= $id_addtemp ?>" name="02">
<?PHP
}else{
?>
<form method="post"
      action="process_rent.php?id_addtemp=<?= $id_addtemp ?>&gkey=<?= $gkey_edt ?>&item_edt=<?= $item_edt ?>"
      name="02">
    <?PHP
    }
    ?>
    <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend>การจอง</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" style="color:#FFF;">
                        <tr bgcolor="#333333" height="30">
                            <td align="center" width="35px">ลำดับ</td>
                            <td align="center">รหัส</td>
                            <td align="center">ชื่อสินค้า</td>
                            <!--        <td align="center">หมวดสินค้า</td>
                          <td align="center">ยี่ห้อสิ้นค้า</td>
                          <td align="center">ขนาดขอบยาง</td>   --->
                            <td align="right">ราคา/หน่วย</td>
                            <td align="center">หน่วย</td>
                            <td align="center">ส่วนลด</td>
                            <td align="center">ต้องการจอง</td>
                            <td align="center">วันที่ต้องการสินค้า</td>
                            <td align="center">หมายเหตุ</td>
                        </tr>
                        <?PHP
                        if (@$_GET['ide'] == md5('fu215')) {
                            $sql_dbgseh = "SELECT     Goods.GOODS_KEY, Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Category.CATE_KEY, Category.CATE_NAME, Brand.BRAND_KEY, Brand.BRAND_NAME,
                      Size.SIZE_KEY, Size.SIZE_NAME, Units_of_Measurement.UOM_KEY, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, 
                      Goods_Price_List.GPL_ITEM, Stock_Sale.STOCK_BALANCE, Book_Order_Detail_Temp.AR_BO_ID, Book_Order_Detail_Temp.AR_BOD_ITEM, 
                      Book_Order_Detail_Temp.GOODS_KEY AS gkeyofitem, Book_Order_Detail_Temp.AR_BOD_REMARK, Book_Order_Detail_Temp.AR_BOD_DISCOUNT_PER, 
                      Book_Order_Detail_Temp.AR_BOD_GOODS_AMOUNT, Book_Order_Detail_Temp.AR_BOD_RE_DATE
FROM         Goods RIGHT OUTER JOIN
                      Book_Order_Detail_Temp ON Goods.GOODS_KEY = Book_Order_Detail_Temp.GOODS_KEY LEFT OUTER JOIN
                      Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                      Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY LEFT OUTER JOIN
                      Category ON Goods.CATE_KEY = Category.CATE_KEY LEFT OUTER JOIN
                      Stock_Sale ON Goods.GOODS_KEY = Stock_Sale.GOODS_KEY RIGHT OUTER JOIN
                      Units_of_Measurement ON Stock_Sale.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY
WHERE     (Goods_Price_List.GPL_STATUS = '1') AND
(Book_Order_Detail_Temp.AR_BOD_ITEM = " . $item_edt . ") AND
(Book_Order_Detail_Temp.GOODS_KEY = '" . $gkey_edt . "')  ";
                        } else {
                            $sql_dbgseh = "SELECT     Goods.GOODS_KEY, Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Category.CATE_KEY, Category.CATE_NAME, Brand.BRAND_KEY, Brand.BRAND_NAME,
                      Size.SIZE_KEY, Size.SIZE_NAME, Units_of_Measurement.UOM_KEY, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, 
                      Goods_Price_List.GPL_ITEM, Stock_Sale.STOCK_BALANCE
FROM            Goods LEFT OUTER JOIN
                      Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                      Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY LEFT OUTER JOIN
                      Category ON Goods.CATE_KEY = Category.CATE_KEY LEFT OUTER JOIN
                      Stock_Sale ON Goods.GOODS_KEY = Stock_Sale.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Stock_Sale.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                      Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY
WHERE       (Goods_Price_List.GPL_STATUS = '1')  AND ( " . @$set . " Goods.GOODS_KEY='#' )";
                        }
                        $result = sqlsrv_query($con, $sql_dbgseh);
                        $j = 1;
                        while ($reccord = sqlsrv_fetch_array($result)) {
                            ?>
                            <?PHP
                            if ($item_edt == "" && $gkey_edt == "") {
                            } else {
                                $item_t = $reccord['AR_BOD_GOODS_AMOUNT'];
                                $ex_dicco = $reccord['AR_BOD_DISCOUNT_PER'];
                                $date_re = $reccord['AR_BOD_RE_DATE']->format('Y-m-d');
                                $remark = $reccord['AR_BOD_REMARK'];
                            }
                            ?>
                            <tr bgcolor="#CCCCCC" height="30">
                                <td align="center" width="35px" bgcolor="#888888"><?= $j; ?></td>
                                <td align="left" bgcolor="#888888">&nbsp;
                                    <input type="text" name="gc<?= $j; ?>" value="<?= $reccord['GOODS_CODE'] ?>"
                                           size="10" readonly="readonly"/></td>
                                <td align="left" bgcolor="#888888">&nbsp;
                                    <input type="text" name="gn<?= $j; ?>"
                                           value="<?= $reccord['GOODS_NAME_MAIN'] ?>" size="28"
                                           readonly="readonly"/></td>
                                <!--            <td align="left" bgcolor="#888888">&nbsp;
                  <input type="text" name="cn<?=$j ;?>" value="<?=$reccord['CATE_NAME']?>" size="15" readonly="readonly"  /></td>
                  <td align="left" bgcolor="#888888">&nbsp;
                  <input type="text" name="bn<?=$j ;?>" value="<?=$reccord['BRAND_NAME']?>" size="12" readonly="readonly"  /></td>
                  <td align="left" bgcolor="#888888">&nbsp;
                  <input type="text" name="sn<?=$j ;?>" value="<?=$reccord['SIZE_NAME']?>" size="3" readonly="readonly"  /></td>--->
                                <td align="right" bgcolor="#888888">&nbsp;
                                    <input type="text" name="gp<?= $j; ?>" value="<?= $reccord['GPL_PRICE'] ?>"
                                           style="text-align:right;" size="6" readonly="readonly"/></td>
                                <td align="left" bgcolor="#888888">&nbsp;
                                    <input type="text" name="un<?= $j; ?>" value="<?= $reccord['UOM_NAME'] ?>"
                                           size="2" readonly="readonly" style="text-align: right;"/></td>
                                <td align="right" bgcolor="#888888">&nbsp;
                                    <input type="text" name="ex<?= $j; ?>" value="<?= @$ex_dicco ?>" size="1"
                                           style="text-align:right;" class="validate[required,custom[onlyNumber]] discount"/>
                                    %
                                </td>
                                <td align="right" bgcolor="#888888">&nbsp;คงเหลือ<font color='#FFFFFF' size="3">(
                                        <?= $reccord['STOCK_BALANCE'] ?>
                                        )</font>
                                    <input type="text" value="<?= @$item_t ?>" name="<?= $j ?>"
                                           style="text-align:right;" size="5"
                                           class="validate[required,custom[onlyNumber]] rent">
                                    <?= $reccord['UOM_NAME'] ?></td>
                                <td align="left" bgcolor="#888888">&nbsp;
                                    <input type="text" name="dt<?= $j; ?>" value="<?= @$date_re ?>" size="8"
                                           class="datepicker"/></td>
                                <td align="left" bgcolor="#888888">&nbsp;
                                    <input type="text" name="rm<?= $j; ?>" value="<?= @$remark ?>" class=""
                                           size="20"/></td>
                                <input type="hidden" value="<?= $reccord['GOODS_KEY'] ?>" name="gk<?= $j; ?>">
                                <input type="hidden" value="<?= $reccord['UOM_KEY'] ?>" name="uk<?= $j; ?>">
                            </tr>
                            <?PHP
                            $j++;
                            $m = $j;
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <input type="hidden" value="<?= $m ?>" name="mx">
        <input type="reset" class="Xcloase" value="">
        <input type="submit" class="cinfirm" value="">
    </fieldset>
</form>
<?PHP
}
?>
<?PHP
$itm = @$_POST['mx'];
if (@$_GET['id_addtemp'] == md5('id_addtemp') && (@$_GET['gkey'] != "" && @$_GET['item_edt'] != "")) {
    echo $sql_up = "UPDATE [Dream_Thai].[dbo].[Book_Order_Detail_Temp]
       SET  [AR_BOD_GOODS_AMOUNT] = " . $_POST['1'] . "
      ,[AR_BOD_DISCOUNT_PER] = " . $_POST['ex1'] . "
      ,[AR_BOD_RE_DATE] = '" . $_POST['dt1'] . "'
	  ,[AR_BOD_GOODS_SUM]  = '" . ($_POST['1'] * $_POST['gp1']) . "'
	  ,[AR_BOD_DISCOUNT_AMOUNT] = '" . ((($_POST['1'] * $_POST['gp1']) * $_POST['ex1'] / 100)) . "'
	  ,[AR_BOD_TOTAL] = '" . (($_POST['1'] * $_POST['gp1']) - ((($_POST['1'] * $_POST['gp1']) * $_POST['ex1'] / 100))) . "'
      ,[AR_BOD_REMARK] = '" . $_POST['rm1'] . "'
      WHERE AR_BOD_ITEM = " . $_REQUEST['item_edt'] . " AND  GOODS_KEY = '" . $_REQUEST['gkey'] . "'  ";
    sqlsrv_query($con, $sql_up);
    echo "<script>window.close();</script>";
} else if (@$_GET['id_addtemp'] == md5('id_addtemp') && (@$_GET['gkey'] == "" && @$_GET['item_edt'] == "")) {
    $run_item = sqlsrv_fetch_array(sqlsrv_query($con, "SELECT ISNULL(MAX(AR_BOD_ITEM),0)+1 AS iTEM FROM [Dream_Thai].[dbo].[Book_Order_Detail_Temp];"));
    for ($k = 1; $k <= $itm; $k++) {
        if ($run_item[0] == 1) {
            $item_no = $k;
        } else {
            $item_no = ($run_item[0] + ($k - 1));
        }
        if ($_POST["" . $k . ""] != "") {
            $sum = ($_POST["" . $k . ""] * $_POST["gp" . $k . ""]);
            $temp = " Value = '" . $_POST["" . $k . ""] . "' ";
            $ex = $_POST["ex" . $k . ""];
            $sum_ex = (($sum * $ex) / 100);
            $sum_total = ($sum - $sum_ex);
            //echo" ".$temp." - " .$sum. "-".$_POST["ex".$k.""]."%";
            $sql_add_temp = "INSERT INTO [Dream_Thai].[dbo].[Book_Order_Detail_Temp]
            ([AR_BO_ID]
           ,[AR_BOD_ITEM]
           ,[GOODS_KEY]
           ,[UOM_KEY]
           ,[AR_BOD_GOODS_SELL]
           ,[AR_BOD_GOODS_AMOUNT]
           ,[AR_BOD_GOODS_SUM]
           ,[AR_BOD_DISCOUNT_PER]
           ,[AR_BOD_DISCOUNT_AMOUNT]
           ,[AR_BOD_TOTAL]
           ,[AR_BOD_RE_DATE]
           ,[AR_BOD_SO_STATUS]
           ,[AR_BOD_REMARK]
           ,[AR_BOD_LASTUPD])
     VALUES
           (" . $_SESSION['id_bo'] . "
           ," . $item_no . "
           ,'" . $_POST["gk" . $k . ""] . "'
           ,'" . $_POST["uk" . $k . ""] . "'
           ,'" . $_POST["gp" . $k . ""] . "'
           ,'" . $_POST["" . $k . ""] . "'
           ," . $sum . "
           ," . $ex . "
           ," . $sum_ex . "
           ," . $sum_total . "
           ,' " . $_POST["dt" . $k . ""] . " " . date("H:i:s") . " '
           ,1
           , '" . $_POST["rm" . $k . ""] . "'
           ,'" . date("Y/m/d H:i:s") . "')";
            // echo $sql_add_temp."<BR>";
            $ap_file1 = sqlsrv_query($con, $sql_add_temp);
            if ($ap_file1 == true) {
                //	  echo("<meta http-equiv='refresh' content='1;url=product_search.php' />");
                echo "<script>window.close();</script>";
            }
        }
    }
}
?>
<?PHP
} else {
    echo "<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";
} ?>
</div>
<div class="foot">
    <?PHP include "include/foot.php"; ?>
</div>
</div>
</div>
</body>
</html>