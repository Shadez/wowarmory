var textNone = "Kein Profil gewählt";
var textLearnMore = "Mehr Informationen"
var textLearnMoreHover = "Wenn ihr ein Charakterprofil betrachtet, könnt ihr auf die kleine Stecknadel am oberen rechten Rand dieses Feldes klicken, um euch das Profil zu merken und es in diesem Fenster zu speichern.";

var textClickPin = "Hier klicken, um dieses Profil zu merken.";
var tClickPinBreak = "Hier klicken, um<br />dieses Profil zu merken";
var textViewProfile = "Profil ansehen";

var textSearchTheArmory = "Suche im Arsenal";

var textArmory = "Arsenal";
var textSelectCategory = "--Kategorie wählen--";
var textArenaTeams = "Arena-Teams";
var textCharacters = "Charaktere";
var textGuilds = "Gilden";
var textItems = "Gegenstände";

var textEnterGuildName = "Gildennamen eingeben";
var textEnterCharacterName = "Charakternamen eingeben";
var textEnterTeamName = "Teamnamen eingeben";

var textVs2 = "2v2";
var textVs3 = "3v3";
var textVs5 = "5v5";

var textCurrentlyEquipped = "<span class = 'myGray'>Zurzeit angelegt</span>";

var beforeDiminishingReturns = "<span class = 'myGray'>(Vor abnehmender Wirkung)</span>";

var textPoor = "Schlecht";
var textFair = "Mäßig";
var textGood = "Gut";
var textVeryGood = "Sehr gut";
var textExcellent = "Ausgezeichnet";

var tStwoChar = "Ein Suchbegriff muss mindestens zwei Zeichen lang sein.";
var tScat = "Bitte Kategorie auswählen.";
var tSearchAll = "Alles durchsuchen ";

	var textHideItemFilters = "Filter verbergen";
	var textShowItemFilters = "Filter anzeigen";
	
	var textHideAdvancedOptions = "Erweiterte Optionen aus";
	var textShowAdvancedOptions = "Erweiterte Optionen ein";
	
	var textErrorLevel = "Min. Stufe ist größer als max. Stufe";
	var textErrorSkill = "Min. Fertigkeitswert ist größer als max. Fertigkeitswert";

var tPage = "Seite";
var textOf = "von";

var tRelevance = "Relevanz";
var tRelevanceKr = "";

var tGuildLeader = "Gildenoberhaupt";
var tGuildRank = "Rang";

var textrace = "";
var textclass = "";

var text1race = "Mensch";
var text2race = "Orc";
var text3race = "Zwerg";
var text4race = "Nachtelf";
var text5race = "Untoter";
var text6race = "Tauren";
var text7race = "Gnom";
var text8race = "Troll";
var text10race = "Blutelf";
var text11race = "Draenei";

var text1class = "Krieger";
var text2class = "Paladin";
var text3class = "Jäger";
var text4class = "Schurke";
var text5class = "Priester";
var text6class = "Todesritter";
var text7class = "Schamane";
var text8class = "Magier";
var text9class = "Hexenmeister";
var text11class = "Druide";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 Woche";
	else
		return numWeeks + " Wochen";
}

var tCharName = "Charaktername";
var tGRank = "Gildenrang";
var toBag = "Herkunft";
var tTType = "Aktion";
var tdBag = "Ziel";
var tItem = "Gegenstand"
var tDate = "Zeit & Datum";

var tItemName = "Gegenstand";
var tItemBag = "Fach";
var tItemSlot = "Platz";
var tItemType = "Kategorie";
var tItemSubtype = "Unterkategorie";

var tenchT = "Verzauberung";
var tenchP = "Verzauberung";

var tLoading = "Lädt";
var errorLoadingToolTip = "Fehler beim Laden des Tooltips.";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theDay + theMonth + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay, nospace) {
	
	if (nospace) {
		switch (theDay) {
		case 0: return 'Sonntag';
		case 1: return 'Montag';
		case 2: return 'Dienstag';
		case 3: return 'Mittwoch';
		case 4: return 'Donnerstag';
		case 5: return 'Freitag';
		case 6: return 'Samstag';
		default: return '';
		}		
	} else {
		switch (theDay) {
		case 0: return 'So&nbsp;';
		case 1: return 'Mo&nbsp;';
		case 2: return 'Di&nbsp;&nbsp;';
		case 3: return 'Mi&nbsp;';
		case 4: return 'Do';
		case 5: return 'Fr&nbsp;&nbsp;&nbsp;&nbsp;';
		case 6: return 'Sa&nbsp;';
		default: return '';
		}	
	}
}

function formatDate(theDate, isSimple) {

	var newDate = new Date(theDate);
	
	//var amPM;
	//if (newDate.getHours() >= 12)
	//	amPM = "PM"
	//else
	//	amPM = "AM"
		
	var theHour = newDate.getHours()%12;
	//if (!theHour)
	//	theHour = 12;
		
	var theMinutes = newDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var theYear = newDate.getFullYear();

	if (isSimple)
		var d = newDate.getDate() +"."+ (newDate.getMonth() + 1) +"."+ theYear;
	else
		var d = returnDay(newDate.getDay()) + " " + newDate.getDate() +"."+ (newDate.getMonth() + 1) +"."+ theYear +" "+ theHour +":"+ theMinutes;	

	return d;
}

function formatDateGraph(theDate) {
	
	var newDate = new Date(theDate);
	
	
	var monthArray = new Array();
	monthArray[0] = "Jan";
	monthArray[1] = "Feb";
	monthArray[2] = "März";
	monthArray[3] = "April";
	monthArray[4] = "Mai";
	monthArray[5] = "Juni";
	monthArray[6] = "Juli";
	monthArray[7] = "Aug";
	monthArray[8] = "Sept";
	monthArray[9] = "Okt";
	monthArray[10] = "Nov";
	monthArray[11] = "Dez";
	

	//var amPM;
	//if (newDate.getHours() >= 12)
	//	amPM = "PM"
	//else
	//	amPM = "AM"
		
	var theHour = newDate.getHours()%12;
	//if (!theHour)
	//	theHour = 12;
		
	var theYear = newDate.getFullYear();

	var theMinutes = newDate.getMinutes();
	if (!theMinutes)
		theMinutes = "00"
	if ((parseInt(theMinutes) <= 9) && (theMinutes != "00"))	
		theMinutes = "0" + theMinutes;
		
	var d = new Array();
	d = [newDate.getDate() +", "+ monthArray[newDate.getMonth()] +" "+  theYear, theHour +":"+ theMinutes];
	
	//alert("d: " + d);
	
	return d;
}

function returnDateFormat() {
	return ['day', 'month', 'year'];
}

var gTruncItemNameContents = 70;
var gTruncItemName = 35;
var gTruncGuildRank = 18;

function printBag(bagId) {
	return tItemBag + " " + bagId;
}

var textTeam = "Team";

var textOpponent = "Generischer Team-Name";
var textResult = "Ergebnis";
var textDate = "Datum & Zeit";
var textNewRating = "Neue Wertung";
var textRatingChange = "Wertungsänderung";

var textOverallRatingChange = "Gesamtänderung der Wertung";
var textW = "S";
var textWins = "Siege";
var textL = "N";
var textLosses = "Niederlagen";
var textMP = "GM";
var textMatchesPlayed = "Gespielte Matches";
var textWinPercent = "% gewonnen";
var textAvgChange = "Durchschn. Änderung pro Kampf";

var textCharName = "Charaktername";
var textKillingBlows = "Todesstöße";
var textDamageDone = "Zugefügter Schaden&nbsp;";
var textDamageTaken = "Erlittener Schaden&nbsp;";
var textHealingDone = "Gewirkte Heilung&nbsp;";
var textHealingTaken = "Erhaltene Heilung&nbsp;&nbsp;";
var tRace = "Volk&nbsp;";
var tClass = "Klasse";
var textFindGraph = "&lt;Am Graphen finden&gt;";
var textEmpty = "";

var textRealm = "Realm";
var textTeamDeleted = "Dieses Team existiert nicht mehr";
var textOHistory = "Seht euch eine interaktive Zusammenfassung aller gespielten Matches gegen dieses Team an.";

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

//used in datepicker [t] translate all above then remove [t]
function dateLocalization(){	
	Date.dayNames = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
	Date.abbrDayNames = ['Son', 'Mon', 'Die', 'Mit', 'Don', 'Fre', 'Sam'];
	Date.monthNames = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
	Date.abbrMonthNames = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'];
	
	Date.firstDayOfWeek = 1;
	Date.format = 'dd/mm/yyyy';
	
	Date.use24hr = true;
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
	Date.timeformat = 'H:i:s';	
	Date.dateTimeFormat = 'dd/mm/yyyy H:i:s'
	
	Date.seconds = "Sek";
	Date.minutes = "Min";
	
	$.dpText = {
		TEXT_PREV_YEAR		:	'Voriges Jahr',
		TEXT_PREV_MONTH		:	'Voriger Monat',
		TEXT_NEXT_YEAR		:	'Nächstes Jahr',
		TEXT_NEXT_MONTH		:	'Nächster Monat',
		TEXT_CLOSE			:	'Schließen',
		TEXT_CHOOSE_DATE	:	'Datum auswählen',
		HEADER_FORMAT		:	'mmmm yyyy'
	};
}

jsLoaded=true;

