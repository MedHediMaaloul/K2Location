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
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">LISTE DES CLIENTS INACTIFS</div>
                        <div class="col-sm-12">
                            <p id="delete_message"></p>
                            <!-- search box -->
                            <div style="display: table;">
                                <div style="display: table-cell; width: 50%;">
                                </div>
                                <div style="display: table-cell; width: 100%;">
                                    <input type="input" placeholder="Que recherchez-vous?" id="searchClientI"
                                        class="col-sm-12 rounded rounded-pill form-control border-0 bg-light"/>
                                </div>
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- end search box -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">
                                    <div class="table-responsive" style="height: 460px;" id="client-inactif-list"></div>
                                    <!-- show file modal -->
                                    <div class="modal fade bd-example-modal-sm" id="file-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-img-content">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end file modal -->
                                    <!-- delete Client model -->
                                    <div class="modal fade" id="deleteClient" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <p>voulez-vous supprimer le client ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end  delete modal -->



                                    <!-- show Client model pro -->
                                    <div class="modal fade" id="showClient" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Afficher Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message10"></p>
                                                    <form id="up-clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_Clienttype">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom de l'entreprise<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_entrepriseName100"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclient100">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmail100"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhone100"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdresse100"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientName100"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Num Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNumPermis100"
                                                                    placeholder="Numéro De Permis"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">SIRET<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientSiret100"
                                                                    placeholder="Num Siret"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code NAF<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNaf100"
                                                                    placeholder="Code NAF"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code TVA<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientTva100"
                                                                    placeholder="User TVA"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Création de l'entreprise<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" min="0" id="up_clientDateEntreprise100"
                                                                    placeholder="User Date Entreprise100"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_comment100"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CNI</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                    <div id="cincin100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="permis1100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="kbis1100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="rib1100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Attestation Responsabilité
                                                                Civile</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="attestation1100"></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end show modal -->

<!-- show Client model part -->
<div class="modal fade" id="showClientPart" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Fiche Client Particulier</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="Message100"></p>
                                                    <form id="up-clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_Clienttypepart">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclientpart100">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNamepart100"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmailpart100"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhonepart100"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger"></span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdressepart100"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Num Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNumPermispart100"
                                                                    placeholder="Numéro De Permis"
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_commentpart100"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CNI</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                    <div id="cincinpart100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="permispart1100"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <div id="ribpart1100"></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end show modal -->

                                   <!-- update Client model pro -->
                                   <div class="modal fade" id="updateClient" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_Clienttype">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom de l'entreprise<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_entrepriseName"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclient">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmail"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhone"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdresse"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" style="display:none">
                                                            <label class="col-md-12 p-0">Raison social<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientRaison"
                                                                    placeholder="La raison social"
                                                                    class="form-control p-0 border-0" value="--">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientName"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Num Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNumPermis"
                                                                    placeholder="Numéro De Permis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">SIRET<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientSiret"
                                                                    placeholder="Num Siret"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code NAF<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNaf"
                                                                    placeholder="Code NAF"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Code TVA<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientTva"
                                                                    placeholder="User TVA"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Date Création de l'entreprise<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="date" id="up_clientDateEntreprise"
                                                                    placeholder="User Date Entreprise"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_comment"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CNI</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientCIN"
                                                                    placeholder="CNI de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientPermis"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientKBIS"
                                                                    placeholder="KBIS de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientRIB"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Attestation Responsabilité
                                                                Civile</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientAttestation"
                                                                    placeholder="Attestation Responsabilité Civile de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update">Modifier
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                    <!-- update Client model  part-->
                                    <div class="modal fade" id="updateClientPart" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message_part"></p>
                                                    <form id="up-clientFormPart" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_ClienttypePart">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Nom Conducteur<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNamePart"
                                                                    placeholder="User User"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclientPart">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="up_clientEmailPart"
                                                                    placeholder="user@user.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Téléphone<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientPhonePart"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientAdressePart"
                                                                    placeholder="Votre adresse .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Num Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_clientNumPermisPart"
                                                                    placeholder="Numéro De Permis"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Commentaire

                                                            </label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="up_commentPart"
                                                                    placeholder="Votre commentaire .."
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CNI</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientCINPart"
                                                                    placeholder="CNI de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientPermisPart"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientRIBPart"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_part">Modifier
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->

                                     <!-- update Client doc -->
                                     <div class="modal fade" id="updateClientDoc" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modifier
                                                        document Client
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="up_message"></p>
                                                    <form id="up-clientDocForm" autocomplete="off"
                                                        class="form-horizontal form-material">


                                                        <div class="form-group mb-4">
                                                            <input type="hidden" id="up_idclientdoc">
                                                        </div>



                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">CNI</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientCINdoc"
                                                                    placeholder="CNI de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientPermisdoc"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientKBISdoc"
                                                                    placeholder="KBIS de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientRIBdoc"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="col-md-12 p-0">Attestation Responsabilité
                                                                Civile</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="up_clientAttestationdoc"
                                                                    placeholder="Attestation Responsabilité Civile de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn_update_doc">Modifier
                                                        Client</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end update modal -->


                                    <!-- Modal add client -->
                                    <div class="modal fade" id="Registration-Client" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter Client</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        id="btn-close" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="message"></p>
                                                    <form id="clientForm" autocomplete="off"
                                                        class="form-horizontal form-material">
                                                        <div class="form-group mb-4">


                                                            <label class="col-md-12 p-0">Type<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">

                                                                <select id="Clienttype"
                                                                    onchange="selectclient(this.value)"
                                                                    name="Clienttype">
                                                                    <option value="" disabled selected>Selectionner Type
                                                                    </option>
                                                                    <option value="CLIENT PRO">CLIENT PRO </option>
                                                                    <option value="CLIENT PARTICULIER"> CLIENT
                                                                        PARTICULIER</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group mb-4" id="cont_nom_complet"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Nom Complet<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userName"
                                                                    placeholder="Johnathan Doe"
                                                                    class="form-control p-0 border-0" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_email"
                                                            style="display:none">
                                                            <label for="example-email" class="col-md-12 p-0">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="email" id="userEmail"
                                                                    placeholder="johnathan@admin.com"
                                                                    class="form-control p-0 border-0"
                                                                    name="example-email" id="example-email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_telephone"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Téléphone</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userPhone"
                                                                    placeholder="123 456 7890"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_adresse"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Adresse<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userAdresse"
                                                                    placeholder="Client adresse"
                                                                    class="form-control p-0 border-0">
                                                            </div>

                                                        </div>
                                                        <div class="form-group mb-4" id="cont_raison"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Raison Social<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userRaison"
                                                                    placeholder="La raison sociale"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_comment"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Commentaire<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="text" id="userComment"
                                                                    placeholder="Votre commentaire"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_cin" style="display:none">
                                                            <label class="col-md-12 p-0">CIN</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userCIN"
                                                                    placeholder="CIN de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_permis"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">Permis</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userPermis" name="Permis-client"
                                                                    placeholder="Permis de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_kbis"
                                                            style="display:none">
                                                            <label class="col-md-12 p-0">KBIS</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userKBIS"
                                                                    placeholder="KBIS de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-4" id="cont_rib" style="display:none">
                                                            <label class="col-md-12 p-0">RIB</label>
                                                            <div class="col-md-12 border-bottom p-0">
                                                                <input type="file" id="userRIB"
                                                                    placeholder="RIB de Client"
                                                                    class="form-control p-0 border-0">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" id="btn-register-client">Ajouter
                                                        Client</button>
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