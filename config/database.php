<?php
// Database config - edit with your credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'steam_keys_store');
define('DB_USER', 'root');
define('DB_PASS', '');

function db(){
    static $pdo = null;
    if($pdo === null){
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}
