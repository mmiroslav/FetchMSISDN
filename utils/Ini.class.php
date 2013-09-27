<?php

/**
 * Description of Ini
 *
 * @author mmilivojevic
 */
class Ini {
    public static function file() {
        return parse_ini_file("db/prefs.ini");
    }
}