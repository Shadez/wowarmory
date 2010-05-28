function deleteNode(elementId){
  var label=document.getElementById(elementId);	
  while( label.hasChildNodes() ) { label.removeChild( label.lastChild ); }
}

function deleteChildren(label){
  while( label.hasChildNodes() ) { label.removeChild( label.lastChild ); }
}

function cloneDelete(theSource, theTarget) {
	
	if (Browser.safari) {
		theSourceId = document.getElementById(theSource);
		theClone = theSourceId.cloneNode(true);	
		theSourceId.parentNode.removeChild(theSourceId);
		document.getElementById(theTarget).appendChild(theClone);
	} else {
		if(document.getElementById(theSource)){
		document.getElementById(theTarget).appendChild(document.getElementById(theSource));
	}
	}
}

function createOption(whichNode, theValue, theDisplay) {
	theOption=document.createElement("OPTION");
	theOption.value = theValue;
	theOption.innerHTML = theDisplay;
	eval(whichNode).appendChild(theOption);	
}

function createOptions(whichSelect, whichNode, theArray) {

	var taLength = theArray.length;
	for (i=0; i < taLength; i++) {
		createOption(whichSelect, theArray[i][0], theArray[i][1]);
	}
	document.getElementById(whichNode).appendChild(eval(whichSelect));
}

function childrenToPhantom(elementId){
  var label=document.getElementById(elementId);	
  while( label.hasChildNodes() ) {
	  document.getElementById('formPhantom').appendChild( label.lastChild ); 
  }	
}

function deleteAllButOne(elementId){
  var label = document.getElementById(elementId);
  while( label.childNodes.length > 1 ) {
	label.removeChild(label.lastChild);
	
  }	
}

function setOr(){
	document.formItem.andor[1].checked = 1;
}

function setAnd(){
	document.formItem.andor[0].checked = 1;	
}

function getNodeElement(theParentNode, whichNode){
	
	//this function gets the X number child node and ignores and text
	//X is defined by whichNode
	//this function was created because Safari treats blank text as a child node
	
	var theOperElement = theParentNode;
	var theOperElementNodeNumber;
	var counter;

	var wnLength = whichNode.length;
	for (x = 0; x < wnLength; x++) {
		theOperElement = theOperElement.firstChild;
		theOperElementNodeNumber = whichNode[x];
		counter = 1;
		while (counter < theOperElementNodeNumber || theOperElement.nodeName == "#text") {
			if (theOperElement.nodeName != "#text"){
				counter++;
			}
			theOperElement = theOperElement.nextSibling;
		}
	}
	
	return theOperElement;
	
}

function addAdvOpt(whichPredefined, whichOper, theValueArray){
	var theElement = document.getElementsByName('advOptions'+ currentAdvOpt +'Remove')[0];
	theElement.style.display = "block";

	elementsArray = document.getElementsByName('optionAdvOptions'+currentAdvOpt);

	theClone = document.getElementsByName('optionAdvOptions'+currentAdvOpt)[elementsArray.length-1].cloneNode(true);
	/*
	var theCompareDiv = getNodeElement(theClone, [2, 1]);
	
	if (whichOper == "compare")
		theCompareDiv.style.display = "block";
	else
		theCompareDiv.style.display = "none";	
*/

	var idWrapperOptions = document.getElementById('wrapperOptions'+ currentAdvOpt);
	idWrapperOptions.appendChild(theClone);

	if (whichPredefined)
		setPredefinedOption(whichPredefined, whichOper, theValueArray);
	else {
		//getNodeElement(theClone, [2, 1, 2]).value = 0;
		//theClone.lastChild.previousSibling.lastChild.value = 0; //set the compare value to zero
	}


	var wrapperOptionsKids = getNumberOfChildDivs(idWrapperOptions);

	if (wrapperOptionsKids >= 2) {
		document.getElementById('idAndOr').style.display = "block";		

		if (wrapperOptionsKids >= 6)
			document.getElementById('idAddFilter'+currentAdvOpt).style.display = "none";
	}
		

}

function changeAdvOptionsExtra(whichOne, theKey){
	
	if (theKey == "add") {
		elementCompare = document.getElementsByName('advOptWrapper'+currentAdvOpt)[theCounter];
	} else {
		elementCompare = getNodeElement(theKey, [2]);

	}

	deleteChildren(elementCompare);				

	if (whichOne != "key") {
		elementsArray = document.getElementsByName('wrapper'+ whichOne+currentAdvOpt);
		theClone = elementsArray[elementsArray.length-1].cloneNode(true);
		elementCompare.appendChild(theClone);
	}
}

function getNumberOfChildDivs(theElement){
	var numberOfDivs = 0;
	var theElementChild = theElement.firstChild;
	var tcLength = theElement.childNodes.length;
	for (x = 0; x < tcLength; x++) {
		if (theElementChild.nodeName == "DIV")
			numberOfDivs++
		theElementChild = theElementChild.nextSibling;
	}
	
	return numberOfDivs;
	
}

function getFormElements(theElement){
	//takes a parent node and returns an array of formelement child nodes
	var theArray = new Array;
	var theElementChild = theElement.firstChild;
	var tcLength = theElement.childNodes.length;
	for (x = 0; x < tcLength; x++) {
		if (theElementChild.nodeName == "INPUT" || theElementChild.nodeName == "SELECT")
			theArray.push(theElementChild);
		theElementChild = theElementChild.nextSibling;
	}
	
	return theArray;
	
}

function deleteRest() {
	var theElement = document.getElementById('wrapperOptions'+currentAdvOpt);
	
	var numberOfDivs = getNumberOfChildDivs(theElement);
	
	while (numberOfDivs > theCounter) {
		if (theElement.lastChild.nodeName == "DIV")
			numberOfDivs--;
		theElement.removeChild(theElement.lastChild);
	}
	
	if (theCounter < 6)
		document.getElementById('idAddFilter'+currentAdvOpt).style.display = "block";		
	
	theCounter = 0;
	

	
}

function setPredefinedOption(whichPredefined, theOper, theValueArray){
	if (theOper == "compare") {
		
		if (theValueArray) {
			theValue = theValueArray[2];			
			if (theValueArray[1] == "gt")
				theOperValue = 0;
			else if (theValueArray[1] == "gteq")
				theOperValue = 1;
			else if (theValueArray[1] == "eq")
				theOperValue = 2;				
			else if (theValueArray[1] == "lt")
				theOperValue = 3;				
			else if (theValueArray[1] == "lteq")
				theOperValue = 4;	
		} else {
			theValue = 0;
			theOperValue = 0;
		}		
		document.getElementsByName('advOptions'+ currentAdvOpt + whichPredefined)[theCounter].selected = 1;	
		document.getElementsByName('advOptOper')[theCounter].selectedIndex = theOperValue; //set the compare operator to greater than
		document.getElementsByName('advOptValue')[theCounter].value = theValue; //set the compare value to zero

	} else if (theOper == "spelleffect") {
		if (theValueArray) {
			theValue = theValueArray[2];
			if (theValueArray[1] == "resist")
				theOperValue = 0;
			else if (theValueArray[1] == "interrupt")
				theOperValue = 1;
			else if (theValueArray[1] == "proc")
				theOperValue = 2;								
			else if (theValueArray[1] == "dispel")
				theOperValue = 3;				
			else if (theValueArray[1] == "cooldown")
				theOperValue = 4;				
			else if (theValueArray[1] == "casttime")
				theOperValue = 5;	
			else if (theValueArray[1] == "spellcost")
				theOperValue = 6;					
			else if (theValueArray[1] == "duration")
				theOperValue = 7;					
			else if (theValueArray[1] == "range")
				theOperValue = 8;				
			else if (theValueArray[1] == "threat")
				theOperValue = 9;					
			else if (theValueArray[1] == "group")
				theOperValue = 10;					
			else if (theValueArray[1] == "summon")
				theOperValue = 11;	
		} else {
			theValue = 0;
		}		
		document.getElementsByName('advOptions'+ currentAdvOpt + whichPredefined)[theCounter].selected = 1;	
		document.getElementsByName('advOptOper')[theCounter].selectedIndex = theOperValue; //set the compare operator to greater than		
	}
	
}


function addPredefinedAdvOpt(whichPredefined, theValueArray){
	
	
	whichOper = document.getElementById('advOptions'+ currentAdvOpt + whichPredefined).className;

	if (getNumberOfChildDivs(document.getElementById('wrapperOptions'+currentAdvOpt)) <= theCounter) {
		addAdvOpt(whichPredefined, whichOper, theValueArray);
	}

	changeAdvOptionsExtra(whichOper, "add");
	
	setPredefinedOption(whichPredefined, whichOper, theValueArray);

	if (theCounter == 0) {
		setFirstClearRemove();		
	}
	
	 theCounter++;

}

function resetForms() {	
	document.formItem.reset();
	document.getElementById('idAndOr').style.display = "none";		
	deleteRest();		
	addPredefinedAdvOpt('none');		
	changedungeon('all');
	changesource('all');
	changetype('all');
	setAnd();	
	theCounter = 0;
}

function hideAdvOptWrapperChildren(theException){
		var theNode = document.getElementsByName('advOptWrapper'+currentAdvOpt)[0];
		var theNodeLength = theNode.childNodes.length;
		var theNode = theNode.firstChild;
		for (x=0; x < theNodeLength; x++) {
			if (theNode.nodeName == "DIV") {
				theNode.style.display = "none";
				if (x == theException)
					theNode.style.display = "block";				
			}
			theNode = theNode.nextSibling;
		}			
}

function removeAdvOpt(whichNode){

	var elementsFirst = document.getElementsByName('advOptions'+ currentAdvOpt +'Remove');
	if (elementsFirst.length == 2) { //clear instead of remove

		//document.getElementById('selectAdvOptions'+currentAdvOpt).selectedIndex = 0;
		document.getElementsByName('advOptName')[0].selectedIndex = 0;
		elementsFirst[0].style.display = "none";
		
		//hide the children
		hideAdvOptWrapperChildren();

	} else {
		whichNode.parentNode.parentNode.removeChild(whichNode.parentNode);
		setFirstClearRemove();
	}

	var numberOfDivs = getNumberOfChildDivs(document.getElementById('wrapperOptions'+currentAdvOpt));

	if (numberOfDivs < 6) {
		document.getElementById('idAddFilter'+currentAdvOpt).style.display = "block";

		if (numberOfDivs < 2)	
			document.getElementById('idAndOr').style.display = "none";
	}

}

function setFirstClearRemove(){

	var elements = document.getElementsByName('advOptions'+ currentAdvOpt +'Remove');
	if (elements.length == 2){
		if (document.getElementsByName('advOptName')[0].selectedIndex != 0) {	
			elements[0].style.display = "block";			
		} else {
			elements[0].style.display = "none";
		}
	}
}


function changeAdvOptions(theParentNode, theValue){
	
	whichOne = document.getElementById('advOptions'+ currentAdvOpt + theValue).className;

	/*
	whichOne = "compare";
	if (theValue == "bindsPickedUp" || theValue == "bindsEquip" || theValue == "bindsWhenUsed" || theValue == "none" || theValue == "unique" || theValue == "uniqueEquipped")
		whichOne = "key";
	else if (theValue == "requiresProfession")
		whichOne = "profession";
*/
	changeAdvOptionsExtra(whichOne, theParentNode);

	//var elements = document.getElementsByName('advOptions'+ currentAdvOpt +'Remove');

	setFirstClearRemove();
}

function changeusbleBy(whichClass){
	
	childrenToPhantom('parentPredefinedFilter');
	childrenToPhantom('parentUsableBySpecific');	

	if (whichClass == 11) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedDruid'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByDruid'));		
	} else if (whichClass == 3) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedHunter'));
	} else if (whichClass == 8) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedMage'));
	} else if (whichClass == 2) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedPaladin'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByPaladin'));				
	} else if (whichClass == 5) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedPriest'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByPriest'));					
	} else if (whichClass == 4) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedRogue'));
	} else if (whichClass == 7) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedShaman'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByShaman'));				
	} else if (whichClass == 9) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedWarlock'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByWarlock'));		
	} else if (whichClass == 1) {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedWarrior'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByWarrior'));				
	}else if (whichClass == 6) {
		//document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedDeathKnight'));
		document.getElementById('parentUsableBySpecific').appendChild(document.getElementById('childUsableByDeathKnight'));				
	} else {
		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('childPredefinedGeneric'));
//		document.getElementById('parentPredefinedFilter').appendChild(document.getElementById('hiddenPredefinedGeneric'));		
	}

}



function toggleItemFilter() {
	var theElement = document.getElementById('showHideItemFilters');
	//document.getElementById('showHideItemsTooMany').style.display = "none";

	if (theElement.style.display == "none") {
		
		document.getElementById('replaceShowFilters1').innerHTML = textHideItemFilters;
		document.getElementById('replaceShowFilters2').innerHTML = textHideItemFilters;		
		
		theElement.style.display = "block";
	} else {		
		document.getElementById('replaceShowFilters1').innerHTML = textShowItemFilters;		
		document.getElementById('replaceShowFilters2').innerHTML = textShowItemFilters;		
		
		theElement.style.display = "none";
	}
}



function toggleAllComplex(theInput){
	var theElement = document.getElementById('showHideAllComplex');
	if (theElement.style.display == "none" || theInput == 1) {
		document.getElementById('replaceAllComplex').innerHTML = textHideAdvancedOptions;
		theElement.style.display = "block"
	} else {
		document.getElementById('replaceAllComplex').innerHTML = textShowAdvancedOptions;		
		theElement.style.display = "none"	
	}
}

  function changedungeon(whichSelected) {
    childrenToPhantom('dungeonParentBosses');
    childrenToPhantom('dungeonParentHeroic');	
    if (whichSelected != "badgeofjustice" && whichSelected != "all" && whichSelected != "dungeons" && whichSelected != "raids") {
		cloneDelete('child'+whichSelected, 'dungeonParentBosses');
//	  document.getElementById('dungeonParentBosses').appendChild(document.getElementById('child'+whichSelected));		
	}

	
	//check for heroic mode
	var hasHeroicMode = document.getElementById("dungeon"+whichSelected);
	if(hasHeroicMode) { //check to see if this element exists
	  if(hasHeroicMode.className == "fake1") { //if it exists, see it's classname to see if it has a heroic mode (fake1 = has heroic mode)
		cloneDelete('childHeroic', 'dungeonParentHeroic');
	  }
	}
	
	if (whichSelected == "dungeons") {
		cloneDelete('childHeroic', 'dungeonParentHeroic');		
	}
	//end check for heroic mode

  }


  function changetype(whichSelected){
	try{  
	    document.getElementById('showHideError').style.display = "none";
	} catch(e) {
		return;
	}
	currentAdvOpt = "";

	childrenToPhantom('parentSingle');
	document.getElementById('formPhantom').appendChild(document.getElementById('childAdvancedOptions'));	
	childrenToPhantom('parentMultiple');

	cloneDelete('childRarity', 'formPhantom');
	
	document.getElementById('parentUsableBySpecific').style.marginTop = "0px";

    if (whichSelected == "weapons") {
		cloneDelete('divMultiple', 'parentMultiple');
		cloneDelete('childWeapons', 'parentMultiple');
		cloneDelete('childRarity', 'weaponParentRarity');
		document.getElementById('childRarityClass').className = "sub-label";

		cloneDelete('childRequiredLevel', 'weaponParentRequiredLevel');
		
		cloneDelete('childUsableBy', 'weaponParentUsableBy');		
		document.getElementById('weaponParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));		

		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";					

	} else if (whichSelected == "armor") {
		cloneDelete('divMultiple', 'parentMultiple');		
		cloneDelete('childArmor', 'parentMultiple');
		cloneDelete('childSlot', 'armorParentSlot');
		cloneDelete('childRarity', 'armorParentRarity');		
		document.getElementById('childRarityClass').className = "sub-label";		

		cloneDelete('childRequiredLevel', 'armorParentRequiredLevel');
		
		cloneDelete('childUsableBy', 'armorParentUsableBy');		
		document.getElementById('armorParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));		

		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";					

	} else if (whichSelected == "containers") {
		cloneDelete('childContainers', 'parentSingle');		
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";
	} else if (whichSelected == "projectiles") {
		cloneDelete('childProjectiles', 'parentSingle');		
	} else if (whichSelected == "quivers") {
		cloneDelete('childQuivers', 'parentSingle');		
	} else if (whichSelected == "gems"){
		cloneDelete('divMultiple', 'parentMultiple');		
		
		cloneDelete('childGems', 'parentMultiple');		
		
		cloneDelete('childUsableBy', 'gemParentUsableBy');		


		document.getElementById('gemParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));		

		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";					

	} else if (whichSelected == "recipes") {
		cloneDelete('childRecipes', 'parentSingle');		
	} else if (whichSelected == "consumables") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";		
	} else if (whichSelected == "mounts") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";
 	} else if (whichSelected == "smallpets") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";						
	} else if (whichSelected == "reagents") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";				
	} else if (whichSelected == "misc") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";				
	} else if (whichSelected == "tradegoods") {
		cloneDelete('childRarity', 'parentSingle');		
		document.getElementById('childRarityClass').className = "sub-label-top";				
	} else if (whichSelected == "enchP") {
		cloneDelete('divMultiple', 'parentMultiple');		

		cloneDelete('childEnchP', 'parentMultiple');
		
		cloneDelete('childSlotEnchP', 'enchPParentSlot');		

		document.getElementById('enchPParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));				

		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";		
		
	} else if (whichSelected == "enchT") {
		cloneDelete('divMultiple', 'parentMultiple');

		cloneDelete('childEnchT', 'parentMultiple');		
		
		cloneDelete('childSlotEnchT', 'enchTParentSlot');		

		document.getElementById('enchTParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));				
		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";		
	} else if (whichSelected == "all") {
		cloneDelete('divMultiple', 'parentMultiple');		
		
		cloneDelete('childAllComplex', 'parentMultiple');		

		cloneDelete('childRarity', 'allComplexParentRarity');
		document.getElementById('childRarityClass').className = "sub-label";				

		cloneDelete('childRequiredLevel', 'allComplexParentRequiredLevel');
		
		cloneDelete('childUsableBy', 'allComplexParentUsableBy');		


		document.getElementById('allComplexParentAdvancedOptions').appendChild(document.getElementById('childAdvancedOptions'));		
		currentAdvOpt = "Weapon";

		if (document.getElementById('wrapperOptions'+currentAdvOpt).childNodes.length < 2)	
			document.getElementById('idAndOr').style.display = "none";
		else
			document.getElementById('idAndOr').style.display = "block";					
	}else if (whichSelected == "glyphs") {	
		cloneDelete('childUsableBy', 'parentSingle');

		document.getElementById('parentUsableBySpecific').style.float = "right";
		
		if($.browser.msie)
			document.getElementById('parentUsableBySpecific').style.marginTop = "21px";
		else	
			document.getElementById('parentUsableBySpecific').style.marginTop = "19px";

		
	} 

	if (currentAdvOpt != "")
		setFirstClearRemove();
	
  }
  
  function changesource(whichForm) {
    document.getElementById('showHideError').style.display = "none";	  
    childrenToPhantom('parentSourceSub1');

	  document.getElementById('childRequiredLevel').style.display = "block";

    if (whichForm == "dungeon") {
		cloneDelete('childDungeon', 'parentSourceSub1');		
	} else if (whichForm == "reputation") {
		cloneDelete('childReputationRewards', 'parentSourceSub1');		
	} else if (whichForm == "pvpAlliance") {
		cloneDelete('childPvPalliance', 'parentSourceSub1');		
	} else if (whichForm == "pvpHorde") {
		cloneDelete('childPvPhorde', 'parentSourceSub1');		
	} else if (whichForm == "quest") {
	  document.getElementById('childRequiredLevel').style.display = "none";
	  document.getElementById('rqrMin').value = "";	  
	  document.getElementById('rqrMax').value = "";	  	  
	  
	}
	
	theCurrentForm = whichForm;
	

  }

  function submitForm(){
	
	hasProblem = 0;



	if (document.formItem.searchQuery.value == "") {
	    childrenToPhantom('divSearchQuery');
	}
	
	if (document.formItem.rqrMin && document.formItem.rqrMax) {
		if (document.formItem.rqrMin.value > document.formItem.rqrMax.value && document.formItem.rqrMax.value != "") {
	    document.getElementById('showHideError').style.display = "block";
		document.getElementById('replaceError').innerHTML = textErrorLevel;
		document.getElementsByName('divErrorLevel')[0].className = "filterError";						
		
			hasProblem = 1;
		}
	}

	if (document.formItem.minSkill && document.formItem.maxSkill) {
		if (document.formItem.minSkill.value > document.formItem.maxSkill.value && document.formItem.maxSkill.value != "") {
	    document.getElementById('showHideError').style.display = "block";
		document.getElementById('replaceError').innerHTML = textErrorSkill;
		document.getElementsByName('divErrorLevel')[0].className = "filterError";						
		
			hasProblem = 1;
		}
	}

	if(!hasProblem) {
		
	  if (currentAdvOpt != "") {//if the form has advanced options
		  elementsArray = document.getElementsByName('optionAdvOptions'+currentAdvOpt);
		  wrapperArray = document.getElementsByName('advOptWrapper'+currentAdvOpt);
		  advOptCount = elementsArray.length - 1;
		  for (i = 0; i < advOptCount; i++) {
			theSelect = getFormElements(elementsArray[i]);
			hiddenElement=document.createElement("input");
			hiddenElement.setAttribute("type", "hidden");
			hiddenElement.setAttribute("name", "fl[advOpt]");			
			hiddenElement.value = theSelect[0].value;
			if (wrapperArray[i].childNodes.length > 0) {
				theExtra = getFormElements(wrapperArray[i].firstChild);
				var teLength = theExtra.length;
				for (x = 0; x < teLength; x++) {
					hiddenElement.value += "_"+ theExtra[x].value;
				}
			}			
			document.getElementById('formItem').appendChild(hiddenElement);
			
			//childrenToPhantom('wrapperOptions'+currentAdvOpt);
			
		  }
	  }
		
	  document.formItem.submit();
	}
  }
  



function roleTank() {
	addPredefinedAdvOpt('defenseRating');
	addPredefinedAdvOpt('dodgeRating');
	addPredefinedAdvOpt('parryRating');	
	deleteRest();
	setOr();	
}

function roleMeleeDps() {
	addPredefinedAdvOpt('critRating');	
	addPredefinedAdvOpt('attackPower');
	deleteRest();	
	setOr();
}

function roleCasterDps() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	deleteRest();	
	setOr();
}

function roleHealer() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellManaRegen');
	deleteRest();	
	setOr();
}




function roleMeleeDpsPvP() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');	
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();
}

function roleCasterDpsPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('critRating');	
	addPredefinedAdvOpt('resilience');
	deleteRest();		
	setOr();
}

function roleHealerPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();
}




//Druid Begin
function roleTankDruid() {
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('defenseRating');
	addPredefinedAdvOpt('dodgeRating');	
	deleteRest();	
	setOr();
}

function roleMeleeDpsDruid() {
	addPredefinedAdvOpt('strength');
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();	
	setOr();	
}

function roleCasterDpsDruid() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('critRating');	
	deleteRest();	
	setOr();
}

function roleHealerDruid() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellManaRegen');
	deleteRest();	
	setOr();
}



function roleMeleeDpsDruidPvP() {
	addPredefinedAdvOpt('strength');
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();	
}

function roleCasterDpsDruidPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('critRating');	
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();
}

function roleHealerDruidPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();
}


//Hunter Begin
function roleRangedDpsHunter() {
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();		
	setOr();
}



function roleRangedDpsHunterPvP() {
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();		
	setOr();
}



//Mage
function roleCasterDpsMage() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellPowerArcane');
	addPredefinedAdvOpt('spellPowerFire');
	addPredefinedAdvOpt('spellPowerFrost');
	deleteRest();	
	setOr();	
}



function roleCasterDpsMagePvP() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();	
}




function roleTankPaladin() {
	addPredefinedAdvOpt('defenseRating');
	addPredefinedAdvOpt('blockRating');
	addPredefinedAdvOpt('dodgeRating');
	addPredefinedAdvOpt('parryRating');
	addPredefinedAdvOpt('spellPower');
	deleteRest();			
	setOr();	
}

function roleMeleeDpsPaladin() {
	addPredefinedAdvOpt('strength');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();			
	setOr();		
}

function roleCasterDpsPaladin() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellPowerHoly');
	deleteRest();			
	setOr();		
}

function roleHealerPaladin() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	deleteRest();			
	setOr();		
}




function roleMeleeDpsPaladinPvP() {
	addPredefinedAdvOpt('strength');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();		
}

function roleCasterDpsPaladinPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();		
}

function roleHealerPaladinPvP() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();		
}



function roleCasterDpsPriest() {
	addPredefinedAdvOpt('critRating');	
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellPowerShadow');
	deleteRest();			
	setOr();		
}

function roleHealerPriest() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellManaRegen');
	deleteRest();			
	setOr();	
}









function roleCasterDpsPriestPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();		
}

function roleHealerPriestPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();	
}


function roleMeleeDpsRogue() {;
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();			
	setOr();		
}








function roleMeleeDpsRoguePvP() {
	addPredefinedAdvOpt('agility');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();			
	setOr();		
}






function roleMeleeDpsShaman() {
	addPredefinedAdvOpt('strength');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();
	setOr();	
}

function roleCasterDpsShaman() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellPowerNature');
	deleteRest();	
	setOr();		
}

function roleHealerShaman() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellManaRegen');
	deleteRest();	
	setOr();		
}







function roleMeleeDpsShamanPvP() {
	addPredefinedAdvOpt('strength');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');	
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();	
}

function roleCasterDpsShamanPvP() {
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();		
}

function roleHealerShamanPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();		
}






function roleCasterDpsWarlock() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('spellPowerFire');
	addPredefinedAdvOpt('spellPowerShadow');
	deleteRest();	
	setOr();		
}







function roleCasterDpsWarlockPvP() {
	addPredefinedAdvOpt('spellPower');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();		
}


function roleTankWarrior() {
	addPredefinedAdvOpt('blockRating');
	addPredefinedAdvOpt('defenseRating');
	addPredefinedAdvOpt('dodgeRating');
	addPredefinedAdvOpt('parryRating');
	deleteRest();	
	setOr();		
}

function roleMeleeDpsWarrior() {
	addPredefinedAdvOpt('strength');
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('attackPower');
	deleteRest();	
	setOr();		
}


function roleMeleeDpsWarriorPvP() {
	addPredefinedAdvOpt('strength');	
	addPredefinedAdvOpt('critRating');
	addPredefinedAdvOpt('resilience');
	deleteRest();	
	setOr();		
}





jsLoaded=true;//needed for ajax script loading