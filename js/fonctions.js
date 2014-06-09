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
	* Méthode qui sera appelée au changement du besoin
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


	//FIN ONGLET BESOIN

	//DEBUT ONGLET RELATIONEL

	//Cache le formulaire d'ajout d'un lien
	$('#ajoutLienType').hide();

	//Cache la liste des types
	$('#lienType').hide();

	//Afficher le formulaire de création de lien
	$('#ajoutLien').click(function(){
		$('#ajoutLienType').show();
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

});
