<?php
// $servername = '127.0.0.1';
// $username = 'root';
// $password = '';
// $dbname = 'devkestnwgadmin';

$servername = 'Localhost';
$username = 'root';
$password = 'K2Location';
$dbname = 'db_k2loc';
try {
        $bdd = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8', $username, $password);
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
