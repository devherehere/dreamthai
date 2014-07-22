<?PHP
ob_start();
@session_start();
include "../include/connect.inc.php";

$list_clam_item = $_POST['list_item'];
var_dump($list_clam_item);
/*
for($i = 0;$i<count($list_clam_item);$i++){

    $sql = "INSERT INTO [Customer_Return_Picture]
       [AR_CN_ID]
      ,[AR_CND_ITEM]
      ,[AR_CNP_ITEM]
      ,[AR_CNP_PIC]
      ,[AR_CNP_REMARK]
      ,[AR_CNP_LASTUPD]
      ,[AR_CNP_PIC_NAME]
      VALUES
      '".$_SESSION['id_cn']."',
'$list_clam_item[]'

      ";

    sqlsrv_query($con,);*/

?>