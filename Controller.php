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
			'deleteClientRevenu' => 'DeleteClientRevenuAction',
			'addClientHistorique' => 'AddClientHistoriqueAction',
			'modifClientHistorique' => 'ModifClientHistoriqueAction',
			'deleteClientHistorique' => 'DeleteClientHistoriqueAction',
			'addClientRelationel' => 'AddClientRelationelAction',
			'modifClientRelationel' => 'ModifClientRelationelAction',
			'deleteClientRelationel' => 'DeleteClientRelationelAction',
			'deleteClientBesoin' => 'DeleteClientBesoinAction',
			'addClientBesoin' => 'AddClientBesoinAction'
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
		Auth::setInfo('page','Accueil');
		AffichePage(AfficheHome());
	}

	//Déconnexion
	public function LogoutAction(){
		AffichePage(include_once "logout.php");
	}
	
	//Droits
	public function DroitsAction(){
		Auth::setInfo('page','Mes droits');
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
		Auth::setInfo('page','Base Clients');
		$id = Auth::getInfo('portSelect');
		$modeAgence = Auth::getInfo('modeAgence');
		if($modeAgence == 1){
			$query = "SELECT pro.`PRO-Nom`, cli.`CLT-Ville`, cli.`CLT-DateNaissance`, cli.`CLT-Sensibilite` ,cli.`CLT-Civilité`, cli.`CLT-Conseiller`, cli.`CLT-Type`, cli.`CLT-Statut`, cli.`CLT-Nom`, cli.`CLT-Prénom`, cli.`CLT-NumID`, con.`CON-Couleur`,con.`CON-Nom` ,con.`CON-Prénom`, civ.`CIV-Nom`, sta.`SPR-Nom`, typ.`TYP-Nom`
			FROM `clients et prospects` cli, `conseillers` con, `civilites` civ, `statut professionnel` sta, `type client` typ, `professions` pro
			WHERE cli.`CLT-Conseiller` = con.`CON-NumID`
			AND cli.`CLT-Civilité` = civ.`CIV-NumID`
			AND cli.`CLT-Statut` = sta.`SPR-NumID`
			AND pro.`PRO-NumID` = cli.`CLT-Profession`
			AND cli.`CLT-Type` = typ.`TYP-NumID`";
			//Si il y a un filtre
			if(isset($_POST['filtre']) && $_POST['filtre'] != 'all'){
				$query.=" AND typ.`TYP-NumID` = ".$_POST['filtre']."";
			} 
			//Si il y a une recherche
			if(isset($_POST['recherche'])){
				$query.=" AND cli.`CLT-Nom` LIKE '".$_POST['recherche']."%'";
			}
			$query.=" ORDER BY cli.`CLT-Nom`;";

		} else {
			$query = "SELECT pro.`PRO-Nom`, cli.`CLT-Ville`, cli.`CLT-DateNaissance`, cli.`CLT-Sensibilite`, cli.`CLT-Civilité`, cli.`CLT-Conseiller`, cli.`CLT-Type`, cli.`CLT-Statut`,cli.`CLT-Nom`, cli.`CLT-Prénom`, cli.`CLT-NumID`, con.`CON-Couleur`,con.`CON-Nom` ,con.`CON-Prénom`, civ.`CIV-Nom`, sta.`SPR-Nom`, typ.`TYP-Nom`
			FROM `clients et prospects` cli,`conseillers` con, `civilites` civ, `statut professionnel` sta, `type client` typ, `professions` pro
			WHERE cli.`CLT-Conseiller` = $id 
			AND con.`CON-NumID` = $id 
			AND cli.`CLT-Civilité` = civ.`CIV-NumID`
			AND cli.`CLT-Statut` = sta.`SPR-NumID`
			AND pro.`PRO-NumID` = cli.`CLT-Profession`
			AND cli.`CLT-Type` = typ.`TYP-NumID`";
			//Si il y a un filtre
			if(isset($_POST['filtre']) && $_POST['filtre'] != 'all'){
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
		Auth::setInfo('page','Ajout Client');
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

			//Requete Type Historique
			$query_typ_his = "SELECT * FROM `type historique`";
			$pdo->exec("SET NAMES UTF8");
			$res_typ_his = $pdo->query($query_typ_his);
			$type_historique = $res_typ_his->fetchALL(PDO::FETCH_ASSOC);

			//Requete Historique Clients
			$query_his = "SELECT * FROM `historique par client` WHERE `H/C-NumClient` = ".$client[0]['CLT-NumID']."";
			$res_his = $pdo->query($query_his);
			$historiques = $res_his->fetchALL(PDO::FETCH_ASSOC);

			//Requete Type Relation
			$query_typ_rel = "SELECT * FROM `relations`";
			$pdo->exec("SET NAMES UTF8");
			$res_typ_rel = $pdo->query($query_typ_rel);
			$type_relation = $res_typ_rel->fetchALL(PDO::FETCH_ASSOC);

			//Requete Relations Clients
			$query_rel = "SELECT * FROM `relations par personne` WHERE `R/P-NumApporteur` = ".$client[0]['CLT-NumID']."";
			$res_rel = $pdo->query($query_rel);
			$relations = $res_rel->fetchALL(PDO::FETCH_ASSOC);

			//Requete Personnes
			$query_pers = "SELECT `CLT-NumID`, `CLT-Nom`, `CLT-Prénom` FROM `clients et prospects` ORDER BY `CLT-Nom`";
			$pdo->exec("SET NAMES UTF8");
			$res_pers = $pdo->query($query_pers);
			$personnes = $res_pers->fetchALL(PDO::FETCH_ASSOC);

			//Requete Besoins
			$query_bes = "SELECT distinct(be.`BES-NOM`), bt.`B/T-NumType`, be.`BES-NumID` FROM `besoins par type produits` bt, `besoins existants` be WHERE bt.`B/T-NumBesoin` = be.`BES-NumID`";
			$pdo->exec("SET NAMES UTF8");
			$res_bes = $pdo->query($query_bes);
			$besoins = $res_bes->fetchALL(PDO::FETCH_ASSOC);

			//Requete Occurences
			$query_occ = "SELECT bc.`OCC-Nom`, bt.`B/T-NumBesoin`, bt.`B/T-NumType` FROM `besoins par type produits` bt, `besoins occurences` bc WHERE bt.`B/T-NumOcc` = bc.`OCC-NumID`;";
			$pdo->exec("SET NAMES UTF8");
			$res_occ = $pdo->query($query_occ);
			$occurences = $res_occ->fetchALL(PDO::FETCH_ASSOC);

			//Requete Besoins Client
			$query_bes_cli = "SELECT * FROM `besoins par client` bc, `besoins occurences` bo, `besoins existants` be WHERE bc.`B/C-NumBesoin` = be.`BES-NumID` AND  bc.`B/C-NumOcc` = bo.`OCC-NumID` AND bc.`B/C-NumClient` = ".$client[0]['CLT-NumID']." ;";
			$pdo->exec("SET NAMES UTF8");
			$res_bes_cli = $pdo->query($query_bes_cli);
			$besoins_cli = $res_bes_cli->fetchALL(PDO::FETCH_ASSOC);

			Auth::setInfo('page',$client[0]['CLT-Nom']);
			AffichePage(AfficheFicheClient($client[0],$types_client,$conseillers,$civilites,$situations,$sensibilites,$categories,$professions,$status,$type_revenus,$revenus,$type_historique,$historiques,$type_relation,$relations,$personnes,$besoins,$occurences,$besoins_cli));
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
		if(empty($optionIS)){
			$optionIS = 0;
		} else {
			$optionIS = 1;
		}
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
					`CLT-Profession`='$profession',";
					if($promotion != null){
						$query.="`CLT-Promotion`='$promotion',";
					} else {
						$query.="`CLT-Promotion`=null,";
					}
		$query.="
					`CLT-Statut`='$statut',
					`CLT-CBC`='$mois',
					`CLT-OptionIS`=$optionIS
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

	//Supression d'un revenu d'un client
	public function DeleteClientRevenuAction(){
		extract($_POST);
		$query = "DELETE FROM `revenus par client` WHERE `R/C-NumID`=$idRevenu";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=revenus");
	}

	//Ajout d'un historique d'un client
	public function AddClientHistoriqueAction(){
		extract($_POST);
		if(empty($demAssistante)){
			$demAssistante = 0;
		} else {
			$demAssistante = 1;
		}
		if(empty($demCourtier)){
			$demCourtier = 0;
		} else {
			$demCourtier = 1;
		}
		if(empty($tutoriel)){
			$tutoriel = 0;
		} else {
			$tutoriel = 1;
		}
		if(empty($elements)){
			$elements = 0;
		} else {
			$elements = 1;
		}
		if(empty($cloture)){
			$cloture = 0;
		} else {
			$cloture = 1;
		}
		$query = "INSERT INTO `historique par client` VALUES (null,'$idClient','$type',
			CASE WHEN '$date' <> '' THEN STR_TO_DATE('$date','%d/%m/%Y') ELSE null END,'$commentaire',$demAssistante,$demCourtier,$cloture,
			CASE WHEN '$dateCloture' <> '' THEN STR_TO_DATE('$dateCloture','%d/%m/%Y') ELSE null END,$tutoriel,$elements,CASE WHEN '$echMax' <> '' THEN STR_TO_DATE('$echMax','%d/%m/%Y') ELSE null END)";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=historique");
	}

	//Suppression d'un historique d'un client
	public function DeleteClientHistoriqueAction(){
		extract($_POST);
		$query = "DELETE FROM `historique par client` WHERE `H/C-NumID`=$idHistorique";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=historique");
	}

	//Modification d'un historique d'un client
	public function ModifClientHistoriqueAction(){
		extract($_POST);
		if(empty($demAssistante)){
			$demAssistante = 0;
		} else {
			$demAssistante = 1;
		}
		if(empty($demCourtier)){
			$demCourtier = 0;
		} else {
			$demCourtier = 1;
		}
		if(empty($tutoriel)){
			$tutoriel = 0;
		} else {
			$tutoriel = 1;
		}
		if(empty($elements)){
			$elements = 0;
		} else {
			$elements = 1;
		}
		if(empty($cloture)){
			$cloture = 0;
		} else {
			$cloture = 1;
		}
		$query = "UPDATE `historique par client` SET 
			`H/C-DemandeAssistante`=$demAssistante, 
			`H/C-DemandeCourtier`=$demCourtier,
			`H/C-TypeHistorique`=$type,
			`H/C-Date`=CASE WHEN '$date' <> '' THEN STR_TO_DATE('$date','%d/%m/%Y') ELSE null END,
			`H/C-DateMax`=CASE WHEN '$echMax' <> '' THEN STR_TO_DATE('$echMax','%d/%m/%Y') ELSE null END,
			`H/C-Tutoriel`=$tutoriel,
			`H/C-Eléments`=$elements,
			`H/C-Commentaire`='$commentaire',
			`H/C-Cloture`=$cloture,
			`H/C-DateCloture`=CASE WHEN '$dateCloture' <> '' THEN STR_TO_DATE('$dateCloture','%d/%m/%Y') ELSE null END
			WHERE `H/C-NumID`=$idHistorique";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=historique");
	}

	//Ajout d'un historique d'un client
	public function AddClientRelationelAction(){
		extract($_POST);
		//Insertion de la relation
		$query = "INSERT INTO `relations par personne` VALUES ($idClient,$pers,$type,null)";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		//Insertion de la relation inverse
		$query2 = "SELECT `REL-NumInverse` FROM `relations` WHERE `REL-Num` = $type";
		$pdo->exec("SET NAMES UTF8");
		$res2 = $pdo->query($query2);
		$res22 = $res2->fetchALL(PDO::FETCH_ASSOC);
		$type_inverse = $res22[0]['REL-NumInverse'];
		if($type_inverse != 0){
			$query3 = "INSERT INTO `relations par personne` VALUES ($pers,$idClient,$type_inverse,null)";
			$pdo->exec("SET NAMES UTF8");
			$res3 = $pdo->exec($query3);
		}
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=relationel");
	}

	//Suppression d'une relation d'un client
	public function DeleteClientRelationelAction(){
		extract($_POST);
		//Suppression de la relation
		$query = "DELETE FROM `relations par personne` WHERE `R/P-NumApporteur`= $idApp AND `R/P-NumReco` = $idReco AND `R/P-Type` = $idType";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		//Suppresion de la relation inverse
		$query2 = "SELECT `REL-NumInverse` FROM `relations` WHERE `REL-Num` = $idType";
		$pdo->exec("SET NAMES UTF8");
		$res2 = $pdo->query($query2);
		$res22 = $res2->fetchALL(PDO::FETCH_ASSOC);
		$type_inverse = $res22[0]['REL-NumInverse'];
		if($type_inverse != 0){
			$query3 = "DELETE FROM `relations par personne` WHERE `R/P-NumApporteur` = $idReco AND `R/P-NumReco` = $idApp AND `R/P-Type` = $type_inverse";
			$pdo->exec("SET NAMES UTF8");
			$res3 = $pdo->exec($query3);
		}
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=relationel");
	}

	//Modification d'une relation d'un client
	public function ModifClientRelationelAction(){
		extract($_POST);
		$query = "UPDATE`relations par personne` SET `R/P-NumApporteur`= $idApp, `R/P-NumReco` = $pers, `R/P-Type` = $type, `R/P-Commentaire` = '$commentaire'
				  WHERE `R/P-NumApporteur`= $idApp AND `R/P-NumReco` = $idReco AND `R/P-Type` = $idType";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=relationel");
	}

	//Ajout d'un besoin d'un client
	public function AddClientBesoinAction(){
		extract($_POST);
		$idBesoin = explode("/",$idBesoin)[0];
		$query = "INSERT INTO `besoins par client` VALUES ($idClient,$idType,$idBesoin,$idOcc)";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		echo $query;
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=besoin");
	}

	//Modification d'un besoin d'un client
	public function DeleteClientBesoinAction(){
		extract($_POST);
		//Suppression de la relation
		$query = "DELETE FROM `besoins par client` WHERE `B/C-NumClient`= $idClient AND `B/C-NumType` = $idType AND `B/C-NumBesoin` = $idBesoin AND `B/C-NumOcc` = $idOcc;";
		$pdo = BDD::getConnection();
		$pdo->exec("SET NAMES UTF8");
		$res = $pdo->exec($query);
		header("Location: index.php?action=ficheClient&idClient=".$idClient."&onglet=besoin");
	}

}