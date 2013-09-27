<?php
    $json = json_decode($_POST, true);
    $deviceId = $json["device_id"];
    $notificationUrl = $json["push_url"];
    
    require_once './db/connect.php';
    
    $db = dbConnect();
    $query = sprintf("INSERT INTO user 
                      VALUES ('%s', '%s')",
            mysql_real_escape_string($deviceId),
            mysql_real_escape_string($notificationUrl)
            );

    $result = mysql_result($query, $db);
    if (!$result) {
        throw new Exception('Could not enter data: '. mysql_error());
    }
?>