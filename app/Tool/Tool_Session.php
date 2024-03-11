<?php

class Tool_Session {

    public function __construct () {}

    // Log in.
    public static function start () { session_start(); }

    // Destroy all session variables.
    public static function unset () { session_unset(); }

    // Destroy the session.
    public static function destroy () { session_destroy(); }

    public static function set ($aVariables) {

        if (!isset($aVariables) || count($aVariables) == 0) {

            $jsonMessage = json_encode([ 'Message' => ' - SESSION (SET) => There are no data to establish session variables.' ]);

            return $jsonMessage;

        }

        self::start();

        // Establish the new value in the session.
        foreach ($aVariables as $mixKey => $mixValue)
            $_SESSION[ $mixKey ] = $mixValue;

        $jsonMessage = json_encode([ 'Message' => ' - SESSION (SET) => SUCCESS!!!' ]);

        return $jsonMessage;

    }

    public static function get ($strKey = null) {

        if (is_null($strKey)) {

            $jsonMessage = json_encode([ 'Message' => ' - SESSION (GET) => There is no key to obtaining its corresponding session variable.' ]);

            return $jsonMessage;

        }

        self::start();

        if (!isset($_SESSION[ $strKey ])) {

            $jsonMessage = json_encode([ 'Message' => ' - SESSION (GET) => There is no variable ' . $strKey . '.' ]); 
            
            return $jsonMessage;

        }

        // Access the session.
        $mixValue = $_SESSION[ $strKey ];

        $jsonMessage = json_encode([ 'Message' => ' - SESSION (GET) => [ ' . $strKey . ' ] = ' . $mixValue ]);

        return $jsonMessage;

    }

    public static function delete ($strKey = null) {

        if (is_null($strKey)) { 
            
            $jsonMessage = json_encode([ 'Message' => ' - SESSION (DELETE) => There is no key to eliminating the session variable.' ]); 

            return $jsonMessage;

        }

        self::start();

        if (!isset($_SESSION[ $strKey ])) { 
            
            $jsonMessage = json_encode([ 'Message' => ' - SESSION (DELETE) => There is no variable ' . $strKey . '.' ]); 

            return $jsonMessage;

        }

        // Eliminate the session variable.
        unset($_SESSION[ $strKey ]);

        $jsonMessage = json_encode([ 'Message' => ' - SESSION (DELETE) => [ ' . $strKey . ' ].' ]);

        return $jsonMessage;

    }

    public static function clear () {

        self::start();
        self::unset();
        self::destroy();

        $jsonMessage = json_encode([ 'Message' => ' - SESSION (CLEAR)' ]);

        return $jsonMessage;

    }

}