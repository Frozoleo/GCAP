/*****************************************************/

function dyn_required(chemin_required,chemin_non_required)
{
	var queryAll_inputs_utiles = document.querySelectorAll(chemin_required),
		queryAll_inputs = document.querySelectorAll(chemin_non_required);
	
	for(var i=0, li=queryAll_inputs.length;i<li;i++)
	{
		queryAll_inputs[i].removeAttribute('required');
	}
	
	for(var i=0, li=queryAll_inputs_utiles.length;i<li;i++)
	{
		queryAll_inputs_utiles[i].setAttribute('required', 'required');
	}	
}

function dyn_visibilite(nom, recherche)
{
	for(var i=0, li=recherche.length; i<li; i++)
	{			
		if(recherche[i].id==nom)
		{
			recherche[i].className='Visible';  
		}

		else
		{
			recherche[i].className='Invisible'; 
		}
	}	
}

function informations_upload(filelist)
{
	var info = document.querySelector('div#info_upload'),
		nom = document.querySelector('p#nom span'),
		taille = document.querySelector('p#taille span'),
		type = document.querySelector('p#type span'),
		label = document.querySelector('label.file');
				
	info.style.display = "block";
	
	nom.innerHTML = filelist.files[0].name;
	taille.innerHTML = filelist.files[0].size + ' octets';
	type.innerHTML = filelist.files[0].type;
	label.innerHTML = 'Fichier choisi : ' + filelist.files[0].name;
}

/*****************************************************/
var queryAll_domaine = document.querySelectorAll('.form-style-5 div.domaine .dynamique1'),
	queryAll_materiel = document.querySelectorAll('.form-style-5 div.materiel .dynamique2'),
	queryAll_materiel_plus = document.querySelectorAll('.form-style-5 div.materiel .dynamique3'),
	query_materiel_plus = document.querySelector('.form-style-5 div.materiel div#materiel_plus'),
	query_special_EPC3200 = document.querySelector('.form-style-5 div.materiel div#materiel_plus div#special_EPC3200'),
	queryAll_PS = document.querySelectorAll('.form-style-5 div.PS .dynamique2');
	memoire=true;
		
(function(){
	var domaine = document.getElementById('domaine'),
		materiel = document.querySelector('select#materiel'),
		Palier_technique = document.getElementById('Palier_technique'),
		UC = document.getElementById('UC'),
		PS = document.querySelector('select#PS');
	
	/* poursuivre.addEventListener('click', function()
	{
		if(memoire)
		{
			document.querySelector('#form1').style.display = "none";
			poursuivre.setAttribute("style", "position: absolute; top: 80%; left: 50%; transform: translateX(-50%);");
			poursuivre.setAttribute("value", "Valider et revenir au formulaire");
			document.querySelector('#my_dropzone').style.visibility = "visible";	
		}
		
		else
		{
			document.querySelector('#form1').style.display = "block";
			poursuivre.setAttribute("style", "position: none; top: none; left: none; transform: none;");
			poursuivre.setAttribute("value", "Déposer des pièces jointes");
			document.querySelector('#my_dropzone').style.visibility = "hidden";		
		}

		memoire=!memoire;
	}); */
	
	domaine.addEventListener('change', function(e) 
	{
		switch (e.target.value) 
		{	
			case 'materiel': 
				dyn_visibilite("materiel",queryAll_domaine);
				dyn_required('.form-style-5 div.domaine .rang1#materiel','.form-style-5 div.domaine .rang1');
			break;
			
			case 'PS': 
				dyn_visibilite("PS",queryAll_domaine);
				dyn_required('.form-style-5 div.domaine .rang1#PS','.form-style-5 div.domaine .rang1');
			break;
			
			case 'autre': 
				dyn_visibilite("description",queryAll_domaine);
				dyn_required('.form-style-5 div.domaine .rang1#description','.form-style-5 div.domaine .rang1');
			break;
			
			default:
				dyn_visibilite("rien",queryAll_domaine);
				dyn_required('rien','.form-style-5 div.domaine .rang1');
		}
	});
	
	materiel.addEventListener('change', function(e) 
	{
		switch (e.target.value) 
		{	
			case 'in_PS': 
				dyn_visibilite("in_PS",queryAll_materiel);
				dyn_required('.form-style-5 div.domaine div.materiel div#in_PS .rang2','.form-style-5 div.domaine .rang2');
			break;
			
			case 'out_PS': 
				dyn_visibilite("out_PS",queryAll_materiel);
				dyn_required('.form-style-5 div.domaine div.materiel div#out_PS .rang2','.form-style-5 div.domaine .rang2');
			break;
			
			case 'autre': 
				dyn_visibilite("description",queryAll_materiel);
				dyn_required('.form-style-5 div.domaine div.materiel .rang2#description','.form-style-5 div.domaine .rang2');
			break;
			
			default:
				dyn_visibilite("rien",queryAll_materiel);
				dyn_required('rien','.form-style-5 div.domaine div.materiel .rang2');
		}
	});
		
	Palier_technique.addEventListener('change', function(e)
	{
		switch (e.target.selectedOptions[0].parentNode.label) 
		{	
			case 'Poste asservi': 
				dyn_visibilite("PAGC",queryAll_materiel_plus);
				query_materiel_plus.className='Visible';
				dyn_required('.form-style-5 div.domaine div.materiel div#materiel_plus .rang4#type_materiel_PAGC','.form-style-5 div.domaine .rang4');
				dyn_required('.form-style-5 div.domaine div.materiel div#materiel_plus .rang3','.form-style-5 div.domaine .rang3');
			break;
			
			case 'PCCN': 
				dyn_visibilite("PCCN",queryAll_materiel_plus);
				query_materiel_plus.className='Visible';
				dyn_required('.form-style-5 div.domaine div.materiel div#materiel_plus .rang4#type_materiel_PCCN','.form-style-5 div.domaine .rang4');
				dyn_required('.form-style-5 div.domaine div.materiel div#materiel_plus .rang3','.form-style-5 div.domaine .rang3');
			break;
			
			default:
				dyn_visibilite("rien",queryAll_materiel_plus);
				query_materiel_plus.className='Invisible';
				dyn_required('rien','.form-style-5 div.domaine div.materiel .rang4');
				dyn_required('rien','.form-style-5 div.domaine .rang3');
		}
	});
	
	UC.addEventListener('change', function(e)
	{
		if (e.target.selectedOptions[0].parentNode.label=="EPC3200") 
		{	
				query_special_EPC3200.className='Visible';
				dyn_required('.form-style-5 div.domaine div.materiel div#materiel_plus div#special_EPC3200 .rang5#UC','.form-style-5 div.domaine .rang5');		
		}		
	});
	
	PS.addEventListener('change', function(e) 
	{
		switch (e.target.value) 
		{	
			case 'materielle': 
				dyn_visibilite("materielle",queryAll_PS);
				dyn_required('.form-style-5 div.domaine div.PS div#materielle .rang2','.form-style-5 div.domaine .rang2');
			break;
			
			case 'logicielle': 
				dyn_visibilite("logicielle",queryAll_PS);
				dyn_required('.form-style-5 div.domaine div.PS div#logicielle .rang2','.form-style-5 div.domaine .rang2');
			break;
			
			default:
				dyn_visibilite("rien",queryAll_PS);
				dyn_required('rien','.form-style-5 div.domaine .rang2');
		}
	});
})();

/*****************************************************/

function message_contextuel()
{
	var queryAll = document.querySelectorAll('form.form-style-5 input'),
		messages = messages_personnalisés();
		
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
}

function messages_personnalisés()
{
	return ["Votre nom doit être écrit en caractères alphanumériques accentués et/ou masjuscule <strong>non</strong> espacés et dans la limite de 40 caractères",
			"Votre prénom doit être écrit en caractères alphanumériques accentués et/ou masjuscule <strong>non</strong> espacés et dans la limite de 40 caractères",
			"le nom de l'AMEPS doit être écrit en caractères alphanumériques (accentués ou non) et dans la limite de 40 caractères",
			"le nom de l'ACR doit être écrit en caractères alphanumériques (accentués ou non) et dans la limite de 40 caractères",
			"Format d'une adresse mail : jean.dupont@enedis.fr",
			"formats accéptés : \'AXAXAXAXAX\' ou \'AX AX AX AX AX\'",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '-' ; 20 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			"liste des caractères exclus : caractères accentués et spéciales à l'exception de '.','_' et '-' ; 40 caractères max",
			];
}

/*****************************************************/
