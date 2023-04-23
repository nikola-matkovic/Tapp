<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



// if($_SERVER["SERVER_NAME"] === "localhost" ){
$host = "localhost";
$username = "nikola";
$password = "nikola";
$database = "tapp";
// }
// else{
//     $host = "sql203.epizy.com";
//     $username = "epiz_33878269";
//     $password = "37lro6zKEVV";
//     $database = "epiz_33878269_tapp";
// }

$user_password = $_POST['password'];

if( !($user_password === "Jovana123" || $user_password === "Nikola123")){
    echo "Invalid password";
    die(1);
}


$connString = "mysql:host=$host;dbname=$database";

$conn = new PDO($connString, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT messages.id as id, messages.text, messages.audio, users.id as user_id, users.name
FROM messages
INNER JOIN users
ON messages.user_id = users.id
ORDER BY messages.id;
';

$stmt = $conn->prepare($sql);

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result, JSON_UNESCAPED_UNICODE);