;(function ( $, window, document, undefined ) {
	var body = $("body");

    var defaults = {
    	onProgress: function(playedPerc, playedTime){}
    };

    function video( element, options ) {
        var _this = this;
        this.showClouds = true;
        this.options = $.extend(true, {}, defaults, options );
        this.element = element;

        element.removeAttribute("controls");

        this.init();
    }
    
    video.prototype = {   
        init: function() {
        	var _this = this;
			var fclick = false;
			this.fullScreen = false;
			this.playing = false;
			this.mouseMoved = null;

			$(".v-c-progress").css("width", $(this.element).width() - 16);

			$(".v-container").mouseover(function(){
				_this.toggleProgressBar("show");
			});

			$(".v-container").mouseout(function(){
				_this.toggleProgressBar("hide");
			});

			//toggle hd
			body.on("click", ".v-c-hd", function(){
				$(this).toggleClass("active");
			});

			var playTimeOut = null;
			//Pause - Play
			$(".v-c-play, #videoPlayer, .v-playButton").click(function(){
				if($(".v-c-play").hasClass("active")){
					_this.element.pause();
					$(".v-playButton").show();


					playTimeOut = setTimeout(function(){
						$(".v-playButton").fadeOut();
					}, 3000);
				}else{
					_this.element.play();
					$(".v-playButton").hide();
				}
				
				$(".v-c-play").toggleClass("active");
			});

			$(".v-container").mousemove(function(){
				if(playTimeOut != null)
					clearTimeout(playTimeOut);

				if($(".v-playButton").is(":visible"))
					playTimeOut = setTimeout(function(){
						$(".v-playButton").fadeOut();
					}, 3000);

				if(_this.element.paused && _this.element.currentTime != 0){
					$(".v-playButton").show();
				}
			});

			//Toggle fullscreen
			$(".v-c-fullScreen").click(function(){

				fclick = true;
				_this.fullScreenMode();
				setTimeout(function(){
					fclick = false;
				}, 200);

				_this.fullScreen = _this.fullScreen ? false : true;
			});

			//user is entering or leaving fullScren mode
			$(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e){
				if(!fclick){
					_this.fullScreen = true;
					_this.fullScreenMode();
					//set this to false so auto resize function wouldn't fire
					fclick = true;

					_this.fullScreen = false;
				}

			});

			//change volume
			$(".v-c-volume-slider").slider({
				orientation: "horizontal",
				max: 1,
				range: "min",
				step: 0.01,
				value: 0.75,
				slide: function(event, ui) {
					if(ui.value < 0.6)
						$(".v-c-volume").css("width", "14px");

					if(ui.value < 0.2)
						$(".v-c-volume").css("width", "10px");

					if(ui.value > 0.6)
						$(".v-c-volume").css("width", "");


					_this.element.volume = ui.value;
				}
			});

			$(".v-c-progress").slider({
				orientation: "horizontal",
				max: 100,
				range: "min",
				step: 1,
				value: 0
			}).on("slide", function(event, ui){
				_this.sliding = true;
				_this.element.currentTime = _this.element.duration / 100 * ui.value;
			}).on("slidestop", function(event, ui){
				_this.sliding = false;
			});

			$(".v-c-progress .ui-slider-handle").append('<img src="media/images/vide-player-handle.png" class="video-player-handle-img" />');

			$(this.element).bind("contextmenu oncontextmenu", function(e){
				e.preventDefault();
			})

			//mute 
			$(".v-c-volume").click(function(){
				$(".v-c-volume-slider").slider("value", 0);

				$(".v-c-volume").css("width", "12px");
				_this.element.volume = 0;
			});

			//handle data on progress
			this.element.addEventListener("timeupdate", function(event){
				_this.progress(event);
			});

			//playback ended
			this.element.addEventListener("ended", function(event){
				$(".v-c-play").removeClass("active");
			});

			this.element.addEventListener("progress", function(event){
				_this.buffer();
			}, true);

			setTimeout(function(){
				_this.buffer();
			}, 100)
        },

		toggleProgressBar: function(action){
			if(action == "hide"){
				$(".video-player-handle-img")
					.stop()
					.animate({
						width: 6,
						height: 6,
						top: -4,
						left: 5
					}, 400, function(){
						$(this).hide();
					});

				$(".v-c-progress-bg, .v-c-progress, .v-c-buffer")
					.stop()
					.animate({
						height: 4
					}, 500)
					.css('overflow', 'visible');

			}else{
				$(".video-player-handle-img")
				.show()
				.stop()
				.animate({
					width: 15,
					height: 15,
					left: 0,
					top: 0
				}, 20);
				
				$(".v-c-progress-bg, .v-c-progress, .v-c-buffer")
					.stop()
					.animate({
						height: 10
					}, 20)
					.css('overflow', 'visible');
			}
		},

		fullScreenMode: function(){
			vContainer = $(".v-container")[0];
			var _this = this;

			if(!this.fullScreen){
				fsc = vContainer.requestFullScreen || vContainer.webkitRequestFullScreen || vContainer.mozRequestFullScreen;
				fsc.call(vContainer);

				$(".v-container").addClass("v-fullScreen");

				setTimeout(function(){
					$(".v-c-progress").css("width", $(window).width() - 16);
				}, 100);
				
				var showBar = null;
				$(".v-container").bind("mousemove", function(){
					if(this.mouseMoved != null)
						clearTimeout(this.mouseMoved);

					if(showBar != null)
						clearTimeout(showBar);
					
					setTimeout(function(){
						$(".v-c-container").stop().animate({
							bottom: 0
						}, 50);

						$(".v-top-container")
							.stop()
							.animate({
								top: 0,
							}, 50);
					}, 50)

					this.mouseMoved = setTimeout(function(){
						if(!_this.fullScreen)
							return;

						$(".v-c-container").stop().animate({
							bottom: "-43px"
						});

						$(".v-top-container")
							.stop()
							.animate({top: "-47px"});
					}, 3000);
				});
			}else{
				if (document.exitFullscreen) document.exitFullscreen();
				else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
				else if (document.webkitCancelFullScreen) document.webkitCancelFullScreen();

				$(".v-container").removeClass("v-fullScreen");

				setTimeout(function(){
					$(".v-c-progress").css("width", $(_this.element).width() - 16);
				}, 100);
				
				$(".v-container").unbind("mousemove");
				$(".v-c-container").stop().css("bottom", 0);
				$(".v-top-container").stop().css("top", "");
			}
		},

		buffer: function(){
		    var v = document.getElementById('videoPlayer');
		    var r = v.buffered;
		    var total = v.duration;

			var end = r.end(r.length - 1);

			buffered = ( (end / total) * 100 );

			$(".v-c-buffer").css("width", buffered + "%");		
		},

		progress: function(event){
			data = event.target;
			time = parseInt(data.currentTime);

			if(time == 2 && !this.onPlayHideProgress){
				this.toggleProgressBar("hide");
				this.onPlayHideProgress = true;
			}

			if(!this.sliding)
				$(".v-c-progress").slider("value", data.currentTime / data.duration * 100);

			$(".v-c-length .current")
				.text(
					moment("00:00", "mm:ss")
						.seconds(time)
						.format("mm:ss")
				);

			this.options.onProgress(data.currentTime / data.duration * 100, time);
			this.playing = true;
		},

		now: function(){
			return moment("00:00", "mm:ss")
				.seconds(this.element.currentTime)
				.format("mm:ss");
		},

		pause: function(){
			this.element.pause();

			$(".v-c-play").removeClass("active");
		},

        destroy: function(){
            this.container.hide();

            $(this.element).data('video', null);
        }

    }

    $.fn.video = function(opt) {
        // slice arguments to leave only arguments after function name
        var args = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
            var item = $(this), instance = item.data('video');
            if(!instance) {
                // create plugin instance and save it in data
                item.data('video', new video(this, opt));
            } else {
                // if instance already created call method
                if(typeof opt === 'string') {
                    instance[opt].apply(instance, args);
                }
            }
        });
    };

})( jQuery, window, document );