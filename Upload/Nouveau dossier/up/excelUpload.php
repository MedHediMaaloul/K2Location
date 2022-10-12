<?php
require('php-excel-reader/excel_reader2.php');
require('SpreadsheetReader.php');
require('db_config.php');


if(isset($_POST['Submit'])){
  $mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','xlsx','application/vnd.oasis.opendocument.spreadsheet'];
  if(in_array($_FILES["file"]["type"],$mimes)){
    $uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);
    $Reader = new SpreadsheetReader($uploadFilePath);
    $totalSheet = count($Reader->sheets());
    echo "Vous avez en total ".$totalSheet." sheets ajouté".
    $html="<table border='1'>";
    $html.="<tr><th>Title</th><th>Description</th></tr>";
    /* For Loop for all sheets */
    for($i=0;$i<$totalSheet;$i++){
      $Reader->ChangeSheet($i);
      foreach ($Reader as $Row)
      {

        
        $html.="<tr>";
        $nom_entreprise = isset($Row[0]) ? $Row[0] : '';
        $nom_conducteur = isset($Row[1]) ? $Row[1] : '';
        $email = isset($Row[2]) ? $Row[2] : '';
        $tel = isset($Row[3]) ? $Row[3] : '';
        $adresse = isset($Row[4]) ? $Row[4] : '';
        $raison_social = isset($Row[5]) ? $Row[5] : '';
        $num_permis = isset($Row[6]) ? $Row[6] : '';
        $comment = isset($Row[7]) ? $Row[7] : '';
        $type = isset($Row[8]) ? $Row[8] : '';
        $date_creation_entreprise = isset($Row[9]) ? $Row[9] : '';
        $siret = isset($Row[10]) ? $Row[10] : '';
        $naf = isset($Row[11]) ? $Row[11] : '';
        $codetva = isset($Row[12]) ? $Row[12] : '';

        $html.="<td>".$nom."</td>";
        $html.="<td>".$email."</td>";
        $html.="</tr>";
        $query = "insert into client (nom_entreprise,nom,email,tel,adresse,raison_social,num_permis,comment,type,date_creation_entreprise,siret,naf,codetva) 
                              values('".$nom_entreprise."','".$nom_conducteur."','".$email."','".$tel."','".$adresse."','".$raison_social."','".$num_permis."','".$comment."','".$type."','".$date_creation_entreprise."','".$siret."','".$naf."','".$codetva."')";
        $conn->query($query);
       }
    }
    $html.="</table>";
    echo "<br />La liste des clients est ajoutée avec succès";
  }else { 
    die("<br/>Veuillez vérifier le type de fichier. Fichier Excel uniquement."); 
  }
}
?>