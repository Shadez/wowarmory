<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">News Manager</h1>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <?php
    $news_item = Template::GetPageData('news_item');
    if(is_array($news_item)) {
        $title = '';
        if(isset($news_item['title_' . Armory::GetLocale()]) && $news_item['title_' . Armory::GetLocale()] != null) {
            $title = $news_item['title_' . Armory::GetLocale()];
        }
        else {
            $title = isset($news_item['title_en_gb']) ? $news_item['title_en_gb'] : null;
        }
        echo '<h2>' . $title . '</h2>';
    }
    else {
        echo '<h2><a href="?action=news&subaction=add">Add New Item</a><br />Select Item to Edit:</h2>';
        $armory_news = Utils::GetArmoryNews(true);
        if(is_array($armory_news)) {
            $count = count($armory_news);
            echo '<ul>';
            for($i = 0; $i < $count; ++$i) {
                echo sprintf('<li><a href="?action=news&subaction=edit&itemid=%d">%s</a> (%s)</li>', $armory_news[$i]['id'], $armory_news[$i]['title'], $armory_news[$i]['date']);
            }
            echo '</ul>';
        }
    }
    ?>
    <p></p>
    <?php
    switch(Template::GetPageData('news_result')) {
        case 'error_array':
        case 'error_insert':
            echo 'Unable to update/create news item!';
            break;
    }
    if(is_array($news_item) && Template::GetPageData('news_result') != 'ok') {
        echo sprintf('<form id="edit" name="edit" action="" method="post">
                <label><span style="color:red;"><strong>*</strong></span> ID:</label>
                <input type="text" class="smallInput wide" value="%d" disabled="true" name="id" />
                <input type="hidden" value="%d" name="newsid" />
                <label><span style="color:red;"><strong>*</strong></span> Date (in day.moth.year hour:minute:second format):</label>
                <input type="text" class="smallInput wide" value="%s" name="date" />
            	<label>Title (deDE):</label>
                <input type="text" class="smallInput wide" value="%s" name="title_de_de" />
            	<label><span style="color:red;"><strong>*</strong></span> Title (enGB):</label>
                <input type="text" class="smallInput wide" value="%s" name="title_en_gb" />
            	<label>Title (esES):</label>
                <input type="text" class="smallInput wide" value="%s" name="title_es_es" />
            	<label>Title (frFR):</label>
                <input type="text" class="smallInput wide" value="%s" name="title_fr_fr" />
            	<label>Title (ruRU):</label>
                <input type="text" class="smallInput wide" value="%s" name="title_ru_ru" />
                <label>Text (deDE):</label>
                <textarea class="smallInput wide" rows="7" cols="30" name="text_de_de">%s</textarea>
                <label><span style="color:red;"><strong>*</strong></span> Text (enGB):</label>
                <textarea class="smallInput wide" rows="7" cols="30" name="text_en_gb">%s</textarea>
                <label>Text (esES:)</label>
                <textarea class="smallInput wide" rows="7" cols="30" name="text_es_es">%s</textarea>
                <label>Text (frFR):</label>
                <textarea class="smallInput wide" rows="7" cols="30" name="text_fr_fr">%s</textarea>
                <label>Text (ruRU):</label>
                <textarea class="smallInput wide" rows="7" cols="30" name="text_ru_ru">%s</textarea>
                <br />
                <input type="checkbox" id="display" name="display" value="1"%s /> <strong>Display on main</strong>
                <br />
                <a class="button" onclick="javascript:doSubmit();"><span>Submit</span></a>
                <a class="button_notok" onclick="javascript:doReset();"><span>Clear</span></a>
            </form>', $news_item['id'], $news_item['id'], date('d.m.Y H:i:s', $news_item['date']), 
            $news_item['title_de_de'], $news_item['title_en_gb'],
            $news_item['title_es_es'], $news_item['title_fr_fr'], $news_item['title_ru_ru'],
            $news_item['text_de_de'], $news_item['text_en_gb'],
            $news_item['text_es_es'], $news_item['text_fr_fr'], $news_item['text_ru_ru'],
            $news_item['display'] == 1 ? ' checked' : null
            );
    }
    ?>
    <br />
    <div class="clear"></div><br />
    <!--NOTIFICATION MESSAGES-->    
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
