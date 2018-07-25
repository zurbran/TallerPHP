<?php
    session_start();
    session_destroy();
    $url = 'http://localhost/grupo30/index.php';
    header( "Location: $url" );
?>