<?php
session_start();
if (isset($_SESSION["adminuser"])) {

    $_SESSION["adminuser"] = null;
    session_destroy();

    echo ("success");
}
