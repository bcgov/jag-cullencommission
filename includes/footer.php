            <div id="Footer">
                <p>&copy; 2019 Cullen Commission</p>
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
    //     $('#NavbarHome').toggleClass('active');
    // });
});

</script>
</body>
</html>