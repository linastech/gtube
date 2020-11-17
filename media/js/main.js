$(document).ready(function(){
	$("#videoPlayer").video({
		onProgress: function(playedPerc, playedTime){
			$(".v-t-marker").css("left", playedPerc + "%");
		}
	});
});