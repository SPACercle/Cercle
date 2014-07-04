$(document).ready(function() {

	//DEBUT ONGLET BESOIN

	/**
	* Méthode pour faire de l'Ajax
	*/
    function getXhr(){
        var xhr = null; 
		if(window.XMLHttpRequest) // Firefox et autres
		   xhr = new XMLHttpRequest(); 
		else if(window.ActiveXObject){ // Internet Explorer 
		   try {
	                xhr = new ActiveXObject("Msxml2.XMLHTTP");
	            } catch (e) {
	                xhr = new ActiveXObject("Microsoft.XMLHTTP");
	            }
		}
		else { // XMLHttpRequest non supporté par le navigateur 
		   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
		   xhr = false; 
		} 
        return xhr;
	}

	/**
	* Méthode qui sera appelée au changement du besoin retraite
	*/
	$('#besoin2').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin2").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin prévoyance
	*/
	$('#besoin3').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences2').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin3").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin prévoyance post-activité
	*/
	$('#besoin4').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences3').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin4").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin santé
	*/
	$('#besoin5').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences4').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin5").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin épargne
	*/
	$('#besoin6').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences5').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin6").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin chomage
	*/
	$('#besoin7').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences6').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin7").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	/**
	* Méthode qui sera appelée au changement du besoin prévoyance
	*/
	$('#besoin8').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				document.getElementById('occurences7').innerHTML = leselect;
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxOcc.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		infos = document.getElementById("besoin8").value;
		var tab = infos.split("/");
		idBesoin =tab[0];
		idType =tab[1];
		xhr.send("idBesoin="+idBesoin+"&idType="+idType);
	});

	$('#occurences').bind('DOMNodeInserted', function() {
		if($('#occurences').text() == ""){
			$('#form1').submit();
		}
	});
	$('#occurences').change(function() {
		$('#form1').submit();
	});

	$('#occurences2').bind('DOMNodeInserted', function() {
		if($('#occurences2').text() == ""){
			$('#form2').submit();
		}
	});
	$('#occurences2').change(function() {
		$('#form2').submit();
	});

	$('#occurences3').bind('DOMNodeInserted', function() {
		if($('#occurences3').text() == ""){
			$('#form3').submit();
		}
	});
	$('#occurences3').change(function() {
		$('#form3').submit();
	});


	$('#occurences4').bind('DOMNodeInserted', function() {
		if($('#occurences4').text() == ""){
			$('#form4').submit();
		}
	});
	$('#occurences4').change(function() {
		$('#form4').submit();
	});


	$('#occurences5').bind('DOMNodeInserted', function() {
		if($('#occurences5').text() == ""){
			$('#form5').submit();
		}
	});
	$('#occurences5').change(function() {
		$('#form5').submit();
	});


	$('#occurences6').bind('DOMNodeInserted', function() {
		if($('#occurences6').text() == ""){
			$('#form6').submit();
		}
	});
	$('#occurences6').change(function() {
		$('#form6').submit();
	});


	$('#occurences7').bind('DOMNodeInserted', function() {
		if($('#occurences7').text() == ""){
			$('#form7').submit();
		}
	});
	$('#occurences7').change(function() {
		$('#form7').submit();
	});



	//FIN ONGLET BESOIN

	//DEBUT ONGLET BESOIN

	//Cache le formulaire d'ajout d'un revnu
	$('#formRevenu').hide();

	//Afficher le formulaire de création de revenu
	$('#ajoutRevenu').click(function(){
		$('#formRevenu').show();
	});

	//FIN ONGLET BESOIN

	//DEBUT ONGLET HISTORIQUE

	//Cache le formulaire d'ajout d'un historique
	$('#formHistorique').hide();

	//Afficher le formulaire de création d'historique
	$('#ajoutHistorique').click(function(){
		$('#formHistorique').show();
	});

	//FIN ONGLET HISTORIQUE

	//DEBUT ONGLET BESOIN

	//Cache le formulaire d'ajout d'un historique
	$('#formBesoin1').hide();
	$('#formBesoin2').hide();
	$('#formBesoin3').hide();
	$('#formBesoin4').hide();
	$('#formBesoin5').hide();
	$('#formBesoin6').hide();
	$('#formBesoin7').hide();

	//Afficher le formulaire de création d'historique
	$('#ajoutBesoin1').click(function(){
		$('#formBesoin1').show();
	});
	$('#ajoutBesoin2').click(function(){
		$('#formBesoin2').show();
	});
	$('#ajoutBesoin3').click(function(){
		$('#formBesoin3').show();
	});
	$('#ajoutBesoin4').click(function(){
		$('#formBesoin4').show();
	});
	$('#ajoutBesoin5').click(function(){
		$('#formBesoin5').show();
	});
	$('#ajoutBesoin6').click(function(){
		$('#formBesoin6').show();
	});
	$('#ajoutBesoin7').click(function(){
		$('#formBesoin7').show();
	});

	//FIN ONGLET BESOIN

	//DEBUT ONGLET RELATIONEL

	//Cache le formulaire d'ajout d'un lien
	$('#ajoutLienType').hide();

	//Afficher le formulaire de création de lien
	$('#ajoutLien').click(function(){
		$('#ajoutLienType').show();

		//Cache la liste des types
		$('#lienType').hide();
	});

	//Quand la personne est glissé dans la boite, la selection du type s'affiche
	$('#destinationFields').mouseover(function(){
		$('#lienType').show();
	});

	nb = 0;

	//Si le lien à créer dispose de toutes les infos, le formulaire se soumet
	$('#lien').bind('DOMNodeInserted', function(event) {
	    nb = nb + 1
	    if(nb/4 == 2){
			$('#formLien').submit();
		}
	});

	//FIN ONGLET RELATIONEL


	//DEBUT ONGLET SOLUTION RETENUES

	/**
	* Méthode qui sera appelée au changement du type produit
	*/
	$('#typeProduit').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				//$('#sourceFields')[2].innerHTML = leselect;
				$('#produitListe').find("#sourceFields").html(leselect);
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxProdFiltre.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		idType = document.getElementById("typeProduit").value;
		idComp = document.getElementById("compagnie").value;
		isCom = 0;
		if($('#isCom').prop('checked')){
			isCom = 1;
		}
		xhr.send("idType="+idType+"&idComp="+idComp+"&isCom="+isCom);
	});

	/**
	* Méthode qui sera appelée au changement de la compagnie
	*/
	$('#compagnie').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				$('#produitListe').find("#sourceFields").html(leselect);
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxProdFiltre.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		idType = document.getElementById("typeProduit").value;
		idComp = document.getElementById("compagnie").value;
		isCom = 0;
		if($('#isCom').prop('checked')){
			isCom = 1;
		}
		xhr.send("idType="+idType+"&idComp="+idComp+"&isCom="+isCom);
	});

	/**
	* Méthode qui sera appelée au changement de la case commercialisé
	*/
	$('#isCom').change(function(){
		var xhr = getXhr();
		// On défini ce qu'on va faire quand on aura la réponse
		xhr.onreadystatechange = function(){
			// On ne fait quelque chose que si on a tout reçu et que le serveur est ok
			if(xhr.readyState == 4 && xhr.status == 200){
				leselect = xhr.responseText;
				// On se sert de innerHTML pour rajouter les options a la liste
				$('#produitListe').find("#sourceFields").html(leselect);
			}
		}
		// Ici on va voir comment faire du post
		xhr.open("POST","ajaxProdFiltre.php",true);
		// ne pas oublier ça pour le post
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		// ne pas oublier de poster les arguments
		// ici, l'id du besoin
		idType = document.getElementById("typeProduit").value;
		idComp = document.getElementById("compagnie").value;
		isCom = 0;
		if($('#isCom').prop('checked')){
			isCom = 1;
		}
		xhr.send("idType="+idType+"&idComp="+idComp+"&isCom="+isCom);
	});

	//Soummission formulaire ajout produit dès qu'un prodit est glissé dans la case
	$('#produitListe').find("#destinationFields").bind('DOMNodeInserted', function() {
		$('#formAddProduit').submit();
	});

	//Cache le formaulaire d'ajout
	$('#formProduitClient').hide();

	//Afficher le formulaire de création de lien
	$('#ajoutProduit').click(function(){
		$('#formProduitClient').show();
	});

	//FIN ONGLET SOLUTIONS RETENUES

	//DEBUT COMPAGNIES

	$('#formContact').hide();

	$('#ajoutContact').click(function(){
		$('#formContact').show();
	});

	$('#formContactLoc').hide();

	$('#ajoutContactLoc').click(function(){
		$('#formContactLoc').show();
	});

	$('#formCode').hide();

	$('#ajoutCode').click(function(){
		$('#formCode').show();
	});

	//FIN COMPAGNIES

	//DEBUT PARTENAIRES

	$('#formAccord').hide();

	$('#ajoutAccord').click(function(){
		$('#formAccord').show();
	});

	//FIN PARTENAIRES

	//DEBUT FICHE PRODUIT

	$('#anomAjout').click(function(){
		$('#anom2').hide();
		$('#anom1').show();
	});

	//FIN FICHE PRODUIT

});
