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
                    <div class="card-heading">LISTE DES NOTIFICATIONS CONTRAT</div>
                    <div class="card-body">
                    
                        <!-- search box -->
                    
       
                        <!-- end search box -->
                        <p id="delete_message"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <!-- PDF model  -->




                                    <!-- END PDF model -->


                                    <!-- end modal delet contrat -->
                                    <div class="table-responsive" id="contrat-list-pack"> </div>
                                    <!-- update Contrat modal -->
                                    
<?php
include("Gestion_location/inc/connect_db.php");
global $conn;
$output = '';
$query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse,CL.nom_entreprise,C.view,CL.nom_entreprise 
        FROM contrat_client as C 
        left JOIN client as CL 
        on C.id_client=CL.id_client
        WHERE C.etat_contrat != 'S'
        AND (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))
        ";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $str1 = "Le contrat de ";
        $str2 = " du client ";
        $str3 = " se terminera bientôt";
        if ($row["view"] == 1) {
            if ($row['nom_entreprise'] == ""){
                $output .= '
                    <div class="border-bottom border-dark p-3" style="background-color: #DFE9F2;">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                         $row["nom"] . '' . $str3 .  '</a></div>
                    </div>';
            }else if ($row['nom'] == ""){
                $output .= '
                    <div class="border-bottom border-dark p-3" style="background-color: #DFE9F2;">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                         $row["nom_entreprise"] . '' . $str3 .  '</a></div>
                    </div>';
            }else{
                $output .= '
                    <div class="border-bottom border-dark p-3" style="background-color: #DFE9F2;">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' .
                        $row["nom"] . '(' .$row["nom_entreprise"]. ')' . '' . $str3 .  '</a></div>
                    </div>';
            }   
        }else{
            if ($row['nom_entreprise'] == ""){
                $output .= '
                    <div class="border-bottom border-dark p-3">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' . 
                        $row["nom"] . '' . $str3 .  '</a></div>
                    </div>';
            }else if ($row['nom'] == ""){
                $output .= '
                    <div class="border-bottom border-dark p-3">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' . 
                        $row["nom_entreprise"] . '' . $str3 .  '</a></div>
                    </div>';
            }else{
                $output .= '
                    <div class="border-bottom border-dark p-3">
                        <div class="text-secondary" ><a onClick="reply_click(this.id)" id="'.$row["id_contrat"].'" target="_blank" att="'.$row["id_contrat"].
                        '" href="Liste_notifications_update.php?clicked_id=' . $row["id_contrat"] . '">' . $str1 . '' . $row["type_location"] . '' . $str2 . '' . 
                        $row["nom"] . '(' .$row["nom_entreprise"]. ')' . '' . $str3 .  '</a></div>
                    </div>';
            }

            
        }
        
    }
}
echo($output);





 







?>


                                    <!--end update Contrat modal -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>
    
    </body>

    </html>