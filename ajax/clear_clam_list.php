<?php
ob_start();
@session_start();
include "../include/connect.inc.php";
$sql = "DELETE FROM [Customer_Return_Detail] WHERE  [AR_CN_ID] ='". $_POST['id_cn'] ."'";

sqlsrv_query($con, $sql);

?>