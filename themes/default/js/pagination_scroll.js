/**
 * This file is part of Cloud-Partner
 *
 * @license none
 *
 * Copyright (c) 2008-Present, CIIAB
 * All rights reserved.
 *
 * create 2018 by CEOS-IT
 */
 
var loading = false;
$(document).ready(function() {	
	$('table').after("<div id='loader'><img src='" + getBaseURL() + "/images/ajax-loader.gif' alt='Loading' width='48px' height='48px'></div>");
	$('#loader').hide();
});

$(window).scroll(function(event){
	if ($(document).height() > $(window).height()) { 
		var height = parseFloat($('body').height() - $(window).height());
		var scrollex = parseFloat(($(this).scrollTop()));
		var method = "load" + $("table").attr("id");
		var pagination = localStorage.getItem("pagination_"+ $("table").attr("id"));
		var compteur = localStorage.getItem("compteur_"+ $("table").attr("id"));

		if(pagination == null){
			localStorage.setItem("pagination_"+ $("table").attr("id"),getBody($("table")));
		}

		if(compteur == null){
			localStorage.setItem("compteur_"+ $("table").attr("id"),1);
		}
		
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			var additional = 2.5;
		}else{
			var additional = 1;
		}
		
		if(!loading && scrollex.between((parseFloat(height) - additional),(parseFloat(height) + additional)))
		{
			var POST = "Pagination="+pagination;
			console.log(POST);
			if(compteur == 1 && pagination <= getBody($("table"))){
				loading = true;
				$('#loader').show();
				$.ajax({
					type	: 'POST',
					dataType: 'json',
					url		: getBaseURL() + '/ajax/'+ method +'/',
					data	: POST,
					
					success : function(Data) {

						var tr = "";
						td = [];
						$(Data.request).each(function(index) {
							tr += "<tr>";
							for( var attrObject in this ) {
								
								if(Data.request[index][attrObject] == null){
									Data.request[index][attrObject] = "";
								}
								
								td[index] += "<td>";
								td[index] += Data.request[index][attrObject];
								td[index] += "</td>";
							}
							tr += td[index];
							tr += "</tr>";
						});

						if(getBody($("table")) <= parseInt(Data.amount)){
							localStorage.setItem("compteur_"+ $("table").attr("id"),0);
							if($("table tbody").append(tr)){
								localStorage.setItem("pagination_"+ $("table").attr("id"),getBody($("table")));
								localStorage.setItem("compteur_"+ $("table").attr("id"),1);
							}
						}
						
						loading = false;
						$('#loader').hide();
					},
					fail : function() {
						console.log("Erreur, La méthode n'est pas écrite .");
					}
				});
			}
		}
	}
});