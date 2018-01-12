
/*****************************************
  PERMET DE TRIER UN LES ELEMENTS OPTIONS 
 *****************************************/
function tri(selecteur)
{
    var liste=document.getElementById(selecteur);
    var options=liste.options;
    var nboptions=options.length;
    var options2=new Array();

    for (var ix=0; ix<nboptions; ix++) options2 [ ix ] =options [ ix ] ;
    options2.sort(triage);
    for (var ix=0; ix<nboptions; ix++) options [ ix ] =options2 [ ix ] ;
}

/*****************************************
  PERMET DE TRIER UN LES ELEMENTS OPTIONS 
 *****************************************/
function triage(option1, option2)
{
	if (option1.text<option2.text) return -1;
	if (option1.text>option2.text) return 1;
	return 0;
}

/*****************************************
  PERMET D'OBTENIR UN NOMBRE ALEATOIRE  
 *****************************************/
function getRandomIntInclusive(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min +1)) + min;
}

function cutUrlMap(GooglemapUrl){
	var traitement = GooglemapUrl.split("@");
	var str = traitement[1].split("/");
	var coord = str[0].split(",");
	
	return parseFloat(coord[0])+","+parseFloat(coord[1]);
	
	// https://www.google.fr/@50.474744,2.5621129,14z
}