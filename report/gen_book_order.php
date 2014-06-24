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
        $this->Cell(4, 1, '��Ť���Թ������', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_MO_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'TR', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, '', 'L');
        $this->Cell(4, 1, '��ǹŴ���������� (' . $obj->PROM_DISCOUNT_PER . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_PROM_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 2, $obj->PROM_NAME, 'LT', 0);
        $this->Cell(4, 1, '��ǹŴ�Թʴ (' . $obj->CASH_DISCOUNT_PER . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_CASH_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, '', 'LB');
        $this->Cell(4, 1, '������Ť������ (' . $obj->AR_BO_TAX . ' %)', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_TAX_TOTAL, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'R', 0, 'C');
        $this->Ln();
        $this->Cell(10, 1, '��Ť���ط�� ( ' . num2thai($obj->AR_BO_NET) . ' )', 'LB');
        $this->Cell(4, 1, '��Ť���ط�� Total Amount', 1, 0, 'L');
        $this->Cell(3, 1, number_format($obj->AR_BO_NET, 2), 1, 0, 'R');
        $this->Cell(2, 1, '', 'RB', 0, 'C');
        $this->Ln(3);
        $this->Cell(6, 0, '...............................................................................', 0, 0, 'C');
        $this->Cell(7, 0, '...............................................................................', 0, 0, 'C');
        $this->Cell(6, 0, '...............................................................................', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(6, 0, '�ѹ���.............../.................../....................', 0, 0, 'C');
        $this->Cell(7, 0, '�ѹ���.............../.................../....................', 0, 0, 'C');
        $this->Cell(6, 0, '�ѹ���.............../.................../....................', 0, 0, 'C');
        $this->ln(1);
        $this->Cell(6, 0, '�١���', 0, 0, 'C');
        $this->Cell(7, 0, '���ºѭ��', 0, 0, 'C');
        $this->Cell(6, 0, '���͹��ѵ�', 0, 0, 'C');

        $this->iso = $obj->DOC_ISO;
        $this->dar = $obj->DOC_DAR;
    }

    function footer()
    {
        $this->SetY(-5.9);
        $this->SetFont('angsana', '', 10);
        // Print centered page number
        $this->Cell(1,0);
        $this->Cell(1, 10, 'ISO :' . $this->iso, 0, 0, 'C');
        $this->Cell(13);
        $this->Cell(5, 10, 'DAR :' .$this->dar , 0, 0, 'C');

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
$pdf->Cell(5, 0, '���Ѿ�� : ' . $row->DOC_TEL);
$pdf->Cell(0, 0, '�š�� : ' . $row->DOC_FAX, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 1, '�Ţ��Шӵ�Ǽ���������� : ' . $row->DOC_TAX, 0, 1);
$pdf->Cell(5);
$pdf->Cell(0, 0, $row->DOC_WEBSITE, 0, 1);
$pdf->Ln(1);


$bo_last_insert = "SELECT TOP (1) * FROM  Book_Order ORDER BY  Book_Order.AR_BO_DATE DESC ,Book_Order.AR_BO_KEY  DESC ";


$stmt = sqlsrv_query($con, $bo_last_insert);
$row = sqlsrv_fetch_object($stmt);

$pdf->Cell(5, 0, '�����١���');
$pdf->Cell(7, 0, $row->ARF_KEY);
$pdf->Cell(4, 0, '�Ţ����͡���');
$pdf->Cell(0, 0, $row->AR_BO_KEY, 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Code ');
$pdf->Cell(0, 0, 'Document No. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(5, 0, '�����١��� ');
$pdf->Cell(7, 0, '');
$pdf->Cell(4, 0, '�ѹ����͡��� ');
$pdf->Cell(0, 0, $row->AR_BO_DATE->format('d / m / Y'), 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Customer Name ');
$pdf->Cell(0, 0, 'Document Date. ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, '������� ');
$pdf->Cell(9, 0,'');
$pdf->Cell(3, 0, '��͹䢡�ê��� ');


$pdf->Cell(0, 0, $row->PUR_STATUS . ' ' . $row->TOF_NAME . ' �ѹ ' . $row->TAXT_NAME);
$pdf->Cell(0, 0, '', 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(12, 0, 'Address ');
$pdf->Cell(0, 0, 'Term of Payment ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(2, 0, '���Ѿ�� :');
$pdf->Cell(3, 0, '');
$pdf->Cell(2, 0, '����� : ');
$pdf->Cell(5, 0, '');
$pdf->Cell(4, 0, '��ѡ�ҹ��� : ');
$pdf->Cell(0, 0, '', 0, 1);
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Tel.  ');
$pdf->Cell(7, 0, 'Fax.  ');
$pdf->Cell(0, 0, 'Sale Name  ', 0, 1);

$pdf->Ln(1);
$pdf->Cell(3, 0, '���ͼ��Դ��� : ');
$pdf->Cell(3, 0, '');
$pdf->Ln(0.3);
$pdf->Cell(5, 0, 'Contact Name ');
$pdf->Ln(1);

$pdf->Cell(3, 0, '������ : ');
$pdf->Cell(5, 0, '');
$pdf->Cell(3, 0, '�������㹡�èѴ��  : ');
$pdf->Cell(0, 0, '' );
$pdf->Ln(1);

$head = array('�ӴѺ', '�����Թ���', '�����Թ���', '�ӹǹ', '˹���', '�Ҥ�˹���', '�ӹǹ�Թ', '��ǹŴ', '�ӹǹ�Թ���', '�����˵�');

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
$pdf->show_cal($row);

$pdf->Output();

?>



