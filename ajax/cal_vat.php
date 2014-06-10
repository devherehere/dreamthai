<?php
$cal_vat = ($_POST['total_dis_cash'] * $_POST['vat'])/100;
echo  number_format($cal_vat,2);

?>