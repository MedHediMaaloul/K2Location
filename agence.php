<?php
session_start();
if ((($_SESSION['Role']) == "superadmin") || ($_SESSION['Role']) == "admin") {
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
                    Agence

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
                    <div class="card-heading">LISTE DES AGENCES</div>
                    <div class="card-body">
                        <p id="delete_message"></p>
                        <!-- #fagenceForm   ExportClient5 -->
                        <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Agence"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px"
                            title="Ajouter agence">+</button>

                        <button class="btn btn-primary  " type="button" data-toggle="modal"
                            data-target="#Registration-Agence-Heur"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px"
                            title="Ajouter ouvrant de agence">+</button>
                        <!-- <a href=""><button type="button" class="btn btn-primary"
                                style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 150px;width: 50px;height:50px"><i
                                    class="far fa-file-excel"></i></button></a> -->
                        <!-- search box -->

                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchAgence"
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
                                    <div class="table-responsive" id="agence-list"></div>
                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end file modal -->

                                    <!-- delete agence model -->
                                    <div class="modal fade" id="deleteAgence" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer agence</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer l'agence ?</p>
                                                    <button class="btn btn-success" id="btn_delete_agence">Supprimer
                                                        agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end  delete modal -->


                                    <!-- delete Client model -->
                                    <div class="modal fade" id="deleteAgenceHeur" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>Voulez-vous supprimer cet horaire ?</p>
                                                    <button class="btn btn-success"
                                                        id="btn-delete-agence-heur">Supprimer
                                                        l'horaire</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end  delete modal -->






                                    <!-- update agence model -->
                                    <div class="modal fade" id="updateAgence" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier agence</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-agenceForm" autocomplete="off"
                                                        class="form-horizontal form-material">

                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idagence">
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Lieu agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_agenceLien"
                                                                    placeholder="Agence adresse"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Date création d'agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_agenceDate"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Email agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_agenceEmail"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0"> Tél Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_agenceTele"
                                                                    placeholder=" 0213555"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_agence">Modifier
                                                        agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- Modal add client -->
                                    <div class="modal fade" id="Registration-Agence" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Agence
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="btn-close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="agenceForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Lieu Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="agenceLien"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="agenceDate"
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="agenceEmail"
                                                                    placeholder="pascal@gmail.com"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>

                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Tel Agence<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="agenceTele" placeholder="425183"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-2">


                                                            <label class="col-md-12 p-0"> Horaire </label>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_field">

                                                                    <tr>
                                                                        <td style="width:30%;">

                                                                            <select class="jour" name="jour" id="jour1">

                                                                                <option value="lundi">lundi</option>
                                                                                <option value="mardi">mardi</option>
                                                                                <option value="mercredi">mercredi
                                                                                </option>
                                                                                <option value="jeudi">jeudi</option>
                                                                                <option value="vendredi">
                                                                                    vendredi
                                                                                </option>
                                                                                <option value="samedi">samedi
                                                                                </option>
                                                                                <option value="dimanche">dimanche
                                                                                </option>
                                                                            </select>


                                                                        </td>




                                                                        <td style="width:30%;">
                                                                            <input type="time" name="skill[]"
                                                                                id="fetch-heurdebut1"
                                                                                placeholder="date debut"
                                                                                class="form-control heur-list-debut">


                                                                        </td>
                                                                        <td style="width:30%;"> <input type="time"
                                                                                id="fetch-heurfin1"
                                                                                placeholder="date fin"
                                                                                class="form-control p-0  heur-list-fin"
                                                                                required>
                                                                        </td>
                                                                        <td><button type="button" name="add" id="add"
                                                                                class="btn btn-success">+</button></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>



                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-agence">Ajouter
                                                        agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add modal -->

                                    <!-- Modal add HEUR -->
                                    <div class="modal fade" id="Registration-Agence-Heur" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter ouverture
                                                        Agence
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="btn-close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="agenceFormHeur" autocomplete="off"
                                                        class="form-horizontal form-material">




                                                        <div class="form-group mb-4">
                                                            <?php
                                                            include('Gestion_location/inc/connect_db.php');
                                                            $query = "SELECT * FROM agence where etat_agence!='S' AND id_agence != 0 ORDER BY id_agence ASC";
                                                            $result = mysqli_query($conn, $query);
                                                            ?>
                                                            <label class="col-md-12 p-0"> Agence*</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <select id="IdAgence" name="IdAgence"
                                                                    placeholder="agence"
                                                                    class="form-control p-0 border-0" required>

                                                                    <?php
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo '<option value="' . $row['id_agence'] . '">' . $row['id_agence'] . ' - ' . $row['lieu_agence'] . '</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>



                                                        <div class="form-group mb-2">


                                                            <label class="col-md-12 p-0"> Horaire </label>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_fieldH">

                                                                    <tr>
                                                                        <td style="width:30%;">

                                                                            <select class="jourH" name="jourH"
                                                                                id="jourH">

                                                                                <option value="lundi">lundi</option>
                                                                                <option value="mardi">mardi</option>
                                                                                <option value="mercredi">mercredi
                                                                                </option>
                                                                                <option value="jeudi">jeudi</option>
                                                                                <option value="vendredi">
                                                                                    vendredi
                                                                                </option>
                                                                                <option value="samedi">samedi
                                                                                </option>
                                                                                <option value="dimanche">dimanche
                                                                                </option>
                                                                            </select>


                                                                        </td>


                                                                        </td>

                                                                        <td style="width:30%;">
                                                                            <input type="time" name="skillH[]"
                                                                                id="fetch-heurdebutH"
                                                                                placeholder="date debut"
                                                                                class="form-control heur-list-debutH">


                                                                        </td>
                                                                        <td style="width:30%;"> <input type="time"
                                                                                id="fetch-heurfinH"
                                                                                placeholder="date fin"
                                                                                class="form-control p-0  heur-list-finH"
                                                                                required>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>



                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"
                                                        id="btn-register-agence-heur">Ajouter
                                                        agence</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end add Heur  modal -->


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


<script>
$(document).ready(function() {



    var i = 1;
    $('#add').click(function() {
        // alert('cvbcvb');
        i++;
        $('#dynamic_field').append('<tr id="row' + i +
            '"> <td> <select class="jour"  name="jour" id="jour' +
            i +
            '" ><option value="lundi">lundi</option><option value="mardi">mardi</option> <option value="mercredi">mercredi </option> <option value="jeudi">jeudi</option><option value="vendredi">vendredi</option><option value="samedi">samedi</option><option value="dimanche">dimanche  </option>   </select></td>    <td> <input "name="skill[]"  type="time" id="fetch-heurdebut' +
            i +
            '" placeholder="designation" class="form-control p-0 heur-list-debut"  required> </td>     <td> <input type="time" id="fetch-heurfin' +
            i +
            '" placeholder="" class="form-control p-0 heur-list-fin"  required> </td>              <td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

});
</script>


</body>

</html>