<?php

require __DIR__ . '/../vendor/autoload.php'; // Sesuaikan path jika vendor ada di lokasi lain

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..'); // Sesuaikan path ke direktori root proyek
$dotenv->load();

    $user = $_ENV['DB_USER'];
    $pass = $_ENV['DB_PASSWORD'];
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];

    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    global $url;
    $url = "http://localhost:8080/";

    $sql_web = "SELECT * FROM infoweb WHERE id = 1";
    $row_web = $koneksi->prepare($sql_web);
    $row_web->execute();
    global $info_web;
    $info_web = $row_web->fetch(PDO::FETCH_OBJ);

    error_reporting(0);
?>