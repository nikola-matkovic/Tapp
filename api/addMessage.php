<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$host = $_ENV["host"];
$username = $_ENV["username"];
$password = $_ENV["password"];
$database = $_ENV["database"];

$text = $_POST['text'];
$user_id = $_POST['user_id'];

var_dump($_POST);

$connString = "mysql:host=$host;dbname=$database";

$conn = new PDO($connString, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'insert into messages (text, user_id) values(?, ?)';

$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$text, $user_id]);
} 
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}