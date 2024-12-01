<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "cursosonlinedb_lapo";

try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $conexion = new PDO($dsn, $user, $password);
    
} catch (PDOException $e) {
    die("Conexión fallida: ". $e->getMessage());
}