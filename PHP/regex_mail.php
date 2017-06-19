<?php
	function regex_mail_admin($bdd, $mail)
	{
		$enum_mail = traitement_enum($bdd, 'table_u_admin', 'mail');
		$index=count($enum_mail);	
		$boolean = false;

		for ($i = 0; $i < $index; $i++)
		{									
			$boolean = ($boolean) || ($mail===$enum_mail[$i]);
		}
	
		return $boolean;
	}
?>