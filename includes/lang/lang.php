<?php
$lang = "";

if (isset($_GET["ln"])) {
    $val = htmlspecialchars($_GET["ln"]);
    if ($val == "chi") {
        $lang = "chi.html";
    } elseif ($val == "kor") {
        $lang = "kor.html";
    } elseif ($val == "fil") {
        $lang = "fil.html";
    } elseif ($val == "ara") {
        $lang = "ara.html";
    } elseif ($val == "fre") {
        $lang = "fre.html";
    } elseif ($val == "fas") {
        $lang = "fas.html";
    } elseif ($val == "pan") {
        $lang = "pan.html";
    } else {
        $lang = "eng.html";
    }
} else {
    $lang = "eng.html";
}

?>