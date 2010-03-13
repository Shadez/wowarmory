var textNone = "Ninguno";
var textLearnMore = "Haz clic aquí para saber más"
var textLearnMoreHover = "Mientras miras el perfil del personaje, haz clic en la chincheta en la parte superior derecha de esta ventana para marcar este perfil y así guardalo en esa ventana.";

var textClickPin = "Haz clic aquí para marcar este perfil";
var tClickPinBreak = "Haz clic aquí para<br />marcar este perfil";
var textViewProfile = "Ver perfil";

var textSearchTheArmory = "Buscar en la Armería";

var textArmory = "Armería";
var textSelectCategory = "-- Categorías --";
var textArenaTeams = "Equipos de Arena";
var textCharacters = "Personajes";
var textGuilds = "Hermandades";
var textItems = "Objetos";

var textEnterGuildName = "Introduce el nombre de la hermandad";
var textEnterCharacterName = "Introduce el nombre del personaje";
var textEnterTeamName = "Introduce el nombre de tu equipo";

var textVs2 = "2c2";
var textVs3 = "3c3";
var textVs5 = "5c5";

var textCurrentlyEquipped = "<span class = 'myGray'>Equipado</span>";

var beforeDiminishingReturns = "<span class = 'myGray'>(Antes del rendimiento decreciente)</span>";

var textPoor = "Pobre";
var textFair = "Regular";
var textGood = "Bueno";
var textVeryGood = "Muy bueno";
var textExcellent = "Excelente";

var tStwoChar = "La palabra de búsqueda debe contener al menos 2 caracteres.";
var tScat = "Por favor, selecciona una categoría.";
var tSearchAll = "Buscar todo";

	var textHideItemFilters = "Ocultar filtros";
	var textShowItemFilters = "Mostrar filtros";
	
	var textHideAdvancedOptions = "Ocultar opciones";
	var textShowAdvancedOptions = "Mostrar opciones";
	
	var textErrorLevel = "Nivel min. es mayor que nivel max.";
	var textErrorSkill = "Habilidad min. es mayor que Habilidad max.";

var tPage = "Página";
var textOf = "de";

var tRelevance = "Relevancia";
var tRelevanceKr = "";

var tGuildLeader = "Maestro de la hermandad";
var tGuildRank = "Rango";

var textrace = "";
var textclass = "";

var text1race = "Humano";
var text2race = "Orco";
var text3race = "Enano";
var text4race = "Elfo de la noche";
var text5race = "No muerto";
var text6race = "Tauren";
var text7race = "Gnomo";
var text8race = "Troll";
var text10race = "Elfo de sangre";
var text11race = "Draenei";

var text1class = "Guerrero";
var text2class = "Paladín";
var text3class = "Cazador";
var text4class = "Pícaro";
var text5class = "Sacerdote";
var text6class = "Caballero de la Muerte";
var text7class = "Shamán";
var text8class = "Mago";
var text9class = "Brujo";
var text11class = "Druida";

function printWeeks(numWeeks) {
	if (numWeeks == 1)
		return "1 semana";
	else
		return numWeeks + " semanas";
}

var tCharName = "Nombre de personaje";
var tGRank = "Rango de hermandad";
var toBag = "Origen";
var tTType = "Acción";
var tdBag = "Destino";
var tItem = "Objeto"
var tDate = "Fecha y hora";

var tItemName = "Objeto";
var tItemBag = "Pestaña";
var tItemSlot = "Hueco";
var tItemType = "Tipo";
var tItemSubtype = "Subtipo";

var tenchT = "Encantamiento";
var tenchP = "Encantamiento";

var tLoading = "Cargando";
var errorLoadingToolTip = "Error al cargar mensaje de ayuda.";

function returnDateOrder(theMonth, theDay, theYear, theTime) {
	return theDay + theMonth + theYear + theTime; //organize the variables according to your region's custom
}

function returnDay(theDay, nospace) {
	
	if (nospace) {
		switch (theDay) {
		case 0: return 'Domingo';
		case 1: return 'Lunes';
		case 2: return 'Martes';
		case 3: return 'Miércoles';
		case 4: return 'Jueves';
		case 5: return 'Viernes';
		case 6: return 'Sábado';
		default: return '';
		}		
	} else {
		switch (theDay) {
		case 0: return 'Dom&nbsp;';
		case 1: return 'Lun&nbsp;';
		case 2: return 'Mar&nbsp;&nbsp;';
		case 3: return 'Mi&eacute;&nbsp;';
		case 4: return 'Jue';
		case 5: return 'Vie&nbsp;';
		case 6: return 'S&aacute;b&nbsp;';
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
		var d = returnDay(theDate.getDay()) + ", " + newDate.getDate() +"/"+ (newDate.getMonth() + 1) +"/"+ theYear +" "+ theHour +":"+ theMinutes;	

	return d;
}

function formatDateGraph(theDate) {
	
	var newDate = new Date(theDate);
	
	
	var monthArray = new Array();
	monthArray[0] = "Ene";
	monthArray[1] = "Feb";
	monthArray[2] = "Mar";
	monthArray[3] = "Abr";
	monthArray[4] = "May";
	monthArray[5] = "Jun";
	monthArray[6] = "Jul";
	monthArray[7] = "Ago";
	monthArray[8] = "Sep";
	monthArray[9] = "Oct";
	monthArray[10] = "Nov";
	monthArray[11] = "Dic";
	

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

var textTeam = "Equipo";

var textOpponent = "Nombre del equipo oponente";
var textResult = "resultado";
var textDate = "Fecha y hora";
var textNewRating = "Nueva calificación";
var textRatingChange = "Cambio de calif.";

var textOverallRatingChange = "Cambio total de calif.";
var textW = "V";
var textWins = "Victorias";
var textL = "D";
var textLosses = "Derrotas";
var textMP = "PJ";
var textMatchesPlayed = "Partidas jugadas";
var textWinPercent = "% victorias";
var textAvgChange = "Cambio medio por partida";

var textCharName = "Personaje";
var textKillingBlows = "Golpes de gracia";
var textDamageDone = "Daño causado&nbsp;";
var textDamageTaken = "Daño recibido&nbsp;";
var textHealingDone = "Sanación realizada&nbsp;";
var textHealingTaken = "Sanación recibida&nbsp;&nbsp;";
var tRace = "Raza&nbsp;";
var tClass = "Clase";
var textFindGraph = "&lt;Buscar en gráfico&gt;";
var textEmpty = "";

var textRealm = "Reino";
var textTeamDeleted = "Este equipo ya no existe";
var textOHistory = "Ver un resumen interactivo de todas las partidas jugadas contra este equipo.";

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


function dateLocalization(){	
	Date.dayNames = ['Doming', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
	Date.abbrDayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
	Date.monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
	Date.abbrMonthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
	
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
		TEXT_PREV_YEAR		:	'Año anterior',
		TEXT_PREV_MONTH		:	'Mes anterior',
		TEXT_NEXT_YEAR		:	'Año siguiente',
		TEXT_NEXT_MONTH		:	'Mes siguiente',
		TEXT_CLOSE			:	'Cerrar',
		TEXT_CHOOSE_DATE	:	'Elegir fecha',
		HEADER_FORMAT		:	'mmmm yyyy'
	};
}

jsLoaded=true;

