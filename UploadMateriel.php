<?php

session_start();

require('Upload/php-excel-reader/excel_reader2.php');
require('Upload/SpreadsheetReader.php');
require('Upload/db_config.php');

$_SESSION['success']= array();

if(isset($_POST['Submit'])){
  $date = date("Y/m/d");
  $mail = "contact@k2group.fr";
  $tel = "0000000000";
  $i = $j = 0;
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
      foreach ($Reader as $Row )
      {
        $code_categorie = utf8_encode(isset($Row[0]) ? $Row[0] : '');
        $designation = utf8_encode(isset($Row[1]) ? $Row[1] : '');
        $agence = utf8_encode(isset($Row[2]) ? $Row[2] : '');
        $famille_categorie = utf8_encode(isset($Row[3]) ? $Row[3] : '');
        $num_serie = utf8_encode(isset($Row[4]) ? $Row[4] : '');
        $quantite_materiel = utf8_encode(isset($Row[5]) ? $Row[5] : '');
        $designation_comp = utf8_encode(isset($Row[6]) ? $Row[6] : '');
        $num_serie_composant = utf8_encode(isset($Row[7]) ? $Row[7] : '');
        
        $id_user = $_SESSION['id_user'];
        

        if($num_serie == ""){
          $num_serie_obg = 'F';
          $type_location = 'Pack';
        }else{
          $num_serie_obg = 'T';
          $type_location = 'Individuel';
        }
        if(($code_categorie=="") && ($designation=="") && ($agence=="") && ($famille_categorie=="") && ($num_serie=="") && ($quantite_materiel=="") && ($designation_comp=="") && ($num_serie_composant=="")){

        }else{
          if($code_categorie != "Code de categorie"){
          
            $sqlselectagence = 'SELECT * from agence where lieu_agence = "'.$agence.'"';
            $resultselectagence = mysqli_query($conn, $sqlselectagence);
  
            if($resultselectagence->num_rows > 0){
              $rowagence = mysqli_fetch_assoc($resultselectagence);
              $idagence = $rowagence['id_agence'];
            }else{
              $_SESSION['success']['agence'][$i]="Agence $agence est introuvable</br>";
              $i = $i + 1;
            }
  
            $stmt = "SELECT * FROM materiels WHERE code_materiel = '$code_categorie' and designation = '$designation'";
            $resultat_materiel = mysqli_query($conn, $stmt);
            
            if($resultat_materiel->num_rows == 0){
              $_SESSION['success']['categorie'][$j]="Categorie $designation avec le code $code_categorie est introuvable</br>";
              $j = $j + 1;
            }else{
              $rowamateriel = mysqli_fetch_assoc($resultat_materiel);
              $idmateriel = $rowamateriel['id_materiels'];
            }
  
            if($num_serie != ""){
              $stmatagence = "SELECT * FROM materiels_agence WHERE id_materiels = '$idmateriel' and num_serie_materiels = '$num_serie'";
              $resultat_materielagence = mysqli_query($conn, $stmatagence);
              if($resultat_materielagence->num_rows == 0){
                $query_materiel_agence = "insert into materiels_agence (id_materiels, num_serie_materiels, quantite_materiels, quantite_materiels_dispo, id_agence, id_user) 
                      VALUES ('".$idmateriel."','".$num_serie."','".$quantite_materiel."','".$quantite_materiel."','".$idagence."','".$id_user."')";
                $result_materielagence = mysqli_query($conn, $query_materiel_agence); 
                $query_get_max_id_materielagence = "SELECT max(id_materiels_agence) from materiels_agence"; 
                $result_get_max_id_materielagence = mysqli_query($conn, $query_get_max_id_materielagence);
                $rowidmaxmaterielagence = mysqli_fetch_row($result_get_max_id_materielagence);
                $idmaterielagence = $rowidmaxmaterielagence[0];
              }else{
                $rowamaterielagence = mysqli_fetch_assoc($resultat_materielagence);
                $idmaterielagence = $rowamaterielagence['id_materiels_agence'];
              }
              if($designation_comp != ""){
                $stcategorie = "SELECT * FROM composant_materiels WHERE designation_composant = '$designation_comp' and num_serie_composant = '$num_serie_composant'";
                $resultat_categorie = mysqli_query($conn, $stcategorie);
                if ($resultat_categorie->num_rows == 0) {
                  $sql_composant_materiels = "insert into composant_materiels(id_materiels_agence, designation_composant, num_serie_composant) 
                    VALUES ('".$idmaterielagence."', '".$designation_comp."', '".$num_serie_composant."')";
                  $result_composant_materiels = mysqli_query($conn, $sql_composant_materiels); 
                }
              }
            }else{
              $stmatagencequantite = "SELECT * FROM materiels_agence WHERE id_materiels = '$idmateriel' and id_agence = '$idagence'";
              $resultat_materielagencequantite = mysqli_query($conn, $stmatagencequantite);
              
              if($resultat_materielagencequantite->num_rows == 0){
                $query_materiel_agence_quantite = "insert into materiels_agence (id_materiels, num_serie_materiels, quantite_materiels, quantite_materiels_dispo, id_agence, id_user) 
                      VALUES ('".$idmateriel."','".$num_serie."','".$quantite_materiel."','".$quantite_materiel."','".$idagence."','".$id_user."')";
                $result_materielagencequantite = mysqli_query($conn, $query_materiel_agence_quantite); 
              }else{
                $update_query = "UPDATE materiels_agence 
                SET quantite_materiels=$quantite_materiel,quantite_materiels_dispo=$quantite_materiel
                WHERE id_materiels = '$idmateriel' and id_agence = '$idagence'";
                $result_update = mysqli_query($conn, $update_query); 
              }
            }
          }
        }
      }
    }
    $_SESSION['success']['result']="La liste des Matériel est ajoutée avec succès";
    header ("Location:ImportMateriel.php");
  }else { 
    $_SESSION['echec']="Veuillez vérifier le type de fichier. Fichier Excel uniquement.";
    header ("Location:ImportMateriel.php");
  }
}
?>