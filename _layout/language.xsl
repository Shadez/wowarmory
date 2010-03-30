<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="config.xsl"/>

<xsl:variable name="lang" select="/page/@lang" />
<xsl:variable name="loc" select="document(concat('../_content/',$lang,'/strings.xml'))" />

<xsl:variable name="regionLinks" select="document(concat('../_content/_region/',translate($region,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'),'/links.xml'))" />
<xsl:variable name="regionArmoryURL" select="$regionLinks/links/link[@id='armory']" />
<xsl:variable name="regionWoWURL" select="$regionLinks/links/link[@id='wow']" />
<xsl:variable name="regionForumsURL" select="$regionLinks/links/link[@id='forums']" />

<xsl:template match="*" mode="printf">
	<xsl:param name="param1"/>
	<xsl:param name="param2"/>

	<xsl:param name="param3"/>

	<xsl:apply-templates mode="printf">
		<xsl:with-param name="param1" select="$param1"/>
		<xsl:with-param name="param2" select="$param2"/>
		<xsl:with-param name="param3" select="$param3"/>
	</xsl:apply-templates>
</xsl:template>

<xsl:template match="param1" mode="printf"><xsl:param name="param1"/><xsl:value-of select="$param1"/></xsl:template>
<xsl:template match="param2" mode="printf"><xsl:param name="param2"/><xsl:value-of select="$param2"/></xsl:template>

<xsl:template match="param3" mode="printf"><xsl:param name="param3"/><xsl:value-of select="$param3"/></xsl:template>
<xsl:template match="param-html1" mode="printf"><xsl:param name="param1"/><xsl:copy-of select="$param1"/></xsl:template>
<xsl:template match="param-html2" mode="printf"><xsl:param name="param2"/><xsl:copy-of select="$param2"/></xsl:template>
<xsl:template match="param-html3" mode="printf"><xsl:param name="param3"/><xsl:copy-of select="$param3"/></xsl:template>

<xsl:template match="*|@*" mode="format-date">
	<xsl:param name="format" select="$loc/strs/cfg[@id='date.format']"/>
	<xsl:param name="leadingZero" select="$loc/strs/cfg[@id='date.format.leadingZero']"/>

	<xsl:apply-templates select="$format" mode="printf">
		<xsl:with-param name="param1" select="substring(., 1, 4)"/>
		<xsl:with-param name="param2">

			<xsl:apply-templates select="." mode="format-date-component">
				<xsl:with-param name="leadingZero" select="$leadingZero"/>
			</xsl:apply-templates>
		</xsl:with-param>
		<xsl:with-param name="param3">
			<xsl:apply-templates select="." mode="format-date-component">
				<xsl:with-param name="leadingZero" select="$leadingZero"/>
				<xsl:with-param name="start" select="9"/>
			</xsl:apply-templates>

		</xsl:with-param>
	</xsl:apply-templates>
</xsl:template>

<xsl:template match="*|@*" mode="format-date-component">
	<xsl:param name="leadingZero"/>
	<xsl:param name="start" select="6"/>
	<xsl:param name="length" select="2"/>

	<xsl:choose>
		<xsl:when test="$leadingZero = 1">

			<xsl:value-of select="substring(., $start, $length)"/>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="number(substring(., $start, $length))"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

</xsl:stylesheet>
