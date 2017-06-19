<?php
	/*****************************************************************************************************************************************/
	// Création d'une session pour sauvegarder l'identifiant du projet pour les autres pages

	$ds          = DIRECTORY_SEPARATOR;	
	$dossier_session = 'Sessions';
	$chemin_sessions = dirname(__FILE__).$ds.$dossier_session.$ds;
	
	session_save_path($chemin_sessions);
	session_start();
	
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=outil_evenement_ps;charset=utf8', 'root', 'admin');
	}

	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	
	
?>