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
	$code.= "<h3>Autorisations d'accès associés</h3><br/>";
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
	$code= "<form style='display:inline;' action='index.php?action=ajouterClient' method='post'/><button type='submit' class='btn btn-success'><i class='fa fa-plus'></i> Création Client</button></form>";
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
	</span>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class='btn btn-default' onclick=\"$('#myModal').modal('show')\"><i class='fa fa-refresh'></i> Actualiser</button>
	</form>
	";
	$code.= "<hr/><div class='col-lg-12'><div class='table-responsive'>
	<table class='table table-hover tablesorter'>
	<thead>
	<tr>
	<th style='width:90px;'>Etat <i class='fa fa-sort'></i></th>
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
				$code.= '<tr onclick="window.open(\'index.php?action=ficheClient&idClient='.$cli['CLT-NumID'].'\');" class="rowClient" target="_blank">';
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
				$code.="<img src='img/".$smileyMax.".png' style='width:20px;height:20px;'> ".$diffMax." mois";
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
	<h4>Création d\'un Client</h4>
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
	<h4>'.$client["CLT-Nom"].' '.$client["CLT-Prénom"].'</h4>
	<form style="display:inline;" action="index.php?action=courrierClient" method="post"/><button type="submit" class="btn btn-default"><i class="fa fa-envelope"></i> Courrier</button></form>
	<form style="display:inline;" action="index.php?action=arboClient" method="post"/><button type="submit" class="btn btn-default"><i class="fa fa-print"></i> Arborescence Groupe</button></form>
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
	$code.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h4 style="display:inline;">Etat : <img src=\'img/'.$smileyMax.'.png\' style=\'width:20px;height:20px;;\'>';
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
	$code.=AfficheFicheClientGeneral($client,$types_client,$conseillers,$civilites,$situations,$sensibilites);
	//Onglet Personel
	if($client['CLT-PrsMorale'] == 0){
		$code.=AfficheFicheClientPersonel($client,$types_client,$conseillers,$civilites,$situations,$sensibilites);
	}
	//Onglet Professionel
	$code.=AfficheFicheClientProfessionnel($client,$categories,$professions,$status);
	//Onglet Revenus
	if($client['CLT-PrsMorale'] == 0){
		$code.=AfficheFicheClientRevenus($client,$types_revenus,$revenus);
	}
	//Onglet Historique
	$code.=AfficheFicheClientHistorique($client,$types_historique,$historiques);
	//Onglet Relationel
	$code.=AfficheFicheClientRelationel($client,$types_relation,$relations,$personnes);
	//Onglet Besoin
	$code.=AfficheFicheClientBesoin($client,$besoins,$occurences,$besoins_cli);

	//Onglet Solutions retenues
	$code.=AfficheFicheClientSolution($client,$type_produits,$compagnies,$produits);

	//Le reste à faire
	$code.='
		<div class="tab-pane fade in" id="profil">
		</div>
		<div class="tab-pane fade in" id="tracfin">
		</div>
		<div class="tab-pane fade in" id="liquidite">
		</div>
	</div>
	</div>
	';
	//Menu du côté
	if($client['CLT-PrsMorale'] == 0){
		if(!isset($_GET['onglet'])){
			$menu = '<li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		} else {
			$menu = '<li><a href="#general" data-toggle="tab"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "personel"){
			$menu.='<li class="active"><a href="#personel" data-toggle="tab"><i class="fa fa-user fa-lg"></i><b> Personnel</b></a></li>';
		} else {
			$menu.='<li><a href="#personel" data-toggle="tab"><i class="fa fa-user fa-lg"></i><b> Personnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "pro"){
			$menu.='<li class="active"><a href="#pro" data-toggle="tab"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		} else {
			$menu.='<li><a href="#pro" data-toggle="tab"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "revenus"){
			$menu.='<li class="active"><a href="#revenus" data-toggle="tab"><i class="fa fa-euro fa-lg"></i><b> Revenus</b></a></li>';
		} else {
			$menu.='<li><a href="#revenus" data-toggle="tab"><i class="fa fa-euro fa-lg"></i><b> Revenus</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "historique"){
			$menu.='<li class="active"><a href="#historique" data-toggle="tab"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		} else {
			$menu.='<li><a href="#historique" data-toggle="tab"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "relationel"){
			$menu.='<li class="active"><a href="#relationel" data-toggle="tab"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		} else {
			$menu.='<li><a href="#relationel" data-toggle="tab"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$menu.='<li class="active"><a href="#besoin" data-toggle="tab"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		} else {
			$menu.='<li><a href="#besoin" data-toggle="tab"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "profil"){
			$menu.='<li class="active"><a href="#profil" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		} else {
			$menu.='<li><a href="#profil" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "tracfin"){
			$menu.='<li class="active"><a href="#tracfin" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		} else {
			$menu.='<li><a href="#tracfin" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "solution"){
			$menu.='<li class="active"><a href="#solution" data-toggle="tab"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		} else {
			$menu.='<li><a href="#solution" data-toggle="tab"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "liquidite"){
			$menu.='<li class="active"><a href="#liquidite" data-toggle="tab"><i class="fa fa-euro fa-lg"></i><b> Liquidités financières</b></a></li>';
		} else {
			$menu.='<li><a href="#liquidite" data-toggle="tab"><i class="fa fa-euro fa-lg"></i><b> Liquidités financières</b></a></li>';
		}
	} else {
		if(!isset($_GET['onglet'])){
			$menu = '<li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		} else {
			$menu = '<li><a href="#general" data-toggle="tab"><i class="fa fa-pencil-square-o fa-lg"></i><b> Infos Générales</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "pro"){
			$menu.='<li class="active"><a href="#pro" data-toggle="tab"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		} else {
			$menu.='<li><a href="#pro" data-toggle="tab"><i class="fa fa-suitcase fa-lg"></i><b> Professionnel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "historique"){
			$menu.='<li class="active"><a href="#historique" data-toggle="tab"><i class="fa fa-clock-o fa-lg"><b> Historique</b></a></li>';
		} else {
			$menu.='<li><a href="#historique" data-toggle="tab"><i class="fa fa-clock-o fa-lg"></i><b> Historique</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "relationel"){
			$menu.='<li class="active"><a href="#relationel" data-toggle="tab"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		} else {
			$menu.='<li><a href="#relationel" data-toggle="tab"><i class="fa fa-users fa-lg"></i><b> Relationel</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$menu.='<li class="active"><a href="#besoin" data-toggle="tab"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		} else {
			$menu.='<li><a href="#besoin" data-toggle="tab"><i class="fa fa-money fa-lg"></i><b> Besoins</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "profil"){
			$menu.='<li class="active"><a href="#profil" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		} else {
			$menu.='<li><a href="#profil" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Profil Investisseur</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "tracfin"){
			$menu.='<li class="active"><a href="#tracfin" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		} else {
			$menu.='<li><a href="#tracfin" data-toggle="tab"><i class="fa fa-file fa-lg"></i><b> Procedure TRACFIN</b></a></li>';
		}
		if(isset($_GET['onglet']) && $_GET['onglet'] == "solution"){
			$menu.='<li class="active"><a href="#solution" data-toggle="tab"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
		} else {
			$menu.='<li><a href="#solution" data-toggle="tab"><i class="fa fa-check-square fa-lg"></i><b> Solutions retenues</b></a></li>';
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
	if(!isset($_GET['onglet'])){
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
		              <h3 class="panel-title">Contact Perso</h3>
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
		                <h3 class="panel-title">Particularités Client</h3>
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
					<button type="button" class="btn btn-default">Eléments préparatoires</button>&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>
					<button type="button" class="btn btn-default">Mandat Administratif</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Mandat Administratif&nbsp;&nbsp;</label>';
					if($client['CLT-MandatGestion'] == 1){
						$code.='<input type="checkbox" name="mandatGestion" checked>';
					} else {
						$code.='<input type="checkbox" name="mandatGestion">'; 
					}
					$code.='<br/><br/>
					<button type="button" class="btn btn-default">Infos Pré-contractuelles</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Info-Précontractuelles&nbsp;&nbsp;</label>';
					if($client['CLT-InfoPreContrat'] == 1){
						$code.='<input type="checkbox" name="infoPre" checked>';
					} else {
						$code.='<input type="checkbox" name="infoPre">'; 
					}
					$code.='<br/><br/>
					<button type="button" class="btn btn-default">Mandat Placement</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Mandat Placement Exclusif&nbsp;&nbsp;</label>';
					if($client['CLT-MandatCourtage'] == 1){
						$code.='<input type="checkbox" name="mandatCourtage" checked>';
					} else {
						$code.='<input type="checkbox" name="mandatCourtage">'; 
					}
					$code.='<br/><br/>
					<button type="button" class="btn btn-default">Lettre de Mission</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<label>Lettre de Mission&nbsp;&nbsp;</label>';
					if($client['CLT-LettreMission'] == 1){
						$code.='<input type="checkbox" name="lettreMission" checked>';
					} else {
						$code.='<input type="checkbox" name="lettreMission">'; 
					}
					$code.='<br/><br/>
					<button type="button" class="btn btn-default">Ordre de remplacement</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
              <h3 class="panel-title">Contact Professionnel</h3>
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
              <h3 class="panel-title">Informations Professionnelles</h3>
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
				<button type="button" class="btn btn-default">Mandat Pro Administratif</button>&nbsp;
				<button type="button" class="btn btn-default">Mandat Placement</button><br/><br/>
				<button type="button" class="btn btn-default">Ordre de remplacement</button>&nbsp;
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
				<input type="submit" value="Modifier"/>
			</form>
			<form method="post" action="index.php?action=deleteClientRevenu" style="display:inline;">
				<input type="hidden" name="idRevenu" value="'.$revenu['R/C-NumID'].'"/>
				<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				<input type="submit" value="Supprimer"/>
			</form><br/>';
		}
		$code.='
		<br/><br/>
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
			<td><input type="submit" value="Modifier"/></form></td>
			<td><form method="post" action="index.php?action=deleteClientHistorique" style="display:inline;">
				<input type="hidden" name="idHistorique" value="'.$historique['H/C-NumID'].'"/>
				<input type="hidden" name="idClient" value="'.$client['CLT-NumID'].'"/>
				<input type="submit" value="Supprimer"/>
			</form></td>
			</tr>';
		}
	$code.=' 
      	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      	<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
		<form method="post" action="index.php?action=addClientHistorique">
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
			<td><input type="submit" value="Ajouter"/></td>
			<td></td>
		</form>
		</table></tbody>
    </div></div>';
	return($code);
}

//Affichage de l'onglet Relationel
function AfficheFicheClientRelationel($client,$type_relation,$relations,$personnes){
	$code='<div class="tab-pane fade in';
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
			<td><button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-pencil fa-lg"></i> Modifier</button></td></form>
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
      	<tr><td></td><td></td><td></td><td></td><td></td></tr>
      	<tr><td></td><td></td><td></td><td></td><td></td></tr>
      	<tr><td></td><td></td><td></td><td></td><td></td></tr>

		</table></tbody>

		<div id="ajoutLienType">

			<h5 style="display:inline;margin-left:10px;">Lien à créer <span style="color:#A5260A">(Glissez ici les éléments)</span></h5>

	        <div id="fieldChooser" tabIndex="1">
	        	<div id="lienPers">
		            <div id="sourceFields"><h3 style="display:inline;"><span style="color:#A5260A">Personne</span></h3>';
		               foreach ($personnes as $pers) {
							$code.="<div>".$pers['CLT-Nom']." ".$pers['CLT-Prénom']."<input type='hidden' name='pers' value='".$pers['CLT-NumID']."'/></div>";
						}
					$code.='
		            </div>
		        </div>
	            <div id="lienType">
		            <div id="sourceFields"><h3 style="display:inline;"><span style="color:#A5260A">Type</span></h3>';
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
	$code='<div class="tab-pane fade in';
		if(isset($_GET['onglet']) && $_GET['onglet'] == "besoin"){
			$code.=' active';
		}
		$code.='" id="besoin">
		<div class="bs-example">
             <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                <li class="active"><a href="#retraite" data-toggle="tab">Retraite</a></li>
                <li><a href="#prevoyance" data-toggle="tab">Prévoyance</a></li>
                <li><a href="#prevoyancePost" data-toggle="tab">Prévoyance Post-Activité</a></li>
                <li><a href="#sante" data-toggle="tab">Santé</a></li>
                <li><a href="#epargne" data-toggle="tab">Epargne</a></li>
                <li><a href="#chomage" data-toggle="tab">Chômage</a></li>
                <li><a href="#pret" data-toggle="tab">Prêt</a></li>
              </ul>
              <div id="myTabContent" class="tab-content">
              	
                <div class="tab-pane fade active in" id="retraite">
                	<h5>En Retraite, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
	        		</div>
                </div>

                <div class="tab-pane fade in" id="prevoyance">
                	<h5>En Prévoyance, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
	        		</div>
                </div>

                <div class="tab-pane fadein" id="prevoyancePost">
                	<h5>En Prévoyance Post-Activité, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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

                <div class="tab-pane fade in" id="sante">
                	<h5>En Santé, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
	        		</div>
                </div>

                <div class="tab-pane fade in" id="epargne">
                	<h5>En Epargne, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
	        		</div>
                </div>

                <div class="tab-pane fade in" id="chomage">
                	<h5>En Chômage, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
	        		</div>
                </div>

                <div class="tab-pane fade in" id="pret">
                <h5>En Prêt, le client souhaite</h5>
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
				        <h3>Ajouter un besoin </h3>
				        <form action="index.php?action=addClientBesoin" method="post"/>
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
		        		<button class="btn btn-success" type=="submit"><i class="fa fa-plus fa-lg"></i> Ajouter</button>
		        		</form>
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
	<button class="btn btn-success" id="ajoutProduit" style="float:right;"><i class="fa fa-plus fa-lg"></i> Ajouter un Produit</button><br/>
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
	<h3>Création Produit Client</h3><br/>

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
	        <div id="sourceFields" style="float:left;height:150px;width:300px;">
	        	
	        </div>
		</div>

		<br/><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span style="color:red;display:inline;">Glissez le produit ici</span>
		<br/>
		<div id="formProduitClient">
		<div id="destinationFields" style="float:left;height:60px;width:300px;padding:0;margin-left:50px;border:1px solid green;-moz-border-radius: 10px;-webkit-border-radius: 10px;border-radius: 10px;">
		</div>
		</div>
		</form>
	</div>
	</div>

	</div>';
	return($code);
}

function AfficheFicheClientProduit($produit,$personnes,$produits_liste,$situations,$codes,$maitre,$fractionnements,$types_prescripteur){
	$code='
	<div class="col-lg-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Infos produit</h3>
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
	<div class="col-lg-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">Historique des anomalies éventuelles</h3>
			</div>
			<div class="panel-body">
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<button type="submit" class="btn btn-success" style="float:right;"><i class="fa fa-save"></i> Valider Modifications</button>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Différentes phases de mise en place des mes dossiers</h3>
			</div>
			<div class="panel-body">
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<button type="submit" class="btn btn-success" style="float:right;"><i class="fa fa-save"></i> Valider Modifications</button>
			</div>
		</div>
	</div>
	';

	return($code);
}
?>