// mode de sauvegarde de secours offline !
function checkConnexion(){
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		url		: getBaseURL() + '/offline.php',
		
		success : function(Data) {
			if(Data.resultat == 'BDD'){
				$("#msg").html(Data.msg);
			}
			else if(Data.resultat == 'multiconnexion'){
				$("#msg").html(Data.msg);
				setTimeout("redirect()",3000);
			}
		},
		fail : function(Data) {
			console.log("Ko");
		}
	});  
	setTimeout("checkConnexion()", 3500);
}
window.onload = checkConnexion;


function redirect(){
	document.location.href = getBaseURL() + "/auth/logout";
}