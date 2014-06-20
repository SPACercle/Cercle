<?php
	session_start();
	include "../BDD.php";

	$query ="
		SELECT `Clients et Prospects`.*, `Conseillers`.*, `Statut Professionnel`.*, `Civilites`.*,`Professions`.*, `Situation Familiale`.*
	FROM `Statut Professionnel` RIGHT JOIN (
		`Conseillers` RIGHT JOIN (
			`Professions` RIGHT JOIN (
				`Situation Familiale` RIGHT JOIN (
					Civilites RIGHT JOIN `Clients et Prospects` ON Civilites.`CIV-NumID` = `Clients et Prospects`.`CLT-Civilité`
												 ) ON `Situation Familiale`.`SIT-NumID` = `Clients et Prospects`.`CLT-SitFam`
									) ON `Professions`.`PRO-NumID` = `Clients et Prospects`.`CLT-Profession`
								) ON `Conseillers`.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`
						) ON `Statut Professionnel`.`SPR-NumID` = `Clients et Prospects`.`CLT-Statut`
	WHERE `Clients et Prospects`.`CLT-NumID`=".$_GET['idClient'].";
	";

	$query2="
		SELECT `Type Client`.`TYP-Nom`, 
		`visualisation portefeuilles`.`VIS-NumUtilisateur`,
		`Produits par Clients`.`P/C-NumClient`,
		`Produits par Clients`.`P/C-DossierConcurrent`, 
		`type evenements contrat`.`EVE-Nom`, 
		`evenements par produits`.`E/P-DateEffet`, 
		conseillers.`CON-Logo`, 
		`evenements par produits`.`E/P-MontantPP`, 
		`evenements par produits`.`E/P-MontantPU`, 
		`Produits par Clients`.`P/C-AVie`,
		`Produits par Clients`.`P/C-Mad`, 
		`Produits par Clients`.`P/C-PEP`, 
		`Produits par Clients`.`P/C-PERP`, 
		`Produits par Clients`.`P/C-TPG93`,
		IF(`P/C-AVie`=-1,'Assurance Vie',
		    IF(`P/C-Mad`=-1,'Art 154bis du CGI (Madelin)',
		    		IF(`P/C-PEP`=-1,'PEP',
		    			IF(`P/C-PERP`=-1,'PERP',
		    				IF(`P/C-Art82`=-1,'Article 82 du CGI',
		    					IF(`P/C-Art83`=-1,'Article 83 du CGI',
		    						IF(`P/C-Art39`=-1,'Article 39 du CGI','')
		    						)
		    					)
							)
						)
				)
			) AS Fiscalité, 
		`Produits par Clients`.`P/C-Art62`, 
		`Produits par Clients`.`P/C-Art82`, 
		`Produits par Clients`.`P/C-Art83`, 
		`Produits par Clients`.`P/C-Art39`, 
		Fractionnements.`FRA-Nom`, 
		`Produits par Clients`.`P/C-NumContrat`, 
		`Clients et Prospects_1`.`CLT-Civilité`, 
		`Clients et Prospects_1`.`CLT-Nom`, 
		`Clients et Prospects_1`.`CLT-Prénom`, 
		`Clients et Prospects`.`CLT-RaisonSocialePro`, 
		`Clients et Prospects`.`CLT-Nom` AS AssuréNom, 
		`Clients et Prospects`.`CLT-Prénom` AS AssuréPrénom, 
		conseillers.`CON-Nom`, 
		conseillers.`CON-Prénom`, 
		conseillers.`CON-Société`, 
		`type situations contrats`.`TSC-Nom`, 
		`Type Produit`.`TPD-Nom`, 
		Produits.`PDT-Nom`, 
		`Clients et Prospects`.`CLT-Nom`,
		`Clients et Prospects`.`CLT-Prénom`, 
		IF(`P/C-DossierConcurrent`=0,'Dossiers ' & `CON-Société`,'Dossiers Externes') AS Concurrent,
		IF(`P/C-DossierConcurrent`=0,1,0) AS TriConcurrent, Compagnies.`CIE-Nom`
		
		FROM `type situations contrats` RIGHT JOIN (`type evenements contrat` INNER JOIN (`evenements par produits` INNER JOIN ((Fractionnements RIGHT JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN (Compagnies INNER JOIN (`Type Client` INNER JOIN ((`Type Produit` INNER JOIN Produits ON `Type Produit`.`TPD-NumID` = Produits.`PDT-Type`) INNER JOIN (`Clients et Prospects` INNER JOIN `Produits par Clients` ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects`.`CLT-Type`) ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) ON `Clients et Prospects_1`.`CLT-NumID` = `Produits par Clients`.`P/C-NumSouscripteur`) ON Fractionnements.`FRA-NumID` = `Produits par Clients`.`P/C-Fractionnement`) INNER JOIN (`visualisation portefeuilles` INNER JOIN conseillers ON `visualisation portefeuilles`.`VIS-NumORIAS` = conseillers.`CON-NumORIAS`) ON `Clients et Prospects`.`CLT-Conseiller` = conseillers.`CON-NumID`) ON `evenements par produits`.`E/P-NumProduitClient` = `Produits par Clients`.`P/C-NumID`) ON `type evenements contrat`.`EVE-NumID` = `evenements par produits`.`E/P-NumEvenement`) ON `type situations contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`
		
		WHERE (((`Type Client`.`TYP-Nom`)='Client') AND ((`visualisation portefeuilles`.`VIS-NumUtilisateur`)=".$_SESSION['Auth']['id'].") AND ((`Produits par Clients`.`P/C-NumClient`)=".$_GET['idClient'].") AND ((`Produits par Clients`.`P/C-DossierConcurrent`)=0));
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query2);
	$res3 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

    $content="<page backright='5mm' backleft='5mm'>

	<page_header>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>    
	</page_header>

    <span style='font-size:12px'>

		<i><div style='position:absolute;top:130;left:36;color:#95847A;'><h5>Etat récapitulatif des Dossiers de </h5></div>
		<div style='position:absolute;top:130;left:250;color:#95847A;'><h4>".$res2[0]['CLT-Nom']." ".$res2[0]['CLT-Prénom']."</h4></div>

		<div style='position:absolute;top:178;left:5;color:#95847A;'><h4>Dossiers ".$res2[0]['CON-Société']."</h4></div>

		<div style='position:absolute;top:181;left:480;color:#95847A;'><h5> Dossiers suivis par : ".$res2[0]['CON-Nom']." ".$res2[0]['CON-Prénom']."</h5></div></i>

		<div style='position:absolute;top:205;width:100%'><hr/></div>";

		$tab_produit = array();
		foreach ($res3 as $r) {
			if(!in_array($r['TPD-Nom'],$tab_produit)){
				$content.="<div style='position:absolute;top:220;left:15;border:1px solid black;padding:5px;background-color:#7BBDE4;padding-left:30px;padding-right:30px'><b><i>".$r['TPD-Nom']."</i></b></div>";
				array_push($tab_produit,$r['TPD-Nom']);
				$content.="
				<div style='position:absolute;top:245;left:-10;color:#49628C;'><b><ul><li><u>AVIVA - AVIVA Senséo Médical N° 014048728G</u></li></ul></b></div>

				<div style='position:absolute;top:258;left:480;color:#49628C;'> Souscripteur --> ABDENNEBI Mohamed Lotfi</div>

				<div style='position:absolute;top:275;left:390;color:#49628C;'> Fractionnement Mensuel</div>

				<div style='position:absolute;top:275;left:15;color:#95847A;'><i>Situation --> En cours sous prime</i></div>

				<div style='position:absolute;top:295;left:25;color:#49628C;'>Fiscalité - (Art154bis du CGI et Assurance Vie)</div>

				<div style='position:absolute;top:301;left:50;color:#49628C;'><ul><li>Affaire Nouvelle en date du 01/01/2014</li></ul></div>

				<div style='position:absolute;top:312;left:384;color:#95847A;'><b> Montant initial  : 4 864,80 €</b></div>";
			}
		}

		$content.="

		<div style='position:absolute;top:665;left:0;color:#95847A;'><h4><i>Dossiers Externes à titre indicatif</i></h4></div>

		<div style='position:absolute;top:666;left:390;color:#95847A;'><h5><i> ces dossiers n'étant pas gérés directement par le cabinet</i></h5></div>

		<div style='position:absolute;top:693;width:100%'><hr/></div>

		<div style='position:absolute;top:717;left:0;color:#95847A;'><b><u><i>Prévoyance</i></u></b></div>

		<div style='position:absolute;top:745;left:0;color:#49628C;'>LA MÉDICALE DE FRANCE - Médiprat N° </div>

		<div style='position:absolute;top:745;left:640;color:#95847A;'> 4 839,00 €</div>
		<div style='position:absolute;top:745;left:390;color:#95847A;'>En cours sous prime</div>
		<div style='position:absolute;top:745;left:525;color:#95847A;'> Prime annuelle</div>
		
	
	</span>

	</page>";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Mandat Pro.pdf');


?>