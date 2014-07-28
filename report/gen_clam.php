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
WHERE DOC_KEY='DOC-02'";

$stmt = sqlsrv_query($con, $sql_head);
$row = sqlsrv_fetch_object($stmt);


class PDF extends FPDF
{


    public $width = array(1, 3, 4, 3, 2, 2, 4);
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



    }

    function add_row($obj)
    {

        $this->num_list += 1;
        $this->Cell($this->width[0], 1, $this->num_list, 1, 0, 'C');
        $this->Cell($this->width[1], 1, $obj->GOODS_CODE, 1, 0, 'C');
        $this->Cell($this->width[2], 1, $obj->GOODS_NAME_MAIN, 1, 0, 'C');
        $this->Cell($this->width[3], 1, $obj->SERIAL_NUMBER, 1, 0, 'R');
        $this->Cell($this->width[4], 1, $obj->AR_CND_DOT, 1, 0, 'R');
        $this->Cell($this->width[5], 1, $obj->AR_CND_REMAIN , 1, 0, 'R');
        $this->Cell($this->width[6], 1, $obj->AR_CND_DETAIL, 1, 0, 'R');
        $this->Ln();

    }

    function show_cal($obj)
    {

        $this->Cell(19, 1, 'หมายเหตุ : '.$obj->AR_CN_REMARK, 1, 0, 'LTR');
        $this->Ln();

        if($obj->AR_CN_S_STATUS==TRUE){
           $text = 'ลูกค้าประสงค์ขอรับยางเคลมคืน';

        }else{
           $text = 'ลูกค้าไม่ขอรับยางเคลมคืน';

        }
        $this->Cell(19, 1, 'กรณีที่ยางไม่สามารถเคลมได้ :  '.$text, 1, 0, 'LTR');
        $this->Ln();

        $this->Ln(3);
        $this->Cell(4.75, 0, '................................................', 0, 0, 'C');
        $this->Cell(4.75, 0, '................................................', 0, 0, 'C');
        $this->Cell(4.75, 0, '................................................', 0, 0, 'C');
        $this->Cell(4.75, 0, '................................................', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(4.75, 0, 'วันที่.........../............./..............', 0, 0, 'C');
        $this->Cell(4.75, 0, 'วันที่.........../............./..............', 0, 0, 'C');
        $this->Cell(4.75, 0, 'วันที่.........../............./..............', 0, 0, 'C');
        $this->Cell(4.75, 0, 'วันที่.........../............./..............', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(4.75, 0, 'พนักงานขาย', 0, 0, 'C');
        $this->Cell(4.75, 0, 'ลูกค้า', 0, 0, 'C');
        $this->Cell(4.75, 0, 'ผู้ตรวจสอบ', 0, 0, 'C');
        $this->Cell(4.75, 0, 'ฝ่ายบัญชี', 0, 0, 'C');

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
$pdf->Image('logo/cn.png', 17, 1, 0, 0);

$pdf->Cell(5);
$pdf->Cell(0, 0, $row->DOC_COMPANY_NAME_THAI, 0,1);
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


$clam_last_insert = "SELECT TOP (1) * FROM  Customer_Return ORDER BY  AR_CN_LASTUPD  DESC , AR_CN_ID  DESC ";


$stmt = sqlsrv_query($con, $clam_last_insert);
$row = sqlsrv_fetch_object($stmt);

$pdf->Cell(5, 0, 'รหัสลูกค้า');
$pdf->Cell(7, 0, $row->ARF_KEY);
$pdf->Cell(4, 0, 'เลขที่เอกสาร');
$pdf->Cell(0, 0, $row->AR_CN_KEY, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Code ');
$pdf->Cell(0, 0, 'Document No. ', 0, 1);

$sql_cn_head = "SELECT        Contact.CONT_SURNAME, Contact.CONT_NAME, Employee_File.EMP_NAME_THAI, Employee_File.EMP_SURNAME_THAI, Address.ADD_NO,
                         Tambon.TAMBON_NAME_THAI, Amphoe.AMPHOE_NAME_THAI, Tambon.TAMBON_POSTCODE, Province.PROVINCE_NAME_THAI, Address.ADD_PHONE,
                         Address.ADD_FAX, Address.ADD_MOBILE, Document_File.DOC_ISO, Document_File.DOC_DAR, Customer_Return.AR_CN_ID, Customer_Return.AR_CN_KEY,
                         Customer_Return.DOC_KEY, Customer_Return.ARF_KEY, Customer_Return.ADD_ITEM, Customer_Return.CONT_ITEM, Customer_Return.EMP_KEY,
                         Customer_Return.AR_CN_DATE, Customer_Return.AR_CN_EX_DATE, Customer_Return.CNT_KEY, Customer_Return.AR_CN_REMARK,
                         Customer_Return.AR_CN_STATUS, Customer_Return.AR_CN_S_REMARK, Customer_Return.AR_CN_S_STATUS, Customer_Return.AR_CN_QTY,
                         Customer_Return.AR_CN_YES, Customer_Return.AR_CN_NO, Customer_Return.AR_CN_NET, Customer_Return.AR_CN_CREATE_BY,
                         Customer_Return.AR_CN_CREATE_DATE, Customer_Return.AR_CN_REVISE_BY, Customer_Return.AR_CN_LASTUPD, Customer_Return.AR_CN_APPROVE_BY,
                         AR_File.ARF_COMPANY_NAME_THAI, Customer_Return_Type.CNT_NAME
FROM            Employee_File RIGHT OUTER JOIN
                         Customer_Return_Type RIGHT OUTER JOIN
                         Customer_Return ON Customer_Return_Type.CNT_KEY = Customer_Return.CNT_KEY LEFT OUTER JOIN
                         AR_File ON Customer_Return.ARF_KEY = AR_File.ARF_KEY ON Employee_File.EMP_KEY = Customer_Return.EMP_KEY LEFT OUTER JOIN
                         Document_File ON Customer_Return.DOC_KEY = Document_File.DOC_KEY LEFT OUTER JOIN
                         Contact ON Customer_Return.ARF_KEY = Contact.APF_ARF_KEY AND Customer_Return.CONT_ITEM = Contact.CONT_ITEM LEFT OUTER JOIN
                         Address ON Customer_Return.ARF_KEY = Address.APF_ARF_KEY AND Customer_Return.ADD_ITEM = Address.ADD_ITEM LEFT OUTER JOIN
                         Amphoe ON Address.ADD_AMPHOE = Amphoe.AMPHOE_KEY LEFT OUTER JOIN
                         Tambon ON Address.ADD_TAMBON = Tambon.TAMBON_KEY LEFT OUTER JOIN
                         Province ON Address.ADD_PROVINCE = Province.PROVINCE_KEY
WHERE
Customer_Return.AR_CN_KEY = '" . $row->AR_CN_KEY . "'
AND Customer_Return.ARF_KEY = '" . $row->ARF_KEY . "'
AND Address.ADD_ITEM = '".$row->ADD_ITEM."'
AND Contact.CONT_ITEM = '".$row->CONT_ITEM."'
";
$stmt = sqlsrv_query($con, $sql_cn_head);
$obj_bo_head = sqlsrv_fetch_object($stmt);

$pdf->Ln(1);
$pdf->Cell(5, 0, 'ชื่อลูกค้า ');
$pdf->Cell(7, 0, $obj_bo_head->ARF_COMPANY_NAME_THAI);
$pdf->Cell(4, 0, 'วันที่เอกสาร ');
$pdf->Cell(0, 0, $row->AR_CN_CREATE_DATE->format('d / m / Y'), 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Name ');
$pdf->Cell(0, 0, 'Document Date. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, 'ที่อยู่ ');
$pdf->Cell(9, 0, $obj_bo_head->ADD_NO . ' ' . $obj_bo_head->TAMBON_NAME_THAI . ' ' . $obj_bo_head->AMPHOE_NAME_THAI . ' ' . $obj_bo_head->PROVINCE_NAME_THAI . ' ' . $obj_bo_head->TAMBON_POSTCODE);
$pdf->Cell(3, 0, 'ประเภทการรับเคลม');



$pdf->Cell(0, 0,$obj_bo_head->CNT_NAME );
$pdf->Cell(0, 0, '', 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Address ');
$pdf->Cell(0, 0, 'Return Type ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(2, 0, 'โทรศัพท์ :');
$pdf->Cell(3, 0, $obj_bo_head->ADD_PHONE);
$pdf->Cell(2, 0, 'โทรสาร : ');
$pdf->Cell(5, 0, $obj_bo_head->ADD_FAX);
$pdf->Cell(4, 0, 'พนักงานรับเคลม : ');
$pdf->Cell(0, 0, $obj_bo_head->EMP_NAME_THAI . ' ' . $obj_bo_head->EMP_SURNAME_THAI, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Tel.  ');
$pdf->Cell(7, 0, 'Fax.  ');
$pdf->Cell(0, 0, 'Clam Name  ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, 'ชื่อผู้ติดต่อ : ');
$pdf->Cell(3, 0, $obj_bo_head->CONT_NAME . ' ' . $obj_bo_head->CONT_SURNAME);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Contact Name ');
$pdf->Ln(1);


$head = array('ลำดับ', 'รหัสสินค้า', 'ชื่อสินค้า', 'หมายเลขยาง', 'DOT', 'ดอกยางที่เหลือ', 'อาการรับเคลม');

$sql_cn_detail = "SELECT        Goods.GOODS_CODE, Goods.GOODS_NAME_MAIN, Customer_Return_Detail.*
FROM            Customer_Return_Detail LEFT OUTER JOIN
                         Goods ON Customer_Return_Detail.GOODS_KEY = Goods.GOODS_KEY LEFT OUTER JOIN
                         Customer_Return ON Customer_Return_Detail.AR_CN_ID = Customer_Return.AR_CN_ID
WHERE  Customer_Return.AR_CN_KEY = '" . $row->AR_CN_KEY . "'";


$pdf->create_table($head);
$stmt = sqlsrv_query($con, $sql_cn_detail);

while ($obj = sqlsrv_fetch_object($stmt)) {
    $pdf->add_row($obj);
}
$pdf->show_cal($obj_bo_head);

$pdf->Output();

?>



