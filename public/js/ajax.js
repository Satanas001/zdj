function html_requete(url_requete)
{	
		var nb_aleatoire= Math.round(Math.random()*10000); 
		eval ('var object'+nb_aleatoire+'=null;')
		//document.getElementById('chargement').style.display='';
		if(window.XMLHttpRequest){ // Firefox 
			eval("object"+nb_aleatoire+ " = new XMLHttpRequest();"); 
			 if ("object"+nb_aleatoire+".overrideMimeType") {
					"object"+nb_aleatoire+".overrideMimeType('text/html; charset=ISO-8859-15')"; 
			}
		}else if(window.ActiveXObject){ // Internet Explorer 
			eval("object"+nb_aleatoire+ " = new ActiveXObject('Microsoft.XMLHTTP');"); 
		}else { // XMLHttpRequest non supporté par le navigateur 
			alert('Votre navigateur ne supporte pas les objets XMLHTTPRequest...');
		}
		

		
		eval("object"+nb_aleatoire+".open('GET' , url_requete, true);");
		eval("object"+nb_aleatoire+".setRequestHeader('Content-type', 'application/x-www-form-urlencoded');");
		// eval("object"+nb_aleatoire+".setRequestHeader('Connection', 'close');");
		

		eval("object"+nb_aleatoire+".send(null);");
		eval("object"+nb_aleatoire+".onreadystatechange=function(){if (object"+nb_aleatoire+".readyState==4){	eval(object"+nb_aleatoire+".responseText);}}");
}

function html_requete2(url_requete)
{	
	var object;
	var texte = "nom";
		//document.getElementById('chargement').style.display='';
		if(window.XMLHttpRequest){ // Firefox 
			object = new XMLHttpRequest(); 
			// object.overrideMimeType('text/html; charset=ISO-8859-15');
			
		}else if(window.ActiveXObject) // Internet Explorer 
			{object = new ActiveXObject('Microsoft.XMLHTTP'); }
		else { // XMLHttpRequest non supporté par le navigateur 
			alert('Votre navigateur ne supporte pas les objets XMLHTTPRequest...');
		}
		
	var inputs = document.getElementsByTagName('input');
	var selects = document.getElementsByTagName('select');
	var textareas = document.getElementsByTagName('textarea');
	var i ;
	var str = "";
	for (i = 0; i<inputs.length; i++) {
		if (str != "") str += "&";
		
		
		if (inputs[i].getAttribute('type')=="radio"){
			if (inputs[i].checked){
				str += inputs[i].getAttribute('name') + "=" + inputs[i].value;
			}
		}else{
			//str += inputs[i].getAttribute('name') + "=" + inputs[i].value;
			str += inputs[i].getAttribute('name') + "=" + encodeURIComponent(inputs[i].value);
		}
		
	}	
	
	var j;
	var NbColl;
	var a;
	
		
	for (j = 0; j<selects.length; j++) {
	
		if (selects[j].getAttribute('name')=='adrlivraisonSec[]'){
			NbCol1 = eval(selects[j].length);

			for(a=0; a<NbCol1; a++){
				var tab=new Array(NbColl);
				tab[a]=selects[j].options[a].value;
				if (str != "") str += "&";
				str += selects[j].getAttribute('name') + "=" + tab[a];
			}
		
		}else{
			if (str != "") str += "&";
			str += selects[j].getAttribute('name') + "=" + selects[j].value;
		
		}
	}
	
	
	
	var k;
	for (k = 0; k<textareas.length; k++) {
		if (str != "") str += "&";
		str += textareas[k].getAttribute('name') + "=" + textareas[k].value;
	}
	object.open('POST' , url_requete, true);
	object.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	// object.setRequestHeader('Connection', 'close');
	object.send(str);
	object.onreadystatechange=function(){if (object.readyState==4){	eval(object.responseText);}}
		
}

