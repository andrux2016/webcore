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
	
	var NameID = $('input[type=hidden]').attr('name');
	var ValID = $('input[type=hidden]').val();
	$('input').each(function( index ) {
		if($(this).attr('type') == "radio" || $(this).attr('type') == "checkbox"){
			var AjaxPage = $(this).parent().parent().parent().attr('id')+'Edit';
			
			$(this).change(function () {
				var POST = encodeURI(NameID + "=" + ValID + "&" +$(this).attr('name') + "=" + $(this).attr('value'));
				console.log(POST);
				// request Ajax : Update
				$.ajax({
					type	: 'POST',
					dataType: 'json',
					url		: getBaseURL() + '/ajax/'+ AjaxPage +'/',
					data	: POST,
					
					success : function(Data) {
						console.log("Ok, la maj est faite .");
					},
					fail : function() {
						console.log("Erreur, La méthode n'est pas écrite .");
					}
				});
			});
		}
	});
});