<?php

require_once './ServerRequest.class.php';

/**
 * Description of Push
 *
 * @author mmilivojevic
 */
class Push {
    private $message;
    private $deviceId;
    
    private $ini;
    
    function __construct($message, $deviceId) {
        $this->message = $message;
        $this->deviceId = $deviceId;
        
        $this->ini = parse_ini_file("../db/prefs.ini");
    }
    
    public function executePush() {
        $appId = $this->ini['applicationId'];
        $url = "https://pushapi.infobip.com/3/application/$appId/message";
        $request = new ServerRequest($url);
    }
    
    private function authEncode() {
        $user = $this->ini['pushuser'];
        $pass = $this->ini['pushpass'];
        
        return base64_encode($user.':'.$pass);
    }

}
