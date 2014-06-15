<?php
ob_start();
@session_start();

include "../include/connect.inc.php";
define('FPDF_FONTPATH', 'font/');
include "../include/fpdf/fpdf.php";


$sql_head = "SELECT     Document_File.DOC_COMPANY_NAME_THAI, Document_File.DOC_COMPANY_NAME_ENG, Document_File.DOC_ADD, Document_File.DOC_TEL,
                      Document_File.DOC_FAX, Document_File.DOC_TAX, Document_File.DOC_WEBSITE, Book_Order.ARF_KEY, Book_Order.AR_BO_ID,
                      AR_File.ARF_COMPANY_NAME_THAI, AR_File.ARF_COMPANY_NAME_ENG, Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI,
                      Province.PROVINCE_NAME_THAI, Tambon.TAMBON_POSTCODE, Address.ADD_PHONE, Address.ADD_FAX, Title_Name_1.TITLE_NAME_THAI, Contact.CONT_NAME,
                      Contact.CONT_SURNAME, Shipping.SHIPPING_NAME, Shipping.SHIPPING_REMARK, Book_Order.SHIPPING_ADD, Book_Order.AR_BO_KEY,
                      Book_Order.AR_BO_DATE, Book_Order.AR_PUR_STATUS,
                      CASE Book_Order.AR_PUR_STATUS WHEN 0 THEN '" . 'เงินสด' . "' WHEN 1 THEN '" . 'เครดิต' . "' END AS AR_PUR_STATUS, Book_Order.TOF_NAME, Tax_Type.TAXT_NAME,
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

$stmt = sqlsrv_query($con, $sql_head);
$row = sqlsrv_fetch_object($stmt);


class PDF extends FPDF
{

    /*function footer()
    {

        $this->SetY(-6);
        $this->SetFont('angsana','',8);
        // Page number
        $this->Cell(0,10,'1234');
    }*/

    function create_table($head, $data)
    {

        $w = array(1, 2, 3, 1, 1, 2, 2, 1, 2, 4);
        // Header
        for ($i = 0; $i < count($head); $i++) {
            $this->Cell($w[$i], 1, $head[$i], 1, 0, 'C');
        }
        $this->Ln();
        // Data
        /*      foreach($data as $row)
              {
                  $this->Cell($w[0],6,$row[0],'LR');
                  $this->Cell($w[1],6,$row[1],'LR');
                  $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
                  $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
                  $this->Ln();
              }*/
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');

    }

}


$pdf = new PDF('P', 'cm', 'A4');


$pdf->AddFont('angsana', '', 'angsa.php');
$pdf->SetFont('angsana', '', 12);
$pdf->AddPage();
$pdf->Image('logo/logo.png', 1, 1, 3, 2);
$pdf->Image('logo/rent.png', 17, 1, 0, 0);

$pdf->Cell(5);
$pdf->Cell(0, 0, $row->DOC_COMPANY_NAME_THAI, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 1, $row->DOC_COMPANY_NAME_ENG, 0, 1);

$addr = explode(" ", $row->DOC_ADD);

$line1 = $addr[0] . ' ' . $addr[1] . ' ' . $addr[2] . ' ' . $addr[3] . ' ' . $addr[4] . ' ' . $addr[5];
$line2 = $addr[6] . ' ' . $addr[7] . ' ' . $addr[8] . ' ' . $addr[9] . ' ' . $addr[10] . ' ' . $addr[11] . ' ' . $addr[12];
$pdf->Cell(5);
$pdf->Cell(0, 0, $line1, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 1, $line2, 0, 1);
$pdf->Cell(5);
$pdf->Cell(5, 0, 'โทรศัพท์ : ' . $row->DOC_TEL);
$pdf->Cell(0, 0, 'แฟลกซ์ : ' . $row->DOC_FAX, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 1, 'เลขประจำตัวผู้เสียภาษี : ' . $row->DOC_TAX, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 0, $row->DOC_WEBSITE, 0, 1);
$pdf->Ln(1);


$bo_last_insert = 'SELECT     TOP (1) Address.ADD_NO, Amphoe.AMPHOE_NAME_THAI, Province.PROVINCE_NAME_THAI, Tambon.TAMBON_NAME_THAI, Employee_File.EMP_NAME_THAI,
                      Employee_File.EMP_SURNAME_THAI, Book_Order.DOC_KEY, Book_Order.ADD_ITEM, Book_Order.CON_ITEM, Book_Order.PROM_KEY, Book_Order.TOF_NAME,
                      Book_Order.AR_BO_DATE, Book_Order.AR_BO_EX_DATE, Book_Order.AR_BO_REMARK, Book_Order.AR_BO_MO_TOTAL, Book_Order.PROM_DISCOUNT_PER,
                      Book_Order.PROM_DISCOUNT_AMOUNT, Book_Order.AR_BO_PROM_TOTAL, Book_Order.CASH_DISCOUNT_PER, Book_Order.CASH_DISCOUNT_AMOUNT,
                      Book_Order.AR_BO_CASH_TOTAL, Book_Order.AR_BO_TAX, Book_Order.AR_BO_TAX_TOTAL, Book_Order.AR_BO_NET, Book_Order.AR_BO_STATUS,
                      Book_Order.TAXT_KEY, Book_Order.AR_PUR_STATUS, Book_Order.SHIPPING_KEY, Book_Order.SHIPPING_REMARK, Book_Order.SHIPPING_ADD,
                      Book_Order.AR_BO_S_REMARK, Book_Order.AR_BO_CREATE_BY, Book_Order.AR_BO_CREATE_DATE, Book_Order.AR_BO_REVISE_BY,
                      Book_Order.AR_BO_APPROVE_BY, Book_Order.AR_BO_APPROVE_DATE, Book_Order.AR_BO_LASTUPD, Contact.APF_ARF_KEY, Book_Order.AR_BO_KEY,
                      Contact.CONT_NAME, Contact.CONT_SURNAME, Tambon.TAMBON_POSTCODE, Contact.CONT_PHONE, Contact.CONT_EMAIL, Contact.CONT_DEPT,
                      Contact.CONT_TITLE, Address.ADD_PHONE, Address.ADD_FAX, Address.ADD_MOBILE
FROM         Employee_File RIGHT OUTER JOIN
                      Book_Order ON Employee_File.EMP_KEY = Book_Order.EMP_KEY LEFT OUTER JOIN
                      Contact RIGHT OUTER JOIN
                      Province INNER JOIN
                      Amphoe INNER JOIN
                      Address ON Amphoe.AMPHOE_KEY = Address.ADD_AMPHOE ON Province.PROVINCE_KEY = Address.ADD_PROVINCE RIGHT OUTER JOIN
                      Tambon ON Province.PROVINCE_KEY = Tambon.TAMBON_PROVINCE AND Amphoe.AMPHOE_KEY = Tambon.TAMBON_AMPHOE ON
                      Contact.APF_ARF_KEY = Address.APF_ARF_KEY ON Book_Order.ARF_KEY = Contact.APF_ARF_KEY';

$stmt = sqlsrv_query($con, $bo_last_insert);
$row = sqlsrv_fetch_object($stmt);

$pdf->Cell(5, 0, 'รหัสลูกค้า');
$pdf->Cell(7, 0, $row->APF_ARF_KEY);
$pdf->Cell(4, 0, 'เลขที่เอกสาร');
$pdf->Cell(0, 0, $row->AR_BO_KEY, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Code ');
$pdf->Cell(0, 0, 'Document No. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(5, 0, 'ชื่อลูกค้า ');
$pdf->Cell(7, 0, $row->CONT_NAME . ' ' . $row->CONT_SURNAME);
$pdf->Cell(4, 0, 'วันที่เอกสาร ');
$pdf->Cell(0, 0, $row->AR_BO_CREATE_DATE->format('d/m/Y'), 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Name ');
$pdf->Cell(0, 0, 'Document Date. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, 'ที่อยู่ ');
$pdf->Cell(9, 0, $row->ADD_NO . ' ' . $row->TAMBON_NAME_THAI . ' ' . $row->AMPHOE_NAME_THAI . ' ' . $row->PROVINCE_NAME_THAI . ' ' . $row->TAMBON_POSTCODE);
$pdf->Cell(0, 0, 'เงือนไขการชำระ ');
$pdf->Cell(0, 0, '', 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Address ');
$pdf->Cell(0, 0, 'Term of Payment ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(2, 0, 'โทรศัพท์ :' );
$pdf->Cell(3, 0,$row->ADD_PHONE);
$pdf->Cell(2, 0, 'โทรสาร : ');
$pdf->Cell(5, 0,$row->ADD_FAX);
$pdf->Cell(4, 0, 'พนักงานขาย : ');
$pdf->Cell(0, 0,$row->EMP_NAME_THAI.' '.$row->EMP_SURNAME_THAI, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Tel.  ');
$pdf->Cell(7, 0, 'Fax.  ');
$pdf->Cell(0, 0, 'Sale Name  ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(5, 0, 'ชื่อผู้ติดต่อ : ');
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Contact Name ');
$pdf->Ln(1);

$pdf->Cell(10, 0, 'ขนส่งโดย : ');

$pdf->Cell(3, 0, 'ที่อยู่ในการจัดส่ง  : ');
$pdf->Cell(0, 0,$row->SHIPPING_ADD );
$pdf->Ln(1);

$head = array('ลำดับ', 'รหัสสินค้า', 'ชื่อสินค้า', 'จำนวน', 'หน่วย', 'ราคาหน่วย', 'จำนวนเงิน', 'ส่วนลด', 'จำนวนเงินรวม', 'หมายเหตุ');


$pdf->create_table($head, '');
$pdf->Output();

?>



