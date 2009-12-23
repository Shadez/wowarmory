function initCharTalents() {
	
	var currUrl = location.href;
	
	if(currUrl.indexOf("group=") != -1){
		var group = currUrl.substr(currUrl.indexOf("group=") + 6,1);		
		if(group == "1" || group == "2"){
			$("#group_" + group + "_link").trigger("click");		
		}	
	}
}

function switchTalentSpec(active, group, talStr) {

	talentCalc.applyTalents(talStr);	
	
	$("#group_1").removeClass("selectedSet");
	$("#group_2").removeClass("selectedSet");
	$("#group_" + group).addClass("selectedSet");
	
	// Switch glyphs	
	$("#glyphSet_1").hide();
	$("#glyphSet_2").hide();
	$("#glyphSet_" + group).show();
}

function switchPetTalentSpec(select) {

	var parts    = select.options[select.selectedIndex].value.split('-');
	var familyId = parseInt(parts[0]);
	var build    = parts[1];
	
	petTalentCalc.changePetTree(null, familyId);
	petTalentCalc.applyTalents(build);
}

function makeGlyphTooltip(name, type, effect){
		
	var tipstr = "<strong>" + name + "</strong><br />";
	tipstr += "<span style='color: #73c7f3'>" + type + "</span><br />";
	tipstr += effect;
	
	setTipText(tipstr);
}