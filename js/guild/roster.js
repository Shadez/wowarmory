var fil_ele;
var filVal;
var unfilteredTable;
var unfilteredTableRows;
var noSearchResults = "";
var MAX_LEVEL = 80;
var MIN_LEVEL = 10;

function initGuildRoster(noSearchResultsTxt){
	
	noSearchResults = noSearchResultsTxt; 

	var sorterObj = $("#rosterTable").tablesorter().tablesorterPager({container: $("#pager")});
	unfilteredTable = new Object(sorterObj[0]);	
	unfilteredTableRows = unfilteredTable.config.rowsCopy;
	
	fil_ele = {
		charName: 	$("#filCharName"),
		minLevel: 	$("#filMinLevel"),
		maxLevel: 	$("#filMaxLevel"),
		race: 		$("#filRaceSelect"),
		gender: 	$("#filGenderSelect"),
		charClass: 		$("#filClassSelect"),
		rank: 		$("#filRankSelect")		
	}
	
	
	//delay input typing
	var searchTimer; //for timeout	
	$(fil_ele.charName).keyup(function() {
		if(searchTimer != null){ clearTimeout(searchTimer); }
		searchTimer = setTimeout("runGuildRosterFilters()", 100);
	});
	
	$(fil_ele.minLevel).keyup(function() {
		if(searchTimer != null){ clearTimeout(searchTimer); }
		searchTimer = setTimeout("runGuildRosterFilters()", 100);
	});
	
	$(fil_ele.maxLevel).keyup(function() {
		if(searchTimer != null){ clearTimeout(searchTimer); }
		searchTimer = setTimeout("runGuildRosterFilters()", 100);
	});
}


function runGuildRosterFilters(){
	
	//get all the values
	filVal = {
		charName: 	$.trim($(fil_ele.charName)[0].value.toLowerCase()),
		minLevel: 	$.trim($(fil_ele.minLevel)[0].value)*1,
		maxLevel: 	$.trim($(fil_ele.maxLevel)[0].value)*1,
		race: 		$(fil_ele.race)[0].value,
		gender: 	$(fil_ele.gender)[0].value,
		charClass: 	$(fil_ele.charClass)[0].value,
		rank: 		$(fil_ele.rank)[0].value
	}
	
	var newRows = [];
	
	//reset back to min level
	if(isNaN(filVal.minLevel) || (filVal.minLevel == "") ){
		$(fil_ele.minLevel)[0].value = MIN_LEVEL;
		filVal.minLevel = MIN_LEVEL;	
	}
	
	//reset back to max level
	if(isNaN(filVal.maxLevel) || (filVal.maxLevel == "")){
		$(fil_ele.maxLevel)[0].value = MAX_LEVEL;
		filVal.maxLevel = MAX_LEVEL;	
	}
	
	
	if( (filVal.charName == "") && (filVal.minLevel == MIN_LEVEL) && (filVal.maxLevel == MAX_LEVEL) && (filVal.race == "-1") 
			&& (filVal.gender == "-1") && (filVal.charClass == "-1") && (filVal.rank == "1") ){		
		newRows = unfilteredTableRows;
	}else{
		//loop through table and check values
		$(unfilteredTableRows).each(function(i){
			
			var currRow = $(this).children();
			var numAdd = 0;
			
			//char name
			if(filVal.charName != ""){
				var currChar = $(currRow[0]).children()[0].innerHTML.toLowerCase();
				if(currChar.indexOf(filVal.charName) != -1) numAdd++;
			}else{ numAdd++ }
			
			//level
			if((filVal.minLevel != MIN_LEVEL) || (filVal.maxLevel != MAX_LEVEL)){
				var currLevel = $(currRow[2])[0].innerHTML*1;
				if((currLevel >= filVal.minLevel) && (currLevel <= filVal.maxLevel)) numAdd++;
			}else{ numAdd++ }			

			//race
			if(filVal.race != "-1"){
				if($(currRow[3]).children()[1].innerHTML == filVal.race) numAdd++;
			}else{ numAdd++ }
			
			//gender
			if(filVal.gender != "-1"){
				if($(currRow[4]).children()[2].innerHTML == filVal.gender) numAdd++;
			}else{ numAdd++ }
			
			//class
			if(filVal.charClass != "-1"){
				if($(currRow[4]).children()[1].innerHTML == filVal.charClass) numAdd++;
			}else{ numAdd++ }
			
			//rank
			if(filVal.rank != "-1"){
				if($(currRow[5]).children()[0].innerHTML == filVal.rank) numAdd++;
			}else{ numAdd++ }
			
			
			if(numAdd == 6){	
				newRows.push($(this));				
			}											 
		});		
	}
	
		//wrap in try/catch to prevent weird errors
	try{		
		var tempTbody = $("#rosterTable tbody")[0];
		tempTbody.innerHTML = "";
	}catch(e){ }

	for(var p=0; p < newRows.length; p++){
		tempTbody.appendChild(newRows[p][0]);
	}
	
	//show no search results message
	if(newRows.length == 0){
		var oneRow = document.createElement("tr");
		var oneCell = document.createElement("td");			
		
		oneCell.innerHTML = noSearchResults;
		oneCell.setAttribute("colspan","7");			
		oneRow.appendChild(oneCell);
		
		tempTbody.appendChild(oneRow);	
		
		newRows = [$(oneRow)];
	}

	$("#rosterTable").trigger("update");	
	$.tablesorterPager.appender(unfilteredTable,newRows,tempTbody);
	
	bindToolTips();	
}


function resetRosterFilters(){
	
	fil_ele.charName[0].value = "";
	fil_ele.minLevel[0].value = MIN_LEVEL;
	fil_ele.maxLevel[0].value = MAX_LEVEL;
	fil_ele.race[0].value = "-1";
	fil_ele.gender[0].value = "-1";
	fil_ele.charClass[0].value = "-1";
	fil_ele.rank[0].value = "-1";
	
	runGuildRosterFilters();
	
}