<?PHP 	
ob_start() ;
@session_start();
ini_set('default_charset', 'tis-620');
if ($_SESSION["user_ses"]  != ''  &&  $_SESSION["user_id"]  != ''){ 
include"include/ms_db_to_csv.php";
include"include/connect.inc.php";
$table1 = "[AR_File]";
$table2 = "[AP_File]";
$table3 = "[Book_Order]";
$table4 = "[Book_Order_Detail]";
$table5 = "[Customer_Return]";
$table6 = "[Customer_Return_Detail]";
$table7 = "[Customer_Return_Picture]";
$file_name = "test01";
$ex1 = ms_db_to_csv($table1,$file_name);
$ex2 = ms_db_to_csv($table2,$file_name);
$ex3 = ms_db_to_csv($table3,$file_name);
$ex4 = ms_db_to_csv($table4,$file_name);
$ex5 = ms_db_to_csv($table5,$file_name);
$ex6 = ms_db_to_csv($table6,$file_name);
$ex7 = ms_db_to_csv($table7,$file_name);
$out = $ex1.$ex2.$ex3.$ex4.$ex5.$ex6.$ex7;
header("Content-type: text/x-csv; charset=tis-620");
header("Content-Disposition: attachment; filename=table_dump.csv");
echo $out; 
// ALL DATABASE
/*  
 $see = "select * from [Dream_Thai].INFORMATION_SCHEMA.TABLES ";
 $ree = mssql_query($see);
 $rows = mssql_num_rows($ree);
 for($k = 1; $k <= $rows; $k ++){
	  $recccre = mssql_fetch_array($ree);
  $file = $k;
  $ex = ms_db_to_csv("[".$recccre[2]."]",$file1);
  $ep .= $ex."<br> ";
 }
 echo $ep;
*/
// ALL DATABASE
?>
<?PHP }else{
		echo"<center><font color = 'red'>!</font></center>";  
} ?>
