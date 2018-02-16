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
$(document).ready(function() {
	$('table').after("<button id='bt_next' data-translate='BT_NEXT' style='margin:auto;padding:auto;'>Suivant</button>");
	var method = "load" + $("table").attr("id");
	
	var pagination = localStorage.getItem("pagination_"+ $("table").attr("id"));
	var compteur = localStorage.getItem("compteur_"+ $("table").attr("id"));

	if(pagination == null){
		localStorage.setItem("pagination_"+ $("table").attr("id"),getBody($("table")));
	}

	if(compteur == null){
		localStorage.setItem("compteur_"+ $("table").attr("id"),1);
	}
	
	
	$("#bt_next").click(function() {
		var pagination = localStorage.getItem("pagination_"+ $("table").attr("id"));
		var POST = "Pagination="+pagination;
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
			},
			fail : function() {
				console.log("Erreur, La méthode n'est pas écrite .");
			}
		});
	});
});