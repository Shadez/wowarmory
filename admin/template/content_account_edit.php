<!-- CONTENT START -->
    <div class="grid_16" id="content">
   <!-- CONTENT TITLE -->
    <div class="grid_9">
    <h1 class="content_edit">Edit Account</h1>
    </div>
<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
    <div class="grid_15" id="textcontent">
    <a href="?action=accounts">Go back</a>
    
    <?php
    $account = Admin::GetAccount(Template::GetPageData('accountid'));
    if(is_array($account)) {
        $gm_levelInfo = null;
        if(!isset($account['gmlevel'])) {
            // trinity.
            $gmlevels = Armory::$rDB->select("SELECT * FROM `account_access` WHERE `id` = %d", $account['id']);
            if(is_array($gmlevels)) {
                foreach($gmlevels as $gmlevel) {
                    $gm_levelInfo .= sprintf('<label>RealmID: "%d"</label><input type="text" name="gmlevel_%d" value="%d" />', $gmlevel['RealmID'], $gmlevel['RealmID'], $gmlevel['gmlevel']);
                }
            }
        }
        else {
            $gm_levelInfo = sprintf('<input type="text" name="gmlevel" value="%d" />', $account['gmlevel']);
        }
        echo sprintf('<form id="edit" name="edit" action="?action=accounts&subaction=edit&accountid=%d" method="post">
    <label>User ID (do not change!):</label>
    <input type="text" name="id" value="%d" />
    <label>User Name:</label>
    <input type="text" name="username" value="%s" />
    <label>Sha1 Hash:</label>
    <input type="text" name="sha_pass_hash" value="%s" size="40" />
    <label>GM Level:</label>
    %s
    <label>E-Mail:</label>
    <input type="text" name="email" value="%s" />
    <label>Join Date:</label>
    <input type="text" name="joindate" value="%s" />
    <label>Last IP:</label>
    <input type="text" name="last_ip" value="%s" />
    <label>Locked:</label>
    <input type="radio" name="locked" value="1"%s /> Yes
    <input type="radio" name="locked" value="0"%s /> No
    <label>Last Login:</label>
    <input type="text" name="last_login" value="%s" />
    <label>Expansion:</label>
    <select name="expansion">
        <option value="2"%s>Wrath of the Lich King</option>
        <option value="1"%s>The Burning Crusade</option>
        <option value="0"%s>World of Warcraft Classic</option>
    </select>
    <br />
    <br />
    <input type="submit" name="subm" value="Update Account" />
    </form>', $account['id'], 
    $account['id'], 
    $account['username'], 
    $account['sha_pass_hash'],
    $gm_levelInfo,
    $account['email'],
    $account['joindate'],
    $account['last_ip'],
    $account['locked'] == 1 ? ' checked' : null,
    $account['locked'] == 0 ? ' checked' : null,
    $account['last_login'],
    $account['expansion'] == 2 ? ' selected' : null,
    $account['expansion'] == 1 ? ' selected' : null,
    $account['expansion'] == 0 ? ' selected' : null);
    }
    ?>
    
    <div class="clear"></div><br />
    </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
