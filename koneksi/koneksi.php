<?php


    $user =  'root';
    $pass = 'password';
    $host = 'mysql-db-1';
    $dbname = 'rental_mobil';

    $koneksi = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    global $url;
    $url = "http://localhost/rental_mobil/";

    $sql_web = "SELECT * FROM infoweb WHERE id = 1";
    $row_web = $koneksi->prepare($sql_web);
    $row_web->execute();
    global $info_web;
    $info_web = $row_web->fetch(PDO::FETCH_OBJ);

    error_reporting(0);
?>