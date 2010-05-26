var charsSelected = 0;

//intializes the character select page
function initializeCharacterSelect(numChars){
	
	$("#searchTable > ul").tabs(); //bind tabs
	
	charsSelected = numChars*1; //make sure its a number
	
	//set dual tooltip checkbox
	if (getcookie2("armory.cookieDualTooltip") == 1){
		$("#checkboxDualTooltip").attr("checked","checked");
	}
	
	//bind sort table
	$(".charSelectTabDiv table").tablesorter();	
	
	//bind tooltips for the sword/crown icons
	setCharacterToolTips();
	
	$(".selSecondaryChar").click(function(){
		$(".selChar").each(function(){
			$(this).addClass("charToAdd");
		});		
		$(this).addClass("newPrimaryChar");
		
		updateCharIcons(getCollectedCharUrls());
	});
		
	$(".delChar").click(function(){
		$(this).prev().removeClass("selChar");
		
		updateCharIcons(getCollectedCharUrls());
	});
	
	//adding from the bottom
	$(".add_on").click(function(){
		var currUrl = $(this).next().attr("href");
			
		//secondary are set to 2 or 3
		currUrl = currUrl.substring(currUrl.indexOf(".xml?")+5);		
		currUrl = currUrl.replace("r=","&r"+(charsSelected+1)+"=");
		currUrl = currUrl.replace("n=","n"+(charsSelected+1)+"=");
			
		updateCharIcons(getCollectedCharUrls() + currUrl);	
	});
}

//get the urls of the primary and secondary chars
function getCollectedCharUrls(){
	var collectedCharUrls = "";				
	var secondaryCtr = 2; //start at 2 since primary is 1

	$(".selChar").each(function(){
		//happens when a secondary char is getting promoted
		if($(this).hasClass("charToAdd")){
			var currUrl = $(this).attr("id");
			
			if($(this).hasClass("newPrimaryChar")){
				currUrl = currUrl.replace("r=","r1=");
				currUrl = currUrl.replace("n=","n1=");
				collectedCharUrls = currUrl + collectedCharUrls;
			}else{
				currUrl = currUrl.replace("r=","&r"+secondaryCtr+"=");
				currUrl = currUrl.replace("n=","n"+secondaryCtr+"=");
				collectedCharUrls += currUrl;
				secondaryCtr++;
			}
		}else{
			//happens when char gets added from grid
			var currUrl = $(this).attr("id");
			
			if($(this).hasClass("selPrimaryChar")){
				currUrl = currUrl.replace("r=","r1=");
				currUrl = currUrl.replace("n=","n1=");			
				collectedCharUrls = currUrl + collectedCharUrls;
			}else if($(this).hasClass("selSecondaryChar")){
				currUrl = currUrl.replace("r=","&r"+secondaryCtr+"=");
				currUrl = currUrl.replace("n=","n"+secondaryCtr+"=");
				collectedCharUrls += currUrl;
				secondaryCtr++;
			}			
		}
	});
		
	//encode url for special chars				
	return collectedCharUrls;
}

//send ajax request to update characters and reload page
function updateCharIcons(charUrls){	
	
	$.ajax({
		type: "GET",
		url: 'character-select-submit.xml?' + charUrls,
		async: false,
		dataType: "text",
		success: function(msg){
			window.location.reload(); //refresh page
		},
		error: function(msg){				
			window.location.reload(); //refresh page
		}
	});
}

char_arr = new Array();
realm_arr = new Array();
var lastfield, ajaxinit, default_realm
function add_rss_char(somefield)
{   var char_req = ochar_req = $("#character"+somefield).val()

    if(char_req == '') { 	if(char_arr[somefield-1] && char_arr[somefield-1].length > 0) 
								{ 	addchar_error(str_removed+" "+char_req,somefield);
									char_arr[somefield-1] = realm_arr[somefield-1] = null; 
									refresh_rss_url()
									//$(".ajax_error:eq("+(somefield-1)+")").html('') 
								}
							else addchar_error(str_err_char,somefield); 
							return;
					   }
    if(char_req.indexOf("@") < 0 && (!default_realm || default_realm=='')) { addchar_error(str_err_realm,somefield); return }
	
	char_req = char_req.split("@")
	if(!char_req[1] && default_realm) char_req[1] = default_realm
	char_req[0] = jQuery.trim(char_req[0])
	char_req[1] = jQuery.trim(char_req[1]).replace(/\s/g,"+")
	var char_req_url = "character-feed.xml?r="+char_req[1]+"&cn="+char_req[0]+"&skipCache"
	
	lastfield = somefield; 

	$.get(char_req_url, {},
	  function(data,textStatus){
		//alert("Data Loaded: " + data + "\nStatus:"+textStatus);
		if(textStatus=="success")
		{ char_arr[somefield-1] = char_req[0]
		  realm_arr[somefield-1] = char_req[1]
		  refresh_rss_url()
		  $(".ajax_error:eq("+(somefield-1)+")").html('')
	   	  $(".character_row:eq("+(somefield-1)+") > a").hide();
		  $(".character_row:eq("+(somefield-1)+")").addClass("ok");
		  if(somefield<6) $(".character_row:eq("+(somefield)+")").fadeIn("fast",function(){	$("#character"+(Number(somefield)+1)).focus();})
		  var charattr = {}
		  var charInfo = data.getElementsByTagName("character")[0]
		  var charLvl = Number(charInfo.getAttribute("level"))
		  var charLvlRg = (charLvl < 60)?"-default":(charLvl < 70)?"":(charLvl < 80)?"-70":"-80"
		  var charimg = '<a href="javascript:;" class="staticTip" onmouseover="setTipText(str_remove)" onclick="rss_remove('+somefield+')"><img class="" src="images/portraits/wow'+charLvlRg+'/'+charInfo.getAttribute("genderId")+"-"+charInfo.getAttribute("raceId")+"-"+charInfo.getAttribute("classId")+'.gif"/></a>'
		  $(".character_row:eq("+(somefield-1)+") > .rss_port").html(charimg)
		  bindToolTips()
		}
	  });
	if(!ajaxinit) { bind_ajax_error(); ajaxinit = true }
	
}

function rss_remove(somefield)
{  $("#character"+somefield).val('')
   add_rss_char(somefield)
	}

function bind_ajax_error()
{ 
  $(".custom_rss_container").ajaxError(function(event, request, settings){
	if(ochar_req.indexOf("@")==-1){ ochar_req += " on " + default_realm}
   addchar_error(str_cantfind.replace('XXX'," <b>" + ochar_req + "</b>"),lastfield);	  
  });
}

function addchar_error(some_err,somefield)
{	var err_field = $(".ajax_error:eq("+(somefield-1)+")")
	err_field.parent().removeClass("ok");
	err_field.html(some_err);
 	err_field.stop();
	err_field.animate({color:"red"},"fast").animate({color:"black"},3000)

}

var focusval
function char_check(targ,option)
{ if(!option) 
   { focusval = targ.value
   }
  else
  { if(targ.value != focusval){ add_rss_char(targ.id.slice(-1)) }
  }
	
}

function check_action()
{ $(this).toggleClass('checked');
  if($(this).parent().hasClass('sub')){ $(this).parent().toggleClass('deselected'); }
  refresh_rss_url()
}

var base_rss_url = location.href.split("custom-rss.xml")[0]+ "character-feed.atom"
function refresh_rss_url()
{ var opt_arr = new Array()
  var achieve_arr = new Array()
  var opt = $(".check_box.checked").each(function(){ if($(this).parent().hasClass("sub")) achieve_arr.push(this.id); 
													 else opt_arr.push(this.id.toUpperCase()); 
												    })
  var feed_url = base_rss_url + "?r="+realm_arr.join(",").replace(/(,+$)+|(^,+)+/g,'')+"&cn="+char_arr.join(",").replace(/(,+$)+|(^,+)/g,'')
  if(opt_arr.length > 0 && opt_arr.length != $(".top_level > .check_box").length) feed_url += "&filters="+opt_arr.join(",")
  if(achieve_arr.length > 0 && $('#achievement').hasClass('checked') && achieve_arr.length != $(".sub > .check_box").length) 
  	feed_url += "&achCategories="+achieve_arr.join(",") 
  if(achieve_arr.length == 0 && $('#achievement').hasClass('checked')) $('#achievement').removeClass('checked')
  if($('#loot').hasClass('checked')){
	  item_qual  = $('#loot_rarity').val(); if(item_qual!='') feed_url += "&itemQuality="+ item_qual.toUpperCase();
	  item_level = $('#loot_ilvl').val(); if(item_level!='') feed_url += "&itemLevel="+ item_level
  }
  feed_url = feed_url.replace(/(,+)/g,',')+"&locale="+lang;  
  if(char_arr.length > 0 && char_arr.join('') != '') $("#customfeed_url").val(feed_url)
  if(char_arr.join('') == '') $("#customfeed_url").val('')
  //$("#rss_link_copy").attr("href",feed_url)
}


function check_default_char()
{
 if((armory_query.n || armory_query.cn) && armory_query.r){ 
	def_chr = armory_query.n||armory_query.cn
	def_rlm = armory_query.r.replace(/\+/g," ")
	$("#character1").val(def_chr+"@"+def_rlm); 
	$(".character_row:first > a").click()
	
	$("#feed_return").html(backhtml.replace("default_chr",def_chr)).attr('href',"character-sheet.xml?r="+armory_query.r+"&cn="+def_chr);
	}
}

function toggle_subfilter(which, targ)
{	$(targ).toggleClass('less')
	$('#'+which).toggle();
}
//Moved setDualTooltipCookie to common.js
