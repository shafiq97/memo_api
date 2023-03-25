<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');


// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the username and password from the request body
  $data = json_decode(file_get_contents('php://input'), true);
  $my_username = $data['username'];
  $my_password = $data['password'];
  
  // Connect to the MySQL database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "memo";
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check for errors in the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Execute a SELECT query to find the user with the given username and password
  $sql = "SELECT * FROM users WHERE username = '$my_username' AND password = '$my_password'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // If the user exists, send a success response with their role
    $row = $result->fetch_assoc();
    $role = $row['role'];
    $id = $row['id'];
    http_response_code(200);
    echo json_encode(array("role" => $role, "user_id" => $id));
  } else {
    // If the user does not exist, send an error response
    http_response_code(401);
    echo json_encode(array("message" => $sql));
  }
  
  // Close the database connection
  $conn->close();
} else {
  // Send an error response
  http_response_code(400);
  echo json_encode(array("message" => "Invalid request method"));
}
?>
