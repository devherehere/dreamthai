<?php
ob_start();
session_start();
$cal_vat = ($_POST['total_dis_cash'] * $_POST['vat']) / 100;
$_SESSION['vat_2'] = $cal_vat;
echo number_format($cal_vat, 2);
?>


