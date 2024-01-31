<?php

class Log
{
    private static $logFilePath = 'logs/aktivnost.log';

    public static function writeToLog($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
    
        file_put_contents(self::$logFilePath, $logMessage, FILE_APPEND);
    }
}
