<?php
include "../include/connect.inc.php";
$sql_promo = sqlsrv_query($con, "SELECT * FROM [Dream_Thai].[dbo].[Promotion]  order by PROM_YEAR DESC , PROM_MONTH DESC");
$row = sqlsrv_fetch_array($sql_promo);


$sql_sum_product = "SELECT SUM(TEMP.AR_BOD_TOTAL)AS sumprice , (SUM(TEMP.AR_BOD_TOTAL)*7/100)AS sum_vat FROM (SELECT     Book_Order_Detail_Temp.AR_BO_ID, Book_Order_Detail_Temp.AR_BOD_ITEM, Book_Order_Detail_Temp.GOODS_KEY, Book_Order_Detail_Temp.UOM_KEY,
Book_Order_Detail_Temp.AR_BOD_GOODS_SELL, Book_Order_Detail_Temp.AR_BOD_GOODS_AMOUNT, Book_Order_Detail_Temp.AR_BOD_GOODS_SUM,
Book_Order_Detail_Temp.AR_BOD_DISCOUNT_PER, Book_Order_Detail_Temp.AR_BOD_DISCOUNT_AMOUNT, Book_Order_Detail_Temp.AR_BOD_TOTAL,
Book_Order_Detail_Temp.AR_BOD_RE_DATE, Book_Order_Detail_Temp.AR_BOD_SO_STATUS, Book_Order_Detail_Temp.AR_BOD_REMARK,
Book_Order_Detail_Temp.AR_BOD_LASTUPD, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, Goods.GOODS_NAME_MAIN,
Goods.GOODS_CODE
FROM         Book_Order_Detail_Temp INNER JOIN
Goods ON Book_Order_Detail_Temp.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
Goods_Price_List ON Book_Order_Detail_Temp.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
Units_of_Measurement ON Book_Order_Detail_Temp.UOM_KEY = Units_of_Measurement.UOM_KEY)AS TEMP
WHERE TEMP.AR_BO_ID = " . $_SESSION['id_bo'] . " ";

@$sum_product = sqlsrv_fetch_array(sqlsrv_query($con, $sql_sum_product));
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0"
       style="color:#36C; font-size:13px; font-family:Tahoma, Geneva, sans-serif; ">
    <tr>
        <td>มูลค่าสินค้ารวม</td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
            <input type="text" name="PRICE"
                   value="<?php echo number_format($sum_product['sumprice'], 2); ?>" disabled
                   id='amount1'></td>
    </tr>
    <tr>
        <td><font color="#000000">ส่วนลดตามโปรโมชั่น</font></td>
        <td><input type='text' name='PROMO' size='5' disabled
                   value='<?php echo number_format($row['PROM_DISCOUNT'], 2); ?>'></td>
        <td>%</td>
        <?php
        $cal_discount = ($sum_product['sumprice'] * $row['PROM_DISCOUNT']) / 100;
        ?>
        <td><input type='text' name='SUMPROMO' size='5' disabled
                   value='<?php echo number_format($cal_discount, 2); ?>'></td>
        <?php
        $price_promo_total = $sum_product['sumprice'] - $cal_discount;

        ?>
        <td><input type="text" name="PRICE_PROMO" disabled
                   value="<?php echo number_format($price_promo_total, 2); ?>"></td>
    </tr>
    <?php
    $sql_dis_cash = "SELECT DISC_NAME, DISC_STATUS FROM Discount_Cash WHERE (DISC_STATUS = '1')";
    $dis_cash = sqlsrv_fetch_array(sqlsrv_query($con, $sql_dis_cash));

    ?>

    <tr>
        <td><font color="#000000">ส่วนลดเงินสด</font></td>

        <td><input type='text' name='MONEY' size='5'
                   value='<?php echo number_format($dis_cash['DISC_NAME'], 2); ?>' disabled></td>
        <td>%</td>
        <?php
        $cal_dis_cash = ($price_promo_total * $dis_cash['DISC_NAME']) / 100;
        ?>

        <td><input type='text' name='SUMMONEY' size='5'
                   value='<?php echo number_format($cal_dis_cash, 2); ?> ' disabled></td>

        <?php
        $total_dis_cash = $price_promo_total - $cal_dis_cash;
        ?>


        <td><input type="text" name="PRICE_MONNEY" disabled
                   value="<?php echo number_format($total_dis_cash, 2); ?>"></td>
    </tr>

    <tr>
        <td>ภาษีมูลค่าเพิ่ม</td>
        <td><input type="text" name="vat" size="5" value="0"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text" name="PRICE_VAT" disabled value=""></td>
    </tr>

    <tr>
        <td>มูลค่าสุทธิ</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="text" name="TOTAL_PRICE" value="" disabled
                   style="background-color: yellow"></td>
    </tr>

</table>

    <script>
        $(function () {

            var vat;
            var total_dis_cash = <?php echo $total_dis_cash;?>;

            vat = $('input[name="vat"]').val();
            $.post('ajax/cal_vat.php', {vat: vat, total_dis_cash: total_dis_cash}, function (data) {
                $('input[name="PRICE_VAT"]').val(data);
            });

            $.post('ajax/cal_total.php', {vat: vat, total_dis_cash: total_dis_cash}, function (data) {
                $('input[name="TOTAL_PRICE"]').val(data);
            });


            $('input[name="vat"]').keyup(function () {
                vat = $(this).val();
                $.post('ajax/cal_vat.php', {vat: vat, total_dis_cash: total_dis_cash}, function (data) {
                    $('input[name="PRICE_VAT"]').val(data);
                });

                $.post('ajax/cal_total.php', {vat: vat, total_dis_cash: total_dis_cash}, function (data) {
                    $('input[name="TOTAL_PRICE"]').val(data);
                });

            });




        });
    </script>

<?php
//set variable session for add to database

$_SESSION['sumprice'] = $sum_product['sumprice'];
$_SESSION['promo_txt_1'] = $row['PROM_DISCOUNT'];
$_SESSION['promo_txt_2'] = $cal_discount;
$_SESSION['promo_txt_3'] = $price_promo_total;
$_SESSION['dis_co_txt_1'] = $dis_cash['DISC_NAME'];
$_SESSION['dis_co_txt_2'] = $cal_dis_cash;
$_SESSION['dis_co_txt_3'] = $total_dis_cash;
//$_SESSION['vat_1'];
//$_SESSION['vat_2'];
//$_SESSION['total'];

?>