<?php
$servername = 'k2locdb.ckgl35d4ad77.eu-west-3.rds.amazonaws.com';
$username = 'root';
$password = 'K2Location';
$dbname = 'db_k2loc';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn === false) {
    die("ERROR: Could not connect." . mysqli_connect_error());
}

//configration  
// $servername = '127.0.0.1';
// $username = 'root';
// $password = '';
// $dbname = 'db_k2loc';

// $conn = mysqli_connect($servername, $username, $password, $dbname);
// if ($conn === false) {
//     die("ERROR: Could not connect." . mysqli_connect_error());
// }