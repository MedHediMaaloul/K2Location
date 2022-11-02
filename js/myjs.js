$(document).ready(function () {
  var path = window.location.pathname;
  var page = path.split("/").pop();
  insertRecord();
  if (page == "client.php") {
    view_client_record();
  }
  update_client_doc_record();
  get_client_doc_record();
  get_client_record();
  get_show_client_record();
  get_show_client_part_record();
  get_client_part_record();
  update_client_record();
  update_client_part_record();
  delete_client_record();

  update_client_doc_record();
  get_client_doc_record();
  if (page == "Client_inactif.php") {
    view_client_inactif_record();
  }

  //materiel
  insertMaterielRecord();
  insertComposantMaterielRecord();
  get_categorie_record();
  update_categorie_record();
  if (page == "materiel-agence.php") {
    view_Materiel_record();
  }
  get_materielcomposant_record();
  get_materiel_record();
  update_materiel_record();
  delete_materiel_record();
  delete_composant_materiel();
  //voitures
  insert_voiture_Record();
  insert_voiture_vendue_Record();
  insert_voiture_HS_Record();
  get_voiture_record();
  get_voiture_vendue_record();
  get_voiture_HS_record();
  view_SettingVoitureHSRecord();
  // view_SettingVoitureTransfRecord();
  update_voiture_record();
  update_voiture_stock_record();
  update_materiel_stock_record();
  update_materiel_stock_quantite_record();
  if (page == "vehicule.php") {
    view_voiture_record();
  }
  delete_voiture_record();
  update_voiture_vendue_record();
  update_voiture_HS_record();
  if (page == "vehicule-HS.php") {
    view_voiture_HS_record();
  }
  if (page == "vehicule-Vendue.php") {
    view_voiture_vendue_record();
  }
  //entretien
  insertEntretienRecord();
  if (page == "entretien-materiel.php") {
    view_Entretien_record_materiel();
  }



  if (page == "Controletechnique.php") {
    view_Controletechnique_record();
  }

  view_controle_historique();
  searchHistoriqueControle();
  user_historiquecontrole_dispo();
  insertInsertControletechniqueRecord();
  searchControleTechnique();
  Type_Controle_dispo();

  if (page == "entretien-voiture.php") {
    view_Entretien_record_voiture();
  }
  view_entretien_historique();
  if (page == "entretien.php") {
    view_Entretien_record();
  }
  get_Entretien_record();
  update_entretien_record();
  get_Entretien_mecanicien_record();
  update_entretien_mecanicien_record();
  delete_entretien_record();
  realisation_entretien_record()
  get_Controle_technique_record();
  get_Controle_technique_mecanicien_record();
  update_Controle_technique_record();
  update_Controle_technique_mecanicien_record();
  delete_Controletechnique_record();
  realisation_Controletechnique_record();
  //contrat
  //Contrat mixte-------------------
  // view_contrat_record_mixte();
  // insertContratMixteRecord();
  delete_contrat_record_mixte();
  get_Mixte_record();
  //Contrat-------------------
  if (page == "contart-materiel.php") {
    view_contrat_record_materiel();
  }
  if (page == "contart-voiture.php") {
    view_contrat_record_voiture();
  }
  if (page == "contart-pack.php") {
    view_contrat_record_pack();
  }
  insertContratVoitureRecord();
  insertContratMaterielRecord();
  insertContratRecord();
  get_Contrat_record_signe();
  get_ContratMateriel_record_signe();
  get_ContratPack_record_signe();
  get_Contrat_record();
  get_Contrat_Materiel_record();
  get_Contrat_Pack_record();
  get_ContratAvenant_record();
  update_contratavenant_record();
  update_contratavenant_materiel_record();
  update_contratavenant_pack_record();
  update_contrat_signe_record();
  update_contratmateriel_signe_record();
  update_contratpack_signe_record();
  update_contrat_record();
  update_contrat_materiel_record();
  update_contrat_pack_record();
  delete_contrat_record();
  delete_contrat_record_materiel();
  delete_contrat_record_pack();
  valide_sortie_contrat_record();
  valide_retour_contrat_record();
  valide_sortie_contrat_materiel();
  valide_retour_contrat_materiel();
  valide_sortie_contrat_pack();
  valide_retour_contrat_pack()
  // Contrat



  // Contrat

  //pdf Contrat

  get_id_client();
  get_id_client_contrat_materiel();
  get_id_client_contrat_pack();
  get_contrat_voiture_avenant();
  get_contrat_materiel_avenant();
  get_contrat_pack_avenant();
  showPDFModel();
  showPDFModel_materiel();
  // showfile();
  showPDFMaterielModel();
  // showPDFMixteModel();
  showPDFPackModel();
  //search
  searchAgence();
  searchUser();
  searchClient();
  searchClientInactif();
  searchCategorie();
  searchVoiture();
  searchVoitureVendu();
  searchVoitureHS();
  searchGestionPack();
  searchMaterielAgence();
  searchStock();
  searchStockMateriel();
  searchContratVoiture();
  searchContratMateriel();
  searchContratPack();
  searchHistoriqueContrat();
  user_modif_dispo();
  searchContratVoitureArchive();
  searchContratMaterielArchive();
  searchEntretiens();
  searchEntretienMateriel();
  searchEntretienVoiture();
  searchContratVoitureArchivage();
  searchContratMaterielArchivage();
  searchContratPackArchivage();
  //notification contrat
  load_unseen_notification();
  load_unseen_notification_entretien();
  load_unseen_notification_paiement();
  load_unseen_notification_contratDebut();
  removeNotification_contratdebut();
  removeNotification();
  removeNotification_entretien();
  //setting voiture
  insertVoitureSettingRecord();
  view_SettingVoitureRecord();
  delete_SettingVoiturerecord();
  // achived Contract
  // view_contrat_archived();
  if (page == "archivage-contart-materiel.php") {
    view_contrat_archived_materiel();
  }
  getValidateContratPaiement();
  update_contrat_validate_record();

  //  User
  insertUserRecord();
  if (page == "utilisateur.php") {
    view_user_record();
  }
  get_user_record();
  update_user_record();
  delete_user_record();


  //  Agence
  insertAgenceRecord();
  insertAgenceRecordHeur();
  if (page == "agence.php") {
    view_agence_record();
  }
  get_agence_record();
  update_agence_record();
  delete_agence_record()
  delete_agence_heur_record();

  //pack
  if (page == "gestion_pack.php") {
    view_group_pack_record();
  }
  insertGroupPackRecord();
  delete_pack_record(); 
  get_packmateriel_record();
  insertMaterielPackRecord();
  delete_materiel_pack();
  get_group_pack_record();
  insertContratPackRecord();
  update_group_pack_record();
  //  categorie
  insertCategorieRecord();
  if (page == "categorie.php") {
    view_categorie_record();
  }
  delete_categorie_record();
  //comp
  insertStockRecord();
  get_materielstock_record();
  if (page == "materiel-grppack.php") {
    view_grppack_record();
  }
  //stock 
  if (page == "stock.php") {
    view_stock_record();
  }
  get_stock_voiture();
  get_stock_material();
  get_stock_material_quantite();
  // view_stock_record1();
  if (page == "stock_matreiel.php") {
    view_stock_materiel_record();
  }
  if (page == "contart-materiel.php") {
    view_stock_Q_record();
  }

  //contrat_archivage
  view_contrat_archivage_record_voiture();
  if (page == "archivage-contart-materiel.php") {
    view_contrat_archivage_record_materiel();
  }
  if (page == "archivage-contart-pack.php") {
    view_contrat_archivage_record_pack();
  }
  if (page == "historique-contart.php") {
    view_contrat_historique();
  }

  //devis 
  insertDevisRecord();
  if (page == "devis.php") {
    view_devis_record();
  }
  genereriddevis();
  delete_devis();
  get_Devis();
  update_devis_record();
  searchDevis();

  //facture

  if (page == "facture-contart-voiture.php") {
    view_facture_contrat_voiture();
  }
  if (page == "facture-contart-materiel.php") {
    view_facture_contrat_materiel();
  }
  if (page == "facture-contart-pack.php") {
    view_facture_contrat_pack();
  }
  insertFacture();
  genereridfacturevoiture();
  genereridfacturemateriel();
  genereridfacturepack();
  searchFactureVoiture();
  searchFactureMateriel();
  searchFacturePack();

  //chauffeur 
  //insertChauffeurRecord();
  if (page == "chauffeur.php") {
    view_chauffeur_record();
  }
  insertK2chauffeur();
  delete_chauffeurk2_record();
  //voiture
  if (page == "k2voiture.php") {
    view_k2voiture_record();
  }
  insertK2voiture();
  delete_voiturek2_record();
  // end voiture
  if (page == "affectation_vehicule.php") {
    view_k2affectation_record();
  }
  insertK2affectation();
  searchAffectation();
  delete_affectationk2_record();

  searchvoiturek2();
  searchchauffeurk2();

  // affictation_dispo();

});




//insert Record in the data base 
function insertRecord() {
  $(document).on("click", "#btn-register-client", function () {
    $("#Registration-Client").scrollTop(0);
    var type = $("#Clienttype").val();
    var raison_social = $("#userRaison").val();
    var num_permis_pro = $("#userNumPermisPro").val();
    var num_permis_part = $("#userNumPermisPart").val();
    var num_siret = $("#userSiret").val();
    var code_naf = $("#userNaf").val();
    var code_tva = $("#userTva").val();
    var date_creation_entreprise = $("#userDateEntreprise").val();
    var comment = $("#userComment").val();
    var nom1 = $("#userName").val();
    var nom2 = $("#userNamepro").val();
    var nom_entreprise = $("#entrepriseName").val();
    var email = $("#userEmail").val();
    var tel = $("#userPhone").val();
    var adresse = $("#userAdresse").val();
    var cin = $("#userCIN").prop("files")[0];
    var permis = $("#userPermis").prop("files")[0];
    var kbis = $("#userKBIS").prop("files")[0];
    var rib = $("#userRIB").prop("files")[0];
    var attestation_civile = $("#userAttestation").prop("files")[0];

    /********************Test Champs obligatoire CLIENT PRO */
    if(type == "CLIENT PRO"){
      nom = nom2;
      num_permis = num_permis_pro;
    }else{
      nom = nom1;
      num_permis = num_permis_part;
    }
    if (type == "CLIENT PRO" && nom_entreprise == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le Nom de l'entreprise !");
    } else if (type == "CLIENT PRO" && email == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir l'email !");
    } else if (type == "CLIENT PRO" && tel == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le numéro téléphone !");
    } else if (type == "CLIENT PRO" && adresse == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir l'adresse !");
    } else if (type == "CLIENT PRO" && num_siret == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le numéro siret !");
    } else if (type == "CLIENT PRO" && code_naf == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le code naf !");
    } else if (type == "CLIENT PRO" && code_tva == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le code tva !");
    } else if (type == "CLIENT PRO" && date_creation_entreprise == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir la date creation de l'entreprise !");
    } 
    /********************Test Champs obligatoire CLIENT PARTICULIER */
    else if (type == "CLIENT PARTICULIER" && nom == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le Nom Conducteur !");
    } else if (type == "CLIENT PARTICULIER" && email == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir l'email !");
    } else if (type == "CLIENT PARTICULIER" && tel == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le numéro téléphone !");
    } else if (type == "CLIENT PARTICULIER" && adresse == "" ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir l'adresse !");
    } else if (type == "CLIENT PARTICULIER" && num_permis == ""  ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le Numéro Permis !");
    } else if (type == "CLIENT PARTICULIER" && permis == null  ){
      $("#message").addClass("alert alert-danger").html("Veuillez remplir le fichier de PERMIS !");
    }
    /********************Test Format Email */
    else if (!isValidEmailAddress(email)) {
      $("#message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("type", type);
      form_data.append("raison_social", raison_social);
      form_data.append("num_permis", num_permis);
      form_data.append("siret", num_siret);
      form_data.append("naf", code_naf);
      form_data.append("codetva", code_tva);
      form_data.append("date_creation_entreprise", date_creation_entreprise);
      form_data.append("comment", comment);
      form_data.append("nom", nom);
      form_data.append("nom_entreprise", nom_entreprise);
      form_data.append("email", email);
      form_data.append("tel", tel);
      form_data.append("adresse", adresse);
      form_data.append("cin", cin);
      form_data.append("kbis", kbis);
      form_data.append("permis", permis);
      form_data.append("rib", rib);
      form_data.append("attestation_civile", attestation_civile);
      $.ajax({
        url: "AjoutClient.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Client").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Client").modal("show");
            $("#clientForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_client_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#clientForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

// dispaly client record

function view_client_record() {
  $.ajax({
    url: "viewclient.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#client-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}
// get particuler client record
function get_client_record() {
  $(document).on("click", "#btn-edit-client", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclient").val(data[0]);
        $("#up_clientName").val(data[1]);
        $("#up_clientEmail").val(data[2]);
        $("#up_clientPhone").val(data[3]);
        $("#up_clientAdresse").val(data[4]);
        $("#up_clientNumPermis").val(data[5]);
        $("#up_clientCIN").val();
        $("#up_comment").val(data[7]);
        $("#up_clientSiret").val(data[13]);
        $("#up_clientNaf").val(data[14]);
        $("#up_clientTva").val(data[15]);
        $("#up_entrepriseName").val(data[16]);
        $("#up_clientDateEntreprise").val(data[17]);
        $("#up_clientPermis").val();
        $("#up_clientKBIS").val();
        $("#up_clientRIB").val();
        $("#up_clientAttestation").val();
        $("#up_clientRaison").val(data[11]);
        $("#up_Clienttype").val(data[12]);
        $("#updateClient").modal("show");
      },
    });
  });
}

// get particuler client record
function get_show_client_record() {
  $(document).on("click", "#btn-show-client", function () {
    console.log('okokok');
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_show_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclient100").val(data[0]);
        $("#up_clientName100").val(data[1]);
        $("#up_clientEmail100").val(data[2]);
        $("#up_clientPhone100").val(data[3]);
        $("#up_clientAdresse100").val(data[4]);
        $("#up_clientNumPermis100").val(data[5]);
        $("#cincin100").html('<a href="uploads/'+data[6]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[6]+'" ></a>');
        $("#up_comment100").val(data[7]);
        $("#up_clientSiret100").val(data[13]);
        $("#up_clientNaf100").val(data[14]);
        $("#up_clientTva100").val(data[15]);
        $("#up_entrepriseName100").val(data[16]);
        $("#up_clientDateEntreprise100").val(data[17]);
        $("#permis1100").html('<a href="uploads/'+data[8]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[8]+'" ></a>');
        $("#kbis1100").html('<a href="uploads/'+data[9]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[9]+'" ></a>');
        $("#rib1100").html('<a href="uploads/'+data[10]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[10]+'" ></a>');
        $("#attestation1100").html('<a href="uploads/'+data[18]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[18]+'" ></a>');
        $("#up_clientRaison100").val(data[11]);
        $("#up_Clienttype100").val(data[12]);
        $("#showClient").modal("show");
      },
    });
  });
}

// get particuler client record
function get_show_client_part_record() {
  $(document).on("click", "#btn-show-client-part", function () {
    console.log('okokok');
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_show_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclientpart100").val(data[0]);
        $("#up_clientNamepart100").val(data[1]);
        $("#up_clientEmailpart100").val(data[2]);
        $("#up_clientPhonepart100").val(data[3]);
        $("#up_clientAdressepart100").val(data[4]);
        $("#up_clientNumPermispart100").val(data[5]);
        $("#cincinpart100").html('<a href="uploads/'+data[6]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[6]+'" ></a>');
        $("#up_commentpart100").val(data[7]);
        $("#permispart1100").html('<a href="uploads/'+data[8]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[8]+'" ></a>');
        $("#ribpart1100").html('<a href="uploads/'+data[10]+'" target="_blank"><img width="40px"height="30px" class="cin" src="uploads/'+data[10]+'" ></a>');
        $("#up_Clienttypepart").val(data[12]);
        $("#showClientPart").modal("show");
      },
    });
  });
}

function update_client_doc_record() {
  $(document).on("click", "#btn_update_doc", function () {
    $("#updateClientDoc").scrollTop(0);
    var updateclientID = $("#up_idclientdoc").val();
    var updateclientCIN = $("#up_clientCINdoc").prop("files")[0];
    var updateclientPermis = $("#up_clientPermisdoc").prop("files")[0];
    var updateclientKBIS = $("#up_clientKBISdoc").prop("files")[0];
    var updateclientAttestation = $("#up_clientAttestationdoc").prop("files")[0];
    var updateclientRIB = $("#up_clientRIBdoc").prop("files")[0];

    if (updateclientRIB && updateclientAttestation && updateclientKBIS && updateclientPermis && updateclientCIN) {
      var verif_file = "true";
    } else {
      var verif_file = "false";
    }


    if (updateclientID == "") {
      $("#up_message_doc")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être null... !");
      $("#updateClientDoc").modal("show");
    } else if (verif_file == "false") {
      $("#up_message_doc")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être null !");
      $("#updateClientDoc").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientID);
      form_data.append("cin", updateclientCIN);
      form_data.append("kbis", updateclientKBIS);
      form_data.append("permis", updateclientPermis);
      form_data.append("rib", updateclientRIB);
      form_data.append("attestation_civile", updateclientAttestation);
      $.ajax({
        url: "update_doc_client.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message_doc")
            .addClass("alert alert-success")
            .html("Le client est modifié avec succès");
          $("#updateClientDoc").modal("show");
          view_client_record();
          view_client_inactif_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientForm").trigger("reset");
      $("#up_message_doc").html("");
      $("#up_message_doc").removeClass("alert alert-danger");
      $("#up_message_doc").removeClass("alert alert-sucess");
    });
  });
}


// get particuler client record DOC
function get_client_doc_record() {
  $(document).on("click", "#btn-edit-doc", function () {
    var ID = $(this).attr("data-id3");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclientdoc").val(data[0]);
        $("#updateClientDoc").modal("show");
      },
    });
  });
}

function get_client_part_record() {
  $(document).on("click", "#btn-edit-client-part", function () {
    var ID = $(this).attr("data-id2");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclientPart").val(data[0]);
        $("#up_clientNamePart").val(data[1]);
        $("#up_clientEmailPart").val(data[2]);
        $("#up_clientPhonePart").val(data[3]);
        $("#up_clientAdressePart").val(data[4]);
        $("#up_clientNumPermisPart").val(data[5]);
        $("#up_clientCINPart").val();
        $("#up_commentPart").val(data[7]);
        $("#up_clientSiret").val(data[13]);
        $("#up_clientNaf").val(data[14]);
        $("#up_clientTva").val(data[15]);
        $("#up_clientDateEntreprise").val(data[17]);
        $("#up_clientPermisPart").val();
        $("#up_clientRIBPart").val();
        $("#up_clientRaisonPart").val(data[11]);
        $("#up_ClienttypePart").val(data[12]);
        $("#updateClientPart").modal("show");
      },
    });
  });
}


function update_client_record() {
  $(document).on("click", "#btn_update", function () {
    $("#updateClient").scrollTop(0);
    var updateclientID = $("#up_idclient").val();
    var updateclientName = $("#up_clientName").val();
    var updateentrepriseName = $("#up_entrepriseName").val();
    var updateclientEmail = $("#up_clientEmail").val();
    var updateclientPhone = $("#up_clientPhone").val();
    var updateclientType = $("#up_Clienttype").val();
    var updateclientAdresse = $("#up_clientAdresse").val();
    var raison_social = $("#up_clientRaison").val();
    var num_permis = $("#up_clientNumPermis").val();
    var num_siret = $("#up_clientSiret").val();
    var code_naf = $("#up_clientNaf").val();
    var code_tva = $("#up_clientTva").val();
    var DateEntreprise = $("#up_clientDateEntreprise").val();
    var comment = $("#up_comment").val();
    var updateclientCIN = $("#up_clientCIN").prop("files")[0];
    var updateclientPermis = $("#up_clientPermis").prop("files")[0];
    var updateclientKBIS = $("#up_clientKBIS").prop("files")[0];
    var updateclientAttestation = $("#up_clientAttestation").prop("files")[0];
    var updateclientRIB = $("#up_clientRIB").prop("files")[0];
   /********************Test Champs obligatoire CLIENT PRO */
   if (updateentrepriseName == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le Nom de l'entreprise !");
  } else if (updateclientEmail == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir l'email !");
  } else if (updateclientPhone == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le numéro téléphone !");
  } else if (updateclientAdresse == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir l'adresse !");
  } else if (raison_social == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le raison social !");
  } else if (num_siret == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le numéro siret !");
  } else if (code_naf == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le code naf !");
  } else if (code_tva == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir le code tva !");
  } else if (DateEntreprise == "" ){
    $("#up_message").addClass("alert alert-danger").html("Veuillez remplir la date creation de l'entreprise !");
  } 
  /********************Test Format Email */
  else if (!isValidEmailAddress(updateclientEmail)) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
  } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientID);
      form_data.append("nom_entreprise", updateentrepriseName);
      form_data.append("nom", updateclientName);
      form_data.append("email", updateclientEmail);
      form_data.append("tel", updateclientPhone);
      form_data.append("adresse", updateclientAdresse);
      form_data.append("raison_social", raison_social);
      form_data.append("num_permis", num_permis);
      form_data.append("siret", num_siret);
      form_data.append("naf", code_naf);
      form_data.append("codetva", code_tva);
      form_data.append("DateEntreprise", DateEntreprise);
      form_data.append("comment", comment);
      form_data.append("updateclientType", updateclientType);
      form_data.append("cin", updateclientCIN);
      form_data.append("kbis", updateclientKBIS);
      form_data.append("permis", updateclientPermis);
      form_data.append("rib", updateclientRIB);
      form_data.append("attestation_civile", updateclientAttestation);
      $.ajax({
        url: "update_client.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#up_message")
            .addClass("alert alert-success")
            .html(data);
          $("#updateClient").modal("show");
          view_client_record();
          view_client_inactif_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function update_client_part_record() {
  $(document).on("click", "#btn_update_part", function () {
    $("#updateClientPart").scrollTop(0);
    var updateclientIDPart = $("#up_idclientPart").val();
    var updateclientNamePart = $("#up_clientNamePart").val();
    var updateclientEmailPart = $("#up_clientEmailPart").val();
    var updateclientPhonePart = $("#up_clientPhonePart").val();
    var updateclientTypePart = $("#up_ClienttypePart").val();
    var updateclientAdressePart = $("#up_clientAdressePart").val();
    var updatenum_permisPart = $("#up_clientNumPermisPart").val();
    var commentPart = $("#up_commentPart").val();
    var updateclientCINPart = $("#up_clientCINPart").prop("files")[0];
    var updateclientPermisPart = $("#up_clientPermisPart").prop("files")[0];
    var updateclientRIBPart = $("#up_clientRIBPart").prop("files")[0];
    /********************Test Champs obligatoire CLIENT PARTICULIER */
    if (updateclientNamePart == "" ){
      $("#up_message_part").addClass("alert alert-danger").html("Veuillez remplir le Nom Conducteur !");
    } else if (updateclientEmailPart == "" ){
      $("#up_message_part").addClass("alert alert-danger").html("Veuillez remplir l'email !");
    } else if (updateclientPhonePart == "" ){
      $("#up_message_part").addClass("alert alert-danger").html("Veuillez remplir le numéro téléphone !");
    } else if (updateclientAdressePart == "" ){
      $("#up_message_part").addClass("alert alert-danger").html("Veuillez remplir l'adresse !");
    } 
    /********************Test Format Email */
    else if (!isValidEmailAddress(updateclientEmailPart)) {
      $("#up_message_part")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientIDPart);
      form_data.append("nom", updateclientNamePart);
      form_data.append("email", updateclientEmailPart);
      form_data.append("tel", updateclientPhonePart);
      form_data.append("adresse", updateclientAdressePart);
      form_data.append("num_permis", updatenum_permisPart);
      form_data.append("comment", commentPart);
      form_data.append("updateclientType", updateclientTypePart);
      form_data.append("cin", updateclientCINPart);
      form_data.append("permis", updateclientPermisPart);
      form_data.append("rib", updateclientRIBPart);
      $.ajax({
        url: "update_clientpart.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#up_message_part")
            .addClass("alert alert-success")
            .html(data);
          $("#updateClientPart").modal("show");
          view_client_record();
          view_client_inactif_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientFormPart").trigger("reset");
      $("#up_message_part").html("");
      $("#up_message_part").removeClass("alert alert-danger");
      $("#up_message_part").removeClass("alert alert-sucess");
    });
  });
}

function delete_client_record() {
  $(document).on("click", "#btn-delete-client", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteClient").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_client.php",
        method: "post",
        data: {
          Delete_ClientID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteClient").modal("toggle");
          view_client_record();
          view_client_inactif_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteClient', function () {
      Delete_ID = "";
    });
  });
}

/*
 * 
 * 
 */
function view_client_inactif_record() {
  $.ajax({
    url: "viewclientinactif.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#client-inactif-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


/*
 *
 * 
 * 
 */

function insertMaterielRecord() {
  $(document).on("click", "#btn-register-Materiel", function () {
    $("#Registration-Materiel").scrollTop(0);

    var id_materiels = $("#IdMateriel").val();
    var materieldesignation = $("#materieldesignation").val();
    var materielnumserie = $("#materielnumserie").val();
    var quitite = $("#quitite").val();
    var materielagence = $("#materielagence").val();
    const selects_composant = Array.from(
      document.querySelectorAll(".materiel-list-comp")
    );
    const selects_num_composant = Array.from(
      document.querySelectorAll(".materiel-list-num_comp")
    );
    var ComposantListe = selects_composant.map((select) => select.value);
    var NumSerieListe = selects_num_composant.map((select) => select.value);
    if(materielagence == undefined){
      materielagence = "";
    }
    if (
      id_materiels == "" ||
      materieldesignation == "" ||
      materielnumserie == "" ||
      quitite == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutMateriel.php",
        method: "post",
        data: {
          id_materiels: id_materiels,
          materieldesignation: materieldesignation,
          materielnumserie: materielnumserie,
          quitite: quitite,
          materielagence: materielagence,
          ComposantListe: ComposantListe,
          NumSerieListe: NumSerieListe,

        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Materiel").modal("show");
          $("#add-MaterielForm").trigger("reset");
          view_Materiel_record();
          view_stock_materiel_record();
        },
      });
    }
    $(document).on("click", "#btn-close-add-materiel", function () {
      $("#add-MaterielForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function get_materielcomposant_record() {
  $(document).on("click", "#btn-add-composant", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#idmateriel").val(data[0]);
        $("#Registration-Composant-Materiel").modal("show");
      },
    });
  });
}


function insertComposantMaterielRecord() {
  $(document).on("click", "#btn-register-composant-Materiel", function () {
    var id_materiels = $("#idmateriel").val();
    $("#Registration-Composant-Materiel").scrollTop(0);
    const selects_composant = Array.from(
      document.querySelectorAll(".list-composant-materiel")
    );
    const selects_num_composant = Array.from(
      document.querySelectorAll(".list-numserie-composant-materiel")
    );
    var ComposantListe = selects_composant.map((select) => select.value);
    var NumSerieListe = selects_num_composant.map((select) => select.value);
    $.ajax({
      url: "AjoutComposantMateriel.php",
      method: "post",
      data: {
        id_materiels: id_materiels,
        ComposantListe: ComposantListe,
        NumSerieListe: NumSerieListe,
      },
      success: function (data) {
        $("#messagecomp").addClass("alert alert-success").html(data);
        $("#Registration-Composant-Materiel").modal("show");
        $("#add-ComposantMaterielForm").trigger("reset");
        view_Materiel_record();
      },
    });
    $(document).on("click", "#btn-close-add-composant-materiel", function () {
      $("#add-ComposantMaterielForm").trigger("reset");
      $("#messagecomp").html("");
      $("#messagecomp").removeClass("alert alert-danger");
      $("#messagecomp").removeClass("alert alert-sucess");
    });
  });
}

//display materiel record
function view_Materiel_record() {
  $.ajax({
    url: "viewMateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Materiel-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function get_materiel_record() {
  $(document).on("click", "#btn-edit-materiel", function () {
    var ID = $(this).attr("data-id");
    //  alert(ID);
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idmateriel").val(data[0]);
        $("#up_materielNserie").val(data[1]);
        $("#up_materielEtat").val(data[2]);
        $("#up_materielagence").val(data[3]);
        $("#up_materielComposant1").val(data[4]);
        $("#up_materielnumserie1").val(data[5]);
        $("#up_idComposant1").val(data[6]);

        $("#updateMaterielAgence").modal("show");
      },
    });
  });
}

function get_materielstock_record() {
  $(document).on("click", "#btn-edit-materiel-stock", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idMaterielstock").val(data[0]);
        $("#up_EtatMaterielstock").val(data[2]);
        $("#up_materielstockagence").val(data[3]);
        $("#Registration-Materiel-stock").modal("show");
      },
    });
  });
}

// //update materiel
function update_materiel_record() {
  $(document).on("click", "#btn_updated_materiel_agence", function () {
    $("#updateMaterielAgence").scrollTop(0);
    var updateMaterielId = $("#up_idmateriel").val();
    var up_materielEtat = $("#up_materielEtat").val();
    var up_materielagence = $("#up_materielagence").val();
    var updateMaterielNumSerie = $("#up_materielNserie").val();

    if(up_materielagence == undefined){
      up_materielagence = "";
    }
    if (
      updateMaterielNumSerie == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "update_materiel.php",
        method: "post",
        data: {
          updateMaterielId: updateMaterielId,
          up_materielEtat: up_materielEtat,
          updateMaterielNumSerie: updateMaterielNumSerie,
          up_materielagence: up_materielagence,
        },
        success: function (data) {
          $("#up_message")
            .addClass("alert alert-success")
            .html(data);
          $("#updateMaterielAgence").modal("show");
          view_Materiel_record();

        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#MaterielForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function delete_materiel_record() {
  $(document).on("click", "#btn-delete-materiel", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteMateriel").modal("show");

    $(document).on("click", "#btn_delete_materiel_agence", function () {
      $.ajax({
        url: "delete_materiel.php",
        method: "post",
        data: {
          Del_ID: Delete_ID
        },
        success: function (data) {
          $("#delete_messagec").addClass("alert alert-success").html(data);
          $("#deleteMateriel").modal("toggle");
          view_Materiel_record();
          setTimeout(function () {
            if ($("#delete_messagec").length > 0) {
              $("#delete_messagec").remove();
            }
          }, 3000);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteMateriel', function () {
      Delete_ID = "";
    });
  });
}

function get_categorie_record() {
  $(document).on("click", "#btn-edit-categorie", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_categorie_agence_data.php",
      method: "post",
      data: {
        CategorieID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcategorie").val(data[0]);
        $("#up_code_materiel").val(data[1]);
        $("#up_designation").val(data[2]);
        $("#up_famille_materiel").val(data[3]);
        $("#up_type_location").val(data[4]);
        $("#up_num_serie_obg").val(data[5]);

        $("#updateCategorieAgence").modal("show");
      },
    });
  });
}

// //update categorie
function update_categorie_record() {
  $(document).on("click", "#btn_updated_categorie_agence", function () {
    $("#updateCategorieAgence").scrollTop(0);
    var updateCategorieId = $("#up_idcategorie").val();
    var updateCategorieCodemateriel = $("#up_code_materiel").val();
    var updateCategorieDesignation = $("#up_designation").val();
    var updateCategorieFamillemateriel = $("#up_famille_materiel").val();
    var updateCategorieTypelocation = $("#up_type_location").val();
    var updateCategorieNumserie = $("#up_num_serie_obg").val();
    if (
      updateCategorieNumserie == "" || updateCategorieTypelocation == "" 
    ) {
      $("#up_message_categorie")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "update_categorie_materiel.php",
        method: "post",
        data: {
          updateCategorieId: updateCategorieId,
          updateCategorieCodemateriel: updateCategorieCodemateriel,
          updateCategorieDesignation: updateCategorieDesignation,
          updateCategorieFamillemateriel: updateCategorieFamillemateriel,
          updateCategorieTypelocation: updateCategorieTypelocation,
          updateCategorieNumserie: updateCategorieNumserie,
        },
        success: function (data) {
          $("#up_message_categorie")
            .addClass("alert alert-success")
            .html(data);
          $("#updateCategorieAgence").modal("show");
          view_categorie_record();

        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#CategorieForm").trigger("reset");
      $("#up_message_categorie").html("");
      $("#up_message_categorie").removeClass("alert alert-danger");
      $("#up_message_categorie").removeClass("alert alert-sucess");
    });
  });
}

function delete_composant_materiel() {
  $(document).on("click", "#btn-delete-composant", function () {
    var Delete_ID = $(this).attr("data-id");
    $("#deleteComposant").modal("show");
    $(document).on("click", "#btn-delete-composant", function () {
      $.ajax({
        url: "delete_composant_materiel.php",
        method: "post",
        data: {
          Delete_COMPOSANTID: Delete_ID
        },
        success: function (data) {
          $("#delete_messagec").addClass("alert alert-success").html(data);
          $("#deleteComposant").modal("toggle");
          view_Materiel_record();
          setTimeout(function () {
            if ($("#delete_messagec").length > 0) {
              $("#delete_messagec").remove();
            }
          }, 3000);
        },
      });
    });
  });
}



// Afficher voitures
/*
 * 
 */
function view_voiture_record() {
  $.ajax({
    url: "viewvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_voiture_vendue_record() {

  $.ajax({
    url: "viewvoiturevendue.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list-vendue").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },

  });
}

function view_voiture_HS_record() {

  $.ajax({
    url: "viewvoitureHS.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#voiture-list-HS").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },

  });
}

/*
 * 
 */

//Ajouter voitures in the data base
function insert_voiture_Record() {
  $(document).on("click", "#btn-register-voiture", function () {
    $("#Registration-Voiture").scrollTop(0);
    var type = $("#Voituretype").val();
    var pimm = $("#Voiturepimm").val();
    var boite_vitesse = $("#Voitureboitevitesse").val();
    var type_carburant = $("#Voituretypecarburant").val();
    var marqueModele = $("#voitureMarqueModel").val();
    var fournisseur = $("#Voiturefournisseur").val();
    var km = $("#Voiturekm").val();
    var date_achat = $("#Voituredate_achat").val();
    var dispo = "OUI";
    var date_immatriculation = $("#date_immatriculation").val();
    var date_DPC_VGP = $("#date_DPC_VGP").val();
    var date_DPC_VT = $("#date_DPC_VT").val();
    var date_DPT_Pollution = $("#date_DPT_Pollution").val();
    var vgp = $("#vgp").prop("files")[0];
    var carte_grise = $("#carte_grise").prop("files")[0];
    var carte_verte = $("#carte_verte").prop("files")[0];
    var etat_voiture = "Disponible";
    var vehiculeagence = $("#vehiculeagence").val();

    if(vehiculeagence == undefined){
      vehiculeagence = "";
    }
    if (vgp) {
      var verif_file_vgp = "true";
    } else {
      var verif_file_vgp = "false";
    }
    if (carte_verte && carte_grise) {
      var verif_file = "true";
    } else {
      var verif_file = "false";
    }
    if (type == null || pimm == "" || boite_vitesse == null || type_carburant == null || marqueModele == null || km == "" || date_immatriculation == ""){
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if ((type == "CAMION NACELLE" && verif_file_vgp == "false") || (type == "FOURGON NACELLE" && verif_file_vgp == "false")) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir le fichier VGP !");
    } else if (verif_file == "false") {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir les fichiers carte_verte et carte_grise!");
    } else {
      var form_data = new FormData();
      form_data.append("type", type);
      form_data.append("pimm", pimm);
      form_data.append("boite_vitesse", boite_vitesse);
      form_data.append("type_carburant", type_carburant);
      form_data.append("marqueModele", marqueModele);
      form_data.append("fournisseur", fournisseur);
      form_data.append("km", km);
      form_data.append("date_achat", date_achat);
      form_data.append("dispo", dispo);
      form_data.append("date_immatriculation", date_immatriculation);
      form_data.append("date_DPC_VGP", date_DPC_VGP);
      form_data.append("date_DPC_VT", date_DPC_VT);
      form_data.append("date_DPT_Pollution", date_DPT_Pollution);
      form_data.append("vgp", vgp);
      form_data.append("carte_grise", carte_grise);
      form_data.append("carte_verte", carte_verte);
      form_data.append("etat_voiture", etat_voiture);
      form_data.append("vehiculeagence", vehiculeagence);

      $.ajax({
        url: "AjoutVoiture.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture").modal("show");
          } else {
            $("#message").addClass("alert alert-success").html(data);
            $("#Registration-Voiture").modal("show");
            $("#addvoitureForm").trigger("reset");
            view_voiture_record();
            view_stock_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoitureForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

//Ajouter voitures in the data base btn-register-voiture-vendue
function insert_voiture_vendue_Record() {
  $(document).on("click", "#btn-register-voiture-vendue", function () {
    $("#Registration-Voiture-Vendue").scrollTop(0);
    var voitureMarqueModel = $("#voitureMarqueModel").val();
    var Voituredate_vendue = $("#Voituredate_vendue").val();
    var VoitureCommentaire = $("#VoitureCommentaire").val();
    var vehiculevendueagence = $("#vehiculevendueagence").val();
    if(vehiculevendueagence == undefined){
      vehiculevendueagence = "";
    }
    if (
      voitureMarqueModel == "" ||
      Voituredate_vendue == "" ||
      VoitureCommentaire == ""
    ) {
      $("#message-VV")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("voitureMarqueModel", voitureMarqueModel);
      form_data.append("Voituredate_vendue", Voituredate_vendue);
      form_data.append("VoitureCommentaire", VoitureCommentaire);
      form_data.append("vehiculevendueagence", vehiculevendueagence);
      $.ajax({
        url: "AjoutVoitureVendue.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message-VV")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture-Vendue").modal("show");
          } else {
            $("#message-VV").addClass("alert alert-success").html(data);
            $("#Registration-Voiture-Vendue").modal("show");
            $("#addvoiturevoitureForm").trigger("reset");
            view_voiture_vendue_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoiturevoitureForm").trigger("reset");
      $("#message-VV").html("");
      $("#message-VV").removeClass("alert alert-danger");
      $("#message-VV").removeClass("alert alert-sucess");
    });
  });
}


//Ajouter voitures in the data base btn-register-voiture-vendue
function insert_voiture_HS_Record() {
  $(document).on("click", "#btn-register-voiture-HS", function () {
    $("#Registration-Voiture-HS").scrollTop(0);
    var voitureIDHS = $("#voitureIDHS").val();
    var Voituredate_HS = $("#Voituredate_HS").val();
    var VoitureCommentaire = $("#VoitureCommentaire").val();
    var vehiculehsagence  = $("#vehiculehsagence").val();
    if(vehiculehsagence == undefined){
      vehiculehsagence = "";
    }
    if (
      voitureIDHS == "" ||
      Voituredate_HS == "" ||
      VoitureCommentaire == ""
    ) {
      $("#message-HS")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("voitureIDHS", voitureIDHS);
      form_data.append("Voituredate_HS", Voituredate_HS);
      form_data.append("VoitureCommentaire", VoitureCommentaire);
      form_data.append("vehiculehsagence", vehiculehsagence);
      $.ajax({
        url: "AjoutVoitureHS.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message-HS")
              .removeClass("alert alert-success")
              .addClass("alert alert-danger")
              .html(data);
            $("#Registration-Voiture-HS").modal("show");
          } else {
            $("#message-HS").addClass("alert alert-success").html(data);
            $("#Registration-Voiture-HS").modal("show");
            $("#addvoitureHSForm").trigger("reset");
            view_voiture_HS_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#addvoitureHSForm").trigger("reset");
      $("#message-HS").html("");
      $("#message-HS").removeClass("alert alert-danger");
      $("#message-HS").removeClass("alert alert-sucess");
    });
  });
}

//supprimer voiture
function delete_voiture_record() {
  $(document).on("click", "#btn-delete-voiture", function () {
    //  console.log('hee');
    var Delete_ID = $(this).attr("data-id1");
    //  console.log(Delete_ID);
    $("#deleteVoiture").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "DeleteVoiture.php",
        method: "post",
        data: {
          id_voiture: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteVoiture").modal("toggle");
          view_voiture_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteVoiture', function () {
      Delete_ID = "";
    });
  });
}

// get particuler client record
function get_voiture_record() {
  $(document).on("click", "#btn-edit-voiture", function () {
    var ID = $(this).attr("data-id");
    //console.log(ID);  
    $.ajax({
      url: "get_voiture_data.php",
      method: "post",
      data: {
        id_voiture: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Up_Voitureid").val(data[0]);
        $("#up_voitureType").val(data[1]);
        $("#up_voiturePimm").val(data[2]);
        $("#up_voitureMarqueModel").val(data[3]);
        $("#up_voiturefournisseur").val(data[4]);
        $("#up_voiturekm").val(data[5]);
        $("#up_voituredate_achat").val(data[6]);
        $("#up_date_immatriculation").val(data[7]);
        $("#up_date_DPC_VGP").val(data[8]);
        $("#up_date_DPC_VT").val(data[9]);
        $("#up_date_DPT_Pollution").val(data[10]);
        
        $("#up_carte_grise").val();
        $("#updateVoiture").modal("show");
      },
    });
  });
}

// get particuler client record
function get_voiture_vendue_record() {
  $(document).on("click", "#btn-edit-voiture-vendue", function () {
    var ID = $(this).attr("data-id");
    // $("#updateVoitureVendue").modal("show");

    console.log(ID);
    $.ajax({
      url: "get_voiture_vendue_data.php",
      method: "post",
      data: {
        id_voitureH: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#Up_VoitureVendueid").val(data[0]);
        $("#Up_Voituredate_vendue").val(data[1]);
        $("#Up_VoitureCommentaire").val(data[2]);


        $("#updateVoitureVendue").modal("show");
      },
    });
  });
}


// get particuler client record
function get_voiture_HS_record() {
  $(document).on("click", "#btn-edit-voiture-HS", function () {
    var ID = $(this).attr("data-id");
    console.log(ID);
    $.ajax({
      url: "get_voiture_HS_data.php",
      method: "post",
      data: {
        id_voitureH: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#Up_VoitureHSid").val(data[0]);
        $("#Up_VHSid").val(data[1]);
        $("#Up_Voituredate_HS").val(data[2]);
        $("#Up_VoitureCommentaire").val(data[3]);
        $("#up_VoitureHS").val(data[4]);


        $("#updateVoitureHS").modal("show");
      },
    });

  });
}

// Update Record
function update_voiture_record() {
  $(document).on("click", "#btn_update_voiture", function () {
    $("#updateVoiture").scrollTop(0);
    var UpdateID = $("#Up_Voitureid").val();
    var upvoitureType = $("#up_voitureType").val();
    var upvoiturePimm = $("#up_voiturePimm").val();
    var upvoitureModeleMarque = $("#up_voitureMarqueModel").val();
    var upvoiturefournisseur = $("#up_voiturefournisseur").val();
    var upvoiturekm = $("#up_voiturekm").val();
    var upvoituredate_achat = $("#up_voituredate_achat").val();
    var upvoituredispo = 'OUI';
    var up_date_immatriculation = $("#up_date_immatriculation").val();
    var up_date_DPC_VGP = $("#up_date_DPC_VGP").val();
    var up_date_DPT_Pollution = $("#up_date_DPT_Pollution").val();
    var up_etat_voiture = $("#up_etat_voiture").val();
    var up_date_DPC_VT = $("#up_date_DPC_VT").val();
    var updatevgp = $("#up_vgp").prop("files")[0];
    var updatecartegrise = $("#up_carte_grise").prop("files")[0];
    var updatecarteverte = $("#up_carte_verte").prop("files")[0];
    if (updatevgp) {
      var verif_file_vgp = "true";
    } else {
      var verif_file_vgp = "false";
    }
    if ((upvoitureType == "CAMION NACELLE" && verif_file_vgp == "false") || (upvoitureType == "FOURGON NACELLE" && verif_file_vgp == "false")) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir le fichier VGP !");
    }else if (upvoitureType == null || upvoiturePimm == "" || upvoitureModeleMarque == null || upvoiturekm == "" || up_date_immatriculation == "" || upvoituredispo == "") {
      $("#up_message").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoiture").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("id_voiture", UpdateID);
      form_data.append("type", upvoitureType);
      form_data.append("pimm", upvoiturePimm);
      form_data.append("marquemodele", upvoitureModeleMarque);
      form_data.append("fournisseur", upvoiturefournisseur);
      form_data.append("km", upvoiturekm);
      form_data.append("date_achat", upvoituredate_achat);
      form_data.append("dispo", upvoituredispo);
      form_data.append("up_date_immatriculation", up_date_immatriculation);
      form_data.append("up_date_DPC_VGP", up_date_DPC_VGP);
      form_data.append("up_date_DPT_Pollution", up_date_DPT_Pollution);
      form_data.append("up_etat_voiture", up_etat_voiture);
      form_data.append("up_date_DPC_VT", up_date_DPC_VT);
      form_data.append("vgp", updatevgp);
      form_data.append("carte_grise", updatecartegrise);
      form_data.append("carte_verte", updatecarteverte);
      $.ajax({
        url: "UpdateVoiture.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#up_message")
            .addClass("alert alert-success")
            .html(data);
          $("#upvoitureForm").modal("show");
          view_voiture_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

// Update Record
function update_voiture_vendue_record() {
  $(document).on("click", "#btn_update_voiture_vendue", function () {

    $("#updateVoitureVendue").scrollTop(0);
    var UpdateID = $("#Up_VoitureVendueid").val();
    var Up_Voituredate_vendue = $("#Up_Voituredate_vendue").val();
    var Up_VoitureCommentaire = $("#Up_VoitureCommentaire").val();


    if (
      Up_VoitureCommentaire == ""
    ) {
      $("#up_message_vendue").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoitureVendue").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoitureVendue.php",
        method: "POST",
        data: {
          id_voiture_vendue: UpdateID,
          Up_Voituredate_vendue: Up_Voituredate_vendue,
          Up_VoitureCommentaire: Up_VoitureCommentaire,


        },

        success: function () {

          $("#up_message_vendue")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updateVoitureVendue").modal("show");
          view_voiture_vendue_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voiturevendueForm").trigger("reset");
      $("#up_message_vendue").html("");
      $("#up_message_vendue").removeClass("alert alert-danger");
      $("#up_message_vendue").removeClass("alert alert-sucess");
    });
  });
}

// Update Record
function update_voiture_HS_record() {
  $(document).on("click", "#btn_update_voiture_HS", function () {

    $("#updateVoitureHS").scrollTop(0);
    var UpdateID = $("#Up_VoitureHSid").val();
    var Up_Voituredate_HS = $("#Up_Voituredate_HS").val();
    var Up_VoitureCommentaire = $("#Up_VoitureCommentaire").val();
    var up_VoitureHS = $("#up_VoitureHS").val();
    var Up_VHSid = $("#Up_VHSid").val();


    if (
      Up_VoitureCommentaire == ""
    ) {
      $("#up_message_HS").html("Veuillez remplir tous les champs obligatoires !");
      $("#updateVoitureHS").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoitureHS.php",
        method: "POST",
        data: {
          id_voiture_HS: UpdateID,
          Up_Voituredate_HS: Up_Voituredate_HS,
          Up_VoitureCommentaire: Up_VoitureCommentaire,
          up_VoitureHS: up_VoitureHS,
          Up_VHSid: Up_VHSid,


        },

        success: function () {

          $("#up_message_HS")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updateVoitureHS").modal("show");
          view_voiture_HS_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureHSForm").trigger("reset");
      $("#up_message_HS").html("");
      $("#up_message_HS").removeClass("alert alert-danger");
      $("#up_message_HS").removeClass("alert alert-sucess");
    });
  });
}

function insertEntretienRecord() {
  $(document).on("click", "#btn-register-Entretien", function () {
    $("#Registration-Entretien").scrollTop(0);

    var ObjetEntretien = $("#ObjetEntretien").val();
    var LieuEntretien = $("#LieuEntretien").val();
    var CoutEntretien = $("#CoutEntretien").val();
    var Entretiendate = $("#Entretiendate").val();
    var EntretienFindate = $("#EntretienFindate").val();
    var EntretienCommentaire = $("#EntretienCommentaire").val();
    var EntretienType = $("#EntretienType").val();
    var EntretienModelVoiture = $("#EntretienModelVoiture").val();
    var EntretienDateAchatVoiture = $("#EntretienNomMateriel").val();
    var EntretienNomMateriel = $("#EntretienModelMateriel").val();

    // console.log(EntretienDateAchatVoiture);
    if (EntretienType == "" || ObjetEntretien == "" || LieuEntretien == "" || CoutEntretien == "") {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (Entretiendate > EntretienFindate) {
      $("#message")
        .addClass("alert alert-danger")
        .html(" La date de début ne peut pas être postérieure à la date de fin!");

    } else {
      $.ajax({
        url: "AjoutEntretien.php",
        method: "post",
        data: {
          EntretienType: EntretienType,
          Entretiendate: Entretiendate,
          EntretienCommentaire: EntretienCommentaire,
          EntretienModelVoiture: EntretienModelVoiture,
          ObjetEntretien: ObjetEntretien,
          LieuEntretien: LieuEntretien,
          CoutEntretien: CoutEntretien,
          EntretienFindate: EntretienFindate,
          EntretienDateAchatVoiture: EntretienDateAchatVoiture,
          EntretienNomMateriel: EntretienNomMateriel,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Entretien").modal("show");
          $("#EntretienForm").trigger("reset");
          view_Entretien_record_materiel();
          view_Entretien_record();
          load_unseen_notification_entretien();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#EntretienForm").trigger("reset");
      $("#Registration-Entretien").modal("show");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}


function insertInsertControletechniqueRecord() {
  $(document).on("click", "#btn-register-Controle-technique", function () {
    $("#Registration-Controle-technique").scrollTop(0);

    var typeControletechnique = $("#Controlevehiculetype").val();
    var ObjetControletechnique = $("#ObjetControletechnique").val();
    var LieuControletechnique = $("#LieuControletechnique").val();
    var CoutControletechnique = $("#CoutControletechnique").val();
    var Controletechniquedate = $("#Controletechniquedate").val();
    var ControletechniqueFindate = $("#ControletechniqueFindate").val();
    var ProchaineControletechniquedate = $("#ProchaineControletechniquedate").val();
    var ControletechniqueCommentaire = $("#ControletechniqueCommentaire").val();
    var ControletechniqueVoiture = $("#ControletechniqueVoiture").val();

    if (typeControletechnique == "" || ObjetControletechnique == "" || LieuControletechnique == "" || CoutControletechnique == "" || ControletechniqueCommentaire == "" || ControletechniqueVoiture == "" ||
      Controletechniquedate == "" || ControletechniqueFindate == "") {
      $("#message-Controle-technique")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (Controletechniquedate > ControletechniqueFindate) {
      $("#message-Controle-technique")
        .addClass("alert alert-danger")
        .html(" La date de début ne peut pas être postérieure à la date de fin!");

    } else {
      $.ajax({
        url: "AjoutControletechnique.php",
        method: "post",
        data: {
          typeControletechnique: typeControletechnique,
          ObjetControletechnique: ObjetControletechnique,
          LieuControletechnique: LieuControletechnique,
          CoutControletechnique: CoutControletechnique,
          ControletechniqueCommentaire: ControletechniqueCommentaire,
          ControletechniqueVoiture: ControletechniqueVoiture,
          Controletechniquedate: Controletechniquedate,
          ControletechniqueFindate: ControletechniqueFindate,
          ProchaineControletechniquedate: ProchaineControletechniquedate,
        },
        success: function (data) {
          $("#message-Controle-technique").addClass("alert alert-success").html(data);
          $("#Registration-Controle-technique").modal("show");
          $("#EntretienForm").trigger("reset");
          view_Controletechnique_record();
          Type_Controle_dispo();
          searchControleTechnique();
          load_unseen_notification_entretien();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#EntretienForm").trigger("reset");
      $("#Registration-Controle-technique").modal("show");
      $("#message-Controle-technique").html("");
      $("#message-Controle-technique").removeClass("alert alert-danger");
      $("#message-Controle-technique").removeClass("alert alert-sucess");
    });
  });
}

function searchControleTechnique() {
  $("#searchControleTechnique").keyup(function () {
    var search = $(this).val();
    if (search != "") {
      $("#searchTypeControleTechnique").hide();
    } else {
      $("#searchTypeControleTechnique").show();
    }
    $.ajax({
      url: "searchControleTechnique.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Controle-technique-list").html(response);
      },
    });
  });
}

function Type_Controle_dispo() {
  var IDtype_search = $("#Type_Controle_Technique_search").val();
  if (IDtype_search != "0") {
    $("#searchControleTechnique").hide();
  } else {
    $("#searchControleTechnique").show();
  }
  $.ajax({
    url: "searchTypeControleTechnique.php",
    method: "post",
    data: {
      querytype: IDtype_search,
    },
    success: function (response) {
      $("#Controle-technique-list").html(response);
    },
  });
}


function view_Entretien_record() {
  $.ajax({
    url: "viewentretien.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_Controletechnique_record() {
  $.ajax({
    url: "viewControletechnique.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Controle-technique-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_controle_historique() {
  $.ajax({
    url: "viewcontrolehistorique.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#historique-controle-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function searchHistoriqueControle() {
  $("#searchhistoriquecontrole").keyup(function () {
    var search = $(this).val();
    if (search != "") {
      $("#searchusermodifcontrole").hide();
    } else {
      $("#searchusermodifcontrole").show();
    }
    $.ajax({
      url: "searchhistoriquecontrole.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#historique-controle-list").html(response);
      },
    });
  });
}

function user_historiquecontrole_dispo() {
  var IDusermodif_controlesearch = $("#user_modif_controle_search").val();
  if (IDusermodif_controlesearch != "0") {
    $("#searchhistoriquecontrole").hide();
  } else {
    $("#searchhistoriquecontrole").show();
  }
  $.ajax({
    url: "searchHistoriqueControleUser.php",
    method: "post",
    data: {
      queryuser: IDusermodif_controlesearch,
    },
    success: function (response) {
      $("#historique-controle-list").html(response);
    },
  });
}



//view entretien record  DisplayEntretienRecordMateriel
function view_Entretien_record_materiel() {
  $.ajax({
    url: "viewentretienmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list-Materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_Entretien_record_voiture() {
  $.ajax({
    url: "viewentretienvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Entretien-list-voiture").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_entretien_historique() {
  $.ajax({
    url: "viewentretienhistorique.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#historique-entretien").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function get_Entretien_record() {
  $(document).on("click", "#btn-edit-Entretien", function () {
    var ID = $(this).attr("data-id");

    // console.log("hello");
    $.ajax({
      url: "get_entretien_data.php",
      method: "post",
      data: {
        EntretienID: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#up_identretien").val(data[0]);
        $("#up_EntretienType").val(data[1]);
        $("#up_Entretiendate").val(data[2]);
        $("#up_EntretienCommentaire").val(data[3]);
        $("#up_EntretienIdVoiture").val(data[5]);
        $("#up_ObjetEntretien").val(data[7]);
        $("#up_LieuEntretien").val(data[8]);
        $("#up_CoutEntretien").val(data[9]);
        $("#up_EntretiendateFin").val(data[10]);

        $("#updateEntretien").modal("show");
      },
    });
  });
}

function update_entretien_record() {
  $(document).on("click", "#btn_updated_Entretien", function () {
    var updateEntretienId = $("#up_identretien").val();
    var up_ObjetEntretien = $("#up_ObjetEntretien").val();
    var up_LieuEntretien = $("#up_LieuEntretien").val();
    var up_CoutEntretien = $("#up_CoutEntretien").val();
    var updateEntretienDate = $("#up_Entretiendate").val();
    var up_EntretiendateFin = $("#up_EntretiendateFin").val();
    var updateEntretienCommentaire = $("#up_EntretienCommentaire").val();
    var up_EntretienIdVoiture = $("#up_EntretienIdVoiture").val();
    var up_VoitureEntretien = $("#up_VoitureEntretien").val();

    if (up_ObjetEntretien == "" || up_LieuEntretien == "" || up_CoutEntretien == "") {
      $("#up-message").html("please fill in the blanks");
      $("#updateEntretien").modal("show");
    } else {
      $.ajax({
        url: "update_entretien.php",
        method: "post",
        data: {
          up_dateEntretienId: updateEntretienId,
          up_dateEntretienDate: updateEntretienDate,
          up_dateEntretienCommentaire: updateEntretienCommentaire,
          up_EntretienIdVoiture: up_EntretienIdVoiture,
          up_ObjetEntretien: up_ObjetEntretien,
          up_LieuEntretien: up_LieuEntretien,
          up_CoutEntretien: up_CoutEntretien,
          up_EntretiendateFin: up_EntretiendateFin,
          up_VoitureEntretien: up_VoitureEntretien,
        },
        success: function (data) {
          $("#up_message").addClass("alert alert-success").html(data);
          $("#updateEntretien").modal("show");
          view_Entretien_record();
          view_Entretien_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close-up", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function get_Entretien_mecanicien_record() {
  $(document).on("click", "#btn-edit-Entretien-mecanicien", function () {
    var ID = $(this).attr("data-id3");

    // console.log("hello");
    $.ajax({
      url: "get_entretien_data.php",
      method: "post",
      data: {
        EntretienID: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#up_identretien").val(data[0]);
        $("#up_EntretienCommentaireIntervenantMecanicien").val(data[4]);
       

        $("#updateEntretienMecanicien").modal("show");
      },
    });
  });
}

function update_entretien_mecanicien_record() {
  $(document).on("click", "#btn_updated_EntretienMecanicien", function () {
    var updateEntretienId = $("#up_identretien").val();
    var updateEntretienCommentaireIntervenant = $("#up_EntretienCommentaireIntervenantMecanicien").val();

    $.ajax({
      url: "update_entretien_mecanicien.php",
      method: "post",
      data: {
        up_dateEntretienId: updateEntretienId,
        updateEntretienCommentaireIntervenant: updateEntretienCommentaireIntervenant,
      },
      success: function (data) {
        $("#up_message_mecanicien").addClass("alert alert-success").html(data);
        
        view_Entretien_record();
        view_Entretien_record_materiel();
        setTimeout(function () {
          if ($("#up_message_mecanicien").length > 0) {
            $("#up_message_mecanicien").remove();
          }
        }, 2500);
        $("#updateEntretienMecanicien").modal("toggle");
      },
    });

    $(document).on("click", "#btn-close-up", function () {
      $("#updateEntretienMecanicienForm").trigger("reset");
      $("#up_message_mecanicien").html("");
      $("#up_message_mecanicien").removeClass("alert alert-danger");
      $("#up_message_mecanicien").removeClass("alert alert-sucess");
    });
  });
}

//supprimer entretien
function delete_entretien_record() {
  $(document).on("click", "#btn-delete-Entretien", function () {
    // console.log("hee");
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteEntretien").modal("show");
    $(document).on("click", "#btn_delete_Entretien", function () {
      $.ajax({
        url: "DeleteEntretien.php",
        method: "post",
        data: {
          id_entretien: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteEntretien").modal("toggle");
          view_Entretien_record_materiel();
          view_Entretien_record();
          load_unseen_notification_entretien();
          // load_unseen_notification_entretien();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteEntretien', function () {
      Delete_ID = "";
    });
  });
}

function realisation_entretien_record() {
  $(document).on("click", "#btn-confirmation-Entretien", function () {
    var RealisationEntretien_ID = $(this).attr("data-id2");
    $("#realisationEntretien").modal("show");
    $(document).on("click", "#btn_realisation_Entretien", function () {
      $.ajax({
        url: "RealisationEntretien.php",
        method: "post",
        data: {
          RealisationEntretien_ID: RealisationEntretien_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#realisationEntretien").modal("toggle");
          view_Entretien_record_voiture();
          load_unseen_notification_entretien();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#realisationEntretien', function () {
      RealisationEntretien_ID = "";
    });
  });
}



//supprimer entretien
function delete_Controletechnique_record() {
  $(document).on("click", "#btn-delete-Controletechnique", function () {
    // console.log("hee");
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteControleTechnique").modal("show");
    $(document).on("click", "#btn_delete_Controletechnique", function () {
      $.ajax({
        url: "DeleteControletechnique.php",
        method: "post",
        data: {
          id_entretien: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteControleTechnique").modal("toggle");
          // view_Entretien_record_materiel();
          view_Controletechnique_record();
          Type_Controle_dispo();
          searchControleTechnique();
          load_unseen_notification_entretien();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteControletechnique', function () {
      Delete_ID = "";
    });
  });
}

function get_Controle_technique_record() {
  $(document).on("click", "#btn-edit-Controletechnique", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_Controle_technique_data.php",
      method: "post",
      data: {
        ControleTechniqueID: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#up_idcontroletechnique").val(data[0]);
        $("#up_Controle_technique_Commentaire").val(data[1]);
        $("#up_controledate").val(data[3]);
        $("#updateControleTechnique").modal("show");
      },
    });
  });
}

function update_Controle_technique_record() {
  $(document).on("click", "#btn_updated_controle_technique", function () {
    var up_Id_Controle_technique = $("#up_idcontroletechnique").val();
    var up_Commentaire_Controle_technique = $("#up_Controle_technique_Commentaire").val();
    var up_date_Controle_technique = $("#up_controledate").val();

    if (up_Commentaire_Controle_technique == "" || up_date_Controle_technique == "") {
      $("#up_messageCT").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      $("#updateControleTechnique").modal("show");
    } else {
      $.ajax({
        url: "update_Controle_technique.php",
        method: "post",
        data: {
          up_Id_Controle_technique: up_Id_Controle_technique,
          up_Commentaire_Controle_technique: up_Commentaire_Controle_technique,
          up_date_Controle_technique: up_date_Controle_technique,
        },
        success: function (data) {
          $("#up_messageCT").addClass("alert alert-success").html(data);
          $("#updateControleTechnique").modal("show");
          view_Controletechnique_record();
          Type_Controle_dispo();
          searchControleTechnique();
          setTimeout(function () {
            if ($("#up_messageCT").length > 0) {
              $("#up_messageCT").remove();
            }
          }, 2500);
          $("#updateControleTechnique").modal("toggle");
        },
      });
    }
    $(document).on("click", "#btn-close-up", function () {
      $("#updateControleTechnique").trigger("reset");
      $("#up_messageCT").html("");
      $("#up_messageCT").removeClass("alert alert-danger");
      $("#up_messageCT").removeClass("alert alert-sucess");
    });
  });
}

function get_Controle_technique_mecanicien_record() {
  $(document).on("click", "#btn-edit-mecanicien-Controletechnique", function () {
    var ID = $(this).attr("data-id3");
    $.ajax({
      url: "get_Controle_technique_data.php",
      method: "post",
      data: {
        ControleTechniqueID: ID
      },
      dataType: "JSON",
      success: function (data) {

        $("#up_idcontroletechniquemec").val(data[0]);
        $("#up_Controle_techniquemec_Commentaire_interv").val(data[2]);
        $("#updateControleTechniqueMecanicien").modal("show");
      },
    });
  });
}

function update_Controle_technique_mecanicien_record() {
  $(document).on("click", "#btn_updated_controle_technique_mecanicien", function () {
    var up_Id_Controle_technique_mec = $("#up_idcontroletechniquemec").val();
    var up_Commentaire_Controle_technique_mec_interv = $("#up_Controle_techniquemec_Commentaire_interv").val();

    $.ajax({
      url: "update_Controle_technique_mecanicien.php",
      method: "post",
      data: {
        up_Id_Controle_technique_mec: up_Id_Controle_technique_mec,
        up_Commentaire_Controle_technique_mec_interv: up_Commentaire_Controle_technique_mec_interv,
      },
      success: function (data) {
        $("#up_messageCTmeca").addClass("alert alert-success").html(data);
        setTimeout(function () {
            $("#up_messageCTmeca").remove();
        }, 2500);
        $("#updateControleTechniqueMecanicien").modal("toggle");
        view_Controletechnique_record();
        Type_Controle_dispo();
        searchControleTechnique();
      },
    });

    $(document).on("click", "#btn-close-up", function () {
      $("#updateControleTechniqueMecanicien").trigger("reset");
      $("#up_messageCTmeca").html("");
      $("#up_messageCTmeca").removeClass("alert alert-danger");
      $("#up_messageCTmeca").removeClass("alert alert-sucess");
    });
  });
}

//supprimer entretien
function realisation_Controletechnique_record() {
  $(document).on("click", "#btn-confirmation-Controletechnique", function () {
    var Realisation_ID = $(this).attr("data-id2");
    $("#realisationControleTechnique").modal("show");
    $(document).on("click", "#btn_realisation_Controletechnique", function () {
      $.ajax({
        url: "RealisationControletechnique.php",
        method: "post",
        data: {
          Realisation_ID: Realisation_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#realisationControleTechnique").modal("toggle");
          view_Controletechnique_record();
          Type_Controle_dispo();
          searchControleTechnique();
          load_unseen_notification_entretien();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#realisationControleTechnique', function () {
      Realisation_ID = "";
    });
  });
}

// Afficher contrats

function view_contrat_record_materiel() {

  $.ajax({
    url: "viewcontratmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-materiel").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },

  });
}

function view_contrat_record_voiture() {
  $.ajax({
    url: "viewcontratvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-voiture").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_contrat_archivage_record_voiture() {
  $.ajax({
    url: "viewcontratarchivagevoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-voiture-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_contrat_archivage_record_materiel() {
  $.ajax({
    url: "viewcontratarchivagemateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-materiel-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_contrat_archivage_record_pack() {
  $.ajax({
    url: "viewcontratarchivagepack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-pack-archivage").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_contrat_record_pack() {
  $.ajax({
    url: "viewcontratpack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-pack").html(data.html);
          //  load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function view_contrat_historique() {
  $.ajax({
    url: "viewcontrathistorique.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-modification-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function get_Contrat_Pack_record() {
  $(document).on("click", "#btn-edit-contrat-pack", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_contrat_pack_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateDebutContrat").val(data[1]);
        $("#up_DateFinContrat").val(data[2]);
        $("#up_dureeContrat").val(data[3]);
        $("#up_PrixContrat").val(data[4]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_DatePrelevementContrat").val(data[8]);
        $("#up_NbreKilometreContrat").val(data[9]);
        $("#up_moyenCaution").val(data[10]);
        $("#up_numCautionCBMateriel").val(data[11]);
        $("#up_Caution").val(data[5]);
        $("#up_numCautionMateriel").val(data[6]);
        $("#up_Cautioncheque").val(data[12]);
        $("#update-Contrat-pack").modal("show");
        view_contrat_record_pack();
      },
    });
  });
}


//add contrats in the data base

function insertContratVoitureRecord() {
  $(document).on("click", "#btn-register-contrat-voiture", function () {
    $("#Registration-Contrat-Voiture").scrollTop(0);
    var type = $("#Contrattype").val();
    var TypeContrat = 'Vehicule';
    var ContratDuree = $("#dureeContrat").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContrat").val();
    var ContratAssurence = $("#AssuranceContrat").val();
    var ContratPaiement = $("#ModePaiementContrat").val();
    var ContratDatePaiement = $("#DatePrelevementContrat").val();
    var Contrat_voiture = $("#list_materiel").val();
    var ContratClient = $("#ClientContrat").val();
    var AgenceDepClient = $("#ClientAgenceDep").val();
    var AgenceRetClient = $("#ClientAgenceRet").val();
    var ContratCaution = $("#CautionContrat").val();
    var ContratCautionCheque = $("#CautionContratcheque").val();
    var NbreKilometreContrat = $("#NbreKilometreContrat").val();
    var ContratMoyenCaution = $("#moyenCaution").val();
    var ContratNumCaution = $("#numCaution").val();
    var ContratNumCautionCB = $("#numCautionCB").val();
    var contratvehiculeagence = $("#contratvehiculeagence").val();
    var ContratAvenant = $("#ContratClient").val();
    var ContratAvenantDateDebut = $("#DateDebutContratAvenant").val();
    var ContratAvenantDateFin = $("#DateFinContratAvenant").val();
    var ContratAvenant_voiture = $("#list_materiel_avenant").val();
    if (Contrat_voiture == undefined){
      Contrat_voiture = ContratAvenant_voiture;
    }
    if(contratvehiculeagence == undefined){
      contratvehiculeagence = "";
    }
    if (type == "CONTRAT" && (contratvehiculeagence == null && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" || ContratClient == null || ContratPrixContrat == "" ||
        ContratMoyenCaution == "" || ContratPaiement == "" || Contrat_voiture == null))){
        $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      } else if (type == "CONTRAT" && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" || ContratClient == null || ContratPrixContrat == "" ||
          ContratMoyenCaution == "" || ContratPaiement == "" || Contrat_voiture == null || NbreKilometreContrat == "")){
          $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }
      else if (type == "CONTRAT" && (ContratDateDebut > ContratDateFin)) {
          $("#messagevoiture").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
    
    }else if (type == "CONTRAT AVENANT" && (ContratAvenant == null && (ContratAvenantDateDebut == "" || ContratAvenantDateFin == ""))){
        $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
        } else if (type == "CONTRAT AVENANT" && (Contrat_voiture == null || ContratAvenantDateDebut == "" || ContratAvenantDateFin == "")){
            $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
        }
        else if (type == "CONTRAT AVENANT" && (ContratAvenantDateDebut > ContratAvenantDateFin)) {
            $("#messagevoiture").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
    
    }else {
      $.ajax({
        url: "AjoutContratVoiture.php",
        method: "post",
        data: {
          typecontratavenant: type,
          TypeContrat: TypeContrat,
          ContratDuree: ContratDuree,
          ContratDateDebut: ContratDateDebut,
          ContratDateFin: ContratDateFin,
          ContratAssurence: ContratAssurence,
          ContratPrixContrat: ContratPrixContrat,
          ContratPaiement: ContratPaiement,
          ContratDatePaiement: ContratDatePaiement,
          Contrat_voiture: Contrat_voiture,
          ContratClient: ContratClient,
          AgenceDepClient: AgenceDepClient,
          AgenceRetClient: AgenceRetClient,
          ContratCaution: ContratCaution,
          ContratCautionCheque: ContratCautionCheque,
          NbreKilometreContrat: NbreKilometreContrat,
          ContratMoyenCaution: ContratMoyenCaution,
          ContratNumCaution: ContratNumCaution,
          ContratNumCautionCB: ContratNumCautionCB,
          contratvehiculeagence: contratvehiculeagence,
          ContratAvenant: ContratAvenant,
          ContratAvenantDateDebut: ContratAvenantDateDebut,
          ContratAvenantDateFin: ContratAvenantDateFin,
        },
        success: function (data) {
          $("#messagevoiture").addClass("alert alert-success").html(data);
          $("#contratvoitureForm").trigger("reset");
          view_contrat_record_voiture();
          load_unseen_notification();
          load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratvoitureForm").trigger("reset");
      $("#messagevoiture").html("");
      $("#messagevoiture").removeClass("alert alert-danger");
      $("#messagevoiture").removeClass("alert alert-sucess");
    });

  });
}

    
   
function insertContratMaterielRecord() {
  $(document).on("click", "#btn-register-contrat-materiel", function () {
    $("#Registration-Contrat-materiel").scrollTop(0);
    var type = $("#Contrattype").val();
    var ContratNum = $("#NumContrat").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratDuree = $("#dureeContrat").val();
    var ContratClient = $("#ClientContrat").val();
    var ContratAssurence = $("#AssuranceContrat").val();
    var AgenceDepClient = $("#ClientAgenceDep").val();
    var AgenceRetClient = $("#ClientAgenceRet").val();
    var ContratPrixContrat = $("#PrixContrat").val();
    var ContratCaution = $("#CautionContrat").val();
    var ContratCautionCheque = $("#CautionContratcheque").val();
    var ContratNbreKilometre = $("#NbreKilometreContrat").val();
    var moyenCaution = $("#moyenCaution").val();
    var ContratNumCaution = $("#numCautionMateriel").val();
    var ContratNumCautionCB = $("#numCautionCBMateriel").val();
    var ContratPaiement = $("#ModePaiementContrat").val();
    var ContratDatePaiement = $("#DatePrelevementContrat").val();
    var contratmaterielagence = $("#contratmaterielagence").val();
    var Id_materiel = $("#list_materiel").val();
    var ContratAvenant = $("#ContratClient").val();
    var ContratAvenantDateDebut = $("#DateDebutContratAvenant").val();
    var ContratAvenantDateFin = $("#DateFinContratAvenant").val();
    var ContratAvenant_materiel = $("#materielContratAvenant").val();
    console.log(ContratDuree);
    if (Id_materiel == undefined){
      Id_materiel = ContratAvenant_materiel;
    }
    if(contratmaterielagence == undefined){
      contratmaterielagence = "";
    }
    if (type == "CONTRAT" && (contratmaterielagence == null && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" ||
        ContratClient == null || ContratPrixContrat == "" || ContratPaiement == "" || moyenCaution == "" || Id_materiel == null))) {
        $("#message").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires !");
      } else if (type == "CONTRAT" && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" || ContratClient == null ||
        ContratPrixContrat == "" || ContratPaiement == "" || moyenCaution == "" || Id_materiel == null)){
        $("#message").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires !");
      } else if (type == "CONTRAT" && (ContratDateDebut > ContratDateFin)) {
      $("#message").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
    }else if (type == "CONTRAT AVENANT" && (ContratAvenant == null && (ContratAvenantDateDebut == "" || ContratAvenantDateFin == ""))){
      $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if (type == "CONTRAT AVENANT" && (Id_materiel == null || ContratAvenantDateDebut == "" || ContratAvenantDateFin == "")){
          $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if (type == "CONTRAT AVENANT" && (ContratAvenantDateDebut > ContratAvenantDateFin)) {
          $("#messagevoiture").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
    } else {
      $.ajax({
        url: "AjoutContratMateriel.php",
        method: "post",
        data: {
          typecontratavenant: type,
          ContratNum: ContratNum,
          ContratDateDebut: ContratDateDebut,
          ContratDateFin: ContratDateFin,
          AgenceDepClient: AgenceDepClient,
          AgenceRetClient: AgenceRetClient,
          ContratPrixContrat: ContratPrixContrat,
          ContratAssurence: ContratAssurence,
          ContratPaiement: ContratPaiement,
          ContratDatePaiement: ContratDatePaiement,
          ContratClient: ContratClient,
          moyenCaution: moyenCaution,
          ContratCaution: ContratCaution,
          ContratCautionCheque: ContratCautionCheque,
          ContratNbreKilometre: ContratNbreKilometre,
          ContratNumCaution: ContratNumCaution,
          ContratNumCautionCB: ContratNumCautionCB,
          contratmaterielagence: contratmaterielagence,
          ContratDuree: ContratDuree,
          Id_materiel: Id_materiel,
          ContratAvenant: ContratAvenant,
          ContratAvenantDateDebut: ContratAvenantDateDebut,
          ContratAvenantDateFin: ContratAvenantDateFin,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#contratForm").trigger("reset");
          view_contrat_record_materiel();
          load_unseen_notification();
          load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}
//add contrats in the data base

function insertContratRecord() {
  $(document).on("click", "#btn-register-contrat", function () {
    $("#Registration-Contrat").scrollTop(0);


    var ContratDate = $("#DateContrat").val();

    var ContratNum = $("#NumContrat").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContrat").val();
    var ContratAssurence = $("#AssuranceContrat").val();
    var ContratPaiement = $("#ModePaiementContrat").val();
    var ContratDatePaiement = $("#DatePrelevementContrat").val();
    var ContratVoitureModel = $("#VoitureModele").val();
    var ContratVoiturePIMM = $("#VoiturePimm").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevu").val();
    var ContratClient = $("#ClientContrat").val();
    var ContratCaution = $("#CautionContrat").val();
    var ContratNumCaution = $("#numCaution").val();
    var ContratNumCautionMateriel = $("#numCautionMateriel").val();
    var ContratDuree = $("#dureeContrat").val();
    var Id_materiel = $("#list_materiel").val();
    alert(ContratDateDebut);
    //console.log(ContratVoitureModel+"the pimm:"+ContratVoiturePIMM);
    console.log(ClientContrat);

    if (
      ContratDateDebut == "" ||
      ContratDateFin == "" ||
      ContratPrixContrat == "" ||
      ContratPaiement == "" ||
      ContratClient == "" ||
      ContratDate == "" ||
      Id_materiel == undefined ||
      ContratDuree == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "AjoutContratMateriel.php",
        method: "post",
        data: {
          ContratDate: ContratDate,
          ContratNum: ContratNum,
          ContratDateDebut: ContratDateDebut,
          ContratDateFin: ContratDateFin,
          ContratPrixContrat: ContratPrixContrat,
          ContratAssurence: ContratAssurence,
          ContratPaiement: ContratPaiement,
          ContratDatePaiement: ContratDatePaiement,
          ContratVoitureModel: ContratVoitureModel,
          ContratVoiturePIMM: ContratVoiturePIMM,
          ContratVoiturekMPrevu: ContratVoiturekMPrevu,
          ContratClient: ContratClient,
          ContratCaution: ContratCaution,
          ContratNumCaution: ContratNumCaution,
          ContratNumCautionMateriel: ContratNumCautionMateriel,
          ContratDuree: ContratDuree,
          Id_materiel: Id_materiel,
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat").modal("show");
          $("#contratForm").trigger("reset");
          view_contrat_record_materiel();
          view_contrat_record_voiture();
          load_unseen_notification();
          load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}


function get_Contrat_record_signe() {
  $(document).on("click", "#btn-id-client-voiture-signe", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "get_contrat_signe_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontratsigne").val(data[0]);
        $("#contratsigne").val(data[1]);
        $("#Contrat-Voiture-Signe").modal("show");
        view_contrat_record_voiture();
      },
    });
  });
}

function get_ContratMateriel_record_signe() {
  $(document).on("click", "#btn-id-client-materiel-signe", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "get_contrat_signe_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#idcontratsignemateriel").val(data[0]);
        $("#contratsigne").val(data[1]);
        $("#Contrat-Materiel-Signe").modal("show");
        view_contrat_record_materiel();
      },
    });
  });
}

function get_ContratPack_record_signe() {
  $(document).on("click", "#btn-id-client-pack-signe", function () {
    var ID = $(this).attr("data-id4");
    $.ajax({
      url: "get_contrat_signe_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontratsignepack").val(data[0]);
        $("#contratsigne").val(data[1]);
        $("#Contrat-pack-Signe").modal("show");
        view_contrat_record_pack();
      },
    });
  });
}

function get_Contrat_record() {
  $(document).on("click", "#btn-edit-contrat-voiture", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_contrat_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateContratFin").val(data[1]);
        $("#up_ContratType").val(data[2]);
        $("#up_DateContratDebut").val(data[3]);
        $("#up_PrixContrat").val(data[5]);
        $("#up_NbreKilometreContrat").val(data[6]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_Caution").val(data[8]);
        $("#up_DatePrelevementContrat").val(data[9]);
        $("#up_dureeContrat").val(data[10]);
        $("#up_moyenCaution").val(data[11]);
        $("#up_numCaution").val(data[12]);
        $("#up_numCautionCB").val(data[13]);
        $("#up_Cautioncheque").val(data[14]);
        $("#update-Contrat-Voiture").modal("show");
        view_contrat_record_materiel();
        view_contrat_record_voiture();
      },
    });
  });
}

function get_Contrat_Materiel_record() {
  $(document).on("click", "#btn-edit-contrat-materiel", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_contrat_materiel_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontrat").val(data[0]);
        $("#up_DateContratDebut").val(data[3]);
        $("#up_DateContratFin").val(data[1]);
        $("#up_dureeContrat").val(data[10]);
        $("#up_DatePrelevementContrat").val(data[9]);
        $("#up_PrixContrat").val(data[5]);
        $("#up_NbreKilometreContrat").val(data[6]);
        $("#up_ModePaiementContrat").val(data[7]);
        $("#up_Caution").val(data[8]);
        $("#up_CautionMateriel").val(data[8]);
        $("#up_moyenCaution").val(data[11]);
        $("#up_numCaution").val(data[12]);
        $("#up_numCautionCB").val(data[13]);
        $("#up_Cautioncheque").val(data[14]);

        $("#update-Contrat-Materiel").modal("show");
        view_contrat_record_materiel();
      },
    });
  });
}

function get_ContratAvenant_record() {
  $(document).on("click", "#btn-edit-contrat-avenant", function () {
    var ID = $(this).attr("data-id1");
    $.ajax({
      url: "get_contratavenant_data.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idcontratavenant").val(data[0]);
        $("#up_DateContratAvenantDebut").val(data[1]);
        $("#up_DateContratAvenantFin").val(data[2]);
        $("#update-ContratAvenant").modal("show");
        view_contrat_record_materiel();
        view_contrat_record_voiture();
      },
    });
  });
}


function update_contratavenant_record() {
  $(document).on("click", "#btn_updated_ContratAvenant_Voiture", function () {
    $("#update-ContratAvenant").scrollTop(0);
    var updateContratId = $("#up_idcontratavenant").val();
    var up_DateContratDebut = $("#up_DateContratAvenantDebut").val();
    var up_DateContratFin = $("#up_DateContratAvenantFin").val();
    var ContratAvenant_voiture = $("#list_materiel_avenant").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == ""
    ) {
      $("#up_messageavenant_voiture")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-ContratAvenant").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_messageavenant_voiture")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat_avenant.php",
        method: "post",
        data: {
          up_contraId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          ContratAvenant_voiture: ContratAvenant_voiture,
        },
        success: function (data) {
          $("#up_messageavenant_voiture").addClass("alert alert-success").html(data);
          $("#update-ContratAvenant").modal("show");
          view_contrat_record_voiture();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratAvenantForm").trigger("reset");
      $("#up_messageavenant_voiture").html("");
      $("#up_messageavenant_voiture").removeClass("alert alert-danger");
      $("#up_messageavenant_voiture").removeClass("alert alert-sucess");
    });
  });
}

function update_contratavenant_materiel_record() {
  $(document).on("click", "#btn_updated_ContratAvenant_Materiel", function () {
    $("#update-ContratAvenant").scrollTop(0);
    var updateContratId = $("#up_idcontratavenant").val();
    var up_DateContratDebut = $("#up_DateContratAvenantDebut").val();
    var up_DateContratFin = $("#up_DateContratAvenantFin").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == ""
    ) {
      $("#up_messageavenant_materiel")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-ContratAvenant").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_messageavenant_materiel")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat_avenant_materiel.php",
        method: "post",
        data: {
          up_contraId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
        },
        success: function (data) {
          $("#up_messageavenant_materiel").addClass("alert alert-success").html(data);
          $("#update-ContratAvenant").modal("show");
          view_contrat_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratAvenantForm").trigger("reset");
      $("#up_messageavenant_materiel").html("");
      $("#up_messageavenant_materiel").removeClass("alert alert-danger");
      $("#up_messageavenant_materiel").removeClass("alert alert-sucess");
    });
  });
}

function update_contratavenant_pack_record() {
  $(document).on("click", "#btn_updated_ContratAvenant_Pack", function () {
    $("#update-ContratAvenant").scrollTop(0);
    var updateContratId = $("#up_idcontratavenant").val();
    var up_DateContratDebut = $("#up_DateContratAvenantDebut").val();
    var up_DateContratFin = $("#up_DateContratAvenantFin").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == ""
    ) {
      $("#up_messageavenant_pack")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-ContratAvenant").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_messageavenant_pack")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat_avenant_pack.php",
        method: "post",
        data: {
          up_contraId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
        },
        success: function (data) {
          $("#up_messageavenant_pack").addClass("alert alert-success").html(data);
          $("#update-ContratAvenant").modal("show");
          view_contrat_record_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratAvenantForm").trigger("reset");
      $("#up_messageavenant_pack").html("");
      $("#up_messageavenant_pack").removeClass("alert alert-danger");
      $("#up_messageavenant_pack").removeClass("alert alert-sucess");
    });
  });
}


function update_contrat_signe_record() {
  $(document).on("click", "#btn_updated_Contrat_Voiture_Sigen", function () {
    $("#Contrat-Voiture-Signe").scrollTop(0);
    var updateContratId = $("#up_idcontratsigne").val();
    var contratsigne_voiture = $("#contratsigne_voiture").prop("files")[0];
    if (
      updateContratId == "" ||
      contratsigne_voiture == undefined
    ) {
      $("#message_contrat_signe")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#Contrat-Voiture-Signe").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateContratId );
      form_data.append("contratsigne_voiture",contratsigne_voiture );
      $.ajax({
        url: "update_contrat_signe.php",
        method: "post",
        processData: false,
        contentType: false,
       data: form_data,
        success: function (data) {
          $("#message_contrat_signe").addClass("alert alert-success").html(data);
          $("#Contrat-Voiture-Signe").modal("show");
          view_contrat_record_voiture();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratFormSigne").trigger("reset");
      $("#message_contrat_signe").html("");
      $("#message_contrat_signe").removeClass("alert alert-danger");
      $("#message_contrat_signe").removeClass("alert alert-sucess");
    });
  });
}

function update_contratmateriel_signe_record() {
  $(document).on("click", "#btn_updated_Contrat_Materiel_Signe", function () {
    $("#Contrat-materiel-Signe").scrollTop(0);
    var updateContratId = $("#idcontratsignemateriel").val();
    var contratsigne_materiel = $("#contratsignemateriel").prop("files")[0];
   
    if (
      updateContratId == "" ||
      contratsigne_materiel == undefined
    ) {
      $("#message_contratmateriel_signe")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#Contrat-materiel-Signe").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateContratId );
      form_data.append("contratsigne_materiel",contratsigne_materiel );
      $.ajax({
        url: "update_contratmateriel_signe.php",
        method: "post",
        processData: false,
        contentType: false,
       data: form_data,
        success: function (data) {
          $("#message_contratmateriel_signe").addClass("alert alert-success").html(data);
          $("#Contrat-materiel-Signe").modal("show");
          view_contrat_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratMaterielFormSigne").trigger("reset");
      $("#message_contratmateriel_signe").html("");
      $("#message_contrat_signe_materiel").removeClass("alert alert-danger");
      $("#message_contrat_signe_materiel").removeClass("alert alert-sucess");
    });
  });
}

function update_contratpack_signe_record() {
  $(document).on("click", "#btn_updated_Contrat_Pack_Sigen", function () {
    $("#Contrat-pack-Signe").scrollTop(0);
    var updateContratId = $("#up_idcontratsignepack").val();
    var contratsigne_pack = $("#contratsigne_pack").prop("files")[0];
   
    if (
      updateContratId == "" ||
      contratsigne_pack == undefined
    ) {
      $("#message_contrat_signe_pack")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#Contrat-pack-Signe").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateContratId );
      form_data.append("contratsigne_pack",contratsigne_pack );
      $.ajax({
        url: "update_contratpack_signe.php",
        method: "post",
        processData: false,
        contentType: false,
       data: form_data,
        success: function (data) {
          $("#message_contrat_signe_pack").addClass("alert alert-success").html(data);
          $("#Contrat-pack-Signe").modal("show");
          view_contrat_record_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratPackFormSigne").trigger("reset");
      $("#message_contrat_signe_pack").html("");
      $("#message_contrat_signe_pack").removeClass("alert alert-danger");
      $("#message_contrat_signe_pack").removeClass("alert alert-sucess");
    });
  });
}

function update_contrat_record() {
  $(document).on("click", "#btn_updated_Contrat_Voiture", function () {
    $("#update-Contrat-Voiture").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateContratDebut").val();
    var up_DateContratFin = $("#up_DateContratFin").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratType = $("#up_ContratType").val();
    var updateNbreKilometreContrat  = $("#up_NbreKilometreContrat").val();
    var updateContratPaiement = $("#up_ModePaiementContrat").val();
    var up_moyenCaution = $("#up_moyenCaution").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratCautionCheque = $("#up_Cautioncheque").val();
    var updateContratnumCaution = $("#up_numCaution").val();
    var updateContratnumCautionCB = $("#up_numCautionCB").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratPrix == "" ||
      up_moyenCaution == "" ||
      updateNbreKilometreContrat == "" ||
      updateContratPaiement == "" ||
      updateContratType == ""
    ) {
      $("#up_message_voiture")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Voiture").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_message_voiture")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat.php",
        method: "post",
        data: {
          up_contraId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratType: updateContratType,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          up_moyenCaution: up_moyenCaution,
          up_contratCaution: updateContratCaution,
          updateContratCautionCheque: updateContratCautionCheque,
          updateNbreKilometreContrat: updateNbreKilometreContrat,
          updateContratnumCaution: updateContratnumCaution,
          updateContratnumCautionCB: updateContratnumCautionCB,
        },
        success: function (data) {
          $("#up_message_voiture").addClass("alert alert-success").html(data);
          $("#update-Contrat-Voiture").modal("show");
          view_contrat_record_voiture();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_voiture").html("");
      $("#up_message_voiture").removeClass("alert alert-danger");
      $("#up_message_voiture").removeClass("alert alert-sucess");
    });
  });
}

/*
 * update_contrat_record
 * 
 */
function update_contrat_materiel_record() {
  $(document).on("click", "#btn_updated_Contrat_Materiel", function () {
    $("#update-Contrat-Materiel").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateContratDebut").val();
    var up_DateContratFin = $("#up_DateContratFin").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratCautionCheque = $("#up_Cautioncheque").val();
    var updateContratPaiement = $("#up_ModePaiementContrat").val();
    var updateContratMoyenCaution = $("#up_moyenCaution").val();
    var updateContratnumCaution = $("#up_numCaution").val();
    var updateContratnumCautionCB = $("#up_numCautionCB").val();
    var upDatePrelevementContrat = $("#up_DatePrelevementContrat").val();
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratPrix == "" ||
      updateContratMoyenCaution == "" ||
      updateContratPaiement == ""
    ) {
      $("#up_message_materiel").addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Materiel").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_message_materiel")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );

    } else {
      $.ajax({
        url: "update_contrat_materiel.php",
        method: "post",
        data: {
          updateContratId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          up_contratCaution: updateContratCaution,
          updateContratCautionCheque: updateContratCautionCheque,
          updateContratMoyenCaution: updateContratMoyenCaution,
          updateContratnumCaution: updateContratnumCaution,
          updateContratnumCautionCB: updateContratnumCautionCB,
          up_DatePrelevementContrat: upDatePrelevementContrat,
        },
        success: function (data) {
          $("#up_message_materiel").addClass("alert alert-success").html(data);
          $("#update-Contrat-Materiel").modal("show");
          view_contrat_record_materiel();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_materiel").html("");
      $("#up_message_materiel").removeClass("alert alert-danger");
      $("#up_message_materiel").removeClass("alert alert-sucess");
    });
  });
}



function update_contrat_pack_record() {
  $(document).on("click", "#btn_updated_Contrat_Pack", function () {
    $("#update-Contrat-Pack").scrollTop(0);
    var updateContratId = $("#up_idcontrat").val();
    var up_DateContratDebut = $("#up_DateDebutContrat").val();
    var up_DateContratFin = $("#up_DateFinContrat").val();
    var upDureeContrat = $("#up_dureeContrat").val();
    var updateContratPrix = $("#up_PrixContrat").val();
    var updateContratNbreKilometre = $("#up_NbreKilometreContrat").val();
    var updateContratPaiement = $("#up_ModePaiementContrat").val();
    var upDatePrelevementContrat = $("#up_DatePrelevementContrat").val();
    var updateContratmoyenCaution = $("#up_moyenCaution").val();
    var updateContratCaution = $("#up_Caution").val();
    var updateContratnumCaution = $("#up_numCautionMateriel").val();
    var updateContratnumCautionCB = $("#up_numCautionCBMateriel").val();
    var updateContratCautionCheque = $("#up_Cautioncheque").val();
    
    if (
      up_DateContratDebut == "" ||
      up_DateContratFin == "" ||
      upDureeContrat == "" ||
      updateContratNbreKilometre == "" ||
      updateContratmoyenCaution == "" ||
      updateContratPaiement == "" ||
      updateContratPrix == ""
    ) {
      $("#up_message_pack").addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      $("#update-Contrat-Pack").modal("show");
    } else if (up_DateContratDebut > up_DateContratFin) {
      $("#up_message_pack")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      $.ajax({
        url: "update_contrat_pack.php",
        method: "post",
        data: {
          updateContratId: updateContratId,
          up_DateContratDebut: up_DateContratDebut,
          up_DateContratFin: up_DateContratFin,
          upDureeContrat: upDureeContrat,
          up_contratPrix: updateContratPrix,
          up_contratPaiement: updateContratPaiement,
          updateContratNbreKilometre: updateContratNbreKilometre,
          up_DatePrelevementContrat: upDatePrelevementContrat,
          updateContratmoyenCaution: updateContratmoyenCaution,
          updateContratCaution: updateContratCaution,
          updateContratCautionCheque: updateContratCautionCheque,
          updateContratnumCaution: updateContratnumCaution,
          updateContratnumCautionCB: updateContratnumCautionCB, 
        },
        success: function (data) {
          $("#up_message_pack").addClass("alert alert-success").html(data);
          $("#update-Contrat-Pack").modal("show");
          view_contrat_record_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateContratForm").trigger("reset");
      $("#up_message_pack").html("");
      $("#up_message_pack").removeClass("alert alert-danger");
      $("#up_message_pack").removeClass("alert alert-sucess");
    });
  });
}
/*
 * 
 * 
 */

function delete_contrat_record() {
  $(document).on("click", "#btn-delete-contrat-voiture", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContrat").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteContrat").modal("toggle");
          view_contrat_record_voiture();
          view_contrat_archivage_record_voiture();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteContrat', function () {
      Delete_ID = "";
    });
  });
}

function valide_sortie_contrat_record() {
  $(document).on("click", "#btn-valide-sortie-contrat-voiture", function () {
    var Sortie_Voiture_ID = $(this).attr("data-id-sortie-voiture");
    $("#ValideSortieContrat").modal("show");
    $(document).on("click", "#btn_valide_sortie_voiture", function () {
      $.ajax({
        url: "valide_sortie_contrat.php",
        method: "post",
        data: {
          Sortie_ContratID: Sortie_Voiture_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#ValideSortieContrat").modal("toggle");
          view_contrat_record_voiture();
          view_contrat_archivage_record_voiture();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideSortieContrat', function () {
      Sortie_Voiture_ID = "";
    });
  });
}

function valide_retour_contrat_record() {
  $(document).on("click", "#btn-valide-retour-contrat-voiture", function () {
    var Retour_Voiture_ID = $(this).attr("data-id-retour-voiture");
    $("#ValideRetourContrat").modal("show");
    $(document).on("click", "#btn_valide_retour_voiture", function () {
      $.ajax({
        url: "valide_retour_contrat.php",
        method: "post",
        data: {
          Retour_ContratID: Retour_Voiture_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#ValideRetourContrat").modal("toggle");
          view_contrat_record_voiture();
          view_contrat_archivage_record_voiture();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideRetourContrat', function () {
      Retour_Voiture_ID = "";
    });
  });
}

function valide_sortie_contrat_materiel() {
  $(document).on("click", "#btn-valide-sortie-contrat-materiel", function () {
    var Sortie_Materiel_ID = $(this).attr("data-id-sortie-materiel");

    $("#ValideSortieContratMateriel").modal("show");
    $(document).on("click", "#btn_valide_sortie_materiel", function () {
      $.ajax({
        url: "valide_sortie_contrat.php",
        method: "post",
        data: {
          Sortie_ContratID: Sortie_Materiel_ID
        },
        success: function (data) {
          $("#delete_message_materiel").addClass("alert alert-success").html(data);
          $("#ValideSortieContratMateriel").modal("toggle");
          view_contrat_record_materiel();
          view_contrat_archivage_record_materiel();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message_materiel").length > 0) {
              $("#delete_message_materiel").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideSortieContrat', function () {
      Sortie_Materiel_ID = "";
    });
  });
}

function valide_retour_contrat_materiel() {
  $(document).on("click", "#btn-valide-retour-contrat-materiel", function () {
    var Retour_Materiel_ID = $(this).attr("data-id-retour-materiel");
    $("#ValideRetourContratMateriel").modal("show");
    $(document).on("click", "#btn_valide_retour_materiel", function () {
      $.ajax({
        url: "valide_retour_contrat.php",
        method: "post",
        data: {
          Retour_ContratID: Retour_Materiel_ID
        },
        success: function (data) {
          $("#delete_message_materiel").addClass("alert alert-success").html(data);
          $("#ValideRetourContratMateriel").modal("toggle");
          view_contrat_record_materiel();
          view_contrat_archivage_record_materiel();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message_materiel").length > 0) {
              $("#delete_message_materiel").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideRetourContrat', function () {
      Retour_Materiel_ID = "";
    });
  });
}

function valide_sortie_contrat_pack() {
  $(document).on("click", "#btn-valide-sortie-contrat-pack", function () {
    var Sortie_Pack_ID = $(this).attr("data-id-sortie-pack");
    $("#ValideSortieContratPack").modal("show");
    $(document).on("click", "#btn_valide_sortie_pack", function () {
      $.ajax({
        url: "valide_sortie_contrat.php",
        method: "post",
        data: {
          Sortie_ContratID: Sortie_Pack_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#ValideSortieContratPack").modal("toggle");
          view_contrat_record_pack();
          view_contrat_archivage_record_pack();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideSortieContrat', function () {
      Sortie_Pack_ID = "";
    });
  });
}

function valide_retour_contrat_pack() {
  $(document).on("click", "#btn-valide-retour-contrat-pack", function () {
    var Retour_Pack_ID = $(this).attr("data-id-retour-pack");
    $("#ValideRetourContratPack").modal("show");
    $(document).on("click", "#btn_valide_retour_pack", function () {
      $.ajax({
        url: "valide_retour_contrat.php",
        method: "post",
        data: {
          Retour_ContratID: Retour_Pack_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#ValideRetourContratPack").modal("toggle");
          view_contrat_record_pack();
          view_contrat_archivage_record_pack();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#ValideRetourContrat', function () {
      Retour_Pack_ID = "";
    });
  });
}

/** */

function delete_contrat_record_materiel() {
  $(document).on("click", "#btn-delete-contrat-materiel", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContrat").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message_materiel").addClass("alert alert-success").html(data);
          $("#deleteContrat").modal("toggle");
          //  view_contrat_record_voiture();
          view_contrat_record_materiel();
          view_contrat_archivage_record_materiel();
          // load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message_materiel").length > 0) {
              $("#delete_message_materiel").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteContrat', function () {
      Delete_ID = "";
    });
  });
}
/**
 * 
 */


/** */

function delete_contrat_record_pack() {
  $(document).on("click", "#btn-delete-contrat-pack", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContratPack").modal("show");
    $(document).on("click", "#btn_delete_pack", function () {

      $.ajax({
        url: "delete_contrat.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteContratPack").modal("toggle");
          view_contrat_record_pack();
          view_contrat_archivage_record_pack();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteContratPack', function () {
      Delete_ID = "";
    });
  });
}
/**
 * 
 */

function showPDFModel() {
  $(document).on("click", "#btn-show-contrat-voiture", function () {
    var ID = $(this).attr("data-id2");
    $("#PDF-Voiture-modal").modal("show");
    // console.log(ID);
    $.ajax({
      url: "selectContratVoiture.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[18]);
        //depanage de client CIRCET
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }
        $("#Client-mail").text(data[2]);
        console.log(data[3]);
        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Voiture-Category").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Voiture-PIMM").text(data[7]);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        $("#Num-cheque-caution").text(data[17]);
        // do the calc of ttc
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        //$("#Contrat-Mode-Paiement").text(data[11]);
        $("#Contrat-Caution").text(data[12]);
        var date = new Date(data[15]);
        // console.log(date.getDay());
        var day = date.getDate();

        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }
        //$("#Contrat-Date-Prelevement").text(date.getDate());
        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        // $("#kmprevu").text(data[14]);
        $("#PDF-Voiture-modal").modal("show");
      },
    });
  });
}




/**
 * 
 * 
 */


function showPDFModel_materiel() {
  $(document).on("click", "#btn-show-contrat-materiel", function () {
    var ID = $(this).attr("data-id4");
    $("#PDF-Materie-modal").modal("show");
    // console.log(ID);


    $.ajax({
      url: "selectContratMateriel.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {

        //depanage de client CIRCET
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[1]);
        $("#Client-mail").text(data[2]);

        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Contrat-Designation").text(data[5]);
        $("#Contrat-numero").text(data[6]);
        $("#Composant-Designation").text(data[7]);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        $("#Contrat-Mode-Paiement").text(data[11]);
        $("#Contrat-Caution").text(data[12]);
        $("#Contrat-Date").text(data[13]);
        $("#Composant-numero").text(data[14]);
        $("#Contrat-Date-Prelevement").text(data[15]);
        $("#Num-cheque-caution").text(data[16]);
        // do the calc of ttc
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        //$("#Contrat-Mode-Paiement").text(data[11]);
        $("#Contrat-Caution").text(data[12]);
        var date = new Date(data[15]);
        // console.log(date.getDay());
        var day = date.getDate();

        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }
        //$("#Contrat-Date-Prelevement").text(date.getDate());
        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        // $("#kmprevu").text(data[14]);
        $("#PDF-Materie-modal").modal("show");
      },
    });
  });
}

/**
 * 
 * 
 * 
 */


function showPDFPackModel() {
  $(document).on("click", "#btn-show-contrat-pack", function () {
    var ID = $(this).attr("data-id4");

    //alert(ID);
    $.ajax({
      url: "selectContratPack.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        //  alert(data);
        $("#Contrat-number").text(data[0]);
        $("#Client-nom").text(data[1]);
        $("#Client-mail").text(data[2]);
        $("#Client-tel").text(data[3]);
        $("#Client-address").text(data[4]);
        $("#Voiture-PIMM").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Contrat-Date-Debut").text(data[7]);
        $("#Contrat-Date-Fin").text(data[8]);
        $("#Contrat-Prix").text(data[9]);
        $("#Contrat-prix-TTC").text(data[10]);
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }

        $("#Contrat-Date-Prelevement").text(data[12]);
        $("#Contrat-Caution").text(data[13]);
        $("#Num-cheque-caution").text(data[15]);
        $("#Contrat-Date").text(data[17]);

        // alert(data[18]);
        // alert(data[19]);

        console.log(data[21]);

        var materielNamee = "<ul class ='list-unstyled'>";
        data[18].forEach((ee) => {
          materielNamee = materielNamee + `<li>${ee}</li>`;
        });
        materielNamee = materielNamee + "</ul>";
        $("#Materiel-Name").html(materielNamee);
        var SerialNumbers = "<ul class ='list-unstyled'>";
        data[19].forEach((ee) => {
          SerialNumbers = SerialNumbers + `<li>${ee}</li>`;
        });
        SerialNumbers = SerialNumbers + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumbers);
        var kmPervu = data[14];
        var duree = data[16];
        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu 30000 km/an  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/jour  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/semaine  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(
              "Kilométrage prévu " +
              kmPervu +
              " km/mois  (tarification du kilomètre supplémentaire 0.12 €HT)"
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            ) &&
            $("#contrat-kmprevu").text(" ");
        }

        $("#PDF-Voiture-Pack-modal").modal("show");
      },
    });
  });
}

function closeImage() {
  $("#appear_image_div").remove();
}
// id bnt to show materiel contract modal :btn-show-contrat-materiel
function showPDFMaterielModel() {
  $(document).on("click", "#btn-show-contrat-materiel", function () {
    var ID = $(this).attr("data-id4");
    //$("#PDF-Soudeuses-modal").modal("show");

    // console.log(ID);
    $.ajax({
      url: "selectContratMateriel.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-number").text(data[1]);
        $("#Client-Company").text(data[2]);
        $("#Client-Address").text(data[3]);
        $("#Client-Siret").text(data[4]);
        var numCautionMateriel = data[16];
        if (numCautionMateriel == null) {
          $("#Num-cheque-caution-materiel").text(" ");
        } else {
          $("#Num-cheque-caution-materiel").text(data[16]);
        }
        // $("#Materiel-Category").text(data[5]);
        if (data[5] === "SOUDEUSES") {
          $("#changement-electrode").text("- Changement d'électrodes");
        } else {
          $("#changement-electrode").text(" ");
        }
        var materielName = "<ul class ='list-unstyled'>";
        data[6].forEach((e) => {
          materielName = materielName + `<li>${e}</li>`;
        });
        materielName = materielName + "</ul>";
        $("#Materiel-Name").html(materielName);
        var SerialNumber = "<ul class ='list-unstyled'>";
        data[7].forEach((e) => {
          SerialNumber = SerialNumber + `<li>${e}</li>`;
        });
        SerialNumber = SerialNumber + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumber);
        $("#Contrat-Date-Debut").text(data[8].split("-").reverse().join("-"));
        $("#Contrat-Date-Fin").text(data[9].split("-").reverse().join("-"));
        $("#Contrat-Prix").text(data[10]);
        // do the calc of ttc
        $("#Contrat-prix-TTC").text(
          parseFloat(data[10]) + parseFloat(data[10]) * 0.2
        );
        var date = new Date(data[14]);
        // console.log(date.getDay());
        var day = date.getDate();
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }
        var duree = data[15];
        $("#Contrat-Caution").text(data[12]);
        if (!!day && (duree == "Standard" || duree == "LLD")) {
          $("#Contrat-Date-Prelevement").text(
            "le " + day.toString() + " de chaque mois."
          );
        } else {
          $("#Contrat-Date-Prelevement").text(" ");
        }

        if (duree == "Standard") {
          $("#ilpourra").text(
              "Il pourra y être mis fin par chacune des parties à tout moment en adressant un courrier recommandé en respectant un préavis d'un mois."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de :  "
            );
        } else if (duree == "Par Jour") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "Par Semaine") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "Par Mois") {
          $("#ilpourra").text(" ") &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        } else if (duree == "LLD") {
          $("#ilpourra").text(
              "Le locataire a la possibilité pendant toute la durée du contrat de mettre fin à celui-ci en respectant un préavis incompressible d'une semaine (7 jours).Le locataire est redevable des loyers au prorata temporis au termes des sept (7) jours de préavis."
            ) &&
            $("#prix-location").text(
              "euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : "
            );
        }

        $("#Contrat-Date").text(data[13].split("-").reverse().join("-"));
        $("#PDF-Soudeuses-modal").modal("show");
      },
    });
  });
}

/*
 * searchAgence
 */

function searchAgence() {
  $("#searchAgence").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchAgence.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#agence-list").html(response);
      },
    });
  });
}

/*
 *  End searchAgence
 */

/*
 * searchUser
 */

function searchUser() {
  $("#searchUser").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchUser.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#user-list").html(response);
      },
    });
  });
}


function searchClient() {
  $("#searchClientA").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchClient.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#client-list").html(response);
      },
    });
  });
}

function searchClientInactif() {
  $("#searchClientI").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchClientInactif.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#client-inactif-list").html(response);
      },
    });
  });
}


function searchCategorie() {
  $("#searchCategorie").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchCategorie.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Categorie-list").html(response);
      },
    });
  });
}

function searchVoiture() {
  $("#searchVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVehicule.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list").html(response);
      },
    });
  });
}


function searchVoitureVendu() {
  $("#searchVoitureVendu").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoitureVendu.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list-vendue").html(response);
      },
    });
  });
}


function searchVoitureHS() {
  $("#searchVoitureHS").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoitureHS.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#voiture-list-HS").html(response);
      },
    });
  });
}

function searchGestionPack() {
  $("#searchGestionPack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchGestionPack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#group-pack-list").html(response);
      },
    });
  });
}


function searchMaterielAgence() {
  $("#searchMaterielAgence").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Materiel-list").html(response);
      },
    });
  });
}


function searchStock() {
  $("#searchStock").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchStock.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#stock-list").html(response);
      },
    });
  });
}

function searchStockMateriel() {
  $("#searchStockMateriels").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchStockMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (data) {
        $("#stock-list-materiel").html(data.html);    
      },
    });
  });
}

function searchContratVoiture() {
  $("#searchContratVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-voiture").html(response);
      },
    });
  });
}

function searchContratMateriel() {
  $("#searchContratMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-materiel").html(response);
      },
    });
  });
}

function searchContratPack() {
  $("#searchContratPack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratPack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-pack").html(response);
      },
    });
  });
}

function searchHistoriqueContrat() {
  $("#searchhistoriquecontrat").keyup(function () {
    var search = $(this).val();
    if (search != "") {
      $("#searchusermodifcontrat").hide();
    } else {
      $("#searchusermodifcontrat").show();
    }
    $.ajax({
      url: "searchHistoriqueContrat.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-modification-list").html(response);
      },
    });
  });
}

function user_modif_dispo() {
  var IDusermodif_contratsearch = $("#user_modif_contrat_search").val();
  // alert(IDaffectationK2_vehicule);
  if (IDusermodif_contratsearch != "0") {
    $("#searchhistoriquecontrat").hide();
  } else {
    $("#searchhistoriquecontrat").show();
  }
  $.ajax({
    url: "searchHistoriqueUserContrat.php",
    method: "post",
    data: {
      queryuser: IDusermodif_contratsearch,
    },
    success: function (response) {
      $("#contrat-modification-list").html(response);
    },
  });
}
/*
 * searchEntretiens
 */
function searchEntretiens() {
  $("#searchEntretiens").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretiens.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list").html(response);
      },
    });
  });
}

/*
 * end searchEntretiens
 */

function searchEntretienMateriel() {
  $("#searchEntretienMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretienMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list-Materiel").html(response);
      },
    });
  });
}

function searchEntretienVoiture() {
  $("#searchEntretienVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchEntretienVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#Entretien-list-voiture").html(response);
      },
    });
  });
}

// Search Contrat Archivage

function searchContratVoitureArchivage() {
  $("#searchContratVoitureArchivage").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoitureArchivage.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-voiture-archivage").html(response);
      },
    });
  });
}

function searchContratMaterielArchivage() {
  $("#searchContratMaterielArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratMaterielArchivage.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-materiel-archivage").html(response);
      },
    });
  });
}

function searchContratPackArchivage() {
  $("#searchContratPackArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratPackArchivage.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-pack-archivage").html(response);
      },
    });
  });
}

// founction de notification de contrat
function load_unseen_notification(view = "") {
  $.ajax({
    url: "contratnotification.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-contrat").html(data.notification_contrat);
      if (data.unseen_notification > 0) {
        $("#count-contrat").html(data.unseen_notification);
      } else {
        $("#count-contrat").css("display", "none");
      }
    },
  });
}
// fin founction de notification de contrat

function removeNotification() {
  $(document).on("click", "#toggle-contrat", function () {
    $("#count-contrat").html("0").css("display", "none");
    load_unseen_notification("yes");
  });
}

function removeNotification_entretien() {
  $(document).on("click", "#toggle-entretien", function () {
    $("#count-entretien").html("0").css("display", "none");
    load_unseen_notification_entretien("yes");
  });
}

function removeNotification_contratdebut() {
  $(document).on("click", "#toggle-contratdebut", function () {
    $("#count-contratdebut").html("0").css("display", "none");
    load_unseen_notification_contratDebut("yes");
  });
}

function load_unseen_notification_contratDebut(view = "")
{
  $.ajax({
    url: "contratnotificationdebut.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-contratDebut").html(data.notification_contratDebut);
      if (data.unseen_notification_contratDebut > 0) {
        $("#count-contratdebut").html(data.unseen_notification_contratDebut);
      } else {
        $("#count-contratdebut").css("display", "none");
      }
    },
  });
}
//////////////////////////
function load_unseen_notification_entretien(view = "") {
  $.ajax({
    url: "contratnotificationEntretien.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-entretien").html(data.notification_entretien);
      if (data.unseen_notification_entretien > 0) {
        $("#count-entretien").html(data.unseen_notification_entretien);
      } else {
        $("#count-entretien").css("display", "none");
      }
    },
  });
}

function load_unseen_notification_paiement(view = "") {
  $.ajax({
    url: "contratnotificationPaiement.php",
    method: "POST",
    data: {
      view: view
    },
    dataType: "json",
    success: function (data) {
      $("#dropdown-menu-paiement").html(data.notification_paiement);
      if (data.unseen_notification_paiement > 0) {
        $("#count-paiement").html(data.unseen_notification_paiement);
      } else {
        $("#count-paiement").css("display", "none");
      }
    },
  });
}

function insertVoitureSettingRecord() {
  $(document).on("click", "#btn-Setting-Voiture", function () {
    var voitureMarque = $("#Setting_voitureMarque").val();
    var voitureModel = $("#Setting_voitureModele").val();

    if (voitureMarque == "" || voitureModel == "") {
      $("#message-setting")
        .addClass("text-danger")
        .html("Veuillez remplirdd tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutSettingVoiture.php",
        method: "post",
        data: {
          voitureMarque: voitureMarque,
          voitureModel: voitureModel,
        },
        success: function (data) {
          $("#message-setting").addClass("text-success").html(data);
          $("#Setting-Voiture").modal("show");
          $("#setting-voitureForm").trigger("reset");
          view_SettingVoitureRecord();
        },
      });
    }
  });

  $(document).on("click", "#btn-close-voiture_setting", function () {
    $("#setting-voitureForm").trigger("reset");
    $("#message-setting").remove();
  });
}

function view_SettingVoitureRecord() {
  $.ajax({
    url: "viewSettingVoiture.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSetting").html(data.html);
      }
    },
  });
}

function view_SettingVoitureHSRecord() {
  $.ajax({
    url: "viewSettingVoitureHS.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSettingHS").html(data.html);
      }
    },
  });
}


// function view_SettingVoitureTransfRecord() {
//   $.ajax({
//     url: "viewSettingVoitureTransf.php",
//     method: "post",
//     success: function (data) {
//       data = $.parseJSON(data);
//       if (data.status == "success") {
//         $("#tableSettingTransf").html(data.html);
//       }
//     },
//   });
// }



function delete_SettingVoiturerecord() {
  $(document).on("click", "#btn_delete_marque", function () {
    var Delete_ID = $(this).attr("data-id6");
    $.ajax({
      url: "deleteSettingVoitur.php",
      method: "post",
      data: {
        Del_ID: Delete_ID
      },
      success: function (data) {
        view_SettingVoitureRecord();
      },
    });
  });
}

function view_contrat_archived() {

  $.ajax({
    url: "viewcontratArchivedVoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-archived").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },

  });
}

function view_contrat_archived_materiel() {
  $.ajax({
    url: "viewcontratArchivedMateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-archived-materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function searchContratVoitureArchive() {
  $("#searchContratVoitureArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratVoitureArchive.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-archived").html(response);
      },
    });
  });
}

// historique modif contrats
// function view_ModifContratVoitureRecord() {
//   $.ajax({
//     url: "viewSettingVoitureTransf.php",
//     method: "post",
//     success: function (data) {
//       data = $.parseJSON(data);
//       if (data.status == "success") {
//         $("#tableSettingModifContratVoiture").html(data.html);
//       }
//     },
//   });
// }

// function view_ModifContratMaterielRecord() {
//   $.ajax({
//     url: "viewSettingVoitureTransf.php",
//     method: "post",
//     success: function (data) {
//       data = $.parseJSON(data);
//       if (data.status == "success") {
//         $("#tableSettingModifContratMateriel").html(data.html);
//       }
//     },
//   });
// }

// function view_ModifContratPackRecord() {
//   $.ajax({
//     url: "viewSettingVoitureTransf.php",
//     method: "post",
//     success: function (data) {
//       data = $.parseJSON(data);
//       if (data.status == "success") {
//         $("#tableSettingModifContratPack").html(data.html);
//       }
//     },
//   });
// }
// End historique modif contrats

function searchContratMaterielArchive() {
  $("#searchContratMaterielArchive").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchContratMaterielArchive.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#contrat-list-archived-materiel").html(response);
      },
    });
  });
}

function getValidateContratPaiement() {
  $(document).on("click", "#contrat-paiement", function () {
    //  console.log('hee');
    var contrat_ID = $(this).attr("data-paiement");
    console.log(contrat_ID);
    $("#validatePaiementContrat").modal("show");
    $.ajax({
      url: "ValidateContratPaiement.php",
      method: "post",
      data: {
        contrat_ID: contrat_ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#validate-contrat-id").val(data[0]);
        $("#validatePaiementContrat").modal("show");
      },
    });
  });
}

function update_contrat_validate_record() {
  $(document).on("click", "#btn_validatePaiement", function () {
    var updateContratId = $("#validate-contrat-id").val();
    location.reload();
    $.ajax({
      url: "update_validate_paiement_contrat.php",
      method: "post",
      data: {
        updateContratId: updateContratId,
      },
      success: function (data) {
        location.reload();
      },
    });
  });
}
// view contrat record mixte
function view_contrat_record_mixte() {
  $.ajax({
    url: "viewcontratMixte.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#contrat-list-mixte").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },

  });
}
// End view contrat record mixte
// insertContratMixteRecord

function insertContratMixteRecord() {


  $(document).on("click", "#btn-register-contrat-m1", function () {
    $("#Registration-Contrat-mixte").scrollTop(0);
    const selects = Array.from(
      document.querySelectorAll(".materiel-list-contrat-mixte")
    );
    const ContratmaterielListe = selects.map((select) => Number(select.value));
    // var ContratDate = $("#DateContratMixte").val();
    // var ContratType = $("#TypeContratMixte").val();

    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContratMixte").val();
    var ContratAssurence = "K2";
    var ContratPaiement = $("#ModePaiementContratMixte").val();
    // var ContratDatePaiement = $("#DatePrelevementContratMixte").val();
    var ContratDatePaiement = null;
    var ContratVoitureModel = $("#VoitureModeleMixte").val();
    var ContratVoiturePIMM = $("#VoiturePimmMixte").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevuMixte").val();
    var ContratVoiturekMPrevu = null;
    var ContratClient = $("#ClientContratMixte").val();
    var ContratCaution = $("#CautionContratMixte").val();
    var ContratNumCaution = $("#numCautionMixte").val();
    var ContratDuree = $("#dureeContratMixte").val();
    var ContratFileMixte = $("#ControlFileMixte").prop("files")[0] ?
      $("#ControlFileMixte").prop("files")[0] :
      "no file";
    if (
      ContratDate == "" ||
      ContratDateDebut == "" ||
      ContratDateFin == "" ||
      ContratPrixContrat == "" ||
      ContratPaiement == "" ||
      ContratDuree == ""
    ) {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (ContratDateDebut > ContratDateFin) {
      $("#message")
        .addClass("alert alert-danger")
        .html(
          "La date de début ne peut pas être postérieure à la date de fin!"
        );
    } else {
      var form_data = new FormData();
      form_data.append("ContratDate", ContratDate);
      form_data.append("ContratType", ContratType);
      //  form_data.append("ContratNum", ContratNum);
      form_data.append("ContratDateDebut", ContratDateDebut);
      form_data.append("ContratDateFin", ContratDateFin);
      form_data.append("ContratPrixContrat", ContratPrixContrat);
      form_data.append("ContratAssurence", ContratAssurence);
      form_data.append("ContratPaiement", ContratPaiement);
      form_data.append("ContratDatePaiement", ContratDatePaiement);
      form_data.append("ContratVoitureModel", ContratVoitureModel);
      form_data.append("ContratVoiturePIMM", ContratVoiturePIMM);
      form_data.append("ContratVoiturekMPrevu", ContratVoiturekMPrevu);
      form_data.append("ContratmaterielListe", ContratmaterielListe);
      form_data.append("ContratClient", ContratClient);
      form_data.append("ContratCaution", ContratCaution);
      form_data.append("ContratNumCaution", ContratNumCaution);
      // form_data.append("ContratNumCautionMateriel", ContratNumCautionMateriel);
      form_data.append("ContratDuree", ContratDuree);
      form_data.append("ContratFileMixte", ContratFileMixte);

      $.ajax({
        url: "AjoutContratMixte.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat").modal("show");
          $("#contratForm").trigger("reset");
          view_contrat_record_mixte();
          // view_contrat_record_voiture();
          // load_unseen_notification();
          // load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });

  });
}
// end insertContratMixteRecord


function delete_contrat_record_mixte() {
  $(document).on("click", "#btn-delete-contrat-mixte", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteContratMixte").modal("show");
    $(document).on("click", "#btn_delete_mixte", function () {
      $.ajax({
        url: "delete_contrat_mixte.php",
        method: "post",
        data: {
          Delete_ContratID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteContratMixte").modal("toggle");
          view_contrat_record_mixte();
          view_contrat_record_materiel();
          load_unseen_notification();
          //   
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteContratMixte', function () {
      Delete_ID = "";
    });
  });
}


function showPDFMixteModel() {
  $(document).on("click", "#btn-show-contrat-mixte", function () {
    var ID = $(this).attr("data-id2");
    //$("#PDF-Soudeuses-modal").modal("show");
    // $("#PDF-Voiture-Mixte-modal").modal("show");
    //alert(ID);
    $.ajax({
      url: "selectContratMixte.php",
      method: "post",
      data: {
        ContratID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#Contrat-number").text(data[0]);
        $("#Client-Siret").text(data[1]);
        $("#Client-Address").text(data[2]);
        $("#Client-Company").text(data[3]);
        $("#Voiture-PIMM").text(data[4]);
        $("#Voiture-Category").text(data[5]);
        $("#Voiture-Marque").text(data[6]);
        $("#Contrat-Date-Debut").text(data[7]);
        $("#Contrat-Date-Fin").text(data[8]);
        $("#Contrat-Prix").text(data[9]);
        $("#Contrat-prix-TTC").text(data[10]);
        var ModePaiementContrat = data[11];
        if (ModePaiementContrat == "Virements bancaires") {
          $("#Contrat-Mode-Paiement").text(
            "Des Virements bancaires seront effectués "
          );
        } else if (ModePaiementContrat == "Carte bancaire") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements par carte bancaire seront effectués "
          );
        } else if (ModePaiementContrat == "Prélèvements automatiques") {
          $("#Contrat-Mode-Paiement").text(
            "Des prélèvements automatiques seront effectués  "
          );
        } else if (ModePaiementContrat == "Espèces") {
          $("#Contrat-Mode-Paiement").text(
            "Des paiements en espèces seront effectués "
          );
        } else {
          $("#Contrat-Mode-Paiement").text("Chèque");
        }

        $("#Contrat-Date-Prelevement").text(data[12]);
        $("#Contrat-Caution").text(data[13]);
        $("#Num-cheque-caution").text(data[15]);
        $("#Contrat-Date").text(data[17]);

        // alert(data[18]);
        // alert(data[19]);

        console.log(data[21]);

        var materielNamee = "<ul class ='list-unstyled'>";
        data[18].forEach((ee) => {
          materielNamee = materielNamee + `<li>${ee}</li>`;
        });
        materielNamee = materielNamee + "</ul>";
        $("#Materiel-Name").html(materielNamee);
        var SerialNumbers = "<ul class ='list-unstyled'>";
        data[19].forEach((ee) => {
          SerialNumbers = SerialNumbers + `<li>${ee}</li>`;
        });
        SerialNumbers = SerialNumbers + "</ul>";
        $("#Materiel-Num-Serie").html(SerialNumbers);
        $("#PDF-Voiture-Mixte-modal").modal("show");
      },
    });
  });
}
//contrat pack
function get_Mixte_record() {
  $(document).on("click", "#btn-edit-contrat-pack", function () {
    var ID = $(this).attr("data-id3");
    $("#update-Contrat-Pack").modal("show");
  });
}



//  =======================================================================
//                                   user
//  =======================================================================

//insert Record in the data base 

function insertUserRecord() {
  $(document).on("click", "#btn-register-user", function () {
    $("#Registration-User").scrollTop(0);
    var typeuser = $("#roletype").val();
    var nom = $("#userName").val();
    var login = $("#userLogin").val();
    var email = $("#userEmail").val();
    var passord = $("#userPassword").val();
    var id_user_agence = $("#UserAgence").val();
    if (typeuser == "responsable" && (nom == "" || login == "" || id_user_agence == "" || passord == "")) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if (nom == "" || login == "" || passord == "") {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("typeuser", typeuser);
      form_data.append("nom", nom);
      form_data.append("login", login);
      form_data.append("email", email);
      form_data.append("passord", passord);
      form_data.append("id_user_agence", id_user_agence);
      $.ajax({
        url: "AjoutUser.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-User").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-User").modal("show");
            $("#userForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            view_user_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#userForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_user_record() {
  $.ajax({
    url: "viewuser.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#user-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

/*
 */
function view_stock_record() {
  $.ajax({
    url: "selectVoiteurDispoStock1.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#stock-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}
/*
 * 
 */


function get_stock_voiture() {
  $(document).on("click", "#btn-transfert", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_voiture_data.php",
      method: "post",
      data: {
        id_voiture: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idvoiture").val(data[0]);
        $("#up_voitureAgence").val(data[14]);

        $("#updatevoiturestock").modal("show");
      },
    });

  });
}

function get_stock_material() {
  $(document).on("click", "#btn-transfert-materiel", function () {

    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idmaterial").val(data[0]);
        $("#up_materialagence").val(data[3]);

        $("#updatematerialestock").modal("show");
      },
    });

  });
}

function get_stock_material_quantite() {
  $(document).on("click", "#btn-transfert-materiel-quantite", function () {

    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_materiel_agence_data.php",
      method: "post",
      data: {
        MaterielID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idmaterialquantite").val(data[0]);
        $("#quititematerialquantite").val(data[4]);
        $("#up_materialquantiteagence").val(data[3]);

        $("#updatematerialestockquantite").modal("show");
      },
    });

  });
}



// Update Record
function update_voiture_stock_record() {
  $(document).on("click", "#btn_update_voiture_stock", function () {
    $("#updatevoiturestock").scrollTop(0);
    var UpdateID = $("#up_idvoiture").val();
    var up_voitureAgence = $("#up_voitureAgence").val();

    if (up_voitureAgence == null) {
      $("#up_message").html("Veuillez  Agence obligatoires !");
      $("#updatevoiturestock").modal("show");
    } else {
      $.ajax({
        url: "UpdateVoiturestock.php",
        method: "POST",
        data: {
          id_voiture: UpdateID,
          up_voitureAgence: up_voitureAgence,

        },
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le véhicule est modifié avec succès");
          $("#updatevoiturestock").modal("show");
          view_stock_record()
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-voitureForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function update_materiel_stock_record() {
  $(document).on("click", "#btn_update_materiel_stock", function () {
    $("#updatematerialestock").scrollTop(0);
    var UpdateID = $("#up_idmaterial").val();
    var up_materialagence = $("#up_materialagence").val();

    if (up_materialagence == null) {
      $("#up_message").html("Veuillez  Agence obligatoires !");
      $("#updatematerialestock").modal("show");
    } else {
      $.ajax({
        url: "UpdateMaterialstock.php",
        method: "POST",
        data: {
          id_materiel: UpdateID,
          up_materialagence: up_materialagence,

        },
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le matériel est modifié avec succès");
          $("#updatematerialestock").modal("show");
          view_stock_materiel_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-materialForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

function update_materiel_stock_quantite_record() {
  $(document).on("click", "#btn_update_materiel_stock_quantite", function () {
    $("#updatematerialestockquantite").scrollTop(0);
    var UpdateID = $("#up_idmaterialquantite").val();
    var up_materialagence = $("#up_materialquantiteagence").val();
    var up_quantitemateriel = $("#quititematerialquantite").val();
    if (up_materialagence == null) {
      $("#up_messagequantite").html("Veuillez  Agence obligatoires !");
      $("#updatematerialestockquantite").modal("show");
    } else {
      $.ajax({
        url: "UpdateMaterialquantitestock.php",
        method: "POST",
        data: {
          id_materiel: UpdateID,
          up_materialagence: up_materialagence,
          up_quantitemateriel: up_quantitemateriel,
        },
        success: function (data) {
            $("#up_messagequantite").addClass("alert alert-success").html(data);
            view_stock_materiel_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-materialForm").trigger("reset");
      $("#up_messagequantite").html("");
      $("#up_messagequantite").removeClass("alert alert-danger");
      $("#up_messagequantite").removeClass("alert alert-sucess");
    });
  });
}
/*
 * 
 * 
 * 
 */
function view_stock_Q_record() {
  //alert('bilel555');
  $.ajax({
    // url: "viewstock.php",
    url: "selectVoiteurDispoStock.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#stock-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function view_stock_materiel_record() {
  $.ajax({
    url: "selectMaterielQtiDispo.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {

          $("#stock-list-materiel").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}
// get particuler user record
function get_user_record() {
  $(document).on("click", "#btn-edit-user", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_user_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_iduser").val(data[0]);
        $("#up_userName").val(data[1]);
        $("#up_userLogin").val(data[2]);
        // $("#up_userPassword").val(data[3]);
        $("#updateuseretat").val(data[4]);
        $("#up_userEmail").val(data[5]);
        $("#updateUser").modal("show");

      },
    });
  });
}

// update  user record
function update_user_record() {
  $(document).on("click", "#btn_update_user", function () {
    $("#updateUser").scrollTop(0);
    var updateuserID = $("#up_iduser").val();
    var updateuserName = $("#up_userName").val();
    var updateuserLogin = $("#up_userLogin").val();
    var updateuserPassword = $("#up_userPassword").val();
    var updateuseretat = $("#updateuseretat").val();
    var updateuserEmail = $("#up_userEmail").val();
    if (
      updateuserID == "" ||
      updateuserName == "" ||
      updateuserLogin == "" ||
      updateuserEmail == "" ||
      updateuserPassword == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateUser").modal("show");
    }else if (!isValidEmailAddress(updateuserEmail)) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("le champ « email » est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateuserID);
      form_data.append("nom", updateuserName);
      form_data.append("login", updateuserLogin);
      form_data.append("password", updateuserPassword);
      form_data.append("updateuseretat", updateuseretat);
      form_data.append("email", updateuserEmail);

      $.ajax({
        url: "update_user.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,

        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le utilisateur est modifié avec succès");
          $("#updateUser").modal("show");
          view_user_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-userForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}


function delete_user_record() {
  $(document).on("click", "#btn-delete-user", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteUser").modal("show");
    $(document).on("click", "#btn_delete_user", function () {
      $.ajax({
        url: "delete_user.php",
        method: "post",
        data: {
          Delete_UserID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteUser").modal("toggle");
          view_user_record();

          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteUser', function () {
      Delete_ID = "";
    });
  });
}
// ============================================================
//            Agence Ajouter
//==============================================


function insertAgenceRecord() {
  $(document).on("click", "#btn-register-agence", function () {

    $("#Registration-Agence").scrollTop(0);

    const selects_jour = Array.from(
      document.querySelectorAll(".jour")
    );
    //  alert(selects_composant);
    const selects_date_debut = Array.from(
      document.querySelectorAll(".heur-list-debut")
    );
    const selects_date_fin = Array.from(
      document.querySelectorAll(".heur-list-fin")
    );
    var JourListe = selects_jour.map((select) => select.value);
    var DateDebutListe = selects_date_debut.map((select) => select.value);
    var DateFinListe = selects_date_fin.map((select) => select.value);

    var agenceLien = $("#agenceLien").val();
    var agenceDate = $("#agenceDate").val();
    var agenceEmail = $("#agenceEmail").val();
    var agenceTele = $("#agenceTele").val();
    if (
      agenceLien == "" ||
      agenceDate == "" ||
      agenceEmail == "" ||
      agenceTele == ""

    ) {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      // setTimeout(function() {
      //   $("#message").removeClass('alert alert-danger');
      // }, 2500);

    } else if (!isValidEmailAddress(agenceEmail)) {
      $("#message")
        .addClass("alert alert-danger")
        .html("  Email  est invalide");
    } else {
      var form_data = new FormData();
      form_data.append("agenceLien", agenceLien);
      form_data.append("agenceDate", agenceDate);
      form_data.append("agenceEmail", agenceEmail);
      form_data.append("agenceTele", agenceTele);
      form_data.append("JourListe", JourListe);
      form_data.append("DateDebutListe", DateDebutListe);
      form_data.append("DateFinListe", DateFinListe);
      $.ajax({
        url: "AjoutAgence.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Agence").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Agence").modal("show");
            $("#agenceForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            // view_client_record();
            view_agence_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#agenceForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

// ----------------------------------------------------

function insertAgenceRecordHeur() {
  $(document).on("click", "#btn-register-agence-heur", function () {

    $("#Registration-Agence-Heur").scrollTop(0);

    var IdAgence = $("#IdAgence").val();
    var jourH = $("#jourH").val();
    var heurdebutH = $("#fetch-heurdebutH").val();
    var heurfinH = $("#fetch-heurfinH").val();

    if (
      IdAgence == null ||
      jourH == null ||
      heurdebutH == "" ||
      heurfinH == ""

    ) {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
      // setTimeout(function() {
      //   $("#message").removeClass('alert alert-danger');
      // }, 2500);

    } else {
      var form_data = new FormData();
      form_data.append("IdAgence", IdAgence);
      form_data.append("jourH", jourH);
      form_data.append("heurdebutH", heurdebutH);
      form_data.append("heurfinH", heurfinH);

      $.ajax({
        url: "AjoutAgenceHeur.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Agence-Heur").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Agence-Heur").modal("show");
            $("#agenceFormHeur").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");
            // view_client_record();
            view_agence_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#agenceFormHeur").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}


/*
END AGENCE ADD
*/

function view_agence_record() {
  $.ajax({
    url: "viewagence.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#agence-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

/*  

*/
function get_agence_record() {
  $(document).on("click", "#btn-edit-agence", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_agence_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idagence").val(data[0]);
        $("#up_agenceLien").val(data[1]);
        $("#up_agenceDate").val(data[2]);
        $("#up_agenceEmail").val(data[3]);
        $("#up_agenceTele").val(data[4]);
        // $("#up_agenceTele").val(data[4]);
        $("#updateAgence").modal("show");

      },
    });
  });
}


/*
 * update agence
 */
function update_agence_record() {
  $(document).on("click", "#btn_update_agence", function () {
    $("#updateAgence").scrollTop(0);
    var up_idagence = $("#up_idagence").val();
    var up_agenceLien = $("#up_agenceLien").val();
    var up_agenceDate = $("#up_agenceDate").val();
    var up_agenceEmail = $("#up_agenceEmail").val();
    var up_agenceTele = $("#up_agenceTele").val();
    if (
      up_agenceLien == "" ||
      up_agenceDate == "" ||
      up_agenceEmail == "" ||
      up_agenceTele == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#id_agence").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("up_idagence", up_idagence);
      form_data.append("up_agenceLien", up_agenceLien);
      form_data.append("up_agenceDate", up_agenceDate);
      form_data.append("up_agenceEmail", up_agenceEmail);
      form_data.append("up_agenceTele", up_agenceTele);


      $.ajax({
        url: "update_agence.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,

        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le Agence est modifié avec succès");
          $("#updateAgence").modal("show");
          view_agence_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateAgence").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}

/*
 * end update
 */


/*
 * delete_agence_record
 */

function delete_agence_record() {
  $(document).on("click", "#btn-delete-agence", function () {
    var Delete_ID = $(this).attr("data-id1");
    // console.log(Delete_ID);
    $("#deleteAgence").modal("show");
    $(document).on("click", "#btn_delete_agence", function () {
      $.ajax({
        url: "delete_agence.php",
        method: "post",
        data: {
          Delete_AgenceID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteAgence").modal("toggle");
          view_agence_record();

          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteAgence', function () {
      Delete_ID = "";
    });
  });
}



function delete_agence_heur_record() {
  $(document).on("click", "#btn-delete-agence-heur", function () {

    var Delete_ID = $(this).attr("data-id4");
    // alert (Delete_ID);
    // console.log(Delete_ID);
    $("#deleteAgenceHeur").modal("show");
    $(document).on("click", "#btn-delete-agence-heur", function () {
      $.ajax({
        url: "delete_agence_heur.php",
        method: "post",
        data: {
          Delete_AgenceID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteAgenceHeur").modal("toggle");
          view_agence_record();

          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
  });
}


/*
 * end delete_agence_record
 */

//-------------------------------------------------------


function insertGroupPackRecord() {

  $(document).on("click", "#btn-register-pack", function () {
    $("#Registration-Pack").scrollTop(0);
    const selects_pack = Array.from(
      document.querySelectorAll(".materiel-list-pack")
    );
    const selects_quantite = Array.from(
      document.querySelectorAll(".materiel-list-quantite")
    );
    const PackListe = selects_pack.map((select) => Number(select.value));
    const QuantiteListe = selects_quantite.map((select) => Number(select.value));
    // alert(ContratmaterielListe);

    var DesignationPack = $("#DesignationPack").val();
    var VoitureType = $("#VoitureType").val();
    if (
      DesignationPack == ""

    ) {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else if ((selects_pack[0].value == "Nom Matériel") && (VoitureType == "sans vehicule")) {
      //  || cin =="" || tel ==""|| permis =="" || rib ==""|| nom_societe =="")
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs Matériel ou vehicule obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("DesignationPack", DesignationPack);
      form_data.append("VoitureType", VoitureType);
      //  form_data.append("ContratNum", ContratNum);
      form_data.append("PackListe", PackListe);
      form_data.append("QuantiteListe", QuantiteListe);

      $.ajax({
        url: "AjoutGroupPack.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Pack").modal("show");
          $("#grouppackForm").trigger("reset");
          view_group_pack_record();
          // view_contrat_record_voiture();
          // load_unseen_notification();
          // load_unseen_notification_paiement();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#grouppackForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });

  });

}

function view_group_pack_record() {
  $.ajax({
    url: "viewgrouppack.php",
    method: "post",
    success: function (data) {
      try {

        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#group-pack-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

/*
 * delete_agence_record
 */

function delete_pack_record() {
  $(document).on("click", "#btn-delete-pack", function () {

    var Delete_ID = $(this).attr("data-id1");
    //  alert(Delete_ID);
    // // console.log(Delete_ID);
    $("#deletePack").modal("show");
    $(document).on("click", "#btn_delete_pack", function () {
      $.ajax({
        url: "delete_pack.php",
        method: "post",
        data: {
          Delete_PackID: Delete_ID
        },
        success: function (data) {
          $("#delete_message_pack").addClass("alert alert-success").html(data);
          $("#deletePack").modal("toggle");
          view_group_pack_record();

          setTimeout(function () {
            if ($("#delete_message_pack").length > 0) {
              $("#delete_message_pack").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deletePack', function () {
      Delete_ID = "";
    });
  });
}

function delete_materiel_pack() {
  $(document).on("click", "#btn-delete-materiel", function () {
    var Delete_ID = $(this).attr("data-id");
    $("#deleteMateriel").modal("show");
    $(document).on("click", "#btn-delete-materiel", function () {
      $.ajax({
        url: "delete_materiel_pack.php",
        method: "post",
        data: {
          Delete_MATERIELID: Delete_ID
        },
        success: function (data) {
          $("#delete_message_pack").addClass("alert alert-success").html(data);
          $("#deleteMateriel").modal("toggle");
          view_group_pack_record();
          setTimeout(function () {
            if ($("#delete_message_pack").length > 0) {
              $("#delete_message_pack").remove();
            }
          }, 3000);
        },
      });
    });
  });
}

function get_packmateriel_record() {
  $(document).on("click", "#btn-add-materiel", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_group_pack_data.php",
      method: "post",
      data: {
        PackID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#idpack").val(data[0]);
        $("#Registration-Materiel-Pack").modal("show");
      },
    });
  });
}

function insertMaterielPackRecord() {
  $(document).on("click", "#btn-register-Materiel-Pack", function () {
    var id_pack = $("#idpack").val();
    $("#Registration-Materiel-Pack").scrollTop(0);
    const selects_pack = Array.from(
      document.querySelectorAll(".materiel-list-pack-mat")
    );
    const selects_quantite = Array.from(
      document.querySelectorAll(".materiel-list-quantite-pack")
    );
    const PackListe = selects_pack.map((select) => Number(select.value));
    const QuantiteListe = selects_quantite.map((select) => Number(select.value));
    if ((selects_pack[0].value == "")) {
      $("#messagemat")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs Matériel obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("id_pack", id_pack);
      form_data.append("PackListe1", PackListe);
      form_data.append("QuantiteListe1", QuantiteListe);
      $.ajax({
        url: "AjoutMaterielPack.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#messagemat").addClass("alert alert-success").html(data);
          $("#Registration-Materiel-Pack").modal("show");
          $("#add-MaterielPackForm").trigger("reset");
          view_group_pack_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-MaterielPackForm").trigger("reset");
      $("#messagemat").html("");
      $("#messagemat").removeClass("alert alert-danger");
      $("#messagemat").removeClass("alert alert-sucess");
    });
  });
}
/*
 * Get group pack record 
 */
function get_group_pack_record() {
  $(document).on("click", "#btn-edit-pack", function () {
    var ID = $(this).attr("data-id");
    $.ajax({
      url: "get_group_pack_data.php",
      method: "post",
      data: {
        PackID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idPack").val(data[0]);
        $("#up_DesignationPack").val(data[1]);
        $("#up_TypeVoiturePack").val(data[2]);
        $("#up_EtatPack").val(data[3]);
        $("#update-Pack").modal("show");
      },
    });
  });
}
/*
 * end get group pack record
 */

/*
 *  update group pack record
 */

function update_group_pack_record() {
  $(document).on("click", "#btn_updated_Group_Pack", function () {
    $("#updatePackForm").scrollTop(0);
    var pack_id = $("#up_idPack").val();

    var up_DesignationPack = $("#up_DesignationPack").val();
    var up_TypeVoiturePack = $("#up_TypeVoiturePack").val();
    var up_EtatPack = $("#up_EtatPack").val();
    if (
      up_DesignationPack == "" ||
      up_TypeVoiturePack == "" ||
      up_EtatPack == ""
    ) {
      $("#up_message_pack")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#update-Pack").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("pack_id", pack_id);
      form_data.append("up_DesignationPack", up_DesignationPack);
      form_data.append("up_TypeVoiturePack", up_TypeVoiturePack);
      form_data.append("up_EtatPack", up_EtatPack);

      $.ajax({
        url: "update_group_pack.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,

        success: function () {

          $("#up_message_pack")
            .addClass("alert alert-success")
            .html("Le pack est Modifié avec succès");
          $("#update-Pack").modal("show");
          view_group_pack_record();

        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updatePackForm").trigger("reset");
      $("#up_message_pack").html("");
      $("#up_message_pack").removeClass("alert alert-danger");
      $("#up_message_pack").removeClass("alert alert-sucess");
    });
  });
}

/*
 * end update group pack record
 */


// insertContratMixteRecord

function insertContratPackRecord() {


  $(document).on("click", "#btn-register-contrat-mixte", function () {
    $("#Registration-Contrat-mixte").scrollTop(0);
    const selects = Array.from(
      document.querySelectorAll(".materiel-list-pack")
    );
    const ContratmaterielListe = selects.map((select) => Number(select.value));

    const quantite = Array.from(
      document.querySelectorAll(".quantite-list-pack")
    );
    const ContratquantiteListe = quantite.map((select) => Number(select.value));
    // var ContratDate = $("#DateContratMixte").val();
    var type = $("#Contrattype").val();
    var VehiculePack = $("#vehicule_pack").val();
    var id_pack = $("#id_pack").val();
    var ContratType = "Pack";
    var ContratDuree = $("#dureeContratMixte").val();
    var ContratDateDebut = $("#DateDebutContrat").val();
    var ContratDateFin = $("#DateFinContrat").val();
    var ContratPrixContrat = $("#PrixContratMixte").val();
    var ContratAssurence = $("#AssuranceContratMixte").val();
    var ContratPaiement = $("#ModePaiementContratMixte").val();
    var ContratDatePaiement = $("#DatePrelevementContratMixte").val();
    var ContratVoiturekMPrevu = $("#VoitureKMPrevuMixte").val();
    var ContratClient = $("#ClientContratMixte").val();
    var AgenceRetClient = $("#ClientAgenceRet").val();
    var ContratCaution = $("#CautionContratMixte").val();
    var ContratCautionCheque = $("#CautionContratMixtecheque").val();
    var NbreKilometreContrat = $("#NbreKilometreContrat").val();
    var ContratmoyenCaution = $("#moyenCaution").val();
    var ContratNumCaution = $("#numCautionMixte").val();
    var ContratNumCautionCB = $("#numCautionCBMixte").val();
    var contratpackagence = $("#contratpackagence").val();

    const selectsavenant = Array.from(
      document.querySelectorAll(".materiel-list-pack-avenant")
    );
    const ContratAvenantmaterielListe = selectsavenant.map((select) => Number(select.value));

    const quantiteavenant = Array.from(
      document.querySelectorAll(".quantite-list-pack-avenant")
    );
    const ContratAvenantquantiteListe = quantiteavenant.map((select) => Number(select.value));

    var ContratAvenant = $("#ContratClient").val();
    var ContratAvenantDateDebut = $("#DateDebutContratAvenant").val();
    var ContratAvenantDateFin = $("#DateFinContratAvenant").val();

    notfound = 0;
    for(var i=0; i<ContratmaterielListe.length; i++) {
      if(ContratmaterielListe[i] === 0) {
           notfound = 1;
      }
    }
    if(contratpackagence == undefined){
      contratpackagence = "";
    }
    if(VehiculePack == undefined){
      VehiculePack = 0;
    }
    if(type == "CONTRAT" && (VehiculePack!=0 && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" || ContratClient == null || ContratPrixContrat == "" || 
      ContratmoyenCaution == "" || id_pack == null || ContratPaiement == ""))){
        $("#message").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if(type == "CONTRAT" && (VehiculePack==0 && (ContratDateDebut == "" || ContratDateFin == "" || ContratDuree == "" || ContratClient == null || ContratPrixContrat == "" || 
      ContratmoyenCaution == "" || id_pack == null || ContratPaiement == ""))){
        $("#message").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if (type == "CONTRAT" && (ContratDateDebut > ContratDateFin)) {
        $("#message").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
      }else if (type == "CONTRAT" && (notfound == 1)) {
        $("#message").addClass("alert alert-danger").html("Veuillez vérifier la liste de matériels!");
      }else if (type == "CONTRAT" && (VehiculePack == null)) {
        $("#message").addClass("alert alert-danger").html("Veuillez vérifier la liste de véhicules!");

    }else if (type == "CONTRAT AVENANT" && (ContratAvenant == null && (ContratAvenantDateDebut == "" || ContratAvenantDateFin == ""))){
        $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if (type == "CONTRAT AVENANT" && (VehiculePack == null || ContratAvenantDateDebut == "" || ContratAvenantDateFin == "")){
        $("#messagevoiture").addClass("alert alert-danger").html("Veuillez remplir tous les champs obligatoires!");
      }else if (type == "CONTRAT AVENANT" && (ContratAvenantDateDebut > ContratAvenantDateFin)) {
        $("#messagevoiture").addClass("alert alert-danger").html("La date de début ne peut pas être postérieure à la date de fin!");
    
    }else {
      var form_data = new FormData();
      form_data.append("typecontratavenant", type);
      form_data.append("ContratType", ContratType);
      form_data.append("ContratDateDebut", ContratDateDebut);
      form_data.append("ContratDateFin", ContratDateFin);
      form_data.append("ContratPrixContrat", ContratPrixContrat);
      form_data.append("ContratAssurence", ContratAssurence);
      form_data.append("ContratPaiement", ContratPaiement);
      form_data.append("ContratDatePaiement", ContratDatePaiement);
      form_data.append("ContratVoiturekMPrevu", ContratVoiturekMPrevu);
      form_data.append("ContratClient", ContratClient);
      form_data.append("AgenceRetClient", AgenceRetClient);
      form_data.append("NbreKilometreContrat", NbreKilometreContrat);
      form_data.append("ContratmoyenCaution", ContratmoyenCaution);
      form_data.append("ContratCaution", ContratCaution);
      form_data.append("ContratCautionCheque", ContratCautionCheque);
      form_data.append("ContratNumCaution", ContratNumCaution);
      form_data.append("ContratNumCautionCB", ContratNumCautionCB);
      form_data.append("VehiculePack", VehiculePack);
      form_data.append("id_pack", id_pack);
      form_data.append("ContratmaterielListe", ContratmaterielListe);
      form_data.append("ContratquantiteListe", ContratquantiteListe);
      form_data.append("contratpackagence", contratpackagence);
      form_data.append("ContratDuree", ContratDuree);
      form_data.append("ContratAvenant", ContratAvenant);
      form_data.append("ContratAvenantDateDebut", ContratAvenantDateDebut);
      form_data.append("ContratAvenantDateFin", ContratAvenantDateFin);
      form_data.append("ContratAvenantmaterielListe", ContratAvenantmaterielListe);
      form_data.append("ContratAvenantquantiteListe", ContratAvenantquantiteListe);

      $.ajax({
        url: "AjoutContratPack.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Contrat-mixte").modal("show");
          $("#contratpackForm").trigger("reset");
          view_contrat_record_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#contratpackForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });

  });
}
// end insertContratMixteRecord

/*
 * insertCategorieRecord
 */
function insertCategorieRecord() {

  $(document).on("click", "#btn-register-Materiel-Categorie", function () {

    $("#Registration-Categorie").scrollTop(0);
    var code_materiel = $("#code_materiel").val();
    var designation = $("#designation").val();
    var famille_materiel = $("#famille_materiel").val();
    var type_location = $("#type_location").val();
    var num_serie_obg = $("#num_serie_obg").val();
    if (
      code_materiel == "" ||
      designation == "" ||
      famille_materiel == "" ||
      type_location == ""

    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");

    } else {
      var form_data = new FormData();
      form_data.append("code_materiel", code_materiel);
      form_data.append("designation", designation);
      form_data.append("famille_materiel", famille_materiel);
      form_data.append("type_location", type_location);
      form_data.append("num_serie_obg", num_serie_obg);
      $.ajax({
        url: "AjoutCategorie.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#message")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Categorie").modal("show");
          } else {
            $("#message")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#Registration-Categorie").modal("show");
            $("#add-CategorieForm").trigger("reset");
            $("#message").removeClass("text-danger").addClass("text-success");

            view_categorie_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-CategorieForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function view_categorie_record() {
  $.ajax({
    url: "viewcategorie.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#Categorie-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}



function delete_categorie_record() {
  $(document).on("click", "#btn-delete-categorie", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteCategorie").modal("show");

    $(document).on("click", "#btn_delete_categorie", function () {
      $.ajax({
        url: "delete_categorie.php",
        method: "post",
        data: {
          Del_ID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteCategorie").modal("toggle");
          view_categorie_record();

          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 3000);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteCategorie', function () {
      Delete_ID = "";
    });
  });
}

/*
 *  insert Stock Record
 */

function insertStockRecord() {
  $(document).on("click", "#btn-register-Materiel-stock", function () {
    $("#Registration-Materiel-stock").scrollTop(0);
    var ID = $("#up_idMaterielstock").val();
    var signe = $("#stockSigne").val();
    var value = $("#value").val();
    var etat = $("#up_EtatMaterielstock").val();
    var materielstockagence = $("#up_materielstockagence").val();
    if(materielstockagence == undefined){
      materielstockagence = "";
    }
    if (
      etat == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      var form_data = new FormData();
      form_data.append("ID", ID);
      form_data.append("signe", signe);
      form_data.append("value", value);
      form_data.append("etat", etat);
      form_data.append("materielstockagence", materielstockagence);
      $.ajax({
        url: "AjoutStock.php",
        method: "post",
        processData: false,
        contentType: false,
        data: form_data,
        success: function (data) {
          if (data.error) {
            $("#messagest")
              .removeClass("text-success")
              .addClass("text-danger")
              .html(data);
            $("#Registration-Materiel-stock").modal("show");
          } else {
            $("#messagest")
              .removeClass("text-danger")
              .addClass("text-success")
              .html(data);
            $("#add-MaterielStockForm").trigger("reset");
            $("#messagest").removeClass("text-danger").addClass("text-success");

            view_Materiel_record();
          }
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-MaterielStockForm").trigger("reset");
      $("#messagest").html("");
      $("#messagest").removeClass("alert alert-danger");
      $("#messagest").removeClass("alert alert-sucess");
    });
  });
}

function view_grppack_record() {
  $.ajax({
    url: "viewgrppack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#grppack-list").html(data.html);

        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}


function isValidEmailAddress(emailAddress) {
  var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
  return pattern.test(emailAddress);
}


function get_id_client() {
  $(document).on("click", "#btn-id-client", function () {
    var ID = $(this).attr("data-id3");
    window.open("fpdf/contratvehicule1.php?id=" + ID, '_blank');
  });
}

function get_contrat_voiture_avenant() {
  $(document).on("click", "#btn-id-contrat-avenant", function () {
    var ID = $(this).attr("data-id");
    window.open("fpdf/ContratVehiculeAvenant.php?id=" + ID, '_blank');
  });
}

function get_contrat_materiel_avenant() {
  $(document).on("click", "#btn-id-contrat-avenant-materiel", function () {
    var ID = $(this).attr("data-id");
    window.open("fpdf/ContratMaterielAvenant.php?id=" + ID, '_blank');
  });
}

function get_contrat_pack_avenant() {
  $(document).on("click", "#btn-id-contrat-avenant-pack", function () {
    var ID = $(this).attr("data-id");
    window.open("fpdf/ContratPackAvenant.php?id=" + ID, '_blank');
  });
}

// get id client
function get_id_client_contrat_materiel() {
  $(document).on("click", "#btn-id-client-materiel", function () {
    var id_contrat_materiel = $(this).attr("data-id5");
    window.open("fpdf/ContratMateriel.php?id=" + id_contrat_materiel, '_blank');

  });
}

// get id client
function get_id_client_contrat_pack() {
  $(document).on("click", "#btn-id-client-pack", function () {
    var id_contrat_pack = $(this).attr("data-id3");
    window.open("fpdf/ContratPack.php?id=" + id_contrat_pack, '_blank');

  });
}


function insertDevisRecord() {
  $(document).on("click", "#btn-register-Devis", function () {
    $("#Registration-Devis").scrollTop(0);
    var ClientDevis = $("#ClientDevis").val();
    var NomDevis = $("#NomDevis").val();
    var ModePaiementDevis = $("#ModePaiementDevis").val();
    var CommentaireDevis = $("#CommentaireDevis").val();
    var DateDevis = $("#DateDevis").val();
    var RemiseDevis = $("#RemiseDevis").val();
    var EscompteDevis = $("#EscompteDevis").val();
    var devisagence = $("#devisagence").val();
    const selects_code = Array.from(
      document.querySelectorAll(".code-list-comp")
    );
    const selects_designation = Array.from(
      document.querySelectorAll(".designation-list-num_comp")
    );
    const selects_quantition = Array.from(
      document.querySelectorAll(".quantition-list-num_comp")
    );
    const selects_prix = Array.from(
      document.querySelectorAll(".prix-list-num_comp")
    );
    const selects_depot = Array.from(
      document.querySelectorAll(".depot-list-num_comp")
    );
    var codeListe = selects_code.map((select) => select.value);
    var designationListe = selects_designation.map((select) => select.value);
    var quantitionListe = selects_quantition.map((select) => select.value);
    var prixListe = selects_prix.map((select) => select.value);
    var depotListe = selects_depot.map((select) => select.value);
    if(devisagence == undefined){
      devisagence = "";
    }
    if (
      ClientDevis == "" ||
      NomDevis == "" ||
      ModePaiementDevis == "" ||
      CommentaireDevis == "" ||
      DateDevis == "" ||
      RemiseDevis == "" ||
      EscompteDevis == "" ||
      codeListe == "" ||
      designationListe == "" ||
      prixListe == ""
    ) {
      $("#message")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutDevis.php",
        method: "post",
        data: {
          ClientDevis: ClientDevis,
          NomDevis: NomDevis,
          ModePaiementDevis: ModePaiementDevis,
          CommentaireDevis: CommentaireDevis,
          DateDevis: DateDevis,
          RemiseDevis: RemiseDevis,
          EscompteDevis: EscompteDevis,
          codeListe: codeListe,
          designationListe: designationListe,
          quantitionListe: quantitionListe,
          prixListe: prixListe,
          devisagence: devisagence,
          depotListe: depotListe
        },
        success: function (data) {
          $("#message").addClass("alert alert-success").html(data);
          $("#Registration-Devis").modal("show");
          $("#add-DevisForm").trigger("reset");
          view_devis_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#add-MaterielForm").trigger("reset");
      $("#message").html("");
      $("#message").removeClass("alert alert-danger");
      $("#message").removeClass("alert alert-sucess");
    });
  });
}

function delete_devis() {
  $(document).on("click", "#btn-delete-devis", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteDevis").modal("show");
    $(document).on("click", "#btn_delete", function () {
      $.ajax({
        url: "delete_devis.php",
        method: "post",
        data: {
          Delete_DevisID: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteDevis").modal("toggle");
          view_devis_record();
          load_unseen_notification();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteDevis', function () {
      Delete_ID = "";
    });
  });
}

function view_devis_record() {
  $.ajax({
    url: "viewdevis.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#devis-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid Response Devis !");
      }
    },
  });
}

function get_Devis() {
  $(document).on("click", "#btn-edit-devis", function () {
    var ID = $(this).attr("data-id");

    $.ajax({
      url: "get_devis_data.php",
      method: "post",
      data: {
        DevisID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idDevis").val(data[0]);
        $("#up_NomDevis").val(data[1]);
        $("#up_ModePaiementDevis").val(data[2]);
        $("#up_CommentaireDevis").val(data[3]);
        $("#up_DateDevis").val(data[4]);
        $("#up_RemiseDevis").val(data[5]);
        $("#up_EscompteDevis").val(data[7]);
        $("#up_ClientDevis").val(data[8]);
        $("#up_code_comp1").val(data[10]);
        $("#up_designation_comp_1").val(data[11]);
        $("#up_quantition_comp_1").val(data[12]);
        $("#up_prix_comp_1").val(data[13]);
        $("#up_depot_comp_1").val(data[14]);
        $("#up_devisagence").val(data[15]);

        $("#updateDevis").modal("show");
        view_devis_record();
      },
    });
  });
}


function genereriddevis() {
  $(document).on("click", "#btn-id-client-devis", function () {
    var idDevis = $(this).attr("data-id2");
    window.open("fpdf/devis.php?id=" + idDevis, '_blank');
  });
}

function update_devis_record() {
  $(document).on("click", "#btn_update_devis", function () {
    $("#updateDevis").scrollTop(0);
    var updateDevislId = $("#up_idDevis").val();
    var updateDevisName = $("#up_NomDevis").val();
    var updateDevisModePaiement = $("#up_ModePaiementDevis").val();
    var updateDevisCommentaire = $("#up_CommentaireDevis").val();
    var updateDevisDate = $("#up_DateDevis").val();
    var updateDevisRemise = $("#up_RemiseDevis").val();
    var updateDevisEscompte = $("#up_EscompteDevis").val();
    var updateDevisClient = $("#up_ClientDevis").val();
    // var up_code_comp1 = $("#up_code_comp1").val();
    // var up_designation_comp_1 = $("#up_designation_comp_1").val();
    // var up_quantition_comp_1 = $("#up_quantition_comp_1").val();
    // var up_prix_comp_1 = $("#up_prix_comp_1").val();
    // var up_depot_comp_1 = $("#up_depot_comp_1").val();
    var up_devisagence = $("#up_devisagence").val();
    if(up_devisagence == undefined){
      up_devisagence = "";
    }
    if (
      updateDevisName == "" ||
      updateDevisModePaiement == "" ||
      updateDevisCommentaire == "" ||
      updateDevisDate == "" ||
      updateDevisRemise == "" ||
      updateDevisEscompte == "" ||
      updateDevisClient == ""
    ) {
      $("#up_message_Devis")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateDevis").modal("show");
    } else {
      $.ajax({
        url: "update_devis.php",
        method: "post",
        data: {
          up_idDevis: updateDevislId,
          up_NomDevis: updateDevisName,
          up_ModePaiementDevis: updateDevisModePaiement,
          up_CommentaireDevis: updateDevisCommentaire,
          up_DateDevis: updateDevisDate,
          up_RemiseDevis: updateDevisRemise,
          up_EscompteDevis: updateDevisEscompte,
          up_ClientDevis: updateDevisClient,
          // up_code_comp1: up_code_comp1, 
          // up_designation_comp_1: up_designation_comp_1,
          // up_quantition_comp_1: up_quantition_comp_1,
          // up_prix_comp_1: up_prix_comp_1, 
          // up_depot_comp_1: up_depot_comp_1,
          up_devisagence: up_devisagence,
        },
        success: function (data) {
          $("#up_message_Devis").addClass("alert alert-success").html(data);
          $("#updateDevis").modal("show");
          view_devis_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#updateDevisForm").trigger("reset");
      $("#up_message_Devis").html("");
      $("#up_message_Devis").removeClass("alert alert-danger");
      $("#up_message_Devis").removeClass("alert alert-success");
    });
  });
}

function searchDevis() {
  $("#searchDevis").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchDevis.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#devis-list").html(response);
      },
    });
  });
}

//Afficher les factures 
function insertFacture() {
  $(document).on("click", "#btn-register-facture", function () {
    $("#Registration-Facture").scrollTop(0);
    var ContratFacture = $("#ContratFacture").val();
    var DateArret = $("#DateArret").val();
    if (ContratFacture == " " || DateArret == "") {
      $("#messagefacture")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutFacture.php",
        method: "post",
        data: {
          ContratFacture: ContratFacture,
          DateArret: DateArret
        },
        success: function (data) {
          $("#messagefacture").addClass("alert alert-success").html(data);
          $("#Registration-Facture").modal("show");
          $("#FactureForm").trigger("reset");
          view_facture_contrat_voiture();
          view_facture_contrat_materiel();
          view_facture_contrat_pack();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#FactureForm").trigger("reset");
      $("#messagefacture").html("");
      $("#messagefacture").removeClass("alert alert-danger");
      $("#messagefacture").removeClass("alert alert-sucess");
    });

  });
}

function view_facture_contrat_voiture() {
  $.ajax({
    url: "viewfacturecontratvoiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-voiture").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function searchFactureVoiture() {
  $("#searchFactureVoiture").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFactureVoiture.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-voiture").html(response);
      },
    });
  });
}

function view_facture_contrat_materiel() {
  $.ajax({
    url: "viewfacturecontratmateriel.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-materiel").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function searchFactureMateriel() {
  $("#searchFactureMateriel").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFactureMateriel.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-materiel").html(response);
      },
    });
  });
}

function view_facture_contrat_pack() {
  $.ajax({
    url: "viewfacturecontratpack.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#facture-list-contrat-pack").html(data.html);
          load_unseen_notification_paiement();
        }
      } catch (e) {
        console.error("Invalid Response!");
      }
    },
  });
}

function searchFacturePack() {
  $("#searchFacturePack").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchFacturePack.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#facture-list-contrat-pack").html(response);
      },
    });
  });
}

function genereridfacturevoiture() {
  $(document).on("click", "#btn-id-client-facture", function () {
    var idFactureVoiture = $(this).attr("data-id4");
    window.open("fpdf/facture_client.php?id=" + idFactureVoiture, '_blank');
  });
}

function genereridfacturemateriel() {
  $(document).on("click", "#btn-id-client-facture-materiel", function () {
    var idFactureMateriel = $(this).attr("data-id4");
    window.open("fpdf/facture_materiel_client.php?id=" + idFactureMateriel, '_blank');
  });
}

function genereridfacturepack() {
  $(document).on("click", "#btn-id-client-facture-pack", function () {
    var idFacturePack = $(this).attr("data-id4");
    window.open("fpdf/facture_pack_client.php?id=" + idFacturePack, '_blank');
  });
}
/*
 * VIEW  CHAUFFEUR 
 */
function view_chauffeur_record() {
  $.ajax({
    url: "viewchauffeur.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#chauffeur-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid  Response chauffeur!");
      }
    },
  });
}

/*
 * END CHAUFFEUR 
 */

//supprimer CHAUFFEUR
function delete_voiturek2_record() {
  $(document).on("click", "#btn-delete-k2vehicule", function () {
    //  console.log('hee'); "btn-delete-k2vehicule"
    var Delete_ID = $(this).attr("data-id1");

    //  console.log(Delete_ID);
    $("#deletevoiturek2").modal("show");
    $(document).on("click", "#btn_delete_voiturek2", function () {
      $.ajax({
        url: "DeleteVoiturek2.php",
        method: "post",
        data: {
          id_voiture: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deletevoiturek2").modal("toggle");
          view_k2voiture_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deletevoiturek2', function () {
      Delete_ID = "";
    });
  });
}
/*
 * end  K2-VOITURE 
 */
/*
 * VIEW  K2-CHAUFFEUR 
 */
function view_k2voiture_record() {
  $.ajax({
    url: "viewk2voiture.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#k2voiture-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid  Response chauffeur!");
      }
    },
  });
}

/*
 * END  K2-VOITEUR  
 */

/*
 * DELETE  K2-VOITEUR  
 */

//supprimer chauffeur k2
function delete_chauffeurk2_record() {
  $(document).on("click", "#btn-delete-chauffeur", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deletechauffeur").modal("show");
    $(document).on("click", "#btn_delete_chauffeur", function () {
      $.ajax({
        url: "DeleteChauffeurk2.php",
        method: "post",
        data: {
          id_chauffeur: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deletechauffeur").modal("toggle");
          view_chauffeur_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deletechauffeur', function () {
      Delete_ID = "";
    });
  });
}

function searchchauffeurk2() {
  $("#searchchauffeur").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchChauffeur.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#chauffeur-list").html(response);
      },
    });
  });
}


/*
 * DELETE  K2-VOITEUR  
 */
/*
 * VIEW  K2-VOITURE 
 */
function view_k2affectation_record() {
  $.ajax({
    url: "viewk2affectation.php",
    method: "post",
    success: function (data) {
      try {
        data = $.parseJSON(data);
        if (data.status == "success") {
          $("#affectation-list").html(data.html);
        }
      } catch (e) {
        console.error("Invalid  Response chauffeur!");
      }
    },
  });
}
/*
 * END  K2-VOITEUR  
 */
function insertK2affectation() {
  $(document).on("click", "#btn-register-affectation", function () {
    $("#Registration-affectation").scrollTop(0);
    var IDaffectationK2_vehicule = $("#affectationK2_vehicule").val();
    var IDaffectationChauffeur = $("#affectationChauffeur").val();
    var IDaffectationDateDebut = $("#affectationDateDebut").val();

    if (
      IDaffectationK2_vehicule == "Choisissez" ||
      IDaffectationChauffeur == "Choisissez" ||
      IDaffectationDateDebut == "") {

      $("#messageaffectation")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutK2Affectation.php",
        method: "post",
        data: {
          IDaffectationK2_vehicule: IDaffectationK2_vehicule,
          IDaffectationChauffeur: IDaffectationChauffeur,
          IDaffectationDateDebut: IDaffectationDateDebut,

        },
        success: function (data) {
          $("#messageaffectation").addClass("alert alert-success").html(data);
          $("#Registration-affectation").modal("show");
          $("#affectationForm").trigger("reset");
          view_k2affectation_record();
        },
      });
    }
    $(document).on("click", "#btn-close-affectation", function () {
      $("#affectationForm").trigger("reset");
      $("#messageaffectation").html("");
      $("#messageaffectation").removeClass("alert alert-danger");
      $("#messageaffectation").removeClass("alert alert-sucess");
    });
  });
}
/*
 * searchAffectation
 */
function searchAffectation() {
  $("#searchaffectation").keyup(function () {

    var search = $(this).val();
    if (search != "") {
      $("#searchvoiture").hide();
    } else {
      $("#searchvoiture").show();
    }
    $.ajax({
      url: "searchAffectation.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#affectation-list").html(response);
      },
    });
  });
}
/* 
 *  End search
 */
function affictation_dispo() {
  var IDaffectationK2_vehiculesearch = $("#affectationK2_vehicule_search").val();
  // alert(IDaffectationK2_vehicule);
  if (IDaffectationK2_vehiculesearch != "0") {
    $("#searchaffectation").hide();
  } else {
    $("#searchaffectation").show();
  }
  $.ajax({
    url: "searchAffectationId.php",
    method: "post",
    data: {
      queryk2: IDaffectationK2_vehiculesearch,
    },
    success: function (response) {
      $("#affectation-list").html(response);
    },
  });
}

function insertK2voiture() {
  $(document).on("click", "#btn-register-voiturek2", function () {
    $("#Registration-voiturek2k").scrollTop(0);
    var voitureImmatriculation = $("#voitureImmatriculation").val();
    var voitureMarque = $("#voitureMarque").val();
    if (
      voitureImmatriculation == "" ||
      voitureMarque == "") {
      $("#messagevoiture")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutK2Voiture.php",
        method: "post",
        data: {
          voitureImmatriculation: voitureImmatriculation,
          voitureMarque: voitureMarque,
        },
        success: function (data) {
          $("#messagevoiture").addClass("alert alert-success").html(data);
          $("#Registration-voiturek2").modal("show");
          $("#voitureFormk2").trigger("reset");
          view_k2voiture_record();
        },
      });
    }
    $(document).on("click", "#btn-close-affectation", function () {
      $("#voitureFormk2").trigger("reset");
      $("#messagevoiture").html("");
      $("#messagevoiture").removeClass("alert alert-danger");
      $("#messagevoiture").removeClass("alert alert-sucess");
    });

  });
}

function searchvoiturek2() {
  $("#searchvoiturek2").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoiturek2.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#k2voiture-list").html(response);
      },
    });
  });
}

function insertK2chauffeur() {
  $(document).on("click", "#btn-register-chauffeur", function () {
    $("#Registration-chauffeur").scrollTop(0);
    var chauffeurName = $("#chauffeurName").val();
    var chauffeurEmail = $("#chauffeurEmail").val();
    if (
      chauffeurName == "" ||
      chauffeurEmail == "") {
      $("#messagechauffeur")
        .addClass("alert alert-danger")
        .html("Veuillez remplir tous les champs obligatoires !");
    } else {
      $.ajax({
        url: "AjoutK2Chauffeur.php",
        method: "post",
        data: {
          chauffeurName: chauffeurName,
          chauffeurEmail: chauffeurEmail,
        },
        success: function (data) {
          $("#messagechauffeur").addClass("alert alert-success").html(data);
          $("#Registration-chauffeur").modal("show");
          $("#chauffeurForm").trigger("reset");
          view_chauffeur_record();
        },
      });
    }
    $(document).on("click", "#btn-close-affectation", function () {
      $("#chauffeurForm").trigger("reset");
      $("#messagechauffeur").html("");
      $("#messagechauffeur").removeClass("alert alert-danger");
      $("#messagechauffeur").removeClass("alert alert-sucess");
    });

  });
}

function delete_affectationk2_record() {
  $(document).on("click", "#btn-delete-k2affectation", function () {
    var Delete_ID = $(this).attr("data-id1");
    $("#deleteaffectation").modal("show");
    $(document).on("click", "#btn_delete_affectation", function () {
      $.ajax({
        url: "DeleteAffectationk2.php",
        method: "post",
        data: {
          id_affectation: Delete_ID
        },
        success: function (data) {
          $("#delete_message").addClass("alert alert-success").html(data);
          $("#deleteaffectation").modal("toggle");
          view_k2affectation_record();
          setTimeout(function () {
            if ($("#delete_message").length > 0) {
              $("#delete_message").remove();
            }
          }, 2500);
        },
      });
    });
    $(document).on('hide.bs.modal', '#deleteaffectation', function () {
      Delete_ID = "";
    });
  });
}



function update_client_doc_record() {
  $(document).on("click", "#btn_update_doc", function () {
    $("#updateClientDoc").scrollTop(0);
    var updateclientID = $("#up_idclientdoc").val();

    var updateclientCIN = $("#up_clientCINdoc").prop("files")[0];
    var updateclientPermis = $("#up_clientPermisdoc").prop("files")[0];
    var updateclientKBIS = $("#up_clientKBISdoc").prop("files")[0];
    var updateclientAttestation = $("#up_clientAttestationdoc").prop("files")[0];
    var updateclientRIB = $("#up_clientRIBdoc").prop("files")[0];
    if (
      updateclientID == ""
    ) {
      $("#up_message")
        .addClass("alert alert-danger")
        .html("Les champs obligatoires ne peuvent pas être nuls !");
      $("#updateClientDoc").modal("show");
    } else {
      var form_data = new FormData();
      form_data.append("_id", updateclientID);
      form_data.append("cin", updateclientCIN);
      form_data.append("kbis", updateclientKBIS);
      form_data.append("permis", updateclientPermis);
      form_data.append("rib", updateclientRIB);
      form_data.append("attestation_civile", updateclientAttestation);
      $.ajax({
        url: "update_doc_client.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: form_data,
        success: function () {
          $("#up_message")
            .addClass("alert alert-success")
            .html("Le client est modifié avec succès");
          $("#updateClientDoc").modal("show");
          view_client_record();
          view_client_inactif_record();
        },
      });
    }
    $(document).on("click", "#btn-close", function () {
      $("#up-clientForm").trigger("reset");
      $("#up_message").html("");
      $("#up_message").removeClass("alert alert-danger");
      $("#up_message").removeClass("alert alert-sucess");
    });
  });
}


// get particuler client record DOC
function get_client_doc_record() {
  $(document).on("click", "#btn-edit-doc", function () {
    var ID = $(this).attr("data-id3");
    $.ajax({
      url: "get_client_data.php",
      method: "post",
      data: {
        ClientID: ID
      },
      dataType: "JSON",
      success: function (data) {
        $("#up_idclientdoc").val(data[0]);
        $("#updateClientDoc").modal("show");
      },
    });
  });
}



function searchchauffeurk2() {
  $("#searchchauffeur").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchChauffeur.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#chauffeur-list").html(response);
      },
    });
  });
}

function searchvoiturek2() {
  $("#searchvoiturek2").keyup(function () {
    var search = $(this).val();
    $.ajax({
      url: "searchVoiturek2.php",
      method: "post",
      data: {
        query: search
      },
      success: function (response) {
        $("#k2voiture-list").html(response);
      },
    });
  });
}