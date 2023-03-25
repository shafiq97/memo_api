<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Replace database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memo";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the user ID from the query string parameter
$user_id = $_GET['user_id'];

// SQL query to fetch data from the memo table for the current user
$sql = "SELECT * FROM memos WHERE assignee_id = '$user_id'";

// Fetch data from the database
$result = mysqli_query($conn, $sql);

if (!$result) {
  die("Error fetching data: " . mysqli_error($conn));
}

// Convert the result set to a JSON object
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}
http_response_code(200);
echo json_encode($data);

// Close the database connection
mysqli_close($conn);
?>
