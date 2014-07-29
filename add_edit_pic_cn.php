<?PHP
ob_start();
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<head>
    <!--------------------------------------------------------LIGHTBOX--------------------------------->
    <link rel="stylesheet" href="css/colorbox.css"/>
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery-ui-1.7.2.custom.min.js"></script>
    <script src="js/jquery.colorbox.js"></script>
    <script>
        $(document).ready(function () {
            //Examples of how to assign the ColorBox event to elements
            $(".group1").colorbox({rel: 'group1'});
            $(".group2").colorbox({rel: 'group2', transition: "fade"});
            $(".group3").colorbox({rel: 'group3', transition: "none", width: "75%", height: "75%"});
            $(".group4").colorbox({rel: 'group4', slideshow: true});
            $(".ajax").colorbox();
            $(".youtube").colorbox({iframe: true, innerWidth: 425, innerHeight: 344});
            $(".vimeo").colorbox({iframe: true, innerWidth: 500, innerHeight: 409});
            $(".iframe").colorbox({iframe: true, width: "80%", height: "80%"});
            $(".inline").colorbox({inline: true, width: "50%"});
            $(".callbacks").colorbox({
                onOpen: function () {
                    alert('onOpen: colorbox is about to open');
                },
                onLoad: function () {
                    alert('onLoad: colorbox has started to load the targeted content');
                },
                onComplete: function () {
                    alert('onComplete: colorbox has displayed the loaded content');
                },
                onCleanup: function () {
                    alert('onCleanup: colorbox has begun the close process');
                },
                onClosed: function () {
                    alert('onClosed: colorbox has completely closed');
                }
            });

            //Example of preserving a JavaScript event for inline calls.
            $("#click").click(function () {
                $('#click').css({"background-color": "#f00", "color": "#fff", "cursor": "inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });

            $(document.body).on('change', 'input:file', function () {

                console.log($(this).prop('files'));
                var file_list = $(this).prop('files');


                var input_item = $(this);
                var reader = new FileReader();

                var list_clam_id = input_item.parent().parent().parent().prev().find('td').text();
                var num_pic_clam = input_item.parent().find('.show_pic_clam').children('.pic_item_clam').length + 1;

                var str = input_item.prop('value');
                var arr = str.split("\\");

                reader.readAsDataURL(file_list.item(0));
                reader.onload = function () {


                    var sType = reader.result;
                    var dType = sType.split('/');

                    if (dType[0] != 'data:image') {
                        alert('รูปภาพเท่านั้น!!');
                        return false;

                    }

                    $('.show_pic').prop('src', reader.result).css('display', 'block');
                };
            });


        });
    </script>
    <!--------------------------------------------------------LIGHTBOX--------------------------------->
    <style>
        .addpic {
            background: url(img/uppic.png);
            float: right;
        / / margin-top : 5 px;
        / / margin-left : 15 px;
        / / margin-bottom : 5 px;
            margin-right: 320px;
            border: none;
            display: block;
            width: 94px;
            height: 27px;
            cursor: pointer;
        }

        .back {
            background: url(img/cancle.png);
            float: left;
            margin-top: 5px;
            margin-left: 15px;
            margin-bottom: 5px;
            border: none;
            display: block;
            width: 94px;
            height: 27px;
            cursor: pointer;
        }

        .savepic {
            background: url(img/save_pic.png);
            float: left;
            margin-top: 5px;
            margin-left: 15px;
            margin-bottom: 5px;
            border: none;
            display: block;
            width: 94px;
            height: 27px;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <?PHP include "include/connect.inc.php"; ?>
    <title>BOOKING (Online)</title>
</head>
<body>
<div id="wrapper">
<div class="mian">
<div class="head">
    <?PHP include "include/head.php"; ?>
    <div class="chklogin">
        <?PHP include "include/sessionl_ogin.php"; ?>
    </div>
    <?PHP
    if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {
        ?>
        <div class="menu">
            <?PHP include "include/menu.php"; ?>
        </div>
    <?PHP } ?>
</div>
<div class="content">
    <?PHP if ($_SESSION["user_ses"] != '' && $_SESSION["user_id"] != '') {
        if (isset($_GET['id_item']) == 1) {
            $_SESSION['id_item'] = $_GET['id_item'];
        }

        ?>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
        <legend>รายละเอียดใบเคลมสินค้า</legend>


        <?
        $open = "SELECT * FROM  Customer_Return_Picture
		 WHERE AR_CN_ID = " . $_SESSION['id_cn'] . " AND AR_CND_ITEM = " . $_SESSION['id_item'] . " ORDER BY AR_CNP_ITEM ASC ";
        $result = sqlsrv_query($con, $open);
        $i = 1;

        if (sqlsrv_has_rows($result)):

            ?>
            <table width="100%" border="0" cellspacing="1" cellpadding="0"
            style="color:#FFF; font-size:13px; font-family:Tahoma, Geneva, sans-serif; border:  thin #999 solid; ">
            <tr bgcolor="#333333" height="20">
                <td align="center" width="5%">ลำดับ</td>
                <td align="center" width="35%">รูป</td>
                <td align="center">หมายเหตุ</td>
                <td align="center" width="5%">ลบรูป</td>
            </tr>
            <?PHP


            while ($arr = sqlsrv_fetch_array($result)):
                ?>
                <tr height="25">
                    <td align="center" bgcolor="#888888"><?= $i ?></td>
                    <td align="left" bgcolor="#888888">&nbsp;
                        <a class="group1" href="_pic_file_cn/<?= $arr['AR_CNP_PIC_NAME'] ?>"
                           title="<?= $arr['AR_CNP_PIC_NAME'] ?>">
                            <font color="#FFFFFF"><?= $arr['AR_CNP_PIC_NAME'] ?></font>
                        </a></td>
                    <td align="left" bgcolor="#888888">&nbsp;<?= $arr['AR_CNP_REMARK'] ?></td>
                    <td align="center" bgcolor="#888888">
                        <a href="clear_temp.php?id=<?= md5('del_pic_cn') ?>&gitem=<?= $arr['AR_CNP_ITEM'] ?>&namep=<?= $arr['AR_CNP_PIC_NAME'] ?>&item=<?= $_SESSION['id_item'] ?>"
                           onClick="return confirm('คุณแน่ใจหรือไม่')">
                            <img src="img/del_list.png" border="0"></a></td>
                </tr>
                <?PHP
                $i++;
            endwhile;
        else:
            ?>
            <div style="color: red;text-align: center">ไม่มีรูป!</div>

        <?
        endif;
        ?>
        </table>
        </fieldset>

        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
            <legend>อัพโหลดรูป</legend>
            <form method="post"
                  action="add_edit_pic_cn.php?id_up=<?= $_SESSION['id_cn'] ?>&amp;id_key=<?= md5('add_pic') ?>"
                  name="02" enctype="multipart/form-data">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><input type="file" name="upload" class="uplode">

                            หมายเหตุ
                            <input type="text" name="remark" size="60" class="frominput">
                            <input type="submit" class="addpic" value=""></td>

                    </tr>
                </table>
                <p class="show_pic" style="display: none;color: #000000">ภาพตัวอย่าง</p>

                <div class="show_pic" style="display: none;border:1px dashed #000000 ;width: 200px;height: 150px;">

                    <img class="show_pic" width="200" height="150" src="" style="display: none;"/>

                </div>

            </form>
        </fieldset>
        <!---  <a href="clear_temp.php?id=<?=md5('del_pic_all')?>&item=<?=$_SESSION['id_item']?>&itemp=<?=($i-1)?>" class="clear_list"  onClick="return confirm('คุณแน่ใจหรือไม่')"></a>--->
        <a href="add_edit_pic_cn.php?id=<?= md5('save') ?>" class="savepic"></a>
        <a href="clear_temp.php?id=<?= md5('del_pic_calcle') ?>&item=<?= $_SESSION['id_item'] ?>&itemp=<?= ($i - 1) ?>"
           class="back" onClick="return confirm('คุณแน่ใจหรือไม่')"></a> <BR/>
        <BR/>

        <?PHP
        if ($_REQUEST['id_key'] == md5('add_pic')) {
            if (trim($_FILES["upload"]["tmp_name"]) != "") {
                if ((($_FILES["upload"]["type"] == "image/gif")
                        || ($_FILES["upload"]["type"] == "image/jpeg")
                        || ($_FILES["upload"]["type"] == "image/png")
                        || ($_FILES["upload"]["type"] == "image/pjpeg")) //ภาพจะอัพได้ แค่ 4 นามสกุลเท่านั้น
                    && ($_FILES["upload"]["size"] < 1048576)
                ) { // limit size ได้ไม่เกิน 1 MB
                    if ($_FILES["upload"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["upload"]["error"] . "<br />";
                    } else {
                        if (file_exists("_pic_file_cn/" . $_FILES["upload"]["name"])) {
                            echo $_FILES["upload"]["name"] . " already exists. ";
                        } else {
                            /*$cn_id = "cn_" . $_SESSION['id_cn'] . "_item_";
                            $cn_item = $_SESSION['id_item'] . "_";
                            $day = date("Y-m-dHis");
                            $fnamepic = $cn_id . $cn_item . $day;
                            if ($_FILES["upload"]["type"] == "image/jpeg") {
                                $namepic = $fnamepic . ".jpg";
                            } else if ($_FILES["upload"]["type"] == "image/gif") {
                                $namepic = $fnamepic . ".gif";
                            } else if ($_FILES["upload"]["type"] == "image/png") {
                                $namepic = $fnamepic . ".png";
                            }
                            $pass = "_pic_file_cn/";*/

                            $fp = fopen($_FILES["upload"]["tmp_name"], "r");
                            $ReadBinary = fread($fp,128);
                            fclose($fp);
                            $FileData = addslashes($ReadBinary);
                        }
                   /*     copy($_FILES["upload"]["tmp_name"], "" . $pass . $namepic);*/
                        $item_pic_run = sqlsrv_fetch_array(sqlsrv_query($con, "SELECT ISNULL(MAX(AR_CNP_ITEM),0)+1 AS  AR_CNP_ITEM
		  FROM [Customer_Return_Picture]  WHERE AR_CN_ID = " . $_SESSION['id_cn'] . " AND AR_CND_ITEM = " . $_SESSION['id_item'] . ""));
                     echo $sql = "INSERT INTO [Customer_Return_Picture]
           ([AR_CN_ID]
           ,[AR_CND_ITEM]
           ,[AR_CNP_ITEM]
           ,[AR_CNP_PIC]
           ,[AR_CNP_REMARK]
           ,[AR_CNP_LASTUPD]
           ,[AR_CNP_PIC_NAME])
     VALUES
           (" . $_SESSION['id_cn'] . "
           ," . $_SESSION['id_item'] . "
           ," . $item_pic_run[0] . "
           ,'".$FileData."'
           ,'" . $_POST['remark'] . "'
           ,'" . date("Y/m/d H:i:s") . "'
           ,'" . $_FILES["upload"]["name"] . "');";

                        $stmt = sqlsrv_query($con, $sql);
                        var_dump($stmt);
                        if (sqlsrv_rows_affected($stmt) > 0) {
                            echo "
			  <table width=\"100%\">
			  	<tr bgcolor = '#d6ffcd'>
			  		<td><font color = '#036d05' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกสำเร็จ</font></td>
				</tr>
			  </table>
			  ";
                            echo("<meta http-equiv='refresh' content='1;url= add_edit_pic_cn.php' />");
                        } else {
                            echo "
			  <table width=\"100%\">
			  	<tr bgcolor = '#ffcdcd'>
			  		<td><font color = '#e04b4b' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกผิดผลาด</font></td>
				</tr>
			  </table>
			  ";
                            //	  echo("<meta http-equiv='refresh' content='1;url= add_edit_pic_cn.php' />");
                        }
                    }
                }
            } else {
                echo "
			  <table width=\"100%\">
			  	<tr bgcolor = '#ffcdcd'>
			  		<td><font color = '#e04b4b' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกผิดผลาด</font></td>
				</tr>
			  </table>
			  ";
                //	  echo("<meta http-equiv='refresh' content='1;url= add_edit_pic_cn.php' />");
            }
        }

        if ($_GET['id'] == md5('save')) {
            /*  $sql_temp_to_mas = "INSERT INTO [Customer_Return_Picture]
              SELECT * FROM [Customer_Return_Picture] WHERE [AR_CN_ID] = ".$_SESSION['id_cn']."
              AND  AR_CND_ITEM = ".$_SESSION['id_item']."";
              sqlsrv_query($con,$sql_temp_to_mas);
              sqlsrv_query($con,"DELETE FROM   Customer_Return_Picture WHERE AR_CN_ID = ".$_SESSION['id_cn']."
               AND  AR_CND_ITEM = ".$_SESSION['id_item']."");*/
            echo "<script> window.close();</script>";
            exit();
        }

        ?>
    <?PHP
    } else {
        echo "<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";
    } ?>
</div>
<div class="foot">
    <?PHP include "include/foot.php"; ?>
</div>
</div>
</div>
</body>
</html>