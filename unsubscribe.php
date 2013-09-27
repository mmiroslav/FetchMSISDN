<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jsonString = file_get_contents('php://input');
        $json = json_decode($jsonString, false);
        $deviceId = $json->{'device_id'};
        
        require_once './db/connect.php';

        $db = dbConnect();
        $query = sprintf("DELETE FROM `badgermm_infobip`.`user` WHERE `userid` = '%s'",
                mysql_real_escape_string($deviceId)
        );

        $result = mysql_query($query, $db);
        if (!$result) {
            throw new Exception('Could not delete data: '. mysql_error());
        }
    }
?>
