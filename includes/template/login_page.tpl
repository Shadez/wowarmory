<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>{{#armory_login_auth_title#}}</title>
			<meta http-equiv="imagetoolbar" content="false"/> 
			<link rel="shortcut icon" href="images/login/favicon.ico" type="image/x-icon"/>
			<link rel="stylesheet" type="text/css" media="screen, projection" href="_css/login/master.css"/>
			<link rel="stylesheet" type="text/css" media="screen, projection" href="_css/login/region_EU.css"/>
			<!--[if IE 6]>
				<link rel="stylesheet" type="text/css" href="_css/login/master-ie6.css" />
			<![endif]-->			
			<script type="text/javascript" src="_js/login/common.js"></script>
			<script type="text/javascript" src="_js/login/jquery.js"></script>
			<script type="text/javascript">
				var $j = jQuery.noConflict();
				var processingStr = "{{#armory_login_processing_string#}}";
			</script>			
		</head>
		<body>
	<div class="page loginView">
	<div class="">
		<form id="loginForm" class="submitForm" name="loginForm" autocomplete="off" method="post" action="?submit" onsubmit="login.disableButton('submit', this); return true;">
			<div class="formRow accountName">
				<label class="formLabel" for="accountName" style="margin-bottom:1px">{{#armory_login_accountname_label#}}</label>
	            <input value="{{$accountName}}" id="accountName" name="accountName" maxlength="320" type="text" tabindex="1" class="text" />
		{{if $error_username}}
        <div class="errorTooltip">
			<div class="tooltipBg">
				<p>
					{{$error_username}}<br />
				</p>
				<div class="arrow"></div>
			</div>
		</div>
        {{/if}}
				<script type="text/javascript">
					document.getElementById('accountName').focus();
				</script>
			</div>
			<div class="formRow password">
				<label class="formLabel" for="password">{{#armory_login_password_label#}}</label>
	            <input id="password" name="password" maxlength="16" type="password" tabindex="2" autocomplete="off" class="text" />
        {{if $error_password}}
        <div class="errorTooltip">
			<div class="tooltipBg">
				<p>
					{{$error_password}}<br />
				</p>
				<div class="arrow"></div>
			</div>
		</div>
        {{/if}}
	        </div>	
	        <input type="submit" class="hiddenSubmit" />
			<a class="submit" href="javascript:;" onclick="Form.submit(this)" tabindex="3">{{#armory_login_auth_button#}}</a>
	           <div class="signUp">
				<p>&nbsp;</p>
				<p><a href="index.xml">{{#armory_login_return_to_armory#}}</a></p>
                </div>	 
		</form>	
	</div>
	</div>
		</body>
</html>