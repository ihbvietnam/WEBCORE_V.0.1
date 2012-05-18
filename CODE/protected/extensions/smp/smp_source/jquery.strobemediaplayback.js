/*****************************************************
*  
*  Copyright 2010 Adobe Systems Incorporated.  All Rights Reserved.
*  
*****************************************************
*  The contents of this file are subject to the Berkeley Software Distribution (BSD) Licence
*  (the "License"); you may not use this file except in
*  compliance with the License. 
* 
*  Software distributed under the License is distributed on an "AS IS"
*  basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
*  License for the specific language governing rights and limitations
*  under the License.
*   
*  
*  The Initial Developer of the Original Code is Adobe Systems Incorporated.
*  Portions created by Adobe Systems Incorporated are Copyright (C) 2010 Adobe Systems 
*  Incorporated. All Rights Reserved. 
*  
*****************************************************/

/**
 * jQuery plugin that generate the necessary video playback mark-up.
 * @param {Object} /iPad/i
 */
(function($, undefined){


    /**
     * Adapts the options of the video player based on the device/browser capabilities.
     */
    var AdaptiveExperienceConfigurator = function(){
    };
    
    var adaptiveExperienceConfiguratorMethods = {
    
        initialize: function(){
            this.userAgent = navigator.userAgent;
            
            this.isiPad = this.userAgent.match(/iPad/i) != null;
            this.isiPhone = this.userAgent.match(/iPhone/i) != null;
            this.isAndroid = this.userAgent.match(/Android/i) != null;
            
            this.screenWidth = screen.width;
            this.screenHeight = screen.width;
            this.isPhone = this.screenHeight < 360;
            this.isTablet = this.screenHeight >= 360 && this.screenHeight <= 768;
            this.isDesktop = this.screenHeight > 768;
            
            this.hasHTML5VideoCapability = !!document.createElement('video').canPlayType;
            this.hasFlashPlayerCapability = this.detectFlashPlayerCapability();
            this.flashPlayerVersion = swfobject.getFlashPlayerVersion();
        },
        
        /**
         * This is exploration code - sniff user agents for detecting Flash Capability.
         *
         * ... exploration code, far from being complete
         */
        detectFlashPlayerCapability: function(){
            // iPhone & iPad don't have flash capability
            var result = this.isDesktop;
			result &= !(this.isiPad && this.isiPhone);
            // Assume that Android 2.2 phones & tablets have flash support... 
			// this is slightly exagerated by, this is exploration code
            result |= !this.isDesktop && (this.userAgent.match(/Android 2.2/i) != null);			
            return result;
        },
        
        adapt: function(options){
        
            if (!this.userAgent) {
                // Initialize lazily
                this.initialize();
            }
            
            // First, extend with default values
            options = $.extend({}, $.fn.strobemediaplayback.defaults, options);
            this.changed = true;
            var i = 0, n = this.rules.length;
            while (this.changed) {
                this.changed = false;
                for (i = 0; i < n; i++) {
                    this.rules[i](this, options);
                }
                this.changed = false;
            }
            return options;
        },
        
        setOption: function(options, name, value){
            if (!options.hasOwnProperty(name) || options[name] != value) {
                options[name] = value;
                this.changed = true;
            }
        },
        rules: [ //playerImplementation
function(context, options){
            if (options.favorFlashOverHtml5Video && context.hasFlashPlayerCapability) {
                context.setOption(options, "useHTML5", false);
            }
            else 
                if (!options.favorFlashOverHtml5Video && context.hasHTML5VideoCapability) {
                    context.setOption(options, "useHTML5", true);
                }
                else 
                    if (options.favorFlashOverHtml5Video) {
                        context.setOption(options, "useHTML5", !context.hasFlashPlayerCapability);
                    }
                    else {
                        context.setOption(options, "useHTML5", context.hasHTML5VideoCapability);
                    }
        }, //neverUseJavaScriptControlsOnIPhone:
 function(context, options){
            if (context.isiPhone) {
                context.setOption(options, "javascriptControls", false);
            }
        }, //hideVolumeControlOnIPad: 
 function(context, options){
            if (context.isiPad) {
                context.setOption(options, "disabledControls", ".volume");
            }
        }, // No Flash & No HTML5 Video
 function(context, options){
            if (!context.hasFlashPlayerCapability && !context.hasHTML5VideoCapability) {
                context.setOption(options, "javascriptControls", false);
                context.setOption(options, "displayAlternativeContent", true);
            }
        }
]
    };
    
    AdaptiveExperienceConfigurator.prototype = adaptiveExperienceConfiguratorMethods;
	
    
    
	$.fn.adaptiveexperienceconfigurator = new AdaptiveExperienceConfigurator();
    
    var StrobeMediaPlayback = function(element,options,parameters,attributes){
        this.$element = $(element);
        this.options = $.extend({}, $.fn.strobemediaplayback.defaults, options);
         this.parameters=parameters;
         this.attributes=attributes;
    };
	
	// HACK: keeps the reference to the context of the function which uses swfobject 
	// - needed for the swfobject.js error callback handler.
    var onFlashEmbedCompleteThisReference = null;
	
    var strobeMediaPlaybackMethods = {
        initialize: function(){        
            if (this.options.useHTML5) {
				var $video = $("<video></video>");
                $video.attr("id", this.options.id);	
                $video.attr("class", "smp_video");
                $video.attr("preload", "none");
                $video.attr("width", this.options.width);
                $video.attr("height", this.options.height);
                $video.attr("src", this.options.src);
				
				if (this.options.loop)
				{
					$video.attr("loop", "loop");
				}
				if (this.options.autoPlay)
				{
					$video.attr("autoplay", "autoplay");
				}
				if (this.options.controlBarMode !=  "none")
				{
					$video.attr("controls", "controls");
				}
				if  (this.options.poster != "")
				{
					$video.attr("poster", this.options.poster);
				}
                
                this.$element.replaceWith($video);
            }
            else {
                this.options.queryString = $.fn.strobemediaplayback.generateQueryString(this.options);
                var flashvars = this.options;
                var params=this.parameters;
                var attributes=this.attributes;

				onFlashEmbedCompleteThisReference = this;
                swfobject.embedSWF(
                                        this.options.swf,
					this.$element.attr("id"), 
					this.options.width, 
					this.options.height, 
					this.options.minimumFlashPlayerVersion,
					this.options.expressInstallSwfUrl, 
					flashvars, 
                                        params,
                                        attributes,
					this.onFlashEmbedComplete);            
            }
            
			
            if (this.options.useHTML5 && typeof(onJavaScriptBridgeCreated) == "function") {
				// TODO: reimplmenet this so that it uses options.javascriptCallbackFunction
                onJavaScriptBridgeCreated(this.options.id, true);
            }
        },
		
		onFlashEmbedComplete: function(event)
		{
			if (!event.success && $.fn.adaptiveexperienceconfigurator.hasHTML5VideoCapability)
			{
				onFlashEmbedCompleteThisReference.useHTML5 = true;
				onFlashEmbedCompleteThisReference.initialize();			
			}
		}
    }
    
    StrobeMediaPlayback.prototype = strobeMediaPlaybackMethods;
    
    $.fn.strobemediaplayback = function(options,parameters,attributes){
        var instances = [], i;
        
        var result = this.each(function(){
            instances.push(new StrobeMediaPlayback(this, options,parameters,attributes));
        });
        
        for (i = 0; i < instances.length; i++) {
            instances[i].initialize();
        }
        
        return result;
    };
    
    /**
     * Plug-in default values
     */
    $.fn.strobemediaplayback.defaults = {
        favorFlashOverHtml5Video: true,
        swf: "StrobeMediaPlayback.swf",
        javascriptCallbackFunction: "org.strobemediaplayback.triggerHandler",
        minimumFlashPlayerVersion: "10.1.0",
        expressInstallSwfUrl: "expressInstall.swf",
		autoPlay: false,
		loop: false,
		controlBarMode: "docked",
		poster: ""
    };    
	
	
    /**
     * Utitility method that will retrieve the page parameters from the Query String.
     */
    $.fn.strobemediaplayback.parseQueryString = function(queryString){
        var options = {};
        
        var queryPairs = queryString.split('&'), queryPair, n = queryPairs.length;
        for (var i = 0; i < n; i++) {
            queryPair = queryPairs[i].split('=');
            if (queryPair[1] == "true" || queryPair[1] == "false") {
                options[queryPair[0]] = (queryPair[1] == "true");
            }
            else {
                var number = parseFloat(queryPair[1]);
                if (!isNaN(number)) {
                    options[queryPair[0]] = number;
                }
                else {
                    options[queryPair[0]] = queryPair[1];
                }
            }
        }
        return options;
    }
    
    
    /**
     * Utitility method that will retrieve the page parameters from the Query String.
     */
    $.fn.strobemediaplayback.generateQueryString = function(options){
        var queryStrings = [];
        for (var key in options) {
            if (queryStrings.length > 0) {
                queryStrings.push("&");
            }
            queryStrings.push(encodeURIComponent(key));
            queryStrings.push("=");
            queryStrings.push((options[key]));
        }
        return queryStrings.join("");
    }

    
    /**
     * Custom video playback controls
     */
    var writableProperties = "src preload currentTime defaultPlaybackRate playbackRate autoplay loop controls volume muted".split(" ");
    
    var timeRangeProperties = "played seekable buffered".split(" ");
    var timeRangeMethods = {
        start: function(index){
            return this._start[index];
        },
        end: function(index){
            return this._end[index];
        }
    }
    
    var monitorChanges = function(monitor){
        var i = writableProperties.length;
        while (i--) {
            var propertyName = writableProperties[i];
            if (monitor.cc.hasOwnProperty(propertyName) &&
            monitor.videoElement.hasOwnProperty(propertyName) &&
            monitor.cc[propertyName] != monitor.videoElement[propertyName]) {            
            
                var setter = "set" + propertyName.charAt(0).toUpperCase() + propertyName.substring(1);
                monitor.$strobeMediaPlayback[0][setter](monitor.videoElement[propertyName]);
				monitor.cc[propertyName] = monitor.videoElement[propertyName];
            }
        }
        setTimeout(function(){
            monitorChanges(monitor)
        }, 500);
    };
    
    var VideoElementMonitor = function($strobeMediaPlayback){
        this.$strobeMediaPlayback = $strobeMediaPlayback;
        this.strobeMediaPlayback = $strobeMediaPlayback[0];
        
        this.videoElement = {
            duration: 0,
            currentTime: 0,
            paused: true,
            muted: false
        };
        
        this.cc = {
            duration: 0,
            currentTime: 0,
            paused: true,
            muted: false
        };
        // 
        this.videoElement.play = jQuery.proxy(this.strobeMediaPlayback.play2, this.strobeMediaPlayback);
        this.videoElement.pause = jQuery.proxy(this.strobeMediaPlayback.pause, this.strobeMediaPlayback);
        this.videoElement.load = jQuery.proxy(this.load, this);
        this.$videoElement = $(this.videoElement);
    }
	
    var isPropertyChanged = function(object, cc, propertyName)
	{
		return !object.hasOwnProperty(propertyName) && object[propertyName] != cc[propertyName];
	}
	
    var videoElementMonitorMethods = {
        load: function(){			
            this.strobeMediaPlayback.setSrc(this.videoElement.src);
            this.strobeMediaPlayback.load();
        },
        
        update: function(properties, events, monitor){       			
            var propertyName;
			for (propertyName in properties) {
                if (jQuery.inArray("emptied", events) < 0 &&
                monitor.cc.hasOwnProperty(propertyName) &&
                monitor.videoElement.hasOwnProperty(propertyName) &&
                (monitor.cc[propertyName] != monitor.videoElement[propertyName] && !isNaN(monitor.cc[propertyName]) && !isNaN(monitor.videoElement[propertyName]))) {
                    // this value changed
                    continue;
                }
                monitor.cc[propertyName] = properties[propertyName];
                monitor.videoElement[propertyName] = properties[propertyName];
                if (jQuery.inArray(propertyName, timeRangeProperties) >= 0) {
                    monitor.videoElement[propertyName].start = timeRangeMethods.start;
                    monitor.videoElement[propertyName].end = timeRangeMethods.end;
                }
            }

            if (events) {
                var i = events.length;
                while (i--) {
                    monitor.$videoElement.triggerHandler(events[i]);
                }
            }
        }
    }
    
    VideoElementMonitor.prototype = videoElementMonitorMethods;
    
    /**
     *
     */
    var StrobeMediaPlaybackChrome = function(element, options){
        this.$window = $(window);
        this.$document = $(document);
        this.$element = $(element);
        this.options = $.extend({}, $.fn.strobemediaplaybackchrome.defaults, options);
    };
    
    
    var strobeMediaPlaybackChromeMethods = {
        initialize: function(){
            if (!this.options.javascriptControls) {
                this.$element.find(".strobeMediaPlaybackControlBar,.smp-error,.playoverlay").hide();
                return;
            }
            
            this.$player = $("#" + this.options.id)
            this.player = this.$player.get(0);
            
            // TODO: Encapsulate this in a dedicated class
            if (!this.options.useHTML5) {
            
                this.monitor = new VideoElementMonitor(this.$player);
                this.$player.data("videoElement", this.monitor.$videoElement);
                this.player = this.monitor.videoElement;
                this.$player = this.monitor.$videoElement;                
                org.strobemediaplayback.proxied[this.options.id] = this.monitor;             
                monitorChanges(this.monitor);
            }          
            
            this.sliding = false;
            
            this.playOverlay = this.$element.find('.playoverlay');
            this.play = this.$element.find('.smp.play');
            this.mute = this.$element.find('.smp.volume');
            this.time = this.$element.find('.time');
            this.currentTimeLabel = this.$element.find('.currentTime');
            this.durationLabel = this.$element.find('.duration');
            this.errorOverlay = this.$element.find('.smp-error');
            this.fullscreen = this.$element.find('.fullscreen');
            
            this.play.bind('click', this, this.onPlayClick);
            this.playOverlay.bind('click', this, this.onPlayClick);
            this.mute.bind('click', this, this.onMuteClick);
            this.fullscreen.bind('click', this, this.onFullScreenClick);
            
            this.$player.bind("play", this, this.onPlay);
            this.$player.bind("pause", this, this.onPause);
            this.$player.bind("volumechange", this, this.onVolumeChange);
            this.$player.bind("durationchange", this, this.onDurationChange);
            this.$player.bind("timeupdate", this, this.onTimeUpdate);
            this.$player.bind("waiting", this, this.onWaiting);
            this.$player.bind("seeking", this, this.onSeeking);
            this.$player.bind("seeked", this, this.onSeeked);
            this.$player.bind("ended", this, this.onPause);
            this.$player.bind("error", this, this.onError);
            this.$player.bind("progress", this, this.onProgress);            
            
            this.timeTrack = this.$element.find(".video-track");
            this.slider = this.$element.find(".slider");
            this.played = this.$element.find(".played");
            this.buffered = this.$element.find(".buffered");
            
            this.slider.bind("mousedown", this, this.onSliderMouseDown);
            this.slider.bind("touchstart", this, this.onSliderMouseDown);
            
            // Keep here for further experimentation
            //this.slider.bind("touchmove", this, this.onTouchMove);
            
            this.timeTrack.bind('mousedown', this, this.onTimeTrackClick);
            
            this.$window.bind("orientationchange", this, this.onOrinetationChangeOrResize);
            this.$window.bind("resize", this, this.onOrinetationChangeOrResize);
            
            if (options.disabledControls) {
                this.$element.find(options.disabledControls).addClass("disabled");
            }
            
            this.isFullScreen = false;
            this.layoutControlBar(this.options.width, this.options.height);
        },
        
        onSliderMouseDown: function(event){
            var duration, time, player;
            if (!event.data.sliding) {
                event.preventDefault();
                
                // TODO: Move the sliding code into a special widget
                player = event.data.player;
                event.data.sliding = true;
                duration = player.duration;
                event.data.onProgress(event);
                var timeTrack = event.data.timeTrack;
                var slider = event.data.slider;
                
                var moveTarget = event.data.$document;
                moveTarget.bind("mousemove", event.data, onMouseMove);
                moveTarget.bind("touchmove", event.data, onMouseMove);
                
                moveTarget.bind("mouseup", event.data, onMouseUp);
                moveTarget.bind("touchend", event.data, onMouseUp);
                
                moveTarget.bind("touchcancel", event.data, onTouchCancel);
                
            }
            
            function onMouseMove(event){
                event.preventDefault();
                var timeTrackWidth = event.data.timeTrack.outerWidth();
                var offsetLeft = event.data.timeTrack.offset().left;
                var x = event.clientX;
                var originalEvent = event.originalEvent;
                if (typeof x == 'undefined' && originalEvent && originalEvent.touches && originalEvent.touches.length > 0) {
                    x = originalEvent.touches[0].pageX;
                }
                var relativePosition = (x - offsetLeft) / (timeTrackWidth);
                
                time = duration * relativePosition;
                if (time < duration && time > 0) {
                
                    var timePercent = (Math.max(0, time) / duration * 100);
                    event.data.slider.css({
                        "left": timePercent + "%"
                    });
                    
                    event.data.played.css({
                        "width": timePercent + "%"
                    });
                    event.data.seekTime = time;
                    event.data.onProgress(event);
                }
                
            };
            
            function onMouseUp(event){
                moveTarget.unbind("mousemove");
                moveTarget.unbind("touchmove");
                
                moveTarget.unbind("mouseup");
                moveTarget.unbind("touchend");
                
                if (time > 0) {
                    event.data.seekTime = 0;
                    player.currentTime = time;
                }
                event.data.sliding = false;
            };
            
            function onTouchCancel(event){
                event.data.seekTime = 0;
                event.data.sliding = false;
            };
                    },
        
        onOrinetationChangeOrResize: function(event){
            event.data.layoutControlBar(event.data.options.width, event.data.options.height);
        },
        
        onPlayClick: function(event){
            var player = event.data.player;
            
            if (player.paused) {
                player.play();
            }
            else {
                player.pause();
            }
        },
        
        onMuteClick: function(event){
            var player = event.data.player;
            player.muted = !player.muted;
        },
        
        onFullScreenClick: function(event){
            event.data.$element.parent().toggleClass("fullscreen-mode");
        },
        
        onTimeTrackClick: function(event){
            var duration = event.data.player.duration;
            var timeTrackWidth = event.data.timeTrack.outerWidth();
            var offsetLeft = event.data.timeTrack.offset().left;
            var relativePosition = (event.clientX - offsetLeft) / (timeTrackWidth);
            
            var time = duration * relativePosition;            
            
            if (time > 0) {
                event.data.player.currentTime = time;
            }
            
            
            $("#seekDebug").html("clientX=" + event.clientX + " width=" + timeTrackWidth + " duration=" + duration + " time=" + time);
        },
        
        onPlay: function(event){
            event.data.errorOverlay.hide();
            event.data.play.removeClass("play").addClass("pause");
            if (event.data.useHTML5 &&
            event.data.options.hasOwnProperty("playButtonOverlay") &&
            event.data.options.playButtonOverlay) {
                event.data.playOverlay.fadeOut(600);
            }
        },
        
        onPause: function(event){
            event.data.play.removeClass("pause").addClass("play");
            if (event.data.useHTML5 && event.data.options.playButtonOverlay) {
                event.data.playOverlay.fadeIn(600);
            }
        },
        
        onWaiting: function(event){
            // $("#debug").append("BUFFERING");
            event.data.buffered.css({
                "width": 0
            });
        },
        
        onError: function(event){
            //$("#debug").append("ERROR" + event.data.player.error.code);
            if (event.data.useHTML5) {
                var message;
                switch (event.target.error.code) {
                    case event.target.error.MEDIA_ERR_ABORTED:
                        message = 'You aborted the video playback.';
                        break;
                    case event.target.error.MEDIA_ERR_NETWORK:
                        message = 'A network error caused the video download to fail part-way.';
                        break;
                    case event.target.error.MEDIA_ERR_DECODE:
                        message = 'The video playback was aborted due to a corruption problem or because the video used features your browser did not support.';
                        break;
                    case event.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
                        message = 'The video could not be loaded, either because the server or network failed or because the format is not supported.';
                        break;
                    default:
                        message = 'An unknown error occurred.';
                        break;
                }
                //$("#debug").append(message);
                event.data.errorOverlay.html(message);
                event.data.errorOverlay.show();
            }
        },
        
        onSeeking: function(event){
            // $("#debug").append("SEEKING");
        },
        
        onSeeked: function(event){
            event.data.onProgress(event);
        },
        
        onVolumeChange: function(event){
            if (event.data.player.muted) {
                event.data.mute.addClass("mute");
            }
            else {
                event.data.mute.removeClass("mute");
            }
        },
        
        onDurationChange: function(event){
            var duration = event.data.player.duration;
            var currentTime = event.data.player.currentTime;
            
            var timeDuration = formatTimeStatus(currentTime, duration);
            
            event.data.currentTimeLabel.html(timeDuration[0]);
            event.data.durationLabel.html(timeDuration[1]);
        },
        
        onTimeUpdate: function(event){
            if (event.data.sliding) {
                return;
            }
            var duration = event.data.player.duration;
            var currentTime = event.data.player.currentTime;
            
            var timeDuration = formatTimeStatus(currentTime, duration);
            
            event.data.currentTimeLabel.html(timeDuration[0]);
            event.data.durationLabel.html(timeDuration[1]);
            
            var timePercent = (Math.max(0, currentTime) / duration * 100);
            
            event.data.slider.css({
                "left": timePercent + "%"
            });
            
            event.data.played.css({
                "width": timePercent + "%"
            });
            
            event.data.onProgress(event);
        },
        
        onProgress: function(event){
            var bufferedPercent = 0;
            
            if (!event.data.player.seeking) {
                var buffered = event.data.player.buffered;
                
                var time = event.data.seekTime || Math.max(0, event.data.player.currentTime);
                //$("#debug").append(buffered.length + "-" + buffered.end(buffered.length - 1));
                var timePercent = time / event.data.player.duration * 100;
                if (buffered) {
                    var lastBuffered = buffered.end(buffered.length - 1);
                    bufferedPercent = (lastBuffered / event.data.player.duration) * 100;
                    bufferedPercent -= timePercent;
                    //$("#debug").append(bufferedPercent);
                }
                if (timePercent + bufferedPercent > 100) {
                    bufferedPercent = 100 - timePercent;
                }
            }
            var css = {
                "left": timePercent + "%",
                "width": bufferedPercent + "%"
            }
            if (bufferedPercent + timePercent > 99) {
                event.data.buffered.addClass("done")
            }
            else {
                event.data.buffered.removeClass("done")
            }
            event.data.buffered.css(css);
        },
        
        layoutControlBar: function(newWidth, newHeight){
            if (this.useHTML5 && this.options.playButtonOverlay) {
                this.playOverlay.fadeIn(600);
                this.playOverlay.css({
                    "left": (newWidth / 2 - this.playOverlay.width() / 2) + "px",
                    "top": (newHeight / 2 - this.playOverlay.height() / 2) + "px"
                });
            }
            
            $('.video-progress2').css({
                "width": (newWidth - 200) + "px"
            });
            
            //$('.strobeMediaPlaybackControlBar').fadeIn(600);
            $('.strobeMediaPlaybackControlBar').css({
                "width": newWidth - 6 + "px"
            });
        }
        
    }
    
    StrobeMediaPlaybackChrome.prototype = strobeMediaPlaybackChromeMethods;
    
    
    /**
     * jQuery plugin hook
     */
    $.fn.strobemediaplaybackchrome = function(options){
        var instances = [], i;
        var result = this.each(function(){
            instances.push(new StrobeMediaPlaybackChrome(this, options));
        });
        
        for (i = 0; i < instances.length; i++) {
            instances[i].initialize();
        }
        return result;
    };
    
    /**
     * jQuery plugin defaults
     */
    $.fn.strobemediaplaybackchrome.defaults = {
        javascriptControls: false
    };
    
    
    // Internals, private functions
    
    function onMouseMove(event){
        showControlBar();
    }
    
    function formatTimeStatus(currentPosition, totalDuration){
        var h;
        var m;
        var s;
        function prettyPrintSeconds(seconds, leadingMinutes, leadingHours){
            seconds = Math.floor(isNaN(seconds) ? 0 : Math.max(0, seconds));
            h = Math.floor(seconds / 3600);
            m = Math.floor(seconds % 3600 / 60);
            s = seconds % 60;
            return ((h > 0 || leadingHours) ? (h + ":") : "") +
            (((h > 0 || leadingMinutes) && m < 10) ? "0" : "") +
            m +
            ":" +
            (s < 10 ? "0" : "") +
            s;
        }
        
        var totalDurationString = prettyPrintSeconds(totalDuration);
        var currentPositionString = prettyPrintSeconds(currentPosition, h > 0 || m > 9, h > 0);
        return [currentPositionString, totalDurationString];
    }
    
})(jQuery);


/*
 * Generate org.strobemediaplayback namespace - which will be used by the
 * Flash/Strobe Media Playback once it is ready
 */
if (typeof org == 'undefined') {
    var org = {};
}

if (typeof org.strobemediaplayback == 'undefined') {
    org.strobemediaplayback = {};
}

if (typeof org.strobemediaplayback.proxied == 'undefined') {
    org.strobemediaplayback.proxied = {};
}

org.strobemediaplayback.triggerHandler = function(id, eventName, updatedProperties){
    if (eventName == "onJavaScriptBridgeCreated") {
        if (typeof onJavaScriptBridgeCreated == "function") {
            onJavaScriptBridgeCreated(id);
        }
    }
    else {
        if (typeof org.strobemediaplayback.proxied[id] != 'undefined') {
            org.strobemediaplayback.proxied[id].update(updatedProperties, [eventName], org.strobemediaplayback.proxied[id]);
        }
    }
}


