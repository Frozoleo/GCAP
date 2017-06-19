<?php include("PHP/session_bbd.php"); ?>

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
		
			<h1 class="classique">Outil défaillance</h1>
			
		</header>
		
		<!--********************************************************************************************************************************-->
		<!-- Gestionnaire d'erreur ou d'information (affiche le rectangle gris en bas de l'écran) -->
		<?php
		
			if(!empty($_GET['num_erreur'])) 
			{
				echo '<div id="info_message_top" class="visible">';
				switch ($_GET['num_erreur']) 
				{	
					case 1: 
						echo '<mark> Le nom fourni pour votre defaillance est déjà utilisé </mark>';
					break;
					
					default:
						echo '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
				}
				echo '</div>';
			}

		?>
		
		<!--********************************************************************************************************************************-->
		
		<?php include("PHP/corps.php"); ?>
		<?php include("PHP/fonctions_formulaire.php"); ?>
				
		<!--********************************************************************************************************************************-->
		<!-- Gestionnaire d'erreur ou d'information (affiche le rectangle gris en bas de l'écran) -->
		
		
			<form method="post" action="traitement_formulaire.php" class="form-style-5" enctype="multipart/form-data">
				<div class="form">
					
					<?php
						if(!empty($_SESSION['id_profil']))
						{
							$req = $bdd->prepare('SELECT * FROM table_profil WHERE id_profil = ?');
							$req->execute(array($_SESSION['id_profil']));
							$donnnes = $req->fetch();
							
							$req->closeCursor();
						}
					?>
			
					<fieldset>
						<legend><span class="number">1</span> Informations générales</legend>
						<input type="text" name="nom" pattern="<?php echo regex_nom_prenom;?>" value="<?php if(!empty($donnnes['nom'])){echo $donnnes['nom'];}?>" placeholder="Votre Nom *" <?php if(!empty($donnnes['nom'])){echo 'disabled';} ?> required />
						<input type="text" name="prenom" pattern="<?php echo regex_nom_prenom;?>" value="<?php if(!empty($donnnes['prenom'])){echo $donnnes['prenom'];}?>" placeholder="Votre Prénom *" <?php if(!empty($donnnes['prenom'])){echo 'disabled';} ?>required />	
						<input type="text" name="ameps" pattern="<?php echo regex_acr_ameps;?>" value="<?php if(!empty($donnnes['ameps'])){echo $donnnes['ameps'];}?>" placeholder="Votre AMEPS *"<?php if(!empty($donnnes['ameps'])){echo 'disabled';} ?> required />
						<input type="text" name="acr" pattern="<?php echo regex_acr_ameps;?>" value="<?php if(!empty($donnnes['acr'])){echo $donnnes['acr'];}?>" placeholder="Votre ACR *"<?php if(!empty($donnnes['acr'])){echo 'disabled';} ?> required />
						<input type="email" name="mail" pattern="<?php echo regex_mail;?>" value="<?php if(!empty($donnnes['mail'])){echo $donnnes['mail'];}?>" placeholder="Adresse email *" <?php if(!empty($donnnes['mail'])){echo 'disabled';} ?> required />
						<input type="tel" name="tel" pattern="<?php echo regex_tel;?>" value="<?php if(!empty($donnnes['tel'])){echo $donnnes['tel'];}?>" placeholder="Numéro de téléphone *" <?php if(!empty($donnnes['tel'])){echo 'disabled';} ?> required />
					</fieldset>
					
					<fieldset>
						<legend><span class="number">2</span> Definition de l'evenement</legend>
						
						<label class="classique" for="domaine">L'événement concerne :</label>
						<label class="fleche">
							<select name="domaine" id="domaine" required>
								<option value="-1">Veuillez faire un choix *</option>
								<option value="materiel">un matériel précis</option>
								<option value="PS">l'ensemble d'un poste source</option>
								<option value="autre">autre (préciser)</option>
							</select>
							<?php
								bouton_aide("Cet outil web est une <strong>ébauche</strong> d'un projet plus large de gestion de défaillance sur les postes sources. <br /> Cette page vous présente les fonctionnalités suivantes :<ul><li> </li><li> </li><li> </li></ul>");
							?>
						</label>
						
						<!--************************************************-->
						<div class="domaine">
							<!--************************************************-->
							<div class="Invisible dynamique1" id="materiel">
								<label class="classique" for="materiel">Le matériel est-il :</label>
								<label class="fleche">
									<select name="materiel" id="materiel" class="rang1">
										<option value="-1">Veuillez faire un choix *</option>
										<option value="in_PS">dans un poste source (PCCN, PAGC)</option>
										<option value="out_PS">hors d'un poste source (PAPC)</option>
										<option value="autre">autre (préciser)</option>
									</select>
									<?php
										bouton_aide("aide");
									?>
								</label>
								
								<!--************************************************-->
								
								<div class="materiel">						
									<div class="Invisible dynamique2" id="in_PS">
									
										<input type="text" name="Nom_Poste" class="rang2" id="Nom_Poste" pattern="<?php echo regex_classique;?>" placeholder="Nom du poste *">
										<label class="classique" for="Palier_technique">Le poste est un :</label>
										<label class="fleche">
											<select name="Palier_technique" class="rang2" id="Palier_technique">
												<option value='-1'>Palier technique *</option>
												<?php
												
													$enum_palier = traitement_enum($bdd, 'table_f_in_ps', 'Palier_technique');
													$index=count($enum_palier);
													$mem=true;
													
													echo '<optgroup label="Poste asservi">';
											
													for ($i = 0; $i < $index; $i++)
													{
														if((strstr($enum_palier[$i],'PCCN')) && ($mem))
														{
															echo '<optgroup label="PCCN">';
															$mem=!$mem;
														}									
														echo '<option value="'.$enum_palier[$i].'">'.$enum_palier[$i].'</option>';
													}
												?>															
											</select>
										</label>
										
										<div class="Invisible" id="materiel_plus">
											<label class="classique" for="type_materiel_PCCN">Il s'agit :</label>
											<label class="fleche Invisible dynamique3" id="PCCN">
												<select name="type_materiel_PCCN" class="rang4" id="type_materiel_PCCN"> 
										
													<option value="-1">Type du materiel *</option>
													
													<?php
													
														$enum_materiel = traitement_enum($bdd, 'table_f_in_ps', 'Type_materiel');
														
														for ($i = 0; $i < 6; $i++)
														{
															echo '<option value="'.$enum_materiel[$i].'">'.$enum_materiel[$i].'</option>';
														}

													?>
												
												</select>
											</label>
											<label class="fleche Invisible dynamique3" id="PAGC">
												<select name="type_materiel_PAGC" class="rang4" id="type_materiel_PAGC"> 
										
													<option value="-1">Type du materiel *</option>
													
													<?php
													
														$enum_materiel = traitement_enum($bdd, 'table_f_in_ps', 'Type_materiel');
														$index=count($enum_materiel);

														for ($i = 6; $i < $index; $i++)
														{
															echo '<option value="'.$enum_materiel[$i].'">'.$enum_materiel[$i].'</option>';
														}	

													?>
												
												</select>
											</label>
											
											<div class="Invisible" id="special_EPC3200">
												<label class="classique" for="UC">Il s'agit :</label>
												<label class="fleche">
													<select name="UC" class="rang5" id="UC"> 
											
														<option value="-1">Unité Centrale *</option>
														
														<?php
														
															$enum_UC = traitement_enum($bdd, 'table_f_in_ps', 'UC');
															$index=count($enum_UC);
															
															for ($i = 0; $i < index; $i++)
															{
																echo '<option value="'.$enum_UC[$i].'">'.$enum_UC[$i].'</option>';
															}

														?>
													
													</select>
												</label>
											</div>
											
											<label class="fleche">
												<select name="Constructeur" class="rang3">							
													<option value="-1">Constructeur du matériel *</option>												
													<?php
													
														$enum_constructeur = traitement_enum($bdd, 'table_f_in_ps', 'Constructeur');	
														$index=count($enum_constructeur);
														
														for ($i = 0; $i < $index; $i++)
														{
															echo '<option value="'.$enum_constructeur[$i].'">'.$enum_constructeur[$i].'</option>';
														}
													
													?>											
												</select>	
											</label>										
				
											<input type="text" name="Reference" class="rang3" pattern="<?php echo regex_reference;?>" placeholder="Référence du matériel *">
											<input type="number" name="Age" class="rang3" pattern="<?php echo regex_age;?>" placeholder="Age du matériel *">
											
											<input type="text" name="version_materielle" class="rang3" pattern="<?php echo regex_materiel_logiciel;?>" placeholder="Version materielle *">
											<input type="text" name="version_logicielle" class="rang3" pattern="<?php echo regex_materiel_logiciel;?>" placeholder="Version logicielle *">
										</div>
										
									</div>
									
									<div class="Invisible dynamique2" id="out_PS">
										<label class="classique" for="out_PS">Type de PAPC :</label>
										<label class="fleche">
											<select name="out_PS" class="rang2" id="out_PS">
												<option value="-1">Type de PAPC *</option>
												<option value="Compteur">Compteur</option>
												<option value="OMT">OMT</option>
												<option value="DEIE">DEIE</option>
												<option value="autre">autre (préciser)</option>
											</select>
											<?php
												bouton_aide("aide");
											?>
										</label>
										
										<input type="text" name="nom_PAPC" class="rang2" pattern="<?php echo regex_classique;?>" placeholder="Nom du matériel PAPC *">
										<input type="text" name="nom_configuration" class="rang2" pattern="<?php echo regex_classique;?>" placeholder="Nom de configration Poste Source *">
										
									</div>
									
									<textarea class="Invisible dynamique2" name="description" class="rang2" id="description" placeholder="Veuillez décrire le lieu d'action de l'événement *" ></textarea>
								</div>
								
								<!--************************************************-->
							</div>
							
							<!--************************************************-->							
							<div class="Invisible dynamique1" id="PS">
								<label class="classique" for="PS">L'anomalie est d'ordre :</label>
								<label class="fleche">
									<select name="PS" id="PS" class="rang1">
										<option value="-1">Veuillez faire un choix *</option>
										<option value="materielle">matérielle</option>
										<option value="logicielle">logicielle</option>
										<option value="autre">autre ou inconnu (préciser)</option>
									</select>
									<?php
										bouton_aide("aide");
									?>
								</label>
								
								<!--************************************************-->
								
								<div class="PS">
									<div class="Invisible dynamique2" id="materielle">						
										<label class="classique" for="file">Icône du fichier (JPG, PNG ou GIF | max. 15 Ko) :</label>
										<div class="cadre_upload">
											<label class="file" for="fichier">Parcourir</label>
											<input type="file" name="fichier" class="rang2" id="fichier" onchange="informations_upload(this);" multiple/>
										</div>
										<?php informations_upload(); ?>							
									</div>
									
									<div class="Invisible dynamique2" id="logicielle">
									</div>
								</div>
								
								<!--************************************************-->
								
							</div>

							<!--************************************************-->	
							<textarea class="Invisible dynamique1 rang1" name="description" class="rang1" id="description" placeholder="Veuillez décrire la cadre de l'événement *" ></textarea>
						</div>
						
						<!--************************************************-->		
						
					</fieldset>

					<fieldset>
						<legend id="descriptif"><span class="number">3</span>Description de l'evenement</legend>
						<input type="text" name="Nom_defaillance" pattern="<?php echo regex_classique;?>" placeholder="Donner un nom à l'événement *" required/>
						<textarea name="Description" placeholder="Description formelle de l'événement *" required ></textarea>
					</fieldset>
					
					<input type="submit" value="Valider & Envoyer" />
							
				</div>
						
			</form>
		
		<!--********************************************************************************************************************************-->
		<!-- Fonctions de traitement et d'affichage javascript -->		
						
		<script src="JS/message_information.js"></script>
		<script src="JS/deco_auto.js"></script>
		<script src="JS/formulaire.js"></script>
		<script src="JS/dropzone.js"></script>
				
	</body>

</html>