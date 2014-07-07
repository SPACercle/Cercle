<?php
    session_start();
    include "../BDD.php";


    if($_SESSION['Auth']['modeAgence'] == 1){
        $query ='
        SELECT DISTINCT `CLT-NumID`, `CON-NumID`, `CON-Nom`, `CON-Prénom`, `CLT-Nom`, `CLT-Prénom`
        FROM `Clients et Prospects`, `Statut Professionnel`, `Conseillers`
        WHERE `CLT-Statut` = `SPR-NumID` 
        AND `CLT-Type` = 1 
        AND `SPR-Nom` NOT IN ("Salarié(e) Non Titulaire de l\'état","Fonctionnaire","MCU-PH","Salarié(e) Cadre","Retraité(e)","PU-PH sans Secteur Privé","Salarié(e) Non Cadre") 
        AND `CON-NumID` = `CLT-Conseiller`
        AND `CLT-NumID` NOT IN (
            SELECT DISTINCT cli.`CLT-NumID` 
            FROM `Clients et Prospects` cli, `Relations par personne` rp, `Statut Professionnel` sp, `Conseillers` con
            WHERE cli.`CLT-Statut` = sp.`SPR-NumID` 
            AND  rp.`R/P-NumApporteur` = cli.`CLT-NumID` 
            AND rp.`R/P-Type` = 13 AND cli.`CLT-Type` = 1 
            AND `SPR-Nom` NOT IN ("Salarié(e) Non Titulaire de l\'état","Fonctionnaire","MCU-PH","Salarié(e) Cadre","Retraité(e)","PU-PH sans Secteur Privé","Salarié(e) Non Cadre")
            AND con.`CON-NumID` = cli.`CLT-Conseiller`
            )
        ORDER BY `CON-Nom`, `CLT-Nom`, `CLT-Prénom`;
        ';
    } else {
        $query ='
        SELECT DISTINCT `CLT-NumID`, `CON-NumID`, `CON-Nom`, `CON-Prénom`, `CLT-Nom`, `CLT-Prénom`
        FROM `Clients et Prospects`, `Statut Professionnel`, `Conseillers`
        WHERE `CLT-Statut` = `SPR-NumID` 
        AND `CLT-Type` = 1 
        AND `SPR-Nom` NOT IN ("Salarié(e) Non Titulaire de l\'état","Fonctionnaire","MCU-PH","Salarié(e) Cadre","Retraité(e)","PU-PH sans Secteur Privé","Salarié(e) Non Cadre") 
        AND `CON-NumORIAS` = 10057159
        AND `CON-NumID` = `CLT-Conseiller`
        AND `CLT-NumID` NOT IN (
            SELECT DISTINCT cli.`CLT-NumID` 
            FROM `Clients et Prospects` cli, `Relations par personne` rp, `Statut Professionnel` sp, `Conseillers` con
            WHERE cli.`CLT-Statut` = sp.`SPR-NumID` 
            AND  rp.`R/P-NumApporteur` = cli.`CLT-NumID` 
            AND rp.`R/P-Type` = 13 AND cli.`CLT-Type` = 1 
            AND `SPR-Nom` NOT IN ("Salarié(e) Non Titulaire de l\'état","Fonctionnaire","MCU-PH","Salarié(e) Cadre","Retraité(e)","PU-PH sans Secteur Privé","Salarié(e) Non Cadre")
            AND con.`CON-NumORIAS` = '.$_SESSION['Auth']['orias'].'
            AND con.`CON-NumID` = cli.`CLT-Conseiller`
            )
        ORDER BY `CON-Nom`, `CLT-Nom`, `CLT-Prénom`;
        ';
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $liste = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>

        <div style='position:absolute;top:21;left:29'><h3>Clients Sans Expert Comptable</h3></div>";

        $tab = array();
        $i = 65;
        foreach ($liste as $l) {
            if($i > 1000){
                $content.="</span></page><page backright='10mm'><span style='font-size:12px'>";
                $i = 65;
            }
            if(!in_array($l['CON-NumID'],$tab)){
                $content.="<div style='position:absolute;top:".$i.";left:30'><h4>".$l['CON-Nom']." ".$l['CON-Prénom']."</h4></div>";
                array_push($tab,$l['CON-NumID']);
                $i = $i + 50;
            }
            $content.="<div style='position:absolute;top:".$i.";left:30'>".$l['CLT-Nom']." ".$l['CLT-Prénom']."</div>";
            $i = $i + 20;
        }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ListeClientsSansExpertComptable.pdf');


?>