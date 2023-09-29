<?php


$servername = "localhost";
$username = "ucc";
$password = "ucc";
$dbname = "ucc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to delete a record
$sql = "DELETE FROM server_test WHERE datetimea<=DATE_SUB(NOW(), INTERVAL 1 HOUR)";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();


?>