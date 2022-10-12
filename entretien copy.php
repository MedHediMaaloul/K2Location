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
          ENTRETIENS
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
          <div class="card-heading">LISTE DES ENTRETIENS</div>
          <div class="card-body">
            <p id="delete_message"></p>
            <button class="btn btn-success " type="button" data-toggle="modal" data-target="#Registration-Entretien" style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button>

            <div class="row">
              <div class="col-sm-12">
                <div class="white-box">
                  <div class="table-responsive" id="Entretien-list"></div>
                  <!-- delete Entretien model -->
                  <div class="modal fade" id="deleteEntretien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Supprimer Entretien</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <p>voulez-vous supprimer le client ?</p>
                          <button class="btn btn-success" id="btn_delete_Entretien">Supprimer Entretien</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end  delete modal -->
                  <!-- update Entretien model -->
                  <div class="modal fade" id="updateEntretien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modifier Entretien</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p id="up_message"></p>
                          <form id="updateEntretienForm" autocomplete="off" class="form-horizontal form-material">
                          <div class="form-group mb-4">
                              <input type="hidden" id="up_identretien">
                            </div>
                            <div class="form-group mb-4">
                              <label for="example-email" class="col-md-12 p-0"style="color:black;font-size:15px">Entretien De :</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input id="up_Entretiende" class="form-control p-0 border-0" style="color:black;font-size:20px" name="Entretiendate" disabled>
                              </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Type Entretien*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="text" id="up_EntretienType" placeholder="nom de Entretien" class="form-control p-0 border-0" required disabled> 
                                <!-- <select class="form-control form-control p-0 border-0" id="up_EntretienType">
                                <option value="" disabled selected>Selectionner Type Entretien</option>
                                  <option>véhicule</option>
                                  <option>Materiel</option>
                                </select> -->
                            </div>
                            </div>
                            <div class="form-group mb-4">
                              <label for="example-email" class="col-md-12 p-0">Date Entretien*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="up_Entretiendate" class="form-control p-0 border-0" name="Entretiendate">
                              </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Commentaire*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <!-- <input type="text" id="Entretienfournisseur" placeholder="fournisseur de Entretien" class="form-control p-0 border-0"> -->
                                <textarea class="form-control p-0 border-0" id="up_EntretienCommentaire" rows="3"></textarea>
                              </div>
                            </div>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success" id="btn_updated_Entretien">Modifier Entretien</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-close">Fermer</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end update modal -->
                  <!-- Modal add Entretien -->
                  <div class="modal fade" id="Registration-Entretien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter Entretien</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p id="message"></p>
                          <form id="EntretienForm" autocomplete="off" class="form-horizontal form-material">
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Type Entretien*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <!-- <input type="text" id="Entretienname" placeholder="nom de Entretien" class="form-control p-0 border-0" required> </div> -->
                                <select class="form-control form-control p-0 border-0" id="EntretienType">
                                <option value="" disabled selected>Selectionner Type Entretien</option>
                                  <option>véhicule</option>
                                  <option>Materiel</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group mb-4">
                              <label for="example-email" class="col-md-12 p-0">Date Entretien*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <input type="date" id="Entretiendate" class="form-control p-0 border-0" name="Entretiendate">
                              </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Commentaire*</label>
                              <div class="col-md-12 border-bottom p-0">
                                <!-- <input type="text" id="Entretienfournisseur" placeholder="fournisseur de Entretien" class="form-control p-0 border-0"> -->
                                <textarea class="form-control p-0 border-0" id="EntretienCommentaire" rows="3"></textarea>
                              </div>
                            </div>
                            <div id="voiture" style="display: none">
                            <div class="form-group mb-4" >
                              <label class="col-md-12 p-0">Model Voiture</label>
                              <div class="col-md-12 border-bottom p-0">
                                <?php 
                                include('Gestion_location/inc/connect_db.php');
                                $query = "SELECT * FROM voiture ORDER BY modele ASC";
                                $result = mysqli_query($conn, $query);
                                ?>
                                <select id="EntretienModelVoiture" name="EntretienModelVoiture" onchange="FetchPIMM(this.value)" class="form-control p-0 border-0"> 
                                  <option value="" disabled selected>Selectionner Model Voiture</option>
                                  <?php
                                    if ($result->num_rows > 0 ){
                                        while($row = $result->fetch_assoc()){ 
                                            echo '<option value="'.$row['id_voiture'].'">'.$row['marque'].' '.$row['modele'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">PIMM</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="EntretienPIMM" name="EntretienPIMM" onchange="FetchDateAchatVoiture(this.value)" class="form-control p-0 border-0"> 
                                  <option value="" disabled selected>Selectionner Model Voiture d'abord</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                              <label class="col-md-12 p-0">Date Achat Voiture</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="EntretienDateAchatVoiture" name="EntretienDateAchatVoiture"  class="form-control p-0 border-0">
                                <option value="" disabled selected>Selectionner PIMM Voiture d'abord</option>
                                </select>
                              </div>
                            </div>
                            </div>
                            <div id="materiel" style="display: none">
                            <div class="form-group mb-4" >
                              <label class="col-md-12 p-0">Nom Materiel</label>
                              <?php 
                                include('Gestion_location/inc/connect_db.php');
                                $query = "SELECT * FROM materiel ORDER BY nom_materiel ASC";
                                $result = mysqli_query($conn, $query);
                                ?>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="EntretienNomMateriel" name="EntretienNomMateriel" onchange="FetchNumSerie(this.value)" class="form-control p-0 border-0">
                                <option value="" disabled selected>Selectionner Nom Materiel</option>
                                <?php
                                    if ($result->num_rows > 0 ){
                                        while($row = $result->fetch_assoc()){ 
                                            echo '<option value="'.$row['id_materiel'].'">'.$row['nom_materiel'].'</option>';
                                        }
                                    }
                                    ?>
                                </select> 
                              </div>
                            </div>
                            <div class="form-group mb-4" >
                              <label class="col-md-12 p-0">Num Serie Materiel</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select  id="EntretienNumSerieMateriel" name="EntretienNumSerieMateriel" onchange="FetchDateAchatMateriel(this.value)" class="form-control p-0 border-0">
                                <option value="" disabled selected>Selectionner Nom Materiel d'abord</option> 
                                </select>
                                </div>
                            </div>
                            <div class="form-group mb-4" >
                              <label class="col-md-12 p-0">Date Achat Materiel</label>
                              <div class="col-md-12 border-bottom p-0">
                                <select id="EntretienDateAchatMateriel" placeholder="date d'achat de Entretien" class="form-control p-0 border-0">
                                <option value="" disabled selected>Selectionner Num Serie Materiel d'abord</option> 
                              </select>
                              </div>
                            </div>
                            </div>
                          </form> 
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-success" id="btn-register-Entretien">Ajouter Entretien</button>
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

  </body>

  </html>