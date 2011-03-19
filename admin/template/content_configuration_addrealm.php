<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">Add Realm</h1>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <a href="?action=config">Go back</a>
    <form id="edit" name="edit" action="?action=config&subaction=addrealm" method="post">
    <label>Realm ID (do not change!):</label>
    <input type="text" name="realmID" value="<?php echo count(Armory::$realmData) + 1; ?>" />
    <label>Realm Name:</label>
    <input type="text" name="realmName" value="" />
    <label>Realm Type:</label>
    <select name="realmType">
        <option value="1">MaNGOS</option>
        <option value="2">Trinity Core</option>
    </select>
    <br />
    <br />
    <label>Characters MySQL DB host:</label>
    <input type="text" name="realmCharsHost" value="<?php echo Armory::$mysqlconfig['host_armory']; ?>" />
    <label>Characters MySQL DB user:</label>
    <input type="text" name="realmCharsUser" value="<?php echo Armory::$mysqlconfig['user_armory']; ?>" />
    <label>Characters MySQL DB user password:</label>
    <input type="text" name="realmCharsPassword" value="<?php echo Armory::$mysqlconfig['pass_armory']; ?>" />
    <label>Characters MySQL DB name:</label>
    <input type="text" name="realmCharsName" />
    <label>Characters MySQL DB charset:</label>
    <input type="text" name="realmCharsCharset" value="UTF8" />
    <br />
    <label>World MySQL DB host:</label>
    <input type="text" name="realmWorldHost" value="<?php echo Armory::$mysqlconfig['host_armory']; ?>" />
    <label>World MySQL DB user:</label>
    <input type="text" name="realmWorldUser" value="<?php echo Armory::$mysqlconfig['user_armory']; ?>" />
    <label>World MySQL DB user password:</label>
    <input type="text" name="realmWorldPassword" value="<?php echo Armory::$mysqlconfig['pass_armory']; ?>" />
    <label>World MySQL DB name:</label>
    <input type="text" name="realmWorldName" />
    <label>World MySQL DB charset:</label>
    <input type="text" name="realmWorldCharset" value="UTF8" />
    <br />
    <input type="submit" name="subm" value="Submit" />
    </form>
    <div class="clear"></div><br />
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
