<?php
 
$envPath = __DIR__ . '/../.env';
 
if (!file_exists($envPath)) {
    die("Erreur : le fichier .env est manquant.");
}
 
$env = parse_ini_file($envPath);
 
$host     = $env['DB_HOST']    ?? 'localhost';
$dbname   = $env['DB_NAME']    ?? '';
$user     = $env['DB_USER']    ?? '';
$password = $env['DB_PASS']    ?? '';
$charset  = $env['DB_CHARSET'] ?? 'utf8mb4';
 
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
