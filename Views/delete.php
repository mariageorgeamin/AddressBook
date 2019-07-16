<?php
require_once '../autoload.php';
$id = intval($_GET['cid']);
$contact = new Contacts();
$db = new MYSQLHandler("contacts");
$contact = $db->delete(__PRIMARY_KEY__, $id);
if ($contact) {
    header("Location: http://localhost/AddressBook/index.php");
    $_SESSION["errorType"] = "success";
    $_SESSION["errorMsg"] = "Contact deleted successfully.";
} else {
    $_SESSION["errorType"] = "danger";
    $_SESSION["errorMsg"] = "Failed to delete contact.";
}