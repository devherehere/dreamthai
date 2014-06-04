<?PHP
ob_start();
@session_start();
$dsn="(local)"; 
$username="sa"; 
$password="root"; 
$objConnect = mssql_connect($dsn,$username,$password) or die("Error Connect to Database");
$objDB = mssql_select_db("Dream_Thai");
?>