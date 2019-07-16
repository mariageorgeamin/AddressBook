<?php
session_start();

define('DB_DRIVER', 'mysql');
define("__HOST__", "localhost");
define("__USER__", "root");
define("__PASS__", "Iti@os39");
define("__DB__", "contacts");
define("__DEBUG_MODE__", 0);
define("__PRIMARY_KEY__", "id");
define("__TABLE__", "contacts");
define("__RECORDS_PER_PAGE__", 5);

if ($_SESSION["errorType"] != "" && $_SESSION["errorMsg"] != "") {
    $ERROR_TYPE = $_SESSION["errorType"];
    $ERROR_MSG = $_SESSION["errorMsg"];
    $_SESSION["errorType"] = "";
    $_SESSION["errorMsg"] = "";
} else {
    $ERROR_TYPE = $_SESSION["errorType"];
    $ERROR_MSG = $_SESSION["errorMsg"];
}
