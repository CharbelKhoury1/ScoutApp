<?php

function connection()
{
    $conn = mysqli_connect("127.0.0.1", "root", "", "scoutproject") or die("Failed to connect to database: " . mysqli_error($conn));
    return $conn;
}

function downloadAttachment($transactionId)
{
    $conn = connection();
    $query = "SELECT attachment FROM transaction";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $attachment = $row['attachment'];

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="transaction_attachment.pdf"');
        header('Content-Length: ' . strlen($attachment));

        ob_clean();
        flush();
        fpassthru($attachment);
        exit();
    } else {
        echo "Attachment not found.";
    }

    mysqli_close($conn);
}

if (isset($_GET['id'])) {
    $transactionId = $_GET['id'];
    downloadAttachment($transactionId);
} else {
    echo "Invalid request.";
}
?>