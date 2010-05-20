
var AuctionCreate = {
	
	// The current chosen item data
	current: null,

    // The last chosen items ID
    last_id: null,
	
	// The current item locatin: bank, bag, mail
	sorting: 0,
	
	// Last ticket
	ticket: null,
	
	// Are we currently in the batch creation process
	creating: false,
	
	// Total amount created
	created: 0,
	
	// Timer used for search field
	timer: null,
	
	// Cached items
	cached: {},
	
	// Timer after an auction to reset the forms
	resetTimer: null,

    // Total amount of items in each bag
    bagTotals: {
        all: 0,
        bag: 0,
        bank: 0,
        mail: 0
    },

    // Values for the price per stack/item calculations
    price: {
        starting: 0,
        startingManual: 0,
        buyout: 0,
        buyoutManual: 0
    },
	
	/**
	 * Show or hide certain item lists.
     *
	 * @param int option
	 * @param object node
	 */
	filterSorting: function(option, node) {
		AuctionCreate.sorting = option;
		
		$('#createBrowseTabs .houseButton').removeClass('opened');
		$(node).addClass('opened');

        var target = 'sortAll';
        switch (option) {
            case 3: target = 'sortMail'; break;
            case 2: target = 'sortBank'; break;
            case 1: target = 'sortInv'; break;
        }

        $('#filterItemList div').hide();
        $('#filterItemList #'+ target).show();
		
		AuctionCreate.filter();
		return false;
	},
	
	/**
	 * Filter the items based on certain conditions.
	 */
	filter: function() {
		var rarity = $('#itemRarity').val();
		var option = $('#filterList').val();
		var classes = [];
		
		// Show all, hide classes that aren't
		$('#filterItemList table tr').show();
		
		// Get classes
		var maxRarity = 5;
		for (var i = rarity; i <= maxRarity; i++) {
			classes[classes.length] = '.quality'+ i;
		}
		
		$('#filterItemList table tr').not(classes.join(', ')).hide();
		
		// Filter down more
		if (option != 'isAll')
			$('#filterItemList table tr').not('.'+ option).hide();

        $('#filterItemList #createMailboxNotice').show();

        // Update bag totals
        $('#bagQty_3').html($('#sortMail tr:visible').length.toString());
        $('#bagQty_2').html($('#sortBank tr:visible').length.toString());
        $('#bagQty_1').html($('#sortInv tr:visible').length.toString());
        $('#bagQty_0').html($('#sortAll tr:visible').length.toString());
	},
	
	/**
	 * Select an item, save its data to the object, populate the fields.
     * 
	 * @param obj data
	 */
	chooseItem: function(data, row) {
		clearTimeout(AuctionCreate.resetTimer);

        if (AuctionCreate.current)
            AuctionCreate.last_id = AuctionCreate.current.id;
		
		if (AuctionCreate.current && AuctionCreate.current.obj == data.obj && AuctionCreate.current.source == data.source)
			return;
		
		if (parseInt(data.source) > 3)
			data.source = 0;
		
		if (AuctionCreate.cached[data.source +'_'+ data.obj]) {
			AuctionCreate.current = AuctionCreate.cached[data.source +'_'+ data.obj];
		} else {
			AuctionCreate.current = data;
			AuctionCreate.cached[data.source +'_'+ data.obj] = data;
		}

		AuctionCreate.sorting = data.source;

		$('#filterItemList table tr').removeClass('selected');
		$(row).addClass('selected');

		// Item info
		$('#itemIconImg').html($('<img src="/wow-icons/_images/43x43/'+ data.icon +'.png" alt="" />'));
		$('#itemName').html(data.name).removeAttr('class').addClass('rarity'+ data.quality);
		$('#quantityLeft, #totalQuantity').html(data.qty);
		$('#noOfStacks').val(1);
		$('#maxQuantity').html(data.stack);
		
		if (data.qty.length >= 4)
			$('#totalQuantity').css({ fontSize: '12px', bottom: '2px' });
		else
			$('#totalQuantity').removeAttr('style');

		// Buttons, progress
		$('#createAuctionForm input, #createAuctionForm select').removeAttr('disabled');
		$('#createButtons, #createButton').show();
		$('#createProgress, #createErrors, #createButtonDisabled, #finishMsg, #continueButton').hide();
		$('.progressBarLoader').css('width', '0%').html('');
		$('#currentCreated').html('0');

        if (data.qty == 1) {
            $('#totalQuantity').html('');
            $('#createAuctionForm select').attr('disabled', 'disabled');
            $('.maxButtonEnabled').hide();
            $('.maxButtonDisabled').show();
        } else {
            $('.maxButtonEnabled').show();
            $('.maxButtonDisabled').hide();
        }
		
		// Swap panes
		$('#chooseAnItem, #depositError').hide();
		$('#itemFields').show();
		
		AuctionCreate.maxQuantity();
		AuctionCreate.loadSimilar('unitBuyout', 'false', true);
        AuctionCreate.price.starting = 0;
        AuctionCreate.price.startingManual = 0;
        AuctionCreate.price.buyout = 0;
        AuctionCreate.price.buyoutManual = 0;
	},
	
	/**
	 * Load the similar auctions.
	 */
	loadSimilar: function(sort, reversed, reload) {
		if (!AuctionCreate.current)
			return;

        if (!sort)
            sort = $('#sort_money .sortLink:eq(0)').attr('rel');

        var searchQuery = getcookie2('armory.ah.lastSimilar')

        if (reload && searchQuery) {
            var parts = searchQuery.split('|');
            AuctionSearch.queryString.reverse = reversed = parts[0];
            AuctionSearch.queryString.sort = sort = parts[1];
            
        } else {
            if (!reversed) {
                if (AuctionSearch.currentSort && AuctionSearch.currentSort == AuctionSearch.queryString.sort)
                    reversed = (AuctionSearch.queryString.reverse == 'true') ? 'false' : 'true';
                else
                    reversed = AuctionSearch.queryString.reverse;
            }

            AuctionSearch.queryString.sort = sort;
            AuctionSearch.queryString.reverse = reversed;
        }
        
        var query = {
            sort:   sort,
            start:  0,
            end:    5,
            fmt:    'xml',
            xsl:    '/_layout/auction/similar.xsl',
            id:     AuctionCreate.current.id,
            n:      AuctionCreate.current.name,
            reverse: reversed,
            excludeNoBuyout: true
        };
		
		$.ajax({
			url: '/auctionhouse/search.json',
			data: Auction.appendQuery(query),
			dataType: 'html',
			type: 'GET',
			success: function(data, status) {
				$("#similarAuctions").html(data);
				$('#similarAuctions').fadeIn();
			}
		});

        setcookie('armory.ah.lastSimilar', AuctionSearch.queryString.reverse +'|'+ AuctionSearch.queryString.sort, true);
	},

    /**
	 * Find more similar.
	 */
	findSimilar: function() {
        Auction.openPage('search', { n: AuctionCreate.current.name });
	},
	
	/**
	 * Get the max possible quantity based on the stack size.
     * 
	 * @param int amount
	 */
	getMaxQuantity: function(amount) {
		if (!amount || isNaN(amount))
			amount = AuctionCreate.current.qty;
			
		if (parseInt(amount) > parseInt(AuctionCreate.current.stack)) 
			amount = AuctionCreate.current.stack;
			
		return amount;
	},
	
	/**
	 * Update to the max amount of quantity allowed.
	 */
	maxQuantity: function() {	
		$('#quantity').val(AuctionCreate.getMaxQuantity());
		AuctionCreate.updateQuantityLeft();
        AuctionCreate.updateDeposit();
	},

    /**
     * Update to the max possible stack, based on quantity available.
     */
    maxStacks: function() {
        var maxStacks = $('#maxStacks').html();
        var quantity = $('#quantity').val();
        var stacks = Math.floor(AuctionCreate.current.qty / quantity);

        if (stacks <= 0)
			stacks = 1;
        else if (stacks > maxStacks)
            stacks = maxStacks;

        $('#noOfStacks').val(stacks);
        AuctionCreate.updateQuantityLeft();
        AuctionCreate.updateDeposit();
    },
	
	/**
	 * Automatically check if the quantity is correct, based on the stack.
     * 
	 * @param obj input
	 */
	checkQuantity: function(input) {
		var amount = AuctionCreate.checkNumeric(input);
		var maxSize = AuctionCreate.getMaxQuantity(amount);
		var value;

		if (amount >= maxSize) 
            value = maxSize;
        else if (amount == '')
            value = 1;
        else
            value = amount;
        
        $(input).val(value);
		AuctionCreate.updateDeposit();
		AuctionCreate.updateQuantityLeft();
	},
	
	/**
	 * Automatically check if the stack is correct.
     * 
	 * @param obj input
	 */
	checkStack: function(input) {
		var amount = AuctionCreate.checkNumeric(input);

		if (amount <= 0) 
			$(input).val(1);
		else if (amount > 20)
			$(input).val(20);
			
		AuctionCreate.updateDeposit();
		AuctionCreate.updateQuantityLeft();
	},
	
	/**
	 * Check the input and only accept numeric values.
     *
	 * @param obj input
	 */
	checkNumeric: function(input) {
		var value = $(input).val();
			value = parseInt(value);
			
		if (!value || isNaN(value))
			value = '';
			
		value.toString().replace('.', '');
			
		$(input).val(value);
		return value;
	},

	/**
	 * Numeric only for blur/focus.
     *
	 * @param obj input
	 */
    prepareNumeric: function(input) {
		input = $(input);
		var value = input.val().toString();
		
		if (value == '0')
			input.val('');
		else if (value == '')
			input.val('0');
    },
	
	/**
	 * Update to see how much quantity is left.
	 */
	updateQuantityLeft: function() {
		var amount = parseInt($('#quantity').val());
		var noStacks = parseInt($('#noOfStacks').val());
		
		if (isNaN(amount))
			amount = 0;
			
		if (isNaN(noStacks))
			noStacks = 1;
			
		amount = amount * noStacks;
		
		var qtyLeft = $('#quantityLeft');
		var left = AuctionCreate.current.qty - amount;
		
		if (left < 0) {
			qtyLeft.html(left.toString()).addClass('textRed');
			$('#createButton').hide();
			$('#createButtonDisabled').show();
		} else {
			qtyLeft.html(left.toString()).removeClass('textRed');
			$('#createButton').show();
			$('#createButtonDisabled').hide();
		}
	},
	
	/**
	 * Determine the deposit and starting price amounts.
	 */
	updateDeposit: function() {
		var id = AuctionCreate.current.id;
		var dur = $('#createAuctionForm input[type="radio"]:checked').val();
		var qty = $('#quantity').val();
		var stacks = $('#noOfStacks').val();

        if (!qty || isNaN(qty))
            qty = 1;

        if (!stacks || isNaN(stacks))
            stacks = 1;

		$.ajax({
			url: '/auctionhouse/deposit.json',
			data: 'id='+ id +'&duration='+ dur +'&quan='+ qty +'&stacks='+ stacks,
			dataType: 'json',
			type: 'GET',
			success: function(data, status) {
				if (data.error) {
					$('#createButton').hide();
					$('#createButtonDisabled').show();
					$('#depositError').html(data.error.message).show();
					
					$('#depositAmount .copperCoin').html('0');
					$('#depositAmount .silverCoin').html('0');
					$('#depositAmount .goldCoin').html('0');
					
				} else {
                    AuctionCreate.price.starting = data.suggestedPrice;

					var deposit = Auction.formatMoney(data.totalDeposit);
					var amount = Auction.formatMoney(data.suggestedPrice);
					var current = $('#baseCurrentMoney').html();
					
					$('#depositAmount .copperCoin').html(deposit.copper.toString());
					$('#depositAmount .silverCoin').html(deposit.silver.toString());
					$('#depositAmount .goldCoin').html(deposit.gold.toString());

					var startCopper = $('#startCopper');
					var startSilver = $('#startSilver');
					var startGold = $('#startGold');
                    var startPrice = Auction.deformatMoney(startGold.val(), startSilver.val(), startCopper.val());

                    // only update if a different item
                    if (AuctionCreate.current.id != AuctionCreate.last_id) {
                        startCopper.val(amount.copper);
                        startSilver.val(amount.silver);
                        startGold.val(amount.gold);

                    // only update if the new price is larger than the current
                    } else if (data.suggestedPrice > startPrice) {
                        startCopper.val(amount.copper);
                        startSilver.val(amount.silver);
                        startGold.val(amount.gold);
                        
                    } else {
                        if (startGold.val() == '')
                            startGold.val(amount.gold);

                        if (startSilver.val() == '')
                            startSilver.val(amount.silver);

                        if (startCopper.val() == '')
                            startCopper.val(amount.copper);
                    }
					
					if (current < data.totalDeposit) {
						$('#depositError, #createButtonDisabled').show();
						$('#createButton').hide();
					} else {
						AuctionCreate.ticket = data.ticket;

						$('#createButtonDisabled, #depositError').hide();
						$('#createButton').show();
					}
				}

                AuctionCreate.last_id = AuctionCreate.current.id;
			}
		});
	},

    /**
     * Calculate the starting price based on the per type.
     */
    swapPerType: function() {
        var starting = AuctionCreate.price.startingManual || AuctionCreate.price.starting;
        var buyout = AuctionCreate.price.buyoutManual || AuctionCreate.price.buyout;

        if ($('#pricePer').val() == 'perItem') {
            AuctionCreate.price.startingManual = starting / $('#quantity').val();
            AuctionCreate.price.buyoutManual = buyout / $('#quantity').val();
        } else {
            AuctionCreate.price.startingManual = starting * $('#quantity').val();
            AuctionCreate.price.buyoutManual = buyout * $('#quantity').val();
        }

        var newStarting = Auction.formatMoney(AuctionCreate.price.startingManual);

        $('#startCopper').val(newStarting.copper);
        $('#startSilver').val(newStarting.silver);
        $('#startGold').val(newStarting.gold);

        if (AuctionCreate.price.buyoutManual > 0) {
            var newBuyout = Auction.formatMoney(AuctionCreate.price.buyoutManual);

            $('#buyCopper').val(newBuyout.copper);
            $('#buySilver').val(newBuyout.silver);
            $('#buyGold').val(newBuyout.gold);
        }
    },

    /**
     * Overwrite the buyout price values.
     *
     * @param obj node
     * @param string type
     */
    setBuyoutPrice: function(node, type) {
        var value = $(node).val();
        var gold, silver, copper;

        switch (type) {
            case 'gold':
                gold = value;
                silver = $('#buySilver').val();
                copper = $('#buyCopper').val();
            break;
            case 'silver':
                gold = $('#buyGold').val();
                silver = value;
                copper = $('#buyCopper').val();
            break;
            case 'copper':
                gold = $('#buyGold').val();
                silver = $('#buySilver').val();
                copper = value;
            break;
        }

        AuctionCreate.price.buyoutManual = Auction.deformatMoney(gold, silver, copper);
    },

    /**
     * Overwrite the starting price values.
     *
     * @param obj node
     * @param string type
     */
    setStartingPrice: function(node, type) {
        var value = $(node).val();
        var gold, silver, copper;

        switch (type) {
            case 'gold':
                gold = value;
                silver = $('#startSilver').val();
                copper = $('#startCopper').val();
            break;
            case 'silver':
                gold = $('#startGold').val();
                silver = value;
                copper = $('#startCopper').val();
            break;
            case 'copper':
                gold = $('#startGold').val();
                silver = $('#startSilver').val();
                copper = value;
            break;
        }

        AuctionCreate.price.startingManual = Auction.deformatMoney(gold, silver, copper);
    },

	/**
	 * Begin browsing the items but waiting for the user to stop typing.
	 */
	setKeyword: function() {
		clearTimeout(AuctionCreate.timer);
		
		$('#createFilter .spinner').show();
		
		AuctionCreate.timer = setTimeout(function() { 
			AuctionCreate.browseItems(); 
		}, 1000);
	},
	
	/**
	 * Reload the page with it filtered.
	 */
	browseItems: function() {
        AuctionCreate.current = null;

		$.ajax({
			url: '/auctionhouse/create/',
			data: 'rhtml=y&fmt=xml&xsl=/_layout/auction/item_listing.xsl&n='+ encodeURIComponent($('#createKeyword').val()),
			dataType: 'html',
			type: 'GET',
			success: function(data, status) {
				$("#filterItemContent").html(data);
				$('#createFilter .spinner').hide();
				bindToolTips();
                AuctionCreate.filterSorting(0, $('#createBrowseTabs .houseButton:eq(3)'));
			}
		});
	},
	
	/**
	 * Prepare an auction for creation.
	 */
	create: function() {
		if (AuctionCreate.ticket == null) {
			AuctionCreate.updateDeposit();
			
			setTimeout(function() {
				AuctionCreate.create();			
			}, 1000);
			
		} else {
            var buyout = Auction.deformatMoney($('#buyGold').val(), $('#buySilver').val(), $('#buyCopper').val());
            var starting = Auction.deformatMoney($('#startGold').val(), $('#startSilver').val(), $('#startCopper').val());
            var quantity = $('#quantity').val();
            
			var params = {
				quan: quantity,
				duration: $('#createAuctionForm input[type="radio"]:checked').val(),
				stacks: $('#noOfStacks').val(),
				buyout: buyout,
				bid: starting
			};
			
			$('#createAuctionForm input, #createAuctionForm select').attr('disabled', 'disabled');
			$('#createButtons, #createErrors').hide();
			$('#createProgress').show();
			$('#totalCreated, #toastTotalAuctionCreated').html(params.stacks);
			
			$('#retryButton, #finishButton, #createMsg, #finishMsg, #createOverlay').hide();
			$('#stopButton').show();
				
			AuctionCreate.creating = true;
			AuctionCreate.createProcess(params);

            $('#progressWrap .progressBar').removeClass('progressStopped');
		}
	},
	
	/**
	 * Fire the ajax call to create an auction, if a ticket is returned, process the next create in the batch.
     * 
	 * @param obj params
	 */
	createProcess: function(params) {
		if (!$('#tab_create').hasClass('selected-tab')) {
			AuctionCreate.current = null;
			AuctionCreate.creating = false;
			Auction.toast('interrupted');
			
			return false;
		}
			
		if (AuctionCreate.creating == true) {
			Auction.increaseCounter('currentCreated');
			$('#createOverlay').show();
			
			var current = AuctionCreate.current;
			var maxPercent = 100;
			var perPercent = Math.round(maxPercent / params.stacks);
			var curPercent = $('.progressBarLoader').css('width');
				curPercent = parseInt(curPercent.replace('%', ''));
			
			if (perPercent < 1)
				perPercent = 1;

			if ((current.source.length > 1) || (!current.guid) || (current.guid == ''))
				current.source = AuctionCreate.sorting;
			
			if (!params.ticket)
				params.ticket = AuctionCreate.ticket;
		
			// Throw ajax!
			$.ajax({
				url: '/auctionhouse/create.json',
				data: 'id='+ current.id +'&source='+ current.source +'&guid='+ current.guid +'&'+ $.param(params),
				dataType: 'json',
				type: 'POST',
				success: function(data, status) {
					var decrement = params.quan;
                    var cacheSlug = current.source +'_'+ current.obj;
                    
                    // Transaction
                    if (data.transactions) {
                        Auction.alertTransaction(data.transactions);
                    }

					// Successful, continue!
					if (data.auc) {
						$('#createMsg').show();
						Auction.updateMoney(data.deposit, '-');
						
						// Update progress bar
						curPercent = curPercent + perPercent;
						if ((curPercent >= maxPercent) || (curPercent >= 95)) 
							curPercent = maxPercent;

                        $('.progressPercent').html(curPercent +'%');
						$('.progressBarLoader').animate({ width: curPercent +'%' }, { 
							duration: 'slow', 
							complete: function() {
								if (!data.ticket && params.stacks > 1)
									Auction.toast('total', 3000, { total: params.stacks });
							} 
						});

                        // In/decrease counters
                        Auction.increaseCounter('myAuctionsTotal');
                        Auction.decreaseCounter('totalQuantity', decrement);
                        Auction.decreaseCounter('itemQty_0_'+ current.obj, decrement);

                        $.each(data.sources, function(key, source) {
                            var source2 = 0;

                            switch (source.source) {
                                case 'MAIL': source2 = 3; break;
                                case 'BAG': source2 = 2; break;
                                case 'INVENTORY': source2 = 1; break;
                            }

                            Auction.decreaseCounter('itemQty_'+ source2 +'_'+ current.obj, decrement);
                        });

						// Update the cached object, if reaches 0 set timer
						AuctionCreate.cached[cacheSlug].qty = AuctionCreate.cached[cacheSlug].qty - decrement;
						
						if (AuctionCreate.cached[cacheSlug].qty == 0) {
                            $('#auction_0_'+ current.obj).remove();
                            $('#auction_1_'+ current.obj).remove();
                            $('#auction_2_'+ current.obj).remove();
                            $('#auction_3_'+ current.obj).remove();

                            if (current.source > 0) {
                                Auction.decreaseCounter('bagQty_'+ current.source, 1);
                            }

							AuctionCreate.resetTimer = setTimeout(function() {
								$('#chooseAnItem').fadeIn('slow');
								$('#itemFields').fadeOut('slow');
								$('#similarAuctions').empty();
							}, 4500);
						}
						
						// Batch create, continue process
						if (data.ticket) {
							params.ticket = data.ticket;
							
							setTimeout(function() {
								AuctionCreate.createProcess(params);			
							}, 1000);
							
						// Last creation
						} else {
							setTimeout(function() {
								$('#createMsg, #stopButton, #retryButton, #createOverlay').hide();
								$('#finishMsg').fadeIn('normal');

                                if (AuctionCreate.cached[cacheSlug].qty > 0)
                                    $('#continueButton').show();
                                else
                                    $('#createAuctionForm input[type=text]').val('');
							}, 1000);
						}
					}
					
					// Error
					if (data.error) {
						Auction.toast('interrupted');
						AuctionCreate.showError(data);
					}	
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					Auction.toast('interrupted');	
				}
			});
			
		}
	},
	
	/**
	 * Cancel batch creation, and refresh the page.
	 */
	stopCreation: function(button) {
		AuctionCreate.creating = false;
		AuctionCreate.current = null;
		Auction.toast('interrupted');
		
		setTimeout(function() {
			Auction.openPage('create');
		}, 1500);
	},

    /**
     * Reset the form to continue creation.
     */
    continueCreation: function(button) {
        AuctionCreate.updateDeposit();
        
        $('#stopButton, #retryButton, #createMsg, #finishMsg, #createErrors, #depositError, #createProgress, #continueButton').hide();
        $('#createButtons').show();
        $('#currentCreated, #totalCreated').html('0');
        $('#progressWrap .progressPercent').html('0%');
        $('#progressWrap .progressBarLoader').css('width', '0%');
        $('#itemFields input, #itemFields select').removeAttr('disabled');
        
        AuctionCreate.updateQuantityLeft();
    },
	
	/**
	 * Display an error!
	 */
	showError: function(data) {
		$('#createAuctionForm input, #createAuctionForm select').removeAttr('disabled');
		$('#currentCreated').html('0');
		$('#createErrors').show().html(Auction.parseErrorMsg(data));
		$('#stopButton, #finishButton, #createMsg, #finishMsg, #createOverlay').hide();
		$('#retryButton').show();
        $('#progressWrap .progressBar').addClass('progressStopped');
	}
	
}
