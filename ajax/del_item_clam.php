<?php
include "../include/connect.inc.php";
$goods_key = $_POST['goods_key'];
$id_cn = $_POST['id_cn'];

sqlsrv_query($con,"DELETE FROM [Customer_Return_Detail] WHERE AR_CN_ID ='".$id_cn."' AND GOODS_KEY='".$goods_key."'");

?>