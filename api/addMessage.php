<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if($_SERVER["SERVER_NAME"] === "localhost" ){
    $host = "localhost";
    $username = "nikola";
    $password = "nikola";
    $database = "tapp";
}
else{
    $host = "sql203.epizy.com";
    $username = "epiz_33878269";
    $password = "37lro6zKEVV";
    $database = "epiz_33878269_tapp";
}

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