<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<link href="_css/tools/talent-calc.css" rel="stylesheet" type="text/css" />
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="tab" id="tab_talentCalculator">
<a href="talent-calc.xml">{#armory_talent_calc_talents_calc#}</a>
</div>
<div class="selected-tab" id="tab_petTalentCalculator">
<a href="talent-calc.xml?pid=-1">{#armory_talent_calc_pet_talents#}</a>
</div>
<div class="tab" id="tab_arenaCalculator">
<a href="arena-calculator.xml">{#armory_talent_calc_arena_calc#}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="" href="talent-calc.xml?pid=-1" id="Ferocity_subTab" onclick="petTalentCalc.changePetTree(0); return false"><span>Ferocidad</span></a>
<a class="" href="talent-calc.xml?pid=-2" id="Tenacity_subTab" onclick="petTalentCalc.changePetTree(1); return false"><span>Tenacidad</span></a>
<a class="" href="talent-calc.xml?pid=-3" id="Cunning_subTab" onclick="petTalentCalc.changePetTree(2); return false"><span>Astucia</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="petTalentCalcBg">
<div class="talentCalcFooter">
<script src="_js/tools/talent-calc.js" type="text/javascript"></script>
<script type="text/javascript">
		var talentData_tkwen68 = [
{literal}		
			{
				id:   "Ferocity",
				name: "Ferocidad",
				talents: [
				
					{
						id:     2107,
						tier:   0,
						column: 0,
						name:  "Reflejos de cobra",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Aumenta la velocidad de ataque de tu mascota un 15%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							,
							"Aumenta la velocidad de ataque de tu mascota un 30%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							
						]
					}
					,
					{
						id:     2109,
						tier:   0,
						column: 1,
						name:  "Carrerilla",
						icon:  "ability_druid_dash",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Aumenta la velocidad de movimiento de tu mascota un 80% durante 16 s."
							
						]
					}
					,
					{
						id:     2203,
						tier:   0,
						column: 1,
						name:  "En picado",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Aumenta la velocidad de movimiento de tu mascota un 80% durante 16 s."
							
						]
					}
					,
					{
						id:     2112,
						tier:   0,
						column: 2,
						name:  "Gran aguante",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Aumenta el aguante total de tu mascota un 4%."
							,
							"Aumenta el aguante total de tu mascota un 8%."
							,
							"Aumenta el aguante total de tu mascota un 12%."
							
						]
					}
					,
					{
						id:     2113,
						tier:   0,
						column: 3,
						name:  "Armadura natural",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Aumenta la armadura de tu mascota un 5%."
							,
							"Aumenta la armadura de tu mascota un 10%."
							
						]
					}
					,
					{
						id:     2124,
						tier:   1,
						column: 0,
						name:  "Agazapar mejorado",
						icon:  "ability_druid_cower",
						
						ranks: [
						
							"La penalización de velocidad de movimiento del Agazapar de tu mascota se reduce un 50%."
							,
							"La penalización de velocidad de movimiento del Agazapar de tu mascota se reduce un 100%."
							
						]
					}
					,
					{
						id:     2128,
						tier:   1,
						column: 1,
						name:  "Sediento de sangre",
						icon:  "ability_druid_primaltenacity",
						
						ranks: [
						
							"Los ataques de tu mascota tienen un 10% de probabilidad de aumentar su felicidad un 5% y de sanar el 5% de su salud total."
							,
							"Los ataques de tu mascota tienen un 20% de probabilidad de aumentar su felicidad un 5% y de sanar un 5% de su salud total."
							
						]
					}
					,
					{
						id:     2125,
						tier:   1,
						column: 2,
						name:  "Collera con pinchos",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Tu mascota inflige un 3% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 6% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 9% de daño extra con todos los ataques."
							
						]
					}
					,
					{
						id:     2151,
						tier:   1,
						column: 3,
						name:  "Velocidad de jabalí",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Aumenta un 30% la velocidad de movimiento de tu mascota."
							
						]
					}
					,
					{
						id:     2106,
						tier:   2,
						column: 0,
						name:  "Desvieje de la manada",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 1% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 2% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 3% de daño aumentado durante 10 s."
							
						]
					}
					,
					{
						id:     2152,
						tier:   2,
						column: 2,
						name:  "Corazón de león",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 15%."
							,
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 30%."
							
						]
					}
					,
					{
						id:     2111,
						tier:   2,
						column: 3,
						name:  "Cargar",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Tu mascota carga contra un enemigo, inmovilizándolo durante 1 s, y aumenta el poder de ataque cuerpo a cuerpo de tu mascota un 25% en su siguiente ataque."
							
						]
					}
					,
					{
						id:     2219,
						tier:   2,
						column: 3,
						name:  "Descenso en picado",
						icon:  "ability_hunter_pet_dragonhawk",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Tu mascota cae en picado sobre un enemigo, lo inmoviliza durante 1 s y añade un 25% de ataque cuerpo a cuerpo al siguiente ataque de la mascota."
							
						]
					}
					,
					{
						id:     2156,
						tier:   3,
						column: 1,
						name:  "Corazón del fénix",
						icon:  "inv_misc_pheonixpet_01",
						
							requires: 2128,
						
						ranks: [
						
							"Cuando tu mascota muera, volverá a la vida milagrosamente con la salud completa."
							
						]
					}
					,
					{
						id:     2129,
						tier:   3,
						column: 2,
						name:  "Picadura de araña",
						icon:  "ability_hunter_pet_spider",
						
						ranks: [
						
							"Aumenta un 3% la probabilidad de golpe crítico de tu mascota."
							,
							"Aumenta un 6% la probabilidad de golpe crítico de tu mascota."
							,
							"Aumenta un 9% la probabilidad de golpe crítico de tu mascota."
							
						]
					}
					,
					{
						id:     2154,
						tier:   3,
						column: 3,
						name:  "Gran resistencia",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Tu mascota recibe un 5% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 10% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 15% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							
						]
					}
					,
					{
						id:     2155,
						tier:   4,
						column: 0,
						name:  "Rabioso",
						icon:  "ability_druid_berserk",
						
						ranks: [
						
							"Tu mascota entra en un frenesí de muerte. Los ataques que impacten en el objetivo tienen una probabilidad de aumentar el poder de ataque un 5%. Este efecto se acumula hasta 5 veces. Dura 20 s."
							
						]
					}
					,
					{
						id:     2153,
						tier:   4,
						column: 1,
						name:  "Lame tus heridas",
						icon:  "ability_hunter_mendpet",
						
							requires: 2156,
						
						ranks: [
						
							"Tu mascota se sana un 100% de su salud total durante 5 s mientras esté canalizando."
							
						]
					}
					,
					{
						id:     2157,
						tier:   4,
						column: 2,
						name:  "Llamada de lo Salvaje",
						icon:  "ability_druid_kingofthejungle",
						
							requires: 2129,
						
						ranks: [
						
							"Tu mascota ruge, aumentando un 10% el poder de ataque cuerpo a cuerpo y a distancia de tu mascota. Dura 20 s."
							
						]
					}
					,
					{
						id:     2254,
						tier:   5,
						column: 0,
						name:  "Ataque de tiburón",
						icon:  "inv_misc_fish_35",
						
						ranks: [
						
							"Tu mascota inflige un 3% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 6% de daño extra con todos los ataques."
							
						]
					}
					,
					{
						id:     2253,
						tier:   5,
						column: 2,
						name:  "Caza salvaje",
						icon:  "inv_misc_horn_04",
						
							requires: 2157,
						
						ranks: [
						
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 20% y el poder de ataque un 15%."
							,
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 40% y el poder de ataque un 30%."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Tenacity",
				name: "Tenacidad",
				talents: [
				
					{
						id:     2114,
						tier:   0,
						column: 0,
						name:  "Reflejos de cobra",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Aumenta la velocidad de ataque de tu mascota un 15%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							,
							"Aumenta la velocidad de ataque de tu mascota un 30%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							
						]
					}
					,
					{
						id:     2237,
						tier:   0,
						column: 1,
						name:  "Cargar",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 3179210,
						
							categoryMask1: 1610612736,
						
						ranks: [
						
							"Tu mascota carga contra un enemigo, inmovilizándolo durante 1 s, y aumenta el poder de ataque cuerpo a cuerpo de tu mascota un 25% en su siguiente ataque."
							
						]
					}
					,
					{
						id:     2116,
						tier:   0,
						column: 2,
						name:  "Gran aguante",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Aumenta el aguante total de tu mascota un 4%."
							,
							"Aumenta el aguante total de tu mascota un 8%."
							,
							"Aumenta el aguante total de tu mascota un 12%."
							
						]
					}
					,
					{
						id:     2117,
						tier:   0,
						column: 3,
						name:  "Armadura natural",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Aumenta la armadura de tu mascota un 5%."
							,
							"Aumenta la armadura de tu mascota un 10%."
							
						]
					}
					,
					{
						id:     2126,
						tier:   1,
						column: 0,
						name:  "Collera con pinchos",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Tu mascota inflige un 3% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 6% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 9% de daño extra con todos los ataques."
							
						]
					}
					,
					{
						id:     2160,
						tier:   1,
						column: 1,
						name:  "Velocidad de jabalí",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Aumenta un 30% la velocidad de movimiento de tu mascota."
							
						]
					}
					,
					{
						id:     2173,
						tier:   1,
						column: 2,
						name:  "Sangre de los rinocerontes",
						icon:  "spell_shadow_lifedrain",
						
							requires: 2116,
						
						ranks: [
						
							"Aumenta el aguante total de tu mascota un 2% y aumenta todos los efectos de sanación sobre tu mascota un 20%."
							,
							"Aumenta el aguante total de tu mascota un 4% y aumenta todos los efectos de sanación sobre tu mascota un 40%."
							
						]
					}
					,
					{
						id:     2122,
						tier:   1,
						column: 3,
						name:  "Aderezar mascota",
						icon:  "inv_helmet_94",
						
							requires: 2117,
						
						ranks: [
						
							"Aumenta la armadura de tu mascota un 5% y la probabilidad de esquivar un 1%."
							,
							"Aumenta la armadura de tu mascota un 10% y la probabilidad de esquivar un 2%."
							
						]
					}
					,
					{
						id:     2110,
						tier:   2,
						column: 0,
						name:  "Desvieje de la manada",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 1% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 2% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 3% de daño aumentado durante 10 s."
							
						]
					}
					,
					{
						id:     2123,
						tier:   2,
						column: 1,
						name:  "Perro guardián",
						icon:  "ability_physical_taunt",
						
						ranks: [
						
							"Bramido de tu mascota genera un 10% de amenaza extra y un 10% de tu felicidad total."
							,
							"Bramido de tu mascota genera un 20% de amenaza extra y un 10% de tu felicidad total."
							
						]
					}
					,
					{
						id:     2162,
						tier:   2,
						column: 2,
						name:  "Corazón de león",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 15%."
							,
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 30%."
							
						]
					}
					,
					{
						id:     2277,
						tier:   2,
						column: 3,
						name:  "Pisotón de trueno",
						icon:  "ability_golemthunderclap",
						
						ranks: [
						
							"Sacude el terreno con tremenda fuerza e inflige 3-5 p. de daño de Naturaleza a todos los enemigos en un radio de 8 m. Esta facultad provoca una cantidad moderada de amenaza extra."
							
						]
					}
					,
					{
						id:     2163,
						tier:   3,
						column: 2,
						name:  "Gracia de la mantis",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Reduce la probabilidad de que tu mascota reciba un golpe crítico con ataques cuerpo a cuerpo un 2%."
							,
							"Reduce la probabilidad de que tu mascota reciba un golpe crítico con ataques cuerpo a cuerpo un 4%."
							
						]
					}
					,
					{
						id:     2161,
						tier:   3,
						column: 3,
						name:  "Gran resistencia",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Tu mascota recibe un 5% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 10% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 15% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							
						]
					}
					,
					{
						id:     2171,
						tier:   4,
						column: 0,
						name:  "Última carga",
						icon:  "spell_nature_shamanrage",
						
						ranks: [
						
							"Tu mascota gana temporalmente un 30% de su salud máxima durante 20 s. Cuando el efecto se disipa, la salud se pierde."
							
						]
					}
					,
					{
						id:     2170,
						tier:   4,
						column: 1,
						name:  "Provocar",
						icon:  "spell_nature_reincarnation",
						
							requires: 2123,
						
						ranks: [
						
							"Tu mascota provoca que el objetivo la ataque durante 3 s."
							
						]
					}
					,
					{
						id:     2172,
						tier:   4,
						column: 2,
						name:  "Rugido de sacrificio",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2163,
						
						ranks: [
						
							"Protege a un objetivo amistoso de los golpes críticos, haciendo que los ataques contra ese objetivo no puedan ser golpes críticos, pero un 20% de todo el daño recibido por ese objetivo también lo recibe la mascota. Dura 12 s."
							
						]
					}
					,
					{
						id:     2169,
						tier:   4,
						column: 3,
						name:  "Intervenir",
						icon:  "ability_hunter_pet_turtle",
						
						ranks: [
						
							"Tu mascota corre a gran velocidad hacia el miembro del grupo, interceptando el siguiente ataque a distancia o cuerpo a cuerpo hecho contra él."
							
						]
					}
					,
					{
						id:     2258,
						tier:   5,
						column: 1,
						name:  "Lomoplata",
						icon:  "ability_hunter_pet_gorilla",
						
						ranks: [
						
							"Bramido de tu mascota también sana un 1% de su salud total."
							,
							"Bramido de tu mascota también sana un 2% de su salud total."
							
						]
					}
					,
					{
						id:     2255,
						tier:   5,
						column: 2,
						name:  "Caza salvaje",
						icon:  "inv_misc_horn_04",
						
							requires: 2172,
						
						ranks: [
						
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 20% y el poder de ataque un 15%."
							,
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 40% y el poder de ataque un 30%."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Cunning",
				name: "Astucia",
				talents: [
				
					{
						id:     2118,
						tier:   0,
						column: 0,
						name:  "Reflejos de cobra",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Aumenta la velocidad de ataque de tu mascota un 15%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							,
							"Aumenta la velocidad de ataque de tu mascota un 30%. Tu mascota asestará golpes más rápido pero cada golpe infligirá menos daño."
							
						]
					}
					,
					{
						id:     2119,
						tier:   0,
						column: 1,
						name:  "Carrerilla",
						icon:  "ability_druid_dash",
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Aumenta la velocidad de movimiento de tu mascota un 80% durante 16 s."
							
						]
					}
					,
					{
						id:     2201,
						tier:   0,
						column: 1,
						name:  "En picado",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Aumenta la velocidad de movimiento de tu mascota un 80% durante 16 s."
							
						]
					}
					,
					{
						id:     2120,
						tier:   0,
						column: 2,
						name:  "Gran aguante",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Aumenta el aguante total de tu mascota un 4%."
							,
							"Aumenta el aguante total de tu mascota un 8%."
							,
							"Aumenta el aguante total de tu mascota un 12%."
							
						]
					}
					,
					{
						id:     2121,
						tier:   0,
						column: 3,
						name:  "Armadura natural",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Aumenta la armadura de tu mascota un 5%."
							,
							"Aumenta la armadura de tu mascota un 10%."
							
						]
					}
					,
					{
						id:     2165,
						tier:   1,
						column: 0,
						name:  "Velocidad de jabalí",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Aumenta un 30% la velocidad de movimiento de tu mascota."
							
						]
					}
					,
					{
						id:     2207,
						tier:   1,
						column: 1,
						name:  "Movilidad",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2119,
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Reduce el tiempo de reutilización de la facultad Carrerilla de tu mascota 8 s."
							,
							"Reduce el tiempo de reutilización de la facultad Carrerilla de tu mascota 16 s."
							
						]
					}
					,
					{
						id:     2208,
						tier:   1,
						column: 1,
						name:  "Movilidad",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2201,
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Reduce el tiempo de reutilización de la facultad En picado de tu mascota 8 s."
							,
							"Reduce el tiempo de reutilización de la facultad En picado de tu mascota 16 s."
							
						]
					}
					,
					{
						id:     2182,
						tier:   1,
						column: 2,
						name:  "Enfoque de búho",
						icon:  "ability_hunter_pet_owl",
						
						ranks: [
						
							"Tu mascota tiene un 15% de probabilidad tras usar una facultad de que la siguiente facultad no cueste enfoque si se usa en 8 s."
							,
							"Tu mascota tiene un 30% de probabilidad tras usar una facultad de que la siguiente facultad no cueste enfoque si se usa en 8 s."
							
						]
					}
					,
					{
						id:     2127,
						tier:   1,
						column: 3,
						name:  "Collera con pinchos",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Tu mascota inflige un 3% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 6% de daño extra con todos los ataques."
							,
							"Tu mascota inflige un 9% de daño extra con todos los ataques."
							
						]
					}
					,
					{
						id:     2166,
						tier:   2,
						column: 0,
						name:  "Desvieje de la manada",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 1% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 2% de daño aumentado durante 10 s."
							,
							"Cuando las facultades Zarpa, Mordedura o Bofetada de tu mascota infligen un golpe crítico, tú y tu mascota infligís un 3% de daño aumentado durante 10 s."
							
						]
					}
					,
					{
						id:     2167,
						tier:   2,
						column: 1,
						name:  "Corazón de león",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 15%."
							,
							"Reduce la duración de todos los efectos de aturdimiento y miedo que se usen contra tu mascota un 30%."
							
						]
					}
					,
					{
						id:     2206,
						tier:   2,
						column: 2,
						name:  "Carroñero",
						icon:  "ability_racial_cannibalize",
						
						ranks: [
						
							"Tu mascota puede generar salud y felicidad comiéndose un cadáver. No funcionará con los restos de criaturas elementales o mecánicas."
							
						]
					}
					,
					{
						id:     2168,
						tier:   3,
						column: 1,
						name:  "Gran resistencia",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Tu mascota recibe un 5% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 10% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							,
							"Tu mascota recibe un 15% menos de daño de la magia Arcana, de Fuego, de Escarcha, de Naturaleza y de las Sombras."
							
						]
					}
					,
					{
						id:     2177,
						tier:   3,
						column: 2,
						name:  "Arrinconado",
						icon:  "ability_hunter_survivalinstincts",
						
						ranks: [
						
							"Cuando está por debajo del 35% de salud, tu mascota inflige un 25% más de daño y tiene un 30% menos de probabilidad de recibir un golpe crítico."
							,
							"Cuando está por debajo del 35% de salud, tu mascota inflige un 50% más de daño y tiene un 60% menos de probabilidad de recibir un golpe crítico."
							
						]
					}
					,
					{
						id:     2183,
						tier:   3,
						column: 3,
						name:  "Frenesí de comida",
						icon:  "inv_misc_fish_48",
						
							requires: 2127,
						
						ranks: [
						
							"Tu mascota inflige un 8% de daño extra a los objetivos con menos del 35% de salud."
							,
							"Tu mascota inflige un 16% de daño extra a los objetivos con menos del 35% de salud."
							
						]
					}
					,
					{
						id:     2181,
						tier:   4,
						column: 0,
						name:  "Mordedura de lobezno",
						icon:  "ability_druid_lacerate",
						
						ranks: [
						
							"Un ataque feroz que inflige 5 p. de daño, modificados por el nivel de mascota, que tu mascota puede usar cuando realice un ataque crítico. No se puede esquivar, bloquear o parar."
							
						]
					}
					,
					{
						id:     2184,
						tier:   4,
						column: 1,
						name:  "Rugido de recuperación",
						icon:  "ability_druid_mastershapeshifter",
						
						ranks: [
						
							"El rugido inspirador de tu mascota restaura el 30% de tu maná total durante 9 s."
							
						]
					}
					,
					{
						id:     2175,
						tier:   4,
						column: 2,
						name:  "Cabezota",
						icon:  "ability_warrior_bullrush",
						
							requires: 2177,
						
						ranks: [
						
							"Elimina todos los efectos que reducen el movimiento y todos los efectos que provocan pérdida de control sobre tu mascota y reduce el daño infligido a tu mascota un 20% durante 12 s."
							
						]
					}
					,
					{
						id:     2257,
						tier:   4,
						column: 3,
						name:  "Gracia de la mantis",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Reduce la probabilidad de que tu mascota reciba un golpe crítico con ataques cuerpo a cuerpo un 2%."
							,
							"Reduce la probabilidad de que tu mascota reciba un golpe crítico con ataques cuerpo a cuerpo un 4%."
							
						]
					}
					,
					{
						id:     2256,
						tier:   5,
						column: 0,
						name:  "Caza salvaje",
						icon:  "inv_misc_horn_04",
						
							requires: 2181,
						
						ranks: [
						
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 20% y el poder de ataque un 15%."
							,
							"Aumenta la contribución que tu mascota obtiene de tu aguante un 40% y el poder de ataque un 30%."
							
						]
					}
					,
					{
						id:     2278,
						tier:   5,
						column: 3,
						name:  "Rugido de sacrificio",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2257,
						
						ranks: [
						
							"Protege a un objetivo amistoso de los golpes críticos, haciendo que los ataques contra ese objetivo no puedan ser golpes críticos, pero un 20% de todo el daño recibido por ese objetivo también lo recibe la mascota. Dura 12 s."
							
						]
					}
					
				]
			}
			
		];

		var petData_tkwen68 = null;
		
					petData_tkwen68 = {
					3: {
							name:  "Araña",
							tree:  "2",
							catId:  17,
							icon:  "ability_hunter_pet_spider"
						}
						,26: {
							name:  "Ave rapaz",
							tree:  "2",
							catId:  2,
							icon:  "ability_hunter_pet_owl"
						}
						,31: {
							name:  "Devastador",
							tree:  "2",
							catId:  14,
							icon:  "ability_hunter_pet_ravager"
						}
						,30: {
							name:  "Dracohalcón",
							tree:  "2",
							catId:  8,
							icon:  "ability_hunter_pet_dragonhawk"
						}
						,33: {
							name:  "Esporiélago",
							tree:  "2",
							catId:  18,
							icon:  "ability_hunter_pet_sporebat"
						}
						,24: {
							name:  "Murciélago",
							tree:  "2",
							catId:  0,
							icon:  "ability_hunter_pet_bat"
						}
						,38: {
							name:  "Quimera",
							tree:  "2",
							catId:  24,
							icon:  "ability_hunter_pet_chimera"
						}
						,34: {
							name:  "Raya abisal",
							tree:  "2",
							catId:  12,
							icon:  "ability_hunter_pet_netherray"
						}
						,35: {
							name:  "Serpiente",
							tree:  "2",
							catId:  16,
							icon:  "spell_nature_guardianward"
						}
						,27: {
							name:  "Serpiente alada",
							tree:  "2",
							catId:  22,
							icon:  "ability_hunter_pet_windserpent"
						}
						,41: {
							name:  "Silítido",
							tree:  "2",
							catId:  63,
							icon:  "ability_hunter_pet_silithid"
						}
						,32: {
							name:  "Acechador deformado",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_warpstalker"
						}
						,8: {
							name:  "Cangrejo",
							tree:  "1",
							catId:  6,
							icon:  "ability_hunter_pet_crab"
						}
						,6: {
							name:  "Crocolisco",
							tree:  "1",
							catId:  7,
							icon:  "ability_hunter_pet_crocolisk"
						}
						,20: {
							name:  "Escórpido",
							tree:  "1",
							catId:  15,
							icon:  "ability_hunter_pet_scorpid"
						}
						,9: {
							name:  "Gorila",
							tree:  "1",
							catId:  9,
							icon:  "ability_hunter_pet_gorilla"
						}
						,42: {
							name:  "Gusano",
							tree:  "1",
							catId:  62,
							icon:  "ability_hunter_pet_worm"
						}
						,5: {
							name:  "Jabalí",
							tree:  "1",
							catId:  3,
							icon:  "ability_hunter_pet_boar"
						}
						,4: {
							name:  "Oso",
							tree:  "1",
							catId:  1,
							icon:  "ability_hunter_pet_bear"
						}
						,43: {
							name:  "Rinoceronte",
							tree:  "1",
							catId:  61,
							icon:  "ability_hunter_pet_rhino"
						}
						,21: {
							name:  "Tortuga",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_turtle"
						}
						,44: {
							name:  "Avispa",
							tree:  "0",
							catId:  60,
							icon:  "ability_hunter_pet_wasp"
						}
						,46: {
							name:  "Bestia espíritu",
							tree:  "0",
							catId:  58,
							icon:  "ability_druid_primalprecision"
						}
						,45: {
							name:  "Can del Núcleo",
							tree:  "0",
							catId:  59,
							icon:  "ability_hunter_pet_corehound"
						}
						,7: {
							name:  "Carroñero",
							tree:  "0",
							catId:  4,
							icon:  "ability_hunter_pet_vulture"
						}
						,39: {
							name:  "Demosaurio",
							tree:  "0",
							catId:  25,
							icon:  "ability_hunter_pet_devilsaur"
						}
						,2: {
							name:  "Felino",
							tree:  "0",
							catId:  5,
							icon:  "ability_hunter_pet_cat"
						}
						,25: {
							name:  "Hiena",
							tree:  "0",
							catId:  10,
							icon:  "ability_hunter_pet_hyena"
						}
						,1: {
							name:  "Lobo",
							tree:  "0",
							catId:  23,
							icon:  "ability_hunter_pet_wolf"
						}
						,37: {
							name:  "Palomilla",
							tree:  "0",
							catId:  11,
							icon:  "ability_hunter_pet_moth"
						}
						,11: {
							name:  "Raptor",
							tree:  "0",
							catId:  13,
							icon:  "ability_hunter_pet_raptor"
						}
						,12: {
							name:  "Zancaalta",
							tree:  "0",
							catId:  19,
							icon:  "ability_hunter_pet_tallstrider"
						}
						
					};
				
			var textTalentBeastMasteryName = "Maestría en bestias";
			var textTalentBeastMasteryDesc = "Dominas el arte del Adiestramiento de bestias y aprendes la facultad de domesticar mascotas exóticas, sumando 4 p. a la cantidad total de p. de habilidad con mascotas.";
		
	
		var textTalentStrSingle = "Requiere {0} punto en {1}.";
		var textTalentStrPlural = "Requiere {0} puntos en {1}.";
		var textTalentRank = "Rango {0}/{1}";
		var textTalentNextRank = "Siguiente rango";
		var textTalentReqTreeTalents = "Requiere {0} puntos en talentos de {1}.";
		var textPrintableClassTalents = "{0} talentos";
		var textPrintableMinReqLevel = "Nivel mínimo necesario: {0}";
		var textPrintableReqTalentPts = "Puntos de talentos necesarios: {0}";
		var textPrintableTreeTalents = "{0} talentos";
		var textPrintablePtsPerTree = "{0} punto(s)";
		var textPrintableDontWastePaper = "Por favor, no malgastes papel";

		var petTalentCalc = new TalentCalculator();

		$(document).ready(function() { {/literal} 

			petTalentCalc.initTalentCalc(
				"{$openTree}", 
				"{$talentTree}", 
				"calc",
				"true",
				"tkwen68",
				talentData_tkwen68,
				petData_tkwen68
			);
		{literal} }); {/literal}
	</script>
<div class="calcInfo">
<a class="awesomeButton awesomeButton-exportBuild" href="#" id="linkToBuild_tkwen68"><span>
<div class="staticTip" onmouseover="setTipText('Haz clic en este enlace y luego copia la URL que aparece en la barra de direcci&oacute;n')">Enlace a esta ficha</div>
</span></a><a class="awesomeButton awesomeButton-printableVersion" href="javascript:;" onclick="petTalentCalc.showPrintableVersion()"><span>
<div>Imprimir</div>
</span></a><span class="calcInfoLeft"><b>Nivel necesario</b>&nbsp;<span class="ptsHolder" id="requiredLevel">10</span><b>Pts. utilizados</b>&nbsp;<span class="ptsHolder" id="pointsSpent">0</span><b>Pts. restantes</b>&nbsp;<span class="ptsHolder" id="pointsLeft">0</span></span><a class="petBeastMastery staticTip" href="javascript:;" id="beastMasteryToggler" onclick="petTalentCalc.toggleBeastMastery()" onmouseover="petTalentCalc.displayBeastMasteryTooltip()">+4</a>
</div>
<div class="talContainer petTalCalcContainer" id="talContainer_tkwen68">
<div class="talentFrame">
<div class="talentTreeContainer" id="Ferocity_treeContainer_tkwen68" style="display: none">
<div class="talentTree" id="Ferocity_tree_tkwen68" style="margin-right: 3px; background-image: url('images/talents/bg/small/HunterPetFerocity.jpg')">
<div class="tier">
<div class="talent staticTip col0" id="2107_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_guardianward.jpg');">
<div class="talentHolder
						" id="2107_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2107, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2107);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2107_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2109_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/ability_druid_dash.jpg');">
<div class="talentHolder
						" id="2109_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2109, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2109);">
<span id="spellInfo_2109" style="display: none;"><span style="float: left;">30 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 32 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2109_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2203_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_shadow_burningspirit.jpg');">
<div class="talentHolder
						" id="2203_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2203, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2203);">
<span id="spellInfo_2203" style="display: none;"><span style="float: left;">30 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 32 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2203_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2112_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_unyeildingstamina.jpg');">
<div class="talentHolder
						" id="2112_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2112, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2112);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2112_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2113_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_spiritarmor.jpg');">
<div class="talentHolder
						" id="2113_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2113, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2113);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2113_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2124_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_cower.jpg');">
<div class="talentHolder
						 disabled" id="2124_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2124, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2124);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2124_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2128_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_primaltenacity.jpg');">
<div class="talentHolder
						 disabled" id="2128_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2128, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2128);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2128_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2125_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_jewelry_necklace_22.jpg');">
<div class="talentHolder
						 disabled" id="2125_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2125, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2125);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2125_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2151_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_boar.jpg');">
<div class="talentHolder
						 disabled" id="2151_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2151, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2151);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2151_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2106_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_monsterhorn_06.jpg');">
<div class="talentHolder
						 disabled" id="2106_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2106, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2106);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2106_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2152_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_bannerpvp_02.jpg');">
<div class="talentHolder
						 disabled" id="2152_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2152, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2152);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2152_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2111_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_bear.jpg');">
<div class="talentHolder
						 disabled" id="2111_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2111, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2111);">
<span id="spellInfo_2111" style="display: none;"><span style="float: right;">8&nbsp;-Rango de 25 metros</span><span style="float: left;">35 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 25 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2111_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2219_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_dragonhawk.jpg');">
<div class="talentHolder
						 disabled" id="2219_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2219, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2219);">
<span id="spellInfo_2219" style="display: none;"><span style="float: right;">8&nbsp;-Rango de 25 metros</span><span style="float: left;">35 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 25 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2219_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col1" id="2156_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_pheonixpet_01.jpg');">
<div class="talentHolder
						 disabled" id="2156_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2156, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2156);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2156_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2129_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_spider.jpg');">
<div class="talentHolder
						 disabled" id="2129_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2129, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2129);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2129_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2154_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_nature_resistnature.jpg');">
<div class="talentHolder
						 disabled" id="2154_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2154, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2154);">
<span id="spellInfo_2154" style="display: none;"><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2154_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2155_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_berserk.jpg');">
<div class="talentHolder
						 disabled" id="2155_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2155, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2155);">
<span id="spellInfo_2155" style="display: none;"><span style="float: right;">Reutilizaci&oacute;n de 45 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2155_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2153_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_mendpet.jpg');">
<div class="talentHolder
						 disabled" id="2153_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2153, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2153);">
<span id="spellInfo_2153" style="display: none;"><span style="float: right;">Reutilizaci&oacute;n de 3 min.</span><span style="float: left;">Canalizado</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2153_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2157_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_kingofthejungle.jpg');">
<div class="talentHolder
						 disabled" id="2157_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2157, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2157);">
<span id="spellInfo_2157" style="display: none;"><span style="float: right;">Reutilizaci&oacute;n de 5 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2157_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2254_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_fish_35.jpg');">
<div class="talentHolder
						 disabled" id="2254_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2254, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2254);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2254_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2253_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_horn_04.jpg');">
<div class="talentHolder
						 disabled" id="2253_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2253, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2253);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2253_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/ability_druid_swipe.png) 0 0 no-repeat;">
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(0, true);"><span>Reiniciar</span></a><span id="treeName_0_tkwen68" style="font-weight: bold;">Ferocidad</span> &nbsp;<span id="treeSpent_0_tkwen68">0</span>
</div>
</div>
</div>
<div class="talentTreeContainer" id="Tenacity_treeContainer_tkwen68" style="display: none">
<div class="talentTree" id="Tenacity_tree_tkwen68" style="margin-right: 3px; background-image: url('images/talents/bg/small/HunterPetTenacity.jpg')">
<div class="tier">
<div class="talent staticTip col0" id="2114_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_guardianward.jpg');">
<div class="talentHolder
						" id="2114_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2114, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2114);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2114_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2237_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/ability_hunter_pet_bear.jpg');">
<div class="talentHolder
						" id="2237_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2237, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2237);">
<span id="spellInfo_2237" style="display: none;"><span style="float: right;">8&nbsp;-Rango de 25 metros</span><span style="float: left;">35 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 25 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2237_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2116_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_unyeildingstamina.jpg');">
<div class="talentHolder
						" id="2116_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2116, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2116);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2116_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2117_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_spiritarmor.jpg');">
<div class="talentHolder
						" id="2117_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2117, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2117);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2117_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2126_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_jewelry_necklace_22.jpg');">
<div class="talentHolder
						 disabled" id="2126_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2126, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2126);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2126_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2160_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_boar.jpg');">
<div class="talentHolder
						 disabled" id="2160_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2160, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2160);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2160_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2173_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_shadow_lifedrain.jpg');">
<div class="talentHolder
						 disabled" id="2173_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2173, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2173);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2173_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2122_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_helmet_94.jpg');">
<div class="talentHolder
						 disabled" id="2122_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2122, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2122);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2122_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2110_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_monsterhorn_06.jpg');">
<div class="talentHolder
						 disabled" id="2110_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2110, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2110);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2110_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2123_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_physical_taunt.jpg');">
<div class="talentHolder
						 disabled" id="2123_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2123, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2123);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2123_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2162_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_bannerpvp_02.jpg');">
<div class="talentHolder
						 disabled" id="2162_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2162, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2162);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2162_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2277_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_golemthunderclap.jpg');">
<div class="talentHolder
						 disabled" id="2277_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2277, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2277);">
<span id="spellInfo_2277" style="display: none;"><span style="float: right;">Cuerpo a cuerpo</span><span style="float: left;">20 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 10 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2277_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col2" id="2163_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_ahnqirajtrinket_02.jpg');">
<div class="talentHolder
						 disabled" id="2163_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2163, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2163);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2163_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2161_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_nature_resistnature.jpg');">
<div class="talentHolder
						 disabled" id="2161_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2161, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2161);">
<span id="spellInfo_2161" style="display: none;"><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2161_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2171_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_nature_shamanrage.jpg');">
<div class="talentHolder
						 disabled" id="2171_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2171, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2171);">
<span id="spellInfo_2171" style="display: none;"><span style="float: right;">Reutilizaci&oacute;n de 6 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2171_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2170_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_nature_reincarnation.jpg');">
<div class="talentHolder
						 disabled" id="2170_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2170, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2170);">
<span id="spellInfo_2170" style="display: none;"><span style="float: left;">Cuerpo a cuerpo</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 3 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2170_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2172_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_demoralizingroar.jpg');">
<div class="talentHolder
						 disabled" id="2172_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2172, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2172);">
<span id="spellInfo_2172" style="display: none;"><span style="float: left;">Rango de 40 metros</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 1 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2172_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2169_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_turtle.jpg');">
<div class="talentHolder
						 disabled" id="2169_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2169, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2169);">
<span id="spellInfo_2169" style="display: none;"><span style="float: right;">8&nbsp;-Rango de 25 metros</span><span style="float: left;">20 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 30 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2169_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col1" id="2258_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_gorilla.jpg');">
<div class="talentHolder
						 disabled" id="2258_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2258, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2258);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2258_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2255_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_horn_04.jpg');">
<div class="talentHolder
						 disabled" id="2255_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2255, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2255);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2255_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/ability_hunter_pet_bear.png) 0 0 no-repeat;">
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(1, true);"><span>Reiniciar</span></a><span id="treeName_1_tkwen68" style="font-weight: bold;">Tenacidad</span> &nbsp;<span id="treeSpent_1_tkwen68">0</span>
</div>
</div>
</div>
<div class="talentTreeContainer" id="Cunning_treeContainer_tkwen68" style="display: none">
<div class="talentTree" id="Cunning_tree_tkwen68" style="margin-right: 3px; background-image: url('images/talents/bg/small/HunterPetCunning.jpg')">
<div class="tier">
<div class="talent staticTip col0" id="2118_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_guardianward.jpg');">
<div class="talentHolder
						" id="2118_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2118, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2118);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2118_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2119_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/ability_druid_dash.jpg');">
<div class="talentHolder
						" id="2119_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2119, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2119);">
<span id="spellInfo_2119" style="display: none;"><span style="float: left;">30 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 32 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2119_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2201_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_shadow_burningspirit.jpg');">
<div class="talentHolder
						" id="2201_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2201, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2201);">
<span id="spellInfo_2201" style="display: none;"><span style="float: left;">30 Man&aacute;</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 32 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2201_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2120_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_unyeildingstamina.jpg');">
<div class="talentHolder
						" id="2120_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2120, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2120);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2120_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2121_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_nature_spiritarmor.jpg');">
<div class="talentHolder
						" id="2121_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2121, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2121);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2121_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2165_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_boar.jpg');">
<div class="talentHolder
						 disabled" id="2165_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2165, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2165);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2165_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2207_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_animalhandler.jpg');">
<div class="talentHolder
						 disabled" id="2207_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2207, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2207);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2207_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2208_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_animalhandler.jpg');">
<div class="talentHolder
						 disabled" id="2208_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2208, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2208);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2208_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2182_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_pet_owl.jpg');">
<div class="talentHolder
						 disabled" id="2182_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2182, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2182);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2182_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2127_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_jewelry_necklace_22.jpg');">
<div class="talentHolder
						 disabled" id="2127_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2127, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2127);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2127_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2166_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_monsterhorn_06.jpg');">
<div class="talentHolder
						 disabled" id="2166_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2166, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2166);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2166_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2167_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_bannerpvp_02.jpg');">
<div class="talentHolder
						 disabled" id="2167_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2167, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2167);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2167_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2206_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_racial_cannibalize.jpg');">
<div class="talentHolder
						 disabled" id="2206_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2206, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2206);">
<span id="spellInfo_2206" style="display: none;"><span style="float: left;">Cuerpo a cuerpo</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 30 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2206_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col1" id="2168_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/spell_nature_resistnature.jpg');">
<div class="talentHolder
						 disabled" id="2168_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2168, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2168);">
<span id="spellInfo_2168" style="display: none;"><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2168_numPoints_tkwen68">0</span><span>/</span><span>3</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2177_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_hunter_survivalinstincts.jpg');">
<div class="talentHolder
						 disabled" id="2177_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2177, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2177);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2177_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2183_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_fish_48.jpg');">
<div class="talentHolder
						 disabled" id="2183_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2183, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2183);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2183_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2181_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_lacerate.jpg');">
<div class="talentHolder
						 disabled" id="2181_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2181, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2181);">
<span id="spellInfo_2181" style="display: none;"><span style="float: left;">Cuerpo a cuerpo</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 10 seg.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2181_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2184_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_mastershapeshifter.jpg');">
<div class="talentHolder
						 disabled" id="2184_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2184, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2184);">
<span id="spellInfo_2184" style="display: none;"><span style="float: left;">Rango de 40 metros</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 3 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2184_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col2" id="2175_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_warrior_bullrush.jpg');">
<div class="talentHolder
						 disabled" id="2175_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2175, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2175);">
<span id="spellInfo_2175" style="display: none;"><span style="float: right;">Reutilizaci&oacute;n de 3 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2175_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2257_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_ahnqirajtrinket_02.jpg');">
<div class="talentHolder
						 disabled" id="2257_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2257, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2257);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2257_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
</div>
<div class="tier">
<div class="talent staticTip col0" id="2256_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/inv_misc_horn_04.jpg');">
<div class="talentHolder
						 disabled" id="2256_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2256, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2256);">
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2256_numPoints_tkwen68">0</span><span>/</span><span>2</span>
</div>
</div>
</div>
<div class="talent staticTip col3" id="2278_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/grey/ability_druid_demoralizingroar.jpg');">
<div class="talentHolder
						 disabled" id="2278_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2278, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2278);">
<span id="spellInfo_2278" style="display: none;"><span style="float: left;">Rango de 40 metros</span>
<br>
<span style="float: right;">Reutilizaci&oacute;n de 1 min.</span><span style="float: left;">Instant&aacute;neo</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2278_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/ability_hunter_combatexperience.png) 0 0 no-repeat;">
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(2, true);"><span>Reiniciar</span></a><span id="treeName_2_tkwen68" style="font-weight: bold;">Astucia</span> &nbsp;<span id="treeSpent_2_tkwen68">0</span>
</div>
</div>
</div>
</div>
</div>
<div class="petFamilies" id="petFamilies">
<div class="petGroup" id="0_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(0)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Ferocidad</h4>
<div class="petFamily staticTip" id="44_family" onclick="petTalentCalc.changePetTree(0, 44, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(44)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wasp.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="46_family" onclick="petTalentCalc.changePetTree(0, 46, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(46)" style="background-image: url(wow-icons/_images/43x43/ability_druid_primalprecision.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="45_family" onclick="petTalentCalc.changePetTree(0, 45, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(45)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_corehound.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="7_family" onclick="petTalentCalc.changePetTree(0, 7, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(7)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_vulture.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="39_family" onclick="petTalentCalc.changePetTree(0, 39, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(39)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_devilsaur.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="2_family" onclick="petTalentCalc.changePetTree(0, 2, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(2)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_cat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="25_family" onclick="petTalentCalc.changePetTree(0, 25, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(25)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_hyena.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="1_family" onclick="petTalentCalc.changePetTree(0, 1, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(1)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wolf.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="37_family" onclick="petTalentCalc.changePetTree(0, 37, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(37)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_moth.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="11_family" onclick="petTalentCalc.changePetTree(0, 11, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(11)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_raptor.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="12_family" onclick="petTalentCalc.changePetTree(0, 12, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(12)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_tallstrider.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
</div>
<div class="petGroup" id="1_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(1)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Tenacidad</h4>
<div class="petFamily staticTip" id="32_family" onclick="petTalentCalc.changePetTree(1, 32, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(32)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_warpstalker.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="8_family" onclick="petTalentCalc.changePetTree(1, 8, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(8)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crab.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="6_family" onclick="petTalentCalc.changePetTree(1, 6, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(6)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crocolisk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="20_family" onclick="petTalentCalc.changePetTree(1, 20, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(20)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_scorpid.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="9_family" onclick="petTalentCalc.changePetTree(1, 9, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(9)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_gorilla.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="42_family" onclick="petTalentCalc.changePetTree(1, 42, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(42)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_worm.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="5_family" onclick="petTalentCalc.changePetTree(1, 5, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(5)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_boar.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="4_family" onclick="petTalentCalc.changePetTree(1, 4, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(4)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bear.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="43_family" onclick="petTalentCalc.changePetTree(1, 43, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(43)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_rhino.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="21_family" onclick="petTalentCalc.changePetTree(1, 21, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(21)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_turtle.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
</div>
<div class="petGroup" id="2_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(2)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Astucia</h4>
<div class="petFamily staticTip" id="3_family" onclick="petTalentCalc.changePetTree(2, 3, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(3)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_spider.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="26_family" onclick="petTalentCalc.changePetTree(2, 26, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(26)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_owl.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="31_family" onclick="petTalentCalc.changePetTree(2, 31, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(31)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_ravager.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="30_family" onclick="petTalentCalc.changePetTree(2, 30, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(30)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_dragonhawk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="33_family" onclick="petTalentCalc.changePetTree(2, 33, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(33)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_sporebat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="24_family" onclick="petTalentCalc.changePetTree(2, 24, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(24)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="38_family" onclick="petTalentCalc.changePetTree(2, 38, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(38)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_chimera.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="34_family" onclick="petTalentCalc.changePetTree(2, 34, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(34)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_netherray.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="35_family" onclick="petTalentCalc.changePetTree(2, 35, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(35)" style="background-image: url(wow-icons/_images/43x43/spell_nature_guardianward.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="27_family" onclick="petTalentCalc.changePetTree(2, 27, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(27)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_windserpent.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="41_family" onclick="petTalentCalc.changePetTree(2, 41, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(41)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_silithid.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
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
<petTalentTabs>
<petTalentTab key="Cunning" name="Astucia" order="2">
<family catId="17" icon="ability_hunter_pet_spider" id="3" name="Ara&ntilde;a"></family>
<family catId="2" icon="ability_hunter_pet_owl" id="26" name="Ave rapaz"></family>
<family catId="14" icon="ability_hunter_pet_ravager" id="31" name="Devastador"></family>
<family catId="8" icon="ability_hunter_pet_dragonhawk" id="30" name="Dracohalc&oacute;n"></family>
<family catId="18" icon="ability_hunter_pet_sporebat" id="33" name="Espori&eacute;lago"></family>
<family catId="0" icon="ability_hunter_pet_bat" id="24" name="Murci&eacute;lago"></family>
<family catId="24" icon="ability_hunter_pet_chimera" id="38" name="Quimera"></family>
<family catId="12" icon="ability_hunter_pet_netherray" id="34" name="Raya abisal"></family>
<family catId="16" icon="spell_nature_guardianward" id="35" name="Serpiente"></family>
<family catId="22" icon="ability_hunter_pet_windserpent" id="27" name="Serpiente alada"></family>
<family catId="63" icon="ability_hunter_pet_silithid" id="41" name="Sil&iacute;tido"></family>
</petTalentTab>
<petTalentTab key="Tenacity" name="Tenacidad" order="1">
<family catId="21" icon="ability_hunter_pet_warpstalker" id="32" name="Acechador deformado"></family>
<family catId="6" icon="ability_hunter_pet_crab" id="8" name="Cangrejo"></family>
<family catId="7" icon="ability_hunter_pet_crocolisk" id="6" name="Crocolisco"></family>
<family catId="15" icon="ability_hunter_pet_scorpid" id="20" name="Esc&oacute;rpido"></family>
<family catId="9" icon="ability_hunter_pet_gorilla" id="9" name="Gorila"></family>
<family catId="62" icon="ability_hunter_pet_worm" id="42" name="Gusano"></family>
<family catId="3" icon="ability_hunter_pet_boar" id="5" name="Jabal&iacute;"></family>
<family catId="1" icon="ability_hunter_pet_bear" id="4" name="Oso"></family>
<family catId="61" icon="ability_hunter_pet_rhino" id="43" name="Rinoceronte"></family>
<family catId="21" icon="ability_hunter_pet_turtle" id="21" name="Tortuga"></family>
</petTalentTab>
<petTalentTab key="Ferocity" name="Ferocidad" order="0">
<family catId="60" icon="ability_hunter_pet_wasp" id="44" name="Avispa"></family>
<family catId="58" icon="ability_druid_primalprecision" id="46" name="Bestia esp&iacute;ritu"></family>
<family catId="59" icon="ability_hunter_pet_corehound" id="45" name="Can del N&uacute;cleo"></family>
<family catId="4" icon="ability_hunter_pet_vulture" id="7" name="Carro&ntilde;ero"></family>
<family catId="25" icon="ability_hunter_pet_devilsaur" id="39" name="Demosaurio"></family>
<family catId="5" icon="ability_hunter_pet_cat" id="2" name="Felino"></family>
<family catId="10" icon="ability_hunter_pet_hyena" id="25" name="Hiena"></family>
<family catId="23" icon="ability_hunter_pet_wolf" id="1" name="Lobo"></family>
<family catId="11" icon="ability_hunter_pet_moth" id="37" name="Palomilla"></family>
<family catId="13" icon="ability_hunter_pet_raptor" id="11" name="Raptor"></family>
<family catId="19" icon="ability_hunter_pet_tallstrider" id="12" name="Zancaalta"></family>
</petTalentTab>
</petTalentTabs>
<spells>
<spell description="Dominas el arte del Adiestramiento de bestias y aprendes la facultad de domesticar mascotas ex&oacute;ticas, sumando 4 p. a la cantidad total de p. de habilidad con mascotas." id="53270" name="Maestr&iacute;a en bestias"></spell>
</spells>
</div>
</div>
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{include file="faq_index.tpl"}
{include file="overall_right_block.tpl"}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{include file="overall_footer.tpl"}