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
    <!--    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css"-->
    <?PHP include "include/connect.inc.php"; ?>
    <title>BOOKING (Online)</title>
    <script src="js/jquery-1.9.1.js"></script>
    <script>
        $(function () {


            $.ajax({
                type: 'post',
                url: 'include/clamTemp.php',
                beforeSend: function (xhr) {
                    xhr.overrideMimeType('content="text/html; charset=tis-620"');
                },
                success: function (data) {
                    $('#clam_detail').html(data);
                }
            });


            $(window).focus(function () {
                $.ajax({
                    type: 'post',
                    url: 'include/clamTemp.php',
                    beforeSend: function (xhr) {
                        xhr.overrideMimeType('content="text/html; charset=tis-620"');
                    },
                    success: function (data) {
                        $('#clam_detail').html(data);
                    }
                });

            });

            $(document.body).on('click', '.del_item_clam', function () {
                var check = confirm('ต้องการลบ ใช่หรือไม่?');
                if (check == true) {
                    var goods_key = $(this).data('goods-key');
                    $.post('ajax/del_item_clam.php', {goods_key: goods_key, id_cn:<?= $_SESSION['id_cn'];?>}, function () {
                        window.location = 'Cn_online.php';

                    });

                }


            });
            $(document.body).on('click', '.clear_list', function () {
                var check = confirm('ต้องการลบทั้งหมด ใช่หรือไม่?');
                if (check == true) {

                    $.post('ajax/clear_clam_list.php', {id_cn:<?= $_SESSION['id_cn'];?>}, function () {
                        window.location = 'Cn_online.php';

                    });

                }


            });

/*
            $('#content2').hide();
            $('#content3').hide();
            $('#content4').hide();
            $('#content5').hide();

            $(document.body).on('click', '.add_cn', function () {
                $('#content2').show();
                $('#content3').show();
                $('#content4').show();
                $('#content5').show();

            });
            */


        });
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
<?PHP
if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {

    $sql_duc = "SELECT     DOC_KEY, MODULE_KEY, DOC_TITLE_NAME, DOC_NAME_THAI, DOC_NAME_ENG, DOC_SET_YEAR, DOC_SET_MONTH, DOC_RUN, DOC_DATE, DOC_REMARK, DOC_STATUS, DOC_CREATE_BY, DOC_REVISE_BY, DOC_LASTUPD, DOC_ISO, DOC_DAR, DOC_COMPANY_NAME_THAI, DOC_COMPANY_NAME_ENG, DOC_ADD, DOC_TEL, DOC_FAX, DOC_TAX, DOC_WEBSITE, DOC_LOGO, DOC_FORMPRINT
FROM  Document_File WHERE (DOC_STATUS = '1') AND (MODULE_KEY = 3)";
    $docrun = sqlsrv_fetch_array(sqlsrv_query($con, $sql_duc));
    $date_ex = date('Y/m/d H:i:s', strtotime("+" . $docrun['DOC_DATE'] . " day"));
    $day = explode("-", date("Y-m-d"));
    if ($docrun[5] == 1) {
        $yy = ($day[0] + 543);
    } else if ($docrun[5] == 2) {
        $yy = ($day[0]);
    } else if ($docrun[5] == 3) {
        $yy = iconv_substr(($day[0] + 543), 2, 4, "UTF-8");
    } else if ($docrun[5] == 4) {
        $yy = iconv_substr($day[0], 2, 4, "UTF-8");
    }
    if ($docrun[6] == 0) {
        $mm = '';
    } else {
        $mm = $day[1];
    }
    $cn_run = sqlsrv_fetch_array(sqlsrv_query($con, "SELECT ISNULL(MAX(AR_CN_ID),0)+1 AS  AR_CN_KEY FROM [Customer_Return] "));
    $_SESSION['id_cn'] = $cn_run[0];
    $cn_id = sprintf("%03d", $cn_run[0]);
    $don_no = "" . $docrun['DOC_TITLE_NAME'] . "-" . $yy . "" . $mm . "-" . $cn_id;
    $_SESSION['clam_doc'] = $don_no;
    ?>
    <form method="post" name="01" action="Cn_online.php?action=save">
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
            <legend>ใบเคลมสินค้า</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td> เลขที่ใบเครมสินค้า
                        <input type="text" name="cn_paper" value="<?= $don_no ?>" size="30" disabled="disabled">
                        <br>
                        ลูกค้า
                        <input type="text" name="cn_key" size="15" value="<?= $_SESSION["clam_cust_arf"] ?>" disabled>
                        &nbsp;&nbsp;
                        <input type="text" name="cn_cust_name" size="30" value="<?= $_SESSION['clam_cust_name'] ?>"
                               disabled>
                        <a href="cust_search.php?clam=true&action=choose_customer" style="margin:0px;"><img
                                src="img/se_c.png"
                                border="0"
                                height="23"/></a> <br>
                        ผู้ติดต่อ
                        <select name="contact" class="frominput">
                            <?php
                            if ($_SESSION['clam_item_contact'] != null) {

                                $sql_contact = "SELECT   Contact.CONT_ITEM, Contact.CONT_TITLE, Contact.CONT_NAME, Contact.CONT_SURNAME, AP_File.APF_KEY, Title_Name.TITLE_NAME_THAI FROM Title_Name INNER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN
AP_File ON Contact.APF_ARF_KEY = AP_File.APF_KEY WHERE  Contact.CONT_STATUS = '1'  AND APF_ARF_KEY = '" . $_SESSION['clam_cust_arf'] . "'";

                                $stmt_contact = sqlsrv_query($con, $sql_contact);
                                while ($ckey = sqlsrv_fetch_array($stmt_contact)) {
                                    if ($ckey['CONT_ITEM'] == $_SESSION['clam_item_contact']) {
                                        $select = "selected='selected' ";
                                    } else {
                                        $select = "";
                                    }
                                    echo "<option value='" . $ckey['CONT_ITEM'] . "' " . $select . ">" . $ckey['TITLE_NAME_THAI'] . "  " . $ckey['CONT_NAME'] . " " . $ckey['CONT_SURNAME'] . "</option>";
                                }
                            } else {
                                echo "<option value=''></option>";
                            }
                            ?>
                            <option value="">------ เลือก-------</option>
                        </select>
                        <BR>
                        พนักงานเคลม

                        <select name="empkey" class="frominput">
                            <?= $emk['EMP_NAME_THAI'] . "  " . $emk['EMP_SURNAME_THAI']; ?>

                            <?PHP
                            $sql_e = sqlsrv_query($con, "SELECT  Employee_File.EMP_KEY,Title_Name.TITLE_NAME_THAI,
													  Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI
 FROM Title_Name INNER JOIN Employee_File ON Title_Name.TITLE_KEY = Employee_File.TITLE_KEY  WHERE  EMP_STATUS  = '1' ORDER BY Employee_File.EMP_NAME_THAI ASC");
                            while ($ekey = sqlsrv_fetch_array($sql_e)) {
                                if ($ekey['EMP_KEY'] == $_SESSION['user_id']) {

                                    $select = 'selected';
                                } else {
                                    $select = '';
                                }

                                echo "<option value='" . $ekey['EMP_KEY'] . "'" . $select . ">" . $ekey['TITLE_NAME_THAI'] . " " . $ekey['EMP_NAME_THAI'] . " " . $ekey['EMP_SURNAME_THAI'] . "</option>";
                            }
                            ?>
                            </option>
                            <option value="">------ เลือก-------</option>
                        </select></td>
                    <td align="left" width="54%"> วันที่สร้างใบเครม
                        <input type="text" name="cn_date" size="30" disabled="disabled" value="<?= date("d/m/Y") ?>">
                        <br>
                        ที่อยู่
                        <?php

                        $sql_address = "SELECT   Address.ADD_ITEM,  Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE,  Address.ADD_MOBILE, Address.ADD_FAX, Address.ADD_EMAIL, Address.ADD_DEFAULT FROM Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1')
					  AND Address.APF_ARF_KEY = '" . $_SESSION['clam_cust_arf'] . "' ";
                        $sql_dbgadd = sqlsrv_query($con, $sql_address);

                        ?>



                        <select name="ADD_ITEM" class="frominput">
                            <?php
                            while ($address = sqlsrv_fetch_array($sql_dbgadd)):
                                $full_address = $address['ADD_NO'] . ' ' . $address['TAMBON_NAME_THAI'] . ' ' . $address['AMPHOE_NAME_THAI'] . ' ' . $address['PROVINCE_NAME_THAI'] . ' ' . $address['TAMBON_POSTCODE'];
                                ?>
                                <option <?= ($address['ADD_ITEM'] == $_SESSION['clam_item_address']) ? 'selected' : ' ' ?>
                                    value="<?= $address['ADD_ITEM']; ?>"><?php echo $full_address; ?></option>
                            <?php endwhile; ?>
                        </select>


                        <br>
                        Tel.
                        <input type="text" name="cn_tel" size="30" disabled="disabled"
                               value="<?= $address['ADD_PHONE']; ?>">
                        &nbsp;&nbsp; FAX.
                        <input type="text" name="cn_fax" size="30" disabled="disabled"
                               value="<?= $address['ADD_FAX'] ?>">
                        <br>
                        ประเภทการเครม
                        <select name="type_re" class="frominput">
                            <?PHP
                            $sql_e = sqlsrv_query($con, "SELECT *FROM [Customer_Return_Type] WHERE (CNT_STATUS = '1')");
                            while ($type_re = sqlsrv_fetch_array($sql_e)) {
                                echo "<option value='" . $type_re['CNT_KEY'] . "' selected=\"selected\" >" . $type_re['CNT_NAME'] . "</option>";
                            }
                            ?>
                            <option value="">------ เลือก-------</option>
                        </select></td>
                </tr>
            </table>

<!--            <button type="button" class="add_cn">เพิ่ม</button>-->


        </fieldset>

        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;" id="content2">

            <legend>

            </legend>
            <div id="clam_detail">
            </div>


            <div class="clear_list"></div>

            <a href="product_search.php?clam=true" target="_blank" class="add_list"></a>
        </fieldset>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top" width="50%">
                    <fieldset style="width:93%; margin-left:11px; margin-bottom:10px;" id="content3">
                        <legend>กรณีที่ยางไม่สามารถเคลมได้</legend>
                        <br>
                        <input type="radio" name="sta_return" checked="checked" value="1">ลุกค้าประสงค์ขอรับยางเคลมคืน
                        <input type="radio" name="sta_return" value="0">ลุกค้าไม่ขอรับยางเคลมคืน
                    </fieldset>
                </td>
                <td valign="top" width="5">
                </td>
                <td valign="top">
                    <fieldset style="width:92%; margin-left:11px; margin-bottom:10px;" id="content4">
                        <legend>หมายเหตุ</legend>
                        <input type="text" name="cn_remark" size="70">
                        &nbsp;&nbsp;
                    </fieldset>
                </td>
            </tr>
        </table>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;" id="content5">
            <legend></legend>
            <input type="reset" value="  " class="Clear">
            <input type="submit" value=" " class="CnOk "
                   onclick="return confirm('ต้องการบันทึกข้อมูลเลขที่ <?= $_SESSION['clam_doc'] ?> ใช่หรือไม่')">
        </fieldset>
    </form>


    <?PHP

    if ($_GET['action'] == 'save') {

       $sql_insert = " INSERT INTO [Customer_Return]
       (
       [AR_CN_ID]
      ,[AR_CN_KEY]
      ,[DOC_KEY]
      ,[ARF_KEY]
      ,[ADD_ITEM]
      ,[CONT_ITEM]
      ,[EMP_KEY]
      ,[AR_CN_DATE]
      ,[CNT_KEY]
      ,[AR_CN_REMARK]
      ,[AR_CN_STATUS]
      ,[AR_CN_S_STATUS]
      ,[AR_CN_QTY]
      ,[AR_CN_YES]
      ,[AR_CN_NO]
      ,[AR_CN_NET]
      ,[AR_CN_CREATE_BY]
      ,[AR_CN_LASTUPD]
      ,[AR_CN_CREATE_DATE]
      )
  VALUES
  (
  " . $_SESSION['id_cn'] . ",
  '" . $_SESSION['clam_doc'] . "',
  'DOC-02',
  '" . $_SESSION["clam_cust_arf"] . "',
  '" . $_POST['ADD_ITEM'] . "',
  '" . $_POST['contact'] . "',
'" . $_POST['empkey'] . "',
'" . date('Y-m-d') . "',
'" . $_POST['type_re'] . "',
'" . $_POST['cn_remark'] . "',
3,
" . $_POST['sta_return'] . ",
" . $_SESSION['num_item_clam'] . ",
0,
0,
0,
'" . $_POST['empkey'] . "',
'" . date('Y-m-d H:i:s') . "',
'" . date('Y-m-d H:i:s') . "'

  )";
        $stmt = sqlsrv_query($con, $sql_insert);
        if (sqlsrv_rows_affected($stmt) > 0) {
            echo '<script>window.open("report/gen_clam.php", "_blank")</script>';
            echo '<script>window.location.href = "Cn_online.php"</script>';

        }
    }
    ?>
<?PHP


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