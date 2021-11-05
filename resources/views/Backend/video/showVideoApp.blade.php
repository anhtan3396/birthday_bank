<?php
    $url = $video->video_path;
    parse_str(parse_url($url, PHP_URL_QUERY), $youtube);
	//print_r($youtube['v']); die();
    $url =$video->video_path;
    preg_match('/(?<=(?:v|i)=)[a-zA-Z0-9-]+(?=&)|(?<=(?:v|i)\/)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+/', $url, $matches);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Japanese Test | Xem Video</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/video.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">

</head>
<body>
	<section class="wrapper-pay">
		<div class="content">
			 <div id="player"></div>

    <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
		
        player = new YT.Player('player', {
          height: window.innerWidth*9/16,
          width: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
          videoId: '<?php echo $matches[0] ?>',
          playerVars: {rel:0},
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING && !done) {
          setTimeout(stopVideo, 6000);
          done = true;
        }
      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>
			<div class="description">
				<h4>Thông tin bài giảng</h4>
				<table class="table table-striped custab">
					<tr>
						<th>Tên:</th>
					</tr>
					<tr>
						<th style="font-weight: normal;">{{ $video->video_title }}</th>
					</tr>
					<tr>
						<th>Mô tả:</th>
					</tr>
					<tr>
						<th style="font-weight: normal;">{{ $video->video_description  }}</th>
					</tr>

				</table>
			</div>
		</div>
		<div class="copy-right">
			<p>@Copyright - 2017 by THAOTOKYO</p>
		</div>
	</section>

</body>
</html>