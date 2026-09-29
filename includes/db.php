<?php
$host = '148.113.206.59';
$db = 'avicola2_bdtajetas';
$user = 'avicola2_root';
$pass = 'PapuBillas@@@';
// $link = new PDO("mysql:host=host.cpse13.eu;dbname=y224661_bdgeneral" , "y224661_userbdg" , "@003EWQ2");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>



