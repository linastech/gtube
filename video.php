<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>gTube</title>
	<link href="media/css/darkstyle.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="media/css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="media/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="media/js/jquery-ui-1.10.2.js"></script>
	<script type="text/javascript" src="media/js/moment.js"></script>
	<script type="text/javascript" src="media/js/video_player.js"></script>
	<script type="text/javascript" src="media/js/main.js"></script>
    </head>
	
	
<body>
	<div id="container">
		<header>
			<a href="/">gTube</a>
			<form id="search">
			<input id="searchbar" type="text" name="Keyword" autofocus/>
			<input id="searchb" type="submit" value="Search" />
			</form>
		</header>

		<div id="wrapper">
			<div id="title">/g/ Is Filled with Idiots, Starring OP</div>
			<div id="videocont">
			<div id="video" class="v-container" style="z-index: 999;top: 0px;margin: 0px;">
				<div class="v-wrapper">
				<div class="v-playButton"></div>
							<?php
								$id = $_GET["id"];
								if (file_exists(getcwd()."/video/".$id.".webm")) {
						echo "<video  poster=\"video/previews/$id.png\"  id=\"videoPlayer\">\n";
						echo "\t<source src=\"video/$id.mp4\" type=\"video/mp4\">\n";
						echo "\t<source src=\"video/$id.webm\" type=\"video/webm\">\n";
						echo "\tYour browser does not support the video tag.\n";
						echo "\t</video>\n";
								}
								else {
									echo "<img src='media/images/video-not-found.png'>\n";
								}
							?>
				</div>
				<div class="v-c-container">
				<div class="v-c-progress-bg">
					<div class="v-c-progress"></div>
					<div class="v-c-buffer"></div>
				</div>
				<div class="displayInline v-c-play"></div>
				<div class="displayInline v-c-length">
					<span class="current">0:00</span> / <span class="total">0:38</span>
				</div>
				<div class="displayInline v-c-volume-container">
					<div class="v-c-volume"></div>
				</div>
				<div class="v-c-volume-controller displayInline">
					<div class="v-c-volume-bg"></div>
					<div class="v-c-volume-slider"></div>
				</div>
				<div class="displayInline v-c-fullScreen"></div>
				<div class="displayInline v-c-hd"></div>
				</div>
			</div>
			</div>
			<div id="desc">
			<p>
				<div id="uploaded">Uploaded on: 11/7/2013, Filesize: 2KB</div>
				This is a description for the video. Stuff is said down here. <a href="#">This is a link</a> More text is here. Fuck Lorem.
			</p>
			<form id="tools">
				<input id="sage" type="submit" value="Sage" />
				<input id="report" type="submit" value="Report" />
				<input id="download" type="submit" value="Download" />
			</form>
			</div>
			<div id="comments">
			<div class="comment">>First!<div class="user">Posted By: Anon, On 11/31/13 1:13:03pm</div></div>
			<div class="comment">Fuck Off<div class="user">Posted By: Anon, On 11/30/13 1:13:03pm</div></div>
			<div class="comment">This site layout is the shit<div class="user">Posted By: Anon, On 11/13/13 1:13:03pm</div></div>
			<div class="comment">FibreChips is awesome!<div class="user">Posted By: !5RRtZawAKg, On 11/11/13 1:13:03pm</div></div>	
			<div class="comment">I'd just like to interject for moment. What you're refering to as Linux, is in fact, GNU/Linux, or as I've recently taken to calling it, GNU plus Linux. Linux is not an operating system unto itself, but rather another free component of a fully functioning GNU system made useful by the GNU corelibs, shell utilities and vital system components comprising a full OS as defined by POSIX.Many computer users run a modified version of the GNU system every day, without realizing it. Through a peculiar turn of events, the version of GNU which is widely used today is often called Linux, and many of its users are not aware that it is basically the GNU system, developed by the GNU Project.There really is a Linux, and these people are using it, but it is just a part of the system they use. Linux is the kernel: the program in the system that allocates the machine's resources to the other programs that you run. The kernel is an essential part of an operating system, but useless by itself; it can only function in the context of a complete operating system. Linux is normally used in combination with the GNU operating system: the whole system is basically GNU with Linux added, or GNU/Linux. All the so-called Linux distributions are really distributions of GNU/Linux!		<div class="user">Posted By: RMS, On 1/6/60 1:13:03pm</div></div>
			</div>
				<div id="footer">
					<p><?php $f_contents = file("footers.txt"); $line = $f_contents[rand(0, count($f_contents) - 1)]; echo($line);?></p>
					<form id="ulform" enctype="multipart/form-data" action="upload.php" method="post">
						<input name="vidfile" id="vidfile" type="file" />
						<input type="submit" value="Upload" name="submit" id="submit" />
					</form>
				</div>
		</div>
	</div>
    </body>
</html>
