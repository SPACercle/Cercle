<?php

	include "../BDD.php";

	extract($_GET);

	$query ="SELECT cli.*, el.*, con.* FROM `clients et prospects` cli, `elements` el, `conseillers` con WHERE cli.`CLT-NumID`=$idClient AND el.`ELT-NumClt`=$idClient AND cli.`CLT-Conseiller`=con.`CON-NumID`
	";

	$pdo = BDD::getConnection();
	$pdo->exec("SET NAMES UTF8");
	$res = $pdo->query($query);
	$res2 = $res->fetchALL(PDO::FETCH_ASSOC);

	$logo = explode("\\",$res2[0]['CON-Logo'])[3];

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:0'><img style='width:250px;height:48px;' src='../img/logos/".$logo."' ALT=''></div>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
		<span style='font-size:10px;color:#6F6F46'><div style='position:absolute;top:63;left:20'>".$res2[0]['CON-Adresse']."</div>
		<div style='position:absolute;top:73;left:20'>".$res2[0]['CON-Adresse2']."</div>
		<div style='position:absolute;top:84;left:20'>".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</div></span>
    </page_header>

    <span style='font-size:12px'>
 	
		<i><div style='position:absolute;top:165;left:259;border:1px solid black;padding:5px;margin:0px'><h4 style='margin-top:0px;'>Eléments préparatoires à l'étude de </h4></div>
		<div style='position:absolute;top:178;left:311'><h5>Dr Mohamed Lotfi ABDENNEBI</h5></div></i>

		<b><span style='font-size:13px'>
		<div style='position:absolute;top:276;left:30'>Conformément à votre demande, voici la liste des éléments nécessaires a fin de mieux préparer votre rencontre avec ".$res2[0]['CON-Prénom']." ".$res2[0]['CON-Nom'].", Gérant de la société ".$res2[0]['CON-Société']."</div>
		</span></b>

		<span style='font-size:10px'><i>
		<div style='position:absolute;top:308;left:50'>SARL au Capital de 5100 € inscrite au Registre du commerce et des Sociétés de ".$res2[0]['CON-RCSVille']." sous le N° 5".$res2[0]['CON-NumRCS']." -  Code ".$res2[0]['CON-APE']."</div>

		<div style='position:absolute;top:320;left:50'>Sise ".$res2[0]['CON-Adresse']." ".$res2[0]['CON-Adresse2']." ".$res2[0]['CON-CP']." ".$res2[0]['CON-VIlle']."</div>

		<div style='position:absolute;top:331;left:50'>Immatriculée  à l'ORIAS sous le N° ".$res2[0]['CON-NumORIAS']." www.orias.fr et placée sous le contrôle de l'ACP - 61 rue Taitbout - 75436 PARIS Cedex 09</div>
		</i></span>

		<div style='position:absolute;top:488;left:450'>Avis Imposition (2042)</div>";
		if($res2[0]['ELT-AvisImpots2042M'] == 1){
			$content.="<div style='position:absolute;top:488;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-AvisImpots2042'] == 1){
			$content.="<div style='position:absolute;top:488;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:508;left:450'>Déclaration Impôts (2042)</div>";
		if($res2[0]['ELT-Declaration2042M'] == 1){
			$content.="<div style='position:absolute;top:508;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-Declaration2042'] == 1){
			$content.="<div style='position:absolute;top:508;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:528;left:450'>Déclaration (2035)</div>";
		if($res2[0]['ELT-Declaration2035M'] == 1){
			$content.="<div style='position:absolute;top:528;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-Declaration2035'] == 1){
			$content.="<div style='position:absolute;top:528;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:421;left:31'><b>Relevé Individuel de Situation Retraite</b></div>";
		if($res2[0]['ELT-RISM'] == 1){
			$content.="<div style='position:absolute;top:421;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-RIS'] == 1){
			$content.="<div style='position:absolute;top:421;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:489;left:31'>CRAM Relevé de Carrière </div>";
		if($res2[0]['ELT-CRAMM'] == 1){
			$content.="<div style='position:absolute;top:489;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CRAM'] == 1){
			$content.="<div style='position:absolute;top:489;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:509;left:31'>MSA Relevé de Carrière</div>";
		if($res2[0]['ELT-MSAM'] == 1){
			$content.="<div style='position:absolute;top:509;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-MSA'] == 1){
			$content.="<div style='position:absolute;top:509;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:528;left:31'>ARRCO Relevé de Points</div>";
		if($res2[0]['ELT-ARRCOM'] == 1){
			$content.="<div style='position:absolute;top:528;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-ARRCO'] == 1){
			$content.="<div style='position:absolute;top:528;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:548;left:31'>AGIRC Relevé de Points</div>";
		if($res2[0]['ELT-AGIRCM'] == 1){
			$content.="<div style='position:absolute;top:548;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-AGIRC'] == 1){
			$content.="<div style='position:absolute;top:548;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:568;left:31'>IRCANTEC Relevé de Points</div>";
		if($res2[0]['ELT-IRCANTECM'] == 1){
			$content.="<div style='position:absolute;top:568;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-IRCANTEC'] == 1){
			$content.="<div style='position:absolute;top:568;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:421;left:450'> Dernier Bulletin Salaire (Année N et N-1)</div>";
		if($res2[0]['ELT-FichePaieM'] == 1){
			$content.="<div style='position:absolute;top:421;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-FichePaie'] == 1){
			$content.="<div style='position:absolute;top:421;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		
		$content.="
		<div style='position:absolute;top:465;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Informations Fiscales</b></div>

		<div style='position:absolute;top:394;left:657;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'> Monsieur</div>

		<div style='position:absolute;top:394;left:716;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'> Madame</div>

		<div style='position:absolute;top:401;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Situation Retraite</b></div>

		<div style='position:absolute;top:394;left:310;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'> Monsieur</div>

		<div style='position:absolute;top:394;left:374;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'> Madame</div>

		<div style='position:absolute;top:622;left:31'>CARPIMKO Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CARPIMKOM'] == 1){
			$content.="<div style='position:absolute;top:622;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CARPIMKO'] == 1){
			$content.="<div style='position:absolute;top:622;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:642;left:31'>CARMF Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CARMFM'] == 1){
			$content.="<div style='position:absolute;top:642;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CARMF'] == 1){
			$content.="<div style='position:absolute;top:642;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:661;left:31'>CARPV Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CARPVM'] == 1){
			$content.="<div style='position:absolute;top:661;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CARPV'] == 1){
			$content.="<div style='position:absolute;top:661;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:681;left:31'>CAVAMAC Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CAVAMACM'] == 1){
			$content.="<div style='position:absolute;top:681;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CAVAMAC'] == 1){
			$content.="<div style='position:absolute;top:681;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:701;left:31'>CAVEC Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CAVECM'] == 1){
			$content.="<div style='position:absolute;top:701;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CAVEC'] == 1){
			$content.="<div style='position:absolute;top:701;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:721;left:31'>CAVOM Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CAVOMM'] == 1){
			$content.="<div style='position:absolute;top:721;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CAVOM'] == 1){
			$content.="<div style='position:absolute;top:721;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:740;left:31'>CIPAV Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CIPAVM'] == 1){
			$content.="<div style='position:absolute;top:740;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CIPAV'] == 1){
			$content.="<div style='position:absolute;top:740;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:760;left:31'>CNBF Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CNBFM'] == 1){
			$content.="<div style='position:absolute;top:760;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CNBF'] == 1){
			$content.="<div style='position:absolute;top:760;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:780;left:31'>CARCDSF Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CARCDSFM'] == 1){
			$content.="<div style='position:absolute;top:780;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CARCDSF'] == 1){
			$content.="<div style='position:absolute;top:780;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:799;left:31'>CRN Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CRNM'] == 1){
			$content.="<div style='position:absolute;top:799;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CRN'] == 1){
			$content.="<div style='position:absolute;top:799;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:819;left:31'>CAVP Appel de cotisations et Relevé de points</div>";
		if($res2[0]['ELT-CAVPM'] == 1){
			$content.="<div style='position:absolute;top:819;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-CAVP'] == 1){
			$content.="<div style='position:absolute;top:819;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:874;left:31'>RSI  Relevé de Carrière</div>";
		if($res2[0]['ELT-RSIM'] == 1){
			$content.="<div style='position:absolute;top:874;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-RSI'] == 1){
			$content.="<div style='position:absolute;top:874;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:894;left:31'>ORGANIC  Relevé de Points</div>";
		if($res2[0]['ELT-ORGANICM'] == 1){
			$content.="<div style='position:absolute;top:894;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-ORGANIC'] == 1){
			$content.="<div style='position:absolute;top:894;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:914;left:31'>AVA  Relevé de Points</div>";
		if($res2[0]['ELT-AVAM'] == 1){
			$content.="<div style='position:absolute;top:914;left:327'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-AVA'] == 1){
			$content.="<div style='position:absolute;top:914;left:387'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:602;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Professions Libérales</b></div>

		<div style='position:absolute;top:850;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Indépendants</b></div>

		<div style='position:absolute;top:823;left:450'>Conditions Générales</div>";
		if($res2[0]['ELT-PrevCGM'] == 1){
			$content.="<div style='position:absolute;top:823;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-PrevCG'] == 1){
			$content.="<div style='position:absolute;top:823;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:843;left:450'>Conditions Particulières</div>";
		if($res2[0]['ELT-PrevCPM'] == 1){
			$content.="<div style='position:absolute;top:843;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-PrevCP'] == 1){
			$content.="<div style='position:absolute;top:843;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:862;left:450'>Appel de cotisations</div>";
		if($res2[0]['ELT-PrevCotM'] == 1){
			$content.="<div style='position:absolute;top:862;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-PrevCot'] == 1){
			$content.="<div style='position:absolute;top:862;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:725;left:450'>Tableau des Garanties</div>";
		if($res2[0]['ELT-SanteTableauM'] == 1){
			$content.="<div style='position:absolute;top:725;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-SanteTableau'] == 1){
			$content.="<div style='position:absolute;top:725;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:744;left:450'>Appel de cotisations</div>";
		if($res2[0]['ELT-SanteCotM'] == 1){
			$content.="<div style='position:absolute;top:744;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-SanteCot'] == 1){
			$content.="<div style='position:absolute;top:744;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:598;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Retraite</b></div>

		<div style='position:absolute;top:799;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Prévoyance</b></div>

		<div style='position:absolute;top:705;left:450;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Contrats Santé</b></div>

		<div style='position:absolute;top:914;left:450;'>Autres Dossiers</div>";
		if($res2[0]['ELT-AutresDossiersM'] == 1){
			$content.="<div style='position:absolute;top:914;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-AutresDossiers'] == 1){
			$content.="<div style='position:absolute;top:914;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:618;left:450'>Conditions Générales</div>";
		if($res2[0]['ELT-RetCGM'] == 1){
			$content.="<div style='position:absolute;top:618;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-RetCG'] == 1){
			$content.="<div style='position:absolute;top:618;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:638;left:450'>Conditions Particulières</div>";
		if($res2[0]['ELT-RetCPM'] == 1){
			$content.="<div style='position:absolute;top:638;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-RetCP'] == 1){
			$content.="<div style='position:absolute;top:638;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<div style='position:absolute;top:658;left:450'>Appel de cotisations</div>";
		if($res2[0]['ELT-RetCotM'] == 1){
			$content.="<div style='position:absolute;top:658;left:678'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}
		if($res2[0]['ELT-RetCot'] == 1){
			$content.="<div style='position:absolute;top:658;left:735'><img width=15 height=15 src='../img/check.jpg'/></div>";
		}

		$content.="
		<span style='font-size:11px;color:red;'><i><div style='position:absolute;top:445;left:31'><u>Si ce document n'est pas disponible uniquement, merci de nous faire parvenir</u></div></i></span>

		<div style='position:absolute;top:469;left:31;border:1px solid black;padding:5px;background-color:#7BBDE4;padding:1px;'><b>Salariés</b></div>

		<div style='position:absolute;top:571;left:500'><b><u>Dossiers Complémentaires</u></b></div>

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
    $html2pdf->Output('Elements Préparatoires.pdf');


?>