<?php
include("Gestion_location/inc/connect_pdo.php");

$time = rand( 0, time() );
$filname = "MaterielListeK2_$time";

header('Content-Encoding: UTF-8');
header('Content-type:application/csv; charset=UTF-8');
header('Content-Type: text/html; charset=windows-1251');
header('Content-Type: text/html; charset=utf-8');
header("Content-Disposition: attachment; filename=$filname.csv");

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$stmt = $bdd->prepare("SELECT *
FROM materiels AS M 
LEFT JOIN materiels_agence AS MA ON M.id_materiels = MA.id_materiels
LEFT JOIN composant_materiels AS CM ON MA.id_materiels_agence = CM.id_materiels_agence
LEFT JOIN agence AS A ON MA.id_agence=A.id_agence
ORDER BY M.code_materiel,M.designation,MA.num_serie_materiels");
$stmt->execute();
$data = $stmt->fetchAll();
?>
"Code de categorie";"Designation";"Agence";"Famille de categorie";"num_serie_materiels";"quantite_materiels";"designation_comp";"num_serie_composant"
<?php
foreach($data as $d){
    echo '"'.utf8_decode($d->code_materiel).'";"'.utf8_decode($d->designation).'";"'.utf8_decode($d->lieu_agence).'";"'.utf8_decode($d->famille_materiel).'";"'.utf8_decode($d->num_serie_materiels).'";"'.utf8_decode($d->quantite_materiels).'";"'.utf8_decode($d->designation_composant).'";"'.utf8_decode($d->num_serie_composant).'";'."\n";
}
?>