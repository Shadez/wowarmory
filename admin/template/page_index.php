<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>World of Warcraft Armory : Administration panel</title>
<link rel="stylesheet" type="text/css" href="template/css/960.css" />
<link rel="stylesheet" type="text/css" href="template/css/reset.css" />
<link rel="stylesheet" type="text/css" href="template/css/text.css" />
<link rel="stylesheet" type="text/css" href="template/css/blue.css" />
<link type="text/css" href="template/css/smoothness/ui.css" rel="stylesheet" />
    <script type="text/javascript" src="template/js/jquery.min.js"></script>
    <script type="text/javascript" src="template/js/blend/jquery.blend.js"></script>
	<script type="text/javascript" src="template/js/ui.core.js"></script>
	<script type="text/javascript" src="template/js/ui.sortable.js"></script>    
    <script type="text/javascript" src="template/js/ui.dialog.js"></script>
    <script type="text/javascript" src="template/js/ui.datepicker.js"></script>
    <script type="text/javascript" src="template/js/effects.js"></script>
    <script type="text/javascript" src="template/js/flot/jquery.flot.pack.js"></script>
    <!--[if IE]>
    <script language="javascript" type="text/javascript" src="template/js/flot/excanvas.pack.js"></script>
    <![endif]-->
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="template/css/iefix.css" />
	<script src="template/js/pngfix.js"></script>
    <script>
        DD_belatedPNG.fix('#menu ul li a span span');
    </script>        
    <![endif]-->
<?php
switch(Template::GetPageData('action')) {
    case 'index':
        echo sprintf('<script language="javascript" type="text/javascript">
// JavaScript Document
$(function () {
    %s

    // first correct the timestamps - they are recorded as the daily
    // midnights in UTC+0100, but Flot always displays dates in UTC
    // so we have to add one hour to hit the midnights in the plot
    for (var i = 0; i < d.length; ++i)
      d[i][0] += 60 * 60 * 1000;

    // helper for returning the weekends in a period
    function weekendAreas(axes) {
        var markings = [];
        var d = new Date(axes.xaxis.min);
        // go to the first Saturday
        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) %% 7))
        d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var i = d.getTime();
        do {
            // when we don\'t set yaxis the rectangle automatically
            // extends to infinity upwards and downwards
            markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
            i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
    }
    
    var options = {
        xaxis: { mode: "time" },
		selection: { mode: "xy" },
		lines: { show: true, fill: 0.5 },
		points: { show: true },
		yaxis: { min: 1, max: 1000 },
        grid: { markings: weekendAreas, hoverable: true, clickable: true, labelMargin: 10 },
		colors: ["#639ecb"], //639ecb //e03c42 
		shadowSize: 2
    };
  	function showTooltip(x, y, contents) {
        $(\'<div id="tooltip">\' + contents + \'</div>\').css( {
            position: \'absolute\',
            display: \'none\',
            top: y - 35,
            left: x + 0,
			color: \'#333\',
            border: \'1px solid #999\',
            padding: \'2px\',
            \'background-color\': \'#EFEFEF\',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
	
    var plot = $.plot($("#placeholder"), [d], options);
    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(0);
                    
                    if(y == 1) {
                        showTooltip(item.pageX, item.pageY,
                               y + " visitor");
                    }
                    else {
                        showTooltip(item.pageX, item.pageY,
                               y + " visitors");
                    }
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });
});
</script>', Admin::GetJSFormattedVisitorsValue());
        break;
    case 'news':
        echo '<script>
function doSubmit(){
   self.focus();
   document.edit.submit();
}

function doReset(){
   self.focus();
   document.edit.title_de_de.value = "";
   document.edit.title_en_gb.value = "";
   document.edit.title_es_es.value = "";
   document.edit.title_fr_fr.value = "";
   document.edit.title_ru_ru.value = "";
   document.edit.text_de_de.value = "";
   document.edit.text_en_gb.value = "";
   document.edit.text_es_es.value = "";
   document.edit.text_fr_fr.value = "";
   document.edit.text_ru_ru.value = "";
}
</script>';
        break;
}
?>
</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	  
  	<!--LOGO-->
	<div class="grid_8" id="logo">World of Warcraft Armory : Admin panel</div>
    <div class="grid_8">
<!-- USER TOOLS START -->
      <div id="user_tools"><span>Welcome, <a href="?"><?php echo Admin::GetAdminUserName(); ?></a>  |  <a href="?logout">Logout</a></span></div>
    </div>
<!-- USER TOOLS END -->    
<div class="grid_16" id="header">
<!-- MENU START -->
<div id="menu">
	<ul class="group" id="menu_group_main">
		<li class="item first"  id="one"><a href="?action=index" class="main<?php     echo Template::GetPageData('action') == 'index'    ? ' current' : null; ?>"><span class="outer"><span class="inner dashboard">Home</span></span></a></li>
        <li class="item middle" id="two"><a href="?action=news" class="main<?php      echo Template::GetPageData('action') == 'news'     ? ' current' : null; ?>"><span class="outer"><span class="inner newsletter">News Manager</span></span></a></li>
		<li class="item middle" id="three"><a href="?action=config" class="main<?php  echo Template::GetPageData('action') == 'config'   ? ' current' : null; ?>"><span class="outer"><span class="inner settings">Configuration</span></span></a></li>
        <li class="item middle" id="four"><a href="?action=accounts" class="main<?php echo Template::GetPageData('action') == 'accounts' ? ' current' : null; ?>"><span class="outer"><span class="inner users">Accounts</span></span></a></li>
		<li class="item middle" id="five"><a href="?action=database" class="main<?php echo Template::GetPageData('action') == 'database' ? ' current' : null; ?>"><span class="outer"><span class="inner database">Database</span></span></a></li>        
		<li class="item middle" id="six"><a href="?action=info" class="main<?php      echo Template::GetPageData('action') == 'info'     ? ' current' : null; ?>"><span class="outer"><span class="inner reports">Information</span></span></a></li> 
        <li class="item middle" id="seven"><a href="?action=updates" class="main<?php echo Template::GetPageData('action') == 'updates'  ? ' current' : null; ?>"><span class="outer"><span class="inner updates">Updates</span></span></a></li>          
		<li class="item last"   id="eight"><a href="?action=help" class="main<?php    echo Template::GetPageData('action') == 'help'     ? ' current' : null; ?>"><span class="outer"><span class="inner help">Help</span></span></a></li>     
  </ul>
</div>
<!-- MENU END -->
</div>
<!--
<div class="grid_16">
    <div id="tabs">
         <div class="container">
            <ul>
                      <li><a href="#" class="current"><span>Dashboard elements</span></a></li>
                      <li><a href="forms.html"><span>Content Editing</span></a></li>
                      <li><a href="#"><span>Submenu Link 3</span></a></li>
                      <li><a href="#"><span>Submenu Link 4</span></a></li>
                      <li><a href="#"><span>Submenu Link 5</span></a></li>
                      <li><a href="#"><span>Submenu Link 6</span></a></li>
                      <li><a href="#" class="more"><span>More Submenus</span></a></li>
           </ul>
        </div>
    </div>
</div>
<div class="grid_16" id="hidden_submenu">
	  <ul class="more_menu">
		<li><a href="#">More link 1</a></li>
		<li><a href="#">More link 2</a></li>  
	    <li><a href="#">More link 3</a></li>    
        <li><a href="#">More link 4</a></li>                               
      </ul>
	  <ul class="more_menu">
		<li><a href="#">More link 5</a></li>
		<li><a href="#">More link 6</a></li>  
	    <li><a href="#">More link 7</a></li> 
        <li><a href="#">More link 8</a></li>                                  
      </ul>
	  <ul class="more_menu">
		<li><a href="#">More link 9</a></li>
		<li><a href="#">More link 10</a></li>  
	    <li><a href="#">More link 11</a></li>  
        <li><a href="#">More link 12</a></li>                                 
      </ul>            
  </div>
  -->
<?php
switch(Template::GetPageData('action')) {
    default:
    case 'index':
        Template::LoadTemplate('content_index');
        break;
    case 'news':
        switch(Template::GetPageData('subaction')) {
            case 'added':
                Template::LoadTemplate('content_news_redirect');
                break;
            default:
                Template::LoadTemplate('content_news');
                break;
        }
        break;
    case 'config':
        switch(Template::GetPageData('subaction')) {
            default:
                Template::LoadTemplate('content_configuration');
                break;
            case 'edit':
                Template::LoadTemplate('content_configuration_edit');
                break;
            case 'addrealm':
                Template::LoadTemplate('content_configuration_addrealm');
                break;
        }
        break;
    case 'accounts':
        switch(Template::GetPageData('subaction')) {
            default:
                Template::LoadTemplate('content_accounts_list');
                break;
            case 'edit':
                Template::LoadTemplate('content_account_edit');
                break;
        }
        break;
    case 'database':
        switch(Template::GetPageData('subaction')) {
            default:
                Template::LoadTemplate('content_database');
                break;
            case 'open':
                if(!isset($_GET['table'])) {
                    Template::LoadTemplate('content_database_opened');
                }
                else {
                    Template::LoadTemplate('content_table_list');
                }
                break;
        }
        break;
}
?>   
  </div>
<div class="clear"> </div>

		<!-- This contains the hidden content for modal box calls -->
		<div class='hidden'>
			<div id="inline_example1" title="This is a modal box" style='padding:10px; background:#fff;'>
			<p><strong>This content comes from a hidden element on this page.</strong></p>
            			
			<p><strong>Try testing yourself!</strong></p>
            <p>You can call as many dialogs you want with jQuery UI.</p>
			</div>
		</div>
</div>
<!-- WRAPPER END -->
<!-- FOOTER START -->
<div class="container_16" id="footer">
Website Administration by <a href="http://www.webgurus.biz">WebGurus</a></div>
<!-- FOOTER END -->
</body>
</html>
