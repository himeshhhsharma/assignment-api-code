<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "assignment";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO user_information (name, phone, dob) VALUES ('$name', '$phone', '$dob')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        $_SESSION['message'] = 'User information submitted successfully!';
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
