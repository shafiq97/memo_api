<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(array("success" => false, "error" => "Connection failed: " . $conn->connect_error)));
}

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$wilayah = $_POST['wilayah'];
$department = $_POST['department'];
$position = $_POST['position'];
$tel_no = $_POST['tel_no'];

// Check if passwords match
if ($password !== $confirm_password) {
  echo json_encode(array("success" => false, "error" => "Passwords do not match."));
  exit();
}

// Check if email already exists
$sql = "SELECT id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo json_encode(array("success" => false, "error" => "Email already exists."));
  exit();
}

// Insert user into the database
$sql = "INSERT INTO users (username, email, password, wilayah, department, position, tel_no)
VALUES ('$email', '$email', '$password', '$wilayah', '$department', '$position', '$tel_no')";

if ($conn->query($sql) === TRUE) {
  echo json_encode(array("success" => true, "message" => "User registered successfully."));
} else {
  echo json_encode(array("success" => false, "error" => "Error: " . $sql . "<br>" . $conn->error));
}

$conn->close();
?>
