<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>
<xsl:include href="../includes.xsl"/>

<xsl:template match="page">
	<html>
	<head>
		<title><xsl:value-of select="$loc/strs/str[@id='armory.labels.wow-the-armory']"/></title>
		<link rel="stylesheet" type="text/css" href="_css/errors.css" />
		<link rel="stylesheet" type="text/css" href="_css/_lang/{$lang}/language.css" />
	</head>
	<body class="errorpage">	
		<div class="container">	
        <xsl:choose>
           <!-- maintenance -->
            <xsl:when test="errorhtml/@type = 'maintenance'">
                <h1><xsl:value-of select="$loc/strs/str[@id='armory.maintenance.text']"/></h1>
            </xsl:when>
            <xsl:otherwise>
                <xsl:choose>
                    <!-- file not found -->
                    <xsl:when test="errorhtml/@type = '404'">
                        <h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.error.filenotfound']"/></h1>
                    </xsl:when>
                    <!-- service unavailable -->
                    <xsl:when test="errorhtml/@type = '503'">
                        <h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.error.unavailable']"/></h1>
                    </xsl:when>
                    <!-- general error -->
                    <xsl:otherwise>
                        <h1><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.errormessage']"/></h1>
                    </xsl:otherwise>
                </xsl:choose>
                <ul>
                    <li><a href="index.xml"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.returntoprevious']"/></a></li>
                    <li><a href="{$regionWoWURL}"><xsl:value-of select="$loc/strs/unsorted/str[@id='armory.labels.returntomain']"/></a></li>
                </ul>			
          </xsl:otherwise>
        </xsl:choose>	
		</div>	
	</body>
	</html>
</xsl:template>
</xsl:stylesheet>