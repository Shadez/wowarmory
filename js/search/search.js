function initSearchResults(searchType, searchTxt, upgradeTxt, filterValues, relColIndex){

	if((searchType == "items") && (upgradeTxt == "")){
		$("#searchQuery")[0].value = searchTxt;
		
		//go through each filter and trigger change and set value
		for(var filter in filterValues){
			try{
				var filterElement = document.getElementById(filter);					
				filterElement.value = filterValues[filter];					
				$("#"+filter).trigger("change");
			}catch(e){}			
		}	
	}
	
	try{
		document.getElementById('replaceShowFilters1').innerHTML = textHideItemFilters;
		document.getElementById('replaceShowFilters2').innerHTML = textHideItemFilters;		
	}catch(e) {}
	
	$("#searchResultsTable").tablesorter({sortList: [[relColIndex,1]]}).tablesorterPager({container: $("#pager") });
	

	
	
	triggerRender();
}


function triggerRender(){	
	//ie7 render fail
	if($.browser.msie && $.browser.version == "7.0"){
		$("#searchResultsTable th .sortArw").hide();	
		$("#searchResultsTable th .sortArw").show();
	
		$("#searchResultsTable .rel-container").hide();
		$("#searchResultsTable .rel-container").show();
	}
	
}