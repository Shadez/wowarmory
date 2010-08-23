<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="language.xsl"/>
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>
<xsl:template match="page">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><xsl:value-of select="$loc/strs/login/str[@id='login-title']"/></title>
		<meta http-equiv="imagetoolbar" content="false"/> 
		<link rel="shortcut icon" href="images/login/favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" media="screen, projection" href="_css/login/master.css"/>
		<link rel="stylesheet" type="text/css" media="screen, projection" href="_css/login/region_EU.css"/>
		<!--[if IE 6]>
			<link rel="stylesheet" type="text/css" href="_css/login/master-ie6.css" />
		<![endif]-->
        <xsl:if test="@logout = '1'">
        <meta http-equiv="refresh" content="3;url=index.xml"/>
        </xsl:if>
		<script type="text/javascript" src="_js/login/common.js"></script>
		<script type="text/javascript" src="_js/login/jquery.js"></script>
		<script type="text/javascript">
			var $j = jQuery.noConflict();
			var processingStr = "<xsl:value-of select="$loc/strs/login/str[@id='login-jquery-processed']"/>";
		</script>			
	</head>
	<body>
    <xsl:if test="@logout='1'">
        <div class="page logoutView">
        <div class="logout">
        <h2 class="loggedOut"><xsl:value-of select="$loc/strs/login/str[@id='logoff-you-logged-off']"/></h2>
        <p class="redirect"><xsl:value-of select="$loc/strs/login/str[@id='logoff-redirect-info']"/></p>
        <p class="redirect"><xsl:value-of select="$loc/strs/login/str[@id='logoff-redirect-link-1']"/> <a href="index.xml"><xsl:value-of select="$loc/strs/login/str[@id='logoff-redirect-link-2']"/></a><xsl:value-of select="$loc/strs/login/str[@id='logoff-redirect-link-3']"/></p>
        </div>
        </div>
    </xsl:if>
    <xsl:if test="@logout=''">
        <div class="page loginView">
            <div class="">
                <form id="loginForm" class="submitForm" name="loginForm" method="post" action="" onsubmit="login.disableButton('submit', this); return true;">
                    <div class="formRow accountName">
                        <label class="formLabel" for="accountName" style="margin-bottom:1px"><xsl:value-of select="$loc/strs/login/str[@id='login-username-label']"/></label>
                        <input value="{@username}" id="accountName" name="accountName" maxlength="320" type="text" tabindex="1" class="text" />
                        <xsl:if test="@loginError = '1'">
                            <div class="errorTooltip"><div class="tooltipBg"><p><xsl:value-of select="$loc/strs/login/str[@id='login-error-username']"/></p><div class="arrow"></div></div></div>
                            <script type="text/javascript">
                                document.getElementById('accountName').focus();
                            </script>
                        </xsl:if>
                    </div>
                    <div class="formRow password">
                        <label class="formLabel" for="password"><xsl:value-of select="$loc/strs/login/str[@id='login-password-label']"/></label>
                        <input id="password" name="password" maxlength="16" type="password" tabindex="2" class="text" />
                        <xsl:if test="@passwordError = '1'">
                            <div class="errorTooltip"><div class="tooltipBg"><p><xsl:value-of select="$loc/strs/login/str[@id='login-error-password']"/></p><div class="arrow"></div></div></div>
                            <script type="text/javascript">
                                document.getElementById('password').focus();
                            </script>
                        </xsl:if>
                        <xsl:if test="@passwordError = '2'">
                            <div class="errorTooltip"><div class="tooltipBg"><p><xsl:value-of select="$loc/strs/login/str[@id='login-error-incorrect-password']"/></p><div class="arrow"></div></div></div>
                            <script type="text/javascript">
                                document.getElementById('password').focus();
                            </script>
                        </xsl:if>
                    </div>
                    <input type="submit" class="hiddenSubmit" />
                    <br />
                    <a class="submit" href="javascript:;" onclick="Form.submit(this)" tabindex="3"><xsl:value-of select="$loc/strs/login/str[@id='login-auth-button']"/></a>
                    <div class="signUp">
                        <p> </p>
                        <p><a href="index.xml"><xsl:value-of select="$loc/strs/login/str[@id='login-return-to-armory']"/></a></p>
                    </div>	 
                </form>	
            </div>
        </div>
    </xsl:if>
    </body>
</html>
</xsl:template>
</xsl:stylesheet>