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
                    <div class="card-heading">LISTE DES NOTIFICATIONS </div>
                    <div class="card-body">
                    
                        <!-- search box -->
                    
       
                        <!-- end search box -->
                        <p id="delete_message"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="contrat-list-pack"> </div>
                                    <?php
                                        include("Gestion_location/inc/connect_db.php");
                                        global $conn;
                                        $output = '';
                                        $query = "SELECT * FROM `notification` where  id_user = ".$_SESSION['id_user']." ORDER BY date_creation DESC ";
                                        $result = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $query_nomuser = "SELECT nom_user FROM user AS U,contrat_client AS C
                                                    where U.id_user = C.id_user
                                                    AND C.id_contrat =".$row["id_contrat"];
                                                $result_nomuser = mysqli_query($conn, $query_nomuser);
                                                $row_nomuser = mysqli_fetch_row($result_nomuser);
                                                $nomuser = $row_nomuser[0];
                                                if ($row["status"] == 0) {
                                                    $output .= '
                                                        <div class="border-bottom border-dark p-3" style="background-color: #DFE9F2;">
                                                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].'" href="Liste_notif_debut_contrat.php?clicked_id=' . $row["id_contrat"] . '">Le contrat n°'. $row["id_contrat"] .' a été crée par "'. $nomuser .'" le ' . $row["date_creation"] . '</a></div>
                                                        </div>';
                                                }else{
                                                    $output .= '
                                                        <div class="border-bottom border-dark p-3">
                                                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].'" href="Liste_notif_debut_contrat.php?clicked_id=' . $row["id_contrat"] . '">Le contrat n°'. $row["id_contrat"] .' a été crée par "'. $nomuser .'" le ' . $row["date_creation"] . '</a></div>
                                                        </div>';
                                                }  
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