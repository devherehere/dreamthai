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
    <?PHP
    include "include/connect.inc.php";?>
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
    <div class="menu">
        <?PHP include "include/menu.php"; ?>
    </div>
</div>
<div class="content">
<?PHP  if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != ''){
if (@$_GET['id_search'] != "") {
    $sql_ss = "SELECT  [ARF_KEY]
      ,[BT_KEY]
      ,[ARF_COMPANY_NAME_THAI]
      ,[ARF_COMPANY_NAME_ENG]
      ,[ARF_COMPANY_PIC]
      ,[ARF_TAX_ID]
	  ,[ARF_TYPE],
	  CASE ARF_TYPE
	  WHEN 1 THEN 'ลูกหนี้การค้าในประเทศ'
	  WHEN 2 THEN 'ลูกหนี้การค้าต่างประเทศ'
	  WHEN 3 THEN 'ลูกหนี้การค้าอื่นๆ'
	  END AS ARF_TYPE_NAME

      ,[ARF_CREDIT_LIMIT]
      ,[ARF_CREDIT_STATUS],
	  CASE ARF_CREDIT_STATUS
	  WHEN 0 THEN 'ไม่อนุมัติ'
	  WHEN 1 THEN 'รอการพิจารณา'
	  WHEN 2 THEN 'อนุมัติ'
	  WHEN 3 THEN 'ยกเลิก'
	  END AS ARF_CREDIT_STATUS_NAME
      ,[ARF_REMARK]
      ,[CURNCY_KEY]
      ,[ARF_STATUS],
	  CASE ARF_STATUS
	  WHEN 0 THEN 'ติดต่อไม่ได้'
	  WHEN 1 THEN 'ติดต่อได้'
	  WHEN 2 THEN 'ยกเลิกการขาย'
	  WHEN 3 THEN 'เลิกกิจการ'
	  END AS ARF_STATUS_NAME
      ,[ARF_CREATE_BY]
      ,[ARF_CREATE_DATE]
      ,[ARF_REVISE_BY]
      ,[ARF_LASTUPD]
      ,[ARF_REASON_APPROVE]
      ,[ARF_APPROVE_BY]
      ,[ARF_APPROVE_DATE]
  FROM [Dream_Thai].[dbo].[AR_File]
  WHERE  ARF_KEY = '" . $_GET['id_search'] . "'";
    $arr_ss = sqlsrv_fetch_array(sqlsrv_query($con, $sql_ss));
}
?>
<?PHP
$add = md5('add');
?>
<?PHP
@$temp_ac = $_GET['id_action'];
if ($temp_ac == md5('1')){
?>
<form method="post" name="01" action="index.php?id=<?= $add ?>">
    <?PHP
    }else if ($temp_ac == md5('2')){
    ?>
    <form method="post" name="01" action="Cn_online.php?id=<?= $add ?>">
        <?PHP
        }else{
        ?>
        <form method="post" name="01" action="#">
            <?PHP
            }
            ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="middle">
                        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
                            <legend>ค้นหาลูกค้า</legend>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td> ชื่อลูกค้า
                                        <input type="text" name="cust_arf" value="<?= @$arr_ss['ARF_KEY']; ?>"
                                               size="20">
                                        <input type="text" name="cust_name"
                                               value="<?= @$arr_ss['ARF_COMPANY_NAME_THAI']; ?>" size="50">
                                        <a href="cust_search.php?tmp=<?= @$temp_ac ?>"><img src="img/se_c.png"
                                                                                            border="0"/></a>
                                        ประเภทลูกค้า
                                        <input type="text" name="cust_type" value="<?= @$arr_ss['ARF_TYPE_NAME']; ?>" size="20">
                                        <BR>
                                        สถานะการอนุมัติวงเงิน
                                        <input type="text" name="cust_credit_conf"
                                               value="<?= @$arr_ss['ARF_CREDIT_STATUS_NAME']; ?>" size="20">
                                        วงเงินเครดิต
                                        <input type="text" name="cust_credit" style="text-align:right;"
                                               value="<?= number_format(@$arr_ss['ARF_CREDIT_LIMIT'], 2); ?>" size="20">
                                        สถานะ
                                        <input type="text" name="cust_sta" value="<?= @$arr_ss['ARF_STATUS_NAME']; ?>" size="20">
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
                            <legend>รายละเอียดลูกค้า</legend>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="0"
                                               style="color:#FFF;">
                                            <tr bgcolor="#333333" height="30">
                                                <td align="center" width="35px">ลำดับ</td>
                                                <td align="center">ที่อยู่</td>
                                                <td align="center">Tel.</td>
                                                <td align="center">Fax.</td>
                                                <td align="center">E-mail</td>
                                                <td align="center" width="55px">ตัวเลือก</td>
                                            </tr>
                                            <?PHP
                                            if (@$_GET['id_search'] != "") {
                                                $sql_dbgadd = "SELECT     Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI,
                      Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, 
                      Address.ADD_MOBILE, Address.ADD_FAX, Address.ADD_EMAIL, Address.ADD_DEFAULT
FROM         Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1')AND (AR_File.ARF_KEY = '" . $_GET['id_search'] . "')";
                                                $i = 1;
                                                $sql_dbgadd1 = sqlsrv_query($con, $sql_dbgadd);
                                                while ($dbgadd = sqlsrv_fetch_array($sql_dbgadd1)) {
                                                    if ($dbgadd['ADD_DEFAULT'] == TRUE) {
                                                        $chkked = 'checked="checked"';
                                                    } else {
                                                        $chkked = '';
                                                    }
                                                    ?>
                                                    <tr bgcolor="#CCCCCC" height="30">
                                                        <td align="center" width="35px"
                                                            bgcolor="#888888"><?= $i; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= " " . $dbgadd['ADD_NO'] . " " . $dbgadd['TAMBON_NAME_THAI'] . "  " . $dbgadd['AMPHOE_NAME_THAI'] . "  " . $dbgadd['PROVINCE_NAME_THAI'] . " " . $dbgadd['TAMBON_POSTCODE']; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgadd['ADD_MOBILE']; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgadd['ADD_FAX']; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgadd['ADD_EMAIL']; ?></td>
                                                        <td align="center" bgcolor="#888888"><input type="radio"
                                                                                                    name="item_address"
                                                                                                    value="<?= $dbgadd[2]; ?>"  <?= $chkked; ?> />
                                                        </td>
                                                    </tr>
                                                    <?PHP
                                                    $i = $i + 1;
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="ar_key_add" value="<?= $_GET['id_search'] ?>">
                                        </table>
                                        <BR></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="0"
                                               style="color:#FFF;">
                                            <tr bgcolor="#333333" height="30">
                                                <td align="center" width="35px">ลำดับ</td>
                                                <td align="center">ชื่อผู้ติดต่อ</td>
                                                <td align="center">แผนก</td>
                                                <td align="center">Tel.</td>
                                                <td align="center">E-mail</td>
                                                <td align="center" width="55px">ตัวเลือก</td>
                                            </tr>
                                            <?PHP
                                            if (@$_GET['id_search'] != "") {
                                                $sql_dbgcont = sqlsrv_query($con, "SELECT     Contact.CONT_TITLE, Title_Name.TITLE_NAME_THAI, Contact.CONT_NAME, Contact.CONT_SURNAME, Contact.CONT_DEPT, Contact.CONT_PHONE,   Contact.CONT_EMAIL, AR_File.ARF_KEY, Contact.CONT_ITEM, Contact.CONT_DEFAULT
FROM         Title_Name LEFT OUTER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN AR_File ON Contact.APF_ARF_KEY = AR_File.ARF_KEY  WHERE (Contact.CONT_STATUS = '1') AND (Contact.APF_ARF_KEY = '" . $_GET['id_search'] . "')");
                                                $j = 1;
                                                while ($dbgcont = sqlsrv_fetch_array($sql_dbgcont)) {
                                                    if ($dbgcont['CONT_DEFAULT'] == TRUE) {
                                                        $chkked2 = 'checked="checked"';
                                                    } else {
                                                        $chkked2 = '';
                                                    }
                                                    ?>
                                                    <tr bgcolor="#CCCCCC" height="30">
                                                        <td align="center" width="35px"
                                                            bgcolor="#888888"><?= $j; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgcont[1] . " " . $dbgcont[2] . " " . $dbgcont[3] . ""; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgcont[4]; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgcont[5]; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgcont[6]; ?></td>
                                                        <td align="center" bgcolor="#888888"><input type="radio"
                                                                                                    name="item_contact"
                                                                                                    value="<?= $dbgcont[0]; ?>" <?= $chkked2; ?> />
                                                        </td>
                                                    </tr>
                                                    <?PHP
                                                    $j = $j + 1;
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="cn_key_add" value="<?= $_GET['id_search'] ?>">
                                        </table>
                                        <BR></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="1" cellpadding="0"
                                               style="color:#FFF; ">
                                            <tr bgcolor="#333333" height="30">
                                                <td align="center" width="35px">ลำดับ</td>
                                                <td align="center">สถานะการขาย</td>
                                                <td align="center">เงื่อนไขการชำระ</td>
                                                <td align="center">ประเภทภาษี</td>
                                                <td align="center" width="55px">ตัวเลือก</td>
                                            </tr>
                                            <?PHP
                                            if (@$_GET['id_search'] != "") {
                                                $sql_dbgpay = sqlsrv_query($con, "SELECT   DISTINCT   AR_File.ARF_KEY, CASE Condition_Payment.COND_PUR_STATUS WHEN 0 THEN 'ขายสด'
			WHEN 1 THEN 'ขายเชื่อ' END AS STATUS, Condition_Payment.TOF_NAME, Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY,    	
			Condition_Payment.COND_ITEM, Condition_Payment.COND_DEFAULT  FROM         Tax_Type INNER JOIN
            Condition_Payment ON Tax_Type.TAXT_KEY = Condition_Payment.TAXT_KEY RIGHT OUTER JOIN  
			AR_File ON Condition_Payment.APF_ARF_KEY = AR_File.ARF_KEY  WHERE  (Condition_Payment.COND_STATUS = '1')");
                                                $k = 1;
                                                while ($dbgpay = sqlsrv_fetch_array($sql_dbgpay)) {
                                                    if ($dbgpay['COND_DEFAULT'] == TRUE) {
                                                        $chkked3 = 'checked="checked"';
                                                    } else {
                                                        $chkked3 = '';
                                                    }
                                                    ?>
                                                    <tr bgcolor="#CCCCCC" height="30">
                                                        <td align="center" width="35px"
                                                            bgcolor="#888888"><?= $k; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgpay[1]; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgpay[2]; ?></td>
                                                        <td align="left" bgcolor="#888888">&nbsp;
                                                            <?= $dbgpay[3]; ?></td>
                                                        <td align="center" bgcolor="#888888"><input type="radio"
                                                                                                    name="item_pay"
                                                                                                    value="<?= $dbgpay[2]; ?>" <?= $chkked3; ?> />
                                                        </td>
                                                    </tr>
                                                    <?PHP
                                                    $k = $k + 1;
                                                }
                                            }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <input type="reset" class="Xcloase" value="">
                        <input type="submit" class="cinfirm" value="">
        </form>
        <a href="add_newcust.php" class="add_con" target="_blank"></a>
        </td>
        </tr>
        </table>
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