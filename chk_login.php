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
<title>BOOKING(Online)</title>
</head>
<body>
<div id="wrapper">
  <div class="mian">
    <div class="content">
    <?PHP
	         $tdate_up = date("Y-m-d ")." ".date("H:i:s");
   			 $sql="select * from  [Dream_Thai].[dbo].[Login]  where USERNAME = '".$_POST['user']."'  and  PASSWORD = '".$_POST['pwd']."'";
			 $result=sqlsrv_query($con,$sql);
			 $record=sqlsrv_fetch_array($result);
			 $user_id = $record['EMP_KEY'];
			 $user_ses=$record['USERNAME'];
			 $password_ses=$record['PASSWORD'];
			 $status_ses=$record['LOGIN_STATUS'];
			 if($_POST['user']  ==  $user_ses   &&  $_POST['pwd']  ==  $password_ses){
							    $settime="UPDATE  [Dream_Thai].[dbo].[Login]   SET  LOGIN_LASTUPD  =  '".$tdate_up."'  WHERE  EMP_KEY =  '".$user_id."'";
			                    sqlsrv_query($con,$settime);	 
   				 if($status_ses == '1'){
						    $_SESSION["user_ses"]  = $user_ses;
							$_SESSION["user_id"]  =    $user_id;
								echo "<script>alert(\"Wellcome  ".$_SESSION["user_ses"] .$_SESSION["user_id"] ."  \")</script>";
								echo("<meta http-equiv='refresh' content='0;url=index.php' />");
				 }
			}else{
		 		echo("<meta http-equiv='refresh' content='0;url= login.php?login=error' />");
			}	 
	
	?>
    </div>
   	<div class="foot">
    </div>
  </div>
</div>
</body>
</html>