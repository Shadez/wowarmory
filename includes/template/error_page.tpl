</div>
</div>
<div class="login-container">
<a class="loginLink" href="character-sheet.xml?login=1" id="loginLinkRedirect">Войти</a>
</div>
</div>
</div>
<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-int">
<div class="parch-bot">
<div id="replaceMain">
<tabInfo subTab="profile" tab="character" tabGroup="character" tabUrl=""></tabInfo>
<link href="_css/character/sheet.css" rel="stylesheet" type="text/css">
<div id="dataElement">
<div class="parchment-top">
<div class="parchment-content">
<div class="list">
<div class="player-side notab">
<div class="info-pane">
<div class="profile-wrapper">
<blockquote>
<b class="iguilds">
<h4>
<a href="index.xml">{{#armory_armory_string#}}</a>
</h4>
<h3>{{#armory_error_string#}}</h3>
</b>
</blockquote>
<div class="filtercontainer" style="margin:50px auto;padding:6px; width:80%">
<div class="bankcontentsfiltercontainer" style="width:100%; text-align: center;">
<div style="padding:10px;">
<div class="guildloginmsg" style="padding-left:10px">
<div class="guilderrortitle">{{$errorTitle}}</div>
<str id="armory.labels.nocharacter">{{$errorText}}
</str>
</div>
</div>
</div>
<div class="clearfilterboxsm"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot"></div>
{{include file="faq_index.tpl"}}
{{include file="overall_right_block.tpl"}}
<script type="text/javascript">
    faqSwitch(currentFaq);
</script>
</div>
<script type="text/javascript">
    function setArmorySearchFocus() {
        document.formSearch.armorySearch.focus();
    }
    window.onload = setArmorySearchFocus;	
</script>
</div>
</div>
