<?PHP
ob_start();
@session_start();
include "../include/connect.inc.php";


$sql_add_temp = "INSERT INTO [Book_Order_Detail_Temp]
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

$ap_file1 = sqlsrv_query($con, $sql_add_temp);

?>