<style>
    .refesh {
        background:url(../img/ref.png);
        float:right;
        margin-top:5px;
        margin-right:0px;
        margin-bottom:5px;
        border:none;
        display:block;
        width:94px;
        height:26px;
        cursor:pointer;
    }
</style>
<?PHP
ob_start();
@session_start();
include"connect.inc.php";
?>
<?PHP
$sql = "SELECT        Customer_Return_Detail.AR_CN_ID, Customer_Return_Detail.AR_CND_ITEM, Customer_Return_Detail.GOODS_KEY, Units_of_Measurement.UOM_NAME,
                         Customer_Return_Detail.SERIAL_NUMBER, Goods.GOODS_NAME_MAIN, Goods.GOODS_CODE, Customer_Return_Detail.AR_CND_REMAIN,
                         Customer_Return_Detail.AR_CND_DOT, Customer_Return_Detail.AR_CND_DETAIL, Customer_Return_Detail.AR_CND_REMAIN AS Expr1,
                         Units_of_Measurement.UOM_KEY
FROM            Customer_Return_Detail LEFT OUTER JOIN
                         Goods ON Customer_Return_Detail.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                         Units_of_Measurement ON Customer_Return_Detail.UOM_KEY = Units_of_Measurement.UOM_KEY
WHERE        (Customer_Return_Detail.AR_CN_ID = ".$_SESSION['id_cn'].")";


$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$result = sqlsrv_query($con, $sql, $params, $options );
$row_count = sqlsrv_num_rows($result);

$_SESSION['num_item_clam'] = $row_count;

if (sqlsrv_has_rows($result) == true):
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF; font-size:13px; font-family:Tahoma, Geneva, sans-serif; border:  thin #999 solid; ">
        <tr bgcolor="#333333" height="20">
            <td align="center" >ลำดับ</td>
            <td align="center">รหัสสินค้า</td>
            <td align="center">ชื่อสินค้า</td>
            <td align="center">หน่วย</td>
            <td align="center">Serial Number</td>
            <td align="center">ดอกยางที่เหลือ<BR>(.mm)</td>
            <td align="center">อาการที่รับเคลม</td>

            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <?PHP
        $j = 1;

        while ($reccord = sqlsrv_fetch_array($result)) {
            ?>
            <tr bgcolor="#7f7f7f" height="20">
                <td align="center" ><?= $j ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['GOODS_CODE'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['GOODS_NAME_MAIN'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['UOM_NAME'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['SERIAL_NUMBER'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['AR_CND_REMAIN'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['AR_CND_DETAIL'] ?></td>
                <td align="center" bgcolor="#888888">
                    <a href="<?= BASE_URL;?>add_edit_pic_cn.php?id_item=<?= $reccord['AR_CND_ITEM'] ?>&goods_code=<?= $reccord['GOODS_CODE'];?>" target="_blank"  ><img src="<?= BASE_URL;?>img/pic.png" border="0"></a>
                </td>
                <td align="center">
                    <a href="<?= BASE_URL;?>edit_cn.php?goods_key=<?= $reccord['GOODS_KEY'] ?>&item=<?= $reccord['AR_CND_ITEM'] ?>"  target="_blank" >
                        <img src="<?= BASE_URL;?>img/edt_list.png" border="0"></a>
                </td>
                <td align="center">
                        <img src="<?= BASE_URL;?>img/del_list.png" border="0" class="del_item_clam" style="cursor: pointer;" data-goods-key="<?= $reccord['GOODS_KEY']; ?>">
                </td>
            </tr>
            <?PHP
            $j++;
            $_SESSION['max_cn'] = $j - 1;
        }
    else:
        ?>
        <div style="color: red;text-align: center;">ยังไม่ได้เพิ่มรายการ!</div>
    <?php
    endif;
    ?>
    <!---WHILE LOOP-->
</table>

