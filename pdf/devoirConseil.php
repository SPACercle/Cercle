<?php

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
	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$query2 ="
		SELECT `Revenus par Client`.`R/C-NumClient`, `Type Revenus`.`REV-Nom`, `Revenus par Client`.`R/C-Année` AS Année, `Revenus par Client`.`R/C-Montant` AS Montant
		FROM `Type Revenus` INNER JOIN `Revenus par Client` ON `Type Revenus`.`REV-NumID` = `Revenus par Client`.`R/C-TypeRevenus`
		GROUP BY `Revenus par Client`.`R/C-NumClient`, `Type Revenus`.`REV-Nom`, `Revenus par Client`.`R/C-Année`, `Revenus par Client`.`R/C-Montant`
		HAVING (((`Revenus par Client`.`R/C-NumClient`)=".$_GET['idClient'].") AND ((`Type Revenus`.`REV-Nom`)='Revenus'))
		ORDER BY `Revenus par Client`.`R/C-Année` DESC;
	";
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query2);
	$res3 = $res->fetchALL(PDO::FETCH_ASSOC);


	$query3 ="
		SELECT DISTINCT `Clients et Prospects`.`CLT-NumID`, `Type Produit`.`TPD-Nom`, `Type Produit`.`TPD-NomDet`
		FROM `Clients et Prospects` INNER JOIN ((`Type Produit` INNER JOIN `Besoins par Type Produits` ON `Type Produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`) INNER JOIN `Besoins par Client` ON (`Besoins par Type Produits`.`B/T-NumOcc` = `Besoins par Client`.`B/C-NumOcc`) AND (`Besoins par Type Produits`.`B/T-NumBesoin` = `Besoins par Client`.`B/C-NumBesoin`) AND (`Besoins par Type Produits`.`B/T-NumType` = `Besoins par Client`.`B/C-NumType`)) ON `Clients et Prospects`.`CLT-NumID` = `Besoins par Client`.`B/C-NumClient`
		WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."));
	";
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query3);
	$res4 = $res->fetchALL(PDO::FETCH_ASSOC);
	
	$query4 ="
		SELECT DISTINCT `TPD-Nom` FROM `type produit` WHERE `TPD-Nom` NOT IN (
			SELECT DISTINCT tp.`TPD-Nom` FROM `besoins par client` bc, `type produit` tp WHERE bc.`B/C-NumClient` = ".$_GET['idClient']." AND tp.`TPD-NumID` = bc.`B/C-NumType`
		);
	";

	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query4);
	$res5 = $res->fetchALL(PDO::FETCH_ASSOC);

	
	$query5 ="
		SELECT `Clients et Prospects`.`CLT-NumID`, `Type Produit`.`TPD-NomDet`, `Type Produit`.`TPD-Nom`, `Besoins Existants`.`BES-Nom`, `Besoins Occurences`.`OCC-Nom`, `Besoins Existants`.`BES-Tri`, `Besoins Occurences`.`OCC-Tri`
		FROM `Type Produit` INNER JOIN (`Clients et Prospects` INNER JOIN ((`Besoins Occurences` INNER JOIN (`Besoins Existants` INNER JOIN `Besoins par Type Produits` ON `Besoins Existants`.`BES-NumID` = `Besoins par Type Produits`.`B/T-NumBesoin`) ON `Besoins Occurences`.`OCC-NumID` = `Besoins par Type Produits`.`B/T-NumOcc`) INNER JOIN `Besoins par Client` ON (`Besoins par Type Produits`.`B/T-NumOcc` = `Besoins par Client`.`B/C-NumOcc`) AND (`Besoins par Type Produits`.`B/T-NumBesoin` = `Besoins par Client`.`B/C-NumBesoin`) AND (`Besoins par Type Produits`.`B/T-NumType` = `Besoins par Client`.`B/C-NumType`)) ON `Clients et Prospects`.`CLT-NumID` = `Besoins par Client`.`B/C-NumClient`) ON `Type Produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`
		WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."))
		ORDER BY `Besoins Existants`.`BES-Tri`, `Besoins Occurences`.`OCC-Tri`;
	";

	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query5);
	$res6 = $res->fetchALL(PDO::FETCH_ASSOC);

	$query6 ="
		SELECT `type produit`.`TPD-Nom`, `besoins existants`.`BES-Nom` FROM `type produit`,`besoins existants`, `Besoins par Type Produits`
		WHERE  `besoins existants`.`BES-Nom` NOT IN (
			SELECT DISTINCT `besoins existants`.`BES-Nom`
			FROM `Type Produit` INNER JOIN (`Clients et Prospects` INNER JOIN ((`Besoins Occurences` INNER JOIN (`Besoins Existants` INNER JOIN `Besoins par Type Produits` ON `Besoins Existants`.`BES-NumID` = `Besoins par Type Produits`.`B/T-NumBesoin`) ON `Besoins Occurences`.`OCC-NumID` = `Besoins par Type Produits`.`B/T-NumOcc`) INNER JOIN `Besoins par Client` ON (`Besoins par Type Produits`.`B/T-NumOcc` = `Besoins par Client`.`B/C-NumOcc`) AND (`Besoins par Type Produits`.`B/T-NumBesoin` = `Besoins par Client`.`B/C-NumBesoin`) AND (`Besoins par Type Produits`.`B/T-NumType` = `Besoins par Client`.`B/C-NumType`)) ON `Clients et Prospects`.`CLT-NumID` = `Besoins par Client`.`B/C-NumClient`) ON `Type Produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`
			WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."))
			ORDER BY `Besoins Existants`.`BES-Tri`, `Besoins Occurences`.`OCC-Tri`
		)
		AND `type produit`.`TPD-Nom` IN (
			SELECT DISTINCT `type produit`.`TPD-Nom`
			FROM `Type Produit` INNER JOIN (`Clients et Prospects` INNER JOIN ((`Besoins Occurences` INNER JOIN (`Besoins Existants` INNER JOIN `Besoins par Type Produits` ON `Besoins Existants`.`BES-NumID` = `Besoins par Type Produits`.`B/T-NumBesoin`) ON `Besoins Occurences`.`OCC-NumID` = `Besoins par Type Produits`.`B/T-NumOcc`) INNER JOIN `Besoins par Client` ON (`Besoins par Type Produits`.`B/T-NumOcc` = `Besoins par Client`.`B/C-NumOcc`) AND (`Besoins par Type Produits`.`B/T-NumBesoin` = `Besoins par Client`.`B/C-NumBesoin`) AND (`Besoins par Type Produits`.`B/T-NumType` = `Besoins par Client`.`B/C-NumType`)) ON `Clients et Prospects`.`CLT-NumID` = `Besoins par Client`.`B/C-NumClient`) ON `Type Produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`
			WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."))
			ORDER BY `Besoins Existants`.`BES-Tri`, `Besoins Occurences`.`OCC-Tri`
		)
		AND `type produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`
		AND `Besoins par Type Produits`.`B/T-NumBesoin` = `besoins existants`.`BES-NumID`
		GROUP BY `type produit`.`TPD-Nom`, `besoins existants`.`BES-Nom`;
	;";

	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query6);
	$res7 = $res->fetchALL(PDO::FETCH_ASSOC);

	$query7 ="
		SELECT DISTINCT `Clients et Prospects`.`CLT-NumID`, `Type Produit`.`TPD-Nom`, Produits.`PDT-Nom`, Compagnies.`CIE-Nom`, `Evenements par Produits`.`E/P-ObligationConseils`, `Produits par Clients`.`P/C-DossierConcurrent`, `Evenements par Produits`.`E/P-DateSignature`, `Produits par Clients`.`P/C-SituationContrat`
		FROM (Compagnies INNER JOIN ((`Type Produit` INNER JOIN Produits ON `Type Produit`.`TPD-NumID` = Produits.`PDT-Type`) INNER JOIN (`Clients et Prospects` INNER JOIN `Produits par Clients` ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) INNER JOIN `Evenements par Produits` ON `Produits par Clients`.`P/C-NumID` = `Evenements par Produits`.`E/P-NumProduitClient`
		WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient'].") AND ((`Evenements par Produits`.`E/P-ObligationConseils`)=0) AND ((`Produits par Clients`.`P/C-DossierConcurrent`)=0) AND ((`Produits par Clients`.`P/C-SituationContrat`) IN (1,2,12)));
	";
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query7);
	$res8 = $res->fetchALL(PDO::FETCH_ASSOC);


	/*$query8 ="
		SELECT DISTINCT `Type Produit`.`TPD-Nom`
		FROM `Clients et Prospects` INNER JOIN ((`Type Produit` INNER JOIN `Besoins par Type Produits` ON `Type Produit`.`TPD-NumID` = `Besoins par Type Produits`.`B/T-NumType`) INNER JOIN `Besoins par Client` ON (`Besoins par Type Produits`.`B/T-NumOcc` = `Besoins par Client`.`B/C-NumOcc`) AND (`Besoins par Type Produits`.`B/T-NumBesoin` = `Besoins par Client`.`B/C-NumBesoin`) AND (`Besoins par Type Produits`.`B/T-NumType` = `Besoins par Client`.`B/C-NumType`)) ON `Clients et Prospects`.`CLT-NumID` = `Besoins par Client`.`B/C-NumClient`
		WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."));
	";*/
	/*$query8 = "
	SELECT DISTINCT `type produit`.`TPD-Nom`
	FROM `produits par clients` INNER JOIN (`type produit` INNER JOIN ((`besoins existants` INNER JOIN `besoins par type produits` ON `besoins existants`.`BES-NumID` = `besoins par type produits`.`B/T-NumBesoin`) INNER JOIN (`clients et prospects` INNER JOIN `besoins par client` ON `clients et prospects`.`CLT-NumID` = `besoins par client`.`B/C-NumClient`) ON (`besoins par type produits`.`B/T-NumType` = `besoins par client`.`B/C-NumType`) AND (`besoins par type produits`.`B/T-NumOcc` = `besoins par client`.`B/C-NumOcc`)) ON `type produit`.`TPD-NumID` = `besoins par type produits`.`B/T-NumType`) ON `produits par clients`.`P/C-NumClient` = `clients et prospects`.`CLT-NumID`
	WHERE (((`clients et prospects`.`CLT-NumID`)=".$_GET['idClient'].")) AND `type produit`.`TPD-Nom` NOT IN (SELECT DISTINCT(`TPD-Nom`) FROM `produits par clients`, `produits`, `type produit` WHERE `P/C-NumClient` = ".$_GET['idClient']." AND `P/C-NumProduit` = `PDT-NumID` AND `PDT-Type` = `TPD-NumID`);
	";*/
	$query8="SELECT DISTINCT `type produit`.`TPD-Nom`
	FROM `produits par clients` INNER JOIN (`type produit` INNER JOIN ((`besoins existants` INNER JOIN `besoins par type produits` ON `besoins existants`.`BES-NumID` = `besoins par type produits`.`B/T-NumBesoin`) INNER JOIN (`clients et prospects` INNER JOIN `besoins par client` ON `clients et prospects`.`CLT-NumID` = `besoins par client`.`B/C-NumClient`) ON (`besoins par type produits`.`B/T-NumType` = `besoins par client`.`B/C-NumType`) AND (`besoins par type produits`.`B/T-NumOcc` = `besoins par client`.`B/C-NumOcc`)) ON `type produit`.`TPD-NumID` = `besoins par type produits`.`B/T-NumType`) ON `produits par clients`.`P/C-NumClient` = `clients et prospects`.`CLT-NumID`
	WHERE (((`clients et prospects`.`CLT-NumID`)=".$_GET['idClient'].")) AND `type produit`.`TPD-Nom` NOT IN (
		SELECT DISTINCT(`TPD-Nom`) 
		FROM `produits par clients`, `produits`, `type produit`, `evenements par produits`
		WHERE `P/C-NumClient` = 2440 AND `P/C-NumProduit` = `PDT-NumID` AND `PDT-Type` = `TPD-NumID` AND `P/C-DossierConcurrent` = 0 AND `E/P-ObligationConseils` = 0 AND `E/P-NumProduitClient` = `P/C-NumID`
	);
	";
	
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query8);
	$res9 = $res->fetchALL(PDO::FETCH_ASSOC);


	$query9 ="
		SELECT min(`E/P-DateSignature`) AS DateSignature FROM `evenements par produits` eve, `produits par clients` pro WHERE pro.`P/C-NumID` = eve.`E/P-NumProduitClient` AND pro.`P/C-NumClient` = ".$_GET['idClient']." AND `E/P-ObligationConseils` = 0;
	";

	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query9);
	$res10 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:-5;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:12px'><i>
    
    <div style='position:absolute;top:133;left:250;'><i><h4 style='margin-top:0px;'>Formalisation du Devoir de conseil</h4></i></div>

    <div style='position:absolute;top:159;left:150'>(Loi n°2005-1564 du 15 décembre 2005 complétée par le décret n°2006-1091 du 30 aout 2006)</div>

    <div style='position:absolute;top:201;left:25'>".$res2[0]['CIV-NomDétaillé']." ".$res2[0]['CLT-Nom'].",</div>

	<div style='position:absolute;top:224;left:25'>Le présent document retrace notre dialogue et nos échanges préalables à votre décision d’adhérer à un contrat d’assurance. Cette  démarche nous a permis ensemble de préciser votre situation personnelle et professionnelle et de définir vos souhaits et objectifs en matière de protection sociale.</div>
	
	<u><b><div style='position:absolute;top:274;left:25'>Importance des cotisations</div></b></u>

	<div style='position:absolute;top:290;left:25'>Vous attestez par la présente que les garanties proposées, les modalités de paiement des cotisations et leur évolution éventuelle ont été évoquées. Votre attention a été attirée sur le fait que l'interruption des cotisations périodiques entrainera pour certains dossier la résiliation automatique de certaines garanties (en cas d'incapacité, d'invalidité, ou de garanties de bonne fin en cas de décès par exemple), dans les délais prévus aux dispositions générales. Le défaut de paiement peut  provoquer la mise en réduction de l'adhésion avec toutes ses conséquences. Malgré le fait que certaines compagnies vous permettent à nouveau la reprise de ces versements, nous vous engageons à vous rapprocher de votre cabinet, pour en mesurer les risques et les conséquences.</div>

	<u><b><div style='position:absolute;top:378;left:25'>Prise d'effet des garanties</div></b></u>

	<div style='position:absolute;top:397;left:25'>La prise d'effet des garanties indiquée sur le Certificat d’adhésion par la compagnie d'Assurances, est liée aux conditions suspensives du paiement de la première cotisation et sous réserve d’acceptation par cette même compagnie, concrétisée par l’émission d’un Certificat d’adhésion précisant le montant des garanties pour chacun des risques couverts.
	<br/>Note de couverture : L’Assuré peut bénéficier d’une  garantie supplémentaire temporaire en cas de décès suite à un Accident survenu entre la date de signature de la demande d’adhésion et la date d’acceptation par la compagnie d'Assurances.</div>

	<div style='position:absolute;top:456;left:25'><h4>I- Votre situation</h4></div></i>

	<div style='position:absolute;top:536;left:25'>Vous exercez la profession de ".$res2[0]['PRO-Nom']."  avec un statut de ".$res2[0]['SPR-Nom']." </div>
	<div style='position:absolute;top:516;left:25'>Vous demeurez au ".$res2[0]['CLT-Adresse']." ".$res2[0]['CLT-Code Postal']." ".$res2[0]['CLT-Ville']."</div>
	<div style='position:absolute;top:498;left:25'>Vous êtes né(e) le ".date('d/m/Y',strtotime($res2[0]['CLT-DateNaissance']))."</div>
	<div style='position:absolute;top:554;left:25'>Vous êtes ".$res2[0]['SIT-Nom'].""; 
	 if($res2[0]['CLT-NbEnfants'] != null){
	 	$content.=" et vous avez ".$res2[0]['CLT-NbEnfants']." enfant(s)";
	 }
	$content.="</div>";

	if(isset($res3[0])){
		$content.="<div style='position:absolute;top:574;left:25'>Les derniers revenus portés à notre connaissance sont ceux de l'année ".$res3[0]['Année'].", ils s'élèvent à ".$res3[0]['Montant']." euros</div>";
	}

	$content.="
	<div style='position:absolute;top:598;left:25'><h4><i>II- Informations relatives à vos besoins actuels</i></h4></div>

	<b><i><u><div style='position:absolute;top:647;left:33'>Vous souhaitez étudier sur un contrat spécifique </div>
	<div style='position:absolute;top:664;left:33'>votre couverture en matière de ...</div></u></i></b>";

	$i = 691;
	foreach ($res4 as $r) {
		$content.="<div style='position:absolute;top:".$i.";left:41'>".$r['TPD-Nom']."</div>";
		$i = $i + 15;
	}

	$content.="
	<b><i><u><div style='position:absolute;top:648;left:404'> Vous ne souhaitez pas étudier sur un contrat </div>
	<div style='position:absolute;top:665;left:404'>spécifique votre couverture en matière de ...</div></u></i></b>";

	$i = 691;
	foreach ($res5 as $r) {
		$content.="<div style='position:absolute;top:".$i.";left:408'>".$r['TPD-Nom']."</div>";
		$i = $i + 15;
	}

	$content.="
	<div style='position:absolute;top:1000;left:700'>Page 1/4</div>
	</span>

	<div style='position:absolute;top:1015;left:700;border:1px solid black;font-size:9px;padding-left:10px;padding-right:10px;'>Paraphe<br/><br/><br/><br/></div>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>

	<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:-5;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:11px'>

	<div style='position:absolute;top:90;left:33'><h4><i>III- Et voici plus précisément le recueil des besoins que vous avez formulé</i></h4></div>";

	$i = 150;
	$dejaPasse = array();
	foreach ($res6 as $r) {
		if(!in_array($r['TPD-Nom'],$dejaPasse)){
			$content.="<div style='position:absolute;top:".$i.";left:45;color:#54644A'><u><b><i>".$r['TPD-Nom']."</i></b></u></div>";
			$i = $i + 23;
			$content.="<div style='position:absolute;top:".$i.";left:35;color:#54644A;'><i><u>".$r['TPD-NomDet']."</u></i></div>";
			$i = $i + 40;
			$nom = $r['TPD-Nom'];
			array_push($dejaPasse,$nom);
			foreach ($res6 as $r) {
				if($r['TPD-Nom'] == $nom){
					$content.="<div style='position:absolute;top:".$i.";left:33;color:#54644A;'>- ".$r['BES-Nom'].", ".$r['OCC-Nom']."</div>";
					if(strlen($r['BES-Nom'].", ".$r['OCC-Nom']) > 140){
						$i = $i + 25;
					} else {
						$i = $i + 15;
					}
					
				}
			}
			$i = $i + 10;
		}
	}

	$content.="
	<div style='position:absolute;top:1000;left:700'>Page 2/4</div>
	<div style='position:absolute;top:1015;left:700;border:1px solid black;font-size:9px;padding-left:10px;padding-right:10px;'>Paraphe<br/><br/><br/><br/></div>
	</span>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>

	<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:-5;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:11px'>";

	$i = 150;
	$content.="
	<div style='position:absolute;top:".($i-35).";left:33;border:1px solid black;padding:5px;background-color:#F59191;'> Pour information, voici les besoins que vous n'avez pas souhaité retenir : </div>";
	
	$dejaPasse = array();
	foreach ($res7 as $r) {
		if(!in_array($r['TPD-Nom'],$dejaPasse)){
			$content.="<div style='position:absolute;top:".$i.";left:45;color:#BA1419'><u><b><i>".$r['TPD-Nom']."</i></b></u></div>";
			$i = $i + 23;
			$nom = $r['TPD-Nom'];
			array_push($dejaPasse,$nom);
			foreach ($res7 as $r) {
				if($r['TPD-Nom'] == $nom){
					$content.="<div style='position:absolute;top:".$i.";left:33;color:#BA1419;'>- ".$r['BES-Nom']."</div>";
					$i = $i + 15;
				}
			}
			$i = $i + 15;
		}
	}

	$content.="
	<div style='position:absolute;top:1000;left:700'>Page 3/4</div>
	<div style='position:absolute;top:1015;left:700;border:1px solid black;font-size:9px;padding-left:10px;padding-right:10px;'>Paraphe<br/><br/><br/><br/></div>
	</span>";

	$content.="
    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>

	<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:-5;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:12px'><i>
		
	<div style='position:absolute;top:90;left:29'><h4><i>IV- Solutions retenues en fonction de vos besoins</i></h4></div>

	<div style='position:absolute;top:125;left:29'>En fonction des informations communiquées et validées ensemble, l’intermédiaire a analysé en toute impartialité les contrats d’assurances. 
	<br/>Vous avez choisi et accepté en toute connaissance de cause et après que des explications claires et motivées vous aient été fournies, de retenir les propositions suivantes : </div>

	<div style='position:absolute;top:189;left:29'>Les critères suivants ont été pris en compte : rapport qualité prix, fiscalité conforme aux dispositions fiscales et sociales en vigueur, taux de cotisation, procédures d'adhésion </div>";
	
	$i = 221;
	$tab_couv = array();
	foreach ($res8 as $r) {
		if(!in_array($r['TPD-Nom'],$tab_couv)){
			array_push($tab_couv,$r['TPD-Nom']);
			$content.="<div style='position:absolute;top:".$i.";left:29;color:#54644A;'><u><b>Couverture du Risque ".$r['TPD-Nom']."</b></u></div>";
			$i = $i + 27;
		}
		$content.="<div style='position:absolute;top:".$i.";left:45;color:#54644A;'>- ".$r['PDT-Nom']." géré par la compagnie d'assurance ".$r['CIE-Nom']."</div>";
		$i = $i + 20;
		$content.="<div style='position:absolute;top:".$i.";left:53;color:#54644A;'>dont les conditions et les modalités retenues constituent une solution au regard de votre situation en matière de ".$r['TPD-Nom']."</div>";
		$i = $i + 20;
	}

	$i = $i + 15;
	if(isset($res9[0])){
		$content.="<div style='position:absolute;top:".$i.";left:25;color:#BA1419;'><h4>V- Solutions qui feront l'objet d'une étude ultérieure</h4></div>";
		$i = $i + 40;
		$content.="<div style='position:absolute;top:".$i.";left:25;color:#BA1419;'>Attention, Prenez note du fait que, compte tenu de différentes contraintes, les risques suivants ne sont pas couverts dans l'immédiat et feront l'objet d'une étude ultérieure</div>";
		$i = $i + 30;
		foreach ($res9 as $r) {
			$content.="<div style='position:absolute;top:".$i.";left:62;color:#BA1419;'><b>".$r['TPD-Nom']."</b></div>";
			$i = $i + 15;
		}
	}
	$i = $i + 15;

	if(isset($res10[0]['DateSignature'])){
		$mois = date('m',strtotime($res10[0]['DateSignature']));
		switch($mois){
			case 1:
				$mois = "janvier";
				break;
			case 2:
				$mois = "février";
				break;
			case 3:
				$mois = "mars";
				break;
			case 4:
				$mois = "avril";
				break;
			case 5:
				$mois = "mai";
				break;
			case 6:
				$mois = "juin";
				break;
			case 7:
				$mois = "juillet";
				break;
			case 8:
				$mois = "août";
				break;
			case 9:
				$mois = "septembre";
				break;
			case 01:
				$mois = "janvier";
				break;
			case 02:
				$mois = "février";
				break;
			case 03:
				$mois = "mars";
				break;
			case 04:
				$mois = "avril";
				break;
			case 05:
				$mois = "mai";
				break;
			case 06:
				$mois = "juin";
				break;
			case 07:
				$mois = "juillet";
				break;
			case 08:
				$mois = "août";
				break;
			case 09:
				$mois = "septembre";
				break;
			case 10:
				$mois = "octobre";
				break;
			case 11:
				$mois = "novembre";
				break;
			case 12:
				$mois = "décembre";
				break;
		}
		$date = date('d',strtotime($res10[0]['DateSignature']))." ".$mois." ".date('Y',strtotime($res10[0]['DateSignature']));
	} else {
		$date = "???";
	}

	$content.="

	<div style='position:absolute;top:".$i.";left:25'>Le client reconnaît avoir pris connaissance de contenu du présent document préalablement à la signature du ou des contrats d’assurance proposé(s) ci-dessus et en accepter les termes. Il reconnait également avoir reçu les Conditions générales de ces mêmes contrats, et après lecture attentive, en accepter les termes.</div>
	</i>

	<div style='position:absolute;top:".($i+62).";left:25'>Fait à ".$res2[0]['CLT-Ville'].", le ".$date." en deux exemplaires, dont un pour ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']."  ".$res2[0]['CLT-Nom']." qui reconnait l'a voir reçu.</div>

	<div style='position:absolute;top:".($i+150).";left:501'> ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']."</div>
	<div style='position:absolute;top:".($i+150).";left:184'>".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</div>
	<div style='position:absolute;top:".($i+125).";left:473'> L'intermédiaire en Assurances</div>
	<div style='position:absolute;top:".($i+125).";left:184'>Le Candidat à l'Assurance</div>
	
	<div style='position:absolute;top:1000;left:700'>Page 4/4</div>
	<div style='position:absolute;top:1015;left:700;border:1px solid black;font-size:9px;padding-left:10px;padding-right:10px;'>Paraphe<br/><br/><br/><br/></div>

	</span>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('DevoirConseil.pdf');

?>