<?php

	include("PHP/session_bbd.php");
	include("PHP/upload_general.php");

	$nom_dossier_sauvegarde = 'uploads';
	$nom_dossier_general = 'uploads_libre';
	$chemin_sauvegarde = dirname(__FILE__).$ds.$nom_dossier_sauvegarde.$ds;
	
	$req = $bdd->prepare('SELECT nom, prenom FROM table_u_profil WHERE id_profil = ?');
	$req->execute(array($_SESSION['id_profil']));
	$donnees = $req->fetch();
	$req->closeCursor();
	
	$dossier_utilisateur = strtolower($donnees['nom']).'_'.strtolower($donnees['prenom']);
	$chemin_partiel = $chemin_sauvegarde.$dossier_utilisateur.$ds;
	$chemin_total = $chemin_partiel.$nom_dossier_general.$ds;
	
	if(!file_exists($chemin_partiel))
	{		
		mkdir($chemin_total, 0777, true);
		$fichier_index = fopen($chemin_total.'NE_PAS_TOUCHER.txt', "w+");
		fseek($fichier_index, 0);
		fputs($fichier_index, 0);
		fclose($fichier_index);
	}
	
	$upload = upload('file',$chemin_total.$_FILES['file']['name'],FALSE, FALSE); //array('png','gif','jpg','jpeg')
				
	$fichier_index = fopen($chemin_total.'NE_PAS_TOUCHER.txt', "r+");
	$index_courant = fgets($fichier_index);
	$nom = $index_courant.'_'.$_FILES['file']['name'];
	
	rename($chemin_total.$_FILES['file']['name'], $chemin_total.$nom); 
	
	$index_courant++;
	fseek($fichier_index, 0);
	fputs($fichier_index, $index_courant);
	fclose(fichier_index);
	

?>      