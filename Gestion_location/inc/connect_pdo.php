<?php
// $servername = 'devkestnwgadmin.mysql.db';
// $username = 'devkestnwgadmin';
// $password = 'Ajim123456';
// $dbname = 'devkestnwgadmin';

// $servername = '127.0.0.1';
// $username = 'root';
// $password = '';
// $dbname = 'devkestnwgadmin';

// $servername = 'http://35.180.98.249/phpmyadmin/';
// $username = 'root';
// $password = 'K2Location';
// $dbname = 'db_k2loc';
try {
        $bdd = new PDO('mysql:host=Localhost;dbname=db_k2loc;charset=utf8', 'root', 'K2Location');
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}