<?php
$navHome = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/lang/lang.php');

?>
<div class="Aside2Col">
    <div class="Aside">
        <p class="AsideTitle">Welcome</p>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/lang/welcome_' . $lang);
?>
    </div>
    <div class="LatestEvents">
        <p class="LatestEventsTitle">Latest Information</p>
        <div class="LatestEventsContainer">
            <div class="LatestEvent">
                <p class="LatestEventDesc">November 26, 2020<br /><strong>Ruling</strong><br /><a href="/rulings/">Ruling on Admissibility of Transcripts – Ruling #18</a></p>
            </div>
            <div class="LatestEvent">
                <p class="LatestEventDesc">November 19, 2020<br /><strong>Ruling</strong><br /><a href="/rulings/">Application Pursuant to Rule 60 – Ruling #17</a></p>
            </div>
            <div class="LatestEvent">
                <p class="LatestEventDesc">November 16, 2020<br /><strong>News Release</strong><br /><a href="/media?open=22/">Interim Report Submitted</a></p>
            </div>
        </div>
    </div>
</div>
<br class="ClearFloats" />
<div class="ButtonBar">
    <a href="demo.php?ln=fre" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">French</button></a>
    <a href="demo.php?ln=chi" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Chinese</button></a>
    <a href="demo.php?ln=pan" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Punjabi</button></a>
    <a href="demo.php?ln=ara" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Arabic</button></a>
    <a href="demo.php?ln=fas" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Farsi</button></a>
    <a href="demo.php?ln=kor" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Korean</button></a>
    <a href="demo.php?ln=fil" class="LanguageLink"><button class="Button TonedDownButton SmallerButtonLabel ButtonBarButton LanguageButton">Filipino</button></a>
</div>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/lang/home_' . $lang);
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>