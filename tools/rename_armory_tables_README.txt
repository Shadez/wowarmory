This script renames tables in armory database (only armory tables which listed in this file!) to new name with new prefix.
Open http://armory_url/tools/rename_armory_tables.php, set new prefix and execute script.
If you want to execute all queries automatically, open php file and change $update_type value to 'query'.

IMPORTANT: when queries are executed to DB, you need to change $ArmoryConfig['settings']['db_prefix'] to new value!
Also, in security reasons you should rename, move or remove this file from your web server.

_______________________________________

Данный скрипт переименовывает таблицы в базе Оружейной (только таблицы, приведенные в этом файле!) на новое имя с новым префиксом.
Откройте http://armory_url/tools/rename_armory_tables.php в браузере, задайте новый префикс и нажимите "Start rename".
Если вы хотите автоматически выполнить все запросы, откройте php файл и измените значение переменной $update_type на 'query'.

ВАЖНО: после того, как запросы будут выполнены, вам необходимо изменить значение параметра $ArmoryConfig['settings']['db_prefix'] на новый префикс!
Так же, в плане безопасности, вам следует переименовать/переместить или удалить этот файл с веб сервера после того, как операция будет выполнена.

==============
Armory tables:
==============

armory_achievement
armory_achievement_category
armory_achievement_criteria
armory_bookmarks
armory_classes
armory_db_version
armory_enchantment
armory_extended_cost
armory_faction
armory_gemproperties
armory_glyphproperties
armory_icons
armory_instance_data
armory_instance_template
armory_item_equivalents
armory_item_sources
armory_itemdisplayinfo
armory_itemsetdata
armory_itemsetinfo
armory_itemsubclass
armory_login_characters
armory_maps
armory_news
armory_petcalc
armory_professions
armory_races
armory_randomproperties
armory_randompropertypoints
armory_randomsuffix
armory_rating
armory_realm_data
armory_skills
armory_source
armory_spell
armory_spell_duration
armory_spellenchantment
armory_ssd
armory_ssv
armory_string
armory_talent_icons
armory_talents
armory_talenttab
armory_titles