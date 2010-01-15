var charsSelected = 0;

//intializes the character select page
function initializeCharacterSelect(numChars){
	
	$("#searchTable > ul").tabs(); //bind tabs
	
	charsSelected = numChars*1; //make sure its a number
	
	//set dual tooltip checkbox
	if (getcookie2("armory.cookieDualTooltip") == 1){
		$("#checkboxDualTooltip").attr("checked","checked");
	}
	
	//bind sort table
	$(".charSelectTabDiv table").tablesorter();	
	
	//bind tooltips for the sword/crown icons
	setCharacterToolTips();
	
	$(".selSecondaryChar").click(function(){
		$(".selChar").each(function(){
			$(this).addClass("charToAdd");
		});		
		$(this).addClass("newPrimaryChar");
		
		updateCharIcons(getCollectedCharUrls());
	});
		
	$(".delChar").click(function(){
		$(this).prev().removeClass("selChar");
		
		updateCharIcons(getCollectedCharUrls());
	});
	
	//adding from the bottom
	/*$(".add_on").click(function(){
		var currUrl = $(this).next().attr("href");
			
		//secondary are set to 2 or 3
		currUrl = currUrl.substring(currUrl.indexOf(".xml?")+5);		
		currUrl = currUrl.replace("r=","&r"+(charsSelected+1)+"=");
		currUrl = currUrl.replace("n=","n"+(charsSelected+1)+"=");
			
		updateCharIcons(getCollectedCharUrls() + currUrl);	
	});*/
}

//get the urls of the primary and secondary chars
function getCollectedCharUrls(){
	var collectedCharUrls = "";				
	var secondaryCtr = 2; //start at 2 since primary is 1

	$(".selChar").each(function(){
		//happens when a secondary char is getting promoted
		if($(this).hasClass("charToAdd")){
			var currUrl = $(this).attr("id");
			
			if($(this).hasClass("newPrimaryChar")){
				currUrl = currUrl.replace("r=","r1=");
				currUrl = currUrl.replace("n=","n1=");
				collectedCharUrls = currUrl + collectedCharUrls;
			}else{
				currUrl = currUrl.replace("r=","&r"+secondaryCtr+"=");
				currUrl = currUrl.replace("n=","n"+secondaryCtr+"=");
				collectedCharUrls += currUrl;
				secondaryCtr++;
			}
		}else{
			//happens when char gets added from grid
			var currUrl = $(this).attr("id");
			
			if($(this).hasClass("selPrimaryChar")){
				currUrl = currUrl.replace("r=","r1=");
				currUrl = currUrl.replace("n=","n1=");			
				collectedCharUrls = currUrl + collectedCharUrls;
			}else if($(this).hasClass("selSecondaryChar")){
				currUrl = currUrl.replace("r=","&r"+secondaryCtr+"=");
				currUrl = currUrl.replace("n=","n"+secondaryCtr+"=");
				collectedCharUrls += currUrl;
				secondaryCtr++;
			}			
		}
	});
		
	//encode url for special chars				
	return collectedCharUrls;
}

//send ajax request to update characters and reload page
function updateCharIcons(charUrls){	
	/*
	$.ajax({
		type: "GET",
		url: 'character-select-submit.xml?' + charUrls,
		async: false,
		dataType: "text",
		success: function(msg){
			window.location.reload(); //refresh page
		},
		error: function(msg){				
			window.location.reload(); //refresh page
		}
	});*/
}


//boolean for displaying dual tooltips or not
function setDualTooltipCookie() {
    if (document.getElementById('checkboxDualTooltip').checked)
        setcookie("armory.cookieDualTooltip", 1);
    else
        setcookie("armory.cookieDualTooltip", 0);
}
