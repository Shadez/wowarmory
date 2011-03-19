<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <div class="grid_9">
    <h1 class="dashboard">Home</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
      <div class="column" id="left">
		<div class="portlet">
            <div class="portlet-header"><img src="template/images/icons/chart_bar.gif" width="16" height="16" alt="Reports" /> Visitors - Last 30 days</div>
            <div class="portlet-content">
            <div id="placeholder" style="width:auto; height:250px;"></div>
            </div>
        </div>      
      </div>
      <div class="column">
      <div class="portlet">
		<div class="portlet-header"><img src="template/images/icons/comments.gif" width="16" height="16" title="Notifications" alt="Notifications" />Notifications</div>

		<div class="portlet-content">
            <?php
            $notifications = Admin::GetNotifications();
            if(is_array($notifications) && isset($notifications[0])) {
                foreach($notifications as $notify) {
                    echo sprintf('<p class="info" id="%s"><span class="info_inner">%s</span></p>', $notify['type'], $notify['message']);
                }
            }
            else {
                echo 'Everything is correct.';
            }
            ?>
            </div>
       </div>
    </div>
   </div>
    <div class="clear"> </div>
<!-- END CONTENT--> 
