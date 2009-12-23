//browser detection		
if($.browser.msie){
	if($.browser.version == "7.0")		addStylesheet('/css/browser/ie7.css');
	if($.browser.version == "6.0")		addStylesheet('/css/browser/ie.css');
}else if($.browser.mozilla){
	if(parseFloat($.browser.version) <= 1.9)	addStylesheet('/css/browser/firefox2.css');
}else if($.browser.opera)				addStylesheet('/css/browser/opera.css');
else if($.browser.safari)				addStylesheet('/css/browser/safari.css');

//set global login var
var isLoggedIn = ("" != '');
var bookmarkToolTip = "Вы можете запомнить до 30 профилей персонажа.";

var isHomepage 		 = ("false" != "true");
var globalSearch 	 = "1";
var theLang 		 = "ru_ru";
var region 			 = "EU"; //in language.xsl DO NOT REMOVE

var regionUrl = {
	armory: 	"",
	forums: 	"",
	wow: 		""
}	
/*  */		
$(document).ready(function() {			
	initializeArmory(); //initialize the armory!
});		
/* */