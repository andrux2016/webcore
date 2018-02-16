/** TRADUCTION EN DIRECT **/
$(document).ready(function(){
	
	var code = sessionStorage.getItem("lang");
	
	$(".langue").click(function() {
		sessionStorage.setItem("lang",$(this).data("lang"));
		checkLanguage(this);
	});
	
	if(typeof code != 'undefined'){
		checkLanguage(code);
	}
});

function checkLanguage(object){
	
	if(typeof $(object).data("lang") == 'undefined'){
		var code = object;
	}else{
		var code = $(object).data("lang");
	}
	
	
	$.ajax({
		type	: 'POST',
		dataType: 'json',
		url		: getBaseURL() + '/ajax/lang/',
		data	: 'code='+code,
		
		success : function(Data) {

			array = [];
			for( var i in Data ) {
				array[i] = Data[i];
			}

			// les champs avec la class .text
			$("title").text(array[$("title").data("translate")]+" ");
			
			$( ".text" ).each(function( index ) {
				$( this ).text(array[$( this ).data("translate")]+" ");
			});
			
			$( 'button' ).each(function( index ) {
				$( this ).text(array[$( this ).data("translate")]+" ");
			});
			
		},
		fail : function(Data) {
			console.log("Ko");
		}
	});
}