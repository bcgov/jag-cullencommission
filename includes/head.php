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
    <meta charset="UTF-8">
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
