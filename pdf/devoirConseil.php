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

	//TENDU !!!
	$query8 ="
		
		SELECT DISTINCT [R-Besoins Produits].[CLT-NumID], [R-Besoins Produits].[TPD-Nom] AS Besoins, [R-Dossier a Formaliser].[TPD-Nom] AS Offre, IIf(IsNull([Offre]),[Besoins],"") AS Absence
		FROM [R-Dossier a Formaliser] RIGHT JOIN [R-Besoins Produits] ON [R-Dossier a Formaliser].[TPD-Nom] = [R-Besoins Produits].[TPD-Nom];

		//R-Besoin Produits
		SELECT DISTINCT [Clients et Prospects].[CLT-NumID], [Type Produit].[TPD-Nom], [Type Produit].[TPD-NomDet]
		FROM [Clients et Prospects] INNER JOIN (([Type Produit] INNER JOIN [Besoins par Type Produits] ON [Type Produit].[TPD-NumID] = [Besoins par Type Produits].[B/T-NumType]) INNER JOIN [Besoins par Client] ON ([Besoins par Type Produits].[B/T-NumOcc] = [Besoins par Client].[B/C-NumOcc]) AND ([Besoins par Type Produits].[B/T-NumBesoin] = [Besoins par Client].[B/C-NumBesoin]) AND ([Besoins par Type Produits].[B/T-NumType] = [Besoins par Client].[B/C-NumType])) ON [Clients et Prospects].[CLT-NumID] = [Besoins par Client].[B/C-NumClient]
		WHERE ((([Clients et Prospects].[CLT-NumID])=[Formulaires]![F-Temp]![NumID]));

		//R-Dossier a Formaliser
		SELECT DISTINCT [Clients et Prospects].[CLT-NumID], [Type Produit].[TPD-Nom], Produits.[PDT-Nom], Compagnies.[CIE-Nom], [Evenements par Produits].[E/P-ObligationConseils], [Produits par Clients].[P/C-DossierConcurrent], [Evenements par Produits].[E/P-DateSignature], [Produits par Clients].[P/C-SituationContrat]
		FROM (Compagnies INNER JOIN (([Type Produit] INNER JOIN Produits ON [Type Produit].[TPD-NumID] = Produits.[PDT-Type]) INNER JOIN ([Clients et Prospects] INNER JOIN [Produits par Clients] ON [Clients et Prospects].[CLT-NumID] = [Produits par Clients].[P/C-NumClient]) ON Produits.[PDT-NumID] = [Produits par Clients].[P/C-NumProduit]) ON Compagnies.[CIE-NumID] = Produits.[PDT-Cie]) INNER JOIN [Evenements par Produits] ON [Produits par Clients].[P/C-NumID] = [Evenements par Produits].[E/P-NumProduitClient]
		WHERE ((([Clients et Prospects].[CLT-NumID])=[Formulaires]![F-Temp]![NumID]) AND (([Evenements par Produits].[E/P-ObligationConseils])=No) AND (([Produits par Clients].[P/C-DossierConcurrent])=No) AND (([Produits par Clients].[P/C-SituationContrat]) In (1,2,12)));

	";
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query8);
	$res9 = $res->fetchALL(PDO::FETCH_ASSOC);
	

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:-;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<div style='position:absolute;top:83;left:20'><span>".$res2[0]['CON-Adresse']."</span></div>
		<div style='position:absolute;top:99;left:20'><span>".$res2[0]['CON-Adresse2']."</span></div>
		<div style='position:absolute;top:114;left:20'><span>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div>
    </page_header>

    <span style='font-size:11.5px'>
    	
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

    /*require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Mandat Pro.pdf');*/

?>