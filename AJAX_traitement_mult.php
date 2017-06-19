<?php 

/*********************************************************************************************************************************************/
/*		Fichier : traitement_acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr			 */
/*********************************************************************************************************************************************/

	header("Content-Type: text/plain");

	/*****************************************************************************************************************************************/
	// Création d'une session pour sauvegarder l'identifiant du projet pour les autres pages

	include("PHP/session_bbd.php");

	/*****************************************************************************************************************************************/
	
	include("PHP/mail_automatique.php");
	include("PHP/concatenation_type.php");
	include("PHP/fonctions_formulaire.php");
	include("PHP/regex_mail.php");
	
	function evenments_profil($bdd, $mail)
	{
		if(regex_mail_admin($bdd, $mail))
		{		
			$req_inter = $bdd->prepare('SELECT r.Id_reponsabilite Id_reponsabilite 
								FROM table_u_responsabilite r INNER JOIN table_u_admin a ON a.Id_admin = r.Id_expert1 WHERE a.mail = ?');
			$req_inter->execute(array($mail));
			
			while ($donnnes_inter = $req_inter->fetch())
			{
				$req = $bdd->prepare('SELECT ge.Id_general Id_general, ge.Nom Nom, ge.Type Type, ge.Sous_type Sous_type, ge.Description_synthetique Description_synthetique, ge.Etat Etat, ge.Date_derniere_modification Date_derniere_modification, ge.Mots_cles Mots_cles 
											FROM table_general ge INNER JOIN table_u_responsabilite r ON r.Id_reponsabilite = ge.Id_G_reponsabilite WHERE r.Id_reponsabilite = ?');
				$req->execute(array($donnnes_inter['Id_reponsabilite']));
				
				while ($donnees = $req->fetch())
				{
					echo '!'.$donnees['Id_general'].'$'.$donnees['Nom'].'$'.concatenation_type($donnees).'$'.$donnees['Description_synthetique'].'$'.$donnees['Etat'].'$'.$donnees['Date_derniere_modification'].'$'.$donnees['Mots_cles'];
				}
			}
			
			$req_inter->closeCursor();
		}
		else
		{
			$req = $bdd->prepare('SELECT g.Id_general Id_general, g.Nom Nom, g.Type Type, g.Sous_type Sous_type, g.Description_synthetique Description_synthetique, g.Etat Etat, g.Date_derniere_modification Date_derniere_modification, g.Mots_cles Mots_cles 
									FROM table_general g INNER JOIN table_u_profil p ON p.id_profil = g.Id_G_region WHERE p.mail = ?');
			$req->execute(array($mail));
			
			while ($donnees = $req->fetch())
			{
				echo '!'.$donnees['Id_general'].'$'.$donnees['Nom'].'$'.concatenation_type($donnees).'$'.$donnees['Description_synthetique'].'$'.$donnees['Etat'].'$'.$donnees['Date_derniere_modification'].'$'.$donnees['Mots_cles'];
			}
		}				
		
		$req->closeCursor();
	}
	
	/*****************************************************************************************************************************************/
	
	if(!empty($_POST["mdp"]))
	{	
		$req = $bdd->query('SELECT mail FROM table_u_profil');
		$erreur=false;

		// Vérifie si le mail existe déjà dans la base
		while ($donnees = $req->fetch())
		{
			if ($donnees['mail']==$_POST["mail"])
			{
				$erreur=true;
			}
		}
		
		$req->closeCursor();
	
		// Si le mail n'est pas déjà utilisé
		if (!$erreur)
		{
			// Insertion des champs dans la base de données
			$req = $bdd->prepare('INSERT INTO table_u_profil(mail, mdp, nom, prenom, ameps, acr, tel) VALUES(:mail, :mdp, :nom, :prenom, :ameps, :acr, :tel)');
			$req->execute(array(
				'mail' => $_POST["mail"],
				'mdp' => $_POST["mdp"],
				'nom' => $_POST["nom"],
				'prenom' => $_POST["prenom"],
				'ameps' => $_POST["ameps"],
				'acr' => $_POST["acr"],
				'tel' => $_POST["tel"]
				));
				
			$req->closeCursor();
			
			// Partage l'id du projet de travail dans la session
			$req = $bdd->prepare('SELECT id_profil FROM table_u_profil WHERE mail = ?');
			$req->execute(array($_POST['mail']));
			$req = $req->fetch();
			$_SESSION['id_profil'] = $req['id_profil'];
			
			echo 'Bonjour '.$_POST["prenom"].' '.$_POST["nom"];
			
			evenments_profil($bdd, $_POST["mail"]);
		}
		
		else
		{
			echo 'NOK';
		}
	}
	
	else if(!empty($_POST["mdp_save"]))
	{
		if(regex_mail_admin($bdd, $_POST['mail']))
		{
			$req = $bdd->prepare('SELECT mdp FROM table_u_admin WHERE mail = ? ');			
		}
		
		else
		{
			$req = $bdd->prepare('SELECT mdp FROM table_u_profil WHERE mail = ? ');
		}		
		
		$req->execute(array($_POST['mail']));
		$donnee = $req->fetch();
		
		if($_POST["mdp_save"]==$donnee["mdp"])
		{
			// Partage l'id du projet de travail dans la session
			if(regex_mail_admin($bdd, $_POST['mail']))
			{
				$req = $bdd->prepare('SELECT id_admin FROM table_u_admin WHERE mail = ?');
			}
			else
			{
				$req = $bdd->prepare('SELECT id_profil, nom, prenom FROM table_u_profil WHERE mail = ?');
			}
			$req->execute(array($_POST['mail']));
			$donnee = $req->fetch();			
			$req->closeCursor();
			if(regex_mail_admin($bdd, $_POST['mail']))
			{
				$_SESSION['id_admin'] = $donnee['id_admin'];
				$prenom = explode('.', $_POST['mail']);
				$nom = explode('@', $prenom[1]);
				$nom= $nom[0];
				$prenom = $prenom[0];
			}
			else
			{
				$_SESSION['id_profil'] = $donnee['id_profil'];
				$nom= $donnee['nom'];
				$prenom = $donnee['prenom'];
			}
			
			echo 'Bonjour '.$prenom.' '.$nom;
			
			evenments_profil($bdd, $_POST["mail"]);
		}

		else
		{
			echo 'NOK';
		}
	}
	
	else if(!empty($_POST["mdp_oubli"]))
	{			
		$req = $bdd->query('SELECT mail FROM table_u_profil');
		$existe=false;

		// Vérifie si le mail existe dans la base
		while ($donnees = $req->fetch())
		{
			if ($donnees['mail']==$_POST['mdp_oubli'])
			{
				$existe=true;
				break;
			}
			
		}
		
		if($existe)
		{
			$req = $bdd->prepare('SELECT mdp, nom FROM table_u_profil WHERE mail = ? ');
			$req->execute(array($_POST['mdp_oubli']));
			$donnee = $req->fetch();
		
			$message_txt = "M/Mme ".$donnee['nom'].", Suite à la demande de récupération effectuée sur le site \"Outil evenement PS\", Voici le mot de passe associé à votre adresse mail : ".$donnee['mdp']." .";
			$message_html = "<html><head></head><body>M/Mme ".$donnee['nom'].",<br /><br /> Suite à la demande de récupération effectuée sur le site \"Outil evenement PS\", Voici le mot de passe associé à votre adresse mail :<br /><h2 class='sous_menu'>".$donnee['mdp']."</h2></body></html>";
			$sujet = "Recuperation de votre mot de passe";
			$adresse = $_POST["mdp_oubli"];

			Generation_mail($adresse,$sujet,$message_txt,$message_html);
			
			echo 'OK';
		}
		
		else
		{
			echo 'NOK';
		}
	}
	
	else if(!empty($_POST["deco"]))
	{
		session_destroy();
		echo 'OK';
	}

?>