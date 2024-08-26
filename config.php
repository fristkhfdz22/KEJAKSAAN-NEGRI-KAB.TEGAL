<?php
$host = 'localhost';
$db = 'kejaksaan_negri';
$user = 'root'; // atau username database Anda
$pass = ''; // atau password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();

}

?>
