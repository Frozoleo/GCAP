<?php 
	include("PHP/session_bbd.php"); 
	include("PHP/concatenation_type.php");
	include("PHP/regex.php");
?>

<!--****************************************************************************************************************************************-->
<!--	Fichier : acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr						-->
<!--****************************************************************************************************************************************-->

<!DOCTYPE html>

<!--****************************************************************************************************************************************-->

<html>

	<!-- En-tête -->
	<head>
		<meta charset="utf8" />
		<?php include("header_OE.php"); ?>
	</head>
	
	<!-- Corps -->
	<body id="accueil">
	
		<header class="classique">
		
			<h1 class="classique">Outil Événement Poste Source</h1>
			
		</header>
		
		<!--********************************************************************************************************************************-->
		<!-- Gestionnaire d'erreur ou d'information (affiche le rectangle gris en bas de l'écran) -->
		
		<?php		
			if(!empty($_GET['validation']))
			{
				switch ($_GET['validation'])
				{	
					case 1: 
						$message = '<em> Le formulaire a été correctement renseigné, la defaillance vient d\'étre alertée au GCAP </em>';
					break;
					
					case 2: 
						$message = '<em> Vous venez d\'accepter la prise en charge de la défaillance </em>';
					break;
					
					default:
						$message = '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
				}				
			}
			else
			{
				$message = '<em></em>';
			}
		?>	
		
		<div id="info_message_top" class="<?php if(!empty($_GET['validation'])){echo "visible";}else{echo "invisible";}?>"><?php echo $message;?></div>				
		
		<!--********************************************************************************************************************************-->
		
		<?php include("PHP/corps.php"); ?>
					
		<div class="couverture" id="account">
			<div class="popup_block">
				<a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="fermer" src="Images/fermer.png" onmouseover="this.src='Images/fermer_hover.png'" onmouseout="this.src='Images/fermer.png'"></a>
				<span class="chargement accueil" style="display: none;"><img src="Images/loader_rectiligne.gif" alt="loading" WIDTH='120%' /></span>

				<form class="form-style-5 accueil" onsubmit="connexion_compte(); return false;">
					<div class="champ3">
						<fieldset>
							<legend>Champs à renseigner</legend>
							<input type="email" name="mail" pattern="<?php echo regex_mail;?>" placeholder="Adresse email *" required/>
							<input type="password" name="mdp_save" pattern="<?php echo regex_mdp;?>" placeholder="Mot de passe *" required/>
							<a href="#" onclick="mdp_oubli(); return false;">Mot de passe oublié</a>
							
							<input type="submit" value="Valider"/>
						</fieldset>
					</div>
				</form>
				
			</div>
		</div>
		
		<div class="couverture" id="new_account">
			<div class="popup_block">
				<a class="close" href="#noWhere"><img alt="Fermer" title="Fermer la fenêtre" class="fermer" src="Images/fermer.png" onmouseover="this.src='Images/fermer_hover.png'" onmouseout="this.src='Images/fermer.png'"></a>
				<span class="chargement accueil" style="display: none;"><img src="Images/loader_rectiligne.gif" alt="loading" /></span>

				<form class="form-style-5 accueil" onsubmit="creation_compte(); return false;">
					<div class="champ3">
						<fieldset>
							<legend>Informations générales</legend>
							<input type="text" name="nom" pattern="<?php echo regex_nom_prenom;?>" placeholder="Votre Nom *" required/>
							<input type="text" name="prenom" pattern="<?php echo regex_nom_prenom;?>" placeholder="Votre Prénom *" required/>
							<input type="text" name="ameps" pattern="<?php echo regex_acr_ameps;?>" placeholder="Votre AMEPS *" required/>
							<input type="text" name="acr" pattern="<?php echo regex_acr_ameps;?>" placeholder="Votre ACR *" required/>
							<input type="email" name="mail" pattern="<?php echo regex_mail;?>" placeholder="Adresse email *" required/>
							<input type="tel" name="tel" pattern="<?php echo regex_tel;?>" placeholder="Numéro de téléphone *" required/>
							
							<legend>Mot de passe</legend>
							<input type="password" name="mdp" pattern="<?php echo regex_mdp;?>" placeholder="Mot de passe *" required title="Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et doit faire au moins 10 caractères."/> 
							
							<input type="submit" value="Valider"/>
						</fieldset>
					</div>
				</form>
				
			</div>
		</div>

		
		
		<div class="corps">
		
			<!--********************************************************************************************************************************-->
			
			<!--***********************************************-->
			<div class="sous_menu gauche n1">
				<h2 class="sous_menu"> Compte </h2>
				<div class="liste">
					<a href="#account" class="traits">
						<div class="element_menu">
							<span> <img src = "Images/connexion.png" alt = "connexion"> </span>
							<span>Se connecter</span>
						</div>
					</a>
					<?php
					if((!empty($_SESSION["id_admin"])) || (!empty($_SESSION['id_profil'])))
					{
						echo '<a href="#null" class="traits" onclick="return false;">';
							echo '<div class="element_menu">';
								echo '<span> <img src = "Images/deconnexion.png" alt = "deconnexion"> </span>';
								echo '<span>Se Deconnecter</span>';
							echo '</div>';
							echo '<input type="hidden" name="deco" value="1"/>';
							echo '<input type="hidden" name="deco" value="1"/>';
						echo '</a>';
					}
					?>
					<a href="#new_account" class="traits">
						<div class="element_menu"> 
							<span> <img src = "Images/new_account.png" alt = "nouveau_compte"> </span>
							<span>S'inscrire</span>
						</div>
					</a>
				</div>
			</div>
			
			<!--***********************************************-->
			<div class="sous_menu droite n1">
				<div class="liste">
					<a href="#" class="traits" onclick="window.open('formulaire.php?'); return false;">
						<div class="element_menu">
							<span> <img src = "Images/plus.png" alt = "account"> </span>
							<span>Ajouter un évenement</span>
						</div>
					</a>
				</div>
			</div>
			
			<div class="sous_menu droite n2">
				<div class="liste">
					<a href="#" class="traits" onclick="window.open('dropzone.php?'); return false;">
						<div class="element_menu">
							<span> <img src = "Images/plus.png" alt = "account"> </span>
							<span>Déposer des piéces jointes</span>
						</div>
					</a>
				</div>
			</div>
			
			<?php	
			
				if((!empty($_SESSION["id_admin"])) || (!empty($_SESSION['id_profil'])))
				{																					
					echo '<table class="tableau_filtre" id="personnel">';

						echo '<thead>';
							echo '<tr>';
								echo '<th>N°</th>';
								echo '<th>Nom de l\'événement</th>';
								echo '<th>Type d\'événement</th>';
								echo '<th>Descriptif réduit</th>';
								echo '<th>État d\'avancement</th>';
								echo '<th>Dernière modification</th>';
								echo '<th>Mots clés</th>';
							echo '</tr>';
						echo '</thead>';

						echo '<tbody> ';

						if(!empty($_SESSION["id_profil"]))
						{
							$req = $bdd->prepare('SELECT g.Id_general Id_general, g.Nom Nom, g.Type Type, g.Sous_type sous_type, g.Description_synthetique Description_synthetique, g.Etat Etat, g.Date_derniere_modification Date_derniere_modification, g.Mots_cles Mots_cles 
													FROM table_general g INNER JOIN table_u_profil p ON p.id_profil = g.Id_G_region WHERE p.id_profil = ?');
							$req->execute(array($_SESSION["id_profil"]));
							
							while ($donnees = $req->fetch())
							{
								echo '<tr onclick=window.open("timeline_resolution.php?Id='.$donnees["Id_general"].'");>';																	

									echo '<td>'.$donnees['Id_general'].'</td>';
									
									echo '<td>'.$donnees['Nom'].'</td>';
									
									echo '<td>'.concatenation_type($donnees).'</td>';
									
									echo '<td>'.$donnees['Description_synthetique'].'</td>';
									
									echo '<td class="etat_js">'.$donnees['Etat'].'</td>';
									
									echo '<td>'.$donnees['Date_derniere_modification'].'</td>';
									
									echo '<td>'.$donnees['Mots_cles'].'</td>';
									
								echo '</tr>';
							
							}
						}
						else if(!empty($_SESSION["id_admin"]))
						{
							$req_inter = $bdd->prepare('SELECT r.Id_reponsabilite Id_reponsabilite 
												FROM table_u_responsabilite r INNER JOIN table_u_admin a ON a.Id_admin = r.Id_expert1 WHERE a.Id_admin = ?');
							$req_inter->execute(array($_SESSION["id_admin"]));
							
							while ($donnnes_inter = $req_inter->fetch())
							{								
								$req = $bdd->prepare('SELECT ge.Id_general Id_general, ge.Nom Nom, ge.Type Type, ge.Sous_type Sous_type, ge.Description_synthetique Description_synthetique, ge.Etat Etat, ge.Date_derniere_modification Date_derniere_modification, ge.Mots_cles Mots_cles 
															FROM table_general ge INNER JOIN table_u_responsabilite r ON r.Id_reponsabilite = ge.Id_G_reponsabilite WHERE r.Id_reponsabilite = ?');
								$req->execute(array($donnnes_inter['Id_reponsabilite']));
								
								while ($donnees = $req->fetch())
								{
									echo '<tr onclick=window.open("timeline_resolution.php?Id='.$donnees["Id_general"].'");>';																	

										echo '<td>'.$donnees['Id_general'].'</td>';
										
										echo '<td>'.$donnees['Nom'].'</td>';
										
										echo '<td>'.concatenation_type($donnees).'</td>';
										
										echo '<td>'.$donnees['Description_synthetique'].'</td>';
										
										echo '<td class="etat_js">'.$donnees['Etat'].'</td>';
										
										echo '<td>'.$donnees['Date_derniere_modification'].'</td>';
										
										echo '<td>'.$donnees['Mots_cles'].'</td>';
										
									echo '</tr>';
								}
							}
							
							$req_inter->closeCursor();
						}		

						$req->closeCursor();
								
						echo '</tbody>';
					   
					echo '</table>';
					
					echo '<div class="separateur">';
						echo '<hr>';
					echo '</div>';
				}
				
			?>
		
			<table class="tableau_filtre" id="general">

				<!-- <caption>Défaillances existantes</caption> -->

				<thead> <!-- En-tête du tableau -->
					<tr>
						<th>N°</th>
						<th>Nom de l'événement</th>
						<th>Type d'événement</th>
						<th>Descriptif réduit</th>
						<th>État d'avancement</th>
						<th>Dernière modification</th>
						<th>Mots clés</th>
					</tr>
				</thead>

				<tbody> <!-- Corps du tableau -->
						
					<!-- Remplissage dynamique du corps du tableau avec les defaillances -->
					<?php
						
						$storeFolder = 'uploads';
						$ds          = DIRECTORY_SEPARATOR;								
						
						$req = $bdd->query('SELECT * FROM table_general ORDER BY Id_general ASC');							

						while ($donnees = $req->fetch())
						{
							echo '<tr onclick=window.open("timeline_resolution.php?Id='.$donnees["Id_general"].'");>';
							
								/*if($donnees['Pieces_jointes']=='present')
								{
									$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds . $donnees['Nom_defaillance'] . $ds;
									$targetPath = 'file:///'.$targetPath;
									echo '<td class="text_left piece_jointe"><a href="'.$targetPath.'" title="Cliquez pour accéder aux pièces jointes">'.$donnees['Nom_defaillance'].'</a></td>';
								}
								
								else
								{
									echo '<td class="text_left">'.$donnees['Nom_defaillance'].'</td>';
								}	*/		

								echo '<td>'.$donnees['Id_general'].'</td>';
								
								echo '<td>'.$donnees['Nom'].'</td>';
								
								echo '<td>'.concatenation_type($donnees).'</td>';
								
								echo '<td>'.$donnees['Description_synthetique'].'</td>';
								
								echo '<td class="etat_js">'.$donnees['Etat'].'</td>';
								
								echo '<td>'.$donnees['Date_derniere_modification'].'</td>';
								
								echo '<td>'.$donnees['Mots_cles'].'</td>';
								
							echo '</tr>';
						
						}

						$req->closeCursor();

					?>
						
				</tbody>
			   
			</table>
		
		</div>
		
		<!--********************************************************************************************************************************-->
		<!-- Cache le rectangle au bout de 6 secondes -->
		
		<?php
			if((!empty($_GET["filtre"])) && (!empty($_GET["pers"])))
			{
				echo '<div class="bouton_vertical">';
					echo '<input type="button" class="button type1" value="Prendre en charge" name="valider_charge" onclick="window.open(\'traitement_formulaire.php?filtre=5489&pers='.$_GET["pers"].'&Nom_defaillance='.$_GET["filtre"].'\');" />';
				echo '</div>';
			}
		?>
		
		<script src="tablefilter/tablefilter.js"></script>
		<script src="JS/fonctions_AJAX.js"></script>
		<script src="JS/fonctions_js.js"></script>
		<script src="JS/deco_auto.js"></script>
		<script src="JS/accueil.js"></script>
		
	</body>

</html>