            <div id="Footer">
                <p><a href="/" class="FooterNavbarLink">Home</a> - <a href="/introductory-statement/" class="FooterNavbarLink">Introductory Statement</a> - <a href="/inquiry-team/" class="FooterNavbarLink">Inquiry Team</a> - <a href="/participants/" class="FooterNavbarLink">Participants</a> - <a href="/public-meetings-information/" class="FooterNavbarLink">Public Meetings</a> - <a href="/about/" class="FooterNavbarLink">About</a> - <a href="/contact/" class="FooterNavbarLink">Contact</a> - <a href="/media-inquires/" class="FooterNavbarLink">Media</a></p>
                <p class="FooterDisclaimer"><a href="/files/DisclaimerV.4-22-Oct-2019-002.pdf" target="_blank">Disclaimer/Copyright/Privacy Statement</a></p>
                <p style="margin-bottom: 0px">&copy; 2019 Cullen Commission</p>
            </div>
            </div>
            </div>
            <script>
                let isDisplayed = false;

                function displayNavbar() {
                    let navbarContainer = document.getElementById('NavbarContainer');
                    if (isDisplayed) {
                        navbarContainer.style.maxHeight = '0px';
                    } else {
                        navbarContainer.style.maxHeight = navbarContainer.scrollHeight + 'px';
                    }
                    isDisplayed = !isDisplayed;
                }

                $(document).ready(function() {
                    // SHOWS HOW TO OPEN A SUB-NAV
                    // let time = 250;
                    // $('#NavbarHome').click(function() {
                    //     if ($('#NavbarHomeSubNav').length) {
                    //         $('#NavbarHomeSubNav').slideToggle(time);
                    //     }
                    //     $('#NavbarHome').toggleClass(activeClass);
                    // });
                    let time = 250;
                    let activeClass = 'active';
                    $('#NavbarComState').click(function() {
                        if ($('#NavbarComStateSubNav').length) {
                            $('#NavbarComStateSubNav').slideToggle(time);
                        }
                        $('#NavbarComState').toggleClass(activeClass);
                    });
                    $('#NavbarLegislation').click(function() {
                        if ($('#NavbarLegislationSubNav').length) {
                            $('#NavbarLegislationSubNav').slideToggle(time);
                        }
                        $('#NavbarLegislation').toggleClass(activeClass);
                    });
                    $('#NavbarHearings').click(function() {
                        if ($('#NavbarHearingsSubNav').length) {
                            $('#NavbarHearingsSubNav').slideToggle(time);
                        }
                        $('#NavbarHearings').toggleClass(activeClass);
                    });
                    $('#NavbarRepPub').click(function() {
                        if ($('#NavbarRepPubSubNav').length) {
                            $('#NavbarRepPubSubNav').slideToggle(time);
                        }
                        $('#NavbarRepPub').toggleClass(activeClass);
                    });
                    $('#NavbarWebcast').click(function() {
                        if ($('#NavbarWebcastSubNav').length) {
                            $('#NavbarWebcastSubNav').slideToggle(time);
                        }
                        $('#NavbarWebcast').toggleClass(activeClass);
                    });
                });
            </script>
            </body>

            </html>