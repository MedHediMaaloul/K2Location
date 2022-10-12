 <?php
    session_start();
    include('Gestion_location/inc/connect_db.php');
    $id_agence = $_SESSION['id_agence'];
    $debut = date('');
    $fin = date('');

    $value = '<table class="table">
    <tr>
        <th class="border-top-0">ID</th>
        <th class="border-top-0">Code de matériel</th>
        <th class="border-top-0">N° de série</th>
        <th class="border-top-0">Désignation</th>
        <th class="border-top-0">Quantité disponible</th>
        <th class="border-top-0">Localisation</th>
        <th class="border-top-0">Disponibilité</th>
        <th class="border-top-0">Transfert</th>
    </tr>';

    if ($id_agence != "0") {
        $query = "SELECT * FROM materiels_agence,materiels,agence
         where materiels_agence.id_materiels = materiels.id_materiels
         AND materiels_agence.id_agence = agence.id_agence
     and  materiels_agence.etat_materiels !='F'
    and materiels_agence.id_agence = '$id_agence'
    ORDER BY id_materiels_agence ASC";
    } else {
        $query = "SELECT * FROM materiels_agence,materiels,agence 
        where materiels_agence.id_materiels = materiels.id_materiels
         AND materiels_agence.id_agence = agence.id_agence
        and  materiels_agence.etat_materiels !='F'
        ORDER BY id_materiels_agence ASC";
    }

    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['etat_materiels'] == "HS") {
            $color = "badge bg-light-info text-white fw-normal";
            $color1 = "background-color: #ffc36d!important";
            $etat = "HORS SERVICE";
            $qti = 0;
        } elseif ($row['etat_materiels'] == "T") {
            $id_materiels_agence = $row['id_materiels_agence'];
            if ($row['num_serie_obg'] == "T") {
                $disponibilte = disponibilite_materiel_num_seriee($row['id_materiels_agence']);
                $localisation = Localisation_materiel($row['id_materiels_agence']);
                if ($disponibilte == "0") {
                    $color = "badge bg-light-success text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "DISPONIBLE";
                    $qti = 1;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=1 WHERE id_materiels_agence=$id_materiels_agence";
                    mysqli_query($conn, $update_query);
                } else {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $etat = "En Location";
                    $qti = 0;
                    $row['lieu_agence'] = $localisation;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=0 WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                }
            }
            //si le matiriel ne pas de n serie
            else {
                $disponibilteqti = disponibilite_materiel_qti_num_seriee($row['id_materiels_agence'], $row['quantite_materiels']);
                $localisation = Localisation_materiel($row['id_materiels_agence']);
                if ($disponibilteqti > 0) {
                    $color = "badge bg-light-success text-white fw-normal";
                    $color1 = "background-color: #2cd07e!important";
                    $etat = "DISPONIBLE";
                    $qti = $disponibilteqti;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=$qti WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                } else {
                    $color = "badge bg-light-info text-white fw-normal";
                    $color1 = "background-color: #ff5050!important";
                    $etat = "En Location";
                    $qti = $disponibilteqti;
                    $row['lieu_agence'] = $localisation;
                    $update_query = "UPDATE materiels_agence SET quantite_materiels_dispo=$qti WHERE id_materiels_agence='$id_materiels_agence'";
                    mysqli_query($conn, $update_query);
                }
            }
            $value .= '
                <tbody>          
                    <tr>
                        <td class="border-top-0">' . $row['id_materiels_agence'] . '</td>
                        <td class="border-top-0">' . $row['code_materiel'] . '</td>
                        <td class="border-top-0">' . $row['num_serie_materiels'] . '</td>
                        <td class="border-top-0">' . $row['designation'] . '</td>
                        <td class="border-top-0">' .   $qti . '</td>
                        <td class="border-top-0">' . $row['lieu_agence'] . '</td>          
                        <td><span class="' . $color . '" style ="' . $color1 . '">' . $etat . '</span></td>
                        <td class="border-top-0">';
                            if ($row['num_serie_obg'] == "T") {
                                $value .= '
                                <button title="Transférer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                            } else {
                                $value .= '<button title="Transférer la voiture" class="btn waves-effect waves-light btn-outline-dark" id="btn-transfert-materiel-quantite" data-id=' . $row['id_materiels_agence'] . ' ><i class="fas fa-exchange-alt"></i></button>';
                            }
                        $value .= '</td>
                    </tr>
                </tbody>';
        }
    }
    
    $value .= '</table>';

    echo json_encode(['status' => 'success', 'html' => $value]);


    function disponibilite_materiel_num_seriee($id_materiels_agence)
    {
        global $conn;
        $date = date('Y-m-d');
   
        $queryp = "SELECT * FROM contrat_client,materiel_contrat_client
        where contrat_client.id_contrat =materiel_contrat_client.id_contrat
        and id_materiels_agence ='$id_materiels_agence'
        and etat_contrat ='A'
        and (ContratDateDebut <= '$date' and ContratDateFin>= '$date')";
        $resultp = mysqli_query($conn, $queryp);

        $queryavenant = "SELECT * FROM contrat_client,contrat_client_avenant,materiel_contrat_client
        where contrat_client_avenant.id_contrat_avenant =materiel_contrat_client.id_contrat_avenant
        AND contrat_client_avenant.id_contrat_client =contrat_client.id_contrat
        and materiel_contrat_client.id_materiels_agence ='$id_materiels_agence'
        and contrat_client.etat_contrat ='A'
        and (materiel_contrat_client.ContratDateDebut <= '$date' and materiel_contrat_client.ContratDateFin>= '$date')";
        $resultavenant = mysqli_query($conn, $queryavenant);
        
        if ($resultp->num_rows > 0 || $resultavenant->num_rows > 0)  {
            return "1";  
        }else{
            return "0";  
        }
    }

    function Localisation_materiel($id_materiels_agence)
    {
        global $conn;
        $date = date('Y-m-d');
        
        $queryi = "SELECT CL.nom_entreprise,CL.nom FROM materiel_contrat_client As C,client AS CL,contrat_client AS CC
        where C.id_materiels_agence ='$id_materiels_agence'
        and C.id_contrat =CC.id_contrat
        and CC.id_client = CL.id_client
        and CC.etat_contrat ='A'
        and (C.ContratDateDebut <= '$date' and C.ContratDateFin>= '$date')";    
        $resulti = mysqli_query($conn, $queryi);

        $queryavenant = "SELECT CL.nom_entreprise,CL.nom 
        FROM contrat_client AS CC,contrat_client_avenant AS CA,materiel_contrat_client AS C,client AS CL
        where CA.id_contrat_avenant =C.id_contrat_avenant
        AND CA.id_contrat_client =CC.id_contrat
        and CC.id_client = CL.id_client
        and C.id_materiels_agence ='$id_materiels_agence'
        and CC.etat_contrat ='A'
        and (C.ContratDateDebut <= '$date' and C.ContratDateFin>= '$date')";
        $resultavenant = mysqli_query($conn, $queryavenant);

        if($resulti->num_rows > 0){
            $row = mysqli_fetch_row($resulti);
            $nomentreprise = $row[0];
            $nom = $row[1];

            if ($nomentreprise == ""){
                $nomclient=$nom;
            }else if ($nom == ""){
                $nomclient=$nomentreprise;
            }else{
                $nomclient=$nomentreprise . " / Conducteur : " . $nom;
            }
        }else if($resultavenant->num_rows > 0){
            $row1 = mysqli_fetch_row($resultavenant);
            $nomentreprise1 = $row1[0];
            $nom1 = $row1[1];

            if ($nomentreprise1 == ""){
                $nomclient=$nom1;
            }else if ($nom1 == ""){
                $nomclient=$nomentreprise1;
            }else{
                $nomclient=$nomentreprise1 . " / Conducteur : " . $nom1;
            }
        }else{
            $nomclient = "";
        }
        
        return $nomclient;
    }

    function disponibilite_materiel_qti_num_seriee($id_materiels_agence, $quantite_materiels)
    {
        global $conn;
        $date = date('Y-m-d');
        $qti = $quantite_materiels;

        $queryi = "SELECT SUM(quantite_contrat) AS qutite FROM materiel_contrat_client AS MC,contrat_client AS C
        where  MC.id_contrat = C.id_contrat
        and C.etat_contrat ='A'
        and ( MC.ContratDateDebut <= '$date' and MC.ContratDateFin >= '$date')
        and MC.id_materiels_agence = $id_materiels_agence";
        $resulti = mysqli_query($conn, $queryi);

        $queryavenant = "SELECT SUM(quantite_contrat) AS qutite
        FROM contrat_client AS C,contrat_client_avenant AS CA,materiel_contrat_client AS MC
        where CA.id_contrat_avenant = MC.id_contrat_avenant
        AND CA.id_contrat_client =C.id_contrat
        and MC.id_materiels_agence ='$id_materiels_agence'
        and C.etat_contrat ='A'
        and (MC.ContratDateDebut <= '$date' and MC.ContratDateFin >= '$date')";
        $resultavenant = mysqli_query($conn, $queryavenant);

        if($resulti->num_rows > 0 && $resultavenant->num_rows == 0){
            $row = mysqli_fetch_assoc($resulti);
            $qtite = $qti - $row['qutite'];
        }else if($resultavenant->num_rows > 0 && $resulti->num_rows == 0){
            $row1 = mysqli_fetch_assoc($resultavenant);
            $qtite = $qti - $row1['qutite'];
        }else if($resultavenant->num_rows > 0 && $resulti->num_rows > 0){
            $row1 = mysqli_fetch_assoc($resultavenant);
            $row = mysqli_fetch_assoc($resulti);
            $qtite = $qti - $row1['qutite'] - $row['qutite'];
        }else{
            $qtite =  $qti;
        }

        return $qtite;
    }


