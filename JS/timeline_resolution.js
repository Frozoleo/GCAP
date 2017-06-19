function event_suppresion(query_click, query_suppr) 
{
	(function(query_suppr) 
	{
		query_click.addEventListener("click", function() 
		{
			query_suppr.parentNode.removeChild(query_suppr);
			point_inf();
		});
	}(query_suppr));
}

function ajout_legend()
{
	var div_All = document.querySelectorAll('li.event#demande_information form.form-style-5 div.form');
	
	if((div_All.length!=0) && (div_All[div_All.length-1].firstChild.lastChild.name=="Onglet"))
	{
		alert ("Vous devez définir au moins un champ pour un onglet donné");
	}
	
	else
	{
		var form = document.querySelector('li.event#demande_information form.form-style-5'),
			input_onglet_existant = document.querySelector('li.event#demande_information form.form-style-5 input[name=Onglet]'),
			input_onglet = document.createElement('input'),
			fieldset = document.createElement('fieldset'),
			div = document.createElement('div'),
			label_suppression = document.createElement('label'),
			div_suppression = document.createElement('div');
			
		div.setAttribute('class', 'form');
		fieldset.setAttribute('class', 'sous');
		div_suppression.setAttribute('class', 'legend1');
		label_suppression.setAttribute('class', 'supprimer');
		input_onglet = input_onglet_existant.cloneNode(true);
		input_onglet.removeAttribute('readonly');
		input_onglet.removeAttribute('onmouseover'); 
		input_onglet.removeAttribute('onmouseout');
		
		label_suppression.appendChild(input_onglet);
		label_suppression.appendChild(div_suppression);
		fieldset.appendChild(label_suppression);
		
		div.appendChild(fieldset);
		form.appendChild(div);
		
		event_suppresion(div_suppression, div);
		point_sup();
	}
}
function ajout_element()
{
	var div_All = document.querySelectorAll('li.event#demande_information form.form-style-5 div.form');		
	
	if(div_All.length==0)
	{
		alert ("Commencez par définir un onglet");
	}
	
	else
	{
		var form = document.querySelector('li.event#demande_information form.form-style-5'),		
			select_existant = document.querySelector('li.event#demande_information form.form-style-5 label.fleche'),
			input_nom_existant = document.querySelector('li.event#demande_information form.form-style-5 input[name=Question]'),
			input_aide_existant = document.querySelector('li.event#demande_information form.form-style-5 input[name=Aide]'),
			div_aide_existant = document.querySelector('li.event#demande_information form.form-style-5 div.after'),
			
			div_separateur = document.createElement('div'),
			input_nom = document.createElement('input'),
			select = document.createElement('label'),
			input_aide = document.createElement('input'),
			div_aide = document.createElement('div'),
			label_aide = document.createElement('label'),
			div_suppression = document.createElement('div'),
			
			fieldset = div_All[div_All.length-1].firstChild;
		
		input_nom = input_nom_existant.cloneNode(true);
		select = select_existant.cloneNode(true);
		input_aide = input_aide_existant.cloneNode(true);
		div_aide = div_aide_existant.cloneNode(false);
		
		input_nom.removeAttribute('readonly');		
		input_nom.removeAttribute('onmouseover'); 
		input_nom.removeAttribute('onmouseout');
		
		select.firstChild.removeAttribute('readonly');
		select.removeAttribute('onmouseover');
		select.removeAttribute('onmouseout');
		
		div_separateur.setAttribute('class', 'champ_q');
		label_aide.setAttribute('class', 'ajouter');
		
		div_suppression.setAttribute('class', 'legend2');

		label_aide.appendChild(div_aide);
		label_aide.appendChild(input_aide);
		
		div_separateur.appendChild(div_suppression);
		div_separateur.appendChild(input_nom);
		div_separateur.appendChild(select);
		div_separateur.appendChild(label_aide);
		
		fieldset.appendChild(div_separateur);
		
		div_aide.addEventListener('click', function discret()
		{
			div_aide.style.display='none';
			input_aide.removeAttribute('readonly');
			
			this.removeAttribute('onmouseover'); 
			input_aide.removeAttribute('onmouseover');
			
			this.removeAttribute('onmouseout');
			input_aide.removeAttribute('onmouseout');
			
			label_aide.className="ajouter";
			
			this.removeEventListener('click', discret);
		});
	
		input_aide.addEventListener('click', function discret()
		{
			div_aide.style.display='none';
			input_aide.removeAttribute('readonly');
			
			this.removeAttribute('onmouseover'); 
			div_aide.removeAttribute('onmouseover');
			
			this.removeAttribute('onmouseout');
			div_aide.removeAttribute('onmouseout');
			
			label_aide.className="event";
			
			this.removeEventListener('click', discret);
		});
		
		event_suppresion(div_suppression, div_separateur);
		point_sup();		
	}
}

function dyn1($nom, $recherche)
{
	for(var i=0, li=$recherche.length; i<li; i++)
	{			
		if($recherche[i].id==$nom)
		{
			$recherche[i].className='Visible';  
		}

		else
		{
			$recherche[i].className='Invisible'; 
		}
	}	
}

function point_sup()
{
	var queryAll_li = document.querySelectorAll('li.event'),
		queryAll_h3 = document.querySelectorAll('li.event h3');
	
	for(var i=0, li=queryAll_li.length; i<li; i++)
	{
		queryAll_point = document.querySelectorAll('li.event#'+queryAll_li[i].id+' div.point_deco');
		
		for(var j=0, lj=5; j<lj; j++)
		{
			if((queryAll_li[i].offsetHeight>=(200+j*175)) && (typeof queryAll_point[j] === 'undefined'))
			{
				var div = document.createElement('div');
				div.setAttribute('class', 'point_deco n'+(1+j));
				queryAll_li[i].insertBefore(div, queryAll_h3[i]);
			}
		}
	}
}

function point_inf()
{
	var queryAll_li = document.querySelectorAll('li.event');
	
	for(var i=0, li=queryAll_li.length; i<li; i++)
	{
		var queryAll_point = document.querySelectorAll('li.event#'+queryAll_li[i].id+' div.point_deco');
			
		for(var j=0, lj=queryAll_point.length; j<lj; j++)
		{	
			if(queryAll_li[i].offsetHeight<(200+j*175))
			{
				queryAll_point[j].parentNode.removeChild(queryAll_point[j]);
			}
		}
	}
}

/*************************************************************************************/

function hover_liee(chemin)
{
	var query_div = document.querySelector(chemin+' > div.after'),
		query_h3 = document.querySelector(chemin+' > h3'),
		query_li = document.querySelector(chemin),
		query_form = document.querySelector(chemin+' .form-style-5');
	
	if(typeof query_div !== 'undefined' && query_div != null)
	{
		query_div.setAttribute('onmouseover', 'this.parentNode.className="event onhover";');
		query_div.setAttribute('onmouseout', 'this.parentNode.className="event";');
		
		query_div.addEventListener('click', function discret()
		{
			query_form.className='Visible form-style-5';  
			query_h3.className='Invisible';  
			point_sup();
			
			query_h3.removeAttribute('onmouseover'); 
			query_div.removeAttribute('onmouseover');
			
			query_h3.removeAttribute('onmouseout');
			query_div.removeAttribute('onmouseout');
			
			query_li.className="event";
			
			this.removeEventListener('click', discret);
		});	
	}
	if(typeof query_h3 !== 'undefined' && query_h3 != null)
	{
		query_h3.setAttribute('onmouseover', 'this.parentNode.className="event onhover";'); 
		query_h3.setAttribute('onmouseout', 'this.parentNode.className="event";');
		
		query_h3.addEventListener('click', function discret()
		{
			query_form.className='Visible form-style-5';  
			query_h3.className='Invisible';  
			point_sup();
			
			query_h3.removeAttribute('onmouseover'); 
			query_div.removeAttribute('onmouseover');
			
			query_h3.removeAttribute('onmouseout');
			query_div.removeAttribute('onmouseout');
			
			query_li.className="event";
			
			this.removeEventListener('click', discret);
		});
	}
}

/*************************************************************************************/

(function(){

	var tfConfig = 
	{
        base_path: 'tablefilter/',
		
		responsive: true,
		
        col_widths: ['25px', '200px', '250px', '200px', '200px', '250px', '100px'],
        col_types: ['number ', 'string', 'string', 'string', 'string', 'date', 'string'],
		
        alternate_rows: true,
		mark_active_columns: true,
        highlight_keywords: true,
		
		grid: false,
		
		themes: [{
            name: 'mytheme'
        }]
    };
	
	var tf = new TableFilter(document.querySelector('.tableau_filtre#general'),tfConfig);
    tf.init();
	
	hover_liee('li.event#demande_information');
	hover_liee('li.event#Reponse_GCAP');
	hover_liee('li.event#Renseignements_finaux');

	var queryAll_label = document.querySelectorAll('li.event#demande_information label.ajouter'),
		queryAll_sous_div = document.querySelectorAll('li.event#demande_information label.ajouter div.after'),
		queryAll_input = document.querySelectorAll('li.event#demande_information label.ajouter input'),
		query_select = document.querySelector('li.event#demande_information label.ajouter label.fleche'),
		
		queryAll_demande_information = document.querySelectorAll('li.event#demande_information .form-style-5 .dynamique'),
		
		query_div_validation = document.querySelector('li.event#validation_AMEPS div.validation_AMEPS + div.validation_AMEPS'),
		query_form3 = document.querySelector('li.event#validation_AMEPS .form-style-5');

	for(var i=0, li=queryAll_label.length; i<li; i++)
	{			
		queryAll_sous_div[i].setAttribute('onmouseover', 'this.parentNode.className="ajouter onhover";');		
		queryAll_sous_div[i].setAttribute('onmouseout', 'this.parentNode.className="ajouter";');
	}
	
	for(var i=0, li=queryAll_input.length; i<li; i++)
	{
		queryAll_input[i].setAttribute('onmouseover', 'this.parentNode.className="ajouter onhover";'); 
		queryAll_input[i].setAttribute('onmouseout', 'this.parentNode.className="ajouter";');
	}
	
	if(query_select!=null)
	{
		query_select.setAttribute('onmouseover', 'this.parentNode.className="ajouter onhover";'); 
		query_select.setAttribute('onmouseout', 'this.parentNode.className="ajouter";');
	}
	
	if(queryAll_input[0]!=null){queryAll_input[0].addEventListener('click', function(){ajout_legend();});}
	if(queryAll_sous_div[0]!=null){queryAll_sous_div[0].addEventListener('click', function(){ajout_legend();});}
	
	if(queryAll_input[1]!=null){queryAll_input[1].addEventListener('click', function(){ajout_element();});}
	if(query_select!=null){query_select.addEventListener('click', function(){ajout_element();});}
	if(queryAll_input[2]!=null){queryAll_input[2].addEventListener('click', function(){ajout_element();});}
	if(queryAll_sous_div[1]!=null){queryAll_sous_div[1].addEventListener('click', function(){ajout_element();});}

	
	if(query_div_validation!=null)
	{
		query_div_validation.addEventListener('click', function discret()
		{
			query_form3.className='Visible form-style-5';   
			point_sup();
		});
	}
	
	point_sup();
	
	time_out();
})();











/*************************************************************************************/

/*
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
*/

/*****************************************************/