<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
}
?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">LISTE DES NOTIFICATIONS DE CONTRÔLE PÉRIODIQUE VÉHICULES</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="contrat-list-pack"> </div>     
                                    <?php
                                        include("Gestion_location/inc/connect_db.php");
                                        global $conn;
                                        $id_agence = $_SESSION['id_agence'];
                                        $output = '';
                                        if ($_SESSION['Role'] == "superadmin" || $_SESSION['Role'] == "responsable") {
                                            $query = "SELECT *
                                                    FROM controletechnique AS CT 
                                                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                                                    WHERE CT.controle_status = 0
                                                    AND CT.date_controletechnique != '0000-00-00'
                                                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14";
                                        }else{
                                            $query = "SELECT *
                                                    FROM controletechnique AS CT 
                                                    LEFT JOIN voiture AS V ON CT.id_voiture=V.id_voiture
                                                    WHERE CT.controle_status = 0
                                                    AND V.id_agence = $id_agence
                                                    AND CT.date_controletechnique != '0000-00-00'
                                                    AND DATEDIFF(CT.date_controletechnique, NOW()) BETWEEN 0 AND 14";
                                        }
                                        $result = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $str1 = "Le Contrôle Périodique de la voiture ";
                                                $str2 = " à vérifier  ";
                                                $output .= '<div class="border-bottom border-dark p-3">
                                                    <div class="text-secondary">' . $str1 . $row["pimm"] . $str2 . '' . date('d-m-Y', strtotime($row['date_controletechnique'])) .'</div>
                                                </div>';
                                            }
                                        }
                                        echo($output);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('Gestion_location/inc/footer.php')
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>
    </body>
    </html>