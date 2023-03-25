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

// Handle the file upload
if (isset($_FILES['file'])) {
  $file = $_FILES['file'];

  // Define the target directory and file name
  $targetDir = "uploads/";
  $targetFile = $targetDir . basename($file["name"]);

  // Move the uploaded file to the target directory
  if (move_uploaded_file($file["tmp_name"], $targetFile)) {
    echo "File uploaded: " . $targetFile . "\n";
  } else {
    echo "Error uploading file\n";
  }
} else {
  echo "No file received\n";
}

// Prepare the SQL query
$stmt = $conn->prepare("INSERT INTO memos (sender_name, recipient_name, cc, reference, date, subject, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $sender_name, $recipient_name, $cc, $reference, $date, $subject, $basename($file["name"]));

// Execute the query
if ($stmt->execute() === TRUE) {
  echo "Data inserted successfully";
} else {
  echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
?>