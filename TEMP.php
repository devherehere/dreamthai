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
<?PHP include"include/mercenary_libery.php";?>
<title>BOOKING (Online)</title>
</head>
<body>
<div id="wrapper">
  <div class="mian">
	<div class="head">
      <?PHP include"include/head.php";?>
       <div class="chklogin"> <?PHP include"include/sessionl_ogin.php";?></div>
       <?PHP 
		if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ ?>
      <div class="menu">
        <?PHP include"include/menu.php";?>
      </div>
      <?PHP }  ?>
    </div>
    <div class="content">
        <?PHP if ($_SESSION["user_ses"]  != ''  && $_SESSION["user_id"]  != ''){  
		//echo $test->$showmes("MMMMMM");
		echo showmes("MMMMMM");
		?>
    
       <?PHP }else{
		echo"<center><font color = 'red'>กรุณาเข้าสู่ระบบ</font></center>";  
      } ?>
    </div>
   	<div class="foot"><?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>