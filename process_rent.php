<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=tis-620">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css">
    <!-- Validate Form -->
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>

    <!-- Validate Form -->
    <!-- DatePicker Jquery-->
    <script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
    <link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css"/>
    <script type="text/javascript">


        $(function () {
            $(".datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                minDate: 0,
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

            $('#form').validate({
                errorClass: 'error'
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
            list-style: none;
            line-height: 30px;
        }

        .error {
            color: red

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
if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {
    ?>


    <form id="form" method="post" action="process_rent.php?action=save">


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
                                <td align="right">ราคา/หน่วย</td>
                                <td align="center">หน่วย</td>
                                <td align="center">ส่วนลด</td>
                                <td align="center">ต้องการจอง</td>
                                <td align="center">วันที่ต้องการสินค้า</td>
                                <td align="center">หมายเหตุ</td>
                            </tr>
                            <?PHP
                            $goods_code = implode("','", $_POST['goods_code']);
                            $sql_dbgseh = "SELECT        Goods.GOODS_CODE,Goods.GOODS_KEY, Goods.GOODS_NAME_MAIN, Units_of_Measurement.UOM_NAME ,Units_of_Measurement.UOM_KEY, Size.SIZE_NAME, Brand.BRAND_NAME, Category.CATE_NAME,
                             (SELECT        SUM(STOCK_BALANCE) AS Expr1
                               FROM            Stock_Balance
                               WHERE        (GOODS_KEY = Goods.GOODS_KEY)) AS STOCK_BALANCE, Goods_Price_List.GPL_PRICE, Goods.GOODS_KEY
FROM            Goods INNER JOIN
                         Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY INNER JOIN
                         Category ON Goods.CATE_KEY = Category.CATE_KEY INNER JOIN
                         Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                         Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                         Units_of_Measurement ON Goods.UOM_KEY = Units_of_Measurement.UOM_KEY
WHERE        (Goods_Price_List.GPL_STATUS = '1')  AND  Goods.GOODS_CODE   IN  ('" . $goods_code . "')";

                            $result = sqlsrv_query($con, $sql_dbgseh);
                            $j = 1;
                            $i = 0;
                            while ($reccord = sqlsrv_fetch_array($result)) {

                                if ($item_edt == "" && $gkey_edt == "") {


                                } else {
                                    $item_t = $reccord['AR_BOD_GOODS_AMOUNT'];
                                    $ex_dicco = $reccord['AR_BOD_DISCOUNT_PER'];
                                    $date_re = $reccord['AR_BOD_RE_DATE']->format('Y-m-d');
                                    $remark = $reccord['AR_BOD_REMARK'];
                                }

                                ?>
                                <tr bgcolor="#CCCCCC" height="30">

                                    <input type="hidden" name="goods_key[<?php echo $i; ?>]"
                                           value="<?= $reccord['GOODS_KEY'] ?>"/>

                                    <td align="center" width="35px" bgcolor="#888888">
                                        <?= $j; ?>
                                    </td>
                                    <td align="left" bgcolor="#888888">&nbsp;
                                        <input type="text" name="goods_code[<?php echo $i; ?>]"
                                               value="<?= $reccord['GOODS_CODE'] ?>"
                                               size="10" readonly="readonly"/>
                                    </td>
                                    <td align="left" bgcolor="#888888">&nbsp;
                                        <input type="text" name="goods_name[<?php echo $i; ?>]"
                                               value="<?= $reccord['GOODS_NAME_MAIN'] ?>" size="28"
                                               readonly="readonly"/>
                                    </td>

                                    <td align="right" bgcolor="#888888">&nbsp;
                                        <input type="text" name="gpl_price[<?php echo $i; ?>]"
                                               value="<?= $reccord['GPL_PRICE'] ?>"
                                               style="text-align:right;" size="6" readonly="readonly"/>
                                    </td>
                                    <td align="left" bgcolor="#888888">&nbsp;
                                        <input type="text" name="un<?= $j; ?>" value="<?= $reccord['UOM_NAME'] ?>"
                                               size="2" readonly="readonly" style="text-align: right;"/>
                                    </td>
                                    <td align="right" bgcolor="#888888">&nbsp;
                                        <input type="text" name="dis[<?php echo $i; ?>]" value="<?= @$ex_dicco ?>"
                                               size="1"
                                               style="text-align:right;"
                                               class="discount  " data-rule-required="true"
                                               data-msg-required="*ต้องกรอกข้อมูล"/>
                                        %
                                    </td>
                                    <td align="right" bgcolor="#888888">&nbsp;คงเหลือ<font color='#FFFFFF' size="3">(
                                            <?= $reccord['STOCK_BALANCE'] ?>
                                            )</font>
                                        <input type="text" value="<?= @$item_t ?>" name="num_rent[<?php echo $i; ?>]"
                                               style="text-align:right;" size="5"
                                               class="rent" data-rule-required="true"
                                               data-msg-required="*ต้องกรอกข้อมูล">
                                        <?= $reccord['UOM_NAME'] ?>
                                    </td>
                                    <td align="left" bgcolor="#888888">&nbsp;
                                        <input type="text" name="date_re[<?php echo $i; ?>]" value="" size="8"
                                               class="datepicker" data-rule-required="true"
                                               data-msg-required="*ต้องกรอกข้อมูล"/>
                                    </td>
                                    <td align="left" bgcolor="#888888">&nbsp;
                                        <input type="text" name="remark[<?php echo $i; ?>]" value="<?= @$remark ?>"
                                               class=""
                                               size="20"/>
                                    </td>
                                    <input type="hidden" value="<?= $reccord['UOM_KEY'] ?>"
                                           name="uom_key[<?php echo $i; ?>]">
                                </tr>
                                <?PHP
                                $i++;
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

    if ($_GET['action'] == 'save') {
        $goods_key = $_POST['goods_key'];
        $gpl_price = $_POST['gpl_price'];
        $num_rent = $_POST['num_rent'];
        $dis = $_POST['dis'];
        $uom_key = $_POST['uom_key'];
        $date_re = $_POST['date_re'];
        $item_no = 0;

        $sql_check_item = "SELECT * FROM [Dream_Thai].[dbo].[Book_Order_Detail] WHERE AR_BO_ID = '" . $_SESSION['id_bo'] . "'";
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $stmt_check_item = sqlsrv_query($con, $sql_check_item, $params, $options);
        $num = sqlsrv_num_rows($stmt_check_item);

        if ($num > 0) {
            $item_no = $num + 1;
        } else {
            $item_no = 1;

        }


        for ($i = 0; $i < count($goods_key); $i++) {

            $goods_sum = $gpl_price[$i] * $num_rent[$i];
            $dis_amount = $goods_sum * ($dis[$i] / 100);
            $dis_total = $goods_sum - $dis_amount;

//            echo $goods_key[$i] . ' ' . $uom_key[$i] . ' ' . $gpl_price[$i] . ' ' . $num_rent[$i] . ' ' . $goods_sum . ' ' . $dis[$i] . ' ' . $dis_amount . ' ' . $dis_total.'<br/>';


             $sql_add_temp = "INSERT INTO [Dream_Thai].[dbo].[Book_Order_Detail]
                                    (
                                   [AR_BO_ID]
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
                                  ,'" . $goods_key[$i] . "'
                                  ,'" . $uom_key[$i] . "'
                                  ,'" . $gpl_price[$i] . "'
                                  ,'" . $num_rent[$i] . "'
                                  ," . $goods_sum . "
                                  ," . $dis[$i] . "
                                  ," . $dis_amount . "
                                  ," . $dis_total . "
                                  ,' " . $date_re[$i] . " " . date("H:i:s") . " '
                                  ,1
                                  , '" . $_POST["rm" . $k . ""] . "'
                                  ,'" . date("Y/m/d H:i:s") . "')";

            $insert_bo_detail = sqlsrv_query($con, $sql_add_temp);
            $item_no++;


        }
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $sql = "select * from [Dream_Thai].[dbo].[Book_Order_Detail] where [AR_BO_ID] = '" . $_SESSION['id_bo'] . "' ";
        $stmt = sqlsrv_query($con, $sql, $params, $options);

        if (sqlsrv_num_rows($stmt) > 0) {
            //	  echo("<meta http-equiv='refresh' content='1;url=product_search.php' />");
            echo "<script>window.close();</script>";
        }

    }


} else {
    echo "<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";
}

?>
</div>
<div class="foot">
    <?PHP include "include/foot.php"; ?>
</div>
</div>
</div>
</body>
</html>