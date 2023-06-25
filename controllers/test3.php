<?php require_once('tcpdf/tcpdf.php');
function connection()
{
    $conn = mysqli_connect("127.0.0.1", "root", "", "scoutproject") or die("Failed to connect to database: " . mysqli_error($conn));
    return $conn;
}

$con = connection();

$transactionId = 65; // Replace with the actual transaction ID you want to download

$query = "SELECT * FROM `transaction` WHERE transaction_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $transactionId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $attachmentData = $row['attachment'];

    // Create a new TCPDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Transaction Attachment');
    $pdf->SetSubject('Transaction Attachment');

    // Set default header and footer data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, true);

    // Remove default footer
    $pdf->setPrintFooter(false);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Output the attachment data as a PDF file
    $pdf->writeHTML($attachmentData, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('transaction_attachment.pdf', 'D');
}

?>