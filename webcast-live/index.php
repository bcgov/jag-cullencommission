<?php
$title = 'Live Webcast';
$subNavOpen = '#NavbarWebcast';
$navWebcastLive = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Live Webcast</h1>
<?php
$hearingsFile = file_get_contents('../data/hearings.json');
$hearings = json_decode($hearingsFile, true);
$found = false;
for ($i = 0; $i < count($hearings['hearings']); $i++) {
    if (date('Y-m-d', ($hearings['hearings'][$i][0]) / 1000) == date('Y-m-d')) {
        if ($hearings['hearings'][$i][1]['isCancelled'] != 1) {
            $found = true;
        }
        break;
    }
}
if ($found) {
    echo '<p style="text-align: center; font-size: 2rem"><strong>Witness Exclusion Order In Effect.</strong></p><p style="text-align: center"><em>If you have been notified that you will be testifying, the Commissioner has directed that, unless you have permission, you may not view hearings, read transcripts or review exhibits for the hearings beginning October 26, 2020, onwards.</em></p><div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://www.ustream.tv/embed/23995188?autoplay=true" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe></div><p style="text-align: center; font-weight: bold">If you are having a problem accessing the main channel for the livestream of the hearings, <a href="backup/">please click here</a>.</p>' . "\n";
} else {
    echo '<p>No hearings are scheduled today. Please check <a href="/schedule/">the hearings schedule</a> for more information on the timing of hearings.</p>';
}
?>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>