<?php

session_start();
$id_agence = $_SESSION['id_agence'];
$Role = $_SESSION['Role'];
// verification si la personn est bien passé par la page pour se connecter
if (!isset($_SESSION['User'])) {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
} else {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
}
?>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  --
       ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    Tableau de bord
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <?php
            include('Gestion_location/inc/connect_db.php');
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">TABLEAU DE BORD</div>
                    <div class="card-body">

                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Les totaux
                                    enregistrés</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <!-- Nbre total de clients  -->
                            <div class="col">
                                <div class="card border border-primary mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-primary shadow text-primary p-3 my-card"
                                        style="display:inline-block"><span class="fa fa-user" aria-hidden="true"
                                            style="margin-top:3px"></span></div>
                                    <div class="text-primary text-center mt-3">
                                        <h4>Nombre total de clients</h4>
                                    </div>
                                    <?php

                                    $query = "SELECT id_client FROM client  WHERE etat_client != 'S' ORDER BY id_client ";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-primary text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de véhicules  -->
                            <div class="col">
                                <div class="card  border border-info mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-info shadow text-info p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-truck" aria-hidden="true"
                                            style="margin-top:3px"></span></div>
                                    <div class="text-info text-center mt-3">
                                        <h4>Nombre total de véhicules</h4>
                                    </div>
                                    <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT id_voiture FROM voiture 
                                    WHERE actions != 'S' 
                                    ORDER BY id_voiture";
                                    } else {
                                        $query = "SELECT id_voiture FROM voiture 
                                        WHERE actions != 'S' 
                                        AND id_agence = $id_agence
                                        ORDER BY id_voiture";
                                    }

                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-info text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                    <div class="card-group">
                                        <div class="card border border-info shadow text-info p-3 my-card"
                                            style="display:inline-block"><span class="fas fa-truck" aria-hidden="true"
                                                style="margin-top:3px"></span>
                                            <span class="fas fa-wrench" aria-hidden="true"
                                                style="margin-top:3px"></span>
                                            <?php
                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                $query = "SELECT id_voiture  FROM voiture Where etat_voiture = 'HS' or etat_voiture = 'Entretien'    
                                             ORDER BY id_voiture ";
                                            } else {
                                                $query = "SELECT id_voiture  FROM voiture Where etat_voiture = 'HS' or etat_voiture = 'Entretien'
                                             AND id_agence = $id_agence
                                             ORDER BY id_voiture ";
                                            }
                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            ?>
                                            <h5 class="text-info text-center mt-3">Nombre de véhicules en maintenance:
                                                <div class="text-info text-center mt-2">
                                                    <h1><?php echo $row; ?></h1>
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de matériels  -->
                            <div class="col">
                                <div class="card border border-secondary mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-secondary shadow text-secondary p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-box-open" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-secondary text-center mt-3">
                                        <h4>Nombre total de Matériels</h4>
                                    </div>
                                    <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT id_materiels_agence 
                                        FROM materiels_agence 
                                        WHERE   etat_materiels != 'F'
                                        ORDER BY id_materiels_agence";
                                    } else {
                                        $query = "SELECT id_materiels_agence 
                                    FROM materiels_agence 
                                    WHERE   etat_materiels != 'F'
                                    AND id_agence = $id_agence
                                    ORDER BY id_materiels_agence";
                                    }


                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-secondary text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de packs  -->
                            <div class="col">
                                <div class="card border border-dark mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-dark shadow text-dark p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-cube" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-dark text-center mt-3">
                                        <h4>Nombre total de Packs</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_group_packs 
                                   FROM group_packs 
                                   WHERE   etat_group_pack = 'T'
                                   ORDER BY id_group_packs";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-dark text-center mt-2">
                                        <h1>
                                            <?php echo $row; ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total d'entretiens  -->
                            <div class="col">
                                <div class="card border border-danger mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-danger shadow text-danger p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-wrench" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-danger text-center mt-3">
                                        <h4>Nombre total d'entretiens</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_entretien FROM entretien  ORDER BY id_entretien";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-danger text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de factures  -->
                            <div class="col">
                                <div class="card border border-success mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-success shadow text-success p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-list-alt" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-success text-center mt-3">
                                        <h4>Nombre total de factures</h4>
                                    </div>
                                    <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT id_facture FROM facture_client ORDER BY id_facture";
                                    } else {
                                        $query = "SELECT id_facture FROM facture_client WHERE id_agence = $id_agence ORDER BY id_facture";
                                    }
                                    
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-success text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de contrats  -->
                            <div class="col">
                                <div class="card border border-warning mx-sm-1 p-3"
                                    style="width: 400px; height: 400px;">
                                    <div class="card border border-warning shadow text-warning p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-calendar" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-warning text-center mt-3">
                                        <h4>Nombre total de contrats</h4>
                                    </div>
                                    <?php

                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){

                                        $query = "SELECT id_contrat  FROM contrat_client WHERE etat_contrat != 'S'
                                         ORDER BY id_contrat ";
                                    } else {
                                        $query = "SELECT id_contrat  FROM contrat_client WHERE etat_contrat != 'S'
                                         and id_agence = $id_agence
                                         ORDER BY id_contrat ";
                                    }

                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-warning text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                    <!-- Groupe des contrats  -->
                                    <div class="card-group">
                                        <div class="card border border-warning shadow text-warning p-3 my-card"
                                            style="display:inline-block"><span class="fas fa-truck" aria-hidden="true"
                                                style="margin-top:3px"></span>
                                            <?php

                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){

                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Vehicule' AND etat_contrat != 'S'
        
                                                     ORDER BY id_contrat ";
                                            } else {


                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Vehicule' AND etat_contrat != 'S'
                                                    AND id_agence = $id_agence
                                                    ORDER BY id_contrat ";
                                            }


                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            ?>
                                            <h5 class="text-warning text-center mt-3">Nombre total de contrats véhicule
                                                :
                                                <div class="text-warning text-center mt-2">
                                                    <h1><?php echo $row; ?></h1>
                                                </div>
                                            </h5>
                                        </div>


                                        <div class="card border border-warning shadow text-warning p-3 my-card"
                                            style="display:inline-block"><span class="fas fa-box-open"
                                                aria-hidden="true" style="margin-top:3px"></span>
                                            <?php

                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){

                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Materiel' AND etat_contrat != 'S' ORDER BY id_contrat ";
                                            } else {

                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Materiel' AND etat_contrat != 'S'
                                                 AND id_agence = $id_agence
                                                    ORDER BY id_contrat ";
                                            }


                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            ?>
                                            <h5 class="text-warning text-center mt-3">Nombre total de contrats matériel
                                                :
                                                <div class="text-warning text-center mt-2">
                                                    <h1><?php echo $row; ?></h1>
                                                </div>
                                            </h5>
                                        </div>


                                        <div class="card border border-warning shadow text-warning p-3 my-card"
                                            style="display:inline-block"><span class="fas fa-cube" aria-hidden="true"
                                                style="margin-top:3px"></span>
                                            <?php
                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Pack' AND etat_contrat != 'S' ORDER BY id_contrat ";
                                            } else {
                                                $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Pack' AND etat_contrat != 'S' AND id_agence = $id_agence ORDER BY id_contrat ";
                                            }
                                            $query_run = mysqli_query($conn, $query);
                                            $row = mysqli_num_rows($query_run);
                                            ?>
                                            <h5 class="text-warning text-center mt-3">Nombre total de contrats pack :
                                                <div class="text-warning text-center mt-2">
                                                    <h1><?php echo $row; ?></h1>
                                                </div>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Les pourcentages  -->

                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Les
                                    pourcentages enregistrés</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm" id="voiturechart" style="width: 300px; height: 200px;"></div>
                            <div class="col-sm" id="materielchart" style="width: 300px; height: 200px;"></div>
                            <div class="col-sm" id="packchart" style="width: 300px; height: 200px;"></div>
                            <div class="col-sm" id="entretienchart" style="width: 300px; height: 200px;"></div>
                            <div class="col-sm" id="contratchart" style="width: 300px; height: 200px;"></div>
                            <div class="col-sm" id="facturechart" style="width: 300px; height: 200px;"></div>
                        </div>

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });
                        google.charts.setOnLoadCallback(drawChartVoiture);
                        google.charts.setOnLoadCallback(drawChartMateriel);
                        google.charts.setOnLoadCallback(drawChartPack);
                        google.charts.setOnLoadCallback(drawChartEntretien);
                        google.charts.setOnLoadCallback(drawChartContrat);
                        google.charts.setOnLoadCallback(drawChartFacture);

                        function drawChartEntretien() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    $query = "SELECT type, count(*) as number FROM entretien GROUP BY type";
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "['" . $row["type"] . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux d\'Entretiens par type',
                                is3D: true,
                            };      
                            var chart = new google.visualization.PieChart(document.getElementById('entretienchart'));
                            chart.draw(data, options);
                        }

                        function drawChartPack() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    $query = "SELECT etat_group_pack, count(id_group_packs) as number FROM group_packs GROUP BY etat_group_pack";
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['etat_group_pack'] == "T") {
                                            $rowETAT = "DISPONIBLE";
                                        } elseif ($row['etat_group_pack'] == "F") {
                                            $rowETAT = "NON DISPONIBLE";
                                        } elseif ($row['etat_group_pack'] == "S") {
                                            $rowETAT = "SUPPRIME";
                                        }
                                        echo "['" . $rowETAT . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux de Packs par etat',
                                is3D: true,
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('packchart'));
                            chart.draw(data, options);
                        }

                        function drawChartFacture() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT C.type_location, count(F.id_facture) as number FROM facture_client As F LEFT JOIN contrat_client AS C ON F.id_contrat =C.id_contrat 
                                                GROUP BY C.type_location";
                                    }else{
                                        $query = "SELECT C.type_location, count(F.id_facture) as number FROM facture_client As F LEFT JOIN contrat_client AS C ON F.id_contrat =C.id_contrat 
                                                WHERE F.id_agence = $id_agence
                                                GROUP BY C.type_location";
                                    }
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "['" . $row["type_location"] . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux de Factures par type',
                                is3D: true,
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('facturechart'));
                            chart.draw(data, options);
                        }

                        function drawChartMateriel() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT etat_materiels, count(id_materiels_agence) as number FROM materiels_agence  GROUP BY etat_materiels";
                                    }else{
                                        $query = "SELECT etat_materiels, count(id_materiels_agence) as number FROM materiels_agence WHERE id_agence = $id_agence  GROUP BY etat_materiels";
                                    }
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['etat_materiels'] == "T") {
                                            $rowETAT = "DISPONIBLE";
                                        } elseif ($row['etat_materiels'] == "F") {
                                            $rowETAT = "NON DISPONIBLE";
                                        } elseif ($row['etat_materiels'] == "HS") {
                                            $rowETAT = "HORS SERVICE";
                                        } elseif ($row['etat_materiels'] == "E") {
                                            $rowETAT = "ENTRETIEN";
                                        }
                                        echo "['" . $rowETAT . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux de Materiels par état',
                                is3D: true,
                                tooltip: { isHtml: true }
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('materielchart'));
                            chart.draw(data, options);
                        }

                        function drawChartVoiture() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT etat_voiture, count(*) as number FROM voiture GROUP BY etat_voiture";
                                    }else{
                                        $query = "SELECT etat_voiture, count(*) as number FROM voiture WHERE id_agence = $id_agence GROUP BY etat_voiture";
                                    }
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['etat_voiture'] == "Disponible") {
                                            $rowETAT = "DISPONIBLE";
                                        } elseif ($row['etat_voiture'] == "Loue") {
                                            $rowETAT = "LOUE";
                                        } elseif ($row['etat_voiture'] == "HS") {
                                            $rowETAT = "HORS SERVICE";
                                        } elseif ($row['etat_voiture'] == "Entretien") {
                                            $rowETAT = "ENTRETIEN";
                                        } elseif ($row['etat_voiture'] == "Vendue") {
                                            $rowETAT = "VENDUE";
                                        }
                                        echo "['" . $rowETAT . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux de Véhicules par état',
                                is3D: true,
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('voiturechart'));
                            chart.draw(data, options);
                        }

                        function drawChartContrat() {
                            var data = google.visualization.arrayToDataTable([
                                ['type', 'Number'],
                                <?php
                                    if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                        $query = "SELECT type_location, count(*) as number FROM contrat_client GROUP BY type_location";
                                    }else{
                                        $query = "SELECT type_location, count(*) as number FROM contrat_client WHERE id_agence = $id_agence GROUP BY type_location";
                                    }
                                    $result = mysqli_query($conn, $query);
                                    ?>
                                <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "['" . $row["type_location"] . "', " . $row["number"] . "],";
                                    }
                                    ?>
                            ]);
                            var options = {
                                title: 'Taux de Contrats par type',
                                is3D: true,   
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('contratchart'));
                            chart.draw(data, options);
                        }
                        
                        </script>
                        
                        <div class="row  no-gutters align-items-center mb-4">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-3">Véhicule disponibles ( Nombre Total : 
                                    <?php   
                                        function number_vehicule_dispo(){
                                            global $conn;
                                            $id_agence = $_SESSION['id_agence'];
                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                $number_vehicule_loue = "SELECT COUNT(*) AS Numbervehiculeloue FROM contrat_client 
                                                where type_location = 'Vehicule' 
                                                AND etat_contrat = 'A' 
                                                AND ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW())))";
                                                $resultnumber_vehicule_loue = mysqli_query($conn, $number_vehicule_loue);

                                                $number_vehicule_loue_avenant = "SELECT COUNT(*) AS Numbervehiculeloueavenant 
                                                FROM contrat_client_avenant as CA,contrat_client as c 
                                                where c.id_contrat = CA.id_contrat_client
                                                AND c.type_location = 'Vehicule' 
                                                AND ((CA.debut_contrat_avenant <= DATE(NOW()) and CA.fin_contrat_avenant >=DATE(NOW())))";
                                                $resultnumber_vehicule_loue_avenant = mysqli_query($conn, $number_vehicule_loue_avenant);
                                            }else{
                                                $number_vehicule_loue = "SELECT COUNT(*) AS Numbervehiculeloue FROM contrat_client 
                                                where type_location = 'Vehicule' 
                                                AND etat_contrat = 'A' 
                                                AND (id_agence = $id_agence OR id_agenceret = $id_agence)
                                                AND ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW())))";
                                                $resultnumber_vehicule_loue = mysqli_query($conn, $number_vehicule_loue);

                                                $number_vehicule_loue_avenant = "SELECT COUNT(*) AS Numbervehiculeloueavenant 
                                                FROM contrat_client_avenant as CA,contrat_client as c 
                                                where c.id_contrat = CA.id_contrat_client
                                                AND c.type_location = 'Vehicule' 
                                                AND (c.id_agence = $id_agence OR c.id_agenceret = $id_agence)
                                                AND ((CA.debut_contrat_avenant <= DATE(NOW()) and CA.fin_contrat_avenant >=DATE(NOW())))";
                                                $resultnumber_vehicule_loue_avenant = mysqli_query($conn, $number_vehicule_loue_avenant);
                                            }
                                            $number_vehicule_loue_normal = mysqli_fetch_assoc($resultnumber_vehicule_loue);
                                            $number_vehicule_loue_avenant = mysqli_fetch_assoc($resultnumber_vehicule_loue_avenant);

                                            if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                $number_vehicule_total = "SELECT COUNT(*) AS Numbervehiculetotal FROM voiture 
                                                where actions !='S' 
                                                AND etat_voiture = 'Disponible'";
                                                $resultnumber_vehicule_total = mysqli_query($conn, $number_vehicule_total);
                                            }else{
                                                $number_vehicule_total = "SELECT COUNT(*) AS Numbervehiculetotal FROM voiture 
                                                where actions !='S' 
                                                AND id_agence = $id_agence
                                                AND etat_voiture = 'Disponible'";
                                                $resultnumber_vehicule_total = mysqli_query($conn, $number_vehicule_total);
                                            }
                                            $number_vehicule_total = mysqli_fetch_assoc($resultnumber_vehicule_total);

                                            return $number_vehicule_total['Numbervehiculetotal'] - ($number_vehicule_loue['Numbervehiculeloue'] + $number_vehicule_loue_avenant['Numbervehiculeloueavenant']);   
                                        }
                                        $number_vehicule_dispo = number_vehicule_dispo();
                                        echo $number_vehicule_dispo?> )
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                <div class="row">
                                    <div class="col-12 table-responsive" style="height:300px;">
                                        <?php
                                        $value = '<table class="table table-striped table-bordered table-hover">
                                                    <tr class="thead-dark" style="height:10px;">
                                                        <th class="border-top-0">ID Voiture</th>
                                                        <th class="border-top-0">Marque Voiture</th>
                                                        <th class="border-top-0">Modèle Voiture</th>
                                                        <th class="border-top-0">Immatriculation Voiture</th>
                                                    </tr>';
                                        function disponibilite_Vehicule($id_voiture){
                                            global $conn;
                                            $query = "SELECT * FROM contrat_client 
                                               where id_voiture ='$id_voiture' 
                                               and etat_contrat = 'A' 
                                               and ((date_debut <= DATE(NOW()) and date_fin >=DATE(NOW())))";
                                            $result = mysqli_query($conn, $query);
                                            $nb_res = mysqli_num_rows($result);

                                            $query_avenant = "SELECT * FROM contrat_client_avenant 
                                               where id_voiture_avenant ='$id_voiture' 
                                               and ((debut_contrat_avenant <= DATE(NOW()) and fin_contrat_avenant >=DATE(NOW())))";
                                            $result_avenant = mysqli_query($conn, $query_avenant);
                                            $nb_res_avenant = mysqli_num_rows($result_avenant);

                                            if ($nb_res == 0 && $nb_res_avenant == 0) {
                                                return "disponibile";
                                            } else {
                                                return "non disponibile";
                                            }
                                        }

                                        if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                            $query = "SELECT V.id_voiture,V.pimm,MM.Marque,MM.Model
                                            FROM voiture as V 
                                            left JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel
                                            WHERE etat_voiture='Disponible'
                                            AND actions != 'S'
                                            ORDER BY id_voiture";
                                            $result = mysqli_query($conn, $query);
                                        } else {
                                            $query = "SELECT V.id_voiture,V.pimm,MM.Marque,MM.Model
                                            FROM voiture as V 
                                            left JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel
                                            WHERE etat_voiture='Disponible'
                                            AND actions != 'S'
                                            AND V.id_agence = $id_agence
                                            ORDER BY id_voiture";
                                            $result = mysqli_query($conn, $query);
                                        }
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $disponibilte = disponibilite_Vehicule($row['id_voiture']);
                                            if ($disponibilte == 'disponibile') {
                                                $value .= '               
                                                <tr>
                                                    <td class="border-top-0 font-weight-bold">' . $row['id_voiture'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['Marque'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['Model'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['pimm'] . '</td>
                                                </tr>';
                                            } 
                                        }
                                        $value .= '</table>';
                                        echo $value;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters align-items-center mb-3">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-3">Contrats qui
                                    prendront fin</div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">

                                </div> -->
                                <div class="row">
                                    <div class="col-9 table-responsive" style="height:300px;">
                                        <?php
                                        $value = '<table class="table table-striped table-bordered table-hover">
                                            <tr class="thead-dark">
                                                <th class="border-top-0">ID Contrat</th>
                                                <th class="border-top-0">Type Contrat</th>
                                                <th class="border-top-0">Date Fin</th>
                                                <th class="border-top-0">Nom Client</th>
                                                <th class="border-top-0">Email Client</th>
                                                <th class="border-top-0">Téléphone Client</th>
                                                <th class="border-top-0">Adresse Client</th>
                                            </tr>';
                                        if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                            $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.nom_entreprise,CL.email,CL.tel,CL.adresse FROM `contrat_client` as C left JOIN client as CL on C.id_client=CL.id_client
                                                        WHERE (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
                                                        AND etat_contrat != 'S'";
                                        } else {
                                            $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.nom_entreprise,CL.email,CL.tel,CL.adresse FROM `contrat_client` as C left JOIN client as CL on C.id_client=CL.id_client
                                                        WHERE (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
                                                        AND etat_contrat != 'S'
                                                        AND C.id_agence = $id_agence";
                                        }
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $value .= '<tr>
                                                <td class="border-top-0 font-weight-bold">' . $row['id_contrat'] . '</td>
                                                <td class="border-top-0 font-weight-bold">' . $row['type_location'] . '</td>
                                                <td class="border-top-0 font-weight-bold">' . $row['date_fin'] . '</td>';
                                                if ($row['nom_entreprise'] == ""){
                                                    $value .= '<td class="border-top-0 font-weight-bold">' . $row['nom'] . '</td>';
                                                }else if ($row['nom'] == ""){
                                                    $value .= '<td class="border-top-0 font-weight-bold">' . $row['nom_entreprise'] . '</td>';
                                                }else{
                                                    $value .= '<td class="border-top-0 font-weight-bold">' . $row['nom_entreprise'] . " / Conducteur : " . $row['nom'] . '</td>';
                                                }
                                                $value .= '<td class="border-top-0 font-weight-bold">' . $row['email'] . '</td>
                                                <td class="border-top-0 font-weight-bold">' . $row['tel'] . '</td>
                                                <td class="border-top-0 font-weight-bold">' . $row['adresse'] . '</td>
                                            </tr>';
                                        }
                                        $value .= '</table>';
                                        echo $value;
                                        ?>
                                    </div>
                                    <div class="col-3">
                                        <div class="box-part text-center align-middle " style="margin-top: 5px;">
                                            <i class="fas fa-star text-secondary" style="font-size: 40px;"></i>
                                            <i class="fas fa-star" style="font-size: 70px;"></i>
                                            <i class="fas fa-star text-secondary" style="font-size: 40px;"></i>
                                            <div class="title">
                                                <h3 class="text-uppercase">Meilleur client</h3>
                                            </div>
                                            <div class="text border border-dark">
                                                <?php
                                                if($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable"){
                                                    $query = "SELECT COUNT(id_contrat) As compt,C.id_client,CL.nom,CL.email,CL.adresse
                                                    from contrat_client AS C
                                                    LEFT JOIN client AS CL ON C.id_client=CL.id_client
                                                    WHERE C.etat_contrat != 'S'
                                                    GROUP BY id_client
                                                    ORDER BY compt DESC
                                                    LIMIT 1";     
                                                }else{
                                                    $query = "SELECT COUNT(id_contrat) As compt,C.id_client,CL.nom,CL.email,CL.adresse
                                                    from contrat_client AS C
                                                    LEFT JOIN client AS CL ON C.id_client=CL.id_client
                                                    WHERE C.etat_contrat != 'S'
                                                    AND C.id_agence = $id_agence
                                                    GROUP BY id_client
                                                    ORDER BY compt DESC
                                                    LIMIT 1";
                                                }
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<h1 class="font-weight-bold text-uppercase mb-1">' . '<span>' . $row['nom'] . '</span></h1>';
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Email:</span>' . ' ' . '<span class="font-weight-bold">' . $row['email'] . '</span></h3>';
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Adresse:</span>' . ' ' . '<span class="font-weight-bold">' . $row['adresse'] . '</span></h3>';
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Nombre de locations:</span>' . ' ' . '<span class="font-weight-bold">' . $row['compt'] . '</span></h3>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <?php
    include('Gestion_location/inc/footer.php')
    ?>
    </body>

    </html>