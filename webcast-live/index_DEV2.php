<?php
$title = 'Live Webcast';
$subNavOpen = '#NavbarWebcast';
$navWebcastLive = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Live Webcast</h1>
<!-- <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://vimeo.com/event/62773/" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div> -->
<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/421725295" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>