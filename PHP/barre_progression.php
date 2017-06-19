<?php 

	function conversion_num_g($etat)
	{
		switch ($etat)
		{
			case 'En attente de traitement': 
				$etat=0;
			break;
			
			case 'En cours de traitement': 
				$etat=1;
			break;
			
			case 'Demande d\'information': 
				$etat=1;
			break;
			
			case 'Repondu,en attente de validation': 
				$etat=2;
			break;					
			
			case 'Valide': 
				$etat=3;
			break;
			
			default:
				$etat=-1;
		}
		return $etat;
	}
	
	function conversion_num_i($etat)
	{
		switch ($etat)
		{
			case 'En attente de traitement': 
				$etat=0;
			break;
			
			case 'En cours de traitement': 
				$etat=1;
			break;
			
			case 'Demande d\'information': 
				$etat=2;
			break;
			
			case 'Repondu,en attente de validation': 
				$etat=3;
			break;					
			
			case 'Valide': 
				$etat=3;
			break;
			
			default:
				$etat=-1;
		}
		return $etat;
	}

	function avancement_g($etat_reel, $etat_condition)
	{
		if(!empty($etat_reel))
		{		
			$etat_reel = conversion_num_g($etat_reel);
			$etat_condition = conversion_num_g($etat_condition);
		
			if($etat_reel>$etat_condition)
			{
				echo 'done';
			}
			
			if($etat_reel==$etat_condition)
			{
				echo 'active';
			}
		}		
	}
	
	function avancement_i($etat_reel, $etat_condition)
	{
		if(!empty($etat_reel))
		{		
			$etat_reel = conversion_num_i($etat_reel);
			$etat_condition = conversion_num_i($etat_condition);
		
			if($etat_reel>$etat_condition)
			{
				echo 'done';
			}
			
			if($etat_reel==$etat_condition)
			{
				echo 'active';
			}
		}		
	}

?>

<div class="container">
	<ul class="progressbar">
		<li class="<?php avancement_g($donnees['Etat'], 'En attente de traitement') ?>">En attente de traitement</li>
		<li class="<?php avancement_g($donnees['Etat'], 'En cours de traitement') ?>">En cours de traitement</li>
		<li class="<?php avancement_g($donnees['Etat'], 'Repondu,en attente de validation') ?>">Repondu, en attente de validation</li>
		<li class="<?php avancement_g($donnees['Etat'], 'Repondu,en attente de validation') ?>">Validé</li>
	</ul>
	<ul class="progressbar3">
		<li class="<?php avancement_i($donnees['Etat'], 'En cours de traitement') ?>">Informations en traitement</li>
		<li class="<?php avancement_i($donnees['Etat'], 'Demande d\'information') ?>">Demande d'information</li>
		<li class="<?php avancement_i($donnees['Etat'], 'Demande d\'information') ?>">Toutes informations fournies</li>
	</ul>
</div>