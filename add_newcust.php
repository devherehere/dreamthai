<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(function(){
	$("select#list1").change(function(){
		var datalist2 = $.ajax({	
			  url: "state.php", 
			  data:"list1="+$(this).val(),
			  async: false
		}).responseText;		
	$("select#list2").html(datalist2); 	
	});
	$("select#list2").change(function(){
		var datalist3 = $.ajax({
			  url: "state.php", 
			  data:"list2="+$(this).val(),
			  async: false
		}).responseText;		
	$("select#list3").html(datalist3); 
	});
	$("select#list3").change(function(){
		var datalist4 = $.ajax({
			  url: "state.php", 
			  data:"list3="+$(this).val(),
			  async: false
		}).responseText;		
	$("select#list4").html(datalist4); 
	});
});
</script>
<!-- Validate Form -->
<script src="js/jquery.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" />
<!-- Validate Form -->
<?PHP 	
ob_start();
@session_start();
include"include/connect.inc.php";
?>
<title>BOOKING (Online)</title>
</head>
<body>
<div id="wrapper">
  <div class="mian">
    <div class="head">
      <?PHP include"include/head.php";?>
      <div class="chklogin">
        <?PHP include"include/sessionl_ogin.php";?>
      </div>
      <?PHP if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
      <div class="menu">
        <?PHP include"include/menu.php";?>
      </div>
      <?PHP } ?>
    </div>
    <div class="content">
      <?PHP if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
      <?PHP
    $rec_run = mssql_fetch_array(mssql_query(" SELECT ARF_KEY  FROM AR_File ORDER BY ARF_KEY DESC "));
//	$run =  sprintf ("%03d", $rec_run[0]); 
    $id_run = "ARF-".date("Y")."".(sprintf ("%04d",iconv_substr($rec_run[0],8,11,"UTF-8")+1));
	$add = md5('add');
	$edt = md5('edt');
	?>
      <?PHP
    if($_REQUEST['id_key'] == md5('add')){
		$sql_arf = "INSERT INTO [Dream_Thai].[dbo].[AR_File]
           ([ARF_KEY]
           ,[BT_KEY]
           ,[ARF_COMPANY_NAME_THAI]
           ,[ARF_COMPANY_NAME_ENG]
           ,[ARF_TAX_ID]
           ,[ARF_TYPE]
           ,[ARF_CREDIT_LIMIT]
           ,[ARF_CREDIT_STATUS]
           ,[ARF_REMARK]
           ,[CURNCY_KEY]
           ,[ARF_STATUS]
           ,[ARF_CREATE_BY]
           ,[ARF_CREATE_DATE]
           ,[ARF_REVISE_BY]
           ,[ARF_LASTUPD]
           ,[ARF_REASON_APPROVE]
           ,[ARF_APPROVE_BY]
           ,[ARF_APPROVE_DATE])
     VALUES
           ('".$_POST['id_arf']."'
           ,'".$_POST['bt_id']."'
           ,'".trim($_POST['name_cust_th'])."'
           ,'".trim($_POST['name_cust_en'])."'  
           ,NULL
           ,".$_POST['type_id']."  
           ,".$_POST['credit_cust']." 
           ,1
           ,NULL
           ,'".$_POST['curcen_id']."'
           ,1
           ,'". $_SESSION["user_id"]."'
           ,'".date("Y/m/d H:i:s")."'
           ,NULL
           ,'".date("Y/m/d H:i:s")."'
           ,NULL
           ,NULL
           ,NULL)";
		///------------------------------------------------------------------------------------------------------
		$sql_address = "INSERT INTO [Dream_Thai].[dbo].[Address]
           ([APF_ARF_KEY]
           ,[ADD_ITEM]
           ,[ADD_NO]
           ,[ADD_PROVINCE]
           ,[ADD_AMPHOE]
           ,[ADD_TAMBON]
           ,[ADD_PHONE]
           ,[ADD_FAX]
           ,[ADD_MOBILE]
           ,[ADD_WEBSITE]
           ,[ADD_EMAIL]
           ,[ADD_REMARK]
           ,[ADD_DEFAULT]
           ,[ADD_STATUS]
           ,[ADD_CREATE_BY]
           ,[ADD_REVISE_BY]
           ,[ADD_LASTUPD])
     VALUES
           ('".$_POST['id_arf']."'
           ,'01'
           ,'".$_POST['add_no_cust']."'
           ,'".$_POST['province_cust']."'
           ,'".$_POST['ampur_cust']."'
           ,'".$_POST['tumbon_cust']."'
           ,'".$_POST['phone_cust']."'
           ,'".$_POST['fax_cust']."'
           ,'".$_POST['mobile_cust']."'
           ,'".$_POST['url_cust']."'
           ,'".$_POST['email_cust']."'
           ,NULL
           ,1
           ,1
           ,'". $_SESSION["user_id"]."'
           ,NULL
           ,'".date("Y/m/d H:i:s")."')";
     ///------------------------------------------------------------------------------------------------------	   
	$sql_contact = "INSERT INTO [Dream_Thai].[dbo].[Contact]
           ([APF_ARF_KEY]
           ,[CONT_ITEM]
           ,[CONT_TITLE]
           ,[CONT_NAME]
           ,[CONT_SURNAME]
           ,[CONT_PHONE]
           ,[CONT_EMAIL]
           ,[CONT_DEPT]
           ,[CONT_REMARK]
           ,[CONT_DEFAULT]
           ,[CONT_STATUS]
           ,[CONT_CREATE_BY])
     VALUES
           ('".$_POST['id_arf']."'
           ,'01'
           ,'".$_POST['title_contact_cust']."'
           ,'".$_POST['n_contact_cust']."'
           ,'".$_POST['l_contact_cust']."'
           ,'".$_POST['tell_contact_cust']."'
           ,'".$_POST['email_contact']."'
           ,'".$_POST['depart_cust']."'
           ,  'REMARK'
           ,1
           ,1
           ,'". $_SESSION["user_id"]."');";
		  ///---------------------------------------------------------------------------------------------------
		$sql_payment="INSERT INTO [Dream_Thai].[dbo].[Condition_Payment]
           ([APF_ARF_KEY]
           ,[COND_ITEM]
           ,[COND_PUR_STATUS]
           ,[TOF_NAME]
           ,[TAXT_KEY]
           ,[COND_REMARK]
           ,[COND_DEFAULT]
           ,[COND_STATUS]
           ,[COND_CREATE_BY]
           ,[COND_REVISE_BY]
           ,[COND_LASTUPD])
     VALUES
           ('".$_POST['id_arf']."'
           ,'01'
           ,'".$_POST['id_cust']."'
           ,".$_POST['tof_pay_id']."
           ,'".$_POST['tax_id']."'
           ,NULL
           ,1
           ,1
           ,'". $_SESSION["user_id"]."'
           ,NULL
           ,'".date("Y/m/d H:i:s")."')";
		/*
         echo "".$sql_arf."<HR>";
		 echo "".$sql_address."<HR>";
		 echo "".$sql_contact."<HR>";
		 echo "".$sql_payment."<HR>";
		 */
		$ap_file1 = mssql_query($sql_arf);
		$ap_file2 = mssql_query($sql_address);
		$ap_file3 = mssql_query($sql_contact);
		$ap_file4 = mssql_query($sql_payment);
	    if($ap_file1 == true && $ap_file2 == true && $ap_file3 == true && $ap_file4 == true){
			  echo"
			  <table width=\"100%\">
			  	<tr bgcolor = '#d6ffcd'>
			  		<td><font color = '#036d05' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกสำเร็จ</font></td>
				</tr>
			  </table>
			  "; 
	   }else{
		      echo"
			  <table width=\"100%\">
			  	<tr bgcolor = '#ffbfbf'>
			  		<td><font color = 'red' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผิดผลาด</font></td>
				</tr>
			  </table>
			  ";   
	   }
	}
	?>
      <form method="post" action="add_newcust.php?id_key=<?=$add?>">
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend>ข้อมูลลูกค้า</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top"> รหัส
                <input type="text" name="id_arf" size="15" value="<?= $id_run?>"  readonly="readonly">
                ประเภทลูกค้า
                <select name="type_id" class="frominput" >
                  <option value="" >--------------เลือก--------------</option>
                  <option value="1" selected="selected">ลูกหนี้การค้าในประเทศ</option>
                  <option value="2" >ลูกหนี้การค้าต่างประเทศ</option>
                  <option value="3" >ลูกหนี้การค้าอื่นๆ</option>
                </select>
                <BR>
                ชื่อลูกค้า(TH)
                <input type="text" name="name_cust_th" size="55" class="validate[required,length[0,50]]">
                <br>
                <font color="#000000">ชื่อลูกค้า(EN)</font>
                <input type="text" name="name_cust_en" size="55"  ></td>
              <td valign="top" align="right"> วงเงินเครดิต(บาท)
                <input type="text" name="credit_cust" size="22" class="validate[required,length[0,13],custom[onlyNumber]]">
                <BR>
                ประเภทภาษีของกิจการ
                <select name="bt_id" class="frominput" >
                  <?php
								$sql_bt =  mssql_query(" SELECT BT_NAME,BT_KEY  FROM Business_Type WHERE BT_STATUS = '1' " );
						    	while($bt = mssql_fetch_array($sql_bt)){
								echo "<option value='".$bt[1]."'>".$bt[0]."</option>";	
							    }	
					?>
                  <option value="">--------------เลือก--------------</option>
                </select>
                <BR>
                สถานะการขายสินค้า
                <select name="id_cust" class="frominput" >
                  <option value="" >--------------เลือก--------------</option>
                  <option value="0" selected="selected">ขายสด</option>
                  <option value="1" >ขายเชื่อ</option>
                </select></td>
              <td valign="top" align="right"> สกุลเงิน
                <select name="curcen_id" class="frominput" >
                  <?php
								$sql_mon =  mssql_query(" SELECT CURNCY_NAME_THAI , CURNCY_KEY FROM Currency WHERE (CURNCY_STATUS = '1') " );
						    	while($mon = mssql_fetch_array($sql_mon)){
								echo "<option value='".$mon[1]."'>".$mon[0]."</option>";	
							    }	
					?>
                  <option value="">--------------เลือก--------------</option>
                </select>
                <BR>
                ประเภทภาษี
                <select name="tax_id" class="frominput" >
                  <?PHP 
								$sql_v = mssql_query("SELECT TAXT_NAME, TAXT_KEY FROM Tax_Type WHERE (TAXT_STATUS = '1')");
									while($vatt = mssql_fetch_array($sql_v)){
								echo "<option value=' ".$vatt[1]." '> ".$vatt[0]." </option>";	
							    }		
				   ?>
                  <option value="">--------------เลือก--------------</option>
                </select>
                <BR>
                เงื่อนไขการชำระเงิน(วัน)
                <select name="tof_pay_id" class="frominput" >
                  <?PHP 
				                $sql_pay = mssql_query("SELECT TOF_NAME, TOF_STATUS FROM Term_of_Payment WHERE  (TOF_STATUS = 1)" );
								while($pay = mssql_fetch_array($sql_pay)){
								echo "<option value='".$pay[0]."'>".$pay[0]."</option>";	
							    }		
				     ?>
                  <option value="">--------------เลือก--------------</option>
                </select></td>
            </tr>
          </table>
        </fieldset>
        <!--------------------------------------------------------------------------------------------------------------------------------->
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend>ที่อยู่</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" align="left">เลขที่
                <input type="text" name="add_no_cust"   size="80" class="validate[required,length[0,50]]"/></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td align="left"> จังหวัด
                <select name="province_cust" class="frominput"  id="list1" >
                  <option value="">--------------เลือก--------------</option>
                  <?PHP 
				                $sql_prov= mssql_query("SELECT PROVINCE_NAME_THAI, PROVINCE_KEY FROM Province WHERE (PROVINCE_STATUS = '1') " );
								while($prov = mssql_fetch_array($sql_prov)){
								echo "<option value='".$prov[1]."'>".$prov[0]."</option>";	
							    }		
				     ?>
                </select>
                เขต/อำเภอ
                <select name="ampur_cust" class="frominput" id="list2">
                  <option value="" selected="selected">--------------เลือก--------------</option>
                </select></td>
              <td align="right">แขวง / ตำบล
                <select name="tumbon_cust" class="frominput"  id="list3">
                  <option value="" selected="selected">--------------เลือก--------------</option>
                </select></td>
              <td align="right"> รหัสไปษณีย์
                <select name="post_no_cust" class="frominput"   id="list4">
                  <option value="" selected="selected">--------------เลือก--------------</option>
                </select></td>
            </tr>
            <tr>
              <td align="left">เบอร์โทรศัพท์
                <input type="text" name="phone_cust" size="22" class="validate[required,custom[onlyNumber],length[0,50]]"></td>
              <td align="right"><font color="#000000">FAX</font>
                <input type="text" name="fax_cust" size="22" ></td>
              <td align="right"><font color="#000000">เบอร์มือถือ</font>
                <input type="text" name="mobile_cust" size="22" ></td>
            </tr>
            <tr>
              <td align="left"><font color="#000000">E-mail </font>
                <input type="text" name="email_cust" size="30"  ></td>
              <td colspan="2" align="right"><font color="#000000">Website</font>
                <input type="text" name="url_cust" size="81"   ></td>
            </tr>
          </table>
        </fieldset>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend>ผู้ติดต่อ</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="left">คำนำหน้าชื่อ
                <select name="title_contact_cust" class="frominput"  >
                  <?PHP 
				                $sql_ti = mssql_query("SELECT TITLE_NAME_THAI, TITLE_KEY FROM Title_Name WHERE (TITLE_STATUS = '1') " );
								while($ti = mssql_fetch_array($sql_ti)){
								echo "<option value='".$ti[1]."'>".$ti[0]."</option>";	
							    }		
				     ?>
                  <option value="">--------------เลือก--------------</option>
                </select></td>
              <td align="left">ชื่อผุ้ติดต่อ
                <input type="text" name="n_contact_cust" size="40" class="validate[required,length[0,50]]"></td>
              <td align="left">นามสกุล
                <input type="text" name="l_contact_cust" size="40" class="validate[required,length[0,50]]"></td>
            </tr>
            <tr>
              <td align="left">แผนก
                <input type="text" name="depart_cust" size="30" class="validate[required,length[0,50]]"></td>
              <td align="left">เบอร์โทรศัพท์
                <input type="text" name="tell_contact_cust" size="30" class="validate[required,custom[onlyNumber],length[0,50]]"></td>
              <td align="left">E-mail
                <input type="text" name="email_contact" size="50" class="validate[required,custom[email],length[0,50]]"></td>
            </tr>
          </table>
        </fieldset>
        <input type="reset" class="Xcloase" value="">
        <input type="submit" class="cinfirm" value="">
        <BR>
        <BR>
      </form>
      <?PHP }else{
		echo"<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";  
      } ?>
    </div>
    <div class="foot">
      <?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>