/*******            Resistances         ******/
var arcaneTooltip = '<span class="tooltipTitle">Сопротивление тайной магии '+ theCharacter.resistances.arcane.value + theCharacter.resistances.arcane.breakdown +'</span><span class="tooltipContentSpecial">Увеличивает сопротивление тайной магии.<br/>Сопротивление уровню '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.arcane.rank +'</span></span>';
var arcanePetBonus = "<span class = 'tooltipContentSpecial'>Увеличивает сопротивление вашего питомца на "+ theCharacter.resistances.arcane.petBonus + "</span>";

var fireTooltip = '<span class="tooltipTitle">Сопротивлении магии огня '+ theCharacter.resistances.fire.value + theCharacter.resistances.fire.breakdown +'</span><span class = "tooltipContentSpecial">Увеличивает сопротивление магии огня.<br/>Сопротивление уровню '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.fire.rank +'</span></span>';
var firePetBonus = "<span class = 'tooltipContentSpecial'>Увеличивает сопротивление вашего питомца на "+ theCharacter.resistances.fire.petBonus + "</span>";

var natureTooltip = '<span class="tooltipTitle">Сопротивление силам природы '+ theCharacter.resistances.nature.value + theCharacter.resistances.nature.breakdown +'</span><span class = "tooltipContentSpecial">Увеличивает сопротивление силам природы.<br/>Сопротивление уровню '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.nature.rank +'</span></span>';
var naturePetBonus = "<span class = 'tooltipContentSpecial'>Увеличивает сопротивление вашего питомца на "+ theCharacter.resistances.nature.petBonus + "</span>";

var frostTooltip = '<span class="tooltipTitle">Сопротивление магии льда '+ theCharacter.resistances.frost.value + theCharacter.resistances.frost.breakdown +'</span><span class = "tooltipContentSpecial">Увеличивает сопротивление магии льда.<br/>Сопротивление уровню '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.frost.rank +'</span></span>';
var frostPetBonus = "<span class = 'tooltipContentSpecial'>Увеличивает сопротивление вашего питомца на "+ theCharacter.resistances.frost.petBonus + "</span>";

var shadowTooltip = '<span class="tooltipTitle">Сопротивление темной магии '+ theCharacter.resistances.shadow.value + theCharacter.resistances.shadow.breakdown +'</span><span class = "tooltipContentSpecial">Увеличивает сопротивление темной магии.<br/>Сопротивление уровню '+ theCharacter.level +': <span class="myWhite">'+ theCharacter.resistances.shadow.rank +'</span></span>';
var shadowPetBonus = "<span class = 'tooltipContentSpecial'>Увеличивает сопротивление вашего питомца на "+ theCharacter.resistances.shadow.petBonus + "</span>";

/*******            Resistances End       ******/


/*******            Base Stats       ******/

var baseStatsDisplay = "Базовые характеристики";

var baseStatsStrengthTitle = "Сила ";
var baseStatsStrengthAttack = "Увеличивает силу атаки на "+theCharacter.baseStats.strength.attack;
var baseStatsStrengthBlock = "Увеличивает блок на "+theCharacter.baseStats.strength.block+" <br/>";
var baseStatsStrengthDisplay = "Сила: ";

var baseStatsAgilityTitle = "Ловкость ";
var baseStatsAgilityAttack = "Увеличивает силу атаки на "+theCharacter.baseStats.agility.attack;
var baseStatsAgilityCritHitPercent = "Увеличивает вероятность критического удара "+ theCharacter.baseStats.agility.critHitPercent +"%";
var baseStatsAgilityArmor = "Увеличивает броню на "+ theCharacter.baseStats.agility.armor;
var baseStatsAgilityDisplay = "Ловкость: ";

var baseStatsStaminaTitle = "Выносливость ";
var baseStatsStaminaHealth = "Увеличивает здоровье на "+ theCharacter.baseStats.stamina.health;
var baseStatsStaminaPetBonus = "Увеличивает выносливость питомца на "+ theCharacter.baseStats.stamina.petBonus;
var baseStatsStaminaDisplay = "Выносливость: ";

var baseStatsIntellectTitle = "Интеллект ";
var baseStatsIntellectMana = "Увеличивает ману на "+ theCharacter.baseStats.intellect.mana;
var baseStatsIntellectCritHitPercent = "Увеличивает вероятность критического поражения заклинаниями "+ theCharacter.baseStats.intellect.critHitPercent + "%";
var baseStatsIntellectPetBonus = "Увеличивает интеллект вашего питомца на "+ theCharacter.baseStats.intellect.petBonus;
var baseStatsIntellectDisplay = "Интеллект: ";

var baseStatsSpiritTitle = "Дух ";
var baseStatsSpiritHealthRegen = "Увеличивает восполнение здоровья на "+ theCharacter.baseStats.spirit.healthRegen +" ед./с вне боя.";
var baseStatsSpiritManaRegen = "Увеличивает восполнение маны на "+ theCharacter.baseStats.spirit.manaRegen +" ед. каждые 5 с в свободное от чтения заклинаний время";
var baseStatsSpiritDisplay = "Дух: ";

var baseStatsArmorTitle = "Броня ";
var baseStatsArmorReductionPercent = "Уменьшает получаемый физический урон на "+ theCharacter.baseStats.armor.reductionPercent +"%";
var baseStatsArmorPetBonus = "Увеличивает броню вашего питомца на "+ theCharacter.baseStats.armor.petBonus;
var baseStatsArmorDisplay = "Броня: ";

/*******            Base Stats  End     ******/


/*******            Melee     ******/

var meleeDisplay = "Ближний бой";

var meleeMainHandTitle = "Правая рука";
var meleeOffHandTitle = "Левая рука";

var meleeExpertiseTitle = "Мастерство "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.rating;
var meleeMainHandWeaponSkill = "Уменьшает вероятность того, что противник парирует ваш удар или увернется от него, на "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.percent + "%";
var meleeMainHandWeaponRating = "Рейтинг мастерства "+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.value + " (+"+ theCharacter.melee.weaponSkill.mainHandWeaponSkill.additional +" ед. мастерства)";
/*var meleeOffHandWeaponSkill = "Weapon Skill "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.value;
var meleeOffHandWeaponRating = "Weapon Skill Rating "+ theCharacter.melee.weaponSkill.offHandWeaponSkill.rating;*/
var meleeWeaponSkillDisplay = "Мастерство: ";

var meleeDamageMainHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.speed +"</span>Скорость атаки (с):<br/>";
var meleeDamageMainHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.min +" - "+ theCharacter.melee.damage.mainHandDamage.max;
var meleeDamageMainHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.mainHandDamage.percent +"%</span>";
var meleeDamageDisplay = "Урон: ";

var meleeDamageMainHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.mainHandDamage.dps +"</span>УВС:";
var meleeDamageOffHandAttackSpeed = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.speed +"</span>Attack Speed (seconds):<br/>";
var meleeDamageOffHandDamage = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.min +" - "+ theCharacter.melee.damage.offHandDamage.max;
var meleeDamageOffHandPercent = " <span "+ theCharacter.melee.damage.mainHandDamage.effectiveColor +"> x "+ theCharacter.melee.damage.offHandDamage.percent +"%</span>";
var meleeDamageOffHandDps = "<span class='floatRight'>"+ theCharacter.melee.damage.offHandDamage.dps +"</span>УВС:<br/>";

var meleeSpeedTitle = "Скорость атаки ";
var meleeSpeedHaste = "Скорость боя "+ theCharacter.melee.speed.mainHandSpeed.hasteRating +" ("+theCharacter.melee.speed.mainHandSpeed.hastePercent+"% haste)";
var meleeSpeedDisplay = "Скорость: ";

var meleePowerTitle = "Сила атаки в ближнем бою ";
var meleePowerIncreasedDps = "Увеличивает урон, наносимый оружием ближнего боя, на "+ theCharacter.melee.power.increasedDps +" увс.";
var meleePowerDisplay = "Сила атаки";

var meleeHitRatingTitle = "Рейтинг меткости ";
var meleeHitRatingIncreasedHitPercent = "Увеличивает вероятность попасть по цели оружием ближнего боя "+ theCharacter.level +" на "+theCharacter.melee.hitRating.increasedHitPercent +"% <br/>Рейтинг пробивания брони " + theCharacter.melee.hitRating.armorPenetration + " (Броня противника снижена на " + theCharacter.melee.hitRating.reducedArmorPercent + "%).";
var meleeHitRatingDisplay = "Рейтинг меткости: ";

var meleeCritChanceTitle = "Критический удар ";
var meleeCritChanceRating = "Рейтинг критического урона "+theCharacter.melee.critChance.rating+" (+"+theCharacter.melee.critChance.plusPercent+"% вероятности нанести критический урон)";
var meleeCritChanceDisplay = "Критический удар: ";

/*******            Melee  End     ******/


/*******            Ranged     ******/

var rangedDisplay = "Оружие дальнего боя";
var rangedWeaponSkillTitle = "Навык владения оружием ";
var rangedWeaponSkillRating = "Рейтинг владения оружием "+ theCharacter.ranged.weaponSkill.rating;
var rangedWeaponSkillDisplay = "Навык владения оружием: ";

var rangedDamageTitle = "Дальний бой";
var rangedDamageSpeed = "<span class='floatRight'>"+ theCharacter.ranged.damage.speed +"</span>Скорость атаки (с):<br/>";
var rangedDamageDamage = "<span class='floatRight'>"+ theCharacter.ranged.damage.min +" - "+ theCharacter.ranged.damage.max;
var rangedDamageDamagePercent = " <span "+ theCharacter.ranged.damage.effectiveColor +"> x "+ theCharacter.ranged.damage.percent +"%</span><br/>";
var rangedDamageDisplay = "Урон: ";
var rangedDamageDps = "<span class='floatRight'>"+ theCharacter.ranged.damage.dps +"</span>УВС: ";

var rangedSpeedTitle = "Скорость атаки "+theCharacter.ranged.speed.value;
var rangedSpeedHaste = "Скорость атаки "+ theCharacter.ranged.speed.hasteRating +" ("+theCharacter.ranged.speed.hastePercent+"% к атаке)";
var rangedSpeedDisplay = "Скорость: ";

var rangedPowerTitle = "Сила атаки дальнего боя ";
var rangedPowerIncreasedDps = "Увеличивает урон, наносимый оружием дальнего боя на "+ theCharacter.ranged.power.increasedDps +" УВС.";
var rangedPowerPetAttack = "Увеличивает силу атаки вашего питомца на "+ theCharacter.ranged.power.petAttack;
var rangedPowerPetSpell = "Увеличивает урон от заклинаний вашего питомца на "+ theCharacter.ranged.power.petSpell;
var rangedPowerDisplay = "Сила атаки: ";

var rangedHitRatingTitle = "Рейтинг меткости ";
var rangedHitRatingIncreasedPercent = "Увеличивает вероятность попасть из оружия дальнего боя по цели уровня "+ theCharacter.level +" на "+theCharacter.ranged.hitRating.increasedHitPercent +"% <br/>Рейтинг пробивания брони " + theCharacter.ranged.hitRating.armorPenetration + " (Броня противника снижена на " + theCharacter.ranged.hitRating.reducedArmorPercent + "%).";
var rangedHitRatingDisplay = "Рейтинг меткости: ";

var rangedCritChanceTitle = "Критический удар ";
var rangedCritChanceRating = "Рейтинг критического урона "+theCharacter.ranged.critChance.rating+" (+"+theCharacter.ranged.critChance.plusPercent+"% вероятности нанесения критического урона)";
var rangedCritChanceDisplay = "Критический удар: ";

/*******            Ranged  End     ******/


/*******            Spell     ******/

var spellDisplay = "Заклинания";
var spellBonusDamageTitle = "Дополнительный урон ";
var spellBonusDamagePetBonusFire = "<br />Ваш урон от магии огня увеличивает<br />силу атаки вашего питомца на "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />, а урон от заклинаний - на "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamagePetBonusShadow = "<br />Ваш урон от магии тьмы увеличивает<br />силу атаки вашего питомца на "+theCharacter.spell.bonusDamage.petBonusAttack +"<br />, а урон от заклинаний - на "+theCharacter.spell.bonusDamage.petBonusDamage +"<br/>";
var spellBonusDamageDisplay = "Дополнительный урон:";

var spellBonusHealingTitle = "Доп. лечение ";
var spellBonusHealingValue = "Увеличивает эффект ваших целительских заклинаний на "+theCharacter.spell.bonusHealing.value;
var spellBonusHealingDisplay = "Доп. лечение: ";

var spellHitRatingTitle = "Рейтинг меткости ";
var spellHitRatingIncreasedPercent = "Увеличивает вероятность попадания в цель уровня "+ theCharacter.level +" на "+theCharacter.spell.hitRating.increasedHitPercent +"%";
var spellHitRatingDisplay = "Рейтинг меткости: ";

var spellCritChanceTitle = "Рейтинг критического урона ";
var spellCritChanceDisplay = "Критический удар: ";

var spellHasteRatingTitle = "Рейтинг скорости боя";
var spellHasteRatingDisplay = "Рейтинг скорости боя: ";
var spellHasteRatingTooltip = "Увеличивает рейтинг скорости чтения заклинаний на " + theCharacter.spell.hasteRating.percent + "%.";

var spellPenetrationTitle = "Проникающая способность ";
var spellPenetrationTooltip = "<br />Проникающая способность " + theCharacter.spell.hitRating.spellPenetration + " (Снижает сопротивляемость противника магиям на " + theCharacter.spell.hitRating.spellPenetration + ")";
var spellPenetrationDisplay = "Проникающая способность: ";

var spellManaRegenTitle = "Восполнение маны ";
var spellManaRegenNotCasting = theCharacter.spell.manaRegen.notCasting +" ед. маны восполняется каждые 5 с во время, свободное от произнесения заклинаний ";
var spellManaRegenCasting = theCharacter.spell.manaRegen.casting +" ед. маны восполняется каждые 5 с во время произнесения заклинаний";
var spellManaRegenDisplay = "Восполнение маны: ";

/*******            Spell  End     ******/

/*******            Defenses     ******/

var defensesDisplay = "Защита";

var defensesDefenseTitle = "Защита ";
var defensesDefenseRating = "Рейтинг защиты "+ theCharacter.defenses.defense.rating +" (+"+ theCharacter.defenses.defense.plusDefense +" ед. защиты)";
var defensesDefenseIncreasePercent = "Увеличивает вероятность увернуться, блокировать или парировать удар на "+ theCharacter.defenses.defense.increasePercent +"%";
var defensesDefenseDecreasePercent = "Снижает вероятность получить урон и критический урона на "+ theCharacter.defenses.defense.decreasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDefenseDisplay = "Защита: ";

var defensesDodgeTitle = "Рейтинг уклонения ";
var defensesDodgePercent = "Увеличивает вероятность уклониться от удара на "+ theCharacter.defenses.dodge.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesDodgeDisplay = "Уклонение: ";

var defensesParryTitle = "Парирование ";
var defensesParryPercent = "Увеличивает вероятность парировать удар на"+ theCharacter.defenses.parry.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesParryDisplay ="Парирование: ";

var defensesBlockTitle = "Рейтинг блока ";
var defensesBlockPercent = "Увеличивает вероятность блокировать удар на "+ theCharacter.defenses.block.increasePercent +"%" + "<br/>" + beforeDiminishingReturns;
var defensesBlockDisplay = "Блок: ";

var defensesResilienceTitle = "Устойчивость ";
var defensesResilienceHitPercent = "Периодический урон и вероятность получить критический удар понижен на  "+ theCharacter.defenses.resilience.hitPercent +"%.";
var defensesResilienceDamagePercent = "Эффективность похищения маны и критического урона понижена на "+ theCharacter.defenses.resilience.damagePercent +"%.";
var defensesResilienceDisplay = "Устойчивость: ";

/*******            Defenses  End     ******/

var textNA = "Н/Д";
var textNotApplicable = "Недоступно";

var textHoly = "Магия света";
var textFire = "Магия огня";
var textNature = "Силы природы";
var textFrost = "Магия льда";
var textShadow = "Магия тьмы";
var textArcane = "Тайная магия";

var textHybrid = "Гибрид";
var textUntalented = "Нет талантов";

var textRating = "Рейтинг ";
var textNotRanked = "Нет рейтинга";
var textStandingColon = "Рейтинг на прошлой неделе:";
var textRatingColon = "Рейтинг:";
var text2v2Arena = "Арена 2v2";
var text3v3Arena = "Арена 3v3";
var text5v5Arena = "Арена 5v5";
var textTeamNameColon = "Название команды:";

var textFindUpgrade = "Найти предмет рангом выше";

var textLoading = "Загрузка...";


var textHead = "Голова";
var textNeck = "Шея";
var textShoulders = "Плечи";
var textBack = "Спина";
var textChest = "Грудь";
var textShirt = "Рубашка";
var textTabard = "Гербовая накидка";
var textWrists = "Кисти рук";
var textHands = "Руки";
var textWaist = "Пояс";
var textLegs = "Ноги";
var textFeet = "Ступни";
var textFinger = "Палец";
var textTrinket = "Аксессуар";
var textMainHand = "Правая рука";
var textOffHand = "Левая рука";
var textRanged = "Дальний бой";
var textRelic = "Реликвия";
jsLoaded=true;