
$.ajaxSetup({
	error: function (XMLHttpRequest, textStatus, errorThrown) {
		
		// If user session is timed out, request will fail
		if (XMLHttpRequest.status != 200)
			document.location = '/auctionhouse/index.xml';
	}
});

/**
 * Package all auction functions into a class namespace
 */
var Auction = {

    /**
     * Transaction data.
     */
    transactions: {
        firstWarning: false,
        secondWarning: false,
        totalLeft: null,
        maxLimit: 25, // 200 for live
        maxBatch: 20
    },
	
	/**
	 * Create overlay for bidding.
     * 
	 * @param int id - Auction ID
	 * @param int minBid - Minimum bid amount
     * @param int buyoutPrice
	 */
	openBid: function(id, minBid) {
        Auction.closeOverlays();

		var row = $("#auction_"+ id);
        var obj = Auction.clone(id, 'rowBid', row);

        obj.find('.action-button a').click(function() {
            Auction.bid(id, this);
            return false;
        });

        var money = Auction.formatMoney(minBid);
		$('#auctionClone_'+ id +' .enter-bid-gold').val(money.gold);
		$('#auctionClone_'+ id +' .enter-bid-silver').val(money.silver);
		$('#auctionClone_'+ id +' .enter-bid-copper').val(money.copper);
        
		return false;
	},
	
	/**
	 * Bid on an item / Send data through AJAX.
     *
     * @param int id
	 * @param obj button
	 */
	bid: function(id, button) {
		var gold    = $('#auctionClone_'+ id +' .enter-bid-gold').val();
		var silver  = $('#auctionClone_'+ id +' .enter-bid-silver').val();
		var copper  = $('#auctionClone_'+ id +' .enter-bid-copper').val();
		var total   = Auction.deformatMoney(gold, silver, copper);

        if (!total || isNaN(total))
            total = 0;

        $.ajax({
            url: '/auctionhouse/bid.json',
            data: {
                auc: id,
                money: total
            },
            dataType: 'json',
            type: 'POST',
            success: function(data, status) {
                $(button).parent('.action-button').remove();
                
                var tpl = 'overlay-bidfinish';

                if (data.error)
                    tpl = 'overlay-error';
                else if (data.buyout)
                    tpl = 'overlay-buyoutfinish';

                $('#auctionClone_'+ id +' .action-message div').hide();
                $('#auctionClone_'+ id +' .action-message .'+ tpl).show();

                if (data.error) {
                    $('#auctionClone_'+ id +' .action-message .'+ tpl +' b').html(Auction.parseErrorMsg(data));

                } else {
                    if (data.buyout) {
                        Auction.toast('won');
                        Auction.decreaseCounter('activeBids_counter');
                        Auction.wonItemCache[data.aucItem.auc] = true;
                    } else {
                        Auction.toast('bid');
                    }

                    Auction.increaseCounter('myBidsTotal');
                    Auction.updateMoney(data.moneySpent, '-');
                    
                    $('#auction_'+ id +' .bidCol .goldCoin').html(gold);
                    $('#auction_'+ id +' .bidCol .silverCoin').html(silver);
                    $('#auction_'+ id +' .bidCol .copperCoin').html(copper);
                    $('#auction_'+ id +' .highBidder').show();
                    $('#auction_'+ id +' .openBid').hide();

                    window.setTimeout(function() {
                        Auction.closeOverlay(id, (data.buyout));
                        Auction.toggleButtons(id, true);
                    }, 2000);
                }

                // Transaction
                if (data.transactions) {
                    Auction.alertTransaction(data.transactions);
                }
            }
        });
		
		return false;
	},
	
	/**
	 * Create overlay for buyout.
     * 
	 * @param int id - Auction ID
	 * @param int buyPrice
	 */
	openBuyout: function(id, buyPrice) {
        Auction.closeOverlays();

		var row = $("#auction_"+ id);
        var obj = Auction.clone(id, 'rowBuyout', row);

        obj.find('.action-button a').click(function() {
            Auction.buyout(id, this, buyPrice);
            return false;
        });

        var money = Auction.formatMoney(buyPrice);
		$('#auctionClone_'+ id +' .action-message .goldCoin').html(money.gold.toString());
        $('#auctionClone_'+ id +' .action-message .silverCoin').html(money.silver.toString());
        $('#auctionClone_'+ id +' .action-message .copperCoin').html(money.copper.toString());

		return false;
	},
	
	/**
	 * Buyout an item / Send data through AJAX.
     *
	 * @param int id
	 * @param obj button
	 * @param int amount
	 */
	buyout: function(id, button, amount) {
		$.ajax({
			url: '/auctionhouse/bid.json',
			data: {
                auc: id,
                money: amount
            },
			dataType: 'json',
			type: 'POST',
			success: function(data, status) {
                $(button).parent('.action-button').remove();
                
                var tpl = (data.error) ? 'overlay-error' : 'overlay-finish';

                $('#auctionClone_'+ id +' .action-message div').hide();
                $('#auctionClone_'+ id +' .action-message .'+ tpl).show();

                if (data.error) {
                    $('#auctionClone_'+ id +' .action-message .'+ tpl +' b').html(Auction.parseErrorMsg(data));

                } else {
                    Auction.toast('won');
                    Auction.updateMoney(amount, '-');
                    Auction.increaseCounter('myBidsTotal');
                    Auction.decreaseCounter('activeBids_counter');
                    Auction.wonItemCache[data.aucItem.auc] = true;

                    if ($('#tab_bids').hasClass('selected-tab'))
                        Auction.decreaseCounter('myBidsTotal');

                    window.setTimeout(function() {
                        Auction.closeOverlay(id, true);
                    }, 2000);
                }

                // Transaction
                if (data.transactions) {
                    Auction.alertTransaction(data.transactions);
                }
			}
		});
		
		return false;
	},
	
	/**
	 * Create the overlay for cancelling an auction.
     *
	 * @param int id - Auction ID
	 */
	openCancel: function(id) {
        Auction.closeOverlays();

		var row = $("#auction_"+ id);
        var obj = Auction.clone(id, 'rowCancel', row);

        obj.find('.action-button a').click(function() {
            Auction.cancel(id, this);
            return false;
        });

		return false;
	},
	
	/**
	 * Send the call to cancel the auction.
     *
     * @param int id
	 * @param obj button
	 */
	cancel: function(id, button) {
		$.ajax({
			url: '/auctionhouse/cancel.json',
			data: {
                auc: id
            },
			dataType: 'json',
			type: 'POST',
			success: function(data, status) {                
				if (data.success) {
					Auction.decreaseCounter('activeAuctions_counter');
					Auction.decreaseCounter('myAuctionsTotal');
					Auction.toast('cancelled');
					Auction.updateBuyoutTotal(id);
					Auction.closeOverlay(id, true);
                    
					setTimeout(function() {
						var table = $('#table_active');
						if (table.find('table tbody tr').length == 0) {
							table.siblings('.tableTitle').find('a').addClass('closed');
							table.remove();
						}
					}, 1000);

				} else {
                    $(button).parent('.action-button').remove();

                    $('#auctionClone_'+ id +' .action-message').find('div').hide();
                    $('#auctionClone_'+ id +' .action-message .overlay-error').show().find('b').html(data.error.message);
				}
			}
		});
		
		return false;
	},
	
	/**
	 * Relist the item.
     *
	 * @param obj params
	 */
	relist: function(params) {
        Auction.openPage('create', { n: params.name }, function() {
			setTimeout(function() {
				AuctionCreate.chooseItem(params, $('#auction_0_'+ params.obj));
			}, 500);
		});
	},
	
	/**
	 * Get money from an auction.
     *
	 * @param int id - Auction ID
	 * @param int mail_id
	 * @param obj button
	 */
	getMoney: function(id, mail_id, button, page) {
		$(button).addClass('disabled').attr('onclick', '');

		var data = {};
		var counter = (page == 'bid') ? 'bidsLost_counter' : 'auctionsSold_counter';
		
		if (mail_id)
			data.mailIds = mail_id;
        else
            data.auc = id;

		$.ajax({
			url: '/auctionhouse/takeMail.json',
			data: data,
			dataType: 'json',
			type: 'POST',
			success: function(data, status) {
                if (data.error) {
                    var colSpan = ($.browser.msie) ? 'colSpan' : 'colspan';
                    var td = $('<td>')
                        .html('<b>'+ data.error.message +'</b>')
                        .attr(colSpan, 5)
                        .addClass('ar textRed');

                    $('#auction_'+ id +' td:gt(0)').remove();
                    $('#auction_'+ id).append(td);
                    
                } else {
                    Auction.updateMoney(data.money, '+');
                    Auction.decreaseCounter(counter);
                    Auction.fadeRow(id, null);
                }
			}
		});
		
		return false;
	},
	
	/**
	 * Get all money from all auctions listed.
     * 
	 * @param string table
	 * @param string page
	 * @param obj button
	 */
	getAllMoney: function(table, page, button) {
		var inputs = $('#'+ table +' .auction-mailIds');
		var counter = (page == 'bid') ? 'bidsLost_counter' : 'auctionsSold_counter';
		var ids = [];
		
		$.each(inputs, function(k, v) {
			ids[ids.length] = $(v).val();
		});
		
		$.ajax({
			url: '/auctionhouse/takeMail.json',
			data: {
                mailIds: ids.join(',')
            },
			dataType: 'json',
			type: 'POST',
			success: function(data, status) {
				Auction.updateMoney(data.money, '+');
				Auction.decreaseCounter(counter, ids.length);
				
				var node = $('#'+ table);
				
				node.siblings('.tableTitle').find('a').addClass('closed');
				node.find('tbody tr:not(.moneyArrived)').fadeOut('normal', function() { 
					$(this).remove(); 
					
					if (node.find('tbody tr').length == 0)
						node.remove();
				});
				
				$(button).remove();
			}
		});
		
		return false;
	},
	
	/**
	 * Get your current chars total money.
	 */
	loadMoney: function() {
		$.ajax({
			url: '/auctionhouse/money.json',
			dataType: 'json',
			type: 'GET',
			success: function(data, status) {
				if (data.money) {
					var amount = Auction.formatMoney(data.money);
					
					$('#baseCurrentMoney').html(data.money);
                    $('#auctionHouse .goldCoin').html(amount.gold.toString());
                    $('#auctionHouse .silverCoin').html(amount.silver.toString());
                    $('#auctionHouse .copperCoin').html(amount.copper.toString());
				}
			}
		});

        window.setTimeout(function() {
            Auction.loadMoney();
        }, 300000);
		
		return false;
	},
	
	/**
	 * Update the static money at the top left.
     * 
	 * @param int value
	 * @param string mode
	 */
	updateMoney: function(value, mode) {
		var current = parseInt($('#baseCurrentMoney').html());
		var total = (mode == '+') ? Math.round(current + value) : Math.round(current - value);
		var amount = Auction.formatMoney(total);
					
		$('#baseCurrentMoney').html(total);
        $('#auctionHouse .goldCoin').html(amount.gold.toString());
        $('#auctionHouse .silverCoin').html(amount.silver.toString());
        $('#auctionHouse .copperCoin').html(amount.copper.toString());
	},

    /**
     * Last opened overlay ID.
     */
    lastOverlay: null,
	
	/**
	 * Clone the row, apply attributes then return.
     * 
	 * @param int id
	 * @param string element
	 * @param obj source
	 */
	clone: function(id, element, source) {
		var obj = $('#'+ element).clone();
        var colSpan = ($.browser.msie) ? 'colSpan' : 'colspan';

		obj
            .attr('id', 'auctionClone_'+ id)
            .addClass('auction-overlay')
            .find('td')
                .attr(colSpan, source.find('td').length)
            .end()
            .find('.action-message, .action-button')
                .hide()
            .end();

        source
            .after(obj)
            .addClass('auction-selected');

        obj.find('.action-message, .action-button').fadeIn('normal');

        $('.auctionButtons', source).hide();
        $('.auctionButtons.locked', source).show();
            
		/*var cancel = $('#rowCloseButton').clone();
        obj.find('.auctionTable').html(source.clone().addClass('auction-selected'));

        // Set cell widths
        var length = $('td', source).length;
        var width;

        for (var i = 0; i <= length; ++i) {
            width = $('td:eq('+ i +')', source).width();

            if (i > 0 && width)
                $('td:eq('+ i +')', obj).css('width', width + 2);
        }

        // Add cancel
        cancel.removeAttr('id').click(function() {
            Auction.closeOverlay(id);
            return false;
        });

        obj.find('.auctionTable td:last')
            .css('width', '100px')
            .attr('valign', 'middle')
            .removeClass('ar')
            .addClass('ac')
            .html(cancel);

        // Position
        var blackout = $('#overlayMask');
        var body = $('body');
        var props = {
            width: body.width(),
            height: body.height()
        };

        if ($.browser.msie) {
            props.position = 'absolute';
            props.top = body.scrollTop();
            blackout.fadeTo(100, .7);
            $('select').hide();
        }

        blackout
            .css(props)
            .click(function() {
                Auction.closeOverlay(id);
                $(this).unbind('click');
            }).show();

        Auction.positionOverlay(id);

        $(window).bind('resize.overlay'+ id, function() {
            Auction.positionOverlay(id);
        });*/

        // Save ID
        Auction.lastOverlay = id;
        
		return obj;
	},

    /**
     * Position the overlay.
     *
     * @param int id
     * @deprecated
     */
    _positionOverlay: function(id) {
        var offset = $('#auction_'+ id).offset();
        var overlay = $('#auctionClone_'+ id);

        overlay.css({
            top: offset.top - 3,
            left: offset.left - 2
        });
    },

    /**
     * Close the overlay.
     *
     * @param int id
     * @param boolean deleteSource
     */
    closeOverlay: function(id, deleteSource) {
        var source = $('#auction_'+ id);
        source.removeClass('auction-selected');
        
        $('#auctionClone_'+ id).remove();
        $('.auctionButtons', source).hide();
        $('.auctionButtons.enabled', source).show();

        if (deleteSource)
            source.remove();

        Auction.lastOverlay = null;

        /*$('#auctionClone_'+ id).fadeOut('fast', function() {
            $(this).remove();
            $('#overlayMask').hide();

            if (deleteSource)
                $('#auction_'+ id).remove();

            if ($.browser.msie)
                $('select').show();
        });

        $(window).unbind('resize.overlay'+ id);
        Auction.lastOverlay = null;*/
    },

    /**
     * Close all overlays.
     */
    closeOverlays: function() {
        $('.auction-overlay').remove();
        $('.auctionTable tr').removeClass('auction-selected');

        Auction.closeOverlay(Auction.lastOverlay);

        /*if (Auction.lastOverlay) {
            $(window).unbind('resize.overlay'+ Auction.lastOverlay);
            Auction.lastOverlay = null;
        }*/
    },
	
	/**
	 * Fade out a row then remove it.
     * 
	 * @param int id
	 * @param obj button
     * @param int speed
	 */
	fadeRow: function(id, button, speed) {
        if (!speed)
            speed = 'fast';

        $('#aucButtons_'+ id +' .auctionButtons').removeAttr('onclick');

        // Cant fade out both
		$('#auction_'+ id).fadeOut(speed, function () {
			$(this).remove(); 
		});
		
		$('#auctionClone_'+ id).fadeOut(speed, function () {
			$(this).remove(); 
		});
		
		return false;
	},
	
	/**
	 * Format a money amount into its 3 parts.
     * 
	 * @param int amount
	 * @return obj
	 */
	formatMoney: function(amount) {
		var gold = Math.floor(amount / 10000);
		var silver = Math.floor((amount - (gold * 10000)) / 100);
		var copper = Math.floor((amount - (gold * 10000)) - (silver * 100));
		
		if (!silver) silver = '0';
		if (!copper) copper = '0';
		if (!gold) 	 gold = '0';
		
		return {
			gold: gold,
			silver: silver,
			copper: copper
		};
	},
	
	/**
	 * Format 3 parts into a single money value.
     * 
	 * @param int amount
	 * @return obj
	 */
	deformatMoney: function(gold, silver, copper) {
		gold = Math.round(gold);
		silver = Math.round(silver);
		copper = Math.round(copper);
			
		return (((gold * 100) * 100) + (silver * 100) + (copper * 1));
	},
	
	/**
	 * Open a page based on the hash, or the given url.
     * 
	 * @param string url
	 * @param obj query
	 * @param function callback
	 */
	openPage: function(url, query, callback) {
        Auction.closeOverlays();
    
		var hash = window.location.hash;
        
        // Determine the hash / fragment
		if (url) {
			hash = url;
		} else {
			hash = (!hash || hash == '') ? 'summary' : hash.replace('#', '');
		}

        // Build query
        if (!query) {
            query = {};

            if (hash == 'search') {
                if (searchTerm = getcookie2('armory.ah.search')) {
                    if (searchTerm != ';')
                        query.n = searchTerm;
                    
                    deleteCookie('armory.ah.search');

                } else if (lastSearch = getcookie2('armory.ah.lastSearch')) {
                    query = lastSearch;

                } else {
                    query = { start: 0, end: 0 };
                }
            }
        }

        // Render page accordingly
        $('.tabs div').removeClass('selected-tab tab').addClass('tab');
		$('#tab_'+ hash +' a').parent().addClass('selected-tab').removeClass('tab');
		$('#auctionHouseContent').empty().addClass('loadingContent');

		if (hash == 'summary')
			$('#infoPaneContainer').addClass('summaryTakeover');
		else
			$('#infoPaneContainer').removeClass('summaryTakeover');

		// Scroll if page is down
		if ($(window).scrollTop() > 400)
            window.scrollTo(0, $('#dataElement').offset().top);

			//$('html, body').animate({ scrollTop: $('#dataElement').offset().top }, 1000);

		// Fetch new page
		$.ajax({
			url: '/auctionhouse/'+ hash +'/',
			data: Auction.appendQuery(query, hash),
			dataType: 'html',
			type: 'GET',
			success: function(data, status) {
				$('#auctionHouseContent').html(data).removeClass('loadingContent');

				Auction.openContent();
				bindToolTips();

				if (callback)
					callback();

				// Reset all objects
				AuctionCreate.current = AuctionCreate.ticket = AuctionCreate.timer = AuctionCreate.resetTimer = null;
				AuctionCreate.cached = {};
			}
		});

        return false;
	},
	
	/**
	 * Load a content panel depending on the cookie.
	 */
	openContent: function() {
		var panels = getcookie2('armory.ah.panels');
		
		if (panels) {
			panels = panels.split(',');
		
			$.each(panels, function() {
				var slug = this.split('_');
				
				$('#toggle_'+ slug[1]).addClass('opened');
				$('#'+ this).show();					
			});
		}
	},

    /**
     * Append the char info into the query.
     *
     * @param obj|string query
     * @return mixed
     */
    appendQuery: function(query, hash) {
        var name = $('#char_name').val();
        var realm = $('#char_realm').val();
        var faction = $('#char_faction').val();

        if (!faction) faction = 2;

        if (typeof query == "object") {
            query.rhtml = true;
            query.cn = name;
            query.r = realm;
            query.f = faction;
            
            if (hash == 'create')
                query.xsl = '/_layout/auction/create.xsl';

        } else if (typeof query == "string") {
            query += '&rhtml=true&cn='+ urlEncode(name) +'&r='+ urlEncode(realm) +'&f='+ urlEncode(faction);

            if (hash == 'create')
                query += '&xsl=/_layout/auction/create.xsl';
        }

        return query;
    },

	/**
	 * Open and close panes, save state to a cookie.
     * 
	 * @param string id
	 * @param obj node
	 */
	toggleContent: function(id, node) {
        node = $(node);
		
		$('#table_'+ id).toggle();
		Auction.toggleButtons(null, false);

        // Get panels
		var cookie = getcookie2('armory.ah.panels');
		
		if (cookie.substr(0, 1) == ',')
			cookie = cookie.substr(1, cookie.length - 1);
		
		var panels  = cookie.split(',');
		var index   = $.inArray('table_'+ id, panels);

        // Filter
		if (node.hasClass('opened')) {
			node.removeClass('opened');
			
			if (index >= 0)
				panels.splice(index, 1);
				
		} else {
			node.addClass('opened');
			
			if (index < 0)
				panels.push('table_'+ id);
		}
			
		setcookie('armory.ah.panels', panels.join(','), true);
	},

	/**
	 * Enable or disable the buttons in the row.
     *
	 * @param int id
	 * @param boolean disable
	 */
	toggleButtons: function(id, disable) {
        if (id) {
            var source = $("#auction_"+ id);
            $('.auctionButtons', source).hide();

            if (disable)
                $('.auctionButtons.disabled', source).show();
            else
                $('.auctionButtons.enabled', source).show();
            
        } else {
            $('.auctionButtons').hide();

            if (disable)
                $('.auctionButtons.disabled').show();
            else
                $('.auctionButtons.enabled').show();
        }
	},

    /**
     * An key/value object of re-usable toast messages.
     */
    toastMsgs: {},

    /**
	 * Toast out a message!
     * 
	 * @param string msg
     * @param int timer
     * @param obj opts
	 */
    toast: function(msg, timer, opts) {
        if (Auction.toastMsgs[msg]) {
            var container = $('#toastContainer');
            var toast = $('<div>')
                .addClass('ahToast')
                .html(Auction.toastMsgs[msg])
                .hide()
                .appendTo(container);

            // Set binds
            switch (msg) {
                case 'bid': case 'outbid': case 'won':
                    toast.click(function() {
                        openAuctionPage('bids');
                    });
                break;
                case 'sold': case 'cancelled': case 'expired': case 'created': case 'total':
                    toast.click(function() {
                        openAuctionPage('auctions');
                    });
                break;
            }

            // Set timer
            if (timer === false) {
                toast.click(function() {
                   toast.fadeOut('normal', function() {
                       $(this).remove();
                   });
                });
                
                //Auction.flashTitle(msg);
            } else {
                if (isNaN(timer))
                    timer = 3000;
                
                setTimeout(function() {
                    toast.fadeOut('normal', function() {
                       $(this).remove();
                   });
                }, timer);
            }

            // Set options
            if (opts) {
                if (opts.total)
                    toast.html(Auction.toastMsgs[msg].replace('{total}', opts.total));
            }

            var totalToasts = $('#toastContainer .ahToast');

            if (totalToasts.length > 10) {
                var removeLimit = Math.round(totalToasts.length - 10);
                $('#toastContainer .ahToast:lt('+ removeLimit +')').fadeOut();
            }

            // Create close
            $('<a/>')
                .addClass('toastClose')
                .attr('href', '#close')
                .click(function() {
                    $(this).parent('.ahToast').fadeOut('normal', function() {
                        $(this).remove();
                    });
                    return false;
                })
                .appendTo(toast);

            // Show the toast!
            toast.fadeIn();
        }
    },
	
	/**
	 * Increase the values for a certain field.
     * 
	 * @param string id
	 * @param int amount
	 */
	increaseCounter: function(id, amount) {
		if (!amount) amount = 1;
			
		var source  = $('#'+ id);

        if (data = source.html()) {
            var counter = parseInt(data) + amount;

            if (counter < 0) counter = 0;

            source.html(counter.toString());
        }
	},
	
	/**
	 * Decrease the values for a certain field.
     * 
	 * @param string id
	 * @param int amount
	 */
	decreaseCounter: function(id, amount) {
		if (!amount) amount = 1;

		var source  = $('#'+ id);

        if (data = source.html()) {
            var counter = parseInt(data) - amount;

            if (counter < 0) counter = 0;

            source.html(counter.toString());
        }
	},
	
	/**
	 * Find the item in the search.
     * 
	 * @param string name
	 */
	findInAH: function(name, load) {
		name = name.replace("'", "\'");
		setcookie('armory.ah.search', name, false);

        if (load)
            Auction.openPage('search');
        else
            window.location.href = '/auctionhouse/index.xml#search';
	},
	
	/**
	 * Update the buyout total after an auction cancel.
     * 
	 * @param int id - Auction Id
	 */
	updateBuyoutTotal: function(id) {
		var total   = $('#buyoutTotal').val();
		var gold    = $('#auction_'+ id +' .buyCol .goldCoin').html();
		var silver  = $('#auction_'+ id +' .buyCol .silverCoin').html();
		var copper  = $('#auction_'+ id +' .buyCol .copperCoin').html();
		
		if (gold == '--' || !gold)      gold = '0';
		if (silver == '--' || !silver)  silver = '0';
		if (copper == '--' || !copper)  copper = '0';
		
		var amount = Auction.deformatMoney(gold, silver, copper);
		$('#buyoutTotal').val((total - amount));
		
		var newTotal = Auction.formatMoney((total - amount));
		$('#buyoutTotalChart .goldCoin').html(newTotal.gold.toString());
		$('#buyoutTotalChart .silverCoin').html(newTotal.silver.toString());
		$('#buyoutTotalChart .copperCoin').html(newTotal.copper.toString());
	},

    /**
     * Switch the auction houses.
     * 
     * @param string house
     */
    changeHouse: function(house) {
        $.ajax({
			url: '/auctionhouse/faction.json',
			data: {
                f: house
            },
			dataType: 'json',
			type: 'GET',
			success: function(data, status) {
                location.reload(true);
            }
        });
	},

	/**
     * Add an entry here when we buyout items.
     * Won Auction alerts are supressed for items in this array.
     */
	wonItemCache: [],

	/**
     * A counter for the most recent mail that has been seen
	 * Any mail with a larger ID triggers a mail alert.
     */
	checkedMail: 0,

    /**
     * Periodically pull for new mail notifications.
     */
	pullMail: function() {
		$.ajax({
			url: '/auctionhouse/mail.json',
			data: {
                lastMailId: Auction.checkedMail ? Auction.checkedMail : 0
            },
			dataType: 'json',
			type: 'GET',
			success: function(data, status) {
				var largest = 0;
				var doAlert = false;

				// Don't show alerts on the first scan of mail (it contains all results)
				if (Auction.checkedMail && Auction.checkedMail > 0) {
					doAlert = true;
					largest = Auction.checkedMail;	
				}

				// Alert for everything 
				var alertThreshold = largest;

				if (data.error) {
					return;
				} else {
                    $.each(data, function(action, mail) {
                        if (mail) {
                            for(var i in mail) {
                                if (mail[i].mailId > alertThreshold) {
                                    largest = Math.max(largest, mail[i].mailId);

                                    if (doAlert) {
                                        switch (action) {
                                            case 'won':
                                                if (Auction.wonItemCache[mail[i].auc])
                                                    Auction.wonItemCache.splice(mail[i].auc, 1);
                                                else
                                                    Auction.toast('won', false);
                                            break;
                                            case 'sold':
                                                Auction.toast('sold', false);
                                            break;
                                            case 'ended':
                                                if (mail[i].mailType == 3)
                                                    Auction.toast('expired', false);
                                            break;
                                            case 'lost':
                                                if (mail[i].mailType == 0)
                                                    Auction.toast('outbid', false);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    });

					Auction.checkedMail = largest; 
				}

                // Every 3 minutes
				setTimeout(function() {
                    Auction.pullMail();
                }, 180000);
			}
		});
	},

    /**
     * The base title for the page, when flashing page titles.
     */
    baseTitle: '',

    /**
     * The timer for the page title.
     */
    titleTimer: null,

    /**
     * Flash the page title.
     * 
     * @param string msg
     */
    flashTitle: function(msg) {
        if (!Auction.baseTitle)
            Auction.baseTitle = document.title;

        $(window).blur(function() {
            $(this).focus(function() {
                Auction.stopFlash();
            });
        });

        $(window).focus(function() {
            Auction.stopFlash();
        });

        if (Auction.toastMsgs[msg] && msg != 'total') {
            if (document.title == Auction.baseTitle)
                document.title = Auction.toastMsgs[msg];
            else
                document.title = Auction.baseTitle;

            clearTimeout(Auction.titleTimer);
            Auction.titleTimer = setTimeout(function() {
                Auction.flashTitle(msg);
            }, 1000);
        }
    },

    /**
     * Stop the rotating flash title.
     */
    stopFlash: function() {
        document.title = Auction.baseTitle;
        clearTimeout(Auction.titleTimer);
    },

    /**
     * Display remaining transaction data.
     *
     * @param object data
     */
    alertTransaction: function(data) {
        var numLeft = Auction.transactions.totalLeft = data.numLeft;
        var first = Auction.transactions.maxBatch;
        var second = Auction.transactions.maxBatch / 2;

        if (numLeft <= 0) {
            Auction.toast('transactionMax', false)

        } else if (numLeft <= 5) {
            Auction.toast('transaction', 5000, { total: numLeft });

        } else if (Auction.transactions.firstWarning == false && numLeft <= first && numLeft >= (second + 1)) {
            Auction.toast('transaction', 5000, { total: numLeft });
            Auction.transactions.firstWarning = true;

        } else if (Auction.transactions.secondWarning == false && numLeft <= second && numLeft >= 6) {
            Auction.toast('transaction', 5000, { total: numLeft });
            Auction.transactions.secondWarning = true;

        }
    },

    /**
     * Parse the error message.
     *
     * @param object error
     * @return string
     */
    parseErrorMsg: function(data) {
        if (data.error.code == 10008) {
            data.transactions.resetMillis = data.transactions.resetMillis || '';
            
            var date = new Date(data.transactions.resetMillis);
            data.error.message = data.error.message.replace('[TIME]', date.toUTCString());
        }

        return data.error.message;
    }
    
}
