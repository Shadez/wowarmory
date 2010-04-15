<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="../includes.xsl"/>

<xsl:template name="selectTeamTypeData">

<xsl:variable name = "docArena" select = "document('../../_data/arenacost.xml')" />

 <div class="parchment-top">
  <div class="parchment-content">

<div class="list">
	<xsl:call-template name="tabs">
		<xsl:with-param name="tabGroup" select="'tools'" />
		<xsl:with-param name="currTab" select="'arenaCalculator'" />
		<xsl:with-param name="subTab" select="''" />
		<xsl:with-param name="tabUrlAppend" select="''" />
		<xsl:with-param name="subtabUrlAppend" select="''" />
	</xsl:call-template>
<div class="full-list">

<div class="info-pane">
<div class="profile-wrapper">
<blockquote><b class="iarenateams"><h4><a href="battlegroups.xml"><xsl:value-of select="$loc/strs/arena/str[@id='arena']"/></a></h4><h3><xsl:value-of select="$loc/strs/arenaCalc/str[@id='title']"/></h3></b></blockquote>


<div class="sidebarstretch">
<div class="arenacalc">

<div style="position:relative; z-index:9999;">

	<div class="crosshairsketch"></div>
</div>


<div class="maincontent">


<div class="calc-select">


	<h1><xsl:value-of select="$loc/strs/arenaCalc/str[@id='selectCalc']"/></h1>

	<ul>
		<li class="calculatorActive" id="classPoints">
			<a href="#" class="button1bg" onClick="javascript:showCat('Points'); return false;">
				<div>
					<h2><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.arenaPoints']"/></h2>
					<h3><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.arenaPoints.question']"/></h3>
				</div>
			</a>
		</li>
		
		<li class="calculatorInactive" id="classRating">	
			<a href="#" class="button2bg" onClick="javascript:showCat('Rating'); calcRating(document.getElementById('inputRatingPointsNeeded').value);return false;">
				<div>
					<h2><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.rating']"/></h2>
					<h3><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.rating.question']"/></h3>
				</div>
			</a>
		</li>
		
		<li class="calculatorInactive" id="classTime">
			<a href="#" class="button3bg" onClick="javascript:showCat('Time'); calcGoal(document.getElementById('inputGoalPointsDesired').value, document.getElementById('inputAverageRatingGoal').value); return false;">
				<div>
					<h2><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.time']"/></h2>
					<h3><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.time.question']"/></h3>
				</div>
			</a>
		</li>
	</ul>
	
	<div class="clear"></div>
</div>



<div class="calculator">
<div class="calculator-botbg">
<div class="calculator-topbg">

<div style="height:600px">


<div id="hidePoints">
	<h4><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.arenaPoints.question']"/></h4>
	<div class="redrow">
		<span class="red-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='ratingColon']"/></span>
		<div><input onFocus = "this.select()" value = "0" id = "inputRating" name = "inputRating" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcPoints(this.value);" /></div>
	</div>
	<ul>
		<li><span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='arenapoints']"/></span><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='twoVcolon']"/></h5><h6 id="replaceTwo">0</h6></div></li>
		<li><span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='arenapoints']"/></span><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='threeVcolon']"/></h5><h6 id="replaceThree">0</h6></div></li>
		<li><span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='arenapoints']"/></span><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='fiveVcolon']"/></h5><h6 id="replaceFive">0</h6></div></li>
	</ul>
</div>



<div id="hideRating" style="display:none;">
	<h4><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.rating.question']"/></h4>
	
	<div id = "hideRatingCalc" style="display:block;" class="equation">
		
		<table>
			<tr>
				<td class="eqlabel"><span class="teal-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='itemCostColon']"/></span></td>
				<td rowspan="5" style="width:61px;"></td>
				<td class="equation-input"><input value = "0" name = "inputItemCost" onFocus="this.select(); focusCalcPointsNeeded();" id = "inputArmorCost" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcDiffRating();" /></td>
			</tr>
			<tr>
				<td colspan="3" class="eqspacer1"></td>
			</tr>
			<tr>
				<td class="eqlabel"><span class="green-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='haveArenaPointsColon']"/></span></td>
				<td class="equation-input"><input value = "0" name = "inputHavePoints" onFocus="this.select(); focusCalcPointsNeeded();" id = "inputCurrentPoints" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcDiffRating(); check5000error(this.value);" /><!--<span name = "error5000">(You can have 5000 points maximum)</span>--></td>
			</tr>
			<tr>
				<td colspan="3" class="eqspacer2"></td>
			</tr>
			<tr>
				<td class="eqlabel"><span class="brown-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='pointsNeededColon']"/></span></td>
				<td class="equation-input"><input value = "0" name = "inputPointsNeeded" class = "inputUnfocus" onFocus="this.select(); focusPointsNeeded();" id = "inputRatingPointsNeeded" type="text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcRating(this.value);" /></td>
			</tr>
		</table>
		
	</div>
	
	<div class="ratingtable">

		<div class="ratingweeks">
			<span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='numWeeks']"/></span>
			<ul>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week1']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week2']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week3']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week4']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week5']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week6']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week7']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week8']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week9']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week10']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week11']"/></li>
				<li><xsl:value-of select="$loc/strs/arenaCalc/str[@id='week12']"/></li>
			</ul>
		</div>
		
		<div class="ratingbracket">
			<span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='avgtwo']"/></span>
			<ul>
				<li><span id = "replaceRatingTwo1">0</span></li>
				<li><span id = "replaceRatingTwo2">0</span></li>
				<li><span id = "replaceRatingTwo3">0</span></li>
				<li><span id = "replaceRatingTwo4">0</span></li>
				<li><span id = "replaceRatingTwo5">0</span></li>
				<li><span id = "replaceRatingTwo6">0</span></li>
				<li><span id = "replaceRatingTwo7">0</span></li>
				<li><span id = "replaceRatingTwo8">0</span></li>
				<li><span id = "replaceRatingTwo9">0</span></li>
				<li><span id = "replaceRatingTwo10">0</span></li>
				<li><span id = "replaceRatingTwo11">0</span></li>
				<li><span id = "replaceRatingTwo12">0</span></li>
			</ul>
		</div>
		
		<div class="ratingbracket">
			<span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='avgthree']"/></span>
			<ul>
				<li><span id = "replaceRatingThree1">0</span></li>
				<li><span id = "replaceRatingThree2">0</span></li>
				<li><span id = "replaceRatingThree3">0</span></li>
				<li><span id = "replaceRatingThree4">0</span></li>
				<li><span id = "replaceRatingThree5">0</span></li>
				<li><span id = "replaceRatingThree6">0</span></li>
				<li><span id = "replaceRatingThree7">0</span></li>
				<li><span id = "replaceRatingThree8">0</span></li>
				<li><span id = "replaceRatingThree9">0</span></li>
				<li><span id = "replaceRatingThree10">0</span></li>
				<li><span id = "replaceRatingThree11">0</span></li>
				<li><span id = "replaceRatingThree12">0</span></li>
			</ul>
		</div>
		
		<div class="ratingbracket" style="margin-right:0;">
			<span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='avgfive']"/></span>
			<ul>
				<li><span id = "replaceRatingFive1">0</span></li>
				<li><span id = "replaceRatingFive2">0</span></li>
				<li><span id = "replaceRatingFive3">0</span></li>
				<li><span id = "replaceRatingFive4">0</span></li>
				<li><span id = "replaceRatingFive5">0</span></li>
				<li><span id = "replaceRatingFive6">0</span></li>
				<li><span id = "replaceRatingFive7">0</span></li>
				<li><span id = "replaceRatingFive8">0</span></li>
				<li><span id = "replaceRatingFive9">0</span></li>
				<li><span id = "replaceRatingFive10">0</span></li>
				<li><span id = "replaceRatingFive11">0</span></li>
				<li><span id = "replaceRatingFive12">0</span></li>
			</ul>
		</div>
		
	</div>
<div class="clear"></div>
</div><!--hideRating-->



<div id = "hideTime" style="display:none;">
	<h4><xsl:value-of select="$loc/strs/arenaCalc/str[@id='calc.time.question']"/></h4>

	<div id = "hideTimeCalc" style="display:block;" class="equation">
		<table>
			<tr>
				<td class="eqlabel"><span class="teal-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='itemCostColon']"/></span></td>
				<td rowspan="5" style="width:61px;"></td>
				<td class="equation-input"><input value = "0" name = "inputItemCost" id = "inputArmorCostGoal" onFocus="this.select(); focusCalcPointsNeeded();" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcDiffGoal();" /></td>
			</tr>
			<tr>
				<td colspan="3" class="eqspacer1"></td>
			</tr>
			<tr>
				<td class="eqlabel"><span class="green-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='haveArenaPointsColon']"/></span></td>
				<td class="equation-input"><input value = "0" name = "inputHavePoints" id = "inputCurrentPointsGoal" onFocus="this.select(); focusCalcPointsNeeded();" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcDiffGoal(); check5000error(this.value);" /><!--<span name = "error5000">(You can have 5000 points maximum)</span>--></td>
			</tr>
			<tr>
				<td colspan="3" class="eqspacer2"></td>
			</tr>
			<tr>
				<td class="eqlabel"><span class="brown-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='pointsNeededColon']"/></span></td>
				<td class="equation-input"><input value = "0" name = "inputPointsNeeded" class = "inputUnfocus" id = "inputGoalPointsDesired" onFocus="this.select(); focusPointsNeeded();" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcGoal(this.value, document.getElementById('inputAverageRatingGoal').value); calcItemCost(eval(this.value));" /></td>
			</tr>
		</table>
		
	</div>
	
	<div class="redrow">
		<span class="red-label"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='averageRatingColon']"/></span>
		<div><input onFocus = "this.select();" value = "0" name = "inputRating" id = "inputAverageRatingGoal" type = "text" size = "4" onKeyUp = "javascript: traverseNames(this.name, this.value); calcDiffGoal();" /></div>
	</div>
		


	<ul>
		<li><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='twoVcolon']"/></h5><h6 id="replaceTwoGoal">0</h6></div></li>
		<li><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='threeVcolon']"/></h5><h6 id="replaceThreeGoal">0</h6></div></li>
		<li><div><h5><xsl:value-of select="$loc/strs/arenaCalc/str[@id='fiveVcolon']"/></h5><h6 id="replaceFiveGoal">0</h6></div></li>
	</ul>
	

</div><!--hideTime-->


</div>
</div>


</div>
</div>
</div>




<div class="sidebar">
<h1><div><span><xsl:value-of select="$loc/strs/arenaCalc/str[@id='referenceSheet']"/></span></div></h1>
<div class="sidebar-padding">

	
	
	<div class="sidebar-module pinned-player" id = "hideOpera">
		<h2>
			<span></span>
			<a href="updates.xml#anchorpinprofile" id="hideWhatPin"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.whatsthis']"/></a>
			<xsl:value-of select="$loc/strs/arenaCalc/str[@id='pinnedProfile']"/>
		</h2>
		<div class="sidebar-module-bot">
			<div class="profile-name">
				<span id="replacePinName" class="playername">                    
                    <strong><xsl:value-of select="$loc/strs/login/str[@id='armory.login.mustlogin']"/></strong>                                       
                </span>
                <span id="replacePinGuild"></span>
			</div>
			<table id = "colorRating" class="ratings-on">
				<tr>
					<td></td>
					<td><xsl:value-of select="$loc/strs/arenaCalc/str[@id='rating']"/></td>
					<td><xsl:value-of select="$loc/strs/arenaCalc/str[@id='points']"/></td>
				</tr>		
				<tr>
					<td><a id = "href2" class="arenalinkoff"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.2v2']"/></a><xsl:value-of select="$loc/strs/arenaCalc/str[@id='colon']"/></td>
					<td name = "colorRating" class="pinned-redbg"><span id = "replace2Rating">-</span></td>
					<td><span id = "replace2Points">-</span></td>
				</tr>
				<tr>
					<td><a id = "href3" class="arenalinkoff"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.3v3']"/></a><xsl:value-of select="$loc/strs/arenaCalc/str[@id='colon']"/></td>
					<td name = "colorRating" class="pinned-redbg"><span id = "replace3Rating">-</span></td>
					<td><span id = "replace3Points">-</span></td>
				</tr>
				<tr>
					<td><a id = "href5" class="arenalinkoff"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.5v5']"/></a><xsl:value-of select="$loc/strs/arenaCalc/str[@id='colon']"/></td>
					<td name = "colorRating" class="pinned-redbg"><span id = "replace5Rating">-</span></td>
					<td><span id = "replace5Points">-</span></td>
				</tr>
				<tr>
					<td colspan="3" class="table-seperator"></td>
				</tr>
				<tr>
					<td colspan="2"><xsl:value-of select="$loc/strs/arenaCalc/str[@id='haveArenaPointsColon']"/></td>
					<td id = "colorHavePoints"><span id = "replaceCurrentPoints">-</span></td>
				</tr>
			</table>
			<p><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='disclaimer.stats']" /></p>
		</div>
	</div>
	
	
	<div class="sidebar-module legend">
		<h2>
			<span></span>
			<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='title.itemCosts']" />
		</h2>
		
		<div id="divItemCosts" class="sidebar-module-bot">
			<select onChange = "showHideLegend(this.value); return false">

			<xsl:for-each select = "$docArena/arenaItems/season" >
					<xsl:variable name = "theKey" select = "@key" />
					<option value = "{$theKey}"><xsl:value-of select = "$loc/strs/arenaCalc/str[@id=concat('items.', $theKey)]" /></option>
			</xsl:for-each>

			</select><br />
			<xsl:apply-templates select="$docArena"/>
		</div>
	</div>
</div>
</div>

		<div class="clear"></div>
	</div>
</div>



<div class="rlbox2 aboutarena">
	<div>
		<h1><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='title.formulae']" /></h1>
		<div class="formulae">
			<table>
				<tr>
					<td class="formula-label1"><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='formula.ifrating']" /> &#8804; 1500</td>
					<td>&#8594;</td>
					<td class="formula-label2"><span class="pointscolor"><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='points']" /></span> &#61;</td>
					<td colspan="3" style="padding-left:0;">[ <xsl:value-of select = "$loc/strs/arenaCalc/str[@id='decimal']" />22 &#215; <span class="ratingcolor"><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='rating']" /></span> + 14 ]</td>
				</tr>
				<tr>
					<td colspan="3" class="formula-label2 formula-spacer"><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='ninerepeating1']" /></td>
					<td colspan="3" class="formula-spacer" style="padding-left:0;"><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='ninerepeating2']" /></td>
				</tr>
				<tr>
					<td class="formula-label1"><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='formula.ifrating']" /> &#62; 1500</td>
					<td>&#8594;</td>
					<td class="formula-label2"><span class="pointscolor"><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='points']" /></span> &#61;</td>
					<td class="lfloor"></td>
					<td class="formula-division">
					<div>1511<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='decimal']" />26</div>
					<div class="hr"><hr/></div>
					<div>1 + 1639<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='decimal']" />28 &#215; 2<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='decimal']" />71828 <sup>-0<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='decimal']" />00412 &#215; <span class="ratingcolor"><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='rating']" /></span></sup></div></td>
					<td class="rfloor"></td>
				</tr>
			</table>
		</div>
		
		<div class="penalty">
			<table>
				<tr>
					<td class="penalty-title"><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='penalty.title']" /></td>
					<td><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='penalty.two']" /></td>
				</tr>
				<tr>
					<td></td>
					<td><xsl:apply-templates select = "$loc/strs/arenaCalc/str[@id='penalty.three']" /></td>
				</tr>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">

function calcItemCost(thePointsNeeded){
	if (thePointsNeeded == '' || thePointsNeeded == 0 || !thePointsNeeded) {
		document.getElementById('inputArmorCostGoal').value = 0;
		document.getElementById('inputArmorCost').value = 0;	
	} else {
		document.getElementById('inputArmorCostGoal').value = eval(document.getElementById('inputCurrentPointsGoal').value) + eval(thePointsNeeded);
		document.getElementById('inputArmorCost').value = eval(document.getElementById('inputCurrentPointsGoal').value) + eval(thePointsNeeded);
	}

}

function traverseNames(elemName, theValue){
	var tempArray = document.getElementsByName(elemName);
	for (var i = 0; i &lt; tempArray.length; i++) {
		tempArray[i].value = theValue;
	}
}

function calcDiffRating() {
	var armorCost = document.getElementById('inputArmorCost').value;
	var currentPoints = document.getElementById('inputCurrentPoints').value;
	if (armorCost) {
		if (!currentPoints)
			currentPoints = 0;
		var diff = armorCost - currentPoints;
		if (diff &gt;= 0) {
			calcRating(diff);
			document.getElementById('inputRatingPointsNeeded').value = diff;
			document.getElementById('inputGoalPointsDesired').value = diff;
		} else {
			calcRating(diff);		
			document.getElementById('inputRatingPointsNeeded').value = 0;	
			document.getElementById('inputGoalPointsDesired').value = 0;			
		}
	} else {
			calcRating(0);
			document.getElementById('inputRatingPointsNeeded').value = 0;	
			document.getElementById('inputGoalPointsDesired').value = 0;			
	}
}

function focusPointsNeeded() {
	document.getElementById('inputArmorCost').className = 'inputUnfocus';
	document.getElementById('inputCurrentPoints').className = 'inputUnfocus';
	document.getElementById('inputRatingPointsNeeded').className = 'inputFocus';
	
	document.getElementById('inputArmorCostGoal').className = 'inputUnfocus';
	document.getElementById('inputCurrentPointsGoal').className = 'inputUnfocus';
	document.getElementById('inputGoalPointsDesired').className = 'inputFocus';

}

function focusCalcPointsNeeded() {
	document.getElementById('inputArmorCost').className = 'inputFocus';
	document.getElementById('inputCurrentPoints').className = 'inputFocus';
	document.getElementById('inputRatingPointsNeeded').className = 'inputUnfocus';
	
	document.getElementById('inputArmorCostGoal').className = 'inputFocus';
	document.getElementById('inputCurrentPointsGoal').className = 'inputFocus';
	document.getElementById('inputGoalPointsDesired').className = 'inputUnfocus';
}

function pointCalculator(theRating, theSize) {
	var thePenalty;
	var theRatingUsed = theRating;
	if (theSize == 2)
		thePenalty = .24;
	else if (theSize == 3)
		thePenalty = .12;
	else
		thePenalty = 0;
	
	if (isNaN(theRatingUsed) || theRatingUsed &lt; 1500) 
		theRatingUsed = 1500;
		
	if (theRatingUsed &lt;= 0) {
		return 0;
	} else if (theRatingUsed &lt;= 1500) {
		temp = 0.22 * eval(theRatingUsed) + 14;
    	return Math.round(temp * (1 - thePenalty));
	} else {
		temp = 1511.26 / (1 + 1639.28 * Math.pow(2.71828, (-0.00412 * eval(theRatingUsed))));
    	return Math.floor(temp * (1 - thePenalty));
	}

}

function check5000error(havePoints) {

	var nameArray = document.getElementsByName('error5000');
/*	
	if (havePoints &gt; 5000) {
		nameArray[0].style.display = "block";
		nameArray[1].style.display = "block";		
	} else {
		nameArray[0].style.display = "none";
		nameArray[1].style.display = "none";		
	}*/
}

function calcPoints(rating) {
	var pointsArray = new Array();
	var temp;
	
   	pointsArray[0] = pointCalculator(rating, 2);
   	pointsArray[1] = pointCalculator(rating, 3);
   	pointsArray[2] = pointCalculator(rating, 5);
	
	document.getElementById("replaceTwo").innerHTML = pointsArray[0];
	document.getElementById("replaceThree").innerHTML = pointsArray[1];
	document.getElementById("replaceFive").innerHTML = pointsArray[2];
	
	return pointsArray;	
}

function calcRating(points) {
	var tempArray = new Array();
	var displayNumWeeks = 12;
	var armorCost = eval(document.getElementById('inputCurrentPoints').value) + eval(points);
	var inputArmorCost = document.getElementById('inputArmorCost').value;
	
	if (inputArmorCost == "") {
	} else if (inputArmorCost == 0 &amp;&amp; document.getElementById('inputRatingPointsNeeded').value == 0){
	} else if (isNaN(armorCost)) {
		document.getElementById('inputArmorCost').value = points;
		document.getElementById('inputArmorCostGoal').value = points;
	} else {
		document.getElementById('inputArmorCost').value = armorCost;
		document.getElementById('inputArmorCostGoal').value = armorCost;
	}
		
	for (var i = 1; i &lt;= displayNumWeeks; i++) {
		tempArray = calcRatingFunc(Math.ceil(points/i));
		document.getElementById("replaceRatingTwo"+i).innerHTML = tempArray[0];
		document.getElementById("replaceRatingThree"+i).innerHTML = tempArray[1];
		document.getElementById("replaceRatingFive"+i).innerHTML = tempArray[2];
	}
}

function calcRatingFunc(points) {
/* used by calcRating */
	var pointsArray = new Array();
	
	if (!points)
		points = 0;
	
//2v2	
	if (points &lt;= 261) {
    	pointsArray[0] = Math.floor(((eval(points) / (1 - .24) - 14)/0.22)) - 2;
	} else {
    	pointsArray[0] = Math.ceil((Math.log((1511.26/(points / (1 - .24)) - 1)/1639.28))/(Math.log(2.71828))/-0.00412);
	}

//3v3
	if (points &lt;= 303) {
    	pointsArray[1] = Math.floor(((eval(points) / (1 - .12) - 14)/0.22)) - 2;	
	} else {
    	pointsArray[1] = Math.ceil((Math.log((1511.26/(points / (1 - .12)) - 1)/1639.28))/(Math.log(2.71828))/-0.00412);	
	}
	
	
//5v5	
	if (points &lt;= 344) {
    	pointsArray[2] = Math.floor((eval(points) - 14)/0.22) - 2;
	} else {
    	pointsArray[2] = Math.ceil((Math.log((1511.26/points - 1)/1639.28))/(Math.log(2.71828))/-0.00412);
	}
	
	if (pointsArray[0] &lt; 0)
		pointsArray[0] = 0;
	if (pointsArray[1] &lt; 0)
		pointsArray[1] = 0;
	if (pointsArray[2] &lt; 0)
		pointsArray[2] = 0;				

	if (isNaN(pointsArray[0]))
		pointsArray[0] = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='impossible']" />";
	if (isNaN(pointsArray[1]))
		pointsArray[1] = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='impossible']" />";
	if (isNaN(pointsArray[2]))
		pointsArray[2] = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='impossible']" />";
	
	return pointsArray;
}

function calcGoal(pointsDesired, averageRating) {
	var pointsRecieved = new Array();
	
	if (averageRating) {
		pointsReceived = calcPoints(averageRating);
		if (pointsReceived[0] != 0) {
			document.getElementById('replaceTwoGoal').innerHTML = printWeeks(Math.ceil(pointsDesired/pointsReceived[0]));
			document.getElementById('replaceThreeGoal').innerHTML = printWeeks(Math.ceil(pointsDesired/pointsReceived[1]));
			document.getElementById('replaceFiveGoal').innerHTML = printWeeks(Math.ceil(pointsDesired/pointsReceived[2]));
		} else {
			document.getElementById('replaceTwoGoal').innerHTML = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='week0']" />";
			document.getElementById('replaceThreeGoal').innerHTML = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='week0']" />";
			document.getElementById('replaceFiveGoal').innerHTML = "<xsl:value-of select = "$loc/strs/arenaCalc/str[@id='week0']" />";
		}		
	}
}

function calcDiffGoal() {
	var armorCost = document.getElementById('inputArmorCostGoal').value;
	var currentPoints = document.getElementById('inputCurrentPointsGoal').value;
	var averageRating = document.getElementById('inputAverageRatingGoal').value;	
	
	var diff = armorCost - currentPoints;	
	
	if (diff &lt;= 0)
		diff = 0;
	
	if (diff &gt;= 0) {
		document.getElementById('inputRatingPointsNeeded').value = diff;
		document.getElementById('inputGoalPointsDesired').value = diff;		
	} else {
		return false;
	}
	
	if (averageRating) {
		calcGoal(diff, averageRating);
	}
}



function showCat(whichDiv){

	document.getElementById('colorRating').className = "";
	
	document.getElementById('colorHavePoints').className = "";	

	<xsl:for-each select="$docArena/arenaItems/season[@usesArenaPoints = 1]">
		$('#hideLegend<xsl:value-of select = "@key" />').removeClass('itemson');
	</xsl:for-each>

	document.getElementById('hidePoints').style.display = "none";
	document.getElementById('hideRating').style.display = "none";
	document.getElementById('hideTime').style.display = "none";		
	
	document.getElementById('classPoints').className = "calculatorInactive";
	document.getElementById('classRating').className = "calculatorInactive";
	document.getElementById('classTime').className = "calculatorInactive";
	
	document.getElementById('hide'+whichDiv).style.display = "";	
	document.getElementById('class'+whichDiv).className = "calculatorActive";
	
	if (whichDiv == "Points" || whichDiv == "Time") {
		document.getElementById('colorRating').className = "ratings-on";
	}
	
	if (whichDiv == "Rating" || whichDiv == "Time") {
		document.getElementById('colorHavePoints').className = "pinned-greenbg";
	<xsl:for-each select = "$docArena/arenaItems/season[@usesArenaPoints = 1]">
		$('#hideLegend<xsl:value-of select = "@key" />').addClass('itemson');
	</xsl:for-each>
	}
	
}


function showHideLegend(whichSeason) {
	$('#divItemCosts .hideLegend').css('display', 'none');
	$('#hideLegend' + whichSeason).css('display', '');
}



   var http_request = false;
   function makeRequest(url, parameters) {
      http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType) {
            http_request.overrideMimeType('text/xml');
         }
      } else if (window.ActiveXObject) { // IE
         try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
            try {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
         }
      }
      if (!http_request) {
         alert('Cannot create XMLHTTP instance');
         return false;
      }
      http_request.onreadystatechange = alertContents;
      http_request.open('GET', url + parameters, true);
      http_request.send(null);
   }
//<![CDATA[
   function alertContents() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {

            var xmldoc = http_request.responseXML;
			
			var arenaPointsTest = xmldoc.getElementsByTagName('arenacurrency')[0];
			
			if (arenaPointsTest)
            	arenaPoints = arenaPointsTest.getAttribute("value");
			else
				arenaPoints = 0;
			
            var guildName = xmldoc.getElementsByTagName('character')[0].getAttribute("guildName");
            var guildUrl = xmldoc.getElementsByTagName('character')[0].getAttribute("guildUrl");

			if (guildName)
				document.getElementById('replacePinGuild').innerHTML = '&lt;<a href = "guild-info.xml?'+ guildUrl +'">'+ guildName +'</a>&gt;';
			
            var ratingsArrayTemp = new Array();
			ratingsArrayTemp = xmldoc.getElementsByTagName('arenaTeam');
			
			var ratingsArray = new Array();
			
			var pointMaker = new Array();
			pointMaker[0] = [0, 0];
			for (var i = 0; i < ratingsArrayTemp.length; i++) {
				ratingsArray[i] = [ratingsArrayTemp[i].getAttribute("size"), ratingsArrayTemp[i].getAttribute("rating"), pointCalculator(ratingsArrayTemp[i].getAttribute("rating"), ratingsArrayTemp[i].getAttribute("size"))]
				if (ratingsArray[i][2] > pointMaker[0][1])
					pointMaker[0] = [ratingsArray[i][0], ratingsArray[i][2]]
				document.getElementById('replace'+ ratingsArray[i][0] +'Rating').innerHTML = ratingsArray[i][1];
				document.getElementById('replace'+ ratingsArray[i][0] +'Points').innerHTML = ratingsArray[i][2]; 
				document.getElementById('href'+ratingsArray[i][0]).href = "team-info.xml?"+ ratingsArrayTemp[i].getAttribute("url");
				document.getElementById('href'+ratingsArray[i][0]).className = "jeffon";
			}

			if (pointMaker[0][0])
				document.getElementById('replace'+ pointMaker[0][0] +'Points').innerHTML = "<strong>"+pointMaker[0][1] +"</strong>";

			document.getElementById('inputCurrentPoints').value = arenaPoints;
			document.getElementById('inputCurrentPointsGoal').value = arenaPoints;
			document.getElementById('replaceCurrentPoints').innerHTML = arenaPoints;			
         } else {
            alert('There was a problem with the request.');
         }
      }
   }
   
//add primary profile
if(isLoggedIn){
	var loggedInCharUrl = $(".userName").attr("href");
	var loggedInCharName = $(".userName").html();
	
	try{
		loggedInCharUrl = loggedInCharUrl.substr(loggedInCharUrl.indexOf(".xml")+4);	
	
		makeRequest('character-sheet.xml', loggedInCharUrl);
	
		document.getElementById('replacePinName').innerHTML = '<a href="character-sheet.xml'+ loggedInCharUrl +'">'+ loggedInCharName + '</a>';
		document.getElementById('hideWhatPin').style.display = "none";
	}catch(e){}
}else{

	document.getElementById('hideWhatPin').style.display = "none";
}

   


//]]>

var gTotalSeasons = <xsl:value-of select = "$docArena/arenaItems/season[position() = 1]/@key" />;
document.getElementById('hideLegend'+gTotalSeasons).style.display = "block";

var gBaseArenaPoints = <xsl:value-of select = "$docArena/arenaItems/season[position() = 1]/@defaultPoints" />;
document.getElementById("inputRating").value = gBaseArenaPoints;
document.getElementById("inputAverageRatingGoal").value = gBaseArenaPoints;

calcPoints(gBaseArenaPoints);

if (Browser.opera || Browser.safari)
	document.getElementById('hideOpera').style.display = "none";

</script>


	<!--/end team-type/-->	
  </div><!--/end profile-wrapper/-->
</div>

</div><!--/end player-side/-->

</div><!--/end list/-->
 </div>
</div>

</xsl:template>



<xsl:template match="arenaItems/season">
<div id="hideLegend{@key}" class="hideLegend" style="display: none;">
	<table>
	<xsl:apply-templates />
	</table>
    
</div>
</xsl:template>

<xsl:template match="arenaItems/season/honor">
	<tr>
		<td colspan="2">
			<span>
				<xsl:apply-templates mode="printf" select="$loc/strs/arenaCalc/str[@id='honorone']">
					<xsl:with-param name="param1" select="../@key" />
				</xsl:apply-templates><p />
				<xsl:apply-templates mode="printf" select="$loc/strs/arenaCalc/str[@id='honortwo']">
					<xsl:with-param name="param1" select="../@key" />
				</xsl:apply-templates><p />
				<a href="search.xml?fl%5Bsource%5D=pvpAlliance&amp;fl%5Bpvp%5D=arena{../@key}&amp;fl%5Btype%5D=all&amp;searchType=items">
					<xsl:apply-templates mode="printf" select="$loc/strs/arenaCalc/str[@id='seasononelink']">
						<xsl:with-param name="param1" select="../@key" />
					</xsl:apply-templates>
				</a>
			</span><p />
		</td>
	</tr>
</xsl:template>

<xsl:template match="arenaItems/season/weapon">
	<tr>
		<td class="itemtype-label"><span><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='weapons']" /></span></td>
		<td class="itemcost-label"><span><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='itemCost']" /></span></td>
	</tr>
</xsl:template>

<xsl:template match="arenaItems/season/armor">
	<tr>
		<td colspan="2" class="itemcost-bot"></td>
	</tr>
	<tr>
		<td class="itemtype-label"><span><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='armor']" /></span></td>
		<td class="itemcost-label"><span><xsl:value-of select = "$loc/strs/arenaCalc/str[@id='itemCost']" /></span></td>
	</tr>
</xsl:template>

<xsl:template match="arenaItems/season/end">
	<tr>
		<td colspan="2" class="itemcost-bot"></td>
	</tr>
</xsl:template>	

<xsl:template match="arenaItems/season/item">
<xsl:variable name="stringKey" select="@key" />
	<tr>
		<td class="itemcost-type"><a href="{@url}"><xsl:value-of select="$loc/strs/arenaCalc/str[@id=$stringKey]" /></a></td>
		<td class="itemcost-cost"><xsl:call-template name = "search-and-replace">
			  <xsl:with-param name = "input" select = "@cost" />
			  <xsl:with-param name = "search-string" select = "'or'" />
			  <xsl:with-param name = "replace-string" select = "$loc/strs/arenaCalc/str[@id='or']" />
			</xsl:call-template></td>
	</tr>
</xsl:template>

<xsl:template match="page/selectTeamType">

<div id="dataElement">
    <xsl:call-template name="selectTeamTypeData" />
</div>

</xsl:template>

</xsl:stylesheet>
