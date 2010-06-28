function initializeOpposingTeams(){
	
	//add class to headers for proper sorting
	$("#teamsTable .masthead .numericSort").addClass("{sorter: 'numeric'}")
	
	
	$("#teamsTable").tablesorter().tablesorterPager({container: $("#pager")}); ;
	

}
