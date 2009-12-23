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
<div id="replaceMain">
<div class="front-top">
<div class="loginbg">
<a class="loginLink" href="index.xml?login=1" id="loginLinkRedirect">{{#armory_login_string#}}</a>
</div>
<div class="logo">
<a href="armoryLink"><span>World of Warcraft Armory</span></a>
</div>
</div>
<div class="data-container">
<div class="data-shadow-top">
<!---->
</div>
<div class="data-shadow-sides">
<div class="parch-front">
<div class="search-module">
<em class="search-icon"></em>
<form action="search.xml" method="get" name="formSearch" onSubmit="return menuCheckLength(document.formSearch);">
<input id="armorySearch" maxlength="72" name="searchQuery" onkeypress="$('#formSearch_errorSearchLength').html('')" size="16" type="text" value="" /><a class="submit" href="javascript:void(0);" onclick="return menuCheckLength(document.formSearch)"><span>{{#armory_search_button#}}</span></a>
<div id="errorSearchType"></div>
<div id="formSearch_errorSearchLength"></div>
<input name="searchType" type="hidden" value="all">
</form>
{{include file="$menu_file.tpl"}}
</div>
</div>
</div>
<div class="data-shadow-bot">
<!---->
</div>
</div>
<div class="page-bot">
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