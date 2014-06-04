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
       <div class="chklogin"><?PHP include"include/sessionl_ogin.php";?></div>
       <div class="menu"></div>
    </div>
    <div class="content">
    <?PHP    
	   @session_start();
        session_destroy();
        echo("<meta http-equiv='refresh' content='0;url= login.php' />");
    ?>
    </div>
   	<div class="foot"><?PHP  include"include/foot.php";?>
    </div>
  </div>
</div>
</body>
</html>