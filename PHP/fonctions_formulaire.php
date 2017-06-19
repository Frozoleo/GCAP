<?php

	/*********************************************************************************************************************************/
	// Fonction : ConvertMySQLRequestToJavascriptArray Finalité : Convertir un table sql en tableau javascript associatif
	// Arguments : "$Resultat" -> informations extraites de la table sql "$Champs_Resultat" -> nom des colones de la table 
	// "$NomTableauJavaScript" -> nom du tableau javascript de sortie
	function traitement_enum($bdd, $nom_table, $nom_colone)
	{
		$enum= $bdd->prepare("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND COLUMN_NAME = ?");
		$enum->execute(array($nom_table, $nom_colone));
		$enum=$enum->fetch();
		$tab_enum= explode("','", $enum[0]);
		
		$tab_enum[0]=str_replace("enum(","",$tab_enum[0]);
		$tab_enum[0]=str_replace("'","",$tab_enum[0]);
		
		$index_fin=count($tab_enum)-1;
		$tab_enum[$index_fin]=str_replace(")","",$tab_enum[$index_fin]);
		$tab_enum[$index_fin]=str_replace("'","",$tab_enum[$index_fin]);
		
		return $tab_enum;
	}	
	
	function bouton_aide($message_aide)
	{
		echo '<div class="aide_hover">';
			echo '<img src="Images/aide.png" class="aide" alt="aide" />';
			echo '<span> '.$message_aide.' </span>';
		echo '</div>';
	}
	
	function informations_upload()
	{
		echo '<div id="info_upload">';
			echo '<p id="nom">Nom du fichier: <span></span></p>';
			echo '<p id="taille">Taille du fichier: <span></span></p>';
			echo '<p id="type">Type du fichier: <span></span></p>';
		echo '</div>';
	}
?>