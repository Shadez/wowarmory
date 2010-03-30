<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:import href="talent-page.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="talents"><link rel="stylesheet" type="text/css" href="_css/tools/talent-calc.css" />
	
	<xsl:variable name="petMode" select="boolean(@familyId)" />

	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">				
                <div class="list">

					<!-- Tabs -->
					<xsl:choose>
						<xsl:when test="$petMode">
							<xsl:call-template name="tabs">
								<xsl:with-param name="tabGroup" select="'tools'" />
								<xsl:with-param name="currTab" select="'petTalentCalculator'" />
								<xsl:with-param name="subTab" select="''" />
								<xsl:with-param name="tabUrlAppend" select="''" />
								<xsl:with-param name="subtabUrlAppend" select="''" />
							</xsl:call-template>
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="tabs">
								<xsl:with-param name="tabGroup" select="'tools'" />
								<xsl:with-param name="currTab" select="'talentCalculator'" />
								<xsl:with-param name="subTab" select="@classId" />
								<xsl:with-param name="tabUrlAppend" select="''" />
								<xsl:with-param name="subtabUrlAppend" select="''" />
							</xsl:call-template>
						</xsl:otherwise>
					</xsl:choose>

                    <div class="full-list">
                        <div class="info-pane">
							<div class="talentCalcBg">
								<xsl:if test="$petMode"><xsl:attribute name="class">petTalentCalcBg</xsl:attribute></xsl:if>

								<div class="talentCalcFooter">
									<xsl:choose>
										<!-- Pet Talent Calculator -->
										<xsl:when test="$petMode">
											<xsl:call-template name="talentCalc">
												<xsl:with-param name="tcVarName" select="'petTalentCalc'" />
												<xsl:with-param name="uniqueId" select="'tkwen68'" />
												<xsl:with-param name="pageMode" select="'calc'" />
												<xsl:with-param name="whichFamilyId" select="@familyId" />
												<xsl:with-param name="talStr" select="@tal" />
											</xsl:call-template>
										</xsl:when>
										<!-- Talent Calculator -->
										<xsl:otherwise>
											<xsl:call-template name="talentCalc">
												<xsl:with-param name="tcVarName" select="'talentCalc'" />
												<xsl:with-param name="uniqueId" select="'wenld36'" />
												<xsl:with-param name="pageMode" select="'calc'" />
												<xsl:with-param name="whichClassId" select="@classId" />
												<xsl:with-param name="talStr" select="@tal" />
											</xsl:call-template>
										</xsl:otherwise>
									</xsl:choose>
								</div>

							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>

</xsl:stylesheet>