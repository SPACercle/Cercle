<?php
    include "../BDD.php";

    $query ="SELECT `CIE-TarifInternet`, `CIE-Nom` FROM `compagnies` WHERE `CIE-TarifInternet` <> '' ORDER BY `CIE-Nom`;";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $sites = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:12px'>
        <div style='position:absolute;top:0;left:0'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
        <div style='position:absolute;top:10;left:300;border:1px solid black;padding:5px;'><h4>Liste des Sites de tarifications Compagnies</h4></div>";

        $i = 130;
        foreach ($sites as $site) {
            $content.="
                <div style='position:absolute;top:".$i.";left:20'><b>".$site['CIE-Nom']."</b></div>
                <div style='position:absolute;top:".$i.";left:283'><a href='".$site['CIE-TarifInternet']."'>".$site['CIE-TarifInternet']."</a></div>
            ";
            $i = $i + 20;
        }

        $content.="
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Procédure Traitement.pdf');


?>