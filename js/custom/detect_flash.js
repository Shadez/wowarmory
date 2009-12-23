var flashId="mobile_armory_banner";
if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){
	document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
}else
	printFlash("mobile_armory_banner", "images/ru_ru/flash/mobile_armory_banner.swf", "transparent", "", "", "300", "175", "best", "", "linkUrl=/iphone.xml", "")