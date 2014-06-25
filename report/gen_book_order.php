<?php
ob_start();
@session_start();

include "../include/connect.inc.php";
define('FPDF_FONTPATH', 'font/');
include "../include/fpdf/fpdf.php";
include "../include/num2text.php";

$sql_head = "SELECT         DOC_KEY, MODULE_KEY, DOC_TITLE_NAME, DOC_NAME_THAI, DOC_NAME_ENG, DOC_SET_YEAR, DOC_SET_MONTH, DOC_RUN, DOC_DATE,
                         DOC_REMARK, DOC_STATUS, DOC_CREATE_BY, DOC_REVISE_BY, DOC_LASTUPD, DOC_ISO, DOC_DAR, DOC_COMPANY_NAME_THAI,
                         DOC_COMPANY_NAME_ENG, DOC_ADD, DOC_TEL, DOC_FAX, DOC_TAX, DOC_WEBSITE, DOC_LOGO, DOC_FORMPRINT
FROM            Document_File
WHERE DOC_KEY='DOC-01'";

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
    public $width = array(1, 3, 4, 1, 1, 2, 2, 1, 2, 2);
    public $num_list = 0;
    public $iso;
    public $dar;

    function create_table($head)
    {


        // Header
        for ($i = 0; $i < count($head); $i++) {
            $this->Cell($this->width[$i], 1, $head[$i], 1, 0, 'C');
        }
        $this->Ln();

        //$this->Cell(array_sum($w), 0, '', 'T');

    }

    function add_row($obj)
    {

        $this->num_list += 1;
        $this->Cell($this->width[0], 1, $this->num_list, 1, 0, 'C');
        $this->Cell($this->width[1], 1, $obj->GOODS_CODE, 1, 0, 'C');
        $this->Cell($this->width[2], 1, $obj->GOODS_NAME_MAIN, 1, 0, 'C');
        $this->Cell($this->width[3], 1, number_format($obj->AR_BOD_GOODS_AMOUNT, 2), 1, 0, 'R');
        $this->Cell($this->width[4], 1, $obj->UOM_NAME, 1, 0, 'R');
        $this->Cell($this->width[5], 1, number_format($obj->AR_BOD_GOODS_SELL, 2), 1, 0, 'R');
        $this->Cell($this->width[6], 1, number_format($obj->AR_BOD_GOODS_SUM, 2), 1, 0, 'R');
        $this->Cell($this->width[7], 1, number_format($obj->AR_BOD_DISCOUNT_PER, 2), 1, 0, 'R');
        $this->Cell($this->width[8], 1, number_format($obj->AR_BOD_TOTAL, 2), 1, 0, 'R');
        $this->Cell($this->width[9], 1, '', 1, 0, 'C');
        $this->Ln();

    }

    function show_cal($obj)
    {
        $this->Cell(10, 1, '', 'LT');
        $this->Cell(4, 1, 'มูลค่าสินค้ารวม', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_MO_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'TR', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, '', 'L');
        $this->Cell(4, 1, 'ส่วนลดตามโปรโมชั่น (' . $obj->PROM_DISCOUNT_PER . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_PROM_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 2, $obj->PROM_NAME, 'LT', 0);
        $this->Cell(4, 1, 'ส่วนลดเงินสด (' . $obj->CASH_DISCOUNT_PER . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_CASH_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, '', 'LB');
        $this->Cell(4, 1, 'ภาษีมูลค่าเพิ่ม (' . $obj->AR_BO_TAX . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_TAX_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, 'มูลค่าสุทธิ ( ' . num2thai($obj->AR_BO_NET) . ' )', 'LB');
        $this->Cell(4, 1, 'มูลค่าสุทธิ Total Amount', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_NET, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'RB', 0, 'C');
        $this->Ln(3);
        $this->Cell(6, 0, '...............................................................................', 0, 0, 'C');
        $this->Cell(7, 0, '...............................................................................', 0, 0, 'C');
        $this->Cell(6, 0, '...............................................................................', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(6, 0, 'วันที่.............../.................../....................', 0, 0, 'C');
        $this->Cell(7, 0, 'วันที่.............../.................../....................', 0, 0, 'C');
        $this->Cell(6, 0, 'วันที่.............../.................../....................', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(6, 0, 'ลูกค้า', 0, 0, 'C');
        $this->Cell(7, 0, 'ฝ่ายบัญชี', 0, 0, 'C');
        $this->Cell(6, 0, 'ผู้อนุมัติ', 0, 0, 'C');

        $this->iso = $obj->DOC_ISO;
        $this->dar = $obj->DOC_DAR;
    }

    function footer()
    {
        $this->SetY(-5.9);
        $this->SetFont('angsana', '', 10);
        // Print centered page number
        $this->Cell(1, 0);
        $this->Cell(1, 10, 'ISO :' . $this->iso, 0, 0, 'C');
        $this->Cell(13);
        $this->Cell(5, 10, 'DAR :' . $this->dar, 0, 0, 'C');

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


$bo_last_insert = "SELECT TOP (1) * FROM  Book_Order ORDER BY  Book_Order.AR_BO_DATE DESC ,Book_Order.AR_BO_KEY  DESC ";


$stmt = sqlsrv_query($con, $bo_last_insert);
$row = sqlsrv_fetch_object($stmt);

$pdf->Cell(5, 0, 'รหัสลูกค้า');
$pdf->Cell(7, 0, $row->ARF_KEY);
$pdf->Cell(4, 0, 'เลขที่เอกสาร');
$pdf->Cell(0, 0, $row->AR_BO_KEY, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Code ');
$pdf->Cell(0, 0, 'Document No. ', 0, 1);

$sql_bo_head = "SELECT        Book_Order.AR_BO_ID, Book_Order.AR_BO_KEY, Book_Order.DOC_KEY, Book_Order.ARF_KEY, Book_Order.ADD_ITEM, Book_Order.EMP_KEY,
                         Book_Order.PROM_KEY, Book_Order.TOF_NAME, Book_Order.AR_BO_DATE, Book_Order.AR_BO_EX_DATE, Book_Order.AR_BO_REMARK,
                         Book_Order.AR_BO_MO_TOTAL, Book_Order.PROM_DISCOUNT_PER, Book_Order.PROM_DISCOUNT_AMOUNT, Book_Order.AR_BO_PROM_TOTAL,
                         Book_Order.CASH_DISCOUNT_PER, Book_Order.CASH_DISCOUNT_AMOUNT, Book_Order.AR_BO_CASH_TOTAL, Book_Order.AR_BO_TAX,
                         Book_Order.AR_BO_TAX_TOTAL, Book_Order.AR_BO_NET, Book_Order.AR_BO_STATUS, Book_Order.TAXT_KEY, Book_Order.AR_PUR_STATUS,
                         Book_Order.SHIPPING_KEY, Book_Order.SHIPPING_REMARK, Book_Order.SHIPPING_ADD, Book_Order.AR_BO_S_REMARK, Book_Order.AR_BO_CREATE_BY,
                         Book_Order.AR_BO_CREATE_DATE, Book_Order.AR_BO_REVISE_BY, Book_Order.AR_BO_APPROVE_BY, Book_Order.AR_BO_APPROVE_DATE,
                         Book_Order.AR_BO_LASTUPD, Contact.CONT_SURNAME, Contact.CONT_NAME, Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI,
                         Shipping.SHIPPING_NAME, AR_File.ARF_COMPANY_NAME_THAI, Book_Order.CON_ITEM, Address.ADD_NO, Tambon.TAMBON_NAME_THAI,
                         Amphoe.AMPHOE_NAME_THAI, Tambon.TAMBON_POSTCODE, Province.PROVINCE_NAME_THAI, Address.ADD_PHONE, Address.ADD_FAX, Address.ADD_MOBILE,
                         Promotion.PROM_NAME, Tax_Type.TAXT_NAME, Document_File.DOC_ISO, Document_File.DOC_DAR
FROM            Shipping RIGHT OUTER JOIN
                         Province RIGHT OUTER JOIN
                         Address LEFT OUTER JOIN
                         Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY LEFT OUTER JOIN
                         Tambon ON Address.ADD_TAMBON = Tambon.TAMBON_KEY ON Province.PROVINCE_KEY = Address.ADD_PROVINCE RIGHT OUTER JOIN
                         Document_File LEFT OUTER JOIN
                         Book_Order ON Document_File.DOC_KEY = Book_Order.DOC_KEY LEFT OUTER JOIN
                         Tax_Type ON Book_Order.TAXT_KEY = Tax_Type.TAXT_KEY LEFT OUTER JOIN
                         Promotion ON Book_Order.PROM_KEY = Promotion.PROM_KEY ON Address.ADD_ITEM = Book_Order.ADD_ITEM AND
                         Address.APF_ARF_KEY = Book_Order.ARF_KEY ON Shipping.SHIPPING_KEY = Book_Order.SHIPPING_KEY LEFT OUTER JOIN
                         Employee_File ON Book_Order.EMP_KEY = Employee_File.EMP_KEY LEFT OUTER JOIN
                         AR_File ON Book_Order.ARF_KEY = AR_File.ARF_KEY LEFT OUTER JOIN
                         Contact ON Book_Order.CON_ITEM = Contact.CONT_ITEM AND Book_Order.ARF_KEY = Contact.APF_ARF_KEY

WHERE
Book_Order.AR_BO_KEY = '" . $row->AR_BO_KEY . "'
AND Book_Order.ARF_KEY = '" . $row->ARF_KEY . "'
AND Address.ADD_ITEM = '".$row->ADD_ITEM."'
AND Contact.CONT_ITEM = '".$row->CON_ITEM."'
";
$stmt = sqlsrv_query($con, $sql_bo_head);
$obj_bo_head = sqlsrv_fetch_object($stmt);

$pdf->Ln(1);
$pdf->Cell(5, 0, 'ชื่อลูกค้า ');
$pdf->Cell(7, 0, $obj_bo_head->ARF_COMPANY_NAME_THAI);
$pdf->Cell(4, 0, 'วันที่เอกสาร ');
$pdf->Cell(0, 0, $row->AR_BO_DATE->format('d / m / Y'), 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Name ');
$pdf->Cell(0, 0, 'Document Date. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, 'ที่อยู่ ');
$pdf->Cell(9, 0, $obj_bo_head->ADD_NO . ' ' . $obj_bo_head->TAMBON_NAME_THAI . ' ' . $obj_bo_head->AMPHOE_NAME_THAI . ' ' . $obj_bo_head->PROVINCE_NAME_THAI . ' ' . $obj_bo_head->TAMBON_POSTCODE);
$pdf->Cell(3, 0, 'เงือนไขการชำระ ');

if ($obj_bo_head->AR_PUR_STATUS == 0) {
    $ar_pur_status = 'ขายสด';

} else {
    $ar_pur_status = 'ขายเชื่อ';

}

$pdf->Cell(0, 0, $ar_pur_status . ' ' . $obj_bo_head->TOF_NAME . ' วัน ' . $obj_bo_head->TAXT_NAME);
$pdf->Cell(0, 0, '', 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Address ');
$pdf->Cell(0, 0, 'Term of Payment ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(2, 0, 'โทรศัพท์ :');
$pdf->Cell(3, 0, $obj_bo_head->ADD_PHONE);
$pdf->Cell(2, 0, 'โทรสาร : ');
$pdf->Cell(5, 0, $obj_bo_head->ADD_FAX);
$pdf->Cell(4, 0, 'พนักงานขาย : ');
$pdf->Cell(0, 0, $obj_bo_head->EMP_NAME_THAI . ' ' . $obj_bo_head->EMP_SURNAME_THAI, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Tel.  ');
$pdf->Cell(7, 0, 'Fax.  ');
$pdf->Cell(0, 0, 'Sale Name  ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, 'ชื่อผู้ติดต่อ : ');
$pdf->Cell(3, 0, $obj_bo_head->CONT_NAME . ' ' . $obj_bo_head->CONT_SURNAME);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Contact Name ');
$pdf->Ln(1);

$pdf->Cell(3, 0, 'ขนส่งโดย : ');
$pdf->Cell(5, 0, $obj_bo_head->SHIPPING_NAME);
$pdf->Cell(3, 0, 'ที่อยู่ในการจัดส่ง  : ');
$pdf->Cell(0, 0, $row->SHIPPING_ADD);
$pdf->Ln(1);

$head = array('ลำดับ', 'รหัสสินค้า', 'ชื่อสินค้า', 'จำนวน', 'หน่วย', 'ราคาหน่วย', 'จำนวนเงิน', 'ส่วนลด', 'จำนวนเงินรวม', 'หมายเหตุ');

$sql_bo_detail = "SELECT         Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Book_Order_Detail.AR_BOD_GOODS_AMOUNT, Book_Order_Detail.AR_BOD_GOODS_SUM,
                         Book_Order_Detail.AR_BOD_DISCOUNT_PER, Book_Order_Detail.AR_BOD_DISCOUNT_AMOUNT, Book_Order_Detail.AR_BOD_TOTAL,
                         Book_Order_Detail.AR_BOD_GOODS_SELL, Units_of_Measurement.UOM_NAME, Book_Order.AR_BO_KEY
FROM            Book_Order INNER JOIN
                         Book_Order_Detail ON Book_Order.AR_BO_ID = Book_Order_Detail.AR_BO_ID INNER JOIN
                         Units_of_Measurement ON Book_Order_Detail.UOM_KEY = Units_of_Measurement.UOM_KEY LEFT OUTER JOIN
                         Goods ON Book_Order_Detail.GOODS_KEY = Goods.GOODS_KEY
WHERE Book_Order.AR_BO_KEY = '" . $row->AR_BO_KEY . "'";

$pdf->create_table($head);
$stmt = sqlsrv_query($con, $sql_bo_detail);

while ($obj = sqlsrv_fetch_object($stmt)) {
    $pdf->add_row($obj);
}
$pdf->show_cal($obj_bo_head);

$pdf->Output();

?>



