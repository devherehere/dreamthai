<?PHP 	
ob_start();
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<?PHP include"include/connect.inc.php";?>
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
      <?PHP 
		if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
      <div class="menu">
        <?PHP include"include/menu.php";?>
      </div>
      <?PHP }  ?>
    </div>
    <div class="content">
      <?PHP if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){  
	    if(@$_REQUEST['id'] == md5('add')){
		if(isset($_POST['item_address'])  == 1 && isset($_POST['item_contact']) == 1 && isset($_POST['item_pay']) == 1  ){
		 $sql_dbgadd = sqlsrv_query($con,"SELECT     Address.ADD_FAX, Address.ADD_EMAIL, Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Address.ADD_PHONE FROM    Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1') AND (Address.ADD_ITEM = '".$_POST['item_address']."');");
		 $address_cn =  sqlsrv_fetch_array($sql_dbgadd);
		 
		 $sql_dbgcont = sqlsrv_query($con,"SELECT  Contact.CONT_TITLE, Title_Name.TITLE_NAME_THAI, Contact.CONT_NAME,
		Contact.CONT_SURNAME, Contact.CONT_DEPT, Contact.CONT_PHONE, Contact.CONT_EMAIL, AR_File.ARF_KEY, Contact.CONT_ITEM
		FROM         Title_Name INNER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE RIGHT OUTER JOIN
         AR_File ON Contact.APF_ARF_KEY = AR_File.ARF_KEY  WHERE     (Contact.CONT_STATUS = '1') 
		 AND (Contact.CONT_TITLE = '".$_POST['item_contact']."');");
		$contact_ =  sqlsrv_fetch_array($sql_dbgcont);
		
		 $sql_dbgpay = sqlsrv_query($con,"SELECT     AR_File.ARF_KEY, CASE Condition_Payment.COND_PUR_STATUS WHEN 0 THEN 'ขายสด' 
			WHEN 1 THEN 'ขายเชื่อ' END AS STATUS, Condition_Payment.TOF_NAME, Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY,    	
			Condition_Payment.COND_ITEM, Condition_Payment.COND_DEFAULT  FROM         Tax_Type INNER JOIN
            Condition_Payment ON Tax_Type.TAXT_KEY = Condition_Payment.TAXT_KEY RIGHT OUTER JOIN  
			AR_File ON Condition_Payment.APF_ARF_KEY = AR_File.ARF_KEY  WHERE  (Condition_Payment.COND_STATUS = '1') AND     
			Condition_Payment.TOF_NAME =  ".$_POST['item_pay'].";");
		$c_pay =  sqlsrv_fetch_array($sql_dbgpay); 
		
		$cn_cust_arf  = $_POST['cust_arf'];
		$cn_cust_name = $_POST['cust_name'];
		$cn_add_item = $address_cn['ADD_ITEM'];  
		$cn_add_name = $address_cn['TAMBON_NAME_THAI']." ".$address_cn['AMPHOE_NAME_THAI']." ".$address_cn['PROVINCE_NAME_THAI']."";
		$cn_add_fax = $address_cn['ADD_FAX'];
		$cn_add_phone = $address_cn['ADD_PHONE'];
		$cn_phone_con = $contact_[5];
		$cn_vat_pay = $c_pay[3]; 
		$cn_vat_sale = $c_pay[1];   
		$cn_day_pay = $c_pay[2];
		$cn_cust_type = $_POST['cust_type'];
		$cn_cust_credit_conf = $_POST['cust_credit_conf'];
		$cn_cust_credit = $_POST['cust_credit'];
		$cn_cust_sta = $_POST['cust_sta'];
		 if($cust_arf != ""){
			$_SESSION["cn_add_item"]  = $address_cn['ADD_ITEM'];	 
			$_SESSION["cn_con_item"]  = $contact_['CONT_ITEM'];	 
			$_SESSION["cn_cust_arf"] = $cn_cust_arf;
			$_SESSION['cn_cust_sta'] = $cn_cust_sta;
			$_SESSION['cn_cust_credit'] = $cn_cust_credit;
			$_SESSION['cn_cust_credit_conf'] = $cn_cust_credit_conf;
			$_SESSION['cn_cust_type'] = $cn_cust_type;
			$_SESSION['cn_day_pay'] = $cn_day_pay;
			$_SESSION['cn_vat_sale'] = $cn_vat_sale;
			$_SESSION['cn_vat_pay'] = $cn_vat_pay;
			$_SESSION['cn_add_phone']  = $cn_add_phone;
			$_SESSION['cn_add_fax']       = $cn_add_fax;
			$_SESSION['cn_key_con']      = $cn_key_con;
			$_SESSION['cn_add_name']   = $cn_add_name;
			$_SESSION['cn_add_item']     = $cn_add_item;
			$_SESSION['cn_cust_name']  = $cn_cust_name;
		}
    }else{

   }
}
	     $sql_duc = "SELECT     DOC_KEY, MODULE_KEY, DOC_TITLE_NAME, DOC_NAME_THAI, DOC_NAME_ENG, DOC_SET_YEAR, DOC_SET_MONTH, DOC_RUN, DOC_DATE, DOC_REMARK, DOC_STATUS, DOC_CREATE_BY, DOC_REVISE_BY, DOC_LASTUPD, DOC_ISO, DOC_DAR, DOC_COMPANY_NAME_THAI, DOC_COMPANY_NAME_ENG, DOC_ADD, DOC_TEL, DOC_FAX, DOC_TAX, DOC_WEBSITE, DOC_LOGO, DOC_FORMPRINT
FROM  Document_File WHERE (DOC_STATUS = '1') AND (MODULE_KEY = 3)";
	     $docrun = sqlsrv_fetch_array(sqlsrv_query($con,$sql_duc));
		 $date_ex =  date('Y/m/d H:i:s',strtotime("+".$docrun['DOC_DATE']." day"));
		 $day = explode("-", date("Y-m-d"));
	     if($docrun[5] == 1){
		   		$yy = ($day[0]+543);
	     }else if($docrun[5] == 2){
 		  		$yy = ($day[0]);
 	     }else if($docrun[5] == 3){
		   		$yy = iconv_substr(($day[0]+543),2,4,"UTF-8");
	     }else if($docrun[5] == 4){
		   		$yy = iconv_substr($day[0],2,4,"UTF-8");
	     }
		 if($docrun[6] == 0){
			  	$mm = '';
		 }else{
			  	$mm = $day[1]; 
		 }
		  $cn_run = sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ISNULL(MAX(AR_CN_ID),0)+1 AS  AR_CN_KEY FROM [Dream_Thai].[dbo].[Customer_Return] "));
	      $_SESSION['id_cn'] = $cn_run[0];
		  $cn_id =  sprintf ("%03d", $cn_run[0]); 
		  $don_no = "".$docrun['DOC_TITLE_NAME']."-".$yy."".$mm."-".$cn_id;
	  ?>
      <form method="post" name="01" action="Cn_online.php?id=<?=md5('addtable')?>" target="_blank">
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend>ใบเคลมสินค้า</legend>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td> เลขที่ใบเครมสินค้า
                <input type="text" name="cn_paper"  value="<?= $don_no?>" size="30" disabled="disabled">
                <br>
                ลูกค้า
                <input type="text" name="cn_key" size="15" value="<?=$_SESSION["cn_cust_arf"]?>">
                &nbsp;&nbsp;
                <input type="text" name="cn_cust_name" size="30" value="<?=$_SESSION['cn_cust_name']?>">
                <a href="cust_chk.php?id_action=<?=md5('2')?>" style="margin:0px;"><img src="img/se_c.png" border="0" height="23" /></a> <br>
                ผู้ติดต่อ
                <select name="contact" class="frominput" >
                  <?php
								$sql_c =  sqlsrv_query($con," SELECT     Contact.CONT_TITLE, Contact.CONT_NAME, Contact.CONT_SURNAME, AP_File.APF_KEY, Title_Name.TITLE_NAME_THAI, Contact.CONT_ITEM
FROM         Title_Name LEFT OUTER JOIN
                      Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE RIGHT OUTER JOIN
                      AP_File ON Contact.APF_ARF_KEY = AP_File.APF_KEY
WHERE     (Contact.CONT_DEFAULT = '1') " );
						    	while($ckey = sqlsrv_fetch_array($sql_c)){		 
									if($ckey[1] == $_SESSION["cn_key_con"]){
										$select = "selected='selected' ";
									}else{
										$select = "";
									}
								echo "<option value='".$ckey['CONT_ITEM']."' ".$select.">".$ckey['TITLE_NAME_THAI']."  ".$ckey['CONT_NAME']." ".$ckey['CONT_SURNAME']."</option>";	
							    }	
					?>
                  <option value=""   >------  เลือก-------</option>
                </select>
                <BR>
                พนักงานเคลม
                <select name="empkey"  class="frominput"  >
                  <?=$emk['EMP_NAME_THAI']."  ".$emk['EMP_SURNAME_THAI'];?>
                  </option>
                  <?PHP 
								$sql_e =  sqlsrv_query($con,"SELECT  Employee_File.EMP_KEY,Title_Name.TITLE_NAME_THAI,
													  Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI
 FROM Title_Name INNER JOIN Employee_File ON Title_Name.TITLE_KEY = Employee_File.TITLE_KEY WHERE  EMP_STATUS  = '1'");
						    	while($ekey = sqlsrv_fetch_array($sql_e)){
								echo "<option value='".$ekey['EMP_KEY']."'>".$ekey['TITLE_NAME_THAI']." ".$ekey['EMP_NAME_THAI']." ".$ekey['EMP_SURNAME_THAI']."</option>";	
							    }	 	
				  ?>
                  <option value=""  >------  เลือก-------</option>
                </select></td>
              <td align="left" width="54%"> วันที่สร้างใบเครม
                <input type="text" name="cn_date" size="30" disabled="disabled" value="<?=date("Y/m/d")?>">
                <br>
                ที่อยู่
                <input type="text" name="cn_add" size="80" value="<?=$_SESSION['cn_add_name']?>">
                <br>
                Tel.
                <input type="text" name="cn_tel" size="30" disabled="disabled"  value="<?=$_SESSION['cn_add_phone']?>">
                &nbsp;&nbsp; FAX.
                <input type="text" name="cn_fax" size="30" disabled="disabled"  value="<?=$_SESSION['cn_add_fax']?>">
                <br>
                ประเภทการเครม
                <select name="type_re"  class="frominput"  >
                  <?PHP 
								$sql_e =  sqlsrv_query($con,"SELECT *FROM [Dream_Thai].[dbo].[Customer_Return_Type] WHERE (CNT_STATUS = '1')");
						    	while($type_re = sqlsrv_fetch_array($sql_e)){
								echo "<option value='".$type_re['CNT_KEY']."' selected=\"selected\" >".$type_re['CNT_NAME']."</option>";	
							    }	 	
				 			 ?>
                  <option value=""  >------  เลือก-------</option>
                </select></td>
            </tr>
          </table>
        </fieldset>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend></legend>
          <iframe src="include/clamTemp.php" width="100%" scrolling="no" height="400" 
                 style="
                 display:block;
                 border:none;
            "> </iframe>
          <a href="clear_temp.php?id=2" class="clear_list" target="_blank"  onclick="return confirm('คุณแน่ใจหรือไม่')"  ></a> 
          <a href="product_search.php?cn=<?=md5('2')?>" target="_blank" class="add_list"  ></a>
        </fieldset>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" width="50%">
              <fieldset style="width:93%; margin-left:11px; margin-bottom:10px;">
             	<legend>กรณีที่ยางไม่สามารถเคลมได้</legend><br>
                 <input type="radio" name="sta_return" checked="checked" value="1">ลุกค้าประสงค์ขอรับยางเคลมคืน
                 <input type="radio" name="sta_return"  value="0">ลุกค้าไม่ขอรับยางเคลมคืน
           </fieldset>
              </td>
              <td valign="top" width="5">
              </td>
              <td valign="top">
              <fieldset style="width:92%; margin-left:11px; margin-bottom:10px;">
                <legend>หมายเหตุ</legend>
                <input type="text" name="cn_remark" size="70">
                &nbsp;&nbsp;
              </fieldset>
              </td>
          </tr>
        </table>
        <fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
          <legend></legend>
          <input type="reset" value="  " class="Clear" >
          <input type="submit" value=" " class="CnOk " onclick="return confirm('ต้องการบันทึกข้อมูลเลขที่ <?=$_SESSION['key_bo']?> ใช่หรือไม่')">
        </fieldset>
      </form>
            <?PHP
      if($_GET['id'] == md5('addtable')){
		  $sql = "INSERT INTO [Dream_Thai].[dbo].[Customer_Return]
           ([AR_CN_KEY]
           ,[DOC_KEY]
           ,[ARF_KEY]
           ,[ADD_ITEM]
           ,[CONT_ITEM]
           ,[EMP_KEY]
           ,[AR_CN_DATE]
           ,[AR_CN_EX_DATE]
           ,[CNT_KEY]
           ,[AR_CN_REMARK]
           ,[AR_CN_STATUS]
           ,[AR_CN_S_REMARK]
           ,[AR_CN_S_STATUS]
           ,[AR_CN_QTY]
           ,[AR_CN_YES]
           ,[AR_CN_NO]
           ,[AR_CN_NET]
           ,[AR_CN_CREATE_BY]
           ,[AR_CN_CREATE_DATE]
           ,[AR_CN_LASTUPD])
     VALUES
           ('".$don_no."'
           ,'".$docrun['DOC_KEY']."'
           ,'".$_SESSION["cn_cust_arf"]."'
           ,'".$_SESSION['cn_add_item']."'
           ,'".$_POST['contact']."'
           ,'".$_POST['empkey']."'
           ,'".date("Y/m/d H:i:s")."'
           ,'".$date_ex."'
           ,'".type_re."'
           ,'".$_POST['cn_remark']."'
           ,3
           ,''
           ,'".$_POST['sta_return']."'
           ,".$_SESSION['max_cn']."
           ,0.00
           ,0.00
           ,0.00
           ,'".$_POST['empkey']."'
           ,'".date("Y/m/d H:i:s")."'
           ,'".date("Y/m/d H:i:s")."')";
		   $sql_temp_to_mas = "INSERT INTO [Dream_Thai].[dbo].[Customer_Return_Detail]  SELECT * FROM 
		   [Dream_Thai].[dbo].[Customer_Return_Detail_Temp] WHERE [AR_CN_ID] = ".$_SESSION['id_cn']." ";
		   $chkadd ="SELECT * FROM [Dream_Thai].[dbo].[Customer_Return_Detail_Temp] WHERE AR_CN_ID = ".($_SESSION['id_cn'])." ;";
		     if(sqlsrv_num_rows(sqlsrv_query($chkadd)) > 0){
		     $ap_file1 = sqlsrv_query($con,$sql_temp_to_mas); 
		     $ap_file2 = sqlsrv_query($con,$sql); 
	         $ap_file3 = sqlsrv_query($con,"DELETE FROM   Customer_Return_Detail_Temp WHERE AR_CN_ID = ".$_SESSION['id_cn']."");
		    }else{
				echo"ไม่สามารถบันทึกข้อมูลซ้ำอีกได้ได้!!";
				mssql_close();
				echo("<meta http-equiv='refresh' content='3;url= index.php' />");
			 }
	         if($ap_file1 == true && $ap_file2 == true && $ap_file3 == true){
			  echo"
			  <table width=\"100%\">
			  	<tr bgcolor = '#d6ffcd'>
			  		<td><font color = '#036d05' size='4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บันทึกสำเร็จ</font></td>
				</tr>
			  </table>
			  "; 
			  echo("<meta http-equiv='refresh' content='3;url= report/report_cn.php' />");
	   }else{
		   echo "<script>alert(\" ผิดผลาด\")
             window.close();
		   </script>";
	   }
	  }
	  ?>
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