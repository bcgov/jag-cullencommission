<?php
header("Cache-Control: no-cache, no-store, must-revalidate, private"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header("X-XSS-Protection: 1");
header('X-Frame-Options: DENY');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157960287-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-157960287-1');
    </script>
    <meta charset="UTF-8">
    <link rel="icon" href="data:;base64,Q3VsbGVuIENvbW1pc3Npb24=">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/6bee0296c4.js" crossorigin="anonymous"></script>
    <script src="/js/jquery.js"></script>
    <link rel="stylesheet" href="/css/main.css" type="text/css">
    <title><?php
            if (isset($title)) {
                echo $title . " - Cullen Commission";
            } else {
                echo "Cullen Commission";
            }

            ?></title>