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
    </div>
    <div class="content">
    <form method="post" name="login" action="chk_login.php">
    <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" style=" border:thin dotted #999; padding:35px;">
 		<tr>
    		<td valign="top" width="30" align="right"></td>
            <td valign="top" align="right"><font color="#333333">USERNAME </font></td>
    		<td valign="top"><input type="text" name="user">
            </td>
  		</tr>
        <tr>
    		<td valign="top" width="30" align="right"></td>
            <td valign="top" align="right"><font color="#333333">PASSWORD</font></td>
    		<td valign="top"> <input type="password" name="pwd">
            </td>
  		</tr>
        <tr>
            <td valign="top" colspan="3" align="center"><input type="submit" value=" " class="buttonlogin"></td>
  		</tr>
	</table>
    </form>
    </div> 
   	<div class="foot"><?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>