<?php 
include "db_connection.php";

if (isset($_GET['userIds']) && isset($_GET['key'])){
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

$userSuppliedKey = $_GET['key'];
$generationKey = "SwH3Pu9_b_s3^dGY";
$sig = hash_hmac('sha256', $_GET["userIds"], $generationKey);

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

$userIds = explode(",", $_GET['userIds']);
$conn = OpenCon();
$sql = "SELECT * FROM usernameColors WHERE userID IN ({$_GET['userIds']})";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Content-Type: application/json");
    // output data of each row
    $colors = [];
    while($row = $result->fetch_assoc()) {
        // $row["userId"]
        // $row["color"]
        // $row["isColorPro"]
        $userData = [
            "userId" => $row["userId"],
            "color" => $row["color"],
            "isColorPro" => $row["isColorPro"] === "1"
        ];
        array_push($colors, $userData);
    }
    echo json_encode(array("colors" => $colors), JSON_PRETTY_PRINT);
} else {
    echo "0 results";
}
echo $conn->error;
$conn->close();
?>