<?PHP
ob_start();
@session_start();
include "include/connect.inc.php";

$SQL = "SELECT * FROM  Customer_Return_Picture WHERE AR_CNP_ITEM = '".$_GET['ar_cnp_item']."' AND AR_CN_ID= ".$_SESSION['id_cn']." ";
$Query = sqlsrv_query($con,$SQL) or die ("Error Query [".$SQL."]");
$Result = sqlsrv_fetch_array($Query);

?>

<!DOCTYPE html>
<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<head>
    <script src="js/jquery-1.7.min.js"></script>
    <script src="js/jquery-ui-1.7.2.custom.min.js"></script>
<head>
<body>


<img src="" height="150" alt="Image preview...">

<script>

    $(function(){
        var reader  = new FileReader();

        reader.readAsDataURL( <? echo base64_encode($Result["AR_CNP_PIC"])?> );

        reader.onload = function () {
            alert('asdfasdf');
            $('img').prop('src',reader.result);
        }


    });

</script>


</body>

</html>

