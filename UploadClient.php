<?php

session_start();

require('Upload/php-excel-reader/excel_reader2.php');
require('Upload/SpreadsheetReader.php');
require('Upload/db_config.php');

if(isset($_POST['Submit'])){
  $mimes = ['text/csv','application/vnd.ms-excel','application/vnd-xls','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'application/vnd.ms-excel.template.macroEnabled.12','application/vnd.ms-excel.sheet.macroEnabled.12',
  'application/vnd.ms-excel.sheet.binary.macroEnabled.12','application/vnd.ms-excel.addin.macroEnabled.12','application/vnd.oasis.opendocument.spreadsheet'];
  if(in_array($_FILES["file"]["type"],$mimes)){
    $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
    $Reader = new SpreadsheetReader($uploadFilePath);
    $totalSheet = count($Reader->sheets());
    /* For Loop for all sheets */
    for($i=0;$i<$totalSheet;$i++){
      $Reader->ChangeSheet($i);
      foreach ($Reader as $Row)
      {
        $nom_entreprise = utf8_encode(isset($Row[0]) ? $Row[0] : '');
        $nom_conducteur = utf8_encode(isset($Row[1]) ? $Row[1] : '');
        $email = utf8_encode(isset($Row[2]) ? $Row[2] : '');
        $tel = utf8_encode(isset($Row[3]) ? $Row[3] : '');
        $adresse = utf8_encode(isset($Row[4]) ? $Row[4] : '');
        $raison_social = utf8_encode(isset($Row[5]) ? $Row[5] : '');
        $num_permis = utf8_encode(isset($Row[6]) ? $Row[6] : '');
        $comment = utf8_encode(isset($Row[7]) ? $Row[7] : '');
        $type = utf8_encode(isset($Row[8]) ? $Row[8] : '');
        $date_creation_entreprise = utf8_encode(isset($Row[9]) ? $Row[9] : '');
        $siret = utf8_encode(isset($Row[10]) ? $Row[10] : '');
        $naf = utf8_encode(isset($Row[11]) ? $Row[11] : '');
        $codetva = utf8_encode(isset($Row[12]) ? $Row[12] : '');

        if ($nom_conducteur != "Nom Conducteur") {
       
          $query = "insert into client (nom_entreprise,nom,email,tel,adresse,raison_social,num_permis,comment,type,date_creation_entreprise,siret,naf,codetva) 
                      values('".$nom_entreprise."','".$nom_conducteur."','".$email."','".$tel."','".$adresse."','".$raison_social."','".$num_permis."','".$comment."','".$type."','".date("Y-m-d", strtotime($date_creation_entreprise))."','".$siret."','".$naf."','".$codetva."')";
          $conn->query($query);
        }
      }
    }
    $_SESSION['success']="La liste des Clients est ajoutée avec succès";
    header ("Location:ImportClient.php");
  }else { 
    $_SESSION['echec']="Veuillez vérifier le type de fichier. Fichier Excel uniquement.";
    header ("Location:ImportClient.php");
  }
}
?>