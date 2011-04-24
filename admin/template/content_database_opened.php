<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">Database <?php
    if(isset($_GET['realm']) && isset($_GET['name']) && isset(Armory::$realmData[$_GET['realm']])) {
        echo '`' . $_GET['name'] . '` (' . Armory::$realmData[$_GET['realm']]['name'] . ')';
    }
    ?></h1>
    <a href="?action=database">Go Back</a>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <?php
    $list = Template::GetPageData('tables_list');
    if(is_array($list)) {
        foreach($list as $table) {
            echo sprintf('<a href="?action=database&subaction=open&type=%s&name=%s&realm=%d&table=%s">%s</a><br />', $_GET['type'], $_GET['name'], $_GET['realm'], $table, $table);
        }
    }
    ?>
    <div class="clear"></div><br />
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
