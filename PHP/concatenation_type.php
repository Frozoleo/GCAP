<?php 
	function concatenation_type ($donnees)
	{
		switch ($donnees['Type'].'.'.$donnees['Sous_type']) 
		{	
			case 'materiel.in_PS': 
				$type='Contrôle commande Poste source';														
			break;
			
			case 'materiel.out_PS': 
				$type='Contrôle commande hors Poste source';
			break;
			
			case 'materiel.autre': 
				$type='Contrôle commande autre';
			break;
			
			case 'PS.materielle': 
				$type='Poste source général';														
			break;
			
			case 'PS.logicielle': 
				$type='Poste Source configuration';
			break;
			
			case 'PS.autre': 
				$type='Poste Source autre';
			break;
			
			case 'autre.': 
				$type='autre';
			break;
			
			default:
				echo '<mark> Une erreur s\'est prorduite lors d\'un traitement </mark>';
			break;
		}
		return $type;
	}
?>