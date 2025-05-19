<?php
$dsn = 'mysql:host=localhost;dbname=crm_db;charset=utf8mb4';
$user = 'dbuser';
$pass = 'dbpass';
$pdo = new PDO($dsn, $user, $pass);

define('JWT_SECRET', 'your_secret_key');
