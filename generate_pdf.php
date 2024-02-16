<?php
require_once 'vendor/autoload.php';
$userID = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($userID > 0) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "assignment";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM user_information WHERE id = $userID";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing the SQL query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $conn->close();
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 16);
        $pdf->Cell(40, 10, 'User Information');
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Name: ' . $userData['name']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Phone: ' . $userData['phone']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Date of Birth: ' . $userData['dob']);
        $filename = 'user_information'.$userID.'.pdf';
        $pdf->Output($filename, 'D');
    } else {
        $conn->close();
        echo 'User not found.';
    }
} else {
    echo 'Invalid user ID.';
}
?>