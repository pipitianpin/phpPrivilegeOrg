/*
*
*this fle contains all the jwplayer functions, using jwplayer API for cutomizing jwplayer 
*/

var oldstates = null;
var video_length = 0;
var required_duration = endtime - starttime;
var mid_of_player_width = playerWidth/2;
var mid_of_player_height = playerHeight/2;
var isFullscreen_on_portable_device = false;
var viewerStyle = ''; //for ie10 or less versions to make fullscreen
var winXCor = null;
var winYCor = null;
var winOuterWidth = null;
var winOuterHeight = null;
var isfullscreen_on_ie = false;
var s;  //for jquery ui slider instance
//var clicks, timer, delay;      //for detecting double click on player div
//clicks =0; delay=1000;timer=null;
//$(document).ready(function(e) {
	//loadjscssfile('/js/lib/jquery-1.7.2.min.js', 'js');
    set_controlbar_size_position(playerWidth, playerHeight);
	//check_flash_version_function();  
//});	
//-----user activity/inactivity on touch devices. show/hie of control bar on this basis --//
idleTimer = null;
idleState = false;
idleWait = 5000;

(function ($) {
    $(document).ready(function () {
		// jquery code for dynamic width an dheight for player //
		/*var isMobile = window.matchMedia("only screen and (max-width: 760px)");
			if (isMobile.matches) {
				var iframeWidth = $('#programPagePlayer').width();
				var iframeHeight = parseInt(((9*iframeWidth)/16), 10);
				$('#programPagePlayer').css('height',iframeHeight + 'px');
			}
			else
			{
				$('#programPagePlayer').css('height','360px');
			}*/
		//end of code for dynamic width and height //	
		
        $('*').bind('mousemove keydown scroll', function () {
            clearTimeout(idleTimer); 
			 //active state  
            if (idleState == true) { 
				       $('.control_bar').fadeIn(500);      
            }
            idleState = false;
			 idleTimer = setTimeout(function () {
            // Idle Event
			 if(jwplayer(playername).getState() == "PLAYING")
						{
							$('.control_bar').fadeOut(500);
						}
            idleState = true; }, idleWait);
        });
        $("body").trigger("mousemove");
    });
}) (jQuery)
//---end of touch device active/inactive status code--//
//---Mouse hover effect when player is in playing mode. Displays control bar, if mouse hovers-------//
$( "#player_control_wrapper" ).mouseleave(function() {
	if(jwplayer(playername).getState() == "PLAYING")
	{
		$('.control_bar').fadeOut(500);
	}
});
$( "#player_control_wrapper" ).mouseenter(function() {
	/*$('.control_bar').css('filter', 'alpha(opacity=40)');*/
	$('.control_bar').fadeIn(500);
});

//-----------------------//

//if start and end time is given
var formatted_duration = format_duration(Math.round(required_duration));
		  if(formatted_duration.indexOf("-")==-1)
		  {
		  $('#duration_time').html(formatted_duration);
		  }
				  
			  
//--onReady function , when player renders on browser------//
jwplayer(playername).onReady(function() {
	$('#loader').css('background-image','url(/assets/images/embedPlayer/playBig.png)');
	$('#loader').css('background-repeat','no-repeat');
	$('#loader').css('display','block');
});

//--end of onReady function , when player renders on browser------//

//----event listener for player screen clicking ----//

jwplayer(playername).onDisplayClick(function() {
	playPauseRequested();
});		
// --------------event listener for customized JWplayer's play button--------------//
$('#play-pause').click(function() {
	//$(this).find("img").toggle();
	//var mode =jwplayer(playername).getRenderingMode();
	//alert(mode);
	playPauseRequested();
});

$('#loader').click(function() {
	playPauseRequested();
});
	
//--------------event listener for clickig on backward or forward buttons------------//
	$('#back10sec').click(function() {
		var jwplayerPosition = jwplayer(playername).getPosition();
		//alert(jwplayer(playername).getPosition());
		var backPosition = jwplayerPosition-10;
		//alert(backPosition);
		if(backPosition > starttime)
		{
			jwplayer(playername).seek(backPosition);
		}
	});
	$('#forward10sec').click(function() {
		var jwplayerPosition = jwplayer(playername).getPosition();
		var forwardPosition = jwplayerPosition+10;
		if(forwardPosition < endtime)
		jwplayer(playername).seek(forwardPosition);
	});

		
//-------------when player goes into play state---------//		
jwplayer(playername).onPlay(function(callback) {
	$('#loader').css('display','none');
	var isPlaying = jwplayer(playername).getState();
	if(isPlaying == "PLAYING")
	{
		$('#play-pause').find("img#pause_button").css('display','inline');
		$('#play-pause').find("img#play_button").css('display','none');
	}

});

//-------------when player goes into error state, while playing media file---------//		
jwplayer(playername).onError(function(callback) {
	var isError = jwplayer(playername).getState();
		$('#error').html(callback.message);
		$('#error').css('display','block');
		$('#loader').css('display','none');
		//$('#play-pause').find("img#pause_button").css('display','inline');
		//$('#play-pause').find("img#play_button").css('display','none');

});

		
//------ function call when player goes into buffer-------//
jwplayer(playername).onBuffer(function() {
	$('#play-pause').find("img#pause_button").css('display','inline');
	 $('#play-pause').find("img#play_button").css('display','none');
	 $('#loader').css('background-image','url(/assets/images/embedPlayer/ajax-loader.gif)');
	$('#loader').css('display','block');
});

jwplayer(playername).onBufferChange(function() {
});

jwplayer(playername).onIdle(function(callback) {
	//$('#loader').css('display','none');
	oldstates =null;
	if(callback.oldstate == 'PLAYING')
	{
	$('#loader').css('background-image','url(/assets/images/embedPlayer/replay.png)');
	$('#loader').css('display','block');
	}
	$('#play-pause').find("img#pause_button").css('display','none');
	 $('#play-pause').find("img#play_button").css('display','inline');
});		
//------ end of function call when player goes into buffer or in IDLE-------//
		

// ----------pause event--------------------------------//			
jwplayer(playername).onPause(function() {
	oldstates = jwplayer(playername).getPosition();
	$('#play-pause').find("img#pause_button").css('display','none');
	 $('#play-pause').find("img#play_button").css('display','inline');
	$('#loader').css('display','none');
	$('.control_bar').fadeIn(500);
});

// Event listener for the seek bar on clicking on slider
//$('#seek-bar').click(function() {
    //alert("yes");
	/*$( "#seek-bar" ).slider({
  		slide: function( event, ui ) {
				var time = ui.value;
				console.log("slider time is : "+time);
			  // var new_seek_position = <?php //echo $starttime;?> + Math.round((time/100)*<?php //echo $required_duration; ?>);
			   //var new_seek_position = Math.round((time/100)*<?php //echo $required_duration; ?>);
			   var new_seek_position = Math.round((time/100)*required_duration);
			   console.log("new seek position: "+new_seek_position+" and player is: "+playername);
			   jwplayer(playername).seek(new_seek_position);
			   $('#play-pause').find("img#pause_button").css('display','inline');
			   $('#play-pause').find("img#play_button").css('display','none');
			}
	 });*/
//});

//-------------------------// 


// Update the seek bar as the video plays
jwplayer(playername).onTime(function() {
		if (video_length == 0 && endtime == 0) {
			// we don't have a duration, so it's playing so we can discover it...
			video_length = jwplayer(playername).getDuration();
			endtime = video_length;
			required_duration = endtime - starttime;
			var duration_time = format_duration(Math.round(required_duration));
			//alert(duration_time);
				  if(duration_time.indexOf("-")==-1)
				  {
				 	 $('#duration_time').html(duration_time);
					 $('#duration_time').hide();
					 $('#duration_time').get(0).offsetHeight;
					 $('#duration_time').show();
				  }
		  }
//----------updating slider value and handle on fly----------------------//		
	 // var value = (100 /<?php //echo $required_duration; ?>) * (jwplayer(playername).getPosition()-<?php //echo $starttime; ?>);
	   var value = (100 /required_duration) * (jwplayer(playername).getPosition() - starttime);
	  //$('#seek-bar').val(value);
	    s.slider('option', 'value', value); /*.find('.ui-widget-header').css('width', loaded + '%');*/
	    //$('#seek-bar').slider('option', 'value', value); /*.find('.ui-widget-header').css('width', loaded + '%');*/
	 

//------stops video when position is greater than given end time-----------//
		  //if (jwplayer(playername).getPosition() > '<?php //echo $endtime; ?>') {
		 // if (jwplayer(playername).getPosition() > '<?php //echo $required_duration; ?>') {
		if (jwplayer(playername).getPosition() > endtime ) {
		  jwplayer(playername).stop();
		  oldstates = starttime;
		   //oldstates = 0;
		  $('#play-pause').find("img#pause_button").css('display','none');
		  $('#play-pause').find("img#play_button").css('display','inline');
		  }
//---------updating elapsed time , left digits of control bar-----------//	  
	  var position = jwplayer(playername).getPosition();
	 // var elapsed_time = format_duration(Math.round(jwplayer(playername).getPosition()-<?php// echo $starttime; ?>));
	  var elapsed_time = format_duration(Math.round(jwplayer(playername).getPosition() - starttime));
	  if(elapsed_time.indexOf("-")==-1)
	  {
	  $('#elapsed_time').html(elapsed_time);
	  $('#elapsed_time').hide();
	  $('#elapsed_time').get(0).offsetHeight;
	  $('#elapsed_time').show();
	  }
	  	  
});
			
//-------------------------//

//------initiating jquery time-slider ------//
$(function(){
  s = $("#seek-bar").slider({
        range: "max",
        min: 0,
        max: 100,
        value: 0,
		 slide: function( event, ui ) {
				var time = ui.value;
				//console.log("slider time is : "+time);
			  // var new_seek_position = <?php //echo $starttime;?> + Math.round((time/100)*<?php //echo $required_duration; ?>);
			   //var new_seek_position = Math.round((time/100)*<?php //echo $required_duration; ?>);
			   var new_seek_position = Math.round((time/100)*required_duration) + Math.round(starttime);
			   console.log("new seek position: "+new_seek_position+" and time is: "+time+" required duration : "+starttime);
			   jwplayer(playername).seek(new_seek_position);
			   $('#play-pause').find("img#pause_button").css('display','inline');
			   $('#play-pause').find("img#play_button").css('display','none');
			   //$('.control_bar').fadeIn(500); 
			}
    })
   // .css('background-image', 'url()');
});
/*var time = 0,
    bytes = 0;
getCurrentTime = function() { return time++; };
getVideoBytesLoaded = function() {
    return (bytes += Math.floor(Math.random()*500000) + 1000000);
};*/
//--------end of jquery slider -----------//	
		
// Event listener for the mute button
$('#mute').click (function() {
		 set_volume_icon();
});

function set_volume_icon() {
	if (jwplayer(playername).getMute() == false) {
			// Mute the video
			jwplayer(playername).setMute(true);
			$('#mute').removeClass('s-volume');
			$('#mute').addClass('s-volume-mute');
		  } else {
			// Unmute the video
			jwplayer(playername).setMute(false);
			$('#mute').removeClass('s-volume-mute');
			$('#mute').addClass('s-volume');
		  }
		  $('#volume_bar1').toggleClass('state_toggle');
		  $('#volume_bar2').toggleClass('state_toggle');
		  $('#volume_bar3').toggleClass('state_toggle');
		  $('#volume_bar4').toggleClass('state_toggle');
		  $('#volume_bar5').toggleClass('state_toggle');	
}

//-----------------------//
		
// Event listener for the volume bar 
$('#volume_bar1').click (function() {
			  jwplayer(playername).setVolume('20');
			  $('.volume_bars').removeClass('state_toggle');
			  $(this).css('color','#1AC7CC');
			  $('#volume_bar2').css('color','#000');
			  $('#volume_bar3').css('color','#000');
			  $('#volume_bar4').css('color','#000');
			  $('#volume_bar5').css('color','#000');
			  $('#mute').removeClass('s-volume-mute');
			  $('#mute').addClass('s-volume');
});
$('#volume_bar2').click (function() {
			  jwplayer(playername).setVolume('40');
			  $('.volume_bars').removeClass('state_toggle');
			  $(this).css('color','#1AC7CC');
			  $('#volume_bar1').css('color','#1AC7CC');
			  $('#volume_bar3').css('color','#000');
			  $('#volume_bar4').css('color','#000');
			  $('#volume_bar5').css('color','#000');
			  $('#mute').removeClass('s-volume-mute');
			  $('#mute').addClass('s-volume');
});
$('#volume_bar3').click (function() {
			  jwplayer(playername).setVolume('60');
			  $('.volume_bars').removeClass('state_toggle');
			  $(this).css('color','#1AC7CC');
			  $('#volume_bar1').css('color','#1AC7CC');
			  $('#volume_bar2').css('color','#1AC7CC');
			  $('#volume_bar4').css('color','#000');
			  $('#volume_bar5').css('color','#000');
			  $('#mute').removeClass('s-volume-mute');
			  $('#mute').addClass('s-volume');
});
$('#volume_bar4').click (function() {
			  jwplayer(playername).setVolume('80');
			  $('.volume_bars').removeClass('state_toggle');
			  $(this).css('color','#1AC7CC');
			  $('#volume_bar1').css('color','#1AC7CC');
			  $('#volume_bar2').css('color','#1AC7CC');
			  $('#volume_bar3').css('color','#1AC7CC');
			  $('#volume_bar5').css('color','#000');
			  $('#mute').removeClass('s-volume-mute');
			  $('#mute').addClass('s-volume');
});
$('#volume_bar5').click (function() {
			  jwplayer(playername).setVolume('100');
			  $('.volume_bars').removeClass('state_toggle');
			  $(this).css('color','#1AC7CC');
			  $('#volume_bar1').css('color','#1AC7CC');
			  $('#volume_bar2').css('color','#1AC7CC');
			  $('#volume_bar3').css('color','#1AC7CC');
			  $('#volume_bar4').css('color','#1AC7CC');
			  $('#mute').removeClass('s-volume-mute');
			  $('#mute').addClass('s-volume');
});
//-----------------------//


/*$(function(){
    parent.$.colorbox.resize({
        innerWidth:"640",
        innerHeight:"360"
    });
});	*/
		
// Event listener for the full-screen button
//$("#full-screen").on("click", function(e) {
function toggleFull(video) {	
		var video = document.getElementById("player_control_wrapper");
		var elem = document.body;
		if(window.devicePixelRatio !== undefined) {    //-----chechks devices pixel ratio----//
   		   dpr = window.devicePixelRatio;
		} else {
				dpr = 1;
		}
		//var width = window.screen.width*dpr;
		//var height = window.screen.height*dpr;
		var width = window.screen.width;
		var height = window.screen.height;
		var innerWidth = window.innerWidth;
		var winWidth = window.screen.availWidth;
		var winHeight = window.screen.availHeight;
		var top_window_obj = window.top;
		//alert("width: "+width+" height "+height);
		var bIsAppleMobile = fnIsAppleMobile();  //--------check for if agent is ipad, iphone....//
		var is_android_device = fnIsAndroidDevice(); //-------check for if device is android-------//
			if(bIsAppleMobile || is_android_device)
			{
				var isWidth = jwplayer(playername).getWidth();
				var isHeight= jwplayer(playername).getHeight();
				
				if(isWidth != playerWidth || isHeight != playerHeight)
				{
					jwplayer(playername).resize(640,360);
					notFullScreenOnDevices();
				}
				else
				{					
					
					jwplayer(playername).resize(innerWidth,innerWidth*(9/16));
					isFullScreenOnDevices();
					controlBarPositionOnDevices(); //checks if device is in portrait position, than adjust the position of control bar
				}
				$("#"+playername+"").toggleClass('positionPlayerOnDeviceInFullscreen');
				$("#player_control_wrapper").toggleClass('handDevicePlayerWrapper');
			}
			else
			{	  
			  if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
					if (document.exitFullscreen) {
							document.exitFullscreen();
							jwplayer(playername).resize(640,360);
						} else if (document.webkitExitFullscreen) {
							document.webkitExitFullscreen();
							jwplayer(playername).resize(640,360);
							notFullScreen();
						} else if (document.mozCancelFullScreen) {
							document.mozCancelFullScreen();
							jwplayer(playername).resize(640,360);
						} else if (document.msExitFullscreen) {
							document.msExitFullscreen();
							jwplayer(playername).resize(640,360);
						} /*else {
							 if(viewerStyle != ""){
								 
								
							 }
						}*/
			  }
			  else if (video.requestFullscreen) {
				  jwplayer(playername).resize(width,height);
				  video.requestFullscreen();
			  } else if (video.mozRequestFullScreen) {
				  jwplayer(playername).resize(width,height);
				  video.mozRequestFullScreen(); // Firefox
			  } else if (video.webkitRequestFullscreen) {
				  jwplayer(playername).resize(width,height);
				  video.webkitRequestFullscreen(); // Chrome and Safari
				  isFullScreen();
			  } else if (video.msRequestFullscreen) {
				  jwplayer(playername).resize(width,height);
				  video.msRequestFullscreen();
			  } else if (typeof window.ActiveXObject !== "undefined") { // Older IE less than 11
					/*var wscript = new ActiveXObject("WScript.Shell");
					if (wscript !== null) {
						wscript.SendKeys("{F11}");
					}*/
					/*alert("1");
					//Stage["displayState"] = "fullScreen";
					stage.displayState = StageDisplayState.FULL_SCREEN;
					alert("2");*/
					 if(viewerStyle.length == 0){
						//document.body.style.overflow = "hidden";
                		viewerStyle = video.style.cssText;
						winXCor = window.screenX;
						winYCor = window.screenY;
						winOuterWidth = window.outerWidth;
						winOuterHeight = window.outerHeight;
						
						
						top_window_obj.window.moveTo(0,0);
						top_window_obj.window.resizeTo(window.screen.width,window.screen.height);
						
                		video.style.cssText = "position:fixed; top:0px; left:0px; height:100%; width:100%; z-index:9998;";	
						
						jwplayer(playername).resize(window.innerWidth,window.innerHeight);	
						//jwplayer(playername).resize(window.innerWidth,window.innerWidth/1.77);
						isFullScreen();	
						isfullscreen_on_ie = true;
						//alert(jwplayer().getWidth()+" and "+jwplayer().getHeight());
						//alert(window.screen.width+" and "+window.screen.height);
						//alert(jwplayer().getFullscreen());
							
					 } else {
						     //document.body.style.overflow = "inherit";
						     video.style.cssText = viewerStyle;
							 jwplayer(playername).resize(640,360);
							 notFullScreen();
							 //alert("cors are "+winXCor+" and "+winYCor+" size is "+winOuterWidth+" and "+winOuterHeight);
							 window.resizeTo(winOuterWidth,winOuterHeight);
							 window.moveTo(winXCor, winYCor);
							 isfullscreen_on_ie = false; 
							 viewerStyle = ""; 	 
					 }
					 
						
			  }  	
		}
}
//-- function for handling resizing window, while player is in full screen mode on IE 10 or less --//
/*$(window).resize(function(e) {
				if(isfullscreen_on_ie == true)
				{
                    var new_w_height = $(window).height();
                    var new_w_width = $(window).width();
                    jwplayer(playername).resize(new_w_width, new_w_height);
				}
});*/

//-----toggling fullscreen on double click--//
document.getElementById("player_control_wrapper").ondblclick = function() {toggleFull('player_control_wrapper');};

//---code for handling escape key on fullscreen mode on IE browser---//
window.document.onkeydown = function (e)
      {
        if (!e) e = event;
        if (e.keyCode == 27 && isfullscreen_on_ie == true)
        {
			toggleFull('player_control_wrapper');   
		 }
      }		
//---code for handling escape key on fullscreen mode---//
document.addEventListener("fullscreenchange", function () {
	(document.fullscreenElement && document.fullscreenElement != null) ? isFullScreen() : notFullScreen();
}, false);
document.addEventListener("webkitfullscreenchange", function () {
	(document.webkitFullscreenElement && document.webkitFullscreenElement != null) ? isFullScreen() : notFullScreen();
}, false);
document.addEventListener("mozfullscreenchange", function () {
	(document.mozFullScreen) ? isFullScreen() : notFullScreen();
}, false);
document.addEventListener("MSFullscreenChange", function () {
	(document.msFullscreenElement && document.msFullscreenElement != null) ? isFullScreen() : notFullScreen();
}, false);
//$(document).bind('webkitfullscreenchange', onFullscreenChange);

//--code for checking handheld devices's orientation if it is landscape or portrait --/
var previousOrientation = window.orientation;
var checkOrientation = function(){
    if(window.orientation !== previousOrientation){
        previousOrientation = window.orientation;
		if(isFullscreen_on_portable_device) {
			// orientation changed, so adjust player's width and height //
			//alert('HOLY ROTATING SCREENS BATMAN:' + window.orientation + " " + window.innerWidth + " " +window.innerHeight+" and "+screen.width+" "+screen.height);
			jwplayer(playername).resize(window.innerWidth,window.innerWidth*(9/16));	
			// adjust control bar position //
			controlBarPositionOnDevices();
		}
    }
	//-- function for handling resizing window, while player is in full screen mode on IE 10 or less --//
	if(isfullscreen_on_ie == true)
				{
                    var new_w_height = $(window).height();
                    var new_w_width = $(window).width();
                    jwplayer(playername).resize(new_w_width, new_w_height);
				}
};
window.addEventListener("resize", checkOrientation, false);
window.addEventListener("orientationchange", checkOrientation, false);
setInterval(checkOrientation, 2000);  // Android doesn't always fire orientationChange on 180 degree turns, so for making sure it  checks even it is 180 turn


function isFullScreen() {
	//alert("yes");
	  $('#full-screen').removeClass('full_screen_color');
	  $('#full-screen').addClass('normal_screen');
	  $('#loader').css('position','absolute');
	  $('#loader').css('top','45%');
	  $('#loader').css('left','50%');
	  $('#error').css('top','45%');
	  $('#error').css('left','45%');
	 $('.control_bar').addClass('control_bar_fullscreen');
	 $('.time_slider_range').css('width',370);
	 $('.control_bar_text').css('display','inline');
}
		
function notFullScreen() {
	//alert("no");
	$('#full-screen').removeClass('normal_screen');
	  $('#full-screen').addClass('full_screen_color');
	  jwplayer(playername).resize(playerWidth,playerHeight);
	  set_controlbar_size_position(playerWidth, playerHeight);
	  $('.control_bar').removeClass('control_bar_fullscreen');
	  
}
function isFullScreenOnDevices() {
	//alert("yes");
	isFullscreen_on_portable_device = true;
	  $('#full-screen').removeClass('full_screen_color');
	  $('#full-screen').addClass('normal_screen');
	  $('#loader').css('position','absolute');
	  $('#loader').css('top','45%');
	  $('#loader').css('left','50%');
	  $('#error').css('top','45%');
	  $('#error').css('left','45%');
	 $('.control_bar').addClass('control_bar_fullscreen_on_devices');
	 $('.time_slider_range').css('width',370);
	 $('.control_bar_text').css('display','inline');
}
		
function notFullScreenOnDevices() {
	//alert("no");
	isFullscreen_on_portable_device = false;
	$('#full-screen').removeClass('normal_screen');
	  $('#full-screen').addClass('full_screen_color');
	  jwplayer(playername).resize(playerWidth,playerHeight);
	  set_controlbar_size_position(playerWidth, playerHeight);
	  $('.control_bar').removeClass('control_bar_fullscreen_on_devices');
	  
}

function controlBarPositionOnDevices() {
	if(window.orientation == '0' || window.orientation == '180') {
		var portraitHeightOfPlayer = jwplayer(playername).getHeight();
		var videoControlPos = $("#video-controls").css('top');
		$("#video-controls").css('top',portraitHeightOfPlayer+'px');		
	} else {
		$("#video-controls").css('top',-50+'px');
	}
}

function playPauseRequested() {
	var jwplayer_state = jwplayer(playername).getState();
	if(jwplayer_state == "PLAYING" || jwplayer_state == "BUFFERING")
	{
		jwplayer(playername).pause(true);
	}
	else
	{
	   //if(oldstates != null && oldstates < '<?php echo $endtime; ?>'){
		  if(oldstates != null && oldstates < endtime){ 
			jwplayer(playername).seek(oldstates);
		} else {
			
				setTimeout(function()
				{ jwplayer(playername).seek(starttime); }, 20);
				//jwplayer(playername).play(true);
				//if (video_length == 0) {
					// if we don't have a duration yet, so start playing
					//jwplayer(playername).play(true);
				  //}
				  
		 }
	}
}
		
//-----elaped duration formatting in javascript --------//
function format_duration(secs) {
	 secs = Math.round(secs);
    //var hours = Math.floor(secs / (60 * 60));

    //var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(secs / 60);
	if(minutes < 10)
	{
			minutes = "0"+minutes;
	}
    var divisor_for_seconds = secs % 60;
    var seconds = Math.ceil(divisor_for_seconds);
	if(seconds < 10)
	{
			seconds = "0"+seconds;
	}
	var duration_formatted = minutes+":"+seconds;
    return duration_formatted;
}
//----end of -elaped duration formatting in javascript --------//

// ------ Function fnIsAppleMobile or ipad------//
function fnIsAppleMobile() 
{
    if (navigator && navigator.userAgent && navigator.userAgent != null) 
    {
        var strUserAgent = navigator.userAgent.toLowerCase();
        var arrMatches = strUserAgent.match(/(iphone|ipod|ipad)/);
        if (arrMatches != null) 
             return true;
    } // End if (navigator && navigator.userAgent) 

    return false;
} 
//------ End Function fnIsAppleMobile-------//

//--------function for detecting android devices---//
function fnIsAndroidDevice()
{
	var isAndroid = navigator.userAgent.toLowerCase().indexOf("android");
	  if(isAndroid > -1)
	  {
		  return true;
	  }
	  return false;
}

//---------function for handling size and position of controlbar and play/loader images----------//
function set_controlbar_size_position(playerWidth, playerHeight) {
	
	$('#video-controls').css('width',playerWidth-20);
	$('#video-controls').css('top',playerHeight-50);
	$('#loader').css('top', mid_of_player_height-25 );
	$('#loader').css('left', mid_of_player_width-15 );
	$('#error').css('top', mid_of_player_height-25 );
	$('#error').css('left', mid_of_player_width-90 );
	//checking for ipad or android agents, so that hide volume icons
	var is_mobile_ipad = fnIsAppleMobile();
	var is_android_device = fnIsAndroidDevice();
	if(is_mobile_ipad || is_android_device) {
		$('#mute').css('display', 'none');
		$('#volume_bar').css('display', 'none');
	}
	/*if(playerWidth<150)
	{
		$('.control_bar_text').css('display','none');
		$('#seek-bar').css('width',0);
		$('.time_slider_range').css('display','none');
		$('a.play_button').css('padding','7px 5px 3px 5px');
		
	}
	else */if(playerWidth<320)
	{
		$('.control_bar_text').css('display','none');
		$('a.play_button').css('padding','7px 5px 3px 5px');
		if(is_mobile_ipad || is_android_device) {
		    $('#seek-bar').css('width',playerWidth-20-140+32);
		} else {
			$('#seek-bar').css('width',playerWidth-20-140-50);
		}
	}
	else
	{
		if(is_mobile_ipad || is_android_device) {
			$('#seek-bar').css('width',playerWidth-20-280+32);
		} else {
			$('#seek-bar').css('width',playerWidth-20-280);
		}
	}
	
	
}

//---------end of function for handling size and position of controlbar and play/loader images----------//

//-----elaped duration formatting in javascript --------//
function format_duration(secs) {
	 secs = Math.round(secs);
    //var hours = Math.floor(secs / (60 * 60));

    //var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(secs / 60);
	if(minutes < 10)
	{
			minutes = "0"+minutes;
	}
    var divisor_for_seconds = secs % 60;
    var seconds = Math.ceil(divisor_for_seconds);
	if(seconds < 10)
	{
			seconds = "0"+seconds;
	}
	var duration_formatted = minutes+":"+seconds;
    return duration_formatted;
}
//----end of -elaped duration formatting in javascript --------//
//------function for adding css and js files in headf of page dynamically------//
//$(document).ready(function(e) {

	if(extraFiles == '1')
	{
		
	loadjscssfile('css/colorbox.css', 'css');
	loadjscssfile('css/jquery-ui.css', 'css');
	loadjscssfile('/js/lib/jquery-1.11.1.min.js', 'js');
	loadjscssfile('/js/lib/jquery-1.7.2.min.js', 'js');
	loadjscssfile('js/lib/jquery.colorbox-min.js', 'js');
	}
    
//});

function loadjscssfile(filename, filetype){
 if (filetype=="js"){ //if filename is a external JavaScript file
  var fileref=document.createElement('script');
  fileref.setAttribute("type","text/javascript");
  fileref.setAttribute("src", filename);
 }
 else if (filetype=="css"){ //if filename is an external CSS file
  var fileref=document.createElement("link");
  fileref.setAttribute("rel", "stylesheet");
  fileref.setAttribute("type", "text/css");
  fileref.setAttribute("href", filename);
 }
 if (typeof fileref!="undefined")
 {
 var isdone = document.getElementsByTagName("head")[0].appendChild(fileref);
 //alert(isdone);
 }
}

//------function for checking flash player existanse--------//
/*function check_flash_version_function() {
	 var version = '0,0,0,0';
    try {
        try {
            var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
            try { axo.AllowScriptAccess = 'always'; }
            catch(e) { version = '6,0,0'; }
        } catch(e) {}
        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable(
            '$version').replace(/D+/g, ',').match(/^,?(.+),?$/)[1];
    } catch(e) {
        try {
            if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
                version = (navigator.plugins["Shockwave Flash 2.0"] || 
                    navigator.plugins["Shockwave Flash"]).description.replace(/D+/g, ",").match(/^,?(.+),?$/)[1];
            }
        } catch(e) {}
    }
    if(version == '0,0,0,0') {
       //hasflash.innerHTML = "Your browser has not installed Adobe Flash, please go to Adobe site and install latest flash player";
	   alert("Your browser has not installed Adobe Flash, please go to Adobe site and install latest flash player.");
	  // $.fn.colorbox({html:"<h3 style='padding-left:10px;'>Your browsers Flash Player Version</h3><p style='color:#f00; padding:10px;'>Your browser has not installed Adobe Flash, please go to Adobe site and install latest flash player.</p>", width:400, height:200, closeButton:true});
    } else {
		
		var isLess = check_Version(version);
		if(isLess)
		{
			alert("Error loading player: Flash version must be 10.0 or greater. Your Browser has installed Adobe Flash "+version);
			//hasflash.innerHTML = "Error loading player: Flash version must be 10.0 or greater. Your Browser has installed Adobe Flash "+version;
			 //$.fn.colorbox({html:"<h3 style='padding-left:10px;'>Your browsers Flash Player Version</h3><p style='color:#f00; padding:10px;'>Error loading player: Flash version must be 10.0 or greater. Your Browser has installed Adobe Flash "+version+"</p>", width:400, height:200, closeButton:true, opacity:1});

		}
    }
}*/
//----------function for checking flash player version--------//
/*function check_Version(version) {
		if(version.indexOf('.') != false)
		{
			var firstDigit = version.match(/\d/) 
			var index_of_digit = version.indexOf(firstDigit)
			var indexofDot = version.indexOf('.');
			var flash_version= version.slice(index_of_digit, indexofDot);
		}
		if(flash_version < 16)
		return true;
}*/
/*-------------------------------------------------------------------------------------*/
/*$(function ()
{
	$.import_js('js/lib/jquery-1.11.1.min.js');
	$.import_js('/js/lib/jquery-1.11.1-ui.js');
	$.import_js('/js/jwplayer-6.10/jwplayer.js');
});	*/
/*(function($)
{
    var import_js_imported = [];

    $.extend(true,
    {
        import_js : function(script)
        {
			alert("yes false");
            var found = false;
            for (var i = 0; i < import_js_imported.length; i++)
                if (import_js_imported[i] == script) {
                    found = true;
                    break;
                }

            if (found == false) {
				
                $("head").append('<script type="text/javascript" src="' + script + '"></script>');
                import_js_imported.push(script);
            }
        }
    });

})(jQuery);*/