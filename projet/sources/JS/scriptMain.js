// fichier contenant toutes les fonctions javascript utilisées sur le site

//switche la source d'une image
function toggleDisplay(element,id){
	var div = document.getElementById(id);
	if(div.style.display=="none") {
		div.style.display = "block";
		element.querySelector("img").src="sources/images/flecheBas.png";
	} 
	else {
		div.style.display = "none";
		element.querySelector("img").src="sources/images/flecheDroite.png";
	}
}

//vérifie que 2 mot de passe sont identiques
function check(input) {

	  if (input.value != document.getElementById('passe').value) {
		input.setCustomValidity('Les deux mots de passe ne correspondent pas.');
		 alert("MDP different");
	  } else {
		// le champ est valide : on réinitialise le message d'erreur
		input.setCustomValidity('');
	  }

}


