<?php


define('__PAYMENTAPI_LIBRARY_PATH__', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

function __paymentapi_autoloader($class) {
    $paths = array('mpayapi/db', 'mpayapi/utils');
    foreach ($paths as $path) {
        $fileName = __PAYMENTAPI_LIBRARY_PATH__ . $path . '/' . $class . '.class.php';
        if (is_file($fileName))
            require_once $fileName;
    }
}

spl_autoload_register('__paymentapi_autoloader');
require_once './db/connect.php';

$receiver = $_GET['receiver'];
$sender = $_GET['sender'];
$when = $_GET['when'];
$text = $_GET['text'];

$db = dbConnect();
$query = sprintf("INSERT INTO  `badgermm_infobip`.`log` (
`sender` , `receiver` , `when` , `textmsg`) VALUES ('%s', '%s', '%s', '%s')", 
        mysql_real_escape_string($sender), 
        mysql_real_escape_string($receiver), 
        mysql_real_escape_string($when), 
        mysql_real_escape_string($text));

$result = mysql_query($query, $db);
if (!$result) {
    throw new Exception('Could not enter data: ' . mysql_error());
} else {
    echo "OK insert";
}
//$content = explode(' ', $text);

$push = new Push($sender, 111);
$result = $push->executePush();

var_dump($result);
