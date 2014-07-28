<?PHP
ob_start();
@session_start();
?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<!-- Validate Form -->
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery.validate.min.js"></script>
<!--<script src="js/jquery.validationEngine.js"></script>-->
<!--<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>-->
<!-- Validate Form -->
<!-- DatePicker Jquery-->
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css"/>


<style>
    .frominput {
        background-color: #e3efff;
    }

    input {
        background-color: #e3efff;
        border-radius: 4px;
        height: 20px;
        margin: 3px;
        text-align: right;
    }

    .cal {
        background: url(../img/cal.png);
        float: right;
        margin-top: 5px;
        margin-right: 0px;
        margin-bottom: 5px;
        border: none;
        display: block;
        width: 94px;
        height: 26px;
        cursor: pointer;
    }

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

<script type="text/javascript">


/*Jquery*/
$(function () {

    $('select[name="trans_key"]').change(function () {
        $('input[name="trans_etc"]').attr('disabled', true);
        if ($(this).val() == '1') {
            $('input[name="trans_etc"]').attr('disabled', false);
        }
    });


    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy',
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
        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']});
    $("#datepicker-en").datepicker({
        dateFormat: 'dd/mm/yy'
    });
    $("#inline").datepicker({
        dateFormat: 'dd/mm/yy',
        inline: true
    });


    /*form*/

    var formA = $('#formA').validate({
        rules: {
            send_pl: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            send_pl: {
                'required': '*ต้องการสถานที่ในการจัดส่ง',
                'minlength': '*กรอกอย่างน้อย 5 ตัวอักษร'
            }
        }


    });

    $(document.body).on('click', 'input[type="button"]', function () {
        var ar_bo_key = $('input[name="ar_bo_key"').val();
        var action = confirm('ต้องการบันทึกข้อมูลเลขที่ ' + ar_bo_key + ' ใช่หรือไม่');

        if (action) {
            $('#formA').submit();
        }


    });


    $('#formA').submit(function (event) {
        event.preventDefault();
        if (formA.valid()) {

            var arf_key = $('input[name="arf_key"]').val();
            var empkey = $('select[name="empkey"]').val();
            var promotion = $('input[name="promotion"]').data('prom-key');
            var tof_name = $('select[name="tof_name"]').val();
            var remark = $('input[name="remark"]').val();
            var vat_key = $('select[name="vat_key"]').val();
            var pur_sta = $('select[name="pur_sta"]').val();
            var trans_key = $('select[name="trans_key"]').val();
            var trans_etc = $('input[name="trans_etc"]').val();
            var send_pl = $('input[name="send_pl"]').val();
            var vat = $('input[name="vat"]').val();
            var con_item = $('select[name="ID_CONTACT"]').val();

            $.ajax({
                type: 'post',
                url: 'ajax/add_bo.php',
                beforeSend: function (xhr) {
                    xhr.overrideMimeType('content="text/html; charset=tis-620"')
                },
                data: {
                    arf_key: arf_key,
                    empkey: empkey,
                    promotion: promotion,
                    tof_name: tof_name,
                    remark: remark,
                    vat_key: vat_key,
                    pur_sta: pur_sta,
                    trans_key: trans_key,
                    trans_etc: trans_etc,
                    send_pl: send_pl,
                    vat: vat,
                    con_item: con_item
                },
                success: function (data) {

                    window.open('report/gen_book_order.php', '_blank');
                    window.location.href = 'index.php';
                }


            });

        }

    });

    /*event when start document*/

    $.ajax({
        type: 'post',
        url: 'include/productTemp.php',
        beforeSend: function (xhr) {
            xhr.overrideMimeType('content="text/html; charset=tis-620"');
        },
        success: function (data) {
            $('#product_temp').html(data);
        }
    });

    $.ajax({
        type: 'post',
        url: 'ajax/calculate.php',
        beforeSend: function (xhr) {
            xhr.overrideMimeType('content="text/html; charset=tis-620"');
        },
        success: function (data) {
            $('#calculate').html(data);
        }
    });


    /*event when start window active*/

    $(window).focus(function () {
        //send request again when window active
        $.ajax({
            type: 'post',
            url: 'include/productTemp.php',
            beforeSend: function (xhr) {
                xhr.overrideMimeType('content="text/html; charset=tis-620"');
            },
            success: function (data) {
                $('#product_temp').html(data);

            }
        });

        $.ajax({
            type: 'post',
            url: 'ajax/calculate.php',
            beforeSend: function (xhr) {
                xhr.overrideMimeType('content="text/html; charset=tis-620"');
            },
            success: function (data) {
                $('#calculate').html(data);
            }
        });

    });


    $(document.body).on('click', 'div.del_item_bo', function () {
        var bod_item = $(this).parent().parent().find('td').first().text();
        var goods_key = $(this).parent().parent().find('td').first().next().text();
        var check = confirm("คุณต้องการลบรายการ ลำดับที่ " + bod_item + "รหัสสินค้า " + goods_key);
        if (check == true) {
            $.ajax({
                type: 'post',
                url: 'ajax/del_item_bod',
                beforeSend: function (xhr) {
                    xhr.overrideMimeType('content="text/html; charset=tis-620"');
                },
                data: {
                    bod_item: bod_item
                },
                success: function (data) {
                    //document.write(data);
                    window.location.href = 'index.php';
                }
            });

        }
    });

    $(document.body).on('click', '.clear_list', function () {
       var check = confirm('คุณต้องการลบทั้งหมด ?');
       if(check == true){
           $.post('ajax/clear_bo_list.php',{id_bo:<?=$_SESSION['id_bo'];?>},function(){

               window.location.href = 'index.php';
           });

       }

    });


});


</script>


<?PHP
include "include/connect.inc.php";
?>
<title>BOOKING (Online)</title>

</head>
<body>


<div id="wrapper">
<div class="mian">
<div class="head">
    <?PHP include "include/head.php"; ?>
    <div class="chklogin">
        <?PHP include "include/sessionl_ogin.php"; ?>
    </div>
    <?PHP
    if (@$_SESSION["user_ses"] != '' && @$_SESSION["user_id"] != '') {
        ?>
        <div class="menu">
            <?PHP include "include/menu.php"; ?>
        </div>
    <?PHP } ?>
</div>
<div class="content">
<div id="debug"></div>
<?PHP if (@$_SESSION["user_ses"] != '' && @$_SESSION["user_id"] != '') {


 $sql_address = "SELECT     Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE,  Address.ADD_MOBILE, Address.ADD_FAX, Address.ADD_EMAIL, Address.ADD_DEFAULT FROM Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1')
					  AND (Address.ADD_ITEM = '" . $_SESSION['item_address'] . "') AND Address.APF_ARF_KEY = '" . $_SESSION['cust_arf'] . "' ";
$sql_dbgadd = sqlsrv_query($con, $sql_address);
$address = sqlsrv_fetch_array($sql_dbgadd);

$full_address = $address['ADD_NO'] . ' ' . $address['TAMBON_NAME_THAI'] . ' ' . $address['AMPHOE_NAME_THAI'] . ' ' . $address['PROVINCE_NAME_THAI'] . ' ' . $address['TAMBON_POSTCODE'];
$_SESSION['full_address'] = $full_address;



$day = explode("-", date("Y-m-d"));
$sql_duc = "SELECT     DOC_KEY, MODULE_KEY, DOC_TITLE_NAME, DOC_NAME_THAI, DOC_NAME_ENG, DOC_SET_YEAR, DOC_SET_MONTH, DOC_RUN, DOC_DATE, DOC_REMARK, DOC_STATUS, DOC_CREATE_BY, DOC_REVISE_BY, DOC_LASTUPD, DOC_ISO, DOC_DAR, DOC_COMPANY_NAME_THAI, DOC_COMPANY_NAME_ENG, DOC_ADD, DOC_TEL, DOC_FAX, DOC_TAX, DOC_WEBSITE, DOC_LOGO, DOC_FORMPRINT
FROM   Document_File WHERE  (DOC_STATUS = '1') AND (MODULE_KEY = 2)";
$stm = sqlsrv_query($con, $sql_duc);
$docresult = sqlsrv_fetch_array($stm);
$doc_keyy = $docresult['DOC_KEY'];

$_SESSION['doc_keyy'] = $doc_keyy;

$date_ex = date('Y/m/d H:i:s', strtotime("+" . $docresult['DOC_DATE'] . " day"));
if ($docresult[5] == 1) {
    $yy = ($day[0] + 543);
} else if ($docresult[5] == 2) {
    $yy = ($day[0]);
} else if ($docresult[5] == 3) {
    $yy = iconv_substr(($day[0] + 543), 2, 4, "UTF-8");
} else if ($docresult[5] == 4) {
    $yy = iconv_substr($day[0], 2, 4, "UTF-8");
}
if ($docresult[6] == 0) {
    $mm = '';
} else {
    $mm = $day[1];
}
if (empty($_SESSION['id_bo'])) {
    $query = " SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Book_Order] ";
    $stm = sqlsrv_query($con, $query);
    $rec_run = sqlsrv_fetch_array($stm);
    $_SESSION['id_bo'] = $rec_run[0];
}
$chk = "SELECT * FROM [Book_Order] WHERE AR_BO_ID = " . ($_SESSION['id_bo']) . " ;";
if (sqlsrv_num_rows(sqlsrv_query($con, $chk)) > 0) {
    $temp = $_SESSION['id_bo'];
    $_SESSION['id_bo'] = $temp + 1;
    sqlsrv_query($con, "UPDATE [Book_Order_Detail_Temp] SET [AR_BO_ID] = " . $_SESSION['id_bo'] . " WHERE AR_BO_ID = " . $temp . " ");
    $rec_run = sqlsrv_fetch_array(sqlsrv_query($con, " SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Book_Order] "));
    $_SESSION['id_bo'] = $rec_run[0];
    $run_id = sprintf("%03d", $rec_run[0]);
    $run_id2 = sprintf("%03d", ($run_id - 1));
    $BO_KEY = $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id . "";
    $_SESSION['key_bo'] = $BO_KEY;
    echo "<script>alert('เลขที่ใบจอง ( " . "" . $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id2 . "" . " ) ซ้ำ เลขที่ใหม่คือ ( " . $_SESSION['key_bo'] . " )')</script>";
} else {
    $rec_run = sqlsrv_fetch_array(sqlsrv_query($con, " SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Book_Order] "));
    $_SESSION['id_bo'] = $rec_run[0];
    $run_id = sprintf("%03d", $rec_run[0]);
    $BO_KEY = $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id . "";
    $_SESSION['key_bo'] = $BO_KEY;
}

?>



<form method="post" name="formA" id="formA">
<fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
    <legend>ใบจองสินค้า</legend>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="middle" align="left"> เลขที่ใบจองสินค้า
                <input type="text" name="ar_bo_key" size="50" class="validate[required,length[0,50]]"
                       value="<?php echo @$BO_KEY ?>" id="txt" disabled="disabled"/>
                <BR>
                ลูกค้า
                <input type="text" name="arf_key" size="15" class="validate[required,length[0,50]]"
                       value="<?php echo @$_SESSION["cust_arf"]; ?>" readonly="readonly"/>
                &nbsp;&nbsp;
                <input type="text"
                       name="NAME_CUST"
                       size="32"
                       class="validate[required,length[0,50]]"
                       value="<?php echo @$_SESSION["cust_name"] ?>" readonly="readonly"
                    />

                <a href="cust_search.php?action=choose_customer" style="margin:0px;">
                    <img src="img/se_c.png" border="0" height="23"/></a><BR>
                <font color="#000000">ผู้ติดต่อ</font>
                <select name="ID_CONTACT" class="frominput">
                    <?php
                    $sql_contact = "SELECT   Contact.CONT_ITEM, Contact.CONT_TITLE, Contact.CONT_NAME, Contact.CONT_SURNAME, AP_File.APF_KEY, Title_Name.TITLE_NAME_THAI FROM Title_Name INNER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN
AP_File ON Contact.APF_ARF_KEY = AP_File.APF_KEY WHERE  Contact.CONT_STATUS = '1' AND APF_ARF_KEY = '" . $_SESSION['cust_arf'] . "'";
                    $stmt_contact = sqlsrv_query($con, $sql_contact);

                    while ($ckey = sqlsrv_fetch_array($stmt_contact)):
                        ?>

                        <?php
                        if ($ckey['CONT_ITEM'] == $_SESSION['item_contact']) {
                            $select = "selected='selected' ";
                        } else {
                            $select = "";
                        }

                        echo "<option value='" . $ckey['CONT_ITEM'] . "' " . $select . " >" . $ckey['TITLE_NAME_THAI'] . " " . $ckey['CONT_NAME'] . "  " . $ckey['CONT_SURNAME'] . "</option>";



                    endwhile;
                    ?>

                </select>
                <BR></td>
            <td valign="middle" align="left"> วันที่สร้างใบจอง
                <input type="text" name="DATE_CRE" id="datepicker" disabled="disabled"
                       value="<?php echo date("d/m/Y") ?>">
                สถานะการอนุมัติ
                <input type="text" name="rent_conn" class="validate[required,length[0,50]]"
                       value="<?php echo @$_SESSION['cust_credit_conf'] ?>" readonly="readonly">
                <BR>
                <font color="#000000"> ที่อยู่</font>
                <input type="text" name="ADDRESS" size="75" class="validate[required,length[0,50]]"
                       value="<?= $full_address; ?>" readonly="readonly">
                <BR>
                <font color="#000000">Tel.</font> &nbsp;
                <input type="text" name="TEL" size="20" class="validate[required,length[0,50]]"
                       value="<?= $address['ADD_PHONE']; ?>" readonly="readonly">
                <font color="#000000"> FAX. </font>&nbsp;
                <input type="text" name="FAX" size="20" class="validate[required,length[0,50]]"
                       value="<?= $address['ADD_FAX']; ?>" readonly="readonly"></td>
        </tr>
        <tr>
            <td colspan="2"> พนักงานขาย
                <select name="empkey" class="frominput">
                    <?PHP
                    $sql_emp = "SELECT        Employee_File.EMP_KEY, Employee_File.DEPT_KEY, Employee_File.POSI_KEY, Employee_File.EMP_START_DATE, Employee_File.EMP_END_DATE,
                         Employee_File.EMP_SALARY, Employee_File.EMP_PHONE, Employee_File.EMP_MOBILE, Employee_File.TITLE_KEY, Employee_File.EMP_NAME_THAI,
                         Employee_File.EMP_SURNAME_THAI, Employee_File.EMP_NAME_ENG, Employee_File.EMP_SURNAME_ENG, Employee_File.EMP_ID_CARD,
                         Employee_File.EMP_PLACE, Employee_File.EMP_ISSUE_DATE, Employee_File.EMP_EXPIRE_DATE, Employee_File.EMP_BIRTHDATE, Employee_File.EMP_RACE,
                         Employee_File.EMP_NATIONALILY, Employee_File.EMP_RERIGION, Employee_File.EMP_ADD_CUR, Employee_File.EMP_PROVINCE_CUR,
                         Employee_File.EMP_AMPHOE_CUR, Employee_File.EMP_TAMBON_CUR, Employee_File.EMP_ADD_HOME, Employee_File.EMP_PROVINCE_HOME,
                         Employee_File.EMP_AMPHOE_HOME, Employee_File.EMP_TAMBON_HOME, Employee_File.EMP_NAME_DAD, Employee_File.EMP_AGE_DAD,
                         Employee_File.EMP_CAREER_DAD, Employee_File.EMP_MOBILE_DAD, Employee_File.EMP_STATUS_DAD, Employee_File.EMP_ADD_DAD,
                         Employee_File.EMP_NAME_MOM, Employee_File.EMP_AGE_MOM, Employee_File.EMP_CAREER_MOM, Employee_File.EMP_MOBILE_MOM,
                         Employee_File.EMP_STATUS_MOM, Employee_File.EMP_ADD_MOM, Employee_File.EMP_DAD_MOM_STATUS, Employee_File.EMP_TOTAL_SIB,
                         Employee_File.EMP_TOTAL_NUM, Employee_File.EMP_MY_STATUS, Employee_File.EMP_NAME_MATE, Employee_File.EMP_AGE_MATE,
                         Employee_File.EMP_CAREER_MATE, Employee_File.EMP_MOBILE_MATE, Employee_File.EMP_TOTAL_CHILD, Employee_File.EMP_REMARK,
                         Employee_File.EMP_STATUS, Employee_File.EMP_CREATE_BY, Employee_File.EMP_CREATE_DATE, Employee_File.EMP_REVISE_BY,
                         Employee_File.EMP_LASTUPD, Title_Name.TITLE_NAME_THAI
FROM            Employee_File LEFT OUTER JOIN
                         Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY
ORDER BY Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI";

                    $stmt_emp = sqlsrv_query($con, $sql_emp);
                    while ($ekey = sqlsrv_fetch_array($stmt_emp)) {
                        if ($_SESSION['user_id'] == $ekey['EMP_KEY']) {
                            echo "<option value='" . $ekey['EMP_KEY'] . "' selected>" . $ekey['TITLE_NAME_THAI'] . " " . $ekey['EMP_NAME_THAI'] . " " . $ekey['EMP_SURNAME_THAI'] . "</option>";

                        } else {
                            echo "<option value='" . $ekey['EMP_KEY'] . "'>" . $ekey['TITLE_NAME_THAI'] . " " . $ekey['EMP_NAME_THAI'] . " " . $ekey['EMP_SURNAME_THAI'] . "</option>";
                        }

                    }
                    ?>
                    <option value="">------ เลือก-------</option>
                </select>
                &nbsp; &nbsp; Vat
                <select name="vat_key" class="frominput" id="vat_key">
                    <?PHP
                    $sql_pay_con = "SELECT        Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY, Condition_Payment.COND_ITEM, Condition_Payment.COND_PUR_STATUS, Condition_Payment.APF_ARF_KEY
FROM            Tax_Type RIGHT OUTER JOIN
                         Condition_Payment ON Tax_Type.TAXT_KEY = Condition_Payment.TAXT_KEY LEFT OUTER JOIN
                         AR_File ON Condition_Payment.APF_ARF_KEY = AR_File.ARF_KEY
WHERE        (Tax_Type.TAXT_STATUS = '1') AND (Condition_Payment.COND_STATUS = '1') AND Condition_Payment.APF_ARF_KEY='" . $_SESSION['cust_arf'] . "'";


                    $sql_v = sqlsrv_query($con, $sql_pay_con);
                    while ($vatt = sqlsrv_fetch_array($sql_v)) {
                        if ($vatt['COND_ITEM'] == $_SESSION["item_pay"]) {
                            $selectv = "selected='selected' ";
                        } else {
                            $selectv = "";
                        }
                        echo "<option value='" . $vatt[1] . "' " . $selectv . ">" . $vatt[0] . " </option>";
                    }
                    ?>
                    <option value="">------ เลือก-------</option>
                </select>
                &nbsp; &nbsp; สถานะการขายสินค้า
                <select name="pur_sta" class="frominput" >
                    <?PHP
                    $sql_v = sqlsrv_query($con, $sql_pay_con);
                    while ($vatt = sqlsrv_fetch_array($sql_v)) {

                        if ($vatt['COND_PUR_STATUS'] == 0) {
                            $txt = 'ขายสด';
                        } else {
                            $txt = 'ขายเชื่อ';
                        }

                        if ($vatt['COND_ITEM'] ==  $_SESSION["item_pay"]){
                            $selectv = "selected='selected' ";
                        }else {
                            $selectv = "";
                        }


                        echo "<option value='" . $vatt['COND_PUR_STATUS'] . "' " . $selectv . ">" . $txt . " </option>";
                    }



                    ?>
                </select>
                &nbsp; &nbsp; เงื่อนไขการชำระเงิน
                <select name="tof_name" class="frominput" >
                    <?PHP
                    echo $_SESSION["tof"];
                    $sql_pay = sqlsrv_query($con, "SELECT   TOF_KEY   ,  TOF_NAME  FROM         Term_of_Payment
													WHERE     (TOF_STATUS = '1')  ORDER BY TOF_NAME ");

                    while ($pay = sqlsrv_fetch_array($sql_pay)) {

                        if ($_SESSION["tof"] == $pay[1]) {
                            $selectp = "selected='selected' ";
                        } else {
                            $selectp = "  ";
                        }
                        echo "<option value='" . $pay[1] . "' " . $selectp . ">" . $pay[1] . "</option>";
                    }

                    ?>
                </select>(วัน)
            </td>
        </tr>
    </table>
</fieldset>


<fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
    <legend>รายละเอียดในใบจองสินค้า</legend>


    <div id="product_temp">

    </div>


    <div  class="clear_list"></div>
    <a href="product_search.php?bo=true" target="_blank" class="add_list"></a>
</fieldset>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" width="45%">
            <fieldset style="width:94%; margin-left:11px; margin-bottom:10px;">
                <legend></legend>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>ขนส่งโดย</td>
                        <td><select name="trans_key" class="frominput">
                                <?php
                                $sql_ship = sqlsrv_query($con, "SELECT     SHIPPING_NAME, SHIPPING_KEY
								FROM         Shipping    WHERE     (SHIPPING_STATUS = '1')
								ORDER BY SHIPPING_NAME");
                                while ($ship = sqlsrv_fetch_array($sql_ship)) {
                                    echo "<option value='" . $ship[1] . "'>" . $ship[0] . "</option>";
                                }
                                ?>
                                <option value="1">อื่นๆ</option>
                            </select></td>
                    </tr>

                    <tr>
                        <td>สถานที่ส่ง</td>
                        <td><input type="text" name="send_pl" size="60" class="" id="send_pl">
                        </td>
                    </tr>
                    <tr>
                        <td><font color="#000000">ขนส่งอื่นๆ</font></td>
                        <td><input type="text" name="trans_etc" size="60" id="input" disabled></td>
                    </tr>
                    <tr>
                        <td><font color="#000000">หมายเหตุ</font></td>
                        <td><input type="text" name="remark" size="60"></td>
                    </tr>
                    <tr>
                        <td>Promotion</td>
                        <td>


                            <?php

                            $sql_promo = sqlsrv_query($con, "SELECT * FROM [Promotion]  order by PROM_YEAR DESC , PROM_MONTH DESC");
                            $row = sqlsrv_fetch_array($sql_promo);

                            ?>


                            <input name="promotion" size="60" style="background-color:yellow;text-align:center"
                                   value="<?php echo $row['PROM_NAME']; ?>"
                                   data-prom-key="<?php echo $row['PROM_KEY']; ?>" disabled>


                        </td>
                    </tr>
                </table>
            </fieldset>
        </td>
        <td valign="top" width="1%">&nbsp;</td>
        <td valign="top" width="45%">

            <div id="calculate">

            </div>


</table>


<fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
    <legend></legend>
    <input type="reset" value="  " class="Clear">
    <input type="button" value=" " class="Ok">
</fieldset>

</form>


</div>
<div class="foot">
    <?PHP include "include/foot.php"; ?>
</div>

</div>
</div>
<?PHP
} else {
    echo "<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";
} ?>
</body>
</html>