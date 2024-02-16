<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;
$client = new Client();
$url = 'https://dummyjson.com/users?limit=5&skip=10&select=firstName,phone,birthDate';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";

try {
    $response = $client->get($url);
    $data = $response->getBody()->getContents();
    $jsonData = json_decode($data, true);
    foreach ($jsonData['users'] as $user) {
        $name = $user['firstName'];
        $phone = $user['phone'];
        $dob = $user['birthDate'];

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape values to prevent SQL injection
        $name = $conn->real_escape_string($name);
        $phone = $conn->real_escape_string($phone);
        $dob = $conn->real_escape_string($dob);
        $sql = "INSERT INTO user_information (name, phone, dob) VALUES ('$name', '$phone', '$dob')";
        if ($conn->query($sql) === TRUE) {
            echo "User information inserted successfully!\n";
        } else {
            echo "Error inserting user information: " . $conn->error . "\n";
        }
        $conn->close();
    }

} catch (GuzzleHttp\Exception\RequestException $e) {
    echo "Error: " . $e->getMessage();
}