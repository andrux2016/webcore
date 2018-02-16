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
	
	var page = $("table").attr("id");
	
	$("#"+ page +" input").each(function(index) {
		$(this).keyup(function() {
			if($(this).val().length >= 4){
				
				/* system list
				if($("#listSearch" + $(this).attr('name')).length <= 0){
					$(this).after("<div id='listSearch" + $(this).attr('name') +"' class='listSearch'></div>");
				}*/
				
				var InputObject = $("#listSearch" + $(this).attr('name'));
				
				var POST = encodeURI($(this).attr('name') + "=" + $(this).val());
				$.ajax({
					type	: 'POST',
					dataType: 'json',
					url		: getBaseURL() + '/ajax/searchIn'+ page +'/',
					data	: POST,
					
					success : function(Data) {
						var tr = "";
						td = [];
						/* system list
							var texte = "";
							$(Data).each(function( index ) {
								texte += "<p>"+ this.value + "</p>";
							});
							
							
							$(InputObject).html(texte);
							$("#" + $(InputObject).attr('id') +" p").click(function() {
								var NameSelected = $(this).text();

							});
						*/
						$(Data).each(function(index) {
							tr += "<tr>";
							var i = 0;
							for( var attrObject in this ) {
								
								if(Data[index][attrObject] == null){
									Data[index][attrObject] = "";
								}

								if(i == 0){
									td[index] += "<td class='id'>";
								}else{
									td[index] += "<td>";
								}
								td[index] += Data[index][attrObject];
								td[index] += "</td>";
								i++;
							}
							tr += td[index];
							tr += "</tr>";
						});
						$("table tbody tr").hide();
						$("table tfoot").html(tr);
					},
					fail : function() {
						console.log("Erreur, La méthode n'est pas écrite .");
					}
				});
			}else{
				$("#listSearch" + $(this).attr('name')).remove();
				$("table tbody tr").show();
				$("table tfoot tr").remove();
			}
		});
	});
});