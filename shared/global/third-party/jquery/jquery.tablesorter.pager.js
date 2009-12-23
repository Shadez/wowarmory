(function($) {
	$.extend({
		tablesorterPager: new function() {
			
			function updatePageDisplay(c,table) {
				
				var currSearchType = $("#searchTypeHolder")[0].innerHTML;
				
				if(currSearchType != ""){
					currSearchType = "_"+currSearchType;
				}
				
				var pageSelect1 = $(c.cssPageSelect1 + currSearchType);
				var pageSelect2 = $(c.cssPageSelect2 + currSearchType);
				var pageSelect3 = $(c.cssPageSelect3 + currSearchType);
				
				var s = $(c.cssPageDisplay,c.container).val((c.page+1));					
				$(c.cssPageTotal + currSearchType).html(c.totalPages);
				
				var currPage = c.page + 1;
		
				//handling different total # of pages
				switch(c.totalPages){
					case 0:
					case 1:						
						$(pageSelect1)[0].innerHTML = "1"
						$(pageSelect2).hide();
						$(pageSelect3).hide();					
						
						disableArrows(c, { prevArrow: true, nextArrow: true, lastArrow: true, firstArrow: true });
						
						break;
					case 2:
						$(pageSelect1)[0].innerHTML = "1";
						$(pageSelect2)[0].innerHTML = "2";
						$(pageSelect3).hide();
						enableArrows(c, { prevArrow: true, nextArrow: true, lastArrow: true, firstArrow: true });
						break;
					case 3:
						enableArrows(c, { prevArrow: true, nextArrow: true, lastArrow: true, firstArrow: true });
					
						$(pageSelect1)[0].innerHTML = "1";
						$(pageSelect2)[0].innerHTML = "2";
						$(pageSelect3)[0].innerHTML = "3"
						
						$(pageSelect1).show();
						$(pageSelect2).show();
						$(pageSelect3).show();					
						break;					
					default:
						//4 or more pages so show all the arrows
						enableArrows(c, { prevArrow: true, nextArrow: true, lastArrow: true, firstArrow: true });
					
						//last page or 2nd to last page
						if((currPage == c.totalPages) || (currPage == c.totalPages-1)){
							$(pageSelect1)[0].innerHTML = c.totalPages-2;	
							$(pageSelect2)[0].innerHTML = c.totalPages-1;
							$(pageSelect3)[0].innerHTML = c.totalPages;
						}else{
							$(pageSelect1)[0].innerHTML = currPage;
							$(pageSelect2)[0].innerHTML = currPage+1;
							$(pageSelect3)[0].innerHTML = currPage+2;
						}
						$(pageSelect1).show();
						$(pageSelect2).show();
						$(pageSelect3).show();
				}
				
				//clear the classes
				$(pageSelect1).removeClass();
				$(pageSelect2).removeClass();
				$(pageSelect3).removeClass();
				
				//bind page selects so users can click on the number to navigate
				$(pageSelect1).unbind('click');
				$(pageSelect2).unbind('click');
				$(pageSelect3).unbind('click');			
				
				$(pageSelect1).click(function(){
					moveToThisPage(table,$(this).html()*1);
				});
				$(pageSelect2).click(function(){
					moveToThisPage(table,$(this).html()*1);
				});
				$(pageSelect3).click(function(){					  
					moveToThisPage(table,$(this).html()*1);
				});
				
				//set selected or not
				if($(pageSelect1).html()*1 == currPage){					
					$(pageSelect1).addClass("sel");
					$(pageSelect2).addClass("p");
					$(pageSelect3).addClass("p");
				}else if($(pageSelect2).html()*1 == currPage){
					$(pageSelect2).addClass("sel");
					$(pageSelect1).addClass("p");
					$(pageSelect3).addClass("p");					
				}else if($(pageSelect3).html()*1 == currPage){
					$(pageSelect3).addClass("sel");					
					$(pageSelect1).addClass("p");
					$(pageSelect2).addClass("p");
				}
				//enable or disable arrows depending on the page we're on
				if(currPage == 1){
					disableArrows(c, { prevArrow: true, nextArrow: false, lastArrow: false, firstArrow: true });					
				}else if(currPage == c.totalPages){	
					disableArrows(c, { prevArrow: false, nextArrow: true, lastArrow: true, firstArrow: false });
				}				
			}
			
			function disableArrows(c, arrowOptions){
	
				var currSearchType = $("#searchTypeHolder").html();				
				var tabPrefix = (currSearchType != "") ? "#tab" + currSearchType + " " : "";
				
				//store reference
				var arrows = {
					next: $(tabPrefix + c.cssNext),
					prev: $(tabPrefix + c.cssPrev),
					last: $(tabPrefix + c.cssLast),
					first: $(tabPrefix + c.cssFirst)
				}		
					
				if((arrowOptions.prevArrow) && ($(arrows.prev).hasClass("prevPg-on"))){
					$(arrows.prev).removeClass("prevPg-on");
					$(arrows.prev).addClass("prevPg-off");						
				}
				
				if((arrowOptions.nextArrow) && ($(arrows.next).hasClass("nextPg-on"))){
					$(arrows.next).removeClass("nextPg-on");
					$(arrows.next).addClass("nextPg-off");						
				}
				
				if((arrowOptions.firstArrow) && ($(arrows.first).hasClass("firstPg-on"))){
					$(arrows.first).removeClass("firstPg-on");
					$(arrows.first).addClass("firstPg-off");						
				}
				
				if((arrowOptions.lastArrow) && ($(arrows.last).hasClass("lastPg-on"))){
					$(arrows.last).removeClass("lastPg-on");
					$(arrows.last).addClass("lastPg-off");						
				}				
			}
			
			function enableArrows(c, arrowOptions){				
				
				var currSearchType = $("#searchTypeHolder").html();
				
				var tabPrefix = (currSearchType != "") ? "#tab" + currSearchType + " " : "";
				
				//store reference
				var arrows = {
					next: $(tabPrefix + c.cssNext),
					prev: $(tabPrefix + c.cssPrev),
					last: $(tabPrefix + c.cssLast),
					first: $(tabPrefix + c.cssFirst)
				}
				
				if((arrowOptions.prevArrow) && ($(arrows.prev).hasClass("prevPg-off"))){			
					$(arrows.prev).removeClass("prevPg-off");
					$(arrows.prev).addClass("prevPg-on");
				}
				
				if((arrowOptions.nextArrow) && ($(arrows.next).hasClass("nextPg-off"))){
					$(arrows.next).removeClass("nextPg-off");
					$(arrows.next).addClass("nextPg-on");						
				}
				
				if((arrowOptions.firstArrow) && ($(arrows.first).hasClass("firstPg-off"))){
					$(arrows.first).removeClass("firstPg-off");
					$(arrows.first).addClass("firstPg-on");						
				}
				
				if((arrowOptions.lastArrow) && ($(arrows.last).hasClass("lastPg-off"))){
					$(arrows.last).removeClass("lastPg-off");
					$(arrows.last).addClass("lastPg-on");						
				}
			}
			
			function setPageSize(table,size) {			
				var c = table.config;
				c.size = size;
				c.totalPages = Math.ceil(c.totalRows / c.size);
				c.pagerPositionSet = false;
				moveToPage(table);				
			}			
			function moveToFirstPage(table) {
				var c = table.config;
				c.page = 0;
				moveToPage(table);
			}
			
			function moveToLastPage(table) {
				var c = table.config;
				c.page = (c.totalPages-1);
				moveToPage(table);
			}
			
			function moveToNextPage(table) {
				var c = table.config;
				c.page++;
				if(c.page >= (c.totalPages-1)) {
					c.page = (c.totalPages-1);
				}
				moveToPage(table);
			}
			
			function moveToPrevPage(table) {
				var c = table.config;
				c.page--;
				if(c.page <= 0) {
					c.page = 0;
				}
				moveToPage(table);
			}
			
			function moveToThisPage(table,page){
				var c = table.config;
				c.page = page-1;
				
				if(c.page <= 0) {
					c.page = 0;
				}
				moveToPage(table);
			}
						
			
			function moveToPage(table) {
				var c = table.config;
				if(c.page < 0 || c.page > (c.totalPages-1)) {
					c.page = 0;
				}
				
				renderTable(table,c.rowsCopy);
			}
			
			function renderTable(table,rows) {
				
				var c = table.config;
				var l = rows.length;
				var s = (c.page * c.size);
				var e = (s + c.size);
				if(e > rows.length ) {
					e = rows.length;
				}		
				
				var tableBody = $(table.tBodies[0]);
				
				//store first row html
				var tempRowHTML = rows[0][0].innerHTML
				
				//make sure it shows 0 results if colspan exists
				if(tempRowHTML.indexOf("colspan") == -1){
					$(c.cssCurrResults)[0].innerHTML = rows.length.toString();
				}else{
					$(c.cssCurrResults)[0].innerHTML = "0";
				}			
				
				// clear the table body				
				$.tablesorter.clearTableBody(table);			

				for(var i = s; i < e; i++) {					
					var o = rows[i];
					var l = o.length;
					for(var j=0; j < l; j++) {						
						tableBody[0].appendChild(o[j]);
					}
				}
			
				
				if( c.page >= c.totalPages ) {
        			moveToLastPage(table);
				}
				
				updatePageDisplay(c,table);
			}
			this.appender = function(table,rows) {
				
				var c = table.config;
				
				c.rowsCopy = rows;
				c.totalRows = rows.length;
				c.totalPages = Math.ceil(c.totalRows / c.size);
				
				renderTable(table,rows);
			};
			
			this.defaults = {
				size: 10,
				offset: 0,
				page: 0,
				totalRows: 0,
				totalPages: 0,
				container: null,
				cssNext: '.nextPg',
				cssPrev: '.prevPg',
				cssFirst: '.firstPg',
				cssLast: '.lastPg',
				cssPageDisplay: '#pagingInput',
				cssPageSize: '#pageSize',
				cssPageTotal: '#totalPages',
				cssPageSelect1: '#pageSelect1',
				cssPageSelect2: '#pageSelect2',
				cssPageSelect3: '#pageSelect3',
				cssCurrResults: '#currResults',
				cssTotalResults: '#totalResults',
				seperator: "/",
				positionFixed: true,
				appender: this.appender,
				pageDelay: 0
			};
			
			this.construct = function(settings) {
				
				return this.each(function() {	
					
					config = $.extend(this.config, $.tablesorterPager.defaults, settings);
					
					var table = this, pager = config.container;
				
					$(this).trigger("appendCache");
					
					config.size = parseInt($("#pageSize",pager).val());
					
					//list total results number
					$(this.totalResults)[0].innerHTML = config.rowsCopy.length.toString();
					
					/* when users change the page in the input box */
					$(config.cssPageDisplay).keyup(function(e){														
						/* delay so users can type multiple numbers */
						var whichpage = 1;
						if(config.pageDelay != 0)		clearTimeout(config.pageDelay);
						if(!(isNaN($(this)[0].value)))	whichpage = $(this)[0].value*1;
						config.pageDelay = setTimeout(function() { moveToThisPage(table,whichpage) }, 400);
					});					
					$(config.cssFirst,pager).click(function() {
						moveToFirstPage(table);
						return false;
					});
					$(config.cssNext,pager).click(function() {
						moveToNextPage(table);
						return false;
					});
					$(config.cssPrev,pager).click(function() {
						moveToPrevPage(table);
						return false;
					});
					$(config.cssLast,pager).click(function() {
						moveToLastPage(table);
						return false;
					});
					$(config.cssPageSize,pager).change(function() {
						setPageSize(table,parseInt($(this).val()));
						return false;
					});
					
					setPageSize(table,parseInt($(config.cssPageSize).val()));
					
				});
			};
		}
	});
	// extend plugin scope
	$.fn.extend({
        tablesorterPager: $.tablesorterPager.construct
	});

	
})(jQuery);				