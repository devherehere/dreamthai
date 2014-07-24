<?PHP
ob_start();
@session_start();
$dsn="AKE-PC\SQLEXPRESS";
$username="sa"; 
$password="1234"; 
//$objConnect = mssql_connect($dsn,$username,$password) or die("Error Connect to Database");
//$objDB = mssql_select_db("Dream_Thai");

	$connectInfo = array(
		"Database"=>'Dream_Thai_Imp',
		"UID"=>$username,
		"PWD"=>$password
	);
	
$con = sqlsrv_connect($dsn,$connectInfo);



define('BASE_URL','http://localhost/dreamthai/');

?>