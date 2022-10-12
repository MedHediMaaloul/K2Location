<?php
session_start();
if (($_SESSION['Role']) == "superadmin" || ($_SESSION['Role']) == "admin" || ($_SESSION['Role']) == "responsable") {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    include('Gestion_location/inc/header_sidebar.php');
} else {
    header("Location:login.php");
    // si elle est bien connecté alors c'est bon
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
                    STOCK VÉHICULE

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
                    <div class="card-heading">LISTE DES STOCKS VÉHICULES</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <?php
                        if (($_SESSION['Role']) != "superadmin") {
                        ?>
                            <button class="btn btn-success" alt="ajouter" type="button" data-toggle="modal"
                                data-target="#Registration-Voiture"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
                        <?php
                        }
                        ?>
                        <?php
                        if (($_SESSION['Role']) == "responsable") {
                        ?>
                            <a href="ExportStockVoiture.php" role="button"
                            style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            <i class="fa fa-download"
                                style="background-color: DodgerBlue;border: none;color: white;padding: 10px 5px;cursor: pointer;font-size: 20px;">
                            </i>Export</a>
                        <?php
                        }
                        ?>
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchStock"
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
                                    <div class="table-responsive" id="stock-list"></div>

                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end file modal -->
                                    <!-- delete stock model -->

                                    <!-- update Transfert  model -->

                                    <div class="modal fade" id="updatevoiturestock" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier voiture</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-voitureForm" autocomplete="off"
                                                        class="form-horizontal form-material">


                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idvoiture">
                                                        </div>



                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $id_agence = $_SESSION['id_agence'];
                                                        $query = "SELECT * FROM agence  where etat_agence !='S' AND id_agence != $id_agence AND id_agence != '0' ";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select name="type" id="up_voitureAgence"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        Agence </option>
                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['lieu_agence'] .   '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn_update_voiture_stock">Modifier
                                                        Agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->
                                     <!-- Modal add voiture -->
                                     <div class="modal fade" id="Registration-Voiture" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter véhicule
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="addvoitureForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type" id="Voituretype"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        type de véhicule </option>
                                                                    <option value="FOURGON UTILITAIRE">FOURGON
                                                                        UTILITAIRE</option>
                                                                    <option value="VOITURE DE SOCIÉTÉ">VOITURE DE
                                                                        SOCIÉTÉ</option>
                                                                    <option value="CAMION NACELLE">CAMION NACELLE
                                                                    </option>
                                                                    <option value="FOURGON NACELLE">FOURGON NACELLE
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">PIMM<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="Voiturepimm" placeholder="PIMM"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <!-- select marque model -->
                                                        <?php
                                                        include_once('Gestion_location/inc/connect_db.php');
                                                        $query = "SELECT * FROM marquemodel  WHERE  etat_marque!='S'  ORDER BY Marque ASC";
                                                        $result = mysqli_query($conn, $query);
                                                        ?>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Marque/Modèle<span
                                                                    class="text-danger">* </span></label>
                                                            <label class="col-md-12 p-0">
                                                                <div class="col-md-12 border-bottom p-0">
                                                                    <span class="text-danger"></span>
                                                                    <select name="type" id="voitureMarqueModel"
                                                                        class="form-control p-0 border-0" required>
                                                                        <option value="" disabled selected>Selectionner
                                                                            Marque & Modèle </option>
                                                                        <?php
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo '<option value="' . $row['id_MarqueModel'] . '">' . $row['Marque'] .  '  ' . $row['Model'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Boite de vitesse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type" id="Voitureboitevitesse"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        la boite de vitesse</option>
                                                                    <option value="Manuelle">Manuelle</option>
                                                                    <option value="Automatique">Automatique</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Type de carburant<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select type="text" name="type"
                                                                    id="Voituretypecarburant"
                                                                    class="form-control p-0 border-0" required>
                                                                    <option value="" disabled selected>Selectionner
                                                                        le type de carburant</option>
                                                                    <option value="Essence">Essence</option>
                                                                    <option value="Diesel">Diesel</option>
                                                                    <option value="Electrique">Electrique</option>
                                                                    <option value="Hybride">Hybride</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Fournisseur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="Voiturefournisseur"
                                                                    placeholder="Fournisseur"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Km<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="number" id="Voiturekm" placeholder="Km"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Achat</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="Voituredate_achat"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date 1er
                                                                immatriculation</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_immatriculation"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VGP</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPC_VGP"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPC VT</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPC_VT"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> DPT Pollution</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="date_DPT_Pollution"
                                                                    placeholder="01/01/2020"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Carte grise</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="carte_grise"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Carte verte</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="carte_verte"
                                                                    class="form-control p-0 border-0" required>
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
                                                                            <select id="vehiculeagence" name="vehiculeagence"
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
                                                    <button class="btn btn-success" id="btn-register-voiture">Ajouter
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
        </div>
        <!-- /.col -->
    </div>
</div>

<?php
include('Gestion_location/inc/footer.php')
?>
</body>

</html>