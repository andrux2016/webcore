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
function getBaseURL()
{
    var url = location.href;
	var cpt = 0;
    var baseURL = url.substring(0, url.indexOf('/', 14)); 
 
	if (baseURL.indexOf('http://localhost') != -1) {
			var pathname = location.pathname;
			var index1 = url.indexOf(pathname);
			var index2 = url.indexOf("/", index1 + 1);
			var baseLocalUrl = url.substr(0, index2);
			var existence = pathname.split("/");
			
			var namePage = window.location.pathname;
			namePage = namePage.split("/");
			namePage = namePage[namePage.length - 1];

			for(var i = 1;i<=existence.length;i++)
			{
				if(existence[i] != '' && typeof existence[i]!="undefined")
				{
					cpt ++;
				}
			}
			
			if(cpt >= 2){
				if(namePage.length > 0){
					return url.substr(0,url.length - 1 - namePage.length);
				}else{
					return url.substr(0,url.length - 1);
				}
			}else{
				return baseLocalUrl;
			}
			
	}
	else 
	{
			var pathname = location.pathname;
			var index1 = url.indexOf(pathname);
			var index2 = url.indexOf("/", index1 + 1);
			var baseLocalUrl = url.substr(0, index2);

		return baseURL;
	}
};
console.log(getBaseURL());