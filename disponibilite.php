<?php
require_once('Gestion_location/inc/connect_db.php');

function disponibilite_materiel_num_serie($id_materiels_agence, $debut, $fin)
{
    global $conn;


    /*
    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $row['quantite_materiels_dispo'];
*/

    $query = "SELECT * FROM contrat_client, materiel_contrat_client
    where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
    id_materiels_agence ='$id_materiels_agence' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
     
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        echo ("disponibile");
    } else {
        echo ("Non disponibile");
    }
}


function disponibilite_materiel($id_materiels, $debut, $fin)
{
    global $conn;




    $query = "SELECT * FROM materiel_group_packs,materiels 
     where materiels.id_materiels = materiel_group_packs.id_materiels";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['num_serie_obg'] == 'T') {
            echo $row['id_materiels'];
        }
    }


    /*

    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels ='$id_materiels' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    echo $row['quantite_materiels_dispo'];

    
    $query = "SELECT * FROM contrat_client, materiel_contrat_client,materiels_agence
    where
      contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
      materiel_contrat_client.id_materiels_agence= materiels_agence.id_materiels_agence and 
      materiels_agence.id_materiels ='$id_materiels' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
 
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        echo ("disponibile");
    } else {
        echo ("Non disponibile");
    }
    */
}



//disponibilite_materiel_num_serie(3, "2021-06-01", "2021-09-01");

function disponibilite_voiture($id_voiture, $debut, $fin)
{
    global $conn;





    $query = "SELECT * FROM contrat_client, voiture
    where  contrat_client.id_voiture= voiture.id_voiture and 
    contrat_client.id_voiture ='$id_voiture' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
     or (date_debut <='$fin' and date_fin >='$fin' ) 
     or (date_debut >='$debut' and date_fin <='$fin' ))
      
    ";
    $result = mysqli_query($conn, $query);
    $nb_res = mysqli_num_rows($result);
    if ($nb_res == 0) {
        echo ("disponibile");
    } else {
        echo ("Non disponibile");
    }
}


/*
disponibilite_voiture(6, "2021-06-01", "2021-12-01");
echo "<br>";
disponibilite_voiture(6, "2021-06-01", "2021-06-12");
echo "<br>";
disponibilite_voiture(6, "2021-07-06", "2021-07-06");
echo "<br>";
disponibilite_voiture(6, "2021-08-01", "2021-09-01");
*/

function disponibilite_quantite_materiel($id_materiels_agence, $debut, $fin, $quantite)
{
    global $conn;

    $sqlqtidispo = "SELECT quantite_materiels_dispo from   materiels_agence where  id_materiels_agence ='$id_materiels_agence' ";
    $resultqtidispo = mysqli_query($conn, $sqlqtidispo);
    $row = mysqli_fetch_assoc($resultqtidispo);
    $quantite_materiels_dispo = $row['quantite_materiels_dispo'];

    $query = "SELECT SUM(quantite_contrat) as quantite_loue
    FROM contrat_client, materiel_contrat_client
    where  contrat_client.id_contrat= materiel_contrat_client.id_contrat and 
    id_materiels_agence ='$id_materiels_agence' and 
    ((date_debut <='$debut' and date_fin >='$debut' )
    or (date_debut <='$fin' and date_fin >='$fin' ) 
    or (date_debut >='$debut' and date_fin <='$fin' )) ";
    $result = mysqli_query($conn, $query);
    $row_quantite = mysqli_fetch_assoc($result);
    $quantite_loue = $row_quantite['quantite_loue'];
    if ($quantite_loue == '')
        $quantite_loue = 0;

    $quantite_disponible = $quantite_materiels_dispo - $quantite_loue;


    if ($quantite <= $quantite_disponible) {
        echo ("disponibile");
    } else {
        echo ("Non disponibile");
    }
}





function disponibilite_pack($id_pack, $debut, $fin)
{
    global $conn;

    $nb_materiel_numserie = 0;

    $nb_materiel_sansnumserie = 0;

    $query = "SELECT * FROM materiel_group_packs,materiels 
     where materiels.id_materiels = materiel_group_packs.id_materiels
     and materiel_group_packs.id_group_packs =$id_pack";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['num_serie_obg'] == 'T') {



            $query_mat = "SELECT * FROM materiels_agence
    where materiels.id_materiels = " . $row['id_materiels'];
            $result_mat = mysqli_query($conn, $query_mat);
            while ($row_mat = mysqli_fetch_assoc($result_mat)) {
                $id_materiels_agence = $row_mat['id_materiels_agence'];
                if (disponibilite_materiel_num_serie($id_materiels_agence, $debut, $fin) == 'disponibile') {
                    $materiel_numserie_disponible = 'ok';
                    // $tab[$nb_materiel_numserie];= 'ok';
                }
            }
            $nb_materiel_numserie++;
        } else {
            $nb_materiel_sansnumserie++;
            $qti =   $row['quantite'];

            $query_mat = "SELECT * FROM materiels_agence
            where materiels.id_materiels = " . $row['id_materiels'];
            $result_mat = mysqli_query($conn, $query_mat);
            while ($row_mat = mysqli_fetch_assoc($result_mat)) {
                $id_materiels_agence = $row_mat['id_materiels_agence'];
                if (disponibilite_quantite_materiel($id_materiels_agence, $debut, $fin, $qti) != 'disponibile') {
                    $materiel_numserie_disponible = 'ok';
                }
            }
        }
    }

    if (($materiel_numserie_disponible == "ok" || $nb_materiel_numserie == 0)) {
        echo "disponible";
    }
}