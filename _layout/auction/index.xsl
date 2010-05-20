<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="header.xsl" />

	<xsl:template match="error">
        <div id="dataElement">
            <div class="parchment-top">
                <div class="parchment-content">   
                    <div class="list">
                    	<xsl:call-template name="auctionTabs" />

                        <div class="full-list">
                            <div class="info-pane" id="infoPaneContainer">
                            	<xsl:call-template name="auctionUser" />
 
                                <xsl:if test="@code = 100">
                                    <script type="text/javascript">
                                        $(function() {
                                            useFullTooltip = true;
                                            Auction.openPage('search');
                                        });
                                    </script>
                                </xsl:if>
   
                                <div id="auctionHouseContent">
                                    <div class="emptyResult2">
                                        <span><xsl:value-of select="@message" /></span>
                                    </div>
                                </div>
 
                                <span class="clear"><!-- --></span>
                        	</div>
                        </div>
                    </div>  
                </div>      
            </div>
        </div> 
    </xsl:template>  

    <xsl:template match="auctionStatus">
        <div id="dataElement">
            <div class="parchment-top">
                <div class="parchment-content">
                    <div class="list">	
                    	<xsl:call-template name="auctionTabs" />
		
                        <div class="full-list">
                            <div class="info-pane summaryTakeover" id="infoPaneContainer">
                            	<xsl:call-template name="auctionUser" />
                                
                                <script type="text/javascript">
									$(function() {
                                        useFullTooltip = true;
                                        Auction.loadMoney();

                                        // IE fix
                                        setTimeout(function() {
                                            Auction.openPage();
                                        }, 1000);
                                    });
								</script>
                                
                                <div id="auctionHouseContent" class="loadingContent">
                                   
                                </div>
                                
                                <span class="clear"><!-- --></span>
                        	</div>        
                        </div>     
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>

</xsl:stylesheet>