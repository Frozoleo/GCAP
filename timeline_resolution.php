<?php include("PHP/session_bbd.php"); ?>
<?php include("PHP/concatenation_type.php"); ?>
<?php include("PHP/fonctions_formulaire.php"); ?>

<!--****************************************************************************************************************************************-->
<!--	Fichier : acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr						-->
<!--****************************************************************************************************************************************-->

<!DOCTYPE html>

<!--****************************************************************************************************************************************-->

<html>

	<!-- En-tête -->
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="CSS/timeline_resolution.css">
		<link rel="stylesheet" href="CSS/page.css" />
		<link rel="stylesheet" href="CSS/bouton_aide_triangulaire.css" />
		<link rel="stylesheet" href="CSS/barre_progression.css" />
		<link rel="stylesheet" href="CSS/formulaire_2.css" />
		<link rel="stylesheet" href="CSS/mise_en_page_OE.css" />
		<link rel="stylesheet" href="CSS/aide.css" />
		<link rel="stylesheet" href="CSS/dropzone.css" />
		<link rel="stylesheet" href="CSS/deco_auto.css" />
		<link rel="stylesheet" href="CSS/bouton_popup.css" />
		<link rel="stylesheet" href="CSS/message_information.css" />
		<title>Outil Événement Poste Source</title>
	</head>
	
	<!-- Corps -->
	<body id="accueil">
	
		<header class="classique">
		
			<h1 class="classique">Outil défaillance</h1>
			
		</header>
		
		<?php
			$req = $bdd->prepare('SELECT * FROM table_general WHERE Id_general = ?');
			$req->execute(array($_GET['Id']));
			$donnees = $req->fetch();
			$req->closeCursor();
		
			$req1 = $bdd->prepare('SELECT p.id_profil id_profil, p.nom nom_pro, p.prenom prenom_pro, p.ameps ameps_pro, p.acr acr_pro, p.mail mail_pro, p.tel tel_pro
								FROM table_general g INNER JOIN table_u_profil p ON p.id_profil = g.Id_G_region WHERE g.Id_general = ?');
			$req1->execute(array($_GET['Id']));
			
			$req_inter = $bdd->prepare('SELECT r.Id_expert1 Id_expert1 
								FROM table_general ge INNER JOIN table_u_responsabilite r ON r.Id_reponsabilite = ge.Id_G_reponsabilite WHERE ge.Id_general = ?');
			$req_inter->execute(array($_GET['Id']));
			$donnnes_inter = $req_inter->fetch();
			
			$req2 = $bdd->prepare('SELECT a.mail mail_gcap, a.tel tel_gcap 
								FROM table_u_responsabilite r INNER JOIN table_u_admin a ON a.Id_admin = r.Id_expert1 WHERE r.Id_expert1 = ?');
			$req2->execute(array($donnnes_inter['Id_expert1']));
			
			$donnnes1 = $req1->fetch();
			$donnnes2 = $req2->fetch();
			
			$prenom_GCAP =	explode('.', $donnnes2['mail_gcap']);
			$nom_GCAP =	explode('@', $prenom_GCAP[1]);
			$nom_GCAP = $nom_GCAP[0];
			$prenom_GCAP = $prenom_GCAP[0];
			
			$req1->closeCursor();
			$req2->closeCursor();
			$req_inter->closeCursor();
		?>
		
		<!--********************************************************************************************************************************-->
		<!-- Gestionnaire d'erreur ou d'information (affiche le rectangle gris en bas de l'écran) -->
		
		<?php		
			if(!empty($_GET['acceptation']))
			{
				switch ($_GET['acceptation'])
				{	
					case 1: 
						$message = '<em> Vous êtes maintenant responsable de cet événement </em>';
					break;
					
					case 0: 
						$message = '<em> '+$prenom_GCAP+' '+$nom_GCAP+' a été demandé comme responsable de cet événement </em>';
					break;
					
					case -1: 
						$message = '<em> Vous n\'avez pas renseigné l\'adresse du transfert </em>';
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
		
		<div id="info_message_top" class="<?php if(!empty($_GET['acceptation'])){echo "visible";}else{echo "invisible";}?>"><?php echo $message;?></div>				
		
		<!--********************************************************************************************************************************-->
		
		<span class="chargement" style="display: none;"><img src="Images/loader_circulaire.gif" alt="loading" /></span>			
		
		<?php include("PHP/corps.php"); ?>

		<div id="content">

			<ul class="timeline">
				<li class="event" id="information" data-date="12:30 - 1:00pm">
					<div class="after"></div>
					<h3>Formulation initiale de l'événement</h3>
					
					<?php include("PHP/barre_progression.php");?>
					
					<div class="form_timeline">
						<form class="form-style-5 form_timeline">
							<fieldset>
								<legend><span class="number">1</span> Responsable Région</legend>
									<ul>
										<li> M/Mme : <?php echo $donnnes1['prenom_pro'].' '.$donnnes1['nom_pro'];?></li>
										<li> AMEPS : <?php echo $donnnes1['ameps_pro'];?> | ACR : <?php echo $donnnes1['acr_pro'];?></li>
										<li> Mail : <?php echo $donnnes1['mail_pro'];?> | Tel : <?php echo $donnnes1['tel_pro'];?></li>
									</ul>
							</fieldset>						
						</form>
					
						<?php
							if($donnees['Etat']=='En cours de traitement')
							{
								echo '<form class="form-style-5 form_timeline">';
									echo '<fieldset >';
										echo '<legend><span class="number">2</span> Responsable GCAP</legend>';
										echo '<ul>';
											echo '<li> M. : '.$prenom_GCAP.' '.$nom_GCAP.'</li>';
											echo '<li> Mail : '.$donnnes2['mail_gcap'].'</li>';
											echo '<li> Tel : '.$donnnes2['tel_gcap'].'</li>';
										echo '</ul>';
									echo '</fieldset>';
								echo '</form>';
							}
						?>
					</div>
			
					<div class="corps resolution">			
						<table class="tableau_filtre" id="general">

							<!-- <caption>Défaillances existantes</caption> -->

							<thead> <!-- En-tête du tableau -->
								<tr>
									<th>N°</th>
									<th>Nom de l'événement</th>
									<th>Type d'événement</th>
									<th>Descriptif réduit</th>
									<th>Dernière modification</th>
									<th>Mots clés</th>
								</tr>
							</thead>

							<tbody> <!-- Corps du tableau -->
									
								<!-- Remplissage dynamique du corps du tableau avec les defaillances -->
								<?php	

									echo '<tr>';
									
										echo '<td>'.$donnees['Id_general'].'</td>';
										
										echo '<td>'.$donnees['Nom'].'</td>';
										
										echo '<td>'.concatenation_type($donnees).'</td>';
										
										echo '<td>'.$donnees['Description_synthetique'].'</td>';				
										
										echo '<td>'.$donnees['Date_derniere_modification'].'</td>';
										
										echo '<td>'.$donnees['Mots_cles'].'</td>';
										
									echo '</tr>';
								
								?>
									
							</tbody>
						   
						</table>
					</div>
										
					<form class="form-style-5 form_timeline" id="description">						
						<fieldset>
							<legend><span class="number">3</span> <strong>Description</strong> </legend>
								<p class="description"> <?php echo $donnees['Description'];?> </p>
						</fieldset>						
					</form>
				</li>
				
				<!-- champ contextuel à construire --> 
				
				<?php
				
					if((!empty($_SESSION["id_admin"])) && ($_SESSION["id_admin"]==$donnnes_inter['Id_expert1']) && ($donnees['Etat']=='En attente de traitement'))
					{
						echo '<li class="event" id="acceptation_GCAP" data-date="5:00 - 8:00pm">';
							echo '<div class="after"></div>';
							echo '<div class="conteneur n1">';
							
								echo '<div class="validation_GCAP" id="validation_GCAP">';
									echo '<form method="post" action="traitement_timeline.php" class="form-style-5 sous_conteneur">';
										echo '<div class="sous_conteneur">';
											echo '<input class="camoufler" type="submit" />';
											echo '<input type="hidden" name="validation" value="1"/>';
											echo '<input type="hidden" name="Identifiant" value="'.$_GET['Id'].'"/>';
											echo '<div class="after valider"></div>';
											echo '<h3>Accepter</h3>';
										echo '</div>';
									echo '</form>';
								echo '</div>';
								
								echo '<div class="validation_GCAP">';																
									echo '<form method="post" action="traitement_timeline.php" class="form-style-5 sous_conteneur">';
																			
										echo '<div class="sous_conteneur">';
											echo '<input class="camoufler" type="submit" />';
											echo '<input type="hidden" name="validation" value="0"/>';
											echo '<input type="hidden" name="Identifiant" value="'.$_GET['Id'].'"/>';
											echo '<div class="after transfert"></div>';
											echo '<h3>Transférer</h3>';	
										echo '</div>';
										echo '<div>';
											echo '<label class="fleche">';
												echo '<select name="transfert" class="transfert" id="transfert" required>';
													echo '<option value="-1">Adresse mail du transfert *</option>';
													
													$enum_mail = traitement_enum($bdd, 'table_u_admin', 'mail');
													$index=count($enum_mail);									
							
													for ($i = 0; $i < $index; $i++)
													{									
														echo '<option value="'.($i+1).'">'.$enum_mail[$i].'</option>';
													}												
												echo '</select>';
											echo '</label>';
										echo '</div>';
										
									echo '</form>';									
								echo '</div>';
								
							echo '</div>';							
						echo '</li>';
					}
				
					if((!empty($_SESSION["id_admin"])) && ($_SESSION["id_admin"]==$donnnes_inter['Id_expert1']) && ($donnees['Etat']=='En cours de traitement'))
					{
						echo '<li class="event" id="demande_information" data-date="2:30 - 4:00pm">';
							echo '<div class="after"></div>';
							echo '<h3 class="Visible">Ajouter une demande d\'information</h3>';
							echo '<form class="form-style-5 accueil Invisible">';
								echo '<fieldset>';
									
									echo '<label class="ajouter" for="Onglet"><div class="after"></div><input type="text" name="Onglet" pattern="^[a-zA-Z0-9]{1,20}$" placeholder="Nom de l\'onglet *" readonly ></label>';
									echo '<label class="ajouter" for="Question"><div class="after"></div><input type="text" name="Question" pattern="^[a-zA-Z0-9]{1,20}$" placeholder="Nom du champ ou question *" readonly >';
										echo '<label class="fleche">';
											echo '<select name="champs" id="champs" readonly >';
												echo '<option value="-1">Type du champ *</option>';
												echo '<option value="text_mono">zone de texte monoligne</option>';
												echo '<option value="text_mult">zone de texte multiligne</option>';
												echo '<option value="nombre">nombre</option>';
												echo '<option value="liste">liste déroulante (préciser)</option>';
											echo '</select>';
										echo '</label>';
										echo '<input type="text" name="Aide" pattern="^[a-zA-Z0-9]{1,20}$" placeholder="texte du bouton d\'aide *" readonly >';
									echo '</label>';
									
									
									
								echo '</fieldset>';
							echo '</form>';							
						echo '</li>';

						echo '<li class="event" id="Reponse_GCAP" data-date="5:00 - 8:00pm">';
							echo '<div class="after"></div>';
							echo '<h3 class="Visible">Apporter une réponse</h3>';
							
							echo '<div class="Invisible spec">';
								echo '<form class="form-style-5 accueil Visible" onsubmit="creation_compte();">';
									echo '<div class="form">';
										echo '<fieldset>';
											
											echo '<input type="text" name="Onglet" pattern="^[a-zA-Z0-9]{1,20}$" placeholder="Titre de la réponse (facultatif) *" >';
											echo '<textarea name="description" id="description" placeholder="Votre réponse (ou résumé de celle-ci) *" required ></textarea>';

										echo '</fieldset>';
									echo '</div>';
								echo '</form>';	
								
								echo '<form action="upload.php" class="dropzone" id="dropzone_timeline"></form>';
							echo '</div>';
							
						echo '</li>';
					}
					
					//<input type="text" name="Reference" pattern="^[a-zA-Z0-9]{1,20}$" placeholder="Référence du matériel *" required>
					//<input type="number" name="Age" pattern="^[0-9]{2}$" placeholder="Age du matériel *" required>					
					//<textarea class="Invisible dynamique2" name="description" id="description" placeholder="Veuillez décrire le lieu d'action de l'évenement *" required ></textarea>				
				?>
				
				<?php					
					if((!empty($_SESSION["id_profil"])) && ($_SESSION["id_profil"]==$donnnes1['id_profil']) && ($donnees['Etat']=='Repondu,en attente de validation'))
					{
						echo '<li class="event" id="validation_AMEPS"data-date="8:30 - 9:30pm">';
							echo '<div class="after"></div>';
							echo '<div class="conteneur n2">';
								echo '<div class="validation_AMEPS" onclick="traitement_timeline.php?valide_AMEPS=true;">';
									echo '<div class="after valider"></div>';
									echo '<h3>Valider</h3>';
								echo '</div>';
								echo '<div class="validation_AMEPS" onclick="traitement_timeline.php?valide_AMEPS=false;">';
									echo '<div class="after invalider"></div>';
									echo '<h3>Invalider</h3>';
								echo '</div>';
							echo '</div>';
							echo '<form class="form-style-5 accueil Invisible" onsubmit="creation_compte();">';
								echo '<div class="form">';
									echo '<fieldset>';
										echo '<textarea name="description" id="description" placeholder="Expliquez *" required ></textarea>';
									echo '</fieldset>';
								echo '</div>';
							echo '</form>';
						echo '</li>';
					}
					
					if((!empty($_SESSION["id_admin"])) && ($_SESSION["id_admin"]==$donnnes_inter['Id_expert1']) && ($donnees['Etat']=='Valide'))
					{
						echo '<li class="event" id="Renseignements_finaux" data-date="5:00 - 8:00pm">';
							echo '<div class="after"></div>';
							echo '<h3 class="Visible">Finaliser l\'évenement</h3>';
							echo '<form method="post" action="traitement_timeline.php" class="form-style-5 accueil Invisible" enctype="multipart/form-data">';
								echo '<div class="form">';
														
									echo '<fieldset>';
									
										echo '<label class="classique" for="type_materiel_PCCN">Veuillez renseigner les derniers éléments utiles à la recherche:</label>';																												
										echo '<textarea name="Description_synthetique" placeholder="Description synthetique de l\'événement *" required ></textarea>';
										echo '<input type="text" name="Mots_cles" pattern="<?php echo regex_classique;?>" placeholder="Mots clés *" required/>';
						
										echo '<label class="classique" for="type_materiel_PCCN">Veuillez corriger le nom afin qu\'il soit plus évocateur:</label>';																			
										echo '<input type="text" name="Nom" pattern="<?php echo regex_classique;?>" placeholder="Nouveau nom *" required/>';
										
										echo '<input type="submit" value="Valider & Envoyer" />';
										
									echo '</fieldset>';
									
								echo '</div>';					
							echo '</form>';
							
						echo '</li>';
					}
					
				?>
			</ul>
			
		</div>
		
		<!--********************************************************************************************************************************-->
		<!-- Fonctions de traitement et d'affichage javascript -->		
						
		<script src="tablefilter/tablefilter.js"></script>
		<script src="JS/fonctions_AJAX.js"></script>
		<script src="JS/fonctions_js.js"></script>
		<script src="JS/timeline_resolution.js"></script>
		<script src="JS/deco_auto.js"></script>
		<script src="JS/dropzone.js"></script>
				
	</body>

</html>

<!--
echo '<li class="event" id="demande_information" data-date="2:30 - 4:00pm">';						
							echo '<h3 class="Visible">Ajouter une demande d\'information</h3>';							
							echo '<form class="form-style-5 accueil Invisible" onsubmit="creation_compte();">';
								echo '<div class="champ3">';
									echo '<fieldset>';
										echo '<legend>Informations générales</legend>';
										echo '<input type="text" name="nom" pattern="echo regex_nom_prenom;" placeholder="Votre Nom *" required/>';
										echo '<input type="text" name="prenom" pattern="echo regex_nom_prenom;" placeholder="Votre Prénom *" required/>';
										echo '<input type="text" name="ameps" pattern="echo regex_acr_ameps;" placeholder="Votre AMEPS *" required/>';
										echo '<input type="text" name="acr" pattern="echo regex_acr_ameps;" placeholder="Votre ACR *" required/>';
										
										
										echo '<legend>Mot de passe</legend>';
										
										
										echo '<input type="submit" value="Valider"/>';
									echo '</fieldset>';
								echo '</div>';
							echo '</form>';							
						echo '</li>';
-->