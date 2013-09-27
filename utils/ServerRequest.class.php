<?php

/**
 * Description of Request
 *
 * @author Miroslav Milivojevic <miroslav.milivojevic@infobip.com>
 */
class ServerRequest {

    private $url;
    private $fields;        //array|string (hint: is_array())
    private $fieldsNo;      //in case that $fields are not array
    private $headers;

    function __construct() {
        $this->url = Prefs::getApiUrl();
    }

    public function postRequest() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (is_array($this->fields)) {
            curl_setopt($ch, CURLOPT_POST, count($this->fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_dataArrayToUrl());
        } else {
            curl_setopt($ch, CURLOPT_POST, $this->fieldsNo);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->fields);
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * URL-ify data for POST/GET
     * @param array $data array od data to be parsed
     * @return string url fields
     */
    private function _dataArrayToUrl(array $data = null) {
        if (empty($data))
            $data = $this->fields;

        foreach ($data as $key => $value) {
            $fieldsUrl .=urlencode($key) . '=' . urlencode($value) . '&';
        }
        //removes last ampersent '&' at string
        rtrim($fieldsUrl, '&');

        return $fieldsUrl;
    }

    /**
     * Set request data
     * @param mixed $fields array of fields or url-ify data
     * @param type $fieldsNo number of fields, if $fields is type of string
     */
    public function setFields($fields, $fieldsNo = null) {
        $this->fields = $fields;
        $this->fieldsNo = $fieldsNo;
    }

    /**
     * Set request URL
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * Append to url (without liding slash "/", ex: transaction/)
     * @param string $url
     */
    public function appendToUrl($url) {
        $this->url .= $url;
    }

    /**
     * Set request headers
     * @param array $headers
     */
    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    /**
     * GET request
     * 
     * @return json
     */
    public function getRequest() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->_generateUrl());
        $result = curl_exec($ch);
        $inf = curl_getinfo($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Append fields to URL
     * 
     * @return string $url 
     */
    private function _generateUrl() {
        $url;
        if (is_array($this->fields)) {
            $url = $this->url . '?' . $this->_dataArrayToUrl();
        } else {
            $url = $this->url . '?' . $this->fields;
        }
        //removes questuin mark '?' et the end of url, if ther is no params
        rtrim($url, '?');
        return $url;
    }

}


