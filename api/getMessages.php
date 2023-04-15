<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$host = "localhost";
$username = "nikola";
$password = "nikola";
$database = "tapp";

$connString = "mysql:host=$host;dbname=$database";

$conn = new PDO($connString, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'select * from messages inner join users on messages.user_id = users.id order by messages.id;';

$stmt = $conn->prepare($sql);

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result, JSON_UNESCAPED_UNICODE);