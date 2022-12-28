<?php
include("Gestion_location/inc/connect_pdo.php");
global $conn;
$time = rand( 0, time() );
$filname = "StockVoitureListeK2_$time";

header('Content-Encoding: UTF-8');
header('Content-type:application/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=$filname.csv");

$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$stmt = $bdd->prepare("SELECT V.id_voiture,V.type,V.pimm,MM.Marque,MM.Model,V.boite_vitesse,V.type_carburant,V.date_achat,V.date_immatriculation,
A.lieu_agence
FROM voiture AS V 
LEFT JOIN marquemodel AS MM ON V.id_MarqueModel=MM.id_MarqueModel
LEFT JOIN agence AS A ON V.id_agence=A.id_agence
WHERE V.actions !='S'
ORDER BY V.id_voiture");
$stmt->execute();
$data = $stmt->fetchAll();
?>
"type";"pimm";"Marque";"Model";"boite_vitesse";"type_carburant";"date_achat";"Localisation";"Disponibilite"
<?php
foreach($data as $d){
    $d->etat_voiture = "DISPONIBLE";
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $del = $bdd->prepare("SELECT * FROM contrat_client As C,client AS CL
    where C.id_voiture ='$d->id_voiture' 
    and C.id_client = CL.id_client
    and C.etat_contrat = 'A' 
    and ((C.date_debut <= DATE(NOW()) 
    and C.date_fin >=DATE(NOW())))");
    $del->execute();
    $data1 = $del->fetchAll();
    if ($del->rowCount() > 0){
        $d->etat_voiture = "En Location";
        foreach($data1 as $d1){
            $d->lieu_agence = $d1->nom_entreprise;
        }
    }
    $del_avenant = $bdd->prepare("SELECT * FROM contrat_client_avenant As CA,contrat_client As C,client AS CL
    where CA.id_voiture_avenant ='$d->id_voiture' 
    and CA.id_contrat_client = C.id_contrat
    and C.id_client = CL.id_client 
    and ((CA.debut_contrat_avenant <= DATE(NOW()) and CA.fin_contrat_avenant >=DATE(NOW())))");
    $del_avenant->execute();
    $data_avenant = $del_avenant->fetchAll();
    if ($del_avenant->rowCount() > 0){
        $d->etat_voiture = "En Location";
        foreach($data_avenant as $d2){
            $d->lieu_agence = $d2->nom_entreprise;
        }
    }
    echo '"'.utf8_decode($d->type).'";"'.utf8_decode($d->pimm).'";"'.utf8_decode($d->Marque).'";"'.utf8_decode($d->Model).'";"'.utf8_decode($d->boite_vitesse).'";"'.utf8_decode($d->type_carburant).'";"'.utf8_decode($d->date_achat).'";"'.utf8_decode($d->lieu_agence).'";"'.utf8_decode($d->etat_voiture).'";'."\n";
}
?>
