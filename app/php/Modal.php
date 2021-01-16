<?php

/**
 * This is file works as the application entry point.
 * It pulls all back-end functionality files to one location.
 *
 */

require_once "templates.php";
require_once "config/databaseConfiguration.php";
require_once "classes/_classAutoLoader.php";
require_once "config/functions.php";
require_once "config/constants.php";
require_once "config/path.php";

//create a global User
/**
 * @example  $moderator = new AdminUser();
 *
 */


$fields = [
    "firstName",
    "lastName",
    "otherName",
    "gender",
    "nationalId",
    "Email",
    "userName",
    "password",
    "Address",
    "city",
    "role",
    "status",
    "logID"
];

$values = [
    "firstName",
    "lastName",
    "otherName",
    "gender",
    "nationalID",
    "email1",
    "user1",
    "password",
    "Address",
    "city",
    "role",
    "status",
    "1"
];

$combined  = array_combine($fields, $values);

$admin = new User();

$combined  = array_combine($fields, $values);

$table = "tbl_users";
$fields = array(
    "firstName",
);
$order_by = "firstName";
$order_set = "ASC";
$offset = 0;
$reference = [
    array("UUID", $id),
];

$admin->database_read_by_ref($table,$fields,null,null,0,null);


