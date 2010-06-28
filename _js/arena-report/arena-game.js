function initializeArenaGame(startTime, matchLength, offset){
	
	$("#arenaGameTable .masthead .numericSort").addClass("{sorter: 'numeric'}")
	
	//truncate vars
	$(".truncateMe").each(function(){
		var truncStr = $(this)[0].innerHTML;
		
		if(truncStr.length > 15){
			truncStr = truncStr.substr(0,15);
			truncStr = truncStr + "...";
			$(this)[0].innerHTML = truncStr;
		}
								   
	});
	
	
	$("#arenaGameTable").tablesorter();
	
	dateLocalization();
	
	$("#matchStartTime").html( new Date((startTime*1) + (offset*1)).asUTCTime());
	
	var matchMins = Math.floor(matchLength / 60);
	var matchSecs = matchLength - (matchMins*60)

	$("#matchLength").html(matchMins + " " + Date.minutes + " " + matchSecs + " " + Date.seconds);
	
	
}