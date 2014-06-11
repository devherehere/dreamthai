<meta http-equiv=Content-Type content="text/html; charset=tis-620">
    <?PHP
	
	$query = " SELECT *  FROM [Dream_Thai].[dbo].[Document_File] WHERE  [DOC_KEY] ='DOC-01' ";
	$stmt = sqlsrv_query($con,$query);
	 $head = sqlsrv_fetch_array($stmt);    
	 echo"<BR><center>".$head['DOC_COMPANY_NAME_THAI']."</center><BR>";
	 echo"<center>".$head['DOC_ADD']." ".$head['DOC_WEBSITE']."</center><BR>";
	 echo"<center>โทรศัพท์ ".$head['DOC_TEL']." แฟลกซ์ ".$head['DOC_FAX']." </center><BR>";
    ?>
<script language="JavaScript">
/* 
var message="คุณจะทำอะไร?!?...";   //edit this message to say what you want

function clickIE() {if (document.all) {alert(message); return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {alert(message);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}

document.oncontextmenu=new Function("return false")
*/
</script>