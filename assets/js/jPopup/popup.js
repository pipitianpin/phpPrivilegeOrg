/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = new Array();
popupStatus[0] = 0;

//loading popup with jQuery magic!
function loadPopup(popupBoxId, bgId, multipleId, presetOpacity){
	//loads popup only if it is disabled
	if(popupStatus[multipleId]==0){
		$("#" + bgId).css({
			"opacity": (presetOpacity == undefined?"0.7":presetOpacity)
		});
		$("#" + bgId).fadeIn("slow");
		$("#" + popupBoxId).fadeIn("slow");
		popupStatus[multipleId] = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(popupBoxId, bgId, multipleId, callback){
	//disables popup only if it is enabled
	if(popupStatus[multipleId]==1){
		$("#" + bgId).fadeOut("slow");
		$("#" + popupBoxId).fadeOut("slow");
		popupStatus[multipleId] = 0;
		//console.log(typeof callback);
		if ((typeof callback) == "function") callback();
	}
}

//centering popup
function centerPopup(popupBoxId, bgId){
	$("#" + popupBoxId).center();
	var windowHeight = document.documentElement.clientHeight;
	//only need force for IE6
	
	$("#" + bgId).css({
		"height": windowHeight
	});
	
}
function showPopup(popupBoxId, bgId, closeId, preventClose, multipleId, presetOpacity, closeCallback){
	if (multipleId != undefined && multipleId !== null && multipleId != ""){
		popupStatus[multipleId] = 0;
		multipleId = parseInt(multipleId);
	}else{
		multipleId = 0;
	}
	if(popupStatus[multipleId]==1){
		disablePopup(popupBoxId, bgId, multipleId, closeCallback);
	}
	var popupBoxObj = $("#" + popupBoxId);
	var bgObj = $("#" + bgId);
	var closeObj = $("#" + closeId);
	
	//init css
	popupBoxObj.css("position","fixed");
	popupBoxObj.css("z-index","99999");
	popupBoxObj.css("font-size","13px");
	
	bgObj.css("position","fixed");
	bgObj.css("height","100%");
	bgObj.css("width","100%");
	bgObj.css("top","0");
	bgObj.css("left","0");
	bgObj.css("background","#000000");
	bgObj.css("border","1px solid #cecece");
	bgObj.css("z-index","99998");
	
	closeObj.click(function(){
		disablePopup(popupBoxId, bgId, multipleId, closeCallback);
	});
	if (preventClose != 1){
		//Click out event!
		bgObj.click(function(){
			disablePopup(popupBoxId, bgId, multipleId, closeCallback);
		});
		
		//Press Escape event!
		$(document).keypress(function(e){
			if(e.keyCode==27 && popupStatus[multipleId]==1){
				disablePopup(popupBoxId, bgId, multipleId, closeCallback);
			}
		});
	}
	
	centerPopup(popupBoxId, bgId);
	loadPopup(popupBoxId, bgId, multipleId, presetOpacity);
}

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
    return this;
}
