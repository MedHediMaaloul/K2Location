<?php
include("Gestion_location/inc/connect_pdo.php");
$time = rand( 0, time() );
$filname = "VoitureListeK2_$time";

header('Content-Encoding: UTF-8');
header('Content-type:application/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=$filname.csv");

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$stmt = $bdd->prepare("SELECT V.id_voiture,V.type,V.pimm,MM.Marque,MM.Model,V.boite_vitesse,V.type_carburant,
V.date_DPC_VGP,V.date_DPC_VT,V.date_DPT_Pollution,V.id_MarqueModel,V.fournisseur,V.km,V.date_achat,V.date_immatriculation,
A.lieu_agence
FROM voiture AS V 
LEFT JOIN marquemodel AS MM ON V.id_MarqueModel=MM.id_MarqueModel
LEFT JOIN agence AS A ON V.id_agence=A.id_agence
ORDER BY V.id_voiture");
$stmt->execute();
$data = $stmt->fetchAll();
?>
"type";"pimm";"Marque";"Model";"Agence";"fournisseur";"km";"date_achat";"date_immatriculation";"boite_vitesse";"type_carburant";"date_DPC_VGP";"date_DPC_CT";"date_DPT_Pollution"
<?php
foreach($data as $d){
    echo '"'.utf8_decode($d->type).'";"'.utf8_decode($d->pimm).'";"'.utf8_decode($d->Marque).'";"'.utf8_decode($d->Model).'";"'.utf8_decode($d->lieu_agence).'";"'.utf8_decode($d->fournisseur).'";"'.utf8_decode($d->km).'";"'.utf8_decode($d->date_achat).'";"'.utf8_decode($d->date_immatriculation).'";"'.utf8_decode($d->boite_vitesse).'";"'.utf8_decode($d->type_carburant).'";"'.utf8_decode($d->date_DPC_VGP).'";"'.utf8_decode($d->date_DPC_VT).'";"'.utf8_decode($d->date_DPT_Pollution).'";'."\n";
}
?>
