<?php
include 'include/connect.inc.php';


/* Get the product picture for a given product ID. */

$tsql = "SELECT * FROM  Customer_Return_Picture
		 WHERE AR_CN_ID = ? AND AR_CND_ITEM = ? AND AR_CNP_ITEM = ?";

$params = array (
		&$_GET ['ar_cn_id'],
		&$_GET ['ar_cnd_item'],
		&$_GET ['ar_cnp_item']
		
);


/* Execute the query. */
$stmt = sqlsrv_query ( $con, $tsql, $params );
if ($stmt === false) {
	echo "Error in statement execution.</br>";
	die ( print_r ( sqlsrv_errors (), true ) );
}

/* Retrieve the image as a binary stream. */
$getAsType = SQLSRV_PHPTYPE_STREAM ( SQLSRV_ENC_BINARY );
if (sqlsrv_fetch ( $stmt )) {
	$image = sqlsrv_get_field ( $stmt, 3, $getAsType );
	fpassthru ( $image );
} else {
	echo "Error in retrieving data.</br>";
	die ( print_r ( sqlsrv_errors (), true ) );
}

/* Free the statement and connectin resources. */
sqlsrv_free_stmt ( $stmt );
sqlsrv_close ( $con );
?>