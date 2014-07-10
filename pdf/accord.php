<?php
    session_start();

    include "../BDD.php";
    include "../Auth.php";

    $query ="
    SELECT civilites.`CIV-Nom`, `clients et prospects`.`CLT-Nom`, `clients et prospects`.`CLT-Prénom`, `type responsable`.`R/A-Type`, conseillers.`CON-Nom`, conseillers.`CON-Prénom`, conseillers.`CON-NumORIAS`
    FROM ((`type responsable` INNER JOIN `accords partenaires` ON `type responsable`.`R/A-NumID` = `accords partenaires`.`ACC-NumType`) INNER JOIN conseillers ON `accords partenaires`.`ACC-NumConseiller` = conseillers.`CON-NumID`) INNER JOIN (`clients et prospects` INNER JOIN civilites ON `clients et prospects`.`CLT-Civilité` = civilites.`CIV-NumID`) ON `accords partenaires`.`ACC-NumPartenaire` = `clients et prospects`.`CLT-NumID`
    ORDER BY `CLT-Nom`;
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $accords = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>
        <div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
        <div style='position:absolute;top:15;left:37'><h3>Gestion des Accords Partenaires</h3></div>";

    $i = 90;
    $tab = array();
    foreach ($accords as $acc) {
        if(Auth::getInfo('modeAgence') == 1){
            if($i > 985){
                $content.=" </span></page><page backright='10mm'><span style='font-size:12px'><div style='position:absolute;top:15;left:37;border:1px solid black;padding:2px;'><h3>Gestion des Accords Partenaires</h3></div>";
                $i = 90;
            }
            if(!in_array($acc['CLT-Nom'],$tab)){
                $i = $i + 15;
                array_push($tab,$acc['CLT-Nom']);
                $content.="
                <div style='position:absolute;top:".$i.";left:65;color:#5C83B4;font-size:14px;'><b>".$acc['CIV-Nom']." ".$acc['CLT-Nom']." ".$acc['CLT-Prénom']."</b></div>";
                $i = $i + 20;
            } else {
                $i = $i + 7;
            }
            $content.="
            <div style='position:absolute;top:".$i.";left:125'>".$acc['R/A-Type']."</div>
            <div style='position:absolute;top:".$i.";left:200'><b>".$acc['CON-Nom']." ".$acc['CON-Prénom']."</b></div>
            ";
             $i = $i + 10;
        } else {
            if(Auth::getInfo('orias') == $acc['CON-NumORIAS']){
                if($i > 985){
                    $content.=" </span></page><page backright='10mm'><span style='font-size:12px'><div style='position:absolute;top:15;left:37;border:1px solid black;background:#7F8FA6;padding:2px;'><h3>Gestion des Accords Partenaires</h3></div>";
                    $i = 90;
                }
                if(!in_array($acc['CLT-Nom'],$tab)){
                    $i = $i + 15;
                    array_push($tab,$acc['CLT-Nom']);
                    $content.="
                    <div style='position:absolute;top:".$i.";left:65;color:#5C83B4;font-size:14px;'><b>".$acc['CIV-Nom']." ".$acc['CLT-Nom']." ".$acc['CLT-Prénom']."</b></div>";
                    $i = $i + 20;
                } else {
                    $i = $i + 7;
                }
                $content.="
                <div style='position:absolute;top:".$i.";left:125'>".$acc['R/A-Type']."</div>
                <div style='position:absolute;top:".$i.";left:200'><b>".$acc['CON-Nom']." ".$acc['CON-Prénom']."</b></div>
                ";
                 $i = $i + 10;
                }
        }
    }

    $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('AccordsPartenaires.pdf');


?>