<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the data from the POST request
$sender_name = $_POST['sender_name'];
$recipient_name = $_POST['recipient_name'];
$cc = $_POST['cc'];
$reference = $_POST['reference'];
$date = $_POST['date'];
$subject = $_POST['subject'];

// Prepare the SQL query
$stmt = $conn->prepare("INSERT INTO memos (sender_name, recipient_name, cc, reference, date, subject) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $sender_name, $recipient_name, $cc, $reference, $date, $subject);

// Execute the query
if ($stmt->execute() === TRUE) {
  echo "Data inserted successfully";
} else {
  echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
