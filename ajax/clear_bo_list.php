<?php
ob_start();
@session_start();
include "../include/connect.inc.php";
$sql = "DELETE FROM [Book_Order_Detail] WHERE  [AR_BO_ID] ='". $_POST['id_bo'] ."'";

sqlsrv_query($con, $sql);

?>