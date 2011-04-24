<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <div class="grid_9">
    <h1 class="content_edit">Accounts</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="clear"></div>
    <div class="portlet">
        <div class="portlet-header fixed"><img src="template/images/icons/user.gif" width="16" height="16" alt="Accounts List" title="Accounts List" />Accounts List</div>
		<form id="edit" name="edit" action="?action=accounts" method="post">
        <input type="text" name="searchAccount" value="<?php echo isset($_POST['searchAccount']) ? $_POST['searchAccount'] : null; ?>" />
        <input type="submit" name="subm" value="Search" />
        </form>
        <br />
        <div class="portlet-content nopadding">
        <div class="pagination">
        <?php
        $page_count = round(Armory::$rDB->selectCell("SELECT COUNT(*) FROM `account`") / 20)+1;
        $str = 'action=accounts';
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
                <th width="34" scope="col"><input type="checkbox" name="allbox" id="allbox" onclick="checkAll()" /></th>
                <th width="136" scope="col"><a href="?action=accounts&sortby=username&sorttype=<?php echo isset($_GET['sorttype']) ? $_GET['sorttype'] == 'ASC' ? 'DESC' : 'ASC' : 'ASC'; ?>">Username</a></th>
                <th width="102" scope="col">Hash</th>
                <th width="109" scope="col"><a href="?action=accounts&sortby=gmlevel&sorttype=<?php echo isset($_GET['sorttype']) ? $_GET['sorttype'] == 'ASC' ? 'DESC' : 'ASC' : 'ASC'; ?>">GM Level</a></th>
                <th width="129" scope="col">E-Mail</th>
                <th width="171" scope="col">IP Address</th>
                <th width="123" scope="col">Last Login</th>
                <th width="90" scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                <?php
                $accounts_list = Template::GetPageData('accounts_list');
                if(is_array($accounts_list)) {
                    foreach($accounts_list as $account) {
                        echo sprintf('<tr>
                <td width="34"><label>
                    <input type="checkbox" name="checkbox" id="checkbox" />
                </label></td>
                <td>%s</td>
                <td>%s</td>
                <td>%d</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td width="90"><a href="?action=accounts&subaction=edit&accountid=%d" class="edit_icon" title="Edit"></a> <a href="?action=accounts&subaction=delete&accountid=%d" class="delete_icon" title="Delete"></a></td>
              </tr>', $account['username'], $account['sha_pass_hash'], $account['gmlevel'], $account['email'], $account['last_ip'], $account['last_login'], $account['id'], $account['id']);
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
