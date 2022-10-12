<?php
session_start();
//verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
  // si elle est bien connecté alors c'est bon
  header('Location:dashboard.php');
} else {
  header("Location:login.php");
  //echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
}
?>
