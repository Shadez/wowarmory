<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="menuNav" mode="createNavMenu">
    <!-- base menu -->
    <ul id="nav">
        <xsl:apply-templates select="links/link" />
    </ul>
</xsl:template>

<xsl:template match="link" mode="list">
    <xsl:if test="link">

        <ul>
			<iframe class="iframeFix" src="javascript:'';" marginwidth="0" marginheight="0" align="bottom" scrolling="no" frameborder="1"></iframe>
            <xsl:apply-templates select="link" />
        </ul>
    </xsl:if>
</xsl:template>

<!-- creates recursive submenus -->
<xsl:template match="link">
	<xsl:variable name="displayed">
		<xsl:choose>

			<xsl:when test="not(exclude/@region =$region)">1</xsl:when>
			<xsl:otherwise>0</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:if test="$displayed = 1">
	<xsl:variable name="menuRoot" select="/menuNav" />
    <li>

        <!-- check to use "fly" or not -->
        <xsl:choose>
            <xsl:when test="link or @subMenu">
                <xsl:attribute name="class">fly</xsl:attribute>
            </xsl:when>
            <xsl:otherwise>
                <xsl:attribute name="class">nofly</xsl:attribute>
            </xsl:otherwise>            
        </xsl:choose>

		<xsl:if test="parent::links">
			<xsl:attribute name="class">fly toplevel-li</xsl:attribute>
		</xsl:if>
        
        <!-- use span or link -->
        <xsl:choose>
            <xsl:when test="@span">
                <span>
					<xsl:choose>

						<xsl:when test="@node2">
							<xsl:value-of select="$loc/strs/*[name() = current()/@node]/*[name() = current()/@node2]/str[@id=current()/@key]" />
						</xsl:when>
						<xsl:when test="@node and not(@node2)">
							<xsl:value-of select="$loc/strs/*[name() = current()/@node]/str[@id=current()/@key]" />
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@key]" />
						</xsl:otherwise>

					</xsl:choose>
				</span>
            </xsl:when>
            <xsl:otherwise>
                <a href="index.xml">
                    <!-- set link -->
                    <xsl:attribute name="href">
                        <xsl:choose>
                            <xsl:when test="@url">

                                <xsl:value-of select="@url"/>
                            </xsl:when>
                            <xsl:otherwise>
                                <!-- get url based on urltype -->
                                <xsl:choose>
                                    <xsl:when test="@param1">
                                        <xsl:apply-templates select="$menuRoot/urls/url[@id=current()/@param1]" mode="printf">
                                            <xsl:with-param name="param1" select="@param1" />
                                            <xsl:with-param name="param2" select="$menuRoot/urls/urlstr[@id='all']/text()" />

                                            <xsl:with-param name="param3" select="$menuRoot/urls/urlstr[@id='all']/text()" />
                                        </xsl:apply-templates>
                                    </xsl:when>
                                    <xsl:when test="@param2">
                                        <xsl:apply-templates select="$menuRoot/urls/url[@id=current()/../@param1]" mode="printf">
                                            <xsl:with-param name="param1" select="../@param1" />
                                            <xsl:with-param name="param2" select="@param2" />
                                            <xsl:with-param name="param3" select="$menuRoot/urls/urlstr[@id='all']/text()" />
                                        </xsl:apply-templates>

                                    </xsl:when>
									<xsl:when test="@param3">
                                        <xsl:apply-templates select="$menuRoot/urls/url[@id=current()/../../@param1]" mode="printf">
                                            <xsl:with-param name="param1" select="../../@param1" />
                                            <xsl:with-param name="param2" select="../@param2" />
                                            <xsl:with-param name="param3" select="@param3" />
                                        </xsl:apply-templates>
                                    </xsl:when>
                                    <xsl:when test="@param4">

                                        <xsl:apply-templates select="$menuRoot/urls/url[@id=current()/../../../@param1]" mode="printf">
                                            <xsl:with-param name="param1" select="../../../@param1" />
                                            <xsl:with-param name="param2" select="../../@param2" />
                                            <xsl:with-param name="param3" select="../@param3" />
                                            <xsl:with-param name="param4" select="@param4" />
                                        </xsl:apply-templates>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <xsl:apply-templates select="$menuRoot/urls/url[@id='items']" mode="printf">

                                            <xsl:with-param name="param1" select="$menuRoot/urls/urlstr[@id='all']/text()" />
                                            <xsl:with-param name="param2" select="$menuRoot/urls/urlstr[@id='all']/text()" />
                                            <xsl:with-param name="param3" select="$menuRoot/urls/urlstr[@id='all']/text()" />
                                        </xsl:apply-templates>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </xsl:otherwise>
                        </xsl:choose>
					</xsl:attribute>

                    <!-- check if toplevel, top level has no href -->               
					<xsl:if test="parent::links">
                        <xsl:attribute name="class">toplevel</xsl:attribute>
                        <xsl:attribute name="href">javascript:void(0)</xsl:attribute>
                    </xsl:if>

                    <!-- set link text -->
					<xsl:choose>

						<xsl:when test="@node2">
							<xsl:value-of select="$loc/strs/*[name() = current()/@node]/*[name() = current()/@node2]/str[@id=current()/@key]" />
						</xsl:when>
						<xsl:when test="@node and not(@node2)">
							<xsl:value-of select="$loc/strs/*[name() = current()/@node]/str[@id=current()/@key]" />
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$loc/strs/unsorted/str[@id=current()/@key]" />
						</xsl:otherwise>

					</xsl:choose>
                </a>
            </xsl:otherwise>
        </xsl:choose>

		<xsl:if test="@subMenu = 'battlegroups'">
			<ul>
				<iframe class="iframeFix" src="javascript:'';" marginwidth="0" marginheight="0" align="bottom" scrolling="no" frameborder="1"></iframe>
				<xsl:call-template name="battlegroupsMenu">

					<xsl:with-param name="teamSize" select="@teamSize" />
				</xsl:call-template>
			</ul>
		</xsl:if>

        <xsl:apply-templates select="." mode="list"/>
    </li>
	</xsl:if>
</xsl:template>

<xsl:template name="battlegroupsMenu">
	<xsl:param name="teamSize" />	
	<xsl:for-each select="$bgXML/battlegroup[not(@tournamentBattleGroup=1)]">
		<xsl:sort select="@display" />
		<xsl:if test="realms/realm">
			<li class="nofly"><a href="arena-ladder.xml?ts={$teamSize}&amp;{@ladderUrl}"><xsl:value-of select="@display" /></a></li>
		</xsl:if>
	</xsl:for-each>
</xsl:template>
</xsl:stylesheet>