<?php 
	include("PHP/session_bbd.php");
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
	<body id="accueil" class="index">
	
		<header class="classique">
		
			<h1 class="classique">Outil Événement Poste Source</h1>
			
		</header>
			
		<!--********************************************************************************************************************************-->
		
		<?php include("PHP/corps.php"); ?>
		
		<form action="dropzone_upload.php" class="dropzone" id="dropzone"></form>
		
		<footer class="classique" onclick="window.close();">
		
			<h2 class="classique">Quitter la page</h1>
		
		</footer>
		
		<!--********************************************************************************************************************************-->
		<!-- Fonctions de traitement et d'affichage javascript -->

		<script src="JS/deco_auto.js"></script>
		<script src="JS/dropzone.js"></script>
		
	</body>

</html>