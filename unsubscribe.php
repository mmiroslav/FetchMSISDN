<?php
    $json = json_decode($_POST, true);
    $deviceId = $json["device_id"];
    
    require_once './db/connect.php';
    
    $db = dbConnect();
    $query = sprintf("DELETE FROM user WHERE 'userid' = '%s'",
            mysql_real_escape_string($deviceId)
    );

    $result = mysql_query($query, $db);
    if (!$result) {
        throw new Exception('Could not delete data: '. mysql_error());
    }
?>
