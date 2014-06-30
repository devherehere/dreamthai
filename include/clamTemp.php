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
$sql = "SELECT  Customer_Return_Detail.AR_CN_ID, Customer_Return_Detail.AR_CND_ITEM, Customer_Return_Detail.GOODS_KEY, 
                      Units_of_Measurement.UOM_NAME, Customer_Return_Detail.SERIAL_NUMBER, Goods.GOODS_NAME_MAIN, Goods.GOODS_CODE, 
                      Customer_Return_Detail.AR_CND_REMAIN, Customer_Return_Detail.AR_CND_DOT, Customer_Return_Detail.AR_CND_DETAIL, Customer_Return_Detail.AR_CND_REMAIN, Units_of_Measurement.UOM_KEY
FROM         Customer_Return_Detail INNER JOIN
                      Goods ON Customer_Return_Detail.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Customer_Return_Detail.UOM_KEY = Units_of_Measurement.UOM_KEY
					  WHERE Customer_Return_Detail.AR_CN_ID = " . $_SESSION['id_cn'] . " ";
$result = sqlsrv_query($con, $sql);
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
            <td align="center" width="15%">หมายเหตุ</td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        <?PHP
        $j = 1;

        while ($reccord = mssql_fetch_array($result)) {
            ?>
            <tr bgcolor="#7f7f7f" height="20">
                <td align="center" ><?= $j ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['GOODS_CODE'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['GOODS_NAME_MAIN'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['UOM_NAME'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['SERIAL_NUMBER'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['AR_CND_REMAIN'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['AR_CND_DETAIL'] ?></td>
                <td align="left" bgcolor="#888888">&nbsp;<?= $reccord['AR_CND_REMARK'] ?></td>
                <td align="center" bgcolor="#888888"> 
                    <a href="../add_edit_pic_cn.php?id_item=<?= $reccord['AR_CND_ITEM'] ?>" target="_blank"  ><img src="../img/pic.png" border="0"></a>
                </td>
                <td align="center">
                    <a href="../process_cn.php?ide=<?= md5('fu313') ?>&gkey=<?= $reccord['GOODS_KEY'] ?>&item=<?= $reccord['AR_CND_ITEM'] ?>"  target="_blank" >
                        <img src="../img/edt_list.png" border="0"></a>
                </td>
                <td align="center">
                    <a href="../clear_temp.php?id=<?= md5('del313') ?>&gitem=<?= $reccord['AR_CND_ITEM'] ?>"  target="_blank" onClick="return confirm('คุณแน่ใจหรือไม่')">
                        <img src="../img/del_list.png" border="0"></a>
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

