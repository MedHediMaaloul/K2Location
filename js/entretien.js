function FetchPIMM(id_voiture) {
  $("#EntretienPIMM").html("");
  $("#EntretienDateAchatVoiture").html(
    "<option disabled selected>Select PIMM</option>"
  );
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#EntretienPIMM").html(data);
    },
  });
}



function List_Comp_Materiel(id_materiels_agence) {

  $.ajax({
    type: "post",
    url: "selectcompmateriel.php",
    data: {
      id_materiels_agence: id_materiels_agence
    },
    success: function (data) {
      $("#list_composant").html(data);

    },
  });
}

function MaterielCategorie(id_materiel) {
  $.ajax({
    type: "post",
    url: "selectmaterielcategorie.php",
    data: {
      id_materiel: id_materiel
    },
    success: function (data) {
      if (data == "T") {
        $("#cont_num_serie").show();
        $("#cont_composant").show();
        $("#cont_quitite").hide();
        document.getElementById("quitite").value = 1;
        document.getElementById("materielnumserie").value = "";
      } else {
        $("#cont_num_serie").hide();
        $("#cont_composant").hide();
        $("#cont_quitite").show();
        document.getElementById("materielnumserie").value = "vide";
      }
    },
  });
}


function changeTypeMatrielePack(id_materiel, id) {
  $.ajax({
    type: "post",
    url: "selectmaterielcategorie.php",
    data: {
      id_materiel: id_materiel
    },
    success: function (data) {
      //$("#VoiturePimmMixte").html(data);
      if (data == "T") {

        $("#quantite_" + id).hide();
        document.getElementById("quantite_" + id).value = 1;


      } else {

        $("#quantite_" + id).show();
        document.getElementById("quantite_" + id).value = "";

      }
    },
  });
}

function changeTypeMatrielPack(id_materiel, id) {
  $.ajax({
    type: "post",
    url: "selectpackmaterielcategorie.php",
    data: {
      id_materiel: id_materiel
    },
    success: function (data) {
      if (data == "T") {
        $("#quantitepack_" + id).hide();
        document.getElementById("quantitepack_" + id).value = 1;
      } else {
        $("#quantitepack_" + id).show();
        document.getElementById("quantitepack_" + id).value = "";
      }
    },
  });
}





function FetchPIMMContrat(id_voiture) {
  $("#VoiturePimm").html("");
  $.ajax({
    type: "post",
    url: "selectboxcontrat.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#VoiturePimm").html(data);
    },
  });
}

function FetchPIMMContratMixte(id_voiture) {
  $("#VoiturePimmMixte").html("");
  $.ajax({
    type: "post",
    url: "selectboxcontrat.php",
    data: {
      Model_id: id_voiture
    },
    success: function (data) {
      $("#VoiturePimmMixte").html(data);
    },
  });
}

// function FetchCINClientContrat(id_voiture){
//   $('#ClientCINContrat').html('');
//   $.ajax({
//     type:'post',
//     url: 'selectboxcontrat.php',
//     data : { Model_id : id_voiture},
//     success : function(data){
//        $('#ClientCINContrat').html(data);
//     }

//   })
// }

function FetchDateAchatVoiture(id_voiture) {
  $("#EntretienDateAchatVoiture").html("");
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Pimm_id: id_voiture
    },
    success: function (data) {
      $("#EntretienDateAchatVoiture").html(data);
    },
  });
}

function FetchNumSerie(id_materiel) {
  $("#EntretienNumSerieMateriel").html("");
  $("#EntretienDateAchatMateriel").html(
    "<option disabled selected>Select Num Serie</option>"
  );
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      Materiel_id: id_materiel
    },
    success: function (data) {
      $("#EntretienNumSerieMateriel").html(data);
    },
  });
}

function FetchDateAchatMateriel(id_materiel) {
  $("#EntretienDateAchatMateriel").html("");
  $.ajax({
    type: "post",
    url: "selectBoxEntretien.php",
    data: {
      NumSerieMateriel: id_materiel
    },
    success: function (data) {
      $("#EntretienDateAchatMateriel").html(data);
    },
  });
}
$(function () {
  $("#Voituretype").change(function () {
    if ($(this).val() === "CAMION NACELLE") {
      $("#inputvgp").show();
    } else if ($(this).val() === "FOURGON NACELLE"){
      $("#inputvgp").show();
    } else {
      $("#inputvgp").hide();
    }
  });
});
$(function () {
  $("#up_voitureType").change(function () {
    if ($(this).val() === "CAMION NACELLE") {
      $("#up_inputvgp").show();
    } else if ($(this).val() === "FOURGON NACELLE"){
      $("#up_inputvgp").show();
    } else {
      $("#up_inputvgp").hide();
    }
  });
});
$(function () {
  $("#EntretienType").change(function () {
    if ($(this).val() === "Vehicule") {
      $("#voiture").show();
      $("#materiel").hide();
    } else if ($(this).val() === "Materiel") {
      $("#voiture").hide();
      $("#materiel").show();
    } else {
      $("#voiture").hide();
      $("#materiel").hide();
    }
  });
});

$(function () {
  $("#TypeContrat").change(function () {
    if ($(this).val() === "Véhicule") {
      $("#voiture").show();
      $("#materiel").hide();
    } else if ($(this).val() === "Matériel") {
      $("#voiture").hide();
      $("#materiel").show();
    } else {
      $("#voiture").hide();
      $("#materiel").hide();
    }
  });
});
$(function () {
  $("#up_ModePaiementContrat").change(function () {
    if (
      $(this).val() === "Prélèvements automatiques" ||
      $(this).val() === "Virements bancaires" ||
      $(this).val() === "Carte bancaire" ||
      $(this).val() === "Espèces"
    ) {
      $("#up_inputDatePrelevementContrat").show();
    } else {
      $("#up_inputDatePrelevementContrat").hide();
    }
  });
});
$(function () {
  $("#dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#inputkmprevu").show();
    } else {
      $("#inputkmprevu").hide();
    }
  });
});
$(function () {
  $("#up_dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#up_inputkmprevu").show();
    } else {
      $("#up_inputkmprevu").hide();
    }
  });
});
$(function () {
  $("#moyenCaution").change(function () {
    if ($(this).val() === "Carte bancaire") {
      $("#inputNumCB").show();
      $("#inputNumChequeCaution").hide();
    } else if ($(this).val() === "Cheque"){
      $("#inputNumChequeCaution").show();
      $("#inputNumCB").hide();
    } else {
      $("#inputNumChequeCaution").show();
      $("#inputNumCB").show();
    }
  });
});
$(function () {
  $("#up_moyenCaution").change(function () {
    if ($(this).val() === "Carte bancaire") {
      $("#up_inputNumCB").show();
      $("#up_inputNumChequeCaution").hide();
    } else if ($(this).val() === "Cheque"){
      $("#up_inputNumChequeCaution").show();
      $("#up_inputNumCB").hide();
    } else {
      $("#up_inputNumChequeCaution").show();
      $("#up_inputNumCB").show();
    }
  });
});
$(function () {
  $("#dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#inputDatePrelevementContrat").hide();
    } else {
      $("#inputDatePrelevementContrat").show();
    }
  });
});
$(function () {
  $("#up_dureeContrat").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#up_inputDatePrelevementContrat").hide();
    } else {
      $("#up_inputDatePrelevementContrat").show();
    }
  });
});
$(function () {
  $("#dureeContratMixte").change(function () {
    if (
      $(this).val() === "Par Jour" ||
      $(this).val() === "Par Semaine" ||
      $(this).val() === "Par Mois"
    ) {
      $("#inputDatePrelevementContrat").hide();
    } else {
      $("#inputDatePrelevementContrat").show();
    }
  });
});

$(function () {
  $("#klillimite").click(function () {
      if ($(this).is(":checked")) {
          $("#cont_NbreKilometreNotOblig").show();
          $("#cont_NbreKilometreOblig").hide();
      } else {
          $("#cont_NbreKilometreNotOblig").hide();
          $("#cont_NbreKilometreOblig").show();
      }
  });
});

$(function() {
  $('#ClientContrat').select2({
      dropdownParent: $('#ClientContrat').parent()
  });
});

function affichier_materiel_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();
  var contratmaterielagence = $("#contratmaterielagence").val();
  $.ajax({
    type: "post",
    url: "selectMaterielDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
      contratmaterielagence: contratmaterielagence,
    },
    success: function (data) {
      $("#materiel").html(data);
    },
  });
}

function afficher_materiel_avenant_dispo() {
  var IDContratAvenant = $("#ContratClient").val();
  var DateFinContrat = $("#DateFinContratAvenant").val();
  var DateDebutContrat = $("#DateDebutContratAvenant").val();
  $.ajax({
    type: "post",
    url: "selectMaterielAvenantDispo.php",
    data: {
      IDContratAvenant: IDContratAvenant,
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
    },
    success: function (data) {
      $("#materielContratAvenant").html(data);
    },
  });
}


function affichier_voiture_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();
  var contratvehiculeagence = $("#contratvehiculeagence").val();
  $.ajax({
    type: "post",
    url: "selectVoiteurDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
      contratvehiculeagence: contratvehiculeagence,
    },
    success: function (data) {
      $("#materielVoiteur").html(data);
    },
  });
}

function affichier_voiture_dispo_contratavenant() {
  var IDContrat = $("#ContratClient").val();
  var type = $("#type1").val();
  var DateFinContratAvenant = $("#DateDebutContratAvenant").val();
  var DateDebutContratAvenant = $("#DateDebutContratAvenant").val();
  $.ajax({
    type: "post",
    url: "selectVehiculeavenantDispo.php",
    data: {
      IDContrat: IDContrat,
      type: type,
      DateFinContratAvenant: DateFinContratAvenant,
      DateDebutContratAvenant: DateDebutContratAvenant,
    },
    success: function (data) {
      $("#materielVoiteurContratAvenant").html(data);
    },
  });
}

function affichier_update_voiture_dispo_contratavenant() {
  var IDContrat = $("#up_idcontratavenant").val();
  var type = $("#type").val();
  var DateFinContratAvenant = $("#up_DateContratAvenantDebut").val();
  var DateDebutContratAvenant = $("#up_DateContratAvenantFin").val();
  $.ajax({
    type: "post",
    url: "selectVehiculeavenantDispo.php",
    data: {
      IDContrat: IDContrat,
      type: type,
      DateFinContratAvenant: DateFinContratAvenant,
      DateDebutContratAvenant: DateDebutContratAvenant,
    },
    success: function (data) {
      $("#materielupdateVoiteurContratAvenant").html(data);
    },
  });
}


function affichier_pack_dispo() {
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();
  var contratpackagence = $("#contratpackagence").val();
  if(contratpackagence == undefined){
    contratpackagence = "";
  }
  $.ajax({
    type: "post",
    url: "selectPackDispo.php",
    data: {
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
      contratpackagence: contratpackagence,
    },
    success: function (data) {
      $("#materielPack").html(data);
    },
  });
}

function afficher_pack_dispo_contratavenant() {
  var IDContrat = $("#ContratClient").val();
  var DateFinContrat = $("#DateFinContratAvenant").val();
  var DateDebutContrat = $("#DateDebutContratAvenant").val();
  $.ajax({
    type: "post",
    url: "selectPackAvenantDispo.php",
    data: {
      IDContratAvenant: IDContrat,
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
    },
    success: function (data) {
      $("#materielPack_ContratAvenant").html(data);
    },
  });
}

function List_Materiel_Pack(id_pack) {
  var contratpackagence = $("#contratpackagence").val();
  var DateFinContrat = $("#DateFinContrat").val();
  var DateDebutContrat = $("#DateDebutContrat").val();
  $.ajax({
    type: "post",
    url: "selectmaterielpack.php",
    data: {
      id_pack: id_pack,
      id_agence: contratpackagence,
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat
    },
    success: function (data) {
      $("#list_materiel_pack").html(data);

    },
  });
}

function List_Materiel_Pack_Avenant() {
  var IDContrat = $("#ContratClient").val();
  var DateFinContrat = $("#DateFinContratAvenant").val();
  var DateDebutContrat = $("#DateDebutContratAvenant").val();
  var type="";
  if (vehicule.checked == 1){
    type="vehicule";
  } else if (materiel.checked == 1){
    type="materiel"; 
  }
  $.ajax({
    type: "post",
    url: "selectmaterielpackavenant.php",
    data: {
      IDContratAvenant: IDContrat,
      DateFinContrat: DateFinContrat,
      DateDebutContrat: DateDebutContrat,
      type: type
    },
    success: function (data) {
      $("#list_materiel_pack_ContratAvenant").html(data);

    },
  });
}

function selectclient(data) {
  //$("#VoiturePimmMixte").html(data);
  if (data == "CLIENT PRO") {
    $("#cont_nom_complet_pro").show();
    $("#cont_contrat_type").show();
    $("#cont_nom_complet_part").hide();
    $("#cont_email").show();
    $("#cont_telephone").show();
    $("#cont_adresse").show();
    $("#cont_raison").hide();
    $("#cont_nom_conducteur_pro").show();
    $("#cont_numpermisPro").show();
    $("#cont_numpermisPart").hide();
    $("#cont_siret").show();
    $("#cont_naf").show();
    $("#cont_tva").show();
    $("#cont_date_entreprise").show();
    $("#cont_comment").show();
    $("#cont_cin").show();
    $("#cont_kbis").show();
    $("#cont_rib").show();
    $("#cont_permis").show();
    $("#cont_attestation").show();
    document.getElementById("nom").value = "";
    document.getElementById("email").value = "";
    document.getElementById("tel").value = "";
    document.getElementById("adresse").value = "";
    document.getElementById("cin").value = "";
    document.getElementById("raison_social").value = "";
    document.getElementById("num_permis").value = "";
    document.getElementById("siret").value = "";
    document.getElementById("naf").value = "";
    document.getElementById("tva").value = "";
    document.getElementById("date_creation_entreprise").value = "";
    document.getElementById("permis").value = "";
    document.getElementById("kbis").value = "";
    document.getElementById("rib").value = "";
    document.getElementById("attestation_civile").value = "";
    document.getElementById("comment").value = "";
  } else {
    $("#cont_nom_complet_pro").hide();
    $("#cont_nom_complet_part").show();
    $("#cont_contrat_type").show();
    $("#cont_email").show();
    $("#cont_telephone").show();
    $("#cont_adresse").show();
    $("#cont_raison").hide();
    $("#cont_nom_conducteur_pro").hide();
    $("#cont_numpermisPro").hide();
    $("#cont_numpermisPart").show();
    $("#cont_siret").hide();
    $("#cont_naf").hide();
    $("#cont_tva").hide();
    $("#cont_date_entreprise").hide();
    $("#cont_comment").show();
    $("#cont_cin").show();
    $("#cont_kbis").hide();
    $("#cont_rib").show();
    $("#cont_permis").show();
    $("#cont_attestation").hide();
  }
}

function selectcontratvoiture(data) {
  if (data == "CONTRAT AVENANT") {
    $("#cont_DateDebutContrat").hide();
    $("#cont_DateFinContrat").hide();
    $("#cont_dureeContrat").hide();
    $("#inputDatePrelevementContrat").hide();
    $("#cont_ClientContrat").hide();
    $("#cont_ClientAgenceRet").hide();
    $("#cont_PrixContrat").hide();
    $("#cont_NbreKilometreContrat").hide();
    $("#cont_moyenCaution").hide();
    $("#inputNumCB").hide();
    $("#inputNumChequeCaution").hide();
    $("#cont_ModePaiementContrat").hide();
    $("#cont_contratvehiculeagence").hide();
    $("#materielVoiteur").hide();
    $("#cont_listecontrat").show();
    $("#cont_DateDebutContratAvenant").show();
    $("#cont_DateFinContratAvenant").show();
    $("#materielVoiteurContratAvenant").show();
    $("#cont_ChocheKilometreillimite").hide();
  } else if (data == "CONTRAT CADRE"){
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratvehiculeagence").show();
    $("#materielVoiteur").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#materielVoiteurContratAvenant").hide();
    $("#cont_ChocheKilometreillimite").show();
  }else {
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_NbreKilometreContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratvehiculeagence").show();
    $("#materielVoiteur").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#materielVoiteurContratAvenant").hide();
    $("#cont_ChocheKilometreillimite").hide();
  }
}

function selectcontratmateriel(data) {
  //$("#VoiturePimmMixte").html(data);
  if (data == "CONTRAT") {
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratmaterielagence").show();
    $("#materiel").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#materielContratAvenant").hide();
  } else if (data == "CONTRAT CADRE"){
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratmaterielagence").show();
    $("#materiel").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#materielContratAvenant").hide();
  }else {
    $("#cont_DateDebutContrat").hide();
    $("#cont_DateFinContrat").hide();
    $("#cont_dureeContrat").hide();
    $("#inputDatePrelevementContrat").hide();
    $("#cont_ClientContrat").hide();
    $("#cont_ClientAgenceRet").hide();
    $("#cont_PrixContrat").hide();
    $("#cont_moyenCaution").hide();
    $("#inputNumCB").hide();
    $("#inputNumChequeCaution").hide();
    $("#cont_ModePaiementContrat").hide();
    $("#cont_contratmaterielagence").hide();
    $("#materiel").hide();
    $("#cont_listecontrat").show();
    $("#cont_DateDebutContratAvenant").show();
    $("#cont_DateFinContratAvenant").show();
    $("#materielContratAvenant").show();
  }
}

function selectcontratpack(data) {
  //$("#VoiturePimmMixte").html(data);
  if (data == "CONTRAT") {
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratmaterielagence").show();
    $("#materielPack").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#cont_Cochevehiculemateriel").hide();
    $("#materielPack_ContratAvenant").hide();
    $("#cont_ChocheKilometreillimite").hide();
  } else if (data == "CONTRAT CADRE"){
    $("#cont_DateDebutContrat").show();
    $("#cont_DateFinContrat").show();
    $("#cont_dureeContrat").show();
    $("#inputDatePrelevementContrat").show();
    $("#cont_ClientContrat").show();
    $("#cont_ClientAgenceRet").show();
    $("#cont_PrixContrat").show();
    $("#cont_moyenCaution").show();
    $("#inputNumCB").show();
    $("#inputNumChequeCaution").show();
    $("#cont_ModePaiementContrat").show();
    $("#cont_contratmaterielagence").show();
    $("#materielPack").show();
    $("#cont_listecontrat").hide();
    $("#cont_DateDebutContratAvenant").hide();
    $("#cont_DateFinContratAvenant").hide();
    $("#cont_Cochevehiculemateriel").hide();
    $("#materielPack_ContratAvenant").hide();
    $("#cont_ChocheKilometreillimite").show();
  }else {
    $("#cont_DateDebutContrat").hide();
    $("#cont_DateFinContrat").hide();
    $("#cont_dureeContrat").hide();
    $("#inputDatePrelevementContrat").hide();
    $("#cont_ClientContrat").hide();
    $("#cont_ClientAgenceRet").hide();
    $("#cont_PrixContrat").hide();
    $("#cont_moyenCaution").hide();
    $("#inputNumCB").hide();
    $("#inputNumChequeCaution").hide();
    $("#cont_ModePaiementContrat").hide();
    $("#cont_contratmaterielagence").hide();
    $("#materielPack").hide();
    $("#cont_listecontrat").show();
    $("#cont_DateDebutContratAvenant").show();
    $("#cont_DateFinContratAvenant").show();
    $("#cont_Cochevehiculemateriel").show();
    $("#materielPack_ContratAvenant").show();
    $("#cont_ChocheKilometreillimite").hide();
  }
}

function selectrole(data) {
  if (data == "admin") {
    $("#cont_UserAgence").show();
    document.getElementById("nom_user").value = "";
    document.getElementById("login").value = "";
    document.getElementById("password").value = "";
    document.getElementById("id_agence").value = "";
  } else {
    $("#cont_UserAgence").hide();
  }
}
/*
 * view_deleteMaterielRecord
 */
function view_deleteMaterielRecord() {
  $.ajax({
    url: "viewdeletemateriel.php",
    method: "post",
    success: function (data) {
      data = $.parseJSON(data);
      if (data.status == "success") {
        $("#tableSettingmateriel").html(data.html);
      }
    },
  });
}


/*
 * End view_deleteMaterielRecord
 */

/*
 *delete_Settingmaterielgrprecord
 */

function delete_Settingmaterielgrprecord() {
  $(document).on("click", "#btn_delete_materielgrp", function () {
    var Delete_ID = $(this).attr("data-id8");
    $.ajax({
      url: "deleteSettingmaterielgrp.php",
      method: "post",
      data: {
        Del_ID: Delete_ID
      },
      success: function (data) {
        view_deleteMaterielRecord();
        view_group_pack_record();

      },
    });
  });
}


/*
 *  end delete_Settingmaterielgrprecord
 */



MaterielQtiDispo();


function MaterielQtiDispo() {
  $.ajax({
    type: "post",
    url: "selectMaterielQtiDispo.php",
    data: {},
    success: function (data) {

      $("#QTIdispo").html(data);
    },
  });
}