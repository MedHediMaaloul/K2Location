<?php
if (isset($_GET['id'])){

  include("../Gestion_location/inc/connect_db.php");
  $id_client = $_GET['id'];
  $query = "SELECT C.id_contrat,C.moyen_caution,C.caution,C.cautioncheque,C.num_cheque_caution,C.num_cb_caution,C.duree,C.id_client,C.type_location,C.num_contrat,
  C.date_debut,C.date_fin,C.prix,C.assurance,C.mode_de_paiement,C.NbrekmInclus,C.date_ajoute,
  CL.id_client,CL.nom,CL.nom_entreprise,CL.email,CL.tel,CL.adresse,CL.cin,
  V.type,V.pimm,V.id_voiture,
  MM.Model,MM.Marque,
  A.lieu_agence
  FROM contrat_client AS C 
  LEFT JOIN client AS CL ON C.id_client =CL.id_client 
  LEFT JOIN voiture AS V on C.id_voiture = V.id_voiture
  LEFT JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel 
  LEFT JOIN agence as A on C.id_agence=A.id_agence
  WHERE  C.type_location = 'Vehicule'
  AND C.id_client =CL.id_client
  AND C.id_contrat = $id_client";
  
  $result = mysqli_query($conn, $query);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $Contrat_number = $row['id_contrat'];
                  $Contrat_date_debut = $row['date_debut'];
                  $Contrat_date_debut = date("d-m-Y", strtotime($Contrat_date_debut));
                  $Contrat_date_fin = $row['date_fin'];
                  $Contrat_date_fin = date("d-m-Y", strtotime($Contrat_date_fin));
                  
                  $Contrat_price = $row['prix'];
                  $Contrat_moyen_caution = $row['moyen_caution'];
                  $cautioncb = $row['caution'];
                  $cautioncheque = $row['cautioncheque'];
                  if ($Contrat_moyen_caution == "Carte bancaire"){
                    $Contrat_caution = $cautioncb;
                  }else if($Contrat_moyen_caution == "Cheque"){
                    $Contrat_caution = $cautioncheque;
                  }else{
                    $Contrat_caution = $cautioncb + $cautioncheque;
                  }
                  $Contrat_num_caution_cheque = $row['num_cheque_caution'];
                  $Contrat_num_caution_cb = $row['num_cb_caution'];
                  $Contrat_mode_paiement = $row['mode_de_paiement'];
                  $Contrat_duration = $row['duree'];
                  $Contrat_km = $row['NbrekmInclus'];
  
                  $Conducteur_name = $row['nom'];
                  $Entreprise_name = $row['nom_entreprise'];
                  if ($Entreprise_name == ""){
                    $Client_name = $Conducteur_name;
                  }else if($Conducteur_name == ""){
                    $Client_name = $Entreprise_name;
                  }else{
                    $Client_name = $Conducteur_name . " ( " . $Entreprise_name . " ) ";
                  }
                  
                  $Client_mail = $row['email'];
                  $Client_tel = $row['tel'];
                  $Client_adress = $row['adresse'];
  
                  $Vehicule = $row['type'];
                  $Vehicule_model = $row['Model'];
                  $Vehicule_marque = $row['Marque'];
                  $Vehicule_imm = $row['pimm'];

                  $Lieu_agence = $row['lieu_agence'];
              }
          }


require('fpdf.php');

class PDF extends FPDF
{
protected $col = 0; // Colonne courante
protected $y0;      // Ordonnée du début des colonnes
function Header()
{
    global $titre;
        $this->SetFont('Arial','B',12);
        $w = $this->GetStringWidth($titre)+20;
        $this->SetX((310-$w)/8);
        $this->Cell($w,35,utf8_decode($titre),0,1,'C',false);
        $this->Ln(-13);
        $this->y0 = $this->GetY(); 
}
function Footer()
{
    // Pied de page
    $this->SetY(-15);
    $texte = "k2 Group SAS au capital de 146.000 euro - RC DIJON:4669B
    7 RUE JEAN BAPTISTE SAY 21800 CHEVIGNY ST SAUVEUR
    Siret: 88236307000013 TVA: FR59882363090 APE: 4669B";
    $this->SetFont('Arial','B',6);
    $this->MultiCell(0,3,utf8_decode($texte),0,'C');
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(128);
    $this->Cell(0,0,"Page ".$this->PageNo(),0,0,'R');
  
}
function SetCol($col)
{
    // Positionnement sur une colonne
    $this->col = $col;
    $x = 10 + $col * 50;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}
function AcceptPageBreak()
{
    // Méthode autorisant ou non le saut de page automatique
    if($this->col<3)
    {
        // Passage à la colonne suivante
        $this->SetCol($this->col+1);
        // Ordonnée en haut
        $this->SetY($this->y0);
        // On reste sur la page
        return false;
    }
    else
    {
        // Retour en première colonne
        $this->SetCol(0);
        // Saut de page
        return true;
    }
}
function printTableHeader($header,$w){
	//Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(0);
	$this->SetDrawColor(0,0,0);
	$this->SetFont('Arial','B',9);
	for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],'LRT',0,'C');
	$this->Ln();
	//Restauration des couleurs et de la police pour les données du tableau
	$this->SetFillColor(245,245,245);
	$this->SetTextColor(0);
	$this->SetFont('Arial');
 
}
function table($header,$w,$al,$datas){
	//Impression de l'entête tableau
	$this->SetLineWidth(.3);
	$this->printTableHeader($header,$w);
 
	$posStartX=$this->getX();	
	$posBeforeX=$posStartX;
 
	$posBeforeY=$this->getY();
	$posAfterY=$posBeforeY;
	$posStartY=$posBeforeY;
 
	//On parcours le tableau des données
	foreach($datas as $row){
		$posBeforeX=$posStartX;
		$posBeforeY=$posAfterY;
 
		//On vérifie qu'il n'y a pas débordement de page.
		$nb=0;
		for($i=0;$i<count($header);$i++){
			$nb=max($nb,$this->NbLines($w[$i],$row[$i]));
		}
		$h=6*$nb;
 
		//Effectue un saut de page si il y a débordement
		$resultat = $this->CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY);
		if($resultat>0){
			$posAfterY=$resultat;
			$posBeforeY=$resultat;
			$posStartY=$resultat;
		}
 
		//Impression de la ligne
		for($i=0;$i<count($header);$i++){
			$this->MultiCell($w[$i],6,strip_tags($row[$i]),'',$al[$i],false);
			//On enregistre la plus grande hauteur de cellule
			if($posAfterY<$this->getY()){
				$posAfterY=$this->getY();
			}
			$posBeforeX+=$w[$i];
			$this->setXY($posBeforeX,$posBeforeY);
		}
		//Tracé de la ligne du dessous
		$this->Line($posStartX,$posAfterY,$posBeforeX,$posAfterY);
		$this->setXY($posStartX,$posAfterY);
	}
 
	//Tracé des colonnes
	$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
}
function PrintCols($w,$posStartX,$posStartY,$posAfterY){
	$this->Line($posStartX,$posStartY,$posStartX,$posAfterY);
	$colX=$posStartX;
	//On trace la ligne pour chaque colonne
	foreach($w as $row){
		$colX+=$row;
		$this->Line($colX,$posStartY,$colX,$posAfterY);
	}
}
function CheckPageBreak($h,$w,$header,$posStartX,$posStartY,$posAfterY){
	//Si la hauteur h provoque un débordement, saut de page manuel
	if($this->GetY()+$h>$this->PageBreakTrigger){
		//On imprime les colonnes de la page actuelle
		$this->PrintCols($w,$posStartX,$posStartY,$posAfterY);
		//On ajoute une page
		$this->AddPage();
		//On réimprime l'entête du tableau
		$this->printTableHeader($header,$w);
		//On renvoi la position courante sur la nouvelle page
		return $this->GetY();
	}
	//On a pas effectué de saut on revoie 0
	return 0;
}
function NbLines($w,$txt){
  $cw=&$this->CurrentFont['cw'];
  if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
  $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
  $s=str_replace("\r",'',$txt);
  $nb=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
      $nb--;
  $sep=-1;
  $i=0;
  $j=0;
  $l=0;
  $nl=1;
  while($i<$nb)
  {
      $c=$s[$i];
      if($c=="\n")
      {
          $i++;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
          continue;
      }
      if($c==' ')
          $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax)
      {
          if($sep==-1)
          {
              if($i==$j)
                  $i++;
          }
          else
              $i=$sep+1;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
      }
      else
          $i++;
  }
  return $nl;
}
function CorpsChapitre()
{
    // Lecture du fichier texte
    $context = stream_context_create(array(
        'http' => array('ignore_errors' => true),
    ));    
    $fichier = 'http://15.236.8.125/fpdf/conditiongeneral.txt';
    $txt = file_get_contents($fichier, false, $context);
    $this->Image('logok2.jpg',10,13,20,15);
    // Police
    $this->SetFont('Arial','',5.4);
    // Sortie du texte sur 6 cm de largeur
    $this->MultiCell(47,2.4,utf8_decode($txt));
    $this->Ln();
    // Mention
    $this->SetFont('','B','I');
    $this->Cell(0,"2","Paraphe");
    // Retour en première colonne
    $this->SetCol(0);
}

function AjouterChapitre($num, $titre)
{
    // Ajout du chapitre
    $this->AddPage();
    // $this->TitreChapitre($num,$titre);
    $this->CorpsChapitre();
}
function VerifPage()
{
  if( (($this->GetY())==0) | (($this->GetY())>=240) ) {
    $this->AddPage();
  }
}
}

$pdf = new PDF('P','mm','A4');
// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
define('EURO',chr(128));
$pdf->SetTitle(utf8_decode("Contrat Véhicule_N°':".$Contrat_number."_".$Client_name));
$pdf->Image('logok2.jpg',10,15,20,15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,4,utf8_decode('CONTRAT DE LOCATION N°'). $Contrat_number,0,2,'',false);

$position=$pdf->getY();

if($pdf->getY()>$position){
  $position=$pdf->getY();
}
$pdf->SetXY(10,$position+2);

//Tableau
$position=0;
$prixTotal=0;
$prixTotalHorsTaxes=0;
$totalTtc=0;
//Création des données qui seront contenues la table
$datas = array();
$datas[] = array("Nom: ".$Client_name."\n"."Mail: ".$Client_mail."\n"."Tel: ".$Client_tel."\n"."Adresse: ".utf8_decode($Client_adress),utf8_decode("Véhicule: ".$Vehicule."\n"."Marque: ".$Vehicule_marque." ".$Vehicule_model."\n"."Immatriculation: ".$Vehicule_imm));
//Tableau contenant les titres des colonnes
$header=array(utf8_decode('INFORMATIONS CLIENT'),utf8_decode('INFORMATIONS VÉHICULE'));
//Tableau contenant la largeur des colonnes
$w=array(90,100);
//Tableau contenant le centrage des colonnes
$al=array('L','L');
//Génération de la table à proprement dite
$pdf->table($header,$w,$al,$datas);

$pdf->SetY($pdf->GetY()+10);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,'CONDITIONS PARTICULIERES',0,0,'C');
$pdf->SetY($pdf->GetY()+8);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte1 = "Le locataire reconnait que le matériel loué a bien un rapport direct avec son activité et que ce faisant le code de la consommation ne s'applique pas. Le loueur et le locataire certifient, attestent et conviennent que le matériel est livré ce jour, qu'il est conforme à sa désignation, aux prescriptions des règlements d'hygiène et de sécurité du travail, qu'il est en bon état de fonctionnement sans vice apparent ou caché et répond aux besoins du locataire, qu'il n'est pas contrefaisant et qu'il est conforme à la réglementation relative à la pollution et à la protection de l'environnement.";
$pdf->MultiCell(0,5,utf8_decode($texte1));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,'AUTRES INFORMATIONS',0,0);
$pdf->SetY($pdf->GetY()+8);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->Cell(0,0,utf8_decode('État du véhicule:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte2 = "Lors de la remise du véhicule et lors de sa restitution, une fiche de contrôle de l'état du véhicule sera établie entre le locataire et le loueur. Le véhicule devra être restitué dans le même état que lors de sa mise à disposition au locataire. Toutes les détériorations constatées sur le véhicule seront à la charge du locataire, et/ou être déduites en partie ou totalité sur le montant de la caution.";
$pdf->MultiCell(0,5,utf8_decode($texte2));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Durée:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$pdf->MultiCell(0,5,"Du"." ".$Contrat_date_debut." "."au"." ".$Contrat_date_fin);
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Prix de location:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$Contrat_price_ttc = $Contrat_price + $Contrat_price* 0.2 ;
if ($Contrat_duration == "Standard") {
        $texte3 = $Contrat_price. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/mois (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Jour") {
        $texte3 = $Contrat_price. " Euros HT par jour auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/jour (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Semaine") {
        $texte3 = $Contrat_price. " Euros HT par semaine auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/semaine (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "Par Mois") {
        $texte3 = $Contrat_price. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/mois (tarification du kilomètre supplémentaire 0.12 euros HT).";
} else if ($Contrat_duration == "LLD") {
        $texte3 = $Contrat_price. " Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc.
        " euros. "."\n"."Kilométrage prévu ".$Contrat_km." km/mois (tarification du kilomètre supplémentaire 0.12 euros HT).";
}
// $texte3 = $Contrat_price." Euros HT par mois auquel se rajouterons le montant de la TVA (20%), Soit un prix TTC de : ".$Contrat_price_ttc." euros. ";
$pdf->MultiCell(0,5,utf8_decode($texte3));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Mode de paiement:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte4 = "Les loyers sont dus à date échu. Le premier paiement s'effectuera le jour de la mise à disposition du matériel.";
if ($Contrat_mode_paiement == "Virements bancaires"){
    $texte5 = "Des Virements bancaires seront effectués.";
  } else if ($Contrat_mode_paiement == "Carte bancaire") {
    $texte5 = "Des paiements par carte bancaire seront effectués.";
  } else if ($Contrat_mode_paiement == "Prélèvements automatiques") {
    $texte5 = "Des prélèvements automatiques seront effectués.";
  } else if ($Contrat_mode_paiement == "Espèces") {
    $texte5 = "Des paiements en espèces seront effectués.";
  } else {
    $texte5 = "Chèque";
  }
$texte51 = "Toute rupture de contrat avec un engagement minimum de 6 mois, engendre des frais de résiliation à hauteur de 30% de la totalité des factures restantes.";
$pdf->MultiCell(0,5,utf8_decode($texte4)."\n".utf8_decode($texte5)."\n".utf8_decode($texte51));
$pdf->SetY($pdf->GetY()+5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Dépôt de garantie:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte6 = " à titre de dépôt de garantie pour répondre des dégâts qui pourraient être causés aux matériels loués. Le remboursement du dépôt de garantie sera effectué au retour du matériel si celui-ci n'a pas été endommagé."; 
if ($Contrat_moyen_caution == "Carte bancaire"){
  $texte61 = utf8_decode("N° Carte Bancaire de caution : ").$Contrat_num_caution_cb;
} else if ($Contrat_moyen_caution == "Cheque") {
  $texte61 = utf8_decode("N° chèque de caution: ").$Contrat_num_caution_cheque;
} else {
  $texte61 = $cautioncb ." ".chr(128).utf8_decode(" de caution par carte bancaire N° : ").$Contrat_num_caution_cb."\n".$cautioncheque ." ".chr(128).utf8_decode(" de caution par chèque N° : ").$Contrat_num_caution_cheque;
}
// $texte7 = "Pour les contrats avec engagement, toutes ruptures de contrat (que ce soit 6 mois ou 1 ans), engendrons des frais de résiliation à hauteur de 30% de la totalité des factures restantes. ";
$pdf->MultiCell(0,5,utf8_decode("Le locataire verse à K2, une somme de ").$Contrat_caution ." ".chr(128).utf8_decode($texte6)."\n".$texte61);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->SetY($pdf->GetY()+5);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Autres éléments et accessoires:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Sont à charge du locataire les frais suivants :";
$pdf->Cell(0,5,utf8_decode($texte8));
$pdf->SetY($pdf->GetY()+10);
$pdf->Cell(50, 0,utf8_decode("        - Frais d'entretien(lave glace, liquide de refroidissement, adBlue)."));
$pdf->SetY($pdf->GetY()+5);
$pdf->Cell(50, 0,utf8_decode("        - Les frais de carburant, stationnement et de contravention."));
$pdf->SetY($pdf->GetY()+10);
$pdf->Cell(80, 0,utf8_decode("La sous-location du véhicule par le locataire à un tiers est exclue ."));
$pdf->SetY($pdf->GetY()+10);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(0);
$pdf->VerifPage();
$pdf->Cell(0,0,utf8_decode('Clause en cas de litige:'),0,0);
$pdf->SetY($pdf->GetY()+2);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0);
$texte8 = "Les parties conviennent expressément que tout litige pouvant naître de l'exécution du présent contrat relèvera de la compétence du tribunal de commerce de DIJON. Fait en deux exemplaires originaux remis à chacune des parties, A ".$Lieu_agence.", le ";
$pdf->MultiCell(0,5,utf8_decode($texte8).$Contrat_date_debut.".");
$pdf->VerifPage();
$pdf->SetY($pdf->GetY()+10);
$texte9 = "Le locataire soussigné déclare accepter toutes les conditions générales figurant sur les pages suivantes du contrat qui a été établi en autant d'exemplaires que de parties. Signature du contrat et l'autorisation de prélèvement ci-dessous et paraphe de chaque page.";
$pdf->MultiCell(0,5,utf8_decode($texte9));
$pdf->VerifPage();
$pdf->SetY($pdf->GetY()+15);
$Y3 = $pdf->GetY();
$pdf->Line(10, $Y3, 200, $Y3);
$pdf->Line(10, $Y3, 10, $Y3 + 50);
$pdf->Line(100, $Y3, 100, $Y3 + 50);
$pdf->Line(200, $Y3, 200, $Y3 + 50);
$pdf->Line(10, $Y3 + 50, 200, $Y3 + 50);
$pdf->SetY($pdf->GetY()+5);
$y4 = $pdf->GetY();
$x4 = $pdf->GetX();
$texte10 = "             Cachet commercial et signature du LOCATAIRE (client)";
$texte11 = "             précédée de la mention manuscrite Bon pour accord";
$texte12 = "Signature du LOUEUR et Cachet Commercial";
$pdf->Cell($x4 + 100,0,utf8_decode($texte10),0,'C');
$pdf->Cell($x4 + 100,0,utf8_decode($texte12),0,'C');
$pdf->Ln(5);
$pdf->Cell($x4 + 100,0,utf8_decode($texte11),0,'C');
$pdf->Ln(50);
$pdf->SetFont('','B','I');
$x5 = $pdf->GetX();
$pdf->Cell(0,0,"                                                                                                               
                                                                                            Paraphe",0);
$titre = "CONDITIONS GÉNÉRALES DE LOCATION DE MATÉRIEL - K2" ;
// $pdf->AjouterChapitre(1,utf8_decode($titre));
$pdf->Cell(80, 0,utf8_decode($titre));
$txt = "ARTICLE 1 - OBJET
Le loueur loue au client locataire ou à son obligé, le matériel décrit aux clauses et conditions énoncées dans la proposition de location et/ou le contrat de location qu'il accepte et s'engage à observer.
ARTICLE 2 - GÉNÉRALITÉS
2-1 : Pour avoir valeur contractuelle, les présentes conditions générales doivent être expressément mentionnées dans le contrat de location. Les parties contractantes règlent les questions spécifiques dans les conditions particulières du contrat de location.
2-2 : Le loueur met à la disposition du locataire un matériel conforme à la règlementation en vigueur.
2-3 : En garantie de la présente convention, le locataire justifie de son identité en présentant au loueur une pièce d'identité, un KBIS de moins de trois mois, ou une attestation de domicile (quittance EDF ou facture de téléphone de moins de trois mois).
2-4 : La facturation est toujours établie au nom de l'entreprise contractante en deux exemplaires. À la demande du client, le bon de commande peut être joint à la facture, s'il est fourni au loueur en 2 exemplaires.
Pour les demandes d'ouverture de compte et facturation fin de mois, le locataire doit fournir un extrait K BIS de moins de 3 mois et un RIB.
2-5 : Un bon de commande engage le locataire quel que soit le porteur ou le signataire.
2-6 : Tout détenteur de matériel dépourvu d'un contrat de location dûment établi et signé par le loueur peut être poursuivi pour détournement ou vol de matériel.
2-7 : Le locataire procède à toutes démarches auprès des autorités compétentes pour obtenir les autorisations de faire circuler le matériel loué sur le chantier, et/ou le faire stationner sur la voie publique.
ARTICLE 3 - MISE À DISPOSITION
La signature du contrat est préalable à la mise à disposition du matériel. Lorsque cela est impossible, le locataire s'engage à retourner le contrat adressé par le loueur, signé de sa main.
La personne prenant le matériel à l'agence ou le réceptionnant en un autre lieu pour le compte du locataire est présumée habilitée.
3-1 : Le matériel.
Le matériel, ses accessoires, et tout ce qui en permet un usage normal, sont mis à disposition au locataire en bon état de marche, nettoyé et graissé et muni, le cas échéant, de liquide de refroidissement.
Le locataire est en droit de refuser le matériel si le loueur ne fournit pas les documents exigés par la règlementation ainsi que toutes les consignes techniques nécessaires.
La prise de possession du matériel transfère la garde juridique du matériel au locataire.
3-2 : État du matériel lors de la mise à disposition
A la demande de l'une ou l'autre des parties, un état contradictoire peut être établi aux frais exclusifs du locataire.
Si cet état contradictoire fait apparaitre l'incapacité du matériel à remplir sa destination normale, ledit matériel est considéré comme non conforme à la commande.
En l'absence du locataire lors de la réception, ce dernier doit faire état au loueur, dans la 1/2 journée suivant la réception, de ses réserves écrites, des éventuels vices apparents et/ou des non-conformités à la commande.
A défaut de telles réserves, le matériel est réputé conforme aux besoins émis par le locataire et en parfait état de fonctionnement.
2-3 : Date de mise à disposition
Le contrat de location peut prévoir, au choix des parties, une date de livraison ou d'enlèvement. La partie chargée d'effectuer la livraison ou l'enlèvement doit avertir l'autre partie de sa venue avec un préavis raisonnable. 
ARTICLE 4 - DURÉE DE LOCATION
4-1 : La location part du jour de la mise à disposition au locataire du matériel loué et de ses accessoires. Elle prend fin le jour où le matériel loué et ses accessoires sont restitués au loueur.
Ces dates sont fixées dans le contrat de location.
4-2 : La durée prévisible de la location, à partir d'une date initiale, peut être exprimée en toute unité de temps. Toute modification de cette durée doit faire l'objet d'un nouvel accord entre les parties.
4-3 : Dans le cas d'impossibilité de déterminer de manière précise la durée de location, cette dernière peut également être conclue sans terme précis. Dans ce cas, la réputation est présumée avoir été conclue pour une durée indéterminée.
4-4 : Pour toute prolongation du contrat de location au-delà du délai convenu, le locataire devra notifier sa volonté de prolonger au loueur dans un délai de 2 jours ouvrés avant le terme du contrat en cours.
Dans le cadre d'un contrat au moins égal ou supérieur à 6 mois, le délai de prévenance sera porté à 10 jours ouvrés.
4-4 : Le locataire s'engage à retourner le contrat de prolongation signé en original au loueur dans un délai maximal de 2 jours ouvrés suivant réception.
Faute de quoi, des frais de gestion administrative sont susceptibles d'être appliqués.
À défaut de réception du contrat dans un délai de 7 jours ouvrés, le loueur se réserve la possibilité de résilier le contrat dans les conditions prévues à l'article 17.
ARTICLE 5 - CONDITIONS D'UTILISATION
5-1 : Nature de l'utilisation
5-1-1 : Le locataire doit informer le loueur des conditions spécifiques d'utilisation du matériel loué afin que lui soient précisées les règles d'utilisation et de sécurité fixées tant par la règlementation applicable que par le constructeur et/ou le loueur.
5-1-2 : Le matériel doit être confié à un personnel dûment qualifié et muni des autorisations requises.
Le matériel doit être maintenu en bon état de marche et utilisé en respectant les règles d'utilisation et de sécurité visées au 5-1-1.
5-1-3 : Le locataire s'interdit de sous-louer et/ou de prêter le matériel sans l'accord du loueur.
Cependant, dans le cadre d'interventions liées au secours, le loueur ne peut s'opposer à l'utilisation par d'autres entreprises du matériel loué. Le locataire reste néanmoins tenu aux obligations du contrat.
En outre, dans le cadre des chantiers soumis à coordination sécurité, protection de la santé (SPS), le plan général de coordination (PGCSPS) peut prévoir l'utilisation des matériels par d'autres entreprises. Le loueur ne peut s'y opposer mais le locataire reste néanmoins tenu aux obligations du contrat.
5-1-4 : Toute utilisation, non conforme à la déclaration préalable du locataire ou à la destination normale du matériel loué, donne au loueur le droit de résilier le contrat de location, et d'exiger la restitution du matériel.
5-2 : Durée de l'utilisation
Le matériel loué peut être utilisé à discrétion, dans le respect des conditions particulières pendant une durée journalière théorique de 8 heures ou d'une durée mensuelle de 168 heures ou encore pour un kilométrage journalier de 100 km maximum.
Toute utilisation supplémentaire fait obligation au locataire d'en informer le loueur et peut entrainer un supplément de loyer définit par le contrat.
Au-delà de huit heures d'utilisation, un tarif dégressif est appliqué par tranche de huit heures supplémentaires. 
5-3 : Il est interdit d'utiliser du carburant GNR (gazole non routier - Produit détaxé) pour les véhicules routiers appartenant au loueur.
5-4 : : Le locataire s'interdit de céder, donner en gage ou en nantissement le matériel loué.
5-5 : Le locataire doit informer aussitôt le loueur si un tiers tente de faire valoir des droits sur le matériel loué, sous la forme d'une revendication, d'une opposition ou d'une saisie.
5-6 : Le locataire ne peut enlever ou modifier ni les plaques de propriété apposées sur le matériel loué, ni les inscriptions portées par le loueur. Le locataire ne peut ajouter aucune inscription ou marque sur le matériel loué sans autorisation du loueur.
ARTICLE 6 - TRANSPORT
6-1 : Le transport du matériel loué, à l'aller comme au retour, est effectué sous la responsabilité de celle des parties qui l'exécute ou le fait exécuter.
6-2 : La partie qui fait exécuter le transport exerce le recours éventuel contre le transporteur. Il appartient donc à cette partie de vérifier que tous les risques, aussi bien les dommages causés au matériel que ceux occasionnés par celui-ci, sont couverts par une assurance suffisante du transporteur et, à défaut, de prendre toutes mesures utiles pour assurer le matériel loué.
6-3 : Le coût du transport du matériel loué est, à l'aller comme au retour, à la charge du locataire, sauf disposition contraire aux conditions particulières.
Dans l'hypothèse où le transport est effectué par un tiers, il appartient à celui qui l'a missionné de prouver qu'il l'a effectivement réglé. Dans le cas contraire, les comptes entre le loueur et le locataire seront réajustés en conséquence.
6-4 : La responsabilité du chargement et/ou du déchargement et/ou de l'arrimage incombe à celui ou ceux qui les exécutent.
Le préposé au chargement et/ou au déchargement du matériel loué doit, si nécessaire, avoir une autorisation de conduite de son employeur pour ce matériel.
6-5 : Dans tous les cas, lorsqu'un sinistre est constaté à l'arrivée du matériel, le destinataire doit aussitôt formuler les réserves légales auprès du transporteur et en informer l'autre partie afin que les dispositions conservatoires puissent être prises sans retard, et que les déclarations de sinistre aux compagnies d'assurances puissent être faites dans les délais impartis.
6-6 : Le lieu de livraison et de reprise du matériel est celui indiqué au contrat lorsque le loueur en a la charge.
En cas d'absence du locataire sur le site de livraison à l'horaire convenu, le loueur a la faculté de ne pas laisser le matériel ; le cas échéant, les frais de transport (aller et retour) et de manutention sont dus par le locataire. 
ARTICLE 7 - INSTALLATION, MONTAGE, DÉMONTAGE
7-1 : L'installation, le montage et le démontage (lorsque ces opérations s'avèrent nécessaires) sont effectués sous la responsabilité du locataire et par ce dernier.
L'intervention éventuelle du personnel du loueur est limitée à sa compétence et ne peut en aucun cas avoir pour effet de réduire la responsabilité du locataire, notamment en matière de sécurité.
En tout état de cause l'intervention du loueur ou de ses préposés dans les opérations d'installation de montage ou de démontage devra faire l'objet d'un contrat séparé.
Le branchement du matériel électrique et les mises à la terre sont effectués par le client et sous sa responsabilité, y compris quand le montage ou l'installation est confié aux soins du loueur.
Pour la mise en place et la pose des constructions mobiles, le locataire est tenu de prévoir des cales et des aires de terrain aménagées.
7-2 : L'installation, le montage et le démontage ne modifient pas la durée de la location.
ARTICLE 8 - ENTRETIEN DU MATÉRIEL
8-1 : Le locataire procède régulièrement à toutes les opérations courantes d'entretien, de nettoyage, de vérification et d'appoint (graissage, carburant, huiles, antigel, pression et état des pneumatiques, etc..).
8-2 : Le loueur est tenu au remplacement des pièces d'usure dans le respect des règles environnementales.
8-3 : Le locataire réserve au loueur un temps suffisant, dans un endroit accessible, pour permettre à celui-ci de procéder à ces opérations. Les dates et durées d'interventions sont arrêtées d'un commun accord. Sauf stipulations contraires mentionnées dans les conditions particulières, le temps nécessité par l'entretien du matériel à la charge du loueur fait partie intégrante de la durée de location telle que définie à l'article 4.
ARTICLE 9 - PANNES, RÉPARATIONS
9-1 : Le locataire informe le loueur, par tout moyen écrit à sa convenance, en cas de panne immobilisant le matériel pendant la durée de la location.
Le loueur dispose dès lors d'un délai de diagnostic technique de 24 heures à l'issue duquel il devra être trouvé une solution de réparation ou de remplacement sous 72 heures.
Il est entendu que ces délais sont décomptés sur les jours ouvrés uniquement et hors cas de force majeure pour toute demande reçue avant 17 heures.
Faute de quoi le locataire serait en droit de solliciter la résiliation du contrat, sous réserves expresses de restitution du matériel et de paiement des sommes échues.
9-2 : Toutefois, les pannes d'une durée inférieure ou égale à quatre heures ne modifient pas les conditions du contrat.
9-3 : Aucune réparation ne peut être entreprise par le locataire, sans l'autorisation préalable écrite du loueur.
9-4 : Les réparations en cas d'usure anormale ou rupture de pièces dues à une utilisation non conforme, un accident ou à une négligence sont à la charge du locataire.
9-5 : Aucune indemnité complémentaire, de quelque nature que ce soit (perte d'exploitation, perte de location...), ne peut être ne peut être réclamée par le locataire.
ARTICLE 10 - OBLIGATIONS ET RESPONSABILITÉS DES PARTIES
10-1 : Le locataire a la garde juridique du matériel loué pendant la durée de mise à disposition ; il engage sa responsabilité de ce fait sous réserve des clauses concernant le transport.
10-2 : Le locataire ne peut :
- employer le matériel dans un autre lieu ou zone que ce qui est indiqué dans le contrat,
- employer le matériel loué à un autre usage que celui auquel il est normalement destiné,
- utiliser le matériel dans des conditions différentes de celles pour lesquelles la location a été faite,
- enfreindre les règles de sécurité fixées tant par la règlementation en vigueur que par le constructeur et/ou le loueur,
- utiliser le matériel sur des chantiers soumis à obligation de décontamination systématique desdits matériels. 
ARTICLE 11 - DOMMAGES CAUSÉS AUX TIERS (ASSURANCE 'RESPONSABILITÉ CIVILE')
11-1 : Véhicule terrestre à moteur (VTAM) :
Obligations du loueur :
Lorsque le matériel loué est un VTAM au sens de l'article L. 110-1 du Code de la route, le loueur doit obligatoirement avoir souscrit un contrat d'assurance automobile conforme aux articles L. 211-1 et suivants du Code des assurances. Ce contrat couvre les dommages causés aux tiers par le matériel loué dès lors qu'il est impliqué dans un accident de la circulation.
Le loueur doit remettre à la 1ère demande du locataire, une photocopie de son attestation d'assurance en vigueur.
Les dommages occasionnés aux biens appartenant au locataire et à ses préposés resteront exclus de la couverture en responsabilité civile de circulation garantie par le loueur.
11- 2 : Obligations du locataire 
Le locataire s'engage à déclarer au loueur, dans les 48 heures, par lettre recommandée avec accusé de réception, tout accident causé par le véhicule ou dans lequel le véhicule est impliqué, afin que le loueur puisse effectuer auprès de son assureur, sa déclaration de sinistre dans les cinq jours.
Le locataire reste responsable des conséquences d'un retard ou d'une absence de déclaration.
L'assurance responsabilité automobile souscrite par le loueur ne dispense pas le locataire de souscrire une assurance « Responsabilité Civile Entreprise », afin de garantir notamment les dommages causés aux tiers par les VTAM loués lorsqu'ils ne sont pas impliqués dans un accident de la circulation.
11-3 : Autres matériels :
Le locataire et le loueur doivent être couverts, chacun pour sa responsabilité, par une assurance « Responsabilité Civile Entreprise » pour les dommages causés aux tiers par le matériel loué.
Le locataire se conformera aux dispositions de l'article 12-1 ci-après pour effectuer ses déclarations de sinistres. 
ARTICLE 12 - DOMMAGES AU MATÉRIEL LOUÉ (ASSURANCES 'BRIS DE MACHINE, INCENDIE, VOL...') 
12-1 : En cas de dommages, le loueur invite le locataire à procéder à un constat amiable et contradictoire, qui doit intervenir dans un délai de 3 jours ouvrés.
En cas d'accident ou tout autre sinistre, le locataire s'engage à :
1- Informer le loueur (agence ayant établi le contrat) dans les 48 heures par lettre recommandée,
2- Faire établir dans les 48 heures auprès des autorités de police, en cas d'accident corporel, vol ou dégradation par vandalisme, une déclaration mentionnant les circonstances, date, heure et lieu ainsi que l'identification du matériel,
A défaut, le locataire encourt la déchéance des garanties qu'il aurait souscrites au titre de l'article 12-4 ci-après. 
12-2 : Le locataire peut couvrir sa responsabilité pour les dommages causés au matériel loué de trois manières différentes :
12-2-1 : En souscrivant une assurance couvrant le matériel pris en location.
Cette assurance peut être spécifique pour le matériel considéré ou annuelle et couvrir tous les matériels que le locataire prend en location. Elle doit être souscrite au plus tard le jour de la mise à disposition du matériel loué et doit être maintenue pendant la durée du présent contrat de location.
Le locataire doit informer le loueur de l'existence d'une telle couverture d'assurance. En début d'année ou au plus tard au moment de la mise à disposition du matériel, le locataire adresse l'attestation d'assurance correspondant au contrat souscrit, comportant notamment l'engagement pris par la compagnie d'assurances de verser l'indemnité entre les mains du loueur, les références du contrat qu'il a souscrit, le montant des garanties et des franchises.
Les éventuelles limites, exclusions et franchises d'indemnisation résultant du contrat d'assurance souscrit par le locataire sont inopposables au loueur au regard des engagements du contrat.
En cas de dommage au matériel, le locataire et ses assureurs renoncent à tous recours contre le loueur et ses assureurs.
12-2-2 : En acceptant, pour la couverture « Bris de machines », la renonciation à recours du loueur et de son assureur moyennant un coût supplémentaire.
Dans ce cas, le loueur doit clairement informer le locataire sur les limites exactes de l'engagement pris, notamment sur :
- les montants des garanties,
- les franchises,
- les exclusions,
- les conditions de la renonciation à recours de l'assurance contre le locataire.
Toute limite non mentionnée au contrat est alors inopposable au locataire.
Les conditions de la renonciation à recours du Loueur sont énoncées à l'article 12-4 ci-après.
12-2-3 : En restant son propre assureur sous réserve de l'acceptation du loueur.
A défaut d'acceptation du loueur, le locataire :
- soit, souscrit une assurance couvrant le matériel pris en location dans les conditions prévues à l'article 12-2.1,
- soit, accepte les conditions du loueur, prévues à l'article 12-2.2 & 12-4.
12-3 : Dans le cas où le locataire assure le matériel auprès d'une compagnie d'assurances ou sur ses propres deniers, le préjudice est évalué :
- pour le matériel réparable : suivant le montant des réparations.
- pour le matériel non réparable ou volé : à partir de la valeur à neuf, déduction faite d'un coefficient d'usure fixé à dire d'expert ou à défaut dans les conditions particulières.
Indemnisation du loueur hors application de l'article 12-4.
En cas de dommage, vol ou perte du matériel, le contrat de location prend fin le jour de la réception de la déclaration du sinistre faite par le locataire.
L'indemnisation du matériel par le locataire au bénéfice du loueur est faite sans délai, sur la base de la valeur de remplacement par un matériel neuf à la date du sinistre (valeur catalogue), et après déduction d'un pourcentage de vétusté de 10% par an plafonné à 50%. Pour les matériels ayant moins d'un an, la déduction de vétusté est de 0,83% par mois d'ancienneté. Dans tous les cas, le locataire est redevable d'une indemnisation forfaitaire minimum de 250 euros Hors taxes.
L'indemnisation versée par le locataire n'entraîne pas la vente du matériel endommagé, qui reste la propriété exclusive du loueur.
Le loueur décide seul de procéder ou non à la réparation.
Le locataire exerce les recours contre sa compagnie d'assurances a posteriori.
12-4 : Garantie bris de machines-vol
Conformément à l'article 12-2-2, le loueur propose au locataire une renonciation à recours dans les termes suivants :
12-4-1 : Étendue de la garantie
Sont couvert les dommages causés au matériel dans le cadre d'une utilisation normale. Exemple :
- les bris ou destruction accidentels, soudains et imprévisibles,
- les bris dus à une chute ou pénétration de corps étrangers, ne relevant pas de la RC circulation, - les inondations, tempêtes et autres évènements naturels à l'exclusion des tremblements de terre et éruptions volcaniques,
- les dommages électriques, courts-circuits, surtensions,
- les incendies, foudres, explosions de toutes sortes.
Est couvert le vol lorsque le locataire a pris les mesures élémentaires de protection (exemple : chaînes, antivols, cadenas, sabots de Denver, timon démonté, clés restituées au loueur ...)
En dehors des heures d'utilisation du matériel, la garantie est acquise quand :
- le matériel est fermé à clé et stationné dans un endroit clos, et
- les clés et les papiers ne sont pas laissés avec le matériel
Étendue géographique : France métropolitaine.
12-4-2 : Exclusions de la garantie de l'article 12-4-1
Sont exclus de la garantie visée à l'article 12-4-1 :
- les dommages consécutifs à une négligence caractérisée ou intentionnelle, au non-respect des préconisations constructeur,
- les dommages causés par du personnel non qualifié ou non autorisé,
- les crevaisons de pneumatiques, les parties démontables, batteries, vitres, feux, boîte à documents, etc...
- le vol lorsque le matériel est laissé sans surveillance ni protection,
- la perte du matériel,
- les désordres consécutifs à des actes de vandalisme tels que graffitis, détériorations....
- les opérations de transport et celles attachées (grutage, remorquage) ; l'exclusion ne s'applique pas aux remorques prises en location,
- les frais engagés pour dégager le matériel endommagé (grutage, remorquage...) même lorsque ces opérations sont effectuées par le loueur à la demande du locataire,
- les dommages au matériel en circulation ou transporté lorsque c'est la conséquence directe du non-respect des hauteurs sous pont et/ou du code de la route.
Le cas échéant, les dispositions de l'article 12-3 s'appliquent. En outre, le loueur se réserve la possibilité d'un recours à l'encontre du tiers responsable ou de sa compagnie d'assurances.
12-4-3 : Tarification
Cas général : la tarification est faite au taux de 8% du tarif de base du prix de la location, par jour de mise à disposition, week-end et jours fériés compris.
Cas particulier des matériels d'élévation de personnes, des plateformes suspendues, des véhicules et des groupes électrogènes : la tarification est faite au taux de 10% du tarif de base du prix de la location, par jour de mise à disposition, week-end et jours fériés compris.
12-4-4 : Quote-part restant à la charge du locataire :
Matériel réparable : 15 % du montant des réparations avec un minimum de 800 euros hors taxes.
Matériel hors service ou volé : 15 % de la valeur de remplacement par un matériel neuf (valeur catalogue) avec un minimum de 1600 euros hors taxes.
12-4-5 : Limite maximum de garantie : 150 000 euros par sinistre.
12-5 : Validité
Le locataire doit être à jour de ses obligations contractuelles pour bénéficier des garanties visées aux articles 12- 4 et notamment de ses obligations déclaratives visées à l'article 12-1. A défaut, le loueur se réserve la possibilité de refuser ou de résilier lesdites garanties en cours de location.
ARTICLE 13 - VÉRIFICATIONS RÉGLEMENTAIRES
13-1 : Le locataire doit mettre le matériel loué à la disposition du loueur ou de toute personne désignée pour les besoins des vérifications règlementaires.
13-2 : Au cas où une vérification règlementaire ferait ressortir l'inaptitude du matériel, cette dernière a les mêmes conséquences qu'une immobilisation.
13-3 : Le coût des vérifications règlementaires reste à la charge du loueur.
13-4 : Le temps nécessaire à l'exécution des vérifications règlementaires fait partie intégrante de la durée de la location dans la limite d'une demi-journée ouvrée.
ARTICLE 14 - RESTITUTION DU MATÉRIEL
14-1 : A l'expiration du contrat de location, quel qu'en soit le motif, éventuellement prorogé d'un commun accord, le locataire est tenu de rendre le matériel en bon état, compte tenu de l'usure normale inhérente à la durée de l'emploi, nettoyé et, le cas échéant, le plein de carburant fait. A défaut, la fourniture de carburant est facturée au locataire et une prestation de nettoyage pourra être facturée.
Le matériel est restitué, sauf accord contraire des parties, au dépôt du loueur pendant les heures d'ouverture de ce dernier.
14-2 : Lorsque le transport retour du matériel est effectué par le loueur ou son prestataire, le loueur et le locataire conviennent par tout moyen écrit de la date et du lieu de reprise du matériel. La garde juridique est transférée au loueur au moment de la reprise, et au plus tard à l'issue d'un délai de 24 heures à compter de la date de reprise convenue.
Pour toute demande faite le vendredi ou la veille de jour férié, la reprise du matériel s'effectue au plus tard le premier jour ouvré suivant.
Le locataire doit tenir le matériel à la disposition du loueur dans un lieu accessible.
14-3 : Le bon de retour ou de restitution, matérialisant la fin de la location est établi par le loueur. Il y est indiqué notamment :
- le jour et l'heure de restitution,
- les réserves jugées nécessaires notamment sur l'état du matériel restitué.
14-4 : Les matériels et accessoires non restitués et non déclarés volés ou perdus sont facturés au locataire sur la base de la valeur à neuf, après expiration du délai de restitution fixé dans la lettre de mise en demeure.
14-5 : Dans le cas où le matériel nécessite des remises en état consécutives à des dommages imputables au locataire, le loueur peut les facturer au locataire après constat contradictoire. 
ARTICLE 15 - PRIX DE LA LOCATION
15-1 : Le prix du loyer est généralement fixé par unité de temps à rappeler pour chaque location, toute unité de temps commencée étant due dans la limite d'une journée.
Le matériel est loué pour une durée minimum d'une journée. La durée de location hebdomadaire est normalement calculée en jours ouvrés (du lundi au vendredi). Le locataire doit informer préalablement et par écrit le loueur pour une utilisation le samedi, dimanche ou jour férié, sauf pour les matériels dont le tarif est indiqué en jour calendaire.
Toute période commencée est due. Le contrat de location prend fin la veille pour tout matériel restitué dans l'entrepôt du loueur avant 8 H 00.
15-2 : Les tarifs sont révisables annuellement sans préavis.
Les valeurs des indices de révision sont celles publiées par l'INSEE et connues à la date de révision du contrat. En cas de modification de l'un de ces indices ou de substitution à l'un d'eux d'un nouvel indice, il sera fait application de l'indice modifié ou venant se substituer. 
En cas de disparition d'un de ces indices, il sera fait application de l'indice économiquement le plus proche. 
15-3 : Le locataire doit informer le loueur, par écrit, de l'annulation d'une réservation de matériel, au plus tard 24 heures avant la date convenue de mise à disposition. À défaut, la location d'une journée sera facturée au locataire.
15-4 : Dans le cas de modification de la durée de location initialement prévue, les parties peuvent renégocier le prix de ladite location.
15-5 : En sus du prix de la location spécifiée dans le contrat de location, les frais de chargement, de transport, de déchargement et de visite du matériel tant à l'aller qu'au retour sont à la charge exclusive du locataire. Le montant de ces frais devra être spécifié dans le contrat de location.
15-6 : Le dépôt de garantie :
Le montant du dépôt de garantie est indiqué, sur le contrat de location. Il est destiné à garantir le loueur du paiement de l'ensemble des sommes dont le locataire serait redevable au titre de l'ensemble des obligations souscrites dans le cadre de la location. En l'absence de toute somme due par le locataire au loueur, le dépôt de garantie lui sera restitué dans un délai maximum de 8 jours ouvrés à compter de la fin de la location le cas échéant sous forme d'annulation de la pré-autorisation bancaire donnée au plus tard lors de la mise à disposition du véhicule.
Dans le cas où le locataire serait redevable envers le loueur de sommes au titre du présent contrat, le locataire autorise expressément le loueur à retenir les sommes dues sur le dépôt de garantie en en justifiant le montant.
15-7 : Indemnité forfaitaire pour frais de recouvrement
Tout professionnel en situation de retard de paiement est redevable de plein droit, d'une indemnité forfaitaire de recouvrement (art. L.441-3 et art. L.441-6 du Code de Commerce), dont le montant est fixé par décret n° 2012-1115 à la somme de 40 euros (article D 441-5 du Code de Commerce).
ARTICLE 16 - PAIEMENT
Toute facture est payable au comptant, sauf délai de paiement précisé au contrat de location.
En cas de contestation de facture, des frais de gestion de litige pourront être réclamés par le loueur. 
Toute somme non payée à échéance entraîne le paiement de pénalités de retard au taux égal à 3 fois le taux d'intérêt légal en cours, et d'une indemnité forfaitaire pour frais de recouvrement d'un montant de 40 euro, ainsi que la déchéance de tous délais de paiement. Après mise en demeure restée sans effet pendant 8 jours, le locataire sera redevable à titre de dommages et intérêts d'une pénalité forfaitaire égale à 15% de la somme impayée TTC.
ARTICLE 17 - RÉSILIATION
17-1 : Contrat à durée déterminée
En cas d'inexécution de ses obligations par l'une des parties, l'autre partie est en droit de résilier le contrat de location sans préjudice des dommages-intérêts qu'elle pourrait réclamer. 
La résiliation prend effet Après l'envoi d'une mise en demeure restée infructueuse après un délai de 08 jours. Le matériel est restitué dans les conditions de l'article 14. L'indivisibilité entre tous les contrats implique que la résolution de l'un d'eux entraîne de plein droit celle des autres, à la discrétion du loueur.
17-2 : Contrat à durée indéterminée
En cas d'inexécution de ses obligations par l'une des parties, l'autre partie est en droit de résilier le contrat de location sans préjudice des dommages-intérêts qu'elle pourrait réclamer. 
La résiliation prend effet Après l'envoi d'une mise en demeure restée infructueuse après un délai de 08 jours. Le matériel est restitué dans les conditions de l'article 14. L'indivisibilité entre tous les contrats implique que la résolution de l'un d'eux entraîne de plein droit celle des autres, à la discrétion du loueur.
Dans ce cas, une indemnité égale à deux mois de location est due au loueur, après restitution du matériel.
17-3 : La résiliation de contrat de toute nature peut également intervenir pour les causes suivantes (non-exhaustives):
- le loueur peut résilier le contrat dès lors que le locataire emploie le matériel dans un autre lieu ou zone que ce qui est indiqué dans le contrat.
- le loueur peut résilier le contrat dès lors que le contrat de location signé ne lui est pas retourné signé par le locataire dans un délai de 7 jours ouvrés.
17-4 : En tout état de cause, le locataire ayant souscrit à un contrat avec un engagement au moins égal ou supérieur à 6 mois demeurera redevable de 30% des loyers restants à échoir jusqu'à la fin du terme initialement convenu.
ARTICLE 18 - PERTES D'EXPLOITATION
Par principe, les pertes d'exploitation, directes et/ou indirectes, ne peuvent pas être prises en charge.
ARTICLE 19 - CLAUSES D'INTEMPÉRIES
En cas d'intempéries dûment constatées et provoquant une non-utilisation de fait du matériel loué, les obligations du loueur et du locataire sont exécutoires en leur totalité, durant un délai qui ne peut être inférieur à 3 jours de location.
À compter du 4ème jour, et sauf convention contraire, le matériel fera l'objet d'une location à un taux réduit correspondant à la charge d'immobilisation dudit matériel. Ce taux sera fixé dans le contrat de location.
Seule une notification par télécopie avant 10 heures chaque jour d'intempérie permet au locataire de se prévaloir du bénéfice de la présente clause.
Une réduction de prix de 50 % sera appliquée à partir du 4ème jour sauf pour les abris de chantier, les matériels loués au mois, en longue durée ou en contrat à durée déterminée.
Le locataire conservera la garde juridique du matériel.
ARTICLE 20 - FRAIS DE GESTION ADMINISTRATIVE
20-1 : En cas de dommage aux tiers ou au matériel loué, des frais de gestion administrative de 20,00 euro TTC seront facturés au locataire.
20-2 : En cas d'incident de paiement, de quelque nature que ce soit (défaut, insuffisance de provisoire ou position débitrice non autorisée d'un compte bancaire...), des frais de gestion de 25,00 euro TTC seront facturés au locataire.
20-3 : En cas défaut de remise des documents contractuels dans les délais prévus à l'article 3, des frais de gestion administrative de 25,00 euro TTC seront facturés au locataire.
ARTICLE 21 - RÉGLEMENT DES LITIGES / CLAUSE ATTRIBUTIVE DE COMPETENCE
Le présent contrat est régi par la loi française et soumis à la juridiction exclusive des tribunaux français. Tout différend relatif aux présentes conditions impliquant un professionnel sera tranché par le Tribunal de Commerce de PARIS auquel les parties attribuent une compétence exclusive, même en cas de référé, d'appel en garantie ou de pluralité de défendeurs. Tout différend relatif aux présentes conditions impliquant un consommateur sera soumis aux règles légales de compétence d'attribution et territoriale.
ARTICLE 22 - TRAITEMENT INFORMATISÉ DES DONNEES PERSONNELLES 
En sa qualité de responsable de traitement, le Loueur collecte des données à caractère personnel concernant le Client ou tout Conducteur autorisé ou tout tiers intervenant dans les opérations de réservation. 
Ces informations sont nécessaires à la gestion du Contrat de location, à la délivrance des services, à la gestion des relations clients et aux relations commerciales. Elles sont également conservées à des fins de sécurité, ou afin de respecter des obligations légales et réglementaires incombant au Loueur. 
Conformément à la Loi Informatique et Libertés et au RGPD, vous disposez des droits suivants : 
-	droit d'accès (article 15 RGPD),
-	droit de rectification (article 16 RGPD), 
-	droit de mise à jour, de complétude de vos données, droit de verrouillage ou d'effacement de vos données à caractère personnel (article 17 RGPD), lorsqu'elles sont inexactes, incomplètes, équivoques, 20 NOVEMBRE 2021 périmées, ou dont la collecte, l'utilisation, la communication ou la conservation est interdite, 
-	droit à la limitation du traitement de vos données (article 18 RGPD),  
-	droit d'opposition au traitement de vos données (article 21 RGPD), 
-	droit à la portabilité des données que vous nous avez fournies, lorsque vos données font l'objet de traitements automatisés fondés sur votre consentement ou sur un contrat (article 20 RGPD), 
-	droit de définir le sort de vos données après votre mort et de choisir que nous communiquions (ou non) vos données à un tiers que vous aurez préalablement désigné. En cas de décès et à défaut d'instructions de votre part, nous nous engageons à détruire vos données, sauf leur conservation s'avère nécessaire à des fins probatoires ou pour répondre à une obligation légale. 
Vous pouvez exercer vos droits par mail à « mail », ou par courrier ; et ce, en justifiant de votre identité par tous moyens. 
Pour toute question sur vos données à caractère personnel, vous pouvez également écrire à l'adresse suivante : « mail »  ";
$pdf->MultiCell(47,2.4,utf8_decode($txt));
$pdf->Image('logok2.jpg',10,13,20,15);
$pdf->Output('I',utf8_decode("Contrat Véhicule_N°:".$Contrat_number."_".$Client_name.".pdf"));
}
else {
  echo "erreur";
}
?>
