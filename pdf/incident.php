<?php

    $content="<page backright='10mm'>

	<page_header>
		<div style='position:absolute;top:0;left:500'><img style='width:220px;height:70px;' src='../img/logos/strategie/blanc_strategie.jpg' ALT=''></div>
    </page_header>

    <span style='font-size:12px'>
        <div style='position:absolute;top:36;left:33'><b>Procédure de traitement Incident de Gestion</b></div>
        <div style='position:absolute;top:64;left:34'><b>Responsable Sylvain MAILLARD</b></div>
        <div style='position:absolute;top:140;left:26'><h5><u>1) texte</u></h5></div>
        <div style='position:absolute;top:174;left:30'>----</div>
    </span>
    </page>
    ";

    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('IncidentGestion.pdf');


?>