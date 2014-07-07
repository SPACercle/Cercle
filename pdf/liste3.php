<?php
    session_start();
    include "../BDD.php";

    if($_SESSION['Auth']['modeAgence'] == 0){
        $query ="
        SELECT DISTINCT `Clients et Prospects`.`CLT-NumID` AS ExpertNumID, `Clients et Prospects`.`CLT-Nom` AS ExpertNom, `Clients et Prospects`.`CLT-Prénom` AS ExpertPrénom, Relations_1.`REL-Nom` AS LienExpertClient, `Clients et Prospects_1`.`CLT-Nom` AS ClientNom, `Clients et Prospects_1`.`CLT-Prénom` AS ClientPrénom, Professions.`PRO-Nom` AS ClientProfession, `Clients et Prospects_1`.`CLT-Ville` AS ClientVille, `Type Client`.`TYP-Nom`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-NumORIAS`
        FROM Conseillers INNER JOIN (`Type Client` INNER JOIN (Professions RIGHT JOIN (`Clients et Prospects` INNER JOIN (Relations AS Relations_1 INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN `Relations par personne` AS `Relations par personne_1` ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumReco`) ON Relations_1.`REL-Num` = `Relations par personne_1`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumApporteur`) ON Professions.`PRO-NumID` = `Clients et Prospects_1`.`CLT-Profession`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects_1`.`CLT-Type`) ON Conseillers.`CON-NumID` = `Clients et Prospects_1`.`CLT-Conseiller`
        WHERE (((Relations_1.`REL-Nom`)='est expert comptable de') AND ((Conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias']."))
        ORDER BY `ExpertNom`;";
    } else {
        $query ="
        SELECT DISTINCT `Clients et Prospects`.`CLT-NumID` AS ExpertNumID, `Clients et Prospects`.`CLT-Nom` AS ExpertNom, `Clients et Prospects`.`CLT-Prénom` AS ExpertPrénom, Relations_1.`REL-Nom` AS LienExpertClient, `Clients et Prospects_1`.`CLT-Nom` AS ClientNom, `Clients et Prospects_1`.`CLT-Prénom` AS ClientPrénom, Professions.`PRO-Nom` AS ClientProfession, `Clients et Prospects_1`.`CLT-Ville` AS ClientVille, `Type Client`.`TYP-Nom`, Conseillers.`CON-Nom`, Conseillers.`CON-Prénom`, Conseillers.`CON-NumORIAS`
        FROM Conseillers INNER JOIN (`Type Client` INNER JOIN (Professions RIGHT JOIN (`Clients et Prospects` INNER JOIN (Relations AS Relations_1 INNER JOIN (`Clients et Prospects` AS `Clients et Prospects_1` INNER JOIN `Relations par personne` AS `Relations par personne_1` ON `Clients et Prospects_1`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumReco`) ON Relations_1.`REL-Num` = `Relations par personne_1`.`R/P-Type`) ON `Clients et Prospects`.`CLT-NumID` = `Relations par personne_1`.`R/P-NumApporteur`) ON Professions.`PRO-NumID` = `Clients et Prospects_1`.`CLT-Profession`) ON `Type Client`.`TYP-NumID` = `Clients et Prospects_1`.`CLT-Type`) ON Conseillers.`CON-NumID` = `Clients et Prospects_1`.`CLT-Conseiller`
        WHERE (((Relations_1.`REL-Nom`)='est expert comptable de'))
        ORDER BY `ExpertNom`;";
    }

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $liste = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>
        <div style='position:absolute;top:10;left:200'><h3>Liste des Clients par Expert-comptables</h3></div>";

        $tab = array();
        $i = 78;
        foreach ($liste as $l) {
            if($i > 1000){
                $content.=" </span></page><page backright='10mm'><span style='font-size:12px'>";
                $i = 78;
            }
            if(!in_array($l['ExpertNumID'],$tab)){
                array_push($tab,$l['ExpertNumID']);
                $content.="
                <div style='position:absolute;top:".$i.";left:30;width:100%'><hr/></div>
                <div style='position:absolute;top:".$i.";left:30'><h4>".$l['ExpertNom']." ".$l['ExpertPrénom']."</h4></div>
                ";
                $i = $i + 40;
            }
            
            $content.="
            <span style='font-size:11px'><i>
            <span style='color:#462E01'>
            <div style='position:absolute;top:".$i.";left:42'>".$l['LienExpertClient']."</div>
            <div style='position:absolute;top:".$i.";left:183'>".$l['ClientNom']."</div>
            <div style='position:absolute;top:".$i.";left:305'>".$l['ClientPrénom']."</div>
            <div style='position:absolute;top:".$i.";left:427'>".mb_strimwidth($l['ClientProfession'], 0, 30, "...")."</div>
            <div style='position:absolute;top:".$i.";left:600'>".$l['ClientVille']."</div>
            </span>";
            $i = $i + 17;
            $content.="
            <span style='color:#785E2F'>
            <div style='position:absolute;top:".$i.";left:77'>".$l['TYP-Nom']."</div>
            <div style='position:absolute;top:".$i.";left:195'>".$l['CON-Nom']."</div>
            <div style='position:absolute;top:".$i.";left:313'>".$l['CON-Prénom']."</div>
            </span>
            </i></span>
            ";
            $i = $i + 17;
        }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ListeClientsExperts.pdf');


?>