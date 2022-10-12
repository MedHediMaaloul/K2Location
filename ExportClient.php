<?php
include("Gestion_location/inc/connect_pdo.php");
$time = rand( 0, time() );
$filname = "ClientListeK2_$time";

header('Content-Decoding: UTF-8');
header('Content-Type: text/html; charset=utf-8');
header('Content-type:application/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=$filname.csv");

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$stmt = $bdd->prepare("SELECT * FROM `client` WHERE etat_client != 'S' ORDER BY id_client");
$stmt->execute();
$data = $stmt->fetchAll();
?>
"Nom de l'entreprise";"Nom Conducteur";"Email";"Telephone";"Adresse";"Raison Social";"Num Permis";"Commentaire";"Type";"Date Creation de l'entreprise";"Num Siret";"Code Naf";"Code TVA"
<?php
foreach($data as $d){
    echo '"'.utf8_decode($d->nom_entreprise).'";"'.utf8_decode($d->nom).'";"'.utf8_decode($d->email).'";"'.utf8_decode($d->tel).'";"'.utf8_decode($d->adresse).'";"'.utf8_decode($d->raison_social).'";"'.utf8_decode($d->num_permis).'";"'.utf8_decode($d->comment).'";"'.utf8_decode($d->type).'";"'.date("Y-m-d", strtotime($d->date_creation_entreprise)).'";"'.utf8_decode($d->siret).'";"'.utf8_decode($d->naf).'";"'.utf8_decode($d->codetva).'";'."\n";
}
?>