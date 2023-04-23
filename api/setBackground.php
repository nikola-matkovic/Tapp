<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$target_dir = "upload";

$file = $_FILES["file"];
$name = $file["name"];
$ext = explode(".", $name);
$ext = array_pop($ext);
$temp = $file["tmp_name"];
 
$user = $_POST["user_id"];
$user_password = $_POST["password"];
$opacity = $_POST["opacity"];

$string = bin2hex(random_bytes(10)) . "." .$ext;

move_uploaded_file($temp, $target_dir . "/" . $string);

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

if( !($user_password === "Jovana123" || $user_password === "Nikola123")){
    echo "Invalid password";
    die(1);
}


$connString = "mysql:host=$host;dbname=$database";

$conn = new PDO($connString, $username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE users SET background = ? , background_opacity = ? WHERE id = ?;";

$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$string, $opacity, $user]);
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}