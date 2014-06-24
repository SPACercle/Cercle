<?php

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:12px'>
        <div style='position:absolute;top:28;left:26'><b>Procédure de traitement RECLAMATION</b></div>
        <div style='position:absolute;top:56;left:26'><b>Responsable Alain GAZONI</b></div>

        <div style='position:absolute;top:297;left:29'><h5><u>2) Réception de la réclamationA</u></h5></div>

        <i><div style='position:absolute;top:363;left:33'>Confirmation de la prise en charge du sinistre auprès du client (par courrier AR ou mail), lui précisant les  documents à fournir, démarches nécessaires et déroulé.</div>
        </i>
        <div style='position:absolute;top:328;left:29'><h5><u>3) Confirmation de la prise en charge</u></h5></div>

        <div style='position:absolute;top:401;left:29'><h5><u>4) Impression du courrier pour dossier</u></h5></div>

        <i><div style='position:absolute;top:462;left:33'>Formaliser le détail</div>
        </i>
        <div style='position:absolute;top:428;left:29'><h5><u>5) Inscription de la réclamation dans LGC</u></h5></div>

        <i><div style='position:absolute;top:535;left:34'>Fixer un rendez-vous téléphonique une 15zaine plus tard pour faire un point sur la situation, l’avancement du dossier :</div>
        </i>       
        <i><div style='position:absolute;top:549;left:34'>. sur agenda courtier</div>
        </i>
        <i><div style='position:absolute;top:564;left:34'>. sur agenda Delphine pour rappel</div>
        </i>
        <div style='position:absolute;top:500;left:29'><h5><u>6) Positionnement d’un rendez-vous</u></h5></div>

        <i><div style='position:absolute;top:617;left:34'>Lors de l’entretien téléphonique, client donne son avis et son ressenti sur la qualité et rapidité du traitement du dossier =&gt; enregistrement sur LGC, traitement de la Cie</div>
        </i>
        <div style='position:absolute;top:582;left:29'><h5><u>7) Questionnaire</u></h5></div>

        <div style='position:absolute;top:644;left:29'><h5><u>8) Classement du dossier</u></h5></div>

        <i><div style='position:absolute;top:171;left:30'>Remises lors de la première rencontre et indiquant :</div>
        </i>
         
        <i><div style='position:absolute;top:186;left:30'>&quot;Toutes informations complémentaires concernant les dossiers en cours peuvent être obtenues en adressant directement cette demande au cabinet &quot;Coordonnées du cabinet de courtage&quot;. En cas de difficultés rencontrées, vous pouvez notifier par recommandé avec AR au service réclamation du cabinet &quot;Coordonnées du cabinet de courtage&quot;, le motif  de vos réclamations, qui vous répondra dans les plus bref délais. En cas de désaccord, et si toutes les voies de recours amiable ont été épuisées, l'adhérent peut adresser une réclamation écrite avec le motif du litige à l’autorité de Contrôle  Prudentiel (ACP) dont les coordonnées sont les suivantes : 61, rue Taitbout – 75436 Paris cedex 09. Vous pouvez également demander l'avis d'un médiateur. Les modalités vous seront communiquées, sur simple demande par le Service Réclamation du cabinet &quot;Coordonnées du cabinet de courtage&quot;</div>
        </i>
        <div style='position:absolute;top:136;left:26'><h5><u>1) Informations pré-contractuelles</u></h5></div>
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Tracfin.pdf');


?>