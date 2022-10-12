<?php

session_start();

require('Upload/php-excel-reader/excel_reader2.php');
require('Upload/SpreadsheetReader.php');
require('Upload/db_config.php');

if(isset($_POST['Submit'])){
  $date = date("Y/m/d");
  $mail = "contact@k2group.fr";
  $tel = "0000000000";
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
      foreach ($Reader as $Row){
        $b = utf8_encode(isset($Row[0]) ? $Row[0] : '');
        $c = utf8_encode(isset($Row[1]) ? $Row[1] : '');
        $e = utf8_encode(isset($Row[2]) ? $Row[2] : '');
        $f = utf8_encode(isset($Row[3]) ? $Row[3] : '');
        $d = utf8_encode(isset($Row[4]) ? $Row[4] : '');
        $g = utf8_encode(isset($Row[5]) ? $Row[5] : '');
        $h = utf8_encode(isset($Row[6]) ? $Row[6] : '');
        $i = utf8_encode(isset($Row[7]) ? $Row[7] : '');
        $j = utf8_encode(isset($Row[8]) ? $Row[8] : '');
        $k = utf8_encode(isset($Row[9]) ? $Row[9] : '');
        $l = utf8_encode(isset($Row[10]) ? $Row[10] : '');
        $m = utf8_encode(isset($Row[11]) ? $Row[11] : '');
        $n = utf8_encode(isset($Row[12]) ? $Row[12] : '');
        $o = utf8_encode(isset($Row[13]) ? $Row[13] : '');

        $id_user = $_SESSION['id_user'];

        if ($c != "pimm") {
          $sqlselectagence = 'SELECT * from agence where lieu_agence = "'.$d.'"';
          $resultselectagence = mysqli_query($conn, $sqlselectagence);

          if ($resultselectagence->num_rows > 0) {
            $rowagence = mysqli_fetch_assoc($resultselectagence);
            $idagence = $rowagence['id_agence'];
          }else{
            // $queryagence = "insert into agence (lieu_agence,date_agence,email_agence,tel_agence) values('".$d."','".$date."','".$mail."','".$tel."')";
            // $resultagence = mysqli_query($conn, $queryagence); 
            // $query_get_max_id_agence = "SELECT max(id_agence) from agence"; 
            // $result_get_max_id_agence = mysqli_query($conn, $query_get_max_id_agence);
            // $rowidmax = mysqli_fetch_row($result_get_max_id_agence);
            // $idagence = $rowidmax[0];
          }

          $sqlselectpimm = "SELECT * from voiture where pimm ='$c'";
          $resultselectpimm = mysqli_query($conn, $sqlselectpimm);

          if ($resultselectagence->num_rows > 0) {
          }else{
            $sqlselectmarque = "SELECT * from marquemodel where Marque ='$e' and Model ='$f' ";
            $resultselectmarque = mysqli_query($conn, $sqlselectmarque);
          
            if ($resultselectmarque->num_rows > 0) {
                $row = mysqli_fetch_assoc($resultselectmarque);
                $idmarquemodel = $row['id_MarqueModel'];

                $queryvehicule = "insert into voiture
                  (type,pimm,id_MarqueModel,id_agence,fournisseur,km,date_achat,date_immatriculation,boite_vitesse,type_carburant,id_user,date_DPC_VGP,date_DPC_VT,date_DPT_Pollution) 
                  values('".$b."','".$c."','".$idmarquemodel."','".$idagence."','".$g."','".$h."','".date('Y-m-d', strtotime($i))."','".date('Y-m-d', strtotime($j))."','".$k."','".$l."','".$id_user."','".date('Y-m-d', strtotime($m))."','".date('Y-m-d', strtotime($n))."','".date('Y-m-d', strtotime($o))."')";
                $resultvehicule = mysqli_query($conn, $queryvehicule);
            }else {
              $querymarquemodel = "insert into marquemodel
                (Marque,Model) 
                values('".$e."','".$f."')";
              $resultmarquemodel = mysqli_query($conn, $querymarquemodel);

              if ($resultmarquemodel) {
                $sqlselectmarque1 = "SELECT * from marquemodel where Marque ='$e' and Model ='$f' ";
                $resultselectmarque1 = mysqli_query($conn, $sqlselectmarque1);
                $row1 = mysqli_fetch_assoc($resultselectmarque1);
                $idmarquemodel1 = $row1['id_MarqueModel'];

                $queryvehicule = "insert into voiture
                (type,pimm,id_MarqueModel,id_agence,fournisseur,km,date_achat,date_immatriculation,boite_vitesse,type_carburant,id_user,date_DPC_VGP,date_DPC_VT,date_DPT_Pollution) 
                values('".$b."','".$c."','".$idmarquemodel1."','".$idagence."','".$g."','".$h."','".date('Y-m-d', strtotime($i))."','".date('Y-m-d', strtotime($j))."','".$k."','".$l."','".$id_user."','".date('Y-m-d', strtotime($m))."','".date('Y-m-d', strtotime($n))."','".date('Y-m-d', strtotime($o))."')";
                $resultvehicule = mysqli_query($conn, $queryvehicule);
              }
            }
          }
        }  
      }
    }
    $_SESSION['success']="La liste des Voitures est ajoutée avec succès";
    header ("Location:ImportVoiture.php");
  }else { 
    $_SESSION['echec']="Veuillez vérifier le type de fichier. Fichier Excel uniquement.";
    header ("Location:ImportVoiture.php");
  }
}
?>