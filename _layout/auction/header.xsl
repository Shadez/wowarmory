<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="../includes.xsl" />
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

	<!-- User Variables -->
    <xsl:variable name="loginStatus" select="document('../../login-status.xml')" />  
    <xsl:variable name="username" select="$loginStatus/page/loginStatus/@username" />
    <xsl:variable name="user" select="document('../../vault/character-select.xml?sel=2')" />
    <xsl:variable name="char" select="$user/page/characters/character[@selected=1]" />

    <xsl:variable name="wowAnywhere" select="'../../wow-remote.xml'" />

	<!-- Import page specific data, css/js -->
    <xsl:template name="head-content">
        <link rel="stylesheet" href="_css/auction-house.css" type="text/css" />
    	<script type="text/javascript" src="_js/auction/search.js"></script>
        <script type="text/javascript" src="_js/auction/create.js"></script>
    </xsl:template>
    
    <!-- Top Tabs: /_layout/nav/tabs.xml -->
    <xsl:template name="auctionTabs">
        <xsl:call-template name="tabs">
            <xsl:with-param name="tabGroup" select="/page/tabInfo/@tabGroup" />
            <xsl:with-param name="currTab" select="/page/tabInfo/@tab" />
            <xsl:with-param name="subTab" select="/page/tabInfo/@subTab" />
            <xsl:with-param name="tabUrlAppend" select="/page/tabInfo/@tabUrl" />
            <xsl:with-param name="subtabUrlAppend" select="/page/tabInfo/@tabUrl" />
            <xsl:with-param name="tabInfo" select="/page/tabInfo" />
            <xsl:with-param name="auction" select="/page/auctionStatus" />
        </xsl:call-template>
    </xsl:template>
    
    <!-- User Row / Logged In -->
    <xsl:template name="auctionUser">
        <xsl:variable name="txtClass" select="$loc/strs/classes/str[@id=concat('armory.classes.class.', $char/@classId,'.', $char/@genderId)]" />
    	<xsl:variable name="txtRace" select="$loc/strs/races/str[@id=concat('armory.races.race.', $char/@raceId,'.', $char/@genderId)]" />

        <xsl:if test="/page/auctionStatus or /page/error and /page/error/@code != '10007'">
      	<div id="auctionUser">
        	<xsl:choose>
            	<xsl:when test="$char/@factionId = '1'">
                	<xsl:attribute name="class">houseHorde</xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                	<xsl:attribute name="class">houseAlliance</xsl:attribute>
                </xsl:otherwise>
          	</xsl:choose>

            <input type="hidden" id="char_name" value="{$char/@name}" />
            <input type="hidden" id="char_faction" value="{/page/command/@f}" />
            <input type="hidden" id="char_realm" value="{$char/@realm}" />
            
        	<div id="charAvatar">
            	<a href="/character-sheet.xml?{$char/@url}" class="staticTip" onmouseover="setTipText('{$loc/strs/character/str[@id='character-level']} {$char/@level} {$txtRace} {$txtClass}')">
					<xsl:choose>
						<xsl:when test="$char/@level = '80'">
							<img class="primchar-avatar" src="images/portraits/wow-80/{$char/@genderId}-{$char/@raceId}-{$char/@classId}.gif" />            
						</xsl:when>
						<xsl:when test="$char/@level &gt;= '70'">
							<img class="primchar-avatar" src="images/portraits/wow-70/{$char/@genderId}-{$char/@raceId}-{$char/@classId}.gif" />            
						</xsl:when>
						<xsl:when test="$char/@level &gt;= '60'">
							<img class="primchar-avatar" src="images/portraits/wow/{$char/@genderId}-{$char/@raceId}-{$char/@classId}.gif" />
						</xsl:when>
						<xsl:otherwise>
							<img class="primchar-avatar" src="images/portraits/wow-default/{$char/@genderId}-{$char/@raceId}-{$char/@classId}.gif" />
						</xsl:otherwise>
					</xsl:choose>
                </a>
            	<div id="charLevel"><xsl:value-of select="$char/@level" /></div>
            </div>
            
            <div id="charTitle">
            	<div id="charRealm">
                	<a class="staticTip" href="{$regionForumsURL}board.html?sid=1&amp;forumName={$char/@realm}" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.forum.link.realm']}');"><xsl:value-of select="$char/@realm" /></a>
                </div>
                
            	<h2>
                    <xsl:value-of select="$char/@name" />
                    <!--<a href="/vault/character-select.xml" onmouseover="setTipText('{$loc/strs/auctionHouse/str[@id='house.changeChar']}');" class="staticTip changeChar"><img src="/_images/ahouse/me.gif" alt="" /></a>-->

                    <xsl:if test="/page/auctionStatus/mailInfo/@total > 50">
                        <xsl:variable name="mailAlert" select="$loc/strs/auctionHouse/str[@id='create.mailboxNotice']" />
                        <xsl:text> </xsl:text><span class="staticTip" onmouseover="setTipText('{$mailAlert}');"><img src="images/mail-letter.gif" alt="!" /></span>
                    </xsl:if>
                </h2>
            </div>

            <div id="charHouses">
                <xsl:choose>
                    <xsl:when test="/page/command/@f = 2">
                        <xsl:if test="$char/@factionId = 0">
                            <a href="auctionhouse/index.xml?f=a" onclick="Auction.changeHouse('a'); return false;" onmouseover="setTipText('{$loc/strs/auctionHouse/str[@id='house.switchAlliance']}');" class="staticTip"><img src="images/ahouse/icon-alliance.gif" alt="" /></a>
                        </xsl:if>

                        <xsl:if test="$char/@factionId = 1">
                            <a href="auctionhouse/index.xml?f=h" onclick="Auction.changeHouse('h'); return false;" onmouseover="setTipText('{$loc/strs/auctionHouse/str[@id='house.switchHorde']}');" class="staticTip"><img src="images/ahouse/icon-horde.gif" alt="" /></a>
                        </xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <a href="auctionhouse/index.xml?f=n" onclick="Auction.changeHouse('n'); return false;" onmouseover="setTipText('{$loc/strs/auctionHouse/str[@id='house.switchNeutral']}');" class="staticTip"><img src="images/ahouse/icon-neutral.gif" alt="" /></a>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
            
            <div id="auctionTabard">
            	<xsl:choose>
                    <xsl:when test="/page/command/@f = '0'">
                    	<xsl:attribute name="class">tabardAlliance</xsl:attribute>
                    </xsl:when>
                    <xsl:when test="/page/command/@f = '1'">
                    	<xsl:attribute name="class">tabardHorde</xsl:attribute>
                    </xsl:when>
                    <xsl:otherwise>
                    	<xsl:attribute name="class">tabardNeutral</xsl:attribute>
                   	</xsl:otherwise>
                </xsl:choose>

                <xsl:text> </xsl:text>
            </div>
            
            <div id="auctionHouse">
                <div id="houseTitle">
                	<b><xsl:choose>
                        <xsl:when test="/page/command/@f = '0'"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='summary.alliance.house']" /></xsl:when>
                        <xsl:when test="/page/command/@f = '1'"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='summary.horde.house']" /></xsl:when>
                        <xsl:otherwise><xsl:value-of select="$loc/strs/auctionHouse/str[@id='summary.neutral.house']" /></xsl:otherwise>
                    </xsl:choose></b>
                </div>
                
                <span id="baseCurrentMoney" style="display: none">0</span>
                <span class="goldCoin">0</span>
                <span class="silverCoin">0</span>
                <span class="copperCoin">0</span>
            </div>
        </div>
        </xsl:if>
    </xsl:template>
    
    <!-- Auction Item Row Tile -->
    <xsl:template match="aucItem" mode="itemRow">
        <xsl:param name="rowType" />
        <xsl:param name="iterator" />  
        
        <tr id="auction_{@auc}">
        	<xsl:if test="$iterator mod 2 != 1">
                <xsl:attribute name="class">odd</xsl:attribute>
            </xsl:if>
                        
            <td valign="middle">
            	<div class="itemList">
                    <a id="{@id}" href="item-info.xml?i={@id}" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');"><img src="wow-icons/_images/43x43/{@icon}.png" alt="" /></a>
                    <xsl:if test="@quan > 1">
                        <div class="itemListStack"><xsl:value-of select="@quan" /></div>
                    </xsl:if>
                </div>
            	<a id="{@id}" href="item-info.xml?i={@id}" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');">
                    <xsl:call-template name="truncate">
                        <xsl:with-param name="string" select="@n" />
                        <xsl:with-param name="length" select="'25'" />
                    </xsl:call-template>
                </a><br />

                <xsl:choose>
                    <xsl:when test="@seller = '???'">
                        <xsl:value-of select="@seller" />
                    </xsl:when>
                    <xsl:otherwise>
                        <a href="character-sheet.xml?r={$char/@realm}&amp;cn={@seller}" class="sellerName"><xsl:value-of select="@seller" /></a>
                    </xsl:otherwise>
                </xsl:choose>

                <xsl:if test="$char/@name = @seller">
                    <xsl:variable name="isSeller" select="$loc/strs/auctionHouse/str[@id='msg.isSeller']" />
                    <img class="staticTip" onmouseover="setTipText('{$isSeller}');" src="images/ahouse/me.png" alt="" style="margin: 0 0 -2px 5px" />
                </xsl:if>
            </td>
            <td class="ac"><xsl:value-of select="@quan" /></td>
            <td class="ac">
                <xsl:choose>
                    <xsl:when test="/page/command/@sort = 'ILVL'"><xsl:value-of select="@ilvl" /></xsl:when>
                    <xsl:otherwise><xsl:value-of select="@req" /></xsl:otherwise>
                </xsl:choose>
            </td>
            <td>
                <xsl:choose>
                    <xsl:when test="@time=0">
                    	<xsl:variable name="timeMsg" select="$loc/strs/auctionHouse/str[@id='time.short.msg']" />
                    	<span class="staticTip timeShort" onmouseover="setTipText('{$timeMsg}');"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='time.short']" /></span>
                    </xsl:when>
                    <xsl:when test="@time=1">
                    	<xsl:variable name="timeMsg" select="$loc/strs/auctionHouse/str[@id='time.medium.msg']" />
                    	<span class="staticTip timeMedium" onmouseover="setTipText('{$timeMsg}');"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='time.medium']" /></span>
                    </xsl:when>
                    <xsl:when test="@time=2">
                    	<xsl:variable name="timeMsg" select="$loc/strs/auctionHouse/str[@id='time.long.msg']" />
                    	<span class="staticTip timeLong" onmouseover="setTipText('{$timeMsg}');"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='time.long']" /></span>
                    </xsl:when>
                    <xsl:when test="@time=3">
                    	<xsl:variable name="timeMsg" select="$loc/strs/auctionHouse/str[@id='time.verylong.msg']" />
                    	<span class="staticTip timeVeryLong" onmouseover="setTipText('{$timeMsg}');"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='time.verylong']" /></span>
                    </xsl:when>
                </xsl:choose>
            </td>
            <!-- Highest Bidder -->
            <xsl:if test="$rowType = 'myAuctions'">
            <td class="ac">
                <xsl:choose>
                    <xsl:when test="@bidder = '???'"><xsl:value-of select="@buyer" /></xsl:when>
                    <xsl:when test="@bidder != ''"><a href="character-sheet.xml?r={$char/@realm}&amp;cn={@bidder}"><xsl:value-of select="@bidder" /></a></xsl:when>
                    <xsl:otherwise><span class="textRed"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='status.noBids']" /></span></xsl:otherwise>
                </xsl:choose>
            </td>
          	</xsl:if>
            <!-- Bid Status -->
            <xsl:if test="$rowType = 'myBids'">
            <td>
            	<xsl:choose>
                	<xsl:when test="@hbid = 'true'">
                    	<span class="textGreen"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='status.highBidder']" /></span>
                    </xsl:when>
                    <xsl:otherwise>
                        <span class="mailLetter staticTip textRed">
                            <xsl:attribute name="onmouseover">setTipText('<xsl:value-of select="$loc/strs/auctionHouse/str[@id='money.claim']" />');</xsl:attribute>
                            <xsl:value-of select="$loc/strs/auctionHouse/str[@id='status.outbid']" />
                        </span>
                    </xsl:otherwise>
           		</xsl:choose>
            </td>
          	</xsl:if>
            <!-- Buyout / Bid Price -->
            <td class="ar" valign="top">
            	<div class="moneyCol">
                    <xsl:if test="@ppuBid or @ppuBuy">
                        <xsl:attribute name="class">moneyCol staticTip</xsl:attribute>
                        <xsl:attribute name="onmouseover">setTipText($('#auctionPPU_<xsl:value-of select="@auc" />').html(), false);</xsl:attribute>
                    </xsl:if>

                    <div class="bidCol">
                        <xsl:call-template name="goldFormat">
                            <xsl:with-param name="totalMoney" select="@bid" />
                        </xsl:call-template>
                    </div>
                    
                    <div class="buyCol">      
                    	<xsl:if test="not(@buy > 0)">
                        	<xsl:attribute name="class">buyCol noBuyout</xsl:attribute>
                       	</xsl:if>
                        
                        <xsl:call-template name="goldFormat">
                            <xsl:with-param name="totalMoney" select="@buy" />
                        </xsl:call-template>
                    </div>

                    <xsl:if test="@ppuBid or @ppuBuy">
                        <div id="auctionPPU_{@auc}" style="display: none">
                            <table cellpadding="0" cellspacing="0" class="ppuCol">
                                <xsl:if test="@ppuBid">
                                <tr>
                                    <td valign="top"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.ppuBid']" /></td>
                                    <td valign="top" style="width: 140px">
                                        <xsl:call-template name="goldFormat">
                                            <xsl:with-param name="totalMoney" select="@ppuBid" />
                                        </xsl:call-template>
                                    </td>
                                </tr>
                                </xsl:if>

                                <xsl:if test="@ppuBuy">
                                <tr>
                                    <td valign="top"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.ppuBuy']" /></td>
                                    <td valign="top" style="width: 140px">
                                        <xsl:call-template name="goldFormat">
                                            <xsl:with-param name="totalMoney" select="@ppuBuy" />
                                        </xsl:call-template>
                                    </td>
                                </tr>
                                </xsl:if>
                            </table>
                        </div>
                    </xsl:if>
             	</div>       
            </td>
            <td class="ar" valign="top" style="width: 110px">
                <xsl:choose>
                    <xsl:when test="$rowType = 'myAuctions'">
                        <xsl:variable name="itemName">
                            <xsl:call-template name="search-and-replace">
                                <xsl:with-param name="input" select="@n" />
                                <xsl:with-param name="search-string" select="'&quot;'" />
                                <xsl:with-param name="replace-string" select="'\&quot;'" />
                            </xsl:call-template>
                        </xsl:variable>
                        
                        <script type="text/javascript">
                            var i<xsl:value-of select="@auc" /> = "<xsl:value-of select='$itemName' />";
                        </script>

                    	<div class="auctionButtons enabled">
                        	<a href="#" class="houseButton" onclick="Auction.openCancel({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.cancelAuction']" /></span></a>
                        	<a href="#" class="houseButton" onclick="Auction.findInAH(i{@auc}, true); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.search']" /></span></a>
                       	</div>

                        <div class="auctionButtons locked" style="display: none">
                            <a href="#" class="action-close" onclick="Auction.closeOverlay({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>
                        </div>
                    </xsl:when>
                    
                    <xsl:when test="$rowType = 'myBids'">
                    	<xsl:choose>
                        	<!-- If highest bidder -->
                            <xsl:when test="@hbid = 'true'">
                    			<div class="auctionButtons enabled">
                                    <a href="#" class="houseButton disabled" onclick="return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.rebid']" /></span></a>
                                    
                                    <xsl:if test="@buy != ''">
                                        <a href="#" class="houseButton" onclick="Auction.openBuyout({@auc}, {@buy}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.buyout']" /></span></a>
                                    </xsl:if>
                              	</div>

                                <div class="auctionButtons locked" style="display: none">
                                    <a href="#" class="action-close" onclick="Auction.closeOverlay({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>
                                </div>
                            </xsl:when>
                            
                            <!-- If not, get money back or bid again -->
                            <xsl:otherwise>
                    			<div class="auctionButtons enabled">
                                    <a href="#" class="houseButton" onclick="Auction.openBid({@auc}, {@nbid}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.rebid']" /></span></a>
                                    <a href="#" class="houseButton" onclick="Auction.getMoney({@auc}, null, this); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='money.get']" /></span></a>
                              	</div>

                                <div class="auctionButtons disabled" style="display: none">
                                    <a href="#" class="houseButton disabled"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.rebid']" /></span></a>
                                    <a href="#" class="houseButton" onclick="Auction.getMoney({@auc}, null, this); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='money.get']" /></span></a>
                              	</div>

                                <div class="auctionButtons locked" style="display: none">
                                    <a href="#" class="action-close" onclick="Auction.closeOverlay({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>
                                </div>
                           	</xsl:otherwise>
                        </xsl:choose>
                    </xsl:when>
                    
                    <xsl:otherwise>
                    	<xsl:choose>
                        	<!-- If I own that item, disable options -->
                            <xsl:when test="@own = 'true'">
                                <div class="auctionButtons enabled">
                                    <a href="#" class="houseButton active" onclick="return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.myAuction']" /></span></a>
                                    <a href="#" class="houseButton" onclick="Auction.openCancel({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.cancelAuction']" /></span></a>
                                </div>

                                <div class="auctionButtons locked" style="display: none">
                                    <a href="#" class="action-close" onclick="Auction.closeOverlay({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>
                                </div>
                            </xsl:when>
                            
                            <!-- Else bid or buyout -->
                            <xsl:otherwise>
                                <div class="auctionButtons enabled">
                                	<xsl:choose>
                                    	<xsl:when test="@hbid = 'true'">
                                    		<a href="#" class="houseButton active" onclick="return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='status.highBidder']" /></span></a>
                                    	</xsl:when>
                                        <xsl:otherwise>
                                            <a href="#" class="houseButton" onclick="Auction.openBid({@auc}, {@nbid}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.bid']" /></span></a>
                                        </xsl:otherwise>
                                 	</xsl:choose>
                                    
                                    <xsl:if test="@buy != ''">
                                        <a href="#" class="houseButton" onclick="Auction.openBuyout({@auc}, {@buy}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.buyout']" /></span></a>
                                    </xsl:if>
                                </div>

                                <div class="auctionButtons disabled" style="display: none">
                                	<a href="#" class="houseButton active" onclick="return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='status.highBidder']" /></span></a>

                                    <xsl:if test="@buy != ''">
                                        <a href="#" class="houseButton" onclick="Auction.openBuyout({@auc}, {@buy}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.buyout']" /></span></a>
                                    </xsl:if>
                                </div>

                                <div class="auctionButtons locked" style="display: none">
                                    <a href="#" class="action-close" onclick="Auction.closeOverlay({@auc}); return false;"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>
                                </div>  
                         	</xsl:otherwise>
                       	</xsl:choose>       
                    </xsl:otherwise>
                </xsl:choose>
            </td>
       	</tr>
    </xsl:template>
        
   	<!-- Different states for the auction house rows -->
  	<xsl:template name="auctionRowStates">
    	<div style="display: none"> 
            <a href="#" id="rowCloseButton" class="action-close"><span><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.close']" /></span></a>

            <table>
                <tr id="rowBid" class="overlay-bid">
                    <td class="action-row">
                        <div class="action-button">
                            <a href="#"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.confirm']" /></a>
                        </div>

                        <div class="action-message">
                            <div class="overlay-start">
                                <xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.enterBid']" />:
                                <input type="text" class="enter-bid-gold" size="1" maxlength="6" onkeyup="AuctionCreate.checkNumeric(this);" /> <img src="images/ahouse/gold.gif" alt="" style="margin-bottom: -5px" />
                                <input type="text" class="enter-bid-silver" size="1" maxlength="2" onkeyup="AuctionCreate.checkNumeric(this);" /> <img src="images/ahouse/silver.gif" alt="" style="margin-bottom: -5px" />
                                <input type="text" class="enter-bid-copper" size="1" maxlength="2" onkeyup="AuctionCreate.checkNumeric(this);" /> <img src="images/ahouse/copper.gif" alt="" style="margin-bottom: -5px" />
                            </div>

                            <div class="overlay-bidfinish" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.bidFinish']" /></b>
                            </div>

                            <div class="overlay-buyoutfinish" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.buyoutFinish']" /></b>
                            </div>

                            <div class="overlay-error textYellow" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.error']" /></b>
                            </div>
                        </div>

                        <span class="clear"></span>
                    </td>
                </tr>
            
                <tr id="rowBuyout" class="overlay-buyout">
                    <td class="action-row">
                        <div class="action-button">
                            <a href="#"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.confirm']" /></a>
                        </div>

                        <div class="action-message">
                            <div class="overlay-start">
                                <xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.buyout']" />

                                <div class="buyCol">
                                    <span class="copperCoin">0</span>
                                    <span class="silverCoin">0</span>
                                    <span class="goldCoin">0</span>
                                </div>
                            </div>

                            <div class="overlay-finish" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.buyoutFinish']" /></b>
                            </div>

                            <div class="overlay-error textYellow" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.error']" /></b>
                            </div>
                        </div>

                        <span class="clear"></span>
                    </td>
                </tr>
            
                <tr id="rowCancel" class="overlay-cancel">
                    <td class="action-row">
                        <div class="action-button">
                            <a href="#"><xsl:value-of select="$loc/strs/auctionHouse/str[@id='button.confirm']" /></a>
                        </div>

                        <div class="action-message">
                            <div class="overlay-start">
                                <xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.cancelAuction']" />
                            </div>

                            <div class="overlay-error textYellow" style="display: none">
                                <b><xsl:value-of select="$loc/strs/auctionHouse/str[@id='msg.error']" /></b>
                            </div>
                        </div>

                        <span class="clear"></span>
                    </td>
                </tr>
            </table>
        </div>
    </xsl:template>
    
	<xsl:template name="itemListing">
    	<xsl:param name="inventory" />
    	<xsl:param name="mail" />
        <xsl:param name="autoUpdate" />

        <xsl:if test="$autoUpdate = 'true'">
            <script type="text/javascript">
                $(function() {
                    AuctionCreate.bagTotals.bag = <xsl:value-of select="count($inventory/items/invItem[@inventory > 0])" />;
                    AuctionCreate.bagTotals.bank = <xsl:value-of select="count($inventory/items/invItem[@banked > 0])" />;
                    AuctionCreate.bagTotals.mail = <xsl:value-of select="count($inventory/items/invItem[@mail > 0])" />;
                    AuctionCreate.bagTotals.all = AuctionCreate.bagTotals.bag + AuctionCreate.bagTotals.bank + AuctionCreate.bagTotals.mail;

                    $('#bagQty_3').html(AuctionCreate.bagTotals.mail.toString());
                    $('#bagQty_2').html(AuctionCreate.bagTotals.bank.toString());
                    $('#bagQty_1').html(AuctionCreate.bagTotals.bag.toString());
                    $('#bagQty_0').html(AuctionCreate.bagTotals.all.toString());
                });
            </script>
        </xsl:if>
        
        <div id="filterItemList">
            <div id="sortAll">
                <table cellpadding="0" class="auctionTable" cellspacing="0">
                    <tbody>
                        <xsl:for-each select="$inventory/items/invItem">
                            <xsl:variable name="item">
                                <xsl:choose>
                                    <xsl:when test="@guid"><xsl:value-of select="@guid" /></xsl:when>
                                    <xsl:otherwise><xsl:value-of select="@id" /></xsl:otherwise>
                                </xsl:choose>
                            </xsl:variable>

                            <xsl:variable name="itemName">
                                <xsl:call-template name="search-and-replace">
                                    <xsl:with-param name="input" select="@n" />
                                    <xsl:with-param name="search-string" select="'&quot;'" />
                                    <xsl:with-param name="replace-string" select="'\&quot;'" />
                                </xsl:call-template>
                         	</xsl:variable>

                            <xsl:variable name="source">
                                <xsl:if test="@mail > 0">3</xsl:if>
                                <xsl:if test="@banked > 0">2</xsl:if>
                                <xsl:if test="@inventory > 0">1</xsl:if>
                            </xsl:variable> 

                            <tr id="auction_0_{$item}" onclick="AuctionCreate.chooseItem(i0_{$item}, this);">
                                <xsl:attribute name="class">
                                    <xsl:if test="position() mod 2 != 1">odd<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isCo = 'true'">isCo<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isTr = 'true'">isTr<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isEq = 'true'">isEq<xsl:text> </xsl:text></xsl:if>
                                    quality<xsl:value-of select="@qual" />
                                </xsl:attribute>

                                <td colspan="2" style="width: 70%">
                                    <script type="text/javascript">
                                        var i0_<xsl:value-of select="$item" /> = {
                                            id: '<xsl:value-of select="@id" />',
                                            guid: '<xsl:value-of select="@guid" />',
                                            qty: '<xsl:value-of select="@quan" />',
                                            stack: '<xsl:value-of select="@stack" />',
                                            name: "<xsl:value-of select='$itemName' />",
                                            icon: '<xsl:value-of select="@icon" />',
                                            source: '<xsl:value-of select="$source" />',
                                            quality: '<xsl:value-of select="@qual" />',
                                            obj: '<xsl:value-of select="$item" />'
                                        }
                                    </script>

                                    <a id="{@id}" href="#" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');" style="background: url('wow-icons/_images/21x21/{@icon}.png') 0 0 no-repeat;" onclick="return false;">
                                        <xsl:call-template name="truncate">
                                            <xsl:with-param name="string" select="@n" />
                                            <xsl:with-param name="length" select="'30'" />
                                        </xsl:call-template>
                                    </a>
                                </td>
                                <td class="ac"><span id="itemQty_0_{$item}"><xsl:value-of select="@quan" /></span></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </div>

            <div id="sortInv" style="display: none">
                <xsl:if test="$inventory/items/invItem[@inventory > 0]">
                <table cellpadding="0" class="auctionTable" cellspacing="0">      
                    <tbody>   
                        <xsl:for-each select="$inventory/items/invItem[@inventory > 0]">
                            <xsl:variable name="item">
                                <xsl:choose>
                                    <xsl:when test="@guid"><xsl:value-of select="@guid" /></xsl:when>
                                    <xsl:otherwise><xsl:value-of select="@id" /></xsl:otherwise>
                                </xsl:choose>        
                            </xsl:variable> 
                            
                            <xsl:variable name="itemName">
                                <xsl:call-template name="search-and-replace">
                                    <xsl:with-param name="input" select="@n" />
                                    <xsl:with-param name="search-string" select="'&quot;'" />
                                    <xsl:with-param name="replace-string" select="'\&quot;'" />
                                </xsl:call-template>
                         	</xsl:variable>       
                            
                            <tr id="auction_1_{$item}" onclick="AuctionCreate.chooseItem(i1_{$item}, this);">
                                <xsl:attribute name="class">
                                    <xsl:if test="position() mod 2 != 1">odd<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isCo = 'true'">isCo<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isTr = 'true'">isTr<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isEq = 'true'">isEq<xsl:text> </xsl:text></xsl:if>
                                    quality<xsl:value-of select="@qual" />
                                </xsl:attribute>
                                
                                <td colspan="2" style="width: 70%">
                                    <script type="text/javascript">
                                        var i1_<xsl:value-of select="$item" /> = {
                                            id: '<xsl:value-of select="@id" />',
                                            guid: '<xsl:value-of select="@guid" />',
                                            qty: '<xsl:value-of select="@inventory" />',
                                            stack: '<xsl:value-of select="@stack" />',
                                            name: "<xsl:value-of select='$itemName' />",
                                            icon: '<xsl:value-of select="@icon" />',
                                            source: '1',
                                            quality: '<xsl:value-of select="@qual" />',
                                            obj: '<xsl:value-of select="$item" />'
                                        }
                                    </script>
                                    
                                    <a id="{@id}" href="#" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');" style="background: url('wow-icons/_images/21x21/{@icon}.png') 0 0 no-repeat;" onclick="return false;">
                                        <xsl:call-template name="truncate">
                                            <xsl:with-param name="string" select="@n" />
                                            <xsl:with-param name="length" select="'30'" />
                                        </xsl:call-template>
                                    </a>
                                </td>
                                <td class="ac"><span id="itemQty_1_{$item}"><xsl:value-of select="@inventory" /></span></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>        
                </table>
                </xsl:if> 
            </div>
            
            <div id="sortBank" style="display: none">
                <xsl:if test="$inventory/items/invItem[@banked > 0]">
                <table cellpadding="0" class="auctionTable" cellspacing="0">      
                    <tbody>   
                        <xsl:for-each select="$inventory/items/invItem[@banked > 0]">
                            <xsl:variable name="item">
                                <xsl:choose>
                                    <xsl:when test="@guid"><xsl:value-of select="@guid" /></xsl:when>
                                    <xsl:otherwise><xsl:value-of select="@id" /></xsl:otherwise>
                                </xsl:choose>        
                            </xsl:variable>
                            
                            <xsl:variable name="itemName">
                                <xsl:call-template name="search-and-replace">
                                    <xsl:with-param name="input" select="@n" />
                                    <xsl:with-param name="search-string" select="'&quot;'" />
                                    <xsl:with-param name="replace-string" select="'\&quot;'" />
                                </xsl:call-template>
                         	</xsl:variable>   
                            
                            <tr id="auction_2_{$item}" onclick="AuctionCreate.chooseItem(i2_{$item}, this);">
                                <xsl:attribute name="class">
                                    <xsl:if test="position() mod 2 != 1">odd<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isCo = 'true'">isCo<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isTr = 'true'">isTr<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isEq = 'true'">isEq<xsl:text> </xsl:text></xsl:if>
                                    quality<xsl:value-of select="@qual" />
                                </xsl:attribute>
                                
                                <td colspan="2" style="width: 70%">
                                    <script type="text/javascript">
                                        var i2_<xsl:value-of select="$item" /> = {
                                            id: '<xsl:value-of select="@id" />',
                                            guid: '<xsl:value-of select="@guid" />',
                                            qty: '<xsl:value-of select="@banked" />',
                                            stack: '<xsl:value-of select="@stack" />',
                                            name: "<xsl:value-of select='$itemName' />",
                                            icon: '<xsl:value-of select="@icon" />',
                                            source: '2',
                                            quality: '<xsl:value-of select="@qual" />',
                                            obj: '<xsl:value-of select="$item" />'
                                        }
                                    </script>
                                    
                                    <a id="{@id}" href="#" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');" style="background: url('wow-icons/_images/21x21/{@icon}.png') 0 0 no-repeat;" onclick="return false;">
                                        <xsl:call-template name="truncate">
                                            <xsl:with-param name="string" select="@n" />
                                            <xsl:with-param name="length" select="'30'" />
                                        </xsl:call-template>
                                    </a>
                                </td>
                                <td class="ac"><span id="itemQty_2_{$item}"><xsl:value-of select="@banked" /></span></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>        
                </table> 
                </xsl:if>
            </div>      
            
            <div id="sortMail" style="display: none">
                <xsl:if test="$inventory/items/invItem[@mail > 0]">
                <table cellpadding="0" class="auctionTable" cellspacing="0">      
                    <tbody>   
                        <xsl:for-each select="$inventory/items/invItem[@mail > 0]">
                            <xsl:variable name="item">
                                <xsl:choose>
                                    <xsl:when test="@guid"><xsl:value-of select="@guid" /></xsl:when>
                                    <xsl:otherwise><xsl:value-of select="@id" /></xsl:otherwise>
                                </xsl:choose>        
                            </xsl:variable>
                            
                            <xsl:variable name="itemName">
                                <xsl:call-template name="search-and-replace">
                                    <xsl:with-param name="input" select="@n" />
                                    <xsl:with-param name="search-string" select="'&quot;'" />
                                    <xsl:with-param name="replace-string" select="'\&quot;'" />
                                </xsl:call-template>
                         	</xsl:variable>   
                                
                            <tr id="auction_3_{$item}" onclick="AuctionCreate.chooseItem(i3_{$item}, this);">
                                <xsl:attribute name="class">
                                    <xsl:if test="position() mod 2 != 1">odd<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isCo = 'true'">isCo<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isTr = 'true'">isTr<xsl:text> </xsl:text></xsl:if>
                                    <xsl:if test="@isEq = 'true'">isEq<xsl:text> </xsl:text></xsl:if>
                                    quality<xsl:value-of select="@qual" />
                                </xsl:attribute>
                                
                                <td colspan="2" style="width: 70%">
                                    <script type="text/javascript">
                                        var i3_<xsl:value-of select="$item" /> = {
                                            id: '<xsl:value-of select="@id" />',
                                            guid: '<xsl:value-of select="@guid" />',
                                            qty: '<xsl:value-of select="@mail" />',
                                            stack: '<xsl:value-of select="@stack" />',
                                            name: "<xsl:value-of select='$itemName' />",
                                            icon: '<xsl:value-of select="@icon" />',
                                            source: '3',
                                            quality: '<xsl:value-of select="@qual" />',
                                            obj: '<xsl:value-of select="$item" />'
                                        }
                                    </script>
                                    
                                    <a id="{@id}" href="#" class="rarity{@qual} staticTip itemToolTip" onmouseover="setTipParams('{@seed}', '{@rand}', '{@charges}');" style="background: url('wow-icons/_images/21x21/{@icon}.png') 0 0 no-repeat;" onclick="return false;">
                                        <xsl:call-template name="truncate">
                                            <xsl:with-param name="string" select="@n" />
                                            <xsl:with-param name="length" select="'30'" />
                                        </xsl:call-template>
                                    </a>
                                </td>
                                <td class="ac"><span id="itemQty_3_{$item}"><xsl:value-of select="@mail" /></span></td>
                            </tr>
                        </xsl:for-each>
                    </tbody>        
                </table> 
                </xsl:if>
            </div>
        </div>  
    </xsl:template>
    
    <!-- Gold format - Turns bronze into real amount -->
    <xsl:template name="goldFormat">
        <xsl:param name="totalMoney" />
        <xsl:param name="styleSuffix" />

        <xsl:variable name="gold" select="floor($totalMoney div 10000)" />
        <xsl:variable name="silver" select="floor(($totalMoney - ($gold * 10000)) div 100)" />
        <xsl:variable name="copper" select="floor(($totalMoney - ($gold * 10000)) - ($silver * 100))" />
        
        <span class="copperCoin{$styleSuffix}">
        	<xsl:choose>
            	<xsl:when test="$copper > -1"><xsl:value-of select="$copper" /></xsl:when>
                <xsl:otherwise>--</xsl:otherwise>
        	</xsl:choose>
       	</span>
        
        <span class="silverCoin{$styleSuffix}">
        	<xsl:choose>
            	<xsl:when test="$silver > -1"><xsl:value-of select="$silver" /></xsl:when>
                <xsl:otherwise>--</xsl:otherwise>
        	</xsl:choose>
        </span>
            
        <span class="goldCoin{$styleSuffix}">
        	<xsl:choose>
            	<xsl:when test="$gold > -1"><xsl:value-of select="$gold" /></xsl:when>
                <xsl:otherwise>--</xsl:otherwise>
        	</xsl:choose>
        </span>
        
        <span class="clear"><!----></span>   
    </xsl:template>
    
    <!-- Convert milliseconds to days -->
    <xsl:template name="timeLeftFormat">
    	<xsl:param name="seconds" />
        <xsl:variable name="time" select="round(((($seconds div 1000) div 60) div 60) div 24)" />
        
        <xsl:value-of select="$time" />
        <xsl:text> </xsl:text>
        <xsl:value-of select="$loc/strs/auctionHouse/str[@id='days']" />
   	</xsl:template>

</xsl:stylesheet>