var guildInfoCont;
var bankFilters;
var filVals;
var noSearchResults = "";


function initGuildBankContents(txtShowGuildInfo, txtHideGuildInfo, noSearchResultsTxt){
	
	noSearchResults = noSearchResultsTxt; 
	
	var sorterObj = $("#bankContentsTable").tablesorter().tablesorterPager({container: $("#pager")});
	unfilteredTable = new Object(sorterObj[0]);	
	unfilteredTableRows = unfilteredTable.config.rowsCopy;
	
	//replace breaks in info
	guildInfoCont = $("#guildInfoContainer");
	guildInfoCont.html(guildInfoCont.html().replace(/\n/g, '<br />'));
	
	//bind toggler
	$("#guildInfoToggler").click(function(){
		$(guildInfoCont).toggle();
		
		if($(guildInfoCont).css("display") == "block")
			$(this).html(txtHideGuildInfo)
		else
			$(this).html(txtShowGuildInfo)
	});
	
	//store elements
	bankFilters = {
		itemName: 		$("#filItemName"),
		itemQuality: 	$("#filRarity"),
		itemType: 		$("#filItemType"),
		tab: 			$("#filTab")
	}
	
	var searchTimer; //for timeout	
	$(bankFilters.itemName).keyup(function() {
		if(searchTimer != null){ clearTimeout(searchTimer); }
		searchTimer = setTimeout("runBankContentFilters()", 100);
	});
}

function toggleBankTab(clickedLink, whichTab, tabText, tabIcon){

	$("#tabContentHolder .oneBankTab").css("display","none");
	$("#banktabs img").css("display","none");
	
	$("#bankHighlight" + whichTab).css("display","block");
	
	$("#banktab" + whichTab).css("display","block");
	$("#whichTabDisplay")[0].innerHTML = tabText;
	
	$("#whichTabDisplay").attr("style","background: url('/wow-icons/_images/43x43/"+tabIcon+".png') no-repeat;");
}

function runBankContentFilters(){
	
	filVals = {
		itemName: 		$.trim($(bankFilters.itemName)[0].value).toLowerCase(),
		itemQuality: 	$(bankFilters.itemQuality)[0].value,
		itemType: 		$(bankFilters.itemType)[0].value,
		tab: 			$(bankFilters.tab)[0].value		
	}
	
	var newRows = [];
	
	if( (filVals.itemName == "") && (filVals.itemQuality == "-1") && (filVals.itemType == "-1") && (filVals.tab == "-1")  ){
		newRows = unfilteredTableRows;		
	}else{
		$(unfilteredTableRows).each(function(i){
			
			var currRow = $(this).children();
			var numAdd = 0;
			
			//item
			if(filVals.itemName != ""){
				var currItem = $(currRow[0]).children()[0].innerHTML.toLowerCase();
				if(currItem.indexOf(filVals.itemName) != -1) numAdd++;
			}else{ numAdd++ }
			
			//quality
			if(filVals.itemQuality != "-1"){
				if($(currRow[2]).children()[0].innerHTML == filVals.itemQuality) numAdd++;
			}else{ numAdd++ }
			
			//item type
			if(filVals.itemType != "-1"){
				if(currRow[1].innerHTML == filVals.itemType) numAdd++;
			}else{ numAdd++ }
			
			//tab
			if(filVals.tab != "-1"){
				if($(currRow[3]).children()[0].innerHTML == filVals.tab) numAdd++;
			}else{ numAdd++ }
		
			
			if(numAdd == 4){
				newRows.push($(this));
			}			
		});
		
	}

	//wrap in try/catch to prevent weird errors
	try{		
		var tempTbody = $("#bankContentsTable tbody")[0];
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

	$("#bankContentsTable").trigger("update");	
	$.tablesorterPager.appender(unfilteredTable,newRows,tempTbody);
	
	bindToolTips();
	
}


//reset the values
function resetBankContentsFilters(){
	
	$(bankFilters.itemName)[0].value = "";	
	$(bankFilters.itemQuality)[0].value = "-1";
	$(bankFilters.itemType)[0].value = "-1";
	$(bankFilters.tab)[0].value = "-1";
	
	runBankContentFilters();
}