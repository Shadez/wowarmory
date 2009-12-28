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
<a href="talent-calc.xml">{{#armory_talent_calc_talents_calc#}}</a>
</div>
<div class="selected-tab" id="tab_petTalentCalculator">
<a href="talent-calc.xml?pid=-1">{{#armory_talent_calc_pet_talents#}}</a>
</div>
<div class="tab" id="tab_arenaCalculator">
<a href="arena-calculator.xml">{{#armory_talent_calc_arena_calc#}}</a>
</div>
<div class="clear"></div>
</div>
<div class="subTabs">
<div class="upperLeftCorner"></div>
<div class="upperRightCorner"></div>
<a class="" href="talent-calc.xml?pid=-1" id="Ferocity_subTab" onclick="petTalentCalc.changePetTree(0); return false"><span>Ferocity</span></a>
<a class="" href="talent-calc.xml?pid=-2" id="Tenacity_subTab" onclick="petTalentCalc.changePetTree(1); return false"><span>Tenacity</span></a>
<a class="" href="talent-calc.xml?pid=-3" id="Cunning_subTab" onclick="petTalentCalc.changePetTree(2); return false"><span>Cunning</span></a>
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
				name: "Ferocity",
				talents: [
				
					{
						id:     2107,
						tier:   0,
						column: 0,
						name:  "Cobra Reflexes",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Increases your pet's attack speed by 15%.  Your pet will hit faster but each hit will do less damage."
							,
							"Increases your pet's attack speed by 30%.  Your pet will hit faster but each hit will do less damage."
							
						]
					}
					,
					{
						id:     2203,
						tier:   0,
						column: 1,
						name:  "Dive",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Increases your pet's movement speed by 80% for 16 sec."
							
						]
					}
					,
					{
						id:     2109,
						tier:   0,
						column: 1,
						name:  "Dash",
						icon:  "ability_druid_dash",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Increases your pet's movement speed by 80% for 16 sec."
							
						]
					}
					,
					{
						id:     2112,
						tier:   0,
						column: 2,
						name:  "Great Stamina",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Increases your pet's total Stamina by 4%."
							,
							"Increases your pet's total Stamina by 8%."
							,
							"Increases your pet's total Stamina by 12%."
							
						]
					}
					,
					{
						id:     2113,
						tier:   0,
						column: 3,
						name:  "Natural Armor",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Increases your pet's armor by 5%."
							,
							"Increases your pet's armor by 10%."
							
						]
					}
					,
					{
						id:     2124,
						tier:   1,
						column: 0,
						name:  "Improved Cower",
						icon:  "ability_druid_cower",
						
						ranks: [
						
							"The movement speed penalty of your pet's Cower is reduced by 50%."
							,
							"The movement speed penalty of your pet's Cower is reduced by 100%."
							
						]
					}
					,
					{
						id:     2128,
						tier:   1,
						column: 1,
						name:  "Bloodthirsty",
						icon:  "ability_druid_primaltenacity",
						
						ranks: [
						
							"Your pet's attacks have a 10% chance to increase its happiness by 5% and heal 5% of its total health."
							,
							"Your pet's attacks have a 20% chance to increase its happiness by 5% and heal 5% of its total health."
							
						]
					}
					,
					{
						id:     2125,
						tier:   1,
						column: 2,
						name:  "Spiked Collar",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Your pet does an additional 3% damage with all attacks."
							,
							"Your pet does an additional 6% damage with all attacks."
							,
							"Your pet does an additional 9% damage with all attacks."
							
						]
					}
					,
					{
						id:     2151,
						tier:   1,
						column: 3,
						name:  "Boar's Speed",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Increases your pet's movement speed by 30%."
							
						]
					}
					,
					{
						id:     2106,
						tier:   2,
						column: 0,
						name:  "Culling the Herd",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 1% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 2% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 3% increased damage for 10 sec."
							
						]
					}
					,
					{
						id:     2152,
						tier:   2,
						column: 2,
						name:  "Lionhearted",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduces the duration of all Stun and Fear effects used against your pet by 15%."
							,
							"Reduces the duration of all Stun and Fear effects used against your pet by 30%."
							
						]
					}
					,
					{
						id:     2111,
						tier:   2,
						column: 3,
						name:  "Charge",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 42476576,
						
							categoryMask1: 201326592,
						
						ranks: [
						
							"Your pet charges an enemy, immobilizing the target for 1 sec, and increasing the pet's melee attack power by 25% for its next attack."
							
						]
					}
					,
					{
						id:     2219,
						tier:   2,
						column: 3,
						name:  "Swoop",
						icon:  "ability_hunter_pet_dragonhawk",
						
							categoryMask0: 2064,
						
							categoryMask1: 268435456,
						
						ranks: [
						
							"Your pet swoops at an enemy, immobilizing the target for 1 sec, and adds 25% melee attack power to the pet's next attack."
							
						]
					}
					,
					{
						id:     2156,
						tier:   3,
						column: 1,
						name:  "Heart of the Phoenix",
						icon:  "inv_misc_pheonixpet_01",
						
							requires: 2128,
						
						ranks: [
						
							"When your pet dies, it will miraculously return to life with full health."
							
						]
					}
					,
					{
						id:     2129,
						tier:   3,
						column: 2,
						name:  "Spider's Bite",
						icon:  "ability_hunter_pet_spider",
						
						ranks: [
						
							"Increases the critical strike chance of your pet by 3%."
							,
							"Increases the critical strike chance of your pet by 6%."
							,
							"Increases the critical strike chance of your pet by 9%."
							
						]
					}
					,
					{
						id:     2154,
						tier:   3,
						column: 3,
						name:  "Great Resistance",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Your pet takes 5% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 10% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 15% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							
						]
					}
					,
					{
						id:     2155,
						tier:   4,
						column: 0,
						name:  "Rabid",
						icon:  "ability_druid_berserk",
						
						ranks: [
						
							"Your pet goes into a killing frenzy.  Successful attacks have a chance to increase attack power by 5%.  This effect will stack up to 5 times.  Lasts 20 sec."
							
						]
					}
					,
					{
						id:     2153,
						tier:   4,
						column: 1,
						name:  "Lick Your Wounds",
						icon:  "ability_hunter_mendpet",
						
							requires: 2156,
						
						ranks: [
						
							"Your pet heals itself for 100% of its total health over 5 sec while channeling."
							
						]
					}
					,
					{
						id:     2157,
						tier:   4,
						column: 2,
						name:  "Call of the Wild",
						icon:  "ability_druid_kingofthejungle",
						
							requires: 2129,
						
						ranks: [
						
							"Your pet roars, increasing your pet's and your melee and ranged attack power by 10%.  Lasts 20 sec."
							
						]
					}
					,
					{
						id:     2254,
						tier:   5,
						column: 0,
						name:  "Shark Attack",
						icon:  "inv_misc_fish_35",
						
						ranks: [
						
							"Your pet does an additional 3% damage with all attacks."
							,
							"Your pet does an additional 6% damage with all attacks."
							
						]
					}
					,
					{
						id:     2253,
						tier:   5,
						column: 2,
						name:  "Wild Hunt",
						icon:  "inv_misc_horn_04",
						
							requires: 2157,
						
						ranks: [
						
							"Increases the contribution your pet gets from your Stamina by 20% and attack power by 15%."
							,
							"Increases the contribution your pet gets from your Stamina by 40% and attack power by 30%."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Tenacity",
				name: "Tenacity",
				talents: [
				
					{
						id:     2114,
						tier:   0,
						column: 0,
						name:  "Cobra Reflexes",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Increases your pet's attack speed by 15%.  Your pet will hit faster but each hit will do less damage."
							,
							"Increases your pet's attack speed by 30%.  Your pet will hit faster but each hit will do less damage."
							
						]
					}
					,
					{
						id:     2237,
						tier:   0,
						column: 1,
						name:  "Charge",
						icon:  "ability_hunter_pet_bear",
						
							categoryMask0: 3179210,
						
							categoryMask1: 1610612736,
						
						ranks: [
						
							"Your pet charges an enemy, immobilizing the target for 1 sec, and increasing the pet's melee attack power by 25% for its next attack."
							
						]
					}
					,
					{
						id:     2116,
						tier:   0,
						column: 2,
						name:  "Great Stamina",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Increases your pet's total Stamina by 4%."
							,
							"Increases your pet's total Stamina by 8%."
							,
							"Increases your pet's total Stamina by 12%."
							
						]
					}
					,
					{
						id:     2117,
						tier:   0,
						column: 3,
						name:  "Natural Armor",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Increases your pet's armor by 5%."
							,
							"Increases your pet's armor by 10%."
							
						]
					}
					,
					{
						id:     2126,
						tier:   1,
						column: 0,
						name:  "Spiked Collar",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Your pet does an additional 3% damage with all attacks."
							,
							"Your pet does an additional 6% damage with all attacks."
							,
							"Your pet does an additional 9% damage with all attacks."
							
						]
					}
					,
					{
						id:     2160,
						tier:   1,
						column: 1,
						name:  "Boar's Speed",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Increases your pet's movement speed by 30%."
							
						]
					}
					,
					{
						id:     2173,
						tier:   1,
						column: 2,
						name:  "Blood of the Rhino",
						icon:  "spell_shadow_lifedrain",
						
							requires: 2116,
						
						ranks: [
						
							"Increases your pet's total Stamina by 2% and increases all healing effects on your pet by 20%."
							,
							"Increases your pet's total Stamina by 4% and increases all healing effects on your pet by 40%."
							
						]
					}
					,
					{
						id:     2122,
						tier:   1,
						column: 3,
						name:  "Pet Barding",
						icon:  "inv_helmet_94",
						
							requires: 2117,
						
						ranks: [
						
							"Increases your pet's armor by 5% and chance to Dodge by 1%."
							,
							"Increases your pet's armor by 10% and chance to Dodge by 2%."
							
						]
					}
					,
					{
						id:     2110,
						tier:   2,
						column: 0,
						name:  "Culling the Herd",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 1% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 2% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 3% increased damage for 10 sec."
							
						]
					}
					,
					{
						id:     2123,
						tier:   2,
						column: 1,
						name:  "Guard Dog",
						icon:  "ability_physical_taunt",
						
						ranks: [
						
							"Your pet's Growl generates 10% additional threat and 10% of its total happiness."
							,
							"Your pet's Growl generates 20% additional threat and 10% of its total happiness."
							
						]
					}
					,
					{
						id:     2162,
						tier:   2,
						column: 2,
						name:  "Lionhearted",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduces the duration of all Stun and Fear effects used against your pet by 15%."
							,
							"Reduces the duration of all Stun and Fear effects used against your pet by 30%."
							
						]
					}
					,
					{
						id:     2277,
						tier:   2,
						column: 3,
						name:  "Thunderstomp",
						icon:  "ability_golemthunderclap",
						
						ranks: [
						
							"Shakes the ground with thundering force, doing 3 to 5 Nature damage to all enemies within 8 yards.  This ability causes a moderate amount of additional threat."
							
						]
					}
					,
					{
						id:     2163,
						tier:   3,
						column: 2,
						name:  "Grace of the Mantis",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Reduces the chance your pet will be critically hit by melee attacks by 2%."
							,
							"Reduces the chance your pet will be critically hit by melee attacks by 4%."
							
						]
					}
					,
					{
						id:     2161,
						tier:   3,
						column: 3,
						name:  "Great Resistance",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Your pet takes 5% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 10% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 15% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							
						]
					}
					,
					{
						id:     2171,
						tier:   4,
						column: 0,
						name:  "Last Stand",
						icon:  "spell_nature_shamanrage",
						
						ranks: [
						
							"Your pet temporarily gains 30% of its maximum health for 20 sec.  After the effect expires, the health is lost."
							
						]
					}
					,
					{
						id:     2170,
						tier:   4,
						column: 1,
						name:  "Taunt",
						icon:  "spell_nature_reincarnation",
						
							requires: 2123,
						
						ranks: [
						
							"Your pet taunts the target to attack it for 3 sec."
							
						]
					}
					,
					{
						id:     2172,
						tier:   4,
						column: 2,
						name:  "Roar of Sacrifice",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2163,
						
						ranks: [
						
							"Protects a friendly target from critical strikes, making attacks against that target unable to be critical strikes, but 20% of all damage taken by that target is also taken by the pet.  Lasts 12 sec."
							
						]
					}
					,
					{
						id:     2169,
						tier:   4,
						column: 3,
						name:  "Intervene",
						icon:  "ability_hunter_pet_turtle",
						
						ranks: [
						
							"Your pet runs at high speed towards a group member, intercepting the next melee or ranged attack made against them."
							
						]
					}
					,
					{
						id:     2258,
						tier:   5,
						column: 1,
						name:  "Silverback",
						icon:  "ability_hunter_pet_gorilla",
						
						ranks: [
						
							"Your pet's Growl also heals it for 1% of its total health."
							,
							"Your pet's Growl also heals it for 2% of its total health."
							
						]
					}
					,
					{
						id:     2255,
						tier:   5,
						column: 2,
						name:  "Wild Hunt",
						icon:  "inv_misc_horn_04",
						
							requires: 2172,
						
						ranks: [
						
							"Increases the contribution your pet gets from your Stamina by 20% and attack power by 15%."
							,
							"Increases the contribution your pet gets from your Stamina by 40% and attack power by 30%."
							
						]
					}
					
				]
			}
			,
			{
				id:   "Cunning",
				name: "Cunning",
				talents: [
				
					{
						id:     2118,
						tier:   0,
						column: 0,
						name:  "Cobra Reflexes",
						icon:  "spell_nature_guardianward",
						
						ranks: [
						
							"Increases your pet's attack speed by 15%.  Your pet will hit faster but each hit will do less damage."
							,
							"Increases your pet's attack speed by 30%.  Your pet will hit faster but each hit will do less damage."
							
						]
					}
					,
					{
						id:     2201,
						tier:   0,
						column: 1,
						name:  "Dive",
						icon:  "spell_shadow_burningspirit",
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Increases your pet's movement speed by 80% for 16 sec."
							
						]
					}
					,
					{
						id:     2119,
						tier:   0,
						column: 1,
						name:  "Dash",
						icon:  "ability_druid_dash",
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Increases your pet's movement speed by 80% for 16 sec."
							
						]
					}
					,
					{
						id:     2120,
						tier:   0,
						column: 2,
						name:  "Great Stamina",
						icon:  "spell_nature_unyeildingstamina",
						
						ranks: [
						
							"Increases your pet's total Stamina by 4%."
							,
							"Increases your pet's total Stamina by 8%."
							,
							"Increases your pet's total Stamina by 12%."
							
						]
					}
					,
					{
						id:     2121,
						tier:   0,
						column: 3,
						name:  "Natural Armor",
						icon:  "spell_nature_spiritarmor",
						
						ranks: [
						
							"Increases your pet's armor by 5%."
							,
							"Increases your pet's armor by 10%."
							
						]
					}
					,
					{
						id:     2165,
						tier:   1,
						column: 0,
						name:  "Boar's Speed",
						icon:  "ability_hunter_pet_boar",
						
						ranks: [
						
							"Increases your pet's movement speed by 30%."
							
						]
					}
					,
					{
						id:     2208,
						tier:   1,
						column: 1,
						name:  "Mobility",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2201,
						
							categoryMask0: 21238021,
						
						ranks: [
						
							"Reduces the cooldown on your pet's Dive ability by 8 sec."
							,
							"Reduces the cooldown on your pet's Dive ability by 16 sec."
							
						]
					}
					,
					{
						id:     2207,
						tier:   1,
						column: 1,
						name:  "Mobility",
						icon:  "ability_hunter_animalhandler",
						
							requires: 2119,
						
							categoryMask0: 212992,
						
							categoryMask1: -2147483648,
						
						ranks: [
						
							"Reduces the cooldown on your pet's Dash ability by 8 sec."
							,
							"Reduces the cooldown on your pet's Dash ability by 16 sec."
							
						]
					}
					,
					{
						id:     2182,
						tier:   1,
						column: 2,
						name:  "Owl's Focus",
						icon:  "ability_hunter_pet_owl",
						
						ranks: [
						
							"Your pet has a 15% chance after using an ability that the next ability will cost no Focus if used within 8 sec."
							,
							"Your pet has a 30% chance after using an ability that the next ability will cost no Focus if used within 8 sec."
							
						]
					}
					,
					{
						id:     2127,
						tier:   1,
						column: 3,
						name:  "Spiked Collar",
						icon:  "inv_jewelry_necklace_22",
						
						ranks: [
						
							"Your pet does an additional 3% damage with all attacks."
							,
							"Your pet does an additional 6% damage with all attacks."
							,
							"Your pet does an additional 9% damage with all attacks."
							
						]
					}
					,
					{
						id:     2166,
						tier:   2,
						column: 0,
						name:  "Culling the Herd",
						icon:  "inv_misc_monsterhorn_06",
						
						ranks: [
						
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 1% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 2% increased damage for 10 sec."
							,
							"When your pet's Claw, Bite, or Smack ability deals a critical strike, you and your pet deal 3% increased damage for 10 sec."
							
						]
					}
					,
					{
						id:     2167,
						tier:   2,
						column: 1,
						name:  "Lionhearted",
						icon:  "inv_bannerpvp_02",
						
						ranks: [
						
							"Reduces the duration of all Stun and Fear effects used against your pet by 15%."
							,
							"Reduces the duration of all Stun and Fear effects used against your pet by 30%."
							
						]
					}
					,
					{
						id:     2206,
						tier:   2,
						column: 2,
						name:  "Carrion Feeder",
						icon:  "ability_racial_cannibalize",
						
						ranks: [
						
							"Your pet can generate health and happiness by eating a corpse.  Will not work on the remains of elemental or mechanical creatures."
							
						]
					}
					,
					{
						id:     2168,
						tier:   3,
						column: 1,
						name:  "Great Resistance",
						icon:  "spell_nature_resistnature",
						
						ranks: [
						
							"Your pet takes 5% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 10% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							,
							"Your pet takes 15% less damage from Arcane, Fire, Frost, Nature and Shadow magic."
							
						]
					}
					,
					{
						id:     2177,
						tier:   3,
						column: 2,
						name:  "Cornered",
						icon:  "ability_hunter_survivalinstincts",
						
						ranks: [
						
							"When at less than 35% health, your pet does 25% more damage and has a 30% reduced chance to be critically hit."
							,
							"When at less than 35% health, your pet does 50% more damage and has a 60% reduced chance to be critically hit."
							
						]
					}
					,
					{
						id:     2183,
						tier:   3,
						column: 3,
						name:  "Feeding Frenzy",
						icon:  "inv_misc_fish_48",
						
							requires: 2127,
						
						ranks: [
						
							"Your pet does 8% additional damage to targets with less than 35% health."
							,
							"Your pet does 16% additional damage to targets with less than 35% health."
							
						]
					}
					,
					{
						id:     2181,
						tier:   4,
						column: 0,
						name:  "Wolverine Bite",
						icon:  "ability_druid_lacerate",
						
						ranks: [
						
							"A fierce attack causing 5 damage, modified by pet level, that your pet can use after it makes a critical attack.  Cannot be dodged, blocked or parried."
							
						]
					}
					,
					{
						id:     2184,
						tier:   4,
						column: 1,
						name:  "Roar of Recovery",
						icon:  "ability_druid_mastershapeshifter",
						
						ranks: [
						
							"Your pet's inspiring roar restores 30% of your total mana over 9 sec."
							
						]
					}
					,
					{
						id:     2175,
						tier:   4,
						column: 2,
						name:  "Bullheaded",
						icon:  "ability_warrior_bullrush",
						
							requires: 2177,
						
						ranks: [
						
							"Removes all movement impairing effects and all effects which cause loss of control of your pet, and reduces damage done to your pet by 20% for 12 sec."
							
						]
					}
					,
					{
						id:     2257,
						tier:   4,
						column: 3,
						name:  "Grace of the Mantis",
						icon:  "inv_misc_ahnqirajtrinket_02",
						
						ranks: [
						
							"Reduces the chance your pet will be critically hit by melee attacks by 2%."
							,
							"Reduces the chance your pet will be critically hit by melee attacks by 4%."
							
						]
					}
					,
					{
						id:     2256,
						tier:   5,
						column: 0,
						name:  "Wild Hunt",
						icon:  "inv_misc_horn_04",
						
							requires: 2181,
						
						ranks: [
						
							"Increases the contribution your pet gets from your Stamina by 20% and attack power by 15%."
							,
							"Increases the contribution your pet gets from your Stamina by 40% and attack power by 30%."
							
						]
					}
					,
					{
						id:     2278,
						tier:   5,
						column: 3,
						name:  "Roar of Sacrifice",
						icon:  "ability_druid_demoralizingroar",
						
							requires: 2257,
						
						ranks: [
						
							"Protects a friendly target from critical strikes, making attacks against that target unable to be critical strikes, but 20% of all damage taken by that target is also taken by the pet.  Lasts 12 sec."
							
						]
					}
					
				]
			}
			
		];

		var petData_tkwen68 = null;
		
					petData_tkwen68 = {
					24: {
							name:  "Bat",
							tree:  "2",
							catId:  0,
							icon:  "ability_hunter_pet_bat"
						}
						,26: {
							name:  "Bird of Prey",
							tree:  "2",
							catId:  2,
							icon:  "ability_hunter_pet_owl"
						}
						,38: {
							name:  "Chimaera",
							tree:  "2",
							catId:  24,
							icon:  "ability_hunter_pet_chimera"
						}
						,30: {
							name:  "Dragonhawk",
							tree:  "2",
							catId:  8,
							icon:  "ability_hunter_pet_dragonhawk"
						}
						,34: {
							name:  "Nether Ray",
							tree:  "2",
							catId:  12,
							icon:  "ability_hunter_pet_netherray"
						}
						,31: {
							name:  "Ravager",
							tree:  "2",
							catId:  14,
							icon:  "ability_hunter_pet_ravager"
						}
						,35: {
							name:  "Serpent",
							tree:  "2",
							catId:  16,
							icon:  "spell_nature_guardianward"
						}
						,41: {
							name:  "Silithid",
							tree:  "2",
							catId:  63,
							icon:  "ability_hunter_pet_silithid"
						}
						,3: {
							name:  "Spider",
							tree:  "2",
							catId:  17,
							icon:  "ability_hunter_pet_spider"
						}
						,33: {
							name:  "Sporebat",
							tree:  "2",
							catId:  18,
							icon:  "ability_hunter_pet_sporebat"
						}
						,27: {
							name:  "Wind Serpent",
							tree:  "2",
							catId:  22,
							icon:  "ability_hunter_pet_windserpent"
						}
						,4: {
							name:  "Bear",
							tree:  "1",
							catId:  1,
							icon:  "ability_hunter_pet_bear"
						}
						,5: {
							name:  "Boar",
							tree:  "1",
							catId:  3,
							icon:  "ability_hunter_pet_boar"
						}
						,8: {
							name:  "Crab",
							tree:  "1",
							catId:  6,
							icon:  "ability_hunter_pet_crab"
						}
						,6: {
							name:  "Crocolisk",
							tree:  "1",
							catId:  7,
							icon:  "ability_hunter_pet_crocolisk"
						}
						,9: {
							name:  "Gorilla",
							tree:  "1",
							catId:  9,
							icon:  "ability_hunter_pet_gorilla"
						}
						,43: {
							name:  "Rhino",
							tree:  "1",
							catId:  61,
							icon:  "ability_hunter_pet_rhino"
						}
						,20: {
							name:  "Scorpid",
							tree:  "1",
							catId:  15,
							icon:  "ability_hunter_pet_scorpid"
						}
						,21: {
							name:  "Turtle",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_turtle"
						}
						,32: {
							name:  "Warp Stalker",
							tree:  "1",
							catId:  21,
							icon:  "ability_hunter_pet_warpstalker"
						}
						,42: {
							name:  "Worm",
							tree:  "1",
							catId:  62,
							icon:  "ability_hunter_pet_worm"
						}
						,7: {
							name:  "Carrion Bird",
							tree:  "0",
							catId:  4,
							icon:  "ability_hunter_pet_vulture"
						}
						,2: {
							name:  "Cat",
							tree:  "0",
							catId:  5,
							icon:  "ability_hunter_pet_cat"
						}
						,45: {
							name:  "Core Hound",
							tree:  "0",
							catId:  59,
							icon:  "ability_hunter_pet_corehound"
						}
						,39: {
							name:  "Devilsaur",
							tree:  "0",
							catId:  25,
							icon:  "ability_hunter_pet_devilsaur"
						}
						,25: {
							name:  "Hyena",
							tree:  "0",
							catId:  10,
							icon:  "ability_hunter_pet_hyena"
						}
						,37: {
							name:  "Moth",
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
						,46: {
							name:  "Spirit Beast",
							tree:  "0",
							catId:  58,
							icon:  "ability_druid_primalprecision"
						}
						,12: {
							name:  "Tallstrider",
							tree:  "0",
							catId:  19,
							icon:  "ability_hunter_pet_tallstrider"
						}
						,44: {
							name:  "Wasp",
							tree:  "0",
							catId:  60,
							icon:  "ability_hunter_pet_wasp"
						}
						,1: {
							name:  "Wolf",
							tree:  "0",
							catId:  23,
							icon:  "ability_hunter_pet_wolf"
						}
						
					};
				
			var textTalentBeastMasteryName = "Beast Mastery";
			var textTalentBeastMasteryDesc = "You master the art of Beast training, teaching you the ability to tame Exotic pets and increasing your total amount of Pet Skill Points by 4.";
		
	
		var textTalentStrSingle = "Requires {0} point in {1}.";
		var textTalentStrPlural = "Requires {0} points in {1}.";
		var textTalentRank = "Rank {0}/{1}";
		var textTalentNextRank = "Next Rank";
		var textTalentReqTreeTalents = "Requires {0} points in {1} Talents.";
		var textPrintableClassTalents = "{0} Talents";
		var textPrintableMinReqLevel = "Minimum Required Level: {0}";
		var textPrintableReqTalentPts = "Required Talent Points: {0}";
		var textPrintableTreeTalents = "{0} Talents";
		var textPrintablePtsPerTree = "{0} point(s)";
		var textPrintableDontWastePaper = "Don't waste paper!";

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
<div class="staticTip" onmouseover="setTipText('Click on this link and then copy the URL from the address bar')">Link to this build</div>
</span></a><a class="awesomeButton awesomeButton-printableVersion" href="javascript:;" onclick="petTalentCalc.showPrintableVersion()"><span>
<div>Print</div>
</span></a><span class="calcInfoLeft"><b>Required Level</b>&nbsp;<span class="ptsHolder" id="requiredLevel">10</span><b>Points Spent</b>&nbsp;<span class="ptsHolder" id="pointsSpent">0</span><b>Points Left</b>&nbsp;<span class="ptsHolder" id="pointsLeft">0</span></span><a class="petBeastMastery staticTip" href="javascript:;" id="beastMasteryToggler" onclick="petTalentCalc.toggleBeastMastery()" onmouseover="petTalentCalc.displayBeastMasteryTooltip()">+4</a>
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
<span id="spellInfo_2203" style="display: none;"><span style="float: left;">30 Mana</span>
<br>
<span style="float: right;">32 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2109" style="display: none;"><span style="float: left;">30 Mana</span>
<br>
<span style="float: right;">32 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2111" style="display: none;"><span style="float: right;">8&nbsp;-25 yd range</span><span style="float: left;">35 Mana</span>
<br>
<span style="float: right;">25 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2219" style="display: none;"><span style="float: right;">8&nbsp;-25 yd range</span><span style="float: left;">35 Mana</span>
<br>
<span style="float: right;">25 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2154" style="display: none;"><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2155" style="display: none;"><span style="float: right;">45 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2153" style="display: none;"><span style="float: right;">3 min cooldown</span><span style="float: left;">Channeled</span></span>
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
<span id="spellInfo_2157" style="display: none;"><span style="float: right;">5 min cooldown</span><span style="float: left;">Instant</span></span>
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
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(0, true);"><span>Reset</span></a><span id="treeName_0_tkwen68" style="font-weight: bold;">Ferocity</span> &nbsp;<span id="treeSpent_0_tkwen68">0</span>
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
<span id="spellInfo_2237" style="display: none;"><span style="float: right;">8&nbsp;-25 yd range</span><span style="float: left;">35 Mana</span>
<br>
<span style="float: right;">25 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2277" style="display: none;"><span style="float: right;">Melee range</span><span style="float: left;">20 Mana</span>
<br>
<span style="float: right;">10 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2161" style="display: none;"><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2171" style="display: none;"><span style="float: right;">6 min cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2170" style="display: none;"><span style="float: left;">Melee range</span>
<br>
<span style="float: right;">3 min cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2172" style="display: none;"><span style="float: left;">40 yd range</span>
<br>
<span style="float: right;">1 min cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2169" style="display: none;"><span style="float: right;">8&nbsp;-25 yd range</span><span style="float: left;">20 Mana</span>
<br>
<span style="float: right;">30 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(1, true);"><span>Reset</span></a><span id="treeName_1_tkwen68" style="font-weight: bold;">Tenacity</span> &nbsp;<span id="treeSpent_1_tkwen68">0</span>
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
<span id="spellInfo_2201" style="display: none;"><span style="float: left;">30 Mana</span>
<br>
<span style="float: right;">32 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2119" style="display: none;"><span style="float: left;">30 Mana</span>
<br>
<span style="float: right;">32 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2206" style="display: none;"><span style="float: left;">Melee range</span>
<br>
<span style="float: right;">30 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2168" style="display: none;"><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2181" style="display: none;"><span style="float: left;">Melee range</span>
<br>
<span style="float: right;">10 sec cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2184" style="display: none;"><span style="float: left;">40 yd range</span>
<br>
<span style="float: right;">3 min cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2175" style="display: none;"><span style="float: right;">3 min cooldown</span><span style="float: left;">Instant</span></span>
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
<span id="spellInfo_2278" style="display: none;"><span style="float: left;">40 yd range</span>
<br>
<span style="float: right;">1 min cooldown</span><span style="float: left;">Instant</span></span>
<div class="talentHover"></div>
<div class="rankCtr">
<span id="2278_numPoints_tkwen68">0</span><span>/</span><span>1</span>
</div>
</div>
</div>
</div>
<div class="talentTreeInfo" style="background: url(wow-icons/_images/21x21/ability_hunter_combatexperience.png) 0 0 no-repeat;">
<a class="subtleResetButton" href="javascript:;" onclick="petTalentCalc.resetTalents(2, true);"><span>Reset</span></a><span id="treeName_2_tkwen68" style="font-weight: bold;">Cunning</span> &nbsp;<span id="treeSpent_2_tkwen68">0</span>
</div>
</div>
</div>
</div>
</div>
<div class="petFamilies" id="petFamilies">
<div class="petGroup" id="0_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(0)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Ferocity</h4>
<div class="petFamily staticTip" id="7_family" onclick="petTalentCalc.changePetTree(0, 7, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(7)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_vulture.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="2_family" onclick="petTalentCalc.changePetTree(0, 2, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(2)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_cat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="45_family" onclick="petTalentCalc.changePetTree(0, 45, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(45)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_corehound.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="39_family" onclick="petTalentCalc.changePetTree(0, 39, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(39)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_devilsaur.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="25_family" onclick="petTalentCalc.changePetTree(0, 25, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(25)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_hyena.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="37_family" onclick="petTalentCalc.changePetTree(0, 37, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(37)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_moth.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="11_family" onclick="petTalentCalc.changePetTree(0, 11, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(11)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_raptor.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="46_family" onclick="petTalentCalc.changePetTree(0, 46, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(46)" style="background-image: url(wow-icons/_images/43x43/ability_druid_primalprecision.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="12_family" onclick="petTalentCalc.changePetTree(0, 12, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(12)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_tallstrider.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="44_family" onclick="petTalentCalc.changePetTree(0, 44, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(44)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wasp.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="1_family" onclick="petTalentCalc.changePetTree(0, 1, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(1)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_wolf.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
</div>
<div class="petGroup" id="1_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(1)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Tenacity</h4>
<div class="petFamily staticTip" id="4_family" onclick="petTalentCalc.changePetTree(1, 4, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(4)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bear.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="5_family" onclick="petTalentCalc.changePetTree(1, 5, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(5)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_boar.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="8_family" onclick="petTalentCalc.changePetTree(1, 8, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(8)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crab.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="6_family" onclick="petTalentCalc.changePetTree(1, 6, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(6)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_crocolisk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="9_family" onclick="petTalentCalc.changePetTree(1, 9, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(9)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_gorilla.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="43_family" onclick="petTalentCalc.changePetTree(1, 43, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(43)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_rhino.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="20_family" onclick="petTalentCalc.changePetTree(1, 20, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(20)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_scorpid.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="21_family" onclick="petTalentCalc.changePetTree(1, 21, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(21)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_turtle.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="32_family" onclick="petTalentCalc.changePetTree(1, 32, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(32)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_warpstalker.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="42_family" onclick="petTalentCalc.changePetTree(1, 42, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(42)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_worm.png)">
<div class="petFrame"></div>
</div>
<div style="clear: both; overflow: hidden; height:1px"></div>
</div>
<div class="petListArrow"></div>
</div>
<div class="petGroup" id="2_group">
<div class="petGroup_b" onclick="petTalentCalc.changePetTree(2)" onmouseout="$(this).parent().removeClass('hoverPetGroup')" onmouseover="$(this).parent().addClass('hoverPetGroup')">
<h4>Cunning</h4>
<div class="petFamily staticTip" id="24_family" onclick="petTalentCalc.changePetTree(2, 24, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(24)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_bat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="26_family" onclick="petTalentCalc.changePetTree(2, 26, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(26)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_owl.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="38_family" onclick="petTalentCalc.changePetTree(2, 38, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(38)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_chimera.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="30_family" onclick="petTalentCalc.changePetTree(2, 30, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(30)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_dragonhawk.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="34_family" onclick="petTalentCalc.changePetTree(2, 34, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(34)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_netherray.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="31_family" onclick="petTalentCalc.changePetTree(2, 31, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(31)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_ravager.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="35_family" onclick="petTalentCalc.changePetTree(2, 35, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(35)" style="background-image: url(wow-icons/_images/43x43/spell_nature_guardianward.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="41_family" onclick="petTalentCalc.changePetTree(2, 41, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(41)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_silithid.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="3_family" onclick="petTalentCalc.changePetTree(2, 3, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(3)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_spider.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="33_family" onclick="petTalentCalc.changePetTree(2, 33, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(33)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_sporebat.png)">
<div class="petFrame"></div>
</div>
<div class="petFamily staticTip" id="27_family" onclick="petTalentCalc.changePetTree(2, 27, event)" onmouseover="petTalentCalc.displayPetFamilyTooltip(27)" style="background-image: url(wow-icons/_images/43x43/ability_hunter_pet_windserpent.png)">
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
<petTalentTab key="Cunning" name="Cunning" order="2">
<family catId="0" icon="ability_hunter_pet_bat" id="24" name="Bat"></family>
<family catId="2" icon="ability_hunter_pet_owl" id="26" name="Bird of Prey"></family>
<family catId="24" icon="ability_hunter_pet_chimera" id="38" name="Chimaera"></family>
<family catId="8" icon="ability_hunter_pet_dragonhawk" id="30" name="Dragonhawk"></family>
<family catId="12" icon="ability_hunter_pet_netherray" id="34" name="Nether Ray"></family>
<family catId="14" icon="ability_hunter_pet_ravager" id="31" name="Ravager"></family>
<family catId="16" icon="spell_nature_guardianward" id="35" name="Serpent"></family>
<family catId="63" icon="ability_hunter_pet_silithid" id="41" name="Silithid"></family>
<family catId="17" icon="ability_hunter_pet_spider" id="3" name="Spider"></family>
<family catId="18" icon="ability_hunter_pet_sporebat" id="33" name="Sporebat"></family>
<family catId="22" icon="ability_hunter_pet_windserpent" id="27" name="Wind Serpent"></family>
</petTalentTab>
<petTalentTab key="Tenacity" name="Tenacity" order="1">
<family catId="1" icon="ability_hunter_pet_bear" id="4" name="Bear"></family>
<family catId="3" icon="ability_hunter_pet_boar" id="5" name="Boar"></family>
<family catId="6" icon="ability_hunter_pet_crab" id="8" name="Crab"></family>
<family catId="7" icon="ability_hunter_pet_crocolisk" id="6" name="Crocolisk"></family>
<family catId="9" icon="ability_hunter_pet_gorilla" id="9" name="Gorilla"></family>
<family catId="61" icon="ability_hunter_pet_rhino" id="43" name="Rhino"></family>
<family catId="15" icon="ability_hunter_pet_scorpid" id="20" name="Scorpid"></family>
<family catId="21" icon="ability_hunter_pet_turtle" id="21" name="Turtle"></family>
<family catId="21" icon="ability_hunter_pet_warpstalker" id="32" name="Warp Stalker"></family>
<family catId="62" icon="ability_hunter_pet_worm" id="42" name="Worm"></family>
</petTalentTab>
<petTalentTab key="Ferocity" name="Ferocity" order="0">
<family catId="4" icon="ability_hunter_pet_vulture" id="7" name="Carrion Bird"></family>
<family catId="5" icon="ability_hunter_pet_cat" id="2" name="Cat"></family>
<family catId="59" icon="ability_hunter_pet_corehound" id="45" name="Core Hound"></family>
<family catId="25" icon="ability_hunter_pet_devilsaur" id="39" name="Devilsaur"></family>
<family catId="10" icon="ability_hunter_pet_hyena" id="25" name="Hyena"></family>
<family catId="11" icon="ability_hunter_pet_moth" id="37" name="Moth"></family>
<family catId="13" icon="ability_hunter_pet_raptor" id="11" name="Raptor"></family>
<family catId="58" icon="ability_druid_primalprecision" id="46" name="Spirit Beast"></family>
<family catId="19" icon="ability_hunter_pet_tallstrider" id="12" name="Tallstrider"></family>
<family catId="60" icon="ability_hunter_pet_wasp" id="44" name="Wasp"></family>
<family catId="23" icon="ability_hunter_pet_wolf" id="1" name="Wolf"></family>
</petTalentTab>
</petTalentTabs>
<spells>
<spell description="You master the art of Beast training, teaching you the ability to tame Exotic pets and increasing your total amount of Pet Skill Points by 4." id="53270" name="Beast Mastery"></spell>
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
{{include file="faq_index.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
</div>
{{include file="overall_footer.tpl"}}