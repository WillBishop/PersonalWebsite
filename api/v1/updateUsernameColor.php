<?php
include "db_connection.php";


if (isset($_GET['userId']) && isset($_GET['color']) && isset($_GET["key"]) && isset($_GET["colorPro"])){
	header("HTTP/1.1 200 OK");
} else {
	header("HTTP/1.1 400 Bad Request");
	header("Content-Type: application/json");
	$error = [
		"result" => "error",
		"reason" => "Missing required data"
	];  
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
$userId = $_GET['userId'];
$color = $_GET['color'];
$userSuppliedKey = $_GET['key'];
$isColorPro = $_GET["colorPro"];

$generationKey = "SwH3Pu9_b_s3^dGY";


$sig = hash_hmac('sha256', $userId . $color . $isColorPro, $generationKey);

if ($sig !== $userSuppliedKey){
	header("HTTP/1.1 400 Bad Request");
	header("Content-Type: application/json");
	$error = [
		"result" => "error",
		"reason" => "Invalid key"
	];   
	echo json_encode($error, JSON_PRETTY_PRINT);


	exit();
}

$conn = OpenCon();

$sql = "INSERT INTO usernameColors (userId, color, isColorPro) VALUES('{$userId}', '{$color}', '{$isColorPro}') ON DUPLICATE KEY UPDATE    
color='{$color}', isColorPro='{$isColorPro}'";

$result = $conn->query($sql);
if ($result == TRUE){
	header("Content-Type: application/json");
	header("HTTP/1.1 200 OK");
	$data = [
		"result" => "success",
		"userId" => $userId,
		"color" => $color
	];
	echo json_encode($data, JSON_PRETTY_PRINT);
} else {
	header("Content-Type: application/json");
	header("HTTP/1.1 500 Internal Server Error");
	$data = [
		"result" => "error",
		"reason" => "An error has occured, I don't know why, but it has"
	];
	echo json_encode($data, JSON_PRETTY_PRINT);
}

CloseCon($conn);
?>