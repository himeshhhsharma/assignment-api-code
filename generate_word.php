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
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addText('User Information', array('bold' => true, 'size' => 16));
        $section->addText('Name: ' . $userData['name']);
        $section->addText('Phone: ' . $userData['phone']);
        $section->addText('Date of Birth: ' . $userData['dob']);
        $filename = 'user_information'.$userID.'.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);
        header("Content-Disposition: attachment; filename=$filename");
        readfile($filename);
        unlink($filename);
    } else {
        $conn->close();
        echo 'User not found.';
    }
} else {
    echo 'Invalid user ID.';
}
?>