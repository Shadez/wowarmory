<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <div class="grid_9">
    <h1 class="content_edit">Database</h1>
    <?php
    echo sprintf('<a href="?action=database&subaction=open&type=%s&name=%s&realm=%d">Go Back</a>', $_GET['type'], $_GET['name'], $_GET['realm']);
    ?>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="clear"></div>
    <div class="portlet">
        <div class="portlet-header fixed"><img src="template/images/icons/user.gif" width="16" height="16" alt="Table" title="Table" />Table <?php echo $_GET['table']; ?></div>
        <br />
        <div class="portlet-content nopadding">          
        <div class="pagination">
        <?php
        $page_count = round(Admin::GetDB()->selectCell("SELECT COUNT(*) FROM `%s`", $_GET['table']) / 20)+1;
        $str = sprintf('action=database&subaction=open&type=%s&name=%s&realm=%d&table=%s', $_GET['type'], $_GET['name'], $_GET['realm'], $_GET['table']);
        echo sprintf('%s%s%s%s',
            Template::GetPageData('page')     == 1             ? '<span class="active">First page</span>'                                                  : sprintf('<span class="active"><a href="?%s&page=1">First page</a></span>', $str),
            Template::GetPageData('page') - 1 >= 1             ? sprintf('<a href="?%s&page=%d">Previous page</a>', $str, Template::GetPageData('page')-1) : '<span class="active">Previous page</span>',
            Template::GetPageData('page') + 1 <= $page_count   ? sprintf('<a href="?%s&page=%d">Next page</a>', $str, Template::GetPageData('page') + 1)   : '<span class="active">Next page</span>',
            Template::GetPageData('page')     == $page_count   ? '<span class="active">Last page</span>'                                                   : sprintf('<a href="?%s&page=%d">Last page</a>', $str, $page_count)
        );
        ?>
        </div>
        <form action="" method="post">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="">
            <thead>
              <tr>
                <?php
                $table_data = Template::GetPageData('table_data');
                $key_action = '';
                if(is_array($table_data)) {
                    echo '<th width="" scope="col">Actions</th>';
                    foreach($table_data as $cell) {
                        echo sprintf('<th width="" scope="col">%s</th>', $cell['name']);
                        if($cell['key'] == true) {
                            $key_action .= $cell['name'].';';
                        }
                    }
                }
                ?>
              </tr>
            </thead>
            <tbody>
                <?php
                $data = Admin::GetDB()->select("SELECT * FROM `%s` LIMIT %d, 20", $_GET['table'], (20 * (Template::GetPageData('page') - 1)));
                if(is_array($data)) {
                    foreach($data as $item) {
                        $data_item = array_slice($item, 0, 1);
                        $keys = array_keys($data_item);
                        $values = array_values($data_item);
                        echo sprintf('<tr>
                        <td width="90">
                        <a href="?%s&edit=%d&key=%s" class="edit_icon" title="Edit"></a>
                        <a href="?%s&delete=%d&key=%s" class="delete_icon" title="Delete"></a></td>', $str, $values[0], $key_action, $str, $values[0], $key_action);
                        foreach($item as $key => $value) {
                            echo sprintf('<td>%s</td>', $value);
                        }
                        echo '</tr>';
                    }
                }
                ?>
              <tr class="footer">
                <td colspan="4">&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td colspan="3" align="right">     
                </td>
              </tr>
            </tbody>
          </table>
        </form>
		</div>
      </div>
   </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
