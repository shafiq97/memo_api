<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  // Get the memo ID from the request body
  parse_str(file_get_contents("php://input"), $_PUT);
  $memoId = $_PUT['memo_id'];
  
  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "memo";
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check for errors in the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Update the status of the memo with the given ID in the database using an SQL query
  $sql = "UPDATE memos SET status = 'approved' WHERE id = $memoId";
  if ($conn->query($sql) === TRUE) {
    // Send a success response
    http_response_code(200);
    echo json_encode(array("message" => "Memo status updated successfully."));
  } else {
    // Send an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error updating memo status: " . $conn->error));
  }
  
  // Close the database connection
  $conn->close();
} else {
  // Send an error response
  http_response_code(400);
  echo json_encode(array("message" => "Invalid request method."));
}

?>
