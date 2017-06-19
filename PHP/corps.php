<div id="deco_auto_cadre" class="couverture Invisible">
	<div id="deco_auto"><em></em></div>
</div>

<!-- Affichage du logo du GCAP -->
<div class="bas_page" id="gauche">
	<img src = "Images/logo_GCAP.png" alt = "logo_GCAP" id="GCAP">
</div>

<!-- Bouton de contact (en cas d'erreur) -->
<div class="bas_page" id="droite">
	<a href="mailto:leonard.souffache@enedis.fr?subject=Retour utilisateur outil défaillance&cc=clement.huet@enedis.fr"><img src = "Images/retour.png" alt = "Retour" id="Retour"></a>
</div>

<!-- Affichage du bouton d'info -->
<div class="tooltip_info">
	<div id="triangle-1"></div>
		<p class="infos"> Infos </p>
		<span> 	Cet outil web est une <strong>ébauche</strong> d'un projet plus large de gestion de défaillance sur les postes sources. <br />
				Cette page vous présente les fonctionnalités suivantes :
			<ul>
				<li> </li>
				<li> </li>
				<li> </li>
			</ul>
		</span>
	<div id="triangle-2"></div>
</div>

<?php
	if((!empty($_SESSION["id_admin"])) || (!empty($_SESSION['id_profil'])))
	{	
		if(!empty($_SESSION["id_profil"]))
		{
			$req = $bdd->prepare('SELECT prenom, nom FROM table_u_profil WHERE id_profil = ?');			
			$req->execute(array($_SESSION["id_profil"]));
			$donnee = $req->fetch();
			$donnee = mb_strtoupper(substr($donnee[0], 0, 1).substr($donnee[1], 0, 1));
		}
		else if(!empty($_SESSION["id_admin"]))
		{
			$req = $bdd->prepare('SELECT mail FROM table_u_admin WHERE Id_admin = ?');			
			$req->execute(array($_SESSION["id_admin"]));
			$donnee = $req->fetch();
			$donnee = explode("@", $donnee['mail']);
			$donnee = explode(".", $donnee[0]);
			$donnee = mb_strtoupper(substr($donnee[0], 0, 1).substr($donnee[1], 0, 1));
		}
				
		$req->closeCursor();
		
		echo '<div class="tooltip_projet">';
			echo '<p class="compte">'.$donnee.'</p>';
			echo '<span> Cet outil web est une <strong>ébauche</strong> d\'un projet plus large de gestion de défaillance sur les postes sources. <br />
					Cette page vous présente les fonctionnalités suivantes :';
				echo '<ul>';
					echo '<li> </li>';
					echo '<li> </li>';
					echo '<li> </li>';
				echo '</ul>';
			echo '</span>';
		echo '</div>';
	}
?>

<!-- Affichage barre deco_auto -->
<div class="couverture" id="deco_auto_cadre" class="Invisible">
	<div id="deco_auto"><mark></mark></div>
</div>