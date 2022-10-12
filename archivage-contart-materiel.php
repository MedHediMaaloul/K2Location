<?php
session_start();
// verification si la personn est bien passé par la page pour se connecter
if (isset($_SESSION['User'])) {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
} else {
    //  echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
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
                    <div class="card-heading">LISTE DES CONTRATS MATÉRIELS ARCHIVAGES</div>
                    <div class="card-body">

                        <!-- <button class="btn btn-success " type="button" data-toggle="modal"
                            data-target="#Registration-Contrat"
                            style="color:white; border-radius:50% ;font-size:25px;margin:5px;width: 50px;width: 50px;width: 50px;height:50px">+</button> -->
                        <!-- search box -->
                        <div class="p-2 bg-light rounded rounded-pill shadow-sm mb-2">
                            <div class="input-group">
                                <input type="input" placeholder="Que recherchez-vous?" id="searchContratMaterielArchive"
                                    class="form-control border-0  bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- end search box -->
                        <p id="delete_message_materiel"></p>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="white-box">

                                    <!-- PDF model  -->
                                    <div class="modal fade bd-example-modal-xl" id="PDF-Materie-modal" tabindex="-1"
                                        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="Voiture">
                                                        <!-- <button class="btn btn-primary" id="pdf">Print PDF</button> -->
                                                        <div id="toPrint">
                                                            <page_header>
                                                                <div class="row"><img src="plugins\k2-pdf.jpg" alt="" />
                                                                </div>
                                                            </page_header>
                                                            <page>
                                                                <div class="row">CONTRAT DE LOCATION N° <span
                                                                        id="Contrat-number"></div>
                                                                <div class="row">
                                                                    <div class="col-sm info border border-dark">
                                                                        <div
                                                                            class="row content-text font-weight-bold justify-content-center">
                                                                            INFORMATIONS CLIENT</div>
                                                                        <div class="row content-text">Nom:&nbsp
                                                                            <span id="Client-nom">
                                                                        </div>
                                                                        <div class="row content-text">Mail:&nbsp <span
                                                                                id="Client-mail"></span></div>
                                                                        <div class="row content-text">Tel:&nbsp <span
                                                                                id="Client-tel"></span></div>
                                                                        <div class="row content-text">Adresse:&nbsp<span
                                                                                id="Client-address"></div>

                                                                    </div>
                                                                    <div class="col-sm info border border-dark">
                                                                        <div
                                                                            class="row content-text font-weight-bold justify-content-center">
                                                                            INFORMATIONS MATÉRIEL</div>
                                                                        <div class="row">
                                                                            <div class="col content-text">Nom de
                                                                                Matériel:&nbsp<span
                                                                                    id="Contrat-Designation"></span>
                                                                            </div>
                                                                            <div class="col content-text">Num de
                                                                                Série:&nbsp<span
                                                                                    id="Contrat-numero"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col content-text"> <br> <span
                                                                                    id="Composant-Designation"></span>
                                                                            </div>
                                                                            <div class="col content-text"> <br> <span
                                                                                    id="Composant-numero"></span>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div> <br>
                                                                <div
                                                                    class="row d-flex justify-content-center font-weight-bold">
                                                                    CONDITIONS PARTICULIERES
                                                                </div>
                                                                <br>
                                                                <div class="row content-text">
                                                                    Le locataire reconnait que le matériel loué a bien
                                                                    un rapport direct avec son activité et que ce
                                                                    faisant le code de la consommation ne s’applique
                                                                    pas.
                                                                    Le loueur et le locataire certifient, attestent et
                                                                    conviennent que le matériel est livré ce jour, qu’il
                                                                    est conforme à sa désignation, aux prescriptions des
                                                                    règlements d’hygiène et de sécurité du travail,
                                                                    qu’il est en bon état de fonctionnement sans vice
                                                                    apparent ou caché et répond aux besoins du
                                                                    locataire, qu’il n’est pas contrefaisant et qu’il
                                                                    est conforme à la réglementation relative à la
                                                                    pollution et à la protection de l’environnement.
                                                                </div>
                                                                <br>
                                                                <div class="row font-weight-bold">AUTRE INFORMATIONS
                                                                </div>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">État du matériel :
                                                                    </div>
                                                                    <div class="row content-text">
                                                                        <p>Lors de la remise du matériel et lors de sa
                                                                            restitution, une fiche de contrôle de l'état
                                                                            sera établie entre le locataire et le
                                                                            loueur.
                                                                            Le matériel devra être restitué dans le même
                                                                            état que lors de sa mise à disposition au
                                                                            locataire.
                                                                            Toutes les détériorations sur le matériel
                                                                            constatées sur le PV de sortie seront à la
                                                                            charge du locataire et/ou être déduites en
                                                                            partie ou totalité sur le montant de la
                                                                            caution.
                                                                        </p>
                                                                    </div>
                                                                </section>
                                                                <section>
                                                                    <div class="row font-weight-bold">Durée:</div>
                                                                    <div class="row content-text">Du &nbsp<span
                                                                            id="Contrat-Date-Debut"></span> &nbsp au
                                                                        &nbsp <span id="Contrat-Date-Fin"></span> </div>
                                                                    <div class="row content-text" id="ilpourra">
                                                                    </div>
                                                                </section> <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Prix location:
                                                                    </div>
                                                                    <div class="row"><span
                                                                            id="Contrat-Prix"></span>&nbsp euros en HT
                                                                        <div id="prix-location"></div>&nbsp <span
                                                                            id="Contrat-prix-TTC"></span>&nbsp euros en
                                                                        TTC
                                                                    </div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Mode de paiement:
                                                                    </div>
                                                                    <div class="row">
                                                                        Les loyers sont dus à date échu; Le premier
                                                                        paiement s’effectuera le jour de la mise à
                                                                        disposition du matériel.</div>
                                                                    <div class="row"><span
                                                                            id="Contrat-Mode-Paiement">&nbsp</span>&nbsp<span
                                                                            id="Contrat-Date-Prelevement"></span></div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Dépôt de garantie:
                                                                    </div>
                                                                    <div class="row content-text">
                                                                        <p id="next">Le locataire verse à K2, une somme
                                                                            de &nbsp <span id="Contrat-Caution"></span>€
                                                                            à
                                                                            titre de dépôt de garantie pour répondre
                                                                            des dégâts qui pourraient être causés aux
                                                                            matériels loués. Le remboursement du dépôt
                                                                            de
                                                                            garantie sera effectué au retour du matériel
                                                                            si celui-ci n’a pas été endommagé. <br> N°
                                                                            de chèque de caution : <span
                                                                                id="Num-cheque-caution"></span>
                                                                        </p>

                                                                    </div>
                                                                </section>
                                                                <section>
                                                                    <div class="row font-weight-bold">Documents à
                                                                        fournir:</div>
                                                                    <div class="row">Pièce d’identité du gérant</div>
                                                                    <div class="row">Rib pour les prélèvements mensuels
                                                                    </div>
                                                                    <div class="row">Kbis de moins de 3 mois</div>
                                                                    <div class="row">Attestation d’assurance
                                                                        responsabilité civile</div>
                                                                    <div class="row">Pour les contrats avec engagement, toutes ruptures de contrat (que ce soit 6 mois ou 1 ans),
                                                                        engendrons des frais de résiliation à hauteur de 30% de la totalité des factures restantes.</div>
                                                                </section>
                                                                <br>
                                                                <section>
                                                                    <div class="row font-weight-bold ">Autres elements
                                                                        et
                                                                        accessoires:</div>
                                                                    <div class="row">
                                                                        Le locataire prendra en charge l'ensemble des
                                                                        charges afférentes au bon fonctionnement du
                                                                        matériel:
                                                                    </div>
                                                                    <div class="row">- Nettoyage</div>
                                                                    <div class="row" id="changement-electrode"></div>
                                                                    <div class="row content-text">
                                                                        La sous-location du matériel par le locataire à
                                                                        un tiers est exclue
                                                                    </div>
                                                                </section> <br>
                                                                <section>
                                                                    <div class="row font-weight-bold">Clause en cas de
                                                                        litige:</div>
                                                                    <div class="row content-text">
                                                                        <p> Les parties conviennent expressément que
                                                                            tout litige pouvant naître de l'exécution du
                                                                            présent contrat relèvera de la compétence du
                                                                            tribunal de commerce de DIJON.
                                                                            Fait en deux exemplaires originaux remis à
                                                                            chacune des parties,
                                                                            A CHEVIGNY SAINT SAUVEUR, le <span
                                                                                id="Contrat-Date-Debut"></span></p>
                                                                    </div>
                                                                    <br>
                                                                    <br>
                                                                    <div class="row">
                                                                        <p
                                                                            class="content-text d-flex justify-content-center">
                                                                            Le locataire soussigné déclare accepter
                                                                            toutes les conditions générales figurant sur
                                                                            les pages
                                                                            suivantes du contrat qui été établi en
                                                                            autant d’exemplaires que de parties.
                                                                            Signature du contrat et l’autorisation de
                                                                            prélèvement ci-dessous et paraphe de chaque
                                                                            page.
                                                                        </p>

                                                                    </div>
                                                                </section>
                                                                <div class="row">
                                                                    <div
                                                                        class="col-8 signature-client border border-dark content-text d-flex justify-content-center mr-3">
                                                                        <div
                                                                            class="d-flex flex-column bd-highlight mb-3 ">
                                                                            <div
                                                                                class=" bd-highlight font-weight-bold d-flex justify-content-center">
                                                                                Cachet commercial et signature du
                                                                                LOCATAIRE</div>
                                                                            <div
                                                                                class=" bd-highlight d-flex justify-content-center">
                                                                                précédée de la mention manuscrite Bon
                                                                                pour
                                                                                accord</div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-sm signature border border-dark content-text d-flex justify-content-center font-weight-bold ml-3">
                                                                        Signature du LOUEUR</div>
                                                                </div>
                                                                <div class="row" style="margin: 15px;">
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm"></div>
                                                                    <div class="col-sm">Paraphe</div>
                                                                </div>
                                                                <div id="para"></div>
                                                                <?php
                                                                include 'conditionGeneral.php';
                                                                ?>

                                                            </page>
                                                        </div>

                                                        <style>
                                                        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400&display=swap');

                                                        img {
                                                            width: 86px;
                                                            height: 45px;
                                                        }

                                                        .content-text {
                                                            color: black;
                                                            /* letter-spacing: 1px; */
                                                        }

                                                        .para {
                                                            font-size: 7.3px;
                                                        }

                                                        #toPrint {
                                                            font-family: 'Roboto Slab', serif !important;
                                                            font-size: 12px;
                                                            padding: 10px;
                                                            margin: 7px;
                                                            font-weight: 400 !important;
                                                            font-stretch: condensed !important;
                                                            color: black;
                                                        }

                                                        #next {
                                                            color: black;
                                                        }

                                                        .btn-primary {
                                                            position: relative;
                                                            z-index: 1;
                                                        }

                                                        .info {
                                                            margin: 0;
                                                            padding-left: 30px;
                                                        }

                                                        .signature-client {
                                                            height: 160px;
                                                        }

                                                        .Condition {
                                                            font-family: 'Roboto Slab', serif !important;
                                                            font-size: 6.4px;
                                                        }
                                                        </style>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="modal fade loading" tabindex="-1" role="dialog"
                                                        id="spinnerModal">
                                                        <div class="modal-dialog modal-dialog-centered text-center"
                                                            role="document">
                                                            <span class="fas fa-spinner fa-spin fa-6x w-300 text-danger"
                                                                style="width: 6rem; height: 6rem; margin-left:200px"></span>
                                                            <script>
                                                            function modal() {
                                                                $('.loading').modal('show');
                                                                setTimeout(function() {
                                                                    $('.loading').modal('hide');
                                                                }, 3000);
                                                            }
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- END PDF model -->



                                    <!-- END PDF model -->
                                    <!-- modal delet contrat -->
                                    <div class="modal fade" id="deleteContrat" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Supprimer Contrat
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>voulez-vous supprimer le contrat ?</p>
                                                    <button class="btn btn-success" id="btn_delete">Supprimer
                                                        Contrat</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                        id="btn-close">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end modal delet contrat -->
                                    <div class="table-responsive" id="contrat-list-materiel-archivage"> </div>



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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script src="js/GeneratePDF.js"></script>

    </body>

    </html>