<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">

<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="tab" id="tab_talentCalculator">
<a href="talent-calc.xml">{#armory_talent_calc_talents_calc#}</a>
</div>
<div class="tab" id="tab_petTalentCalculator">
<a href="talent-calc.xml?pid=-1">{#armory_talent_calc_pet_talents#}</a>
</div>
<div class="selected-tab" id="tab_arenaCalculator">
<a href="arena-calculator.xml">{#armory_talent_calc_arena_calc#}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs" style="height: 1px;">
<div class="upperLeftCorner" style="height: 5px;"></div>
<div class="upperRightCorner" style="height: 5px;"></div>
</div>
<div class="full-list">
<div class="info-pane">
<div class="profile-wrapper">
<blockquote>
<b class="iarenateams">
<h4>
<a href="/battlegroups.xml">Arenas</a>
</h4>
<h3>Calculadora para las Arenas</h3>
</b>
</blockquote>
<div class="sidebarstretch">
<div class="arenacalc">
<div style="position:relative; z-index:9999;">
<div class="crosshairsketch"></div>
</div>
<div class="maincontent">
<div class="calc-select">
<h1>Selecciona una calculadora:</h1>
<ul>
<li class="calculatorActive" id="classPoints">
<a class="button1bg" href="#" onClick="javascript:showCat('Points'); return false;">
<div>
<h2>Calculadora de puntos de Arenas</h2>
<h3>&iquest;Cu&aacute;ntos puntos de Arenas ganar&eacute; esta semana?</h3>
</div>
</a>
</li>
<li class="calculatorInactive" id="classRating">
<a class="button2bg" href="#" onClick="javascript:showCat('Rating'); calcRating(document.getElementById('inputRatingPointsNeeded').value);return false;">
<div>
<h2>Calculadora de puntuaci&oacute;n</h2>
<h3>&iquest;Cu&aacute;l es la puntuaci&oacute;n media necesaria para obtener la recompensa que deseo?</h3>
</div>
</a>
</li>
<li class="calculatorInactive" id="classTime">
<a class="button3bg" href="#" onClick="javascript:showCat('Time'); calcGoal(document.getElementById('inputGoalPointsDesired').value, document.getElementById('inputAverageRatingGoal').value); return false;">
<div>
<h2>Calculadora de tiempo</h2>
<h3>&iquest;Cu&aacute;ndo podr&eacute; obtener la recompensa de Arenas que deseo?</h3>
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
<h4>&iquest;Cu&aacute;ntos puntos de Arenas ganar&eacute; esta semana?</h4>
<div class="redrow">
<span class="red-label">Puntuaci&oacute;n:</span>
<div>
<input id="inputRating" name="inputRating" onFocus="this.select()" onKeyUp="javascript: traverseNames(this.name, this.value); calcPoints(this.value);" size="4" type="text" value="0">
</div>
</div>
<ul>
<li>
<span>puntos de Arenas</span>
<div>
<h5>2c2:</h5>
<h6 id="replaceTwo">0</h6>
</div>
</li>
<li>
<span>puntos de Arenas</span>
<div>
<h5>3c3:</h5>
<h6 id="replaceThree">0</h6>
</div>
</li>
<li>
<span>puntos de Arenas</span>
<div>
<h5>5c5:</h5>
<h6 id="replaceFive">0</h6>
</div>
</li>
</ul>
</div>
<div id="hideRating" style="display:none;">
<h4>&iquest;Cu&aacute;l es la puntuaci&oacute;n media necesaria para obtener la recompensa que deseo?</h4>
<div class="equation" id="hideRatingCalc" style="display:block;">
<table>
<tr>
<td class="eqlabel"><span class="teal-label">Precio del objeto:</span></td><td rowspan="5" style="width:61px;"></td><td class="equation-input"><input id="inputArmorCost" name="inputItemCost" onFocus="this.select(); focusCalcPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcDiffRating();" size="4" type="text" value="0"></td>
</tr>
<tr>
<td class="eqspacer1" colspan="3"></td>
</tr>
<tr>
<td class="eqlabel"><span class="green-label">Puntos de Arenas obtenidos:</span></td><td class="equation-input"><input id="inputCurrentPoints" name="inputHavePoints" onFocus="this.select(); focusCalcPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcDiffRating(); check5000error(this.value);" size="4" type="text" value="0"></td>
</tr>
<tr>
<td class="eqspacer2" colspan="3"></td>
</tr>
<tr>
<td class="eqlabel"><span class="brown-label">Puntos necesarios:</span></td><td class="equation-input"><input class="inputUnfocus" id="inputRatingPointsNeeded" name="inputPointsNeeded" onFocus="this.select(); focusPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcRating(this.value);" size="4" type="text" value="0"></td>
</tr>
</table>
</div>
<div class="ratingtable">
<div class="ratingweeks">
<span>Semanas</span>
<ul>
<li>1 semana</li>
<li>2 semanas</li>
<li>3 semanas</li>
<li>4 semanas</li>
<li>5 semanas</li>
<li>6 semanas</li>
<li>7 semanas</li>
<li>8 semanas</li>
<li>9 semanas</li>
<li>10 semanas</li>
<li>11 semanas</li>
<li>12 semanas</li>
</ul>
</div>
<div class="ratingbracket">
<span>Punt. media 2c2</span>
<ul>
<li>
<span id="replaceRatingTwo1">0</span>
</li>
<li>
<span id="replaceRatingTwo2">0</span>
</li>
<li>
<span id="replaceRatingTwo3">0</span>
</li>
<li>
<span id="replaceRatingTwo4">0</span>
</li>
<li>
<span id="replaceRatingTwo5">0</span>
</li>
<li>
<span id="replaceRatingTwo6">0</span>
</li>
<li>
<span id="replaceRatingTwo7">0</span>
</li>
<li>
<span id="replaceRatingTwo8">0</span>
</li>
<li>
<span id="replaceRatingTwo9">0</span>
</li>
<li>
<span id="replaceRatingTwo10">0</span>
</li>
<li>
<span id="replaceRatingTwo11">0</span>
</li>
<li>
<span id="replaceRatingTwo12">0</span>
</li>
</ul>
</div>
<div class="ratingbracket">
<span>Punt. media 3c3</span>
<ul>
<li>
<span id="replaceRatingThree1">0</span>
</li>
<li>
<span id="replaceRatingThree2">0</span>
</li>
<li>
<span id="replaceRatingThree3">0</span>
</li>
<li>
<span id="replaceRatingThree4">0</span>
</li>
<li>
<span id="replaceRatingThree5">0</span>
</li>
<li>
<span id="replaceRatingThree6">0</span>
</li>
<li>
<span id="replaceRatingThree7">0</span>
</li>
<li>
<span id="replaceRatingThree8">0</span>
</li>
<li>
<span id="replaceRatingThree9">0</span>
</li>
<li>
<span id="replaceRatingThree10">0</span>
</li>
<li>
<span id="replaceRatingThree11">0</span>
</li>
<li>
<span id="replaceRatingThree12">0</span>
</li>
</ul>
</div>
<div class="ratingbracket" style="margin-right:0;">
<span>Punt. media 5c5</span>
<ul>
<li>
<span id="replaceRatingFive1">0</span>
</li>
<li>
<span id="replaceRatingFive2">0</span>
</li>
<li>
<span id="replaceRatingFive3">0</span>
</li>
<li>
<span id="replaceRatingFive4">0</span>
</li>
<li>
<span id="replaceRatingFive5">0</span>
</li>
<li>
<span id="replaceRatingFive6">0</span>
</li>
<li>
<span id="replaceRatingFive7">0</span>
</li>
<li>
<span id="replaceRatingFive8">0</span>
</li>
<li>
<span id="replaceRatingFive9">0</span>
</li>
<li>
<span id="replaceRatingFive10">0</span>
</li>
<li>
<span id="replaceRatingFive11">0</span>
</li>
<li>
<span id="replaceRatingFive12">0</span>
</li>
</ul>
</div>
</div>
<div class="clear"></div>
</div>
<div id="hideTime" style="display:none;">
<h4>&iquest;Cu&aacute;ndo podr&eacute; obtener la recompensa de Arenas que deseo?</h4>
<div class="equation" id="hideTimeCalc" style="display:block;">
<table>
<tr>
<td class="eqlabel"><span class="teal-label">Precio del objeto:</span></td><td rowspan="5" style="width:61px;"></td><td class="equation-input"><input id="inputArmorCostGoal" name="inputItemCost" onFocus="this.select(); focusCalcPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcDiffGoal();" size="4" type="text" value="0"></td>
</tr>
<tr>
<td class="eqspacer1" colspan="3"></td>
</tr>
<tr>
<td class="eqlabel"><span class="green-label">Puntos de Arenas obtenidos:</span></td><td class="equation-input"><input id="inputCurrentPointsGoal" name="inputHavePoints" onFocus="this.select(); focusCalcPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcDiffGoal(); check5000error(this.value);" size="4" type="text" value="0"></td>
</tr>
<tr>
<td class="eqspacer2" colspan="3"></td>
</tr>
<tr>
<td class="eqlabel"><span class="brown-label">Puntos necesarios:</span></td><td class="equation-input"><input class="inputUnfocus" id="inputGoalPointsDesired" name="inputPointsNeeded" onFocus="this.select(); focusPointsNeeded();" onKeyUp="javascript: traverseNames(this.name, this.value); calcGoal(this.value, document.getElementById('inputAverageRatingGoal').value); calcItemCost(eval(this.value));" size="4" type="text" value="0"></td>
</tr>
</table>
</div>
<div class="redrow">
<span class="red-label">Puntuaci&oacute;n media:</span>
<div>
<input id="inputAverageRatingGoal" name="inputRating" onFocus="this.select();" onKeyUp="javascript: traverseNames(this.name, this.value); calcDiffGoal();" size="4" type="text" value="0">
</div>
</div>
<ul>
<li>
<div>
<h5>2c2:</h5>
<h6 id="replaceTwoGoal">0</h6>
</div>
</li>
<li>
<div>
<h5>3c3:</h5>
<h6 id="replaceThreeGoal">0</h6>
</div>
</li>
<li>
<div>
<h5>5c5:</h5>
<h6 id="replaceFiveGoal">0</h6>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="sidebar">
<h1>
<div>
<span>Hoja de referencia:</span>
</div>
</h1>
<div class="sidebar-padding">
<div class="sidebar-module pinned-player" id="hideOpera">
<h2>
<span></span><a href="/updates.xml#anchorpinprofile" id="hideWhatPin">&iquest;Qu&eacute; es esto?</a>Perfil principal</h2>
<div class="sidebar-module-bot">
<div class="profile-name">
<span class="playername" id="replacePinName"><strong>Inicia sesi&oacute;n en la Armer&iacute;a para que puedas ver la informaci&oacute;n de la arena de tu personaje primario en la calculadora.</strong></span><span id="replacePinGuild"></span>
</div>
<table class="ratings-on" id="colorRating">
<tr>
<td></td><td>Puntuaci&oacute;n</td><td>Puntos</td>
</tr>
<tr>
<td><a class="arenalinkoff" id="href2">2c2</a>:</td><td class="pinned-redbg" name="colorRating"><span id="replace2Rating">-</span></td><td><span id="replace2Points">-</span></td>
</tr>
<tr>
<td><a class="arenalinkoff" id="href3">3c3</a>:</td><td class="pinned-redbg" name="colorRating"><span id="replace3Rating">-</span></td><td><span id="replace3Points">-</span></td>
</tr>
<tr>
<td><a class="arenalinkoff" id="href5">5c5</a>:</td><td class="pinned-redbg" name="colorRating"><span id="replace5Rating">-</span></td><td><span id="replace5Points">-</span></td>
</tr>
<tr>
<td class="table-seperator" colspan="3"></td>
</tr>
<tr>
<td colspan="2">Puntos de Arenas obtenidos:</td><td id="colorHavePoints"><span id="replaceCurrentPoints">-</span></td>
</tr>
</table>
<p>
<str id="disclaimer.stats">Las estad&iacute;sticas de las Arenas no se actualizan inmediatamente.<br>Los puntos los consigue s&oacute;lo un equipo. [<a href="/faq-arena-calculator.xml#anchorgetArenaPoints" target="_blank">m&aacute;s</a>]</str>
</p>
</div>
</div>
<div class="sidebar-module legend">
<h2>
<span></span>Coste del objeto</h2>
<div class="sidebar-module-bot" id="divItemCosts">
<select onChange="showHideLegend(this.value); return false"><option value="7">Objetos Temporada 7</option><option value="6">Objetos Temporada 6</option><option value="5">Objetos Temporada 5</option><option value="4">Objetos Temporada 4</option><option value="3">Objetos Temporada 3</option><option value="2">Objetos Temporada 2</option></select>
<br>
<arenaItems>

  
<div class="hideLegend" id="hideLegend7" style="display: none;">
<table>
  
  
<tr>
<td class="itemtype-label"><span>Armas</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=two&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Dos manos</a></td><td class="itemcost-cost">4250</td>
</tr>  
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=ranged&amp;subTp=xbow&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Ballesta</a></td><td class="itemcost-cost">4250</td>
</tr>  	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano derecha</a></td><td class="itemcost-cost">3000</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Una mano</a></td><td class="itemcost-cost">3000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=offOnly&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano izquierda</a></td><td class="itemcost-cost">1245</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=thrwn&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Arma arrojadiza</a></td><td class="itemcost-cost">1000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=wnd&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Varita</a></td><td class="itemcost-cost">1150</td>
</tr>	
		
    
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
<tr>
<td class="itemtype-label"><span>Armadura</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=shield&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Escudo</a></td><td class="itemcost-cost">300</td>
</tr>
	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=head&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Cabeza</a></td><td class="itemcost-cost">2150</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=chest&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Pecho</a></td><td class="itemcost-cost">2150</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=legs&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Piernas</a></td><td class="itemcost-cost">2150</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=shoulders&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Hombros</a></td><td class="itemcost-cost">1750</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=hands&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Manos</a></td><td class="itemcost-cost">1300</td>
</tr>		

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=offhand&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;f&amp;advOpt=none">Se porta en mano izquierda</a></td><td class="itemcost-cost">1125</td>
</tr>

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=idol&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">&Iacute;dolo</a></td><td class="itemcost-cost">1150</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=totem&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">T&oacute;tem</a></td><td class="itemcost-cost">1150</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena8&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=libram&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Tratado</a></td><td class="itemcost-cost">1150</td>
</tr>	
	
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
  
</table>
</div>  

  
<div class="hideLegend" id="hideLegend6" style="display: none;">
<table>
  
  
<tr>
<td class="itemtype-label"><span>Armas</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=two&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Dos manos</a></td><td class="itemcost-cost">3750</td>
</tr>  
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=ranged&amp;subTp=xbow&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Ballesta</a></td><td class="itemcost-cost">3750</td>
</tr>  	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano derecha</a></td><td class="itemcost-cost">2625 &oacute; 3150</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Una mano</a></td><td class="itemcost-cost">2625 &oacute; 3150</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=offOnly&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano izquierda</a></td><td class="itemcost-cost">1125</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=thrwn&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Arma arrojadiza</a></td><td class="itemcost-cost">1000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=wnd&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Varita</a></td><td class="itemcost-cost">1000</td>
</tr>	
		
    
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
<tr>
<td class="itemtype-label"><span>Armadura</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=shield&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Escudo</a></td><td class="itemcost-cost">1875</td>
</tr>
	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=head&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Cabeza</a></td><td class="itemcost-cost">1875</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=chest&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Pecho</a></td><td class="itemcost-cost">1875</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=legs&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Piernas</a></td><td class="itemcost-cost">1875</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=shoulders&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Hombros</a></td><td class="itemcost-cost">1500</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=hands&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Manos</a></td><td class="itemcost-cost">1125</td>
</tr>		

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=offhand&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;f&amp;advOpt=none">Se porta en mano izquierda</a></td><td class="itemcost-cost">1125</td>
</tr>

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=idol&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">&Iacute;dolo</a></td><td class="itemcost-cost">1000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=totem&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">T&oacute;tem</a></td><td class="itemcost-cost">1000</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena6&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=libram&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Tratado</a></td><td class="itemcost-cost">1000</td>
</tr>	
	
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
  
</table>
</div>  


  
<div class="hideLegend" id="hideLegend5" style="display: none;">
<table>
  
  
<tr>
<td class="itemtype-label"><span>Armas</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=two&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Dos manos</a></td><td class="itemcost-cost">3750</td>
</tr>  
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=ranged&amp;subTp=xbow&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Ballesta</a></td><td class="itemcost-cost">3750</td>
</tr>  	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano derecha</a></td><td class="itemcost-cost">2625 &oacute; 3150</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=main&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Una mano</a></td><td class="itemcost-cost">2625 &oacute; 3150</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=offOnly&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Mano izquierda</a></td><td class="itemcost-cost">1125</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=thrwn&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Arma arrojadiza</a></td><td class="itemcost-cost">1000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=weapons&amp;usbleBy=all&amp;slot=all&amp;subTp=wnd&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Varita</a></td><td class="itemcost-cost">1000</td>
</tr>	
		
    
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
<tr>
<td class="itemtype-label"><span>Armadura</span></td><td class="itemcost-label"><span>Precio</span></td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=shield&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Escudo</a></td><td class="itemcost-cost">1875</td>
</tr>
	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=head&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Cabeza</a></td><td class="itemcost-cost">1875</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=chest&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Pecho</a></td><td class="itemcost-cost">1875</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=legs&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Piernas</a></td><td class="itemcost-cost">1875</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=shoulders&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Hombros</a></td><td class="itemcost-cost">1500</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=hands&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Manos</a></td><td class="itemcost-cost">1125</td>
</tr>		

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=offhand&amp;subTp=all&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;f&amp;advOpt=none">Se porta en mano izquierda</a></td><td class="itemcost-cost">1125</td>
</tr>

    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=idol&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">&Iacute;dolo</a></td><td class="itemcost-cost">1000</td>
</tr>
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=totem&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">T&oacute;tem</a></td><td class="itemcost-cost">1000</td>
</tr>	
    
<tr>
<td class="itemcost-type"><a href="/search.xml?source=pvpAlliance&amp;pvp=arena5&amp;type=armor&amp;usbleBy=all&amp;slot=all&amp;subTp=libram&amp;rqrMin=&amp;rqrMax=&amp;rrt=all&amp;advOptName=none&amp;andor=and&amp;searchType=items&amp;advOpt=none">Tratado</a></td><td class="itemcost-cost">1000</td>
</tr>	
	
<tr>
<td class="itemcost-bot" colspan="2"></td>
</tr>
  
</table>
</div>  



  
<div class="hideLegend" id="hideLegend4" style="display: none;">
<table>
    
<tr>
<td colspan="2"><span>Las recompensas de la temporada 4 de las Arenas pueden adquirirse ahora con puntos de honor y marcas de honor de los campos de batalla.<p></p>Ver el set completo de recompensas de la temporada 4 a trav&eacute;s del enlace a continuaci&oacute;n.<p></p>
<a href="/search.xml?source=pvpAlliance&amp;pvp=arena4&amp;type=all&amp;searchType=items">Recompensas de la temporada 4 de las Arenas</a></span>
<p></p>
</td>
</tr>
  
</table>
</div>  
  
  
<div class="hideLegend" id="hideLegend3" style="display: none;">
<table>
    
<tr>
<td colspan="2"><span>Las recompensas de la temporada 3 de las Arenas pueden adquirirse ahora con puntos de honor y marcas de honor de los campos de batalla.<p></p>Ver el set completo de recompensas de la temporada 3 a trav&eacute;s del enlace a continuaci&oacute;n.<p></p>
<a href="/search.xml?source=pvpAlliance&amp;pvp=arena3&amp;type=all&amp;searchType=items">Recompensas de la temporada 3 de las Arenas</a></span>
<p></p>
</td>
</tr>
  
</table>
</div>  


  
<div class="hideLegend" id="hideLegend2" style="display: none;">
<table>
    
<tr>
<td colspan="2"><span>Las recompensas de la temporada 2 de las Arenas pueden adquirirse ahora con puntos de honor y marcas de honor de los campos de batalla.<p></p>Ver el set completo de recompensas de la temporada 2 a trav&eacute;s del enlace a continuaci&oacute;n.<p></p>
<a href="/search.xml?source=pvpAlliance&amp;pvp=arena2&amp;type=all&amp;searchType=items">Recompensas de la temporada 2 de las Arenas</a></span>
<p></p>
</td>
</tr>
  
</table>
</div>
  

</arenaItems>
</div>
</div>
</div>
</div>
<div class="clear"></div>
</div>
</div>
<div class="rlbox2 aboutarena">
<div>
<h1>F&oacute;rmulas de los puntos de Arenas</h1>
<div class="formulae">
<table>
<tr>
<td class="formula-label1">
<str id="formula.ifrating">Si <span class="ratingcolor">puntuaci&oacute;n</span>
</str> &le; 1500</td><td>&rarr;</td><td class="formula-label2"><span class="pointscolor">Puntos</span> =</td><td colspan="3" style="padding-left:0;">[ ,22 &times; <span class="ratingcolor">Puntuaci&oacute;n</span> + 14 ]</td>
</tr>
<tr>
<td class="formula-label2 formula-spacer" colspan="3">
<str id="ninerepeating1">
<a href="http://www.blizzard.com/press/040401.shtml">0,999... =</a>
</str>
</td><td class="formula-spacer" colspan="3" style="padding-left:0;">
<str id="ninerepeating2">
<a href="http://www.blizzard.com/press/040401.shtml">1</a>
</str>
</td>
</tr>
<tr>
<td class="formula-label1">
<str id="formula.ifrating">Si <span class="ratingcolor">puntuaci&oacute;n</span>
</str> &gt; 1500</td><td>&rarr;</td><td class="formula-label2"><span class="pointscolor">Puntos</span> =</td><td class="lfloor"></td><td class="formula-division">
<div>1511,26</div>
<div class="hr">
<hr>
</div>
<div>1 + 1639,28 &times; 2,71828 <sup>-0,00412 &times; <span class="ratingcolor">Puntuaci&oacute;n</span></sup>
</div>
</td><td class="rfloor"></td>
</tr>
</table>
</div>
<div class="penalty">
<table>
<tr>
<td class="penalty-title">
<str id="penalty.title">Penalizaciones:</str>
</td><td>
<str id="penalty.two">Los equipos 2c2 ganan un <strong>76%</strong> de los puntos obtenidos por un equipo 5c5 que tenga la misma puntuaci&oacute;n.</str>
</td>
</tr>
<tr>
<td></td><td>
<str id="penalty.three">Los equipos 3c3 ganan un <strong>88%</strong> de los puntos obtenidos por un equipo 5c5 que tenga la misma puntuaci&oacute;n.</str>
</td>
</tr>
</table>
</div>
</div>
</div>
<script type="text/javascript">
{literal}
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
	for (var i = 0; i < tempArray.length; i++) {
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
		if (diff >= 0) {
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
	
	if (isNaN(theRatingUsed) || theRatingUsed < 1500) 
		theRatingUsed = 1500;
		
	if (theRatingUsed <= 0) {
		return 0;
	} else if (theRatingUsed <= 1500) {
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
	if (havePoints > 5000) {
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
	} else if (inputArmorCost == 0 && document.getElementById('inputRatingPointsNeeded').value == 0){
	} else if (isNaN(armorCost)) {
		document.getElementById('inputArmorCost').value = points;
		document.getElementById('inputArmorCostGoal').value = points;
	} else {
		document.getElementById('inputArmorCost').value = armorCost;
		document.getElementById('inputArmorCostGoal').value = armorCost;
	}
		
	for (var i = 1; i <= displayNumWeeks; i++) {
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
	if (points <= 261) {
    	pointsArray[0] = Math.floor(((eval(points) / (1 - .24) - 14)/0.22)) - 2;
	} else {
    	pointsArray[0] = Math.ceil((Math.log((1511.26/(points / (1 - .24)) - 1)/1639.28))/(Math.log(2.71828))/-0.00412);
	}

//3v3
	if (points <= 303) {
    	pointsArray[1] = Math.floor(((eval(points) / (1 - .12) - 14)/0.22)) - 2;	
	} else {
    	pointsArray[1] = Math.ceil((Math.log((1511.26/(points / (1 - .12)) - 1)/1639.28))/(Math.log(2.71828))/-0.00412);	
	}
	
	
//5v5	
	if (points <= 344) {
    	pointsArray[2] = Math.floor((eval(points) - 14)/0.22) - 2;
	} else {
    	pointsArray[2] = Math.ceil((Math.log((1511.26/points - 1)/1639.28))/(Math.log(2.71828))/-0.00412);
	}
	
	if (pointsArray[0] < 0)
		pointsArray[0] = 0;
	if (pointsArray[1] < 0)
		pointsArray[1] = 0;
	if (pointsArray[2] < 0)
		pointsArray[2] = 0;				

	if (isNaN(pointsArray[0]))
		pointsArray[0] = "imposible";
	if (isNaN(pointsArray[1]))
		pointsArray[1] = "imposible";
	if (isNaN(pointsArray[2]))
		pointsArray[2] = "imposible";
	
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
			document.getElementById('replaceTwoGoal').innerHTML = "0 semanas";
			document.getElementById('replaceThreeGoal').innerHTML = "0 semanas";
			document.getElementById('replaceFiveGoal').innerHTML = "0 semanas";
		}		
	}
}

function calcDiffGoal() {
	var armorCost = document.getElementById('inputArmorCostGoal').value;
	var currentPoints = document.getElementById('inputCurrentPointsGoal').value;
	var averageRating = document.getElementById('inputAverageRatingGoal').value;	
	
	var diff = armorCost - currentPoints;	
	
	if (diff <= 0)
		diff = 0;
	
	if (diff >= 0) {
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

	
		$('#hideLegend7').removeClass('itemson');
	
		$('#hideLegend6').removeClass('itemson');
	
		$('#hideLegend5').removeClass('itemson');
	
		$('#hideLegend4').removeClass('itemson');
	

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
	
		$('#hideLegend7').addClass('itemson');
	
		$('#hideLegend6').addClass('itemson');
	
		$('#hideLegend5').addClass('itemson');
	
		$('#hideLegend4').addClass('itemson');
	
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
//
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

   


//

var gTotalSeasons = 7;
document.getElementById('hideLegend'+gTotalSeasons).style.display = "block";

var gBaseArenaPoints = 0;
document.getElementById("inputRating").value = gBaseArenaPoints;
document.getElementById("inputAverageRatingGoal").value = gBaseArenaPoints;

calcPoints(gBaseArenaPoints);

if (Browser.opera || Browser.safari)
	document.getElementById('hideOpera').style.display = "none";
{/literal}
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
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{include file="faq_arenacalc.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}