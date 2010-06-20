<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:include href="../includes.xsl"/>

<xsl:template name="faq-template">

	<xsl:param name="faqFileName" />

	<xsl:variable name="faqTitle" select="document(concat('../../_content/',$lang,'/', $faqFileName))/relatedinfo/@topic" />
	<xsl:variable name="faqPath" select="$faqFileName" />

	<div id="dataElement">
		<div class="parchment-top">
			<div class="parchment-content">
				<div class="list">
					<div class="full-list notab">
						<div class="info-pane">
							<div class="profile-wrapper">
								<div class="generic-wrapper">
									<div class="generic-right">
										<div class="genericHeader">
											<div class="faq-nav">
												<div class="nav-links">
													<xsl:for-each select="document('../../_data/faqs.xml')/faqs/faq">
														<xsl:variable name="theKey" select="@key" />
														
														<a href="{@temp}"><xsl:value-of select="$loc/strs/unsorted/str[@id=$theKey]" /></a>
														
														<xsl:if test = "position() != last()"> | </xsl:if>
														
														<xsl:choose>
															<xsl:when test="$lang='en_us' or $lang='en_gb'">
																<xsl:if test="position() = 9"><br/></xsl:if>
															</xsl:when>
															<xsl:when test="$lang='es_mx'">
																<xsl:if test="position() = 6"><br/></xsl:if>
															</xsl:when>
															<xsl:when test="$lang='ru_ru'">
																<xsl:if test="position() = 7"><br/></xsl:if>
															</xsl:when>
															<xsl:otherwise>
																<xsl:if test="position() = 8"><br/></xsl:if>
															</xsl:otherwise>
														</xsl:choose>
													</xsl:for-each>
												</div>
											</div>
											<div class="faq-content">
												<h2><xsl:value-of select="$faqTitle" /></h2>
	
												<xsl:for-each select="document(concat('../../_content/',$lang,'/', $faqPath))/relatedinfo/faqlist/faq">											
													<div class="faq-body">
														<a name="anchor{@key}"></a>	
														<xsl:if test="not(@regOnly) or @regOnly = $region">
															<p class="question"><xsl:value-of select="@question"/></p>
															<div><xsl:apply-templates/></div>
														</xsl:if>
													</div>
												</xsl:for-each>
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
</xsl:template>

<!-- achievements -->
<xsl:template match="faq/achievementsFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-achievements.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- arena calc -->
<xsl:template match="faq/arenaCalcFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-arena-calculator.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- arena ladder -->
<xsl:template match="faq/arenaLadderFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-arena-ladder.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- arena reports -->
<xsl:template match="faq/arenaReportsFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-arena-reports.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- arena tournament -->
<xsl:template match="faq/arenaTournamentFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-arena-tournament.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- armory -->
<xsl:template match="faq/armoryFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-armory.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- auction house -->
<xsl:template match="faq/auctionHouseFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-auction-house.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- calendar -->
<xsl:template match="faq/calendarFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-calendar.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- calendar feed -->
<xsl:template match="faq/calendarFeedFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-calendar-feed.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- character sheet -->
<xsl:template match="faq/characterSheetFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-character-sheet.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- character feed -->
<xsl:template match="faq/characterFeedFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-character-feed.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- guild info -->
<xsl:template match="faq/guildInfoFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-guild-info.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- item info recommended -->
<xsl:template match="faq/itemInfoRecommendedFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-item-info-recommended.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- item info -->
<xsl:template match="faq/itemInfoFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-item-info.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- login -->
<xsl:template match="faq/loginFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-login.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- match reports -->
<xsl:template match="faq/matchReportFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-match-report.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- opponent history -->
<xsl:template match="faq/opponentHistoryFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-opponent-history.xml'" />
	</xsl:call-template>
</xsl:template>

<!-- team info -->
<xsl:template match="faq/teamInfoFaq">
	<xsl:call-template name="faq-template">
		<xsl:with-param name="faqFileName" select="'ri-team-info.xml'" />
	</xsl:call-template>
</xsl:template>

</xsl:stylesheet>