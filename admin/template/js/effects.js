// JavaScript Document
$(document).ready(function(){       
// BROWSER Detection //						   
var browser=navigator.appName;
var b_version=navigator.appVersion;
var version=parseFloat(b_version);

// Using browser detection to disable the jQuery Blend effect on the main menu in IE6 and Opera - z-index issues //

if (b_version.indexOf("MSIE 6.0")==-1 && browser.indexOf("Opera")==-1 && b_version.indexOf("MSIE 7.0")==-1) {
        $("#menu_group_main a").blend();       
}    

// I have used IF statements to avoid missing elements or functions on pages. //
// The effects will work only if the linked element exists in the document    //

if ( $(".column").length > 0 ) {

// We make the .column divs sortable //
		$(".column").sortable({
			connectWith: '.column',
			// We make the .portlet-header to act as a handle for moving portlets //
			handle: '.portlet-header'
		});
		// We create the protlets and style them accordingly by script //
		$(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
			.find(".portlet-header")
				.addClass("ui-widget-header ui-corner-top")
				.prepend('<span class="ui-icon ui-icon-triangle-1-n"></span>')
				.end()
			.find(".portlet-content");
		// We make arrow button on any portlet header to act as a switch for sliding up and down the portlet content //
		$(".portlet-header .ui-icon").click(function() {
			$(this).parents(".portlet:first").find(".portlet-content").slideToggle("fast");
			$(this).toggleClass("ui-icon-triangle-1-s"); 
			return false;	
		});
		// We disable the mouse selection on .column divs //
		$(".column").disableSelection();
}
		// This function is making the info messages to slide up when the X is clicked //
		$(".info").click(function() {
			$(this).slideUp("fast");							 	  
		});
		// This is creating a modal box from a hidden element on the page with id #inline_example1 //
		$("#inline_example1").dialog({
			bgiframe: true,
			autoOpen: false,
			modal: true
		});	
		// This is creating a modal box from a hidden element on the page with id #inline_example2 //
		$("#inline_example2").dialog({
			bgiframe: false,
			autoOpen: false,
			modal: true
		});		
		// This triggers the modal dialog box //
		$('.mail').click(function() {
			$('#inline_example1').dialog('open');
		})
		// This toggles the color changer menu //
		$(".dropdown").click(function() { 
			$("#colorchanger").slideToggle("fast");	
		});	

// The functions below are made as FX for table operations //
if ( $(".approve_icon").length > 0 ) {		
		$(".approve_icon").click(function() { 
			$(this).parents("tr").css({ "background-color" : "#e1fbcd" }, 'fast'); 
				// THE ALERT BELOW CAN BE REMOVED - you can put any function here linked to the approve icon link in the table //
				alert('this is approved');
			});
}
if ( $(".reject_icon").length > 0 ) {	
		$(".reject_icon").click(function() { 
			$(this).parents("tr").css({ "background-color" : "#fbcdcd" }, 'fast'); 	
				// THE ALERT BELOW CAN BE REMOVED - you can put any function here linked to the reject icon link in the table //
			alert('this is rejected');
			});
}

// This function serves the More submenu ideea - you can attach the class .more to any tabbed link and you will trigger the hidden sub-sub menu to appear when clicked - this can be developed in a nice way if you have an enormous amount of links //
if ( $(".more").length > 0 ) {	
		$("#tabs .more").click(function() { 
			$("#hidden_submenu").slideToggle("fast");
			$(this).toggleClass("current"); return false;								 			
		});
}
// This triggers the calendar when clicked on the event tip on the right of the title - dashboard.html - it can be used anywhere in the page //
if ( $(".hidden_calendar").length > 0 ) {
		$(".hidden_calendar").datepicker();
		$(".inline_calendar").click(function() { 
			$(".hidden_calendar").toggle("fast");
		});		
}
// This triggers the 2nd modal box when clicked on the TIP link on the right of the title - forms.html //
if ( $(".inline_tip").length > 0 ) {
		$(".inline_tip").click(function() { 
			$("#inline_example2").dialog('open');
		});
}
});
// THE jQuery scripts end here //

// Below is the "allbox" script for selecting all checkboxes in a table by clicking one of them - usualy the on in the table heading //

if ( $("#allbox").length > 0 ) {		
	function checkAll(){
		for (var i=0;i<document.forms[0].elements.length;i++)
		{
			var e=document.forms[0].elements[i];
			if ((e.name != 'allbox') && (e.type=='checkbox'))
			{
				e.checked=document.forms[0].allbox.checked;
			}
		}
	}
}