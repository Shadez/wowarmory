<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="header.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="guildInfo">

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">
                <div class="list">
					<xsl:call-template name="newGuildTabs" />
                    <div class="full-list">
                        <div class="info-pane">
							<div class="profile-wrapper">
								<div class="profile">
                           			<xsl:call-template name="guildContent" />
						   		</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


<xsl:template name="guildContent">

	<!-- character header -->
	<xsl:call-template name="newGuildHeader" />	
	
	<xsl:variable name="allMembersCount" select="count(guild/members/character)" />

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
		genderStringArray[0]="<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.gender.0']"/>";
		genderStringArray[1]="<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.gender.1']"/>";	
	
		var raceSelected	=-1;
		var classSelected	=-1;
		var genderSelected	=-1;

		//find out how many classes there are
		classMax = 0;
		var csaLength=classStringArray.length;
		for(i=0; i &lt; csaLength; i++) {
			newClassMax=classStringArray[i][1];
			if (classMax &lt; newClassMax)
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
	
	<xsl:for-each select="guild/members/character">
	
		<script type="text/javascript">			
			theRace		= <xsl:value-of select="@raceId"/>;
			theClass	= <xsl:value-of select="@classId"/>;
			theLevel	= <xsl:value-of select="@level"/>;
			theGender	= <xsl:value-of select="@genderId"/>;	
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
				
				for(i = 0; i &lt; raLength; i++) {
					newRaceMax = thisRaceArray[i][1];
					if (raceMax &lt; newRaceMax){
						raceMax=newRaceMax;
					}
				}		
			}
		
		</script>	
		<script type="text/javascript" src="_js/guild/guild-stats.js"></script>
	</xsl:for-each>
	
	<div class="guild-stats-container">
<div class="filtercrest">
	<a id="loginreloadbutton" class="bluebutton" href="javascript: changeStats(-1, -1, levelMin, levelMax, -1, completeArray, 1);"><div class="bluebutton-a"></div><div class="bluebutton-b"><div class="reldiv"><div class="bluebutton-color"><xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/></div></div><xsl:value-of select="$loc/strs/guildBank/str[@id='resetfilters']"/></div><div class="bluebutton-reload"/><div class="bluebutton-c"></div></a>
	<div class="filtertitle" style="float: left; position: relative;"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.header.guild-stats-filters']"/></div>
</div>

<div class="filtercontainer">
<form name="guildStats">
		<div class="error-container1" id="errorMinLevel" style="visibility: hidden; "><div class="error-message"><p></p><span id="errorMessageMinLevel"></span></div></div>
		<div class="error-container2" id="errorMaxLevel" style="visibility: hidden; "><div class="error-message"><p></p><span id="errorMessageMaxLevel"></span></div></div>
			<div class="bankcontentsfiltercontainer" style="width: 200px;">
				<div class="bankcontentsfilter">
						<xsl:value-of select="$loc/strs/general/str[@id='race']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;
						<div id="divReplaceOptionRace"></div>
				</div>
			</div>			
			<div class="bankcontentsfiltercontainer" style="width: 200px;">
				<div class="bankcontentsfilter">
						<xsl:value-of select="$loc/strs/itemTooltip/str[@id='armory.item-tooltip.classes']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>&#160;
						<div id="divReplaceOptionClass"></div>
				</div>
			</div>
			<div class="bankcontentsfiltercontainer" style="width: 100px;">
				<div class="bankcontentsfilter">		
						<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.minlvl']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/><br/>
						<span><input onKeyUp="javascript: changeMinLevel();" type="text" name="inputMinLevel" size="2" maxlength="2" value="10" onClick="javascript:this.form.inputMinLevel.select()" class="guildbankitemname" /></span>
				</div>
			</div>
			<div class="bankcontentsfiltercontainer" style="width: 100px;">
				<div class="bankcontentsfilter">
						<div id="replaceMaxLevelInput"></div>
				</div>
			</div>
			<div class="bankcontentsfiltercontainer" style="width: 200px;">
				<div class="bankcontentsfilter">
						<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.gender']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/>
						<select class="guildbanksubtype" onChange="changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, this.options[this.selectedIndex].value, completeArray, 1);" name="optionGender"><option value="-1"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.both']"/></option><option value="0"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.gender.0']"/></option><option value="1"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.gender.1']"/></option></select>
				</div>
			</div>
	<div class="clearfilterboxsm"></div>
</form>
</div><!--/filtercontainer/-->
	<div class="bottomshadow"></div>
	</div>
	
	<script type="text/javascript">

	replaceString="";
	replaceString='&lt;select class="guildbanksubtype" onChange="changeStats(this.options[this.selectedIndex].value, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray, 1);" name="optionRace"&gt;';
	replaceString += '&lt;option value="-1"&gt;<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.all']"/>&lt;/option&gt;';
	var raceArrayLength=thisRaceArray.length;
	for (d=0; d &lt; raceArrayLength; d++){
		replaceString += '&lt;option value="'+ d +'"&gt;'+ thisRaceArray[d][0] +'&lt;/option&gt;';
	}
	replaceString += '&lt;/select&gt;';

	document.getElementById('divReplaceOptionRace').innerHTML=replaceString;

</script>

<script type="text/javascript">

	replaceString="";
	replaceString='&lt;select onChange="changeStats(raceSelected, this.options[this.selectedIndex].value, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray, 1);" name="optionClass"&gt;&lt;option value="-1"&gt;<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.all']"/>&lt;/option&gt;';
	for (d=0; d &lt; classStringArray.length; d++){
		replaceString +='&lt;option value="'+ d +'"&gt;'+ classStringArray[d][0] +'&lt;/option&gt;';
	}
	replaceString += '&lt;/select&gt;';

	document.getElementById('divReplaceOptionClass').innerHTML=replaceString;

</script>
<script type="text/javascript">	
	replaceString='<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.maxlvl']"/>&lt;br/&gt; &lt;span&gt;&lt;input onKeyUp="javascript: changeMaxLevel();" type="text" name="inputMaxLevel" size="2" class="guildbankitemname" maxlength="2" value="'+ levelMax +'" onClick="javascript:this.form.inputMaxLevel.select()"/&gt;&lt;/span&gt;';
	document.getElementById('replaceMaxLevelInput').innerHTML=replaceString;
</script>	


<div class="stats-wrapper">

	<div class="racial-stats">
	<h2><xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.race.breakdown']"/></h2>
	<div class="race-container">
		<table>
		 <thead>
		  <tr><td><h3><span id="racePercentage0">0</span>%</h3></td>
              <td><h3><span id="racePercentage1">0</span>%</h3></td>
              <td><h3><span id="racePercentage2">0</span>%</h3></td>
              <td><h3><span id="racePercentage3">0</span>%</h3></td>				
              <td><h3><span id="racePercentage4">0</span>%</h3></td>
              <td rowspan="5" class="genders"><div class="g-pos"><div class="gender-box"><div class="male"><em><span id="genderNumber0">0</span></em><em><span id="genderPercentage0">0</span>%</em><a href="javascript: changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"></a></div><div class="female"><a href="#" onClick="changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray); return false;"></a><em><span id="genderPercentage1">100</span>%</em><em><span id="genderNumber1">0</span></em></div></div></div></td>

<script type="text/javascript">	

	for (var i=0; i &lt; 2; i++) {
		if (!genderArray[i][0])
			genderArray[i][0]=0;
	}

	for (i=0; i &lt; 2; i++) {

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
			<td><div class="race-graph"><div class="racebar" id="raceBar0"><xsl:comment/></div></div></td>
			<td><div class="race-graph"><div class="racebar" id="raceBar1"><xsl:comment/></div></div></td>
			<td><div class="race-graph"><div class="racebar" id="raceBar2"><xsl:comment/></div></div></td>
			<td><div class="race-graph"><div class="racebar" id="raceBar3"><xsl:comment/></div></div></td>
			<td><div class="race-graph"><div class="racebar" id="raceBar4"><xsl:comment/></div></div></td>
		</tr>
		</tbody>
		<tr>
			<td><a onMouseOver="javascript: this.style.cursor='hand';" href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);"><div id="raceShield0" class="raceicon"></div></a></td>
			<td><a onMouseOver="javascript: this.style.cursor='hand';" href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);"><div id="raceShield1" class="raceicon"></div></a></td>
			<td><a onMouseOver="javascript: this.style.cursor='hand';" href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);"><div id="raceShield2" class="raceicon"></div></a></td>
			<td><a onMouseOver="javascript: this.style.cursor='hand';" href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);"><div id="raceShield3" class="raceicon"></div></a></td>
			<td><a onMouseOver="javascript: this.style.cursor='hand';" href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray);"><div id="raceShield4" class="raceicon"></div></a></td>
		</tr>
		<tr>
			<td class="nameplate" align="center"><span id="raceName0">a</span></td>
			<td class="nameplate" align="center"><span id="raceName1">a</span></td>
			<td class="nameplate" align="center"><span id="raceName2">a</span></td>
			<td class="nameplate" align="center"><span id="raceName3">a</span></td>
			<td class="nameplate" align="center"><span id="raceName4">a</span></td>
		</tr>
		<tr>
			<td><div class="race-icons"><a href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img id="raceIconMale0" class="p" border="0" /></a><a href="javascript: changeStats(0, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img id="raceIconFemale0" class="p" border="0" /></a></div><h4 id="raceNumber0">0</h4></td>
			<td><div class="race-icons"><a href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img id="raceIconMale1" class="p" border="0" /></a><a href="javascript: changeStats(1, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img id="raceIconFemale1" class="p" border="0" /></a></div><h4 id="raceNumber1">0</h4></td>
			<td><div class="race-icons"><a href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img id="raceIconMale2" class="p" border="0" /></a><a href="javascript: changeStats(2, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img id="raceIconFemale2" class="p" border="0" /></a></div><h4 id="raceNumber2">0</h4></td>
			<td><div class="race-icons"><a href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img id="raceIconMale3" class="p" border="0" /></a><a href="javascript: changeStats(3, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img id="raceIconFemale3" class="p" border="0" /></a></div><h4 id="raceNumber3">0</h4></td>
			<td><div class="race-icons"><a href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 0, completeArray);"><img id="raceIconMale4" class="p" border="0" /></a><a href="javascript: changeStats(4, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, 1, completeArray);"><img id="raceIconFemale4" class="p" border="0" /></a></div><h4 id="raceNumber4">0</h4></td>
		</tr>
		</table>
		</div>
	</div>
	
	<div class="class-stats">
     <h2><xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.class.breakdown']"/></h2>
		<div class="class-container">
	<table>
	 <thead>
		<tr>
      <td><h3><span id="classPercentage0">0</span>%</h3></td>
			<td><h3><span id="classPercentage1">0</span>%</h3></td>
			<td><h3><span id="classPercentage2">0</span>%</h3></td>
			<td><h3><span id="classPercentage3">0</span>%</h3></td>
			<td><h3><span id="classPercentage4">0</span>%</h3></td>
			<td><h3><span id="classPercentage5">0</span>%</h3></td>
			<td><h3><span id="classPercentage6">0</span>%</h3></td>
			<td><h3><span id="classPercentage7">0</span>%</h3></td>
			<td><h3><span id="classPercentage8">0</span>%</h3></td>
			<td><h3><span id="classPercentage9">0</span>%</h3></td>
		</tr>
		</thead>		
		<tbody>
		<tr class="graph-layout">
			<td><div class="class-graph"><div id="classBarStyle0" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle1" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle2" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle3" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle4" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle5" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle6" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle7" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle8" class="classbar"></div></div></td>
			<td><div class="class-graph"><div id="classBarStyle9" class="classbar"></div></div></td>
		</tr>
		</tbody>
		<tr>
      <td><div id="classIcon0" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 0, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[0][0])" ></a></div></td>            
			<td><div id="classIcon1" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 1, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[1][0])" ></a></div></td>
			<td><div id="classIcon2" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 2, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[2][0])" ></a></div></td>
			<td><div id="classIcon3" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 3, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[3][0])" ></a></div></td>
			<td><div id="classIcon4" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 4, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[4][0])" ></a></div></td>
			<td><div id="classIcon5" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 5, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[5][0])" ></a></div></td>
			<td><div id="classIcon6" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 6, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[6][0])" ></a></div></td>
			<td><div id="classIcon7" class="classicon staticTip"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 7, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[7][0])" ></a></div></td>
			<td><div id="classIcon8" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 8, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[8][0])" ></a></div></td>
			<td><div id="classIcon9" class="classicon"><a class="staticTip" href="#" onClick="changeStats(raceSelected, 9, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray); return false;" onmouseover="setTipText(classStringArray[9][0])" ></a></div></td>
		</tr>
		<tr>
      <td><h4><span id="classNumber0">0</span></h4></td>
			<td><h4><span id="classNumber1">0</span></h4></td>
			<td><h4><span id="classNumber2">0</span></h4></td>
			<td><h4><span id="classNumber3">0</span></h4></td>
			<td><h4><span id="classNumber4">0</span></h4></td>
			<td><h4><span id="classNumber5">0</span></h4></td>
			<td><h4><span id="classNumber6">0</span></h4></td>
			<td><h4><span id="classNumber7">0</span></h4></td>
			<td><h4><span id="classNumber8">0</span></h4></td>
			<td><h4><span id="classNumber9">0</span></h4></td>
		</tr>
		</table>
		</div>
	</div>
	
	<div class="level-stats">
		<h2><xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.level.breakdown']"/></h2>
		<div class="level-container">
		<table>
		<tbody>
		<tr class="graph-layout">
			<td onMouseOver="javascript: showTheLevel(10);"><div class="level-graph"><div id="levelBar10" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(11);"><div class="level-graph"><div id="levelBar11" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(12);"><div class="level-graph"><div id="levelBar12" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(13);"><div class="level-graph"><div id="levelBar13" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(14);"><div class="level-graph"><div id="levelBar14" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(15);"><div class="level-graph"><div id="levelBar15" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(16);"><div class="level-graph"><div id="levelBar16" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(17);"><div class="level-graph"><div id="levelBar17" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(18);"><div class="level-graph"><div id="levelBar18" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(19);"><div class="level-graph"><div id="levelBar19" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(20);"><div class="level-graph"><div id="levelBar20" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			
			<td onMouseOver="javascript: showTheLevel(21);"><div class="level-graph"><div id="levelBar21" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(22);"><div class="level-graph"><div id="levelBar22" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(23);"><div class="level-graph"><div id="levelBar23" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(24);"><div class="level-graph"><div id="levelBar24" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(25);"><div class="level-graph"><div id="levelBar25" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(26);"><div class="level-graph"><div id="levelBar26" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(27);"><div class="level-graph"><div id="levelBar27" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(28);"><div class="level-graph"><div id="levelBar28" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(29);"><div class="level-graph"><div id="levelBar29" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(30);"><div class="level-graph"><div id="levelBar30" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			
			<td onMouseOver="javascript: showTheLevel(31);"><div class="level-graph"><div id="levelBar31" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(32);"><div class="level-graph"><div id="levelBar32" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(33);"><div class="level-graph"><div id="levelBar33" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(34);"><div class="level-graph"><div id="levelBar34" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(35);"><div class="level-graph"><div id="levelBar35" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(36);"><div class="level-graph"><div id="levelBar36" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(37);"><div class="level-graph"><div id="levelBar37" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(38);"><div class="level-graph"><div id="levelBar38" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(39);"><div class="level-graph"><div id="levelBar39" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(40);"><div class="level-graph"><div id="levelBar40" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			
			<td onMouseOver="javascript: showTheLevel(41);"><div class="level-graph"><div id="levelBar41" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(42);"><div class="level-graph"><div id="levelBar42" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(43);"><div class="level-graph"><div id="levelBar43" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(44);"><div class="level-graph"><div id="levelBar44" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(45);"><div class="level-graph"><div id="levelBar45" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(46);"><div class="level-graph"><div id="levelBar46" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(47);"><div class="level-graph"><div id="levelBar47" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(48);"><div class="level-graph"><div id="levelBar48" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(49);"><div class="level-graph"><div id="levelBar49" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(50);"><div class="level-graph"><div id="levelBar50" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			
			<td onMouseOver="javascript: showTheLevel(51);"><div class="level-graph"><div id="levelBar51" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(52);"><div class="level-graph"><div id="levelBar52" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(53);"><div class="level-graph"><div id="levelBar53" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(54);"><div class="level-graph"><div id="levelBar54" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(55);"><div class="level-graph"><div id="levelBar55" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(56);"><div class="level-graph"><div id="levelBar56" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(57);"><div class="level-graph"><div id="levelBar57" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(58);"><div class="level-graph"><div id="levelBar58" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(59);"><div class="level-graph"><div id="levelBar59" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(60);"><div class="level-graph"><div id="levelBar60" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			
			<td onMouseOver="javascript: showTheLevel(61);"><div class="level-graph"><div id="levelBar61" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(62);"><div class="level-graph"><div id="levelBar62" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(63);"><div class="level-graph"><div id="levelBar63" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(64);"><div class="level-graph"><div id="levelBar64" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(65);"><div class="level-graph"><div id="levelBar65" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(66);"><div class="level-graph"><div id="levelBar66" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(67);"><div class="level-graph"><div id="levelBar67" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(68);"><div class="level-graph"><div id="levelBar68" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(69);"><div class="level-graph"><div id="levelBar69" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>

			<td onMouseOver="javascript: showTheLevel(70);"><div class="level-graph"><div id="levelBar70" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(71);"><div class="level-graph"><div id="levelBar71" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(72);"><div class="level-graph"><div id="levelBar72" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(73);"><div class="level-graph"><div id="levelBar73" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(74);"><div class="level-graph"><div id="levelBar74" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(75);"><div class="level-graph"><div id="levelBar75" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(76);"><div class="level-graph"><div id="levelBar76" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(77);"><div class="level-graph"><div id="levelBar77" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(78);"><div class="level-graph"><div id="levelBar78" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(79);"><div class="level-graph"><div id="levelBar79" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
			<td onMouseOver="javascript: showTheLevel(80);"><div class="level-graph"><div id="levelBar80" class="levelbar"><xsl:comment>ie</xsl:comment></div></div></td>
		</tr>
		</tbody>
		<tr class="level-range">
			<td colspan="5"><div class="levelicon">10</div></td>
			<td colspan="5"><div class="levelicon">15</div></td>
			<td colspan="5"><div class="levelicon">20</div></td>
			<td colspan="5"><div class="levelicon">25</div></td>
			<td colspan="5"><div class="levelicon">30</div></td>
			<td colspan="5"><div class="levelicon">35</div></td>
			<td colspan="5"><div class="levelicon">40</div></td>
			<td colspan="5"><div class="levelicon">45</div></td>
			<td colspan="5"><div class="levelicon">50</div></td>
			<td colspan="5"><div class="levelicon">55</div></td>
			<td colspan="5"><div class="levelicon">60</div></td>
			<td colspan="5"><div class="levelicon">65</div></td>
			<td colspan="5"><div class="levelicon">70</div></td>
			<td colspan="6"><div class="levelicon">75 <em>80</em></div></td>

		</tr>
		</table>
		<div class="stats-console">
			<div class="stat-padding">

		<p>
		<span class="tooltipGuild">
		<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.totalChars']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/></span><strong>&#160;<xsl:value-of select="$allMembersCount" /></strong></p>
		<p> 
		<span class="tooltipGuild"> 
		<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.matching']"/><xsl:value-of select="$loc/strs/general/str[@id='colon']"/></span>&#160;<strong id="numReturnedResults"></strong></p>
		
		
		<!-- Loc - guild-tooltip-stats-string -->
		<p>
		<span id="countSpecificLevel" class="tooltipGuild">
			<xsl:if test="$lang='ko_kr'"><b id="replaceLevelNum"></b><xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.number']"/></xsl:if>
			<xsl:if test="$lang !='ko_kr'">	<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.number']"/><b id="replaceLevelNum"></b></xsl:if>
			<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.numberAfter']"/>:
		</span>&#160;<strong id="printNum80"></strong></p>
		<p>
		<span class="tooltipGuild">
			<xsl:if test="$lang='ko_kr'"><b id="replaceLevelPercent"></b><xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.percentage']"/></xsl:if>
			<xsl:if test="$lang !='ko_kr'">	<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.percentage']"/><b id="replaceLevelPercent"></b></xsl:if>		 
			<b id="countSpecificLevel"></b>
			<xsl:value-of select="$loc/strs/guildStats/str[@id='armory.guild-stats.percentageAfter']"/>:
		</span>&#160;<b id="printPercent80"></b>%</p>
		<!-- Loc - guild-tooltip-stats-string -->
</div>
		</div></div>	
		</div>
	
	</div>
	<script type="text/javascript">	

	document.getElementById('replaceLevelNum').innerHTML=levelMax;
	document.getElementById('replaceLevelPercent').innerHTML=levelMax;

	for (r=0; r &lt; thisRaceArray.length; r++) {
		theRaceId=thisRaceArray[r][1];
		document.getElementById('raceName'+ r).innerHTML='&lt;a href="#" onClick="changeStats('+ r +', classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, -1, completeArray); return false;"&gt;'+thisRaceArray[r][0] +'&lt;/a&gt;'; 
		document.getElementById('raceShield'+ r).className += ' shield-'+theRaceId;
	}


	for (t=0; t &lt; classStringArray.length; t++) {
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
	
	
</xsl:template>

</xsl:stylesheet>