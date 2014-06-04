<?PHP
ob_start();
@session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>BO report</title>
</head>
<body>

<?php
require('MPDF57/mpdf.php');
include"../include/connect.inc.php";
$rec1 = mssql_fetch_array(mssql_query("SELECT     Document_File.DOC_COMPANY_NAME_THAI, Document_File.DOC_COMPANY_NAME_ENG, Document_File.DOC_ADD, Document_File.DOC_TEL,Document_File.DOC_FAX, Document_File.DOC_TAX, Document_File.DOC_WEBSITE,Document_File.DOC_DAR, AR_File.ARF_COMPANY_NAME_THAI, AR_File.ARF_COMPANY_NAME_ENG,Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, Address.ADD_FAX, Title_Name_1.TITLE_NAME_THAI, Contact.CONT_NAME, Contact.CONT_SURNAME, Title_Name.TITLE_NAME_THAI AS Expr1,Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI, Address.ADD_NO, Customer_Return_Type.CNT_NAME, Customer_Return.ARF_KEY, CONVERT(VARCHAR(10), Customer_Return.AR_CN_DATE, 103) AS AR_CN_DATE, Customer_Return.AR_CN_KEY, Customer_Return.AR_CN_ID,Customer_Return.CNT_KEY, Customer_Return.AR_CN_S_REMARK, CASE Customer_Return.AR_CN_S_STATUS WHEN 1 THEN 'ลูกค้าประสงค์ขอรับยางเคลมคืน' WHEN 0 THEN 'ลูกค้าไม่ขอรับยางเคลมคืน' END AS AR_CN_S_STATUS,Customer_Return.AR_CN_REMARK
FROM         Tambon LEFT OUTER JOIN
                      Address RIGHT OUTER JOIN
                      Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY ON Tambon.TAMBON_KEY = Address.ADD_TAMBON RIGHT OUTER JOIN
                      Customer_Return_Type RIGHT OUTER JOIN
                      Customer_Return ON Customer_Return_Type.CNT_KEY = Customer_Return.CNT_KEY LEFT OUTER JOIN
                      Contact INNER JOIN
                      Title_Name AS Title_Name_1 ON Contact.CONT_TITLE = Title_Name_1.TITLE_KEY ON Customer_Return.ARF_KEY = Contact.APF_ARF_KEY RIGHT OUTER JOIN
                      Document_File ON Customer_Return.DOC_KEY = Document_File.DOC_KEY LEFT OUTER JOIN
                      Employee_File ON Customer_Return.EMP_KEY = Employee_File.EMP_KEY LEFT OUTER JOIN
                      Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY LEFT OUTER JOIN
                      AR_File ON Customer_Return.ARF_KEY = AR_File.ARF_KEY ON Address.ADD_ITEM = Customer_Return.ADD_ITEM AND 
                      Address.APF_ARF_KEY = Customer_Return.ARF_KEY
WHERE     (Customer_Return.AR_CN_ID = ".$_SESSION['id_cn'].")"));
//$_SESSION['id_cn']
$strSQL ="SELECT     Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Units_of_Measurement.UOM_NAME, Document_File.DOC_ISO, Document_File.DOC_DAR, 
                      Customer_Return_Detail.SERIAL_NUMBER, Customer_Return_Detail.AR_CND_DOT, Customer_Return_Detail.AR_CND_REMAIN, 
                      Customer_Return_Detail.AR_CND_DETAIL, Customer_Return_Detail.AR_CND_REMARK, 
                      CASE Customer_Return.AR_CN_S_STATUS WHEN 1 THEN 'ลูกค้าประสงค์ขอรับยางเคลมคืน' WHEN 0 THEN 'ลูกค้าไม่ขอรับยางเคลมคืน' END AS AR_CN_S_STATUS
FROM         Units_of_Measurement INNER JOIN
                      Customer_Return_Detail ON Units_of_Measurement.UOM_KEY = Customer_Return_Detail.UOM_KEY INNER JOIN
                      Customer_Return ON Customer_Return_Detail.AR_CN_ID = Customer_Return.AR_CN_ID INNER JOIN
                      Document_File ON Customer_Return.DOC_KEY = Document_File.DOC_KEY LEFT OUTER JOIN
                      Goods ON Customer_Return_Detail.GOODS_KEY = Goods.GOODS_KEY
WHERE     (Customer_Return_Detail.AR_CN_ID = ".$_SESSION['id_cn'].") "; 

$rec2 = mssql_fetch_array(mssql_query($strSQL));
$dar = "DAR NO : ".$rec2['DOC_DAR']."";
$iso = "ISO : ".$rec2['DOC_ISO']."";
$dar = "DAR No : ".$rec2['DOC_DAR']."";
$head = "".iconv('TIS-620','UTF-8',$rec1['DOC_COMPANY_NAME_THAI'])."        ".
           iconv('TIS-620','UTF-8',$rec1['DOC_COMPANY_NAME_ENG'])."                ".
		   iconv('TIS-620','UTF-8',$rec1['DOC_ADD'])." ".
		   "โทรศัพท์ :".iconv('TIS-620','UTF-8',$rec1['DOC_TEL'])." ".
		   "แฟลกซ์ :".iconv('TIS-620','UTF-8',$rec1['DOC_FAX'])."              ".
		   "เลขประจำตัวผู้เสียภาษี :".iconv('TIS-620','UTF-8',$rec1['DOC_TAX'])."        ".
		   iconv('TIS-620','UTF-8',$rec1['DOC_WEBSITE'])." ";
$remark = "หมายเหตุ ".iconv('TIS-620','UTF-8',$rec1['AR_CN_REMARK'])."";
$retrun_t ="กรณีที่ยางไม่สามารถเคลมได้ : ".$rec1['AR_CN_S_STATUS']."";
$address = "".$rec1['ADD_NO']." ".$rec1['TAMBON_NAME_THAI']." ".$rec1['AMPHOE_NAME_THAI']." ".$rec1['PROVINCE_NAME_THAI']." ".$rec1['TAMBON_POSTCODE']."";

$clam = "".iconv('TIS-620','UTF-8',$rec1['CNT_NAME'])."";

$emp = "".iconv('TIS-620','UTF-8',$rec1['Expr1'])." ".iconv('TIS-620','UTF-8',$rec1['EMP_NAME_THAI'])." ".iconv('TIS-620','UTF-8',$rec1['EMP_SURNAME_THAI'])."";

$contact = "".iconv('TIS-620','UTF-8',$rec1['TITLE_NAME_THAI'])." ".iconv('TIS-620','UTF-8',$rec1['CONT_NAME'])." ".iconv('TIS-620','UTF-8',$rec1['CONT_SURNAME'])."";

$objQuery = mssql_query($strSQL);
$resultData = array();
for ($i=0;$i<mssql_num_rows($objQuery);$i++) {
	$result = mssql_fetch_array($objQuery);
	array_push($resultData,$result);
}
//************************//
class PDF extends MPDF
{
//Load data
function LoadData($file)
{
	//Read file lines
	$lines=file($file);
	$data=array();
	foreach($lines as $line)
		$data[]=explode(';',chop($line));
	return $data;
}

//Simple table
function BasicTable($header,$data)
{
	//Header
	$w=array(8,20,40,25,20,20,45);
	//Header
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();
	//Data
	$i = 1;
	foreach ($data as $eachResult) 
	{		
		$this->Cell(8,5,$i,1,0,'C');
		$this->Cell(20,5,$eachResult['GOODS_CODE'],1,0,'L');
		$this->Cell(40,5,trim(iconv('TIS-620','UTF-8',$eachResult['GOODS_NAME_MAIN'])),1,0,'R');
		$this->Cell(25,5,$eachResult['SERIAL_NUMBER'],1,0,'R');
		$this->Cell(20,5,$eachResult['AR_CND_DOT'],1,0,'C');
		$this->Cell(20,5,$eachResult['AR_CND_REMAIN'],1,0,'L');
		$this->Cell(45,5,$eachResult['AR_CND_DETAIL'],1,0,'L');  
		$this->Ln();
		$i++;   
	}
}
//coredtable
function FancyTable($header,$data)
{
	//Colors, line width and bold font
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	//$this->SetFont('THSaraban','B');
	//Header
	$w=array(8,20,40,25,20,20,45);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$this->Ln();
	//Color and font restoration
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0);
	//$this->SetFont('THSaraban');
	//Data
	$fill=false;
	foreach($data as $row)
	{
		$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		$this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
		$this->Cell($w[2],6,$row[2],'LR',0,'C',$fill);
		$this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
		$this->Cell($w[4],6,$row[4],'LR',0,'R',$fill);
		$this->Cell($w[5],6,number_format($row[5]),'LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row[6]),'LR',0,'L',$fill);
		$this->Ln();
		$fill=!$fill;
	}
	$this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF('th', 'A4', '8', 'THSaraban');
//Column titles
$header=array('ลำดับ','รหัสสินค้า','ชื่อสินค้า','หมายเลขยาง','DOT','ดอกยางที่เหลือ','อาการที่รับเคลม');
//Data loading
$pdf->AddPage();
$pdf->Image('logo/logo.png',15,15,30,0,'','WWW.0.com');
$pdf->Ln(-19);
$pdf->Cell(35,30,' ',0,0,'C');
$pdf->MultiCell(89,4,$head,0,0,'C');
$pdf->Image('logo/cn.png',160,12,30,0,'','WWW.0.com');
$pdf->Ln(17);

$pdf->Cell(21,4,'รหัสลูกค้า',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_KEY']),0,0,'L');
$pdf->Cell(30,4,'เลขที่เอกสาร',0,0,'L');
$pdf->Cell(35,4,iconv('TIS-620','UTF-8',$rec1['AR_CN_KEY']),0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Customer Code',0,0,'L');
$pdf->Cell(85,4,'',0,0,'L');
$pdf->Cell(30,4,'Ducument No.',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'ชื่อลูกค้า',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_COMPANY_NAME_THAI']),0,0,'L');
$pdf->Cell(30,4,'วันที่เอกสาร',0,0,'L');
$pdf->Cell(35,4,iconv('TIS-620','UTF-8',$rec1['AR_CN_DATE']),0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Customer Name:',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_COMPANY_NAME_ENG']),0,0,'L');
$pdf->Cell(30,4,'Ducument Date.',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'ที่อยู่',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$address),0,0,'L');
$pdf->Cell(30,4,'ประเภทการรับเครม ',0,0,'L');
$pdf->Cell(35,4,$clam,0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Address',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_COMPANY_NAME_ENG']),0,0,'L');
$pdf->Cell(30,4,'Term of Payment',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'โทรศัพท์ :',0,0,'L');
$pdf->Cell(20,4,$rec1['ADD_PHONE'],0,0,'L');
$pdf->Cell(15,4,'โทนสาร :',0,0,'L');
$pdf->Cell(50,4,$rec1['ADD_FAX'],0,0,'L');
$pdf->Cell(30,4,'พนักงานรับเคลม',0,0,'L');
$pdf->Cell(35,4,$emp,0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Tel. :',0,0,'L');
$pdf->Cell(20,4,'',0,0,'L');
$pdf->Cell(15,4,'Fax. :',0,0,'L');
$pdf->Cell(50,4,'',0,0,'L');
$pdf->Cell(30,4,'Sale Name',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'ชื่อผู้ติดต่อ',0,0,'L');
$pdf->Cell(85,4,$contact,0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Contact Name',0,0,'L');
$pdf->Cell(85,4,'',0,0,'L');
$pdf->Cell(30,4,'',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();


$pdf->Ln(4);
$pdf->BasicTable($header,$resultData);
$pdf->Cell(178,8,$remark,1,0,'L');
$pdf->Ln();
$pdf->Cell(178,8,$retrun_t,1,0,'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(45,6,'............................................',0,0,'C');
$pdf->Cell(45,6,'............................................',0,0,'C');
$pdf->Cell(45,6,'............................................',0,0,'C');
$pdf->Cell(45,6,'............................................',0,0,'C');
$pdf->Ln();
$pdf->Cell(45,6,'วันที่........./........./........',0,0,'C');
$pdf->Cell(45,6,'วันที่........./........./........',0,0,'C');
$pdf->Cell(45,6,'วันที่........./........./........',0,0,'C');
$pdf->Cell(45,6,'วันที่........./........./........',0,0,'C');
$pdf->Ln();
$pdf->Cell(45,6,'พนักงานขาย',0,0,'C');
$pdf->Cell(45,6,'ลูกค้า',0,0,'C');
$pdf->Cell(45,6,'ผู้ตรวจสอบ',0,0,'C');
$pdf->Cell(45,6,'ฝ่ายบัญชี',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(171,6,$dar,0,0,'L');
$pdf->Cell(171,6,$iso,0,0,'L');
$pdf->Output("report_cn.pdf","F");
?>
Now Loading......<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<meta http-equiv="refresh" content="2;url=report_cn.pdf">

</body>
</html>