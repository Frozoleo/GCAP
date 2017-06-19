<?php
	define("regex_nom_prenom", "^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ-]{1,40}$");
	define("regex_acr_ameps", "^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]{1,40}$");
	define("regex_reference", "/^[a-zA-Z0-9-]{1,20}$/i");
	define("regex_classique", "/^[a-zA-Z0-9._-]{1,40}$/i");
	define("regex_age", "^[0-9]{1,2}$");
	define("regex_materiel_logiciel", "/^[a-zA-Z0-9._-]{1,20}$/i");
	define("regex_mail", "^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$");
	define("regex_tel", "^[0-9\s]{10,14}$");
	define("regex_mdp", "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{10,}$");
?>