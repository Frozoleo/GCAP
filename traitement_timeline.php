<?php

/*********************************************************************************************************************************************/
/*		Fichier : traitement_acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr			 */
/*********************************************************************************************************************************************/

	include('PHP/session_bbd.php');
	include('PHP/mail_automatique.php');

	/*****************************************************************************************************************************************/
	// Traitement des données
	
	if(!empty($_POST["validation"]))
	{		
		if($_POST["validation"])
		{
			$req = $bdd->prepare('UPDATE table_general SET Etat = :Etat WHERE Id_general = :Id_general');
			$result = $req->execute(array('Etat' => 'En cours de traitement', 'Id_general' => $_POST["Identifiant"]));
			$req->closeCursor();
			
			$dir='timeline_resolution.php?Id='.$_POST["Identifiant"].'&acceptation=1';
		}
		else
		{
			if(!empty($_POST["transfert"]))
			{
				$req = $bdd->prepare('SELECT r.Id_reponsabilite Id_reponsabilite 
									FROM table_u_admin a INNER JOIN table_u_responsabilite r ON r.Id_expert1 = a.Id_admin WHERE a.mail = ? AND r.Constructeur = ?');
				$req->execute(array($_POST["transfert"], 'transfert'));
				$donnnes = $req->fetch();
				$req->closeCursor();
				
				$req = $bdd->prepare('UPDATE table_general SET Id_G_reponsabilite = :Id_G_reponsabilite WHERE Id_general = :Id_general');
				$result = $req->execute(array('Id_G_reponsabilite' => $donnnes["Id_reponsabilite"], 'Id_general' => $_POST["Identifiant"]));
				$req->closeCursor();
				
				$message_txt = "Un utilisateur vient de renseigner une événement dans l'outil GCAP, Vous trouverez toutes les informations y referant ici";
				$message_html = 	'<html>
									<head></head>
										<body>
										Un utilisateur vient de renseigner un événement dans l\'outil GCAP, Vous trouverez toutes les informations y referant ici:
										<a href="'.$adresse_serveur.'accueil.php?filtre='.$id.'" title="Cliquez pour accéder à la ligne de défaillance">ici</a></br>
										Pensez à vous connecter avant de sélectionner l\'événement afin d\'avoir les menus appropriés !
										</body>
									</html>';
									
				$sujet = "Demande de prise en charge d'un événement";
				$adresse = $donnnes['mail_GCAP'];

				Generation_mail($adresse,$sujet,$message_txt,$message_html);
				
				$dir='timeline_resolution.php?Id='.$_POST["Identifiant"].'acceptation=0';
			}
			else
			{				
				$dir='timeline_resolution.php?Id='.$_POST["Identifiant"].'acceptation=-1';
			}
		}
	}

	/*****************************************************************************************************************************************/
	//Redirection fonction du traitement
	header('location:'.$dir);

?>