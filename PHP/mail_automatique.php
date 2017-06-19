<?php

	/*************************************************************************************************/
	// Fonction : Generation_mail
	// Finalités : générer un mail en php
	// Argument : @param unknown $adresses : mail du destinataire
	// Argument : @param unknown $sujet : sujet du mail
	// Argument : @param unknown $message_txt : message en format texte
	// Argument : @param unknown $message_html : message en format html
	/*************************************************************************************************/
	function Generation_mail($adresses, $sujet, $message_txt, $message_html)
	{
		// Déclaration des adresses de destination		
		if (is_array($adresses))
		{
			$mail = implode(',', $adresses); 
		}
		else
		{
			$mail = $adresses; 
		}
		
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		 
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========

		//=====Création du header de l'e-mail.
		$header = "From: \"Outil_evenement_PS\"<Outil_evenement_PS@enedis.fr>".$passage_ligne;
		$header.= "Reply-to: \"Outil_evenement_PS\" <Outil_evenement_PS@enedis.fr>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne;
		$header.= "charset: utf-8;".$passage_ligne;
		$header.= "boundary=\"$boundary\"".$passage_ligne;
		//==========

		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========

		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//==========	
	}

?>