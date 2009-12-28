<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link href="favicon.ico" rel="shortcut icon" />
<title>{{#armory_site_title#}}</title>
<meta content="text/html; charset={{$ArmoryConfig.siteCharset}}" http-equiv="Content-Type" />
<meta content="{{#armory_meta_description#}}" name="description" />
<style media="screen, projection" type="text/css">
		@import "_css/master.css";
		@import "shared/global/menu/topnav/topnav.css";
		
		@import "_css/_lang/{{$ArmoryConfig.locale}}/language.css";
		@import "_css/_region/eu/region.css";
        {{$addCssSheet}}
	</style>
<script src="shared/global/third-party/jquery/jquery.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/datefunctions.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/jquery.datepicker.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/jquery.tablesorter.pager.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/jquery.bgiframe.min.js" type="text/javascript"></script>
<script src="shared/global/third-party/sarissa/0.9.9.3/sarissa.js" type="text/javascript"></script>
<script src="_js/common.js" type="text/javascript"></script>
<script src="_js/armory.js" type="text/javascript"></script>
<script type="text/javascript">
		//browser detection		
		if($.browser.msie){
			if($.browser.version == "7.0")		addStylesheet('_css/browser/ie7.css');
			if($.browser.version == "6.0")		addStylesheet('_css/browser/ie.css');
		}else if($.browser.mozilla){
			if(parseFloat($.browser.version) <= 1.9)	addStylesheet('_css/browser/firefox2.css');
		}else if($.browser.opera)				addStylesheet('_css/browser/opera.css');
		else if($.browser.safari)				addStylesheet('_css/browser/safari.css');

		//set global login var
		var isLoggedIn = ("{{$_wow_login}}" != '');
		var bookmarkToolTip = "{{#armory_remember_js_string#}}";

		var isHomepage 		 = ("false" != "true");
		var globalSearch 	 = "1";
		var theLang 		 = "{{$ArmoryConfig.locale}}";
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
</script>
</head>
