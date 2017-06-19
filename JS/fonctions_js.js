/*****************************************************/

function $_GET(param) 
{
	var vars = {};
	window.location.href.replace(location.hash, '').replace
	( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) 
		{ // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}

/*****************************************************/

function time_out()
{
	var infos = document.getElementById("info_message_top");
	if(infos!=null)
	{
		setTimeout(function(){infos.className='invisible';}, 6000);
	}
}

function message_information(message)
{
	var info = document.querySelector('div#info_message_top');
	info.className='visible';
	info.lastChild.innerHTML=message;
	time_out();
}