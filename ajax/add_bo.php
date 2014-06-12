<?PHP
ob_start();
@session_start();
include "../include/connect.inc.php";

if ($_POST['trans_etc'] != '') {
    $tranetc = "  อื่นๆ";
} else {
    $tranetc = " ";
}

$send_pl = iconv('UTF-8','TIS-620',$_POST['send_pl']);
$trans_etc = iconv('UTF-8','TIS-620',$_POST['trans_etc']);
$remark =iconv('UTF-8','TIS-620',$_POST['remark']);

 echo $sql = "INSERT INTO [Dream_Thai].[dbo].[Book_Order]
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
           ,'" . $_SESSION['doc_keyy'] . "'
           ,'" . $_POST['arf_key'] . "'
           ,'" . $_SESSION["add_item"] . "'
           ,'" . $_SESSION["con_item"] . "'
           ,'" . $_POST['empkey'] . "'
           ,'" . $_POST['promotion'] . "'
           ," . $_POST['tof_name'] . "
           ,'" . date("Y/m/d H:i:s") . "'
           ,'" . $date_ex . "'
           ,'" .$remark . "'
           ," . round($_SESSION['sumprice'], 2) . "
           ," . round($_SESSION['promo_txt_1'], 2) . "
           ," . round($_SESSION['promo_txt_2'], 2) . "
           ," . round($_SESSION['promo_txt_3'], 2) . "
           ," . round($_SESSION['dis_co_txt_1'], 2) . "
           ," . round($_SESSION['dis_co_txt_2'], 2) . "
           ," . round($_SESSION['dis_co_txt_3'], 2) . "
           ,'" . $_POST['vat'] . "'
           ," . round($_SESSION['vat_2'], 2) . "
           ," . round($_SESSION['total'], 2) . "
           ,1
           ,'" . $_POST['vat_key'] . "'
           ," . $_POST['pur_sta'] . "
           ,'" . $_POST['trans_key'] . "'
           ,'" . $trans_etc . "  " . $tranetc . " '
           ,'" . $send_pl . "'
           ,''
           ,'" . $_POST['empkey'] . "'
           ,'" . date("Y/m/d H:i:s") . "'
           ,''
           ,''
           ,NULL
           ,'" . date("Y/m/d H:i:s") . "')";

$ap_file2 = sqlsrv_query($con, $sql);

$sql_temp_to_mas = "INSERT INTO [Dream_Thai].[dbo].[Book_Order_Detail]  SELECT * FROM [Dream_Thai].[dbo].[Book_Order_Detail_Temp]
			WHERE [AR_BO_ID] = " . $_SESSION['id_bo'] . " ";

$chkadd = "SELECT * FROM [Dream_Thai].[dbo].[Book_Order_Detail_Temp] WHERE AR_BO_ID = " . ($_SESSION['id_bo']) . " ;";

$stmt = sqlsrv_query($con, $chkadd);
if (sqlsrv_has_rows($stmt) ) {

    $ap_file1 = sqlsrv_query($con, $sql_temp_to_mas);
    $ap_file3 = sqlsrv_query($con, "DELETE FROM   Book_Order_Detail_Temp WHERE AR_BO_ID = " . $_SESSION['id_bo'] . "");
} else {
    echo "ไม่สามารถบันทึกข้อมูลซ้ำอีกได้!!";
    sqlsrv_close($con);
    //echo("<meta http-equiv='refresh' content='3;url= index.php' />");
}


/*if ($ap_file1 == true && $ap_file2 == true && $ap_file3 == true) {
    echo "
			  <table width=\"100%\">
			  	<tr bgcolor = '#d6ffcd'>
			  		<td><font color = '#036d05' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกสำเร็จ</font></td>
				</tr>
			  </table>
			  ";
    //echo("<meta http-equiv='refresh' content='3;url= report/report.php' />");
} else {
    echo "<script>
alert(\" ผิดผลาด\");
			   //window.close();
		   </script>";
}*/



?>
