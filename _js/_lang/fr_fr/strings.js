var textNone = "Aucune";
var textLearnMore = "Cliquez ici pour savoir plus"
var textLearnMoreHover = "Lorsque vous regardez une fiche de personnage, cliquez sur la petite épingle dans le coin supérieur droit de cette fenêtre. Vous aurez ainsi cette fiche à disposition.";

var textClickPin = "Cliquez ici pour épingler cette fiche.";
var tClickPinBreak = "Cliquez ici pour<br />épingler cette fiche.";
var textViewProfile = "Voir la fiche";

var textSearchTheArmory = "Chercher dans l’Armurerie";

var textArmory = "Armurerie";
var textSelectCategory = " --- Catégorie ? --- ";
var textArenaTeams = "Équipes d’arène";
var textCharacters = "Personnages";
var textGuilds = "Guildes";
var textItems = "Objets";

var textEnterGuildName = "Entrez le nom de la guilde";
var textEnterCharacterName = "Entrez le nom du personnage";
var textEnterTeamName = "Entrez le nom de l’équipe";

var textVs2 = "2c2";
var textVs3 = "3c3";
var textVs5 = "5c5";

var textCurrentlyEquipped = "<span class = 'myGray'>Actuellement équipé</span>";

var beforeDiminishingReturns = "<span class = 'myGray'>(avant les rendements décroissants)</span>";

var textPoor = "Mauvaise";
var textFair = "Moyenne";
var textGood = "Bonne";
var textVeryGood = "Très bonne";
var textExcellent = "Excellente";

var tStwoChar = "La recherche doit comporter au moins 2 lettres.";
var tScat = "Veuillez sélectionner une catégorie.";
var tSearchAll = "Cherchez dans la catégorie ";

	var textHideItemFilters = "Cacher les critères";
	var textShowItemFilters = "Montrer les critères";
	
	var textHideAdvancedOptions = "Options avancées OFF";
	var textShowAdvancedOptions = "Options avancées ON";
	
	var textErrorLevel = "Le niveau minimum est plus grand que le niveau maximum";
	var textErrorSkill = "La compétence minimum est plus grande que la compétence maximum";

var tPage = "Page";
var textOf = "sur";

var tRelevance = "de pertinence";
var tRelevanceKr = "";

var tGuildLeader = "Chef de guilde";
var tGuildRank = "Grade";

var textrace = "";
var textclass = "";

var text1race = "Humain";
var text2race = "Orc";
var text3race = "Nain";
var text4race = "Elfe de la nuit";
var text5race = "Mort-vivant";
var text6race = "Tauren";
var text7race = "Gnome";
var text8race = "Troll";
var text10race = "Elfe de sang";
var text11race = "Draeneï";

var text1class = "Guerrier";
var text2class = "Paladin";
var text3class = "Chasseur";
var text4class = "Voleur";
var text5class = "Prêtre";
var text6class = "Chevalier de la mort";
var text7class = "Chaman";
var text8class = "Mage";
var text9class = "Démoniste";
var text11class = "Druide";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 semaine";
	else
		return numWeeks + " semaines";
}

var tCharName = "Nom du personnage";
var tGRank = "Grade de guilde";
var toBag = "Déposant";
var tTType = "Action";
var tdBag = "Dest.";
var tItem = "Objet"
var tDate = "Date & heure";

var tItemName = "Objet";
var tItemBag = "Onglet";
var tItemSlot = "Emplacement";
var tItemType = "Type";
var tItemSubtype = "Catégorie";

var tenchT = "Enchantements";
var tenchP = "Enchantements";

var tLoading = "Chargement";
var errorLoadingToolTip = "Erreur de chargement de la description.";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theDay + theMonth + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay, nospace) {
	
	if (nospace) {
		switch (theDay) {
		case 0: return 'Dimanche';
		case 1: return 'Lundi';
		case 2: return 'Mardi';
		case 3: return 'Mercredi';
		case 4: return 'Jeudi';
		case 5: return 'Vendredi';
		case 6: return 'Samedi';
		default: return '';
		}		
	} else {
		switch (theDay) {
		case 0: return 'Dim&nbsp;';
		case 1: return 'Lun&nbsp;';
		case 2: return 'Mar&nbsp;';
		case 3: return 'Mer&nbsp;';
		case 4: return 'Jeu&nbsp;';
		case 5: return 'Ven&nbsp';
		case 6: return 'Sam&nbsp;';
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
		var d = newDate.getDate() +"/"+ (newDate.getMonth() + 1) +"/"+ theYear;
	else
		var d = returnDay(newDate.getDay()) + " " + newDate.getDate() +" "+ (newDate.getMonth() + 1) +" "+ theYear +" "+ theHour +"h"+ theMinutes;	

	return d;
}

function formatDateGraph(theDate) {
	
	var newDate = new Date(theDate);
	
	
	var monthArray = new Array();
	monthArray[0] = "Jan.";
	monthArray[1] = "Fév.";
	monthArray[2] = "Mars";
	monthArray[3] = "Avril";
	monthArray[4] = "Mai";
	monthArray[5] = "Juin";
	monthArray[6] = "Jui.";
	monthArray[7] = "Août";
	monthArray[8] = "Sept";
	monthArray[9] = "Oct";
	monthArray[10] = "Nov";
	monthArray[11] = "Déc";
	

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

var textTeam = "Équipe";

var textOpponent = "Nom de l'équipe adverse";
var textResult = "Résultat";
var textDate = "Date & heure";
var textNewRating = "Nouvelle cote";
var textRatingChange = "Changement de cote";

var textOverallRatingChange = "Changement global de cote";
var textW = "V";
var textWins = "Victoires";
var textL = "D";
var textLosses = "Défaites";
var textMP = "MJ";
var textMatchesPlayed = "Matches joués";
var textWinPercent = "% de victoires";
var textAvgChange = "Changement approx. par match";

var textCharName = "Nom du personnage";
var textKillingBlows = "Coups de grâce";
var textDamageDone = "Dégâts infligés&nbsp;";
var textDamageTaken = "Dégâts reçus&nbsp;";
var textHealingDone = "Soins prodigués&nbsp;";
var textHealingTaken = "Soins reçus&nbsp;&nbsp;";
var tRace = "Race&nbsp;";
var tClass = "Classe&nbsp;";
var textFindGraph = "&lt;sur le graphique &&gt;";
var textEmpty = "";

var textRealm = "Royaume";
var textTeamDeleted = "Cette équipe n’existe plus";
var textOHistory = "Voir un résumé interactif de tous les matchs joués contre cette équipe.";

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
			output+= '.' + number.substring(mod + 3 * i, mod + 3 * i + 3);
	}
	return (output);
	}
	else return number;
}


function dateLocalization(){	
	Date.dayNames = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
	Date.abbrDayNames = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
	Date.monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
	Date.abbrMonthNames = ['Jan.', 'Fév.', 'Mar.', 'Avr.', 'Mai', 'Juin', 'Juil', 'Août', 'Sep.', 'Oct.', 'Nov.', 'Déc.'];
	
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
	Date.timeformat = 'g:i:s';	
	Date.dateTimeFormat = 'dd/mm/yyyy H:i:s'
	
	Date.seconds = "secs";
	Date.minutes = "mins";
	
	$.dpText = {
		TEXT_PREV_YEAR		:	'Année précédente',
		TEXT_PREV_MONTH		:	'Mois précédent',
		TEXT_NEXT_YEAR		:	'Année suivante',
		TEXT_NEXT_MONTH		:	'Mois suivant',
		TEXT_CLOSE			:	'Fermer',
		TEXT_CHOOSE_DATE	:	'Choisir la date',
		HEADER_FORMAT		:	'mmmmm yyyy'
	};
}

jsLoaded=true;

