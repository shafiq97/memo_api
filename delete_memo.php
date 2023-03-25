<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get the memo ID from the request body
$data = json_decode(file_get_contents("php://input"));
$memoId = $data->memo_id;

// TODO: Authenticate user and check if they have permission to delete memo

// Connect to database
$host = "localhost";
$username = "root";
$password = "";
$database = "memo";
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_errno) {
  die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

// Delete memo from database
$query = "DELETE FROM memos WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $memoId);
if (!$stmt->execute()) {
  die("Error deleting memo: " . $mysqli->error);
}

echo json_encode(array("message" => $mysqli->error));
// Return success response
echo json_encode(array("message" => "Memo deleted÷ successfully"));
