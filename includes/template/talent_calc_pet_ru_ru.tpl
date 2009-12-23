<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<link href="_css/tools/talent-calc.css" rel="stylesheet" type="text/css">
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="tabs">
<div class="tab" id="tab_talentCalculator">
<a href="talent-calc.xml">Расчет талантов</a>
</div>
<div class="selected-tab" id="tab_petTalentCalculator">
<a href="talent-calc.xml?pid=-1">Расчет талантов питомца</a>
</div>
<div class="tab" id="tab_arenaCalculator">
<a href="arena-calculator.xml">Калькулятор Арены</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="" href="talent-calc.xml?pid=-1" id="Ferocity_subTab" onclick="petTalentCalc.changePetTree(0); return false"><span>Свирепость</span></a>
<a class="" href="talent-calc.xml?pid=-2" id="Tenacity_subTab" onclick="petTalentCalc.changePetTree(1); return false"><span>Упорство</span></a>
<a class="" href="talent-calc.xml?pid=-3" id="Cunning_subTab" onclick="petTalentCalc.changePetTree(2); return false"><span>Хитрость</span></a>
</div>
<div class="full-list">
<div class="info-pane">
<div class="petTalentCalcBg">
<div class="talentCalcFooter">
<xsl-template name="head-content">
<script src="_js/tools/talent-calc.js" type="text/javascript"></script>
</xsl-template>
<script type="text/javascript">
		var talentData_tkwen68 = [
		
			{
				id:   "Ferocity",
				name: "Свирепость",
				talents: [
				
					{
						id:     2107,
						tier:   0,
						column: 0,
						name:  "Рефлексы кобры",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Повышает скорость атаки питомца на 15%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							,
							"Повышает скорость атаки питомца на 30%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							
						]
					}
					,
					{
						id:     2203,
						tier:   0,
						column: 1,
						name:  "Пикирование",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Повышает скорость передвижения вашего питомца на 80% на 16 сек."
							
						]
					}
					,
					{
						id:     2109,
						tier:   0,
						column: 1,
						name:  "Порыв",
						icon:  "ability_druid_dash",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Повышает скорость передвижения питомца на 80% на 16 сек."
							
						]
					}
					,
					{
						id:     2112,
						tier:   0,
						column: 2,
						name:  "Выносливость",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Увеличивает общую выносливость питомца на 4%."
							,
							"Увеличивает общую выносливость питомца на 8%."
							,
							"Увеличивает общую выносливость питомца на 12%."
							
						]
					}
					,
					{
						id:     2113,
						tier:   0,
						column: 3,
						name:  "Природная броня",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Увеличивает общую броню питомца на 5%."
							,
							"Увеличивает общую броню питомца на 10%."
							
						]
					}
					,
					{
						id:     2124,
						tier:   1,
						column: 0,
						name:  "Путь к отступлению",
						icon:  "ability_druid_cower",
						
						ranks: [
						
							"Ограничение скорости, накладываемое способностью \"Попятиться\", уменьшается на 50%."
							,
							"Ограничение скорости, накладываемое способностью \"Попятиться\", уменьшается на 100%."
							
						]
					}
					,
					{
						id:     2128,
						tier:   1,
						column: 1,
						name:  "Жажда крови",
						icon:  "ability_druid_primaltenacity",
						
						ranks: [
						
							"С вероятностью 10% каждая атака вашего питомца может повысить ему настроение на 5% и восстановить 5% здоровья."
							,
							"С вероятностью 20% каждая атака вашего питомца может повысить ему настроение на 5% и восстановить 5% здоровья."
							
						]
					}
					,
					{
						id:     2125,
						tier:   1,
						column: 2,
						name:  "Шипастый ошейник",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Увеличивает урон, наносимый вашим питомцем, на 3%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 6%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 9%."
							
						]
					}
					,
					{
						id:     2151,
						tier:   1,
						column: 3,
						name:  "Звериная стремительность",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Повышает скорость передвижения вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2106,
						tier:   2,
						column: 0,
						name:  "Контроль популяции",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 1% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 2% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 3% на 10 сек."
							
						]
					}
					,
					{
						id:     2152,
						tier:   2,
						column: 2,
						name:  "Львиное сердце",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 15%."
							,
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2111,
						tier:   2,
						column: 3,
						name:  "Рывок",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Ваш питомец бросается на противника и обездвиживает его на 1 сек. Сила следующей атаки ближнего боя питомца возрастает на 25%."
							
						]
					}
					,
					{
						id:     2219,
						tier:   2,
						column: 3,
						name:  "Налет",
						icon:  "ability_hunter_pet_dragonhawk",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Питомец налетает на противника, обездвиживая его на 1 сек. Сила следующей атаки ближнего боя питомца увеличивается на 25%."
							
						]
					}
					,
					{
						id:     2156,
						tier:   3,
						column: 1,
						name:  "Сердце феникса",
						icon:  "inv_misc_pheonixpet_01",
						
							requires: 2128,
						
						ranks: [
						
							"После смерти ваш питомец чудесным образом воскресает с полным запасом здоровья."
							
						]
					}
					,
					{
						id:     2129,
						tier:   3,
						column: 2,
						name:  "Укус паука",
						icon:  "ability_hunter_pet_spider",
						
						ranks: [
						
							"Повышает вероятность того, что ваш питомец нанесет критический удар, на 3%."
							,
							"Повышает вероятность того, что ваш питомец нанесет критический удар, на 6%."
							,
							"Повышает вероятность того, что ваш питомец нанесет критический удар, на 9%."
							
						]
					}
					,
					{
						id:     2154,
						tier:   3,
						column: 3,
						name:  "Сильное сопротивление",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Ваш питомец получает на 5% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 10% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 15% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							
						]
					}
					,
					{
						id:     2155,
						tier:   4,
						column: 0,
						name:  "Раж",
						icon:  "ability_druid_berserk",
						
						ranks: [
						
							"Ваш питомец впадает в боевое исступление. Его удары, достигшие цели, могут повысить силу атаки еще на 5%. Эффект суммируется до 5 раз. Время действия – 20 сек."
							
						]
					}
					,
					{
						id:     2153,
						tier:   4,
						column: 1,
						name:  "Зализывание ран",
						icon:  "ability_hunter_mendpet",
						
							requires: 2156,
						
						ranks: [
						
							"Ваш питомец восстанавливает 100% здоровья в течение 5 сек. при поддержании эффекта."
							
						]
					}
					,
					{
						id:     2157,
						tier:   4,
						column: 2,
						name:  "Зов дикой природы",
						icon:  "ability_druid_kingofthejungle",
						
							requires: 2129,
						
						ranks: [
						
							"Ваш питомец издает рык, увеличающий его и вашу силу атаки ближнего и дальнего боя на 10%. Время действия – 20 сек."
							
						]
					}
					,
					{
						id:     2254,
						tier:   5,
						column: 0,
						name:  "Акульи челюсти",
						icon:  "inv_misc_fish_35",
						
						ranks: [
						
							"Все атаки питомца наносят 3% дополнительного урона."
							,
							"Все атаки питомца наносят 6% дополнительного урона."
							
						]
					}
					,
					{
						id:     2253,
						tier:   5,
						column: 2,
						name:  "Жестокая травля",
						icon:  "inv_misc_horn_04",
						
							requires: 2157,
						
						ranks: [
						
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 20% и 15% соответственно."
							,
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 40% и 30% соответственно."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Tenacity",
				name: "Упорство",
				talents: [
				
					{
						id:     2114,
						tier:   0,
						column: 0,
						name:  "Рефлексы кобры",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Повышает скорость атаки питомца на 15%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							,
							"Повышает скорость атаки питомца на 30%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							
						]
					}
					,
					{
						id:     2237,
						tier:   0,
						column: 1,
						name:  "Рывок",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 3179210,
						
							categoryMask1: 1610612736,
						
						ranks: [
						
							"Ваш питомец бросается на противника и обездвиживает его на 1 сек. Сила следующей атаки ближнего боя питомца возрастает на 25%."
							
						]
					}
					,
					{
						id:     2116,
						tier:   0,
						column: 2,
						name:  "Выносливость",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Увеличивает общую выносливость питомца на 4%."
							,
							"Увеличивает общую выносливость питомца на 8%."
							,
							"Увеличивает общую выносливость питомца на 12%."
							
						]
					}
					,
					{
						id:     2117,
						tier:   0,
						column: 3,
						name:  "Природная броня",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Увеличивает общую броню питомца на 5%."
							,
							"Увеличивает общую броню питомца на 10%."
							
						]
					}
					,
					{
						id:     2126,
						tier:   1,
						column: 0,
						name:  "Шипастый ошейник",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Увеличивает урон, наносимый вашим питомцем, на 3%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 6%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 9%."
							
						]
					}
					,
					{
						id:     2160,
						tier:   1,
						column: 1,
						name:  "Звериная стремительность",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Повышает скорость передвижения вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2173,
						tier:   1,
						column: 2,
						name:  "Кровь люторога",
						icon:  "spell_shadow_lifedrain",
						
							requires: 2116,
						
						ranks: [
						
							"Увеличивает выносливость вашего питомца на 2% и усиливает исцеляющие эффекты на 20%."
							,
							"Увеличивает выносливость вашего питомца на 4% и усиливает исцеляющие эффекты на 40%."
							
						]
					}
					,
					{
						id:     2122,
						tier:   1,
						column: 3,
						name:  "Звериный доспех",
						icon:  "inv_helmet_94",
						
							requires: 2117,
						
						ranks: [
						
							"Увеличивает показатель брони питомца на 5%, а вероятность уклонения – на 1%."
							,
							"Увеличивает показатель брони питомца на 10%, а вероятность уклонения – на 2%."
							
						]
					}
					,
					{
						id:     2110,
						tier:   2,
						column: 0,
						name:  "Контроль популяции",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 1% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 2% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 3% на 10 сек."
							
						]
					}
					,
					{
						id:     2123,
						tier:   2,
						column: 1,
						name:  "Сторожевой пес",
						icon:  "ability_physical_taunt",
						
						ranks: [
						
							"Угроза, создаваемая питомцем при использовании способности \"Рык\", повышается на 10%. Кроме того, использование этой способности улучшает его настроение на 10%."
							,
							"Угроза, создаваемая питомцем при использовании способности \"Рык\", повышается на 20%. Кроме того, использование этой способности улучшает его настроение на 10%."
							
						]
					}
					,
					{
						id:     2162,
						tier:   2,
						column: 2,
						name:  "Львиное сердце",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 15%."
							,
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2277,
						tier:   2,
						column: 3,
						name:  "Громовая поступь",
						icon:  "ability_golemthunderclap",
						
						ranks: [
						
							"Грохот, сотрясающий землю и наносящий 3 - 5 ед. урона от сил природы всем противникам в пределах 8 м. Эта способность немного увеличивает уровень угрозы."
							
						]
					}
					,
					{
						id:     2163,
						tier:   3,
						column: 2,
						name:  "Верткость богомола",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Снижает вероятность того, что ваш питомец получит критический удар в ближнем бою, на 2%."
							,
							"Снижает вероятность того, что ваш питомец получит критический удар в ближнем бою, на 4%."
							
						]
					}
					,
					{
						id:     2161,
						tier:   3,
						column: 3,
						name:  "Сильное сопротивление",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Ваш питомец получает на 5% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 10% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 15% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							
						]
					}
					,
					{
						id:     2171,
						tier:   4,
						column: 0,
						name:  "Ни шагу назад",
						icon:  "spell_nature_shamanrage",
						
						ranks: [
						
							"Максимальный запас здоровья вашего питомца повышается на 30% на 20 сек. По окончании действия эффекта дополнительное здоровье теряется."
							
						]
					}
					,
					{
						id:     2170,
						tier:   4,
						column: 1,
						name:  "Провокация",
						icon:  "spell_nature_reincarnation",
						
							requires: 2123,
						
						ranks: [
						
							"Ваш питомец провоцирует противника атаковать его в течение 3 сек."
							
						]
					}
					,
					{
						id:     2172,
						tier:   4,
						column: 2,
						name:  "Рев самопожертвования",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2163,
						
						ranks: [
						
							"Защищает союзника от критических ударов. Атаки против него не могут иметь критического эффекта, но 20% всего урона также получает питомец. Время действия – 12 сек."
							
						]
					}
					,
					{
						id:     2169,
						tier:   4,
						column: 3,
						name:  "Вмешательство",
						icon:  "ability_hunter_pet_turtle",
						
						ranks: [
						
							"Ваш питомец бросается к участнику вашей группы, принимая на себя следующую атаку ближнего или дальнего боя, направленную против него."
							
						]
					}
					,
					{
						id:     2258,
						tier:   5,
						column: 1,
						name:  "Вожак",
						icon:  "ability_hunter_pet_gorilla",
						
						ranks: [
						
							"Издавая рык, питомец восстанавливает 1% от общего объема своего здоровья."
							,
							"Издавая рык, питомец восстанавливает 2% от общего объема своего здоровья."
							
						]
					}
					,
					{
						id:     2255,
						tier:   5,
						column: 2,
						name:  "Жестокая травля",
						icon:  "inv_misc_horn_04",
						
							requires: 2172,
						
						ranks: [
						
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 20% и 15% соответственно."
							,
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 40% и 30% соответственно."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Cunning",
				name: "Хитрость",
				talents: [
				
					{
						id:     2118,
						tier:   0,
						column: 0,
						name:  "Рефлексы кобры",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Повышает скорость атаки питомца на 15%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							,
							"Повышает скорость атаки питомца на 30%. Ваш питомец будет сражаться быстрее, но каждый удар будет наносить меньше урона."
							
						]
					}
					,
					{
						id:     2201,
						tier:   0,
						column: 1,
						name:  "Пикирование",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Повышает скорость передвижения вашего питомца на 80% на 16 сек."
							
						]
					}
					,
					{
						id:     2119,
						tier:   0,
						column: 1,
						name:  "Порыв",
						icon:  "ability_druid_dash",
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Повышает скорость передвижения питомца на 80% на 16 сек."
							
						]
					}
					,
					{
						id:     2120,
						tier:   0,
						column: 2,
						name:  "Выносливость",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Увеличивает общую выносливость питомца на 4%."
							,
							"Увеличивает общую выносливость питомца на 8%."
							,
							"Увеличивает общую выносливость питомца на 12%."
							
						]
					}
					,
					{
						id:     2121,
						tier:   0,
						column: 3,
						name:  "Природная броня",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Увеличивает общую броню питомца на 5%."
							,
							"Увеличивает общую броню питомца на 10%."
							
						]
					}
					,
					{
						id:     2165,
						tier:   1,
						column: 0,
						name:  "Звериная стремительность",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Повышает скорость передвижения вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2208,
						tier:   1,
						column: 1,
						name:  "Подвижность",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2201,
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Сокращает время восстановления способности питомца \"Пикирование\" на 8 с."
							,
							"Сокращает время восстановления способности питомца \"Пикирование\" на 16 с."
							
						]
					}
					,
					{
						id:     2207,
						tier:   1,
						column: 1,
						name:  "Подвижность",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2119,
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Сокращает время восстановления способности питомца \"Пикирование\" на 8 с."
							,
							"Сокращает время восстановления способности питомца \"Пикирование\" на 16 с."
							
						]
					}
					,
					{
						id:     2182,
						tier:   1,
						column: 2,
						name:  "Совиное внимание",
						icon:  "ability_hunter_pet_owl",
						
						ranks: [
						
							"С вероятностью 15% следующая способность вашего питомца будет применена без затрат тонуса, если предыдущая способность использовалась менее 8 сек. назад."
							,
							"С вероятностью 30% следующая способность вашего питомца будет применена без затрат тонуса, если предыдущая способность использовалась менее 8 сек. назад."
							
						]
					}
					,
					{
						id:     2127,
						tier:   1,
						column: 3,
						name:  "Шипастый ошейник",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Увеличивает урон, наносимый вашим питомцем, на 3%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 6%."
							,
							"Увеличивает урон, наносимый вашим питомцем, на 9%."
							
						]
					}
					,
					{
						id:     2166,
						tier:   2,
						column: 0,
						name:  "Контроль популяции",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 1% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 2% на 10 сек."
							,
							"Когда ваш питомец наносит критический удар способностями \"Цапнуть\", \"Укус\" или \"Хлопок\", урон, наносимый вами и вашим питомцем, повышается на 3% на 10 сек."
							
						]
					}
					,
					{
						id:     2167,
						tier:   2,
						column: 1,
						name:  "Львиное сердце",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 15%."
							,
							"Сокращает время действия всех эффектов оглушения и страха на вашего питомца на 30%."
							
						]
					}
					,
					{
						id:     2206,
						tier:   2,
						column: 2,
						name:  "Падальщик",
						icon:  "ability_racial_cannibalize",
						
						ranks: [
						
							"Ваш питомец приобретает способность есть трупы. При этом у него восстанавливается здоровье и улучшается настроение. Останки элементалей и механических существ не могут быть съедены."
							
						]
					}
					,
					{
						id:     2168,
						tier:   3,
						column: 1,
						name:  "Сильное сопротивление",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Ваш питомец получает на 5% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 10% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							,
							"Ваш питомец получает на 15% меньше урона от огня, сил природы, магии льда, тайной и темной магии."
							
						]
					}
					,
					{
						id:     2177,
						tier:   3,
						column: 2,
						name:  "Загнанный зверь",
						icon:  "ability_hunter_survivalinstincts",
						
						ranks: [
						
							"Когда уровень здоровья вашего питомца опускается ниже 35%, наносимый им урон увеличивается на 25%, а вероятность того, что он получит критический урон, понижается на 30%."
							,
							"Когда уровень здоровья вашего питомца опускается ниже 35%, наносимый им урон увеличивается на 50%, а вероятность того, что он получит критический урон, понижается на 60%."
							
						]
					}
					,
					{
						id:     2183,
						tier:   3,
						column: 3,
						name:  "Жажда мяса",
						icon:  "inv_misc_fish_48",
						
							requires: 2127,
						
						ranks: [
						
							"Ваш питомец наносит дополнительно 8% урона противникам с уровнем здоровья ниже 35%."
							,
							"Ваш питомец наносит дополнительно 16% урона противникам с уровнем здоровья ниже 35%."
							
						]
					}
					,
					{
						id:     2181,
						tier:   4,
						column: 0,
						name:  "Укус росомахи",
						icon:  "ability_druid_lacerate",
						
						ranks: [
						
							"После того, как ваш питомец наносит критический удар, он может яростно укусить противника, нанеся 5 ед. урона. Урон зависит от уровня питомца. Эту атаку невозможно парировать или блокировать, от нее нельзя уклониться."
							
						]
					}
					,
					{
						id:     2184,
						tier:   4,
						column: 1,
						name:  "Рев восстановления",
						icon:  "ability_druid_mastershapeshifter",
						
						ranks: [
						
							"Ваш питомец проникновенным ревом восполняет 30% вашего запаса маны в течение 9 сек."
							
						]
					}
					,
					{
						id:     2175,
						tier:   4,
						column: 2,
						name:  "Ослиное упрямство",
						icon:  "ability_warrior_bullrush",
						
							requires: 2177,
						
						ranks: [
						
							"Снимает все замедляющие передвижение эффекты и эффекты, вызывающие потерю контроля над питомцем. Уменьшает урон, получаемый питомцем, на 20% на 12 сек."
							
						]
					}
					,
					{
						id:     2257,
						tier:   4,
						column: 3,
						name:  "Верткость богомола",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Снижает вероятность того, что ваш питомец получит критический удар в ближнем бою, на 2%."
							,
							"Снижает вероятность того, что ваш питомец получит критический удар в ближнем бою, на 4%."
							
						]
					}
					,
					{
						id:     2256,
						tier:   5,
						column: 0,
						name:  "Жестокая травля",
						icon:  "inv_misc_horn_04",
						
							requires: 2181,
						
						ranks: [
						
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 20% и 15% соответственно."
							,
							"Повышает бонусы к выносливости и силе атаки питомца, зависящие от аналогичных параметров охотника, на 40% и 30% соответственно."
							
						]
					}
					,
					{
						id:     2278,
						tier:   5,
						column: 3,
						name:  "Рев самопожертвования",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2257,
						
						ranks: [
						
							"Защищает союзника от критических ударов. Атаки против него не могут иметь критического эффекта, но 20% всего урона также получает питомец. Время действия – 12 сек."
							
						]
					}
					
				]
			}
			
		];

		var petData_tkwen68 = null;
		
					petData_tkwen68 = {
					30: {
							name:  "Дракондор",
							tree:  "2",
							catId:  8,
							icon:  "ability_hunter_pet_dragonhawk"
						}
						,35: {
							name:  "Змей",
							tree:  "2",
							catId:  16,
							icon:  "spell_nature_guardianward"
						}
						,27: {
							name:  "Крылатый змей",
							tree:  "2",
							catId:  22,
							icon:  "ability_hunter_pet_windserpent"
						}
						,24: {
							name:  "Летучая мышь",
							tree:  "2",
							catId:  0,
							icon:  "ability_hunter_pet_bat"
						}
						,31: {
							name:  "Опустошитель",
							tree:  "2",
							catId:  14,
							icon:  "ability_hunter_pet_ravager"
						}
						,3: {
							name:  "Паук",
							tree:  "2",
							catId:  17,
							icon:  "ability_hunter_pet_spider"
						}
						,41: {
							name:  "Силитид",
							tree:  "2",
							catId:  63,
							icon:  "ability_hunter_pet_silithid"
						}
						,34: {
							name:  "Скат Пустоты",
							tree:  "2",
							catId:  12,
							icon:  "ability_hunter_pet_netherray"
						}
						,26: {
							name:  "Сова",
							tree:  "2",
							catId:  2,
							icon:  "ability_hunter_pet_owl"
						}
						,33: {
							name:  "Спороскат",
							tree:  "2",
							catId:  18,
							icon:  "ability_hunter_pet_sporebat"
						}
						,38: {
							name:  "Химера",
							tree:  "2",
							catId:  24,
							icon:  "ability_hunter_pet_chimera"
						}
						,5: {
							name:  "Вепрь",
							tree:  "1",
							catId:  3,
							icon:  "ability_hunter_pet_boar"
						}
						,9: {
							name:  "Горилла",
							tree:  "1",
							catId:  9,
							icon:  "ability_hunter_pet_gorilla"
						}
						,8: {
							name:  "Краб",
							tree:  "1",
							catId:  6,
							icon:  "ability_hunter_pet_crab"
						}
						,6: {
							name:  "Кроколиск",
							tree:  "1",
							catId:  7,
							icon:  "ability_hunter_pet_crocolisk"
						}
						,43: {
							name:  "Люторог",
							tree:  "1",
							catId:  61,
							icon:  "ability_hunter_pet_rhino"
						}
						,4: {
							name:  "Медведь",
							tree:  "1",
							catId:  1,
							icon:  "ability_hunter_pet_bear"
						}
						,32: {
							name:  "Прыгуана",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_warpstalker"
						}
						,20: {
							name:  "Скорпид",
							tree:  "1",
							catId:  15,
							icon:  "ability_hunter_pet_scorpid"
						}
						,42: {
							name:  "Червь",
							tree:  "1",
							catId:  62,
							icon:  "ability_hunter_pet_worm"
						}
						,21: {
							name:  "Черепаха",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_turtle"
						}
						,1: {
							name:  "Волк",
							tree:  "0",
							catId:  23,
							icon:  "ability_hunter_pet_wolf"
						}
						,25: {
							name:  "Гиена",
							tree:  "0",
							catId:  10,
							icon:  "ability_hunter_pet_hyena"
						}
						,45: {
							name:  "Гончая Недр",
							tree:  "0",
							catId:  59,
							icon:  "ability_hunter_pet_corehound"
						}
						,12: {
							name:  "Долгоног",
							tree:  "0",
							catId:  19,
							icon:  "ability_hunter_pet_tallstrider"
						}
						,46: {
							name:  "Дух зверя",
							tree:  "0",
							catId:  58,
							icon:  "ability_druid_primalprecision"
						}
						,39: {
							name:  "Дьявозавр",
							tree:  "0",
							catId:  25,
							icon:  "ability_hunter_pet_devilsaur"
						}
						,2: {
							name:  "Кошка",
							tree:  "0",
							catId:  5,
							icon:  "ability_hunter_pet_cat"
						}
						,37: {
							name:  "Мотылек",
							tree:  "0",
							catId:  11,
							icon:  "ability_hunter_pet_moth"
						}
						,44: {
							name:  "Оса",
							tree:  "0",
							catId:  60,
							icon:  "ability_hunter_pet_wasp"
						}
						,7: {
							name:  "Падальщик",
							tree:  "0",
							catId:  4,
							icon:  "ability_hunter_pet_vulture"
						}
						,11: {
							name:  "Ящер",
							tree:  "0",
							catId:  13,
							icon:  "ability_hunter_pet_raptor"
						}
						
					};
				
			var textTalentBeastMasteryName = "Повелитель зверей";
			var textTalentBeastMasteryDesc = "Вы в совершенстве овладеваете искусством дрессировки, получая возможность приручать экзотических питомцев. Общее количество очков умений питомца увеличивается на 4.";
		
	
		var textTalentStrSingle = "Требуется {0} очко, вложенное в {1}.";
		var textTalentStrPlural = "Требуется {0} очк., вложенных {1}.";
		var textTalentRank = "Уровень {0}/{1}";
		var textTalentNextRank = "Следующий уровень";
		var textTalentReqTreeTalents = "Требуется {0} очк., вложенных в {1}.";
		var textPrintableClassTalents = "Таланты класса \"{0}\"";
		var textPrintableMinReqLevel = "Требуется уровнь: {0}";
		var textPrintableReqTalentPts = "Требуется очков: {0}";
		var textPrintableTreeTalents = "Таланты ветки \"{0}\"";
		var textPrintablePtsPerTree = "{0} очк.";
		var textPrintableDontWastePaper = "Берегите бумагу!";

		var petTalentCalc = new TalentCalculator();

		$(document).ready(function() {

			petTalentCalc.initTalentCalc(
				"{{$openTree}}", 
				"{{$talentTree}}", 
				"calc",
				"true",
				"tkwen68",
				talentData_tkwen68,
				petData_tkwen68
			);
		});
	</script>
<div class="calcInfo">
<a class="awesomeButton awesomeButton-exportBuild" href="#" id="linkToBuild_tkwen68"><span>
<div class="staticTip" onmouseover="setTipText('Щелкните по этой ссылке и скопируйте адрес страницы в адресной строке.')">Ссылка</div>
</span></a><a class="awesomeButton awesomeButton-printableVersion" href="javascript:;" onclick="petTalentCalc.showPrintableVersion()"><span>
<div>Печать</div>
</span></a><span class="calcInfoLeft"><b>Требуется уровень</b>&nbsp;<span class="ptsHolder" id="requiredLevel">10</span><b>Потрачено очков</b>&nbsp;<span class="ptsHolder" id="pointsSpent">0</span><b>Осталось очков</b>&nbsp;<span class="ptsHolder" id="pointsLeft">0</span></span><a class="petBeastMastery staticTip" href="javascript:;" id="beastMasteryToggler" onclick="petTalentCalc.toggleBeastMastery()" onmouseover="petTalentCalc.displayBeastMasteryTooltip()">+4</a>
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
<div class="talent staticTip col1" id="2203_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_shadow_burningspirit.jpg');">
<div class="talentHolder
						" id="2203_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2203, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2203);">
<span id="spellInfo_2203" style="display: none;"><span style="float: left;">30 Мана</span>
<br>
<span style="float: right;">Восстановление: 32  сек</span><span style="float: left;"> Мгновенное действие </span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2203_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2109_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/ability_druid_dash.jpg');">
<div class="talentHolder
						" id="2109_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2109, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2109);">
<span id="spellInfo_2109" style="display: none;"><span style="float: left;">30 Мана</span>
<br>
<span style="float: right;">Восстановление: 32  сек</span><span style="float: left;"> Мгновенное действие </span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2109_numPoints_tkwen68">0</span><span>/</span><span>1</span>
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
<span id="spellInfo_2111" style="display: none;"><span style="float: right;">8&nbsp;- Радиус действия25 </span><span style="float: left;">35 Мана</span>
<br>
<span style="float: right;">Восстановление: 25  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2219" style="display: none;"><span style="float: right;">8&nbsp;- Радиус действия25 </span><span style="float: left;">35 Мана</span>
<br>
<span style="float: right;">Восстановление: 25  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2154" style="display: none;"><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2155" style="display: none;"><span style="float: right;">Восстановление: 45  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2153" style="display: none;"><span style="float: right;"> Восстановление: 3  мин</span><span style="float: left;">Потоковое</span></span>
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
<span id="spellInfo_2157" style="display: none;"><span style="float: right;"> Восстановление: 5  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(0, true);"><span>Сброс</span></a><span id="treeName_0_tkwen68" style="font-weight: bold;">Свирепость</span> &nbsp;<span id="treeSpent_0_tkwen68">0</span>
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
<span id="spellInfo_2237" style="display: none;"><span style="float: right;">8&nbsp;- Радиус действия25 </span><span style="float: left;">35 Мана</span>
<br>
<span style="float: right;">Восстановление: 25  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2277" style="display: none;"><span style="float: right;">Дистанция ближнего боя</span><span style="float: left;">20 Мана</span>
<br>
<span style="float: right;">Восстановление: 10  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2161" style="display: none;"><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2171" style="display: none;"><span style="float: right;"> Восстановление: 6  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2170" style="display: none;"><span style="float: left;">Дистанция ближнего боя</span>
<br>
<span style="float: right;"> Восстановление: 3  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2172" style="display: none;"><span style="float: left;"> Радиус действия40 </span>
<br>
<span style="float: right;"> Восстановление: 1  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2169" style="display: none;"><span style="float: right;">8&nbsp;- Радиус действия25 </span><span style="float: left;">20 Мана</span>
<br>
<span style="float: right;">Восстановление: 30  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(1, true);"><span>Сброс</span></a><span id="treeName_1_tkwen68" style="font-weight: bold;">Упорство</span> &nbsp;<span id="treeSpent_1_tkwen68">0</span>
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
<div class="talent staticTip col1" id="2201_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/spell_shadow_burningspirit.jpg');">
<div class="talentHolder
						" id="2201_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2201, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2201);">
<span id="spellInfo_2201" style="display: none;"><span style="float: left;">30 Мана</span>
<br>
<span style="float: right;">Восстановление: 32  сек</span><span style="float: left;"> Мгновенное действие </span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2201_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
<div class="talent staticTip col1" id="2119_iconHolder_tkwen68" style="background-image:url('wow-icons/_images/_talents31x31/ability_druid_dash.jpg');">
<div class="talentHolder
						" id="2119_talentHolder_tkwen68" onclick="return false" onmousedown="petTalentCalc.addTalent(2119, event); return false;
						" onmouseover="petTalentCalc.makeTalentTooltip(2119);">
<span id="spellInfo_2119" style="display: none;"><span style="float: left;">30 Мана</span>
<br>
<span style="float: right;">Восстановление: 32  сек</span><span style="float: left;"> Мгновенное действие </span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2119_numPoints_tkwen68">0</span><span>/</span><span>1</span>
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
<span id="spellInfo_2206" style="display: none;"><span style="float: left;">Дистанция ближнего боя</span>
<br>
<span style="float: right;">Восстановление: 30  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2168" style="display: none;"><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2181" style="display: none;"><span style="float: left;">Дистанция ближнего боя</span>
<br>
<span style="float: right;">Восстановление: 10  сек</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2184" style="display: none;"><span style="float: left;"> Радиус действия40 </span>
<br>
<span style="float: right;"> Восстановление: 3  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2175" style="display: none;"><span style="float: right;"> Восстановление: 3  мин</span><span style="float: left;"> Мгновенное действие </span></span>
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
<span id="spellInfo_2278" style="display: none;"><span style="float: left;"> Радиус действия40 </span>
<br>
<span style="float: right;"> Восстановление: 1  мин</span><span style="float: left;"> Мгновенное действие </span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2278_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/ability_hunter_combatexperience.png) 0 0 no-repeat;">
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(2, true);"><span>Сброс</span></a><span id="treeName_2_tkwen68" style="font-weight: bold;">Хитрость</span> &nbsp;<span id="treeSpent_2_tkwen68">0</span>
</div>
</div>
</div>
</div>
</div>
<div class="petFamilies" id="petFamilies">
<div class="petGroup" id="0_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(0)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Свирепость</h4>
<div class="petFamily staticTip" id="1_family" onclick="petTalentCalc.changePetTree(0, 1, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(1)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wolf.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="25_family" onclick="petTalentCalc.changePetTree(0, 25, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(25)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_hyena.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="45_family" onclick="petTalentCalc.changePetTree(0, 45, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(45)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_corehound.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="12_family" onclick="petTalentCalc.changePetTree(0, 12, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(12)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_tallstrider.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="46_family" onclick="petTalentCalc.changePetTree(0, 46, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(46)" style="background-image: url(wow-icons/_images/43x43/ability_druid_primalprecision.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="39_family" onclick="petTalentCalc.changePetTree(0, 39, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(39)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_devilsaur.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="2_family" onclick="petTalentCalc.changePetTree(0, 2, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(2)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_cat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="37_family" onclick="petTalentCalc.changePetTree(0, 37, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(37)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_moth.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="44_family" onclick="petTalentCalc.changePetTree(0, 44, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(44)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wasp.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="7_family" onclick="petTalentCalc.changePetTree(0, 7, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(7)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_vulture.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="11_family" onclick="petTalentCalc.changePetTree(0, 11, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(11)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_raptor.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
</div>
<div class="petGroup" id="1_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(1)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Упорство</h4>
<div class="petFamily staticTip" id="5_family" onclick="petTalentCalc.changePetTree(1, 5, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(5)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_boar.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="9_family" onclick="petTalentCalc.changePetTree(1, 9, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(9)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_gorilla.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="8_family" onclick="petTalentCalc.changePetTree(1, 8, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(8)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crab.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="6_family" onclick="petTalentCalc.changePetTree(1, 6, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(6)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crocolisk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="43_family" onclick="petTalentCalc.changePetTree(1, 43, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(43)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_rhino.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="4_family" onclick="petTalentCalc.changePetTree(1, 4, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(4)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bear.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="32_family" onclick="petTalentCalc.changePetTree(1, 32, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(32)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_warpstalker.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="20_family" onclick="petTalentCalc.changePetTree(1, 20, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(20)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_scorpid.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="42_family" onclick="petTalentCalc.changePetTree(1, 42, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(42)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_worm.png)">
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
<h4>Хитрость</h4>
<div class="petFamily staticTip" id="30_family" onclick="petTalentCalc.changePetTree(2, 30, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(30)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_dragonhawk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="35_family" onclick="petTalentCalc.changePetTree(2, 35, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(35)" style="background-image: url(wow-icons/_images/43x43/spell_nature_guardianward.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="27_family" onclick="petTalentCalc.changePetTree(2, 27, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(27)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_windserpent.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="24_family" onclick="petTalentCalc.changePetTree(2, 24, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(24)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="31_family" onclick="petTalentCalc.changePetTree(2, 31, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(31)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_ravager.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="3_family" onclick="petTalentCalc.changePetTree(2, 3, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(3)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_spider.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="41_family" onclick="petTalentCalc.changePetTree(2, 41, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(41)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_silithid.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="34_family" onclick="petTalentCalc.changePetTree(2, 34, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(34)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_netherray.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="26_family" onclick="petTalentCalc.changePetTree(2, 26, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(26)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_owl.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="33_family" onclick="petTalentCalc.changePetTree(2, 33, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(33)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_sporebat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="38_family" onclick="petTalentCalc.changePetTree(2, 38, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(38)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_chimera.png)">
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
<petTalentTab key="Cunning" name="Хитрость" order="2">
<family catId="8" icon="ability_hunter_pet_dragonhawk" id="30" name="Дракондор"></family>
<family catId="16" icon="spell_nature_guardianward" id="35" name="Змей"></family>
<family catId="22" icon="ability_hunter_pet_windserpent" id="27" name="Крылатый змей"></family>
<family catId="0" icon="ability_hunter_pet_bat" id="24" name="Летучая мышь"></family>
<family catId="14" icon="ability_hunter_pet_ravager" id="31" name="Опустошитель"></family>
<family catId="17" icon="ability_hunter_pet_spider" id="3" name="Паук"></family>
<family catId="63" icon="ability_hunter_pet_silithid" id="41" name="Силитид"></family>
<family catId="12" icon="ability_hunter_pet_netherray" id="34" name="Скат Пустоты"></family>
<family catId="2" icon="ability_hunter_pet_owl" id="26" name="Сова"></family>
<family catId="18" icon="ability_hunter_pet_sporebat" id="33" name="Спороскат"></family>
<family catId="24" icon="ability_hunter_pet_chimera" id="38" name="Химера"></family>
</petTalentTab>
<petTalentTab key="Tenacity" name="Упорство" order="1">
<family catId="3" icon="ability_hunter_pet_boar" id="5" name="Вепрь"></family>
<family catId="9" icon="ability_hunter_pet_gorilla" id="9" name="Горилла"></family>
<family catId="6" icon="ability_hunter_pet_crab" id="8" name="Краб"></family>
<family catId="7" icon="ability_hunter_pet_crocolisk" id="6" name="Кроколиск"></family>
<family catId="61" icon="ability_hunter_pet_rhino" id="43" name="Люторог"></family>
<family catId="1" icon="ability_hunter_pet_bear" id="4" name="Медведь"></family>
<family catId="21" icon="ability_hunter_pet_warpstalker" id="32" name="Прыгуана"></family>
<family catId="15" icon="ability_hunter_pet_scorpid" id="20" name="Скорпид"></family>
<family catId="62" icon="ability_hunter_pet_worm" id="42" name="Червь"></family>
<family catId="21" icon="ability_hunter_pet_turtle" id="21" name="Черепаха"></family>
</petTalentTab>
<petTalentTab key="Ferocity" name="Свирепость" order="0">
<family catId="23" icon="ability_hunter_pet_wolf" id="1" name="Волк"></family>
<family catId="10" icon="ability_hunter_pet_hyena" id="25" name="Гиена"></family>
<family catId="59" icon="ability_hunter_pet_corehound" id="45" name="Гончая Недр"></family>
<family catId="19" icon="ability_hunter_pet_tallstrider" id="12" name="Долгоног"></family>
<family catId="58" icon="ability_druid_primalprecision" id="46" name="Дух зверя"></family>
<family catId="25" icon="ability_hunter_pet_devilsaur" id="39" name="Дьявозавр"></family>
<family catId="5" icon="ability_hunter_pet_cat" id="2" name="Кошка"></family>
<family catId="11" icon="ability_hunter_pet_moth" id="37" name="Мотылек"></family>
<family catId="60" icon="ability_hunter_pet_wasp" id="44" name="Оса"></family>
<family catId="4" icon="ability_hunter_pet_vulture" id="7" name="Падальщик"></family>
<family catId="13" icon="ability_hunter_pet_raptor" id="11" name="Ящер"></family>
</petTalentTab>
</petTalentTabs>
<spells>
<spell description="Вы в совершенстве овладеваете искусством дрессировки, получая возможность приручать экзотических питомцев. Общее количество очков умений питомца увеличивается на 4." id="53270" name="Повелитель зверей"></spell>
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