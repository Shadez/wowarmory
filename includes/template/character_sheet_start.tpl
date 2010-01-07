<body>
<form id="historyStorageForm" method="GET">
<textarea id="historyStorageField" name="historyStorageField"></textarea>
</form>
<script src="_js/_lang/{{$ArmoryConfig.locale}}/strings.js" type="text/javascript"></script>
<script type="text/javascript">global_nav_lang = '{{$ArmoryConfig.locale}}'</script>
<div class="tn_armory" id="shared_topnav">
<script src="shared/global/menu/topnav/buildtopnav.js"></script>
</div>
<div class="outer-container">
<div class="inner-container">
<div class="int-top">
<div class="logo">
<a href="index.xml"><span>{{#armory_site_title#}}</span></a>
</div>
<div class="adbox">
<div class="ad-container">
<div id="ad_728x90"></div>
</div>
</div>
</div>
<div class="int">
<div class="search-bar">
<div class="module">
<div class="search-container">
<div class="search-module">
<em class="search-icon"></em>
<form action="search.xml" method="get" name="formSearch" onSubmit="return menuCheckLength(document.formSearch);">
<input id="armorySearch" maxlength="72" name="searchQuery" onkeypress="$('#formSearch_errorSearchLength').html('')" size="16" type="text" value="{{$searchQuery}}"><a class="submit" href="javascript:void(0);" onclick="return menuCheckLength(document.formSearch)"><span>{{#armory_search_button#}}</span></a>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength"></div>
<input name="searchType" type="hidden" value="all">
</form>
{{include file="$menu_file.tpl"}}
</div>
</div>
<div class="login-container">
<a class="loginLink" href="?login=1" id="loginLinkRedirect">{{#armory_login_string#}}</a>
</div>
</div>
</div>
{{if $tpl2include}}
{{include file="$tpl2include.tpl"}}
{{else}}
{{include file="character_sheet_info.tpl"}}
{{/if}}