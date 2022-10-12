<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (!isset($_SESSION['User'])) {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
} else {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
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
                    VÉHICULES
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
                    <div class="card-heading">LISTE DES VOITURES HORS SERVICE</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Voiture-HS"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Hist-Voiture"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px"><i
                                class="fas fa-history"></i></button>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchVoitureHS"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" id="voiture-list-HS"></div>

                                    <!-- setting Voiture -->
                                    <div class="modal fade" id="Registration-Hist-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Historique
                                                        véhicule Hors service</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="tableSettingHS"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close-voiture_setting">Fermer</button>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- end setting Voiture -->
                                    <!-- update Voiture model -->
                                    <div class="modal fade" id="updateVoitureHS" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_HS"></p>
                                                    <form id="up-voitureHSForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_VoitureHSid">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="Up_VHSid">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Hors service</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="Up_Voituredate_HS"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <textarea class="form-control p-0 border-0"
                                                                    id="Up_VoitureCommentaire" rows="3"></textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Disponible<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="up_VoitureHS" id="up_VoitureHS"
                                                                    class="form-control p-0 border-0" required>

                                                                    <option value="HS">Hors Service </option>
                                                                    <option value="Disponible"> Disponible</option>
                                                                </select>
                                                            </div>
                                                        </div>



                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_voiture_HS">Modifier
                                                        véhicule</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- delete voiture model -->
                                    <div class="modal fade" id="deleteVoiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer le véhicule ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        véhicule</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  hist modal -->

                                    <!-- Modal add voiture -->
                                    <div class="modal fade" id="Registration-Voiture-HS" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter véhicule
                                                        Hors Service</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message-HS"></p>
                                                    <form id="addvoitureHSForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <!-- select marque model -->
                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $id_agence = $_SESSION['id_agence'];
                                                        ?>
                                                        <?php
                                                        if ($_SESSION['Role'] == "responsable") {
                                                        $query = "SELECT * 
                                                        FROM voiture as V LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
                                                        WHERE V.etat_voiture = 'Disponible' AND actions='T' ";
                                                        }else{
                                                        $query = "SELECT * 
                                                        FROM voiture as V LEFT JOIN marquemodel AS MM on V.id_MarqueModel=MM.id_MarqueModel 
                                                        WHERE V.etat_voiture = 'Disponible' AND actions='T'  AND V.id_agence='$id_agence'";
                                                        }
                                                        ?>
                                                        <?php
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Véhicule/PIMM<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="voitureIDHS"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        véhicule </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_voiture'] . '">' . $row['Marque'] .  ' - ' . $row['pimm'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <!-- select marque model -->
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Hors service</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="datetime-local" id="Voituredate_HS"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire
                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <textarea class="form-control p-0 border-0"
                                                                    id="VoitureCommentaire" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($_SESSION['Role'] == "responsable") {
                                                        ?>
                                                            <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM agence where id_agence!='0' ";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0">Agence*</label>
                                                            <table>
                                                                <tr>
                                                                    <td>
                                                                        <div class="col-md-10 border-bottom p-0">
                                                                            <select id="vehiculehsagence" name="vehiculehsagence"
                                                                                placeholder="agence"
                                                                                class="form-control p-0 border-0"
                                                                                required>
                                                                                <option value="" disabled selected>Selectionner Agence</option>
                                                                                <?php
                                                                                if ($result->num_rows > 0) {
                                                                                    while ($row = $result->fetch_assoc()) {
                                                                                        echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] .'</option>';
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-voiture-HS">Ajouter
                                                        véhicule</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->
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