<?PHP
ob_start();
@session_start();
include"../include/connect.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>BO report</title>
</head>
<body>

<?php
require('MPDF57/mpdf.php');

$rec1 = sqlsrv_fetch_array(sqlsrv_query("SELECT DISTINCT
                      Document_File.DOC_COMPANY_NAME_THAI, Document_File.DOC_COMPANY_NAME_ENG, Document_File.DOC_ADD, Document_File.DOC_TEL,Document_File.DOC_FAX, Document_File.DOC_TAX, Document_File.DOC_DAR, Document_File.DOC_WEBSITE, Book_Order.ARF_KEY, Book_Order.AR_BO_ID,AR_File.ARF_COMPANY_NAME_THAI, AR_File.ARF_COMPANY_NAME_ENG, Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI,Province.PROVINCE_NAME_THAI, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, Address.ADD_FAX, Title_Name_1.TITLE_NAME_THAI, Contact.CONT_NAME,Contact.CONT_SURNAME, Shipping.SHIPPING_NAME, Shipping.SHIPPING_REMARK, Book_Order.SHIPPING_ADD, Book_Order.AR_BO_KEY,Book_Order.AR_BO_DATE, CONVERT(varchar(10), Book_Order.AR_BO_DATE, 103) AS AR_BO_DATE2, Book_Order.AR_PUR_STATUS,CASE Book_Order.AR_PUR_STATUS WHEN 0 THEN 'เงินสด' WHEN 1 THEN 'เครดิต' END AS AR_PUR_STATUS2, Book_Order.TOF_NAME, Tax_Type.TAXT_NAME,Title_Name.TITLE_NAME_THAI AS Expr1, Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI, Address.ADD_NO,Book_Order.AR_BO_S_REMARK
FROM         Tax_Type INNER JOIN
                      Book_Order INNER JOIN
                      Document_File ON Book_Order.DOC_KEY = Document_File.DOC_KEY INNER JOIN
                      AR_File ON Book_Order.ARF_KEY = AR_File.ARF_KEY ON Tax_Type.TAXT_KEY = Book_Order.TAXT_KEY INNER JOIN
                      Employee_File ON Book_Order.EMP_KEY = Employee_File.EMP_KEY INNER JOIN
                      Contact INNER JOIN
                      Title_Name AS Title_Name_1 ON Contact.CONT_TITLE = Title_Name_1.TITLE_KEY ON Book_Order.ARF_KEY = Contact.APF_ARF_KEY AND 
                      Book_Order.CON_ITEM = Contact.CONT_ITEM LEFT OUTER JOIN
                      Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY RIGHT OUTER JOIN
                      Shipping ON Book_Order.SHIPPING_KEY = Shipping.SHIPPING_KEY RIGHT OUTER JOIN
                      Province LEFT OUTER JOIN
                      Address ON Province.PROVINCE_KEY = Address.ADD_PROVINCE RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Tambon ON Address.ADD_TAMBON = Tambon.TAMBON_KEY ON Book_Order.ADD_ITEM = Address.ADD_ITEM AND 
                      Book_Order.ARF_KEY = Address.APF_ARF_KEY
WHERE     (Book_Order.AR_BO_ID = ".$_SESSION['id_bo'].")"));
//$_SESSION['id_bo']

echo $strSQL ="SELECT     Book_Order_Detail.GOODS_KEY, Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Book_Order_Detail.AR_BOD_GOODS_AMOUNT,
                      Units_of_Measurement.UOM_NAME, Book_Order_Detail.AR_BOD_GOODS_SELL, Book_Order_Detail.AR_BOD_GOODS_SUM, 
                      Book_Order_Detail.AR_BOD_DISCOUNT_PER, Book_Order_Detail.AR_BOD_TOTAL, Book_Order_Detail.AR_BOD_REMARK, Book_Order.PROM_KEY, 
                      Promotion.PROM_NAME, Book_Order.AR_BO_MO_TOTAL, Book_Order.PROM_DISCOUNT_PER, Book_Order.AR_BO_PROM_TOTAL, 
                      Book_Order.CASH_DISCOUNT_PER, Book_Order.AR_BO_CASH_TOTAL, Book_Order.AR_BO_TAX, Book_Order.AR_BO_TAX_TOTAL, Book_Order.AR_BO_NET, 
                      Document_File.DOC_ISO, Document_File.DOC_DAR
FROM         Promotion INNER JOIN
                      Book_Order ON Promotion.PROM_KEY = Book_Order.PROM_KEY INNER JOIN
                      Book_Order_Detail ON Book_Order.AR_BO_ID = Book_Order_Detail.AR_BO_ID LEFT OUTER JOIN
                      Document_File ON Book_Order.DOC_KEY = Document_File.DOC_KEY LEFT OUTER JOIN
                      Units_of_Measurement ON Book_Order_Detail.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                      Goods ON Book_Order_Detail.GOODS_KEY = Goods.GOODS_KEY
WHERE     (Book_Order_Detail.AR_BO_ID = ".$_SESSION['id_bo'].") "; 

$rec2 = sqlsrv_fetch_array(sqlsrv_query($con,$strSQL));
$promo_per ="ส่วนลดตามโปรโมชั่น (".$rec2['PROM_DISCOUNT_PER']." %)";
$monney_ex = "ส่วนลดเงินสด (".$rec2['CASH_DISCOUNT_PER']." %)";
$vat_ex = "ภาษีมูลค่าเพิ่ม (".$rec2['AR_BO_TAX']." %)";

function convert($number){ 
$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
$number = str_replace(",","",$number); 
$number = str_replace(" ","",$number); 
$number = str_replace("บาท","",$number); 
$number = explode(".",$number); 
if(sizeof($number)>2){ 
return 'ทศนิยมหลายตัวนะจ๊ะ'; 
exit; 
} 
$strlen = strlen($number[0]); 
$convert = ''; 
for($i=0;$i<$strlen;$i++){ 
	$n = substr($number[0], $i,1); 
	if($n!=0){ 
		if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
		elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
		elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
		else{ $convert .= $txtnum1[$n]; } 
		$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 
$convert .= 'บาท'; 
if($number[1]=='0' OR $number[1]=='00' OR 
$number[1]==''){ 
$convert .= 'ถ้วน'; 
}else{ 
$strlen = strlen($number[1]); 
for($i=0;$i<$strlen;$i++){ 
$n = substr($number[1], $i,1); 
	if($n!=0){ 
	if($i==($strlen-1) AND $n==1){$convert 
	.= 'เอ็ด';} 
	elseif($i==($strlen-2) AND 
	$n==2){$convert .= 'ยี่';} 
	elseif($i==($strlen-2) AND 
	$n==1){$convert .= '';} 
	else{ $convert .= $txtnum1[$n];} 
	$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 
$convert .= 'สตางค์'; 
} 
return $convert; 
} 
## วิธีใช้งาน
$x = ceil($rec2['AR_BO_NET']); 
$x . "=>" .convert($x); 

$sum_total_th = "มูลค่าสุทธิ ".convert($x)."";

$iso = "ISO : ".$rec2['DOC_ISO']."";
$dar = "DAR No : ".$rec2['DOC_DAR']."";

$head = "".iconv('TIS-620','UTF-8',$rec1['DOC_COMPANY_NAME_THAI'])."        ".
           iconv('TIS-620','UTF-8',$rec1['DOC_COMPANY_NAME_ENG'])."                ".
		   iconv('TIS-620','UTF-8',$rec1['DOC_ADD'])." ".
		   "โทรศัพท์ :".iconv('TIS-620','UTF-8',$rec1['DOC_TEL'])." ".
		   "แฟลกซ์ :".iconv('TIS-620','UTF-8',$rec1['DOC_FAX'])."              ".
		   "เลขประจำตัวผู้เสียภาษี :".iconv('TIS-620','UTF-8',$rec1['DOC_TAX'])."        ".
		   iconv('TIS-620','UTF-8',$rec1['DOC_WEBSITE'])." ";
		   
$address = "".$rec1['ADD_NO']." ".$rec1['TAMBON_NAME_THAI']." ".$rec1['AMPHOE_NAME_THAI']." ".$rec1['PROVINCE_NAME_THAI']." ".$rec1['TAMBON_POSTCODE']."";

$pay = "".$rec1['AR_PUR_STATUS2']." ".iconv('TIS-620','UTF-8',$rec1['TOF_NAME'])." วัน ".iconv('TIS-620','UTF-8',$rec1['TAXT_NAME'])."";

$emp = "".iconv('TIS-620','UTF-8',$rec1['Expr1'])." ".iconv('TIS-620','UTF-8',$rec1['EMP_NAME_THAI'])." ".iconv('TIS-620','UTF-8',$rec1['EMP_SURNAME_THAI'])."";

$contact = "".iconv('TIS-620','UTF-8',$rec1['TITLE_NAME_THAI'])." ".iconv('TIS-620','UTF-8',$rec1['CONT_NAME'])." ".iconv('TIS-620','UTF-8',$rec1['CONT_SURNAME'])."";

$objQuery = sqlsrv_query($con,$strSQL);
$resultData = array();
for ($i=0;$i<sqlsrv_num_rows($objQuery);$i++) {
	$result = sqlsrv_fetch_array($objQuery);
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
	$w=array(8,20,40,10,10,15,15,10,18,25);
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
		$this->Cell(10,5,$eachResult['AR_BOD_GOODS_AMOUNT'],1,0,'R');
		$this->Cell(10,5,iconv('TIS-620','UTF-8',$eachResult['UOM_NAME']),1,0,'R');
		$this->Cell(15,5,$eachResult['AR_BOD_GOODS_SELL'],1,0,'R');
		$this->Cell(15,5,$eachResult['AR_BOD_GOODS_SUM'],1,0,'R');  
		$this->Cell(10,5,$eachResult['AR_BOD_DISCOUNT_PER'],1,0,'R');
		$this->Cell(18,5,$eachResult['AR_BOD_TOTAL'],1,0,'R');
		$this->Cell(25,5,$eachResult['AR_BOD_REMARK'],1,0,'L');
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
	$w=array(8,20,40,10,10,15,15,10,18,25);
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
		$this->Cell($w[5],6,number_format($row[5], 2, ',', ' '),'LR',0,'R',$fill);
		$this->Cell($w[6],6,number_format($row[6], 2, ',', ' '),'LR',0,'L',$fill);
		$this->Cell($w[7],6,$row[7],'LR',0,'C',$fill);
		$this->Cell($w[8],6,number_format($row[8], 2, ',', ' '),'LR',0,'C',$fill);
		$this->Cell($w[9],6,$row[9],'LR',0,'C',$fill);
		$this->Ln();
		$fill=!$fill;
	}
	$this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF('th', 'A4', '8', 'THSaraban');
//Column titles
$header=array('ลำดับ','รหัสสินค้า','ชื่อสินค้า','จำนวน','หน่วย','ราคาหน่วย','จำนวนเงิน','ส่วนลด','จำนวนเงินรวม','หมายเหตุ');
//Data loading
$pdf->AddPage();
//$image1 = "logo/logo.png";
$pdf->Image('logo/logo.png',15,12,30,0,'','WWW.0.com');
$pdf->Ln(-19);
$pdf->Cell(35,30,' ',0,0,'C');
$pdf->MultiCell(89,4,$head,0,0,'C');
$pdf->Image('logo/rent.png',160,12,30,0,'','WWW.0.com');
$pdf->Ln(17);

$pdf->Cell(21,4,'รหัสลูกค้า',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_KEY']),0,0,'L');
$pdf->Cell(30,4,'เลขที่เอกสาร',0,0,'L');
$pdf->Cell(35,4,iconv('TIS-620','UTF-8',$rec1['AR_BO_KEY']),0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Customer Code',0,0,'L');
$pdf->Cell(85,4,'',0,0,'L');
$pdf->Cell(30,4,'Ducument No.',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'ชื่อลูกค้า',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_COMPANY_NAME_THAI']),0,0,'L');
$pdf->Cell(30,4,'วันที่เอกสาร',0,0,'L');
$pdf->Cell(35,4,iconv('TIS-620','UTF-8',$rec1['AR_BO_DATE2']),0,0,'L');
$pdf->Ln();
$pdf->Cell(21,4,'Customer Name:',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$rec1['ARF_COMPANY_NAME_ENG']),0,0,'L');
$pdf->Cell(30,4,'Ducument Date.',0,0,'L');
$pdf->Cell(35,4,'',0,0,'L');
$pdf->Ln();

$pdf->Cell(21,4,'ที่อยู่',0,0,'L');
$pdf->Cell(85,4,iconv('TIS-620','UTF-8',$address),0,0,'L');
$pdf->Cell(30,4,'เงื่อนไขการชำระเงิน',0,0,'L');
$pdf->Cell(35,4,$pay,0,0,'L');
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
$pdf->Cell(30,4,'พนักงานขาย',0,0,'L');
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

$pdf->Cell(21,4,'ขนส่งโดย',0,0,'L');
$pdf->Cell(55,4,iconv('TIS-620','UTF-8',$rec1['SHIPPING_NAME']),0,0,'L');
$pdf->Cell(22,4,'ที่อยู่ในการจัดส่ง',0,0,'L');
$pdf->Cell(55,4,iconv('TIS-620','UTF-8',$rec1['SHIPPING_ADD']),0,0,'L');
$pdf->Ln();

$pdf->Ln(4);
$pdf->BasicTable($header,$resultData);
$pdf->Cell(78,12,iconv('TIS-620','UTF-8',$rec1['AR_BO_S_REMARK']),1,0,'L');
$pdf->Cell(40,6,'มูลค่าสินค้ารวม',1,0,'L');
$pdf->Cell(28,6,number_format($rec2['AR_BO_MO_TOTAL'], 2, ',', ' '),1,0,'R');
$pdf->Cell(25,6,'-',1,0,'C');
$pdf->Ln();
$pdf->Cell(78,6,'',0,0,'C');
$pdf->Cell(40,6,$promo_per,1,0,'L');
$pdf->Cell(28,6,number_format($rec2['AR_BO_PROM_TOTAL'], 2, ',', ' '),1,0,'R');
$pdf->Cell(25,6,'-',1,0,'C');
$pdf->Ln();
$pdf->Cell(78,12,iconv('TIS-620','UTF-8',$rec2['PROM_NAME']),1,0,'L');
$pdf->Cell(40,6,$monney_ex,1,0,'L');
$pdf->Cell(28,6,number_format($rec2['AR_BO_CASH_TOTAL'], 2, ',', ' '),1,0,'R');
$pdf->Cell(25,6,'-',1,0,'C');
$pdf->Ln();
$pdf->Cell(78,6,'',0,0,'C');
$pdf->Cell(40,6,$vat_ex,1,0,'L');
$pdf->Cell(28,6,number_format($rec2['AR_BO_TAX_TOTAL'], 2, ',', ' '),1,0,'R');
$pdf->Cell(25,6,'-',1,0,'C');
$pdf->Ln();
$pdf->Cell(78,10,$sum_total_th,1,0,'L');
$pdf->Cell(40,10,'มูลค่าสุทธิ Total Amount',1,0,'L');
$pdf->Cell(28,10,number_format($rec2['AR_BO_NET'], 2, ',', ' '),1,0,'R');
$pdf->Cell(25,10,'-',1,0,'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Cell(57,6,'............................................',0,0,'C');
$pdf->Cell(57,6,'............................................',0,0,'C');
$pdf->Cell(57,6,'............................................',0,0,'C');
$pdf->Ln();
$pdf->Cell(57,6,'วันที่........./........./........',0,0,'C');
$pdf->Cell(57,6,'วันที่........./........./........',0,0,'C');
$pdf->Cell(57,6,'วันที่........./........./........',0,0,'C');
$pdf->Ln();
$pdf->Cell(57,6,'ลุกค้า',0,0,'C');
$pdf->Cell(57,6,'ฝ่ายบัญชี',0,0,'C');
$pdf->Cell(57,6,'ผู้อนุมัติ',0,0,'C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(171,6,$dar,0,0,'L');
$pdf->Cell(171,6,$iso,0,0,'L');
$pdf->Output("report_bo.pdf","F");
?>
Now Loading......<BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--<meta http-equiv="refresh" content="2;url=report_bo.pdf">-->

</body>
</html>