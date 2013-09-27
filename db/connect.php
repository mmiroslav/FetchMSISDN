<?php

function dbConnect() {
    $ini = parse_ini_file("prefs.ini");

    $username = $ini['username'];
    $password = $ini['password'];
    $hostname = $ini['host'];
    $dbName = $ini['dbName'];

    //connection to the database
    $db = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");

    //select a database to work with
    $selected = mysql_select_db($dbName, $db) or die("Could not select examples");
    return $db;
}