/*********************************************************************************************************************************************/
/*		Fichier : traitement_acceuil.php	Dernière modification : 07/05/2016	Service : GCAP	Contact : leonard.souffache@erdf.fr			 */
/*********************************************************************************************************************************************/

var tfConfig_general = 
	{
        base_path: 'tablefilter/',
		col_2: 'select',
		col_4: 'select',
		col_5: 'select',
		
		responsive: true,
		
		watermark: ['N°', 'Nom', 'Type', 'Descriptif', 'État', 'Date', 'Mots'],
		
		//state: {types: ['hash'],filters: true,page_number: true,page_length: true,sort: true},
        paging: true,
        results_per_page: ['Afficher: ', [10,25,50,100]],
		 
		auto_filter: true,
        auto_filter_delay: 200, //millisecondes
		
		no_results_message: true,
		
        col_widths: ['25px', '200px', '250px', '200px', '200px', '250px', '100px'],
        col_types: ['number ', 'string', 'string', 'string', 'string', 'date', 'string'],
		
        alternate_rows: true,
		mark_active_columns: true,
        highlight_keywords: true,
		
        btn_reset: true,
		btn_reset_text: "Tout afficher",
        rows_counter: true,
		rows_counter_text: 'Nombre d\'événements: ',
        loader: true,
		loader_text: "Filtrage des données...",
		status_bar: true,
		help_instructions_text: 'Utilisez les filtres au-dessus de chaque colonne pour filtrer et limiter les données de la table. Des recherches avancées peuvent être effectuées en utilisant les opérateurs suivants:<br><b><</b>, <b><=</b>, <b><</b>, <b>>=</b>, <b>=</b>, <b>*</b>, <b>!</b>, <b>{</b>, <b>}</b>, <b>||</b>, <b>&&</b>, <b>[empty]</b>, <b>[nonempty]</b>, <b>rgx:</b> <br><a href="https://github.com/koalyptus/TableFilter/wiki/4.-Filter-operators" target="_blank"> Wiki des opérateurs </a>',

        extensions:[{
            name: 'sort'
        }],
		
        themes: [{
            name: 'mytheme'
        }]
    };
	
var tfConfig_perso = 
{
	base_path: 'tablefilter/',
	col_2: 'select',
	col_4: 'select',
	col_5: 'select',
	
	responsive: true,
	
	watermark: ['N°', 'Nom', 'Type', 'Descriptif', 'État', 'Date', 'Mots'],
	
	//state: {types: ['hash'],filters: true,page_number: true,page_length: true,sort: true},
	paging: true,
	results_per_page: ['Afficher: ', [10,25,50,100]],
	 
	auto_filter: true,
	auto_filter_delay: 200, //millisecondes
	
	no_results_message: true,
	
	col_widths: ['25px', '200px', '250px', '200px', '200px', '250px', '100px'],
	col_types: ['number ', 'string', 'string', 'string', 'string', 'date', 'string'],
	
	alternate_rows: true,
	mark_active_columns: true,
	highlight_keywords: true,
	
	btn_reset: true,
	btn_reset_text: "Tout afficher",
	rows_counter: true,
	rows_counter_text: 'Nombre d\'événements: ',
	loader: true,
	loader_text: "Filtrage des données...",
	status_bar: true,
	help_instructions_text: 'Utilisez les filtres au-dessus de chaque colonne pour filtrer et limiter les données de la table. Des recherches avancées peuvent être effectuées en utilisant les opérateurs suivants:<br><b><</b>, <b><=</b>, <b><</b>, <b>>=</b>, <b>=</b>, <b>*</b>, <b>!</b>, <b>{</b>, <b>}</b>, <b>||</b>, <b>&&</b>, <b>[empty]</b>, <b>[nonempty]</b>, <b>rgx:</b> <br><a href="https://github.com/koalyptus/TableFilter/wiki/4.-Filter-operators" target="_blank"> Wiki des opérateurs </a>',
	
	themes: [{
		name: 'mytheme'
	}]
};

/*****************************************************/

function couleur_etat()																			
{
	var td_etat = document.querySelectorAll('div.corps table.tableau_filtre td.etat_js');
	for(var i=0, li=td_etat.length; i<li; i++)
	{
		switch (td_etat[i].innerHTML)
		{
			case 'En attente de traitement':
				td_etat[i].className='en_attente';														
			break;
			
			case 'En cours de traitement':
				td_etat[i].className='en_cours';
			break;
			
			case 'Repondu,en attente de validation':
				td_etat[i].className='repondue';
			break;
			
			case 'Valide': 
				td_etat[i].className='valide';
			break;
			
			default:
				td_etat[i].className='en_attente';
		}
	}
}

function traitement_donnees(donnees)
{
	var temp = donnees.split("!");
	for(var i=1, li=temp.length; i<li; i++)
	{	
		temp[i]=temp[i].split("$");
	}
	return temp;
}

function decoupage_tableau (donnees)
{
	var tableaux = document.querySelector('div.corps table.tableau_filtre');
	if(!(Array.isArray(tableaux)))
	{
		var corps = document.querySelector('div.corps'),
			tableau_existant = document.querySelector('div.corps table.tableau_filtre'),
			thead_existant = document.querySelector('div.corps table.tableau_filtre thead'),
			table = document.createElement('table'),
			thead = document.createElement('thead'),
			tbody = document.createElement('tbody');
		
		table.setAttribute('id', 'personnel');
		table.setAttribute('class', 'tableau_filtre');
		
		thead = thead_existant.cloneNode(true);

		table.appendChild(thead);
			
		for(var i=0, li=donnees.length; i<li; i++)
		{
			var tr = document.createElement('tr'),
				tab_temp = donnees[0];
				tr.setAttribute('onclick', 'window.open("timeline_resolution.php?Id='+donnees[i][0]+'");')
		
			for(var j=0, lj=tab_temp.length; j<lj; j++)
			{
				var td = document.createElement('td');
				if(j==4)
				{
					td.setAttribute('class', 'etat_js');
				}
				
				td.appendChild(document.createTextNode(donnees[i][j]));
				
				tr.appendChild(td);
			}
				
			tbody.appendChild(tr);
		}
		
		table.appendChild(tbody);
		corps.insertBefore(table, tableau_existant);

		var tf_perso = new TableFilter(document.querySelector('.tableau_filtre#personnel'),tfConfig_perso);
		tf_perso.init();

		document.querySelector('.helpFooter').style.display = "none";
		document.querySelector('.tableau_filtre thead tr.fltrow').style.display="none";
		
		var separateur = document.createElement('div'),
			ligne_sep = document.createElement('hr');
			
		separateur.setAttribute('class', 'separateur');
		separateur.appendChild(ligne_sep);
		corps.insertBefore(separateur, tableau_existant);
		
		
	}
}

/*****************************************************/

function retour_AJAX_deconnexion(donnees)
{
	if (donnees == "OK")
	{
		var message = "Vous êtes déconnecté";
		message_information(message);
	} 
	
	else
	{
		alert ("erreur AJAX");
	}
}

function deconnexion_utilisateur()
{
	var element = document.querySelector('body#accueil div.corps div.gauche.n1 div.liste').firstElementChild.nextElementSibling,
		div_tooltip = document.querySelector('body#accueil div.tooltip_projet'),
		tableau = document.querySelector('.tableau_filtre#personnel'),
		div_sep = document.querySelector('div.separateur');

	element.parentNode.removeChild(element);
	div_tooltip.parentNode.removeChild(div_tooltip);
	tableau.parentNode.removeChild(tableau);
	div_sep.parentNode.removeChild(div_sep);
}

function connexion_utilisateur(initiales)
{
	var body = document.querySelector('body#accueil'),
		liste_gauche = document.querySelector('body#accueil div.corps div.gauche.n1 div.liste'),
		tooltip_info = document.querySelector('body#accueil div.tooltip_info'),
		tooltip_info_apres = document.querySelector('body#accueil div.couverture'),
		a_element = document.createElement('a'),
		div_tooltip = document.createElement('div'),
		input_cache = document.createElement('input');

	a_element = liste_gauche.firstElementChild.cloneNode(true);	
	a_element.setAttribute('href','#null');
	a_element.setAttribute('onclick','return false;');
	a_element.firstElementChild.firstElementChild.firstElementChild.setAttribute('src','Images/deconnexion.png');
	a_element.firstElementChild.firstElementChild.firstElementChild.setAttribute('alt','deconnexion');
	a_element.firstElementChild.firstElementChild.nextElementSibling.innerHTML = "Se Deconnecter";
	
	div_tooltip = tooltip_info.cloneNode(true);
	div_tooltip.setAttribute('class', 'tooltip_projet');
	div_tooltip.removeChild(div_tooltip.firstElementChild);
	div_tooltip.removeChild(div_tooltip.lastElementChild);
	div_tooltip.firstElementChild.setAttribute('class', 'compte');
	div_tooltip.firstElementChild.innerHTML = initiales.toUpperCase();
	
	input_cache.setAttribute('type', 'hidden');
	input_cache.setAttribute('name', 'deco');
	input_cache.setAttribute('value', '1');
	input_bidon = input_cache.cloneNode(true);
	
	a_element.addEventListener('click', function discret()
	{		
		AJAX('body#accueil div.corps div.gauche.n1 div.liste input',retour_AJAX_deconnexion);
		deconnexion_utilisateur();
		
		this.removeEventListener('click', discret);
	});
	
	a_element.appendChild(input_cache);
	a_element.appendChild(input_bidon);
	body.insertBefore(div_tooltip, tooltip_info_apres);
	liste_gauche.insertBefore(a_element, liste_gauche.lastElementChild);
	
}

/*****************************************************/

function message_contextuel()
{
	var queryAll_new_account = document.querySelectorAll('#new_account fieldset input'),
		queryAll_account = document.querySelectorAll('#account fieldset input'),
		message_creation = messages_personnalisés_creation(),
		message_connexion = messages_personnalisés_connexion();
		
	for(var i=0, li=queryAll_new_account.length-1; i<li; i++)
	{		
		(function(message) 
		{
			queryAll_new_account[i].addEventListener("keyup", function(e) 
			{
				if (e.target.validity.patternMismatch)
				{
					e.target.setCustomValidity(message);
				} 
				else
				{
					e.target.setCustomValidity("");
				}
			});
		}(message_creation[i]));
	}
	
	for(var i=0, li=queryAll_account.length-1; i<li; i++)
	{		
		(function(message) 
		{
			queryAll_account[i].addEventListener("keyup", function(e) 
			{
				if (e.target.validity.patternMismatch)
				{
					e.target.setCustomValidity(message);
				} 
				else
				{
					e.target.setCustomValidity("");
				}
			});
		}(message_connexion[i]));
	}
}

function AJAX(chemin, fonction)
{
	var queryAll = document.querySelectorAll(chemin),
		chaine_donnee = new Array(),
		valeur=0,
		nom=0;

	for(var i=0, li=queryAll.length-1; i<li; i++)
	{			
		valeur = queryAll[i].value;
		nom = queryAll[i].name;
		if(typeof queryAll[i] !== 'undefined' && queryAll[i] != null)
		{
			chaine_donnee = chaine_donnee.concat([nom,valeur]);  
		}
	}	
	request(fonction, chaine_donnee);
}

function messages_personnalisés_creation()
{
	return ["Votre nom doit être écrit en caractères alphanumériques accentués et/ou masjuscule <strong>non</strong> espacés et dans la limite de 40 caractères",
			"Votre prénom doit être écrit en caractères alphanumériques accentués et/ou masjuscule <strong>non</strong> espacés et dans la limite de 40 caractères",
			"le nom de l'AMEPS doit être écrit en caractères alphanumériques (accentués ou non) et dans la limite de 40 caractères",
			"le nom de l'ACR doit être écrit en caractères alphanumériques (accentués ou non) et dans la limite de 40 caractères",
			"Format d'une adresse mail : jean.dupont@enedis.fr",
			"formats accéptés : \'AXAXAXAXAX\' ou \'AX AX AX AX AX\'",
			"Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et doit faire au moins 10 caractères."
			];
}

function messages_personnalisés_connexion()
{
	return ["Format d'une adresse mail : jean.dupont@enedis.fr",
			"Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et posséder au moins 10 caractères."
			];
}

/*****************************************************/

function retour_AJAX_creation(donnees)
{
	if (donnees.startsWith("Bonjour"))
	{
		var message = "Votre profil a été correctement créé. ATTENTION, un manque d'activité sur la page provoquera une déconexion automatique !",
			tab = traitement_donnees(donnees),
			temp = tab.shift();
			
		temp= temp.split(" ");
		connexion_utilisateur(temp[1].charAt(0)+temp[2].charAt(0));
		
		decoupage_tableau(tab);
		message_information(message);
		window.location="#noWhere";
	} 
	else if (donnees == "NOK")
	{
		alert("Adresse mail déjà utilisée");
	}
	
	else
	{
		alert ("erreur AJAX");
	}
}

function creation_compte()
{
	AJAX('#new_account fieldset input', retour_AJAX_creation);
}

/*****************************************************/

function retour_AJAX_connexion(donnees)
{
	if (donnees.startsWith("Bonjour"))
	{
		var tab = traitement_donnees(donnees),
			message = tab.shift();
			
		temp= message.split(" ");
		connexion_utilisateur(temp[1].charAt(0)+temp[2].charAt(0));
		
		decoupage_tableau(tab);
			
		message_information(message);
		window.location="#noWhere";
	} 
	else if (donnees == "NOK")
	{
		alert("Mot de passe érroné");
	}
	
	else
	{
		alert ("erreur AJAX");
	}
}

function connexion_compte()
{
	AJAX('#account fieldset input', retour_AJAX_connexion);
}

/*****************************************************/

function retour_AJAX_mdp(donnees)
{
	if (donnees == "OK")
	{
		var query = document.querySelector('#account fieldset input[type="email"]').value,
			message = "Le mail de récupération vient d'être envoyé à l\'adresse : "+query+".";
		message_information(message);
		window.location="#noWhere";
	} 
	else if (donnees == "NOK")
	{
		alert("Cette adresse ne correspond à aucun compte valide");
	}
	
	else
	{
		alert ("erreur AJAX");
	}
}

function mdp_oubli()
{
	var query = document.querySelector('#account fieldset input[type="email"]').value;
	
	if(query.trim() == "")
	{
		alert("veuillez renseigner votre adresse mail");
	}
	
	else if(confirm("En confirmant, un mail contenant votre mot de passe sera envoyé à cette adresse mail"))
	{
		request(retour_AJAX_mdp, ["mdp_oubli",query]);
	}
}

/*****************************************************/

(function(){
	
    var tf_global = new TableFilter(document.querySelector('.tableau_filtre#general'),tfConfig_general);
    tf_global.init();
	
	document.querySelector('.helpFooter').style.display = "none";

	time_out();	

	message_contextuel();
	
	couleur_etat();
	
	var a_element = document.querySelector('body#accueil div.corps div.gauche.n1 div.liste a[href="#null"]'),
		tab_perso = document.querySelector('.tableau_filtre#personnel');
	if(typeof a_element !== 'undefined' && a_element != null)
	{
		a_element.addEventListener('click', function discret()
		{		
			AJAX('body#accueil div.corps div.gauche.n1 div.liste input',retour_AJAX_deconnexion);
			deconnexion_utilisateur();
			
			this.removeEventListener('click', discret);
		});
	}
	
	if(typeof tab_perso !== 'undefined' && tab_perso != null)
	{
		var tf_perso = new TableFilter(tab_perso,tfConfig_perso);
		tf_perso.init();

		document.querySelector('.helpFooter').style.display = "none";
	}
	var filtre = $_GET('filtre');
	
	if(typeof filtre !== 'undefined')
	{
		tf_global.setFilterValue(0,filtre);
		tf_global.filter();
	}
	
})();