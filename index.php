<?PHP
ob_start();
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv=Content-Type content="text/html; charset=tis-620">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!-- Validate Form -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.validationEngine.js"></script>
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
    <!-- Validate Form -->
    <!-- DatePicker Jquery-->
    <script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
    <link rel="stylesheet" href="jquery/themes/base/jquery-ui.css" type="text/css"/>

	<style>
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
	</style>
    <script type="text/javascript">
        $(function () {
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
    include "include/connect.inc.php";
    ?>
    <title>BOOKING (Online)</title>
    <script type="text/javascript">
        function modTextbox() {
            document.formA.trans_etc.disabled = !(document.formA.trans_key.value % 2);
        }
        window.onload = modTextbox;
    </script>
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
    if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {
        ?>
        <div class="menu">
            <?PHP include "include/menu.php"; ?>
        </div>
    <?PHP } ?>
</div>
<div class="content">
<?PHP if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {
    if ($_REQUEST['id'] == md5('add')) {
        if (isset($_POST['item_address']) == 1 && isset($_POST['item_contact']) == 1 && isset($_POST['item_pay']) == 1) {
            $sql_dbgadd = sqlsrv_query($con, "SELECT     Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE,  Address.ADD_MOBILE, Address.ADD_FAX, Address.ADD_EMAIL, Address.ADD_DEFAULT FROM Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1') 
					  AND (Address.ADD_ITEM = '" . $_POST['item_address'] . "') AND Address.APF_ARF_KEY = '" . $_POST['ar_key_add'] . "' ;");
            $address_ = sqlsrv_fetch_array($sql_dbgadd);

            $sql_dbgcont = sqlsrv_query($con, "SELECT     Contact.CONT_TITLE, Title_Name.TITLE_NAME_THAI, Contact.CONT_NAME, Contact.CONT_SURNAME, Contact.CONT_DEPT, Contact.CONT_PHONE,   Contact.CONT_EMAIL, AR_File.ARF_KEY, Contact.CONT_ITEM, Contact.CONT_DEFAULT
FROM         Title_Name LEFT OUTER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN AR_File ON Contact.APF_ARF_KEY = AR_File.ARF_KEY  WHERE     (Contact.CONT_STATUS = '1') 
		 AND (Contact.CONT_TITLE = '" . $_POST['item_contact'] . "') AND Contact.APF_ARF_KEY = '" . $_POST['cn_key_add'] . "' ;");
            $contact_ = sqlsrv_fetch_array($sql_dbgcont);

            $sql_dbgpay = sqlsrv_query($con, "SELECT     AR_File.ARF_KEY, CASE Condition_Payment.COND_PUR_STATUS WHEN 0 THEN 'ขายสด'
			WHEN 1 THEN 'ขายเชื่อ' END AS STATUS, Condition_Payment.TOF_NAME, Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY,    	
			Condition_Payment.COND_ITEM, Condition_Payment.COND_DEFAULT  FROM         Tax_Type INNER JOIN
            Condition_Payment ON Tax_Type.TAXT_KEY = Condition_Payment.TAXT_KEY RIGHT OUTER JOIN  
			AR_File ON Condition_Payment.APF_ARF_KEY = AR_File.ARF_KEY  WHERE  (Condition_Payment.COND_STATUS = '1') AND     
			Condition_Payment.TOF_NAME =  " . $_POST['item_pay'] . ";");
            $c_pay = sqlsrv_fetch_array($sql_dbgpay);

            $cust_arf = $_POST['cust_arf'];
            $cust_name = $_POST['cust_name'];
            $add_item = $address_['ADD_ITEM'];
            $add_name = "" . $address_['AMPHOE_NAME_THAI'] . " " . $address_['TAMBON_NAME_THAI'] . "  " . $address_['PROVINCE_NAME_THAI'] . " " . $address_['TAMBON_POSTCODE'] . " ";
            $key_con = $contact_[2];
            $add_fax = $address_['ADD_FAX'];
            $phone_con = $address_['ADD_PHONE']; //----------------------
            $vat_pay = $c_pay[3];
            $vat_sale = $c_pay[1];
            $day_pay = $c_pay[2];
            $cust_type = $_POST['cust_type'];
            $cust_credit_conf = $_POST['cust_credit_conf'];
            $cust_credit = $_POST['cust_credit'];
            $cust_sta = $_POST['cust_sta'];
            if ($cust_arf != "") {
                $_SESSION["add_item"] = $address_['ADD_ITEM'];
                $_SESSION["con_item"] = $contact_['CONT_ITEM'];
                $_SESSION["cust_arf"] = $cust_arf;
                $_SESSION['cust_sta'] = $cust_sta;
                $_SESSION['cust_credit'] = $cust_credit;
                $_SESSION['cust_credit_conf'] = $cust_credit_conf;
                $_SESSION['cust_type'] = $cust_type;
                $_SESSION['day_pay'] = $day_pay;
                $_SESSION['vatsale'] = $vat_sale;
                $_SESSION['vat_pay'] = $vat_pay;
                $_SESSION['phone_con'] = $phone_con;
                $_SESSION['add_fax'] = $add_fax;
                $_SESSION['key_con'] = $key_con;
                $_SESSION['add_name'] = $add_name;
                $_SESSION['add_item'] = $add_item;
                $_SESSION['cust_name'] = $cust_name;
            }
        } else {

        }
    }
    $day = explode("-", date("Y-m-d"));
    $sql_duc = "SELECT     DOC_KEY, MODULE_KEY, DOC_TITLE_NAME, DOC_NAME_THAI, DOC_NAME_ENG, DOC_SET_YEAR, DOC_SET_MONTH, DOC_RUN, DOC_DATE, DOC_REMARK, DOC_STATUS, DOC_CREATE_BY, DOC_REVISE_BY, DOC_LASTUPD, DOC_ISO, DOC_DAR, DOC_COMPANY_NAME_THAI, DOC_COMPANY_NAME_ENG, DOC_ADD, DOC_TEL, DOC_FAX, DOC_TAX, DOC_WEBSITE, DOC_LOGO, DOC_FORMPRINT
FROM   Document_File WHERE  (DOC_STATUS = '1') AND (MODULE_KEY = 2)";
    $stm = sqlsrv_query($con, $sql_duc);
    $docresult = sqlsrv_fetch_array($stm);
    $doc_keyy = $docresult['DOC_KEY'];
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
        $query = " SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Dream_Thai].[dbo].[Book_Order] ";
        $stm = sqlsrv_query($con, $query);
        $rec_run = sqlsrv_fetch_array($stm);
        $_SESSION['id_bo'] = $rec_run[0];
    }
    $chk = "SELECT * FROM [Dream_Thai].[dbo].[Book_Order] WHERE AR_BO_ID = " . ($_SESSION['id_bo']) . " ;";
    if (sqlsrv_num_rows(sqlsrv_query($con, $chk)) > 0) {
        $temp = $_SESSION['id_bo'];
        $_SESSION['id_bo'] = $temp + 1;
        sqlsrv_query($con,"UPDATE [Dream_Thai].[dbo].[Book_Order_Detail_Temp] SET [AR_BO_ID] = " . $_SESSION['id_bo'] . " WHERE AR_BO_ID = " . $temp . " ");
        $rec_run = sqlsrv_fetch_array(sqlsrv_query($con," SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Dream_Thai].[dbo].[Book_Order] "));
        $_SESSION['id_bo'] = $rec_run[0];
        $run_id = sprintf("%03d", $rec_run[0]);
        $run_id2 = sprintf("%03d", ($run_id - 1));
        $BO_KEY = $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id . "";
        $_SESSION['key_bo'] = $BO_KEY;
        echo "<script>alert('เลขที่ใบจอง ( " . "" . $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id2 . "" . " ) ซ้ำ เลขที่ใหม่คือ ( " . $_SESSION['key_bo'] . " )')</script>";
    } else {
        $rec_run = sqlsrv_fetch_array(sqlsrv_query($con, " SELECT  ISNULL(MAX(AR_BO_ID),0)+1 AS AR_BO_KEY  FROM   [Dream_Thai].[dbo].[Book_Order] "));
        $_SESSION['id_bo'] = $rec_run[0];
        $run_id = sprintf("%03d", $rec_run[0]);
        $BO_KEY = $docresult['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $run_id . "";
        $_SESSION['key_bo'] = $BO_KEY;
    }
    $emk = sqlsrv_fetch_array(sqlsrv_query($con, " SELECT     Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI, Title_Name.TITLE_NAME_THAI, Employee_File.EMP_KEY FROM  Employee_File INNER JOIN Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY WHERE  (Employee_File.EMP_STATUS = '1')   AND  Employee_File.EMP_KEY = '" . $_SESSION["user_id"] . " ' "));
    ?>


    <form method="post" name="formA" action="index.php?id=<?= md5('addtable') ?>" target="_blank">
    <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend>ใบจองสินค้า</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="middle" align="left"> เลขที่ใบจองสินค้า
                    <!--  <input type="checkbox" name="ra" id="ra"  onclick="enableTextbox()"   />--->
                    <input type="text" name="ar_bo_key" size="50" class="validate[required,length[0,50]]"
                           value="<?= $BO_KEY ?>" id="txt" disabled="disabled"/>
                    <BR>
                    ลูกค้า
                    <input type="text" name="arf_key" size="15" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["cust_arf"]; ?>" readonly="readonly"/>
                    &nbsp;&nbsp;
                    <input type="text" name="NAME_CUST" size="32" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["cust_name"] ?>" readonly="readonly"/>
                    <a href="cust_chk.php?id_action=<?= md5('1') ?>" style="margin:0px;"><img src="img/se_c.png"
                                                                                              border="0"
                                                                                              height="23"/></a><BR>
                    <font color="#000000">ผู้ติดต่อ</font>
                    <select name="ID_CONTACT" class="frominput">
                        <?php
                        $sql_c = sqlsrv_query($con, "SELECT DISTINCT  Contact.CONT_TITLE, Contact.CONT_NAME, Contact.CONT_SURNAME, AP_File.APF_KEY, Title_Name.TITLE_NAME_THAI FROM Title_Name INNER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN
AP_File ON Contact.APF_ARF_KEY = AP_File.APF_KEY WHERE  (Contact.CONT_DEFAULT = '1') ");
                        while ($ckey = sqlsrv_fetch_array($sql_c)):?>



                            <?php


                            if ($ckey[1] == $_SESSION["key_con"]) {
                                $select = "selected='selected' ";
                            } else {
                                $select = "";
                            }
                            if ($_SESSION["key_con"] != '') {
                                echo "<option value='" . $ckey['AP_File.APF_KEY'] . "' " . $select . ">" . $ckey['TITLE_NAME_THAI'] . " " . $ckey['CONT_NAME'] . "  " . $ckey['CONT_SURNAME'] . "</option>";
                            }


                        endwhile;
                        ?>

                    </select>
                    <BR></td>
                <td valign="middle" align="left"> วันที่สร้างใบจอง
                    <input type="text" name="DATE_CRE" id="datepicker" disabled="disabled"
                           value="<?= date("d/m/Y") ?>">
                    สถานะการอนุมัติ
                    <input type="text" name="rent_conn" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["cust_credit_conf"] ?>" readonly="readonly">
                    <BR>
                    <font color="#000000"> ที่อยู่</font>
                    <input type="text" name="ADDRESS" size="75" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["add_name"] ?>" readonly="readonly">
                    <BR>
                    <font color="#000000">Tel.</font> &nbsp;
                    <input type="text" name="TEL" size="20" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["phone_con"] ?>" readonly="readonly">
                    <font color="#000000"> FAX. </font>&nbsp;
                    <input type="text" name="FAX" size="20" class="validate[required,length[0,50]]"
                           value="<?= $_SESSION["add_fax"] ?>" readonly="readonly"></td>
            </tr>
            <tr>
                <td colspan="2"> พนักงานขาย
                    <select name="empkey" class="frominput">
                        <option value="<?= $_SESSION["user_id"]; ?>" selected="selected">
                            <?= $emk['TITLE_NAME_THAI'] . " " . $emk['EMP_NAME_THAI'] . "  " . $emk['EMP_SURNAME_THAI']; ?>
                        </option>
                        <?PHP
                        $sql_e = sqlsrv_query($con," SELECT Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI, Title_Name.TITLE_NAME_THAI, Employee_File.EMP_KEY FROM Employee_File INNER JOIN Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY
WHERE     (Employee_File.EMP_STATUS = '1') ");
                        while ($ekey = sqlsrv_fetch_array($sql_e)) {
                            if ($ekey['EMP_NAME_THAI'] != $emk['EMP_NAME_THAI']) {
                                echo "<option value='" . $ekey['EMP_KEY'] . "'>" . $ekey['TITLE_NAME_THAI'] . " " . $ekey['EMP_NAME_THAI'] . " " . $ekey['EMP_SURNAME_THAI'] . "</option>";
                            }
                        }
                        ?>
                        <option value="">------ เลือก-------</option>
                    </select>
                    &nbsp; &nbsp; Vat
                    <select name="vat_key" class="frominput" id="vat_key">
                        <?PHP
                        $sql_v = sqlsrv_query($con,"SELECT    Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY
																   	 FROM         AR_File INNER JOIN
                     												 Condition_Payment ON AR_File.ARF_KEY = Condition_Payment.APF_ARF_KEY INNER JOIN
                                                                     Tax_Type ON Condition_Payment.TAXT_KEY = Tax_Type.TAXT_KEY
                                                                     WHERE    (Tax_Type.TAXT_STATUS = '1') AND (Condition_Payment.COND_STATUS = '1')");
                        while ($vatt = sqlsrv_fetch_array($sql_v)) {
                            if ($vatt[0] == $_SESSION["vat_pay"]) {
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
                    <select name="pur_sta" class="frominput">
                        <?PHP
                        if ($vat_sale == "ขายสด") {
                            echo "<option value='0'  selected=\"selected\" >ขายสด</option>";
                        } else {
                            echo "<option value='0' >ขายสด</option>";
                        }
                        if ($vat_sale == "ขายเชื่อ") {
                            echo "<option value='1' selected=\"selected\" >ขายเชื่อ</option>";
                        } else {
                            echo "<option value='1' >ขายเชื่อ</option>";
                        }
                        ?>
                    </select>
                    &nbsp; &nbsp; เงื่อนไขการชำระเงิน
                    <select name="tof_name" class="frominput">
                        <?PHP
                        $sql_pay = sqlsrv_query($con,"SELECT   TOF_KEY   ,  TOF_NAME  FROM         Term_of_Payment
													WHERE     (TOF_STATUS = '1')  ORDER BY TOF_NAME ");
                        while ($pay = sqlsrv_fetch_array($sql_pay)) {
                            if ($_SESSION["day_pay"] == $pay[1]) {
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
        <iframe src="include/productTemp.php" width="100%" scrolling="no" height="400"
                style="
                 display:block;
                 border:#FFF thin solid;
            " ></iframe>
        <a href="clear_temp.php?id=1" class="clear_list" target="_blank"
           onclick="return confirm('คุณแน่ใจหรือไม่')"></a>
        <a href="product_search.php" target="_blank" class="add_list"></a>
    </fieldset>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top" width="45%">
                <fieldset style="width:94%; margin-left:11px; margin-bottom:10px;">
                    <legend></legend>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>ขนส่งโดย</td>
                            <td><select name="trans_key" class="frominput" onchange="modTextbox();">
                                    <?php
                                    $sql_ship = sqlsrv_query($con,"SELECT     SHIPPING_NAME, SHIPPING_KEY
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
                            <td><input type="text" name="send_pl" size="60" class="validate[required,length[0,50]]">
                            </td>
                        </tr>
						<tr>
                            <td><font color="#000000">ขนส่งอื่นๆ</font></td>
                            <td><input type="text" name="trans_etc" size="60" id="input"></td>
                        </tr>
                        <tr>
                            <td><font color="#000000">หมายเหตุ</font></td>
                            <td><input type="text" name="remark" size="60"></td>
                        </tr>
                        <tr>
                            <td>Promotion</td>
                            <td>

							 <!-- <select name="promotion" class="frominput"> -->
                                    <?php

									$sql_promo = sqlsrv_query($con,"SELECT * FROM [Dream_Thai].[dbo].[Promotion]  order by PROM_YEAR DESC , PROM_MONTH DESC");
                                    /* while ($promo = sqlsrv_fetch_array($sql_promo)) {
                                        echo "<option value='" . $promo[0] . "'  >" . $promo[3] . "</option>";
                                    }
									*/
									$row = sqlsrv_fetch_array($sql_promo);

                                    ?>

                                <!--  </select> -->

								<input name="promotion" size="60"  style="background-color:yellow;text-align:center" value="<?php echo $row['PROM_NAME'];?>" disabled>



								</td>
                        </tr>
                    </table>
                </fieldset>
            </td>
            <td valign="top" width="1%">&nbsp;</td>
            <td valign="top" width="45%">


			<!--
                <iframe src="include/cal_result.php" width="97%" scrolling="no" height="182"
                        style="
                 display:block;
                 border:#FFF thin solid;
            " ></iframe>
			-->


<?php
$sql_sum_product  = "SELECT SUM(TEMP.AR_BOD_TOTAL)AS sumprice , (SUM(TEMP.AR_BOD_TOTAL)*7/100)AS sum_vat FROM (SELECT     Book_Order_Detail_Temp.AR_BO_ID, Book_Order_Detail_Temp.AR_BOD_ITEM, Book_Order_Detail_Temp.GOODS_KEY, Book_Order_Detail_Temp.UOM_KEY,
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

$sum_product = sqlsrv_fetch_array(sqlsrv_query($con,$sql_sum_product));
?>




		<form method="post" action="cal_result.php?id=cal">
				<table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#36C; font-size:13px; font-family:Tahoma, Geneva, sans-serif; ">
				  <tr>
					<td>มูลค่าสินค้ารวม</td>
					<td></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="text" name="PRICE" value="<?php echo number_format($sum_product['sumprice'],2); ?>" disabled  id='amount1'></td>
				  </tr>
				  <tr>
					<td><font color="#000000">ส่วนลดตามโปรโมชั่น</font></td>
					<td><input type='text' name='PROMO' size='5'  disabled value='<?php echo number_format( $row['PROM_DISCOUNT'],2);?>' ></td>
					<td>%</td>
					<?php
					$cal_discount = ($sum_product['sumprice']*$row['PROM_DISCOUNT'])/100;
					?>
					<td><input type='text' name='SUMPROMO' size='5'  disabled  value='<?php echo number_format($cal_discount,2);  ?>'  ></td>
					<?php
					$price_promo_total = $sum_product['sumprice'] - $cal_discount;

					?>
					<td><input type="text" name="PRICE_PROMO" disabled value="<?php echo number_format($price_promo_total,2); ?>"></td>
				  </tr>
				  <?php
				   $sql_dis_cash = "SELECT DISC_NAME, DISC_STATUS FROM Discount_Cash WHERE (DISC_STATUS = '1')";
				   $dis_cash = sqlsrv_fetch_array(sqlsrv_query($con,$sql_dis_cash));

				  ?>

				  <tr>
					<td><font color="#000000">ส่วนลดเงินสด</font></td>

					<td><input type='text' name='MONEY' size='5'    value='<?php echo number_format($dis_cash['DISC_NAME'],2); ?>' disabled></td>
					<td>%</td>
					<?php
					$cal_dis_cash = ($price_promo_total * $dis_cash['DISC_NAME'])/100;
					?>

					<td><input type='text' name='SUMMONEY' size='5'   value='<?php echo number_format($cal_dis_cash,2); ?> ' disabled></td>

					<?php
					$total_dis_cash = $price_promo_total - $cal_dis_cash;
					?>


					<td><input type="text" name="PRICE_MONNEY" disabled value="<?php echo number_format($total_dis_cash,2);?>"></td>
				  </tr>

                  <?php
                  $cal_vat = ($total_dis_cash * 7)/100;
                  $vat_total = number_format($cal_vat,2);

                  $cal_total = $total_dis_cash + $cal_vat;
                  $total = number_format($cal_total,2);
                  ?>


				  <script>

				  $(function(){

					var vat;
                    var vat_total ;
                    var total;
                    var select = $('#vat_key option:selected').val();


				    if(select == 'TAXT-01'){
                        vat = 7;
                        $('input[name="vat"]').val(vat);
                        vat_total = '<?php echo $vat_total;?>';
                        total = '<?php echo $total;?>';
                        $('input[name="PRICE_VAT"]').val(vat_total);
                        $('input[name="TOTAL_PRICE"]').val(total );
                    }else{
                        vat = 0;
                        vat_total = '<?php echo number_format(0,2);?>';
                        total = $('input[name="PRICE_MONNEY"]').val();
                        $('input[name="vat"]').val(vat);
                        $('input[name="PRICE_VAT"]').val(vat_total);
                        $('input[name="TOTAL_PRICE"]').val(total);
                    }




                     $('#vat_key').change(function(){

                         select = $('#vat_key option:selected').val();


                         if(select == 'TAXT-01'){
                             vat = 7;
                             $('input[name="vat"]').val(vat);
                             vat_total = '<?php echo $vat_total;?>';
                             total = '<?php echo $total;?>';
                             $('input[name="PRICE_VAT"]').val(vat_total);
                             $('input[name="TOTAL_PRICE"]').val(total);
                         }else{
                             vat = 0;
                             vat_total = '<?php echo number_format(0,2);?>';
                             total = $('input[name="PRICE_MONNEY"]').val();
                             $('input[name="vat"]').val(vat);
                             $('input[name="PRICE_VAT"]').val(vat_total);
                             $('input[name="TOTAL_PRICE"]').val(total);
                         }
                     });
				  });

				  </script>


				  <tr>
					<td>ภาษีมูลค่าเพิ่ม</td>
					<td><input type="text" name="vat" size="5" value="" disabled></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="text" name="PRICE_VAT" disabled value="" ></td>
				  </tr>


				  <tr>
					<td>มูลค่าสุทธิ</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="text" name="TOTAL_PRICE" value="" disabled></td>
				  </tr>
				</table>
		<input type="submit" value=""  class="cal" >
		</form>


    </table>
	</form>



    <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend></legend>
        <input type="reset" value="  " class="Clear">
        <input type="submit" value=" " class="Ok"
               onclick="return confirm('ต้องการบันทึกข้อมูลเลขที่ <?= $_SESSION['key_bo'] ?> ใช่หรือไม่');">
    </fieldset>
    </form>



    <?PHP
    if ($_GET['id'] == md5('addtable')) {
        if ($_POST['trans_etc'] != '') {
            $tranetc = "  อื่นๆ";
        } else {
            $tranetc = " ";
        }
        $sql = "INSERT INTO [Dream_Thai].[dbo].[Book_Order]
           ([AR_BO_ID]
		   ,[AR_BO_KEY]
           ,[DOC_KEY]
           ,[ARF_KEY]
           ,[ADD_ITEM]
           ,[CON_ITEM]
           ,[EMP_KEY]
           ,[PROM_KEY]
           ,[TOF_NAME]
           ,[AR_BO_DATE]
           ,[AR_BO_EX_DATE]
           ,[AR_BO_REMARK]
           ,[AR_BO_MO_TOTAL]
           ,[PROM_DISCOUNT_PER]
           ,[PROM_DISCOUNT_AMOUNT]
           ,[AR_BO_PROM_TOTAL]
           ,[CASH_DISCOUNT_PER]
           ,[CASH_DISCOUNT_AMOUNT]
           ,[AR_BO_CASH_TOTAL]
           ,[AR_BO_TAX]
           ,[AR_BO_TAX_TOTAL]
           ,[AR_BO_NET]
           ,[AR_BO_STATUS]
           ,[TAXT_KEY]
           ,[AR_PUR_STATUS]
           ,[SHIPPING_KEY]
           ,[SHIPPING_REMARK]
           ,[SHIPPING_ADD]
           ,[AR_BO_S_REMARK]
           ,[AR_BO_CREATE_BY]
           ,[AR_BO_CREATE_DATE]
           ,[AR_BO_REVISE_BY]
           ,[AR_BO_APPROVE_BY]
           ,[AR_BO_APPROVE_DATE]
           ,[AR_BO_LASTUPD])
     VALUES
           (" . $_SESSION['id_bo'] . "
           ,'" . $_SESSION['key_bo'] . "'
           ,'" . $doc_keyy . "'
           ,'" . $_POST['arf_key'] . "'
           ,'" . $_SESSION["add_item"] . "'
           ,'" . $_SESSION["con_item"] . "'
           ,'" . $_POST['empkey'] . "'
           ,'" . $_POST['promotion'] . "'
           ," . $_POST['tof_name'] . "
           ,'" . date("Y/m/d H:i:s") . "'
           ,'" . $date_ex . "'
           ,'" . trim($_POST['remark']) . "'
           ," . round($_SESSION['sumprice'], 2) . "
           ," . round($_SESSION['promo_txt_1'], 2) . "
           ," . round($_SESSION['promo_txt_2'], 2) . "
           ," . round($_SESSION['promo_txt_3'], 2) . "
           ," . round($_SESSION['dis_co_txt_1'], 2) . "
           ," . round($_SESSION['dis_co_txt_2'], 2) . "
           ," . round($_SESSION['dis_co_txt_3'], 2) . "
           ,'" . $_SESSION['vat_1'] . "'
           ," . round($_SESSION['vat_2'], 2) . "
           ," . round($_SESSION['total'], 2) . "
           ,1
           ,'" . $_POST['vat_key'] . "'
           ," . $_POST['pur_sta'] . "
           ,'" . $_POST['trans_key'] . "'
           ,'" . trim($_POST['trans_etc'] . "  " . $tranetc) . " '
           ,'" . $_POST['send_pl'] . "'
           ,''
           ,'" . $_POST['empkey'] . "'
           ,'" . date("Y/m/d H:i:s") . "'
           ,''
           ,''
           ,NULL
           ,'" . date("Y/m/d H:i:s") . "')";
        $sql_temp_to_mas = "INSERT INTO [Dream_Thai].[dbo].[Book_Order_Detail]  SELECT * FROM [Dream_Thai].[dbo].[Book_Order_Detail_Temp]
			WHERE [AR_BO_ID] = " . $_SESSION['id_bo'] . " ";
        $chkadd = "SELECT * FROM [Dream_Thai].[dbo].[Book_Order_Detail_Temp] WHERE AR_BO_ID = " . ($_SESSION['id_bo']) . " ;";
        if (sqlsrv_num_rows(sqlsrv_query($con,$chkadd)) > 0) {
            $ap_file1 = sqlsrv_query($con,$sql_temp_to_mas);
            $ap_file2 = sqlsrv_query($con,$sql);
            $ap_file3 = sqlsrv_query($con,"DELETE FROM   Book_Order_Detail_Temp WHERE AR_BO_ID = " . $_SESSION['id_bo'] . "");
        } else {
            echo "ไม่สามารถบันทึกข้อมูลซ้ำอีกได้ได้!!";
            mssql_close();
            echo("<meta http-equiv='refresh' content='3;url= index.php' />");
        }
        if ($ap_file1 == true && $ap_file2 == true && $ap_file3 == true) {
            echo "
			  <table width=\"100%\">
			  	<tr bgcolor = '#d6ffcd'>
			  		<td><font color = '#036d05' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกสำเร็จ</font></td>
				</tr>
			  </table>
			  ";
            echo("<meta http-equiv='refresh' content='3;url= report/report.php' />");
        } else {
            echo "<script>alert(\" ผิดผลาด\")
			   window.close();
		   </script>";
        }
    }
    // echo $_SESSION['id_bo'];
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