<?php
    session_start();

    include "../BDD.php";

    $query ="
        SELECT `CLT-Nom`, `CLT-Prénom` AS Client, Conseillers.`CON-Nom`, Conseillers.`CON-NumORIAS`, Conseillers.`CON-Prénom`, `Clients et Prospects`.`CLT-Nom`, `Clients et Prospects`.`CLT-Prénom`, `Type Produit`.`TPD-Nom`, `Evenements par Produits`.`E/P-Scoring`, `Produits par Clients`.`P/C-DossierConcurrent`, Produits.`PDT-Nom`, Compagnies.`CIE-Nom`, `Type Situations Contrats`.`TSC-Nom`, `Evenements par Produits`.`E/P-MontantPP`, `Evenements par Produits`.`E/P-MontantPU`, `Evenements par Produits`.`E/P-AcceptMedicale`
        FROM `Type Produit` INNER JOIN ((`Type Situations Contrats` INNER JOIN ((Conseillers INNER JOIN `Clients et Prospects` ON Conseillers.`CON-NumID` = `Clients et Prospects`.`CLT-Conseiller`) INNER JOIN ((Compagnies INNER JOIN Produits ON Compagnies.`CIE-NumID` = Produits.`PDT-Cie`) INNER JOIN `Produits par Clients` ON Produits.`PDT-NumID` = `Produits par Clients`.`P/C-NumProduit`) ON `Clients et Prospects`.`CLT-NumID` = `Produits par Clients`.`P/C-NumClient`) ON (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`) AND (`Type Situations Contrats`.`TSC-NumID` = `Produits par Clients`.`P/C-SituationContrat`)) INNER JOIN `Evenements par Produits` ON `Produits par Clients`.`P/C-NumID` = `Evenements par Produits`.`E/P-NumProduitClient`) ON `Type Produit`.`TPD-NumID` = Produits.`PDT-Type`
        WHERE (((Conseillers.`CON-NumORIAS`) Like ".$_SESSION['Auth']['orias'].") AND ((`Type Produit`.`TPD-Nom`)='Epargne') AND ((`Evenements par Produits`.`E/P-Scoring`)=0) AND ((`Produits par Clients`.`P/C-DossierConcurrent`)=0)) OR (((`Type Produit`.`TPD-Nom`)='Retraite') AND ((`Evenements par Produits`.`E/P-Scoring`)=0) AND ((`Produits par Clients`.`P/C-DossierConcurrent`)=0));
    ";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $res2 = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="
    <page backright='10mm'>

    <span style='font-size:10px'>
       <div style='position:absolute;top:26;left:225;border: 1px solid black;padding:5px;'><h3>Dossiers Tracfin en Anomalie</h3></div>

        <div style='position:absolute;top:89;left:30;color:#175AB0;'><h5>".$res2[0]['CON-Nom']." ".$res2[0]['CON-Prénom']."</h5></div>";

        $tab = array();
        $i = 120;
        foreach ($res2 as $r) {
            if($i > 1050){
                $content.="</span></page><page backright='10mm'><span style='font-size:10px'>";
                $i = 40;
            }
            if(!in_array($r['CIE-Nom'],$tab)){
                array_push($tab,$r['CIE-Nom']);
                $i = $i + 12;
                $content.="
                <span style='color:#034962;'>
                <i>
                <div style='position:absolute;top:".$i.";left:30;color:#404040;'><h4><u>".$r['CIE-Nom']."</u></h4></div>";
                $i = $i + 6;
                $content.="
                <div style='position:absolute;top:".$i.";left:422'>Pré-</div>";
                $i = $i + 12;
                $content.="
                <div style='position:absolute;top:".$i.";left:605'> Montant PP &nbsp;&nbsp;&nbsp; Versement</div>";
                $i = $i + 1;
                $content.="
                <div style='position:absolute;top:".$i.";left:411'>acceptation</div>
                </i>
                </span>";
                $i = $i + 7;
            }
            
            $i = $i + 17;
            $content.="
            <span style='color:#034962;'>
            <i>
            <div style='position:absolute;top:".$i.";left:30'><b>".$r['CLT-Nom']." ".$r['CLT-Prénom']."</b></div>
            <div style='position:absolute;top:".$i.";left:254'>".$r['PDT-Nom']."</div>";
            if($r['E/P-AcceptMedicale'] == 1){
                $content.="<div style='position:absolute;top:".$i.";left:430'><img width=15 height=15 src='../img/check.jpg'/></div>";
            }
            $content.="
            <div style='position:absolute;top:".$i.";left:477'> ".$r['TSC-Nom']."</div>
            <div style='position:absolute;top:".$i.";left:614'> ".sprintf('%.2f &euro;',$r['E/P-MontantPP'])."</div>
            <div style='position:absolute;top:".$i.";left:678'> ".sprintf('%.2f &euro;',$r['E/P-MontantPU'])."</div>
            </i>
            </span>";
        }
     
    $content.="   
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('ScoringAnomalie.pdf');


?>