localStorage.clear();

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

/*****************************************
  PERMET DE RECUPERER LES COORDONNEES GM
 *****************************************/
function cutUrlMap(GooglemapUrl){
	var traitement = GooglemapUrl.split("@");
	var str = traitement[1].split("/");
	var coord = str[0].split(",");
	
	return parseFloat(coord[0])+","+parseFloat(coord[1]);
	
	// https://www.google.fr/@50.474744,2.5621129,14z
}

String.prototype.encode = function() {
    return unescape(encodeURIComponent(this));
}
 
String.prototype.decode = function(){
    return decodeURIComponent(escape(this));
}

/*****************************************
  PERMET DE LIMITER LES CARACTERES
 *****************************************/

function checkInput(object,caracteres) {
	console.log(object.value);
	for(x = 0; x < object.value.length; x++)
	{
		if(jQuery.inArray(object.value.charAt(x), caracteres) >=0){
			$(object).removeAttr("style");
			$("button").removeAttr("disabled");
		}else{
			$(object).attr("style","border:2px solid red;");
			$("button").attr("disabled","disabled");
			break;
		}
	}
}

function decodeHTMLEntities(text) {
    var entities = [
        ['amp', '&'],
        ['apos', '\''],
        ['#x27', '\''],
        ['#x2F', '/'],
        ['sol', '/'],
        ['#39', '\''],
        ['#47', '/'],
        ['lt', '<'],
        ['gt', '>'],
        ['nbsp', ' '],
        ['equals', '='],
        ['colon', ':'],
        ['period', '.'],
        ['commat', '@'],
        ['num', '#'],
		['Agrave','À'],
		['Aacute','Á'],
		['Acirc','Â'],
		['Atilde','Ã'],
		['Auml','Ä'],
		['Aring','Å'],
		['Aelig','Æ'],
		['Ccedil','Ç'],
		['Egrave','È'],
		['Eacute','É'],
		['Ecirc','Ê'],
		['Euml','Ë'],
		['Igrave','Ì'],
		['Iacute','Í'],
		['Icirc','Î'],
		['Iuml','Ï'],
		['eth','Ð'],
		['Ntilde','Ñ'],
		['Ograve','Ò'],
		['Oacute','Ó'],
		['Ocirc','Ô'],
		['Otilde','Õ'],
		['Ouml','Ö'],
		['times','×'],
		['Oslash','Ø'],
		['Ugrave','Ù'],
		['Uacute','Ú'],
		['Ucirc','Û'],
		['Uuml','Ü'],
		['Yacute','Ý'],
		['thorn','Þ'],
		['szlig','ß'],
		['agrave','à'],
		['aacute','á'],
		['acirc','â'],
		['atilde','ã'],
		['auml','ä'],
		['aring','å'],
		['aelig','æ'],
		['ccedil','ç'],
		['egrave','è'],
		['eacute','é'],
		['ecirc','ê'],
		['euml','ë'],
		['igrave','ì'],
		['iacute','í'],
		['icirc','î'],
		['iuml','ï'],
		['eth','ð'],
		['ntilde','ñ'],
		['ograve','ò'],
		['oacute','ó'],
		['ocirc','ô'],
		['otilde','õ'],
		['ouml','ö'],
		['divide','÷'],
		['oslash','ø'],
		['ugrave','ù'],
		['uacute','ú'],
		['ucirc','û'],
		['uuml','ü'],
		['yacute','ý'],
		['thorn','þ'],
		['yuml','ÿ'],
        ['quot', '"']
    ];

    for (var i = 0, max = entities.length; i < max; ++i) 
        text = text.replace(new RegExp('&'+entities[i][0]+';', 'g'), entities[i][1]);

    return text;
}

/*****************************************
  PERMET DE RETOURNER LE NOMBRE DE LIGNES TR 
 *****************************************/
function getBody(element) {
    var divider = 2;
    var originalTable = element.clone();
    var tds = $(originalTable).children('tbody').children('tr').length;
    return tds;
}


Number.prototype.between  = function (a, b) {
    var min = Math.min.apply(Math, [a,b]),
        max = Math.max.apply(Math, [a,b]);
    return this > min && this < max;
};

// menu top fixed !
$(window).scroll(function(){
	if($(window).scrollTop() > 75){
		$('.menuTop').css("position","fixed");
		$('.menuTop').css("top","0");
		$('.menuTop').css("margin","0");
		$('.menuTop').css("padding","0");
		$('.menuTop').css("right","0");
		$('.menuTop').css("z-index","9998");
		$('.menuTop').css("width","100%");
		$('.menuTop ul').css("margin-left","55px");
	}else{
		$('.menuTop').css("position","");
		$('.menuTop').css("top","");
		$('.menuTop').css("margin","");
		$('.menuTop').css("padding","");
		$('.menuTop').css("right","");
		$('.menuTop').css("z-index","");
		$('.menuTop').css("width","");
		$('.menuTop ul').css("margin-left","");
	}
});
