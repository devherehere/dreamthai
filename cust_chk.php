<?PHP 	
ob_start();
@session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<link rel="stylesheet" type="text/css" href="css/style.css" />
<?PHP 
	include"include/connect.inc.php";?>
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
      <div class="menu">
        <?PHP include"include/menu.php";?>
      </div>
    </div>
    <div class="content">
      <?PHP  if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ 
	               if($_GET['id_search'] != ""){
					  $sql_ss = "SELECT  *, CASE ARF_STATUS WHEN 0 THEN '�Դ��������' WHEN 1 THEN '�Դ�����' END AS STATUS ,
								                                  CASE ARF_CREDIT_STATUS WHEN 1 THEN '���͹��ѵ�' WHEN 2 THEN '͹��ѵ�' END AS CREDIT_STATUS,
																  CASE ARF_TYPE WHEN 1 THEN '�١˹���ä��㹻����' WHEN 2 THEN '�١˹���ä�ҵ�ҧ�����'
																  WHEN 3 THEN '�١˹���ä������'  END AS TYPE
						    FROM   AR_File  WHERE  (ARF_KEY = '".$_GET['id_search']."')";
					  $arr_ss =  mssql_fetch_array(mssql_query($sql_ss));
				  }
	?>
      <?PHP
	$add = md5('add');
    ?>
      <?PHP
	$temp_ac = $_GET['id_action'];
     if($temp_ac  == md5('1')){
    ?>
      <form method="post" name="01"  action="index.php?id=<?=$add?>">
      <?PHP
	 }else if($temp_ac  == md5('2')){
	?>
      <form method="post" name="01"  action="Cn_online.php?id=<?=$add?>">
      <?PHP
	 }else{
	?>
      <form method="post" name="01"  action="#">
        <?PHP	 
	 }
	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="middle"><fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
              <legend>�����١���</legend>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td> �����١���
                    <input type="text" name="cust_arf" value="<?=$arr_ss['ARF_KEY'];?>" size="20">
                    <input type="text" name="cust_name" value="<?=$arr_ss['ARF_COMPANY_NAME_THAI'];?>" size="50">
                    <a href="cust_search.php?tmp=<?=$temp_ac?>"><img src="img/se_c.png" border="0" /></a> �������١���
                    <input type="text" name="cust_type" value="<?=$arr_ss['TYPE'];?>" size="20">
                    <BR>
                    ʶҹС��͹��ѵ�ǧ�Թ
                    <input type="text" name="cust_credit_conf" value="<?=$arr_ss['CREDIT_STATUS'];?>" size="20">
                    ǧ�Թ�ôԵ
                    <input type="text" name="cust_credit" style="text-align:right;"  value="<?=$arr_ss['ARF_CREDIT_LIMIT'].".00"?>" size="20">
                    ʶҹ�
                    <input type="text" name="cust_sta" value="<?=$arr_ss['STATUS'];?>" size="20"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </fieldset></td>
        </tr>
        <tr>
          <td valign="top"><fieldset style="width:96%; margin-left:11px; margin-bottom:10px;">
              <legend>��������´�١���</legend>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF;">
                      <tr bgcolor="#333333" height="30">
                        <td align="center" width="35px">�ӴѺ</td>
                        <td align="center">�������</td>
                        <td align="center">Tel.</td>
                        <td align="center">Fax.</td>
                        <td align="center">E-mail</td>
                        <td align="center" width="55px">������͡</td>
                      </tr>
                      <?PHP
                 if($_GET['id_search'] != ""){
					  $sql_dbgadd = "SELECT     Address.APF_ARF_KEY, AR_File.ARF_KEY, Address.ADD_ITEM, Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, 
                      Tambon.TAMBON_NAME_THAI, Address.ADD_PROVINCE, Address.ADD_AMPHOE, Address.ADD_TAMBON, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, 
                      Address.ADD_MOBILE, Address.ADD_FAX, Address.ADD_EMAIL, Address.ADD_DEFAULT
FROM         Tambon LEFT OUTER JOIN
                      Address ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY LEFT OUTER JOIN
                      AR_File ON Address.APF_ARF_KEY = AR_File.ARF_KEY
					  WHERE  (Address.ADD_STATUS = '1')AND (AR_File.ARF_KEY = '".$_GET['id_search']."')";
					  $i = 1;
					  $sql_dbgadd1 = mssql_query($sql_dbgadd);
					  while($dbgadd =  mssql_fetch_array($sql_dbgadd1)){
						  if($dbgadd['ADD_DEFAULT'] == TRUE){
							$chkked = 'checked="checked"';  
						  }else{
							$chkked = '';  
						  }
				?>
                      <tr bgcolor="#CCCCCC" height="30">
                        <td align="center" width="35px" bgcolor="#888888"><?=$i ;?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?= " ".$dbgadd['TAMBON_NAME_THAI']."  ".$dbgadd['AMPHOE_NAME_THAI']."  ".$dbgadd['PROVINCE_NAME_THAI']." ".$dbgadd['TAMBON_POSTCODE'];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgadd['ADD_MOBILE'];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgadd['ADD_FAX'];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgadd['ADD_EMAIL'];?></td>
                        <td align="center" bgcolor="#888888"><input type="radio" name="item_address" value="<?=$dbgadd[2];?>"  <?=$chkked;?> /></td>
                      </tr>
                      <?PHP		    
				      $i  = $i  +1 ;
				      }					 
				  }
				?>
                <input type="hidden" name="ar_key_add" value="<?=$_GET['id_search']?>">
                    </table>
                    <BR></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF;">
                      <tr bgcolor="#333333" height="30">
                        <td align="center" width="35px">�ӴѺ</td>
                        <td align="center">���ͼ��Դ���</td>
                        <td align="center">Ἱ�</td>
                        <td align="center">Tel.</td>
                        <td align="center">E-mail</td>
                        <td align="center" width="55px">������͡</td>
                      </tr>
                      <?PHP
                 if($_GET['id_search'] != ""){
					  $sql_dbgcont = mssql_query("SELECT     Contact.CONT_TITLE, Title_Name.TITLE_NAME_THAI, Contact.CONT_NAME, Contact.CONT_SURNAME, Contact.CONT_DEPT, Contact.CONT_PHONE,   Contact.CONT_EMAIL, AR_File.ARF_KEY, Contact.CONT_ITEM, Contact.CONT_DEFAULT
FROM         Title_Name LEFT OUTER JOIN Contact ON Title_Name.TITLE_KEY = Contact.CONT_TITLE LEFT OUTER JOIN AR_File ON Contact.APF_ARF_KEY = AR_File.ARF_KEY  WHERE (Contact.CONT_STATUS = '1') AND (Contact.APF_ARF_KEY = '".$_GET['id_search']."')");
					  $j = 1;
					  while($dbgcont =  mssql_fetch_array($sql_dbgcont)){
						  if($dbgcont['CONT_DEFAULT'] == TRUE){
							$chkked2 = 'checked="checked"';  
						  }else{
							$chkked2 = '';  
						  }
				?>
                      <tr bgcolor="#CCCCCC" height="30">
                        <td align="center" width="35px" bgcolor="#888888"><?=$j ;?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgcont[1]." ".$dbgcont[2]." ".$dbgcont[3]."";?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgcont[4];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgcont[5];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgcont[6];?></td>
                        <td align="center" bgcolor="#888888"><input type="radio" name="item_contact" value="<?=$dbgcont[0];?>" <?=$chkked2;?> /></td>
                      </tr>
                      <?PHP		    
				      $j = $j + 1 ;
				      }
				  }
				?>
                <input type="hidden" name="cn_key_add" value="<?=$_GET['id_search']?>">
                    </table>
                    <BR></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="1" cellpadding="0"  style="color:#FFF; ">
                      <tr bgcolor="#333333" height="30">
                        <td align="center" width="35px">�ӴѺ</td>
                        <td align="center">ʶҹС�â��</td>
                        <td align="center">���͹䢡�ê���</td>
                        <td align="center">����������</td>
                        <td align="center" width="55px">������͡</td>
                      </tr>
                      <?PHP
                 if($_GET['id_search'] != ""){
					  $sql_dbgpay = mssql_query("SELECT   DISTINCT   AR_File.ARF_KEY, CASE Condition_Payment.COND_PUR_STATUS WHEN 0 THEN '���ʴ' 
			WHEN 1 THEN '�������' END AS STATUS, Condition_Payment.TOF_NAME, Tax_Type.TAXT_NAME, Tax_Type.TAXT_KEY,    	
			Condition_Payment.COND_ITEM, Condition_Payment.COND_DEFAULT  FROM         Tax_Type INNER JOIN
            Condition_Payment ON Tax_Type.TAXT_KEY = Condition_Payment.TAXT_KEY RIGHT OUTER JOIN  
			AR_File ON Condition_Payment.APF_ARF_KEY = AR_File.ARF_KEY  WHERE  (Condition_Payment.COND_STATUS = '1')");
					  $k = 1;
					  while($dbgpay =  mssql_fetch_array($sql_dbgpay)){
						  if($dbgpay['COND_DEFAULT'] == TRUE){
							$chkked3 = 'checked="checked"';  
						  }else{
							$chkked3 = '';  
						  }
				?>
                      <tr bgcolor="#CCCCCC" height="30">
                        <td align="center" width="35px" bgcolor="#888888"><?=$k ;?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgpay[1];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgpay[2];?></td>
                        <td align="left" bgcolor="#888888">&nbsp;
                          <?=$dbgpay[3];?></td>
                        <td align="center" bgcolor="#888888"><input type="radio" name="item_pay" value="<?=$dbgpay[2];?>" <?=$chkked3;?> /></td>
                      </tr>
                      <?PHP		    
				      $k = $k + 1 ;
				      }
				  }
				?>
                    </table></td>
                </tr>
              </table>
            </fieldset>
            <input type="reset" class="Xcloase" value="">
            <input type="submit" class="cinfirm" value="">
      </form>
      <a href="add_newcust.php" class="add_con" target="_blank"></a>
      </td>
      </tr>
      </table>
      <?PHP 
	  }else{
		echo"<center><font color = 'red'>��س��������к�</font></center>";  
      } ?>
    </div>
    <div class="foot">
      <?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>