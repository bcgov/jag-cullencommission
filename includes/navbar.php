<?php
$currentCSS = ' CurrentPage';
?>
<div id="MainContent">
    <div id="Navbar">
        <h1 id="MenuDisplay" onclick="displayNavbar()"><i class="fas fa-bars"></i></h1>
        <div id="NavbarContainer">
            <div id="NavbarList">
                <a href="/" class="NavbarButton<?php if (isset($navHome) && $navHome) { echo $currentCSS; } ?>">Home</a>
                <a href="/comm-statements/" class="NavbarButton<?php if (isset($navComState) && $navComState) { echo $currentCSS; } ?>">Commissioner’s Statements</a>
                <a href="/inquiry-team/" class="NavbarButton<?php if (isset($navInqTeam) && $navInqTeam) { echo $currentCSS; } ?>">Inquiry Team</a>
                <a class="NavbarButton HasSubNav" id="NavbarLegislation"><i class="fas fa-chevron-down"></i> Mandate</a>
                <div class="SubNavList" id="NavbarLegislationSubNav">
                    <p><a href="/tor/"<?php if (isset($navTor) && $navTor) { echo ' class="' . $currentCSS . '"'; } ?>>Terms of Reference</a></p>
                    <p><a href="/pub-inq-act/"<?php if (isset($navPubInqAct) && $navPubInqAct) { echo ' class="' . $currentCSS . '"'; } ?>>Public Inquiry Act</a></p>
                </div>
                <a class="NavbarButton HasSubNav" id="NavbarHearings"><i class="fas fa-chevron-down"></i> Hearings</a>
                <div class="SubNavList" id="NavbarHearingsSubNav">
                    <p><a href="/schedule/"<?php if (isset($navSchedule) && $navSchedule) { echo ' class="' . $currentCSS . '"'; } ?>>Schedule</a></p>
                    <p><a href="/witnesses/"<?php if (isset($navWitnesses) && $navWitnesses) { echo ' class="' . $currentCSS . '"'; } ?>>Witnesses</a></p>
                    <p><a href="/transcripts/"<?php if (isset($navTranscripts) && $navTranscripts) { echo ' class="' . $currentCSS . '"'; } ?>>Transcripts</a></p>
                    <p><a href="/exhibits/"<?php if (isset($navExhibits) && $navExhibits) { echo ' class="' . $currentCSS . '"'; } ?>>Exhibits</a></p>
                </div>
                <a href="/rulings/" class="NavbarButton<?php if (isset($navRulings) && $navRulings) { echo $currentCSS; } ?>">Rulings</a>
                <a href="/participants/" class="NavbarButton<?php if (isset($navParticipants) && $navParticipants) { echo $currentCSS; } ?>">Participants</a>
                <a href="/prac-pro/" class="NavbarButton<?php if (isset($navPracPro) && $navPracPro) { echo $currentCSS; } ?>">Practice &amp; Procedure</a>
                <a class="NavbarButton HasSubNav" id="NavbarRepPub"><i class="fas fa-chevron-down"></i> Reports &amp; Publications</a>
                <div class="SubNavList" id="NavbarRepPubSubNav">
                    <p><a href="/com-rep/"<?php if (isset($navComRep) && $navComRep) { echo ' class="' . $currentCSS . '"'; } ?>>Commission Reports</a></p>
                    <p><a href="/other-reports/"<?php if (isset($navOtherReports) && $navOtherReports) { echo ' class="' . $currentCSS . '"'; } ?>>Other Reports</a></p>
                </div>
                <a class="NavbarButton HasSubNav" id="NavbarWebcast"><i class="fas fa-chevron-down"></i> Webcast</a>
                <div class="SubNavList" id="NavbarWebcastSubNav">
                    <p><a href="/webcast-live/"<?php if (isset($navWebcastLive) && $navWebcastLive) { echo ' class="' . $currentCSS . '"'; } ?>>Live Webcast</a></p>
                    <p><a href="/webcast-archive/"<?php if (isset($navWebcastAchive) && $navWebcastAchive) { echo ' class="' . $currentCSS . '"'; } ?>>Webcast Archives</a></p>
                </div>
                <a href="/media/" class="NavbarButton<?php if (isset($navMedia) && $navMedia) { echo $currentCSS; } ?>">Media</a>
                <a href="/faqs/" class="NavbarButton<?php if (isset($navFaqs) && $navFaqs) { echo $currentCSS; } ?>">FAQs</a>
                <a href="/public-meetings/" class="NavbarButton<?php if (isset($navPublicMeetings) && $navPublicMeetings) { echo $currentCSS; } ?>">Public Meetings</a>
                <a href="/contact/" class="NavbarButton<?php if (isset($navContact) && $navContact) { echo $currentCSS; } ?>">Contact</a>
                <div style="padding: 0px 10px 0px 20px">
                    <div class="gcse-searchbox-only">
                        <script async src="https://cse.google.com/cse.js?cx=010889142485745883449:q3vywk2gtj9"></script>
                        <div class="gcse-search"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="Content">