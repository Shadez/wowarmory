
var theMouseLevel = levelMax;
	function showTheLevel(whichLevel) {
		
		
		theMouseLevel = whichLevel;
		
		document.getElementById('printNum80').innerHTML = levelArray[theMouseLevel][0];
		document.getElementById('printPercent80').innerHTML = levelArray[theMouseLevel][1];		
		document.getElementById('replaceLevelNum').innerHTML = whichLevel;		
		document.getElementById('replaceLevelPercent').innerHTML = whichLevel;				

	}
	
	function changeStatsWrapper(){
		changeStats(raceSelected, classSelected, document.guildStats.inputMinLevel.value, document.guildStats.inputMaxLevel.value, genderSelected, completeArray);
		document.getElementById('printNum80').innerHTML = levelArray[theMouseLevel][0];
		document.getElementById('printPercent80').innerHTML = levelArray[theMouseLevel][1];

	}

	function emptyArray0(theArray, theLength) {
		for (var i=0; i < theLength; i++) {
			theArray[i] = [0, 0];
		}
	}

	function emptyArray(theArray, theLength) {
		for (var i=1; i <= theLength; i++) {
			theArray[i] = [0, 0];
		}
	}
	
	function setArrays(filteredArray){
		totalMembers = filteredArray.length;

		emptyArray0(genderArray, genderStringArray.length);
		emptyArray(raceArray, raceMax);
		emptyArray(classArray, classMax);	
		emptyArray(levelArray, levelMax);
	
		var faLength = filteredArray.length;
		for (var a = 0; a < faLength; a++) {
			theRace = filteredArray[a][0];
			theClass = filteredArray[a][1];	
			theLevel = filteredArray[a][2];
			theGender = filteredArray[a][3];
	
		if (theLevel >= levelMin) {
				if (!raceArray[theRace])
					raceArray[theRace] = [1, 0];
				else
					raceArray[theRace][0]++;
		
				if (!classArray[theClass])
					classArray[theClass] = [1, 0];
				else
					classArray[theClass][0]++;
		
				if (!levelArray[theLevel])
					levelArray[theLevel] = [1, 0];
				else
					levelArray[theLevel][0]++;
		
				if (!genderArray[theGender])
					genderArray[theGender] = [1, 0];
				else
					genderArray[theGender][0]++;
			}
		}

	}

	function getFilteredArray(raceFilter, classFilter, minLevel, maxLevel, genderFilter, theArray){

		var theNewArray = theArray.slice();
		var x = 0;
		if (raceFilter != -1) {
			theLoop = theNewArray.length;		
			for (var c = 0; c < theLoop; c++){
				if (theNewArray[x][0] != raceFilter) {
					theNewArray.splice(x, 1);
					x--;
				}
				x++;
			}
		}
		x=0;
		if (classFilter != -1) {
			theLoop = theNewArray.length;
			for (var c = 0; c < theLoop; c++){
				if (theNewArray[x][1] != classFilter) {
					theNewArray.splice(x, 1);
					x--;
				}
				x++;
			}
		}
		x=0;
		
		if (genderFilter != -1) {
			theLoop = theNewArray.length;
			for (var c = 0; c < theLoop; c++){
				if (theNewArray[x][3] != genderFilter) {
					theNewArray.splice(x, 1);
					x--;
				}
				x++;
			}
		}
		x=0;		
		
		if (minLevel != -1 || maxLevel !=-1) {
			if (maxLevel == -1 || !maxLevel)
				maxLevel = levelMax;
			theLoop = theNewArray.length;				
			for (var c = 0; c < theLoop; c++){
				thisLevel = theNewArray[x][2];
				if (thisLevel < minLevel || thisLevel > maxLevel) {
					theNewArray.splice(x, 1);
					x--;
				}
				x++;
			}
		}

		return theNewArray;
	}


	function changeMinLevel() {

		var theInput = document.guildStats.inputMinLevel.value;
		
		minLvlSelected = theInput;

		if (theInput < levelMin || theInput < 10 || theInput > document.guildStats.inputMaxLevel.value || theInput > levelMax){
		} else {
			changeStatsWrapper();
		}
		
		if (theInput.length == 2)
			document.guildStats.inputMinLevel.select();
		
	}

	function changeMaxLevel() {
		var theInput = document.guildStats.inputMaxLevel.value;	
	
		maxLvlSelected = theInput;
	
		if (!theInput || theInput < 10 || theInput < document.guildStats.inputMinLevel.value || theInput > levelMax) {
		} else {
			changeStatsWrapper();
			document.guildStats.inputMaxLevel.select();			
		}
		
		if (theInput.length == 2)
			document.guildStats.inputMaxLevel.select();		
		
	}
	
	function changeStats(changeRace, changeClass, changeMinLevel, changeMaxLevel, changeGender, theArray, fromSelect){

		raceSelected = changeRace;
		classSelected = changeClass;
		genderSelected = changeGender;
		document.guildStats.inputMinLevel.value = changeMinLevel;
		document.guildStats.inputMaxLevel.value = changeMaxLevel;		

		if (changeRace != -1) {
			if (fromSelect != 1)
				document.guildStats.optionRace.selectedIndex = changeRace + 1;
			changeRace = thisRaceArray[changeRace][1];
		} else if (changeRace == -1 && fromSelect == 1)
			document.guildStats.optionRace.selectedIndex = 0;		
		
		if (changeClass != -1) {
			if (fromSelect != 1)
				document.guildStats.optionClass.selectedIndex = changeClass + 1;
			changeClass = classStringArray[changeClass][1];
		} else if (changeClass == -1 && fromSelect == 1)
			document.guildStats.optionClass.selectedIndex = 0;		

		if (changeGender != -1) {
			if (fromSelect != 1)
				document.guildStats.optionGender.selectedIndex = changeGender + 1;
		} else
				document.guildStats.optionGender.selectedIndex = 0;

		setArrays(getFilteredArray(changeRace, changeClass, changeMinLevel, changeMaxLevel, changeGender, theArray));

		for (var i = 0; i < 2; i++) {
			genderNum = genderArray[i][0];
			document.getElementById("genderNumber"+ i).innerHTML = genderNum;
			if (!genderNum)
				genderArray[i][1] = 0;
			else
				genderArray[i][1] = Math.round(genderNum/totalMembers * 100);
			document.getElementById("genderPercentage"+ i).innerHTML = genderArray[i][1];
		}

			percentageLargest = 0;

		var csaLength = classStringArray.length;
		for (var v = 0; v < csaLength; v++) {
			theClassId = classStringArray[v][1];
			classNum = classArray[theClassId][0];

			document.getElementById("classNumber"+ v).innerHTML = classNum;

			if (!classNum)
				classArray[theClassId][1] = 0;
			else
				classArray[theClassId][1] = Math.round(classNum/totalMembers * 100);

			if (percentageLargest < classArray[theClassId][1])
				percentageLargest = classArray[theClassId][1];

			document.getElementById("classPercentage"+ v).innerHTML = classArray[theClassId][1];

			if (changeClass != -1 && theClassId != changeClass)
				document.getElementById("classIcon"+ v).className = "classicon icon-"+ theClassId + "-0";
			else
				document.getElementById("classIcon"+ v).className = "classicon icon-"+ theClassId;

		}

		
		for (var v = 0; v < csaLength; v++) {

			thisClassId = classStringArray[v][1];
		
			if (percentageLargest == 0)
				setHeight = 0;
			else
				setHeight = Math.round((50 * classArray[thisClassId][1])/percentageLargest);
			

			document.getElementById("classBarStyle"+ v).style.height = setHeight + "px";
		
		}

			percentageLargest = 0;

		//change Race Numbers and Percentages and Gender Icons
		var raLength = thisRaceArray.length;
		for (var i = 0; i < raLength; i++) {

		
			thisRaceId = thisRaceArray[i][1];
			if (!raceArray[thisRaceId][0])
				raceArray[thisRaceId][0] = 0;
			document.getElementById("raceNumber"+ i).innerHTML =  raceArray[thisRaceId][0];

			if (totalMembers == 0)
				raceArray[thisRaceId][1] = 0;
			else
				raceArray[thisRaceId][1] = Math.round(raceArray[thisRaceId][0]/totalMembers*100);
				
			if (percentageLargest < raceArray[thisRaceId][1])
				percentageLargest = raceArray[thisRaceId][1];
			document.getElementById("racePercentage"+ i).innerHTML =  raceArray[thisRaceId][1];

			//change race pictures
			if (changeRace != -1 && thisRaceId != changeRace) {
				document.getElementById("raceShield"+ i).className = "raceicon shield-"+ thisRaceId + "-0";
				document.getElementById("raceIconMale"+ i).src = "images/icons/race/"+ thisRaceId +"-0-0.gif";
				document.getElementById("raceIconFemale"+ i).src = "images/icons/race/"+ thisRaceId +"-1-0.gif";
			} else {
				document.getElementById("raceShield"+ i).className = "raceicon shield-"+ thisRaceId;
				if (changeGender == 0 || changeGender == -1)
					document.getElementById("raceIconMale"+ i).src = "images/icons/race/"+ thisRaceId +"-0.gif";
				else
					document.getElementById("raceIconMale"+ i).src = "images/icons/race/"+ thisRaceId +"-0-0.gif";					
				if (changeGender == 1 || changeGender == -1)
					document.getElementById("raceIconFemale"+ i).src = "images/icons/race/"+ thisRaceId +"-1.gif";
				else
					document.getElementById("raceIconFemale"+ i).src = "images/icons/race/"+ thisRaceId +"-1-0.gif";					
			}




		}	

		//change Race Bars
		for (var i = 0; i < raLength; i++) {
			thisRaceId = thisRaceArray[i][1];
			
			if (percentageLargest == 0)
				setHeight = 0;
			else
				setHeight = Math.round((50 * raceArray[thisRaceId][1])/percentageLargest);
			
			document.getElementById("raceBar"+ i).style.height = setHeight + "px";
		}	


		percentageLargest = 0;

		for (var i = levelMin; i <= levelMax; i++) {
			levelNum = levelArray[i][0];
			if (!levelNum)
				levelArray[i][0] = 0;
//			document.getElementById("levelNumber"+ i).innerHTML =  levelArray[i][0];

			if (totalMembers == 0)
				levelArray[i][1] = 0;
			else
				levelArray[i][1] = Math.round(levelArray[i][0]/totalMembers*100);

			if (percentageLargest < levelArray[i][1])
				percentageLargest = levelArray[i][1];

//			document.getElementById("levelPercentage"+ i).innerHTML =  levelArray[i][1];
		}	
		
		//change Level Bars
		var laLength = levelArray.length;
		for (var i = 10; i < laLength; i++) {
		
			if (percentageLargest == 0)
				setHeight = 0;
			else{
				try{	
					setHeight = Math.round(50 * levelArray[i][1]/percentageLargest);		
				}catch(e){
					//alert(i);
				}
			}
		
			document.getElementById("levelBar"+ i).style.height = setHeight + "px";
		}	

		document.getElementById('numReturnedResults').innerHTML = totalMembers;

	}

	setArrays(getFilteredArray(-1, -1, -1, -1, -1, completeArray));
