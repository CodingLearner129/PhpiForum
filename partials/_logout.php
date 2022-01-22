<?php
    session_start();
    echo "Logging out in progress... Please wait...";
    session_destroy();
    header("Location: /forum");
?>