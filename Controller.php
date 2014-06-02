<?php
/*
Classe qui gère les actions, et se charge d'aller récupérer l'affichage correspondant
avec les requêtes nécéssaires
*/

include_once "BDD.php";
include_once "Afficheur.php";

class Controller{

	//Construteur
	//Chaque action dispose de sa fonction (ex : index.php?action=logout => LogoutAction())
	public function __construct() {
		$this->tab = array(
			'logout' => 'LogoutAction',
			'droits'=>'DroitsAction',
			'selectPort' => 'SelectPortefeuilleAction',
			'backAgence' => 'BackAgenceAction',
			'client' => 'ClientAction',
			'ajouterClient' => 'AjoutClientAction',
			'addClientPhysique' => 'AddClientPhysiqueAction',
			'addClientMorale' => 'AddClientMoraleAction',
			'ficheClient' => 'FicheClientAction',
			'modifClientGeneral' => 'ModifClientGeneralAction',
			'supClient' => 'SupressionClientAction',
			'modifClientPersonnel' => 'ModifClientPersonnelAction',
			'modifClientPro' => 'modifClientProAction',
			'addClientRevenu' => 'AddClientRevenuAction',
			'modifClientRevenu' => 'ModifClientRevenuAction',
			'deleteClientRevenu' => 'DeleteClientRevenuAction'
			);
	}

	//Analyse l'action demandée
	public function analyse(){
		if(isset($_GET["action"])){
			if(isset($this->tab[$_GET["action"]])){
				$f=$this->tab[$_GET["action"]];
				$this->$f();
			} else {
				AffichePage("Erreur, Adresse incorrecte");
			}
		} else {
			$this->AfficheDefaultAction();
		}
	}

	//Action par défaut
	public function AfficheDefaultAction(){
		AffichePage(AfficheHome());
	}

	//Déconnexion
	public function LogoutAction(){
		AffichePage(include_once "logout.php");
	}
	
	//Droits
	public function DroitsAction(){
		$id = Auth::getInfo('identifiant');
		$query = "SELECT * FROM `statuts administration` sa,`conseillers` c, `statuts fonctions` sf WHERE `CON-Identifiant`='$id' AND c.`CON-NumAdministration`= sa.`ADM-NumID` AND c.`CON-NumFonction`= sf.`FON-NumID`";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->query($query);
		if($res->rowCount() > 0){
			$droits = $res->fetchALL(PDO::FETCH_ASSOC);
			AffichePage(AfficheDroits($droits));
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Seletion portefeuille
	public function SelectPortefeuilleAction(){
		if(isset($_POST["portSelect"])){
			$tab = explode(':',$_POST["portSelect"]);
			Auth::setInfo('portSelect',$tab[0]);
			if(sizeof($tab) == 3){
				Auth::setInfo('nomPortSelect',$tab[1]." ".$tab[2]);
			} else {
				Auth::setInfo('nomPortSelect',$tab[1]);
			}
			Auth::setInfo('modeAgence',0);
			header("Location: index.php");
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Retour en mode agence
	public function BackAgenceAction(){
		Auth::setInfo('portSelect',null);
		Auth::setInfo('nomPortSelect',null);
		Auth::setInfo('modeAgence',1);
		header("Location: index.php");
	}

	//Base client (liste des clients)
	public function ClientAction(){
		$id = Auth::getInfo('portSelect');
		$modeAgence = Auth::getInfo('modeAgence');
		if($modeAgence == 1){
			$query = "SELECT cli.`CLT-Civilité`, cli.`CLT-Conseiller`, cli.`CLT-Type`, cli.`CLT-Statut`, cli.`CLT-Nom`, cli.`CLT-Prénom`, cli.`CLT-NumID`, con.`CON-Couleur`,con.`CON-Nom` ,con.`CON-Prénom`, civ.`CIV-Nom`, sta.`SPR-Nom`, typ.`TYP-Nom`
			FROM `clients et prospects` cli, `conseillers` con, `civilites` civ, `statut professionnel` sta, `type client` typ
			WHERE cli.`CLT-Conseiller` = con.`CON-NumID`
			AND cli.`CLT-Civilité` = civ.`CIV-NumID`
			AND cli.`CLT-Statut` = sta.`SPR-NumID`
			AND cli.`CLT-Type` = typ.`TYP-NumID`";
			//Si il y a un filtre
			if(isset($_POST['filtre'])){
				$query.=" AND typ.`TYP-NumID` = ".$_POST['filtre']."";
			} 
			//Si il y a une recherche
			if(isset($_POST['recherche'])){
				$query.=" AND cli.`CLT-Nom` LIKE '".$_POST['recherche']."%'";
			}
			$query.=" ORDER BY cli.`CLT-Nom`;";

		} else {
			$query = "SELECT cli.`CLT-Civilité`, cli.`CLT-Conseiller`, cli.`CLT-Type`, cli.`CLT-Statut`,cli.`CLT-Nom`, cli.`CLT-Prénom`, cli.`CLT-NumID`, con.`CON-Couleur`,con.`CON-Nom` ,con.`CON-Prénom`, civ.`CIV-Nom`, sta.`SPR-Nom`, typ.`TYP-Nom`
			FROM `clients et prospects` cli,`conseillers` con, `civilites` civ, `statut professionnel` sta, `type client` typ
			WHERE cli.`CLT-Conseiller` = $id 
			AND con.`CON-NumID` = $id 
			AND cli.`CLT-Civilité` = civ.`CIV-NumID`
			AND cli.`CLT-Statut` = sta.`SPR-NumID`
			AND cli.`CLT-Type` = typ.`TYP-NumID`";
			//Si il y a un filtre
			if(isset($_POST['filtre'])){
				$query.=" AND typ.`TYP-NumID` = ".$_POST['filtre']."";
			} 
			//Si il y a une recherche
			if(isset($_POST['recherche'])){
				$query.=" AND cli.`CLT-Nom` LIKE '".$_POST['recherche']."%'";
			}
			$query.=" ORDER BY cli.`CLT-Nom`;";
		}
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->query($query);
		$clients = $res->fetchALL(PDO::FETCH_ASSOC);
		$query_type = "SELECT * FROM `type client`";
		$pdo->exec("SET NAMES UTF8");
		$res_type = $pdo->query($query_type);
		if($res_type->rowCount() > 0){
			$types = $res_type->fetchALL(PDO::FETCH_ASSOC);
		} else {
			AffichePage(AffichePageMessage("Erreur type !"));
		}
		extract($_POST);
		//Si pas de filtre, on affiche les clients
		if(!isset($filtre)){
			$filtre = 1;
		}
		AffichePage(AfficheClient($clients,$types,$filtre));
	}

	//Ajout client
	public function AjoutClientAction(){
		$query = "SELECT sta.*
		FROM `statut professionnel` sta
		WHERE sta.`SPR-PersonneMorale` = 1
		;";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->query($query);
		if($res->rowCount() > 0){
			$formes = $res->fetchALL(PDO::FETCH_ASSOC);
			AffichePage(AfficheClientAjout($formes));
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Ajout d'un client physique
	public function AddClientPhysiqueAction(){
		if(!empty($_POST["nom"]) && !empty($_POST["date"])){
			extract($_POST);
			if($_POST['prenom'] == null){
				$prenom = '';
			}
			$query = "SELECT *
			FROM `clients et prospects` cli
			WHERE cli.`CLT-Nom` = '$nom'
			AND cli.`CLT-DateNaissance` = '$date'
			;";
			$pdo = BDD::getConnection();
			$pdo->exec("SET NAMES UTF8");
			$res = $pdo->query($query);
			if($res->rowCount() == 0){
				$query = "INSERT INTO `clients et prospects` (`CLT-Nom`,`CLT-Prénom`,`CLT-DateNaissance`,`CLT-Type`,`CLT-Conseiller`) VALUES ('$nom','$prenom','$date','5','5');";
				$pdo = BDD::getConnection();
				$pdo->exec("SET NAMES UTF8");
				$res = $pdo->exec($query);
				if($res > 0){
					header("Location: index.php?action=client");
				}
			} else {
				AffichePage(AffichePageMessage("Erreur ! Le client existe déjà."));
			}
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Ajout d'un client moral
	public function AddClientMoraleAction(){
		if(!empty($_POST["forme"]) && !empty($_POST["raison"])){
			extract($_POST);
			$query = "SELECT *
			FROM `clients et prospects` cli
			WHERE cli.`CLT-Nom` = '$raison'
			AND cli.`CLT-Statut` = '$forme'
			;";
			$pdo = BDD::getConnection();
			$pdo->exec("SET NAMES UTF8");
			$res = $pdo->query($query);
			if($res->rowCount() == 0){
				$query = "INSERT INTO `clients et prospects` (`CLT-Nom`,`CLT-Statut`,`CLT-PrsMorale`,`CLT-Type`,`CLT-Conseiller`) VALUES ('$raison','$forme',1,'5','5');";
				$pdo = BDD::getConnection();
				$pdo->exec("SET NAMES UTF8");
				$res = $pdo->exec($query);
				if($res > 0){
					header("Location: index.php?action=client");
				} else {
					AffichePage(AffichePageMessage("Erreur !"));
				}
			} else {
				AffichePage(AffichePageMessage("Erreur ! Le client existe déjà."));
			}
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Fiche client
	public function FicheClientAction(){
		if(!empty($_GET["idClient"])){
			extract($_GET);

			//Requete du client
			$query = "SELECT * FROM `clients et prospects` WHERE `CLT-NumID` = $idClient;";
			$pdo = BDD::getConnection();
			$pdo->exec("SET NAMES UTF8");
			$res = $pdo->query($query);
			$client = $res->fetchALL(PDO::FETCH_ASSOC);

    		//Requete Type Clients
			$query_type = "SELECT * FROM `type client`";
			$pdo->exec("SET NAMES UTF8");
			$res_type = $pdo->query($query_type);
			$types_client = $res_type->fetchALL(PDO::FETCH_ASSOC);

        	//Requete Conseillers
			$query_cons = "SELECT * FROM `conseillers`";
			$pdo->exec("SET NAMES UTF8");
			$res_cons = $pdo->query($query_cons);
			$conseillers = $res_cons->fetchALL(PDO::FETCH_ASSOC);

        	//Requete Civilités
			$query_civ = "SELECT * FROM `civilites`";
			$pdo->exec("SET NAMES UTF8");
			$res_civ = $pdo->query($query_civ);
			$civilites = $res_civ->fetchALL(PDO::FETCH_ASSOC);

			//Requete Situation
			$query_sit = "SELECT * FROM `situation familiale`";
			$pdo->exec("SET NAMES UTF8");
			$res_sit = $pdo->query($query_sit);
			$situations = $res_sit->fetchALL(PDO::FETCH_ASSOC);

			//Requete Sensibilité
			$query_sen = "SELECT * FROM `sensibilite client`";
			$pdo->exec("SET NAMES UTF8");
			$res_sen = $pdo->query($query_sen);
			$sensibilites = $res_sen->fetchALL(PDO::FETCH_ASSOC);

			//Requete Catégories
			$query_cat = "SELECT * FROM `categorie professionnelle`";
			$pdo->exec("SET NAMES UTF8");
			$res_cat = $pdo->query($query_cat);
			$categories = $res_cat->fetchALL(PDO::FETCH_ASSOC);

			//Requete Professions
			$query_pro = "SELECT * FROM `professions`";
			$pdo->exec("SET NAMES UTF8");
			$res_pro = $pdo->query($query_pro);
			$professions = $res_pro->fetchALL(PDO::FETCH_ASSOC);

			//Requete Satut
			$query_sta = "SELECT * FROM `statut professionnel` WHERE `SPR-PersonneMorale` = ".$client[0]['CLT-PrsMorale']."";
			$pdo->exec("SET NAMES UTF8");
			$res_sta = $pdo->query($query_sta);
			$status = $res_sta->fetchALL(PDO::FETCH_ASSOC);

			//Requete Type Revenus
			$query_typ_rev = "SELECT * FROM `type revenus`";
			$pdo->exec("SET NAMES UTF8");
			$res_typ_rev = $pdo->query($query_typ_rev);
			$type_revenus = $res_typ_rev->fetchALL(PDO::FETCH_ASSOC);

			//Requete Revenus Clients
			$query_rev = "SELECT * FROM `revenus par client` WHERE `R/C-NumClient` = ".$client[0]['CLT-NumID']."";
			$pdo->exec("SET NAMES UTF8");
			$res_rev = $pdo->query($query_rev);
			$revenus = $res_rev->fetchALL(PDO::FETCH_ASSOC);


			AffichePage(AfficheFicheClient($client[0],$types_client,$conseillers,$civilites,$situations,$sensibilites,$categories,$professions,$status,$type_revenus,$revenus));
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Modification de l'onglet général d'une fiche client
	public function ModifClientGeneralAction(){
		extract($_POST);
		if(!isset($morale)){
			$morale = 0;
		} else {
			$morale = 1;
		}
		$query = "UPDATE `clients et prospects` SET `CLT-Type`= $type, `CLT-Conseiller`= $cons,`CLT-Civilité` = $civilite, `CLT-Nom` = '$nom', `CLT-Prénom` = '$prenom' ,`CLT-NomJeuneFille`= '$nomJeuneFille', `CLT-PrsMorale` = $morale
				  WHERE `CLT-NumID` = $idClient;
		";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."");
	}

	//Suppression d'un client
	public function SupressionClientAction(){
		if(!empty($_POST["idClient"])){
			extract($_POST);
			$query = "DELETE FROM `clients et prospects` WHERE `CLT-NumID` = $idClient;";
			$pdo = BDD::getConnection();
			$pdo->exec("SET NAMES UTF8");
			$res = $pdo->exec($query);
			if($res > 0){
				header("Location: index.php?action=client");
			} else {
				AffichePage(AffichePageMessage("Erreur !"));
			}
		} else {
			AffichePage(AffichePageMessage("Erreur !"));
		}
	}

	//Modification de l'onglet Personel d'une fiche client
	public function ModifClientPersonnelAction(){
		extract($_POST);
		if(empty($mandatGestion)){
			$mandatGestion = 0;
		} else {
			$mandatGestion = 1;
		}
		if(empty($infoPre)){
			$infoPre = 0;
		} else {
			$infoPre = 1;
		}
		if(empty($mandatCourtage)){
			$mandatCourtage = 0;
		} else {
			$mandatCourtage = 1;
		}
		if(empty($lettreMission)){
			$lettreMission = 0;
		} else {
			$lettreMission = 1;
		}
		if(!empty($dateNaissance)){
			$query = "UPDATE `clients et prospects` SET `CLT-TelPort`='$telPort',`CLT-TelDom`='$telDom',`CLT-MailPerso`='$mailPerso',`CLT-AdresseSkype`='$skype',`CLT-Adresse`='$adresse',`CLT-Code Postal`='$codePostal',
							 `CLT-Ville`='$ville',`CLT-Sensibilite`='$sensibilite',`CLT-Commentaire`='$com',`CLT-DateNaissance`=STR_TO_DATE('$dateNaissance','%d/%m/%Y'),`CLT-SitFam`='$situation',`CLT-NbEnfants`='$nbEnfants',
							 `CLT-Nationalité`='$nationalite',`CLT-MandatGestion`=$mandatGestion,`CLT-InfoPreContrat`=$infoPre,`CLT-MandatCourtage`=$mandatCourtage,`CLT-LettreMission`=$lettreMission
					  WHERE `CLT-NumID` = $idClient;
			";
		} else {
			$query = "UPDATE `clients et prospects` SET `CLT-TelPort`='$telPort',`CLT-TelDom`='$telDom',`CLT-MailPerso`='$mailPerso',`CLT-AdresseSkype`='$skype',`CLT-Adresse`='$adresse',`CLT-Code Postal`='$codePostal',
							 `CLT-Ville`='$ville',`CLT-Sensibilite`='$sensibilite',`CLT-Commentaire`='$com',`CLT-DateNaissance`=null,`CLT-SitFam`='$situation',`CLT-NbEnfants`='$nbEnfants',
							 `CLT-Nationalité`='$nationalite',`CLT-MandatGestion`=$mandatGestion,`CLT-InfoPreContrat`=$infoPre,`CLT-MandatCourtage`=$mandatCourtage,`CLT-LettreMission`=$lettreMission
					  WHERE `CLT-NumID` = $idClient;
			";
		}
		echo $query;
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=personel");
	}

	//Modification de l'onglet professionel d'une fiche client
	public function ModifClientProAction(){
		extract($_POST);
		$query = "UPDATE `clients et prospects` SET 
					`CLT-RaisonSocialePro`='$raisonPro',
					`CLT-AdressePro`='$adressePro',
					`CLT-CodePostalPro`='$codePostalPro',
					`CLT-VillePro`='$villePro',
					`CLT-TelPro`='$telPro',
					`CLT-FaxPro`='$faxPro',
					`CLT-MailPro`='$mailPro',
					`CLT-ServicePro`='$servicePro',
					`CLT-TelPortPro`='$telPortPro',
					`CLT-Profession`='$profession',
					`CLT-Promotion`='$promotion',
					`CLT-Statut`='$statut',
					`CLT-CBC`='$mois',
					`CLT-OptionIS`='$optionIS'
				  WHERE `CLT-NumID` = $idClient;
		";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=pro");
	}

	//Ajout d'un revenu d'un client
	public function AddClientRevenuAction(){
		extract($_POST);
		$query = "INSERT INTO `revenus par client` VALUES (null,'$idClient','$type','$montant','$annee')";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=revenus");
	}

	//Modification d'un revenu d'un client
	public function ModifClientRevenuAction(){
		extract($_POST);
		$query = "UPDATE `revenus par client` SET `R/C-TypeRevenus`=$type,`R/C-Montant`=$montant,`R/C-Année`='$annee' WHERE `R/C-NumID`=$idRevenu";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=revenus");
	}

	//Ajout d'un revenu d'un client
	public function DeleteClientRevenuAction(){
		extract($_POST);
		$query = "DELETE FROM `revenus par client` WHERE `R/C-NumID`=$idRevenu";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=revenus");
	}
}