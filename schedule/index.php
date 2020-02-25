<?php
$title = 'Hearings Calendar';
$subNavOpen = '#NavbarHearings';
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
?>
<script src="./date-format/date.format.js"></script>
<link rel="manifest" href="./manifest.json" />
<link href="./static/css/2.1fd2b905.chunk.css" rel="stylesheet">
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Hearings Schedule</h1>
<noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root"></div>
<p id="IEMessage">If you are seeing this message then it means that your browser doesn't work with our site. Please
    upgrade your <a href="https://www.google.ca/chrome/">browser for free</a>.</p>
<h2>Upcoming Hearings</h2>
<h3>February 24 -26:</h3>
<p style="margin-top: 0px; padding-top: 0px"><strong>(with the potential of Feb 27 if required)</strong></p>
<p>The hearings are set to run from 9:30 am to 4:00 pm. Those attending must go through a security check to be allowed in the hearing room. Please allow time for this.</p>
<p>No food or drinks other than water is allowed in the hearing room. There is a cloak room for coats, umbrellas etc.</p>
<p>These hearings are for participants’ opening statements and will provide an opportunity for participants (groups, organizations and individuals granted formal standing) to address the Commissioner and to set out the issues and matters that participants would like to see the Inquiry address.</p>
<p>These hearings will be held at 701 West Georgia Street, Vancouver, in Courtroom 801.</p>
<p><strong>Order of participants:</strong></p>
<ol>
    <li>Ministry of Attorney General - Gaming Policy Enforcement Branch and Ministry of Attorney General - Ministry of Finance - <a href="/files/OpeningStatement-OfGPEBAndTheMinistryOfFinance.pdf" target="_blank">Opening Statement</a> </li>
    <li>Government of Canada - <a href="/files/OpeningStatement-GovernmentOfCanada.pdf" target="_blank">Opening Statement</a></li>
    <li>Law Society of BC - <a href="/files/OpeningStatement-LawSocietyOfBC.pdf" target="_blank">Opening Statement</a></li>
    <li>British Columbia Government & Service Employees' Union</li>
    <li>British Columbia Lottery Corporation - <a href="/files/OpeningStatement-BCLC.pdf" target="_blank">Opening Statement</a></li>
    <li>Great Canadian Gaming Corporation - <a href="/files/OpeningStatement-GCGC.pdf" target="_blank">Opening Statement</a></li>
    <li>James Lightbody</li>
    <li>Robert Kroeker</li>
    <li>Gateway Casinos & Entertainment Ltd.</li>
    <li>Canadian Gaming Association</li>
    <li>Society of Notaries Public of BC - <a href="/files/OpeningStatement-SNPBC.pdf" target="_blank">Opening Statement</a></li>
    <li>BMW</li>
    <li>Coalition: Transparency International Canada (TI Canada) Canadians For Tax Fairness (C4TF)Publish What you Pay Canada (PWYP)</li>
    <li>BC Real Estate Association</li>
    <li>British Columbia Civil Liberties Association</li>
    <li>Canadian Bar Association, BC Branch and Criminal Defence Advocacy Society</li>
</ol>
<h3>May 25 – June 26:</h3>
<p>These hearings will deal with an overview of the money laundering topic and regulatory models, as well as attempts to quantify the extent of money laundering activity in British Columbia. These hearings may not occupy the full five-week period in the spring.</p>
<p>The courtroom for these hearings will be announced in the coming weeks.</p>
<h3>September 8 – December 22:</h3>
<p>The main hearings, in which Commission Counsel plan to address specific issues*, include:</p>
<ul>
    <li>Gaming, casinos, horseracing</li>
    <li>Real estate</li>
    <li>Professional services, including accounting and legal</li>
    <li>Corporate sector</li>
    <li>Financial institutions and money services</li>
    <li>Luxury goods</li>
    <li>Cryptocurrency</li>
    <li>Cash-based businesses</li>
    <li>Trade-based money laundering</li>
    <li>Other sectors</li>
    <li>Asset recovery</li>
    <li>Enforcement and regulation</li>
    <li>Government response</li>
    <li>Other jurisdictions’ approaches</li>
</ul>
<p>*These topics are not necessarily listed in sequence, and this hearing plan is subject to variation. Information about the dates on which specific topics will be addressed in the hearings will be posted on our website at: <a href="http://www.cullencommission.ca">www.cullencommission.ca</a>.</p>
<p>The courtroom for these hearings will be announced in the coming weeks.</p>
<script>
    ! function(f) {
        function e(e) {
            for (var r, t, n = e[0], o = e[1], u = e[2], l = 0, a = []; l < n.length; l++) t = n[l], Object.prototype.hasOwnProperty.call(c, t) && c[t] && a.push(c[t][0]), c[t] = 0;
            for (r in o) Object.prototype.hasOwnProperty.call(o, r) && (f[r] = o[r]);
            for (s && s(e); a.length;) a.shift()();
            return p.push.apply(p, u || []), i()
        }

        function i() {
            for (var e, r = 0; r < p.length; r++) {
                for (var t = p[r], n = !0, o = 1; o < t.length; o++) {
                    var u = t[o];
                    0 !== c[u] && (n = !1)
                }
                n && (p.splice(r--, 1), e = l(l.s = t[0]))
            }
            return e
        }
        var t = {},
            c = {
                1: 0
            },
            p = [];

        function l(e) {
            if (t[e]) return t[e].exports;
            var r = t[e] = {
                i: e,
                l: !1,
                exports: {}
            };
            return f[e].call(r.exports, r, r.exports, l), r.l = !0, r.exports
        }
        l.m = f, l.c = t, l.d = function(e, r, t) {
            l.o(e, r) || Object.defineProperty(e, r, {
                enumerable: !0,
                get: t
            })
        }, l.r = function(e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
                value: "Module"
            }), Object.defineProperty(e, "__esModule", {
                value: !0
            })
        }, l.t = function(r, e) {
            if (1 & e && (r = l(r)), 8 & e) return r;
            if (4 & e && "object" == typeof r && r && r.__esModule) return r;
            var t = Object.create(null);
            if (l.r(t), Object.defineProperty(t, "default", {
                    enumerable: !0,
                    value: r
                }), 2 & e && "string" != typeof r)
                for (var n in r) l.d(t, n, function(e) {
                    return r[e]
                }.bind(null, n));
            return t
        }, l.n = function(e) {
            var r = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return l.d(r, "a", r), r
        }, l.o = function(e, r) {
            return Object.prototype.hasOwnProperty.call(e, r)
        }, l.p = "./";
        var r = this.webpackJsonpcalendar = this.webpackJsonpcalendar || [],
            n = r.push.bind(r);
        r.push = e, r = r.slice();
        for (var o = 0; o < r.length; o++) e(r[o]);
        var s = n;
        i()
    }([])
</script>
<script src="./static/js/2.8a915f42.chunk.js"></script>
<script src="./static/js/main.767d0b72.chunk.js"></script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>