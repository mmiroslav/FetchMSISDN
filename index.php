<?php


define('__PAYMENTAPI_LIBRARY_PATH__', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

function __paymentapi_autoloader($class) {
    $paths = array('fetch-msisdn/utils');
    foreach ($paths as $path) {
        $fileName = __PAYMENTAPI_LIBRARY_PATH__ . $path . '/' . $class . '.class.php';
        if (is_file($fileName))
            require_once $fileName;
    }
}

spl_autoload_register('__paymentapi_autoloader');
require_once './db/connect.php';

?>
<a href="mnocallback.php?receiver=385664545&sender=1112223336&when=12312313&text=Nekitexy">Send SMS</a>
