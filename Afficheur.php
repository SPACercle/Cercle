<?php
/*
Classe qui permet d'afficher les différentes pages
Chaque fonction permet d'afficher une fonctionalité
*/

include_once 'BDD.php';

//Affichage de la page avec son contenu
function AffichePage($contenu) {
	print(include_once "kit.php");
}

//Affichage d'un message court sur une page
function AffichePageMessage($message){
	return($message);
}

//Affichage de l'accueil
function AfficheHome(){
	return('<center><br/><br/><br/><br/><img src="img/logo_new.png" style="width:300px;height:300px;"/><br/><br/><h4>Version Beta</h4></center>');
}

//Affichage des droits
function AfficheDroits($droits) {
	$code = "<div class='well'>";
	$code.= " <h4 style='display:inline;'>Statut : </h4>".$droits[0]['ADM-Nom']."<br/><br/>";
	$code.= " <h4 style='display:inline;'>Niveau : </h4>".$droits[0]['ADM-Niveau']."<br/><br/>";
	$code.= " <h4 style='display:inline;'>Fonction : </h4>".$droits[0]['FON-Nom']."<br/>";
	$code.= "</div>";
	$code.= "<div class='well'>";
	$code.= "<h4>Autorisations d'accès associés</h4><br/>";
	$code.= " <h4 style='display:inline;'>Programmation ";
	if($droits[0]['CON-AutAccèsProgrammation'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= "<h4 style='display:inline;'>Gestion données ";
	if($droits[0]['CON-AutGestionDonnées'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= " <h4 style='display:inline;'>Gestion compta ";
	if($droits[0]['CON-AutGestionCompta'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= " <h4 style='display:inline;'>Gestion protos ";
	if($droits[0]['CON-AutGestionProto'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= " <h4 style='display:inline;'>Visualisation protos ";
	if($droits[0]['CON-AutVisuProto'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= " <h4 style='display:inline;'>Gestion compagnies ";
	if($droits[0]['CON-AutGestionCie'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= " <h4 style='display:inline;'>Publipostage ";
	if($droits[0]['CON-AutCourriers'] == 1){
		$code.="<img src='img/valid.gif'/></h4><br/><br/>";
	}else{
		$code.="<img src='img/invalid.png'/></h4><br/><br/>";
	}
	$code.= "</div>";
	return($code);
}

//Affichage de la liste des clients
function AfficheClient($clients,$types,$filtre){
	$code= "<span style='font-size:20px;'><b><u>Liste des Clients</u></b></span><br/><br/>
	<form style='display:inline;' action='index.php?action=ajouterClient' method='post'/><button type='submit' class='btn btn-success'><i class='fa fa-plus'></i> Création Client</button></form>";
	$code.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form style='display:inline;' action='index.php?action=client' method='post'><select name='filtre'>";
	foreach($types as $type){
		if($filtre == $type['TYP-NumID']){
			$code.= "<option selected='selected' value='".$type['TYP-NumID']."'>".$type['TYP-Nom']."</option>";
		} else {
			$code.= "<option value='".$type['TYP-NumID']."'>".$type['TYP-Nom']."</option>";
		}
	}
	if($filtre == 'all'){
		$code.="<option selected='selected' value='all'>Tous</option>";
	} else {
		if(!isset($_POST['filtre'])){
			$code.="<option selected='selected' value='all'>Tous</option>";
		} else {
			$code.="<option value='all'>Tous</option>";
		}
	}
	$code.= '</select> <input type="submit" value="Filtrer"  onclick="$(\'#myModal\').modal(\'show\')"/></form>';
	$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<form style='display:inline;' action='index.php?action=client' method='post'>";
	if(!isset($_POST['filtre'])){
		$filtre = 1;
	}
	$code.="
	<input type='text' class='form-control' style='display:inline;width:200px;' name='recherche'/>
	<span class='input-group-btn' style='display:inline;'>
	<button class='btn btn-default' type='submit' style='display:inline;' onclick=\"$('#myModal').modal('show')\"><i class='fa fa-search'></i></button>
	</span>";
	$code.="
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-default' onclick=\"$('#myModal').modal('show')\"><i class='fa fa-refresh'></i> Actualiser</button>
	</form>
	";
	$code.= "<hr/><div class='col-lg-12'><div class='table-responsive'>
	<table class='table table-hover tablesorter' id='clients'>
	<thead>
	<tr>
	<th style='width:90px;'>Etat <i class='fa fa-sort' id='smileySort'></i></th>
	<th style='width:65px;'>Civilité <i class='fa fa-sort'></i></th>
	<th>Type <i class='fa fa-sort'></i></th>
	<th>Nom Client <i class='fa fa-sort'></i></th>
	<th style='width:120px;'>Date naissance <i class='fa fa-sort'></i></th>
	<th>Profession <i class='fa fa-sort'></i></th>
	<th >Ville <i class='fa fa-sort'></i></th>
	<th style='width:300px;'>Conseiller <i class='fa fa-sort'></i></th>
	<th style='width:70px;'>Accès <i class='fa fa-sort'></i></th>
	</tr>
	</thead>
	<tbody>";
	$code.='
	<script>
	setTimeout("tri()",1000);
	setTimeout("tri()",3000);
	setTimeout("tri()",7000); 
	function tri() {
    	$("#smileySort").click().click();
	}
	</script>';
	foreach($clients as $cli){
		$ok = false;
		foreach(Auth::getInfo('port') as $port){
			if($port['CON-NumID'] == $cli['CLT-Conseiller']){
				$ok = true;
				break;
			}
		}
		if($ok){
			if(in_array($cli['CLT-Conseiller'],Auth::getInfo('portsRestreint'))){
				$code.= '<tr style="cursor:url(\'img/lock.png\'), pointer;">';
			} else {
				$code.= '<tr onclick="window.open(\'index.php?action=ficheClient&idClient='.$cli['CLT-NumID'].'&onglet=general\');" class="rowClient" target="_blank">';
			}
			//DEBUT REQUETE ETAT AVEC SMILEY
			$smiley = 1;
			$pdo = BDD::getConnection();
			if($cli['CLT-Sensibilite'] != 0 && $cli['CLT-Type'] == 1){
				//Requete Historique Clients
				$query_his = "SELECT his.`H/C-NumID`, typ.`HIS-PECSensibilite`, his.`H/C-Date`, sen.`SEN-Fréquence` 
							  FROM `sensibilite client` sen, `historique par client` his, `type historique` typ 
							  WHERE his.`H/C-NumClient` = ".$cli['CLT-NumID']."
							  AND typ.`HIS-NumID` = his.`H/C-TypeHistorique` 
							  AND typ.`HIS-PECSensibilite` = 1 AND sen.`SEN-Num` = ".$cli['CLT-Sensibilite']."";
				$res_his = $pdo->query($query_his);
				$historiques = $res_his->fetchALL(PDO::FETCH_ASSOC);
				$diffMax = 0;
				$smileyMax = 1;
				foreach ($historiques as $historique) {
					$d1 = new DateTime($historique['H/C-Date']); 
					$d2 = new DateTime('NOW'); 
					$diff = $d1->diff($d2); 
					$diff2 = $diff->m + ($diff->y * 12);
					if($diff2 < $historique['SEN-Fréquence']){
						$smiley = 1;
					} else {
						if($diff2 < ($historique['SEN-Fréquence']+3)){
							$smiley = 2;
							if($smileyMax < $smiley){
								$smileyMax = $smiley;
							}
							if($diffMax < $diff2){
								$diffMax = $diff2;
							}
						} else {
							$smiley = 3;
							if($smileyMax < $smiley){
								$smileyMax = $smiley;
							}
							if($diffMax < $diff2){
								$diffMax = $diff2;
							}
						}
					}
				}
			}
			//FIN REQUETE ETAT AVEC SMILEY
			if($cli['CON-Couleur'] == null){
				$couleur = "#CCCCCC";
			} else {
				$couleur = $cli['CON-Couleur'];
			}
			$code.= "<td>";
			if($cli['CLT-Sensibilite'] != 0 && $smiley != 1){
				$code.="<img src='img/".$smileyMax.".png' style='width:20px;height:20px;'/> ".$diffMax." mois";
			} else {
				$code.="";
			}
			if(!isset($cli['CLT-DateNaissance'])){
				$dateNaissance = "";
			} else {
				$dateNaissance = date('d/m/Y',strtotime($cli['CLT-DateNaissance']));
			}
			$code.="</td>
			<td>".$cli['CIV-Nom']."</td>
			<td>".$cli['SPR-Nom']."</td>
			<td><b>".$cli['CLT-Nom']." ".$cli['CLT-Prénom']."</b></td>
			<td>".$dateNaissance."</td>
			<td>".$cli['PRO-Nom']."</td>
			<td>".$cli['CLT-Ville']."</td>
			<td><button type='button' class='btn btn-primary btn-xs' style='background-color:".$couleur.";border-color:black;width:20px;height:15px;'></button>&nbsp;&nbsp;
			 ".$cli['TYP-Nom']." de ".$cli['CON-Prénom']." ".$cli['CON-Nom']."</td>";
			if(in_array($cli['CLT-Conseiller'],Auth::getInfo('portsRestreint'))){
				$code.="<td><i class='fa fa-lock fa-lg lock' style='color:#BB0B0B;'></i></td>";
			} else {
				$code.="<td></td>";
			}
			$code.="</tr>";
		}
	}
	$code .= "</tbody></table></div></div>";
	return($code);
}

//Affichage de l'ajout d'un client
function AfficheClientAjout($formes){
	$code = '
	<span style="font-size:20px;"><b><u>Ajout Client</u></b></span><br/><br/>
	<div class="panel-body">
	<ul class="nav nav-tabs">
	<li class="active"><a href="#physique" data-toggle="tab">Personne physique</a></li>
	<li><a href="#morale" data-toggle="tab">Personne morale</a></li>
	</ul>
	<br/>
	<div class="tab-content">
	<div class="tab-pane fade in active" id="physique">
	<form action="index.php?action=addClientPhysique" method="post">
	<div class="form-group">
	<label>Nom : </label><br/>
	<input type="text" class="form-control" name="nom" placeholder="Nom" style="width:275px;" required/>
	</div>
	<div class="form-group">
	<label for="prenom">Prénom : </label><br/>
	<input type="text" class="form-control" name="prenom" placeholder="Prénom" style="width:275px;"/>
	</div>
	<div class="form-group">
	<label for="date">Date de naissance : </label><br/>
	<input type="date" class="form-control" name="date" placeholder="Date de naissance" style="width:275px;" required/>
	</div>
	<input type="submit" value="Créer"/>
	</form>
	</div>
	<div class="tab-pane fade" id="morale">
	<form action="index.php?action=addClientMorale" method="post">
	<div class="form-group">
	<label for="name">Forme juridique : </label><br/>
	<select name="forme" class="form-control" required style="width:275px;">';
	foreach($formes as $forme){
		$code.="<option value='".$forme['SPR-NumID']."'>".$forme['SPR-Nom']."</option>";
	}
	$code.='
	</select>
	</div>
	<div class="form-group">
	<label for="prenom">Raison sociale <i>(Ne pas mettre de forme juridique dans la raison sociale) :</i> </label><br/>
	<input type="text" class="form-control" name="raison" placeholder="Raison sociale" style="width:275px;" required/>
	</div>
	<input type="submit" value="Créer"/>
	</form>
	</div>
	</div>
	</div>  
	';
	return($code);
}

//Affichage de la fiche client
function AfficheFicheClient($client,$types_client,$conseillers,$civilites,$situations,$sensibilites,$categories,$professions,$status,$types_revenus,$revenus,$types_historique,$historiques,$types_relation,$relations,$personnes,$besoins,$occurences,$besoins_cli,$type_produits,$compagnies,$produits){
	$code='
	<h4 style="display:inline;">'.$client["CLT-Nom"].' '.$client["CLT-Prénom"].'</h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h5 style="display:inline;"><i>'.Auth::getInfo('ongletTitre').'</i></h5><br/><br/>
	<form style="display:inline;" action="index.php?action=courrierClient" method="post"/><button type="submit" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Courrier</button></form>
	<form style="display:inline;" action="index.php?action=supClient" method="post"/><input type="hidden" value="'.$client['CLT-NumID'].'" name="idClient"/><button onclick="return confirm(\'Voulez-vous vraiment supprimer ce client ?\')" type="submit" class="btn btn-danger"><i class="fa fa-trash-o fa-lg"></i> Suppression Client</button></form>';
	//DEBUT REQUETE ETAT AVEC SMILEY
	$pdo = BDD::getConnection();
	$smileyMax = 1;
	if($client['CLT-Sensibilite'] != 0 && $client['CLT-Type'] == 1){
		//Requete Historique Clients
		$query_his = "SELECT his.`H/C-NumID`, typ.`HIS-PECSensibilite`, his.`H/C-Date`, sen.`SEN-Fréquence` 
					  FROM `sensibilite client` sen, `historique par client` his, `type historique` typ 
					  WHERE his.`H/C-NumClient` = ".$client['CLT-NumID']."
					  AND typ.`HIS-NumID` = his.`H/C-TypeHistorique` 
					  AND typ.`HIS-PECSensibilite` = 1 AND sen.`SEN-Num` = ".$client['CLT-Sensibilite']."";
		$res_his = $pdo->query($query_his);
		$historiques_smiley = $res_his->fetchALL(PDO::FETCH_ASSOC);
		$diffMax = 0;
		$frequence;
		foreach ($historiques_smiley as $historique_smiley) {
			$frequence = $historique_smiley['SEN-Fréquence'];
			$d1 = new DateTime($historique_smiley['H/C-Date']); 
			$d2 = new DateTime('NOW'); 
			$diff = $d1->diff($d2); 
			$diff2 = $diff->m + ($diff->y * 12);
			if($diff2 < $historique_smiley['SEN-Fréquence']){
				$smiley = 1;
			} else {
				if($diff2 < ($historique_smiley['SEN-Fréquence']+3)){
					$smiley = 2;
					if($smileyMax < $smiley){
						$smileyMax = $smiley;
					}
					if($diffMax < $diff2){
						$diffMax = $diff2;
					}
				} else {
					$smiley = 3;
					if($smileyMax < $smiley){
						$smileyMax = $smiley;
					}
					if($diffMax < $diff2){
						$diffMax = $diff2;
					}
				}
			}
		}
	}
	//FIN REQUETE ETAT AVEC SMILEY
	$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4 style='display:inline;'>Etat : <img src='img/".$smileyMax.".png' style='width:25px;height:25px;'/>";
	$code.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	';
	if(isset($diffMax) && $diffMax != 0){
		$code.=" ".$diffMax.' mois';
	}
	$code.="</h4>";
	if(isset($frequence) && isset($frenquence)){
		$code.="&nbsp;&nbsp;&nbsp;&nbsp;<i>Sensibilité client : '.$frequence.' mois</i>";
	}
	$code.='
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<img id="load" src="img/load2.gif"/>
	<hr/>
	<div class="panel-body">
	<div class="tab-content">';
	//Onglet Génréral
	if($_GET['onglet'] == "general"){
		$code.=AfficheFicheClientGeneral($client,$types_client,$conseillers,$civilites,$situations,$sensibilites);
	}
	//Onglet Personel
	if($_GET['onglet'] == "personel"){
		if($client['CLT-PrsMorale'] == 0){
			$code.=AfficheFicheClientPersonel($client,$types_client,$conseillers,$civilites,$situations,$sensibilites);
		}
	}
	//Onglet Professionel
	if($_GET['onglet'] == "pro"){
		$code.=AfficheFicheClientProfessionnel($client,$categories,$professions,$status);
	}
	//Onglet Revenus
	if($_GET['onglet'] == "revenus"){
		if($client['CLT-PrsMorale'] == 0){
			$code.=AfficheFicheClientRevenus($client,$types_revenus,$revenus);
		}
	}
	//Onglet Historique
	if($_GET['onglet'] == "historique"){
		$code.=AfficheFicheClientHistorique($client,$types_historique,$historiques);
	}
	//Onglet Relationel
	if($_GET['onglet'] == "relationel"){
		$code.=AfficheFicheClientRelationel($client,$types_relation,$relations,$personnes);
	}
	//Onglet Besoin
	if($_GET['onglet'] == "besoin"){
		$code.=AfficheFicheClientBesoin($client,$besoins,$occurences,$besoins_cli);
	}
	//Onglet Solutions retenues
	if($_GET['onglet'] == "solution"){
		$code.=AfficheFicheClientSolution($client,$type_produits,$compagnies,$produits);
	}

	//Le reste à faire
	$code.='
	<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "profil"){
		$code.=' active';
	}
	$code.='" id="profil"><h3>Fonctionalité à venir</h3></div>';

	$code.='
	<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "tracfin"){
		$code.=' active';
	}
	$code.='" id="tracfin"><h3>Fonctionalité à venir</h3></div>';

	$code.='
	<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "liquidite"){
		$code.=' active';
	}
	$code.='" id="liquidite"><h3>Fonctionalité à venir</h3></div>';

	$code.='
	</div>
	</div>
	';
	//Menu du côté
	if($client['CLT-PrsMorale'] == 0){
		if(isset($_GET['onglet'])  && $_GET['onglet'] == "general"){
			$menu = '<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		} else {
			$menu = '<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "personel"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=personel"><i class="fa fa-user fa-lg"></i><b> Personnel</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=personel"><i class="fa fa-user fa-lg"></i><b> Personnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "pro"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=pro"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=pro"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "revenus"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=revenus"><i class="fa fa-euro fa-lg"></i><b> Revenus</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=revenus"><i class="fa fa-euro fa-lg"></i><b> Revenus</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "historique"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=historique"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=historique"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "relationel"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=relationel"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=relationel"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=besoin&idType=13"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=besoin&idType=13"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		}
		//Pas fait
		if(isset($_GET['onglet']) && $_GET['onglet'] == "profil"){
			$menu.='<li class="active"><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=profil"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		} else {
			$menu.='<li><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=profil"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		}
		//Pas fait
		if(isset($_GET['onglet']) && $_GET['onglet'] == "tracfin"){
			$menu.='<li class="active"><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=tracfin"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		} else {
			$menu.='<li><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=tracfin"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "solution"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=solution"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=solution"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		}
		//Pas fait
		if(isset($_GET['onglet']) && $_GET['onglet'] == "liquidite"){
			$menu.='<li class="active"><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=liquidite"><i class="fa fa-euro fa-lg"></i><b> Liquidités financières</b></a></li>';
		} else {
			$menu.='<li><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=liquidite"><i class="fa fa-euro fa-lg"></i><b> Liquidités financières</b></a></li>';
		}

	} else {
		if(isset($_GET['onglet'])  && $_GET['onglet'] == "general"){
			$menu = '<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		} else {
			$menu = '<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "pro"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=pro"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=pro"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "historique"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=historique"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=historique"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "relationel"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=relationel"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=relationel"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=besoin&idType=13"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=besoin&idType=13"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		}
		//Pa fait
		if(isset($_GET['onglet']) && $_GET['onglet'] == "profil"){
			$menu.='<li class="active"><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=profil"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		} else {
			$menu.='<li><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=profil"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		}
		//Pas fait
		if(isset($_GET['onglet']) && $_GET['onglet'] == "tracfin"){
			$menu.='<li class="active"><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=tracfin"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		} else {
			$menu.='<li><a style="color:#606060;" href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=tracfin"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "solution"){
			$menu.='<li class="active"><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=solution"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		} else {
			$menu.='<li><a href="index.php?action=ficheClient&idClient='.$client['CLT-NumID'].'&onglet=solution"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		}
	}
	$_SESSION['menu'] = $menu; 
	$code.='<script type="text/javascript">document.getElementById(\'load\').style.display = \'none\';</script>';
	return($code);
}

//Affichage de l'onglet Géneral
function AfficheFicheClientGeneral($client,$types_client,$conseillers,$civilites,$situations,$sensibilites){
	$code='
	<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "general"){
		$code.=' active';
	}
	$code.='" id="general">
	<form action="index.php?action=modifClientGeneral" method="post">
	<div class="col-lg-4">
	<div class="form-group">
	<label>Type : </label><br/>
	<select name="type" class="form-control" style="width:275px;">';
	foreach ($types_client as $type) {
		if($type['TYP-NumID'] == $client['CLT-Type']){
			$code.="<option selected='selected' value='".$type['TYP-NumID']."'>".$type['TYP-Nom']."</option>";
		} else {
			$code.="<option value='".$type['TYP-NumID']."'>".$type['TYP-Nom']."</option>";
		}
	}
	$code.='</select></div>
	<div class="form-group">
	<label>Conseiller : </label><br/>
	<select name="cons" class="form-control" style="width:275px;">';
	foreach ($conseillers as $cons) {
		if($cons['CON-NumID'] == $client['CLT-Conseiller']){
			$code.="<option selected='selected' value='".$cons['CON-NumID']."'>".$cons['CON-Prénom']." ".$cons['CON-Nom']."</option>";
		} else {
			$code.="<option value='".$cons['CON-NumID']."'>".$cons['CON-Prénom']." ".$cons['CON-Nom']."</option>";
		}
	}
	$code.='</select></div>
	<div class="form-group">
	<label>Personne Morale  </label>
	';
	if($client['CLT-PrsMorale'] == 1){
		$code.='<input type="checkbox" name="morale" checked>';
	} else {
		$code.='<input type="checkbox" name="morale">'; 
	}
	$code.='
	</div>
	<div class="form-group">
	<label>Civilité : </label><br/>
	<select name="civilite" class="form-control" style="width:275px;">';
	foreach ($civilites as $civilite) {
		if($civilite['CIV-NumID'] == $client['CLT-Civilité']){
			$code.="<option selected='selected' value='".$civilite['CIV-NumID']."'>".$civilite['CIV-Nom']."</option>";
		} else {
			$code.="<option value='".$civilite['CIV-NumID']."'>".$civilite['CIV-Nom']."</option>";
		}
	}
	$code.='</select></div>
	</div>
	<div class="col-lg-4">
	<div class="form-group">
	<label>Nom: </label><br/>
	<input type="text" class="form-control" style="width:275px;" name="nom" value="'.$client['CLT-Nom'].'"/> 
	</div>
	<div class="form-group">
	<label>Prénom : </label><br/>
	<input type="text" class="form-control" style="width:275px;" name="prenom" value="'.$client['CLT-Prénom'].'"/> 
	</div>
	<div class="form-group">
	<label><i>Nom de jeune fille :</i> </label><br/>
	<input type="text" class="form-control" style="width:275px;" name="nomJeuneFille" value="'.$client['CLT-NomJeuneFille'].'"/> 
	<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
	</div>
	</div>
	<div class="col-lg-12">
		<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Valider Modifications</button>
	</div>
	</form>
	</div>';
	return($code);
}

//Affichage de l'onglet Personel
function AfficheFicheClientPersonel($client,$types_client,$conseillers,$civilites,$situations,$sensibilites){
	$code='<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "personel"){
			$code.=' active';
	}
	$code.='" id="personel">
		<form method="post" action="index.php?action=modifClientPersonnel">
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
			<div class="col-lg-6">
				 <div class="panel panel-info">
		             <div class="panel-heading">
		              <h4 class="panel-title"><b>Contact Perso</b></h4>
		             </div>
		            <div class="panel-body">
					<label>Téléphone Portable : </label>
					<input type="text" name="telPort" style="width:110px;" value="'.$client['CLT-TelPort'].'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Téléphone Domicile : </label>
					<input type="text" name="telDom" style="width:110px;" value="'.$client['CLT-TelDom'].'"/><br/><br/>
					<label>Adresse Mail Perso : </label>
					<input type="text" name="mailPerso" style="width:250px;" value="'.$client['CLT-MailPerso'].'"/><br/><br/>
					<label>Adresse Skype : </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="skype" style="width:250px;" value="'.$client['CLT-AdresseSkype'].'"/><br/><br/>
					<label>Adresse : </label>
					<input type="text" name="adresse" style="width:300px;" value="'.$client['CLT-Adresse'].'"/><br/><br/>
					<label>Code Postal : </label>
					<input type="text" name="codePostal" style="width:75px;" value="'.$client['CLT-Code Postal'].'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Ville : </label>
					<input type="text" name="ville" style="width:150px;" value="'.$client['CLT-Ville'].'"/><br/><br/>
					<label>Commentaires : </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Sensibilité : </label>
					<select name="sensibilite" style="width:100px;">';
					foreach ($sensibilites as $sensibilite) {
						if($sensibilite['SEN-Num'] == $client['CLT-Sensibilite']){
							$code.="<option selected='selected' value='".$sensibilite['SEN-Num']."'>".$sensibilite['SEN-Nom']."</option>";
						} else {
							$code.="<option value='".$sensibilite['SEN-Num']."'>".$sensibilite['SEN-Nom']."</option>";
						}
					}
					$code.='</select><br/>
					<textarea name="com" rows="6" cols="75">'.$client['CLT-Commentaire'].'</textarea> 
				</div></div>
			</div>

			<div class="col-lg-6">
				  <div class="panel panel-info">
		             <div class="panel-heading">
		                <h4 class="panel-title"><b>Particularités Client</b></h4>
		             </div>
		            <div class="panel-body">
					<label>Date Naissance : </label>
					<input type="text" name="dateNaissance" style="width:110px;" value="';
					if($client['CLT-DateNaissance']!=null){
						$code.=date('d/m/Y',strtotime($client['CLT-DateNaissance']));
					} else {
						$code.="";
					}
					$code.='"/><br/><br/>
					<label>Situation Familiale : </label>
					<select name="situation" style="width:110px;">';
					foreach ($situations as $situation) {
						if($situation['SIT-NumID'] == $client['CLT-SitFam']){
							$code.="<option selected='selected' value='".$situation['SIT-NumID']."'>".$situation['SIT-Nom']."</option>";
						} else {
							if($client['CLT-SitFam'] == null && $situation['SIT-NumID'] == 5){
								$code.="<option selected='selected' value='".$situation['SIT-NumID']."'>".$situation['SIT-Nom']."</option>";
							} else {
								$code.="<option value='".$situation['SIT-NumID']."'>".$situation['SIT-Nom']."</option>";
							}
						}
					}
					$code.='</select><br/><br/>
					<label>Nb Enfants : </label>
					<input type="text" name="nbEnfants" style="width:110px;" value="'.$client['CLT-NbEnfants'].'"/><br/><br/>
					<label>Nationalité : </label>
					<input type="text" name="nationalite" style="width:110px;" value="'.$client['CLT-Nationalité'].'"/><br/><br/>
					<button type="button" onClick="window.open(\'elements.php?idClient='.$client['CLT-NumID'].'\',\'Eléments Préparatoires\',\'toolbar=no,status=no,width=800,height=800,scrollbars=yes,location=no,resize=yes,menubar=non\')" class="btn btn-default"><i class="fa fa-check-square-o"></i> Eléments préparatoires</button>&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>
					<a type="button" onclick="date()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Mandat Administratif</a>&nbsp;
					<script>
					function date() {
					    var date = prompt("A quelle date souhaites-tu l\'émettre ?","");
					    if (date != null) {
					        window.open("pdf/mandat.php?idClient='.$client['CLT-NumID'].'&date="+date);
					    }
					}
					</script>
					<label>Mandat Administratif&nbsp;&nbsp;</label>';
					if($client['CLT-MandatGestion'] == 1){
						$code.='<input type="checkbox" name="mandatGestion" checked>';
					} else {
						$code.='<input type="checkbox" name="mandatGestion">'; 
					}
					$code.='<br/><br/>
					<a type="button" onclick="date_pre1()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Infos Précontractuelles</a>&nbsp;
					<script>
					function date_pre1() {
					    var date1 = prompt("A quelle date souhaites-tu émettre le premier document ?","");
					    var date2 = prompt("A quelle date souhaites-tu émettre le second document ?","");
					    if (date1 != null && date2 != null) {
					        window.open("pdf/info-pre.php?idClient='.$client['CLT-NumID'].'&date1="+date1+"&date2="+date2);
					    }
					}
					</script>
					<label>Info-Précontractuelles&nbsp;&nbsp;</label>';
					if($client['CLT-InfoPreContrat'] == 1){
						$code.='<input type="checkbox" name="infoPre" checked>';
					} else {
						$code.='<input type="checkbox" name="infoPre">'; 
					}
					$code.='<br/><br/>
					<a type="button" onclick="date_place()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Mandat Placement</a>&nbsp;
					<script>
					function date_place() {
					    var date = prompt("A quelle date souhaites-tu émettre le premier document ?","");
					    var risques = prompt("Quels risques ?","");
					    if (date != null && risques != null) {
					        window.open("pdf/mandatPlacement.php?idClient='.$client['CLT-NumID'].'&date="+date+"&risques="+risques);
					    }
					}
					</script>
					<label>Mandat Placement Exclusif&nbsp;&nbsp;</label>';
					if($client['CLT-MandatCourtage'] == 1){
						$code.='<input type="checkbox" name="mandatCourtage" checked>';
					} else {
						$code.='<input type="checkbox" name="mandatCourtage">'; 
					}
					$code.='<br/><br/>
					<button type="button" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Lettre de Mission</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Lettre de Mission&nbsp;&nbsp;</label>';
					if($client['CLT-LettreMission'] == 1){
						$code.='<input type="checkbox" name="lettreMission" checked>';
					} else {
						$code.='<input type="checkbox" name="lettreMission">'; 
					}
					$code.='<br/><br/>
					<a type="button" onclick="date_ordre()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Ordre de remplacement</a>&nbsp;
					<script>
					function date_ordre() {
					    var date = prompt("A quelle date souhaites-tu émettre le document ?","");
					    var num = prompt("Merci d\'indiquer les N° de contracts ainsi que les Compagnies dans lesquels ces contract ont été souscrits","");
					    if (date != null && num != null) {
					        window.open("pdf/ordreRemp.php?idClient='.$client['CLT-NumID'].'&date="+date+"&num="+num);
					    }
					}
					</script>
					<label>Ordre de remplacement&nbsp;&nbsp;</label>';
					if($client['CLT-MandatCourtage'] == 1){
						$code.='<input type="checkbox" name="ordreRemp" checked>';
					} else {
						$code.='<input type="checkbox" name="ordreRemp">'; 
					}
					$code.='
					</div>
				</div>       
			</div>

			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Valider Modifications</button>
			</form>

	</div>';
	return($code);
}

//Affichage de l'onglet Professionnel
function AfficheFicheClientProfessionnel($client,$categories,$professions,$status){
	$code='<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "pro"){
		$code.=' active';
	}
	$code.='" id="pro">
	<form method="post" action="index.php?action=modifClientPro">
	<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>

	<div class="col-lg-6">
		 <div class="panel panel-info">
            <div class="panel-heading">
              <h4 class="panel-title"><b>Contact Professionnel</b></h4>
            </div>
            <div class="panel-body">
            	<label>Raison Sociale : </label>
            	<input type="text" name="raisonPro" style="width:250px;" value="'.$client['CLT-RaisonSocialePro'].'"/><br/><br/>
				<label>Adresse : </label>
				<input type="text" name="adressePro" style="width:400px;" value="'.$client['CLT-AdressePro'].'"/><br/><br/>
				<label>Code Postal : </label>
				<input type="text" name="codePostalPro" style="width:75px;" value="'.$client['CLT-CodePostalPro'].'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>Ville : </label>
				<input type="text" name="villePro" style="width:200px;" value="'.$client['CLT-VillePro'].'"/><br/><br/>
				<label>Tel Pro : </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="text" name="telPro" style="width:100px;" value="'.$client['CLT-TelPro'].'"/><br/><br/>
				<label>Fax Pro : </label>
				<input type="text" name="faxPro" style="width:100px;" value="'.$client['CLT-FaxPro'].'"/><br/><br/>
				<label>Adresse Mail Pro : </label>
				<input type="text" name="mailPro" style="width:300px;" value="'.$client['CLT-MailPro'].'"/><br/><br/>
				<label>Service : </label>
				<input type="text" name="servicePro" style="width:150px;" value="'.$client['CLT-ServicePro'].'"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label>TelPort : </label>
				<input type="text" name="telPortPro" style="width:150px;" value="'.$client['CLT-TelPortPro'].'"/><br/><br/>
			</div>
		</div>
	</div>

	<div class="col-lg-6">
		 <div class="panel panel-info">
            <div class="panel-heading">
              <h4 class="panel-title"><b>Informations Professionnelles</b></h4>
            </div>
            <div class="panel-body">
            	<label>Catégorie : </label>
            	<select name="categorie" style="width:250px;"><option selected="selected"></option>';
				foreach ($categories as $categorie) {
					$code.="<option value='".$categorie['CAT-NumID']."'>".$categorie['CAT-Nom']."</option>";
				}
				$code.='</select><br/><br/>
				<label>Profession : </label>
				<select name="profession" style="width:400px;">';
				if($client['CLT-Profession'] == null){
					$code.="<option selected='selected'></option>";
				}
				foreach ($professions as $profession) {
					if($profession['PRO-NumID'] == $client['CLT-Profession']){
						$code.="<option selected='selected' value='".$profession['PRO-NumID']."'>".$profession['PRO-Nom']."</option>";
					} else {
						$code.="<option value='".$profession['PRO-NumID']."'>".$profession['PRO-Nom']."</option>";
					}
				}
				$code.='</select><br/><br/>
				<label>Promotion : </label>
				<input type="text" name="promotion" style="width:150px;" value="'.$client['CLT-Promotion'].'"/><br/><br/>
				<label>Statut : </label>
				<select name="statut" style="width:300px;">';
				foreach ($status as $statut) {
					if($statut['SPR-NumID'] == $client['CLT-Statut']){
						$code.="<option selected='selected' value='".$statut['SPR-NumID']."'>".$statut['SPR-Nom']."</option>";
					} else {
						$code.="<option value='".$statut['SPR-NumID']."'>".$statut['SPR-Nom']."</option>";
					}
				}
				$code.='</select><br/><br/>
				<label>Mois Cloture de bilan : </label>
				<input type="text" name="mois" style="width:30px;" value="'.$client['CLT-CBC'].'"/><br/><br/>
				<label>Option IS&nbsp;&nbsp;</label>';
				if($client['CLT-OptionIS'] == 1){
					$code.='<input type="checkbox" name="optionIS" checked>';
				} else {
					$code.='<input type="checkbox" name="optionIS">'; 
				}
				$code.='
				<br/><br/>
				<a type="button" onclick="date()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Mandat Pro Administratif</a>&nbsp;
				<script>
				function date() {
				    var x;
				    var date = prompt("A quelle date souhaites-tu l\'émettre ?","");
				    if (date != null) {
				        window.open("pdf/mandatPro.php?idClient='.$client['CLT-NumID'].'&date="+date);
				    }
				}
				</script>
				<a type="button" onclick="date_place()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Mandat Placement</a>&nbsp;
				<script>
				function date_place() {
				    var x;
				    var date = prompt("A quelle date souhaites-tu l\'émettre ?","");
				    var risques = prompt("Risques ?","");
				    var siret = prompt("N° de siret de l\'entreprise ?","");
				    var rep = prompt("Représentant de l\'entreprise ?","");
				    if (date != null) {
				        window.open("pdf/mandatPlacementPro.php?idClient='.$client['CLT-NumID'].'&date="+date+"&risques="+risques+"&siret="+siret+"&rep="+rep);
				    }
				}
				</script><br/><br/>
				<a type="button" onclick="date_remp()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Ordre de remplacement</a>&nbsp;
				<script>
				function date_remp() {
				    var x;
				    var date = prompt("A quelle date souhaites-tu l\'émettre ?","");
				    var num = prompt("Merci d\'indiquer les N° de contrats ainsi que les compagniers dans lequels ces contrats ont été souscrits","");
				    var siret = prompt("N° de siret de l\'entreprise ?","");
				    var rep = prompt("Représentant de l\'entreprise ?","");
				    if (date != null) {
				        window.open("pdf/ordreRempPro.php?idClient='.$client['CLT-NumID'].'&date="+date+"&num="+num+"&siret="+siret+"&rep="+rep);
				    }
				}</script>&nbsp;
			</div>
		</div>
	</div>

	<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Valider Modifications</button>
	</form>
	</div>';
	return($code);
}

//Affichage de l'onglet Professionnel
function AfficheFicheClientRevenus($client,$types_revenus,$revenus){
	$code='<div class="tab-pane fade in';
		if(isset($_GET['onglet']) && $_GET['onglet'] == "revenus"){
			$code.=' active';
		}
		$code.='" id="revenus">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-success" id="ajoutRevenu"><i class="fa fa-plus fa-lg"></i> Ajouter un Revenu</button><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label>Type</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label>Année</label>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label>Montant</label><br/>';
		foreach($revenus as $revenu) { 
			$code.='
			<form method="post" action="index.php?action=modifClientRevenu" style="display:inline;">
				<input type="hidden" name="idRevenu" value="'.$revenu['R/C-NumID'].'"/>
				<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				<select name="type" style="width:200px;" required><option></option>';
				foreach ($types_revenus as $type) {
					if($type['REV-NumID'] == $revenu['R/C-TypeRevenus']){
						$code.="<option value='".$type['REV-NumID']."' selected='selected'>".$type['REV-Nom']."</option>";
					} else {
						$code.="<option value='".$type['REV-NumID']."'>".$type['REV-Nom']."</option>";
					}
				}
				$code.='</select>
				<input type="text" name="annee" style="width:100px;" value="'.$revenu['R/C-Année'].'" required/>
				<input type="text" name="montant" style="width:100px;" value="'.$revenu['R/C-Montant'].'"required/>
				<button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-pencil fa-lg"></i> Enregistrer</button>
			
			</form>
			<form method="post" action="index.php?action=deleteClientRevenu" style="display:inline;">
				<input type="hidden" name="idRevenu" value="'.$revenu['R/C-NumID'].'"/>
				<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o fa-lg"></i> Supprimer</button>
			</form><br/>';
		}
		$code.='
		<br/><br/>
		<div id="formRevenu">
		<h4>Ajouter un Revenu</h4>
		<form method="post" action="index.php?action=addClientRevenu">
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
			<select name="type" style="width:200px;" required><option></option>';
			foreach ($types_revenus as $type) {
				$code.="<option value='".$type['REV-NumID']."'>".$type['REV-Nom']."</option>";
			}
			$code.='</select>
			<input type="text" name="annee" style="width:100px;" required/>
			<input type="text" name="montant" style="width:100px;" required/>
			<input type="submit" value="Ajouter"/>
		</form>
		</div>
	</div>';
	return($code);
}

//Affichage de l'onglet Historique
function AfficheFicheClientHistorique($client,$types_historique,$historiques){
	$code='<div class="tab-pane fade in';
		if(isset($_GET['onglet']) && $_GET['onglet'] == "historique"){
			$code.=' active';
		}
		$code.='" id="historique">
		<button class="btn btn-success" id="ajoutHistorique"><i class="fa fa-plus fa-lg"></i> Ajouter un Historique</button><br/><br/>
		<div class="table-responsive">
      	<table class="table">
        <thead>
          <tr>
            <th>Demande</th>
            <th>Type</th>
            <th>Date</th>
            <th><span style="background:#CA6060">Ech. Max</span></th>
            <th></th>
            <th>Commentaire</th>
            <th></th>
            <th><span style="color:#FF8000">Date Cloture</span></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
		<tbody>';
		foreach ($historiques as $historique) {
			$code.='<tr>
			<form method="post" action="index.php?action=modifClientHistorique" style="display:inline;">
			<input type="hidden" name="idHistorique" value="'.$historique['H/C-NumID'].'"/>
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>';
			$code.='<td style="min-width: 100px;">';
			if($historique['H/C-DemandeAssistante'] == 1){
				$code.='<input type="checkbox" name="demAssistante" checked>';
			} else {
				$code.='<input type="checkbox" name="demAssistante">'; 
			}
			$code.=" Assistante<br/>";
			if($historique['H/C-DemandeCourtier'] == 1){
				$code.='<input type="checkbox" name="demCourtier" checked>';
			} else {
				$code.='<input type="checkbox" name="demCourtier">'; 
			}
			$code.=" Courtier";
			$code.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>
			<select name="type" style="width:200px;" required><option></option>';
			foreach ($types_historique as $type) {
				if($type['HIS-NumID'] == $historique['H/C-TypeHistorique']){
					$code.="<option value='".$type['HIS-NumID']."' selected='selected'>".$type['HIS-Nom']."</option>";
				} else {
					$code.="<option value='".$type['HIS-NumID']."'>".$type['HIS-Nom']."</option>";
				}
			}
			$code.='</select></td>
			<td><input type="text" name="date" style="width:100px;" value="';
			if($historique['H/C-Date']!=null){
				$code.=date('d/m/Y',strtotime($historique['H/C-Date']));
			} else {
				$code.="";
			}
			$code.='"/></td>
			<td><input type="text" name="echMax" style="width:100px;" value="';
			if($historique['H/C-DateMax']!=null){
				$code.=date('d/m/Y',strtotime($historique['H/C-DateMax']));
			} else {
				$code.="";
			}
			$code.='"/></td><td style="min-width: 100px;">';
			if($historique['H/C-Tutoriel'] == 1){
				$code.='<input type="checkbox" name="tutoriel" checked>';
			} else {
				$code.='<input type="checkbox" name="tutoriel">'; 
			}
			$code.="<span style='color:#FF8000'> Tutoriel</span><br/>";
			if($historique['H/C-Eléments'] == 1){
				$code.='<input type="checkbox" name="elements" checked>';
			} else {
				$code.='<input type="checkbox" name="elements">'; 
			}
			$code.="<span style='color:#FF8000'> Eléments</span>";
			$code.='</td>
			<td><textarea name="commentaire" rows="2" cols="75">'.$historique['H/C-Commentaire'].'</textarea></td><td>';
			if($historique['H/C-Cloture'] == 1){
				$code.='<input type="checkbox" name="cloture" checked>';
			} else {
				$code.='<input type="checkbox" name="cloture">'; 
			}
			$code.='</td>
			<td><input type="text" name="dateCloture" style="width:100px;" value="';
			if($historique['H/C-DateCloture']!=null){
				$code.=date('d/m/Y',strtotime($historique['H/C-DateCloture']));
			} else {
				$code.="";
			}
			$code.='"/></td>
			<td><button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-pencil fa-lg"></i> Enregistrer</button></form></td>
			<td><form method="post" action="index.php?action=deleteClientHistorique" style="display:inline;">
				<input type="hidden" name="idHistorique" value="'.$historique['H/C-NumID'].'"/>
				<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o fa-lg"></i> Supprimer</button>
			</form></td>
			</tr>';
		}
	$code.=' 
		<tr id="formHistorique">
		<form method="post" action="index.php?action=addClientHistorique" id="formHistorique">
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
			<td style="min-width: 100px;"><input type="checkbox" name="demAssistante"> Assistante<br/>
			<input type="checkbox" name="demCourtier"> Courtier</td> 
			<td><select name="type" style="width:200px;" required><option></option>';
			foreach ($types_historique as $type) {
				$code.="<option value='".$type['HIS-NumID']."'>".$type['HIS-Nom']."</option>";
			}
			$code.='</select></td>
			<td><input type="text" name="date" style="width:100px;"/></td>
			<td><input type="text" name="echMax" style="width:100px;"/></td>
			<td style="min-width: 100px;"><input type="checkbox" name="tutoriel"><span style="color:#FF8000"> Tutoriel</span><br/>
			<input type="checkbox" name="elements"><span style="color:#FF8000"> Eléments</span></td> 
			<td><textarea name="commentaire" rows="2" cols="75"></textarea></td>
			<td><input type="checkbox" name="cloture"></td>
			<td><input type="text" name="dateCloture" style="width:100px;"/></td>
			<td><button type="submit" class="btn btn-success btn-xs"><i class="fa fa-plus fa-lg"></i> Ajouter</button></td>
			<td></td>
		</form>
		</tr>
		</table></tbody>
    </div></div>';
	return($code);
}

//Affichage de l'onglet Relationel
function AfficheFicheClientRelationel($client,$type_relation,$relations,$personnes){
	$code='<a type="button" href="pdf/arboGroupe.php?idClient='.$client['CLT-NumID'].'" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Arborescence Groupe</a>
	<div class="tab-pane fade in';
		if(isset($_GET['onglet']) && $_GET['onglet'] == "relationel"){
			$code.=' active';
		}
		$code.='" id="relationel">
		<button class="btn btn-success" id="ajoutLien" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Lien</button><br/>
		<div class="table-responsive">
      	<table class="table">
        <thead>
          <tr>
            <th>Type</th>
            <th>Personne liée</th>
            <th>Commentaire</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
		<tbody>';
		foreach ($relations as $relation) {
			$code.='<tr>
			<form method="post" action="index.php?action=modifClientRelationel" style="display:inline;">
			<input type="hidden" name="idApp" value="'.$relation['R/P-NumApporteur'].'"/>
			<input type="hidden" name="idReco" value="'.$relation['R/P-NumReco'].'"/>
			<input type="hidden" name="idType" value="'.$relation['R/P-Type'].'"/>
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
			<td><select name="type" style="width:200px;" required><option></option>';
			foreach ($type_relation as $type) {
				if($type['REL-Num'] == $relation['R/P-Type']){
					$code.="<option value='".$type['REL-Num']."' selected='selected'>".$type['REL-Nom']."</option>";
				} else {
					$code.="<option value='".$type['REL-Num']."'>".$type['REL-Nom']."</option>";
				}
			}
			$code.='</select></td>
			<td><select name="pers" style="width:200px;" required><option></option>';
			foreach ($personnes as $pers) {
				if($pers['CLT-NumID'] == $relation['R/P-NumReco']){
					$code.="<option value='".$pers['CLT-NumID']."' selected='selected'>".$pers['CLT-Nom']." ".$pers['CLT-Prénom']."</option>";
				} else {
					$code.="<option value='".$pers['CLT-NumID']."'>".$pers['CLT-Nom']." ".$pers['CLT-Prénom']."</option>";
				}
			}
			$code.='</select></td>
			<td><textarea name="commentaire" rows="1" cols="75">'.$relation['R/P-Commentaire'].'</textarea></td>
			<td><button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-pencil fa-lg"></i> Enregistrer</button></td></form>
			<td>
				<form method="post" action="index.php?action=deleteClientRelationel" style="display:inline;">
					<input type="hidden" name="idApp" value="'.$relation['R/P-NumApporteur'].'"/>
					<input type="hidden" name="idReco" value="'.$relation['R/P-NumReco'].'"/>
					<input type="hidden" name="idType" value="'.$relation['R/P-Type'].'"/>
					<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
					<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o fa-lg"></i> Supprimer</button>
				</form>
			</td>
			</tr>';
		}
		$code.='

		</table></tbody>

		<div id="ajoutLienType">

			<h4 style="display:inline;margin-left:10px;">Lien à créer <span style="color:#A5260A">(Glissez ici les éléments)</span></h4>

	        <div id="fieldChooser" tabIndex="1">
	        	<div id="lienPers">
		            <div id="sourceFields"><h4 style="display:inline;"><span style="color:#A5260A">Personne</span></h4>';
		               foreach ($personnes as $pers) {
							$code.="<div>".$pers['CLT-Nom']." ".$pers['CLT-Prénom']."<input type='hidden' name='pers' value='".$pers['CLT-NumID']."'/></div>";
						}
					$code.='
		            </div>
		        </div>
	            <div id="lienType">
		            <div id="sourceFields"><h4 style="display:inline;"><span style="color:#A5260A">Type</span></h4>';
		               foreach ($type_relation as $type) {
							$code.="<div>".$type['REL-Nom']."<input type='hidden' name='type' value='".$type['REL-Num']."'/></div>";
						}
					$code.='
		            </div>
		        </div>
	            	<div id="lien">
		            	<form method="post" action="index.php?action=addClientRelationel" id="formLien">
			            	<div id="destinationFields">
			            	</div>
				            <input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				        </form>
		            </div>
        	</div>

        </div>
			
    </div></div>';
	return($code);
}

//Affichage de l'onglet Besoin
function AfficheFicheClientBesoin($client,$besoins,$occurences,$besoins_cli){
	$code = "";
	if(isset($_GET['idType']) && !$_SESSION['Auth']['dejaReload']){
		$code.="<script>window.location.reload()</script>";
		Auth::setInfo('dejaReload',true);
	}
	$retraite = false;
	$prev = false;
	$prevPost = false;
	$sante = false;
	$epargne = false;
	$chomage = false;
	$pret = false;
	foreach ($besoins_cli as $besoin_cli){
		if($besoin_cli['B/C-NumType'] == 13){
			$retraite = true;
		}
		if($besoin_cli['B/C-NumType'] == 12){
			$prev = true;
		}
		if($besoin_cli['B/C-NumType'] == 15){
			$prevPost = true;
		}
		if($besoin_cli['B/C-NumType'] == 14){
			$sante = true;
		}
		if($besoin_cli['B/C-NumType'] == 4){
			$epargne = true;
		}
		if($besoin_cli['B/C-NumType'] == 6){
			$chomage = true;
		}
		if($besoin_cli['B/C-NumType'] == 2){
			$pret = true;
		}
	}
	$code.='<div class="tab-pane fade in';
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$code.=' active';
		}
		$code.='" id="besoin">
		<div class="bs-example">
             <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 13){
                	$code.=" class='active'";
                }
                $code.='><a href="#retraite" data-toggle="tab">';
                if($retraite){
                	$code.='<b><span style="font-size:15px;">Retraite</span></b>';
                } else {
                	$code.='Retraite';
                }
                $code.='
                </a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 12){
                	$code.=" class='active'";
                }
                $code.='><a href="#prevoyance" data-toggle="tab">';
                if($prev){
                	$code.='<b><span style="font-size:15px;">Prévoyance</span></b>';
                } else {
                	$code.='Prévoyance';
                }
                $code.='</a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 15){
                	$code.=" class='active'";
                }
                $code.='><a href="#prevoyancePost" data-toggle="tab">';
                if($prevPost){
                	$code.='<b><span style="font-size:15px;">Prévoyance Post-Activité</span></b>';
                } else {
                	$code.='Prévoyance Post-Activité';
                }
                $code.='
                </a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 14){
                	$code.=" class='active'";
                }
                $code.='><a href="#sante" data-toggle="tab">';
                if($sante){
                	$code.='<b><span style="font-size:15px;">Santé</span></b>';
                } else {
                	$code.='Santé';
                }
                $code.='
                </a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 4){
                	$code.=" class='active'";
                }
                $code.='><a href="#epargne" data-toggle="tab">';
                if($epargne){
                	$code.='<b><span style="font-size:15px;">Epargne</span></b>';
                } else {
                	$code.='Epargne';
                }
                $code.='
                </a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 6){
                	$code.=" class='active'";
                }
                $code.='><a href="#chomage" data-toggle="tab">';
                if($chomage){
                	$code.='<b><span style="font-size:15px;">Chômage</span></b>';
                } else {
                	$code.='Chômage';
                }
                $code.='
                </a></li>
                <li';
                if(isset($_GET['idType']) && $_GET['idType'] == 2){
                	$code.=" class='active'";
                }
                $code.='><a href="#pret" data-toggle="tab">';
                if($pret){
                	$code.='<b><span style="font-size:15px;">Prêt</span></b>';
                } else {
                	$code.='Prêt';
                }
                $code.='
                </a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
              	
                <div class="tab-pane fade in';
                if($_GET['idType'] == 13){
                	$code.=" active";
                }
                $code.='" id="retraite">
                	<h4>En Retraite, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin1" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
					<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 13){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin1">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form1">
	                	Besoin : <select id="besoin2" name="idBesoin">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 13){
	                			$code.="<option value='".$besoin['BES-NumID']."/13'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences" name="idOcc">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="13" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 12){
                	$code.=" active";
                }
                $code.='" id="prevoyance">
                	<h4>En Prévoyance, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin2" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                	<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 12){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin2">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form2"/>
	                	Besoin : <select id="besoin3" name="idBesoin2">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 12){
	                			$code.="<option value='".$besoin['BES-NumID']."/12'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences2" name="idOcc2">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="12" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 15){
                	$code.=" active";
                }
                $code.='" id="prevoyancePost">
                	<h4>En Prévoyance Post-Activité, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin3" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                	<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 15){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin3">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form3"/>
	                	Besoin : <select id="besoin4" name="idBesoin3">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 15){
	                			$code.="<option value='".$besoin['BES-NumID']."/15'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences3" name="idOcc3">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="15" />
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 14){
                	$code.=" active";
                }
                $code.='" id="sante">
                	<h4>En Santé, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin4" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                	<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 14){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin4">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form4"/>
	                	Besoin : <select id="besoin5" name="idBesoin4">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 14){
	                			$code.="<option value='".$besoin['BES-NumID']."/14'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences4" name="idOcc4">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="14" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 4){
                	$code.=" active";
                }
                $code.='" id="epargne">
                	<h4>En Epargne, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin5" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                	<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 4){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin5">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form5"/>
	                	Besoin : <select id="besoin6" name="idBesoin5">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 4){
	                			$code.="<option value='".$besoin['BES-NumID']."/4'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences5" name="idOcc5">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="4" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 6){
                	$code.=" active";
                }
                $code.='" id="chomage">
                	<h4>En Chômage, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin6" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                	<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 6){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin6">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form6"/>
	                	Besoin : <select id="besoin7" name="idBesoin6">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 6){
	                			$code.="<option value='".$besoin['BES-NumID']."/6'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences6" name="idOcc6">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="6" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>

                <div class="tab-pane fade in';
                if($_GET['idType'] == 2){
                	$code.=" active";
                }
                $code.='" id="pret">
                <h4>En Prêt, le client souhaite</h4><button class="btn btn-success" id="ajoutBesoin7" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Besoin</button><br/>
                <div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Besoin</th>
				            <th>Occurence</th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
	                	foreach ($besoins_cli as $besoin_cli){
	                		if($besoin_cli['B/C-NumType'] == 2){
	                			$code.="<tr><td>".$besoin_cli['BES-Nom']."</td><td>".$besoin_cli['OCC-Nom']."</td>
	                					<td><form action='index.php?action=deleteClientBesoin' method='post'/>
	                					<input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
	                					<input type='hidden' name='idType' value='".$besoin_cli['B/C-NumType']."'/>
	                					<input type='hidden' name='idBesoin' value='".$besoin_cli['B/C-NumBesoin']."'/>
	                					<input type='hidden' name='idOcc' value='".$besoin_cli['B/C-NumOcc']."'/>
	                					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></td>
	                					</form>
	                				</tr>";
	                		}
	                	}
				        $code.='</table></tbody>
						<br/><br/>
						<div id="formBesoin7">
				        <h4>Ajouter un besoin </h4>
				        <form action="index.php?action=addClientBesoin" method="post" id="form7"/>
	                	Besoin : <select id="besoin8" name="idBesoin7">
	                	<option>Choisir...</option>';
	                	foreach ($besoins as $besoin){
	                		if($besoin['B/T-NumType'] == 2){
	                			$code.="<option value='".$besoin['BES-NumID']."/2'>".$besoin['BES-NOM']."</option>";
	                		}
	                	}
	        			$code.='
			        	</select>
		        		<br/><br/>
		        		Occurence :
		        		<select id="occurences7" name="idOcc7">
		        			
		        		</select><br/><br/>
		        		<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
		                <input type="hidden" name="idType" value="2" />
		        		
		        		</form>
		        		</div>
	        		</div>
                </div>
            </div>
    </div></div>';
	return($code);
}

function AfficheFicheClientSolution($client,$type_produits,$compagnies,$produits){
	$code='<div class="tab-pane fade in';
	if(isset($_GET['onglet']) && $_GET['onglet'] == "solution"){
		$code.=' active';
	}
	$code.='" id="solution">

	<button class="btn btn-success" id="ajoutProduit" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Produit</button>

	<a type="button" onclick="dev_cons()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Devoir de conseil</a>&nbsp;
	<script>
	function dev_cons() {
	    window.open("pdf/devoirConseil.php?idClient='.$client['CLT-NumID'].'");
	}
	</script>&nbsp;&nbsp;&nbsp;&nbsp;

	<a type="button" onclick="rec_cont()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Recapitulatif Contrats</a>&nbsp;
	<script>
	function rec_cont() {
	    window.open("pdf/recapContrat.php?idClient='.$client['CLT-NumID'].'");
	}
	</script>&nbsp;&nbsp;&nbsp;&nbsp;

	<br/><br/>
	<div class="table-responsive">
      	<table class="table">
        <thead>
          <tr>
            <th>Souscripteur</th>
            <th>Compagnie</th>
            <th>Produit</th>
            <th>Situation</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
		<tbody>';
			foreach ($produits as $produit) {
				$code.="<tr>";
				$code.="<td>".$produit['CLT-Nom']." ".$produit['CLT-Prénom']."</td>";
				$code.="<td>".$produit['CIE-Nom']."</td>";
				$code.="<td>".$produit['PDT-Nom']."</td>";
				$code.="<td>".$produit['TSC-Nom']."</td>";
				$code.="<td><form action='index.php?action=ficheClientProduit&idProduit=".$produit['P/C-NumID']."'  target='_blank' method='post'><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-pencil fa-lg'></i> Accéder</button></form></td>";
				$code.="<td><form action='index.php?action=deleteClientProduit' method='post'><input type='hidden' name='idProduit' value='".$produit['P/C-NumID']."'/><input type='hidden' name='idClient' value='".$client['CLT-NumID']."'/>
						<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button></form></td>";
				$code.="</tr>";
			}
		
		$code.='
		</table></tbody>
		<br/>
	</div>

	<div id="formProduitClient">
	<h4>Création Produit Client</h4><br/>

	Type Produit :
	<select name="type" id="typeProduit"><option value="rien">Choisir...</option>';
	foreach ($type_produits as $type){
		$code.="<option value=".$type['TPD-NumID'].">".$type['TPD-Nom']."</option>";
	}
	$code.='
	</select>

	<br/><br/>Compagnie :
	<select name="compagnie" id="compagnie"><option value="rien">Choisir...</option>';
	foreach ($compagnies as $compagnie){
		$code.="<option value=".$compagnie['CIE-NumID'].">".$compagnie['CIE-Nom']."</option>";
	}
	$code.='
	</select><br/><br/>

	Commercialisé : <input type="checkbox" name="commerce" id="isCom" checked><br/><br/>

	<div id="produitListe">

		<div id="fieldChooser" tabIndex="1">
			<form method="post" action="index.php?action=addClientProduit" id="formAddProduit">
			<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
	        <div id="sourceFields" style="float:left;height:150px;width:300px;"></div>
		</div>

		<br/><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span style="color:red;display:inline;">Glissez le produit ici</span>
		<br/>

		<div id="destinationFields" style="float:left;height:60px;width:300px;padding:0;margin-left:50px;border:1px solid green;-moz-border-radius: 10px;-webkit-border-radius: 10px;border-radius: 10px;"></div>

		</form>

	</div>

	</div>

	</div>';
	return($code);
}

function AfficheFicheClientProduit($produit,$personnes,$produits_liste,$situations,$codes,$maitre,$fractionnements,$types_prescripteur,$evenements,$type_evenements,$realisateurs,$apporteurs,$commissions,$anomalies,$type_anomalies){
	$code='
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h4 class="panel-title"><b>Infos produit</b></h4>
			</div>
			<div class="panel-body">
				<form action="index.php?action=modifClientProduit1" method="post">
				<input type="hidden" name="idProduit" value="'.$_GET['idProduit'].'"/>
				<b>Type Prescripteur : </b>
				<select name="typePrescripteur">';
				foreach ($types_prescripteur as $typ) {
					if($typ['PRE-Nom'] == $produit['P/C-Type Prescripteur']){
						$code.='<option value="'.$typ['PRE-Nom'].'" selected>'.$typ['PRE-Nom'].'</option>';
					} else {
						$code.='<option value="'.$typ['PRE-Nom'].'">'.$typ['PRE-Nom'].'</option>';
					}
				}
				$code.='
				</select>
				<br/><br/>
				<b>Concurrent : </b>';
				if($produit['P/C-DossierConcurrent'] == 1){
					$code.='<input name="concur" type="checkbox" checked/><br/>';
				} else {
					$code.='<input name="concur" type="checkbox"/><br/>';
				}
				$code.='
				<br/><b>Souscripteur : </b><select name="souscripteur">';
				foreach ($personnes as $pers) {
					if($pers['CLT-NumID'] == $produit['P/C-NumSouscripteur']){
						$code.='<option value="'.$pers['CLT-NumID'].'" selected>'.$pers['CLT-Nom'].' '.$pers['CLT-Prénom'].'</option>';
					} else {
						$code.='<option value="'.$pers['CLT-NumID'].'">'.$pers['CLT-Nom'].' '.$pers['CLT-Prénom'].'</option>';
					}
				}
				$code.='
				</select>
				<br/><br/>
				<h4 style="display:inline;">Produit : </h4>
				<select name="produit">';
				foreach ($produits_liste as $prod_liste) {
					if($prod_liste['PDT-NumID'] == $produit['P/C-NumProduit']){
						$code.='<option value="'.$prod_liste['PDT-NumID'].'" selected>'.$prod_liste['PDT-Nom'].' - '.$prod_liste['CIE-Nom'].'</option>';
					} else {
						$code.='<option value="'.$prod_liste['PDT-NumID'].'">'.$prod_liste['PDT-Nom'].' - '.$prod_liste['CIE-Nom'].'</option>';
					}
				}
				$code.='
				</select><br/><br/>
				<h4 style="display:inline;">Compagnie : </h4>'.$produit['CIE-Nom'].'<br/><br/>
				<input type="hidden" name="compagnie" value="'.$produit['CIE-NumID'].'" />
				<b>Situation : </b>
				<select name="situation">';
				foreach ($situations as $sit) {
					if($sit['TSC-NumID'] == $produit['P/C-SituationContrat']){
						$code.='<option value="'.$sit['TSC-NumID'].'" selected>'.$sit['TSC-Nom'].'</option>';
					} else {
						$code.='<option value="'.$sit['TSC-NumID'].'" >'.$sit['TSC-Nom'].'</option>';
					}
				}
				$code.='
				</select><br/><br/>
				<b>Code Courtier : </b>
				<select name="codeCourtier">';
				foreach ($codes as $cod) {
					if($cod['COD-Code'] == $produit['P/C-NumCodeSofraco']){
						$code.='<option value="'.$cod['COD-Code'].'" selected>'.$cod['COD-Code'].'</option>';
					} else {
						$code.='<option value="'.$cod['COD-Code'].'">'.$cod['COD-Code'].'</option>';
					}
				}
				$code.='
				</select><br/><br/>
				<b>N° Contrat : </b><input type="text" name="numContrat" value="'.$produit['P/C-NumContrat'].'"></input><br/><br/>
				<b>Contrat Maître : </b>
				<select name="maitre">';
				foreach ($maitre as $mai) {
					if($mai['P/C-NumContratMaitre'] == $produit['P/C-NumContratMaitre']){
						$code.='<option value="'.$mai['P/C-NumContratMaitre'].'" selected>'.$mai['P/C-NumContratMaitre'].'</option>';
					} else {
						$code.='<option value="'.$mai['P/C-NumContratMaitre'].'">'.$mai['P/C-NumContratMaitre'].'</option>';
					}
				}
				$code.='
				</select><br/><br/>
				<b>Option : </b><input type="text"  name="option" value="'.$produit['P/C-Option'].'"></input><br/><br/>
				<b>Fractionnement : </b>
				<select name="frac">';
				foreach ($fractionnements as $frac) {
					if($frac['FRA-NumID'] == $produit['P/C-Fractionnement']){
						$code.='<option  value="'.$frac['FRA-NumID'].'" selected>'.$frac['FRA-Nom'].'</option>';
					} else {
						$code.='<option  value="'.$frac['FRA-NumID'].'">'.$frac['FRA-Nom'].'</option>';
					}
				}
				$code.='
				</select><br/><br/>
				<b>Age Terme : </b><input type="text" name="ageTerme" value="'.$produit['P/C-AgeTermeRetraite'].'"></input><br/><br/>

				<div class="well well-sm">';
					if($produit['P/C-AVie'] == 1){
						$code.='<input name="avie" type="checkbox" checked/>';
					} else {
						$code.='<input name="avie" type="checkbox"/>';
					}
					$code.=' A Vie &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-Mad'] == 1){
						$code.='<input name="mad" type="checkbox" checked/>';
					} else {
						$code.='<input name="mad" type="checkbox"/>';
					}
					$code.=' Art154bis &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-Art62'] == 1){
						$code.='<input name="art62" type="checkbox" checked/>';
					} else {
						$code.='<input name="art62" type="checkbox"/>';
					}
					$code.=' Art62 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-PEP'] == 1){
						$code.='<input name="pep" type="checkbox" checked/>';
					} else {
						$code.='<input name="pep" type="checkbox"/>';
					}
					$code.=' PEP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-PERP'] == 1){
						$code.='<input name="perp"  type="checkbox" checked/>';
					} else {
						$code.='<input name="perp" type="checkbox"/>';
					}
					$code.=' PERP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-Art82'] == 1){
						$code.='<input name="art82" type="checkbox" checked/>';
					} else {
						$code.='<input name="art82" type="checkbox"/>';
					}
					$code.=' Art82 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-Art83'] == 1){
						$code.='<input name="art83" type="checkbox" checked/>';
					} else {
						$code.='<input name="art83" type="checkbox"/>';
					}
					$code.=' Art83 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-Art39'] == 1){
						$code.='<input name="art39" type="checkbox" checked/>';
					} else {
						$code.='<input name="art39" type="checkbox"/>';
					}
					$code.=' Art39 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<div class="well well-sm">';
					if($produit['P/C-ClauseType'] == 1){
						$code.='<input name="clauseType" type="checkbox" checked/>';
					} else {
						$code.='<input name="clauseType" type="checkbox"/>';
					}
					$code.=' Clause Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-ClauseDémembrée'] == 1){
						$code.='<input name="clauseDem" type="checkbox" checked/>';
					} else {
						$code.='<input name="clauseDem" type="checkbox"/>';
					}
					$code.=' Clause Démembrée &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-ClauseNominative'] == 1){
						$code.='<input name="clauseNom" type="checkbox" checked/>';
					} else {
						$code.='<input name="clauseNom" type="checkbox"/>';
					}
					$code.=' Clause Nominative &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

					if($produit['P/C-ClauseAcceptée'] == 1){
						$code.='<input name="clauseAcc" type="checkbox" checked/>';
					} else {
						$code.='<input name="clauseAcc" type="checkbox"/>';
					}
					$code.=' Clause Acceptée &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>

				<b>Commentaire : </b><textarea name="commentaire" rows="1" cols="75">'.$produit['P/C-Commentaire'].'</textarea>

				<button type="submit" class="btn btn-success" style="float:right;"><i class="fa fa-save"></i> Valider Modifications</button>

				</form>
			</div>
		</div>
	</div>
	
	<div class="col-lg-12">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h4 class="panel-title"><b>Différentes phases de mise en place des mes dossiers</b></h4>
			</div>
			<div class="panel-body" style="font-size:11px;">';
				foreach ($evenements as $ev) {
					$code.="<div style='background-color:#FDE9E0;margin:5px;padding:5px;border:1px solid #685E43;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;'>";
					$code.="<form action='index.php?action=modifEvProduit' method='post' style='display:inline;'><select name='typeEv'>";
					foreach($type_evenements as $typ){
						if($typ['EVE-NumID'] == $ev['E/P-NumEvenement']){
							$code.="<option value='".$typ['EVE-NumID']."' selected>".$typ['EVE-Nom']."</option>";
						} else {
							$code.="<option value='".$typ['EVE-NumID']."'>".$typ['EVE-Nom']."</option>";
						}
					}
					$code.="</select>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date signature <input style='width:80px;' type='text' name='dateSignature' value='";
							if($ev['E/P-DateSignature']!=null){$code.=date('d/m/Y',strtotime($ev['E/P-DateSignature']));}
							$code.="'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Apporteur <select name='apporteur'><option></option>";
					foreach($apporteurs as $app){
						if($app['APP-NumID'] == $ev['E/P-Apporteur']){
							$code.="<option value='".$app['APP-NumID']."' selected>".$app['APP-Nom']." ".$app['APP-Prénom']."</option>";
						} else {
							$code.="<option value='".$app['APP-NumID']."'>".$app['APP-Nom']." ".$app['APP-Prénom']."</option>";
						}
					}
					$code.="</select>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Realisateur <select name='realisateur'><option></option>";
					foreach($realisateurs as $res){
						if($res['CON-NumID'] == $ev['E/P-Réalisateur']){
							$code.="<option value='".$res['CON-NumID']."' selected>".$res['CON-Nom']." ".$res['CON-Prénom']."</option>";
						} else {
							$code.="<option value='".$res['CON-NumID']."'>".$res['CON-Nom']." ".$res['CON-Prénom']."</option>";
						}
					}
					$code.="</select>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Envoyé ";
					if($ev['E/P-DossierEnvoyéClt'] == 1){
						$code.='<input name="env" type="checkbox" checked/>';
					} else {
						$code.='<input name="env" type="checkbox"/>';
					}

					$code.="<br/>Prime Pério <input style='width:80px;' type='text' name='primePério' value='".$ev['E/P-MontantPP']."'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prime Unique <input style='width:80px;' type='text' name='primeUnique' value='".$ev['E/P-MontantPU']."'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Effet <input style='width:80px;' type='text' name='dateEffet' value='";
							if($ev['E/P-DateEffet']!=null){$code.=date('d/m/Y',strtotime($ev['E/P-DateEffet']));}
							$code.="'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date Envoi Cie <input style='width:80px;' type='text' name='dateEnvoi' value='";
							if($ev['E/P-DateEnvoi']!=null){$code.=date('d/m/Y',strtotime($ev['E/P-DateEnvoi']));}
							$code.="'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Médical ? ";
					if($ev['E/P-AcceptMedicale'] == 1){
						$code.='<input name="medicale" type="checkbox" checked/>';
					} else {
						$code.='<input name="medicale" type="checkbox"/>';
					}

					$code.="<br/>Date Retour <input style='width:80px;' type='text' name='dateRetour' value='";
							if($ev['E/P-DateRetour']!=null){$code.=date('d/m/Y',strtotime($ev['E/P-DateRetour']));}
							$code.="'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Remise<input style='width:80px;' type='text' name='dateRemise' value='";
							if($ev['E/P-DateRemise']!=null){$code.=date('d/m/Y',strtotime($ev['E/P-DateRemise']));}
							$code.="'/>";

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Formalisé ";
					if($ev['E/P-ObligationConseils'] == 1){
						$code.='<input name="formalise" type="checkbox" checked/>';
					} else {
						$code.='<input name="formalise" type="checkbox"/>';
					}

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Scoring ";
					if($ev['E/P-Scoring'] == 1){
						$code.='<input name="scoring" type="checkbox" checked/>';
					} else {
						$code.='<input name="scoring" type="checkbox"/>';
					}

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tracfin ";
					if($ev['E/P-Tracfin'] == 1){
						$code.='<input name="tracfin" type="checkbox" checked/>';
					} else {
						$code.='<input name="tracfin" type="checkbox"/>';
					}

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Complet ";
					if($ev['E/P-DossierComplet'] == 1){
						$code.='<input name="complet" type="checkbox" checked/>';
					} else {
						$code.='<input name="complet" type="checkbox"/>';
					}

					$code.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Classé Jamais Formalisé ";
					if($ev['E/P-ClasséJamaisFormalisé'] == 1){
						$code.='<input name="pdc" type="checkbox" checked/>';
					} else {
						$code.='<input name="pdc" type="checkbox"/>';
					}

					$code.="<br/><br/>
					<b>Commentaire : </b><input style='width:500px;' type='text' name='commentaire' value='".$ev['E/P-Commentaire']."'/><br/><br/>
					<b>Frais négociés</b>&nbsp;&nbsp;&nbsp;&nbsp;
					Entrée &nbsp;<input style='width:30px;' type='text' name='fraisEnt' value='".$ev['E/P-FraisEntNégo']."'/>%&nbsp;&nbsp;&nbsp;
					Gestion &nbsp;<input style='width:30px;' type='text' name='gestionEnt' value='".$ev['E/P-GestEntNégo']."'/>%&nbsp;&nbsp;&nbsp;
					Transfert &nbsp;<input style='width:30px;' type='text' name='transEnt' value='".$ev['E/P-TransEntNégo']."'/>%&nbsp;&nbsp;&nbsp;
					Fond € &nbsp;<input style='width:30px;' type='text' name='tauxInvtEuro' value='".$ev['E/P-TauxInvtEuro']."'/>%&nbsp;&nbsp;&nbsp;
					Fond UC &nbsp;<input style='width:30px;' type='text' name='tauxInvtUC' value='".$ev['E/P-TauxInvtUC']."'/>%&nbsp;&nbsp;&nbsp;
					Autre UC &nbsp;<input style='width:30px;' type='text' name='tauxInvtUCAutre' value='".$ev['E/P-TauxInvtUCAutres']."'/>%&nbsp;&nbsp;&nbsp;
					<br/><br/>
					<b>Choix commission</b>&nbsp;&nbsp;&nbsp;
					<select name='commission'><option></option>";
					foreach($commissions as $com){
						if($com['C/P-NumID'] == $ev['E/P-NumCom']){
							$code.="<option value='".$com['C/P-NumID']."' selected>".$com['C/P-ProtocoleNom']." - ".$com['C/P-ProtocoleAnnée']." - ".$com['C/P-DétailExplicatif']." - Escompte : ".$com['C/P-ComEsc']." - Linéaire : ".$com['C/P-ComLin']."</option>";
						} else {
							$code.="<option value='".$com['C/P-NumID']."'>".$com['C/P-ProtocoleNom']." - ".$com['C/P-ProtocoleAnnée']." - ".$com['C/P-DétailExplicatif']." - Escompte : ".$com['C/P-ComEsc']." - Linéaire : ".$com['C/P-ComLin']."</option>";
						}
					}
					$code.="</select>
					<br/><br/>
						<input type='hidden' name='idProduit' value='".$produit['P/C-NumID']."'/>
						<input type='hidden' name='idEv' value='".$ev['E/P-NumID']."'/>
						<button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Modifer</button>
					</form>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<form action='index.php?action=deleteEvProduit' method='post' style='display:inline;'>
						<input type='hidden' name='idProduit' value='".$produit['P/C-NumID']."'/>
						<input type='hidden' name='idEv' value='".$ev['E/P-NumID']."'/>
						<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Supprimer</button>
					</form>
					</div>";
				} 

				$code.="
				<form method='post' action='index.php?action=addEvProduit'>
					<input type='hidden' name='idProduit' value='".$produit['P/C-NumID']."'/>
					<input type='hidden' name='idRealisateur' value='".Auth::getInfo('id')."'/>
					<button style='float:right;' type='submit' class='btn btn-success'><i class='fa fa-plus'></i> Ajouter Evenement</button>
				</form>
				";

				$code.='
			</div>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4 class="panel-title"><b>Historique des anomalies éventuelles</b></h4>
			</div>
				<div class="panel-body">
					<div class="table-responsive">
				      	<table class="table">
				        <thead>
				          <tr>
				            <th>Type anomalie</th>
				            <th>Date</th>
				            <th>Cloture</th>
				            <th>Date Cloture</th>
				            <th>Commentaire</th>
				            <th></th>
				            <th></th>
				          </tr>
				        </thead>
						<tbody>';
						foreach ($anomalies as $ann) {
							$code.='<tr><td><form action="index.php?action=modifAnomalieProduit" method="post">
									<input type="hidden" name="idProduit" value="'.$produit['P/C-NumID'].'"/>
									<input type="hidden" name="idAnomalie" value="'.$ann['A/P-NumID'].'"/><select name="type">';
							foreach ($type_anomalies as $typ) {
								if($typ['HIA-NumID'] == $ann['A/P-NumAnomalie']){
									$code.="<option value='".$typ['HIA-NumID']."' selected>".$typ['HIA-Nom']."</option>";
								} else {
									$code.="<option value='".$typ['HIA-NumID']."'>".$typ['HIA-Nom']."</option>";
								}
							}
							$code.="</select></td>
							<td><input type='text' name='date' style='width:70px;' value='";
							if($ann['A/P-Date']!=null){$code.=date('d/m/Y',strtotime($ann['A/P-Date']));}
							$code.="'/></td><td>";
							if($ann['A/P-Cloture'] == 1){
								$code.='<input name="cloture" type="checkbox" checked/>';
							} else {
								$code.='<input name="cloture" type="checkbox"/>';
							}
							$code.="</td><td><input type='text' style='width:70px;' name='dateCloture' value='";
							if($ann['A/P-DateCloture']!=null){$code.=date('d/m/Y',strtotime($ann['A/P-DateCloture']));}
							$code.="'/></td>
							<td><input style='width:300px;' type='text' name='commentaire' value='".$ann['A/P-Commentaire']."'/></td>
							<td><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Modifer</button></form></td>
							<td><form action='index.php?action=deleteAnomalieProduit' method='post'>
									<input type='hidden' name='idProduit' value='".$produit['P/C-NumID']."'/>
									<input type='hidden' name='idAnomalie' value='".$ann['A/P-NumID']."'/>
									<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Supprimer</button>
								</form>
							</td></tr>
							";
						}
						$code.='
				
						<tr>
							<form action="index.php?action=addAnomalieProduit" method="post">
							<input type="hidden" name="idProduit" value="'.$produit['P/C-NumID'].'"/>
							<td><select name="type" required><option></option>';
							foreach ($type_anomalies as $typ) {
								$code.="<option value='".$typ['HIA-NumID']."'>".$typ['HIA-Nom']."</option>";
							}
							$code.="</select></td>
							<td><input type='text' style='width:70px;' name='date' /></td><td>
							<input name='cloture' type='checkbox'/>
							</td><td><input type='text' style='width:70px;' name='dateCloture' /></td>
							<td><input style='width:300px;' type='text' name='commentaire'/></td>
							<td><button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus'></i> Ajouter</button></td>
							<td></td></tr>
							</form>
						</tr>
						</table></tbody>
					</div>
				</div>
			</div>
		</div>
	</div>
	";
	$menu = '<li><a href="index.php?action=ficheClient&idClient='.$produit['P/C-NumClient'].'&onglet=solution"><i class="fa fa-backward fa-lg"></i><b> Retour Fiche Client</b></a></li>';
	$_SESSION['menu'] = $menu; 
	return($code);
}

//Affichage des procédures
function AfficheProcedure(){
	$code = '
	<div class="col-lg-6">
		<h4>Stéphane Scalabrino</h4>
		<a type="button" onclick="tracfin()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Tracfin</a>
		<script>
		function tracfin() {
		    window.open("pdf/tracfin.php");
		}
		</script>
		<a type="button" onclick="scoring()" target="_blank" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Scoring</a>
		<script>
		function scoring() {
		    window.open("pdf/scoring.php");
		}
		</script>
		<a type="button" onclick="tracfin_an()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Tracfin Anomalies</a>
		<script>
		function tracfin_an() {
		    window.open("pdf/tracfinAnomalie.php");
		}
		</script>
		<a type="button" onclick="scoring_an()" target="_blank" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Scoring Anomalies</a>
		<script>
		function scoring_an() {
		    window.open("pdf/scoringAnomalie.php");
		}
		</script>
		<hr/>

		<h4>Sylvain Maillard</h4>
		<a type="button" onclick="orias()" target="_blank" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Vérif Orias</a>
		<script>
		function orias() {
		    window.open("pdf/traitement.php");
		}
		</script>
		<hr/>

		<h4>Ali Tazi</h4>
		<a type="button" onclick="sinistre()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Sinistres</a>
		<script>
		function sinistre() {
		    window.open("pdf/sinistre.php");
		}
		</script>
		<a type="button" onclick="rh()" target="_blank" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Dossier RH</a>
		<script>
		function rh() {
		    window.open("pdf/traitement.php");
		}
		</script>
		<hr/>
	</div>

	<div class="col-lg-6">
		<h4>Delphine Taton et Carine Scalabrino</h4>
		<a type="button" onclick="traitement()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Traitement Dossier</a>
		<script>
		function traitement() {
		    window.open("pdf/traitement.php");
		}
		</script>
		<a type="button" onclick="incident()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Incident de Gestion</a>
		<script>
		function incident() {
		    window.open("pdf/incident.php");
		}
		</script>
			<a type="button" onclick="incident2()" target="_blank" class="btn btn-primary disabled"><img src="img/pdf.png" class="pdf"/> Incident de Mise en Place</a>
		<script>
		function incident2() {
		    window.open("pdf/incident2.php");
		}
		</script>
		<hr/>

		<h4>Stéphane Saulnier</h4>
		<a type="button" onclick="confident()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Confidentalité et Secret Professionel</a>
		<script>
		function confident() {
		    window.open("pdf/confident.php");
		}
		</script>
		<a type="button" onclick="respect()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Respect du Secret Médical</a>
		<script>
		function respect() {
		    window.open("pdf/respect.php");
		}
		</script>
		<hr/>

		<h4>Alain Gazoni</h4>
		<a type="button" onclick="reclamation()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> Réclamations</a>
		<script>
		function reclamation() {
		    window.open("pdf/reclamation.php");
		}
		</script>
		<a type="button" onclick="cnil()" target="_blank" class="btn btn-primary"><img src="img/pdf.png" class="pdf"/> CNIL</a>
		<script>
		function cnil() {
		    window.open("pdf/cnil.php");
		}
		</script>
	</div>
	';
	return($code);
}

//Affichage des compagnies
function AfficheCompagnie($compagnies){
	$code="<span style='font-size:20px;'><b><u>Liste Compagnies</u></b></span><br/><br/>
	<form style='display:inline;' action='index.php?action=compagnie' method='post'>
	<input type='text' class='form-control' style='display:inline;width:200px;' name='recherche'/>
	<span class='input-group-btn' style='display:inline;'>
	<button class='btn btn-default' type='submit' style='display:inline;'><i class='fa fa-search'></i></button>
	</span>
	</form>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button class='btn btn-default' style='display:inline;' onclick=\"window.location.reload()\"><i class='fa fa-refresh'></i> Actualiser</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='anom()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Anomalies Codes</a>
	<script>
	function anom() {
	    window.open(\"pdf/anomalieCode.php\");
	}
	</script>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='code1()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Mes Codes</a>
	<script>
	function code1() {
	    window.open(\"pdf/codes.php?idUser=".$_SESSION['Auth']['id']."\");
	}
	</script>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='code2()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Tous les Codes</a>
	<script>
	function code2() {
		alert('Veuillez patienter durant la génération du document...');
	    window.open(\"pdf/codes.php?all=all\");
	}
	</script>
	";
	$code.= "<hr/><div class='col-lg-12'><div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th>ACP</th>
	<th>Compagnie <i class='fa fa-sort'></i></th>
	<th>Adresse <i class='fa fa-sort'></i></th>
	<th>CP <i class='fa fa-sort'></i></th>
	<th>Ville <i class='fa fa-sort'></i></th>
	<th>Accueil Tel</th>
	<th>Fax</th>
	<th>Site Internet</th>
	<th>Tarif Internet</th>
	</tr>
	</thead>
	<tbody>";
	foreach($compagnies as $comp){
		$code.='<tr onclick="window.open(\'index.php?action=ficheCompagnie&idComp='.$comp['CIE-NumID'].'&onglet=general\');" class="rowClient" target="_blank">';
		$code.="
			<td>";
			if($comp['CIE-ACP'] == 1){
				$code.="<img width=15 height=15 src='img/check.jpg'/>";
			}
		$code.="
			</td>
			<td><b>".$comp['CIE-Nom']."</b></td>
			<td>".$comp['CIE-Adresse']."</td>
			<td>".$comp['CIE-CodePostal']."</td>
			<td>".$comp['CIE-Ville']."</td>
			<td style='width:100px;'>".$comp['CIE-AccueilTel']."</td>
			<td style='width:100px;'>".$comp['CIE-Fax']."</td>
			<td>".$comp['CIE-SiteInternet']."</td>
			<td>".$comp['CIE-TarifInternet']."</td>
		";
		$code.="</tr>";
	}
	$code .= "</tbody></table></div></div>";
	return($code);
}

//Affichage de la fiche compagnie
function AfficheFicheCompagnie($compagnie,$contacts,$departements,$contactsLoc,$codes,$courtiers,$compagnies,$codeMaitre){
	$code='<div class="panel-body">
	<div class="tab-content">';

	//Onglet Génréral
	if($_GET['onglet'] == "general"){
		$code.=AfficheFicheCompagnieGeneral($compagnie);
	} 
	//Onglet Annuaire National
	if($_GET['onglet'] == "contact"){
		$code.=AfficheFicheCompagnieContact($contacts,$compagnie[0]['CIE-NumID']);
	} 
	//Onglet Contact Locaux
	if($_GET['onglet'] == "contactLoc"){
		$code.=AfficheFicheCompagnieContactLocaux($compagnie[0]['CIE-NumID'],$departements,$contactsLoc);
	} 
	//Onglet Codes
	if($_GET['onglet'] == "code"){
		$code.=AfficheFicheCompagnieCode($compagnie[0]['CIE-NumID'],$codes,$courtiers,$compagnies,$codeMaitre);
	} 

	$code.='</div></div>';

	//Menu du côté
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "general"){
		$menu = '<li class="active"><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
	} else {
		$menu = '<li><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=general"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "contact"){
		$menu.= '<li class="active"><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=contact"><i class="fa fa-list-alt fa-lg"></i><b> Annuaire National</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=contact"><i class="fa fa-list-alt fa-lg"></i><b> Annuaire National</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "contactLoc"){
		$menu.= '<li class="active"><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=contactLoc"><i class="fa fa fa-users fa-lg"></i><b> Contact Locaux</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=contactLoc"><i class="fa fa fa-users fa-lg"></i><b> Contact Locaux</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "code"){
		$menu.= '<li class="active"><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=code"><i class="fa fa-lock fa-lg"></i><b> Codes</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=ficheCompagnie&idComp='.$compagnie[0]['CIE-NumID'].'&onglet=code"><i class="fa fa-lock fa-lg"></i><b> Codes</b></a></li>';
	}

	$_SESSION['menu'] = $menu; 

	return($code);
}

//Affichage de la fiche compagnie - onglet Général
function AfficheFicheCompagnieGeneral($compagnie){
	$code='<span style="font-size:20px;"><b><u>Informations Générales</u></b></span><br/><br/>
	<form action="index.php?action=modifCompagnieGeneral" method="post">
	<input type="hidden" name="idComp" value="'.$compagnie[0]['CIE-NumID'].'"/> 
		<div class="col-lg-4">
			<div class="form-group">
				<label>Adresse : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="adresse" value="'.$compagnie[0]['CIE-Adresse'].'"/> 
			</div>

			<div class="form-group">
				<label>Code Postal : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="codePostal" value="'.$compagnie[0]['CIE-CodePostal'].'"/> 
			</div>

			<div class="form-group">
				<label>Ville : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="ville" value="'.$compagnie[0]['CIE-Ville'].'"/> 
			</div>

			<div class="form-group">
				<label>Accueil Tel : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="tel" value="'.$compagnie[0]['CIE-AccueilTel'].'"/> 
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label>Fax : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="fax" value="'.$compagnie[0]['CIE-Fax'].'"/> 
			</div>

			<div class="form-group">
				<label>Commentaire : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="com" value="'.$compagnie[0]['CIE-Commentaire'].'"/> 
			</div>

			<div class="form-group">
				<label>Site Internet : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="site" value="'.$compagnie[0]['CIE-SiteInternet'].'"/> 
			</div>

			<div class="form-group">
				<label>Tarif Internet : </label><br/>
				<input type="text" class="form-control" style="width:275px;" name="tarif" value="'.$compagnie[0]['CIE-TarifInternet'].'"/> 
			</div>
		</div>

		<div class="col-lg-4">
			<div class="form-group">
				<label>ACP : </label><br/>';
				if($compagnie[0]['CIE-ACP'] == 1){
					$code.='<input type="checkbox" name="acp" checked/>';
				} else {
					$code.='<input type="checkbox" name="acp"/>';
				}
			$code.='
			</div>
		</div>

		<div class="col-lg-12">
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Valider Modifications</button>
		</div>
	</form>
	';
	return($code);
}

//Affichage de la fiche compagnie - onglet Contacts
function AfficheFicheCompagnieContact($contacts,$idComp){
	$code="
	<button class='btn btn-success' id='ajoutContact' style='float:right;'><i class='fa fa-plus fa-lg'></i> Ajouter un Contact</button>
	<span style='font-size:20px;'><b><u>Annuaire National</u></b></span><br/><br/>
	<a type='button' onclick='impr()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Imprimer</a>
	<script>
	function impr() {
	    window.open(\"pdf/contactCompagnie.php?idComp=".$idComp."\");
	}
	</script>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='site()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Liste sites</a>
	<script>
	function site() {
	    window.open(\"pdf/site.php\");
	}
	</script>
	<br/><br/>
	<div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th>Nom/Service</th>
	<th>Prénom</th>
	<th>Tel Bureau</i></th>
	<th>Mail</th>
	<th>Tel Portable</th>
	<th>Fax</th>
	<th>Fonction</th>
	<th>Horaires Ouverture</th>
	<th>Commentaire</th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<tbody>";
	foreach($contacts as $cont){
		$code.='<tr><form action="index.php?action=modifCompagnieContact" method="post">
			    <input type="hidden" name="idComp" value="'.$cont['C/C-Num'].'"/> 
			    <input type="hidden" name="idNom" value="'.$cont['C/C-Nom'].'"/>
			    <input type="hidden" name="idPrenom" value="'.$cont['C/C-Prénom'].'"/>
		';
		$code.="
			<td><input style='width:200px;' type='text' name='nom' value='".$cont['C/C-Nom']."' required/></td>
			<td><input type='text' name='prenom' value='".$cont['C/C-Prénom']."' required/></td>
			<td><input style='width:100px;' type='text' name='tel' value='".$cont['C/C-TelBureau']."'/></td>
			<td><input style='width:210px;' type='text' name='mail' value='".$cont['C/C-Mail']."'/></td>
			<td><input style='width:100px;' type='text' name='port' value='".$cont['C/C-TelPortable']."'/></td>
			<td><input style='width:100px;' type='text' name='fax' value='".$cont['C/C-Fax']."'/></td>
			<td><input type='text' name='fonction' value='".$cont['C/C-Fonction']."'/></td>
			<td><input style='width:100px;' type='text' name='horaire' value='".$cont['C/C-HorairesOuverture']."'/></td>
			<td><input style='width:150px;' type='text' name='com' value='".$cont['C/C-Commentaire']."'/></td>
			<td><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Enregistrer</button></form></td>
			<td>
				<form action='index.php?action=deleteCompagnieContact' method='post'>
					<input type='hidden' name='idComp' value='".$cont['C/C-Num']."'/>
					<input type='hidden' name='idNom' value='".$cont['C/C-Nom']."'/>
					<input type='hidden' name='idPrenom' value='".$cont['C/C-Prénom']."'/>
					<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i> Supprimer</button>
				</form>
			</td>						
		";
		$code.="</form></tr>";
	}
	$code.="
	<tr id='formContact'>
	<td><form action='index.php?action=addCompagnieContact' method='post'><input style='width:200px;' type='text' name='nom' required/></td>
	<td><input type='text' name='prenom' required/></td>
	<td><input style='width:100px;' type='text' name='tel'/></td>
	<td><input style='width:210px;' type='text' name='mail'/></td>
	<td><input style='width:100px; 'type='text' name='port'/></td>
	<td><input style='width:100px; 'type='text' name='fax'/></td>
	<td><input type='text' name='fonction'/></td>
	<td><input style='width:100px;' type='text' name='horaire'/></td>
	<td><input style='width:150;' type='text' name='com'/></td>
	<td><input type='hidden' name='idComp' value='".$idComp."'/><button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus fa-lg'></i> Ajouter</button></form></td>
	<td></td>
	</tr>
	";
	$code .= "</tbody></table></div>";
	return($code);
}

//Affichage de la fiche compagnie - onglet Contacts Locaux
function AfficheFicheCompagnieContactLocaux($idComp,$departements,$contactsLoc){
	$code="
	<button class='btn btn-success' id='ajoutContactLoc' style='float:right;'><i class='fa fa-plus fa-lg'></i> Ajouter un Contact</button>
	<span style='font-size:20px;'><b><u>Contacts Locaux</u></b></span><br/><br/>
	<form method='post' action='index.php?action=ficheCompagnie&idComp=".$idComp."&onglet=contactLoc'>
		<b>Choisir un Département : </b><select name='dep' required><option></option>";
		foreach ($departements as $dep){
			if( (!empty($_POST['dep']) && $_POST['dep'] == $dep['DPT-Num']) || (!empty($_GET['dep']) && $_GET['dep'] == $dep['DPT-Num']) ){
				$code.="<option value='".$dep['DPT-Num']."' selected>".$dep['DPT-Nom']." (".$dep['DPT-Num'].")</option>";
			} else {
				$code.="<option value='".$dep['DPT-Num']."'>".$dep['DPT-Nom']." (".$dep['DPT-Num'].")</option>";
			}
		}
		$code.="
		</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class='btn btn-default' type='submit' style='display:inline;'><i class='fa fa-search'></i> Filtrer</button>
	</form>
	<br/><br/>
	<div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th>Nom/Service</th>
	<th>Prénom</th>
	<th>Tel Bureau</i></th>
	<th>Mail</th>
	<th>Tel Portable</th>
	<th>Fax</th>
	<th>Fonction</th>
	<th>Commentaire</th>
	<th>Département rattachés</th>
	<th>Délégation Régionale</th>
	<th></th>
	</tr>
	</thead>
	<tbody>";
	if(!empty($_GET['dep'])){
		 $_POST['dep'] = $_GET['dep'];
	}
	foreach($contactsLoc as $cont){
		if(!empty($_POST['dep']) && $cont['R/I-NumDptRattachement'] == $_POST['dep']){
			$code.='<tr><form action="index.php?action=modifCompagnieContactLoc" method="post">
				    <input type="hidden" name="idIns" value="'.$cont['INS-NumID'].'"/> 
				    <input type="hidden" name="idComp" value="'.$idComp.'"/>
				    <input type="hidden" name="idDep" value="'.$_POST['dep'].'"/>
			';
			$code.="
				<td><b><input type='text' name='nom' value='".$cont['INS-Nom']."' required/></b></td>
				<td><input type='text' name='prenom' value='".$cont['INS-Prénom']."' required/></td>
				<td><input type='text' name='tel' value='".$cont['INS-TelBureau']."'/></td>
				<td><input type='text' name='mail' value='".$cont['INS-Mail']."'/></td>
				<td><input type='text' name='port' value='".$cont['INS-TelPortable']."'/></td>
				<td><input type='text' name='fax' value='".$cont['INS-Fax']."'/></td>
				<td><input type='text' name='fonction' value='".$cont['INS-Fonction']."'/></td>
				<td><input type='text' name='com' value='".$cont['INS-Commentaire']."'/></td>
				<td><center><button type='button' onClick=\"window.open('depRatach.php?idIns=".$cont['INS-NumID']."','Départements rattachés','toolbar=no,status=no,width=500,height=500,scrollbars=yes,location=no,resize=yes,menubar=no')\" class='btn btn-default btn-xs'><i class='fa fa-external-link'></i></button></center></td>
				<td><center><button type='button' onClick=\"window.open('delegRegional.php?idIns=".$cont['INS-NumID']."','Délégation Régionale','toolbar=no,status=no,width=1800,height=500,scrollbars=yes,location=no,resize=no,menubar=no')\" class='btn btn-default btn-xs'><i class='fa fa-external-link'></i></button></center></td>
				<td><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Enregistrer</button></form></td>				
			";
			$code.="</form></tr>";
		}
	}
	if(!empty($_POST['dep'])){
		$code.="
		<tr id='formContactLoc'>
		<td><form action='index.php?action=addCompagnieContactLoc' method='post'><input type='text' name='nom' required/></td>
		<td><input type='text' name='prenom' required/></td>
		<td><input type='text' name='tel'/></td>
		<td><input type='text' name='mail'/></td>
		<td><input type='text' name='port'/></td>
		<td><input type='text' name='fax'/></td>
		<td><input type='text' name='fonction'/></td>
		<td><input type='text' name='com'/></td>
		<td><input type='hidden' name='idComp' value='".$idComp."'/>
			<input type='hidden' name='idDep' value='".$_POST['dep']."'/>
			<button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus fa-lg'></i> Ajouter</button></form>
		</td>
		<td></td>
		<td></td>
		</tr>
		";
	}
	$code .= "</tbody></table></div>";
	return($code);
}

//Affichage de la fiche compagnie - onglet Contacts Locaux
function AfficheFicheCompagnieCode($idComp,$codes,$courtiers,$compagnies,$codeMaitre){
	$code="
	<button class='btn btn-success' id='ajoutCode' style='float:right;'><i class='fa fa-plus fa-lg'></i> Ajouter un Code</button>
	<span style='font-size:20px;'><b><u>Codes</u></b></span><br/><br/>
	<a type='button' onclick='liste()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Liste des codes</a>
	<script>
	function liste() {
	    window.open(\"pdf/codes.php?idComp=".$idComp."\");
	}
	</script>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='anom()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Anomalies Codes (".Auth::getInfo('page').")</a>
	<script>
	function anom() {
	    window.open(\"pdf/anomalieCode.php?idComp=".$idComp."\");
	}
	</script>
	<br/><br/>
	<div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th></th>
	<th>Courtier</th>
	<th>Compagnie</i></th>
	<th>Code Courtier</th>
	<th>Source du Code</th>
	<th>Code Maître</th>
	<th>Identifiant</th>
	<th>MDP</th>
	<th>MDP Dirigeant</th>
	<th>Détail</th>
	<th>Transféré</th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<tbody style='font-size:11px;'>";
	foreach($codes as $c){
	if($c['CON-Couleur'] == null){
		$couleur = "#CCCCCC";
	} else {
		$couleur = $c['CON-Couleur'];
	}
	$code.='
		<tr><form action="index.php?action=modifCompagnieCode" method="post">
	    <input type="hidden" name="idCode" value="'.$c['COD-NumID'].'"/> 
	    <input type="hidden" name="idComp" value="'.$idComp.'"/>
	';
	$code.="
		<td><b><button type='button' class='btn btn-primary btn-xs' style='background-color:".$couleur.";border-color:black;width:20px;height:15px;'></button></td>";
		$code.="<td><select style='width:100px;' name='courtier' required>";
		foreach ($courtiers as $courtier) {
			if($courtier['CON-NumID'] == $c['CON-NumID']){
				$code.="<option value='".$courtier['CON-NumID']."' selected>".$courtier['CON-Nom']." ".$courtier['CON-Prénom']."</b></option>";
			} else {
				$code.="<option value='".$courtier['CON-NumID']."'>".$courtier['CON-Nom']." ".$courtier['CON-Prénom']."</b></option>";
			}
		}
		$code.="</select></td><td><select name='compagnie'/ required>";
		foreach ($compagnies as $comp) {
			if($comp['CIE-NumID'] == $c['CIE-NumID']){
				$code.="<option value='".$comp['CIE-NumID']."' selected>".$comp['CIE-Nom']."</b></option>";
			} else {
				$code.="<option value='".$comp['CIE-NumID']."'>".$comp['CIE-Nom']."</b></option>";
			}
		}
		$code.="</td>
		<td><input style='width:50px;' type='text' name='code' value='".$c['COD-Code']."' required/></td>
		<td><select name='typeCode'>";
		if($c['COD-TypeCode'] == "Code"){
			$code.="<option selected>Code</option>";
		} else {
			$code.="<option>Code</option>";
		}
		if($c['COD-TypeCode'] == "Sous Code"){
			$code.="<option selected>Sous Code</option>";
		} else {
			$code.="<option>Sous Code</option>";						
		}
		$code.="</select>";
		$code.="
		<select name='nomCodeMere' required>";
		$tab = array("SPA","AGAPS","SOFRACO","Direct","Services","Inutilisé","Direct mutualisé");
		foreach ($tab as $t) {
			$code.=$c['COD-NomCodeMere']." == ".$t;
			if($c['COD-NomCodeMere'] == $t){
			$code.="<option selected>".$t."</option>";
			} else {
				$code.="<option>".$t."</option>";						
			}
		}
		$code.="</select></td><td><select name='maitre'><option></option>";
		foreach ($codeMaitre as $cm) {
			if($c['COD-CodeMere'] == $cm['COD-Code'] && $c['COD-CodeMere'] != ''){
				$code.="<option value='".$cm['COD-Code']."' selected>".$cm['COD-Code']." | ".$cm['COD-TypeCode']." | ".$cm['COD-NomCodeMere']." | ".$cm['CIE-Nom']."</option>";
			} else {
				$code.="<option value='".$cm['COD-Code']."'>".$cm['COD-Code']." | ".$cm['COD-TypeCode']." | ".$cm['COD-NomCodeMere']." | ".$cm['CIE-Nom']."</option>";
			}
		}
		$code.="</select></td>
		<td style='color:red;'><input style='width:100px;' type='text' name='identifiant' value='".$c['COD-Identifiant']."' required/></td>
		<td style='color:red;'><input style='width:100px;'type='text' name='mdp' value='".$c['COD-MP']."' required/></td>
		<td><input type='text' name='mdpDir' style='width:100px;' value='".$c['COD-MPDir']."'/></td>
		<td><input type='text' name='detail' value='".$c['COD-Détail']."'/></td><td>";
		if($c['COD-Transféré'] == 1){
			$code.="<input type='checkbox' name='transfert' checked/>";
		} else {
			$code.="<input type='checkbox' name='transfert'/>";
		}
		$code.="
		</td>
		<td><button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Enregistrer</button></form></td>
		<td><form action='index.php?action=deleteCompagnieCode' method='post'>
				<input type='hidden' name='idCode' value='".$c['COD-NumID']."'/>
				<input type='hidden' name='idComp' value='".$idComp."'/>
				<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-trash-o fa-lg'></i> Supprimer</button>
			</form>
		</td>				
	";
	$code.="</form></tr>";
	}
	$code.="
		<tr id='formCode'><td><form action='index.php?action=addCompagnieCode' method='post'><input type='hidden' name='idComp' value='".$idComp."'/></td>";
		$code.="<td><select style='width:100px;' name='courtier' required><option></option>";
		foreach ($courtiers as $courtier) {
				$code.="<option value='".$courtier['CON-NumID']."'>".$courtier['CON-Nom']." ".$courtier['CON-Prénom']."</b></option>";
		}
		$code.="</select></td><td><select name='compagnie' required/><option></option>";
		foreach ($compagnies as $comp) {
			$code.="<option value='".$comp['CIE-NumID']."'>".$comp['CIE-Nom']."</b></option>";
		}
		$code.="</td>
		<td><input style='width:50px;' type='text' name='code' required/></td>
		<td><select name='typeCode'><option></option><option>Code</option><option>Sous Code</option></select>
		<select name='nomCodeMere' required>";
		$tab = array("SPA","AGAPS","SOFRACO","Direct","Services","Inutilisé","Direct mutualisé");
		$code.="<option></option>";
		foreach ($tab as $t) {
			$code.="<option>".$t."</option>";						
		}
		$code.="</select></td><td><select name='maitre'><option></option>";
		foreach ($codeMaitre as $cm) {
			$code.="<option value='".$cm['COD-Code']."'>".$cm['COD-Code']." | ".$cm['COD-TypeCode']." | ".$cm['COD-NomCodeMere']." | ".$cm['CIE-Nom']."</option>";
		}
		$code.="</select></td>
		<td style='color:red;'><input style='width:100px;' type='text' name='identifiant' required/></td>
		<td style='color:red;'><input style='width:100px;' type='text' name='mdp' required/></td>
		<td><input type='text' name='mdpDir' style='width:100px;'/></td>
		<td><input type='text' name='detail'/></td><td>
		<input type='checkbox' name='transfert'/>
		</td>
		<td><button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus fa-lg'></i> Ajouter</button></form></td>
		</tr>
	";
	$code .= "</tbody></table></div>";
	return($code);
}

//Affichage des partenaires
function AffichePartenaire($accords,$partenaires,$types,$conseillers,$partenaires2){
	$code='<div class="panel-body">
	<div class="tab-content">';

	//Onglet Accords
	if($_GET['onglet'] == "accord"){
		$code.=AffichePartenaireAccord($accords,$partenaires,$types,$conseillers);
	}
	//Onglet Fiche Partenaire
	if($_GET['onglet'] == "fiche"){
		$code.=AffichePartenaireFiche($partenaires2);
	}
	//Onglet Activité Partenaires
	if($_GET['onglet'] == "activite"){
		$code.=AffichePartenaireActivite();
	}
	//Onglet Listes (PDF)
	if($_GET['onglet'] == "liste"){
		$code.=AffichePartenaireListe();
	}

	//Menu du côté
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "accord"){
		$menu= '<li class="active"><a href="index.php?action=partenaire&onglet=accord"><i class="fa fa-random fa-lg"></i><b> Affectations Accords</b></a></li>';
	} else {
		$menu= '<li><a href="index.php?action=partenaire&onglet=accord"><i class="fa fa-random fa-lg"></i></i><b> Affectations Accords</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "fiche"){
		$menu.= '<li class="active"><a href="index.php?action=partenaire&onglet=fiche"><i class="fa fa-users fa-lg"></i><b> Fiche Partenaire</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=partenaire&onglet=fiche"><i class="fa fa-users fa-lg"></i><b> Fiche Partenaire</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "activite"){
		$menu.= '<li class="active"><a href="index.php?action=partenaire&onglet=activite"><i class="fa fa-briefcase fa-lg"></i><b> Activité Partenaires</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=partenaire&onglet=activite"><i class="fa fa-briefcase fa-lg"></i><b> Activité Partenaires</b></a></li>';
	}
	if(isset($_GET['onglet'])  && $_GET['onglet'] == "liste"){
		$menu.= '<li class="active"><a href="index.php?action=partenaire&onglet=liste"><i class="fa fa-file-text-o fa-lg"></i><b> Listes (PDF)</b></a></li>';
	} else {
		$menu.= '<li><a href="index.php?action=partenaire&onglet=liste"><i class="fa fa-file-text-o fa-lg"></i><b> Listes (PDF)</b></a></li>';
	}

	$code.='</div></div>';

	$_SESSION['menu'] = $menu; 

	return($code);
}

//Affichage des accords partenaires
function AffichePartenaireAccord($accords,$partenaires,$types,$conseillers){
	$code="
	<button class='btn btn-success' id='ajoutAccord' style='float:right;'><i class='fa fa-plus fa-lg'></i> Ajouter un Accord</button>
	<span style='font-size:20px;'><b><u>Affectations Accords Partenaires</u></b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='accord()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Imprimer</a>
	<script>
	function accord() {
	    window.open(\"pdf/accord.php\");
	}
	</script><br/></br>
	<div class='table-responsive' style='width:800px;'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th>Partenaire</th>
	<th>Type</i></th>
	<th>Conseiller</th>
	<th></th>
	<th></th>
	</tr>
	</thead>
	<tbody>";
	foreach ($accords as $acc) {
		$code.="<tr><form action='index.php?action=modifAccord' method='post'>
		<td style='width:300px;'><select name='partenaire'>";
		foreach ($partenaires as $part) {
			if($acc['ACC-NumPartenaire'] == $part['CLT-NumID']){
				$code.="<option value='".$part['CLT-NumID']."' selected>".$part['CLT-Nom']." ".$part['CLT-NomJeuneFille']." ".$part['CLT-Prénom']."</option>";
			} else {
				$code.="<option value='".$part['CLT-NumID']."'>".$part['CLT-Nom']." ".$part['CLT-NomJeuneFille']." ".$part['CLT-Prénom']."</option>";					
			}
		}
		$code.="</select></td>

		<td style='width:50px;'><select name='type'>";
		foreach($types as $typ) {
			if($acc['ACC-NumType'] == $typ['R/A-NumID']){
				$code.="<option value='".$typ['R/A-NumID']."' selected>".$typ['R/A-Type']."</option>";
			} else {
				$code.="<option value='".$typ['R/A-NumID']."'>".$typ['R/A-Type']."</option>";					
			}
		}
		$code.="</select></td>

		<td style='width:150px;'><select name='conseiller'>";
		foreach($conseillers as $con) {
			if($acc['ACC-NumConseiller'] == $con['CON-NumID']){
				$code.="<option value='".$con['CON-NumID']."' selected>".$con['CON-Nom']." ".$con['CON-Prénom']."</option>";
			} else {
				$code.="<option value='".$con['CON-NumID']."'>".$con['CON-Nom']." ".$con['CON-Prénom']."</option>";					
			}
		}
		$code.="</select></td>";

		$code.="
		<td style='width:100px;'>
			<input type='hidden' value='".$acc['ACC-NumID']."' name='idAcc'/>
			<button type='submit' class='btn btn-warning btn-xs'><i class='fa fa-save'></i> Enregistrer</button>
			</form>
		</td>
		<td><form action='index.php?action=deleteAccord' method='post'>
				<input type='hidden' value='".$acc['ACC-NumID']."' name='idAcc'/>
				<button type='submit' class='btn btn-danger btn-xs'><i class='fa fa-save'></i> Supprimer</button>
			</form>
		</td>
		</tr>";
	}
	$code.="
	<tr id='formAccord'>
	<form action='index.php?action=addAccord' method='post'>
	<td style='width:300px;'><select name='partenaire' required><option></option>";
		foreach ($partenaires as $part) {
			$code.="<option value='".$part['CLT-NumID']."'>".$part['CLT-Nom']." ".$part['CLT-NomJeuneFille']." ".$part['CLT-Prénom']."</option>";					
		}
		$code.="</select></td>

		<td style='width:50px;'><select name='type' required><option></option>";
		foreach($types as $typ) {
			$code.="<option value='".$typ['R/A-NumID']."'>".$typ['R/A-Type']."</option>";					
		}
		$code.="</select></td>

		<td style='width:150px;'><select name='conseiller' required><option></option>";
		foreach($conseillers as $con) {
			$code.="<option value='".$con['CON-NumID']."'>".$con['CON-Nom']." ".$con['CON-Prénom']."</option>";					
		}
		$code.="</select>
		<td><button type='submit' class='btn btn-success btn-xs'><i class='fa fa-plus fa-lg'></i> Ajouter</button></form></td>
		</td><td></td>
	</form></tr>";
	$code .= "</tbody></table></div>";
	return($code);
}

//Affichage des fiches partenaires
function AffichePartenaireFiche($partenaires){
	$code="<span style='font-size:20px;'><b><u>Liste Partenaires</u></b></span><br/><br/>
	<form style='display:inline;' action='index.php?action=partenaire&onglet=fiche' method='post'>
	<input type='text' class='form-control' style='display:inline;width:200px;' name='recherche'/>
	<span class='input-group-btn' style='display:inline;'>
	<button class='btn btn-default' type='submit' style='display:inline;'><i class='fa fa-search'></i></button>
	</span>
	</form>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<button class='btn btn-default' style='display:inline;' onclick=\"window.location.reload()\"><i class='fa fa-refresh'></i> Actualiser</button>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='promo()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Promotions</a>
	<script>
	function promo() {
	    window.open(\"pdf/promo.php\");
	}
	</script>
	";
	$code.= "<hr/><div class='col-lg-12'><div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th></th>
	<th>Civilité <i class='fa fa-sort'></i></th>
	<th>Société <i class='fa fa-sort'></i></th>
	<th>Nom Client <i class='fa fa-sort'></i></th>
	<th>Type <i class='fa fa-sort'></i></th>
	<th>Profession <i class='fa fa-sort'></i></th>
	<th>Promo <i class='fa fa-sort'></i></th>
	</tr>
	</thead>
	<tbody>";
	foreach ($partenaires as $part) {
		if($part['CON-Couleur'] == null){
			$couleur = "#CCCCCC";
		} else {
			$couleur = $part['CON-Couleur'];
		}
		$code.='<tr onclick="window.open(\'index.php?action=ficheClient&idClient='.$part['CLT-NumID'].'&onglet=general\');" class="rowClient" target="_blank">
		<td><button type="button" class="btn btn-primary btn-xs" style="background-color:'.$couleur.';border-color:black;width:20px;height:15px;"></button></td>
		<td>'.$part['CIV-Nom'].'</td>
		<td>';
		if($part['SPR-PersonneMorale'] == 1){$code.=$part['SPR-Nom'];}
		$code.="</td>
		<td><b>".$part['CLT-Nom']." ".$part['CLT-Prénom']."</b></td>
		<td><i>".$part['TYP-Nom']." de ".$part['CON-Prénom']." ".$part['CON-Nom']."</i></td>
		<td>".$part['PRO-Nom']."</td>
		<td>".$part['CLT-Promotion']."</td>
		</tr>
		";
	}
	$code .= "</tbody></table></div></div>";
	return($code);
}

//Affichage des activité partenaires
function AffichePartenaireActivite(){
	$code="<span style='font-size:20px;'><b><u>Activités Partenaires</u></b></span><br/><br/>
	<form action='pdf/activite.php' method='post' target='_blanck'>
		<div class='form-group'>
			<label for='date1'>Date de début : </label><br/>
			<input type='date' class='form-control' name='date1' style='width:275px;' required/>
		</div>
		<div class='form-group'>
			<label for='date2'>Date de fin : </label><br/>
			<input type='date' class='form-control' name='date2' style='width:275px;' required/>
		</div>
		<input type='submit' value='Analyse'/>
	</form>
	";
	return($code);
}

//Affichage des pdf
function AffichePartenaireListe(){
	$code="<span style='font-size:20px;'><b><u>Documents PDF</u></b></span><br/><br/>
	<a type='button' onclick='liste1()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Liste des clients par Groupe/Cabinet</a>
	<script>
	function liste1() {
	    window.open(\"pdf/liste1.php\");
	}
	</script>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='liste2()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Liste des Clients sans Expert Comptable</a>
	<script>
	function liste2() {
	    window.open(\"pdf/liste2.php\");
	}
	</script>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a type='button' onclick='liste3()' target='_blank' class='btn btn-primary'><img src='img/pdf.png' class='pdf'/> Liste des Clients Experts</a>
	<script>
	function liste3() {
	    window.open(\"pdf/liste3.php\");
	}
	</script>
	";
	return($code);
}

?>