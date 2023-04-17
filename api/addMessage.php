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

$sql = 'insert into messages (text, user_id) values(?, ?)';

$target_dir = "upload";
$audio = $_FILES["audio"];


if($audio){

    $name = $audio["name"];
    $ext = explode(".", $name);
    $ext = array_pop($ext);
    $temp = $audio["tmp_name"];

    $string = bin2hex(random_bytes(20)) . "." .$ext;

    move_uploaded_file($temp, $target_dir . "/" . $string);

    $sql = 'insert into messages (text, user_id, audio) values(?, ?, ?)';
}



$connString = "mysql:host=$host;dbname=$database";

$conn = new PDO($connString, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$stmt = $conn->prepare($sql);

try {
    if($audio){
        $stmt->execute([$text, $user_id, $string]);
    }
    else{
        $stmt->execute([$text, $user_id]);
    }
}

catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}