<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
  // si elle est bien connecté alors c'est bon
  include('Gestion_location/inc/header_sidebar.php');
} else {
  //echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
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
          CONTRATS
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
          <div class="card-heading">LISTE DES CONTRATS</div>
          <div class="card-body">
            <button class="btn btn-success " type="button" data-toggle="modal" data-target="#Registration-Contrat" style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>
            <p id="delete_message"></p>
            <div class="row">
              <div class="col-sm-12">
                <div class="white-box">
                                    <!-- modal delet contrat -->
                                    <div class="modal fade" id="deleteContrat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Supprimer Contrat</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>voulez-vous supprimer le contrat ?</p>
                          <button class="btn btn-success" id="btn_delete">Supprimer Contrat</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end modal delet contrat -->
                  <div class="table-responsive" id="contrat-list"> </div>
                  <!-- update Contrat modal -->
                  <div class="modal fade" id="update-Contrat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modifier Contrat</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p id="up_message"></p>
                          <form id="updateContratForm" autocomplete="off" class="form-horizontal form-material">
                            <div class="form-group mb-4">
                              <input type="hidden" id="up_idcontrat">
                            </div>
                            <!-- <div class="form-group mb-4">
                              <label for="example-email" class="col-md-12 p-0"style="color:black;font-size:15px">Contrat De :</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input id="up_Contratde" class="form-control p-0 border-0" style="color:black;font-size:20px" name="Entretiendate" disabled>
                              </div>
                            </div> -->
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Type Contrat*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="up_ContratType" placeholder="type de contrat" class="form-control p-0 border-0" required disabled>
                              </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Contrat*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="up_DateContrat" class="form-control p-0 border-0" required> </div>
                            </div>
                            <!-- <div class="form-group mb-4">
                              //  <?php
                                  //  include('Gestion_location/inc/connect_db.php');
                                  //  $query = "SELECT * FROM client ORDER BY nom ASC";
                                  //  $result = mysqli_query($conn, $query);
                                  //  
                                  ?>
                              <label class="col-md-12 p-0"> Nom Complet Client*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="ClientContrat" name="ClientContrat" placeholder="Nom Client" class="form-control p-0 border-0" required>
                                <option value="" disabled selected>Selectionner Un Client</option>
                                  //  <?php
                                      //  if ($result->num_rows > 0) {
                                      //    while ($row = $result->fetch_assoc()) {
                                      //      echo '<option value="' . $row['id_client'] . '">' . $row['nom'] . '</option>';
                                      //    }
                                      //  }
                                      //  
                                      ?>
                                </select> </div>
                            </div> -->
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Début*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="up_DateDebutContrat" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Fin*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="up_DateFinContrat" class="form-control p-0 border-0" required> </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Prix*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="number" id="up_PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Assurance*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="up_AssuranceContrat" placeholder="Assurance" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Mode Paiement*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="up_ModePaiementContrat" placeholder="Mode Paiement" class="form-control p-0 border-0" required> </div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success" id="btn_updated_Contrat">Modifier Contrat</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal add contrat -->
                  <div class="modal fade" id="Registration-Contrat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter contrat</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p id="message"></p>
                          <form id="contratForm" autocomplete="off" class="form-horizontal form-material">
                            <div class="form-group mb-4">
                              <input type="hidden" id="Up_Contratid">
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Contrat*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="DateContrat" placeholder="01/01/2020" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Type Contrat*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select name="type" id="TypeContrat" class="form-control p-0 border-0" required>
                                  <option value="" selected disabled>Selectionnez Type Contrat</option>
                                  <option value="Véhicule">Véhicule</option>
                                  <option value="Matériel">Matériel</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Numéro Contrat*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="NumContrat" placeholder="Numéro contart" class="form-control p-0 border-0" required> </div>
                            </div>
                            <div class="form-group mb-4">
                              <?php
                              include('Gestion_location/inc/connect_db.php');
                              $query = "SELECT * FROM client ORDER BY nom ASC";
                              $result = mysqli_query($conn, $query);
                              ?>
                              <label class="col-md-12 p-0"> Nom Complet Client*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="ClientContrat" name="ClientContrat" placeholder="Nom Client" class="form-control p-0 border-0" required>
                                  <option value="" disabled selected>Selectionner Un Client</option>
                                  <?php
                                  if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                      echo '<option value="' . $row['id_client'] . '">' . $row['nom'] . '</option>';
                                    }
                                  }
                                  ?>
                                </select> </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Début*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="DateDebutContrat" placeholder="01/01/2020" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Fin*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="DateFinContrat" placeholder="01/01/2020" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Prix*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="number" id="PrixContrat" placeholder="1000€" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Assurance*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="AssuranceContrat" placeholder="Assurance" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Mode Paiement*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="ModePaiementContrat" placeholder="Mode Paiement" class="form-control p-0 border-0" required> </div>
                            </div>

                            <div id="voiture" style="display: none">
                              <div class="form-group mb-4">
                                <?php
                                include('Gestion_location/inc/connect_db.php');
                                $query = "SELECT * FROM voiture ORDER BY modele ASC";
                                $result = mysqli_query($conn, $query);
                                ?>
                                <label class="col-md-12 p-0">Modele Voiture*</label>
                                <div class="col-md-12 border-bottom p-0">
                                  <select name="type" id="VoitureModele" placeholder="Modele de voiture" onchange="FetchPIMMContrat(this.value)" class="form-control p-0 border-0" required>
                                    <option value="" disabled selected>Selectionner Model Voiture</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                      while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id_voiture'] . '">' . $row['marque'] . ' ' . $row['modele'] . '</option>';
                                      }
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group mb-4">
                                <label class="col-md-12 p-0">PIMM Voiture*</label>
                                <div class="col-md-12 border-bottom p-0">
                                  <select id="VoiturePimm" placeholder="PIMM de voiture" class="form-control p-0 border-0" required>
                                    <option value="" disabled selected>Selectionner PIMM Voiture d'abord</option>
                                  </select> </div>
                              </div>
                            </div>
                            <div id="materiel" style="display: none">
                              <div class="form-group mb-2">
                                <?php
                                include('Gestion_location/inc/connect_db.php');
                                $query = "SELECT * FROM materiel ORDER BY nom_materiel ASC";
                                $result = mysqli_query($conn, $query);
                                ?>
                                <script>
                                  var materielData = '<?php
                                                      if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                          echo '<option value="' . $row['id_materiel'] . '">' . $row['nom_materiel'] . ' _' . $row['num_serie'] . '</option>';
                                                        }
                                                      }
                                                      ?>';
                                </script>
                                <label class="col-md-12 p-0">Nom Materiel & Num Serie*</label>

                                <div class="table-responsive">
                                  <table class="table table-bordered" id="dynamic_field">

                                    <tr>
                                      <td>
                                        <select name="skill[]" id="fetch-materiel1" placeholder="Enter your Skill" class="form-control materiel-list-contrat">
                                          <option selected disabled>Nom Materiel/Num Serie</option>
                                          <script>
                                            document.write(materielData)
                                          </script>
                                        </select>
                                      </td>
                                      <td><button type="button" name="add" id="add" class="btn btn-success">+</button></td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                              <!-- end test dynamic element -->
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success" id="btn-register-contrat">Ajouter Contrat</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
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
  <script>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id_materiel'] . '">' . $row['nom_materiel'] . ' _' . $row['num_serie'] . '</option>';
      }
    }
    ?>
    $(document).ready(function() {
      var i = 1;
      $('#add').click(function() {
        i++;
        $('#dynamic_field').append('<tr id="row' + i + '"><td><select name="skill[]"  id="fetch-materiel' + i + '" placeholder="Enter your Skill" class="form-control materiel-list-contrat" >' + materielData + '</select></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
      });

      $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
      });
    });
  </script>
  </body>

  </html>
  