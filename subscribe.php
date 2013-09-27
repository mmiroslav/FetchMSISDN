<?php
    $jsonString = file_get_contents('php://input');
    $json = json_decode($jsonString, false);
    
    $deviceId = $json->{'device_id'};
    $notificationUrl = "";
    if(array_key_exists('push_url', $json)) {
        $notificationUrl = $json->{'push_url'};
    }
    
    echo $jsonString . "\n" . $deviceId . "\n" . $notificationUrl;
    
    require_once './db/connect.php';
    
    $db = dbConnect();
    $query = sprintf("INSERT INTO `badgermm_infobip`.`user` (`userid`, `url`)
                      VALUES ('%s', '%s')
                      ON DUPLICATE KEY UPDATE
                      url='%s'",
            mysql_real_escape_string($deviceId),
            mysql_real_escape_string($notificationUrl),
            mysql_real_escape_string($deviceId)
    );

    $result = mysql_query($query, $db);
    if (!$result) {
        throw new Exception('Could not enter data: '. mysql_error());
    }
?>
