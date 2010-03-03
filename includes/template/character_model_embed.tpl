<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta content="text/html; charset={$ArmoryConfig.siteCharset}" http-equiv="Content-Type" />
<meta content="{#armory_meta_description#}" name="description" />
<title>{#armory_site_title#}</title>
<link href="_css/master.css" rel="stylesheet" type="text/css" />
<link href="_css/int.css" rel="stylesheet" type="text/css" />
<link href="_css/character/global.css" rel="stylesheet" type="text/css" />
<script src="shared/global/third-party/jquery/jquery.js" type="text/javascript"></script>
<link href="_css/character/sheet.css" rel="stylesheet" type="text/css" />
<link href="character-feed.atom?r={$realm}&amp;cn={$name}" rel="alternate" title="{$name}" type="application/rss+xml" />
</head>
<body id="wowCharacterEmbed">
<script type="text/javascript">	
                var theClassId 		= {$class};
                var theRaceId 		= {$race};
                var theClassName 	= "{get_wow_class class=$class}";
                var theLevel 		= {$level};		
                var theRealmName 	= "{$realm}";
                var theCharName 	= "{$name}";	
                var actTalentSpec 	= ""
                var getcookie2 = null
</script>
<script src="_js/functions.js" type="text/javascript"></script>
<script src="shared/global/third-party/jquery/jquery.js" type="text/javascript"></script>
<script src="_js/armory.js" type="text/javascript"></script>
<script src="_js/character/charactermodel.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}
                var urlp = HTTP.getURLParams()["skin"];
                var init3dvars = {embedded:true}
                if(urlp){ document.getElementById("wowCharacterEmbed").className = urlp; 
                          init3dvars = {embedded:true,bg:"none",bgColor:"0xFFFFFF"}; 
                        }
{/literal}                       
            </script>
<div id="debugtxt"></div>
<div class="profileCenter" id="center_target">
<div id="pose_saving">
<span>Сохранение...</span>
</div>
<div id="pose_save_ok">
<span>Поза сохранена!</span>
</div>
<div id="ModelViewer3">
<div class="noFlash">
<a class="noflash" href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" target="_blank"><img align="right" class="p" src="images/{$ArmoryConfig.locale}/getflash.gif" /></a>{#armory_install_flash_player_string#}</div>
<script src="_js/character/charactermodel.js" type="text/javascript"></script>
<script src="shared/global/third-party/swfobject2/swfobject.js" type="text/javascript"></script>
<script type="text/javascript">
		 if(!init3dvars) var init3dvars = null
		 if(!charUrl) var charUrl = '{$urlName}'
		  function buildModelViewer(attr) {literal}
		  {		{/literal}
                var lang = "{$ArmoryConfig.locale}".split("_")[0].toLowerCase()
		  		if ("{$ArmoryConfig.locale}" == "zh_tw") lang = "zh_tw"
		  		var modelserver = ""
                var embedlink = '<iframe src="'+String(window.location).split('character')[0]+'character-model-embed.xml?r={$realm}&cn={$name}&rhtml=true" scrolling="no" height="588" width="321" frameborder="0"></iframe>'
				var stringslink = "_content/{$ArmoryConfig.locale}/modelConfig_strings.xml";
				var logolink = "models/images/logo/armory-logo-"+lang+".png" 
                {literal}
				var params = { menu: "false", scale: "noScale", allowFullscreen: "true", allowScriptAccess: "always", bgcolor:"#E3C96A", wmode:"opaque" };
                var attributes = { id:"ModelViewer3" };
                var flashvars = { character: theCharName, modelUrl: "character-model.xml?"+encodeURIComponent(charUrl), fileServer: {/literal}"models/", {literal}
								  embedlink:encodeURIComponent(embedlink), strings:stringslink, logoImg:logolink,
								  loadingtxt:"Loading." //"
								};
				if(getcookie2){ var modelCookies = getArmoryCookies("3d"); 
								for(xi in modelCookies) { flashvars[xi] = modelCookies[xi] } 
							  }
				if(init3dvars)	{ for (var i in init3dvars){ flashvars[i] = init3dvars[i]; } 
									if(init3dvars.bgColor){ params.bgcolor = "#"+init3dvars.bgColor.slice(2) }
								}
				if(attr){ for (var i in attr){ flashvars[i] = attr[i]; } }
                {/literal}
                swfobject.embedSWF("models/flash/ModelViewer3.swf", "ModelViewer3", "100%", "100%", "10.0.0", "models/flash/expressInstall.swf", flashvars, params, attributes);
				{literal}
                $(document).ready(function () { bindMouseActions() });	
		  }
			var str_loginExpired = "Enter username." //"
			buildModelViewer()
            {/literal}
            </script>
</div>
</div>
<div class="embed_bg embed_{$faction_string_class}">
<div class="points">
<a href="character-achievements.xml?{$urlName}" onclick="window.open(this.href);return false;">{$char_achievement_points}</a>
</div>
<div id="forumLinks">{$realm}</div>
<div id="charHeaderTxt_Light">
<div class="charNameHeader">
<a class="charLink" href="character-sheet.xml?{$urlName}" onclick="window.open(this.href);return false;">{$name}</a>
</div>
{if $guildName}
<div class="charGuildName">
<a href="guild-info.xml?{$urlName}&amp;gn={$guildName}" onclick="window.open(this.href);return false;">{$guildName}</a>
</div>
{/if}
<div class="character_desc">{#armory_character_sheet_level_string#}&nbsp;{$level}&nbsp;{get_wow_race race=$race}&nbsp;{get_wow_class class=$class}</div>
</div>
<div class="embed_links">
<a class="trialLink" href="http://www.battle.net/account/creation/wow/region-selection.html" onclick="window.open(this.href);return false;">{#armory_character_model_try_wow#}</a><a href="character-sheet.xml?{$urlName}" onclick="window.open(this.href);return false;">{#armory_character_model_view_on_the_armory#}</a>
</div>
</div>
</body>
</html>