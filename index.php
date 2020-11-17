<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>gTube</title>
	<link rel="stylesheet" type="text/css" href="media/css/darkstyle.css" />
	<script type="text/javascript" src="media/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="media/js/jquery-ui-1.10.2.js"></script>
	<script type="text/javascript" src="media/js/moment.js"></script>
	<script type="text/javascript" src="media/js/video_player.js"></script>
	<script type="text/javascript" src="media/js/main.js"></script>
    </head>



<body>
	<div id="container">
		<header>
			<a href="http://gtube.muhprivacy.com/">gTube</a>
			<form id="search">
				<input id="searchbar" type="text" name="Keyword" autofocus/>
				<input id="searchb" type="submit" value="Search" />
			</form>
		</header>
		<div id="wrapper">
			<div class="section">
				<div class="secTitle">Newest Videos</div>
					<ul class="videos">
					<?php
								foreach (glob("video/*.webm") as $file) {
									$id = preg_replace('/video\//', "", preg_replace('/\.webm/', "", $file));
							echo "<li>\n";
							echo "\t<a href=\"video.php?id=$id\">\n";
						echo "\t<img src='video/previews/$id.png' class='videoThumb'>";
						echo "<div class=\"videoTitle\">$id</div>\n";
							echo "\t</a>\n";
							echo "</li>\n";
						}
							?>
					</ul>
				</div>
				<div class="section">
				<div class="secTitle">Top Videos</div>
					<ul class="videos">
					<?php
								foreach (glob("video/*.webm") as $file) {
									$id = preg_replace('/video\//', "", preg_replace('/\.webm/', "", $file));
							echo "<li>\n";
							echo "\t<a href=\"video.php?id=$id\">\n";
						echo "\t<img src='video/previews/$id.png' class='videoThumb'>";
						echo "<div class=\"videoTitle\">$id</div>\n";
							echo "\t</a>\n";
							echo "</li>\n";
						}
							?>
					</ul>
				</div>
			<div class="section">
				<div class="secTitle">Videos Being Watched</div>
					<ul class="videos">
					<?php
								foreach (glob("video/*.webm") as $file) {
									$id = preg_replace('/video\//', "", preg_replace('/\.webm/', "", $file));
							echo "<li>\n";
							echo "\t<a href=\"video.php?id=$id\">\n";
						echo "\t<img src='video/previews/$id.png' class='videoThumb'>";
						echo "<div class=\"videoTitle\">$id</div>\n";
							echo "\t</a>\n";
							echo "</li>\n";
						}
							?>
					</ul>
				</div>
		</div>
			<div id="footer">
				<p><?php $f_contents = file("footers.txt"); $line = $f_contents[rand(0, count($f_contents) - 1)]; echo($line);?></p>
				<form id="ulform" enctype="multipart/form-data" action="upload.php" method="post">
					<input name="vidfile" id="vidfile" type="file" />
					<input type="submit" value="Upload" name="submit" id="submit" />
				</form>
			</div>
	</div>
</body>
</html>