<?php
$title = 'Transcripts';
$subNavOpen = '#NavbarHearings';
$navTranscripts = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
?>
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<script src="./date-format/date.format.js"></script>
<link rel="stylesheet" href="/css/main.css">
<link rel="manifest" href="./manifest.json" />
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Transcripts</h1>
<p>Available transcripts of the public hearings are posted here. (The exception to this would be in the event of special circumstances where there is a need for protective measures for a witness, document or evidence. This could include measures such as a publication ban, sealing materials or proceeding in a closed (non-public) hearing.)</p>
<h2>2020 Transcripts</h2>
<div id="root"></div>
<p id="IEMessage">If you are seeing this message then it means that your browser doesn't work with our site.
    Please upgrade your <a href="https://www.google.ca/chrome/">browser for free</a>.</p>
<h2>2019 Transcripts</h2>
<p><a href="/files/2019-12-19-Application-Hearing-Transcript.pdf" target="_blank">Application Hearing – Transcript from Dec 19, 2019</a></p>
<p><a href="/files/2019-10-08-Application-Hearing-Transcript.pdf" target="_blank">Oral Hearing Participants Standing – Transcript from Oct 18, 2019</a></p>
<script>
    ! function(e) {
        function r(r) {
            for (var n, f, l = r[0], i = r[1], a = r[2], c = 0, s = []; c < l.length; c++) f = l[c], Object.prototype.hasOwnProperty.call(o, f) && o[f] && s.push(o[f][0]), o[f] = 0;
            for (n in i) Object.prototype.hasOwnProperty.call(i, n) && (e[n] = i[n]);
            for (p && p(r); s.length;) s.shift()();
            return u.push.apply(u, a || []), t()
        }

        function t() {
            for (var e, r = 0; r < u.length; r++) {
                for (var t = u[r], n = !0, l = 1; l < t.length; l++) {
                    var i = t[l];
                    0 !== o[i] && (n = !1)
                }
                n && (u.splice(r--, 1), e = f(f.s = t[0]))
            }
            return e
        }
        var n = {},
            o = {
                1: 0
            },
            u = [];

        function f(r) {
            if (n[r]) return n[r].exports;
            var t = n[r] = {
                i: r,
                l: !1,
                exports: {}
            };
            return e[r].call(t.exports, t, t.exports, f), t.l = !0, t.exports
        }
        f.m = e, f.c = n, f.d = function(e, r, t) {
            f.o(e, r) || Object.defineProperty(e, r, {
                enumerable: !0,
                get: t
            })
        }, f.r = function(e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
                value: "Module"
            }), Object.defineProperty(e, "__esModule", {
                value: !0
            })
        }, f.t = function(e, r) {
            if (1 & r && (e = f(e)), 8 & r) return e;
            if (4 & r && "object" == typeof e && e && e.__esModule) return e;
            var t = Object.create(null);
            if (f.r(t), Object.defineProperty(t, "default", {
                    enumerable: !0,
                    value: e
                }), 2 & r && "string" != typeof e)
                for (var n in e) f.d(t, n, function(r) {
                    return e[r]
                }.bind(null, n));
            return t
        }, f.n = function(e) {
            var r = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return f.d(r, "a", r), r
        }, f.o = function(e, r) {
            return Object.prototype.hasOwnProperty.call(e, r)
        }, f.p = "./";
        var l = this.webpackJsonpfrontend = this.webpackJsonpfrontend || [],
            i = l.push.bind(l);
        l.push = r, l = l.slice();
        for (var a = 0; a < l.length; a++) r(l[a]);
        var p = i;
        t()
    }([])
</script>
<script src="./static/js/2.11b967fc.chunk.js"></script>
<script src="./static/js/main.4f7ed46d.chunk.js"></script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>