function alert_deco_auto()
{
	var deco = document.getElementById("deco_auto_cadre"),
		deco_bouton = document.getElementById("deco_auto"),
		x = setTimeout(function()
		{
			deco.firstElementChild.firstElementChild.innerHTML = "ATTENTION Votre session expirera dans <strong>5 min</strong> : veuillez rafraîchir la page pour prolonger votre connexion </br> <srtong> Cliquez sur ce message pour le faire disparaître </strong>";
			deco.className='couverture Visible';
			
			var sec=50,
				min=4,
				y = setInterval(function()
				{
					if((sec!=0) && (min!=0))
					{
						deco.firstElementChild.firstElementChild.innerHTML = "ATTENTION Votre session expirera dans <strong>"+min+" min "+sec+" sec</strong> : veuillez rafraîchir la page pour prolonger votre connexion. </br> <srtong> Cliquez sur ce message pour le faire disparaître </strong>";
					}
					else if ((sec==0) && (min!=0))
					{
						deco.firstElementChild.firstElementChild.innerHTML = "ATTENTION Votre session expirera dans <strong>"+min+" min</strong> : veuillez rafraîchir la page pour prolonger votre connexion. </br> <srtong> Cliquez sur ce message pour le faire disparaître </strong>";
					}
					else
					{
						deco.firstElementChild.firstElementChild.innerHTML = "ATTENTION Votre session a expirée. Si vous souhaitez vous reconnecter, veuillez vous rendre à la page d'accueil.</br> <srtong> Cliquez sur ce message pour le faire disparaître </strong>";
						clearInterval(y);
					}
					
					sec-=10;
					if(sec==-10)
					{
						min--;
						sec=50;
					}
				}, 10000);
				
			deco_bouton.addEventListener('click', function discret()
			{
				deco.className='couverture Invisble';
				clearInterval(y);
				this.removeEventListener('click', discret);
			});
			
		}, ((1440000) - (5*60*1000))); 

	// 1440 000 => 24*60*1000
}

(function(){
	alert_deco_auto();
})();