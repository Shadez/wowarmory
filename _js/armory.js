/*****************************************************
 * Master Armory Javascript File
 * Copyright (c) 2008 Blizzard Entertainment
 * !!! Requires jQuery  !!!
 * !!! Requires Sarissa !!!
 *****************************************************/
//GLOBAL VARS
var searchTimerId		= null; //timer id for search menu hiding
var IS_ENABLED_XSLT		= $.browser.opera; //is xslt enabled
var region				= ""; //for determining region
var region				= ""; //region

function initializeArmory(){

	//binds
	bindDropDownMenu();
	bindLanguageLinks();
	
	//only bind bookmark menu if they are logged in
	if(isLoggedIn)
		bindBookmarkMenu();
	else		
		bindLoginLink();

	//always bind tooltips last
	bindToolTips();

	//ads are dead last so we don't wait for them
	initializeAds();
}

function initializeAds()
{	//loadScript("http://ads1.msn.com/library/dap.js") 
	//Does not callback when loaded, following commands error when loaded too soon

	$(document).ready(function() {	

		if(!isHomepage){
			//top, long ad
			dapMgr.enableACB("ad_728x90",false);         
			dapMgr.renderAd("ad_728x90","&amp;PG=BLARS7&amp;AP=1390",728,90);

			//middle box ad
			dapMgr.enableACB("ad_300x250",false);         
			dapMgr.renderAd("ad_300x250","&amp;PG=BLARS3&amp;AP=1089",300,250);

		}
		else{
		//middle box ad
		dapMgr.enableACB("ad_300x250",false);         
		dapMgr.renderAd("ad_300x250","&amp;PG=BLARH3&amp;AP=1089",300,250);
		}

	});

}


//begin cookies section
function getexpirydate(nodays){
	var UTCstring;
	Today = new Date();
	nomilli=Date.parse(Today);
	Today.setTime(nomilli+nodays*24*60*60*1000);
	UTCstring = Today.toUTCString();
	return UTCstring;
}

function getcookie2(cookiename) {
	var cookiestring = "" + document.cookie;
	var index1 = cookiestring.indexOf(cookiename);
	if(index1 == -1 || cookiename == "") return "";
	
	var index2=cookiestring.indexOf(';',index1);
	if (index2 == -1) index2 = cookiestring.length;
	
	return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}
function setcookie(name,value,expire){
	var expireString="EXPIRES="+ getexpirydate(365)+";"
	if(expire == "session") expireString="";
	cookiestring = name + "=" + escape(value) + ";" + expireString + "PATH=/";
	document.cookie = cookiestring;
}

//Gets all cookies based on type ie armory.cookie3dFoo and armory.cookie3dBar and returns them as an object ie modelCookies[foo] = bar 
function getArmoryCookies(type) 
{ 	var modelCookies = {}
	var armory_cookies = document.cookie.toString().split(";") 
	for(xi=0;xi<armory_cookies.length;xi++){ 
			if(armory_cookies[xi].indexOf("armory.cookie"+type) > -1)
			{ 	var tempck = armory_cookies[xi].split("=");  
				modelCookies[tempck[0].split("cookie3d")[1].toLowerCase()] = tempck[1];				
			} 
	}
	return modelCookies
}

if(!init3dvars) var init3dvars = null
function demo3dCharacter(file,charName,attr)
{ 	
	var logolink = modelserver + "/models/images/logo/armory-logo-"+lang+".png" 
	var params = { menu: "false", scale: "noScale", allowFullscreen: "true", allowScriptAccess: "always", bgcolor:"#E3C96A", wmode:"opaque" };
	var attributes = { id:"ModelViewer3" };
	var flashvars = { character: charName, modelUrl:encodeURIComponent(file)+"?"+Math.floor(Math.random()*99991), fileServer: modelserver+"/models/", 
					  embedlink:encodeURIComponent(String(window.location)), strings:stringslink, logoImg:logolink,
					  loadingtxt:loadingText, embedded:true
					};
	if(getcookie2){ var modelCookies = getArmoryCookies("3d"); 
					for(xi in modelCookies) { flashvars[xi] = modelCookies[xi] } 
				  }
	if(init3dvars)	{ for (var i in init3dvars){ flashvars[i] = init3dvars[i]; } 
						if(init3dvars.bgColor){ params.bgcolor = "#"+init3dvars.bgColor.slice(2) }
					}
	if(attr){ for (var i in attr){ flashvars[i] = attr[i]; } }
	swfobject.embedSWF(modelserver+"/models/flash/ModelViewer3.swf", "ModelViewer3", "100%", "100%", "10.0.0", modelserver+"/models/flash/expressInstall.swf", flashvars, params, attributes);
	$(document).ready(function () { if(!bindMouseActions) loadScript("/_js/character/charactermodel.js"); bindMouseActions() });	
}
	


//flash detection
var MM_contentVersion = 8;
var plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
if ( plugin ) {
        var words = navigator.plugins["Shockwave Flash"].description.split(" ");
		var wordsLength = words.length;
        for (var i = 0; i < wordsLength; ++i)
        {
        if (isNaN(parseInt(words[i])))
        continue;
        var MM_PluginVersion = words[i];
        }
    var MM_FlashCanPlay = MM_PluginVersion >= MM_contentVersion;
}
else if (navigator.userAgent && navigator.userAgent.indexOf("MSIE")>=0
   && (navigator.appVersion.indexOf("Win") != -1)) {
    document.write('<SCR' + 'IPT LANGUAGE=VBScript\> \n'); //FS hide this from IE4.5 Mac by splitting the tag
    document.write('on error resume next \n');
    document.write('MM_FlashCanPlay = ( IsObject(CreateObject("ShockwaveFlash.ShockwaveFlash." & MM_contentVersion)))\n');
    document.write('</SCR' + 'IPT\> \n');
}


function showNoflashMessage(){
    document.getElementById("noflash-message").style.display="block";
}

var flashString;
var tempObj;
var flashCount = 1;

function printFlash(id, src, wmode, menu, bgcolor, width, height, quality, base, flashvars, noflash){
	
	if(MM_FlashCanPlay){
		flashString = '<object id= "' + id + 'Flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + width + '" height="' + height + '">' +
						'<param name="movie" value="' + src + '"></param><param name="quality" value="' + quality + '"></param>';
        if(base){
			flashString+='<param name="base" value="' + base + '"/>';
        }
		
		if(menu == ""){
			flashString+='<param name="flashvars" value="' + flashvars + '"></param><param name="bgcolor" value="' + bgcolor + '"></param></param><param name="wmode" value="' + wmode + '"></param><param name="salign" value="tl"></param><embed name= "' + id + 'Flash" src="' + src + '" wmode="' + wmode + '" menu="' + menu + '" bgcolor="' + bgcolor + '" width="' + width + '" height="' + height + '" quality="' + quality + '" pluginspage="http://www.macromedia.com/go/getflas/new-hplayer" type="application/x-shockwave-flash" salign="tl" base="' + base + '" flashvars="' + flashvars + '" /></object>';			
		}else{
			flashString+='<param name="flashvars" value="' + flashvars + '"></param><param name="bgcolor" value="' + bgcolor + '"></param><param name="menu" value="' + menu + '"></param><param name="wmode" value="' + wmode + '"></param><param name="salign" value="tl"></param><embed name= "' + id + 'Flash" src="' + src + '" wmode="' + wmode + '" menu="' + menu + '" bgcolor="' + bgcolor + '" width="' + width + '" height="' + height + '" quality="' + quality + '" pluginspage="http://www.macromedia.com/go/getflas/new-hplayer" type="application/x-shockwave-flash" salign="tl" base="' + base + '" flashvars="' + flashvars + '" /></object>';	
		}

    }else{
        flashString = noflash;
    }

    if((id == "loader") && (!Browser.moz)){
        flashString = noflash;
	}
	
	document.getElementById(id).innerHTML = flashString;
	document.getElementById(id).style.display = "block";
}

function thisMovie(movieName) {
	if (navigator.appName.indexOf("Microsoft") != -1)
		return window[movieName]
	else
		return document[movieName]
}

function popIconLarge(movieName,mcName) {
    if(MM_FlashCanPlay){
        try {
            if(Browser.ie)
                try {thisMovie(movieName).TGotoFrame(mcName,1);}catch(e){throw e;}
            else if(!Browser.opera && thisMovie(movieName) && thisMovie(movieName).TGotoFrame) //exclude opera
                    thisMovie(movieName).TGotoFrame(mcName,1);
        }catch(e){
            throw e;
        }
    }
}

function popIconSmall(movieName,mcName) {
    if(MM_FlashCanPlay){
        try {
            if(Browser.ie)
                try {thisMovie(movieName).TGotoFrame(mcName,2);}catch(e){throw e;}
            else
                if(!Browser.opera && thisMovie(movieName) && thisMovie(movieName).TGotoFrame) //exclude opera
                    thisMovie(movieName).TGotoFrame(mcName,2);
        }catch(e){
            throw e;
        }
    }
}

var currentFaq = 1;

function faqSwitch(faqId){

	$("#faqlink"+currentFaq).attr("class","faq-off");
	$("#faqlink"+faqId).attr("class","faq-over");
    
    currentFaq = faqId;
	
    $('#faq-container').html($("#faq"+faqId).html());
}

function menuCheckLength(formReference){

	if (formReference.searchType.value == "all" && globalSearch == "0") {
		$("#errorSearchType").html('<div class="error-container2"><div class="error-message" style = "position: relative; left: -400px; top: -33px; white-space: nowrap;"><p></p>'+ tScat +'</div></div>');
		return false;
	} else
		$("#errorSearchType").html("");


	if((formReference.searchQuery.value).length <= 1){
		$('#'+formReference.name + '_errorSearchLength').html('<div class="error-container2">'+
			'<div class="error-message">'+
			'<p></p>'+ tStwoChar +'</div></div>');
		return false;
	}

	formReference.submit();
}

function goToPropass() {
	if (getcookie2("armory.cookiePropassBG"))
		document.location.href = "/arena-ladder.xml?b="+encodeURI(getcookie2("armory.cookiePropassBG")) + "&ts=3";
	else
		document.location.href = "/battlegroups.xml#tournament";
}

function fixReportLink(linkId, siteUrl){

	var ele = $('#' + linkId);
	if(ele)	{
		ele = ele.get(0);
		
		var replaceUrl="";
	    if(IS_ENABLED_XSLT && window.historyStorage)
	        replaceUrl = siteUrl + "/" + window.historyStorage.getCurrentPage();
	    else
	        replaceUrl = document.location.href;
	
		var browserVer = "";
		jQuery.each(jQuery.browser, function(i, val) {
			if(i == "version")
				browserVer += " Version: " + val;
			if(val == true)
				browserVer += ", " + i;
		});

		ele.href = ele.href.replace("REPLACEURL", replaceUrl).replace("REPLACEBROWSER", browserVer);

		// Fixes the link for the Spanish (AL) locale
		var pos1 = ele.href.indexOf('mailto:');
		var pos2 = ele.href.indexOf('?subject=');
		var pos3 = ele.href.indexOf('&body=');
		if(pos1 == 0 && pos2 != -1 && pos3 != -1) {
			var email   = ele.href.substring(pos1 + 7, pos2);
			var subject = ele.href.substring(pos2 + 9, pos3);
			var body    = ele.href.substring(pos3 + 6);

			ele.href =
				'mailto:' + email +
				'&subject=' + escape(decodeURIComponent(subject)) +
				'&body=' + escape(decodeURIComponent(body));
		}
	}
}

//transforms the #nav ul set into a drop down menu
function bindDropDownMenu()
{
	$("#nav ul").css({display: "none"}); //fix for opera
	$("#nav li").hover(
		function(){
			//mouseover actions
			var topLevelHoverStyle = "background-color: #122930; color: #FFF; padding: 0; margin: 2px 4px 1px 0px;";
			topLevelHoverStyle += " border: 1px solid black; border-bottom: none;"; 
			var listContainer = $(this).find('ul:first');
			
			$(this).find('ul:first').css({visibility: "visible",display: "none"}).show();
			$(this).children("a:first").attr("style", "background-color: #101615; color: #FFF");
			$(this).children("span:first").attr("style", "background-color: #101615;font-weight:bold;cursor:pointer;color:#FFF;");
			
			if($(this).hasClass("toplevel-li"))
				$(this).attr("style", topLevelHoverStyle);							
			else
				$(this).parents("li.toplevel-li").attr("style", topLevelHoverStyle);

			if(($.browser.msie) && ($.browser.version == "6.0"))
					$(listContainer).children("iframe").attr("style","height: " + ($(listContainer).outerHeight() - 1)+ "px; width: " + ($(listContainer).outerWidth()-20) + "px; display: block;");
		},
		function(){
			//mouseout actions
			$(this).find('ul:first').css({visibility: "hidden"});
			$(this).children("a:first").removeAttr("style"); //clear the added style
			$(this).children("span:first").removeAttr("style"); //clear the added style
			
			if($(this).hasClass("toplevel-li")) {

				var topLevelHoverStyle = "color: #FFF; padding: 0; margin: 2px 4px 1px 0px;";
				if($.browser.msie && $.browser.version == "6.0") {
					topLevelHoverStyle += ' padding: 1px'; 
				} else {
					topLevelHoverStyle += ' border: 1px solid transparent; border-bottom: none;';
				}
					
				$(this).attr("style", topLevelHoverStyle);
			}
		});
}


//creates the "find upgrade" flyout menu on character sheet
function setCharSheetUpgradeMenu()
{
	
	//**************************************************************
	// Custom CSS for menu depending on location on char sheet
	// NOTE: "Combining" common functionality causes issues in ie7
	//**************************************************************
	//mouseout/mouseover on the "find upgrade" flyout menu
	$(".leftItems .fly-horz").hover(
		function(){
			//mouseover actions
			$(this).prev().attr("style", "background-position: -3px 0px");
			$(this).css("display","block");
		},
		function(){
			//mouseout actions
			$(this).prev().attr("style", "");
			$(this).css("display","none");
		});

	$(".rightItems .fly-horz").hover(
		function(){
			//mouseover actions
			$(this).prev().attr("style", "background-position: -75px 0");
			$(this).css("display","block");
		},
		function(){
			//mouseout actions
			$(this).prev().attr("style", "");
			$(this).css("display","none");
		});
	$(".bottomItems .fly-horz").hover(
		function(){
			//mouseover actions
			$(this).prev().attr("style", "background-position: 5px -75px");
			$(this).css("display","block");
		},
		function(){
			//mouseout actions
			$(this).prev().attr("style", "");
			$(this).css("display","none");
		});

	

	$(".upgradeBox").hover(
		function(){
			//mouseover actions	
			if(tipsEnabled != false)
			$(this).parent().siblings(".fly-horz").css("display","block");			
		},
		function(){
			//mouseout actions
			$(this).parent().siblings(".fly-horz").css("display","none");			
		});

}


//appends appropriate parameters to the links that change the languages
function bindLanguageLinks()
{
	$("#languageFooter .langLink").each(function(){
		var currLink	 = location.href; //current url
		var theLangHref  = $(this).attr("href"); //current language href

		//look for parameters
		if(currLink.indexOf("?") != -1){
			//single out params
			currLink = currLink.substr(currLink.indexOf("?") + 1);

			//check if the language href already has parameters
			if(theLangHref.indexOf("?") == -1)
				$(this).attr("href", $(this).attr("href") + "?"+currLink);
			else
				$(this).attr("href", $(this).attr("href") + "&"+currLink);
		}
	});
}

//appends appropriate parameters to the login link
function bindLoginLink()
{
	var currLink = location.href; //current url

	//check if the current page already has parameters
	if(currLink.indexOf("?") == -1){
		$("#loginLinkRedirect").attr("href", currLink + "?login=1");
		$("#bmcLink").attr("href", currLink + "?login=1");
	}else{
		$("#loginLinkRedirect").attr("href", currLink + "&login=1");
		$("#bmcLink").attr("href", currLink + "&login=1");
	}
}

if(!this['L10n'])
	L10n = {};

// uses printf from common.js
// operates on timestamps that are a subset of the XML Schema date-time production
L10n.formatTimestamps = function(domQuery, formatConfig) {
	var datePartRegex = /([\d]{4})-([\d]{2})-([\d]{2})(?:T([\d]{2}):([\d]{2}):([\d]{2})(?:([+-])([\d]{2}):([\d]{2}))?)?/;
	var curTime = (new Date()).getTime();

	$(domQuery).each(function(i) {
		var node = $(this);
		var p = datePartRegex.exec(node.text());
		var d = new Date(Date.UTC(p[1], p[2] - 1, p[3], p[4], p[5], p[6]));

		if(p[8] || p[9])
			d.setUTCMilliseconds((p[8] * 3600000 + p[9] * 60000) * (p[7] == "-" ? 1 : -1));

		var timeDiff = curTime - d.getTime();
		var formattedDate = "";

		if(timeDiff < 172800000 && timeDiff >=0 ) { // within 2 days in the past
			if(timeDiff < 86400000) { // 1 day
				var units, format;

				if(timeDiff < 3600000) { // 1 hour
					units = Math.round(timeDiff / 60000); // minutes
					format = units == 1 ? (formatConfig.withinHourSingular || formatConfig.withinHour) : formatConfig.withinHour;
				} else {
					units = Math.round(timeDiff / 3600000); // hours
					format = units == 1 ? (formatConfig.withinDaySingular || formatConfig.withinDay) : formatConfig.withinDay;
				}
				formattedDate = printf(formatConfig.today, printf(format, units));
			} else {
				formattedDate = formatConfig.yesterday;
			}
		} else {
			formattedDate = formatConfig.date.replace(/([a-zA-Z]+)/g, function(token) {
				switch(token) {
				case "yyyy":
					return d.getFullYear();
				case "M":
					return d.getMonth() + 1;
				case "d":
					return d.getDate();
				default:
					return "?";
				}
			});
		}

		node.text(formattedDate);
		node.show();
	});
}


/*****************************************************
 * Compact Tooltips
 *****************************************************/

//GLOBAL VARS
var itemToolTipXSLLoaded = false;
var theGlobalToolTip	 = null; //global tooltip
var xsltProcessor		 = null;
var dualTipsEnabled		 = false;
var isOnCharSheet		 = false;
var toolVault 			 = [];
var tipsEnabled 		 = true;
var tipsEnabledFacebook = false;

//set the (left,top) / (x,y) position of the tooltip
function setToolTipPosition(tooltipObj,e)
{
	var tipPosition = getXYCoords(tooltipObj,e);
	
	//set the position
	$(theGlobalToolTip).css("left",tipPosition[0]);
	$(theGlobalToolTip).css("top",tipPosition[1]);
	$(theGlobalToolTip).show();
}


//finds the best (x,y) position to put the tooltip
function getXYCoords(tooltipObj,e)
{	
	//boolean to see if we use mouse position or not
	var useMousePosition = false;
	
	//find current x,y position
	var xPos = (tipsEnabledFacebook) ? e.pageX : $(tooltipObj).offset().left;
	var yPos = (tipsEnabledFacebook) ? e.pageY : $(tooltipObj).offset().top;
	
	//if the position comes back as (0,0) use the mouse position instead
	//(also adjust for scrolling!)
	if(((xPos - $(window).scrollLeft()) <= 0) && ((yPos - $(window).scrollTop()) <= 0)){
		useMousePosition =  true;
	}
	
	//get the width of the tooltip box and item we are adding tooltip to
	var tooltipWidth = -1;
	var tooltipHeight = -1;
	var itemWidth 	 = $(tooltipObj).outerWidth();
	var itemHeight 	 = $(tooltipObj).outerHeight();
	
	//find out if we're on the character sheet and if we have comparison tooltips on
	if((isOnCharSheet) && (dualTipsEnabled) && (isLoggedIn) && $(tooltipObj).hasClass("itemToolTip")){
				
		//hide div and set all the way to the left so we can get proper width
		$(theGlobalToolTip).hide();
		$(theGlobalToolTip).css("left",0);
		
		tooltipWidth = $(theGlobalToolTip).outerWidth();	
		
		//for character sheet we want to put the tooltip below the item, and center it		
		xPos = xPos - (tooltipWidth/2);
		yPos = yPos + $(tooltipObj).outerHeight() + 7; //add item height
				
		//if tooltip is going to cause horizontal scrolling, nudge it over
		if((itemWidth + xPos + tooltipWidth + 5) > $(window).width()){
			xPos = $(window).width() - tooltipWidth;
		}
		
		//if it goes negative to the left, set the x to 5
		if(xPos < 0){
			xPos = 5;
		}
	}else{
		tooltipWidth = $(theGlobalToolTip).outerWidth();
		tooltipHeight = $(theGlobalToolTip).outerHeight();
		
		//if we didnt get good coordinates, use the mouse position
		if(useMousePosition == true){
			xPos = e.pageX + 7;
			yPos = e.pageY + 15;
		}
		
		//if tooltip is going to cause horizontal scrolling,
		//put it to the left of the link instead
		if(!tipsEnabledFacebook) {
			if((itemWidth + xPos + tooltipWidth + 5) > $(window).width()){
				xPos = xPos - tooltipWidth - 5;			
			}else{
				xPos = xPos + itemWidth + 5;
			}
		} else {
			xPos = xPos + 15;
		}
	}
	
	yPos = yPos - (tooltipHeight/2);
	//check y position
	
	//(below the fold)
	if((yPos + tooltipHeight) > $(window).height() + $(window).scrollTop()){			
		yPos = $(window).height() - tooltipHeight + $(window).scrollTop();			
	}
	
	//above fold
	if(yPos < $(window).scrollTop()){
		yPos =  $(window).scrollTop();
	}
		
	return [xPos,yPos];
}


//sets the html of thetooltip (div)
function setTipText(tipStr)
{	
	//store scoped reference
	var tooltipTxt = $("#globalToolTip_text");	
	
	$(tooltipTxt).html("");
	$(tooltipTxt).append(tipStr);	
		
	//adds "Click to view this item on the WoW Armory" at the very end of the tooltip used on Facebook app
	if(tipsEnabledFacebook) $(tooltipTxt).append(tooltipItemNotice); 

	//if dual tooltips are enabled, add some borders and some text
	if(dualTipsEnabled){
		$(tooltipTxt).find("td:eq(0)").attr("style","padding-right: 10px; width: 275px;");		

		//ie6 is fail
		if(($.browser.msie) && ($.browser.version == "6.0")){
			$(".myTable").css("width","300px");
		}else{			
			if(!isOnCharSheet){
				$(tooltipTxt).css("max-width","275px");
				$(theGlobalToolTip).css("max-width","275px");
			}else{
				$(tooltipTxt).css("max-width","none");
				$(theGlobalToolTip).css("max-width","none");
			}
		}
	}else{
		if(($.browser.msie) && ($.browser.version == "6.0")){
			if($(tooltipTxt).outerWidth() > 300){
				$(tooltipTxt).css("width","300px");	
			}
		}else{
			//set max width to avoid huge tooltips
			$(theGlobalToolTip).css("max-width","400px");
			$(tooltipTxt).css("max-width","400px");			
		}
		
		//hide 2nd and 3rd column
		$(tooltipTxt).find("td:eq(1)").css("display","none");
		$(tooltipTxt).find("td:eq(2)").css("display","none");
		
	}
	
}

//get the html for an item via ajax
function getItemHtml(itemUrl)
{
	//load XSL stylesheet if we haven't yet	
	if(!($.browser.safari) && !($.browser.safari)){
		if(itemToolTipXSLLoaded == false)
		{
			//get the stylesheet			
			var xslDoc = Sarissa.getDomDocument();
			xslDoc.async = false;
			xslDoc.load("_layout/items/tooltip.xsl");
			
			xsltProcessor = new XSLTProcessor();
			xsltProcessor.importStylesheet(xslDoc);		
			
			itemToolTipXSLLoaded = true;
		}
	}	
	
	$.ajax({
		type: "GET",
		url: itemUrl,
		success: function(msg){		
			
			//cache the tooltip text based on browser
			if(($.browser.safari) || ($.browser.safari)){
				toolVault[itemUrl] = msg;
				
				if(toolVault[itemUrl].length <= 4)
					toolVault[itemUrl] = errorLoadingToolTip;
			}else{
				var bufferedDiv = document.createElement("div");
				bufferedDiv.innerHTML = "";
				bufferedDiv.appendChild(xsltProcessor.transformToFragment(msg,window.document));					
				toolVault[itemUrl] = bufferedDiv.innerHTML;
				
				//set error message
				if(toolVault[itemUrl].length <= 4)
					toolVault[itemUrl] = errorLoadingToolTip;					
			}
		},
		error: function(msg){				
			toolVault[itemUrl] = errorLoadingToolTip;
		}
	});
	
	return toolVault[itemUrl];	
}




//gets the "pretty" html for an item tooltip via ajax
function getTipHTML(itemID, itemWithTip, mouseEvent)
{
	//load XSL stylesheet if we haven't yet	
	if(!($.browser.safari) && !($.browser.safari)){
		if(itemToolTipXSLLoaded == false)
		{
			//get the stylesheet			
			var xslDoc = Sarissa.getDomDocument();
			xslDoc.async = false;
			xslDoc.load("_layout/items/tooltip.xsl");
			
			xsltProcessor = new XSLTProcessor();
			xsltProcessor.importStylesheet(xslDoc);		
			
			itemToolTipXSLLoaded = true;
		}
	}
	
	//get the "pretty-html" for the tooltip
	if(toolVault[itemID] == null)
	{		
		//set loading text  
		setTipText(tLoading+"...");
		setToolTipPosition(itemWithTip,mouseEvent);
		
		var urlstr = "item-tooltip.xml?i="+itemID;
		
		$.ajax({
			type: "GET",
			url: urlstr,
			success: function(msg){				
				//cache the tooltip text based on browser
				if(($.browser.safari) || ($.browser.safari)){
					toolVault[itemID] = msg;
					
					if(toolVault[itemID].length <= 4)
						toolVault[itemID] = errorLoadingToolTip;
				}else{
					var bufferedDiv = document.createElement("div");
					bufferedDiv.innerHTML = "";
					bufferedDiv.appendChild(xsltProcessor.transformToFragment(msg,window.document));					
					toolVault[itemID] = bufferedDiv.innerHTML;
					
					//set error message
					if(toolVault[itemID].length <= 4)
						toolVault[itemID] = errorLoadingToolTip;					
				}
				
				//prevent showing the wrong item or an empty tooltip
				if(currItemID == itemID){					
					setTipText(toolVault[itemID]);
					setToolTipPosition(itemWithTip,mouseEvent); //set the position of the tooltip	
				}
			},
			error: function(msg){				
				setTipText(errorLoadingToolTip);
			}
		});
	}else{
		setTipText(toolVault[itemID]);
		setToolTipPosition(itemWithTip,mouseEvent); //set the position of the tooltip	
	}
}

//initialize tooltips on armory page
function bindToolTips()
{	
	//check to see if dual-tooltips are enabled
	if(getcookie2("armory.cookieDualTooltip") == 1)
		dualTipsEnabled = true;
	
	//see if we're on character sheet
	if(location.href.indexOf("character-sheet.xml") != -1)
		isOnCharSheet = true;

	//store reference to the tooltip
	theGlobalToolTip = $("#globalToolTip");
	
	//bind mouseover function for objects with class='tooltip'
	$(".staticTip").mouseover(function (e){

		if(tipsEnabled == false) return
		//need ajax call for tooltip text for items
		if($(this).hasClass("itemToolTip"))
		{	
			//only show an "ajax" tooltip if the item we moused over has an ID
			if(this.id != "")
			{
				
				//set current item id to prevent async mixups (and clean the id)
				currItemID = cleanID(this.id);		
				
				//get the html to put in the div
				getTipHTML(currItemID, this, e);
				
				//show the tooltip
				if($(theGlobalToolTip).css("display") != "block")
					$(theGlobalToolTip).show();

			}else{
				//no id means no item, character sheet items have tooltip placeholders
				if(isOnCharSheet){					
					//get id of parent (that will tell us the slot)
					setToolTipPosition(this,e);
					setTipText(getEmptySlotToolTip($(this).parent().attr("id")));
					
					$(theGlobalToolTip).show();
				}else{
					//if not on char sheet hide tip
					$(theGlobalToolTip).hide();	
				}				
			}
		}else{
			//normal tooltips (static text)
			setToolTipPosition(this,e); //set the position of the tooltip			
			$(theGlobalToolTip).show();
		}		
	});

	//mouseout event for objects with class='tooltip' (hide the tooltip)
	$(".staticTip").mouseout(function (){
		$(theGlobalToolTip).hide();	
		currItemID = null; //set itemid to null (for preventing async messups)
	});

}

//some item ids have "i=" in them, so remove it
function cleanID(itemid)
{
	if(itemid.indexOf("i=") != -1){
		itemid = itemid.substr(itemid.indexOf("i=")+2);
	}
	
	return itemid;	
}

//get the text for an empty character sheet slot
function getEmptySlotToolTip(slotid, classId)
{
	var slottext = "";
	
	switch (slotid) {
		case "0": slottext = textHead; 			break;
		case "1": slottext = textNeck; 			break;
		case "2": slottext = textShoulders; 	break;
		case "3": slottext = textShirt; 		break;
		case "4": slottext = textChest; 		break;
		case "5": slottext = textWaist; 		break;
		case "6": slottext = textLegs; 			break;
		case "7": slottext = textFeet;			break;
		case "8": slottext = textWrists; 		break;
		case "9": slottext = textHands; 		break;
		case "10":
		case "11": slottext = textFinger; 		break;
		case "12":
		case "13": slottext = textTrinket; 		break;
		case "14": slottext = textBack; 		break;
		case "15": slottext = textMainHand; 	break;
		case "16": slottext = textOffHand; 		break;
		case "17":
			if((classId == 6) || (classId == 11) || (classId == 2) || (classId == 7))
				slottext = textRelic;
			else
				slottext = textRanged;
			break;
		case "18": slottext = textTabard; 		break;
	}
	
	return slottext;	
}

/*****************************************************
* End Compact Tooltips
*****************************************************/
 
 
/*****************************************************
* Begin Bookmarks
*****************************************************/ 
 //global vars
var bookmarkTimerId	 = 0; //timer id to keep menu open or close 
var asyncType 		 = (!($.browser.msie) && !($.browser.mozilla)) ? false : true;

//bookmarks a character
function ajaxBookmarkChar(){

	$(theGlobalToolTip).hide();
	//change "bookmark this character" img
	if(asyncType == true){
		$("#profileRight")[0].innerHTML = "<div class=\"bmcEnabled\"></div>";
	}		
	buildBookmarkMenu("bookmarks.xml?" + charUrl + "&action=1");
}

//removes a bookmarked character from the drop down list
function ajaxRemoveChar(removedLink, clickedItem){	
	$(theGlobalToolTip).hide();	//hide tooltip	
	buildBookmarkMenu("bookmarks.xml?" + removedLink + "&action=2");	
}


function buildBookmarkMenu(url){	
	$(".bmlist").remove();
	$(".nobookmark").remove();	
	
	//force refresh for crummy browsers
	if(asyncType == false) 	Sarissa.updateContentFromURI(url, $("#bookmarkHolder")[0],null, function() { window.location.reload() });		
	else 					Sarissa.updateContentFromURI(url, $("#bookmarkHolder")[0],null,bindBookmarkMenu);
}

//keeps bookmark menu dropdown open
function persistBookMarkMenu(){
	if(bookmarkTimerId != null) clearTimeout(bookmarkTimerId);
		
	bookmarkTimerId = setTimeout('$("#menuHolder").hide(); $("#menuHolder").css("z-index","-1");', 500000);	
}

//initialize the bookmark dropdown menu
function bindBookmarkMenu(sFromUrl, oTargetElement){
	
	//bind timers for bookmark menu
	setBookmarkPersistTimers();
	
	//bind function for removing a bookmark
	$(".rmBookmark").click(function(){
			
		//get the link that tells us what character we want to remove	
		var removeBookmarkLink = $(this).prev().attr("href");		
				
		//remove the "/character-sheet.xml?" portion
		removeBookmarkLink = removeBookmarkLink.substr(removeBookmarkLink.indexOf(".xml?")+5);	
		
		//theCharUrl doesnt always exist, so wrap in "try/catch" to avoid errors
		try{
			//remove potential spaces in realm names
			charUrl				= charUrl.replace(/ /g,"+");
			charUrl			    = charUrl.replace(/\%20/g,"+");
			removeBookmarkLink  = removeBookmarkLink.replace(/ /g,"+");
			removeBookmarkLink  = removeBookmarkLink.replace(/\%20/g,"+");	
			
			//means we're on this page, so change the green check to "add bookmark"	
			if(charUrl == removeBookmarkLink){
				document.getElementById("profileRight").innerHTML = "<a id=\"bmcLink\" href=\"javascript:ajaxBookmarkChar()\"></a>";
			}
		}catch(e){ }
		
		//call ajax function to remove the item
		ajaxRemoveChar(removeBookmarkLink,this);	
	});
	
	//rebind tooltips
	bindToolTips();	
}

//binds certain elements to show/persist the bookmark menu
function setBookmarkPersistTimers()
{
	//show bookmark menu and keep it open
	$("#bookmark-user").mouseover(function() {
		persistBookMarkMenu();	
		$("#menuHolder").show();
		$("#menuHolder").css("z-index","10");
		clearTimeout(bookmarkTimerId);
	});
	
	//when leaving bookmark icon, start timer again to prevent menu
	//from not closing if they dont mouse over the menu portion
	$("#bookmark-user").mouseout(function() {
		persistBookMarkMenu();		   
	});
		
	//keep bookmarkmenu open (stop timer)	
	$("#menuHolder .menuItem").mouseover(function(){
		clearTimeout(bookmarkTimerId);
	});	
	
	$("#menuHolder").mouseover(function(){
		clearTimeout(bookmarkTimerId);
	});	
	
	$("#menuHolder").mouseout(function(){
		persistBookMarkMenu();
	});	
	
	//when mousing over parchment, hide the menu
	$(".parchment-top").mouseover(function(){
		$("#menuHolder").hide()						   
	});
	
	//we need to specify the same mousing over for the index page, since "parchemnt-top" doesn't exist there
	$(".parch-front").mouseover(function(){
		$("#menuHolder").hide()						   
	});
	
	//get page vals
	var currPage = $("#bm-currPage").html()*1;
	var totalPages = $("#bm-totalPages").html()*1;
	
	checkArrows();
		
	$("#bmFwd").click(function(){		
		if($(this).hasClass("disabled")) return;
		
		currPage = $("#bm-currPage").html()*1;
		
		if((currPage != totalPages) && (totalPages != 0)){
			$("#bookmarkHolder #page" + currPage).hide();
			$("#bookmarkHolder #page" + (currPage+1)).show();
			
			$("#bm-currPage").html((currPage+1));
			
			checkArrows();
		}
	});
	
	//page back
	$("#bmBack").click(function(){
		if($(this).hasClass("disabled")) return;
		
		currPage = $("#bm-currPage").html()*1;
		
		if(currPage > 1){
			$("#bookmarkHolder #page" + currPage).hide();
			$("#bookmarkHolder #page" + (currPage-1)).show();
			
			$("#bm-currPage").html((currPage-1));
			
			checkArrows();
		}
	});
}


function checkArrows(){
	var currPage = $("#bm-currPage").html()*1;
	var totalPages = $("#bm-totalPages").html()*1;
	
	var arrows = {
		prev: $("#bmBack"),
		next: $("#bmFwd")		
	}
	
	$(arrows.next).removeClass("bmDisabled");
	$(arrows.prev).removeClass("bmDisabled");
	
	if(totalPages == 0){
		$(arrows.next).addClass("bmDisabled");
		$(arrows.prev).addClass("bmDisabled");
	}
	
	if(currPage == 1)
		$(arrows.prev).addClass("bmDisabled");
	
	if(currPage == totalPages)
		$(arrows.next).addClass("bmDisabled");
		
	$("#currPageTxt").html(currPage);
	$("#totalPageTxt").html(totalPages);	
}
/*****************************************************
 * End Bookmarks
 *****************************************************/
 
function urlEncode(value) {
	 return encodeURIComponent(value).replace(/%20/g, '+');
}

function sprintf(str) {
	for(var i = 1; i < arguments.length; ++i) {
		str = str.replace('{' + (i - 1) + '}', arguments[i]);
	}
	return str;
}
