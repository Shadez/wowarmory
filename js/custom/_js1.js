/*  */
if(Browser.iphone && Number(getcookie2("mobIntPageVisits")) < 3 && getcookie2("hasSeenMobInt") == "")
{
	setcookie("mobIntPageOrigin",window.location.href,"session");
	window.location.href = "/mobile-armory-splash.xml";
}
/* */