<?php
    include "../BDD.php";

    $query ="SELECT * FROM `compagnies contacts` WHERE `C/C-Num` = ".$_GET['idComp']." ORDER BY `C/C-Nom`;";

    $pdo = BDD::getConnection();
    $pdo->exec("SET NAMES UTF8");
    $res = $pdo->query($query);
    $contacts = $res->fetchALL(PDO::FETCH_ASSOC);

    $content="<page backright='10mm'>

    <span style='font-size:10px'>
        <div style='position:absolute;top:18;left:26'><h2>Compagnies Contacts Nationaux</h2></div>

        <div style='position:absolute;top:89;left:30'><h4><u>GENERALI</u></h4></div>

        <div style='position:absolute;top:200;left:20'>Nom/Service</div>
        <div style='position:absolute;top:200;left:100'>Prénom</div>
        <div style='position:absolute;top:200;left:180'>TelBureau</div>
        <div style='position:absolute;top:200;left:280'>Mail</div>
        <div style='position:absolute;top:200;left:360'>TelPortable</div>
        <div style='position:absolute;top:200;left:460'>Fax</div>
        <div style='position:absolute;top:200;left:500'>Fonction</div>
        <div style='position:absolute;top:200;left:550'>Horaires Ouverture</div>
        <div style='position:absolute;top:200;left:680'>Commentaire</div>";

        $i = 220;
        foreach ($contacts as $cont) {
            $content.="
                <div style='position:absolute;top:".$i.";left:20'>".$cont['C/C-Nom']."</div>
                <div style='position:absolute;top:".$i.";left:100'>".$cont['C/C-Prénom']."</div>
                <div style='position:absolute;top:".$i.";left:180'>".$cont['C/C-TelBureau']."</div>
                <div style='position:absolute;top:".$i.";left:280'>".$cont['C/C-Mail']."</div>
                <div style='position:absolute;top:".$i.";left:360'>".$cont['C/C-TelPortable']."</div>
                <div style='position:absolute;top:".$i.";left:460'>".$cont['C/C-Fax']."</div>
                <div style='position:absolute;top:".$i.";left:500'>".$cont['C/C-Fonction']."</div>
                <div style='position:absolute;top:".$i.";left:550'>".$cont['C/C-HorairesOuverture']."</div>
                <div style='position:absolute;top:".$i.";left:680'>".$cont['C/C-Commentaire']."</div>
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