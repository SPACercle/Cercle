<?php
    include "../BDD.php";

    // 1 - LA REQUETE
    $query ="SELECT `CIE-TarifInternet`, `CIE-Nom` FROM `compagnies` WHERE `CIE-TarifInternet` <> '' ORDER BY `CIE-Nom`;";
    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $sites = $res->fetchALL(PDO::FETCH_ASSOC);

    // 2 - LE CONTENU DE LA PAGE EN HTML
    $content="
    <page backright='10mm'>
    <span style='font-size:12px'>
    <div style='position:absolute;top:0;left:0'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    <div style='position:absolute;top:10;left:300'><h4>Liste des Sites de tarifications Compagnies</h4></div>";

    $i = 130;
    //Boucle sur les données
    foreach ($sites as $site) {
        $content.="
            <div style='position:absolute;top:".$i.";left:20'><b>".$site['CIE-Nom']."</b></div>
            <div style='position:absolute;top:".$i.";left:283'><a href='".$site['CIE-TarifInternet']."'>".$site['CIE-TarifInternet']."</a></div>
        ";
        $i = $i + 20;
    }

    $content.="</span></page>";

    // 3 - GENERATION DU DOCUEMENT PDF AVEC LE PLUGIN PHP HTML2PDF
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Liste Sites.pdf');
?>