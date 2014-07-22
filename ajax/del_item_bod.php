<?php
ob_start();
@session_start();
include "../include/connect.inc.php";

$bod_item = iconv('UTF-8', 'TIS-620', $_POST['bod_item']);

$sql = "DELETE FROM [Book_Order_Detail] WHERE  [AR_BO_ID] ='" . $_SESSION['id_bo'] . "'  AND [AR_BOD_ITEM] = '" . $bod_item . "'";

sqlsrv_query($con, $sql);

?>