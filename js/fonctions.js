$(document).ready(function() {

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
	$('#besoin').change(function(){
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

	//Cache le formulaire d'ajout d'un lien
	$('#ajoutLienType').hide();

	//Cache la liste des personnes
	//$('#lienPers').hide();

	//Cache la liste des types
	$('#lienType').hide();

	//Afficher le formulaire de création de lien
	$('#ajoutLien').click(function(){
		$('#ajoutLienType').show();
	});

	$('#destinationFields').mouseover(function(){
		$('#lienType').show();
	});

	nb = 0;

	$('#lien').bind('DOMNodeInserted', function(event) {
    /*if (event.type == 'DOMNodeInserted') {
        alert('Content added! Current content:' + '\n\n' + this.innerHTML);
    } else {
        alert('Content removed! Current content:' + '\n\n' + this.innerHTML);
    }*/
    nb = nb + 1
    if(nb/4 == 2){
		$('#formLien').submit();
	}
	});

	/*$('#test').click(function(){
		alert(nb/4);
	});*/
 
});
