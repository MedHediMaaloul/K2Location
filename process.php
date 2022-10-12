<?php
session_start();
require_once('Gestion_location/inc/connect_db.php');

if (isset($_POST['login'])) {
    if (empty($_POST['login']) || empty($_POST['password'])) {
        header("location:login.php?Empty= Veuillez remplir les champs");
    } else {
        $query = "select * from user where login='" . $_POST['login'] . "' and password='" . md5($_POST['password']) . "' 
        AND etat_user ='T'";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['User'] = $_POST['login'];
            $_SESSION['Role'] =  $row['role'];
            $_SESSION['id_user'] =  $row['id_user'];
            $_SESSION['id_agence'] =  $row['id_agence'];
            if($_SESSION['Role'] == "mecanicien"){
                header("location:Controletechnique.php");
            }else{
                header("location:dashboard.php");
            }
        } else {
            header("location:login.php?Invalid= Veuillez saisir le Login et le mot de passe corrects ");
        }
    }
}else{
    echo 'Ne fonctionne pas maintenant!!';
}