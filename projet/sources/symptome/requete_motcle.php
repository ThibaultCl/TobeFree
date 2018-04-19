<?php
//fichier appelé par index.php pour la page de recherche par mot clé

//connexion à la bdd
$connexion = new PDO('mysql:host=localhost;dbname=acuBD;charset=utf8', 'root', 'root');

//page accessible seulement lorsque l'utilisateur est connecté
if(isset($_SESSION['id'],$_SESSION['pseudo'])){

	//nouvelle instance de Smarty
	$tpl = new Smarty();
	$tpl->compile_dir='templates_c/';


	$mot_cle_requete=array();
	$tableau_mot=array();

	//affichage du formulaire de mot clé
	$tpl->display("sources/symptome/symptome.html");

	//traitement du formulaire pour les mots clé envoyés
	if (isset($_POST['keyword'])){
		//récupération des mots clé
		$liste_mot=$_POST['keyword'];
		$tableau_mot=explode(",",$liste_mot);
		$tpl->assign('tableau_mot',$tableau_mot);

		$i = 0;
		$mot_cle_affiche=array();
		$list_symptome=array();

		//requete pour récupérer les symptomes associés aux mots clé
		for ($j=0;$j<count($tableau_mot);$j++)
		{
			$mot_cle_requete[$j]=$tableau_mot[$j];
			$mot_cle_affiche[$j]=$mot_cle_requete[$j];
			$query1 = $connexion->prepare("SELECT DISTINCT symptome.desc FROM symptome,keywords,keySympt WHERE keywords.idK=keySympt.idK AND keySympt.idS=symptome.idS AND keywords.name='$mot_cle_requete[$j]'");

			$query1->execute();
			while($data = $query1->fetch()){

			    $list_symptome[$i]['desc'] = $data['desc'];
			    $list_symptome[$i]['id']="symptome".(string)$i;
			    $i++;
			}
			$query1->closeCursor();
			
			//affichage des mots clé
			if(isset($mot_cle_affiche)){
				$tpl->assign('mot_cle_affiche',$mot_cle_affiche);
			}
		}
		//affichage des symptomes
		if(isset($list_symptome)){
			$tpl->assign('list_symptome', $list_symptome);
		}
	  	//affichage du template du formulaire de symptome
	    $tpl->display("sources/symptome/requetesymptome.html");
	}


	//traitement pour le formulaire de symptome
	if ( isset($_POST['valider']) )
	{	
		$symptome_coche = array();
		$j=0;

		//récupération de la liste de symptome
		for ($k=0;$k<100;$k++){    //remplacer 100 par le nombre de checkbox
			$name="symptome".$k;
			if(isset($_POST[$name]))
				{	
					$symptome_coche[$j]=$_POST[$name];
					$j++;
				}
		}
		
		$tpl->assign('list_symptomeCoche', $symptome_coche);

		//requete de recuperation des pathologie à partir des symptomes cochés
		$i = 0;
		$list_patho = array();
		if(count($symptome_coche)!=0)
		{
			for ($j=0; $j < count($symptome_coche); $j++) { 
				$query5 = $connexion->prepare("SELECT DISTINCT patho.desc FROM patho,symptome,symptPatho WHERE patho.idP=symptPatho.idP AND symptPatho.idS=symptome.idS AND symptome.desc='$symptome_coche[$j]'");
				$query5->execute();
				while($data5 = $query5->fetch()){
					$list_patho[$i]['desc'] = $data5['desc'];
					$list_patho[$i]['under']=str_replace(' ', '_', $data5['desc']);
					$i++;
				}
				$query5->closeCursor();

			}
		}

		//assignation et affichage des pathologies trouvées
		$tpl->assign('list_patho', $list_patho);
		$tpl->display("sources/symptome/affichage_pathologie.html");
	}

}
//l'utilisateur n'est pas connecté
else{
	echo "<h2>Recherche de pathologie par symptomes</h2><p>Vous devez être connecté pour accèder à ce service.</p>";
}


?>
