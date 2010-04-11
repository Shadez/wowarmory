/*******            Resistances         ******/
var arcaneTooltip = '<span class="tooltipTitle">Resistencia a lo Arcano '+ theCharacter.resistances.arcane.value + theCharacter.resistances.arcane.breakdown +'</span><span class="tooltipContentSpecial">Aumenta la habilidad de resistir hechizos y habilidades Arcanas.<br/>Resistencia contra el nivel '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.arcane.rank +'</span></span>';
var arcanePetBonus = "<span class = 'tooltipContentSpecial'>Aumenta la resitencia de tu mascota en "+ theCharacter.resistances.arcane.petBonus + "</span>";

var fireTooltip = '<span class="tooltipTitle">Resistencia al Fuego '+ theCharacter.resistances.fire.value + theCharacter.resistances.fire.breakdown +'</span><span class = "tooltipContentSpecial">Aumenta la habilidad de resistir habilidades y hechizos de Fuego.<br/>Resistencia contra el nivel '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.fire.rank +'</span></span>';
var firePetBonus = "<span class = 'tooltipContentSpecial'>Aumenta la resitencia de tu mascota en "+ theCharacter.resistances.fire.petBonus + "</span>";

var natureTooltip = '<span class="tooltipTitle">Resistencia a la Naturaleza '+ theCharacter.resistances.nature.value + theCharacter.resistances.nature.breakdown +'</span><span class = "tooltipContentSpecial">Aumenta la habilidad de resistir habilidades y hechizos de Naturaleza.<br/>Resistencia contra el nivel '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.nature.rank +'</span></span>';
var naturePetBonus = "<span class = 'tooltipContentSpecial'>Aumenta la resistencia de tu mascota en "+ theCharacter.resistances.nature.petBonus + "</span>";

var frostTooltip = '<span class="tooltipTitle">Resistencia a la Escarcha '+ theCharacter.resistances.frost.value + theCharacter.resistances.frost.breakdown +'</span><span class = "tooltipContentSpecial">Aumenta la habilidad de resistir habilidades y hechizos de Escarcha.<br/>Resistencia contra el nivel '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.frost.rank +'</span></span>';
var frostPetBonus = "<span class = 'tooltipContentSpecial'>Aumenta la resitencia de tu mascota en "+ theCharacter.resistances.frost.petBonus + "</span>";

var shadowTooltip = '<span class="tooltipTitle">Resistencia a la Sombras '+ theCharacter.resistances.shadow.value + theCharacter.resistances.shadow.breakdown +'</span><span class = "tooltipContentSpecial">Aumenta la habilidad de resistir habilidades y hechizos de Sombras.<br/>Resistencia contra el nivel '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.shadow.rank +'</span></span>';
var shadowPetBonus = "<span class = 'tooltipContentSpecial'>Aumenta la resitencia de tu mascota en "+ theCharacter.resistances.shadow.petBonus + "</span>";

/*******            Resistances End       ******/


/*******            Base Stats       ******/

var baseStatsDisplay = "Estadísticas básicas";

var baseStatsStrengthTitle = "Fuerza ";
var baseStatsStrengthAttack = "Aumento del poder de ataque en "+theCharacter.baseStats.strength.attack;
var baseStatsStrengthBlock = "Incrementa el bloqueo en "+theCharacter.baseStats.strength.block+" <br/>";
var baseStatsStrengthDisplay = "Fuerza: ";

var baseStatsAgilityTitle = "Agilidad ";
var baseStatsAgilityAttack = "Incrementa el poder de ataque  "+theCharacter.baseStats.agility.attack;
var baseStatsAgilityCritHitPercent = "Incremento de la posiblidad de impacto crítico en "+ theCharacter.baseStats.agility.critHitPercent +"%";
var baseStatsAgilityArmor = "Incrementa la armadura en "+ theCharacter.baseStats.agility.armor;
var baseStatsAgilityDisplay = "Agilidad: ";

var baseStatsStaminaTitle = "Aguante ";
var baseStatsStaminaHealth = "Aumenta la salud en "+ theCharacter.baseStats.stamina.health;
var baseStatsStaminaPetBonus = "Aumenta el aguante de la mascota en "+ theCharacter.baseStats.stamina.petBonus;
var baseStatsStaminaDisplay = "Aguante: ";

var baseStatsIntellectTitle = "Intelecto ";
var baseStatsIntellectMana = "Incrementa el maná en "+ theCharacter.baseStats.intellect.mana;
var baseStatsIntellectCritHitPercent = "Aumenta el golpe crítico con hechizo en "+ theCharacter.baseStats.intellect.critHitPercent + "%";
var baseStatsIntellectPetBonus = "Aumenta el intelecto de tu mascota en "+ theCharacter.baseStats.intellect.petBonus;
var baseStatsIntellectDisplay = "Intelecto: ";

var baseStatsSpiritTitle = "Espíritu ";
var baseStatsSpiritHealthRegen = "Aumenta la regenaración de salud en "+ theCharacter.baseStats.spirit.healthRegen +" por segundo cuando no estás en combate";
var baseStatsSpiritManaRegen = "Aumenta la regeneración de maná en "+ theCharacter.baseStats.spirit.manaRegen +" durante 5 segundos cuando no se está lazando hechizo";
var baseStatsSpiritDisplay = "Espíritu: ";

var baseStatsArmorTitle = "Armadura ";
var baseStatsArmorReductionPercent = "Reduce el daño físico sufrido en "+ theCharacter.baseStats.armor.reductionPercent +"%";
var baseStatsArmorPetBonus = "Aumenta la armadura de tu mascota en "+ theCharacter.baseStats.armor.petBonus;
var baseStatsArmorDisplay = "Armadura: ";

/*******            Base Stats  End     ******/


/*******            Melee     ******/

var meleeDisplay = "Cuerpo a cuerpo";

var meleeMainHandTitle = "Mano derecha";
var meleeOffHandTitle = "Mano izquierda";

var meleeExpertiseTitle = "Pericia "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.rating;
var meleeMainHandWeaponSkill = "Reduce la probabilidad de que tus ataques sean esquivados o parados en "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.percent + "%";
var meleeMainHandWeaponRating = "Índice de pericia "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.value + " (+"+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.additional +" de pericia)";
/*var meleeOffHandWeaponSkill = "Habilidad con arma "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.value;
var meleeOffHandWeaponRating = "[Índice de habilidad con arma "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.rating;*/
var meleeWeaponSkillDisplay = "Pericia: ";

var meleeDamageMainHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.speed +"</span>Velocidad de ataque (segundos):<br/>";
var meleeDamageMainHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;
var meleeDamageMainHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.mainHandDamage.percent +"%</span>";
var meleeDamageDisplay = "Daño: ";

var meleeDamageMainHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.dps +"</span>Daño por segundo:";
var meleeDamageOffHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.speed +"</span>Velocidad de atauqe (segundos):<br/>";
var meleeDamageOffHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.min +" - "+ theCharacter.melee.damage.offHandDamage.max;
var meleeDamageOffHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.offHandDamage.percent +"%</span>";
var meleeDamageOffHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.dps +"</span>Daño por segundo:<br/>";

var meleeSpeedTitle = "Velocidad de ataque ";
var meleeSpeedHaste = "Índice de celeridad "+ theCharacter.melee.speed.mainHandSpeed.hasteRating +" ("+theCharacter.melee.speed.mainHandSpeed.hastePercent+"% de celeridad)";
var meleeSpeedDisplay = "Velocidad: ";

var meleePowerTitle = "Poder de ataque cuerpo a cuerpo ";
var meleePowerIncreasedDps = "Aumenta el daño con armas cuerpo a cuerpo en "+ theCharacter.melee.power.increasedDps +" de daño por segundo.";
var meleePowerDisplay = "Poder: ";

var meleeHitRatingTitle = "Índice de golpe ";
var meleeHitRatingIncreasedHitPercent = "Aumenta tu probabilidad de acierto cuerpo a cuerpo con un objetivo de nivel "+ theCharacter.level +" en un "+theCharacter.melee.hitRating.increasedHitPercent +"% <br/>Índice de penetración de armadura " + theCharacter.melee.hitRating.armorPenetration + "La aramdura del enemigo se reduce en " + theCharacter.melee.hitRating.reducedArmorPercent + "%).";
var meleeHitRatingDisplay = "Índice de golpe: ";

var meleeCritChanceTitle = "Probabilidad de crítico ";
var meleeCritChanceRating = "Probabilidad de crítico: "+theCharacter.melee.critChance.rating+" (+"+theCharacter.melee.critChance.plusPercent+"% prob. golpe crítico)";
var meleeCritChanceDisplay = "Probabilidad de crítico: ";

/*******            Melee  End     ******/


/*******            Ranged     ******/

var rangedDisplay = "A distancia";
var rangedWeaponSkillTitle = "Habilidad con arma ";
var rangedWeaponSkillRating = "Índice de habilidad con arma: "+ theCharacter.ranged.weaponSkill.rating;
var rangedWeaponSkillDisplay = "Habilidad con arma: ";

var rangedDamageTitle = "Daño a distancia";
var rangedDamageSpeed = "<span class='floatRight'>"+ theCharacter.ranged.damage.speed +"</span>Velocidad de ataque (segundos):<br/>";
var rangedDamageDamage = "<span class='floatRight'>"+ theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max;
var rangedDamageDamagePercent = " <span "+ theCharacter.ranged.damage.effectiveColor +"> x "+ theCharacter.ranged.damage.percent +"%</span><br/>";
var rangedDamageDisplay = "Daño: ";
var rangedDamageDps = "<span class='floatRight'>"+ theCharacter.ranged.damage.dps +"</span>Daño por segundo:";

var rangedSpeedTitle = "Velocidad de ataque"+theCharacter.ranged.speed.value;
var rangedSpeedHaste = "Índice de celeridad "+ theCharacter.ranged.speed.hasteRating +" ("+theCharacter.ranged.speed.hastePercent+"% de celeridad)";
var rangedSpeedDisplay = "Velocidad: ";

var rangedPowerTitle = "Poder de ataque a distancia ";
var rangedPowerIncreasedDps = "Aumenta el daño con armas de ataque a distancia "+ theCharacter.ranged.power.increasedDps +" daño por segundo.";
var rangedPowerPetAttack = "Aumenta el poder de tu mascota en "+ theCharacter.ranged.power.petAttack;
var rangedPowerPetSpell = "Aumenta el daño por hechizo de tu mascota en "+ theCharacter.ranged.power.petSpell;
var rangedPowerDisplay = "Poder: ";

var rangedHitRatingTitle = "Índice de golpe ";
var rangedHitRatingIncreasedPercent = "Aumenta tu probabilidad de acierto cuerpo a cuerpo con un objetivo de nivel "+ theCharacter.level +" en un "+theCharacter.ranged.hitRating.increasedHitPercent +"% <br/>Índice de penetración de armadura " + theCharacter.ranged.hitRating.armorPenetration + "(Armadura del enemigo reducida hasta un " + theCharacter.ranged.hitRating.reducedArmorPercent + "%).";
var rangedHitRatingDisplay = "Índice de golpe: ";

var rangedCritChanceTitle = "Prob. de golpe crítico ";
var rangedCritChanceRating = "Prob. de golpe crítico "+theCharacter.ranged.critChance.rating+" (+"+theCharacter.ranged.critChance.plusPercent+"% de golpe crítico)";
var rangedCritChanceDisplay = "Prob. de golpe crítico: ";

/*******            Ranged  End     ******/


/*******            Spell     ******/

var spellDisplay = "Hechizo";
var spellBonusDamageTitle = "Bon. daño ";
var spellBonusDamagePetBonusFire = "<br />Tu daño de Fuego aumenta <br />el poder de ataque de tu mascota en "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />y el daño de hechizo en  "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamagePetBonusShadow = "<br />Tu daño de Sombras aumenta <br />el poder de ataque de tu mascota en "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />y el daño de hechizo en  "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamageDisplay = "Bon. daño: ";

var spellBonusHealingTitle = "Bon. sanación ";
var spellBonusHealingValue = "Incrementa tu sanación hasta "+theCharacter.spell.bonusHealing.value;
var spellBonusHealingDisplay = "Bon. sanación: ";

var spellHitRatingTitle = "Índice de golpe ";
var spellHitRatingIncreasedPercent = "Aumenta tu probabilidad de acierto cuerpo a cuerpo con un objetivo de nivel "+ theCharacter.level +" en un "+theCharacter.spell.hitRating.increasedHitPercent;
var spellHitRatingDisplay = "Índice de golpe: ";

var spellCritChanceTitle = "Prob. de golpe crítico ";
var spellCritChanceDisplay = "Prob. de golpe crítico: ";

var spellHasteRatingTitle = "Índice de celeridad";
var spellHasteRatingDisplay = "Índice de celeridad: ";
var spellHasteRatingTooltip = "Aumenta la velocidad de lanzamiento de tus hechizos en un " + theCharacter.spell.hasteRating.percent + "%.";

var spellPenetrationTitle = "Penetración ";
var spellPenetrationTooltip = "<br />Penetración del hechizo " + theCharacter.spell.hitRating.spellPenetration + " (Reduce la resistencia del enemigo en un " + theCharacter.spell.hitRating.spellPenetration + ")";
var spellPenetrationDisplay = "Penetración: ";

var spellManaRegenTitle = "Regeneración de maná ";
var spellManaRegenNotCasting = theCharacter.spell.manaRegen.notCasting +" de maná regenerado cada 5 segundos mientras no se está lanzando hechizos";
var spellManaRegenCasting = theCharacter.spell.manaRegen.casting +" de maná regenerado cada 5 segundos mientras se lanza hechizos";
var spellManaRegenDisplay = "Regeneración de maná: ";

/*******            Spell  End     ******/

/*******            Defenses     ******/

var defensesDisplay = "Defensa";

var defensesDefenseTitle = "Defensa ";
var defensesDefenseRating = "Índice de defensa "+ theCharacter.defenses.defense.rating +" (+"+ theCharacter.defenses.defense.plusDefense +" Defensa)";
var defensesDefenseIncreasePercent = "Aumenta la probabilidad de esquivar, bloquear o parar en  "+ theCharacter.defenses.defense.increasePercent +"%";
var defensesDefenseDecreasePercent = "Disminuye la probabilidad de recibir golpes y golpes críticos en "+ theCharacter.defenses.defense.decreasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDefenseDisplay = "Defensa: ";

var defensesDodgeTitle = "Índice de esquivar ";
var defensesDodgePercent = "Aumenta tu posibilidad de esquivar en "+ theCharacter.defenses.dodge.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDodgeDisplay = "Esquivar: ";

var defensesParryTitle = "Índice de parada ";
var defensesParryPercent = "Aumenta tu posibilidad de parar en "+ theCharacter.defenses.parry.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesParryDisplay ="Parada: ";

var defensesBlockTitle = "Índice de bloqueo ";
var defensesBlockPercent = "Aumenta tu posibilidad de bloquear en "+ theCharacter.defenses.block.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesBlockDisplay = "Bloqueo: ";

var defensesResilienceTitle = "Temple ";
var defensesResilienceHitPercent = "Reduce el daño periódico y la probabilidad de recibir un golpe crítico en un "+ theCharacter.defenses.resilience.hitPercent +"%.";
var defensesResilienceDamagePercent = "Reduce el efecto de drenaje de maná y el daño de golpes críticos en un "+ theCharacter.defenses.resilience.damagePercent +"%.";
var defensesResilienceDisplay = "Temple: ";

/*******            Defenses  End     ******/

var textNA = "N/A";
var textNotApplicable = "No aplicable";

var textHoly = "Sagrado";
var textFire = "Fuego";
var textNature = "Naturaleza";
var textFrost = "Escarcha";
var textShadow = "Sombras";
var textArcane = "Arcano";

var textHybrid = "Híbrido";
var textUntalented = "Sin talentos";

var textRating = "Calificación ";
var textNotRanked = "No clasificado";
var textStandingColon = "Clasificación semana pasada:";
var textRatingColon = "Calificación:";
var text2v2Arena = "Arena 2c2";
var text3v3Arena = "Arena 3c3";
var text5v5Arena = "Arena 5c5";
var textTeamNameColon = "Nombre de equipo:";

var textFindUpgrade = "Buscar mejora";

var textLoading = "Cargando...";

/*******  ******/
var textHead = "Cabeza";
var textNeck = "Cuello";
var textShoulders = "Hombros";
var textBack = "Espalda";
var textChest = "Pecho";
var textShirt = "Camisa";
var textTabard = "Tabardo";
var textWrists = "Muñecas";
var textHands = "Manos";
var textWaist = "Cintura";
var textLegs = "Piernas";
var textFeet = "Pies";
var textFinger = "Dedo";
var textTrinket = "Alhaja";
var textMainHand = "Mano derecha";
var textOffHand = "Mano izquierda";
var textRanged = "Arma a distancia";
var textRelic = "Reliquia";
jsLoaded=true;