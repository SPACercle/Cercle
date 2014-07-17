<?php

	include "../BDD.php";

	$query ="SELECT `Conseillers`.*, `Clients et Prospects`.*, `Civilites`.*
			 FROM `Conseillers` INNER JOIN (`Civilites` INNER JOIN `Clients et Prospects` ON `Civilites`.`CIV-NumID` = `Clients et Prospects`.`CLT-Civilité`) ON `Conseillers`.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`
			 WHERE (((`Clients et Prospects`.`CLT-NumID`)=".$_GET['idClient']."));
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

	$tab = explode("/",$_GET['date1']);
	switch($tab[1]){
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
	$tab = explode("/",$_GET['date1']);
	if(sizeof($tab) > 2){
		$date2 = $tab[1]."/".$tab[0]."/".$tab[2];
		$date_un = date("d",strtotime($date2))." ".$mois." ".$tab[2];
	} else {
		if(sizeof($tab) == 2){
			$date2 = $tab[1]."/".$tab[0];
			$annee = date("Y");
			$date_un = date("d",strtotime($date2))." ".$mois." ".$annee;
		}
	}

	$tab = explode("/",$_GET['date2']);
	switch($tab[1]){
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
	$tab = explode("/",$_GET['date2']);
	if(sizeof($tab) > 2){
		$date2 = $tab[1]."/".$tab[0]."/".$tab[2];
		$date_deux = date("d",strtotime($date2))." ".$mois." ".$tab[2];
	} else {
		if(sizeof($tab) == 2){
			$date2 = $tab[1]."/".$tab[0];
			$annee = date("Y");
			$date_deux = date("d",strtotime($date2))." ".$mois." ".$annee;
		}
	}

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:11.5px'>
  		<div style='position:absolute;top:150;left:290;'><span><h3><i>Fiche d'informations</i></h3></span></div>

		<i><div style='position:absolute;top:230;left:30'>Les informations ci-après sont délivrées á l’attention de ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']." né(e) le ".date('d/m/Y',strtotime($res2[0]['CLT-DateNaissance'])).", demeurant au ".$res2[0]['CLT-Adresse']." ".$res2[0]['CLT-Code Postal']." ".$res2[0]['CLT-Ville']." conformément aux dispositions des articles L520-1-II 1°, R520-1 et R520-2 du Code des assurances par ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']." pour le compte du Cabinet ".$res2[0]['CON-Société'].".</div></i>
		
		<div style='position:absolute;top:275;left:29'><h4><i><u>I - Références et Coordonnées</u></i></h4></div>

		<div style='position:absolute;top:305;left:53'><h5><i><span style='color: #614B3A;'><u>Informations générales sur notre cabinet</u></span></i></h5></div>

		<div style='position:absolute;top:347;left:30'>Le Cabinet ".$res2[0]['CON-Société']." est inscrit au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N° ".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE'].". Son siège social est sis ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle'].". Le Cabinet ".$res2[0]['CON-Société']." est Immatriculé á l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." en tant que Courtier d'Assurance. Cette immatriculation peut être vérifiée auprès de l'ORIAS sur son site internet www.orias.fr ou par courrier adressé á son attention au 1, rue Jules Lefebvre - 75731 PARIS Cedex 09.</div>

		<div style='position:absolute;top:405;left:53'><h5><i><span style='color: #614B3A;'><u>Informations complémentaires</u></span></i></h5></div>

		<div style='position:absolute;top:445;left:30'>Notre cabinet ne détient pas directement ou indirectement plus de 10% des droits de vote ou du capital d'une compagnie d’assurance. Parmi nos actionnaires, nous ne comptons aucune compagnie d'assurance détenant directement ou indirectement plus de 10% des droits de vote ou du capital de notre cabinet.</div>

		<i><div style='position:absolute;top:484;left:29'><h4><u>II - Litiges et Réclamations - Médiation</u></h4></div>

		<div style='position:absolute;top:528;left:30'>Toutes informations complémentaires concernant les dossiers en cours peuvent être obtenues en adressant directement cette demande au cabinet ".$res2[0]['CON-Société'].", ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle'].". En cas de difficultés rencontrées, vous pouvez notifier par recommandé avec AR au service réclamation du cabinet ".$res2[0]['CON-Société'].", le motif  de vos réclamations, qui vous répondra dans les plus brefs délais. En cas de désaccord, et si toutes les voies de recours amiable ont été épuisées, l'adhérent peut adresser une réclamation écrite avec le motif du litige á l’autorité de Contrôle  Prudentiel (ACP) dont les coordonnées sont les suivantes : 61, rue Taitbout – 75436 Paris cedex 09. Vous pouvez également demander l'avis d'un médiateur. Les modalités vous seront communiquées, sur simple demande par le Service Réclamation du cabinet ".$res2[0]['CON-Société'].".</div>

		<div style='position:absolute;top:622;left:29'><h4><u>III - Analyse du Marché</u></h4></div>

		<div style='position:absolute;top:666;left:30'>Le Cabinet ".$res2[0]['CON-Société']." exerce son activité d'intermédiation selon les dispositions prévues á l’article L520-1-II b du code des Assurances. Ainsi, le ou les contrats proposés sont sélectionnés parmi le catalogue produit des organismes assureurs partenaires de notre cabinet, eu égard aux besoins exprimés, á la pertinence des garanties proposées et des conditions tarifaires, sans prétendre á une analyse exhaustive des offres proposées par l'intégralité des entreprises d'assurance présentes sur le marché. Le Cabinet peut communiquer au client qui en fait la demande la liste des entreprises d’assurance avec lesquelles il travaille.</div>

		<span style='color: #614B3A;font-size:10px;'><div style='position:absolute;top:750;left:26'>Les informations recueillies sont nécessaires au traitement de votre demande en matière d'assurance et peuvent faire l'objet d'un traitement informatique. Le destinataire des données est la société Stratégies &amp; Perspectives d'Avenir. Le fichier est enregistré á la CNIL sous le N° 1525993. Conformément á l'article 23 de la loi Informatique et libertés N° 78-17 du 6 janvier 1978 modifiée en 2004, vous bénéficiez d'un droit d'accès et de rectification aux informations vous concernant, que vous pouvez exercer en vous adressant á Stratégies &amp; perspectives d'Avenir - Pôle technologique Nancy - Brabois    6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex.</div></span>
	
		<div style='position:absolute;top:830;left:26'>Fait en 2 exemplaires á ".$res2[0]['CLT-Ville'].", le ".$date_un." en deux exemplaires, dont un pour ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']." qui reconnait l'avoir reçu.</div></i>
		
		<div style='position:absolute;top:890;left:490'>".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']."</div>
		<div style='position:absolute;top:890;left:167'>".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</div>
		<div style='position:absolute;top:870;left:460'> L'intermédiaire en Assurances</div>
		<div style='position:absolute;top:870;left:179'>Le Candidat á l'Assurance</div>

	</span>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  á l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>";

	$content.="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:11px'><i>
  		<div style='position:absolute;top:95;left:290'><span><h3>Obligation de conseil</h3></span></div>

  		<div style='position:absolute;top:167;left:30'>Cette fiche est destinée á améliorer votre compréhension des garanties proposées afin de vous permettre de mieux appréhender les propositions d'assurances qui vous seront faites et ainsi choisir librement vos solutions d'assurance comme vous le permet la loi.  </div>

  		<div style='position:absolute;top:203;left:30'>Les informations ci-après sont délivrées á l’attention de ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']." né(e) le ".date('d/m/Y',strtotime($res2[0]['CLT-DateNaissance'])).", demeurant au ".$res2[0]['CLT-Adresse']." ".$res2[0]['CLT-Code Postal']." ".$res2[0]['CLT-Ville']." conformément aux dispositions des articles L520-1-II 2° du Code des assurances par ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']." pour le compte du Cabinet ".$res2[0]['CON-Société']." .  </div>

		<div style='position:absolute;top:238;left:29'><h5><u>I- Importance des informations</u></h5></div>

		<div style='position:absolute;top:274;left:30'>Le ou les contrats proposés se fondent sur l'analyse de votre situation tant personnelle que professionnelle et des besoins que vous avez exprimés. Aussi, l'exactitude et l'exhaustivité de vos réponses sont essentielles. A défaut, l'appréciation de votre situation ne pourrait être que partielle et serait de nature á remettre en cause la qualité de notre mission d'intermédiation. De la même façon, en cours de contrat, l'assuré doit aviser notre cabinet par écrit de toute modification á venir dans sa situation (changement de statut, d'activité professionnelle, cessation d'activité, montant des revenus professionnels, situations ou sports á risques ....)</div>

		<div style='position:absolute;top:332;left:29'><h5><u>II- Transmission des informations</u></h5></div>

		<div style='position:absolute;top:368;left:30'>En nous communiquant votre adresse postale et/ou électronique, vous acceptez que les informations relatives á l’exécution de votre adhésion soient transmises á cette adresse. Vous pouvez nous demander á tout moment, par écrit, de cesser ce mode de communication. En cas de changement d’adresse postale et/ou électronique, vous devez nous en avertir dans les plus brefs délais. A défaut, les courriers transmis á la dernière adresse connue produiront tous leurs effets. </div>

		<div style='position:absolute;top:411;left:29'><h5><u>III- Importance des conditions générales</u></h5></div>

		<div style='position:absolute;top:447;left:30'>Il est très important que vous lisiez attentivement les conditions générales valant note d'information de votre (ou vos) contrat(s) d'assurances, qui vous seront remises au moment de la signature du (ou des) document(s) d'adhésion. Les conditions générales constituent le document juridique contractuel exprimant les droits et obligations de l'assuré et de l'assureur. Nous attirons votre attention sur les paragraphes des conditions générales consacrées notamment aux risques exclus, á la durée d'adhésion de votre (ou vos) contrat(s), aux délais de carences qui peuvent être appliqués, période pendant laquelle l'assuré ne peut demander la mise en oeuvre de ses garanties, de franchise, période durant laquelle le sinistre reste á la charge de l'assuré(e), aux définitions des garanties ainsi qu'á leurs motifs et dates d'expiration.</div>

		<div style='position:absolute;top:513;left:29'><h5><u>IV- Importance de vos déclarations</u></h5></div>

		<div style='position:absolute;top:549;left:30'>Nous attirons votre attention sur l'importance de la précision et de la sincérité des réponses que vous apporterez aux questions posées par l'assureur, y compris la partie questionnaire de santé. Toute Inexactitude, omission, réticence ou fausse déclaration intentionnelle ou non de la part de l'assuré portant sur les éléments constitutifs du risque au moment de l'adhésion ou en cours d'adhésion, est sanctionnée même si elle a été sans influence sur le sinistre, par une réduction d'indemnité ou une nullité du contrat. De même toute ommission, réticence, fausse déclaration intentionnelle ou non dans la déclaration du sinistre expose l'assuré á une déchéance de garanties et á la résiliation de son adhésion. Le cabinet Social Concept Développement ne saurait être tenu responsable des conséquences qui en découleraient.</div>

		<div style='position:absolute;top:612;left:29'><h5><u>V- Importance des cotisations</u></h5></div>
		
		<div style='position:absolute;top:648;left:30'>Vous attestez par la présente que les garanties proposées, les modalités de paiement des cotisations et leur évolution éventuelle ont été évoquées. Votre attention a été attirée sur le fait que l'interruption des cotisations périodiques entrainera pour certains dossiers la résiliation automatique de certaines garanties (en cas d'incapacité, d'invalidité, ou de garanties de bonne fin en cas de décès par exemple), dans les délais prévus aux dispositions générales. Le défaut de paiement peut  provoquer la mise en réduction de l'adhésion avec toutes ses conséquences. Malgré le fait que certaines compagnies vous permettent á nouveau la reprise de ces versements, nous vous engageons á vous rapprocher de votre cabinet, pour en mesurer les risques et les conséquences</div>

		<div style='position:absolute;top:707;left:29'><h5><u>VI- Prise d'effet des garanties</u></h5></div>

		<div style='position:absolute;top:740;left:30'>La prise d'effet des garanties indiquées sur le Certificat d’adhésion par la compagnie d'Assurances, est liée aux conditions suspensives du paiement de la première cotisation et sous réserve d’acceptation par cette même compagnie, concrétisée par l’émission d’un Certificat d’adhésion précisant le montant des garanties pour chacun des risques couverts. Note de couverture : L’Assuré peut bénéficier d’une garantie supplémentaire temporaire en cas de décès suite á un Accident survenu entre la date de signature de la demande d’adhésion, et la date d’acceptation par la compagnie d'Assurances.</div>

		<div style='position:absolute;top:812;left:30'><span style='color: #614B3A;'>Les informations recueillies sont nécessaires au traitement de votre demande en matière d'assurance et peuvent faire l'objet d'un traitement informatique. Le destinataire des données est la société Stratégies & Perspectives d'Avenir. Le fichier est enregistré á la CNIL sous le N° 1525993. Conformément á l'article 23 de la loi Informatique et libertés N° 78-17 du 6 janvier 1978 modifiée en 2004, vous bénéf iciez d'un droit d'accès et de rectification aux informations vous concernant, que vous pouvez exercer en vous adressant á Stratégies &amp; perspectives d'Avenir - Pôle technologique Nancy - Brabois    6 allée Pelletier Doisy 54603 VILLERS LES NANCY Cedex.</span></div>

		<div style='position:absolute;top:880;left:30'>Fait en 2 exemplaires á ".$res2[0]['CLT-Ville'].", le ".$date_deux." en deux exemplaires, dont un pour ".$res2[0]['CIV-Nom']." ".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']." qui reconnait l'avoir reçu.</div></i>

		<div style='position:absolute;top:936;left:494'> ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom']."</div>
		<div style='position:absolute;top:936;left:171'>".$res2[0]['CLT-Prénom']." ".$res2[0]['CLT-Nom']."</div>
		<div style='position:absolute;top:915;left:464'> L'intermédiaire en Assurances</div>
		<div style='position:absolute;top:915;left:183'>Le Candidat á l'Assurance</div>
		
	</span>

    <page_footer>
    	<span style='font-size:10px'>
    	<b><div style='position:absolute;top:1015;left:90'><span>Siège Social : ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</span></div></b>
		<div style='position:absolute;top:1030;left:40'><span>SARL au Capital de ".$res2[0]['CON-CapitalSocial']." euros inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N°".$res2[0]['CON-NumRCS']." -  Code APE ".$res2[0]['CON-APE']."</span></div>
		<div style='position:absolute;top:1045;left:110'><span> Téléphone :  ".$res2[0]['CON-Tel']."        Fax : ".$res2[0]['CON-Fax']."       ".$res2[0]['CON-Internet']."</span></div>
		<div style='position:absolute;top:1060;left:65'><span>Immatriculée  á l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACPR - 61 rue Taitbout - 75436 PARIS Cedex 09</span></div>
		<div style='position:absolute;top:1075;left:85'><span>Responsabilité Civile Professionnelle et Garanties Financières conformes aux articles L.530-1 et L.530-2 du Code des Assurances</span></div>
		</span>
    </page_footer>

	</page>";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('InfosPrecontractuelles.pdf');



?>