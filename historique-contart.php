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
                    HISTORIQUES CONTRATS
                </h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">LISTE DES HISTORIQUES DE CONTRATS</div>
                    <div class="card-body">
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2" >
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchhistoriquecontrat"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="searchusermodifcontrat">
                            <div class="col-sm">
                                <?php
                                include('Gestion_location/inc/connect_db.php');
                                $id_agence = $_SESSION['id_agence'];
                                ?>
                                <?php
                                    if ($id_agence == "0") {
                                            $query = "SELECT DISTINCT id_user,nom_user
                                            From user,historique_contrat
                                            where historique_contrat.id_user_HC = user.id_user
                                            AND role != 'superadmin' ";
                                    }else{
                                        $query = "SELECT DISTINCT id_user,nom_user
                                            From user,historique_contrat
                                            where historique_contrat.id_user_HC = user.id_user
                                            AND id_agence = $id_agence ";
                                    }
                                ?>
                                <?php
                                $result = mysqli_query($conn, $query);
                                ?>
                                <div class="col-md-12 border-bottom p-0">
                                    <select id="user_modif_contrat_search" name="user_modif_contrat" onchange="user_modif_dispo()"
                                            class="form-control p-0 border-0" required>
                                        <option value="0">Choisissez l'administrateur</option>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['id_user'] . '">' . $row['nom_user'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm"></div>
                            <div class="col-sm"></div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <p id="up_message_pack"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="contrat-modification-list"> </div>
                                </div>
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
</body>
</html>