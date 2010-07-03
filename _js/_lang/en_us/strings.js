var textNone = "None";
var textLearnMore = "Click here to learn more"
var textLearnMoreHover = "While viewing a character profile, click the small pin in the upper right of this window to pin the profile, thereby saving it to the window.";

var textClickPin = "Click here to pin this profile.";
var tClickPinBreak = "Click here to<br />Pin this Profile";
var textViewProfile = "View profile";

var textSearchTheArmory = "Search the Armory";

var textArmory = "Armory";
var textSelectCategory = "--Select a Category--";
var textArenaTeams = "Arena Teams";
var textCharacters = "Characters";
var textGuilds = "Guilds";
var textItems = "Items";

var textEnterGuildName = "Enter Guild Name";
var textEnterCharacterName = "Enter Character Name";
var textEnterTeamName = "Enter Team Name";

var textVs2 = "2v2";
var textVs3 = "3v3";
var textVs5 = "5v5";

var textCurrentlyEquipped = "<span class = 'myGray'>Currently Equipped</span>";

var beforeDiminishingReturns = "<span class = 'myGray'>(Before diminishing returns)</span>";

var textPoor = "Poor";
var textFair = "Fair";
var textGood = "Good";
var textVeryGood = "Very Good";
var textExcellent = "Excellent";

var tStwoChar = "Search must be at least 2 characters long.";
var tScat = "Please select a category.";
var tSearchAll = "Search All ";

	var textHideItemFilters = "Hide Item Filters";
	var textShowItemFilters = "Show Item Filters";
	
	var textHideAdvancedOptions = "Hide Advanced Options";
	var textShowAdvancedOptions = "Show Advanced Options";
	
	var textErrorLevel = "Min Level is greater than Max Level";
	var textErrorSkill = "Min Skill is greater than Max Skill";

var tPage = "Page";
var textOf = "of";

var tRelevance = "Relevance";
var tRelevanceKr = "";

var tGuildLeader = "Guild Leader";
var tGuildRank = "Rank";

var textrace = "";
var textclass = "";

var text1race = "Human";
var text2race = "Orc";
var text3race = "Dwarf";
var text4race = "Night Elf";
var text5race = "Undead";
var text6race = "Tauren";
var text7race = "Gnome";
var text8race = "Troll";
var text10race = "Blood Elf";
var text11race = "Draenei";

var text1class = "Warrior";
var text2class = "Paladin";
var text3class = "Hunter";
var text4class = "Rogue";
var text5class = "Priest";
var text6class = "Death Knight";
var text7class = "Shaman";
var text8class = "Mage";
var text9class = "Warlock";
var text11class = "Druid";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 week";
	else
		return numWeeks + " weeks";
}

var tCharName = "Character Name";
var tGRank = "Guild Rank";
var toBag = "Origin";
var tTType = "Action";
var tdBag = "Dest.";
var tItem = "Item"
var tDate = "Date & Time";

var tItemName = "Item";
var tItemBag = "Tab";
var tItemSlot = "Slot";
var tItemType = "Type";
var tItemSubtype = "Subtype";

var tenchT = "Enchantment";
var tenchP = "Enchantment";

var tLoading = "Loading";
var errorLoadingToolTip = "Error loading tooltip.";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theMonth + theDay + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay, nospace) {
	
	if (nospace) {
		switch (theDay) {
		case 0: return 'Sunday';
		case 1: return 'Monday';
		case 2: return 'Tuesday';
		case 3: return 'Wednesday';
		case 4: return 'Thursday';
		case 5: return 'Friday';
		case 6: return 'Saturday';
		default: return '';
		}		
	} else {
		switch (theDay) {
		case 0: return 'Sun&nbsp;';
		case 1: return 'Mon&nbsp;';
		case 2: return 'Tue&nbsp;&nbsp;';
		case 3: return 'Wed&nbsp;';
		case 4: return 'Thur';
		case 5: return 'Fri&nbsp;&nbsp;&nbsp;&nbsp;';
		case 6: return 'Sat&nbsp;';
		default: return '';
		}
	}
}

function formatDate(theDate, isSimple) {

	var newDate = new Date(theDate);
	
	var amPM;
	if (newDate.getHours() >= 12)
		amPM = "PM"
	else
		amPM = "AM"
		
	var theHour = newDate.getHours()%12;
	if (!theHour)
		theHour = 12;
		
	var theMinutes = newDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var theYear = newDate.getFullYear();

	if (isSimple)
		var d = (newDate.getMonth() + 1) +"/"+ newDate.getDate() +"/"+ theYear;
	else
		var d = returnDay(newDate.getDay()) + " " + (newDate.getMonth() + 1) +"/"+ newDate.getDate() +"/"+ theYear +" "+ theHour +":"+ theMinutes +" "+ amPM;

	return d;
}

function formatDateGraph(theDate) {
	
	var newDate = new Date(theDate);
	
	
	var monthArray = new Array();
	monthArray[0] = "Jan";
	monthArray[1] = "Feb";
	monthArray[2] = "March";
	monthArray[3] = "April";
	monthArray[4] = "May";
	monthArray[5] = "June";
	monthArray[6] = "July";
	monthArray[7] = "Aug";
	monthArray[8] = "Sept";
	monthArray[9] = "Oct";
	monthArray[10] = "Nov";
	monthArray[11] = "Dec";
	

	var amPM;
	if (newDate.getHours() >= 12)
		amPM = "PM"
	else
		amPM = "AM"
		
	var theHour = newDate.getHours()%12;
	if (!theHour)
		theHour = 12;

	var theYear = newDate.getFullYear();

	var theMinutes = newDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var d = new Array();
	d = [monthArray[newDate.getMonth()] +" "+ newDate.getDate() +", "+ theYear, theHour +":"+ theMinutes +" "+ amPM ];
	
	//alert("d: " + d);
	
	return d;
}

function returnDateFormat() {
	return ['month', 'day', 'year'];
}

var gTruncItemNameContents = 70;
var gTruncItemName = 35;
var gTruncGuildRank = 18;

function printBag(bagId) {
	return tItemBag + " " + bagId;
}

var textTeam = "Team";

var textOpponent = "Opponent Team Name";
var textResult = "Result";
var textDate = "Date & Time";
var textNewRating = "New Rating";
var textRatingChange = "Rating Change";

var textOverallRatingChange = "Net Rating Change";
var textW = "W";
var textWins = "Wins";
var textL = "L";
var textLosses = "Losses";
var textMP = "MP";
var textMatchesPlayed = "Matches Played";
var textWinPercent = "Win %&nbsp;&nbsp;";
var textAvgChange = "Avg Change per Match";

var textCharName = "Character Name";
var textKillingBlows = "Killing Blows";
var textDamageDone = "Damage Done&nbsp;";
var textDamageTaken = "Damage Taken&nbsp;";
var textHealingDone = "Healing Done&nbsp;";
var textHealingTaken = "Healing Taken&nbsp;&nbsp;";
var tRace = "Race&nbsp;";
var tClass = "Class";
var textFindGraph = "&lt;find on graph&gt;";
var textEmpty = "";

var textRealm = "Realm";
var textTeamDeleted = "This team no longer exists";
var textOHistory = "View an interactive summary of all the matches played against this team.";

function formatNumber(number)
{
	number = number.toString();
	if (number.length > 3) {
		var mod = number.length % 3;
		var output = (mod > 0 ? (number.substring(0,mod)) : '');
		for (i=0 ; i < Math.floor(number.length / 3); i++) {
			if ((mod == 0) && (i == 0))
				output += number.substring(mod+ 3 * i, mod + 3 * i + 3);
			else
				output+= ',' + number.substring(mod + 3 * i, mod + 3 * i + 3);
		}
		return (output);
	}
	else return number;
}

//used in datepicker
function dateLocalization(){	
	Date.dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	Date.abbrDayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	Date.monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	Date.abbrMonthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	
	Date.firstDayOfWeek = 1;
	Date.format = 'mm/dd/yyyy';
	
	Date.use24hr = false;
	Date.pm = "PM";
	Date.am = "AM";
	
	/*	
		g  	12-hour format of an hour without leading zeros		1 through 12
		G 	24-hour format of an hour without leading zeros 	0 through 23
		h 	12-hour format of an hour with leading zeros		01 through 12
		H 	24-hour format of an hour with leading zeros		00 through 23
		i 	Minutes with leading zeros 							00 to 59
		s 	Seconds, with leading zeros 						00 through 59		
	*/	
	Date.timeformat = 'g:i:s';	
	Date.dateTimeFormat = 'mm/dd/yyyy g:i:s'
	
	Date.seconds = "secs";
	Date.minutes = "mins";
	
	$.dpText = {
		TEXT_PREV_YEAR		:	'Previous year',
		TEXT_PREV_MONTH		:	'Previous month',
		TEXT_NEXT_YEAR		:	'Next year',
		TEXT_NEXT_MONTH		:	'Next month',
		TEXT_CLOSE			:	'Close',
		TEXT_CHOOSE_DATE	:	'Choose date',
		HEADER_FORMAT		:	'mmmm yyyy'
	};
}

jsLoaded=true;


