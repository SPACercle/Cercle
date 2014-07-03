<?php
    session_start();

    include "../BDD.php";
    include "../Auth.php";

    $query ="
    SELECT Professions.`PRO-Conseil`, Professions.`PRO-Nom`, Professions.`PRO-Catégorie`, `Type Client`.`TYP-Nom`, Civilites.`CIV-Nom`, Professions.`PRO-Nom`, `Clients et Prospects`.`CLT-NumID`, `Clients et Prospects`.`CLT-Statut`, `Clients et Prospects`.`CLT-Type`, `Clients et Prospects`.`CLT-Promotion`, `Clients et Prospects`.`CLT-Réseau`, `Clients et Prospects`.`CLT-Syndicat`, `Clients et Prospects`.`CLT-Conseiller`, `Clients et Prospects`.`CLT-PrsMorale`, `Clients et Prospects`.`CLT-Civilité`, `Clients et Prospects`.`CLT-Nom`, `SPR-Nom`, `Statut Professionnel`.`SPR-Nom`, `Clients et Prospects`.`CLT-FJ-RS`, `Clients et Prospects`.`CLT-NomJeuneFille`, `Clients et Prospects`.`CLT-Prénom`,conseillers.`CON-NumORIAS`,conseillers.`CON-Nom`,conseillers.`CON-Prénom`,`SPR-PersonneMorale`,`CON-Couleur`,`CON-NumID`
        FROM conseillers INNER JOIN (Civilites RIGHT JOIN (Professions RIGHT JOIN (`Statut Professionnel` RIGHT JOIN (`Type Client` INNER JOIN `Clients et Prospects` ON `Type Client`.`TYP-NumID` = `Clients et Prospects`.`CLT-Type`) ON `Statut Professionnel`.`SPR-NumID` = `Clients et Prospects`.`CLT-Statut`) ON Professions.`PRO-NumID` = `Clients et Prospects`.`CLT-Profession`) ON Civilites.`CIV-NumID` = `Clients et Prospects`.`CLT-Civilité`) ON conseillers.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`
        WHERE (((Professions.`PRO-Conseil`)=1)";
        if($_SESSION['Auth']['modeAgence'] == 0){
            $query.="AND ((conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias'].")";
        }
        $query.="
        )
        ORDER BY `PRO-Nom`,`CLT-Promotion`, `CLT-Nom`;
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $promos = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>    
        <div style='position:absolute;top:25;left:200;border:1px solid black;padding:2px;'><h3>Gestion des Promotions Partenaires</h3></div>";

        $i = 83;
        $tab_pro = array();
        $tab_promo = array();
        foreach ($promos as $pro) {
            if($i > 1000){
                $i = 83;
                $content.="</span></page><page backright='10mm'><span style='font-size:12px'>";
            }
            if(!in_array($pro['PRO-Nom'],$tab_pro)){
                $i = 83;
                array_push($tab_pro,$pro['PRO-Nom']);
                if(sizeof($tab_pro) != 1){
                    $content.="</span></page><page backright='10mm'><span style='font-size:12px'>";
                }
                $content.="
                <div style='position:absolute;top:".$i.";left:53;'><h3>".$pro['PRO-Nom']."</h3></div>";
                $i = $i + 47;
            }
            if(!in_array($pro['CLT-Promotion'],$tab_promo) && $pro['CLT-Promotion'] != ""){
                $i = $i + 20;
                array_push($tab_promo,$pro['CLT-Promotion']);
                $content.="
                <div style='position:absolute;top:".$i.";left:53;border:1px solid black;padding:2px;background:#7F8FA6;padding:2px;'><b>".$pro['CLT-Promotion']."</b></div>
                ";
                $i = $i + 28;
            } else {
                $i = $i + 18;
            }
            $content.="
            <div style='position:absolute;top:".$i.";left:53'><b>".$pro['CIV-Nom']." ".$pro['CLT-Nom']." ".$pro['CLT-Prénom']."</b></div>";
            if($pro['CON-NumID'] != 5){
                $content.="<div style='position:absolute;top:".$i.";left:404;font-size:10px;color:#856D4D;'><i>".$pro['TYP-Nom']." de ".$pro['CON-Nom']." ".$pro['CON-Prénom']."</i></div>";
            }
            $content.="
             ";
        }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Promotions.pdf');


?>