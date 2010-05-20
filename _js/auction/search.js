
var AuctionSearch = {
	
	// Current search query string
	queryString: {},

	// Current column being sorted
    currentSort: null,
	
	/**
	 * Init binds/hovers
	 */
	initialize: function() {
		$('#auctionSelectBox .selectCol1').hover(
			function() {
				AuctionSearch.openTier(1);
				$('#auctionSelectBox').addClass('hover1');
			},
			function() { 
				AuctionSearch.closeTier(1);
				$('#auctionSelectBox').removeClass('hover1');
			}
		);
		
		// Misc
		$('#itemName').val(AuctionSearch.queryString.n);
		$('#maxResults').val(AuctionSearch.queryString.pageSize);
		$('#itemRarity').val(AuctionSearch.queryString.qual);
		
		if (AuctionSearch.queryString.minLvl > 0)
			$('#minLvl').val(AuctionSearch.queryString.minLvl);
			
		if (AuctionSearch.queryString.maxLvl > 0)
			$('#maxLvl').val(AuctionSearch.queryString.maxLvl);
			
		$('.nextPg-on').click(function() {
			AuctionSearch.nextPage();			
		});
		
		$('.prevPg-on').click(function() {
			AuctionSearch.prevPage();			
		});
	},
	
	/**
	 * Save the sort params to the class.
     *
	 * @param obj params
     * @param boolean isSearch
	 */
	initSorting: function(params, isSearch) {
		AuctionSearch.queryString = params;
		AuctionSearch.queryString.sort = params.sort.toLowerCase();

		// Filters
		if (isSearch) {
			AuctionSearch.initialize();
			
			if (AuctionSearch.queryString.filterId != -1) {
				var filters = AuctionSearch.queryString.filterId.split(',');
				
				AuctionSearch.selectTier(1, filters[0], document.getElementById('tier1_'+ filters[0]));
				
				if (filters.length >= 2)
					AuctionSearch.selectTier(2, filters[1], document.getElementById('tier2_'+ filters[1]));
	
				if (filters.length >= 3)
					AuctionSearch.selectTier(3, filters[2], document.getElementById('tier3_'+ filters[2]));
			}
		}

        AuctionSearch.currentSort = AuctionSearch.queryString.sort;
	},
	
	/**
	 * Updated the sorting buttons once page has loaded.
     *
	 * @param string page
	 */
	updateSorting: function(page) {
		var dir = AuctionSearch.queryString.reverse;
		var sortBy = AuctionSearch.queryString.sort;
		var sortClass = (dir == 'false') ? 'headerSortUp' : 'headerSortDown';
        var text = $('#sort_'+ sortBy +' a').html();

		if ((sortBy == 'bid') || (sortBy == 'buyout') || (sortBy == 'unitbid') || (sortBy == 'unitbuyout')) {
			$('#sort_money').addClass(sortClass);
			$('#sort_money a:eq(0)').attr('rel', sortBy);
			$('#sort_money a:eq(0) .sortText').html(AuctionSearch.truncate(text, 18)).attr('title', text);

        } else if ((sortBy == 'level') || (sortBy == 'ilvl')) {
			$('#sort_levels').addClass(sortClass);
			$('#sort_levels a:eq(0)').attr('rel', sortBy);
			$('#sort_levels a:eq(0) .sortText').html(AuctionSearch.truncate(text)).attr('title', text);

		} else if ((sortBy == 'rarity') || (sortBy == 'name')) {
			if (page == 'search') {
				$('#sort_'+ sortBy).addClass(sortClass);
			} else {
				$('#sort_nameRarity').addClass(sortClass);
				$('#sort_nameRarity a:eq(0)').attr('rel', sortBy);
				$('#sort_nameRarity a:eq(0) .sortText').html(text).attr('title', text);
			}
		} else {
			$('#sort_'+ sortBy).addClass(sortClass);
		}
	},
	
	/**
	 * Sort the data by supplying a page and sort param.
     *
	 * @param page - the ajax page
	 * @param param - the sort name
	 */
	sortBy: function(page, param) {
		if (param == 'money')
			param = $('#sort_money a:eq(0)').attr('rel');
		else if (param == 'levels')
			param = $('#sort_levels a:eq(0)').attr('rel');
		else if (param == 'nameRarity')
			param = $('#sort_nameRarity a:eq(0)').attr('rel');
			
		AuctionSearch.queryString.sort = param;

        if (AuctionSearch.currentSort && AuctionSearch.currentSort == AuctionSearch.queryString.sort)
            AuctionSearch.queryString.reverse = (AuctionSearch.queryString.reverse == 'true') ? 'false' : 'true';

		if (AuctionSearch.queryString.minLvl <= 0)
			delete AuctionSearch.queryString.minLvl;
			
		if (AuctionSearch.queryString.maxLvl <= 0)
			delete AuctionSearch.queryString.maxLvl;
		
		Auction.openPage(page, AuctionSearch.queryString);
	},
	
	/**
	 * Go to the next page.
	 */
	nextPage: function() {
		var query = AuctionSearch.queryString;
			query.start = query.end;
			
		delete query.end;
			
		Auction.openPage('search', query);
	},
	
	/**
	 * Go to the previous page.
	 */
	prevPage: function() {
		var query = AuctionSearch.queryString;
			query.start = query.start - query.pageSize;
		
		delete query.end;
			
		Auction.openPage('search', query);
	},
	
	/**
	 * Open the dropdown.
     *
	 * @param int tier
	 */
	openTier: function(tier) {
		AuctionSearch.closeTier(null);
		var value;
		var dd = $("#categoryTier"+ (tier - 1)).val();
        
		if (tier == 1)
			value = '#selectTier1, #selectTier1 ul';
		else if (tier == 2)
			value = '#selectTier2, #selectTier2 ul#tierMenu2_'+ dd;
		else if (tier == 3)
			value = '#selectTier3, #selectTier3 ul#tierMenu3_'+ dd;

        if (tier == 1)
            $(value).show();
        else if (document.getElementById('tierMenu'+ tier +'_'+ dd))
            $(value).show();
	},
	
	/**
	 * Close the dropdown(s).
     * 
	 * @param int tier
	 */
	closeTier: function(tier) {
		$('#auctionSearch .selectDropdown ul').hide();
		
		if (tier == null)
			$('#auctionSearch .selectDropdown').hide();
		else
			$('#selectTier'+ tier).hide();
	},
	
	/**
	 * Select the tier.
     *
	 * @param int tier
	 * @param string value
	 * @param obj node
	 */
	selectTier: function(tier, value, node) {
		var obj = $(node);
		var text = AuctionSearch.truncate(obj.html());
		
		$('#categoryTier'+ tier).val(value);
		$('#auctionSearch .selectCol'+ tier +' .tierAnchor span').hide();
		$('#tier'+ tier +'_text').html(text).show();
		$('#auctionSelectBox').removeAttr('class');
		
		// Selecting first dropdown
		if (tier == 1) {
			$('#auctionSelectBox').addClass('active1');
			
			$('#auctionSearch .selectCol2').hover(
				function() { 
					AuctionSearch.openTier(2); 
					$('#auctionSelectBox').addClass('hover2');
				},
				function() { 
					AuctionSearch.closeTier(2);
					$('#auctionSelectBox').removeClass('hover2');
				}
			);
			
			$('#categoryTier2').val('');
			$('#categoryTier3').val('');
			AuctionSearch.updateAnchor(2);
			AuctionSearch.updateAnchor(3, true);
			AuctionSearch.detectDropdown(2, value);
			
		// Selecting second
		} else if (tier == 2) {
			$('#auctionSelectBox').addClass('active2');
			
			$('#auctionSearch .selectCol3').hover(
				function() { 
					AuctionSearch.openTier(3); 
					$('#auctionSelectBox').addClass('hover3');
				},
				function() { 
					AuctionSearch.closeTier(3);
					$('#auctionSelectBox').removeClass('hover3');
				}
			);
			
			$('#categoryTier3').val('');
			AuctionSearch.updateAnchor(3);
			AuctionSearch.detectDropdown(3, value);
				
		// Selecting third
		} else if (tier == 3) {
			$('#auctionSelectBox').addClass('active3');
		}
		
		return false;
	},
	
	/**
	 * Detect if a dropdown exists.
     *
	 * @param int tier
	 * @param mixed value
	 * @return boolean
	 */
	detectDropdown: function(tier, value) {
		var exists = document.getElementById('tierMenu'+ tier +'_'+ value);
		var subTier = tier - 1;
        
        if (value == -1)
            exists = false;
		
		$('#auctionSearch .selectCol'+ tier +' .tierAnchor').hide();
		
		if (!exists) {
			$('#auctionSelectBox').removeClass('active'+ subTier).addClass('active'+ tier);
			$('#tier'+ tier +'_none').show();
			
			if (tier == 2) {
				$('#auctionSearch .selectCol3 .tierAnchor').hide();
				$('#tier3_none').show();
				$('#auctionSelectBox').removeClass('active2').addClass('active3');
			}
			
		} else {
			$('#auctionSearch .selectCol'+ tier +' a.tierAnchor').show();
			$('#auctionSearch .selectCol'+ tier +' a.tierAnchor span').hide();
			$('#tier'+ tier +'_choose').show();
		}
		
		return exists;
	},
	
	/**
	 * Update/Show/Hide the buttons.
     *
	 * @param int tier
	 * @param boolean hide
	 */
	updateAnchor: function(tier, hide) {
		$('#auctionSearch .selectCol'+ tier +' .tierAnchor').hide();
		
		if (!hide) {
			$('#auctionSearch .selectCol'+ tier +' a.tierAnchor').show();
			$('#auctionSearch .selectCol'+ tier +' a.tierAnchor span').hide();
			$('#tier'+ tier +'_choose').show();
		}
	},
	
	/**
	 * Truncate the text to fit.
     *
	 * @param string text
	 * @return string
	 */
	truncate: function(text, size) {
        size = size || 10;
        text = text.replace('&amp;', '&');

		if (text.length > size) {
			text = text.substr(0, size);
			return text +'...';
		}
		
		return text;
	},
	
	/**
	 * Gather params and submit form.
	 */
	submitForm: function() {
		var tier1 = $('#categoryTier1').val();
		var tier2 = $('#categoryTier2').val();
		var tier3 = $('#categoryTier3').val();
		var filter = tier1;
		
		if (tier2 != '')
			filter += ','+ tier2;
			
		if (tier3 != '')
			filter += ','+ tier3;
		
		$('#filterId').val(filter);
		$('#pageSize').val($('#maxResults').val());

        // Get params
        var fields = $('#browseAuctionsForm').serializeArray();
        var params = {
            sort: AuctionSearch.currentSort,
            reverse: AuctionSearch.queryString.reverse
        };

        $.each(fields, function(k, v) {
            if (v.value)
                params[v.name] = v.value;
        });

        setcookie('armory.ah.lastSearch', $.param(params), true);
		Auction.openPage('search', params);

		return false;
	},
	
	/**
	 * Reset the form
	 */
	resetForm: function() {
		$('#auctionSearch input').val('');
		$('#auctionSearch #itemRarity').val(0);
		$('#categoryTier1, #categoryTier2, #categoryTier3, #filterId').val('');
		$('.tierAnchor, a.tierAnchor span').hide();
		$('a.tierAnchor span:first, #auctionSearch .selectCol1 a.tierAnchor').show();
		$('#auctionSelectBox').removeClass('active1').removeClass('active2').removeClass('active3');

        deleteCookie('armory.ah.lastSearch');
	}
	
}
