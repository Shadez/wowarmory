function TalentCalculator() {

/*--------------------------------------------*/
//              Private Variables             //
/*--------------------------------------------*/

var talentVars;
var whichClass;
var pageMode = '';
var petMode = false;
var uniqueId = '';
var talentTrees;
var talentLookup = {};
var petFamilies;
var currentPetTree;

/*--------------------------------------------*/
//                 Constants                  //
/*--------------------------------------------*/

var ICON_PREFIX      = 'wow-icons/_images/_talents31x31/';
var ICON_PREFIX_GREY = 'wow-icons/_images/_talents31x31/grey/';
var ICON_TREE_PREFIX = 'wow-icons/_images/21x21/'; 

/*--------------------------------------------*/
//               Public Methods               //
/*--------------------------------------------*/

this.initTalentCalc = function(WhichClass, TalStr, PageMode, PetMode, UniqueId, TalentData, PetData) {

	WhichClass  = parseInt(WhichClass);
	pageMode    = PageMode;
	petMode     = (PetMode == 'true');
	uniqueId    = UniqueId;
	talentTrees = TalentData;
	petFamilies = PetData;

	talentVars = {
		talHolder:            $('#' + getUniqueId('talContainer')),
		pointsLeft:           $("#pointsLeft"),
		pointsSpent:          $("#pointsSpent"),
		reqLevel:             $("#requiredLevel"),
		talentPtsStr:         $('#' + getUniqueId('linkToBuild')),
		pts:                  0,
		basePts:              (petMode ? 16 : 71),
		extraPts:             0,
		maxTrees:             3,
		maxTiers:             (petMode ? 6 : 11),
		pointsPerTier:        (petMode ? 3 : 5),
		beastMasteryReqLevel: 60,
		beastMasteryExtraPts: 4
	};
	talentVars.maxPts = talentVars.basePts + talentVars.extraPts;

	// First pass: only store a reference to each talent
	for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum)
	{
		var tree = talentTrees[treeNum];

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum)
		{
			var talent = tree.talents[talentNum];

			// Store a direct reference to each talent for later use
			talentLookup[talent.id] = talent;
		}
	}

	// Second pass: actual initialization
	for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum)
	{
		var tree = talentTrees[treeNum];

		tree.nameLbl   = $('#' + getUniqueId('treeName'  + '_' + treeNum));
		tree.iconDiv   = tree.nameLbl.parent();
		tree.ctr       = $('#' + getUniqueId('treeSpent' + '_' + treeNum));
		tree.num       = treeNum;
		tree.pts       = 0;
		tree.tierVals  = [0,0,0,0,0,0,0,0,0,0,0];
		tree.reqArrows = [];

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum)
		{
			var talent = tree.talents[talentNum];

			talent.num       = talentNum;
			talent.pts       = 0;
			talent.maxPts    = talent.ranks.length;
			talent.ele       = $('#' + getUniqueId(talent.id + '_talentHolder'));
			talent.iconEle   = $('#' + getUniqueId(talent.id + '_iconHolder'));
			talent.ctr       = $('#' + getUniqueId(talent.id + '_numPoints'));
			talent.tree      = treeNum;

			// TODO: Have this data stored in the JS array directly.
			talent.spellInfo = ($("#spellInfo_" + talent.id) ? $("#spellInfo_" + talent.id).html() : null);

			if(talent.requires)
			{
				talent.reqArrows = [];

				// Store reverse lookup array (direct references to the dependent talents)
				var reqTalent = talentLookup[talent.requires];
				if(reqTalent) {
					if(!reqTalent.dependencies) {
						reqTalent.dependencies = [];
					}
					reqTalent.dependencies.push(talent);
				}
			}

			// Disable context menu so we can right-click talent to subtract
			talent.ele.bind('contextmenu', blockEvent);
		}
	}

	if(petMode)
	{
		if(WhichClass > 0) { // A specific pet family was passed
			changePetTree(null, WhichClass);
		}
		else {
			// Support for pet tree URLs (e.g. ?pid=-1 for Ferocity)
			if(WhichClass >= -3 && WhichClass <= -1)
				changePetTree(-WhichClass - 1);
			else
				changePetTree(0); // Default tree (Ferocity)
		}
	}
	else
	{
		whichClass = WhichClass;
		drawRequiredArrows();
	}

	if(!applyTalents(TalStr))
		updatePointsLeftDisplay();
}

this.addTalent = function(id, e){
	addTalent(id, e);
}

this.makeTalentTooltip = function(id) {
	makeTalentTooltip(id);
}

this.applyTalents = function(build) {
	applyTalents(build);
}

this.resetAllTalents = function() {
	resetAllTalents();	
}

this.resetTalents = function(treeNum, check) {
	resetTalents(treeNum, check);
}

this.changePetTree = function(treeNum, family, e) {
	changePetTree(treeNum, family, e);
}

this.toggleBeastMastery = function() {
	toggleBeastMastery();
}

this.displayBeastMasteryTooltip = function() {
	displayBeastMasteryTooltip();
}

this.displayPetFamilyTooltip = function(id) {
	displayPetFamilyTooltip(id);
}

this.showPrintableVersion = function() {
	showPrintableVersion();
}

/*--------------------------------------------*/
//              Private Methods               //
/*--------------------------------------------*/

// Makes a unique identifier for a DOM element
// (e.g. 'talContainer' becomes 'talContainer_wenld36')
function getUniqueId(id) {
	return id + '_' + uniqueId;
}

// Draws required arrows in the currently visible tree(s)
function drawRequiredArrows() {

	var parentOffset = $(talentVars.talHolder).offset();
	var arrowClass   = "";
	var treeNums     = getVisibleTrees();

	for(var i = 0; i < treeNums.length; ++i) {

		var treeNum = treeNums[i];
		var tree    = talentTrees[treeNum];

		if(tree.reqArrows.length > 0) // Skip tree if already drawn
			continue;

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum) {		
	
			var talent = tree.talents[talentNum];
			if(!talent.requires) continue; // Skip talent if no prerequisite
	
			var reqTalent = talentLookup[talent.requires];
			if(!reqTalent) continue;
	
			var requiredSpellOffset = reqTalent.ele.offset();			
			var currSpellOffset     = talent.ele.offset();
	
			var reqArw = { top: 0, left: 0, height: 0, width: 0 };
			
			// Vertical arrow
			if(currSpellOffset.left == requiredSpellOffset.left) {
				reqArw.top    = (requiredSpellOffset.top + 36) - parentOffset.top;
				reqArw.left   = requiredSpellOffset.left - parentOffset.left + 8;
				reqArw.height = currSpellOffset.top - requiredSpellOffset.top - 33;
				reqArw.width  = 21;

				var arrow = makeReqArrow(reqArw.top, reqArw.left, reqArw.height, reqArw.width, talentVars.talHolder, "vArrow disabledArrow");
				talent.reqArrows.push(arrow);
				tree.reqArrows.push(arrow);
			}
	
			// Horizontal arrow
			else if(currSpellOffset.top == requiredSpellOffset.top)	{
	
				// Right
				if(currSpellOffset.left > requiredSpellOffset.left) {
					reqArw.top    = (requiredSpellOffset.top + 11) - parentOffset.top;
					reqArw.left   = currSpellOffset.left - 17 - parentOffset.left;
					reqArw.height = 21;
					reqArw.width  = currSpellOffset.left - requiredSpellOffset.left - 31;
					arrowClass    = "hArrow arrowRight disabledArrow";
	
				// Left
				} else {
					reqArw.top    = (requiredSpellOffset.top + 11) - parentOffset.top;
					reqArw.left   = requiredSpellOffset.left - 17 - parentOffset.left;
					reqArw.height = 21;
					reqArw.width  = requiredSpellOffset.left - currSpellOffset.left - 33;					
					arrowClass    = "hArrow arrowLeft disabledArrow";

				}
				
				var arrow = makeReqArrow(reqArw.top, reqArw.left, reqArw.height, reqArw.width, talentVars.talHolder, arrowClass);
				talent.reqArrows.push(arrow);
				tree.reqArrows.push(arrow);
	
			// Angle arrow
			} else {
	
				// Vertical line needs to go on bottom in dom for arrow bracket
				reqArw.top    = (requiredSpellOffset.top + 17) - parentOffset.top;
				reqArw.left   = currSpellOffset.left + 8 - parentOffset.left;
				reqArw.height = currSpellOffset.top - requiredSpellOffset.top - 13;
				reqArw.width  = 21;		
	
				var arrow = makeReqArrow(reqArw.top, reqArw.left, reqArw.height, reqArw.width, talentVars.talHolder, "vArrow disabledArrow");
				talent.reqArrows.push(arrow);
				tree.reqArrows.push(arrow);
	
				reqArw.top = reqArw.top - 8;
	
				// Horizontal line				
				if(currSpellOffset.left > requiredSpellOffset.left) {
	
					// Right					
					reqArw.left   = currSpellOffset.left - 15 - parentOffset.left;
					reqArw.height = 21;
					reqArw.width  = currSpellOffset.left - requiredSpellOffset.left - 13;
					arrowClass    = "hArrow arrowRight plain disabledArrow";					
				} else {
	
					// Left
					reqArw.left   = requiredSpellOffset.left - 15 - parentOffset.left - 21;
					reqArw.height = 21;
					reqArw.width  = requiredSpellOffset.left - currSpellOffset.left -14;
					arrowClass    = "hArrow arrowLeft plain disabledArrowL";
				}

				var arrow = makeReqArrow(reqArw.top, reqArw.left, reqArw.height, reqArw.width, talentVars.talHolder, arrowClass);
				talent.reqArrows.push(arrow);
				tree.reqArrows.push(arrow);
			}
		}
	}
}

// Creates an arrow
function makeReqArrow(top, left, height, width, parentDiv, arrowClass) {

	// Add to parent, and return the element so that it can be stored for later use
	return $(
			'<div class="requiredArrow ' + arrowClass +
			'" style="top: ' + top +
			'px; left: '     + left +
			'px; height: '   + height +
			'px; width: '    + width +
			'px;"></div>'
	).appendTo(parentDiv);	
}

// When a talent is clicked on
function addTalent(id, e) {	

	if(pageMode != "calc") return; // Calculator mode only

	var talent    = talentLookup[id];
	var tree      = talentTrees[talent.tree];
	var runChecks = true;

	// Subtract a point
	if(e.which == 3 || e.button == 2 || e.ctrlKey) {

		if(talent.pts > 0) {
			
			// Figure out if we can subtract or not			
			var canSubtract = true;
			var tierTotal = 0;
			
			// Decrement and test
			tree.tierVals[talent.tier]--;

			// Go through tiers and add up points
			for(var tierNum = 0; tierNum < talentVars.maxTiers; ++tierNum) {
				
				tierTotal += tree.tierVals[tierNum];

				var nextTierNum = tierNum + 1;

				if(tree.tierVals[nextTierNum] > 0) { // Ignore tiers with no points in them					
					if(tierTotal < (nextTierNum * talentVars.pointsPerTier)) {
						canSubtract = false;
						break;
					}
				}
			}

			// Make sure the talent we're clicking on is not needed by other talents
			if(canSubtract) {
				if(talent.dependencies && talent.dependencies.length > 0) {
					for(var i = 0; i < talent.dependencies.length; ++i) {

						var dependentTalent = talent.dependencies[i];
						if(dependentTalent.pts > 0) {
							canSubtract = false; // If a dependent talent has points in it, we can't subtract.
							break;
						}
					}
				}
			}
			
			if(canSubtract) {
				talent.pts--;
				tree.pts--;
				talentVars.pts--;
				//tree.tierVals[talent.tier]--; (Already done earlier)

				talent.ele.removeClass("talentMax"); // Certainly no longer maxed if we're subtracting
				
				// If we're coming from being at max points, check all the trees
				if((talentVars.pts + 1) >= talentVars.maxPts) {
					checkAllTrees();	
				}
				
			} else { // Cannot substract? Undo what was done.
				tree.tierVals[talent.tier]++;
			}
		} else {
			runChecks = false;
		}

	// Add a point
	} else {

		// Make sure talent isn't maxed out
		if(talent.pts < talent.maxPts && talentVars.pts < talentVars.maxPts) {

			// Prevent from adding points above where is allowed
			if(tree.pts >= (talent.tier * talentVars.pointsPerTier) && checkDependentTalent(talent)) {				
				talent.pts++;
				tree.pts++;
				talentVars.pts++;
				tree.tierVals[talent.tier]++;

				if(talent.pts >= talent.maxPts) {
					talent.ele.addClass("talentMax");
				}

			} else {
				runChecks = false;
			}
		} else {
			runChecks = false;
		}
	}

	if(runChecks)
	{
		// Update counters
		talent.ctr.text(talent.pts);
		tree.ctr.text(tree.pts);

		makeTalentTooltip(id);

		checkEnabled(tree.num);
	}
}

// Verify if the dependent talent has enough points in it (if any)
function checkDependentTalent(talent) {

	if(talent.requires) {
		
		var reqTalent = talentLookup[talent.requires];
		if(reqTalent && reqTalent.pts < reqTalent.maxPts) {
			return false;
		}
	}		

	return true;
}

function checkAllTrees() {
	
	calcTreePts();
	
	for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum) {			
		checkEnabled(treeNum);	
	}
}

function checkEnabled(treeNum) {

	calcTreePts();
	
	var tree = talentTrees[treeNum];
	for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum) {

		var talent = tree.talents[talentNum];
		var enabled = (talent.tier == 0 || tree.pts >= (talent.tier * talentVars.pointsPerTier));

		if(enabled && talent.pts == 0 && (talentVars.pts >= talentVars.maxPts || pageMode != "calc"))
			enabled = false;
			
		// Dependent talents have special cases
		if(enabled && !checkDependentTalent(talent))
			enabled = false;

		if(enabled) {
			enableTalent(talent);
			enableArrows(talent);

		} else {
			disableTalent(talent);
			disableArrows(talent);
		}
	}
}

// Generate the talent tooltip and display it
function makeTalentTooltip(id) {

	var talent = talentLookup[id];
	if(!talent) return;

	var currRankNum = talent.pts;
	var maxRankNum  = talent.maxPts;

	// Name
	var talentTipStr = "<b>" + talent.name + "</b><br />";
	
	// Rank
	talentTipStr += sprintf(textTalentRank, currRankNum, maxRankNum) + "<br />";

	if(talent.spellInfo) {
		talentTipStr += talent.spellInfo + "<br />";			
	}
		
	// Show if the talent has a required talent
	if(talent.requires) {

		var reqTalent = talentLookup[talent.requires];
		
		if(reqTalent.pts < reqTalent.maxPts) { // Only if prereq. talent isn't maxed out				
		
			talentTipStr += '<span style="color: red">';

			if(reqTalent.maxPts == 1) {
				talentTipStr += sprintf(textTalentStrSingle, reqTalent.maxPts, reqTalent.name);
			} else {
				talentTipStr += sprintf(textTalentStrPlural, reqTalent.maxPts, reqTalent.name);				
			}
			talentTipStr += "</span><br />";
		}
	}
	
	// Show how many points is required in the tree (if not enough points)
	if(talent.tier > 0 && (talent.tier * talentVars.pointsPerTier) > talentTrees[talent.tree].pts) {
		talentTipStr += '<span style="color: red">'
		talentTipStr += sprintf(textTalentReqTreeTalents, talent.tier * talentVars.pointsPerTier, talentTrees[talent.tree].name) + "<br />";
		talentTipStr += '</span>'
	}

	// Current rank
	if(currRankNum != 0) {
		talentTipStr += "<span style='color: #ffd200'>" + talent.ranks[currRankNum - 1] + "</span>";
	}

	//  Next Rank
	if((currRankNum + 1) <= maxRankNum){
		if((maxRankNum > 1) && (currRankNum > 0)){
			talentTipStr += "<br /><br />" + textTalentNextRank + ":<br />";
		}
		talentTipStr += "<span style='color: #ffd200'>" + talent.ranks[currRankNum] + "</span>";
	}

	// IE6: Set maximum width by wrapping tooltip 
	if($.browser.msie && $.browser.version == "6.0"){
		talentTipStr = '<div style="width: 300px">' + talentTipStr + '</div>';
	}

	setTipText(talentTipStr);
}

function enableArrows(talent) {

	if(!talent.requires || !talent.reqArrows) return;
	
	for(var x = 0; x < talent.reqArrows.length; ++x) {
		$(talent.reqArrows[x]).removeClass("disabledArrow");
		$(talent.reqArrows[x]).removeClass("disabledArrowL");
	}
}

function disableArrows(talent) {

	if(!talent.requires || !talent.reqArrows) return;
	
	for(var x = 0; x < talent.reqArrows.length; ++x) {

		if($(talent.reqArrows[x]).hasClass("arrowLeft")) {
			$(talent.reqArrows[x]).addClass("disabledArrowL");
		} else {
			$(talent.reqArrows[x]).addClass("disabledArrow");
		}
	}
}

function enableTalent(talent) {
	talent.ele.removeClass("disabled");
	talent.iconEle.css("background-image", "url('" + ICON_PREFIX + talent.icon + ".jpg')");
}

function disableTalent(talent) {
	talent.ele.addClass("disabled");
	talent.iconEle.css("background-image", "url('" + ICON_PREFIX_GREY + talent.icon + ".jpg')");		
}

function showTalent(talent) {
	talent.iconEle.css('display', '');
	talent.hidden = false;
}

function hideTalent(talent) {
	talent.iconEle.css('display', 'none');
	talent.hidden = true;
}

// Parses a talent build string
function applyTalents(build) {
	
	resetAllTalents(); // Reset all the talents first

	// Don't do anything if the build string is blank
	if(!build) {
		checkAllTrees();
		return false;
	}

	// Pet Talents
	if(petMode)	{

		// Calculator: Enable Beast Mastery if '&bm' is present in the URL
		if(pageMode == 'calc') {
			if(location.search && location.search.indexOf('&bm') != -1) {
				toggleBeastMastery();
			}

		// Otherwise: Enable Beast Mastery as needed.
		} else {
			var nPts = 0;
			for(var x = 0; x < build.length; ++x) {
				nPts += parseInt(build.charAt(x)) | 0;
			}

			if(nPts > talentVars.basePts) {
				enableBeastMastery();
			} else {
				disableBeastMastery();
			}
		}
	}

	var treeNums = getVisibleTrees();
	var nPointsLeft = talentVars.maxPts;
	var ctr = 0;

	for(var i = 0; i < treeNums.length; ++i) {

		var treeNum = treeNums[i];
		var tree    = talentTrees[treeNum];

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum) {		
	
			var
				talent = tree.talents[talentNum];
				nPoints = parseInt(build.charAt(ctr)) | 0;			

			if(nPoints > 0) {

				if(nPoints > talent.maxPts)
					nPoints = talent.maxPts;
				if(nPoints > nPointsLeft)
					nPoints = nPointsLeft;

				talent.pts = nPoints;
				talent.ctr.text(talent.pts);

				if(talent.pts >= talent.maxPts) {
					talent.ele.addClass("talentMax");
				}
				
				nPointsLeft -= nPoints;

			} else {
				talent.pts = 0;
				talent.ctr.text('0');		
			}

			++ctr;
		}
	}

	checkAllTrees();
	
	return true;
}

function resetAllTalents(){	

	for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum) {
		resetTalents(treeNum, false);
	}

	checkAllTrees();
}

// Reset talent points back to zero
function resetTalents(treeNum, check) {

	var tree = talentTrees[treeNum];

	for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum) {
		var talent = tree.talents[talentNum];

		talent.pts = 0;
		talent.ctr.text('0');
		talent.ele.removeClass("talentMax");
		
		if(talent.tier > 0) {
			disableTalent(talent);
		} else {
			talent.iconEle.css("background-image", "url('" + ICON_PREFIX + talent.icon + ".jpg')");	
		}
		
		if(talent.requires){
			disableArrows(talent);
		}	
	}

	// We do not need to calculate tree points if we're resetting all the talents.
	if(check) {
		checkAllTrees();
	}
}

function getCurrentTalentBuild() {

	var build = '';
	var treeNums = getVisibleTrees();

	for(var i = 0; i < treeNums.length; ++i) {

		var treeNum = treeNums[i];
		var tree = talentTrees[treeNum];

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum)	{
			var	talent = tree.talents[talentNum];

			build += talent.pts;
		}
	}

	return build;
}

// Returns which trees are currently visible
function getVisibleTrees()
{
	var treeNums;
	var cache;

	if(!getVisibleTrees.cache) {
		getVisibleTrees.cache = [];
	}

	cache = getVisibleTrees.cache;
	
	// Pet Talent Calculator: only return the currently visible tree
	if(petMode) {

		if(cache.length) { // Use cache if available
			cache[0] = currentPetTree;
		}
		else {
			cache.push(currentPetTree);
		}

	// Talent Calculator: return all the trees
	} else {

		if(cache.length) { // Use cache if available
			;
		}
		else {
			for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum) {
				cache.push(treeNum);
			}
		}
	}
	
	return cache;
}

// Adds up the points in the tree and its tiers
function calcTreePts(){

	talentVars.pts = 0;

	for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum) {
		var tree = talentTrees[treeNum];

		tree.pts = 0;
		for(var tierNum = 0; tierNum < talentVars.maxTiers; ++tierNum) {
			tree.tierVals[tierNum] = 0;
		}

		for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum)	{
			var talent = tree.talents[talentNum];

			tree.pts += talent.pts;
			tree.tierVals[talent.tier] += talent.pts;
		}
		
		talentVars.pts += tree.pts;

		tree.ctr.text(tree.pts);		
	}

	// After running out of talent points, disable talents with no points in them
	if(talentVars.pts >= talentVars.maxPts) {
		for(var talId in talentLookup){

			var talent = talentLookup[talId];
			
			if(!talent.ele.hasClass("talentMax")) {
				if(talent.pts == 0) {
					disableTalent(talent);
					disableArrows(talent);
				}
			}
		}
	}

	updatePointsLeftDisplay();
}

function getRequiredLevel() {

	var reqLevel = 0;

	// Pet Mode
	if(petMode) {
		if(talentVars.pts > 0) {
			reqLevel = 20 + (talentVars.pts - talentVars.extraPts - 1) * 4;
		}

		// Minimum level requirement for Beast Mastery
		if(talentVars.extraPts > 0) {
			reqLevel = Math.max(reqLevel, talentVars.beastMasteryReqLevel);
		}

	// Normal
	} else {
		if(talentVars.pts > 0) {
			reqLevel = talentVars.pts + 9;
		}
	}

	return reqLevel;
}

function getPointsSpent() {

	var ptsSpent;

	// Pet Talent Calculator: total number of points spent
	if(petMode) {
		ptsSpent = talentVars.pts;

	// Talent Calculator: number of points spent per tree
	} else {
		ptsSpent = '';
		for(var treeNum = 0; treeNum < talentVars.maxTrees; ++treeNum)
		{
			if(treeNum > 0)
				ptsSpent += '/';

			ptsSpent += talentTrees[treeNum].pts;
		}
	}

	return ptsSpent;
}

// Updates UI to show what points are left, etc.
function updatePointsLeftDisplay() {

	if(pageMode == 'calc') {
		
		var ptsSpent = getPointsSpent();

		$(talentVars.pointsSpent).text(ptsSpent);
		$(talentVars.pointsLeft).text(talentVars.maxPts - talentVars.pts);

		var reqLevel = getRequiredLevel();	
		$(talentVars.reqLevel).text(reqLevel == 0 ? '-' : reqLevel);
	}

	var url;
	// Pet Talent Calculator
	if(petMode) {
		url = "talent-calc.php?pid=" + whichClass + "&tal=" + getCurrentTalentBuild();
		if(talentVars.extraPts > 0) {
			url += '&bm';
		}

	// Talent Calculator
	} else {
		url = "talent-calc.php?cid=" + whichClass + "&tal=" + getCurrentTalentBuild();
	}

	$(talentVars.talentPtsStr).attr('href', url);
}

// Prevents event from propagating
function blockEvent(event) {
	event = event || window.event;

	if(event.stopPropagation) event.stopPropagation();	
	event.cancelBubble = true;

	return false;
}

// Unhides the arrows in the specified talent tree
function showTreeArrows(treeNum) {
	
	var tree = talentTrees[treeNum];

	$.each(tree.reqArrows, function() {
		this.css('display', '');
	});
}

// Hides the arrows in the specified talent tree
function hideTreeArrows(treeNum) {
	
	var tree = talentTrees[treeNum];

	$.each(tree.reqArrows, function() {
		this.css('display', 'none');
	});
}

// Used in the Pet Talent Calculator
function changePetTree(treeNum, familyId, e)
{
	var changed = false;

	// Allows for calling the function with only a family ID
	if(!treeNum && familyId && petFamilies[familyId]) {
		treeNum = petFamilies[familyId].tree;		
	}

	// Tree change
	if(currentPetTree != treeNum) {
		changed = true;

		var previousPetTree = currentPetTree;
		currentPetTree = treeNum;
	
		// Talent tree
		if(previousPetTree != null)
			$('#' + getUniqueId(talentTrees[previousPetTree].id + '_treeContainer')).css('display', 'none');
		$('#' + getUniqueId(talentTrees[currentPetTree].id + '_treeContainer')).css('display', '');

		// Arrows
		drawRequiredArrows();
		if(previousPetTree != null)
			hideTreeArrows(previousPetTree);
		showTreeArrows(currentPetTree);

		if(pageMode == 'calc') {

			// Subtab
			if(previousPetTree != null)
				$('#' + talentTrees[previousPetTree].id + '_subTab').removeClass('selected-subTab');
			$('#' + talentTrees[currentPetTree].id + '_subTab').addClass('selected-subTab');

			// Pet family group
			$('#' + currentPetTree + '_group').parent().children().removeClass('selectedPetGroup');
			$('#' + currentPetTree + '_group').addClass('selectedPetGroup');

			if(!familyId) { // Chooses the first family in the group
				familyId = parseInt($('#' + treeNum + '_group .petFamily:first').attr('id'));
			}
		}
	}

	// Family change
	if(familyId > 0)
	{
		if(familyId != whichClass)
		{
			changed = true;

			whichClass = familyId; 
	
			// Pet Talent Calculator
			if(pageMode == 'calc') {

				// Highlight family icon
				$('#petFamilies .petFrameSelected').removeClass('petFrameSelected');
				$('#' + familyId + '_family .petFrame:first').addClass('petFrameSelected');

				// Update bottom section with family name and icon
				var name = petFamilies[whichClass].name;
				var maxLength = 9;

				if(name.length > (maxLength + 3)) {
					name = name.substr(0, maxLength) + '...';
				}

				talentTrees[currentPetTree].nameLbl.text(name);
				talentTrees[currentPetTree].iconDiv.css('background-image', 'url(' + ICON_TREE_PREFIX + petFamilies[whichClass].icon + '.png)');
			}
		}
	}

	if(changed)
	{
		resetAllTalents();
		validatePetTalents(); // Support for birds
	}

	if(e) blockEvent(e);
}

function validatePetTalents() {

	var	catId = petFamilies[whichClass].catId;
	var mask;

	if(catId < 32) {
		mask = '0';
	} else {
		catId -= 32;
		mask = '1';
	}

	for(var talentNum = 0, len = talentTrees[currentPetTree].talents.length; talentNum < len; ++talentNum) {

		var talent = talentTrees[currentPetTree].talents[talentNum];
		
		if(talent.categoryMask0 || talent.categoryMask1) {

			var valid = talent['categoryMask' + mask] & (1 << catId);

			if(!talent.hidden && !valid) {
				hideTalent(talent);
			} else if(talent.hidden && valid) {
				showTalent(talent);
			}
		}
	}
}

function enableBeastMastery() {
	talentVars.extraPts = talentVars.beastMasteryExtraPts;
	talentVars.maxPts   = talentVars.basePts + talentVars.extraPts;
}

function disableBeastMastery() {
	talentVars.extraPts = 0;
	talentVars.maxPts   = talentVars.basePts + talentVars.extraPts;
}

function toggleBeastMastery() {

	var ele = $('#beastMasteryToggler');

	// Disable BM
	if(talentVars.extraPts)
	{
		if(talentVars.pts > talentVars.basePts)
		{
			// TODO: Permit the operation by removing points from the end of the tree.
			return;
		}

		disableBeastMastery();
		
		ele.text('+' + talentVars.beastMasteryExtraPts);
		ele.removeClass('petBeastMastery-on');
	}

	// Enable BM
	else
	{
		enableBeastMastery();

		ele.text('-' + talentVars.beastMasteryExtraPts);
		ele.addClass('petBeastMastery-on');
	}

	displayBeastMasteryTooltip();
	checkAllTrees();
}

function displayBeastMasteryTooltip() {
	var tt = '';
	
	tt += '<b>' + textTalentBeastMasteryName + '</b><br />';
	tt += '<span style="color: #ffd200">' + textTalentBeastMasteryDesc + '</span>';

	setTipText(tt);
}

function displayPetFamilyTooltip(id) {
	setTipText(petFamilies[id].name);	
}

function showPrintableVersion() {

	var html = '';

	var className;
	if(petMode) {
		className = petFamilies[whichClass].name;
	} else {
		className = window['text' + whichClass + 'class'];
	}
	var reqLevel = getRequiredLevel();
	var title = sprintf(textPrintableClassTalents, className);
	
	html += '<html><head>';
	html += '<title>' + title + '</title>';
	html += '</head><body style="font-family: Verdana">';

	html += '<h3>' + title + '</h3>';
	html += sprintf(textPrintableMinReqLevel, reqLevel) + '<br />';
	html += sprintf(textPrintableReqTalentPts, talentVars.pts) + '<br /><br />';

	var treeNums = getVisibleTrees();
	for(var i = 0; i < treeNums.length; ++i) {

		var treeNum = treeNums[i];
		var tree    = talentTrees[treeNum];
	
		if(tree.pts > 0) {

			html += '<b><u>' + sprintf(textPrintableTreeTalents, tree.name) + '</u></b> - ';
			html += sprintf(textPrintablePtsPerTree, tree.pts) + '</h3>';
			html += '<ul>';

			for(var talentNum = 0, len = tree.talents.length; talentNum < len; ++talentNum) {		
			
				var talent = tree.talents[talentNum];
	
				if(talent.pts > 0) {
					html += '<li><b>' + talent.name + '</b> - ' + sprintf(textTalentRank, talent.pts, talent.maxPts) + '</li>';
				}
			}
			html += '</ul>';
		}
	}

	if(!talentVars.pts)
		html += textPrintableDontWastePaper;

	html += '</body></html>';
	
	var win;
	win = window.open('', '', 'menubar=yes,status=yes,scrollbars=yes,resizable=yes,toolbar=no'),
	win.document.open();
	win.document.write(html);
	win.document.close();

	if(talentVars.pts)
		win.print();
}

}