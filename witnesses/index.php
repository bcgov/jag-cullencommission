<?php
$title = 'Witnesses';
$subNavOpen = '#NavbarHearings';
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
?>
<script src="./date-format/date.format.js"></script>
<link rel="manifest" href="./manifest.json" />
<link href="./static/css/main.701948e5.chunk.css" rel="stylesheet">
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Witnesses</h1>
<noscript>You need to enable JavaScript to run this app.</noscript>
<p style="font-size: 0.85rem; text-align: center">If you know the name of the witness, please click on the first letter of their surname.<br /> 
You will see their name listed. If you click on that name, the date(s) of testimony are listed.</p>
<p style="font-size: 0.85rem; text-align: center">If you would like to see the schedule of witnesses by date please <a href="/schedule/">click here</a>.</p>
<div id="root"></div>
<p id="IEMessage">If you are seeing this message then it means that your browser doesn't work with our site. Please upgrade your <a href="https://www.google.ca/chrome/">browser for free</a>.</p>
<script>!function (i) { function e(e) { for (var r, t, n = e[0], o = e[1], u = e[2], f = 0, l = []; f < n.length; f++)t = n[f], Object.prototype.hasOwnProperty.call(p, t) && p[t] && l.push(p[t][0]), p[t] = 0; for (r in o) Object.prototype.hasOwnProperty.call(o, r) && (i[r] = o[r]); for (s && s(e); l.length;)l.shift()(); return c.push.apply(c, u || []), a() } function a() { for (var e, r = 0; r < c.length; r++) { for (var t = c[r], n = !0, o = 1; o < t.length; o++) { var u = t[o]; 0 !== p[u] && (n = !1) } n && (c.splice(r--, 1), e = f(f.s = t[0])) } return e } var t = {}, p = { 1: 0 }, c = []; function f(e) { if (t[e]) return t[e].exports; var r = t[e] = { i: e, l: !1, exports: {} }; return i[e].call(r.exports, r, r.exports, f), r.l = !0, r.exports } f.m = i, f.c = t, f.d = function (e, r, t) { f.o(e, r) || Object.defineProperty(e, r, { enumerable: !0, get: t }) }, f.r = function (e) { "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 }) }, f.t = function (r, e) { if (1 & e && (r = f(r)), 8 & e) return r; if (4 & e && "object" == typeof r && r && r.__esModule) return r; var t = Object.create(null); if (f.r(t), Object.defineProperty(t, "default", { enumerable: !0, value: r }), 2 & e && "string" != typeof r) for (var n in r) f.d(t, n, function (e) { return r[e] }.bind(null, n)); return t }, f.n = function (e) { var r = e && e.__esModule ? function () { return e.default } : function () { return e }; return f.d(r, "a", r), r }, f.o = function (e, r) { return Object.prototype.hasOwnProperty.call(e, r) }, f.p = "./"; var r = this.webpackJsonpfrontend = this.webpackJsonpfrontend || [], n = r.push.bind(r); r.push = e, r = r.slice(); for (var o = 0; o < r.length; o++)e(r[o]); var s = n; a() }([])</script>
        <script src="./static/js/2.061d23df.chunk.js"></script>
        <script src="./static/js/main.365fe62f.chunk.js"></script>
<p>The Commission plans to post its witness lists on its website in advance of the witnesses testifying. These lists will be subject to modification if Commission Counsel determines that a witness is unnecessary or that an additional witness is required.</p>
<p>Additional information about the witness lists will be provided in due course.</p>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>