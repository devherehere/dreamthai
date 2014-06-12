<?php
ob_start();
@session_start();

include "../include/connect.inc.php";
define('FPDF_FONTPATH','font/');
include "../include/fpdf/fpdf.php";


echo $sql_head = "SELECT     Document_File.DOC_COMPANY_NAME_THAI, Document_File.DOC_COMPANY_NAME_ENG, Document_File.DOC_ADD, Document_File.DOC_TEL,
                      Document_File.DOC_FAX, Document_File.DOC_TAX, Document_File.DOC_WEBSITE, Book_Order.ARF_KEY, Book_Order.AR_BO_ID,
                      AR_File.ARF_COMPANY_NAME_THAI, AR_File.ARF_COMPANY_NAME_ENG, Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI,
                      Province.PROVINCE_NAME_THAI, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, Address.ADD_FAX, Title_Name_1.TITLE_NAME_THAI, Contact.CONT_NAME,
                      Contact.CONT_SURNAME, Shipping.SHIPPING_NAME, Shipping.SHIPPING_REMARK, Book_Order.SHIPPING_ADD, Book_Order.AR_BO_KEY,
                      Book_Order.AR_BO_DATE, Book_Order.AR_PUR_STATUS,
                      CASE Book_Order.AR_PUR_STATUS WHEN 0 THEN '".�Թʴ."' WHEN 1 THEN '".�ôԵ."' END AS AR_PUR_STATUS, Book_Order.TOF_NAME, Tax_Type.TAXT_NAME,
                      Title_Name.TITLE_NAME_THAI AS Expr1, Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI
FROM         Tax_Type INNER JOIN
                      Book_Order INNER JOIN
                      Document_File ON Book_Order.DOC_KEY = Document_File.DOC_KEY INNER JOIN
                      AR_File ON Book_Order.ARF_KEY = AR_File.ARF_KEY ON Tax_Type.TAXT_KEY = Book_Order.TAXT_KEY INNER JOIN
                      Employee_File ON Book_Order.EMP_KEY = Employee_File.EMP_KEY LEFT OUTER JOIN
                      Title_Name ON Employee_File.TITLE_KEY = Title_Name.TITLE_KEY RIGHT OUTER JOIN
                      Shipping ON Book_Order.SHIPPING_KEY = Shipping.SHIPPING_KEY RIGHT OUTER JOIN
                      Contact INNER JOIN
                      Title_Name AS Title_Name_1 ON Contact.CONT_TITLE = Title_Name_1.TITLE_KEY ON Book_Order.ARF_KEY = Contact.APF_ARF_KEY RIGHT OUTER JOIN
                      Province LEFT OUTER JOIN
                      Address ON Province.PROVINCE_KEY = Address.ADD_PROVINCE RIGHT OUTER JOIN
                      Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY RIGHT OUTER JOIN
                      Tambon ON Address.ADD_TAMBON = Tambon.TAMBON_KEY ON Book_Order.ADD_ITEM = Address.ADD_ITEM AND
Book_Order.ARF_KEY = Address.APF_ARF_KEY
WHERE     (Book_Order.AR_BO_ID = '2')";

$stmt = sqlsrv_query($con,$sql_head);
$row = sqlsrv_fetch_object($stmt);

$pdf = new FPDF('P','cm','A4');
$pdf->AddFont('angsana','','angsa.php');
$pdf->SetFont('angsana','',12);
$pdf->AddPage();
$pdf->Image('logo/logo.png',1,1,0,0);
$pdf->Cell(300,100,$row->DOC_COMPANY_NAME_THAI);
$pdf->Image('logo/cn.png',17,1,0,0);
$pdf->Output();

?>



