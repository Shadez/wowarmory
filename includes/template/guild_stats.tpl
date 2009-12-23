<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="guildStats" tab="guild" tabGroup="guild" tabUrl=""></tabInfo>
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<link href="_css/guild/global.css" rel="stylesheet" type="text/css" />
<div class="tabs">
{{if $name}}
<div class="tab" id="tab_character">
<a href="character-sheet.xml?r={{$realm}}&amp;n={{$name}}&amp;gn={{$guildName}}">{{#armory_character_sheet_character_string#}}</a>
</div>
{{/if}}
<div class="selected-tab" id="tab_guild">
<a href="guild-info.xml?r={{$realm}}&gn={{$guildName}}">{{#armory_character_sheet_guild_string#}}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="" href="guild-info.xml?r={{$realm}}&gn={{$guildName}}" id="guildRoster_subTab"><span>{{#armory_guild_info_guild_roster#}}</span></a>
<a class="selected-subTab" href="guild-stats.xml?r={{$realm}}&gn={{$guildName}}" id="guildStats_subTab"><span>{{#armory_guild_info_statistic#}}</span></a>
<a class="subTabLocked" href="vault/guild-bank-contents.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankContents_subTab"><span>{{#armory_guild_info_guildbank#}}</span></a>
<a class="subTabLocked" href="vault/guild-bank-log.xml?r={{$realm}}&gn={{$guildName}}" id="guildBankLog_subTab"><span>{{#armory_guild_info_guildbanklog#}}</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<div class="profile">
<div class="guildbanks-faction-horde" style="margin-bottom: 40px;">
<div class="profile-left">
<div class="profile-right">
<div style="height: 140px; width: 100%;">
<div class="reldiv">
<div class="guildheadertext">
<div class="guild-details">
<div class="guild-shadow">
<table>
<tr>
<td>
<h1>{{$guildName}}</h1>
<h2>{{$guildMembersCount}}&nbsp;{{#armory_guild_info_members_string#}}</h2>
</td>
</tr>
</table>
</div>
<div class="guild-white">
<table>
<tr>
<td>
<h1>{{$guildName}}</h1>
<h2>{{$guildMembersCount}}&nbsp;{{#armory_guild_info_members_string#}}</h2>
</td>
</tr>
</table>
</div>
</div>
</div>
<div style="position: absolute; margin: -10px 0 0 -10px; z-index: 10000;">
<div id="guild_emblem" style="display:none;"></div>
<script type="text/javascript">
		var flashId="guild_emblem";
		if ((Browser.safari && flashId=="flashback") || (Browser.linux && flashId=="flashback")){//kill the searchbox flash for safari or linux
		   document.getElementById("searchFlash").innerHTML = '<div class="search-noflash"></div>';
		}else
			printFlash("guild_emblem", "images/emblem_ex.swf", "transparent", "", "", "230", "200", "best", "", "{{$guildEmblemStyle}}", "")
		
		</script>
</div>
<div style="position: absolute; margin: 116px 0 0 210px;">
<a class="smFrame" href="javascript:void(0);">
<div>{{$realm}}</div>
<img src="images/icon-header-realm.gif" /></a>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
		var levelMax = 80;
		var levelMin = 10;
		
		//static badness
		var allianceRaceArray = new Array;
		allianceRaceArray[0] = [text1race, 1];
		allianceRaceArray[1] = [text3race, 3];
		allianceRaceArray[2] = [text4race, 4];
		allianceRaceArray[3] = [text7race, 7];
		allianceRaceArray[4] = [text11race, 11];
	
		var hordeRaceArray = new Array;
		hordeRaceArray[0] = [text2race, 2];
		hordeRaceArray[1] = [text5race, 5];
		hordeRaceArray[2] = [text6race, 6];
		hordeRaceArray[3] = [text8race, 8];
		hordeRaceArray[4] = [text10race, 10];
	
		var classStringArray = new Array;
		classStringArray[0] = [text1class, 1];
		classStringArray[1] = [text2class, 2];
		classStringArray[2] = [text3class, 3];
		classStringArray[3] = [text4class, 4];
		classStringArray[4] = [text5class, 5];
		classStringArray[5] = [text7class, 7];
		classStringArray[6] = [text8class, 8];
		classStringArray[7] = [text9class, 9];
		classStringArray[8] = [text11class, 11];
		classStringArray[9] = [text6class, 6];
	
		//sort arrays
		classStringArray.sort();
		hordeRaceArray.sort();	
		allianceRaceArray.sort();
	
		var availableArray = new Array;
		availableArray[1] = [0, 1, 1, 0, 1, 1, 1, 0, 1, 1, 0, 0];
		availableArray[2] = [0, 1, 0, 1, 1, 0, 1, 1, 0, 1, 0, 0];
		availableArray[3] = [0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0];
		availableArray[4] = [0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 1];
		availableArray[5] = [0, 1, 0, 0, 1, 1, 1, 0, 1, 1, 0, 0];
		availableArray[6] = [0, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1];
		availableArray[7] = [0, 1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 0];
		availableArray[8] = [0, 1, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0];
		availableArray[10] = [0, 0, 1, 1, 1, 1, 1, 0, 1, 1, 0, 0];
		availableArray[11] = [0, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0];		

		var genderStringArray = new Array;
		genderStringArray[0]="Муж.";
		genderStringArray[1]="Жен.";	
	
		var raceSelected	=-1;
		var classSelected	=-1;
		var genderSelected	=-1;

		//find out how many classes there are
		classMax = 0;
		var csaLength=classStringArray.length;
		for(i=0; i < csaLength; i++) {
			newClassMax=classStringArray[i][1];
			if (classMax < newClassMax)
				classMax=newClassMax;
		}

		var completeArray = new Array;  //array that holds all the info
		
		var classArray	  = new Array;
		var raceArray	  = new Array;
		var levelArray	  = new Array;
		var genderArray	  = new Array;		
		var totalMembers  = 0;
		var theFaction	  = 0;		
		var x			  = 0;		
	</script>
    
    {{foreach from=$statList item=stat}}
    <script type="text/javascript">			
			theRace		= {{$stat.race}};
			theClass	= {{$stat.class}};
			theLevel	= {{$stat.level}};
			theGender	= {{$stat.gender}};	
			completeArray[x]=[theRace, theClass, theLevel, theGender];
			x++;
			
			if (theFaction == 0){
				if (theRace== 1 || theRace== 3 || theRace== 4 || theRace== 7 || theRace== 11) {
					thisRaceArray = allianceRaceArray;
					theFaction	  = "a";
				}else {
					thisRaceArray = hordeRaceArray;
					theFaction	  = "h";
				}
			
				raceMax = 0;
				
				var raLength = thisRaceArray.length;
				
				for(i = 0; i < raLength; i++) {
					newRaceMax = thisRaceArray[i][1];
					if (raceMax < newRaceMax){
						raceMax=newRaceMax;
					}
				}		
			}
		
		</script>
        <script src="_js/guild/guild-stats.js" type="text/javascript"></script>
        {{/foreach}}
<div class="guild-stats-container">
<div class="filtercrest">
<a class="bluebutton" href="javascript: changeStats(-1, -1, levelMin, levelMax, -1, completeArray, 1);" id="loginreloadbutton">
<div class="bluebutton-a"></div>
<div class="bluebutton-b">
<div class="reldiv">
<div class="bluebutton-color">Очистить критерии</div>
</div>Очистить критерии</div>
<div class="bluebutton-reload"></div>
<div class="bluebutton-c"></div>
</a>
<div class="filtertitle" style="float: left; position: relative;">Фильтр по статистике гильдии</div>
</div>
<div class="filtercontainer">
<form name="guildStats">
<div class="error-container1" id="errorMinLevel" style="visibility: hidden; ">
<div class="error-message">
<p></p>
<span id="errorMessageMinLevel"></span>
</div>
</div>
<div class="error-container2" id="errorMaxLevel" style="visibility: hidden; ">
<div class="error-message">
<p></p>
<span id="errorMessageMaxLevel"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 200px;">
<div class="bankcontentsfilter">Раса:&nbsp;
						<div id="divReplaceOptionRace"></div>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 200px;">
<div class="bankcontentsfilter">Классы:&nbsp;
						<div id="divReplaceOptionClass"></div>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 100px;">
<div class="bankcontentsfilter">Мин. ур.:<br>
<span><input class="guildbankitemname" maxlength="2" name="inputMinLevel" onClick="javascript:this.form.inputMinLevel.select()" onKeyUp="javascript: changeMinLevel();" size="2" type="text" value="10"></span>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 100px;">
<div class="bankcontentsfilter">
<div id="replaceMaxLevelInput"></div>
</div>
</div>
<div class="bankcontentsfiltercontainer" style="width: 200px;">
<div class="bankcontentsfilter">Пол:<select class="guildbanksubtype" name="optionGender" onChange="changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, this.options[this.selectedIndex].value, completeArray, 1);"><option value="-1">Оба</option><option value="0">Муж.</option><option value="1">Жен.</option></select>
</div>
</div>
<div class="clearfilterboxsm"></div>
</form>
</div>
<div class="bottomshadow"></div>
</div>
<script type="text/javascript">

	replaceString="";
	replaceString='<select class="guildbanksubtype" onChange="changeStats(this.options[this.selectedIndex].value, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray, 1);" name="optionRace">';
	replaceString += '<option value="-1">Все</option>';
	var raceArrayLength=thisRaceArray.length;
	for (d=0; d < raceArrayLength; d++){
		replaceString += '<option value="'+ d +'">'+ thisRaceArray[d][0] +'</option>';
	}
	replaceString += '</select>';

	document.getElementById('divReplaceOptionRace').innerHTML=replaceString;

</script><script type="text/javascript">

	replaceString="";
	replaceString='<select onChange="changeStats(raceSelected, this.options[this.selectedIndex].value, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray, 1);" name="optionClass"><option value="-1">Все</option>';
	for (d=0; d < classStringArray.length; d++){
		replaceString +='<option value="'+ d +'">'+ classStringArray[d][0] +'</option>';
	}
	replaceString += '</select>';

	document.getElementById('divReplaceOptionClass').innerHTML=replaceString;

</script><script type="text/javascript">	
	replaceString='Макс. ур.<br/> <span><input onKeyUp="javascript: changeMaxLevel();" type="text" name="inputMaxLevel" size="2" class="guildbankitemname" maxlength="2" value="'+ levelMax +'" onClick="javascript:this.form.inputMaxLevel.select()"/></span>';
	document.getElementById('replaceMaxLevelInput').innerHTML=replaceString;
</script>
<div class="stats-wrapper">
<div class="racial-stats">
<h2>Статистика по расам</h2>
<div class="race-container">
<table>
<thead>
<tr>
<td>
<h3>
<span id="racePercentage0">0</span>%</h3>
</td><td>
<h3>
<span id="racePercentage1">0</span>%</h3>
</td><td>
<h3>
<span id="racePercentage2">0</span>%</h3>
</td><td>
<h3>
<span id="racePercentage3">0</span>%</h3>
</td><td>
<h3>
<span id="racePercentage4">0</span>%</h3>
</td><td class="genders" rowspan="5">
<div class="g-pos">
<div class="gender-box">
<div class="male">
<em><span id="genderNumber0">0</span></em><em><span id="genderPercentage0">0</span>%</em><a href="javascript: changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"></a>
</div>
<div class="female">
<a href="#" onClick="changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray); return false;"></a><em><span id="genderPercentage1">100</span>%</em><em><span id="genderNumber1">0</span></em>
</div>
</div>
</div>
</td><script type="text/javascript">	

	for (var i=0; i < 2; i++) {
		if (!genderArray[i][0])
			genderArray[i][0]=0;
	}

	for (i=0; i < 2; i++) {

		if (totalMembers== 0)
			genderArray[i][1]=0;
		else
			genderArray[i][1]=Math.round(genderArray[i][0]/totalMembers * 100);


	}
	
</script>
</tr>
</thead>
<tbody>
<tr class="graph-layout">
<td>
<div class="race-graph">
<div class="racebar" id="raceBar0">
<!---->
</div>
</div>
</td><td>
<div class="race-graph">
<div class="racebar" id="raceBar1">
<!---->
</div>
</div>
</td><td>
<div class="race-graph">
<div class="racebar" id="raceBar2">
<!---->
</div>
</div>
</td><td>
<div class="race-graph">
<div class="racebar" id="raceBar3">
<!---->
</div>
</div>
</td><td>
<div class="race-graph">
<div class="racebar" id="raceBar4">
<!---->
</div>
</div>
</td>
</tr>
</tbody>
<tr>
<td><a href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);" onMouseOver="javascript: this.style.cursor='hand';">
<div class="raceicon" id="raceShield0"></div>
</a></td><td><a href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);" onMouseOver="javascript: this.style.cursor='hand';">
<div class="raceicon" id="raceShield1"></div>
</a></td><td><a href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);" onMouseOver="javascript: this.style.cursor='hand';">
<div class="raceicon" id="raceShield2"></div>
</a></td><td><a href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);" onMouseOver="javascript: this.style.cursor='hand';">
<div class="raceicon" id="raceShield3"></div>
</a></td><td><a href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);" onMouseOver="javascript: this.style.cursor='hand';">
<div class="raceicon" id="raceShield4"></div>
</a></td>
</tr>
<tr>
<td align="center" class="nameplate"><span id="raceName0">a</span></td><td align="center" class="nameplate"><span id="raceName1">a</span></td><td align="center" class="nameplate"><span id="raceName2">a</span></td><td align="center" class="nameplate"><span id="raceName3">a</span></td><td align="center" class="nameplate"><span id="raceName4">a</span></td>
</tr>
<tr>
<td>
<div class="race-icons">
<a href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img border="0" class="p" id="raceIconMale0"></a><a href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img border="0" class="p" id="raceIconFemale0"></a>
</div>
<h4 id="raceNumber0">0</h4>
</td><td>
<div class="race-icons">
<a href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img border="0" class="p" id="raceIconMale1"></a><a href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img border="0" class="p" id="raceIconFemale1"></a>
</div>
<h4 id="raceNumber1">0</h4>
</td><td>
<div class="race-icons">
<a href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img border="0" class="p" id="raceIconMale2"></a><a href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img border="0" class="p" id="raceIconFemale2"></a>
</div>
<h4 id="raceNumber2">0</h4>
</td><td>
<div class="race-icons">
<a href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img border="0" class="p" id="raceIconMale3"></a><a href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img border="0" class="p" id="raceIconFemale3"></a>
</div>
<h4 id="raceNumber3">0</h4>
</td><td>
<div class="race-icons">
<a href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img border="0" class="p" id="raceIconMale4"></a><a href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img border="0" class="p" id="raceIconFemale4"></a>
</div>
<h4 id="raceNumber4">0</h4>
</td>
</tr>
</table>
</div>
</div>
<div class="class-stats">
<h2>Статистика по классам</h2>
<div class="class-container">
<table>
<thead>
<tr>
<td>
<h3>
<span id="classPercentage0">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage1">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage2">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage3">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage4">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage5">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage6">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage7">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage8">0</span>%</h3>
</td><td>
<h3>
<span id="classPercentage9">0</span>%</h3>
</td>
</tr>
</thead>
<tbody>
<tr class="graph-layout">
<td>
<div class="class-graph">
<div class="classbar" id="classBarStyle0"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle1"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle2"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle3"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle4"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle5"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle6"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle7"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle8"></div>
</div>
</td><td>
<div class="class-graph">
<div class="classbar" id="classBarStyle9"></div>
</div>
</td>
</tr>
</tbody>
<tr>
<td>
<div class="classicon" id="classIcon0">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 0, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[0][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon1">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 1, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[1][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon2">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 2, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[2][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon3">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 3, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[3][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon4">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 4, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[4][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon5">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 5, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[5][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon6">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 6, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[6][0])"></a>
</div>
</td><td>
<div class="classicon staticTip" id="classIcon7">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 7, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[7][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon8">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 8, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[8][0])"></a>
</div>
</td><td>
<div class="classicon" id="classIcon9">
<a class="staticTip" href="#" onClick="changeStats(raceSelected, 9, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[9][0])"></a>
</div>
</td>
</tr>
<tr>
<td>
<h4>
<span id="classNumber0">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber1">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber2">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber3">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber4">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber5">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber6">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber7">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber8">0</span>
</h4>
</td><td>
<h4>
<span id="classNumber9">0</span>
</h4>
</td>
</tr>
</table>
</div>
</div>
<div class="level-stats">
<h2>Статистика по уровню</h2>
<div class="level-container">
<table>
<tbody>
<tr class="graph-layout">
<td onMouseOver="javascript: showTheLevel(10);">
<div class="level-graph">
<div class="levelbar" id="levelBar10">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(11);">
<div class="level-graph">
<div class="levelbar" id="levelBar11">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(12);">
<div class="level-graph">
<div class="levelbar" id="levelBar12">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(13);">
<div class="level-graph">
<div class="levelbar" id="levelBar13">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(14);">
<div class="level-graph">
<div class="levelbar" id="levelBar14">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(15);">
<div class="level-graph">
<div class="levelbar" id="levelBar15">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(16);">
<div class="level-graph">
<div class="levelbar" id="levelBar16">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(17);">
<div class="level-graph">
<div class="levelbar" id="levelBar17">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(18);">
<div class="level-graph">
<div class="levelbar" id="levelBar18">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(19);">
<div class="level-graph">
<div class="levelbar" id="levelBar19">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(20);">
<div class="level-graph">
<div class="levelbar" id="levelBar20">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(21);">
<div class="level-graph">
<div class="levelbar" id="levelBar21">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(22);">
<div class="level-graph">
<div class="levelbar" id="levelBar22">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(23);">
<div class="level-graph">
<div class="levelbar" id="levelBar23">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(24);">
<div class="level-graph">
<div class="levelbar" id="levelBar24">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(25);">
<div class="level-graph">
<div class="levelbar" id="levelBar25">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(26);">
<div class="level-graph">
<div class="levelbar" id="levelBar26">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(27);">
<div class="level-graph">
<div class="levelbar" id="levelBar27">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(28);">
<div class="level-graph">
<div class="levelbar" id="levelBar28">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(29);">
<div class="level-graph">
<div class="levelbar" id="levelBar29">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(30);">
<div class="level-graph">
<div class="levelbar" id="levelBar30">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(31);">
<div class="level-graph">
<div class="levelbar" id="levelBar31">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(32);">
<div class="level-graph">
<div class="levelbar" id="levelBar32">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(33);">
<div class="level-graph">
<div class="levelbar" id="levelBar33">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(34);">
<div class="level-graph">
<div class="levelbar" id="levelBar34">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(35);">
<div class="level-graph">
<div class="levelbar" id="levelBar35">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(36);">
<div class="level-graph">
<div class="levelbar" id="levelBar36">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(37);">
<div class="level-graph">
<div class="levelbar" id="levelBar37">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(38);">
<div class="level-graph">
<div class="levelbar" id="levelBar38">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(39);">
<div class="level-graph">
<div class="levelbar" id="levelBar39">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(40);">
<div class="level-graph">
<div class="levelbar" id="levelBar40">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(41);">
<div class="level-graph">
<div class="levelbar" id="levelBar41">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(42);">
<div class="level-graph">
<div class="levelbar" id="levelBar42">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(43);">
<div class="level-graph">
<div class="levelbar" id="levelBar43">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(44);">
<div class="level-graph">
<div class="levelbar" id="levelBar44">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(45);">
<div class="level-graph">
<div class="levelbar" id="levelBar45">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(46);">
<div class="level-graph">
<div class="levelbar" id="levelBar46">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(47);">
<div class="level-graph">
<div class="levelbar" id="levelBar47">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(48);">
<div class="level-graph">
<div class="levelbar" id="levelBar48">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(49);">
<div class="level-graph">
<div class="levelbar" id="levelBar49">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(50);">
<div class="level-graph">
<div class="levelbar" id="levelBar50">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(51);">
<div class="level-graph">
<div class="levelbar" id="levelBar51">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(52);">
<div class="level-graph">
<div class="levelbar" id="levelBar52">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(53);">
<div class="level-graph">
<div class="levelbar" id="levelBar53">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(54);">
<div class="level-graph">
<div class="levelbar" id="levelBar54">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(55);">
<div class="level-graph">
<div class="levelbar" id="levelBar55">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(56);">
<div class="level-graph">
<div class="levelbar" id="levelBar56">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(57);">
<div class="level-graph">
<div class="levelbar" id="levelBar57">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(58);">
<div class="level-graph">
<div class="levelbar" id="levelBar58">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(59);">
<div class="level-graph">
<div class="levelbar" id="levelBar59">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(60);">
<div class="level-graph">
<div class="levelbar" id="levelBar60">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(61);">
<div class="level-graph">
<div class="levelbar" id="levelBar61">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(62);">
<div class="level-graph">
<div class="levelbar" id="levelBar62">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(63);">
<div class="level-graph">
<div class="levelbar" id="levelBar63">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(64);">
<div class="level-graph">
<div class="levelbar" id="levelBar64">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(65);">
<div class="level-graph">
<div class="levelbar" id="levelBar65">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(66);">
<div class="level-graph">
<div class="levelbar" id="levelBar66">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(67);">
<div class="level-graph">
<div class="levelbar" id="levelBar67">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(68);">
<div class="level-graph">
<div class="levelbar" id="levelBar68">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(69);">
<div class="level-graph">
<div class="levelbar" id="levelBar69">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(70);">
<div class="level-graph">
<div class="levelbar" id="levelBar70">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(71);">
<div class="level-graph">
<div class="levelbar" id="levelBar71">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(72);">
<div class="level-graph">
<div class="levelbar" id="levelBar72">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(73);">
<div class="level-graph">
<div class="levelbar" id="levelBar73">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(74);">
<div class="level-graph">
<div class="levelbar" id="levelBar74">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(75);">
<div class="level-graph">
<div class="levelbar" id="levelBar75">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(76);">
<div class="level-graph">
<div class="levelbar" id="levelBar76">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(77);">
<div class="level-graph">
<div class="levelbar" id="levelBar77">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(78);">
<div class="level-graph">
<div class="levelbar" id="levelBar78">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(79);">
<div class="level-graph">
<div class="levelbar" id="levelBar79">
<!--ie-->
</div>
</div>
</td><td onMouseOver="javascript: showTheLevel(80);">
<div class="level-graph">
<div class="levelbar" id="levelBar80">
<!--ie-->
</div>
</div>
</td>
</tr>
</tbody>
<tr class="level-range">
<td colspan="5">
<div class="levelicon">10</div>
</td><td colspan="5">
<div class="levelicon">15</div>
</td><td colspan="5">
<div class="levelicon">20</div>
</td><td colspan="5">
<div class="levelicon">25</div>
</td><td colspan="5">
<div class="levelicon">30</div>
</td><td colspan="5">
<div class="levelicon">35</div>
</td><td colspan="5">
<div class="levelicon">40</div>
</td><td colspan="5">
<div class="levelicon">45</div>
</td><td colspan="5">
<div class="levelicon">50</div>
</td><td colspan="5">
<div class="levelicon">55</div>
</td><td colspan="5">
<div class="levelicon">60</div>
</td><td colspan="5">
<div class="levelicon">65</div>
</td><td colspan="5">
<div class="levelicon">70</div>
</td><td colspan="6">
<div class="levelicon">75 <em>80</em>
</div>
</td>
</tr>
</table>
<div class="stats-console">
<div class="stat-padding">
<p>
<span class="tooltipGuild">Всего персонажей в гильдии:</span><strong>&nbsp;{{$guildMembersCount}}</strong>
</p>
<p>
<span class="tooltipGuild">Персонажей, отвечающим критериям:</span>&nbsp;<strong id="numReturnedResults"></strong>
</p>
<p>
<span class="tooltipGuild" id="countSpecificLevel">Число персонажей уровня <b id="replaceLevelNum"></b> :
		</span>&nbsp;<strong id="printNum80"></strong>
</p>
<p>
<span class="tooltipGuild">% уровня <b id="replaceLevelPercent"></b><b id="countSpecificLevel"></b> :
		</span>&nbsp;<b id="printPercent80"></b>%</p>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">	

	document.getElementById('replaceLevelNum').innerHTML=levelMax;
	document.getElementById('replaceLevelPercent').innerHTML=levelMax;

	for (r=0; r < thisRaceArray.length; r++) {
		theRaceId=thisRaceArray[r][1];
		document.getElementById('raceName'+ r).innerHTML='<a href="#" onClick="changeStats('+ r +', classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray); return false;">'+thisRaceArray[r][0] +'</a>'; 
		document.getElementById('raceShield'+ r).className += ' shield-'+theRaceId;
	}


	for (t=0; t < classStringArray.length; t++) {
		theClassId=classStringArray[t][1];
		if (!classArray[theClassId][0])
			classArray[theClassId][0]=0;
		document.getElementById('classIcon'+t).className += " icon-"+theClassId;
		document.getElementById('classBarStyle'+t).className += " bar-"+theClassId;
	}

changeStatsWrapper();

document.getElementById('printNum80').innerHTML=levelArray[levelMax][0];
document.getElementById('printPercent80').innerHTML=levelArray[levelMax][1];

</script>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>