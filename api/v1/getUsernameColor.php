<?php 
include "db_connection.php";

if (isset($_GET['userId'])){
    header("HTTP/1.1 200 OK");
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Missing required data";
    exit();
}
$userId = $_GET['userId'];

$conn = OpenCon();
$sql = "SELECT * FROM usernameColors WHERE userID='{$userId}'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    echo "{\n";
    while($row = $result->fetch_assoc()) {
    	header("Content-Type: application/json");
        echo "\"userId\": " . "\"" . $row["userId"] . "\"\n" . "\"color\":" . $row["color"];
    }
    echo "\n}";
} else {
    echo "0 results";
}
$conn->close();
?>