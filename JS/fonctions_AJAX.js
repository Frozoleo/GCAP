function getXMLHttpRequest() 
{
	var xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject) 
	{
		if (window.ActiveXObject) 
		{
			try 
			{
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} 
			catch(e) 
			{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} 
		else 
		{
			xhr = new XMLHttpRequest(); 
		}
	} 
	else
	{
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	return xhr;
}

function request(callback, a_envoyer) 																
{
	var xhr   = getXMLHttpRequest(),
		loader = document.getElementsByClassName("chargement");

	xhr.onreadystatechange = function() 
	{
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
		{
			callback(xhr.responseText);
			loader[0].style.display = "none";
			loader[1].style.display = "none";
		} 
		else if (xhr.readyState < 4) 
		{	
			loader[0].style.display = "inline";
			loader[1].style.display = "inline";
		}
	};
	
	var envoi=a_envoyer[0]+'='+a_envoyer[1];
	
	for(var i=2, l=a_envoyer.length; i<l;i+=2)
	{
		envoi+="&"+a_envoyer[i]+'='+a_envoyer[i+1];
	}

	xhr.open("POST", "AJAX_traitement_mult.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(envoi);
}