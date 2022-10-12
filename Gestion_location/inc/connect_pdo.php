<?php
// $servername = 'devkestnwgadmin.mysql.db';
// $username = 'devkestnwgadmin';
// $password = 'Ajim123456';
// $dbname = 'devkestnwgadmin';

// $servername = '127.0.0.1';
// $username = 'root';
// $password = '';
// $dbname = 'devkestnwgadmin';
try {
        $bdd = new PDO('mysql:host=localhost;dbname=db_k2loc;charset=utf8', 'root', '');
} catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}