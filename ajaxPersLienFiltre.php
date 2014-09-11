<?php
/**
* Code qui va filtrer les personnes dans la boite pour la création de liens
*/
include_once "BDD.php";

extract($_POST);
$query = "SELECT `CLT-Nom`, `CLT-Prénom`, `CLT-NumID` FROM `clients et prospects` WHERE `CLT-Nom` LIKE '".$filtre."%' ORDER BY `CLT-Nom`";

$pdo = BDD::getConnection();
$pdo->exec("SET NAMES UTF8");
$res = $pdo->query($query);
$trow = $res->fetchALL(PDO::FETCH_ASSOC);

echo '
	<h4 style="display:inline;"><span style="color:#A5260A">Personne </span></h4>
	<input type="text" id="filtrePers" class="fc-field fc-selected" tabindex="1" value="'.$filtre.'">
';

foreach ($trow as $row) {
	echo "<div>".$row['CLT-Nom']." ".$row['CLT-Prénom']."<input type='hidden' name='pers' value='".$row['CLT-NumID']."'/></div>";
}


