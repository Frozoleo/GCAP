<?php

/*********************************************************************************************************************************************/
/*		Fichier : traitement_acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr			 */
/*********************************************************************************************************************************************/

	include('PHP/session_bbd.php');
	include('PHP/mail_automatique.php');

	header('Content-Type: text/html; charset=utf-8');
	
	/*****************************************************************************************************************************************/
	// Traitement des données
	
	switch ($_POST["domaine"].value) 
		{	
			case 'materiel': 
				switch ($_POST["materiel"].value) 
				{	
					case 'in_PS': 
						
						$tous_materiel = $_POST["type_materiel_PCCN"]+$_POST["type_materiel_PAGC"];
						
						// Insertion des champs dans la base de données
						$req = $bdd->prepare('INSERT INTO table_f_in_ps(Nom_poste, Palier_technique, Type_materiel, UC, Constructeur, Reference, Age, Version_materielle, Version_logicielle) 
																VALUES(:Nom_poste, :Palier_technique, :Type_materiel, :UC, :Constructeur, :Reference, :Age, :Version_materielle, :Version_logicielle)');
						$req->execute(array(
							'Nom_poste' => $_POST["Nom_Poste"],
							'Palier_technique' => $_POST["Palier_technique"],
							'Type_materiel' => $tous_materiel,
							'UC' => $_POST["UC"],
							'Constructeur' => $_POST["Constructeur"],							
							'Reference' => $_POST["Reference"],
							'Age' => $_POST["Age"],
							'Version_materielle' => $_POST["version_materielle"],
							'Version_logicielle' => $_POST["version_logicielle"]
							));
						$req->closeCursor();	
						
						$id = $bdd->lastInsertId();

						$req = $bdd->prepare('SELECT Id_reponsabilite, Id_expert1, Id_expert2 FROM table_u_responsabilite WHERE Constructeur = ? AND Materiel = ?');
						$req->execute(array($_POST['Constructeur'], $tous_materiel));
						$donnee1 = $req->fetch();
						$req->closeCursor();

						$req = $bdd->prepare('INSERT INTO table_general(Id_G_type, Id_G_region, Id_G_admin, Nom, Type, Sous_type, Description, Date_derniere_modification) 
																VALUES(:Id_G_type, :Id_G_region, :Id_G_admin, :Nom, :Type, :Sous_type, :Description, NOW())');
						$req->execute(array(
							'Id_G_type' => $id,
							'Id_G_region' => $_SESSION['id_profil'],
							'Id_G_admin' => $donnee1['Id_reponsabilite'],
							'Nom' => $_POST["Nom_defaillance"],
							'Type' => $_POST["domaine"],							
							'Sous_type' => $_POST["materiel"],
							'Description' => $_POST["Description"]
							));
							
						$id = $bdd->lastInsertId();
							
						$dir='accueil.php?validation=1';
						
						$req = $bdd->prepare('SELECT mail FROM table_u_profil WHERE id_profil = ?');						
						$req->execute(array($_SESSION['id_profil']));
						$donnee2 = $req->fetch();			
						$req->closeCursor();
		
						$message_txt = "M/Mme.".$_POST["Nom"].", L\'événement que vous venez de renseigner dans l'outil GCAP a bien été prise en compte. Vous serez averti dès qu'un de nos agents l'aura pris en charge";
						$message_html = "<html><head></head><body>M/Mme.".$_POST["Nom"].",<br /><br /> L\'événement que vous venez de renseigner dans l'outil GCAP a bien été prise en compte. Vous serez averti dès qu'un de nos agents l'aura pris en charge.</body></html>";
						$sujet = "Confirmation d'enregistrement de l\'événement";
						$adresse = $donnee2['mail'];
						
						// debug !!!!!!!!!!!!!!!!!!!!!!!!!!!
						$adresse = 'leonard.souffache@erdf.fr';
						// debug !!!!!!!!!!!!!!!!!!!!!!!!!!!

						Generation_mail($adresse,$sujet,$message_txt,$message_html);
						
						sleep(1);

						$req = $bdd->query('SELECT a.mail mail_GCAP FROM table_u_responsabilite r INNER JOIN table_u_admin a ON a.Id_admin = r.Id_expert1 WHERE r.Id_expert1 = '.$donnee1['Id_expert1']);												
						$donnnes = $req->fetch();
						$req->closeCursor();
						
						$adresse_serveur='http://127.0.0.1:8080/OE/';

						$message_txt = "Un utilisateur vient de renseigner un événement dans l'outil GCAP, Vous trouverez toutes les informations y referant ici";
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
						
						/* if(!empty($adresse[1]))
						{
							sleep(1);

							$message_html = 	'<html>
												<head></head>
													<body>
													Un utilisateur vient de renseigner une defaillance dans l\'outil GCAP, Vous trouverez toutes les informations y referant
													<a href="'. $adresse_serveur .'accueil.php?filtre='.$_POST['Nom_defaillance'].'&pers='.$adresses[1].'" title="Cliquez pour accéder à la ligne de défaillance">ici</a>
													</body>
												</html>';
							
							Generation_mail($adresse,$sujet,$message_txt,$message_html);
						} */
							
					break;
					
					case 'out_PS': 
						$type='Contrôle commande hors Poste source';
					break;
					
					case 'autre': 
						$type='Contrôle commande autre';
					break;
					
					default:
						echo '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
					break;
				}													
			break;
			
			case 'PS.': 
				switch ($_POST["PS"].value) 
				{					
					case 'materielle': 
						$type='Poste source général';														
					break;
					
					case 'logicielle': 
						$type='Poste Source configuration';
					break;
					
					case 'autre': 
						$type='Poste Source autre';
					break;
					
					default:
						echo '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
					break;
				}														
			break;

			case 'autre.': 
				$type='autre';
			break;
			
			default:
				echo '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
			break;
		}

	/*****************************************************************************************************************************************/
	//Redirection fonction du traitement
	header('location:'.$dir);
	
	
	
	
	
	
	
	/*
	
	if(($_GET["filtre"]==5489) && (!empty($_GET["pers"])))
	{
		$req = $bdd->prepare('UPDATE table_defaillance SET Etat_avancement = :Etat_avancement WHERE Nom_defaillance = :Nom_defaillance');
		$req->execute(array('Etat_avancement' => 'En cours de traitement', 'Nom_defaillance' => $_GET["Nom_defaillance"]));
		$req->closeCursor();
		
		$req = $bdd->prepare('SELECT Nom_responsable, Prenom_responsable, Nom_defaillance, Date_creation FROM table_defaillance WHERE Nom_defaillance = ?');
		$req->execute(array($_GET['Nom_defaillance']));
		$information_mail = $req->fecth();
		$req->closeCursor();
		
		$nom_expert=explode(".",$_GET["pers"]);
		$nom_expert=$nom_expert[0];
		
		$message_txt = "M/Mme.".$information_mail['Nom_responsable'].", La défaillance dénominée ".$information_mail['Nom_defaillance']." et créée le ".$information_mail['Date_creation']." vient d'être prise en charge par M.".$nom_expert." d\'adresse mail : ".$_GET["pers"].".";
		$message_html = "<html><head></head><body>M/Mme.".$information_mail['Nom_responsable'].",<br /><br /> La défaillance dénominée ".$information_mail['Nom_defaillance']." et créée le ".$information_mail['Date_creation']." vient d'être prise en charge par M.".$nom_expert." d\'adresse mail : ".$_GET["pers"].".</body></html>";
		$sujet = "Confirmation de prise en charge";
		$nom = $information_mail['Nom_responsable'];
		$prenom = $information_mail['Prenom_responsable'];
		$adresse = $prenom.'.'.$nom.'@erdf.fr';

		Generation_mail($adresse,$sujet,$message_txt,$message_html);
		
		$dir='accueil.php?validation=2&filtre='.$_GET["filtre"].'';
		
	}
	
	else if (empty($_GET["filtre"]))
	{
		$req = $bdd->query('SELECT Nom_defaillance FROM table_defaillance');

		// Vérifie si le nom existe déjà dans la base
		while ($donnees = $req->fetch())
		{
			if ($donnees['Nom_defaillance']==$_POST["Nom_defaillance"])
			{
				$erreur=1;
			}
		}
		
		$req->closeCursor();

		// Si le nom n'est pas déjà utilisé
		if (empty($erreur))
		{
			if(!empty($_SESSION['id_dossier']))
			{
				$nouveau_nom =$_POST["Nom_defaillance"] . $ds;
				$storeFolder = 'uploads';
				$fichier_temporaire= 'temp';
				$ancien_nom =$fichier_temporaire.$_SESSION['id_dossier'] . $ds;
				$targetPath = dirname( __FILE__ ) . $ds . $storeFolder . $ds;
				
				if (!rename(($targetPath . $ancien_nom),($targetPath . $nouveau_nom)))
				{
					die('Echec lors du changement de nom de repertoire');
				}
				
				$piece_jointe= 'present';			
			}
			
			else
			{
				$piece_jointe= 'absent';
			}
			
			if($_POST["Type"]==1)
			{
				// Insertion des champs dans la base de données
				$req = $bdd->prepare('INSERT INTO table_defaillance(Type, Nom_defaillance, Materiel, Constructeur, Descriptif, Palier_technique, Nom_poste, Date_creation, Nom_AMEPS, Nom_ACR, Nom_responsable, Prenom_responsable, Pieces_jointes, Etat_avancement) 
															 VALUES(:Type, :Nom_defaillance, :Materiel, :Constructeur, :Descriptif, :Palier_technique, :Nom_poste, NOW(), :Nom_AMEPS, :Nom_ACR, :Nom_responsable, :Prenom_responsable, :Pieces_jointes, :Etat_avancement)');
				$req->execute(array(
					'Type' => $_POST["Type"],
					'Nom_defaillance' => $_POST["Nom_defaillance"],
					'Materiel' => $_POST["Materiel"],
					'Constructeur' => $_POST["Constructeur"],
					'Descriptif' => htmlspecialchars($_POST["Description"]),
					'Palier_technique' => $_POST["Palier_technique"],
					'Nom_poste' => $_POST["Nom_Poste"],
					'Nom_AMEPS' => $_POST["Nom_AMEPS"],
					'Nom_ACR' => $_POST["Nom_ACR"],
					'Nom_responsable' => $_POST["Nom"],
					'Prenom_responsable' => $_POST["Prenom"],
					'Pieces_jointes' => $piece_jointe,
					'Etat_avancement' => 'En attente de traitement'
					));
					
				$adresses = $bdd->prepare('SELECT Mail_expert1, Mail_expert2 FROM table_materiel WHERE Constructeur= ? AND Materiel = ?');
				$adresses->execute(array($_POST["Constructeur"], $_POST["Materiel"]));
				$adresses=$adresses->fetch();
			}
			
			else
			{
				// Insertion des champs dans la base de données
				$req = $bdd->prepare('INSERT INTO table_defaillance(Type, Nom_defaillance, Descriptif, Palier_technique, Nom_poste, Date_creation, Nom_AMEPS, Nom_ACR, Nom_responsable, Prenom_responsable, Pieces_jointes, Etat_avancement) 
															 VALUES(:Type, :Nom_defaillance, :Descriptif, :Palier_technique, :Nom_poste, NOW(), :Nom_AMEPS, :Nom_ACR, :Nom_responsable, :Prenom_responsable, :Pieces_jointes, :Etat_avancement)');
				$req->execute(array(
					'Type' => $_POST["Type"],
					'Nom_defaillance' => $_POST["Nom_defaillance"],
					'Descriptif' => htmlspecialchars($_POST["Description"]),
					'Palier_technique' => $_POST["Palier_technique"],
					'Nom_poste' => $_POST["Nom_Poste"],
					'Nom_AMEPS' => $_POST["Nom_AMEPS"],
					'Nom_ACR' => $_POST["Nom_ACR"],
					'Nom_responsable' => $_POST["Nom"],
					'Prenom_responsable' => $_POST["Prenom"],
					'Pieces_jointes' => $piece_jointe,
					'Etat_avancement' => 'En attente de traitement'
					));
			}
				
			$req->closeCursor();
			
			session_destroy();
			
			
			

			
		}
		
		else
		{
			$dir='formulaire.php?num_erreur='.$erreur;
		}
	}	*/
	
?>