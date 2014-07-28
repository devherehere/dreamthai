<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/validationEngine.jquery.css">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.7.2.custom.css">


<!--Main jquery-->
<script src="js/jquery-1.7.min.js"></script>
<script src="js/jquery-ui-1.7.2.custom.min.js"></script>
<!-- Validate Form -->

<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery.mask.min.js"></script>


<!-- Validate Form -->
<!-- DatePicker Jquery-->
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<!--    <link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css"/>-->

<!--jquery file upload-->
<script src="js/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>


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

        $('.type_detail').mask('999.99');

        $('#form').validate({
            errorClass: 'error'
        });


        var list_clam_item = [];

        var selected = $('input:file');

        $(document.body).on('change', 'input:file', function () {

            console.log($(this).prop('files'));
            var file_list = $(this).prop('files');


            var input_item = $(this);
            var reader = new FileReader();

            var list_clam_id = input_item.parent().parent().parent().prev().find('td').text();
            var num_pic_clam = input_item.parent().find('.show_pic_clam').children('.pic_item_clam').length + 1;
            //var show_detail = 'รายการเคลมที่ ' + list_clam_id + 'ลำดับภาพที่ ' + num_pic_clam;
            var str = input_item.prop('value');
            var arr = str.split("\\");

            reader.readAsDataURL(file_list.item(0));
            reader.onload = function () {


                var sType = reader.result;
                var dType = sType.split('/');

                if (dType[0] != 'data:image') {
                    alert('รูปภาพเท่านั้น!!');
                    return false;

                }

                input_item.next().prop('src', reader.result).css('display', 'block');
            };
        });


        /* selected.change(function () {

         var file_list = $(this).prop('files');


         var input_item = $(this);
         var reader = new FileReader();

         var list_clam_id = input_item.parent().parent().parent().prev().find('td').text();
         var num_pic_clam = input_item.parent().find('.show_pic_clam').children('.pic_item_clam').length + 1;
         //var show_detail = 'รายการเคลมที่ ' + list_clam_id + 'ลำดับภาพที่ ' + num_pic_clam;
         var str = input_item.prop('value');
         var arr = str.split("\\");

         reader.readAsDataURL(file_list.item(0));
         reader.onload = function () {


         var sType = reader.result;
         var dType = sType.split('/');

         if (dType[0] != 'data:image') {
         alert('รูปภาพเท่านั้น!!');
         return false;

         }

         input_item.next().prop('src', reader.result).css('display','block');



         };


         });
         */
        function objImg(clam_item_list, num, blob, file_name) {
            this.clam_item_list = clam_item_list;
            this.num = num;
            this.blob = blob;
            this.file_name = file_name;

        }


        $(document.body).on('click', '.cinfirm', function () {

            $.post('ajax/add_pic.php', {list_item: list_clam_item}, function (data) {

                window.open('ajax/add_pic.php');
            });

            $('#form').submit();
        });


        $(document.body).on('click', '.del_pic', function () {
            $(this).parent().remove();
        });

        $('.pic').hide();


        $(document.body).on('click', '.button_show', function () {

            $(this).next().toggle();
        });

        $(document.body).on('click', '.add_pic', function () {

            $(this).parent().append('<input type="file" class="image" name="upload[]" style="clear:both"multiple/>').append('<img src="" width="200px" height="150px" style="display: none ; margin: 5px"><div style="clear:both"></div>');
        });


    })
    ;


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


    <form id="form" method="post" action="edit_cn.php?action=save" name="formA" enctype="multipart/form-data">


        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
            <legend>สินค้าเคลม</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="0" style="color:#FFF;">
                            <tr bgcolor="#333333" height="30">
                                <td align="center" width="35px">ลำดับ</td>
                                <td align="center" width="70px">รหัส</td>
                                <td align="center" width="70px">ชื่อสินค้า</td>
                                <td align="center" width="40px">หน่วย</td>
                                <td align="center" width="70px">Serial</br>Number</td>
                                <td align="center" width="40px">ดอกยาง</br>ที่เหลือ</td>
                                <td align="center" width="100px" style="color: #00c2ff">อาการ</br>ที่รับเคลม
                                </td>
                                <td align="center" width="100px">หมายเหตุ</td>
                            </tr>
                            <?PHP
                            $goods_key = $_GET['goods_key'];
                            $sql_dbgseh = "SELECT        Goods.GOODS_CODE, Goods.GOODS_KEY, Goods.GOODS_NAME_MAIN, Units_of_Measurement.UOM_NAME, Units_of_Measurement.UOM_KEY, Size.SIZE_NAME,
                         Brand.BRAND_NAME, Category.CATE_NAME,
                             (SELECT        SUM(STOCK_BALANCE) AS Expr1
                               FROM            Stock_Balance
                               WHERE        (GOODS_KEY = Goods.GOODS_KEY)) AS STOCK_BALANCE, Goods_Price_List.GPL_PRICE, Goods.GOODS_KEY AS Expr1,
                         Customer_Return_Detail.AR_CND_DETAIL, Customer_Return_Detail.SERIAL_NUMBER, Customer_Return_Detail.AR_DO_ID, Customer_Return_Detail.AR_CND_DOT,
                         Customer_Return_Detail.AR_CND_REMAIN, Customer_Return_Detail.CNR_KEY, Customer_Return_Detail.AR_CND_PER_CLAIM,
                         Customer_Return_Detail.AR_CND_PRICE_CLAIM, Customer_Return_Detail.AR_CND_STATUS, Customer_Return_Detail.AR_CND_LASTUPD
FROM            Goods INNER JOIN
                         Brand ON Goods.BRAND_KEY = Brand.BRAND_KEY INNER JOIN
                         Category ON Goods.CATE_KEY = Category.CATE_KEY INNER JOIN
                         Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                         Customer_Return_Detail ON Goods.GOODS_KEY = Customer_Return_Detail.GOODS_KEY LEFT OUTER JOIN
                         Size ON Goods.SIZE_KEY = Size.SIZE_KEY LEFT OUTER JOIN
                         Units_of_Measurement ON Goods.UOM_KEY = Units_of_Measurement.UOM_KEY
WHERE        (Goods_Price_List.GPL_STATUS = '1')  AND  Goods.GOODS_KEY  = '" . $goods_key . "' AND AR_CN_ID = '".$_SESSION['id_cn']."'";

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
                                               size="15" readonly="readonly"/>
                                    </td>
                                    <td align="center" bgcolor="#888888">&nbsp;
                                        <input type="text" name="goods_name[<?php echo $i; ?>]"
                                               value="<?= $reccord['GOODS_NAME_MAIN'] ?>" size="30"
                                               readonly="readonly"/>
                                    </td>

                                    <td align="center" bgcolor="#888888">&nbsp;
                                        <input type="text" name="un[<?php echo $i; ?>]"
                                               value="<?= $reccord['UOM_NAME'] ?>"
                                               size="5" style="text-align: center" readonly="readonly"/>
                                    </td>
                                    <td align="center" bgcolor="#888888">&nbsp;
                                        <input type="text" name="serial_num[<?php echo $i; ?>]"
                                               value="<?= $reccord['SERIAL_NUMBER']; ?>"
                                               size="20" style="text-align: center;"

                                            />
                                    </td>
                                    <td align="center" bgcolor="#888888">&nbsp;
                                        <input type="text" name="type_detail[<?php echo $i; ?>]"
                                               value="<?= $reccord['AR_CND_REMAIN']; ?>"
                                               size="10"
                                               style="text-align:right;"
                                               class="type_detail"

                                            />

                                    </td>
                                    <td align="center" bgcolor="#888888"><font color='#FFFFFF' size="3"></font>
                                        <input type="text" value="<?= $reccord['AR_CND_DETAIL']; ?>"
                                               name="clam_detail[<?php echo $i; ?>]"
                                               style="text-align:right;" size="20"
                                               class="rent"
                                               data-rule-required="true"
                                               data-msg-required="*ต้องกรอกข้อมูล"
                                            >

                                    </td>

                                    <td align="center" bgcolor="#888888">&nbsp;
                                        <input type="text" name="remark[<?php echo $i; ?>]" value=""
                                               class=""
                                               size="20"
                                            />
                                    </td>
                                    <input type="hidden" value="<?= $reccord['UOM_KEY']; ?>"
                                           name="uom_key[<?php echo $i; ?>]">
                                    <input type="hidden" value="<?= $_GET['goods_key']; ?>"
                                           name="goods_key">
                                    <input type="hidden" value="<?= $_GET['item']; ?>"
                                           name="item">

                                </tr>

                          <!--      <tr>
                                    <td colspan="8">
                                        <div class="button_show"
                                             style="background-color:  #d5d5d5;border-radius: 5px;width: 100%;"><span
                                                class="ui-icon ui-icon-arrow-1-s">รูปภาพ</span></div>
                                        <div class="pic"
                                             style="height: 100%;width: 100%;border-style: dotted;border: 1.5;color: #000000; padding: 5px;">


                                            <span class="ui-icon ui-icon-plus add_pic"
                                                  style="position: relative;float:left;background-color: #c7cdde; cursor: pointer;"></span>


                                            <div style="clear: both;"></div>
                                            <input type="file" class="image" name="upload[]" multiple
                                                   style="clear: both"/>
                                            <img src="" width="200px" height="150px"
                                                 style="display: none ; margin: 5px;cursor:no-drop">

                                            <div style="clear: both;"></div>
                                        </div>
                                    </td>

                                </tr>-->

                                <?PHP
                                $i++;
                                $j++;
                            }

                            ?>
                        </table>
                    </td>
                </tr>
            </table>
            <input type="hidden" value="<?= $m ?>" name="mx">
            <input type="reset" class="Xcloase" value="">

            <div class="cinfirm" value=""></div>
        </fieldset>
    </form>

    <?PHP

    if ($_GET['action'] == 'save') {


        $goods_key = $_POST['goods_key'];
        $serial_num = $_POST['serial_num'];

        $clam_detail = $_POST['clam_detail'];
        $uom_key = $_POST['uom_key'];
        $remark = $_POST['remark'];


        if (isset($_POST['type_detail'])) {

            $type_detail = $_POST['type_detail'];
        } else {

            $type_detail = 0;
        }


        $sql_check_item = "SELECT * FROM [Customer_Return_Detail] WHERE AR_CN_ID = '" . $_SESSION['id_cn'] . "'";
        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $stmt_check_item = sqlsrv_query($con, $sql_check_item, $params, $options);
        $num = sqlsrv_num_rows($stmt_check_item);




        for ($i = 0; $i < count($goods_key); $i++) {

            if ($type_detail[$i] == '') {

               echo  $sql_add = "UPDATE  [Customer_Return_Detail] SET
             [AR_CN_ID] = " . $_SESSION['id_cn'] . "
              ,[SERIAL_NUMBER] = '" . $serial_num[$i] . "'
              ,[AR_CND_REMAIN] = NULL
              ,[AR_CND_DETAIL] = '" . $clam_detail[$i] . "'
              ,[AR_CND_LASTUPD] = '" . date('Y-m-d H:i:s') . "'
              WHERE [GOODS_KEY] = '" . $_POST['goods_key'] . "' AND [AR_CND_ITEM]= '" . $_POST['item'] . "' AND  AR_CN_ID = '" . $_SESSION['id_cn'] . "'";


            } else {
                echo $sql_add = "UPDATE  [Customer_Return_Detail] SET
             [AR_CN_ID] = " . $_SESSION['id_cn'] . "
              ,[SERIAL_NUMBER] = '" . $serial_num[$i] . "'
              ,[AR_CND_REMAIN] = " . $type_detail[$i] . "
              ,[AR_CND_DETAIL] = '" . $clam_detail[$i] . "'
              ,[AR_CND_LASTUPD] = '" . date('Y-m-d H:i:s') . "'
              WHERE [GOODS_KEY] = '" . $_POST['goods_key'] . "' AND [AR_CND_ITEM]= '" . $_POST['item'] . "' AND  AR_CN_ID = '" . $_SESSION['id_cn'] . "'";
            }



            $insert_cn_detail = sqlsrv_query($con, $sql_add);

        }

        $params = array();
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $sql = "select * from [Customer_Return_Detail] where [AR_CN_ID] = '" . $_SESSION['id_cn'] . "' ";
        $stmt = sqlsrv_query($con, $sql, $params, $options);

        if (sqlsrv_num_rows($stmt) > 0) {
            //	  echo("<meta http-equiv='refresh' content='1;url = product_search . php' />");
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