var unfilteredTable;
var unfilteredTableRows;
var noSearchResults = "";
var arenaSeason;
var TimeZoneOffset = 0;
var g; //holds references to dom objects
var fil; //holds filter stuff
var DOM_READY = false;
var limitData = null;
var linkBattlegroup = "";


function initializeArenaReportGraph(noSearchResultsTxt, seasonStart, seasonEnd, timezoneOffset, highestRating, lowestRating, battleGroup, strCurrent){	
		
	//run date localization strings.js	
	dateLocalization(); 
		
	TimeZoneOffset = timezoneOffset * 1; //make sure its int
	noSearchResults = noSearchResultsTxt; 
	linkBattlegroup = battleGroup;
	
	//store dom elements
	g = {
		ratingLeft:				 $("#textRatingLeft"),
		ratingRight:			 $("#textRatingRight"),
		details:				 $("#containerDetails"),
		delta:					 $("#containerDelta"),
		ratingChangeInterval:	 $("#textRatingChangeInterval"),
		changeAvg:				 $("#textRatingChangeAverage"),
		matchHighlight:			 $("#matchHighlight"),
		ratingChange:			 $("#textRatingChange"),
		textDate:				 $("#textDate"),
		currResults:			 $("#currResults"),
		totalResults:			 $("#totalResults"),
		textOpponent:			 $("#textOpponent"),
		textRatingNew:			 $("#textRatingNew"),
		textStartDate:			 $("#textStartDate"),
		textGamesPlayed:		 $("#textGamesPlayed"),
		textEndDate:			 $("#textEndDate"),
		arenaFlash:				 $("#arenaFlash")
	};
	
	fil = {
		opponentVal: 	$("#opponentVal"),
		ratingMin: 		$("#ratingMin"),
		ratingMax: 		$("#ratingMax"),
		ratingChange: 	$("#ratingChange"),
		ratingLogic: 	$("#ratingLogic"),
		dateStart: 		$("#dateStart"),
		dateEnd: 		$("#dateEnd")	
	};
	

	arenaSeason = { start: new Date(seasonStart*1).asString(), 
				 	end: (seasonEnd == "today") ? (new Date()).asString() : new Date(Date.fromString(seasonEnd)).asString(),
					highestRating: highestRating,
					lowestRating: lowestRating
				  };
				  
	$("#blueStartDate")[0].innerHTML = arenaSeason.start;
	$("#blueEndDate")[0].innerHTML = (seasonEnd == "today") ? strCurrent : arenaSeason.end;
	
	formatDatesInTable();

	//date picker - start, bind events
	$(fil.dateStart).datePicker({ startDate: arenaSeason.start, endDate: arenaSeason.end, verticalOffset: 10, horizontalOffset: 100 })
				   .html(arenaSeason.start).trigger('change')
				   .click(function(){ $(fil.dateStart).dpDisplay() });
	//bind clicks
	$('#dateStartLink').click(function(){ $(fil.dateStart).dpDisplay()});
	$('#tdDateStart').click(function(){ $(fil.dateStart).dpDisplay() });
	
	//date picker - end, bind events
	$(fil.dateEnd).datePicker({ startDate: arenaSeason.start, endDate: arenaSeason.end, verticalOffset: 10, horizontalOffset: 100})
				 .html(arenaSeason.end).trigger('change')
				 .click(function(){	$(fil.dateEnd).dpDisplay() });
	//bind clicks
	$('#dateEndLink').click(function(){ $('#dateEnd').dpDisplay() });
	$('#tdDateEnd').click(function(){  $('#dateEnd').dpDisplay() });
	
	//make table sortable and pageable
	var sorterObj = $("#matchTable").tablesorter().tablesorterPager({container: $("#pager")});
	
	unfilteredTable = new Object(sorterObj[0]);	
	unfilteredTableRows = unfilteredTable.config.rowsCopy;	
	
	$("#textTotalGames").html(unfilteredTableRows.length); //add 1 for the "first game"
		
	/*var searchTimer; //for timeout	
	$("#opponentVal").keyup(function() {
		//console.log("opponentVal --- runFilters");
		if(searchTimer != null){
			//console.log("clear timeout");
			clearTimeout(searchTimer);
		}
		searchTimer = setTimeout("runFilters()", 100);
	});*/
	
	//if there is an opponent in the url, get its value and run a filter against those opponents
	var currUrl = location.href;
	if(currUrl.indexOf("_opp") > -1){
		currUrl = currUrl.substr(currUrl.indexOf("_opp=") + 5);
		
		if(currUrl.indexOf("&") != -1){
			currUrl = currUrl.substr(0,currUrl.indexOf("&"));
		}
		
		currUrl = currUrl.replace(/\+/g," ");
		$(fil.opponentVal)[0].value = currUrl.replace(/\%20/g," ");
		runFilters();		
	}
	
	$("#pageSize").bgiframe();
	
	DOM_READY = true;
	
	//call limit data again if it was called before dom was ready	
	if(limitData != null){
		LimitData(limitData.dateleft,limitData.dateright,limitData.gamesplayed,limitData.ratingchange,limitData.ratingleftchange, limitData.ratingrightchange)		
	}
	
	
	
	//fixFlashFocus();

}

/*************************************
 FILTERS
*************************************/
function runFilters()
{
	var searchVals = {
		opponentVal: 	$.trim($(fil.opponentVal)[0].value).toLowerCase(),
		startDate:	 	Date.fromString($(fil.dateStart).html()).asString(),
		endDate:	 	Date.fromString($(fil.dateEnd).html()).asString(),
		minRating:	 	$(fil.ratingMin)[0].value*1,
		maxRating:	 	$(fil.ratingMax)[0].value*1,
		ratingChange:	$.trim($(fil.ratingChange)[0].value)*1,
		ratingLogic:	$(fil.ratingLogic)[0].value
	};
	
	var newRows = [];
	var rowhtml = "";

	//skip opponent filter if the field is blank
	if(searchVals.opponentVal != ""){		
		newRows = filterOpponent(unfilteredTableRows,searchVals.opponentVal);
	}else{
		newRows = unfilteredTableRows;
	}
	
	//filter dates	(only filter if dates have changed)
	if(!((searchVals.startDate == arenaSeason.start) && (searchVals.endDate == arenaSeason.end))){
		newRows = filterDate(newRows, new Date(searchVals.startDate), new Date(searchVals.endDate))			
	}
	
	//filter ratings (only run filter if rating is different)
	if(!((searchVals.minRating == arenaSeason.lowestRating) && (searchVals.maxRating == arenaSeason.highestRating))){		
		newRows = filterRating(newRows, searchVals.minRating, searchVals.maxRating);	
	}
	
	if((searchVals.ratingLogic != "all") && !(isNaN(searchVals.ratingChange))){
		newRows = filterRatingChange(newRows, searchVals.ratingLogic, searchVals.ratingChange);
	}
	
	$(g.currResults)[0].innerHTML = newRows.length.toString();
	$(g.totalResults)[0].innerHTML = unfilteredTableRows.length.toString();
	
	//if(newRows.length == unfilteredTableRows.length){
	//	$.tablesorterPager.appender(unfilteredTable,unfilteredTableRows);
	//}else{
		//if there are no rows, show an empty row with a message
		if(newRows.length == 0){
			rowhtml = "<tr><td colspan=\"4\">"+noSearchResults+"</td></tr>";		
			newRows = [$(rowhtml)];
		}else{
			//make html rows (need for trigger("update")
			$(newRows).each(function(i){
				rowhtml += "<tr>"+$(this).html()+"</tr>";
			});
		}
		
		
		$("#matchTable tbody")[0].innerHTML = rowhtml;	
		$("#matchTable").trigger("update");	
		$.tablesorterPager.appender(unfilteredTable,newRows);

	//rebind tooltip
	bindToolTips();
}

function resetFilters(){	
	$(fil.opponentVal)[0].value	= "";	
	$(fil.ratingMin)[0].value	= arenaSeason.lowestRating;
	$(fil.ratingMax)[0].value	= arenaSeason.highestRating;	
	$(fil.ratingChange)[0].value = "";
	$(fil.ratingLogic)[0].value	= "all";
	
	$(fil.dateStart).html(arenaSeason.start);
	$(fil.dateEnd).html(arenaSeason.end);
	
	runFilters();
}

function filterOpponent(rows, filterVal){		
	var emptyArr = [];
	
	$(rows).each(function(i){			  
		var currOpponent = $(this).find("td:first > span").html().toLowerCase();
		
		if(currOpponent.indexOf(filterVal) != -1){
			emptyArr.push($(this));
		}		
	});	
	return emptyArr;
}

function filterDate(rows, startDate, endDate){
	var emptyArr = [];
	
	$(rows).each(function(i){
		var currDate = new Date($(this).find("td:eq(3) > span").html().toLowerCase()*1);
		if((currDate >= startDate) && (currDate <= endDate)){
			emptyArr.push($(this));
		}
	});	
	return emptyArr;
}

function filterRating(rows, minRating, maxRating){
	var emptyArr = [];
	
	$(rows).each(function(i){
		var currRating = $(this).find("td:eq(1)").html()*1;
		if((currRating >= minRating) && (currRating <= maxRating)){
			emptyArr.push($(this));
		}
	});	
	return emptyArr;	
}

function filterRatingChange(rows, logicType, ratingChange){
	if(ratingChange == ""){
		return rows;
	}
		
	var emptyArr = [];
	
	$(rows).each(function(i){
		var currRatingChange = $(this).find("td:eq(2) > span").html();
		currRatingChange = currRatingChange.replace(/\+/g,"")*1;		
		switch(logicType){
			case "eq":
				if(currRatingChange == ratingChange)	emptyArr.push($(this));
				break;
			case "gt":
				if(currRatingChange > ratingChange)		emptyArr.push($(this));
				break;
			case "gte":
				if(currRatingChange >= ratingChange)	emptyArr.push($(this));
				break;
			case "lt":
				if(currRatingChange < ratingChange)		emptyArr.push($(this));
				break;
			case "lte":
				if(currRatingChange <= ratingChange)	emptyArr.push($(this));
				break;			
		}
	});	
	return emptyArr;
}
/*************************************
 END FILTERS
*************************************/
function fixFlashFocus(){
	if(!$.browser.msie){
		$("#graphContainer").focus(); //set element to focus to fix safari/chrome bug
	}
}


function PrintResults(opponent,ratingnew,ratingchange,date) {
	
	$(g.details)[0].style.display = "block";
	$(g.details)[0].style.visibility = "visible";
	
	$(g.delta)[0].style.display = "none";
	$(g.delta)[0].style.visibility = "hidden";
	
	$(g.textRatingNew)[0].innerHTML = ratingnew;
	$(g.textOpponent)[0].innerHTML = opponent;
	
	$(g.textDate)[0].innerHTML = '<span class="detailsBlueItalic">' + new Date((date*1) + TimeZoneOffset).asUTCTime() + '</span>';
	
	if (ratingchange >= 0) {
		$(g.ratingChange)[0].innerHTML = "+"+ratingchange;
		$(g.ratingChange).attr("class","detailsRatingChangeGreen");
	}else {
		$(g.ratingChange)[0].innerHTML = ratingchange;
		$(g.ratingChange).attr("class","detailsRatingChangeRed").html(ratingchange);
	}
}



function LimitData(dateleft,dateright,gamesplayed,ratingchange,totalgames, ratingleftchange, ratingrightchange) {	
	//dom isnt ready, so values cant be set until it is, store the values
	if(!DOM_READY){
		limitData = {
			dateleft: dateleft,
			dateright: dateright,
			gamesplayed: gamesplayed,
			ratingchange: ratingchange,
			ratingleftchange: ratingleftchange,
			ratingrightchange: ratingrightchange
		};
		
	}else{
		var dateRange = {
			start:  new Date(dateleft*1 + TimeZoneOffset).asUTCTime(),
			end:	new Date(dateright*1 + TimeZoneOffset).asUTCTime()
		};
	
		$(g.textStartDate)[0].innerHTML = "<span class='detailsBlueItalic'>"+ dateRange.start + "</span>";
		$(g.textEndDate)[0].innerHTML = "<span class='detailsBlueItalic'>"+ dateRange.end + "</span>";	
	
		$(g.textGamesPlayed)[0].innerHTML = gamesplayed;		
	
		if (ratingchange >= 0) {
			$(g.ratingChangeInterval).attr("class","limitRatingChangeGreen");
			$(g.ratingChangeInterval)[0].innerHTML = ratingchange.toString();		
			$(g.changeAvg).attr("class","limitAverageChangeGreen")
			$(g.changeAvg)[0].innerHTML = Math.round(100*ratingchange/gamesplayed)/100;
		}
		else {		
			$(g.ratingChangeInterval).attr("class","limitRatingChangeRed")
			$(g.ratingChangeInterval)[0].innerHTML = ratingchange;		
			$(g.changeAvg).attr("class","limitAverageChangeRed")
			$(g.changeAvg)[0].innerHTML = Math.round(100*ratingchange/gamesplayed)/100;
		}
		$(g.ratingLeft)[0].innerHTML = ratingleftchange;	
		$(g.ratingRight)[0].innerHTML = ratingrightchange;
	}
	
	fixFlashFocus();
}

function FnHideGameDetails() {	
	//$(g.details).attr("style","visibility: hidden; display: none");
	//$(g.delta).attr("style","visibility: visible; display: block");	
	
	//fixFlashFocus();
	
	var detailElement = document.getElementById("containerDetails");
	var deltaElement = document.getElementById("containerDelta");
	
	deltaElement.style.display = "block";
	deltaElement.style.visibility = "visible";
	
	detailElement.style.display = "none";
	detailElement.style.visibility = "hidden";
	
}

function FnShowGameDetails() {
	//$(g.details).attr("style","visibility: visible; display: block");
	//$(g.delta).attr("style","visibility: hidden; display: none");
	
	//fixFlashFocus();
}

function OpenReportPage(id) {
	window.location = "/arena-game.xml?b=" + linkBattlegroup + "&gid="+ id;
}

function FnHighlightInFlash(id) {
	thisMovie("arenaflashFlash").fromJSHighlightMatch(id);
	$(g.matchHighlight).show();
}

function FnClearHighlightInFlash() {	
	thisMovie("arenaflashFlash").fromJSClearHighlightMatch();
	$(g.matchHighlight).hide();
}

function FnViewRecentInFlash() {
	thisMovie("arenaflashFlash").fromJSViewRecent();
}

function FnViewSeasonInFlash() {
	thisMovie("arenaflashFlash").fromJSViewSeason();
}

//called from flash when problem loading the xml
function errorLoadingFlash(){	
	$("#matchHolder").hide();
	$("#graphContainer").hide();
	
	$("#errorLoadingArenaData").attr("style","display: block");
}


function FnEmptyXML() {
	//$("#graphContainer").hide();	
	//$("#graphNone").show();
}

function FnGetGameStart(){
	return $("#gameStartVal").html();	
}

function formatDatesInTable(){
	$("#matchTable .timeFormat").each(function(){
		$(this)[0].innerHTML = new Date(($(this).html()*1) + TimeZoneOffset).asUTCTime();
	});
}