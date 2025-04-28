<?php
// Datos de conexión a la base de datos
$host = 'localhost';    
$db   = 'BD_PRUEBA_FL'; 
$user = 'root';         
$pass = '';             
$charset = 'utf8mb4';  

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones para PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    // Establecer conexión usando PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
