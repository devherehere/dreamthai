<?PHP

ob_start();
@session_start();

include "connect.inc.php";

$sql = "SELECT        Book_Order_Detail.AR_BO_ID, Book_Order_Detail.AR_BOD_ITEM, Book_Order_Detail.UOM_KEY, Book_Order_Detail.AR_BOD_GOODS_SELL,
                         Book_Order_Detail.AR_BOD_GOODS_AMOUNT, Book_Order_Detail.AR_BOD_GOODS_SUM, Book_Order_Detail.AR_BOD_DISCOUNT_PER,
                         Book_Order_Detail.AR_BOD_DISCOUNT_AMOUNT, Book_Order_Detail.AR_BOD_TOTAL, Book_Order_Detail.AR_BOD_RE_DATE,
                         Book_Order_Detail.AR_BOD_SO_STATUS, Book_Order_Detail.AR_BOD_REMARK, Book_Order_Detail.AR_BOD_LASTUPD, Goods.GOODS_NAME_MAIN,
                         Goods.GOODS_CODE, Book_Order_Detail.GOODS_KEY, Units_of_Measurement.UOM_NAME, Goods_Price_List.GPL_PRICE, Goods_Price_List.GPL_STATUS
FROM            Goods INNER JOIN
                         Goods_Price_List ON Goods.GOODS_KEY = Goods_Price_List.GOODS_KEY LEFT OUTER JOIN
                         Units_of_Measurement ON Goods.UOM_KEY = Units_of_Measurement.UOM_KEY RIGHT OUTER JOIN
                         Book_Order_Detail ON Goods.GOODS_KEY = Book_Order_Detail.GOODS_KEY
WHERE        (Book_Order_Detail.AR_BO_ID = '" . $_SESSION['id_bo'] . "') AND (Goods_Price_List.GPL_STATUS = 1) ";
$params = array();
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$result = sqlsrv_query($con, $sql, $params, $options);
$num_rows = sqlsrv_num_rows($result);
header("Content-Type:text/plain;charset=tis-620");
if (sqlsrv_has_rows($result)):

?>

<div style="margin-bottom: 5px;">จำนวนที่เลือก [<?php echo $num_rows ?>]</div>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="color:#FFF; font-size:13px;  ">
    <tr bgcolor="#333333" height="20">
        <td align="center">ลำดับ</td>
        <td align="center">รหัสสินค้า</td>
        <td align="center">ชื่อสินค้า</td>
        <td align="center">หน่วย</td>
        <td align="center">จำนวนที่จอง</td>
        <td align="center">ราคา/หน่วย</td>
        <td align="center">จำนวนเงิน</td>
        <td align="center">ส่วนลด%</td>
        <td align="center">จำนวนเงิน<br>
            หลังหักส่วนลด
        </td>
        <td align="center">วันที่<br>
            ต้องการสินค้า
        </td>
        <td align="center">หมายเหตุ</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <?PHP
    $j = 1;

    while (@$reccord = sqlsrv_fetch_array($result)) :
        ?>
        <tr bgcolor="#7f7f7f" height="20">
            <td align="center" name="bod_item"><?= $reccord['AR_BOD_ITEM']; ?></td>
            <td align="left" bgcolor="#888888">&nbsp;
                <?= $reccord['GOODS_CODE'] ?></td>
            <td align="left" bgcolor="#888888">&nbsp;
                <?= $reccord['GOODS_NAME_MAIN'] ?></td>
            <td align="left" bgcolor="#888888">&nbsp;
                <?= $reccord['UOM_NAME'] ?></td>
            <td align="right" bgcolor="#888888">&nbsp;
                <?= number_format($reccord['AR_BOD_GOODS_AMOUNT'], 2); ?></td>
            <td align="right" bgcolor="#888888">&nbsp;
                <?= number_format($reccord['GPL_PRICE'], 2); ?></td>
            <td align="right" bgcolor="#888888">&nbsp;
                <?= number_format($reccord['AR_BOD_GOODS_SUM'], 2); ?></td>
            <td align="right" bgcolor="#888888">&nbsp;
                <?= number_format($reccord['AR_BOD_DISCOUNT_PER'], 2); ?></td>
            <td align="right" bgcolor="#888888">&nbsp;
                <?= number_format($reccord['AR_BOD_TOTAL'], 2); ?></td>
            <td align="center" bgcolor="#888888">&nbsp;

                <?php

                //echo @date("d/m/Y",strtotime($reccord['AR_BOD_RE_DATE']));
                echo $reccord['AR_BOD_RE_DATE']->format('d/m/Y');
                ?>
            </td>
            <td align="left" bgcolor="#888888">&nbsp;
                <?= $reccord['AR_BOD_REMARK'] ?></td>
            <td align="center"><a
                    href="<?php echo BASE_URL; ?>edit_rent.php?goods_key=<?= $reccord['GOODS_KEY']; ?>"
                    target="_blank"> <img src="<?php echo BASE_URL; ?>img/edt_list.png"></a></td>
            <td align="center">
                <div style="cursor: pointer" class="del_item_bo">
                    <img src="<?php echo BASE_URL; ?>img/del_list.png">
                </div>
            </td>
        </tr>
        <?PHP
        $j++;
    endwhile;
    else:
        ?>
        <div style="text-align: center;color: red">ยังไม่ได้เพิ่มรายการ!</div>
    <?php
    endif;
    ?>


</table>
