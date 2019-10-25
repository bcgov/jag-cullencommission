<div id="MainContent">
    <div id="Navbar">
        <h1 id="MenuDisplay" onclick="displayNavbar()"><i class="fas fa-bars"></i></h1>
        <div id="NavbarContainer">
            <div id="NavbarList">
                <!-- <a href="#" class="NavbarLink"><div class="NavbarItem HasSubNav" id="NavbarTest">Link 01</div></a>
                <div class="SubNavList" id="NavbarTestSubNav">
                    <p><a href="#">Sub-Link 01</a></p>
                    <p><a href="#">Sub-Link 02</a></p>
                    <p><a href="#">Sub-Link 03</a></p>
                </div> -->
                <a href="/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarHome; ?>" id="NavbarHome">Home</div></a>
                <a href="/introductory-statement/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarIntroState; ?>" id="NavbarIntroState">Introductory Statement</div></a>
                <a href="/inquiry-team/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarTeam; ?>" id="NavbarTeam">Inquiry Team</div></a>
                <a href="/participants/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarParticipants; ?>" id="NavbarParticipants">Participants</div></a>
                <a href="/public-meetings-information/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarMeetings; ?>" id="NavbarMeetings">Public Meetings</div></a>
                <a href="/about/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarAbout; ?>" id="NavbarAbout">About</div></a>
                <a href="/contact/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarContact; ?>" id="NavbarContact">Contact</div></a>
                <a href="/media-inquires/" class="NavbarLink"><div class="NavbarItem <?php echo $navbarMedia; ?>" id="NavbarMedia">Media</div></a>
            </div>
        </div>
    </div>
    <div id="Content">
