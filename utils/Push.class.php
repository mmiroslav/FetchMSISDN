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
        $jsonBody = "{ 
                    \"sentType\":\"application\",
                    \"mimeType\":\"text/plain\",
                    \"OSTypes\":[\"iOS\",\"Android\"],
                    \"notificationMessage\":\"$this->message\",
                    \"iOSData\":{\"alert\":\"Your phone number\"}, 
                    \"androidData\": {}}";
        
        $request = new ServerRequest($url);
        $request->setFields($jsonBody);
        $request->setHeaders($this->prepareHeaders());
        $result = $request->postRequest();
        
    }

    private function authEncode() {
        $user = $this->ini['pushuser'];
        $pass = $this->ini['pushpass'];

        return base64_encode($user . ':' . $pass);
    }
    /**
     * Return headers
     * @return array 
     */
    private function prepareHeaders() {
        $auth = $this->authEncode();
        return array(
            "Authorization" => "Basic $auth",
            "Content-Type" => "application/json",
            );
    }

}
