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


	$('#produitListe').find("#destinationFields").mouseenter(function(){

		$('#produitListe').mouseup(function(){
			alert('déposé !');
		});
	});

	//FIN ONGLET SOLUTIONS RETENUES

});
