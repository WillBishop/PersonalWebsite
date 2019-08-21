<?php 
function OpenCon()
{
	$dbhost = "localhost";
	$dbuser = "tkqhwd_color";
	$dbpass = "0gqc362C4d7F$$";
	$db = "tkqhwd_color";
	$conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

	return $conn;
}

function CloseCon($conn)
{
	$conn -> close();
}
?>