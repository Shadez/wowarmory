<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">Database</h1>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <?php
    foreach(Armory::$realmData as $realm_info) {
        echo sprintf('<h3>Realm: %s (type: %s)</h3><a href="?action=database&subaction=open&type=characters&name=%s&realm=%d">Open <strong>"%s"</strong> database (characters)</a><br />
        <a href="?action=database&subaction=open&type=world&name=%s&realm=%d">Open <strong>"%s"</strong> database (world)</a><br /><br />', $realm_info['name'], $realm_info['type'] == SERVER_MANGOS ? 'MaNGOS' : 'TrinityCore', $realm_info['name_characters'], $realm_info['id'], $realm_info['name_characters'], $realm_info['name_world'], $realm_info['id'], $realm_info['name_world']);
    }
    ?>
    <div class="clear"></div><br />
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
