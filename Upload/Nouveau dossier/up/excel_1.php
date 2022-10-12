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
        $code_categorie = isset($Row[0]) ? $Row[0] : '';
        $designation = isset($Row[1]) ? $Row[1] : '';
        $famille_categorie = isset($Row[2]) ? $Row[2] : '';
        $num_serie = isset($Row[3]) ? $Row[3] : '';
        $quantite_materiel = isset($Row[4]) ? $Row[4] : '';
        $designation_comp = isset($Row[5]) ? $Row[5] : '';
        $num_serie_composant = isset($Row[6]) ? $Row[6] : '';
        $agence = isset($Row[7]) ? $Row[7] : '';
        $id_user = $_SESSION['id_user'];

        if ($quantite_materiel == 1) {
            $num_serie_obg = 1;
            $type_location = 'Individuel';
        }else{
            $num_serie_obg = 0;
            $type_location = 'Pack';
        }

        $stmt = "SELECT * FROM materiels WHERE code_materiel = $code_categorie";
        $resultat_materiel = $conn->query($stmt);

        $stmt_agence = "SELECT * FROM agence WHERE lieu_agence = $agence";
        $resultat_agence = $conn->query($stmt_agence);


        if ($resultat_materiel) {
            $query_materiel_agence = "insert into materiels_agence (id_materiels, num_serie_materiels, quantite_materiels, quantite_materiels_dispo, id_agence, id_user) VALUES ('".$resultat_materiel['id_materiels ']."','".$num_serie."','".$quantite_materiel."','".$quantite_materiel."','".$resultat_agence['id_agence']."','".$id_user."')";
            $conn->query($query_materiel_agence);
            $last_id_materiel_agence = $conn->insert_id;

            
        }else{

            $query_materiel = "insert into materiels (code_materiel, designation, famille_materiel, type_location, num_serie_obg, id_user)  VALUES ('".$code_categorie."','".$designation."','".$famille_categorie."','".$type_location."','".$num_serie_obg."','".$id_user."')";
            $conn->query($query_materiel);
            $last_id_materiel = $conn->insert_id;

            $query_materiel_agence = "insert into materiels_agence (id_materiels, num_serie_materiels, quantite_materiels, quantite_materiels_dispo, id_agence, id_user) VALUES ('".$last_id_materiel."','".$num_serie."','".$quantite_materiel."','".$quantite_materiel."','".$resultat_agence['id_agence']."','".$id_user."')";
            $conn->query($query_materiel_agence);
            $last_id_materiel_agence = $conn->insert_id;

        }
        

        if ($designation_comp != '') {
            $sql_composant_materiels = "insert into composant_materiels (id_materiels_agence, designation_composant, num_serie_composant) VALUES ('".$last_id_materiel_agence."', '".$designation_comp."', '".$num_serie_composant."')";
            $conn->query($query_materiel_agence);
      
        }
        

        $html.="<td>".$code_categorie."</td>";
        $html.="<td>".$designation."</td>";
        $html.="<td>".$famille_categorie."</td>";
        $html.="<td>".$num_serie."</td>";
        $html.="<td>".$quantite_materiel."</td>";
        $html.="<td>".$designation_comp."</td>";
        $html.="<td>".$num_serie_composant."</td>";
        $html.="</tr>";
       }
    }
    $html.="</table>";
    echo "<br />La liste des Matériel est ajoutée avec succès";
  }else { 
    die("<br/>Veuillez vérifier le type de fichier. Fichier Excel uniquement."); 
  }
}
?>