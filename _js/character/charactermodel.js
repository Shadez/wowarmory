// Character Model Specific JS calls


function set_3d_quality(type)
{
	setcookie("armory.cookie3dQuality", type);
}

function set_3d_cookie(name,type)
{
	setcookie("armory.cookie3d"+name, type);
}

/* Model Viewer Functions */
var mouseActionsInit
function bindMouseActions(){
		$("#center_target").bind("DOMMouseScroll",wheel)
		document.getElementById("center_target").onmousewheel = wheel;
		RightClick.init("ModelViewer3","center_target");
		$("#center_target").bind("mousedown",function(e){ tipsEnabled = false });
	if(!mouseActionsInit){
		$(window).bind("mouseup",function(e){ tipsEnabled = true;
											    if(e.button == 0){ try{document.getElementById("ModelViewer3").leftClickRelease(); } catch(err){} }
												if(e.button == 2){ try{document.getElementById("ModelViewer3").rightClickRelease();} catch(err){} } });
		$(window).unload( function(){       try{ document.getElementById("ModelViewer3").stopall(); } catch(err){} }); 	
		$(window).bind("blur",function(e){  try{ document.getElementById("ModelViewer3").sleep();   } catch(err){} });
		$(window).bind("focus",function(e){ try{ document.getElementById("ModelViewer3").wakeUp();  } catch(err){} });
		mouseActionsInit = true;
	}
}

function handle(delta) { try{document.getElementById("ModelViewer3").js_mousewheel(delta);}
						 catch(err){  } 
					   }

function cancelEvent(e)
{
  e = e ? e : window.event;
  if(e.stopPropagation)
	e.stopPropagation();
  if(e.preventDefault)
	e.preventDefault();
  e.cancelBubble = true;
  e.cancel = true;
  e.returnValue = false;
  return false;
}
					  

function wheel(event){
	var delta = 0;
	if (!event) /* For IE. */
			event = window.event;
	if (event.wheelDelta) { /* IE/Opera. */
			delta = event.wheelDelta/120;
			if (window.opera)
					delta = -delta;
	} else if (event.detail) { /** Mozilla case. */
			delta = -event.detail/3;
	}
	if (delta) handle(delta);
	if (event.preventDefault) event.preventDefault();
	cancelEvent(event);
}

/*
*** Copyright 2007  ** Paulius Uza * http://www.uza.lt ** Dan Florio * http://www.polygeek.com ** Project website: * http://code.google.com/p/custom-context-menu/ ** -- * RightClick for Flash Player. * Version 0.6.2 *
*/

var RightClick = {
	/* Constructor */
	init: function (objId, contId) {
		this.FlashObjectID = objId
		this.FlashContainerID = contId
		this.Cache = this.FlashObjectID;
		if(window.addEventListener){
			 window.addEventListener("mousedown", this.onGeckoMouse(), true);
		} else {
			document.getElementById(this.FlashContainerID).onmouseup = function() { document.getElementById(RightClick.FlashContainerID).releaseCapture(); }
			document.oncontextmenu = function(){ if(window.event.srcElement.id == RightClick.FlashObjectID) { return false; } else { RightClick.Cache = "nan"; }}
			document.getElementById(this.FlashContainerID).onmousedown = RightClick.onIEMouse;
		}
	},
	/* GECKO / WEBKIT event overkill * @param {Object} eventObject */
	killEvents: function(eventObject) {
		if(eventObject) {
			if (eventObject.stopPropagation) eventObject.stopPropagation();
			if (eventObject.preventDefault) eventObject.preventDefault();
			if (eventObject.preventCapture) eventObject.preventCapture();
		 if (eventObject.preventBubble) eventObject.preventBubble();
		}
	},
	/* GECKO / WEBKIT call right click * @param {Object} ev	 */
	onGeckoMouse: function(ev) {
		return function(ev) {
		if (ev.button != 0) {
			RightClick.killEvents(ev);
			if(ev.target.id == RightClick.FlashObjectID && RightClick.Cache == RightClick.FlashObjectID) {
				RightClick.call();
			}
			RightClick.Cache = ev.target.id;
		}
	  }
	},
	/* IE call right click * @param {Object} ev */
	onIEMouse: function() {
		if (event.button> 1) {
			if(window.event.srcElement.id == RightClick.FlashObjectID && RightClick.Cache == RightClick.FlashObjectID) {
				setTimeout(function(){document.getElementById(RightClick.FlashContainerID).releaseCapture();},1); RightClick.call(); 
			}
			document.getElementById(RightClick.FlashContainerID).setCapture();
			if(window.event.srcElement.id)
			RightClick.Cache = window.event.srcElement.id;
		}
	},
	/* Main call to Flash External Interface */
	call: function() { if(Browser.opera || (Browser.mac && Browser.firefox)) return;
		try{document.getElementById(this.FlashObjectID).rightClick();}
		catch(err){}
	}
}


var ajaxinit;				
function pose_save(somedata){
//	{r:theRealmName,n:theCharName,rot:180,z:20,a:69,timer:5}
	$('#pose_saving').show();
	var postData = somedata;
	if(!postData.cn) postData["cn"] = theCharName;
	if(!postData.r) postData["r"] = theRealmName
	jQuery.post("/vault/character-pose.html", somedata, pose_callback)
	//debugtxt = ''; for(x in somedata) { if(x!='n'&&x!='r') debugtxt += x+"=&quot;"+somedata[x]+"&quot; " } $('#debugtxt').html(debugtxt);
	if(!ajaxinit) { bind_ajax_error(); ajaxinit = true }
}

function pose_callback(data, textStatus)
{ 
	if(textStatus == "success")
	{	
		$('#pose_saving').hide();
		$('#pose_save_ok').fadeIn("fast",function(){$(this).animate({opacity:1},3000,"linear",function(){$(this).fadeOut(3000)}) })
	}
	else $("#pose_saving").html(textStatus)
}

function bind_ajax_error()
{ 
  $("#pose_saving").ajaxError( function(event, request, settings){ $(this).html("<span>"+str_loginExpired+"</span>"); });
}