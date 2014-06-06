<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<!---<marquee behavior='alternate' direction='eft' truespeed='slow'></marquee>--->
<?PHP
$sql_posi = "SELECT   Employee_File.EMP_KEY, Employee_File.DEPT_KEY, Employee_File.POSI_KEY, Title_Name.TITLE_NAME_THAI, Employee_File.EMP_NAME_THAI, 
                      Employee_File.EMP_SURNAME_THAI, Position_File.POSI_NAME_THAI
FROM         Employee_File INNER JOIN
                      Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY INNER JOIN
                      Position_File ON Employee_File.POSI_KEY = Position_File.POSI_KEY
WHERE Employee_File.EMP_KEY = '".$_SESSION["user_id"]."' ";
$stm  = sqlsrv_query($con,$sql_posi);
$s_posi = sqlsrv_fetch_array($stm);
echo "<em><font size=2>ยินดีต้อนรับคุุณ ".$s_posi["TITLE_NAME_THAI"]." ".$s_posi["EMP_NAME_THAI"]." ".$s_posi["EMP_SURNAME_THAI"]." ( ".$s_posi["POSI_NAME_THAI"]." )</font></em>             ";
?>
<font size=2 ><a href="logout.php">เข้าสู่ระบบ</a></font>  