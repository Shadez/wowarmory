<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">Edit Configuration</h1>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <a href="?action=config">Go back</a>
    <form id="edit" name="edit" method="post" action="?action=config&subaction=edit">
    <label><span style="color: red;">MySQL connection info:</span></label>
    <label>Armory database host:</label>
    <input type="text" name="host_armory" value="<?php echo Armory::$mysqlconfig['host_armory']; ?>" />
    <label>Armory database user:</label>
    <input type="text" name="user_armory" value="<?php echo Armory::$mysqlconfig['user_armory']; ?>" />
    <label>Armory database user password:</label>
    <input type="text" name="pass_armory" value="<?php echo Armory::$mysqlconfig['pass_armory']; ?>" />
    <label>Armory database name:</label>
    <input type="text" name="name_armory" value="<?php echo Armory::$mysqlconfig['name_armory']; ?>" />
    <label>Armory database charset:</label>
    <input type="text" name="charset_armory" value="<?php echo Armory::$mysqlconfig['charset_armory']; ?>" />
    <br />
    <label>Realmd database host:</label>
    <input type="text" name="host_realmd" value="<?php echo Armory::$mysqlconfig['host_realmd']; ?>" />
    <label>Realmd database user:</label>
    <input type="text" name="user_realmd" value="<?php echo Armory::$mysqlconfig['user_realmd']; ?>" />
    <label>Realmd database user password:</label>
    <input type="text" name="pass_realmd" value="<?php echo Armory::$mysqlconfig['pass_realmd']; ?>" />
    <label>Realmd database name:</label>
    <input type="text" name="name_realmd" value="<?php echo Armory::$mysqlconfig['name_realmd']; ?>" />
    <label>Realmd database charset:</label>
    <input type="text" name="charset_realmd" value="<?php echo Armory::$mysqlconfig['charset_realmd']; ?>" />
    <br />
    <label><span style="color: red;">Armory settings:</span></label>
    
    <label>News support:</label>
    <input type="radio" name="useNews" value="0"<?php echo Armory::$armoryconfig['useNews'] == false ? ' checked="checked"' : null; ?> /> Disabled
    <input type="radio" name="useNews" value="1"<?php echo Armory::$armoryconfig['useNews'] == true ? ' checked="checked"' : null; ?> /> Enabled
    
    <label>Default Battlegroup name:</label>
    <input type="text" name="defaultBGName" value="<?php echo Armory::$armoryconfig['defaultBGName']; ?>" />
    
    <label>Cache support:</label>
    <input type="radio" name="useCache" value="0"<?php echo Armory::$armoryconfig['useCache'] == false ? ' checked="checked"' : null; ?> /> Disabled
    <input type="radio" name="useCache" value="1"<?php echo Armory::$armoryconfig['useCache'] == true ? ' checked="checked"' : null; ?> /> Enabled
    
    <label>Cache lifetime (in seconds):</label>
    <input type="text" name="cache_lifetime" value="<?php echo Armory::$armoryconfig['cache_lifetime']; ?>" />
    
    <label>Armory database prefix (without "_"!):</label>
    <input type="text" name="db_prefix" value="<?php echo Armory::$armoryconfig['db_prefix']; ?>" />
    
    <label>Min. character level to display (0 to disable):</label>
    <input type="text" name="minlevel" value="<?php echo Armory::$armoryconfig['minlevel']; ?>" />
    
    <label>GM Level display filter:</label>
    <select name="minGmLevelToShow">
        <option value="3"<?php echo Armory::$armoryconfig['minGmLevelToShow'] == 3 ? ' selected' : null; ?>>Everyone</option>
        <option value="2"<?php echo Armory::$armoryconfig['minGmLevelToShow'] == 2 ? ' selected' : null; ?>>Everyone except Administrations</option>
        <option value="1"<?php echo Armory::$armoryconfig['minGmLevelToShow'] == 1 ? ' selected' : null; ?>>Everyone except Administrations and GMs</option>
        <option value="0"<?php echo Armory::$armoryconfig['minGmLevelToShow'] == 0 ? ' selected' : null; ?>>Only players</option>
        <option value="-1"<?php echo Armory::$armoryconfig['minGmLevelToShow'] > 3 ? ' selected' : null; ?>>Custom value</option>
    </select>
    <input type="text" name="minGmLevelToShowCustom" value="<?php echo Armory::$armoryconfig['minGmLevelToShow'] > 3 ? Armory::$armoryconfig['minGmLevelToShow'] : 'Or enter custom value'; ?>" />
    
    <label>Disable characters loading from banned accounts</label>
    <input type="radio" name="skipBanned" value="0"<?php echo Armory::$armoryconfig['skipBanned'] == false ? ' checked="checked"' : null; ?> /> Disabled
    <input type="radio" name="skipBanned" value="1"<?php echo Armory::$armoryconfig['skipBanned'] == true ? ' checked="checked"' : null; ?> /> Enabled
    
    <label>Default locale:</label>
    <select name="defaultLocale">
        <option value="en_gb"<?php echo Armory::$armoryconfig['defaultLocale'] == 'en_gb' ? ' selected' : null; ?>>English (EU)</option>
        <option value="en_us"<?php echo Armory::$armoryconfig['defaultLocale'] == 'en_us' ? ' selected' : null; ?>>English (US)</option>
        <option value="de_de"<?php echo Armory::$armoryconfig['defaultLocale'] == 'de_de' ? ' selected' : null; ?>>German</option>
        <option value="es_es"<?php echo Armory::$armoryconfig['defaultLocale'] == 'es_es' ? ' selected' : null; ?>>Spanish</option>
        <option value="fr_fr"<?php echo Armory::$armoryconfig['defaultLocale'] == 'fr_fr' ? ' selected' : null; ?>>French</option>
        <option value="ru_ru"<?php echo Armory::$armoryconfig['defaultLocale'] == 'ru_ru' ? ' selected' : null; ?>>Russian</option>
    </select>
    
    <label>Disable site (maintenance)?</label>
    <input type="radio" name="maintenance" value="1"<?php echo Armory::$armoryconfig['maintenance'] == true ? ' checked' : null; ?> /> Yes
    <input type="radio" name="maintenance" value="0"<?php echo Armory::$armoryconfig['maintenance'] == false ? ' checked' : null; ?> /> No
    
    <label>Debug log feature:</label>
    <input type="radio" name="useDebug" value="1"<?php echo Armory::$armoryconfig['useDebug'] == true ? ' checked' : null; ?> /> Enabled
    <input type="radio" name="useDebug" value="0"<?php echo Armory::$armoryconfig['useDebug'] == false ? ' checked' : null; ?> /> Disabled
    
    <label>Debug log level:</label>
    <select name="logLevel">
        <option value="3"<?php echo Armory::$armoryconfig['logLevel'] == 3 ? ' selected' : null; ?>>Debug + SQL + Errors</option>
        <option value="2"<?php echo Armory::$armoryconfig['logLevel'] == 2 ? ' selected' : null; ?>>Debug + Errors</option>
        <option value="1"<?php echo Armory::$armoryconfig['logLevel'] == 1 ? ' selected' : null; ?>>Errors only</option>
    </select>
    
    <label>How to report about version errors?</label>
    <select name="checkVersionType">
        <option value="show"<?php echo Armory::$armoryconfig['checkVersionType'] == 'show' ? ' selected' : null; ?>>Display all errors and halt script (Recommended)</option>
        <option value="log"<?php echo Armory::$armoryconfig['checkVersionType'] == 'log' ? ' selected' : null; ?>>Write errors to log and continue script work</option>
    </select>
    <br />
    <label><span style="color: red;">Realms configuration</span></label>
    <?php
    foreach(Armory::$realmData as $realm_info) {
        echo sprintf('<label><span style="color: red;">Realm #%d</span></label>
        <label>ID:</label>
        <input type="text" name="realmid_%d" value="%d" />
        <label>Name:</label>
        <input type="text" name="realmname_%d" value="%s" />
        <label>Type:</label>
        <select name="realmtype_%d">
            <option value="1"%s>MaNGOS</option>
            <option value="2"%s>Trinity Core</option>
        </select>
        <label>Characters DB info (in "host;user;password;name;charset" format):</label>
        <input type="text" name="realmchars_%d" value="%s" size="50" />
        <label>World DB info (in "host;user;password;name;charset" format):</label>
        <input type="text" name="realmworld_%d" value="%s" size="50" />
        <br />
        <!--
        TODO
        <a href="?action=config&subaction=removeRealm&id=%d">Remove realm "%s"</a>
        <br />
        -->', $realm_info['id'],
        $realm_info['id'], $realm_info['id'],
        $realm_info['id'], $realm_info['name'],
        $realm_info['id'], $realm_info['type'] == SERVER_MANGOS ? ' selected' : null, $realm_info['type'] == SERVER_TRINITY ? ' selected' : null,
        $realm_info['id'], sprintf('%s;%s;%s;%s;%s', $realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']),
        $realm_info['id'], sprintf('%s;%s;%s;%s;%s', $realm_info['host_world'], $realm_info['user_world'], $realm_info['pass_world'], $realm_info['name_world'], $realm_info['charset_world']),
        $realm_info['id'], $realm_info['name']
        );
    }
    ?>
    <br />
    
    <input type="submit" name="subm" value="Submit" />
    </form>
    <div class="clear"></div><br />
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
