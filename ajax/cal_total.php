<?php
ob_start();
session_start();
$cal_vat = ($_POST['total_dis_cash'] * $_POST['vat']) / 100;
$total = $_POST['total_dis_cash'] + $cal_vat;
$_SESSION['total'] = $total;
echo number_format($total, 2);
?>
